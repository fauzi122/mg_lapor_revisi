<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class BadanUsahaController extends BaseController
{
    public function registerBU(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'npwp' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validasi.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt('-');
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'npwp' => $request->npwp,
            'password' => $input['password'],
            'role' => 'Badan Usaha'
        ]);
        $success['token'] =  $user->createToken('pelaporan')->accessToken;
        $success['name'] =  $user->name;
        $success['npwp'] =  $user->npwp;

        return $this->sendResponse($success, 'Sukses Registrasi Badan Usaha.');
    }

    public function getDataLaporanBU(Request $request)
    {
        $npwp = $request->NPWP;

        // Validasi jika NPWP kosong
        if ($npwp == 'null' || $npwp == "") {
            $message = "NPWP tidak boleh kosong";
            $response = [
                'status' => "error",
                'message' => $message,
            ];
            return response()->json($response, 200);
        }

        // $dataNpwp = encrypt($npwp);
        if (App::environment('production')) {
            // Jika di produksi, gunakan URL dari APP_URL di .env dan tambahkan '/pelaporan-hilir'
            $url = env('APP_URL') . '/badan-usaha/login';
        } else {
            // Jika di lokal, gunakan URL lokal
            $url = 'http://127.0.0.1:8000/badan-usaha/login';
        }


        $message = "Data Pelaporan";
        App::setLocale('id'); // Set locale ke bahasa Indonesia
        Carbon::setLocale('id');
        $eom = Carbon::now()->endOfMonth()->translatedFormat('d F Y');
        $bulan = Carbon::now()->endOfMonth()->translatedFormat('Y-m');
        $badanUsahaId = User::where('npwp', $npwp)->value('badan_usaha_id');

        // Laporan Niaga
        $queriesNiaga = [
            // MINYAK BUMI
            ['table' => 'jual_hasil_olah_bbms', 'column' => 'bulan'],
            ['table' => 'pasokan_hasil_olah_bbms', 'column' => 'bulan'],
            ['table' => 'harga_bbm_jbus', 'column' => 'bulan'],
            ['table' => 'ekspors', 'column' => 'bulan_peb'],
            ['table' => 'impors', 'column' => 'bulan_pib'],
            ['table' => 'penyminyakbumis', 'column' => 'bulan'],

            // GAS
            ['table' => 'harga_l_p_g_s', 'column' => 'bulan'],
            ['table' => 'penjualan_lngs', 'column' => 'bulan'],
            ['table' => 'pasokanlngs', 'column' => 'bulan'],
            ['table' => 'penjualan_lpgs', 'column' => 'bulan'],
            ['table' => 'pasokan_l_p_g_s', 'column' => 'bulan'],
            ['table' => 'ekspors', 'column' => 'bulan_peb'],
            ['table' => 'impors', 'column' => 'bulan_pib'],
        ];

        $foundNiaga = false;

        foreach ($queriesNiaga as $queryNiaga) {
            $resultNiaga = DB::table("{$queryNiaga['table']}")
                ->where(DB::raw("TO_CHAR(CAST({$queryNiaga['column']} AS DATE), 'YYYY-MM')"), $bulan)
                ->where('npwp', $badanUsahaId)
                ->where('status', 1)
                ->exists();

            if ($resultNiaga) {
                $foundNiaga = true;
                break;
            } else {
                $foundNiaga = false;
                break;
            }
        }

        if ($foundNiaga == false) {
            $statusNiaga = 'Belum Melaporkan';
        } else {
            $statusNiaga = 'Diterima';
        }

        // Laporan Pengolahan
        $queriesPengolahan = [
            // MINYAK BUMI
            ['table' => 'harga_bbm_jbus', 'column' => 'bulan'],
            ['table' => 'pengolahan_minyak_bumi_produksis', 'column' => 'bulan'],
            ['table' => 'pengolahan_minyak_bumi_pasokans', 'column' => 'bulan'],
            ['table' => 'pengolahan_minyak_bumi_distribusis', 'column' => 'bulan'],
            ['table' => 'ekspors', 'column' => 'bulan_peb'],
            ['table' => 'impors', 'column' => 'bulan_pib'],
            ['table' => 'penyminyakbumis', 'column' => 'bulan'],

            // GAS
            ['table' => 'pengolahans', 'column' => 'bulan', 'extra' => ['jenis' => 'Gas Bumi']],
        ];

        $foundPengolahan = false;

        foreach ($queriesPengolahan as $queryPengolahan) {
            $resultPengolahan = DB::table("{$queryPengolahan['table']}")
                ->where(DB::raw("TO_CHAR(CAST({$queryPengolahan['column']} AS DATE), 'YYYY-MM')"), $bulan)
                ->where('npwp', $npwp)
                ->where('status', 1);

            // Tambahan filter jika ada 'extra'
            if (isset($queryPengolahan['extra'])) {
                foreach ($queryPengolahan['extra'] as $field => $value) {
                    $resultPengolahan->where($field, $value);
                }
            }

            if ($resultPengolahan->exists()) {
                $foundPengolahan = true;
                break;
            } else {
                $foundPengolahan = false;
                break;
            }
        }

        if ($foundPengolahan == false) {
            $statusPengolahan = 'Belum Melaporkan';
        } else {
            $statusPengolahan = 'Diterima';
        }

        //laporan Penyimpanan
        $queriesPenyimpanan = [
            ['table' => 'penyminyakbumis', 'column' => 'bulan'], // MINYAK BUMI
            ['table' => 'penygasbumis', 'column' => 'bulan'],    // GAS BUMI
        ];

        $foundPenyimpanan = false;

        foreach ($queriesPenyimpanan as $queryPenyimpanan) {
            $resultPenyimpanan = DB::table("{$queryPenyimpanan['table']}")
                ->where(DB::raw("TO_CHAR(CAST({$queryPenyimpanan['column']} AS DATE), 'YYYY-MM')"), $bulan)
                ->where('npwp', $badanUsahaId)
                ->where('status', 1);

            if ($resultPenyimpanan->exists()) {
                $foundPenyimpanan = true;
                break;
            } else {
                $foundPenyimpanan = false;
                break;
            }
        }

        if ($foundPenyimpanan == false) {
            $statusPenyimpanan = 'Belum Melaporkan';
        } else {
            $statusPenyimpanan = 'Diterima';
        }

        //laporan Pengangkutan
        $queriesPengangkutan = [
            ['table' => 'pengangkutan_minyakbumis', 'column' => 'bulan'], // MINYAK BUMI
            ['table' => 'pengangkutan_gaskbumis', 'column' => 'bulan'],    // GAS BUMI
        ];

        $foundPengangkutan = false;

        foreach ($queriesPengangkutan as $queryPengangkutan) {
            $resultPengangkutan = DB::table("{$queryPengangkutan['table']}")
                ->where(DB::raw("TO_CHAR(CAST({$queryPengangkutan['column']} AS DATE), 'YYYY-MM')"), $bulan)
                ->where('npwp', $badanUsahaId)
                ->where('status', 1);

            if ($resultPengangkutan->exists()) {
                $foundPengangkutan = true;
                break;
            } else {
                $foundPengangkutan = false;
                break;
            }
        }

        if ($foundPengangkutan == false) {
            $statusPengangkutan = 'Belum Melaporkan';
        } else {
            $statusPengangkutan = 'Diterima';
        }

        $dataContent = [
            'laporan_rutin' => [
                [
                    'jenis_pelaporan' => 'Pelaporan Niaga Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'url' => $url,
                ],
                [
                    'jenis_pelaporan' => 'Pelaporan Pengolahan Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'url' => $url,
                ],
                [
                    'jenis_pelaporan' => 'Pelaporan Penyimpanan Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'url' => $url,
                ],
                [
                    'jenis_pelaporan' => 'Pelaporan Pengangkutan Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'url' => $url,
                ]
            ],
            'layanan_penunjang' => [],
            'status_laporan_rutin' => [
                [
                    'jenis_layanan'         => 'Pelaporan Niaga Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'status_laporan'        => $statusNiaga
                ],
                [
                    'jenis_layanan'         => 'Pelaporan Pengolahan Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'status_laporan'        => $statusPengolahan
                ],
                [
                    'jenis_layanan'         => 'Pelaporan Penyimpanan Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'status_laporan'        => $statusPenyimpanan
                ],
                [
                    'jenis_layanan'         => 'Pelaporan Pengangkutan Migas',
                    'batas_akhir_pelaporan' => $eom,
                    'status_laporan'        => $statusPengangkutan
                ],
            ]
        ];

        $response = [
            'status'    => "success",
            'message'   => $message,
            'data'      => $dataContent
        ];

        return response()->json($response, 200);
    }
}
