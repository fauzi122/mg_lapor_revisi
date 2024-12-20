<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekspor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvExporController extends Controller
{


    public function index(){

        $perusahaan = DB::table('ekspors  as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.izin_id', 'a.badan_usaha_id')
        ->select(
            'a.izin_id',
            'b.id_perusahaan',
            'b.NAMA_PERUSAHAAN',
            'c.TGL_DISETUJUI',
            'c.NOMOR_IZIN',
            'c.TGL_PENGAJUAN'
        )
        ->get();

        // Kondisi untuk grup hanya berdasarkan `badan_usaha_id`
        $perusahaan_only_bu = DB::table('ekspors as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.badan_usaha_id')
            ->select(
                'b.id_perusahaan',
                'b.NAMA_PERUSAHAAN'
            )
            ->get();

        $data = [
            'title'=>'Laporan Ekspor',
            'perusahaan' => $perusahaan,
            'perusahaan_only_bu' => $perusahaan_only_bu,
        ];

        return view('evaluator.laporan_bu.exim.expor.index',$data);
    }

    public function cetakperiode(Request $request)
    {
        $request->validate([
            'perusahaan' => 'required',
            't_awal' => 'required|date',
            't_akhir' => 'required|date|after_or_equal:t_awal',
        ]);
    
        $perusahaan = $request->input('perusahaan');
        $t_awal = $request->input('t_awal');
        $t_akhir = $request->input('t_akhir');
    
        $query = DB::table('ekspors as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
            ->whereBetween('bulan_peb', [$t_awal, $t_akhir])
            ->whereIn('a.status', [1, 2, 3]);
    
        if ($perusahaan != 'all') {
            $query->where('a.badan_usaha_id', $perusahaan);
        }
    
        $result = $query->get();
    
        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Ekspor',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.exim.expor.cetak', $data);
            $view->with('reload', true);
    
            return response($view);
        }
    }
    

    public function periode($kode = '')
    {


        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;
        if ($p) {
            
            $per = DB::table('t_perusahaan as a')->select('NAMA_PERUSAHAAN')
            ->where('a.ID_PERUSAHAAN', $p[0])->first();

            $query = DB::table('ekspors as a')
                ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
                ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
                ->select('a.*', 'b.NAMA_PERUSAHAAN','c.NOMOR_IZIN')
                ->where('a.badan_usaha_id', $p[0])
                ->where('a.izin_id', $p[1])
                ->whereIn('a.status', [1, 2,3])
                ->groupBy('a.bulan_peb')->get();


        } else {
            $query = collect(); // Empty collection
            $per = collect(); // Empty collection

        }
        $data = [
            'title'=>'Laporan Ekspor',
            'p' => $p,
            'query' => $query,
            'per' => $per
        ];
        return view('evaluator.laporan_bu.exim.expor.periode', $data);
    }

    public function show($kode = '')
    {

        $pecah = explode(',', Crypt::decryptString($kode));

        if (count($pecah) == 3) {
            $filterBy = substr($pecah[0], 0, 4);
        } else {
        $filterBy = $pecah[0];
        }

        $query = DB::table('ekspors as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.NOMOR_IZIN')
        ->where('a.izin_id', $pecah[1])
            ->where('a.bulan_peb', 'like', "%". $filterBy ."%")
            ->whereIn('a.status', [1, 2,3])
            ->get();

//        var_dump($query);die();

        $data = [
            'title'=>'Laporan Ekspor',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.exim.expor.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        $update = Ekspor::where('id', $id)
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
        $izin_id = Crypt::decrypt($request->input('p')) ;
        $bulan = Crypt::decrypt($request->input('b')) ;



        $update = Ekspor::where('izin_id', $izin_id)->where('bulan_peb',$bulan)
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
            $izin_id = Crypt::decrypt($request->input('p'));
            $bulan = Crypt::decrypt($request->input('b'));

            // Pastikan bahwa izin_id dan bulan ada dalam kondisi where
            $update = Ekspor::where('izin_id', $izin_id)
                ->where('bulan_peb', $bulan)
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
            $update = Ekspor::where('id', $id)
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
//    public function index(Request $request){
//		//dd($request->all());
//		$query = Ekspor::select('ekspors.*','t_perusahaan.NAMA_PERUSAHAAN','izins.key')
//			->leftJoin('t_perusahaan','ekspors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//			->leftJoin('izins','ekspors.izin_id','izins.id')
//			->whereIn('status',['2','1']);
//
//		$bu = Ekspor::select('t_perusahaan.NAMA_PERUSAHAAN')
//			->leftJoin('t_perusahaan','ekspors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//			->groupBy('t_perusahaan.NAMA_PERUSAHAAN')
//			->orderBy('t_perusahaan.NAMA_PERUSAHAAN','asc')
//			->get();
//
//		$produk = Ekspor::select('produk')
//			->groupBy('produk')
//			->orderBy('produk','asc')
//			->get();
//
//		// $kota = Ekspor::select('kabupaten_kota')
//		// 	->groupBy('kabupaten_kota')
//		// 	->orderBy('kabupaten_kota','asc')
//		// 	->get();
//
//		if ($request->bulan1 == '' || $request->bulan2 == '') {
//			// dd('hai');
//            $bulan1 = Carbon::now()->format('Y-m');
//            // $bulan2 = Carbon::now()->subMonth(1);
//            $bulan2 = Carbon::now()->format('Y-m');
//			// dd($bulan1,$bulan2);
//			$query = $query->whereBetween(DB::raw("(date_format(bulan_peb,'%Y-%m'))"), [$bulan1, $bulan2]);
//        } else {
//            $request->validate([
//                'bulan1' => 'required|date',
//                'bulan2' => 'required|date|after_or_equal:date_start'
//            ]);
//
//            $bulan1 = $request->bulan1;
//            $bulan2 = $request->bulan2;
//			$query = $query->whereBetween(DB::raw("(date_format(bulan_peb,'%Y-%m'))"), [$bulan1, $bulan2]);
//        }
//		// dd($bulan1,$bulan2);
//
//		if($request->badan_usaha != ''){
//			$query = $query->where('t_perusahaan.NAMA_PERUSAHAAN',$request->badan_usaha);
//		}
//
//		if($request->produk != ''){
//			$query = $query->where('ekspors.produk',$request->produk);
//		}
//
//		if($request->kab_kota != ''){
//			$query = $query->where('ekspors.kabupaten_kota',$request->kab_kota);
//		}
//
//		$query = $query->orderBy('id','asc')->get();
//		// dd($query);
//        // $query = [];
//        // $bu = [];
//        // $produk = [];
//        // $kota = [];
//
//		return view('evaluator.laporan_bu.exim.expor.index',compact('query','bu','produk'));
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
//		$update = Ekspor::where('id',$id)
//			->update([
//				'catatan' => $request->catatan,
//				'status' => '2'
//			]);
//
//        return redirect()->back()->with('success', 'Catatan revisi berhasil dikirim.');
//	}

    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('ekspors as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->where('a.bulan_peb', $tgl->startOfMonth()->format('Y-m-d'))
        ->whereIn('a.status', [1, 2, 3])
        ->get();

        $perusahaan = DB::table('ekspors as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.exim.expor.lihat-semua-data', [
            'title' => 'Laporan Ekspor',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('ekspors as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->get();

        $query = DB::table('ekspors as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN');
        
        if ($request->perusahaan != 'all') {
            $query->where('badan_usaha_id', $request->perusahaan);
        }

        $result = $query->whereBetween('a.bulan_peb', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.exim.expor.lihat-semua-data', [
            'title' => 'Laporan Ekspor',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
