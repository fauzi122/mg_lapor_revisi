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
    }

    public function handle()
    {
        $api = new APIEsdm();

        // Memanggil API untuk mendapatkan data izin
        $response = $api->post('/perizinan/migas/data-izin', [
            'param' => [
                'npwp' => $this->npwp,
            ],
        ]);

        // Pastikan respons API berhasil
        if (!$response->successful()) {
            logger()->error("Gagal mendapatkan data dari API MIGAS", ['body' => $response->body()]);
            return [
                'status' => 'failed',
                'message' => 'Gagal mendapatkan data dari API MIGAS'
            ];
        }

        // Cek apakah JSON bisa di-decode
        try {
            $json = $response->json();
        } catch (\Throwable $e) {
            logger()->error("Gagal decode JSON dari API MIGAS", [
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
            }
            // dd($data);
            // Iterasi data_izin untuk setiap sub_page_id
            foreach ($data['data_izin'] as $izin) {
                foreach ($izin['multiple_id'] as $subPage) {
                    // Ambil id_permohonan, id_izin, dan sub_page_id
                    $id_permohonan = $izin['Id_Permohonan'];
                    $id_izin = $izin['Id_Izin'];
                    $sub_page_id = $subPage['sub_page_id'];

                    // Panggil fungsi saveTabularData untuk menyimpan data tabular
                    $tabularResult = $this->saveTabularData($id_permohonan, $id_izin, $sub_page_id);

                    // Jika ada error dalam menyimpan tabular, langsung berhenti
                    if ($tabularResult['status'] !== 'success') {
                        return $tabularResult;  // Kembalikan jika ada error pada tabular data
                    }
                }
            }

            // Panggil fungsi untuk menyimpan status DJP
            $djpResult = $this->saveDjpStatus();
            return $djpResult;
        }

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

                return [
                    'status' => 'success',
                    'message' => 'Data Tabular berhasil disimpan atau diperbarui.'
                ];
            } else {
                return [
                    'status' => 'failed',
                    'message' => 'Data tabular tidak ditemukan dalam response.'
                ];
            }
        }

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

                    return [
                        'status' => 'success',
                        'message' => 'Data MIGAS berhasil diproses untuk NPWP ' . $this->npwp
                    ];
                } else {
                    return [
                        'status' => 'failed',
                        'message' => 'Data yang diperlukan tidak ada dalam response API DJP untuk NPWP ' . $this->npwp
                    ];
                }
            } else {
                return [
                    'status' => 'failed',
                    'message' => 'Respons API tidak mengandung "message" untuk NPWP ' . $this->npwp
                ];
            }
        } else {
            return [
                'status' => 'failed',
                'message' => 'Gagal mengambil status DJP untuk NPWP ' . $this->npwp . ': ' . $response->body()
            ];
        }

        return [
            'status' => 'failed',
            'message' => 'Gagal mengambil status DJP'
        ];
    }
}
