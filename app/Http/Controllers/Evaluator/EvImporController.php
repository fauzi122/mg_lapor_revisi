<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Impor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvImporController extends Controller
{

    public function index(){

        $perusahaan = DB::table('impors as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'a.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->select(
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("(d ->> 'Id_Permohonan')::int as id_permohonan"),
                DB::raw("MIN(d ->> 'No_SK_Izin') as no_sk_izin"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tanggal_izin"),
                DB::raw("MIN(d ->> 'Kode_Izin_Desc') as kode_izin_desc"),
                DB::raw("MIN(d ->> 'Jenis_Izin_Desc') as jenis_izin_desc"),
                DB::raw("MIN(d ->> 'Jenis_Pengesahan') as jenis_pengesahan"),
                DB::raw("MIN(d ->> 'Status_Pengesahan') as status_pengesahan"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tanggal_pengesahan"),
                DB::raw("MIN((d ->> 'Tanggal_Berakhir_izin')::date) as tanggal_berakhir_izin")
            )
            ->groupBy('u.name', 'i.npwp', DB::raw("(d ->> 'Id_Permohonan')::int"))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->get();
        $data = [
            'title'=>'Laporan Impor',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.exim.impor.index',$data);
    }

    public function cetakperiode(Request $request)
    {
        $request->validate([
            'perusahaan' => 'required',
            't_awal' => 'required|date',
            't_akhir' => 'required|date|after_or_equal:t_awal',
        ]);

        $perusahaan = $request->input('perusahaan');
        $t_awal = Carbon::parse($request->input('t_awal'));
        $t_akhir = Carbon::parse($request->input('t_akhir'));

        $query = DB::table('impors as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d(data)"))
            ->select(
            'a.id',
            'a.npwp',
            'a.id_permohonan',
            'a.bulan_pib',
            'a.produk',
            'a.hs_code',
            'a.volume_pib',
            'a.invoice_amount_nilai_pabean',
            'a.invoice_amount_final',
            'a.satuan',
            'a.nama_supplier',
            'a.negara_asal',
            'a.pelabuhan_muat',
            'a.vessel_name',
            'a.tanggal_bl',
            'a.bl_no',
            'a.no_pendaf_pib',
            'a.tanggal_pendaf_pib',
            'a.incoterms',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'a.pelabuhan_bongkar',
            'u.name as nama_perusahaan',
            DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
            DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
            DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )->groupBy(
            'a.id',
            'a.npwp',
            'a.id_permohonan',
            'a.bulan_pib',
            'a.produk',
            'a.hs_code',
            'a.volume_pib',
            'a.invoice_amount_nilai_pabean',
            'a.invoice_amount_final',
            'a.satuan',
            'a.nama_supplier',
            'a.negara_asal',
            'a.pelabuhan_muat',
            'a.vessel_name',
            'a.tanggal_bl',
            'a.bl_no',
            'a.no_pendaf_pib',
            'a.tanggal_pendaf_pib',
            'a.incoterms',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'a.pelabuhan_bongkar',
            'u.name'
            )
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->where(function ($q) use ($t_awal, $t_akhir) {
                $q->whereBetween(DB::raw('a.bulan_pib::date'), [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->orWhereBetween('a.created_at', [$t_awal, $t_akhir]);
            });

        if ($perusahaan != 'all') {
            $query->where('a.npwp', $perusahaan);
        }

        $result = $query->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
        }

        $data = [
            'title' => 'Laporan Impor',
            'result' => $result
        ];

        return response(view('evaluator.laporan_bu.exim.impor.cetak', $data)->with('reload', true));
    }



    public function periode($kode = '')
    {


        $p = !empty($kode) ? Crypt::decrypt($kode) : null;
        if ($p) {
            $query = DB::table('impors as a')
                ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
                ->selectRaw('
                    MAX(a.npwp) as npwp, 
                    a.bulan_pib, 
                    MAX(a.status) as status, 
                    MAX(a.catatan) as catatan, 
                    MAX(u.name) as nama_perusahaan,
                    MAX(u.badan_usaha_id) as badan_usaha_id
                    ')
                ->where('a.npwp', $p)
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
                ->groupBy('a.bulan_pib')
                ->get();


        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Impor',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.exim.impor.periode', $data);
    }

    public function show($kode = '')
    {

        $pecah = explode(',', Crypt::decryptString($kode));

        if (count($pecah) !== 3) {
            abort(404, 'Format kode salah');
        }

        $mode  = $pecah[0]; // 'bulan' atau 'tahun'
        $bulan = $pecah[1]; // ex: 2025-06-01
        $npwp  = $pecah[2];

        // Atur filter berdasarkan mode
        if ($mode === 'tahun') {
            $filterBy = substr($bulan, 0, 4); // ambil 2025
            $like = $filterBy . '%'; // like 2025%
        } else {
            $like = $bulan; // exact match bulan
        }

        $query = DB::table('impors as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->select('a.*', 'u.name as nama_perusahaan', 'm.nama_opsi')
            ->where('a.npwp', $npwp)
            ->where('a.bulan_pib', 'like', $like)
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->get();
        // var_dump($query);die();

        $data = [
            'title'=>'Laporan Impor',
            'query'=>$query,
            'per'=>$query->first(),
            'mode'  => $mode

        ];
        return view('evaluator.laporan_bu.exim.impor.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        $update = Impor::where('id', $id)
            ->update([
                'catatan' => $request->catatan,
                'status' => '2'
            ]);

        return redirect()->back()->with('sweet_success', 'Catatan revisi berhasil dikirim.');
    }

    public function updateRevisionNotesAll(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);
        $badan_usaha_id = Crypt::decrypt($request->input('p')) ;
        $bulan = Crypt::decrypt($request->input('b')) ;



        $update = Impor::where('badan_usaha_id', $badan_usaha_id)->where('bulan_pib',$bulan)
            ->whereIn('status', [1, 2,3])
            ->update([
                'catatan' => $request->catatan,
                'status' => '2'
            ]);


        if ($update) {
            return redirect()->back()->with('sweet_success', 'Catatan revisi berhasil dikirim.');
        } else {
            return redirect()->back()->with('sweet_error', 'Catatan revisi gagal dikirim.');
        }
    }

    public function selesaiPeriodeAll(Request $request)
    {
        try {
            $badan_usaha_id = Crypt::decrypt($request->input('p'));
            $bulan = Crypt::decrypt($request->input('b'));

            // Pastikan bahwa badan_usaha_id dan bulan ada dalam kondisi where
            $update = Impor::where('badan_usaha_id', $badan_usaha_id)
                ->where('bulan_pib', $bulan)
                ->whereIn('status', [1, 2,3])
                ->update([
                    'status' => '3'
                ]);



            if ($update) {
                // Jika berhasil, kembalikan respons JSON
                return response()->json(['success' => 'Periode berhasil diselesaikan.']);
            } else {
                // Jika gagal, kembalikan respons JSON dengan status 500 (Internal Server Error)
                return response()->json(['error' => 'Gagal menyelesaikan periode.'], 500);
            }
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }

    public function selesaiPeriode(Request $request)
    {
        try {
            $id = $request->input('id');

            // Pastikan bahwa badan_usaha_id dan bulan ada dalam kondisi where
            $update = Impor::where('id', $id)
                ->update([
                    'status' => '3'
                ]);



            if ($update) {
                // Jika berhasil, kembalikan respons JSON
                return response()->json(['success' => 'Periode berhasil diselesaikan.']);
            } else {
                // Jika gagal, kembalikan respons JSON dengan status 500 (Internal Server Error)
                return response()->json(['error' => 'Gagal menyelesaikan periode.'], 500);
            }
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }

    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('impors as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->where('a.bulan_pib', $tgl->startOfMonth()->format('Y-m-d'))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan_pib',
                'a.produk',
                'a.hs_code',
                'a.volume_pib',
                'a.invoice_amount_nilai_pabean',
                'a.invoice_amount_final',
                'a.satuan',
                'a.nama_supplier',
                'a.negara_asal',
                'a.pelabuhan_muat',
                'a.vessel_name',
                'a.tanggal_bl',
                'a.bl_no',
                'a.no_pendaf_pib',
                'a.tanggal_pendaf_pib',
                'a.incoterms',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'a.pelabuhan_bongkar',
                'u.name',
            )

            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->get();
        // dd($query);

        $perusahaan = DB::table('impors as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->groupBy('u.name', 'i.npwp')
            ->select(
                DB::raw("MAX(a.bulan_pib) as bulan_terbaru"),
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.exim.impor.lihat-semua-data', [
            'title' => 'Laporan Impor',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('impors as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->groupBy('u.name', 'i.npwp')
            ->select(
                DB::raw("MAX(a.bulan_pib) as bulan_terbaru"),
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->get();

        $query = DB::table('impors as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
        ->select(
            'a.id',
            'a.npwp',
            'a.id_permohonan',
            'a.bulan_pib',
            'a.produk',
            'a.hs_code',
            'a.volume_pib',
            'a.invoice_amount_nilai_pabean',
            'a.invoice_amount_final',
            'a.satuan',
            'a.nama_supplier',
            'a.negara_asal',
            'a.pelabuhan_muat',
            'a.vessel_name',
            'a.tanggal_bl',
            'a.bl_no',
            'a.no_pendaf_pib',
            'a.tanggal_pendaf_pib',
            'a.incoterms',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'a.pelabuhan_bongkar',
            'u.name as nama_perusahaan',
            DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
            DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
            DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
        )->groupBy(
            'a.id',
            'a.npwp',
            'a.id_permohonan',
            'a.bulan_pib',
            'a.produk',
            'a.hs_code',
            'a.volume_pib',
            'a.invoice_amount_nilai_pabean',
            'a.invoice_amount_final',
            'a.satuan',
            'a.nama_supplier',
            'a.negara_asal',
            'a.pelabuhan_muat',
            'a.vessel_name',
            'a.tanggal_bl',
            'a.bl_no',
            'a.no_pendaf_pib',
            'a.tanggal_pendaf_pib',
            'a.incoterms',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'a.pelabuhan_bongkar',
            'u.name'
        )->where(function ($q) use ($t_awal, $t_akhir) {
            $q->whereBetween('a.bulan_pib', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                ->orWhereBetween('a.created_at', [$t_awal, $t_akhir]);
        })
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        if ($request->perusahaan !== 'all') {
            $query->where('a.npwp', $request->perusahaan);
        }

        $result = $query->get();

        // if ($request->perusahaan != 'all') {
        //     $query->where('badan_usaha_id', $request->perusahaan);
        // }

        // $result = $query->whereBetween('a.bulan_pib', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
        //             ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.exim.impor.lihat-semua-data', [
            'title' => 'Laporan Impor',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }

//
//    public function index(Request $request){
//		//dd($request->all());
//		$query = Impor::select('impors.*','t_perusahaan.NAMA_PERUSAHAAN','izins.key')
//			->leftJoin('t_perusahaan','impors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//			->leftJoin('izins','impors.izin_id','izins.id')
//			->whereIn('status',['2','1']);
//
//		$bu = Impor::select('t_perusahaan.NAMA_PERUSAHAAN')
//			->leftJoin('t_perusahaan','impors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//			->groupBy('t_perusahaan.NAMA_PERUSAHAAN')
//			->orderBy('t_perusahaan.NAMA_PERUSAHAAN','asc')
//			->get();
//
//		$produk = Impor::select('produk')
//			->groupBy('produk')
//			->orderBy('produk','asc')
//			->get();
//
//		if ($request->bulan1 == '' || $request->bulan2 == '') {
//			// dd('hai');
//            $bulan1 = Carbon::now()->format('Y-m');
//            // $bulan2 = Carbon::now()->subMonth(1);
//            $bulan2 = Carbon::now()->format('Y-m');
//			// dd($bulan1,$bulan2);
//			$query = $query->whereBetween(DB::raw("(date_format(bulan_pib,'%Y-%m'))"), [$bulan1, $bulan2]);
//        } else {
//            $request->validate([
//                'bulan1' => 'required|date',
//                'bulan2' => 'required|date|after_or_equal:date_start'
//            ]);
//
//            $bulan1 = $request->bulan1;
//            $bulan2 = $request->bulan2;
//			$query = $query->whereBetween(DB::raw("(date_format(bulan_pib,'%Y-%m'))"), [$bulan1, $bulan2]);
//        }
//		// dd($bulan1,$bulan2);
//
//		if($request->badan_usaha != ''){
//			$query = $query->where('t_perusahaan.NAMA_PERUSAHAAN',$request->badan_usaha);
//		}
//
//		if($request->produk != ''){
//			$query = $query->where('impors.produk',$request->produk);
//		}
//
//		if($request->kab_kota != ''){
//			$query = $query->where('impors.kabupaten_kota',$request->kab_kota);
//		}
//
//		$query = $query->orderBy('id','asc')->get();
//
//        // $query = [];
//        // $bu = [];
//        // $produk = [];
//        // $kota = [];
//
//		return view('evaluator.laporan_bu.exim.impor.index',compact('query','bu','produk'));
//	}
//
//	public function updateRevisionNotes(Request $request,$id){
//		// dd('hai');
//		// Validasi input jika diperlukan
//        $request->validate([
//            'catatan' => 'required',
//        ]);
//
//        // Proses untuk mengupdate catatan revisi
//        // Misalnya, Anda dapat menyimpan catatan revisi dalam database atau melakukan tindakan lainnya
//        // Contoh:
//		$update = Impor::where('id',$id)
//			->update([
//				'catatan' => $request->catatan,
//				'status' => '2'
//			]);
//
//        return redirect()->back()->with('success', 'Catatan revisi berhasil dikirim.');
//	}
}
