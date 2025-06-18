<?php

namespace App\Library;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class APIEsdm
{
    const CLIENT_ID = '39dc606335d8c4e22ea2c444bf58cecd';
    const CLIENT_SECRET = '9ec10a07e01bb24b9beba125c28cbff1';
    const BASEURL = 'https://apicdev.esdm.go.id/development/dev-sandbox';

    public function post($endpoint, array $data)
    {
        try {
            return Http::withHeaders([
                'client-id' => self::CLIENT_ID,
                'client-secret' => self::CLIENT_SECRET,
            ])
                ->withOptions([
                    'verify' => App::environment('production'), // true di production, false di local
                ])
                ->post(self::BASEURL . $endpoint, $data);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error saat memanggil API ESDM',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get($endpoint, array $params = [])
    {
        try {
            return Http::withHeaders([
                'client-id' => self::CLIENT_ID,
                'client-secret' => self::CLIENT_SECRET,
            ])
                ->withOptions([
                    'verify' => App::environment('production'),
                ])
                ->get(self::BASEURL . $endpoint, $params);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error saat GET ke API ESDM',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
