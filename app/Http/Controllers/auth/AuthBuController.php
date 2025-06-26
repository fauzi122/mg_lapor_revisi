<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\T_perusahaan;
use Illuminate\Support\Str;
use App\Mail\GenOTPMail;
use App\Models\Meping;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Mail;

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



	public function postloginIzinByURL($dataNPWP)
	{

		$npwp = decrypt($dataNPWP);


		$check = User::where('npwp', $npwp)->count();

		if ($check == '0') {
			return redirect('/login')->with('statusLogin', 'Eror Autentikasi');
		}

		$user = User::where('npwp', $npwp)->first();
		// dd($user);
		$email = $user->email;
		$password = '-';
		$credentials = [
			'email' => $email,
			'password' => $password
		];

		$dologin = Auth::attempt($credentials);

		if ($dologin) {
			// Request internal ke route /izin-migas/simpan?npwp=... setelah login berhasil
            Http::get(url('/izin-migas/simpan'), [
                'npwp' => $npwp
            ]);
			return redirect('/');
		} else {
			// dd('hai');
			return redirect('/login')->with('statusLogin', 'Eror Autentikasi');
		}
	}
    
    public function logoutBU()
	{

		Auth::logout();
		return redirect('/login')->with('statusLogin', 'Sukses Logout');
	}
}
