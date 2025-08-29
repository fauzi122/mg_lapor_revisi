<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Impor;
use App\Traits\EvaluatorTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvImporController extends Controller
{
    use EvaluatorTrait;

    protected $tableName = "impors";

    public function index(){

        $perusahaan = $this->indexQuery($this->tableName)->get();

        $data = [
            'title'=>'Laporan Impor',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.exim.impor.index',$data);
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

        $query = DB::table('impors as a')
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
            'a.bulan_pib',
            'a.produk',
            'a.hs_code',
            'a.volume_pib',
            'a.invoice_amount_nilai_pabean',
            'a.invoice_amount_final',
            'a.satuan',
            'a.nama_supplier',
            'a.negara_asal',
            'a.pelabuhan_muat',
            'a.vessel_name',
            'a.tanggal_bl',
            'a.bl_no',
            'a.no_pendaf_pib',
            'a.tanggal_pendaf_pib',
            'a.incoterms',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'a.pelabuhan_bongkar',
            'u.name'
            )
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->where(function ($q) use ($t_awal, $t_akhir) {
                $q->whereBetween(DB::raw('a.bulan_pib::date'), [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')]);
            });

        if ($perusahaan != 'all') {
            $query->where('a.npwp', $perusahaan);
        }

        $result = $query->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
        }

        $data = [
            'title' => 'Laporan Impor',
            'result' => $result
        ];

        return response(view('evaluator.laporan_bu.exim.impor.cetak', $data)->with('reload', true));
    }



    public function periode($kode = '')
    {


        $p = !empty($kode) ? explode(',', Crypt::decryptString($kode)) : null;

        if ($p) {
            $query = $this->periodeQuery($this->tableName, $p, 'bulan_pib')->get();

        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Impor',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.exim.impor.periode', $data);
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

        $query = $this->showQuery($this->tableName, $npwp, $id_permohonan, $like, 'bulan_pib')->get();
        // var_dump($query);die();

        $data = [
            'title'=>'Laporan Impor',
            'query'=>$query,
            'per'=>$query->first(),
            'mode'  => $mode

        ];
        return view('evaluator.laporan_bu.exim.impor.pilihbulan', $data);

    }

    public function updateRevisionNotes(Request $request)
    {

        $request->validate([
            'catatan' => 'required',
        ]);

        $id = Crypt::decrypt($request->input('id'));


        // $update = Impor::where('id', $id)
        //     ->update([
        //         'catatan' => $request->catatan,
        //         'status' => '2'
        //     ]);
        $update = Impor::findOrFail($id);
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

        $models = Impor::where('npwp', $npwp)
            ->where('bulan_pib', $bulan)
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

        // $update = Impor::where('badan_usaha_id', $badan_usaha_id)->where('bulan_pib',$bulan)
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
            $models = Impor::where('npwp', $npwp)
                ->where('bulan_pib', $bulan)
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

            $model = Impor::findOrFail($id);
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

        $query = DB::table('impors as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->where('a.bulan_pib', $tgl->startOfMonth()->format('Y-m-d'))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->select(
                'a.*',
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
            )
            ->groupBy(
                'a.id',
                'a.npwp',
                'a.id_permohonan',
                'a.bulan_pib',
                'a.produk',
                'a.hs_code',
                'a.volume_pib',
                'a.invoice_amount_nilai_pabean',
                'a.invoice_amount_final',
                'a.satuan',
                'a.nama_supplier',
                'a.negara_asal',
                'a.pelabuhan_muat',
                'a.vessel_name',
                'a.tanggal_bl',
                'a.bl_no',
                'a.no_pendaf_pib',
                'a.tanggal_pendaf_pib',
                'a.incoterms',
                'a.status',
                'a.tgl_kirim',
                'a.catatan',
                'a.created_at',
                'a.updated_at',
                'a.id_sub_page',
                'a.pelabuhan_bongkar',
                'u.name',
            )
            ->get();
        // dd($query);

        $perusahaan = $this->perusahaanQuery($this->tableName, 'bulan_pib')->get();

        // return json_decode($query); exit;
        return view('evaluator.laporan_bu.exim.impor.lihat-semua-data', [
            'title' => 'Laporan Impor',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = $this->perusahaanQuery($this->tableName, 'bulan_pib')->get();

        $query = DB::table('impors as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            // ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'a.id_permohonan')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
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
            'a.bulan_pib',
            'a.produk',
            'a.hs_code',
            'a.volume_pib',
            'a.invoice_amount_nilai_pabean',
            'a.invoice_amount_final',
            'a.satuan',
            'a.nama_supplier',
            'a.negara_asal',
            'a.pelabuhan_muat',
            'a.vessel_name',
            'a.tanggal_bl',
            'a.bl_no',
            'a.no_pendaf_pib',
            'a.tanggal_pendaf_pib',
            'a.incoterms',
            'a.status',
            'a.tgl_kirim',
            'a.catatan',
            'a.created_at',
            'a.updated_at',
            'a.id_sub_page',
            'a.pelabuhan_bongkar',
            'u.name'
        );

        if ($request->perusahaan !== 'all') {
            $query->where('a.npwp', $request->perusahaan);
        }

        $query->whereBetween('a.bulan_pib', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);

        $result = $query->get();

        // if ($request->perusahaan != 'all') {
        //     $query->where('badan_usaha_id', $request->perusahaan);
        // }

        // $result = $query->whereBetween('a.bulan_pib', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
        //             ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.exim.impor.lihat-semua-data', [
            'title' => 'Laporan Impor',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }

//
//    public function index(Request $request){
//		//dd($request->all());
//		$query = Impor::select('impors.*','t_perusahaan.NAMA_PERUSAHAAN','izins.key')
//			->leftJoin('t_perusahaan','impors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//			->leftJoin('izins','impors.izin_id','izins.id')
//			->whereIn('status',['2','1']);
//
//		$bu = Impor::select('t_perusahaan.NAMA_PERUSAHAAN')
//			->leftJoin('t_perusahaan','impors.badan_usaha_id','t_perusahaan.ID_PERUSAHAAN')
//			->groupBy('t_perusahaan.NAMA_PERUSAHAAN')
//			->orderBy('t_perusahaan.NAMA_PERUSAHAAN','asc')
//			->get();
//
//		$produk = Impor::select('produk')
//			->groupBy('produk')
//			->orderBy('produk','asc')
//			->get();
//
//		if ($request->bulan1 == '' || $request->bulan2 == '') {
//			// dd('hai');
//            $bulan1 = Carbon::now()->format('Y-m');
//            // $bulan2 = Carbon::now()->subMonth(1);
//            $bulan2 = Carbon::now()->format('Y-m');
//			// dd($bulan1,$bulan2);
//			$query = $query->whereBetween(DB::raw("(date_format(bulan_pib,'%Y-%m'))"), [$bulan1, $bulan2]);
//        } else {
//            $request->validate([
//                'bulan1' => 'required|date',
//                'bulan2' => 'required|date|after_or_equal:date_start'
//            ]);
//
//            $bulan1 = $request->bulan1;
//            $bulan2 = $request->bulan2;
//			$query = $query->whereBetween(DB::raw("(date_format(bulan_pib,'%Y-%m'))"), [$bulan1, $bulan2]);
//        }
//		// dd($bulan1,$bulan2);
//
//		if($request->badan_usaha != ''){
//			$query = $query->where('t_perusahaan.NAMA_PERUSAHAAN',$request->badan_usaha);
//		}
//
//		if($request->produk != ''){
//			$query = $query->where('impors.produk',$request->produk);
//		}
//
//		if($request->kab_kota != ''){
//			$query = $query->where('impors.kabupaten_kota',$request->kab_kota);
//		}
//
//		$query = $query->orderBy('id','asc')->get();
//
//        // $query = [];
//        // $bu = [];
//        // $produk = [];
//        // $kota = [];
//
//		return view('evaluator.laporan_bu.exim.impor.index',compact('query','bu','produk'));
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
//		$update = Impor::where('id',$id)
//			->update([
//				'catatan' => $request->catatan,
//				'status' => '2'
//			]);
//
//        return redirect()->back()->with('success', 'Catatan revisi berhasil dikirim.');
//	}
}
