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
        $perusahaan = DB::table('izin_migas as i')
            ->join('harga_l_p_g_s as h', 'h.npwp', '=', 'i.npwp')
            ->join('users as u', 'u.npwp', '=', 'i.npwp')
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
            ->whereIn(DB::raw('h.status::int'), [1, 2, 3])
            ->groupBy('u.name', 'i.npwp', DB::raw("(d ->> 'Id_Permohonan')::int"))
            ->get();
        // dd($perusahaan);
        $data = [
            'title' => 'Laporan Harga LPG',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.harga.lpg.index', $data);
    }

    public function periode($kode = '')
    {
        $p = !empty($kode) ? Crypt::decrypt($kode) : null;
        if ($p) {
            $query = DB::table('harga_l_p_g_s as a')
                ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
                ->selectRaw('
                    MAX(a.npwp) as npwp, 
                    a.bulan, 
                    MAX(a.status) as status, 
                    MAX(a.catatan) as catatan, 
                    MAX(u.name) as nama_perusahaan,
                    MAX(u.badan_usaha_id) as badan_usaha_id
                    ')
                ->where('a.npwp', $p)
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
                ->groupBy('a.bulan')
                ->get();
        } else {
            $query = '';
        }
        $data = [
            'title' => 'Laporan Harga LPG',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.harga.lpg.periode', $data);
    }

    // public function show($id = '')
    // {

    //     $pecah = explode(',', Crypt::decryptString($id));

    //     if (count($pecah) == 3) {
    //         $filterBy = substr($pecah[0], 0, 4);
    //     } else {
    //         $filterBy = $pecah[0];
    //     }

    //     $query = DB::table('harga_l_p_g_s as a')
    //         ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
    //         ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
    //         ->select(
    //             'a.*',
    //             'u.name as nama_perusahaan',
    //             'm.nama_opsi'
    //         )
    //         ->where('a.npwp', $pecah[1])
    //         ->where('a.bulan', 'like', "%" . $filterBy . "%")
    //         ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
    //         ->get();
    //     // dd($pecah);

    //     //        var_dump($query);die();

    //     $data = [
    //         'title' => 'Laporan Harga LPG',
    //         'query' => $query,
    //         'per' => $query->first()

    //     ];
    //     return view('evaluator.laporan_bu.harga.lpg.pilihbulan', $data);
    // }
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

        $query = DB::table('harga_l_p_g_s as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->select('a.*', 'u.name as nama_perusahaan', 'm.nama_opsi')
            ->where('a.npwp', $npwp)
            ->where('a.bulan', 'like', $like)
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->get();
        //        var_dump($query);die();

        return view('evaluator.laporan_bu.harga.lpg.pilihbulan', [
            'title' => 'Laporan Harga LPG',
            'query' => $query,
            'per'   => $query->first(),
            'mode'  => $mode
        ]);
    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        // $update = DB::table('harga_l_p_g_s')->where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);
        // $update = HargaLPG::where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);

        $update = HargaLPG::findOrFail($id);
        $update->update([
            'status' => '2',
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('sweet_success', 'Catatan revisi berhasil dikirim.');
    }

    public function updateRevisionNotesAll(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);
        $npwp = Crypt::decrypt($request->input('p'));
        $bulan = Crypt::decrypt($request->input('b'));

        $models = HargaLPG::where('npwp', $npwp)
            ->where('bulan', $bulan)
            ->whereIn('status', [1, 2])
            ->get();


        if ($models->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Tidak ada data yang bisa diperbarui.');
        }

        $successCount = 0;

        foreach ($models as $model) {
            try {
                if ($model->update([
                    'catatan' => $request->catatan,
                    'status'  => 2,
                ])) {
                    $successCount++;
                }
            } catch (\Throwable $th) {
                // Biarkan kosong supaya data lain tetap diproses
            }
        }

        if ($successCount > 0 && $successCount === $models->count()) {
            return redirect()->back()->with('sweet_success', 'Semua catatan revisi berhasil dikirim.');
        } elseif ($successCount > 0) {
            return redirect()->back()->with('sweet_warning', "{$successCount} catatan revisi berhasil dikirim, sebagian gagal.");
        } else {
            return redirect()->back()->with('sweet_error', 'Catatan revisi gagal dikirim.');
        }


        // $update = DB::table('harga_l_p_g_s')
        //     ->where('npwp', $npwp)
        //     ->where('bulan', $bulan)
        //     ->whereIn('status', [1, 2, 3])
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);


        // if ($update) {
        //     return redirect()->back()->with('sweet_success', 'Catatan revisi berhasil dikirim.');
        // } else {
        //     return redirect()->back()->with('sweet_error', 'Catatan revisi gagal dikirim.');
        // }
    }

    public function selesaiPeriodeAll(Request $request)
    {
        try {

            $npwp = Crypt::decrypt($request->input('p'));
            $bulan = Crypt::decrypt($request->input('b'));

            $models = HargaLPG::where('npwp', $npwp)
                ->where('bulan', $bulan)
                ->whereIn('status', [1])
                ->get();

            if ($models->isEmpty()) {
                return response()->json(['error' => 'Tidak ada data untuk diselesaikan.'], 404);
            }

            foreach ($models as $model) {
                $model->status = 3;
                $model->save(); // <-- ini yang akan memicu LogTraitEv
            }

            return response()->json(['success' => 'Periode berhasil diselesaikan.']);

            // Pastikan bahwa npwp dan bulan ada dalam kondisi where
            // $update = DB::table('harga_l_p_g_s')
            //     ->where('npwp', $npwp)
            //     ->where('bulan', $bulan)
            //     ->whereIn('status', [1, 2, 3])
            //     ->update([
            //         'status' => '3'
            //     ]);


            // if ($update) {
            //     // Jika berhasil, kembalikan respons JSON
            //     return response()->json(['success' => 'Periode berhasil diselesaikan.']);
            // } else {
            //     // Jika gagal, kembalikan respons JSON dengan status 500 (Internal Server Error)
            //     return response()->json(['error' => 'Gagal menyelesaikan periode.'], 500);
            // }
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }

    public function selesaiPeriode(Request $request)
    {
        try {
            $id = $request->input('id');

            $model = HargaLPG::findOrFail($id);
            $model->status = '3';
            $model->save(); // <-- otomatis memicu LogTraitEv

            return response()->json(['success' => 'Periode berhasil diselesaikan.']);
            // Pastikan bahwa npwp dan bulan ada dalam kondisi where
            // $update = DB::table('harga_l_p_g_s')->where('id', $id)
            //     ->update([
            //         'status' => '3'
            //     ]);



            // if ($update) {
            //     // Jika berhasil, kembalikan respons JSON
            //     return response()->json(['success' => 'Periode berhasil diselesaikan.']);
            // } else {
            //     // Jika gagal, kembalikan respons JSON dengan status 500 (Internal Server Error)
            //     return response()->json(['error' => 'Gagal menyelesaikan periode.'], 500);
            // }
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

        $query = DB::table('harga_l_p_g_s as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d(data)"))
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                'm.nama_opsi',
                DB::raw("d.data ->> 'No_SK_Izin' as nomor_izin"),
                DB::raw("d.data ->> 'Tanggal_Pengesahan' as tgl_disetujui"),
                DB::raw("d.data ->> 'Tanggal_izin' as tgl_pengajuan")
            )
            ->whereBetween('a.bulan', [$t_awal, $t_akhir]);

        if ($perusahaan !== 'all') {
            $query->where('a.npwp', $perusahaan);
        }

        $result = $query->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        }

        $data = [
            'title' => 'Laporan Harga LPG',
            'result' => $result,
        ];

        $view = view('evaluator.laporan_bu.harga.lpg.cetak', $data)->with('reload', true);

        return response($view);
    }






    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('harga_l_p_g_s as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->where('a.bulan', $tgl->format('Y-m-d'))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->select(
                'u.name as nama_perusahaan',
                'i.npwp',
                'm.status',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->groupBy('u.name', 'i.npwp', 'm.status')
            ->get();
        // dd($query);

        $perusahaan = DB::table('harga_l_p_g_s as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->groupBy(
                'u.name',
                'i.npwp'
            )
            ->select(
                DB::raw("MAX(a.bulan) as bulan_terbaru"),
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->get();

        // dd($perusahaan);



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
        $t_awal = Carbon::parse($request->t_awal)->startOfDay();
        $t_akhir = Carbon::parse($request->t_akhir)->endOfDay();

        // Data perusahaan (tanpa mepings)
        $perusahaan = DB::table('harga_l_p_g_s as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->groupBy('u.name', 'i.npwp')
            ->select(
                DB::raw("MAX(a.bulan) as bulan_terbaru"),
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->get();

        // Query data utama
        $query = DB::table('harga_l_p_g_s as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->select(
                'a.id',
                'a.npwp',
                'a.bulan',
                'a.status',
                'a.catatan',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.biaya_perolehan',
                'a.biaya_distribusi',
                'a.biaya_penyimpanan',
                'a.margin',
                'a.ppn',
                'a.harga_jual',
                'a.created_at',
                'a.tgl_kirim',
                'u.name as nama_perusahaan',
                'm.nama_opsi',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->groupBy(
                'a.id',
                'a.npwp',
                'a.bulan',
                'a.status',
                'a.catatan',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.biaya_perolehan',
                'a.biaya_distribusi',
                'a.biaya_penyimpanan',
                'a.margin',
                'a.ppn',
                'a.harga_jual',
                'a.created_at',
                'a.tgl_kirim',
                'u.name',
                'm.nama_opsi'
            );

        // Filter perusahaan
        if ($request->perusahaan != 'all') {
            $query->where('a.npwp', $request->perusahaan);
        }

        // 🔥 Gunakan OR filter: bulan ATAU tgl_kirim
        $query->where(function ($q) use ($t_awal, $t_akhir) {
            $q->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                ->orWhereBetween('a.created_at', [$t_awal, $t_akhir]);
        });

        // Filter status aktif
        $query->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        $result = $query->get();

        return view('evaluator.laporan_bu.harga.lpg.lihat-semua-data', [
            'title' => 'Laporan Harga LPG',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
