<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jual_hasil_olah_bbm;
use App\Traits\EvaluatorTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvHasilOlahController extends Controller
{
    use EvaluatorTrait;

    protected $tableName = "jual_hasil_olah_bbms";

    public function index()
    {
        $perusahaan =  $this->indexQuery($this->tableName)->get();
            
        $data = [
            'title' => 'Laporan Penjualan Hasil Olahan/Minyak Bumi',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.hasil_olah_mb.jual_hasil.index', $data);
    }

    public function periode($kode = '')
    {
        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;

        if ($p) {
            $query = $this->periodeQuery($this->tableName, $p)->get();
        } else {
            $query = '';
        }
        $data = [
            'title' => 'Laporan Penjualan Hasil Olahan/Minyak Bumi',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.hasil_olah_mb.jual_hasil.periode', $data);
    }

    public function show($kode = '')
    {
        $pecah = explode(',', Crypt::decryptString($kode));

        if (count($pecah) !== 4) {
            abort(404, 'Format kode salah');
        }

        $mode  = $pecah[0]; // 'bulan' atau 'tahun'
        $bulan = $pecah[1]; // ex: 2025-06-01
        $npwp  = $pecah[2];
        $id_permohonan  = $pecah[3];

        // Atur filter berdasarkan mode
        if ($mode === 'tahun') {
            $filterBy = substr($bulan, 0, 4); // ambil 2025
            $like = $filterBy . '%'; // like 2025%
        } else {
            $like = $bulan; // exact match bulan
        }

        $query = $this->showQuery($this->tableName, $npwp, $id_permohonan, $like)->get();
        //        var_dump($query);die();

        $data = [
            'title' => 'Laporan Penjualan Hasil Olahan/Minyak Bumi',
            'query' => $query,
            'per' => $query->first(),
            'mode'  => $mode

        ];
        return view('evaluator.laporan_bu.hasil_olah_mb.jual_hasil.pilihbulan', $data);
    }

    public function test()
    {
        $data = [
            'title' => 'Laporan Penjualan Hasil Olahan/Minyak Bumi',


        ];
        return view('evaluator.laporan_bu.hasil_olah_mb.jual_hasil.pilihbulan_backup', $data);
    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        // $update = DB::table('jual_hasil_olah_bbms')->where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);
        $update = Jual_hasil_olah_bbm::findOrFail($id);
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



        // $update = DB::table('jual_hasil_olah_bbms')
        //     ->where('npwp', $badan_usaha_id)
        //     ->where('bulan', $bulan)
        //     ->whereIn('status', [1, 2, 3])
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);
        $models = Jual_hasil_olah_bbm::where('npwp', $npwp)
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

        // $receiver = 'vanturgo16@gmail.com; ozanfauzi39@gmail.com';
        // $subject = 'Tes push notifikasi noreply mail ESDM';
        // $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';

        // $this->emailNotif($receiver,$subject,$content);

        // if($code = '403'){
        //     dd('Forbidden');
        // }
        // else if ($code = '200'){
        //     dd('sukses email');
        // }
        // else if($code = '401'){
        //     dd('gak punya akses');
        // }

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
            // Ambil semua data yang match
            $models = Jual_hasil_olah_bbm::where('npwp', $npwp)
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

            // // Pastikan bahwa badan_usaha_id dan bulan ada dalam kondisi where
            // $update = DB::table('jual_hasil_olah_bbms')
            //     ->where('npwp', $badan_usaha_id)
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

            $model = Jual_hasil_olah_bbm::findOrFail($id);
            $model->status = '3';
            $model->save(); // <-- otomatis memicu LogTraitEv

            return response()->json(['success' => 'Periode berhasil diselesaikan.']);

            // Pastikan bahwa badan_usaha_id dan bulan ada dalam kondisi where
            // $update = DB::table('jual_hasil_olah_bbms')->where('id', $id)
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
        $t_awal = Carbon::parse($request->input('t_awal'));
        $t_akhir = Carbon::parse($request->input('t_akhir'));

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('jual_hasil_olah_bbms as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            // ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d(data)"))
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.produk',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.petugas',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name'
            )
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->where(function ($q) use ($t_awal, $t_akhir) {
                $q->whereBetween(DB::raw('a.bulan::date'), [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')]);
            });

        if ($perusahaan != 'all') {
            $query->where('a.npwp', $perusahaan);
        }

        $result = $query->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Penjualan Hasil Olahan/Minyak Bumi',
                'result' => $result
            ];

            $view = view('evaluator.laporan_bu.hasil_olah_mb.jual_hasil.cetak', $data);

            // Menambahkan script JavaScript untuk reload halaman
            $view->with('reload', true);

            return response($view);
        }
    }



    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('jual_hasil_olah_bbms as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->leftJoin(DB::raw("jsonb_array_elements(d->'multiple_id') as elem"), DB::raw("(elem->>'sub_page_id')::int"), '=', 'a.id_sub_page')
            ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan"),
                DB::raw("MIN(elem->>'sub_page_desc') as kegiatan_usaha")
            )
            ->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.produk',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.petugas',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name',
            )
            ->get();

        $perusahaan = DB::table('jual_hasil_olah_bbms as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
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

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.hasil_olah_mb.jual_hasil.lihat-semua-data', [
            'title' => 'Laporan Penjualan Hasil Olahan/Minyak Bumi',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal . '-01')->startOfMonth();
        $t_akhir = Carbon::parse($request->t_akhir . '-01')->endOfMonth();

        $perusahaan = DB::table('jual_hasil_olah_bbms as a')
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

        $query = DB::table('jual_hasil_olah_bbms as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->leftJoin(DB::raw("jsonb_array_elements(d->'multiple_id') as elem"), DB::raw("(elem->>'sub_page_id')::int"), '=', 'a.id_sub_page')
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan"),
                DB::raw("MIN(elem->>'sub_page_desc') as kegiatan_usaha")
            )->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.produk',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.petugas',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name'
            );
        // dd($query);

        if ($request->perusahaan != 'all') {
            $query->where('a.npwp', $request->perusahaan);
        }

        // 🔥 Gunakan filter: bulan dan status
        $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        // 🔥 Gunakan OR filter: bulan ATAU tgl_kirim
        // $query->where(function ($q) use ($t_awal, $t_akhir) {
        //     $q->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
        //         ->orWhereBetween('a.created_at', [$t_awal, $t_akhir]);
        // });

        // // Filter status aktif
        // $query->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        $result = $query->get();

        return view('evaluator.laporan_bu.hasil_olah_mb.jual_hasil.lihat-semua-data', [
            'title' => 'Laporan Penjualan Hasil Olahan/Minyak Bumi',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
