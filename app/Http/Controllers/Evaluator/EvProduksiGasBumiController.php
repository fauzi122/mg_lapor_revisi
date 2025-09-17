<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use App\Models\Pengolahan;
use App\Traits\EvaluatorTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvProduksiGasBumiController extends Controller
{
    use EvaluatorTrait;

    protected 
    $tableName = "pengolahans", 
    $jenis = "Gas Bumi",
    $tipe = 'Produksi';

    public function index(){

        $perusahaan = $this->indexQuery($this->tableName, $this->jenis, $this->tipe)->get();

        $data = [
            'title'=>'Laporan Gas Bumi Produksi Kilang',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.gb.produksi.index',$data);
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
    
        $query = DB::table('pengolahans as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            // ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d(data)"))
            ->leftJoin(DB::raw("jsonb_array_elements(d->'multiple_id') as elem"), DB::raw("(elem->>'sub_page_id')::int"), '=', 'a.id_sub_page')
            ->where('a.tipe', 'Produksi')
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
                'a.kategori_pemasok',
                'a.intake_kilang',
                'a.produk',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.keterangan',
                'a.jenis',
                'a.tipe',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.petugas',
                'a.nama',
                'a.nama_bu_niaga',
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
                'title' => 'Laporan Gas Bumi Produksi Kilang',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.gb.produksi.cetak', $data);
            $view->with('reload', true);
    
            return response($view);
        }
    }
    

    public function periode($kode = '')
    {


        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;
        if ($p) {
            $query = $this->periodeQuery($this->tableName, $p, 'bulan', $this->jenis, $this->tipe)->get();


        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Gas Bumi Produksi Kilang',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.gb.produksi.periode', $data);
    }

    // public function show($kode = '', $filter = null)
    // {

    //     $pecah = explode(',', Crypt::decryptString($kode));

    //     if ($filter && $filter === "tahun") {
    //         $filterBy = substr($pecah[0], 0, 4);
    //     } 
    //     else {
    //         $filterBy = $pecah[0];
    //     }

    //     $query = DB::table('pengolahans as a')
    //         ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
    //         ->select('a.*', 'b.NAMA_PERUSAHAAN')
    //         ->where('a.jenis', 'Gas Bumi')
    //         ->where('a.tipe', 'Produksi')
    //         ->where('a.badan_usaha_id', $pecah[1])
    //         ->where('a.bulan', 'like', "%". $filterBy ."%")
    //         ->whereIn('a.status', [1, 2,3])
    //         ->get();

    //     // var_dump($query);die();

    //     $data = [
    //         'title'=>'Laporan Gas Bumi Produksi Kilang',
    //         'query'=>$query,
    //         'per'=>$query->first()

    //     ];
    //     return view('evaluator.laporan_bu.gb.produksi.pilihbulan', $data);

    // }

    public function show($kode = '')
    {
        try {
            // Dekripsi kode dan pecah jadi 3 bagian
            $pecah = explode(',', Crypt::decryptString($kode));

            // Pastikan jumlah elemen valid
            if (count($pecah) !== 4) {
                abort(404, 'Format kode salah');
            }

            [$mode, $bulan, $npwp, $id_permohonan] = $pecah;

            // Validasi isi mode
            if (!in_array($mode, ['bulan', 'tahun'])) {
                abort(404, 'Mode tidak dikenali');
            }

            // Filter berdasarkan mode
            $like = $mode === 'tahun' ? substr($bulan, 0, 4) . '%' : $bulan;

            // Jika kolom bulan adalah tipe string: YYYY-MM-DD
            $query = $this->showQuery($this->tableName, $npwp, $id_permohonan, $like, 'bulan', $this->jenis, $this->tipe)->get();

            // Jika tidak ada data, tampilkan halaman 404
            if ($query->isEmpty()) {
                abort(404, 'Data tidak ditemukan.');
            }

            $data = [
                'title' => 'Laporan Gas Bumi Produksi Kilang',
                'query' => $query,
                'per' => $query->first(),
                'mode' => $mode
            ];

            // Kirim ke view
            return view('evaluator.laporan_bu.gb.produksi.pilihbulan', $data);
        } catch (\Exception $e) {
            // Jika dekripsi gagal atau error lainnya, tampilkan 404
            abort(404, 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        // $update = DB::table('pengolahans')->where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);
        $update = Pengolahan::findOrFail($id);
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

        $models = Pengolahan::where('npwp', $npwp)
            ->where('bulan', $bulan)
            ->where('jenis', 'Gas Bumi')
            ->where('tipe', 'Produksi')
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


        // $update = DB::table('pengolahans')
        //     ->where('jenis', 'Gas Bumi')
        //     ->where('tipe', 'Produksi')
        //     ->where('npwp', $badan_usaha_id)
        //     ->where('bulan',$bulan)
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
            $models = Pengolahan::where('npwp', $npwp)
                ->where('bulan', $bulan)
                ->where('jenis', 'Gas Bumi')
                ->where('tipe', 'Produksi')
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

            $model = Pengolahan::findOrFail($id);
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

        $query = $this->lihatSemuaDataQuery($this->tableName, $tgl, 'bulan', $this->jenis, $this->tipe)->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.kategori_pemasok',
                'a.intake_kilang',
                'a.produk',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.keterangan',
                'a.jenis',
                'a.tipe',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.petugas',
                'a.nama',
                'a.nama_bu_niaga',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name'
            )
            ->get();


        $perusahaan = $this->perusahaanQuery($this->tableName)->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.gb.produksi.lihat-semua-data', [
            'title' => 'Laporan Gas Bumi Produksi Kilang',
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

        $query = $this->FilterDataQuery($this->tableName, $this->jenis, $this->tipe)->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan',
                'a.kategori_pemasok',
                'a.intake_kilang',
                'a.produk',
                'a.provinsi',
                'a.kabupaten_kota',
                'a.sektor',
                'a.volume',
                'a.satuan',
                'a.keterangan',
                'a.jenis',
                'a.tipe',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.petugas',
                'a.nama',
                'a.nama_bu_niaga',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name'
            );

        if ($request->perusahaan != 'all') {
            $query->where('a.npwp', $request->perusahaan);
        }

        $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        $result = $query->get();

        return view('evaluator.laporan_bu.gb.produksi.lihat-semua-data', [
            'title' => 'Laporan Gas Bumi Produksi Kilang',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
