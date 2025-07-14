<?php

namespace App\Jobs\bph;

use App\Library\APIBph;
use App\Models\PenjualanJbt;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncJbtJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tgl, $items;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->tgl = Carbon::now();
        $this->items = collect(); // Menggunakan koleksi untuk menampung data
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('MULAI');

        $api = new APIBph();
        $page = 1;

        // Lakukan request halaman berturut-turut hingga tidak ada data
        while (true) {
            $response = $api->post('/bbm/penjualan-jbt', 2023, $page);

            if ($response->status() === 404) {
                Log::info("Tidak ada data lagi pada halaman " . $page);
                break;  // Jika tidak ada data lagi, keluar dari loop
            }

            if ($response->failed()) {
                Log::warning('Gagal sinkronisasi data page ', [
                    'status' => $response->status(),
                    'page' => $page,
                ]);

                $page++;
                usleep(50000); // Tunggu sebelum mencoba lagi
                continue;
            }

            // Jika berhasil mendapatkan data
            $responseData = $response->json();

            // Proses setiap data dalam halaman
            foreach ($responseData['data'] as $value) {
                // Menambahkan data ke koleksi
                if ((int) $value['bulan'] === (int) $this->tgl->month) {
                    $this->items->push($value);
                }
            }

            Log::info("Berhasil ambil data dari halaman $page");

            // Tunggu sebentar sebelum melanjutkan ke halaman berikutnya
            usleep(50000);
            $page++;
        }

        Log::info("TOTAL ITEMS = " . count($this->items));
        Log::info("TOTAL PAGE = " . $page);

        // Update or create data di database
        $this->simpanData();
    }

    /**
     * Simpan data yang telah dikumpulkan.
     */
    protected function simpanData()
    {
        foreach ($this->items as $item) {
            try {
                PenjualanJbt::updateOrCreate(
                    [
                        'id_badan_usaha'   => $item['id_badan_usaha'],
                        'npwp_badan_usaha' => $item['npwp_badan_usaha'],
                        'tahun'            => $item['tahun'],
                        'bulan'            => $item['bulan'],
                        'produk'           => $item['produk'],
                        'provinsi'         => $item['provinsi'],
                        'kabupaten_kota'   => $item['kabupaten_kota'],
                        'sektor'           => $item['sektor'],
                    ],
                    [
                        'nama_badan_usaha' => $item['nama_badan_usaha'],
                        'izin_usaha'       => json_encode($item['izin_usaha']),
                        'volume'           => $item['volume'],
                        'satuan'           => $item['satuan'],
                    ]
                );
            } catch (\Throwable $e) {
                Log::error("Gagal memproses data", [
                    'data'  => $item,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
