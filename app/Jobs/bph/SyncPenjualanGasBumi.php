<?php

namespace App\Jobs\bph;

use App\Library\APIBph;
use App\Models\BphPenjualanGasBumi;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncPenjualanGasBumi implements ShouldQueue
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

            $response = $api->post('/gas/penjualan-gas', $this->tahun, $page);

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
        // Log::info($item);
        try {
            BphPenjualanGasBumi::updateOrCreate(
                [
                    'id_badan_usaha'   => $item['id_badan_usaha'],
                    'npwp_badan_usaha' => $item['npwp_badan_usaha'],
                    'tahun'            => $item['tahun'],
                    'bulan'            => $item['bulan'],
                    'provinsi'         => $item['provinsi'],
                    'kabkot'   => $item['kabkot'],
                    'sektor'           => $item['sektor'],
                ],
                [
                    'nama_badan_usaha' => $item['nama_badan_usaha'],
                    'izin_usaha'       => json_encode($item['izin_usaha']),
                    'konsumen'           => $item['konsumen'],
                    'jml_hari_penyaluran'           => $item['jml_hari_penyaluran'],
                    'ghv'           => $item['ghv'],
                    'keterangan'           => $item['keterangan'],
                    'volume_mmbtu'           => $item['volume_mmbtu'] ?? null,
                    'satuan_mmbtu'           => $item['satuan_mmbtu'] ?? null,
                    'harga_mmbtu'           => $item['harga_mmbtu'] ?? null,
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
