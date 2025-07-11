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

class SyncPenjualanJbt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tgl, $items;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->tgl = Carbon::now();
        $this->items = collect();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('MULAI');
        $api = new APIBph();
        $page = 1;
        
        while (true) {

            $response = $api->post('/bbm/penjualan-jbt', 2023, $page);

            if ($response->status() === 404) {
                Log::info("Tidak ada data lagi pada halaman " . $page);
                break;
            }

            if ($response->failed()) {
                Log::warning('Gagal sinkronisasi data page ', [
                    'status' => $response->status(),
                    'page' => $page,
                ]);
                
                $page++;
                usleep(50000); 
                continue;
            }
            
            // Jika berhasil
            $response =  $response->json();

            foreach ($response['data'] as $value) {

                // if ((int) $value['bulan'] === (int) $this->tgl->month) {
                    $this->items->push($value);
                // }
            }

            usleep(50000);
            $page++;
        }    

        Log::info("TOTAL ITEMS = " . count($this->items));
        Log::info("TOTAL PAGE = " . $page);

        // Update Or Create data di Database
        $this->simpanData();
    }

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
                Log::error("Gagal menyimpan data", [
                    'data'  => $item,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
