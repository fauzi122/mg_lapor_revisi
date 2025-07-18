<?php

namespace App\Jobs\bph;

use App\Library\APIBph;
use App\Models\PenjualanBbm;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncPasokanBbm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tahun;
    /**
     * Create a new job instance.
     */
    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('MULAI '. $this->tahun);
        $api = new APIBph();
        $page = 1;
        
        while (true) {

            $response = $api->post('/bbm/penyediaan', $this->tahun, $page);

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
                continue;
            }
            
            // Jika berhasil
            $response =  $response->json();

            foreach ($response['data'] as $value) {
                $this->simpanData($value);
            }
            $page++;
        }    

        Log::info("TOTAL PAGE = " . $page);
    }

    protected function simpanData($item): void
    {
        try {
            PenjualanBbm::updateOrCreate(
                [
                    'id_badan_usaha'   => $item['id_badan_usaha'],
                    'npwp_badan_usaha' => $item['npwp_badan_usaha'],
                    'tahun'            => $item['tahun'],
                    'bulan'            => $item['bulan'],
                    'produk'           => $item['produk'],
                    'sumber'           => $item['sumber'],
                    'supplier'         => $item['supplier'],
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
