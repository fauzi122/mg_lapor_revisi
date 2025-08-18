<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyminyakbumi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvPenyimpananMinyakBumiController extends Controller
{
    public function index(){

        $perusahaan = DB::table('penyminyakbumis as a')
        ->leftJoin('users as u', 'u.npwp', '=' , 'a.npwp')
        ->leftJoin('izin_migas as i', 'i.npwp', '=', 'a.npwp')
        ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
        ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
        ->groupBy('u.name', 'i.npwp', DB::raw("(d ->> 'Id_Permohonan')::int"))
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
        ->get();
        // dd($perusahaan);

    // Kondisi untuk grup hanya berdasarkan `badan_usaha_id`
    $perusahaan_only_bu = DB::table('penyminyakbumis as a')
        ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('u.name', 'a.npwp')
        ->select(
            'a.npwp',
            'u.name',
        )
        ->get();
// dd($perusahaan_only_bu);

        $data = [
            'title'=>'Laporan Penyimpanan Minyak Bumi',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.penyimpanan.mb.index',$data);
    }
    
    public function cetakperiode(Request $request)
    {
        $request->validate([
            'perusahaan' => 'required',
            't_awal' => 'required|date',
            't_akhir' => 'required|date|after_or_equal:t_awal',
        ]);

        $perusahaan = $request->input('perusahaan');
        $t_awal = Carbon::parse($request->input('t_awal'));
        $t_akhir = Carbon::parse($request->input('t_akhir'));


        $query = DB::table('penyminyakbumis as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d(data)"))
            ->select(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.jenis_fasilitas',
                'a.no_tangki',
                'a.kapasitas_tangki',
                'a.jenis_komoditas',
                'a.produk',
                'a.provinsi',
                'a.kab_kota',
                'a.kategori_supplai',
                'a.volume_stok_awal',
                'a.volume_supply',
                'a.volume_output',
                'a.volume_stok_akhir',
                'a.satuan',
                'a.utilisasi_tangki',
                'a.pengguna',
                'a.tarif_penyimpanan',
                'a.satuan_tarif',
                'a.keterangan',
                'a.tanggal_awal',
                'a.tanggal_akhir',
                'a.commingle',
                'a.jumlah_bu',
                'a.nama_penyewa',
                'a.kapasitas_penyewaan',
                'a.kontrak_sewa',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.jenis_fasilitas',
                'a.no_tangki',
                'a.kapasitas_tangki',
                'a.jenis_komoditas',
                'a.produk',
                'a.provinsi',
                'a.kab_kota',
                'a.kategori_supplai',
                'a.volume_stok_awal',
                'a.volume_supply',
                'a.volume_output',
                'a.volume_stok_akhir',
                'a.satuan',
                'a.utilisasi_tangki',
                'a.pengguna',
                'a.tarif_penyimpanan',
                'a.satuan_tarif',
                'a.keterangan',
                'a.tanggal_awal',
                'a.tanggal_akhir',
                'a.commingle',
                'a.jumlah_bu',
                'a.nama_penyewa',
                'a.kapasitas_penyewaan',
                'a.kontrak_sewa',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name'
            )
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->where(function ($q) use ($t_awal, $t_akhir) {
                $q->whereBetween(DB::raw('a.bulan::date'), [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->orWhereBetween('a.created_at', [$t_awal, $t_akhir]);
            });

        if ($perusahaan != 'all') {
            $query->where('a.npwp', $perusahaan);
        }

        $result = $query->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Penyimpanan Minyak Bumi',
                'result' => $result
            ];

            $view = view('evaluator.laporan_bu.penyimpanan.mb.cetak', $data);
            $view->with('reload', true);

            return response($view);
        }
    }


    public function periode($kode = '')
    {


        $p = !empty($kode) ? Crypt::decrypt($kode) : null;
        if ($p) {
            // $query = DB::table('penyminyakbumis as a')
            //     ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            //     ->select('a.*', 'b.NAMA_PERUSAHAAN')
            //     ->where('a.badan_usaha_id', $p)
            //     ->whereIn('a.status', [1, 2,3])
            //     ->groupBy('a.bulan')->get();
            $query = DB::table('penyminyakbumis as a')
                    ->selectRaw('
                    MAX(a.npwp) as npwp, 
                    a.bulan, 
                    MAX(a.status) as status, 
                    MAX(a.catatan) as catatan, 
                    MAX(u.name) as nama_perusahaan,
                    MAX(u.badan_usaha_id) as badan_usaha_id
                    ')
                ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
                ->where('a.npwp', $p)
                ->groupBy('a.bulan')
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
                ->get();
        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Penyimpanan Minyak Bumi',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.penyimpanan.mb.periode', $data);
    }

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

        $query = DB::table('penyminyakbumis as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->select('a.*', 'u.name as nama_perusahaan')
            ->where('a.npwp', $npwp)
            ->where('a.bulan', 'like', $like)
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->get();

//        var_dump($query);die();

        $data = [
            'title'=>'Laporan Penyimpanan Minyak Bumi',
            'query'=>$query,
            'per'=>$query->first(),
            'mode'  => $mode

        ];
        return view('evaluator.laporan_bu.penyimpanan.mb.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        // $update = Penyminyakbumi::where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);

        $update = Penyminyakbumi::findOrFail($id);
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
        $npwp = Crypt::decrypt($request->input('p')) ;
        $bulan = Crypt::decrypt($request->input('b')) ;

        $models = Penyminyakbumi::where('npwp', $npwp)
            ->where('bulan', $bulan)
            ->whereIn('status', [1, 2, 3])
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


        // $update = Penyminyakbumi::where('badan_usaha_id', $badan_usaha_id)->where('bulan',$bulan)
        //     ->whereIn('status', [1, 2,3])
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

            // Ambil semua data yang match
            $models = Penyminyakbumi::where('npwp', $npwp)
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
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }

    public function selesaiPeriode(Request $request)
    {
        try {
            $id = $request->input('id');

            $model = Penyminyakbumi::findOrFail($id);
            $model->status = '3';
            $model->save(); // <-- otomatis memicu LogTraitEv

            return response()->json(['success' => 'Periode berhasil diselesaikan.']);
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }
	
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
//		$update = Penyminyakbumi::where('id',$id)
//			->update([
//				'catatan' => $request->catatan,
//				'status' => '2'
//			]);
//
//        return redirect()->back()->with('success', 'Catatan revisi berhasil dikirim.');
//	}

public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        // Data bulan ini
        $query = DB::table('penyminyakbumis as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                'i.npwp',
                'm.status',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )->groupBy(
            'a.id',
            'a.npwp',
            'a.id_permohonan',
            'a.bulan',
            'a.jenis_fasilitas',
            'a.no_tangki',
            'a.kapasitas_tangki',
            'a.jenis_komoditas',
            'a.produk',
            'a.provinsi',
            'a.kab_kota',
            'a.kategori_supplai',
            'a.volume_stok_awal',
            'a.volume_supply',
            'a.volume_output',
            'a.volume_stok_akhir',
            'a.satuan',
            'a.utilisasi_tangki',
            'a.pengguna',
            'a.tarif_penyimpanan',
            'a.satuan_tarif',
            'a.keterangan',
            'a.tanggal_awal',
            'a.tanggal_akhir',
            'a.commingle',
            'a.jumlah_bu',
            'a.nama_penyewa',
            'a.kapasitas_penyewaan',
            'a.kontrak_sewa',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'u.name', 
            'i.npwp',
            'm.status'
            )
            ->get();


        $perusahaan = DB::table('penyminyakbumis as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->groupBy('u.name','i.npwp')
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
        return view('evaluator.laporan_bu.penyimpanan.mb.lihat-semua-data', [
            'title' => 'Laporan Penyimpanan Minyak Bumi',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('penyminyakbumis as a')
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

        $query = DB::table('penyminyakbumis as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->select(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.jenis_fasilitas',
                'a.no_tangki',
                'a.kapasitas_tangki',
                'a.jenis_komoditas',
                'a.produk',
                'a.provinsi',
                'a.kab_kota',
                'a.kategori_supplai',
                'a.volume_stok_awal',
                'a.volume_supply',
                'a.volume_output',
                'a.volume_stok_akhir',
                'a.satuan',
                'a.utilisasi_tangki',
                'a.pengguna',
                'a.tarif_penyimpanan',
                'a.satuan_tarif',
                'a.keterangan',
                'a.tanggal_awal',
                'a.tanggal_akhir',
                'a.commingle',
                'a.jumlah_bu',
                'a.nama_penyewa',
                'a.kapasitas_penyewaan',
                'a.kontrak_sewa',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.jenis_fasilitas',
                'a.no_tangki',
                'a.kapasitas_tangki',
                'a.jenis_komoditas',
                'a.produk',
                'a.provinsi',
                'a.kab_kota',
                'a.kategori_supplai',
                'a.volume_stok_awal',
                'a.volume_supply',
                'a.volume_output',
                'a.volume_stok_akhir',
                'a.satuan',
                'a.utilisasi_tangki',
                'a.pengguna',
                'a.tarif_penyimpanan',
                'a.satuan_tarif',
                'a.keterangan',
                'a.tanggal_awal',
                'a.tanggal_akhir',
                'a.commingle',
                'a.jumlah_bu',
                'a.nama_penyewa',
                'a.kapasitas_penyewaan',
                'a.kontrak_sewa',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name'
            );
        // dd($query);

        if ($request->perusahaan != 'all') {
            $query->where('a.npwp', $request->perusahaan);
        }

        // $result = $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
        //         ->whereIn(DB::raw('a.status::int'), [1, 2, 3])->get();

        // 🔥 Gunakan OR filter: bulan ATAU tgl_kirim
        $query->where(function ($q) use ($t_awal, $t_akhir) {
            $q->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                ->orWhereBetween('a.created_at', [$t_awal, $t_akhir]);
        });

        // Filter status aktif
        $query->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        $result = $query->get();

        return view('evaluator.laporan_bu.penyimpanan.mb.lihat-semua-data', [
            'title' => 'Laporan Penyimpanan Minyak Bumi',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
