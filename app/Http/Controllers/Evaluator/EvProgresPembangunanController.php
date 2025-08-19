<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use App\Models\ProgresPembangunan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvProgresPembangunanController extends Controller
{
    public function index()
    {
        $perusahaan = DB::table('izin_migas as i')
            ->join('progres_pembangunans as p', 'p.npwp', '=', 'i.npwp')
            ->join('users as u', 'u.npwp', '=', 'i.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->select(
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("MIN(d ->> 'No_SK_Izin') as no_sk_izin"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tanggal_izin"),
                DB::raw("MIN(d ->> 'Kode_Izin_Desc') as kode_izin_desc"),
                DB::raw("MIN(d ->> 'Jenis_Izin_Desc') as jenis_izin_desc"),
                DB::raw("MIN(d ->> 'Jenis_Pengesahan') as jenis_pengesahan"),
                DB::raw("MIN(d ->> 'Status_Pengesahan') as status_pengesahan"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tanggal_pengesahan"),
                DB::raw("MIN((d ->> 'Tanggal_Berakhir_izin')::date) as tanggal_berakhir_izin")
            )
            ->whereIn(DB::raw('p.status::int'), [0, 1, 2, 3])
            ->groupBy('u.name', 'i.npwp') // ✅ cukup per perusahaan saja
            ->get();

        // dd($perusahaan);
        $data = [
            'title' => 'Progres Pembangunan',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.progres_pembangunan.index', $data);
    }

    public function show($kode = '')
    {
        $npwp = Crypt::decryptString($kode);

        $query = DB::table('progres_pembangunans as p')
            ->leftJoin('users as u', 'p.npwp', '=', 'u.npwp')
            ->select('p.*', 'u.name as nama_perusahaan')
            ->where('p.npwp', $npwp)
            ->whereIn(DB::raw('p.status::int'), [0, 1, 2, 3])
            ->get();

        $data = [
            'title' => 'Laporan Progres Pembangunan',
            'query' => $query,
            'per'   => $query->first(),
        ];

        // dd($data); // cek dulu hasilnya
        return view('evaluator.laporan_bu.progres_pembangunan.show', $data);
    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));

        $update = ProgresPembangunan::findOrFail($id);
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
        
        $update = ProgresPembangunan::where('npwp', $npwp)
            ->whereIn('status', [1, 2, 3])
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

            // Pastikan bahwa npwp dan bulan ada dalam kondisi where
            $update = ProgresPembangunan::where('npwp', $npwp)
                ->whereIn('status', [1, 2, 3])
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

            $model = ProgresPembangunan::findOrFail($id);
            $model->status = '3';
            $model->save(); // <-- otomatis memicu LogTraitEv

            return response()->json(['success' => 'Periode berhasil diselesaikan.']);
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }

    // public function lihatSemuaData()
    // {
    //     $tgl = Carbon::now();

    //     $query = DB::table('progres_pembangunans as p')
    //         ->leftJoin('users as u', 'u.npwp', '=', 'p.npwp')
    //         ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
    //         ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
    //         ->where('p.created_at', $tgl->startOfMonth()->format('Y-m-d'))
    //         ->whereIn(DB::raw('p.status::int'), [1, 2, 3])
    //         ->groupBy(
    //             'a.id',
    //             'a.npwp',
    //             'a.id_permohonan',
    //             'a.prosentase_pembangunan',
    //             'a.realisasi_investasi',
    //             'a.matrik_bobot_pembangunan',
    //             'a.path_matrik_bobot_pembangunan',
    //             'a.bukti_progres_pembangunan',
    //             'a.path_bukti_progres_pembangunan',
    //             'a.tkdn',
    //             'a.status',
    //             'a.catatan',
    //             'a.petugas',
    //             'a.created_at',
    //             'a.updated_at',
    //             'u.name',
    //             'i.npwp',
    //             'm.status'
    //         )
    //         ->select(
    //             'a.*',
    //             'm.status',
    //             'i.npwp',
    //             'u.name as nama_perusahaan',
    //             DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
    //             DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
    //             DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
    //         )
    //         ->get();



    //     $perusahaan = DB::table('progres_pembangunan as p')
    //         ->leftJoin('users as u', 'u.npwp', '=', 'p.npwp')
    //         ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
    //         ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
    //         ->whereIn(DB::raw('p.status::int'), [1, 2, 3])
    //         ->groupBy('u.name', 'i.npwp')
    //         ->select(
    //             'u.name as nama_perusahaan',
    //             'i.npwp',
    //             DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
    //             DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
    //             DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
    //         )
    //         ->get();

    //     return view('evaluator.laporan_bu.exim.expor.lihat-semua-data', [
    //         'title' => 'Laporan Ekspor',
    //         'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
    //         'query' => $query,
    //         'perusahaan' => $perusahaan,
    //     ]);
    // }


    // public function filterData(Request $request)
    // {
    //     $t_awal = Carbon::parse($request->t_awal)->startOfDay();
    //     $t_akhir = Carbon::parse($request->t_akhir)->endOfDay();

    //     // Data perusahaan (dropdown)
    //     $perusahaan = DB::table('ekspors as a')
    //         ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
    //         ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
    //         ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
    //         ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
    //         ->groupBy('u.name', 'i.npwp')
    //         ->select(
    //             DB::raw("MAX(a.bulan_peb) as bulan_terbaru"),
    //             'u.name as nama_perusahaan',
    //             'i.npwp',
    //             DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
    //             DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
    //             DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
    //         )
    //         ->get();

    //     // Data ekspor (utama)
    //     $query = DB::table('ekspors as a')
    //         ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
    //         ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
    //         ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
    //         ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
    //         ->select(
    //             'a.id',
    //             'a.npwp',
    //             'a.bulan_peb',
    //             'a.produk',
    //             'a.hs_code',
    //             'a.volume_peb',
    //             'a.satuan',
    //             'a.invoice_amount_nilai_pabean',
    //             'a.invoice_amount_final',
    //             'a.nama_konsumen',
    //             'a.pelabuhan_muat',
    //             'a.negara_tujuan',
    //             'a.vessel_name',
    //             'a.tanggal_bl',
    //             'a.bl_no',
    //             'a.no_pendaf_peb',
    //             'a.tanggal_pendaf_peb',
    //             'a.incoterms',
    //             'a.status',
    //             'a.tgl_kirim',
    //             'a.catatan',
    //             'a.created_at',
    //             'a.updated_at',
    //             'a.id_sub_page',
    //             'u.name as nama_perusahaan',
    //             DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
    //             DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
    //             DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
    //         )
    //         ->groupBy(
    //             'a.id',
    //             'a.npwp',
    //             'a.bulan_peb',
    //             'a.produk',
    //             'a.hs_code',
    //             'a.volume_peb',
    //             'a.satuan',
    //             'a.invoice_amount_nilai_pabean',
    //             'a.invoice_amount_final',
    //             'a.nama_konsumen',
    //             'a.pelabuhan_muat',
    //             'a.negara_tujuan',
    //             'a.vessel_name',
    //             'a.tanggal_bl',
    //             'a.bl_no',
    //             'a.no_pendaf_peb',
    //             'a.tanggal_pendaf_peb',
    //             'a.incoterms',
    //             'a.status',
    //             'a.tgl_kirim',
    //             'a.catatan',
    //             'a.created_at',
    //             'a.updated_at',
    //             'a.id_sub_page',
    //             'u.name'
    //         )
    //         ->where(function ($q) use ($t_awal, $t_akhir) {
    //             $q->whereBetween('a.bulan_peb', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
    //                 ->orWhereBetween('a.created_at', [$t_awal, $t_akhir]);
    //         })
    //         ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

    //     if ($request->perusahaan !== 'all') {
    //         $query->where('a.npwp', $request->perusahaan);
    //     }

    //     $result = $query->get();

    //     return view('evaluator.laporan_bu.exim.expor.lihat-semua-data', [
    //         'title' => 'Laporan Ekspor',
    //         'periode' => 'Tanggal ' . $t_awal->format('d F Y') . ' - ' . $t_akhir->format('d F Y'),
    //         'query' => $result,
    //         'perusahaan' => $perusahaan,
    //     ]);
    // }
}
