<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan_lng;
use App\Traits\EvaluatorTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvJualLng_Bbg_Cng_Controller extends Controller
{
    use EvaluatorTrait;

    protected $tableName = "penjualan_lngs";

    public function index()
    {
        $perusahaan = $this->indexQuery($this->tableName)->get();

        // Kondisi untuk grup hanya berdasarkan `badan_usaha_id`
        $perusahaan_only_bu = DB::table('penjualan_lngs as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->whereIn('a.status', [1, 2, 3])
            ->groupBy('a.npwp', 'u.npwp', 'u.name')
            ->select(
                'u.npwp',
                'u.name as nama_perusahaan'
            )
            ->get();
    
        $data = [
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
            'perusahaan' => $perusahaan,
            'perusahaan_only_bu' => $perusahaan_only_bu, // Menambahkan ke data array
        ];
    
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.index', $data);
    }
    
    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');
        $t_awal = Carbon::parse($request->t_awal . '-01')->startOfMonth();
        $t_akhir = Carbon::parse($request->t_akhir . '-01')->endOfMonth();
    
        // Query dasar untuk mendapatkan data penjualan
            $query = DB::table('penjualan_lngs as a')
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
                'a.provinsi',
                'a.kabupaten_kota',
                'a.produk',
                'a.konsumen',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.biaya_kompresi',
                'a.satuan_biaya_kompresi',
                'a.biaya_penyimpanan',
                'a.satuan_biaya_penyimpanan',
                'a.biaya_pengangkutan',
                'a.satuan_biaya_pengangkutan',
                'a.biaya_niaga',
                'a.satuan_biaya_niaga',
                'a.harga_bahan_baku',
                'a.satuan_harga_bahan_baku',
                'a.pajak',
                'a.satuan_pajak',
                'a.harga_jual',
                'a.satuan_harga_jual',
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
                'title' => 'Laporan Penjualan LNG/CNG/BBG',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.lng_cng_bbg.penjualan.cetak', $data);
    
            // Menambahkan script JavaScript untuk reload halaman
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
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.periode', $data);
    }
    // public function periode($kode='')
    // {
    //     $p = !empty($kode) ? Crypt::decrypt($kode) : null;
    //     if ($p) {
    //         $query = DB::table('jual_hasil_olah_bbms as a')
    //             ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
    //             ->selectRaw('
    //                 MAX(a.npwp) as npwp, 
    //                 a.bulan, 
    //                 MAX(a.status) as status, 
    //                 MAX(a.catatan) as catatan, 
    //                 MAX(u.name) as nama_perusahaan,
    //                 MAX(u.badan_usaha_id) as badan_usaha_id
    //                 ')
    //             ->where('a.npwp', $p)
    //             ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
    //             ->groupBy('a.bulan')
    //             ->get();
    //     } else {
    //         $query = ''; 
    //     }
    
    //     $data = [
    //         'title' => 'Laporan Penjualan LNG/CNG/BBG',
    //         'p' => $p,
    //         'query' => $query,
    //         'per' => $query->first()
    //     ];
    //     // dd($per);
   
    //     return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.periode', $data);
    // }
     
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
            'title'=>'Laporan Penjualan LNG/CNG/BBG',
            'query'=>$query,
            'per'=>$query->first(),
            'mode'  => $mode

        ];
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        // $update = DB::table('penjualan_lngs')->where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);
        $update = Penjualan_lng::findOrFail($id);
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


        $models = Penjualan_lng::where('npwp', $npwp)
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
    }

    public function selesaiPeriodeAll(Request $request)
    {
        // dd($request);
        try {

            $npwp = Crypt::decrypt($request->input('p'));
            $bulan = Crypt::decrypt($request->input('b'));

            $models = Penjualan_lng::where('npwp', $npwp)
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

            $model = Penjualan_lng::findOrFail($id);
            $model->status = '3';
            $model->save(); // <-- otomatis memicu LogTraitEv

            return response()->json(['success' => 'Periode berhasil diselesaikan.']);
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }

    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('penjualan_lngs as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->leftJoin(DB::raw("jsonb_array_elements(d->'multiple_id') as elem"), DB::raw("(elem->>'sub_page_id')::int"), '=', 'a.id_sub_page')
            ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan"),
                DB::raw("MIN(elem->>'sub_page_desc') as kegiatan_usaha")
            )->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.produk',
                'a.konsumen',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.biaya_kompresi',
                'a.satuan_biaya_kompresi',
                'a.biaya_penyimpanan',
                'a.satuan_biaya_penyimpanan',
                'a.biaya_pengangkutan',
                'a.satuan_biaya_pengangkutan',
                'a.biaya_niaga',
                'a.satuan_biaya_niaga',
                'a.harga_bahan_baku',
                'a.satuan_harga_bahan_baku',
                'a.pajak',
                'a.satuan_pajak',
                'a.harga_jual',
                'a.satuan_harga_jual',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.petugas',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name',
                'i.npwp',
            )
            ->get();

        $perusahaan = $this->perusahaanQuery($this->tableName)->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.lihat-semua-data', [
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
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

        $query = DB::table('penjualan_lngs as a')
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
                'a.provinsi',
                'a.kabupaten_kota',
                'a.produk',
                'a.konsumen',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.biaya_kompresi',
                'a.satuan_biaya_kompresi',
                'a.biaya_penyimpanan',
                'a.satuan_biaya_penyimpanan',
                'a.biaya_pengangkutan',
                'a.satuan_biaya_pengangkutan',
                'a.biaya_niaga',
                'a.satuan_biaya_niaga',
                'a.harga_bahan_baku',
                'a.satuan_harga_bahan_baku',
                'a.pajak',
                'a.satuan_pajak',
                'a.harga_jual',
                'a.satuan_harga_jual',
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

        $result = $query->get();

        return view('evaluator.laporan_bu.lng_cng_bbg.penjualan.lihat-semua-data', [
            'title' => 'Laporan Penjualan LNG/CNG/BBG',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
