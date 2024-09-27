<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvPasokanGasBumiController extends Controller
{
    public function index(){

        $perusahaan = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->where('a.jenis', 'Gas Bumi')
            ->where('a.tipe', 'Pasokan')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.badan_usaha_id')
            ->select('a.jenis', 'a.tipe', 'a.status', 'b.id_perusahaan', 'b.NAMA_PERUSAHAAN')
            ->get();



        $data = [
            'title'=>'Laporan Gas Bumi Pasokan Kilang',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.gb.pasokan.index',$data);
    }

    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');
        $t_awal = $request->input('t_awal');
        $t_akhir = $request->input('t_akhir');

        $result = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN')
            ->where('a.tipe', 'Pasokan')
            ->whereIn('a.status', [1, 2, 3])
            ->where('badan_usaha_id', $perusahaan)
            ->whereBetween('bulan', [$t_awal, $t_akhir])
            ->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        } else {
            $data = [
                'title'=>'Laporan Gas Bumi Pasokan Kilang',
                'result' => $result
            ];

            $view = view('evaluator.laporan_bu.gb.pasokan.cetak', $data);

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
                ->where('a.tipe', 'Pasokan')
                ->where('a.badan_usaha_id', $p)
                ->whereIn('a.status', [1, 2,3])
                ->groupBy('a.bulan')->get();


        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Gas Bumi Pasokan Kilang',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.gb.pasokan.periode', $data);
    }

    public function show($kode = '')
    {

        $pecah = explode(',', Crypt::decryptString($kode));
        $query = DB::table('pengolahans as a')
            ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
            ->select('a.*', 'b.NAMA_PERUSAHAAN')
            ->where('a.jenis', 'Gas Bumi')
            ->where('a.tipe', 'Pasokan')
            ->where('a.badan_usaha_id', $pecah[1])
            ->where('a.bulan', $pecah[0])
            ->whereIn('a.status', [1, 2,3])
            ->get();

//        var_dump($query);die();

        $data = [
            'title'=>'Laporan Gas Bumi Pasokan Kilang',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.gb.pasokan.pilihbulan', $data);

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
}
