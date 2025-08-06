<?php

namespace App\Library;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class APIOss
{
    const BASEURL = 'https://apicdev.esdm.go.id/development/dev-sandbox/';

    // Header tetap
    const USER_KEY = '352fa6f82403d0e389006a44f7498273';
    const CLIENT_ID = 'ffdf72079a5abaee1f41f3c29cfea6fe';
    const CLIENT_SECRET = 'cdf8395a78d136ba7b29e5619c89bfab';

    /**
     * Request POST ke API OSS
     */
    public function post($endpoint, array $data = [], $bearerToken = null)
    {
        try {
            // Log request
            Log::info('Sending POST request to API OSS', [
                'url' => self::BASEURL . ltrim($endpoint, '/'),
                'headers' => $this->buildHeaders($bearerToken),
                'data' => $data,
            ]);

            // Mengirim request
            $response = Http::withHeaders($this->buildHeaders($bearerToken))
                ->withOptions([
                    'verify' => App::environment('production'), // false di local
                ])
                ->post(self::BASEURL . ltrim($endpoint, '/'), $data);

            // Log response
            Log::info('Received response from API OSS', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error saat POST ke API OSS', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'failed',
                'message' => 'Error saat POST ke API OSS',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Request GET ke API OSS
     */
    public function get($endpoint, array $params = [], $bearerToken = null)
    {
        try {
            // Log request
            Log::info('Sending GET request to API OSS', [
                'url' => self::BASEURL . ltrim($endpoint, '/'),
                'headers' => $this->buildHeaders($bearerToken),
                'params' => $params,
            ]);

            // Mengirim request
            $response = Http::withHeaders($this->buildHeaders($bearerToken))
                ->withOptions([
                    'verify' => App::environment('production'),
                ])
                ->get(self::BASEURL . ltrim($endpoint, '/'), $params);

            // Log response
            Log::info('Received response from API OSS', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error saat GET ke API OSS', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'failed',
                'message' => 'Error saat GET ke API OSS',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menyusun header API OSS termasuk Bearer token (jika tersedia)
     */
    private function buildHeaders($bearerToken = null)
    {
        $headers = [
            'user_key' => self::USER_KEY,
            'client-id' => self::CLIENT_ID,
            'client-secret' => self::CLIENT_SECRET,
            'Accept' => 'application/json',
        ];

        if (!empty($bearerToken)) {
            $headers['Authorization'] = 'Bearer ' . $bearerToken;
        }

        return $headers;
    }
}
