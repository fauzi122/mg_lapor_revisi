<?php

namespace App\Jobs;

use App\Library\APIBph;
use App\Models\PenjualanJbt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SyncJbtJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600;
    private $startYear;

    /**
     * Create a new job instance.
     *
     * @param int $startYear
     */
    public function __construct($startYear = 2020)
    {
        $this->startYear = $startYear;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Dapatkan tahun saat ini
        $currentYear = Carbon::now()->year;

        // Loop dari tahun yang diberikan (misalnya 2020) hingga tahun saat ini
        for ($year = $this->startYear; $year <= $currentYear; $year++) {
            try {
                $apiBph = new APIBph();
                $page = 1;
                $lanjut = true;

                // Mendapatkan informasi total halaman dan total record dari API
                do {
                    // Membuat URL berdasarkan tahun dan halaman
                    $response = $apiBph->post('/bbm/penjualan-jbt', $year, $page);
                    $data = $response->json()['data'];

                    // Jika data kosong, berhenti dan lanjutkan ke halaman berikutnya
                    if (empty($data)) {
                        Log::info("Tidak ada data pada page $page untuk tahun $year.");
                        break;  // Keluar dari loop jika tidak ada data pada halaman
                    }

                    // Proses setiap data di halaman
                    foreach ($data as $item) {
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
                    }

                    // Periksa jika masih ada halaman berikutnya
                    $pageCount = $response->json()['sp']['pageCount'] ?? 0; // Cek apakah ada 'pageCount'
                    Log::info("Halaman $page untuk tahun $year: pageCount = $pageCount");

                    // Tentukan apakah kita harus lanjut ke halaman berikutnya
                    if ($page < $pageCount) {
                        $page++;  // Lanjutkan ke halaman berikutnya
                    } else {
                        $lanjut = false;  // Berhenti jika sudah mencapai halaman terakhir
                    }
                } while ($lanjut);  // Lanjutkan loop selama masih ada halaman
            } catch (\Exception $e) {
                Log::error("Error pada tahun $year: " . $e->getMessage());
            }
        }
    }
}
