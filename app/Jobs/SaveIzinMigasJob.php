<?php

namespace App\Jobs;

use App\Library\APIEsdm;
use App\Models\IzinMigas;
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

        $response = $api->post('/data-izin', [
            'param' => [
                'npwp' => $this->npwp,
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json()['responsePerizinan'];

            IzinMigas::on('pgsql_migas')->updateOrCreate(
                ['npwp' => $this->npwp],
                [
                    'data_badan_usaha' => $data['data_badan_usaha'],
                    'data_izin' => $data['data_izin'],
                ]
            );

            return [
                'status' => 'success',
                'message' => 'Data berhasil disimpan dari API ESDM.'
            ];
        }

        return [
            'status' => 'failed',
            'message' => 'Gagal mengambil data dari API: ' . $response->body()
        ];
    }
}
