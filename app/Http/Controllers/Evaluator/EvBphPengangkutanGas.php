<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use App\Jobs\bph\SyncPengangkutanGasBumi;
use App\Models\BphPengangkutanGas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvBphPengangkutanGas extends Controller
{
    public function index()
    {
        $perusahaan = BphPengangkutanGas::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha','izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        $lastSync = BphPengangkutanGas::latest()->first();
        // Dekode JSON pada field izin_usaha
        foreach ($perusahaan as $item) {
            $item->izin_list = json_decode($item->izin_usaha, true);
        }

        $data = [
            'title' => 'Laporan Pengangkutan Gas',
            'perusahaan' => $perusahaan,
            'lastSync' => $lastSync,
        ];
        // dd($perusahaan);
        return view('evaluator.laporan_bu.bph_inline.pengangkutan_gas.index', $data);
    }



    public function periode($kode = '')
    {
        $p = !empty($kode) ? Crypt::decryptString($kode) : null;
        $query = collect();

        if ($p) {
            // Ambil dan group berdasarkan bulan-tahun
            $query = BphPengangkutanGas::select('nama_badan_usaha','bulan', 'tahun', 'npwp_badan_usaha',DB::raw('MIN(id) as id')) 
                ->where('npwp_badan_usaha', $p)
                ->groupBy('tahun', 'bulan', 'nama_badan_usaha', 'npwp_badan_usaha')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }

        $data = [
            'title' => 'Laporan Pengangkutan Gas',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
    //   dd($query);
        return view('evaluator.laporan_bu.bph_inline.pengangkutan_gas.periode', $data);
    }


    public function show($kode = '')
    {
        $pecah = explode(",", Crypt::decryptString($kode));

        $query = BphPengangkutanGas::where([
                        ['npwp_badan_usaha', $pecah[0]],
                        ['tahun', $pecah[1]],
                        ['bulan', $pecah[2]],
                    ])->get();
                    
        $data = [
            'title'=>'Laporan Pengangkutan Gas',
            'query'=>$query,
            'per'=>$query->first()

        ];
        return view('evaluator.laporan_bu.bph_inline.pengangkutan_gas.pilihbulan', $data);

    }

    public function sinkronisasiData() 
    {
        $year = Carbon::now()->year;

        SyncPengangkutanGasBumi::dispatch($year, session()->getId());
        
        return back()->with('sweet_success', 'Sinkronisasi data sedang diproses.');
    }

    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');

        $t_awal = (int) date('Ym', strtotime($request->input("t_awal")));
        $t_akhir   = (int) date('Ym', strtotime($request->input("t_akhir"))); 

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_pengangkutan_gas')
                ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$t_awal, $t_akhir])
                ->orderByRaw('tahun::int')
                ->orderByRaw('bulan::int');
    
        // Jika yang dipilih adalah 'all', maka tidak ada filter berdasarkan perusahaan
        if ($perusahaan !== 'all') {
            $query->where('id_badan_usaha', $perusahaan);
        }
    
        $result = $query->get();

        if ($result->isEmpty()) {
            return redirect()->back()->with('sweet_error', 'Data yang anda minta kosong.');
        } else {
            $data = [
                'title' => 'Laporan Pengangkutan Gas',
                'result' => $result
            ];
    
            $view = view('evaluator.laporan_bu.bph_inline.pengangkutan_gas.cetak', $data);
    
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
        
        $query = BphPengangkutanGas::where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->get();
        $perusahaan  = BphPengangkutanGas::select('npwp_badan_usaha', 'nama_badan_usaha')
                    ->groupBy('npwp_badan_usaha', 'nama_badan_usaha')->get();
        $periode = $tgl->translatedFormat('F Y'); // contoh: "Mei 2025"

        return view('evaluator.laporan_bu.bph_inline.pengangkutan_gas.lihat-semua-data', [
            'title'     => 'Laporan Pengangkutan Gas',
            'query'     => $query,
            'periode'   => $periode,
            'perusahaan'=> $perusahaan,
        ]);
    }


    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = BphPengangkutanGas::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_pengangkutan_gas')
                ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$t_awal->format('Ym'), $t_akhir->format('Ym')])
                ->orderByRaw('tahun::int')
                ->orderByRaw('bulan::int');
    
        // Jika yang dipilih adalah 'all', maka tidak ada filter berdasarkan perusahaan
        if ($request->input("perusahaan") !== 'all') {
            $query->where('id_badan_usaha', $request->input("perusahaan"));
        }

        $result = $query->get();

        return view('evaluator.laporan_bu.bph_inline.pengangkutan_gas.lihat-semua-data', [
            'title' => 'Laporan Pengangkutan Gas',
            'periode' =>  bulan($t_awal->month) ." ".$t_awal->year ." - ". bulan($t_akhir->month) ." ". $t_akhir->year,
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
