<?php

namespace App\Jobs\bph;

use App\Events\BphSyncNotification;
use App\Library\APIBph;
use App\Models\PenjualanJbt;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncPenjualanJbt implements ShouldQueue
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
        $start = microtime(true);

        Log::info('MULAI '. $this->tahun);
        $api = new APIBph();
        $page = 1;
        $items = collect();
        
        DB::beginTransaction();

        try {

            PenjualanJbt::where('tahun', $this->tahun)->delete();
            
            while (true) {

                $response = $api->post('/bbm/penjualan-jbt', $this->tahun, $page);

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
                        'id_badan_usaha'      => isset($value['id_badan_usaha']) ? (int) $value['id_badan_usaha'] : null,
                        'nama_badan_usaha'    => $value['nama_badan_usaha'] ?? null,
                        'npwp_badan_usaha'    => $value['npwp_badan_usaha'] ?? null,
                        'izin_usaha'          => json_encode($value['izin_usaha'] ?? []),
                        'tahun'               => isset($value['tahun']) ? (string) $value['tahun'] : null,
                        'bulan'               => isset($value['bulan']) ? (string) $value['bulan'] : null,
                        'produk'              => $value['produk'] ?? null, // jika memang nanti ingin dipakai
                        'provinsi'            => $value['provinsi'] ?? null,
                        'kabupaten_kota'      => $value['kabupaten_kota'] ?? null, // disesuaikan dengan kolom DB
                        'sektor'              => $value['sektor'] ?? null,
                        'volume'              => isset($value['volume']) ? round((float) $value['volume'], 2) : null,
                        'satuan'              => $value['satuan'] ?? null,
                    ]);

                }
                $page++;
            }    

            Log::info("Total data terkumpul: " . $items->count());
            
            $items->chunk(500)->each(function ($chunk, $i) {
                DB::table('bph_penjualan_jbt')->insert($chunk->toArray());
            });

            DB::commit();

            if ($this->sessionId) {
                broadcast(new BphSyncNotification("Sinkronisasi Penjualan JBT selesai.", $this->sessionId, "penjualan-jbt"));
            }
        } catch (\Throwable $e) {
            Log::error("Gagal menghapus data lama", [
                'tahun' => $this->tahun,
                'error' => $e->getMessage()
            ]);
            DB::rollBack();

            if ($this->sessionId) {
                broadcast(new BphSyncNotification("Sinkronisasi Penjualan JBT gagal", $this->sessionId, "penjualan-jbt"));
            }

            return;
        }           

        Log::info("TOTAL PAGE = " . $page - 1);

        $end = microtime(true); // waktu selesai
        $duration = $end - $start; // durasi dalam detik

        Log::info("Durasi eksekusi: " . round($duration, 2) . " detik (" . round($duration / 60, 2) . " menit)");
    }

    // protected function simpanData($item): void
    // {
    //     try {
    //         PenjualanJbt::updateOrCreate(
    //             [
    //                 'id_badan_usaha'   => $item['id_badan_usaha'],
    //                 'npwp_badan_usaha' => $item['npwp_badan_usaha'],
    //                 'tahun'            => $item['tahun'],
    //                 'bulan'            => $item['bulan'],
    //                 'produk'           => $item['produk'],
    //                 'provinsi'         => $item['provinsi'],
    //                 'kabupaten_kota'   => $item['kabupaten_kota'],
    //                 'sektor'           => $item['sektor'],
    //             ],
    //             [
    //                 'nama_badan_usaha' => $item['nama_badan_usaha'],
    //                 'izin_usaha'       => json_encode($item['izin_usaha']),
    //                 'volume'           => $item['volume'],
    //                 'satuan'           => $item['satuan'],
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
