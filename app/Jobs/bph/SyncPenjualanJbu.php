<?php

namespace App\Jobs\bph;

use App\Library\APIBph;
use App\Models\PenjualanJbu;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncPenjualanJbu implements ShouldQueue
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

            PenjualanJbu::where('tahun', $this->tahun)->delete();
            
            while (true) {

                $response = $api->post('/bbm/penjualan-jbu', $this->tahun, $page);

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

            $items->chunk(250)->each(function ($chunk, $i) {
                DB::table('bph_penjualan_jbu')->insert($chunk->toArray());
            });

            DB::commit();
        } catch (\Throwable $e) {
            Log::error("Gagal menghapus data lama", [
                'tahun' => $this->tahun,
                'error' => $e->getMessage()
            ]);
            DB::rollBack();
            return;
        }        

        Log::info("TOTAL PAGE = " . $page);
    }

    // protected function simpanData($item): void
    // {
    //     try {
    //         PenjualanJbu::updateOrCreate(
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
