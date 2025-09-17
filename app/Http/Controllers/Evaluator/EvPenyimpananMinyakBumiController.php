<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyminyakbumi;
use App\Traits\EvaluatorTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvPenyimpananMinyakBumiController extends Controller
{
    use EvaluatorTrait;

    protected $tableName = "penyminyakbumis";
    
    public function index(){

        $perusahaan = $this->indexQuery($this->tableName)->get();
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
        // $request->validate([
        //     'perusahaan' => 'required',
        //     't_awal' => 'required|date',
        //     't_akhir' => 'required|date|after_or_equal:t_awal',
        // ]);

        $perusahaan = $request->input('perusahaan');
        $t_awal = Carbon::parse($request->t_awal . '-01')->startOfMonth();
        $t_akhir = Carbon::parse($request->t_akhir . '-01')->endOfMonth();


        $query = DB::table('penyminyakbumis as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d(data)"))
            ->leftJoin(DB::raw("jsonb_array_elements(d->'multiple_id') as elem"), DB::raw("(elem->>'sub_page_id')::int"), '=', 'a.id_sub_page')
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN(elem->>'sub_page_desc') as kegiatan_usaha"),
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
                $q->whereBetween(DB::raw('a.bulan::date'), [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')]);
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
        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;
        
        if ($p) {
            $query = $this->periodeQuery($this->tableName, $p)->get();
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
        $query = $this->lihatSemuaDataQuery($this->tableName, $tgl)->groupBy(
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
            )
            ->get();


        $perusahaan = $this->perusahaanQuery($this->tableName)->get();

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
        $t_awal = Carbon::parse($request->t_awal . '-01')->startOfMonth();
        $t_akhir = Carbon::parse($request->t_akhir . '-01')->endOfMonth();

        $perusahaan = $this->perusahaanQuery($this->tableName)->get();

        $query = $this->FilterDataQuery($this->tableName)->groupBy(
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

        $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);


        $result = $query->get();

        return view('evaluator.laporan_bu.penyimpanan.mb.lihat-semua-data', [
            'title' => 'Laporan Penyimpanan Minyak Bumi',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
