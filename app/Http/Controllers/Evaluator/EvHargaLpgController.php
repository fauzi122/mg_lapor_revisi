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
    public function index()
    {
        $perusahaan = DB::table('harga_l_p_g_s as a')
            ->leftJoin(DB::raw('t_perusahaan as b'), DB::raw('a.npwp'), '=', DB::raw("CAST(b.id_perusahaan AS TEXT)"))
            ->leftJoin('r_permohonan_izin as c', 'b.id_perusahaan', '=', 'c.id_perusahaan')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.npwp', 'b.id_perusahaan')
            ->select(
                'b.id_perusahaan',
                DB::raw('MIN(b.nama_perusahaan) as nama_perusahaan'),
                DB::raw('MIN(c.tgl_disetujui) as tgl_disetujui'),
                DB::raw('MIN(c.nomor_izin) as nomor_izin'),
                DB::raw('MIN(c.tgl_pengajuan) as tgl_pengajuan')
            )->get();

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
                ->leftJoin('t_perusahaan as b', DB::raw('a.npwp'), '=', DB::raw("CAST(b.id_perusahaan AS TEXT)"))
                ->selectRaw('
                    MAX(a.npwp) as npwp, 
                    a.bulan, 
                    MAX(a.status) as status, 
                    MAX(a.catatan) as catatan, 
                    MAX(b.nama_perusahaan) as nama_perusahaan
                    ')
                ->where('a.npwp', $p)
                ->whereIn('a.status', [1, 2, 3])
                ->groupBy('a.bulan')
                ->get();
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
            ->leftJoin('t_perusahaan as b', DB::raw('a.npwp'), '=', DB::raw("CAST(b.id_perusahaan AS TEXT)"))
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->select('a.*', 'b.nama_perusahaan', 'm.nama_opsi')
            ->where('a.npwp', $pecah[1])
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
        $npwp = Crypt::decrypt($request->input('p')) ;
        $bulan = Crypt::decrypt($request->input('b')) ;



        $update = DB::table('harga_l_p_g_s')
            ->where('npwp', $npwp)
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

            $npwp = Crypt::decrypt($request->input('p'));
            $bulan = Crypt::decrypt($request->input('b'));

            // Pastikan bahwa npwp dan bulan ada dalam kondisi where
            $update = DB::table('harga_l_p_g_s')
                ->where('npwp', $npwp)
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

            // Pastikan bahwa npwp dan bulan ada dalam kondisi where
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

        // Query Eloquent dengan join yang rapi dan aman
        $query = HargaLPG::query()
            ->select(
                'harga_l_p_g_s.*',
                't_perusahaan.nama_perusahaan',
                'r_permohonan_izin.tgl_disetujui',
                'r_permohonan_izin.nomor_izin',
                'r_permohonan_izin.tgl_pengajuan',
                'mepings.nama_opsi'
            )
            ->leftJoin('t_perusahaan', 'harga_l_p_g_s.npwp', '=', 't_perusahaan.npwp') // asumsi npwp sama tipe
            ->leftJoin('r_permohonan_izin', 't_perusahaan.id_perusahaan', '=', 'r_permohonan_izin.id_perusahaan')
            ->leftJoin('mepings', DB::raw('CAST(harga_l_p_g_s.id_sub_page AS TEXT)'), '=', 'mepings.id_sub_page') // cast agar sama tipe
            ->whereBetween('harga_l_p_g_s.bulan', [$t_awal, $t_akhir]);

        if ($perusahaan !== 'all') {
            $query->where('harga_l_p_g_s.npwp', $perusahaan);
        }


        $result = $query->get();

        // Cek apakah data kosong
        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        }

        $data = [
            'title' => 'Laporan Harga LPG',
            'result' => $result
        ];

        $view = view('evaluator.laporan_bu.harga.lpg.cetak', $data)->with('reload', true);

        return response($view);
    }


    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('harga_l_p_g_s as a')
        ->leftJoin(DB::raw('t_perusahaan as b'), DB::raw('a.npwp'), '=', DB::raw("CAST(b.id_perusahaan AS TEXT)"))
        ->leftJoin('r_permohonan_izin as c', 'b.id_perusahaan', '=', 'c.id_perusahaan')
        ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
        ->select('a.*', 'b.nama_perusahaan','c.tgl_disetujui','c.nomor_izin','c.tgl_pengajuan')
        ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
        ->whereIn('a.status', [1, 2, 3])
        ->get();

        $perusahaan = DB::table('harga_l_p_g_s as a')
        ->leftJoin('t_perusahaan as b', 'a.npwp', '=', DB::raw("CAST(b.id_perusahaan AS TEXT)"))
        ->leftJoin('r_permohonan_izin as c', 'b.id_perusahaan', '=', 'c.id_perusahaan')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('b.id_perusahaan', 'b.nama_perusahaan', 'c.tgl_disetujui', 'c.nomor_izin', 'c.tgl_pengajuan')
        ->select('b.id_perusahaan', 'b.nama_perusahaan', 'c.tgl_disetujui', 'c.nomor_izin', 'c.tgl_pengajuan', 'm.nama_opsi')
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
        ->leftJoin('t_perusahaan as b', 'a.npwp', '=', DB::raw("CAST(b.id_perusahaan AS TEXT)"))
        ->leftJoin('r_permohonan_izin as c', 'b.id_perusahaan', '=', 'c.id_perusahaan')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('b.id_perusahaan', 'b.nama_perusahaan', 'c.tgl_disetujui', 'c.nomor_izin', 'c.tgl_pengajuan')
        ->select('b.id_perusahaan', 'b.nama_perusahaan', 'c.tgl_disetujui', 'c.nomor_izin', 'c.tgl_pengajuan')
        ->get();

        $query = DB::table('harga_l_p_g_s as a')
        ->leftJoin(DB::raw('t_perusahaan as b'), DB::raw('a.npwp'), '=', DB::raw("CAST(b.id_perusahaan AS TEXT)"))
        ->leftJoin('r_permohonan_izin as c', 'b.id_perusahaan', '=', 'c.id_perusahaan')
        ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
        ->select('a.*', 'b.nama_perusahaan','c.tgl_disetujui','c.nomor_izin','c.tgl_pengajuan', 'm.nama_opsi');
        
        if ($request->perusahaan != 'all') {
            $query->where('a.npwp', $request->perusahaan);
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
