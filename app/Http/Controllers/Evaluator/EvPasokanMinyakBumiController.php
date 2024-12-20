<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengolahanMBPasokan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvPasokanMinyakBumiController extends Controller
{
    public function index(){

        $perusahaan = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
            ->where('a.jenis', 'Minyak Bumi')
            ->where('a.tipe', 'Pasokan')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.izin_id', 'a.badan_usaha_id')
            ->select(
                'a.izin_id',
                'a.jenis', 
                'a.tipe', 
                'a.status', 
                'b.id_perusahaan', 
                'b.NAMA_PERUSAHAAN',
                'c.TGL_DISETUJUI',
                'c.NOMOR_IZIN',
                'c.TGL_PENGAJUAN')
            ->get();

        // Kondisi untuk grup hanya berdasarkan `badan_usaha_id`
        $perusahaan_only_bu = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->where('a.jenis', 'Minyak Bumi')
            ->where('a.tipe', 'Pasokan')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.badan_usaha_id')
            ->select(
                'b.id_perusahaan',
                'b.NAMA_PERUSAHAAN'
            )
            ->get();

        $data = [
            'title'=>'Laporan Minyak Bumi Pasokan Kilang',
            'perusahaan' => $perusahaan,
            'perusahaan_only_bu' => $perusahaan_only_bu,
        ];

        return view('evaluator.laporan_bu.mb.pasokan.index',$data);
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
    
        $query = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
            ->where('a.jenis', 'Minyak Bumi')
            ->where('a.tipe', 'Pasokan')
            ->whereBetween('bulan', [$t_awal, $t_akhir])
            ->whereIn('a.status', [1, 2, 3]);
    
        if ($perusahaan != 'all') {
            $query->where('a.badan_usaha_id', $perusahaan);
        }
    
        $result = $query->get();
    
        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Minyak Bumi Pasokan Kilang',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.mb.pasokan.cetak', $data);
            $view->with('reload', true);
    
            return response($view);
        }
    }
    

    public function periode($kode = '')
    {


        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;
        if ($p) {
            $query = DB::table('pengolahans as a')
                ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
                ->select('a.*', 'b.NAMA_PERUSAHAAN')
                ->where('a.jenis', 'Minyak Bumi')
                ->where('a.tipe', 'Pasokan')
                ->where('a.badan_usaha_id', $p)
                ->whereIn('a.status', [1, 2,3])
                ->groupBy('a.bulan')->get();


        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Minyak Bumi Pasokan Kilang',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.mb.pasokan.periode', $data);
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
            ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN','c.NOMOR_IZIN')
            ->where('a.jenis', 'Minyak Bumi')
            ->where('a.tipe', 'Pasokan')
            ->where('a.izin_id', $pecah[1])
            ->where('a.bulan', 'like', "%". $filterBy ."%")
            ->whereIn('a.status', [1, 2,3])
            ->get();

//        var_dump($query);die();

        $data = [
            'title'=>'Laporan Minyak Bumi Pasokan Kilang',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.mb.pasokan.pilihbulan', $data);

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
        $izin_id = Crypt::decrypt($request->input('p')) ;
        $bulan = Crypt::decrypt($request->input('b')) ;



        $update = DB::table('pengolahans')
            ->where('jenis', 'Minyak Bumi')
            ->where('tipe', 'Distribusi')
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
        try {
            $izin_id = Crypt::decrypt($request->input('p'));
            $bulan = Crypt::decrypt($request->input('b'));

            // Pastikan bahwa izin_id dan bulan ada dalam kondisi where
            $update = DB::table('pengolahans')
                ->where('jenis', 'Minyak Bumi')
                ->where('tipe', 'Distribusi')
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

    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('pengolahans as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->where('a.jenis', 'Minyak Bumi')
        ->where('a.tipe', 'Pasokan')
        ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
        ->whereIn('a.status', [1, 2, 3])
        ->get();


        $perusahaan = DB::table('pengolahans as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.mb.pasokan.lihat-semua-data', [
            'title' => 'Laporan Minyak Bumi Pasokan Kilang',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('pengolahans as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->get();

        $query = DB::table('pengolahans as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'a.izin_id', '=', 'c.ID_PERMOHONAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->where('a.jenis', 'Minyak Bumi')
        ->where('a.tipe', 'pasokan');
        
        if ($request->perusahaan != 'all') {
            $query->where('badan_usaha_id', $request->perusahaan);
        }

        $result = $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.mb.Pasokan.lihat-semua-data', [
            'title' => 'Laporan Minyak Bumi pasokan Kilang',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
