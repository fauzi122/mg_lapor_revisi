<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use App\Models\PenjualanJbkp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class EvPenjualanJbkp extends Controller
{

    public function index()
    {
        $perusahaan = PenjualanJbkp::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha')
            ->get();

        // Dekode JSON pada field izin_usaha
        foreach ($perusahaan as $item) {
            $item->izin_list = json_decode($item->izin_usaha, true);
        }

        $data = [
            'title' => 'Laporan Penjualan JBKP',
            'perusahaan' => $perusahaan,
        ];
        // dd($perusahaan);
        return view('evaluator.laporan_bu.bph_inline.penjualan_jbkp.index', $data);
    }



    public function periode($kode = '')
    {
        $p = !empty($kode) ? Crypt::decryptString($kode) : null;
        $query = collect();

        if ($p) {
            // Ambil dan group berdasarkan bulan-tahun
            $query = PenjualanJbkp::select('bulan', 'tahun', DB::raw('MIN(id) as id')) 
                ->where('npwp_badan_usaha', $p)
                ->groupBy('tahun', 'bulan')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }

        $data = [
            'title' => 'Laporan Penjualan JBKP',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
    //   dd($query);
        return view('evaluator.laporan_bu.bph_inline.penjualan_jbkp.periode', $data);
    }


    public function show($kode = '')
    {
        $pecah = explode(',', Crypt::decryptString($kode));
        $query = PenjualanJbkp::get();
        $data = [
            'title'=>'Laporan Penjualan JBKP',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.bph_inline.penjualan_jbkp.pilihbulan', $data);

    }

public function lihatSemuaData()
{
    $tgl = Carbon::now();
    $bulan = $tgl->month; // hasilnya 1–12
    $tahun = $tgl->year;

    $query = PenjualanJbkp::where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->get();
    $perusahaan  = PenjualanJbkp::groupBy('npwp_badan_usaha')->get();
    $periode = $tgl->translatedFormat('F Y'); // contoh: "Mei 2025"

    return view('evaluator.laporan_bu.bph_inline.penjualan_jbkp.lihat-semua-data', [
        'title'     => 'Laporan Penjualan JBKP',
        'query'     => $query,
        'periode'   => $periode,
        'perusahaan'=> $perusahaan,
    ]);
}


    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = DB::table('bph_penjualan_jbkp as a')
        ->leftJoin('t_perusahaan as b', 'a.id_badan_usaha', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->whereIn('a.status', [1, 2, 3])
        ->groupBy('a.id_badan_usaha')
        ->select('b.id_perusahaan', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN')
        ->get();

        $query = DB::table('bph_penjualan_jbkp as a')
        ->leftJoin('t_perusahaan as b', 'a.id_badan_usaha', '=', 'b.ID_PERUSAHAAN')
        ->leftJoin('r_permohonan_izin as c', 'b.ID_PERUSAHAAN', '=', 'c.ID_PERUSAHAAN')
        ->select('a.*', 'b.NAMA_PERUSAHAAN','c.TGL_DISETUJUI','c.NOMOR_IZIN','c.TGL_PENGAJUAN');
        
        if ($request->perusahaan != 'all') {
            $query->where('badan_usaha_id', $request->perusahaan);
        }

        $result = $query->whereBetween('a.bulan', [$t_awal->format('Y-m-d'), $t_akhir->format('Y-m-d')])
                    ->whereIn('a.status', [1, 2, 3])->get();

        return view('evaluator.laporan_bu.bph_inline.penjualan_jbkp.lihat-semua-data', [
            'title' => 'Laporan Penjualan JBKP',
            'periode' => 'Tanggal ' . $t_awal->format('d F Y') . " - " . $t_akhir->format('d F Y'),
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
