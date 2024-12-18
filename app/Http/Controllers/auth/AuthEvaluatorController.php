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
use Illuminate\Support\Facades\Http;

class AuthEvaluatorController extends Controller
{

    public function index()
	{
		return view('evaluator.login');
	}
	public function index_sso()
	{
		return view('evaluator.ssologin');
	}
// pindah sementara
    // public function postloginEvaluator(Request $request)
	// {

	// 	$token = $request->otp;

	// 	$user = User::where('remember_token', $token)->first();
	// 	// dd($user);
	// 	$email = $user->email;
	// 	$password = '-';
	// 	$token = $user->remember_token;
	// 	$credentials = [
	// 		'email' => $email,
	// 		'password' => $password,
	// 		'remember_token' => $token
	// 	];

	// 	$dologin = Auth::attempt($credentials);
	// 	if ($dologin) {
	// 		//update remember token jadi kosong
	// 		$updateUser = User::where('remember_token', $token)->update([
	// 			'remember_token'	=> ''
	// 		]);
	// 		return redirect('/master');
	// 	} else {
	// 		// dd('hai');
	// 		return redirect('/evaluator/login')->with('statusLogin', 'Eror Autentikasi');
	// 	}
	// }

	public function postLogin(Request $request)
	{
		// Validasi data permintaan
		$request->validate([
			'email' => 'required|string|email',
			'password' => 'required|string',
		]);
	
		// Kode yang dikomentari disimpan untuk referensi, tetapi tidak digunakan saat ini.
		// $url = "https://apicdev.esdm.go.id/development/dev-sandbox/sipeg/sso-info?nip=".$request->email;
		// $client_id = "39dc606335d8c4e22ea2c444bf58cecd";
		// $client_secret = "9ec10a07e01bb24b9beba125c28cbff1";
		// $request = Http::get($url,[
		//     'headers' => [
		//         'client-id' => $client_id,
		//         'client-secret' => $client_secret,
		//         'APIKey' => 'SIPEG',
		//     ]
		// ]);
	
		// $jsonResponse = $request->json();
		// dd($url, $client_id, $client_secret, $jsonResponse);
		// $code = $jsonResponse['code'];
	
		$credentials = $request->only('email', 'password');
	
		// Mencoba untuk login dengan kredensial yang diberikan
		if (Auth::attempt($credentials, $request->boolean('remember-check'))) {
			// Redirect ke halaman yang diinginkan jika login berhasil
			return redirect()->intended('master');
		}
	
		// Redirect kembali dengan pesan kesalahan jika login gagal
		return back()->withErrors([
			'login_error' => 'Username atau password salah.',
		])->withInput($request->except('password')); // Simpan input email, tapi hapus field password
	}
	



	public function logout()
	{
		Auth::logout();
		session()->flush();  // Menghapus semua data sesi
	
		return redirect('/evaluator/login')->with('statusLogin', 'Sukses Logout');
	}
	

	public function genOTP(Request $request)
	{
		$request->validate([
			'nip' => 'required'
		]);
		$randomString = Str::random(8);

		//cek dulu di SSO ada atau tidak**


		$nip = $request->nip;
		$email = 'xx@gmail.com';

		//cek NIP di table user
		$checkNIP = User::where('email', $nip)->count();

		if ($checkNIP == '0') {
			//insert ke table user
			$storeUser = User::create([
				'name'	=> 'Siti',
				'email'	=> $nip,
				'password' => bcrypt('-'),
				'remember_token'	=> $randomString,
				'role'	=> 'ADM',
			]);
		} else {
			//update remember token
			$updateUser = User::where('email', $nip)->update([
				'remember_token'	=> $randomString
			]);
		}

		//send email**
		$data = [
			'title' => 'Test Email Evaluator',
			'body' => $randomString
		];

		Mail::to('vanturgo16@gmail.com')->send(new GenOTPMail($data));


		return redirect('/evaluator/login')->with('statusToken', 'Sukses Generate Token, Silahkan Cek Email Anda');
	}
}
