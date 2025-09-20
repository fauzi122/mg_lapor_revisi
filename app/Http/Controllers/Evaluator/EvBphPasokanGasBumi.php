<?php

namespace App\Http\Controllers\Evaluator;

use App\Exports\PenjualanBphPasokanGasBumiExport;
use App\Http\Controllers\Controller;
use App\Jobs\bph\SyncPasokanGasBumi;
use App\Models\BphPasokanGasBumi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvBphPasokanGasBumi extends Controller
{
    
    public function index()
    {
        $perusahaan = BphPasokanGasBumi::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha','izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        $lastSync = BphPasokanGasBumi::latest()->first();
        // Dekode JSON pada field izin_usaha
        foreach ($perusahaan as $item) {
            $item->izin_list = json_decode($item->izin_usaha, true);
        }

        $data = [
            'title' => 'Laporan Pasokan Gas Bumi',
            'perusahaan' => $perusahaan,
            'lastSync' => $lastSync,
        ];
        // dd($perusahaan);
        return view('evaluator.laporan_bu.bph_inline.pasokan_gas_bumi.index', $data);
    }



    public function periode($kode = '')
    {
        $p = !empty($kode) ? Crypt::decryptString($kode) : null;
        $query = collect();

        if ($p) {
            // Ambil dan group berdasarkan bulan-tahun
            $query = BphPasokanGasBumi::select('nama_badan_usaha','bulan', 'tahun', 'npwp_badan_usaha',DB::raw('MIN(id) as id')) 
                ->where('npwp_badan_usaha', $p)
                ->groupBy('tahun', 'bulan', 'nama_badan_usaha', 'npwp_badan_usaha')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }

        $data = [
            'title' => 'Laporan Pasokan Gas Bumi',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
    //   dd($query);
        return view('evaluator.laporan_bu.bph_inline.pasokan_gas_bumi.periode', $data);
    }


    public function show($kode = '', Request $request)
    {
        $pecah = explode(",", Crypt::decryptString($kode));

        $query = BphPasokanGasBumi::where([
                        ['npwp_badan_usaha', $pecah[0]],
                        ['tahun', $pecah[1]],
                        ['bulan', $pecah[2]],
                    ]);

        // Wajib Taruh di bawah query agar ketika searchnya tidak sesuai dia tidak error
        $per = (clone $query)->first();

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->Where('nama_pemasok', 'ILIKE', "%{$search}%")
                    ->orWhere('harga_pasok', 'ILIKE', "%{$search}%");


                if (is_numeric($search)) {
                    $q->orWhere('volume_mmbtu', $search);
                }
            });
        }

        // Fitur Export Data
        if ($request->filled('export')) {
            $export = new PenjualanBphPasokanGasBumiExport($query, $request->export);
            return $export->exportMini();
        }

        // Tampilkan 10 data di table
        $queryPaginate = $query->paginate(10)->appends($request->all());
                    
        $data = [
            'title'=>'Laporan Pasokan Gas Bumi',
            'query'=>$queryPaginate,
            'per'=>$per
        ];
        return view('evaluator.laporan_bu.bph_inline.pasokan_gas_bumi.pilihbulan', $data);

    }

    public function sinkronisasiData() 
    {
        $year = Carbon::now()->year;

        SyncPasokanGasBumi::dispatch($year, session()->getId());
        
        return back()->with('sweet_success', 'Sinkronisasi data sedang diproses.');
    }

    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');

        $t_awal = (int) date('Ym', strtotime($request->input("t_awal")));
        $t_akhir   = (int) date('Ym', strtotime($request->input("t_akhir"))); 

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_pasokan_gas_bumi')
                ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$t_awal, $t_akhir])
                ->orderByRaw('tahun::int')
                ->orderByRaw('bulan::int');
    
        // Jika yang dipilih adalah 'all', maka tidak ada filter berdasarkan perusahaan
        if ($perusahaan !== 'all') {
            $query->where('id_badan_usaha', $perusahaan);
        }

        // Cek apakah data kosong
        if ($query->count() === 0) {
            return redirect()->back()->with('sweet_error', 'Data yang Anda minta kosong.');
        }

        $export = new PenjualanBphPasokanGasBumiExport($query, 'xlsx');
        return $export->export();
    }

    public function lihatSemuaData(Request $request)
    {
        $tgl = Carbon::now();
        $bulan = $tgl->month; // hasilnya 1–12
        $tahun = $tgl->year;
        
        $query = BphPasokanGasBumi::where('bulan', $bulan)
                    ->where('tahun', $tahun);

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->Where('nama_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('npwp_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('nama_pemasok', 'ILIKE', "%{$search}%")
                    ->orWhere('volume_mmbtu', 'ILIKE', "%{$search}%")
                    ->orWhere('harga_pasok', 'ILIKE', "%{$search}%");


                if (is_numeric($search)) {
                    $q->orWhere('volume_mmbtu', $search);
                }
            });
        }

        // Fitur Export Data
        if ($request->filled('export')) {
            $export = new PenjualanBphPasokanGasBumiExport($query, $request->export);
            return $export->exportMini();
        }

        $perusahaan  = BphPasokanGasBumi::select('npwp_badan_usaha', 'nama_badan_usaha')
                    ->groupBy('npwp_badan_usaha', 'nama_badan_usaha')->get();
        $periode = $tgl->translatedFormat('F Y'); // contoh: "Mei 2025"

        $query = $query->paginate(10)->appends($request->all());

        return view('evaluator.laporan_bu.bph_inline.pasokan_gas_bumi.lihat-semua-data', [
            'title'     => 'Laporan Pasokan Gas Bumi',
            'query'     => $query,
            'periode'   => $periode,
            'perusahaan'=> $perusahaan,
        ]);
    }


    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = BphPasokanGasBumi::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_pasokan_gas_bumi')
                ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$t_awal->format('Ym'), $t_akhir->format('Ym')])
                ->orderByRaw('tahun::int')
                ->orderByRaw('bulan::int');
    
        // Jika yang dipilih adalah 'all', maka tidak ada filter berdasarkan perusahaan
        if ($request->input("perusahaan") !== 'all') {
            $query->where('id_badan_usaha', $request->input("perusahaan"));
        }

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->Where('nama_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('npwp_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('nama_pemasok', 'ILIKE', "%{$search}%")
                    ->orWhere('volume_mmbtu', 'ILIKE', "%{$search}%")
                    ->orWhere('harga_pasok', 'ILIKE', "%{$search}%");


                if (is_numeric($search)) {
                    $q->orWhere('volume_mmbtu', $search);
                }
            });
        }

        // Fitur Export Data
        if ($request->filled('export')) {
            $export = new PenjualanBphPasokanGasBumiExport($query, $request->export);
            return $export->exportMini();
        }

        $result = $query->paginate(10)->appends($request->all());


        return view('evaluator.laporan_bu.bph_inline.pasokan_gas_bumi.lihat-semua-data', [
            'title' => 'Laporan Pasokan Gas Bumi',
            'periode' =>  bulan($t_awal->month) ." ".$t_awal->year ." - ". bulan($t_akhir->month) ." ". $t_akhir->year,
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
