<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvDistribusiGasBumiController extends Controller
{

    public function index(){

        $perusahaan = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->where('a.jenis', 'Gas Bumi')
            ->where('a.tipe', 'Distribusi')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.badan_usaha_id')
            ->select('a.jenis', 'a.tipe', 'a.status', 'b.id_perusahaan', 'b.NAMA_PERUSAHAAN')
            ->get();



        $data = [
            'title'=>'Laporan Gas Bumi Distribusi',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.gb.distribusi.index',$data);
    }
    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');
        $t_awal = $request->input('t_awal');
        $t_akhir = $request->input('t_akhir');

        $result = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN')
            ->where('badan_usaha_id', $perusahaan)
            ->where('a.tipe', 'Distribusi')
            ->whereIn('a.status', [1, 2, 3])
            ->whereBetween('bulan', [$t_awal, $t_akhir])
            ->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        } else {
            $data = [
                'title'=>'Laporan Gas Bumi Distribusi Kilang',
                'result' => $result
            ];

            $view = view('evaluator.laporan_bu.gb.distribusi.cetak', $data);

            $view->with('reload', true);

            return response($view);
        }
    }

    public function periode($kode = '')
    {


        $p = !empty($kode) ? Crypt::decrypt($kode) : null;
        if ($p) {
            $query = DB::table('pengolahans as a')
                ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
                ->select('a.*', 'b.NAMA_PERUSAHAAN')
                ->where('a.jenis', 'Gas Bumi')
                ->where('a.tipe', 'Distribusi')
                ->where('a.badan_usaha_id', $p)
                ->whereIn('a.status', [1, 2,3])
                ->groupBy('a.bulan')->get();


        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Gas Bumi Distribusi',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.gb.distribusi.periode', $data);
    }

    public function show($kode = '', $filter = null)
    {

        $pecah = explode(',', Crypt::decryptString($kode));

        if ($filter && $filter === "tahun") {
            $filterBy = substr($pecah[0], 0, 4);
        } 
        else {
            $filterBy = $pecah[0];
        }

        $query = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN')
            ->where('a.jenis', 'Gas Bumi')
            ->where('a.tipe', 'Distribusi')
            ->where('a.badan_usaha_id', $pecah[1])
            ->where('a.bulan', 'like', "%". $filterBy ."%")
            ->whereIn('a.status', [1, 2,3])
            ->get();

//        var_dump($query);die();

        $data = [
            'title'=>'Laporan Gas Bumi Distribusi',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.gb.distribusi.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        $update = DB::table('pengolahans')->where('id', $id)
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



        $update = DB::table('pengolahans')
            ->where('jenis', 'Gas Bumi')
            ->where('tipe', 'Distribusi')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan',$bulan)
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
            $update = DB::table('pengolahans')
                ->where('jenis', 'Gas Bumi')
                ->where('tipe', 'Distribusi')
                ->where('badan_usaha_id', $badan_usaha_id)
                ->where('bulan', $bulan)
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
            $update = DB::table('pengolahans')->where('id', $id)
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
//
//    public function index(Request $request){
//		//dd($request->all());
//		// $query = Penjualan_lpg::select('penjualan_lpgs.*','t_perusahaan.NAMA_PERUSAHAAN','izins.key')
//		// 	->leftJoin('t_perusahaan','penjualan_lpgs.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//		// 	->leftJoin('izins','penjualan_lpgs.izin_id','izins.id')
//		// 	->whereIn('status',['2','1']);
//
//		// $bu = Penjualan_lpg::select('t_perusahaan.NAMA_PERUSAHAAN')
//		// 	->leftJoin('t_perusahaan','penjualan_lpgs.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//		// 	->groupBy('t_perusahaan.NAMA_PERUSAHAAN')
//		// 	->orderBy('t_perusahaan.NAMA_PERUSAHAAN','asc')
//		// 	->get();
//
//		// $produk = Penjualan_lpg::select('produk')
//		// 	->groupBy('produk')
//		// 	->orderBy('produk','asc')
//		// 	->get();
//
//		// $kota = Penjualan_lpg::select('kabupaten_kota')
//		// 	->groupBy('kabupaten_kota')
//		// 	->orderBy('kabupaten_kota','asc')
//		// 	->get();
//
//		// if ($request->bulan1 == '' || $request->bulan2 == '') {
//		// 	// dd('hai');
//        //     $bulan1 = Carbon::now()->format('Y-m');
//        //     // $bulan2 = Carbon::now()->subMonth(1);
//        //     $bulan2 = Carbon::now()->format('Y-m');
//		// 	// dd($bulan1,$bulan2);
//		// 	$query = $query->whereBetween(DB::raw("(date_format(bulan,'%Y-%m'))"), [$bulan1, $bulan2]);
//        // } else {
//        //     $request->validate([
//        //         'bulan1' => 'required|date',
//        //         'bulan2' => 'required|date|after_or_equal:date_start'
//        //     ]);
//
//        //     $bulan1 = $request->bulan1;
//        //     $bulan2 = $request->bulan2;
//		// 	$query = $query->whereBetween(DB::raw("(date_format(bulan,'%Y-%m'))"), [$bulan1, $bulan2]);
//        // }
//		// // dd($bulan1,$bulan2);
//
//		// if($request->badan_usaha != ''){
//		// 	$query = $query->where('t_perusahaan.NAMA_PERUSAHAAN',$request->badan_usaha);
//		// }
//
//		// if($request->produk != ''){
//		// 	$query = $query->where('penjualan_lpgs.produk',$request->produk);
//		// }
//
//		// if($request->kab_kota != ''){
//		// 	$query = $query->where('penjualan_lpgs.kabupaten_kota',$request->kab_kota);
//		// }
//
//		// $query = $query->orderBy('id','asc')->get();
//
//        $query = [];
//        $bu = [];
//        $produk = [];
//        $kota = [];
//
//		return view('evaluator.laporan_bu.gb.distribusi.index',compact('query','bu','produk','kota'));
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
//		$update = Penjualan_lpg::where('id',$id)
//			->update([
//				'catatan' => $request->catatan,
//				'status' => '2'
//			]);
//
//        return redirect()->back()->with('success', 'Catatan revisi berhasil dikirim.');
//	}
//
//    public function pilih_perusahaan(){
//        echo "test";
//    }
}
