<?php

namespace App\Jobs\bph;

use App\Library\APIBph;
use App\Models\KuotaJbkp;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncJbkpKuota implements ShouldQueue
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

            KuotaJbkp::where('tahun', $this->tahun)->delete();
            
            while (true) {

                $response = $api->post('/bbm/kuota-jbkp', $this->tahun, $page);

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
                        'produk'              => $value['produk'] ?? null,
                        'provinsi'            => $value['provinsi'] ?? null,
                        'kabupaten_kota'      => $value['kabupaten_kota'] ?? null,
                        'volume_kl'           => isset($value['volume_kl']) ? (float) $value['volume_kl'] : null,
                    ]);

                }

                $page++;
            }
            
            Log::info("Total data terkumpul: " . $items->count());

            $items->chunk(500)->each(function ($chunk, $i) {
                DB::table('bph_jbt_kuota')->insert($chunk->toArray());
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
    //         KuotaJbkp::updateOrCreate(
    //             [
    //                 'id_badan_usaha'   => $item['id_badan_usaha'],
    //                 'npwp_badan_usaha' => $item['npwp_badan_usaha'],
    //                 'tahun'            => $item['tahun'],
    //                 'produk'           => $item['produk'],
    //                 'provinsi'         => $item['provinsi'],
    //                 'kabupaten_kota'   => $item['kabupaten_kota'],
    //             ],
    //             [
    //                 'nama_badan_usaha' => $item['nama_badan_usaha'],
    //                 'izin_usaha'       => json_encode($item['izin_usaha']),
    //                 'volume_kl'        => $item['volume_kl'],
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
