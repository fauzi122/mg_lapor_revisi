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


	$meping = Meping::select('id_template')->groupBy('id_template')->get();
	$sub_page = Meping::all(); 
	$sub_menu = Meping::select('id_sub_menu')->groupBy('id_sub_menu')->get();

	$result = DB::select("
		SELECT
			m.*,
			i.id AS izin_id,
			i.npwp,
			jt.id_izin,
			jt.tanggal_izin,
			jt.id_permohonan,
			jt.kode_izin_desc,
			jt.jenis_izin_desc,
			jt.jenis_pengesahan,
			jt.status_pengesahan,
			jt.no_sertifikat_izin,
			jt.tanggal_pengesahan,
			jt.sub_page_id,
			jt.no_sk_izin
		FROM mepings m
		JOIN izin_migas i ON TRUE
		JOIN LATERAL (
			SELECT
				(d ->> 'Id_Izin')::int AS id_izin,
				(d ->> 'Tanggal_izin')::date AS tanggal_izin,
				(d ->> 'Id_Permohonan')::int AS id_permohonan,
				(d ->> 'Kode_Izin_Desc') AS kode_izin_desc,
				(d ->> 'Jenis_Izin_Desc') AS jenis_izin_desc,
				(d ->> 'Jenis_Pengesahan') AS jenis_pengesahan,
				(d ->> 'Status_Pengesahan') AS status_pengesahan,
				(d ->> 'No_Sertifikat_izin') AS no_sertifikat_izin,
				(d ->> 'No_SK_Izin') AS no_sk_izin,
				(d ->> 'Tanggal_Pengesahan')::timestamp AS tanggal_pengesahan,
				(mi ->> 'sub_page_id')::int AS sub_page_id
			FROM jsonb_array_elements(i.data_izin::jsonb) d
			LEFT JOIN LATERAL jsonb_array_elements(d -> 'multiple_id') mi ON TRUE
		) jt ON m.id_sub_page::int = jt.sub_page_id AND m.id_template::int = jt.id_izin
		WHERE i.npwp = ?
	", [auth()->user()->npwp]);


	// dd($result);

		$template_counts = [];
		$seen_permohonan = [];

		// Loop untuk setiap baris dalam $result
		foreach ($result as $row) {
			// Skip jika id_permohonan sudah dihitung sebelumnya
			if (in_array($row->id_permohonan, $seen_permohonan)) {
				continue; // Lewatkan iterasi jika id_permohonan sudah ada di $seen_permohonan
			}

			// Tandai id_permohonan sudah dihitung
			$seen_permohonan[] = $row->id_permohonan;

			// Ambil kode izin yang akan dihitung
			$templateName = strtolower($row->kode_izin_desc);

			// Jika template belum ada dalam $template_counts, inisialisasi dengan 0
			if (!isset($template_counts[$templateName])) {
				$template_counts[$templateName] = 0;
			}

			// Increment jumlah untuk template yang ditemukan
			$template_counts[$templateName]++;
		}

		// Meng-update `$template_counts` ke dalam `$data` (untuk ditampilkan di view jika perlu)
		$data['template_counts'] = $template_counts;

		// Store kategori_pengolahan directly in session
		$kategoriPengolahan = Meping::select('kategori')->groupBy('kategori')->get();
		Session::put('kategori_pengolahan', $kategoriPengolahan);

		// Meng-update sesi berdasarkan `$template_counts` yang telah di-update
		Session::put('j_niaga_s', $this->sumSimilarTemplates($template_counts, 'sementara niaga'));
		Session::put('j_niaga', $this->sumSimilarTemplates($template_counts, 'niaga'));
		Session::put('j_pengolahan', $this->sumSimilarTemplates($template_counts, 'pengolahan'));
		Session::put('j_penyimpanan', $this->sumSimilarTemplates($template_counts, 'penyimpanan'));
		Session::put('j_pengangkutan', $this->sumSimilarTemplates($template_counts, 'pengangkutan'));


		// Mengembalikan view dengan data yang telah diupdate
		return view('badanUsaha.dashboard', compact(
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
	
		// $max = 10; // Ini bisa disesuaikan dengan kebutuhan Anda

		// $queries = [];
		// for($i = 1; $i <= $max; $i++) {
		// 	$queries[] = "SELECT $i AS n";
		// }
		
		// $unionQuery = implode(" UNION ALL ", $queries);
		// $numbers = DB::table(DB::raw("($unionQuery) AS numbers"));
		
		// $subQuery = DB::table('r_permohonan_izin as a')
		// 	->join('t_perusahaan as b', 'a.ID_PERUSAHAAN', '=', 'b.ID_PERUSAHAAN')
		// 	->join('fgen_r_template_izin as c', 'a.ID_TEMPLATE', '=', 'c.ID_TEMPLATE')
		// 	->joinSub($numbers, 'numbers', function($join) {
		// 		$join->on(DB::raw('CHAR_LENGTH(REPLACE(a.LIST_SUB_PAGE, "-", ",")) - CHAR_LENGTH(REPLACE(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", ""))'), '>=', DB::raw('numbers.n - 1'));
		// 	})
		// 	->where('a.ID_CURR_PROSES', '=', '140')
		// 	->where('a.ID_PERUSAHAAN', '=', Auth::user()->badan_usaha_id)
		// 	->whereIn('a.ID_TEMPLATE', function($query) {
		// 		$query->select(DB::raw('DISTINCT id_template'))
		// 			->from('mepings');
		// 	})
		// 	->select([
		// 		'a.ID_PERUSAHAAN',
		// 		'b.NAMA_PERUSAHAAN',
		// 		'a.ID_TEMPLATE',
		// 		'a.TGL_DISETUJUI',
		// 		'a.NOMOR_IZIN',
		// 		'a.NO_TRACKING',
		// 		'c.NAMA_TEMPLATE',
		// 		'a.ID_PERMOHONAN',
		// 		DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", numbers.n), ",", -1) AS SUB_PAGE'),
		// 		'a.ID_CURR_PROSES'
		// 	]);
	
		// 	$result = DB::table(DB::raw("({$subQuery->toSql()}) as k"))
		// 	->mergeBindings($subQuery) // penting! agar bindings dapat digunakan dengan benar
		// 	->join('mepings as d', 'k.SUB_PAGE', '=', 'd.id_sub_page')
		// 	->whereIn('SUB_PAGE', function($query) {
		// 		$query->select(DB::raw('DISTINCT id_sub_page'))
		// 			->from('mepings')
		// 			->where('STATUS', '=', 1);
		// 	})
		// 	->select([
		// 		'k.ID_PERUSAHAAN',
		// 		'k.NAMA_PERUSAHAAN',
		// 		'k.NAMA_TEMPLATE',
		// 		'k.SUB_PAGE',
		// 		'k.TGL_DISETUJUI',
		// 		'k.ID_PERMOHONAN',
		// 		'k.NOMOR_IZIN',
		// 		'k.NO_TRACKING',
		// 		'd.nama_opsi'
		// 	])
		// 	->get();