<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekspor;
use App\Traits\EvaluatorTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvExporController extends Controller
{
    use EvaluatorTrait;

    protected $tableName = "ekspors";

    public function index(){

        $perusahaan = $this->indexQuery($this->tableName)->get();

        $data = [
            'title'=>'Laporan Ekspor',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.exim.expor.index',$data);
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


        $query = DB::table('ekspors as a')
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
            'a.id_permohonan',
            'a.npwp',
            'a.bulan_peb',
            'a.produk',
            'a.hs_code',
            'a.volume_peb',
            'a.satuan',
            'a.invoice_amount_nilai_pabean',
            'a.invoice_amount_final',
            'a.nama_konsumen',
            'a.pelabuhan_muat',
            'a.negara_tujuan',
            'a.vessel_name',
            'a.tanggal_bl',
            'a.bl_no',
            'a.no_pendaf_peb',
            'a.tanggal_pendaf_peb',
            'a.incoterms',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'u.name',
            )
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->where(function ($q) use ($t_awal, $t_akhir) {
                $q->whereBetween(DB::raw('a.bulan_peb::date'), [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')]);
            });
    
        if ($perusahaan != 'all') {
            $query->where('a.npwp', $perusahaan);
        }
    
        $result = $query->get();
    
        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Ekspor',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.exim.expor.cetak', $data);
            $view->with('reload', true);
    
            return response($view);
        }
    }
    

    public function periode($kode = '')
    {
        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;

        if ($p) {
            $query = $this->periodeQuery($this->tableName, $p, 'bulan_peb')->get();
        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Ekspor',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.exim.expor.periode', $data);
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

        $query = $this->showQuery($this->tableName, $npwp, $id_permohonan, $like, 'bulan_peb')->get();

//        var_dump($query);die();

        $data = [
            'title'=>'Laporan Ekspor',
            'query'=>$query,
            'per'=>$query->first(),
            'mode'  => $mode

        ];
        return view('evaluator.laporan_bu.exim.expor.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        // $update = Ekspor::where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);
        $update = Ekspor::findOrFail($id);
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

        $models = Ekspor::where('npwp', $npwp)
            ->where('bulan_peb', $bulan)
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


        // $update = Ekspor::where('badan_usaha_id', $badan_usaha_id)->where('bulan_peb',$bulan)
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
            $models = Ekspor::where('npwp', $npwp)
                ->where('bulan_peb', $bulan)
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

            $model = Ekspor::findOrFail($id);
            $model->status = '3';
            $model->save(); // <-- otomatis memicu LogTraitEv

            return response()->json(['success' => 'Periode berhasil diselesaikan.']);
        } catch (\Exception $e) {
            // Tangkap dan tangani exception
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status.'], 500);
        }
    }
    //    public function index(Request $request){
    //		//dd($request->all());
    //		$query = Ekspor::select('ekspors.*','t_perusahaan.NAMA_PERUSAHAAN','izins.key')
    //			->leftJoin('t_perusahaan','ekspors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
    //			->leftJoin('izins','ekspors.izin_id','izins.id')
    //			->whereIn('status',['2','1']);
    //
    //		$bu = Ekspor::select('t_perusahaan.NAMA_PERUSAHAAN')
    //			->leftJoin('t_perusahaan','ekspors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
    //			->groupBy('t_perusahaan.NAMA_PERUSAHAAN')
    //			->orderBy('t_perusahaan.NAMA_PERUSAHAAN','asc')
    //			->get();
    //
    //		$produk = Ekspor::select('produk')
    //			->groupBy('produk')
    //			->orderBy('produk','asc')
    //			->get();
    //
    //		// $kota = Ekspor::select('kabupaten_kota')
    //		// 	->groupBy('kabupaten_kota')
    //		// 	->orderBy('kabupaten_kota','asc')
    //		// 	->get();
    //
    //		if ($request->bulan1 == '' || $request->bulan2 == '') {
    //			// dd('hai');
    //            $bulan1 = Carbon::now()->format('Y-m');
    //            // $bulan2 = Carbon::now()->subMonth(1);
    //            $bulan2 = Carbon::now()->format('Y-m');
    //			// dd($bulan1,$bulan2);
    //			$query = $query->whereBetween(DB::raw("(date_format(bulan_peb,'%Y-%m'))"), [$bulan1, $bulan2]);
    //        } else {
    //            $request->validate([
    //                'bulan1' => 'required|date',
    //                'bulan2' => 'required|date|after_or_equal:date_start'
    //            ]);
    //
    //            $bulan1 = $request->bulan1;
    //            $bulan2 = $request->bulan2;
    //			$query = $query->whereBetween(DB::raw("(date_format(bulan_peb,'%Y-%m'))"), [$bulan1, $bulan2]);
    //        }
    //		// dd($bulan1,$bulan2);
    //
    //		if($request->badan_usaha != ''){
    //			$query = $query->where('t_perusahaan.NAMA_PERUSAHAAN',$request->badan_usaha);
    //		}
    //
    //		if($request->produk != ''){
    //			$query = $query->where('ekspors.produk',$request->produk);
    //		}
    //
    //		if($request->kab_kota != ''){
    //			$query = $query->where('ekspors.kabupaten_kota',$request->kab_kota);
    //		}
    //
    //		$query = $query->orderBy('id','asc')->get();
    //		// dd($query);
    //        // $query = [];
    //        // $bu = [];
    //        // $produk = [];
    //        // $kota = [];
    //
    //		return view('evaluator.laporan_bu.exim.expor.index',compact('query','bu','produk'));
    //	}
    //
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
    //		$update = Ekspor::where('id',$id)
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

        $query = DB::table('ekspors as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            // ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->leftJoin(DB::raw("jsonb_array_elements(d->'multiple_id') as elem"), DB::raw("(elem->>'sub_page_id')::int"), '=', 'a.id_sub_page')
            ->where('a.bulan_peb', $tgl->startOfMonth()->format('Y-m-d'))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->select(
                'a.*',
                'i.npwp',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan"),
                DB::raw("MIN(elem->>'sub_page_desc') as kegiatan_usaha")
            )
            ->groupBy(
                'a.id',
                'a.id_permohonan',
                'a.npwp',
                'a.bulan_peb',
                'a.produk',
                'a.hs_code',
                'a.volume_peb',
                'a.satuan',
                'a.invoice_amount_nilai_pabean',
                'a.invoice_amount_final',
                'a.nama_konsumen',
                'a.pelabuhan_muat',
                'a.negara_tujuan',
                'a.vessel_name',
                'a.tanggal_bl',
                'a.bl_no',
                'a.no_pendaf_peb',
                'a.tanggal_pendaf_peb',
                'a.incoterms',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name',
                'i.npwp',
            )->get();



        $perusahaan = $this->perusahaanQuery($this->tableName, 'bulan_peb')->get();


        return view('evaluator.laporan_bu.exim.expor.lihat-semua-data', [
            'title' => 'Laporan Ekspor',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }


    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal)->startOfDay();
        $t_akhir = Carbon::parse($request->t_akhir)->endOfDay();

        // Data perusahaan (dropdown)
        $perusahaan = $this->perusahaanQuery($this->tableName, 'bulan_peb')->get();


        // Data ekspor (utama)
        $query = DB::table('ekspors as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            // ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
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
            )
            ->groupBy(
                'a.id',
                'a.id_permohonan',
                'a.npwp',
                'a.bulan_peb',
                'a.produk',
                'a.hs_code',
                'a.volume_peb',
                'a.satuan',
                'a.invoice_amount_nilai_pabean',
                'a.invoice_amount_final',
                'a.nama_konsumen',
                'a.pelabuhan_muat',
                'a.negara_tujuan',
                'a.vessel_name',
                'a.tanggal_bl',
                'a.bl_no',
                'a.no_pendaf_peb',
                'a.tanggal_pendaf_peb',
                'a.incoterms',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'u.name'
            );

        if ($request->perusahaan !== 'all') {
            $query->where('a.npwp', $request->perusahaan);
        }

        $query->whereBetween('a.bulan_peb', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        $result = $query->get();

        return view('evaluator.laporan_bu.exim.expor.lihat-semua-data', [
            'title' => 'Laporan Ekspor',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . ' - ' . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
