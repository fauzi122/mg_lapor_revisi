<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Library\APIOss;
use App\Jobs\SaveIzinMigasJob;
use Illuminate\Support\Facades\Log;

class AuthBuController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     return redirect('/login');
    //     // $this->middleware(['permission:permissions.index']);
    // }

    public function postloginIzin(Request $request)
    {
        $bu = $request->perusahaan;

        // Cek apakah user dengan badan_usaha_id tersebut sudah ada
        $check = User::where('badan_usaha_id', $bu)->count();

        if ($check == 0) {
            // Ambil data perusahaan dari tabel t_perusahaan
            $perusahaan = DB::table('t_perusahaan')
                ->where('id_perusahaan', $bu)
                ->first();

            // Pastikan data perusahaan ditemukan
            if ($perusahaan) {
                // Tambahkan user baru berdasarkan data perusahaan
                User::create([
                    'name' => $perusahaan->nama_perusahaan,
                    'email' => $perusahaan->email_perusahaan,
                    'npwp' => $perusahaan->npwp,
                    'password' => bcrypt('-'), // Password dummy, disesuaikan kebutuhan
                    'badan_usaha_id' => $perusahaan->id_perusahaan,
                    'role' => 'BU',
                ]);
            } else {
                return redirect('/login')->with('statusLogin', 'Perusahaan tidak ditemukan');
            }
        }

        // Ambil data user berdasarkan badan_usaha_id
        $user = User::where('badan_usaha_id', $bu)->first();

        if (!$user) {
            return redirect('/login')->with('statusLogin', 'User tidak ditemukan');
        }

        $credentials = [
            'email' => $user->email,
            'password' => '-' // password dummy sesuai yang diset di atas
        ];

        // Lakukan proses login
        if (Auth::attempt($credentials)) {
            return redirect('/');
        } else {
            return redirect('/login')->with('statusLogin', 'Gagal login. Coba lagi.');
        }
    }

    public function postloginIzinByURL(Request $request)
    {
        // $qryStr = 'HGqpJjieV/Ot8kH+cFVi/CCoHI7WlosRTE7YJFuGwnuyR2DjKHdVEzFdIcbrOQQPzGQiSfCH5FiC/CQZ6TbVM0lHIQYJoDIYuJQJUAGEkWnnByMcX0xTLgAteBQvtLSV';
        // $tokenNonOss = $request->query('token_non_oss');
        // $tokenNonOss = str_replace(' ', '+', $tokenNonOss);
        // $key = "pu5dat1nEsdm2020s1lv141nt3grasi!@3$%^";
        // $c = base64_decode($tokenNonOss);
        // $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        // $iv = substr($c, 0, $ivlen);
        // $hmac = substr($c, $ivlen, $sha2len = 32);
        // $ciphertext_raw = substr($c, $ivlen + $sha2len);
        // $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);

        // // Validate HMAC
        // $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        // if (!hash_equals($calcmac, $hmac)) {
        //     return redirect('/login')->with('statusLogin', 'Error: HMAC mismatch');
        // }

        // // Parse the decrypted data into an associative array
        // parse_str($original_plaintext, $output);
        // // Ensure the 'npwp' is extracted from the decrypted data
        // $npwp = isset($output['npwp']) ? $output['npwp'] : null;
        // // Cek apakah NPWP ada di database
        // $check = User::where('npwp', $npwp)->count();

        // if ($check == 0) {
        //     $email = $output['email'] ?? 'default@example.com';  // Ganti dengan email default jika tidak ada
        //     $password = bcrypt('-');  // Encrypt password with bcrypt
        //     // dd($email);

        //     // Membuat record baru di database jika NPWP tidak tersedia
        //     User::updateOrCreate(
        //         [
        //             'email' => $email,
        //             'npwp'  => $npwp,
        //         ],
        //         [
        //             'password' => $password,
        //             'role'     => 'BU',
        //         ]
        //     );
        // }

        // // Ambil user dan login
        // $user = User::where('npwp', $npwp)->first();
        // $email = $user->email;
        // $password = '-';
        // $credentials = [
        //     'email' => $email,
        //     'password' => $password
        // ];

        // $dologin = Auth::attempt($credentials);

        // if ($dologin) {
        //     // Request internal ke route /izin-migas/simpan?npwp=... setelah login berhasil
        //     Http::get(url('/izin-migas/simpan'), [
        //         'npwp' => $npwp
        //     ]);
        //     return redirect('/');
        // } else {
        //     return redirect('/login')->with('statusLogin', 'Error: Autentikasi');
        // }
        // dd($request->has('token_oss'));
        if ($request->has('token_non_oss')) {
            return $this->loginFromNonOSS($request);
        }

        if ($request->query('token_oss')) {
            return $this->loginFromOSS($request);
        }

        return redirect('/login')->with('statusLogin', 'Token tidak ditemukan');
    }

    private function loginFromNonOSS(Request $request)
    {
        $tokenNonOss = str_replace(' ', '+', $request->query('token_non_oss'));
        $key = "pu5dat1nEsdm2020s1lv141nt3grasi!@3$%^";

        try {
            $c = base64_decode($tokenNonOss);
            $ivlen = openssl_cipher_iv_length("AES-128-CBC");
            $iv = substr($c, 0, $ivlen);
            $hmac = substr($c, $ivlen, 32);
            $ciphertext_raw = substr($c, $ivlen + 32);
            $plaintext = openssl_decrypt($ciphertext_raw, "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv);

            $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
            if (!hash_equals($calcmac, $hmac)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'HMAC mismatch'
                ], 400);
            }

            parse_str($plaintext, $output);
            $npwp = $output['npwp'] ?? null;
            $email = $output['email'] ?? 'default@example.com';

            if (!$npwp) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'NPWP tidak ditemukan'
                ], 422);
            }

            $user = User::updateOrCreate(
                ['npwp' => $npwp],
                [
                    'email' => $email,
                    'password' => bcrypt('-'),
                    'badan_usaha_id' => 'NON OSS',
                    'role' => 'BU'
                ]
            );

            $credentials = ['email' => $email, 'password' => '-'];

            if (Auth::attempt($credentials)) {
                try {
                    $result = SaveIzinMigasJob::dispatchSync($npwp);
                    // dd($result);
                    // return response()->json([
                    //     'status' => $result['status'],
                    //     'message' => $result['message']
                    // ]);
                    return redirect('/');
                } catch (\Throwable $e) {
                    // return response()->json([
                    //     'status' => 'error',
                    //     'message' => 'Terjadi kesalahan internal',
                    //     'error' => $e->getMessage()
                    // ], 500);
                    return redirect('/');
                }
                // dd("oke");
                // return response()->json([
                //     'status' => 'success',
                //     'message' => 'Login Non OSS berhasil',
                //     'user' => $user,
                // ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Autentikasi gagal'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Fungsi login dengan token OSS (Bearer + API)
     */
    private function loginFromOSS(Request $request)
    {
        // Ambil token OSS dari query string
        $bearerToken = $request->query('token_oss');
        if (!$bearerToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token OSS tidak tersedia',
            ], 400);
        }

        // Log Token OSS yang diterima
        // Log::info('Received Token OSS', ['token_oss' => $bearerToken]);

        $apiOss = new APIOss();

        // Panggil endpoint userinfo-token
        // Log::info('Sending request to API OSS', [
        //     'url' => 'oss/v1.0/sso/users/userinfo-token',
        //     'bearer_token' => $bearerToken
        // ]);

        $response = $apiOss->post('oss/v1.0/sso/users/userinfo-token', [], $bearerToken);

        // Log Response API
        // Log::info('Received response from API OSS', [
        //     'status' => $response->status(),
        //     'body' => $response->body()
        // ]);

        if (!$response->successful()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token OSS tidak valid atau API gagal',
                'code' => $response->status(),
                'body' => $response->body()
            ], $response->status());
        }

        // Proses data pengguna
        $data = $response->json();
        $userInfo = $data['data'] ?? null;

        // Log data pengguna yang diterima
        // Log::info('Data pengguna dari API OSS', ['user_info' => $userInfo]);

        if (!$userInfo || !isset($userInfo['npwp_perseroan'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pengguna tidak lengkap di response API',
            ], 422);
        }

        $npwp = $userInfo['npwp_perseroan'];
        $email = $userInfo['email'] ?? 'default@example.com';
        $nib = $userInfo['data_nib'][0] ?? null;

        // Simpan atau update user ke database
        $user = User::updateOrCreate(
            ['npwp' => $npwp],
            [
                'email' => $email,
                'password' => bcrypt('-'),
                'badan_usaha_id' => 'OSS',
                'role' => 'BU',
                'nib' => $nib
            ]
        );

        // Log data user yang disimpan/diupdate
        // Log::info('User created or updated', ['user_id' => $user->id]);

        // Autentikasi user
        $credentials = ['email' => $email, 'password' => '-'];
        if (Auth::attempt($credentials)) {
            // Log sukses login
            // Log::info('User authenticated successfully', ['user_id' => $user->id]);

            // Panggil endpoint simpan
            Http::withoutVerifying()->get(url('/izin-migas/simpan'), ['npwp' => $npwp]);

            // Redirect ke homepage setelah login berhasil
            return redirect('/');
        }

        // Log jika autentikasi gagal
        // Log::error('Authentication failed', ['email' => $email]);

        return response()->json([
            'status' => 'error',
            'message' => 'Autentikasi OSS gagal',
        ], 401);
    }

    public function logoutBU()
    {

        Auth::logout();
        return redirect('/login')->with('statusLogin', 'Sukses Logout');
    }
}
