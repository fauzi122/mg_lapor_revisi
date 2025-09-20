<?php

namespace App\Jobs\bph;

use App\Events\BphSyncNotification;
use App\Library\APIBph;
use App\Models\BphPengangkutanGas;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncPengangkutanGasBumi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tahun, $sessionId;
    /**
     * Create a new job instance.
     */
    public function __construct($tahun, $sessionId)
    {
        $this->tahun = $tahun;
        $this->sessionId = $sessionId;
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

            BphPengangkutanGas::where('tahun', $this->tahun)->delete();

            while (true) {

                $response = $api->post('/gas/pengangkutan-gas', $this->tahun, $page);

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
                        'ruas_angkut'         => $value['ruas_angkut'] ?? null,
                        'diameter'            => $value['diameter'] ?? null,
                        'shipper'             => $value['shipper'] ?? null,
                        'tarif_mscf'          => isset($value['tarif_mscf']) ? (float) $value['tarif_mscf'] : null,
                        'satuan_mscf'         => $value['satuan_mscf'] ?? null,
                        'volume_mscf'         => isset($value['volume_mscf']) ? (float) $value['volume_mscf'] : null,
                    ]);
                }
                $page++;
            } 

            Log::info("Total data terkumpul: " . $items->count());

            $items->chunk(250)->each(function ($chunk, $i) {
                DB::table('bph_pengangkutan_gas')->insert($chunk->toArray());
            });

            DB::commit();

            if ($this->sessionId) {
                broadcast(new BphSyncNotification("Sinkronisasi Pengangkutan gas bumi selesai.", $this->sessionId, "pengangkutan-gas-bumi"));
            }
        } catch (\Throwable $e) {
            Log::error("Gagal menghapus data lama", [
                'tahun' => $this->tahun,
                'error' => $e->getMessage()
            ]);
            DB::rollBack();

            if ($this->sessionId) {
                broadcast(new BphSyncNotification("Sinkronisasi Pengangkutan gas bumi gagal", $this->sessionId, "pengangkutan-gas-bumi"));
            }

            return;
        }      

        Log::info("TOTAL PAGE = " . $page);
    }

    // protected function simpanData($item): void
    // {
    //     try {
    //         BphPengangkutanGas::updateOrCreate(
    //             [
    //                 'id_badan_usaha'   => $item['id_badan_usaha'],
    //                 'npwp_badan_usaha' => $item['npwp_badan_usaha'],
    //                 'tahun'            => $item['tahun'],
    //                 'bulan'            => $item['bulan'],
    //             ],
    //             [
    //                 'nama_badan_usaha' => $item['nama_badan_usaha'],
    //                 'izin_usaha' => json_encode($item['izin_usaha']),
    //                 'ruas_angkut' => $item['ruas_angkut'],
    //                 'diameter' => $item['diameter'],
    //                 'shipper' => $item['shipper'],
    //                 'volume_mscf' => $item['volume_mscf'] ?? null,
    //                 'satuan_mscf' => $item['satuan_mscf'] ?? null,
    //                 'tarif_mscf' => $item['tarif_mscf'] ?? null,
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
