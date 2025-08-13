<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use App\Models\Pengolahan;
use Illuminate\Http\Request;
use App\Models\PengolahanMBPasokan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EvPasokanMinyakBumiController extends Controller
{
    public function index(){

        $perusahaan = DB::table('pengolahans as a')
        ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'a.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->where('a.jenis', 'Minyak Bumi')
            ->where('a.tipe', 'Pasokan')
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



        $data = [
            'title'=>'Laporan Minyak Bumi Pasokan Kilang',
            'perusahaan' => $perusahaan,
        ];

        return view('evaluator.laporan_bu.mb.pasokan.index',$data);
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
    
        $query = DB::table('pengolahans as a')
        ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->leftJoin('izin_migas as i', 'u.npwp', '=', 'i.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d(data)"))
            ->where('a.tipe', 'Pasokan')
            ->select(
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
                'u.name as nama_perusahaan',
                DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
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
                'title' => 'Laporan Minyak Bumi Pasokan Kilang',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.mb.pasokan.cetak', $data);
            $view->with('reload', true);
    
            return response($view);
        }
    }
    

    public function periode($kode = '')
    {


        $p = !empty($kode) ? Crypt::decrypt($kode) : null;
        if ($p) {
            $query = DB::table('pengolahans as a')
                ->selectRaw('
                MAX(a.npwp) as npwp, 
                a.bulan, 
                MAX(a.status) as status, 
                MAX(a.catatan) as catatan, 
                MAX(u.name) as nama_perusahaan,
                MAX(u.badan_usaha_id) as badan_usaha_id
                ')
                // ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
                // ->select('a.*', 'b.NAMA_PERUSAHAAN')
                ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
                ->where('a.npwp', $p)
                ->where('a.jenis', 'Minyak Bumi')
                ->where('a.tipe', 'Pasokan')
                ->groupBy('a.bulan')
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
                ->get();


        } else {
            $query = '';

        }
        $data = [
            'title'=>'Laporan Minyak Bumi Pasokan Kilang',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
        return view('evaluator.laporan_bu.mb.pasokan.periode', $data);
    }

    //     public function show($kode = '', $filter = null)
    //     {

    //         $pecah = explode(',', Crypt::decryptString($kode));

    //         if ($filter && $filter === "tahun") {
    //             $filterBy = substr($pecah[0], 0, 4);
    //         } 
    //         else {
    //             $filterBy = $pecah[0];
    //         }

    //         $query = DB::table('pengolahans as a')
    //             ->leftJoin('t_perusahaan as b', 'a.badan_usaha_id', '=', 'b.ID_PERUSAHAAN')
    //             ->select('a.*', 'b.NAMA_PERUSAHAAN')
    //             ->where('a.jenis', 'Minyak Bumi')
    //             ->where('a.tipe', 'Pasokan')
    //             ->where('a.badan_usaha_id', $pecah[1])
    //             ->where('a.bulan', 'like', "%". $filterBy ."%")
    //             ->whereIn('a.status', [1, 2,3])
    //             ->get();

    // //        var_dump($query);die();

    //         $data = [
    //             'title'=>'Laporan Minyak Bumi Pasokan Kilang',
    //             'query'=>$query,
    //             'per'=>$query->first()

    //         ];
    //         return view('evaluator.laporan_bu.mb.pasokan.pilihbulan', $data);

    //     }

    public function show($kode = '')
    {
        try {
            // Dekripsi kode dan pecah jadi 3 bagian
            $pecah = explode(',', Crypt::decryptString($kode));

            // Pastikan jumlah elemen valid
            if (count($pecah) !== 3) {
                abort(404, 'Format kode salah');
            }

            [$mode, $bulan, $npwp] = $pecah;

            // Validasi isi mode
            if (!in_array($mode, ['bulan', 'tahun'])) {
                abort(404, 'Mode tidak dikenali');
            }

            // Filter berdasarkan mode
            $like = $mode === 'tahun' ? substr($bulan, 0, 4) . '%' : $bulan;

            // Jika kolom bulan adalah tipe string: YYYY-MM-DD
            $query = DB::table('pengolahans as a')
                ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
                ->select('a.*', 'u.name as nama_perusahaan')
                ->where('a.jenis', 'Minyak Bumi')
                ->where('a.tipe', 'Pasokan')
                ->where('a.npwp', $npwp)
                ->where('a.bulan', 'like', $like)
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
                ->get();

            // Jika tidak ada data, tampilkan halaman 404
            if ($query->isEmpty()) {
                abort(404, 'Data tidak ditemukan.');
            }

            $data = [
                'title' => 'Laporan Minyak Bumi Pasokan Kilang',
                'query' => $query,
                'per' => $query->first(),
                'mode' => $mode
            ];

            // Kirim ke view
            return view('evaluator.laporan_bu.mb.pasokan.pilihbulan', $data);
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
        $badan_usaha_id = Crypt::decrypt($request->input('p')) ;
        $bulan = Crypt::decrypt($request->input('b')) ;



        $update = DB::table('pengolahans')
            ->where('jenis', 'Minyak Bumi')
            ->where('tipe', 'Distribusi')
            ->where('npwp', $badan_usaha_id)
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
            $badan_usaha_id = Crypt::decrypt($request->input('p'));
            $bulan = Crypt::decrypt($request->input('b'));

            // Pastikan bahwa badan_usaha_id dan bulan ada dalam kondisi where
            $update = DB::table('pengolahans')
                ->where('jenis', 'Minyak Bumi')
                ->where('tipe', 'Distribusi')
                ->where('npwp', $badan_usaha_id)
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

            // Pastikan bahwa badan_usaha_id dan bulan ada dalam kondisi where
            $update = DB::table('pengolahans')->where('id', $id)
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

    public function lihatSemuaData()
    {
        $tgl = Carbon::now();

        $query = DB::table('pengolahans as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->where('a.jenis', 'Minyak Bumi')
            ->where('a.tipe', 'Pasokan')
            ->where('a.bulan', $tgl->startOfMonth()->format('Y-m-d'))
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
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


        $perusahaan = DB::table('pengolahans as a')
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
        return view('evaluator.laporan_bu.mb.pasokan.lihat-semua-data', [
            'title' => 'Laporan Minyak Bumi Pasokan Kilang',
            'periode' => 'Bulan ' . $tgl->monthName . " " . $tgl->year,
            'query' => $query,
            'perusahaan' => $perusahaan,
        ]);
    }

    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('pengolahans as a')
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

        $query = DB::table('pengolahans as a')
            ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
            ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
            ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->where('a.jenis', 'Minyak Bumi')
            ->where('a.tipe', 'Pasokan')
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

        return view('evaluator.laporan_bu.mb.pasokan.lihat-semua-data', [
            'title' => 'Laporan Minyak Bumi pasokan Kilang',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
