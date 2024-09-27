<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\T_perusahaan;
use Illuminate\Support\Str;
use App\Models\Meping;
use App\Models\User;

use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        return redirect('/login');
        // $this->middleware(['permission:permissions.index']);
    }

    public function dashboard()
	{

		$meping = Meping::groupBy('id_template')->get();
		$sub_page = Meping::groupBy('id_sub_page')->get();
		$sub_menu = Meping::groupBy('id_sub_menu')->get();
	
		$max = 10; // Ini bisa disesuaikan dengan kebutuhan Anda

		$queries = [];
		for($i = 1; $i <= $max; $i++) {
			$queries[] = "SELECT $i AS n";
		}
		
		$unionQuery = implode(" UNION ALL ", $queries);
		$numbers = DB::table(DB::raw("($unionQuery) AS numbers"));
		
		$subQuery = DB::table('r_permohonan_izin as a')
			->join('t_perusahaan as b', 'a.ID_PERUSAHAAN', '=', 'b.ID_PERUSAHAAN')
			->join('fgen_r_template_izin as c', 'a.ID_TEMPLATE', '=', 'c.ID_TEMPLATE')
			->joinSub($numbers, 'numbers', function($join) {
				$join->on(DB::raw('CHAR_LENGTH(REPLACE(a.LIST_SUB_PAGE, "-", ",")) - CHAR_LENGTH(REPLACE(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", ""))'), '>=', DB::raw('numbers.n - 1'));
			})
			->where('a.ID_CURR_PROSES', '=', '140')
			->where('a.ID_PERUSAHAAN', '=', Auth::user()->badan_usaha_id)
			->whereIn('a.ID_TEMPLATE', function($query) {
				$query->select(DB::raw('DISTINCT id_template'))
					->from('mepings');
			})
			->select([
				'a.ID_PERUSAHAAN',
				'b.NAMA_PERUSAHAAN',
				'a.ID_TEMPLATE',
				'a.TGL_DISETUJUI',
				'a.NOMOR_IZIN',
				'c.NAMA_TEMPLATE',
				DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", numbers.n), ",", -1) AS SUB_PAGE'),
				'a.ID_CURR_PROSES'
			]);
		
			$result = DB::table(DB::raw("({$subQuery->toSql()}) as k"))
			->mergeBindings($subQuery) // penting! agar bindings dapat digunakan dengan benar
			->join('mepings as d', 'k.SUB_PAGE', '=', 'd.id_sub_page')
			->whereIn('SUB_PAGE', function($query) {
				$query->select(DB::raw('DISTINCT id_sub_page'))
					->from('mepings')
					->where('STATUS', '=', 1);
			})
			->select([
				'k.ID_PERUSAHAAN',
				'k.NAMA_PERUSAHAAN',
				'k.NAMA_TEMPLATE',
				'k.SUB_PAGE',
				'k.TGL_DISETUJUI',
	
				'k.NOMOR_IZIN',
				'd.nama_opsi'
			])
			->get();

		// Menghitung banyaknya munculnya setiap template dari hasil query
		$template_counts = [];
		foreach ($result as $row) {
			$templateName = strtolower($row->NAMA_TEMPLATE);
			if (!isset($template_counts[$templateName])) {
				$template_counts[$templateName] = 0;
			}
			$template_counts[$templateName]++;
		}

		// Meng-update `$template_counts` ke `$data` (jika Anda membutuhkannya untuk view Anda)
		$data['template_counts'] = $template_counts;

		// Menyimpan kategori ke dalam sesi.
		$kategoriPengolahan = Meping::select('kategori')->groupBy('kategori')->get();
		Session::put('kategori_pengolahan', $kategoriPengolahan);

		// Meng-update sesi berdasarkan `$template_counts` yang telah di-update
		Session::put('j_niaga_s', $this->sumSimilarTemplates($template_counts, 'sementara niaga'));
		Session::put('j_niaga', $this->sumSimilarTemplates($template_counts, 'niaga'));
		Session::put('j_pengolahan', $this->sumSimilarTemplates($template_counts, 'pengolahan'));
		Session::put('j_penyimpanan', $this->sumSimilarTemplates($template_counts, 'penyimpanan'));
		Session::put('j_pengangkutan', $this->sumSimilarTemplates($template_counts, 'pengangkutan'));


		return view('badan_usaha.dashboard',compact(
			'result',
			'meping',
			'sub_page',
			'sub_menu',
			'kategoriPengolahan'
		));
	}
	function sumSimilarTemplates($templateCounts, $templateNameToMatch)
	{
		$count = 0;
		foreach ($templateCounts as $templateName => $templateCount) {
			if (strpos($templateName, $templateNameToMatch) !== false) {
				$count += $templateCount;
			}
		}
		return $count;
	}


}
