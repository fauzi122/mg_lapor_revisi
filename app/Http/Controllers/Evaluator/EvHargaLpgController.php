<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HargaLPG;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvHargaLpgController extends Controller
{
    public function index(){

        $perusahaan = DB::table('harga_l_p_g_s as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.badan_usaha_id')
            ->select( 'b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN')
            ->get();
        $data = [
            'title'=>'Laporan Harga LPG',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.harga.lpg.index',$data);
    }

    public function periode($kode = '')
    {


        $p = !empty($kode) ? Crypt::decrypt($kode) : null;
        if ($p) {
            $query = DB::table('harga_l_p_g_s as a')
                ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
                ->select('a.*', 'b.NAMA_PERUSAHAAN')
                ->where('a.badan_usaha_id', $p)
                ->whereIn('a.status', [1, 2,3])
                ->groupBy('a.bulan')->get();


        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Harga LPG',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.harga.lpg.periode', $data);
    }

    public function show($kode = '')
    {

        $pecah = explode(',', Crypt::decryptString($kode));

        if (count($pecah) == 3) {
            $filterBy = substr($pecah[0], 0, 4);
        } else {
        $filterBy = $pecah[0];
        }

        $query = DB::table('harga_l_p_g_s as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN')
            ->where('a.badan_usaha_id', $pecah[1])
            ->where('a.bulan', 'like', "%". $filterBy ."%")
            ->whereIn('a.status', [1, 2,3])
            ->get();

        //        var_dump($query);die();

        $data = [
            'title'=>'Laporan Harga LPG',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.harga.lpg.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        $update = DB::table('harga_l_p_g_s')->where('id', $id)
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



        $update = DB::table('harga_l_p_g_s')
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
            $update = DB::table('harga_l_p_g_s')
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
            $update = DB::table('harga_l_p_g_s')->where('id', $id)
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
    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');
        $t_awal = $request->input('t_awal');
        $t_akhir = $request->input('t_akhir');
    
        // Query dasar untuk mendapatkan data harga LPG
        $query = DB::table('harga_l_p_g_s as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN')
            ->whereBetween('bulan', [$t_awal, $t_akhir]);
    
        // Jika perusahaan bukan 'all', tambahkan kondisi filter untuk badan usaha
        if ($perusahaan !== 'all') {
            $query->where('badan_usaha_id', $perusahaan);
        }
    
        $result = $query->get();
    
        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Harga LPG',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.harga.lpg.cetak', $data);
    
            // Menambahkan script JavaScript untuk reload halaman
            $view->with('reload', true);
    
            return response($view);
        }
    }

    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('harga_l_p_g_s as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN')
        ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
        ->whereIn('a.status', [1, 2, 3])
        ->get();

        $perusahaan = DB::table('harga_l_p_g_s as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN')
        ->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.harga.lpg.lihat-semua-data', [
            'title' => 'Laporan Harga LPG',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('harga_l_p_g_s as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN')
        ->get();

        $query = DB::table('harga_l_p_g_s as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN');
        
        if ($request->perusahaan != 'all') {
            $query->where('badan_usaha_id', $request->perusahaan);
        }

        $result = $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.harga.lpg.lihat-semua-data', [
            'title' => 'Laporan Harga LPG',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
    
}
