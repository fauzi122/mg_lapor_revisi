<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan_lng;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvJualLng_Bbg_Cng_Controller extends Controller
{
    public function index()
    {
        $perusahaan = DB::table('penjualan_lngs as a')
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
        $perusahaan_only_bu = DB::table('penjualan_lngs as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.badan_usaha_id')
            ->select(
                'b.id_perusahaan',
                'b.NAMA_PERUSAHAAN'
            )
            ->get();
    
        $data = [
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
            'perusahaan' => $perusahaan,
            'perusahaan_only_bu' => $perusahaan_only_bu, // Menambahkan ke data array
        ];
    
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.index', $data);
    }
    
    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');
        $t_awal = $request->input('t_awal');
        $t_akhir = $request->input('t_akhir');
    
        // Query dasar untuk mendapatkan data penjualan
        $query = DB::table('penjualan_lngs as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
            ->whereBetween('bulan', [$t_awal, $t_akhir])
            ->whereIn('a.status', [1, 2, 3]);
            // ->groupBy('a.izin_id', 'a.badan_usaha_id');
    
        // Jika perusahaan bukan 'all', tambahkan kondisi filter untuk perusahaan
        if ($perusahaan !== 'all') {
            $query->where('badan_usaha_id', $perusahaan);
        }
    
        $result = $query->get();
    
        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Penjualan LNG/CNG/BBG',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.lng_cng_bbg.penjualan.cetak', $data);
    
            // Menambahkan script JavaScript untuk reload halaman
            $view->with('reload', true);
    
            return response($view);
        }
    }
    
    public function periode($kode='')
    {
        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;
      
        if ($p) {
            $per = DB::table('t_perusahaan as a')->select('NAMA_PERUSAHAAN')
            ->where('a.ID_PERUSAHAAN', $p[0])->first();
    
            $query = DB::table('penjualan_lngs as a')
                ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
                ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
                ->select('a.*', 'b.NAMA_PERUSAHAAN','c.NOMOR_IZIN')
                ->where('a.badan_usaha_id', $p[0])
                ->where('a.izin_id', $p[1])
                ->whereIn('a.status', [1, 2, 3])
                ->groupBy('a.bulan')->get();
        } else {
            $query = collect(); // Empty collection
            $per = collect(); // Empty collection
        }
    
        $data = [
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
            'p' => $p,
            'query' => $query,
            'per' => $per
            // 'per' => $per->first() // Include per within the data array
        ];
        // dd($per);
   
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.periode', $data);
    }
     
    public function show($kode = '')
    {

        $pecah = explode(',', Crypt::decryptString($kode));
        
        if (count($pecah) == 3) {
            $filterBy = substr($pecah[0], 0, 4);
        } else {
        $filterBy = $pecah[0];
        }

        $query = DB::table('penjualan_lngs as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN','c.NOMOR_IZIN')
            ->where('a.izin_id', $pecah[1])
            ->where('a.bulan', 'like', "%". $filterBy ."%")
            ->whereIn('a.status', [1, 2,3])
            ->get();

        //        var_dump($query);die();

        $data = [
            'title'=>'Laporan Penjualan LNG/CNG/BBG',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        $update = DB::table('penjualan_lngs')->where('id', $id)
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



        $update = DB::table('penjualan_lngs')
            ->where('izin_id', $izin_id)
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
        // dd($request);
        try {

            $izin_id = Crypt::decrypt($request->input('p'));
          
      
            $bulan = Crypt::decrypt($request->input('b'));

            // Pastikan bahwa izin_id dan bulan ada dalam kondisi where
            $update = DB::table('penjualan_lngs')
                ->where('izin_id', $izin_id)
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
            $update = DB::table('penjualan_lngs')->where('id', $id)
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

        $query = DB::table('penjualan_lngs as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
        ->whereIn('a.status', [1, 2, 3])
        // ->groupBy('a.izin_id','a.badan_usaha_id')
        ->get();

        $perusahaan = DB::table('penjualan_lngs as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->whereIn('a.status', [1, 2, 3])
        
        // ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.lihat-semua-data', [
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('penjualan_lngs as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->get();

        $query = DB::table('penjualan_lngs as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN');
        
        if ($request->perusahaan != 'all') {
            $query->where('badan_usaha_id', $request->perusahaan);
        }

        $result = $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.lihat-semua-data', [
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
