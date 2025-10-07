<?php

namespace App\Jobs;

use App\Library\APIEsdm;
use App\Models\IzinMigas;
use App\Models\IzinMigasTabular;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveIzinMigasJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $npwp;

    public function __construct($npwp)
    {
        $this->npwp = $npwp;
        logger()->info("[JOB INIT] SaveIzinMigasJob dibuat untuk NPWP: {$npwp}");
    }

    public function handle()
    {
        $api = new APIEsdm();

        logger()->info("[API] Memulai panggilan API data izin untuk NPWP: {$this->npwp}");

        // Memanggil API untuk mendapatkan data izin
        $response = $api->post('/perizinan/migas/data-izin', [
            'param' => [
                'npwp' => $this->npwp,
            ],
        ]);

        // Pastikan respons API berhasil
        if (!$response->successful()) {
            logger()->error("[API ERROR] Gagal mendapatkan data dari API MIGAS", ['npwp' => $this->npwp, 'body' => $response->body()]);
            return [
                'status' => 'failed',
                'message' => 'Gagal mendapatkan data dari API MIGAS'
            ];
        }

        // Cek apakah JSON bisa di-decode
        try {
            $json = $response->json();
            logger()->info("[API] Response API MIGAS berhasil di-decode", ['npwp' => $this->npwp]);
        } catch (\Throwable $e) {
            logger()->error("[JSON ERROR] Gagal decode JSON dari API MIGAS", [
                'npwp' => $this->npwp,
                'body' => $response->body(),
                'error' => $e->getMessage(),
            ]);
            return [
                'status' => 'failed',
                'message' => 'Terjadi kesalahan saat memproses data API MIGAS'
            ];
        }

        // Cek apakah respons API valid dan mengandung data yang dibutuhkan
        if (
            is_array($json) &&
            isset($json['responsePerizinan']) &&
            isset($json['responsePerizinan']['data_badan_usaha']) &&
            isset($json['responsePerizinan']['data_izin'])
        ) {
            $data = $json['responsePerizinan'];

            logger()->info("[DB] Menyimpan data izin MIGAS ke database", ['npwp' => $this->npwp]);

            // Simpan data MIGAS ke database
            IzinMigas::updateOrCreate(
                ['npwp' => $this->npwp],
                [
                    'data_badan_usaha' => $data['data_badan_usaha'],
                    'data_izin' => $data['data_izin'],
                ]
            );

            if (isset($data['data_badan_usaha']['Nama_perusahaan'])) {
                User::where('npwp', $this->npwp)->update([
                    'name' => $data['data_badan_usaha']['Nama_perusahaan']
                ]);
                logger()->info("[DB] Nama perusahaan user diupdate", ['npwp' => $this->npwp, 'name' => $data['data_badan_usaha']['Nama_perusahaan']]);
            }

            // Iterasi data_izin untuk setiap sub_page_id
            foreach ($data['data_izin'] as $izin) {
                foreach ($izin['multiple_id'] as $subPage) {
                    // Ambil id_permohonan, id_izin, dan sub_page_id
                    $id_permohonan = $izin['Id_Permohonan'];
                    $id_izin = $izin['Id_Izin'];
                    $sub_page_id = $subPage['sub_page_id'];

                    logger()->info("[TABULAR] Memproses data tabular", [
                        'npwp' => $this->npwp,
                        'id_permohonan' => $id_permohonan,
                        'id_izin' => $id_izin,
                        'sub_page_id' => $sub_page_id,
                    ]);

                    // Panggil fungsi saveTabularData untuk menyimpan data tabular
                    $tabularResult = $this->saveTabularData($id_permohonan, $id_izin, $sub_page_id);

                    // Jika ada error dalam menyimpan tabular, langsung berhenti
                    if ($tabularResult['status'] !== 'success') {
                        logger()->error("[TABULAR ERROR] Gagal simpan data tabular", [
                            'npwp' => $this->npwp,
                            'message' => $tabularResult['message'],
                        ]);
                        return $tabularResult;  // Kembalikan jika ada error pada tabular data
                    }
                }
            }

            // Panggil fungsi untuk menyimpan status DJP
            $djpResult = $this->saveDjpStatus();
            logger()->info("[DJP] Proses penyimpanan status DJP selesai", ['npwp' => $this->npwp, 'result' => $djpResult]);

            return $djpResult;
        }

        logger()->error("[DATA ERROR] Data API MIGAS tidak lengkap atau tidak sesuai", ['npwp' => $this->npwp, 'body' => $response->body()]);

        return [
            'status' => 'failed',
            'message' => 'Gagal mengambil data dari API Izin: ' . $response->body()
        ];
    }

    public function saveTabularData($id_permohonan, $id_izin, $sub_page_id)
    {
        $api = new APIEsdm();

        // Endpoint API untuk mendapatkan data tabular
        $endpoint = '/perizinan/migas/data-tabular';

        // Kirim parameter ke API
        $response = $api->post($endpoint, [
            'param' => [
                'id_permohonan' => $id_permohonan,
                'id_izin' => $id_izin,
                'sub_page_id' => $sub_page_id,
            ],
        ]);

        // Cek apakah respons API berhasil
        if ($response->successful()) {
            $data = $response->json();

            // Cek apakah response mengandung data yang diperlukan
            if (isset($data['responsePerizinan']['list_data']) && is_array($data['responsePerizinan']['list_data'])) {
                foreach ($data['responsePerizinan']['list_data'] as $tabularData) {
                    // Gunakan updateOrCreate untuk memastikan data diperbarui jika sudah ada
                    IzinMigasTabular::updateOrCreate(
                        [
                            'npwp' => $this->npwp, // NPWP yang digunakan pada data izin
                            'id_permohonan' => $id_permohonan,
                            'id_izin' => $id_izin,
                            'sub_page_id' => $sub_page_id,
                            'nama_tabel' => $tabularData['nama_tabel'], // Gunakan nama_tabel untuk identifikasi
                        ],
                        [
                            'description' => $tabularData['description'],
                            'data' => $tabularData['data'], // Simpan data dalam bentuk JSON
                        ]
                    );
                }

                logger()->info("[TABULAR] Data Tabular berhasil disimpan untuk NPWP {$this->npwp}", [
                    'id_permohonan' => $id_permohonan,
                    'id_izin' => $id_izin,
                    'sub_page_id' => $sub_page_id,
                ]);

                return [
                    'status' => 'success',
                    'message' => 'Data Tabular berhasil disimpan atau diperbarui.'
                ];
            } else {
                logger()->error("[TABULAR ERROR] Data tabular tidak ditemukan dalam response", ['npwp' => $this->npwp]);
                return [
                    'status' => 'failed',
                    'message' => 'Data tabular tidak ditemukan dalam response.'
                ];
            }
        }

        logger()->error("[TABULAR ERROR] Gagal mengambil data dari API Tabular", ['npwp' => $this->npwp, 'body' => $response->body()]);

        return [
            'status' => 'failed',
            'message' => 'Gagal mengambil data dari API Tabular: ' . $response->body()
        ];
    }

    public function saveDjpStatus()
    {
        $api = new APIEsdm();

        $endpoint = '/djp/v2/kswp';

        // Kirim parameter sesuai format yang diberikan
        $response = $api->post($endpoint, [
            'cekKswp' => [
                'npwp' => $this->npwp, // NPWP dari data izin
                'kdizin' => '100', // Nilai statis untuk kdizin
            ],
        ]);

        // Pastikan respons sukses
        if ($response->successful()) {
            $data = $response->json();

            // Cek apakah 'message' ada dalam response dan berisi data yang benar
            if (isset($data['message'])) {
                $message = $data['message'];

                // Pastikan NPWP dan status ada di response
                if (isset($message['NPWP']) && isset($message['status'])) {
                    // Update status DJP berdasarkan NPWP
                    IzinMigas::where('npwp', $message['NPWP'])->update([
                        'status_djp' => $message['status'],
                    ]);

                    logger()->info("[DJP] Status DJP berhasil diperbarui", ['npwp' => $message['NPWP'], 'status' => $message['status']]);

                    return [
                        'status' => 'success',
                        'message' => 'Data MIGAS berhasil diproses untuk NPWP ' . $this->npwp
                    ];
                } else {
                    logger()->error("[DJP ERROR] Data yang diperlukan tidak ada dalam response API DJP", ['npwp' => $this->npwp]);
                    return [
                        'status' => 'failed',
                        'message' => 'Data yang diperlukan tidak ada dalam response API DJP untuk NPWP ' . $this->npwp
                    ];
                }
            } else {
                logger()->error("[DJP ERROR] Respons API tidak mengandung \"message\"", ['npwp' => $this->npwp]);
                return [
                    'status' => 'failed',
                    'message' => 'Respons API tidak mengandung "message" untuk NPWP ' . $this->npwp
                ];
            }
        } else {
            logger()->error("[DJP ERROR] Gagal mengambil status DJP", ['npwp' => $this->npwp, 'body' => $response->body()]);
            return [
                'status' => 'failed',
                'message' => 'Gagal mengambil status DJP untuk NPWP ' . $this->npwp . ': ' . $response->body()
            ];
        }

        logger()->error("[DJP ERROR] Gagal mengambil status DJP secara umum", ['npwp' => $this->npwp]);

        return [
            'status' => 'failed',
            'message' => 'Gagal mengambil status DJP'
        ];
    }
}
