<?php

namespace App\Library;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class APIBph
{
    const BASEURL = 'https://ngembangin.esdm.go.id/inline/hilir/internal/api/dev/pelaporan-migas';

    public function tokenBphApi()
    {
        $url = self::BASEURL . "/login";

        try {

            $response = Http::withBasicAuth('ditjenmigas', 'P@ssw0rd')->post($url, [
                'Username' => "ditjenmigas",
                'Password' => "P@ssw0rd"
            ]);

            if ($response->successful()) {
                $response = $response->json();
                $token = $response['access_token'];
                $expiresIn = $response['expires_in'];

                // Simpan token dan waktu kadaluarsa
                Cache::put('access_token', $token, now()->addSeconds($expiresIn));
                Cache::put('token_expiry', now()->addSeconds($expiresIn));

                return $token;
            } else {
                Log::error('Gagal mendapatkan token.', ["message" => $response["error"]]);
                return;
            }
        } catch (\Throwable $th) {
            log::error('Gagal mendapatkan token.', ["message" => $th->getMessage()]);
            throw new \Exception("Gagal mendapatkan token.");
        }
    }

    public function post($endpoint, $year, $page)
    {
        $token = Cache::get('access_token');

        try {
            $response = Http::timeout(200)
                ->retry(3, 2000)
                ->withToken($token)
                ->post(self::BASEURL . $endpoint, [
                    "tahun" => $year,
                    "page" => $page
                ]);

            // Unauthorized (Token expired)
            if ($response->status() === 401 || $response->json('error') === 'Token is Invalid') {
                // Refresh token
                $this->tokenBphApi();

                // Retry sekali
                $response = Http::timeout(200)
                    ->withToken(Cache::get('access_token'))
                    ->post(self::BASEURL . $endpoint, [
                        "tahun" => $year,
                        "page" => $page
                    ]);
            }

            return $response;
        } catch (\Throwable $th) {
            throw new Exception("Gagal request ke endpoint {$endpoint}: " . $th->getMessage());
        }
    }
}
