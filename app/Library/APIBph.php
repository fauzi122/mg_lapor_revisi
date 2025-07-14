<?php

namespace App\Library;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class APIBph
{
    const BASEURL = 'https://ngembangin.esdm.go.id/inline/hilir/internal/api/dev/pelaporan-migas';

    /**
     * Mendapatkan atau mengupdate token BPH API
     */
    public function tokenBphApi()
    {
        // Cek apakah ada token yang disimpan di cache
        $token = Cache::get('access_token');
        $tokenExpiry = Cache::get('token_expiry');

        // Jika token ada dan belum kadaluarsa
        if ($token && $tokenExpiry && now()->lessThan($tokenExpiry)) {
            return $token;  // Token masih valid
        }

        // Jika token tidak ada atau sudah kadaluarsa, ambil token baru
        return $this->refreshToken();
    }

    /**
     * Melakukan refresh token
     */
    private function refreshToken()
    {
        $url = self::BASEURL . "/login";

        try {
            // Request untuk mendapatkan token baru
            $response = Http::withBasicAuth('ditjenmigas', 'P@ssw0rd')->post($url, [
                'Username' => "ditjenmigas",
                'Password' => "P@ssw0rd"
            ]);

            if ($response->successful()) {
                $responseBody = $response->json();
                $token = $responseBody['access_token'];
                $expiresIn = $responseBody['expires_in'];

                // Simpan token dan waktu kadaluarsa
                Cache::put('access_token', $token, now()->addSeconds($expiresIn));
                Cache::put('token_expiry', now()->addSeconds($expiresIn));

                return $token;
            } else {
                Log::error('Gagal mendapatkan token.', ["message" => $response["error"]]);
                throw new Exception("Gagal mendapatkan token baru.");
            }
        } catch (\Throwable $th) {
            log::error('Gagal mendapatkan token.', ["message" => $th->getMessage()]);
            throw new \Exception("Gagal mendapatkan token.");
        }
    }

    /**
     * Melakukan POST request ke API dengan token yang valid
     */
    public function post($endpoint, $year, $page)
    {
        $token = $this->tokenBphApi(); // Mendapatkan token yang valid

        try {
            $response = Http::timeout(3000)
                ->withToken($token)
                ->post(self::BASEURL . $endpoint, [
                    "tahun" => $year,
                    "page" => $page
                ]);

            // Jika status 401 (Unauthorized), refresh token dan coba lagi
            if ($response->status() === 401) {
                $this->refreshToken();  // Refresh token
                $response = Http::timeout(3000)
                    ->withToken(Cache::get('access_token')) // Gunakan token baru
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
