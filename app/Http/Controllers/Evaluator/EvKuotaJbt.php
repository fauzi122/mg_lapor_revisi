<?php

namespace App\Http\Controllers\evaluator;

use App\Http\Controllers\Controller;
use App\Jobs\bph\SyncJbtKuota;
use App\Models\KuotaJbt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvKuotaJbt extends Controller
{
    
    public function index()
    {
        $perusahaan = KuotaJbt::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha','izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        $lastSync = KuotaJbt::latest()->first();
        // Dekode JSON pada field izin_usaha
        foreach ($perusahaan as $item) {
            $item->izin_list = json_decode($item->izin_usaha, true);
        }

        $data = [
            'title' => 'Laporan JBT Kuota',
            'perusahaan' => $perusahaan,
            'lastSync' => $lastSync,
        ];
        // dd($perusahaan);
        return view('evaluator.laporan_bu.bph_inline.kuota_jbt.index', $data);
    }



    public function periode($kode = '')
    {
        $p = !empty($kode) ? Crypt::decryptString($kode) : null;
        $query = collect();

        if ($p) {
            // Ambil dan group berdasarkan bulan-tahun
            $query = KuotaJbt::select('nama_badan_usaha', 'tahun', 'npwp_badan_usaha',DB::raw('MIN(id) as id')) 
                ->where('npwp_badan_usaha', $p)
                ->groupBy('tahun', 'nama_badan_usaha', 'npwp_badan_usaha')
                ->orderBy('tahun', 'desc')
                // ->orderBy('bulan', 'desc')
                ->get();
        }

// dd($query);
        $data = [
            'title' => 'Laporan JBT Kuota',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
    //   dd($query);
        return view('evaluator.laporan_bu.bph_inline.kuota_jbt.periode', $data);
    }


    public function show($kode = '')
    {
        $pecah = explode(",", Crypt::decryptString($kode));

        $query = KuotaJbt::where([
                        ['npwp_badan_usaha', $pecah[0]],
                        ['tahun', $pecah[1]],
                        // ['bulan', $pecah[2]],
                    ])->get();

        $data = [
            'title'=>'Laporan JBT Kuota',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.bph_inline.kuota_jbt.pilihbulan', $data);

    }

    public function sinkronisasiData() 
    {
        $year = Carbon::now()->year;

        SyncJbtKuota::dispatch($year, session()->getId());
        
        return back()->with('sweet_success', 'Sinkronisasi data sedang diproses.');
    }

    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');

        $t_awal = (int) date('Y', strtotime($request->input("t_awal")));
        $t_akhir   = (int) date('Y', strtotime($request->input("t_akhir"))); 

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_jbt_kuota')
                ->whereBetween('tahun', [$t_awal, $t_akhir]);
                // ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$t_awal, $t_akhir])
                // ->orderByRaw('tahun::int')
                // ->orderByRaw('bulan::int');
    
        // Jika yang dipilih adalah 'all', maka tidak ada filter berdasarkan perusahaan
        if ($perusahaan !== 'all') {
            $query->where('id_badan_usaha', $perusahaan);
        }
    
        $result = $query->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan JBT Kuota',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.bph_inline.kuota_jbt.cetak', $data);
    
            // Menambahkan script JavaScript untuk reload halaman
            $view->with('reload', true);
    
            return response($view);
        }
    }

    public function lihatSemuaData()
    {
        $tgl = Carbon::now();
        $bulan = $tgl->month; // hasilnya 1–12
        $tahun = $tgl->year;
        
        $query = KuotaJbt::where('tahun', $tahun)
                    ->get();
        $perusahaan  = KuotaJbt::select('npwp_badan_usaha', 'nama_badan_usaha')
                    ->groupBy('npwp_badan_usaha', 'nama_badan_usaha')->get();
        $periode = $tgl->translatedFormat('Y'); // contoh: "2025"

        return view('evaluator.laporan_bu.bph_inline.kuota_jbt.lihat-semua-data', [
            'title'     => 'Laporan JBT Kuota',
            'query'     => $query,
            'periode'   => $periode,
            'perusahaan'=> $perusahaan,
        ]);
    }


    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = KuotaJbt::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_jbt_kuota')
                ->whereBetween('tahun', [$t_awal->format('Y'), $t_akhir->format('Y')]);
                // ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$t_awal->format('Ym'), $t_akhir->format('Ym')])
                // ->orderByRaw('tahun::int')
                // ->orderByRaw('bulan::int');
    
        // Jika yang dipilih adalah 'all', maka tidak ada filter berdasarkan perusahaan
        if ($request->input("perusahaan") !== 'all') {
            $query->where('id_badan_usaha', $request->input("perusahaan"));
        }

        $result = $query->get();

        return view('evaluator.laporan_bu.bph_inline.kuota_jbt.lihat-semua-data', [
            'title' => 'Laporan JBT Kuota',
            // 'periode' =>  bulan($t_awal->month) ." ".$t_awal->year ." - ". bulan($t_akhir->month) ." ". $t_akhir->year,
            'periode' =>  $t_awal->year ." - ". $t_akhir->year,
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
