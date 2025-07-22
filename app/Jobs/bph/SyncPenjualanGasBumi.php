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
use Illuminate\Support\Facades\DB;
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
        $items = collect();
        
        DB::beginTransaction();

        
        try {

            BphPenjualanGasBumi::where('tahun', $this->tahun)->delete();
            
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
                    // $this->simpanData($value);
                   $items->push([
                        'id_badan_usaha'      => (int) $value['id_badan_usaha'] ?? null,
                        'nama_badan_usaha'    => $value['nama_badan_usaha'] ?? null,
                        'npwp_badan_usaha'    => $value['npwp_badan_usaha'] ?? null,
                        'izin_usaha'          => json_encode($value['izin_usaha'] ?? []),
                        'tahun'               => $value['tahun'] ?? null,
                        'bulan'               => $value['bulan'] ?? null,
                        'provinsi'            => $value['provinsi'] ?? null,
                        'kabkot'              => $value['kabkot'] ?? null,
                        'sektor'              => $value['sektor'] ?? null,
                        'konsumen'            => $value['konsumen'] ?? null,
                        'jml_hari_penyaluran' => isset($value['jml_hari_penyaluran']) ? (float) $value['jml_hari_penyaluran'] : null,
                        'ghv'                 => isset($value['ghv']) ? (float) $value['ghv'] : null,
                        'keterangan'          => $value['keterangan'] ?? null,
                        'volume_mmbtu'        => isset($value['volume_mmbtu']) ? (float) $value['volume_mmbtu'] : null,
                        'satuan_mmbtu'        => $value['satuan_mmbtu'] ?? null,
                        'harga_mmbtu'         => isset($value['harga_mmbtu']) ? (float) $value['harga_mmbtu'] : null,
                    ]);

                }

                $page++;
            }
            
            Log::info("Total data terkumpul: " . $items->count());

            $items->chunk(250)->each(function ($chunk, $i) {
                DB::table('bph_penjualan_gas_bumi')->insert($chunk->toArray());
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
    //     // Log::info($item);
    //     try {
    //         BphPenjualanGasBumi::updateOrCreate(
    //             [
    //                 'id_badan_usaha'   => $item['id_badan_usaha'],
    //                 'npwp_badan_usaha' => $item['npwp_badan_usaha'],
    //                 'tahun'            => $item['tahun'],
    //                 'bulan'            => $item['bulan'],
    //                 'provinsi'         => $item['provinsi'],
    //                 'kabkot'   => $item['kabkot'],
    //                 'sektor'           => $item['sektor'],
    //             ],
    //             [
    //                 'nama_badan_usaha' => $item['nama_badan_usaha'],
    //                 'izin_usaha'       => json_encode($item['izin_usaha']),
    //                 'konsumen'           => $item['konsumen'],
    //                 'jml_hari_penyaluran'           => $item['jml_hari_penyaluran'],
    //                 'ghv'           => $item['ghv'],
    //                 'keterangan'           => $item['keterangan'],
    //                 'volume_mmbtu'           => $item['volume_mmbtu'] ?? null,
    //                 'satuan_mmbtu'           => $item['satuan_mmbtu'] ?? null,
    //                 'harga_mmbtu'           => $item['harga_mmbtu'] ?? null,
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
