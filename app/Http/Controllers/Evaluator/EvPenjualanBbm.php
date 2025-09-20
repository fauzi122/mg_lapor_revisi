<?php

namespace App\Http\Controllers\Evaluator;

use App\Exports\PenjualanBbmExport;
use App\Http\Controllers\Controller;
use App\Models\PenjualanBbm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvPenjualanBbm extends Controller
{
    public function index()
    {
        $perusahaan = PenjualanBbm::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha','izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        // Dekode JSON pada field izin_usaha
        foreach ($perusahaan as $item) {
            $item->izin_list = json_decode($item->izin_usaha, true);
        }

        $data = [
            'title' => 'Laporan Penjualan BBM',
            'perusahaan' => $perusahaan,
        ];
        // dd($perusahaan);
        return view('evaluator.laporan_bu.bph_inline.penjualan_bbm.index', $data);
    }



    public function periode($kode = '')
    {
        $p = !empty($kode) ? Crypt::decryptString($kode) : null;
        $query = collect();

        if ($p) {
            // Ambil dan group berdasarkan bulan-tahun
            $query = PenjualanBbm::select('nama_badan_usaha','bulan', 'tahun', 'npwp_badan_usaha',DB::raw('MIN(id) as id')) 
                ->where('npwp_badan_usaha', $p)
                ->groupBy('tahun', 'bulan', 'nama_badan_usaha', 'npwp_badan_usaha')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }

        $data = [
            'title' => 'Laporan Penjualan BBM',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
    //   dd($query);
        return view('evaluator.laporan_bu.bph_inline.penjualan_bbm.periode', $data);
    }


    public function show($kode = '', Request $request)
    {
        $pecah = explode(",", Crypt::decryptString($kode));

        $query = PenjualanBbm::where([
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
                $q->Where('produk', 'ILIKE', "%{$search}%")
                    ->orWhere('sumber', 'ILIKE', "%{$search}%")
                    ->orWhere('supplier', 'ILIKE', "%{$search}%")
                    ->orWhere('satuan', 'ILIKE', "%{$search}%");

                if (is_numeric($search)) {
                    $q->orWhere('volume', $search);
                }
            });
        }

        // Fitur Export Excel
        if ($request->filled('export')) {
            $export = new PenjualanBbmExport($query, $request->export);
            return $export->exportMini();
        }

        // Tampilkan Data Dengan 10 Page
        $queryPaginate = $query->paginate(10)->appends($request->all());
                    
        $data = [
            'title'=>'Laporan Penjualan BBM',
            'query'=>$queryPaginate,
            'per'=>$per

        ];
        return view('evaluator.laporan_bu.bph_inline.penjualan_bbm.pilihbulan', $data);

    }

    public function sinkronisasiData() 
    {

        $url = "https://ngembangin.esdm.go.id/inline/hilir/internal/api/dev/pelaporan-migas/bbm/penyediaan";

        $token = Cache::get('access_token');
        $items = collect();
        $tgl = Carbon::now();
        $bulan = $tgl->month; // hasilnya 1–12
        $tahun = $tgl->year;
        $page = 1;
        
        while (true) {
            // Gunakan token untuk akses API
            $response = Http::withToken($token)->post($url, [
                'tahun' => $tahun,
                'page' => $page
            ]);

            if ($response->status() === 401) {
                $token = tokenBphApi();
                $response = Http::withToken($token)->post($url, [
                    'tahun' => $tahun
                ]);
            }

            if ($response->status() === 404) {
                break;
            }

            if ($response->failed()) {
                Log::error('Gagal sinkronisasi data', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with('sweet_error', 'Gagal sinkronisasi data');
            }
            
            // Jika berhasil
            $response =  $response->json();

            foreach ($response['data'] as $value) {

                if ($value['bulan'] == $bulan) {
                    $items->push($value);
                }
            }

            $page++;
        }

        // Update Or Create data di Database
        if (count($items) > 0) {
            foreach ($items as $item) {
                PenjualanBbm::updateOrCreate(
                    [
                        'id_badan_usaha'   => $item['id_badan_usaha'],
                        'tahun'            => $item['tahun'],
                        'bulan'            => $item['bulan'],
                        'produk'           => $item['produk'],
                        'sumber'           => $item['sumber'],
                        'supplier'         => $item['supplier'],
                    ],
                    [
                        "id_badan_usaha" => $item['id_badan_usaha'],
                        "nama_badan_usaha" => $item['nama_badan_usaha'],
                        "npwp_badan_usaha" => $item['npwp_badan_usaha'],
                        "izin_usaha" => json_encode($item['izin_usaha']),
                        'tahun' => $item['tahun'],
                        'bulan' => $item['bulan'],
                        'produk' => $item['produk'],
                        'sumber' => $item['sumber'],
                        'supplier' => $item['supplier'],
                        'volume' => $item['volume'],
                        'satuan' => $item['satuan'],
                    ]
                );
    
            }
        }

        return back()->with('sweet_success', 'Sinkronisasi Data Berhasil');
    }

    public function cetakperiode(Request $request)
    {
        $perusahaan = $request->input('perusahaan');

        $t_awal = (int) date('Ym', strtotime($request->input("t_awal")));
        $t_akhir   = (int) date('Ym', strtotime($request->input("t_akhir"))); 

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_penjualan_bbm')
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

        $export = new PenjualanBbmExport($query, 'xlsx');
        return $export->export();
    }

    public function lihatSemuaData(Request $request)
    {
        $tgl = Carbon::now();
        $bulan = $tgl->month; // hasilnya 1–12
        $tahun = $tgl->year;
        
        $query = PenjualanBbm::where('bulan', $bulan)
                    ->where('tahun', $tahun);

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('npwp_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('produk', 'ILIKE', "%{$search}%")
                    ->orWhere('sumber', 'ILIKE', "%{$search}%")
                    ->orWhere('supplier', 'ILIKE', "%{$search}%")
                    ->orWhere('satuan', 'ILIKE', "%{$search}%");

                // Volume Menggunakan Numeric tidak bisa string
                if (is_numeric($search)) {
                    $q->orWhere('volume', $search);
                }
            });
        }

        // Fitur Export Data
        if ($request->filled('export')) {
            $export = new PenjualanBbmExport($query, $request->export);
            return $export->export();
        }

        $perusahaan  = PenjualanBbm::select('npwp_badan_usaha', 'nama_badan_usaha')
                    ->groupBy('npwp_badan_usaha', 'nama_badan_usaha')->get();
        $periode = $tgl->translatedFormat('F Y'); // contoh: "Mei 2025"

        // Tampilkan 10 data di table
        $query = $query->paginate(10)->appends($request->all());

        return view('evaluator.laporan_bu.bph_inline.penjualan_bbm.lihat-semua-data', [
            'title'     => 'Laporan Penjualan BBM',
            'query'     => $query,
            'periode'   => $periode,
            'perusahaan'=> $perusahaan,
        ]);
    }


    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        $perusahaan = PenjualanBbm::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        // Query untuk mendapatkan data penjualan berdasarkan perusahaan dan tanggal
        $query = DB::table('bph_penjualan_bbm')
                ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$t_awal->format('Ym'), $t_akhir->format('Ym')])
                ->orderByRaw('tahun::int')
                ->orderByRaw('bulan::int');
    
        // Jika yang dipilih adalah 'all', maka tidak ada filter berdasarkan perusahaan
        if ($request->input("perusahaan") !== 'all') {
            $query->where('id_badan_usaha', $request->input("perusahaan"));
        }

        // Fitur search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('npwp_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('produk', 'ILIKE', "%{$search}%")
                    ->orWhere('sumber', 'ILIKE', "%{$search}%")
                    ->orWhere('supplier', 'ILIKE', "%{$search}%");

                // Volume Menggunakan Numeric tidak bisa string
                if (is_numeric($search)) {
                    $q->orWhere('volume', $search);
                }
            });
        }

        // Fitur Export Data
        if ($request->filled('export')) {
            $export = new PenjualanBbmExport($query, $request->export);
            return $export->export();
        }

        // Pagination dengan appends supaya filter & search tetap terbawa
        $result = $query->paginate(10)->appends($request->all());

        return view('evaluator.laporan_bu.bph_inline.penjualan_bbm.lihat-semua-data', [
            'title' => 'Laporan Penjualan BBM',
            'periode' =>  bulan($t_awal->month) ." ".$t_awal->year ." - ". bulan($t_akhir->month) ." ". $t_akhir->year,
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
