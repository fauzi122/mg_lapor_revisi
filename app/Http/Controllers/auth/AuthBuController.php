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


		$check = User::where('badan_usaha_id', $bu)->count();

		if ($check == '0') {
			// dd('hai');
			//insert ke table user dulu
			$perusahaan = DB::table('t_perusahaan')
				->where('ID_PERUSAHAAN', $bu)
				->first();

			$storeUser = User::create([
				'name' => $perusahaan->NAMA_PERUSAHAAN,
				'email' => $perusahaan->EMAIL_PERUSAHAAN,
				'npwp' => $perusahaan->NPWP,
				'password' => bcrypt('-'),
				'badan_usaha_id' => $perusahaan->ID_PERUSAHAAN,
				'role' => 'BU',
			]);
		}

		$user = User::where('badan_usaha_id', $bu)->first();
		// dd($user);
		$email = $user->email;
		$password = '-';
		$credentials = [
			'email' => $email,
			'password' => $password
		];

		$dologin = Auth::attempt($credentials);

		if ($dologin) {
			return redirect('/');
		} else {
			// dd('hai');
			return redirect('/login')->with('statusLogin', 'Eror Autentikasi');
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
