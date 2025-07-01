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
			i.status_djp,
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
				(d ->> 'status_djp')::int AS status_djp,
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

 	$firstStatusDjp = $result[0]->status_djp ?? null;

	// dd($firstStatusDjp);

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
			'kategoriPengolahan',
			'firstStatusDjp'
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
	
		