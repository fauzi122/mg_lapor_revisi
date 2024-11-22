<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pengangkutan_gaskbumi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvPengangkutanGasBumiController extends Controller
{


    public function index()
    {

        $perusahaan = DB::table('pengangkutan_gaskbumis as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')            
            ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN')
            ->groupBy('a.badan_usaha_id')
            ->whereIn('a.status', [1, 2,3])
            ->get();



        $data = [
            'title'=>'Laporan Pengangkutan Gas Bumi',
            'perusahaan' => $perusahaan,
        ];
        return view('evaluator.laporan_bu.pengangkutan.gb.perusahaan', $data);
    }

public function cetakperiode(Request $request)
{
    $perusahaan = $request->input('perusahaan');
    $t_awal = $request->input('t_awal');
    $t_akhir = $request->input('t_akhir');

    // Build the base query
    $query = DB::table('pengangkutan_gaskbumis as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN')
        ->whereIn('a.status', [1, 2, 3])
        ->whereBetween('bulan', [$t_awal, $t_akhir]);

    // Filter by company if not 'all'
    if ($perusahaan !== 'all') {
        $query->where('badan_usaha_id', $perusahaan);
    }

    $result = $query->get();

    // Check if the result is empty
    if ($result->isEmpty()) {
        return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
    } else {
        $data = [
            'title' => 'Laporan Pengangkutan Gas Bumi', // Updated title to match the context
            'result' => $result
        ];

        // Create view with data and a script to trigger reload
        $view = view('evaluator.laporan_bu.pengangkutan.gb.cetak', $data);
        $view->with('reload', true);

        return response($view);
    }
}

    public function periode($kode = '')
    {

        $p = !empty($kode) ? Crypt::decrypt($kode) : null;
        if ($p) {
            $query = DB::table('pengangkutan_gaskbumis as a')
                ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
                ->select('a.*', 'b.NAMA_PERUSAHAAN')
                ->where('a.badan_usaha_id', $p)
                ->whereIn('a.status', [1, 2,3])
                ->groupBy('a.bulan')->get();


        } else {
            $query = '';

        }
        $data = [
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.pengangkutan.gb.pilihperusahaan', $data);
    }
    public function show($kode = '')
    {

        $pecah = explode(',', Crypt::decryptString($kode));

        if (count($pecah) == 3) {
            $filterBy = substr($pecah[0], 0, 4);
        } else {
        $filterBy = $pecah[0];
        }

        $query = DB::table('pengangkutan_gaskbumis as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN')
            ->where('a.badan_usaha_id', $pecah[1])
            ->where('a.bulan', 'like', "%". $filterBy ."%")
            ->whereIn('a.status', [1, 2,3])
            ->get();

        $data = [
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.pengangkutan.gb.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        $update = pengangkutan_gaskbumi::where('id', $id)
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



        $update = pengangkutan_gaskbumi::where('badan_usaha_id', $badan_usaha_id)
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
            $update = pengangkutan_gaskbumi::where('badan_usaha_id', $badan_usaha_id)
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
            $update = pengangkutan_gaskbumi::where('id', $id)
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

        $query = DB::table('pengangkutan_gaskbumis as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN')
        ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
        ->whereIn('a.status', [1, 2, 3])
        ->get();

        $perusahaan = DB::table('pengangkutan_gaskbumis as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN')
        ->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.pengangkutan.gb.lihat-semua-data', [
            'title' => 'Laporan Pengangkutan Gas Bumi',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('pengangkutan_gaskbumis as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.badan_usaha_id')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN')
        ->get();

        $query = DB::table('pengangkutan_gaskbumis as a')
        ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN');
        
        if ($request->perusahaan != 'all') {
            $query->where('badan_usaha_id', $request->perusahaan);
        }

        $result = $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.pengangkutan.gb.lihat-semua-data', [
            'title' => 'Laporan Pengangkutan Gas Bumi',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
