<?php

namespace App\Jobs\bph;

use App\Library\APIBph;
use App\Models\BphPasokanGasBumi;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncPasokanGasBumi implements ShouldQueue
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
        $items = collect();
        
        DB::beginTransaction();
        
        try {

            BphPasokanGasBumi::where('tahun', $this->tahun)->delete();

            while (true) {

                $response = $api->post('/gas/pasokan-gas', $this->tahun, $page);

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
                    // $this->simpanData($value);
                    $items->push([
                        'id_badan_usaha'      => (int) $value['id_badan_usaha'] ?? null,
                        'nama_badan_usaha'    => $value['nama_badan_usaha'] ?? null,
                        'npwp_badan_usaha'    => $value['npwp_badan_usaha'] ?? null,
                        'izin_usaha'          => json_encode($value['izin_usaha'] ?? []),
                        'tahun'               => $value['tahun'] ?? null,
                        'bulan'               => $value['bulan'] ?? null,
                        'nama_pemasok'        => $value['nama_pemasok'] ?? null,
                        'harga_pasok'         => isset($value['harga_pasok']) ? (float) $value['harga_pasok'] : null,
                        'volume_mmbtu'        => isset($value['volume_mmbtu']) ? (float) $value['volume_mmbtu'] : null,
                    ]);
                }
                $page++;
            } 

            Log::info("Total data terkumpul: " . $items->count());

            $items->chunk(250)->each(function ($chunk, $i) {
                DB::table('bph_pasokan_gas_bumi')->insert($chunk->toArray());
            });

            DB::commit();
            Log::info("Simpan data ke database");
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("GAGAL : " . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            throw $th;
        }   

        Log::info("TOTAL PAGE = " . $page);
    }

    // protected function simpanData($item): void
    // {
    //     try {
    //         BphPasokanGasBumi::updateOrCreate(
    //             [
    //                 'id_badan_usaha'   => $item['id_badan_usaha'],
    //                 'npwp_badan_usaha' => $item['npwp_badan_usaha'],
    //                 'tahun'            => $item['tahun'],
    //                 'bulan'            => $item['bulan'],
    //             ],
    //             [
    //                 'nama_badan_usaha' => $item['nama_badan_usaha'],
    //                 'izin_usaha' => json_encode($item['izin_usaha']),
    //                 'volume_mmbtu' => $item['volume_mmbtu'] ?? null,
    //                 'nama_pemasok' => $item['nama_pemasok'],
    //                 'harga_pemasok' => $item['harga_pasok'],
    //             ]
    //         );
    //     } catch (\Throwable $e) {
    //         Log::error("Gagal menyimpan data", [
    //             'data'  => $item,
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }
}
