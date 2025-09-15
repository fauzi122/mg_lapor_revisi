<?php

namespace App\Http\Controllers\Evaluator;

use App\Exports\PenjualanJbtExport;
use App\Http\Controllers\Controller;
use App\Models\PenjualanJbt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvPenjualanJbt extends Controller
{
    public function index()
    {
        $perusahaan = PenjualanJbt::select('id_badan_usaha', 'izin_usaha','nama_badan_usaha','npwp_badan_usaha') 
            ->groupBy('id_badan_usaha','izin_usaha','nama_badan_usaha','npwp_badan_usaha')
            ->get();

        // Dekode JSON pada field izin_usaha
        foreach ($perusahaan as $item) {
            $item->izin_list = json_decode($item->izin_usaha, true);
        }

        $data = [
            'title' => 'Laporan Penjualan JBT',
            'perusahaan' => $perusahaan,
        ];
        // dd($perusahaan);
        return view('evaluator.laporan_bu.bph_inline.penjualan_jbt.index', $data);
    }



    public function periode($kode = '')
    {
        $p = !empty($kode) ? Crypt::decryptString($kode) : null;
        $query = collect();

        if ($p) {
            // Ambil dan group berdasarkan bulan-tahun
            $query = PenjualanJbt::select('nama_badan_usaha','bulan', 'tahun', 'npwp_badan_usaha',DB::raw('MIN(id) as id')) 
                ->where('npwp_badan_usaha', $p)
                ->groupBy('tahun', 'bulan', 'nama_badan_usaha', 'npwp_badan_usaha')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }

        $data = [
            'title' => 'Laporan Penjualan JBT',
            'p' => $p,
            'query' => $query,
            'per' => $query->first()
        ];
    //   dd($query);
        return view('evaluator.laporan_bu.bph_inline.penjualan_jbt.periode', $data);
    }


    public function show($kode = '', Request $request)
    {
        $pecah = explode(",", Crypt::decryptString($kode));

        // Query dasar untuk menampilkan semua data sesuai npwp, tahun, dan bulan
        $query = PenjualanJbt::where([
                        ['npwp_badan_usaha', $pecah[0]],
                        ['tahun', $pecah[1]],
                        ['bulan', $pecah[2]],
                    ]);

        // Mengambil data perusahaan untuk ditampilkan di header
        $per = PenjualanJbt::where('npwp_badan_usaha', $pecah[0])
            ->where('tahun', $pecah[1])
            ->where('bulan', $pecah[2])
            ->first();

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('npwp_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('produk', 'ILIKE', "%{$search}%")
                    ->orWhere('provinsi', 'ILIKE', "%{$search}%")
                    ->orWhere('kabupaten_kota', 'ILIKE', "%{$search}%")
                    ->orWhere('sektor', 'ILIKE', "%{$search}%")
                    ->orWhere('bulan', 'ILIKE', "%{$search}%")
                    ->orWhere('tahun', 'ILIKE', "%{$search}%");

                    // Volume Menggunakan Numeric tidak bisa string
                    if (is_numeric($search)) {
                        $q->orWhere('volume', $search);
                    }
            });
        }


        // Pagination 10 per halaman, dengan membawa semua parameter request agar tetap tersimpan
        $query = $query->paginate(10)->appends($request->all());

        // Data dikirim ke view
        $data = [
            'title'=>'Laporan Penjualan JBT',
            'query'=>$query,
            'per'=>$per

        ];
        return view('evaluator.laporan_bu.bph_inline.penjualan_jbt.pilihbulan', $data);

    }

    public function sinkronisasiData() 
    {

        $url = "https://ngembangin.esdm.go.id/inline/hilir/internal/api/dev/pelaporan-migas/bbm/penjualan-jbt";

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
                PenjualanJbt::updateOrCreate(
                    [
                        'id_badan_usaha'   => $item['id_badan_usaha'],
                        'tahun'            => $item['tahun'],
                        'bulan'            => $item['bulan'],
                        'produk'           => $item['produk'],
                        'provinsi'         => $item['provinsi'],
                        'kabupaten_kota'   => $item['kabupaten_kota'],
                        'sektor'           => $item['sektor'],
                    ],
                    [
                        'id_badan_usaha'    => $item['id_badan_usaha'],
                        'nama_badan_usaha'  => $item['nama_badan_usaha'],
                        'npwp_badan_usaha'  => $item['npwp_badan_usaha'],
                        'izin_usaha'        => json_encode($item['izin_usaha']),
                        'tahun'            => $item['tahun'],
                        'bulan'            => $item['bulan'],
                        'produk'           => $item['produk'],
                        'provinsi'         => $item['provinsi'],
                        'kabupaten_kota'   => $item['kabupaten_kota'],
                        'sektor'           => $item['sektor'],
                        'volume'           => $item['volume'],
                        'satuan'           => $item['satuan'],
                    ]
                );
    
            }
        }

        return back()->with('sweet_success', 'Sinkronisasi Data Berhasil');
    }

    public function cetakperiode(Request $request)
    {
        // Ambil nilai "perusahaan" dari input request (biasanya dari form/filter di frontend)
        $perusahaan = $request->input('perusahaan');

        // Ubah input tanggal awal menjadi format integer "YYYYMM"
        // Contoh: "2025-01-15" -> 202501
        $t_awal = (int) date('Ym', strtotime($request->input("t_awal")));
        $t_akhir   = (int) date('Ym', strtotime($request->input("t_akhir")));

        // Buat instance dari class PenjualanJbtExport
        // lalu passing parameter: tanggal awal, tanggal akhir, dan perusahaan
        $export = new PenjualanJbtExport($t_awal, $t_akhir, $perusahaan);

        // Jalankan fungsi export() dari class PenjualanJbtExport
        // dan return hasilnya (biasanya file Excel/CSV yang akan didownload)
        return $export->export();
    }

    public function lihatSemuaData(Request $request)
    {
        $tgl = Carbon::now();
        $bulan = $tgl->month; // hasilnya 1–12
        $tahun = $tgl->year;

        // Base query: bulan berjalan saja
        $query = PenjualanJbt::where('bulan', $bulan)
                    ->where('tahun', $tahun);

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('npwp_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('produk', 'ILIKE', "%{$search}%")
                    ->orWhere('provinsi', 'ILIKE', "%{$search}%")
                    ->orWhere('kabupaten_kota', 'ILIKE', "%{$search}%")
                    ->orWhere('sektor', 'ILIKE', "%{$search}%")
                    ->orWhere('bulan', 'ILIKE', "%{$search}%")
                    ->orWhere('tahun', 'ILIKE', "%{$search}%");

                    // Volume Menggunakan Numeric tidak bisa string
                    if (is_numeric($search)) {
                        $q->orWhere('volume', $search);
                    }
            });
        }

        // Daftar perusahaan untuk dropdown/filter
        $perusahaan  = PenjualanJbt::select('npwp_badan_usaha', 'nama_badan_usaha')
                    ->groupBy('npwp_badan_usaha', 'nama_badan_usaha')->get();

        $periode = $tgl->translatedFormat('F Y'); // contoh: "Mei 2025"

        // Pagination 10 per halaman
        $query = $query->paginate(10)->appends($request->all());

        return view('evaluator.laporan_bu.bph_inline.penjualan_jbt.lihat-semua-data', [
            'title'     => 'Laporan Penjualan JBT',
            'query'     => $query,
            'periode'   => $periode,
            'perusahaan'=> $perusahaan,
        ]);
    }


    public function filterData(Request $request)
    {
        $t_awal = Carbon::parse($request->t_awal);
        $t_akhir = Carbon::parse($request->t_akhir);

        // Daftar perusahaan
        $perusahaan = PenjualanJbt::select('id_badan_usaha', 'izin_usaha', 'nama_badan_usaha', 'npwp_badan_usaha')
            ->groupBy('id_badan_usaha', 'izin_usaha', 'nama_badan_usaha', 'npwp_badan_usaha')
            ->get();

        // Base query
        $query = DB::table('bph_penjualan_jbt')
            ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [
                $t_awal->format('Ym'),
                $t_akhir->format('Ym')
            ])
            ->orderByRaw('tahun::int')
            ->orderByRaw('bulan::int');

        // Filter perusahaan
        if ($request->filled("perusahaan") && $request->perusahaan !== 'all') {
            $query->where('id_badan_usaha', $request->perusahaan);
        }

        // Fitur search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('npwp_badan_usaha', 'ILIKE', "%{$search}%")
                    ->orWhere('produk', 'ILIKE', "%{$search}%")
                    ->orWhere('provinsi', 'ILIKE', "%{$search}%")
                    ->orWhere('kabupaten_kota', 'ILIKE', "%{$search}%")
                    ->orWhere('sektor', 'ILIKE', "%{$search}%");

                    // Volume Menggunakan Numeric tidak bisa string
                    if (is_numeric($search)) {
                        $q->orWhere('volume', $search);
                    }
            });
        }

        // Pagination dengan appends supaya filter & search tetap terbawa
        $result = $query->paginate(10)->appends($request->all());

        return view('evaluator.laporan_bu.bph_inline.penjualan_jbt.lihat-semua-data', [
            'title' => 'Laporan Penjualan JBT',
            'periode' => bulan($t_awal->month) . " " . $t_awal->year . " - " . bulan($t_akhir->month) . " " . $t_akhir->year,
            'query' => $result,
            'perusahaan' => $perusahaan,
        ]);
    }
}
