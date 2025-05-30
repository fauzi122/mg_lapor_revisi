<?php

namespace App\Http\Controllers;
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
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
	public function index()
	{
		$perusahaan = DB::table('r_permohonan_izin as a')
			->join('t_perusahaan as b', 'a.ID_PERUSAHAAN', '=', 'b.ID_PERUSAHAAN')
			->whereIn('a.ID_TEMPLATE', function ($query) {
				$query->select('id_template')
					->from('mepings')
					->groupBy('id_template');
			})
			->where('a.ID_CURR_PROSES', '140')
			->select('b.NAMA_PERUSAHAAN', 'b.EMAIL_PERUSAHAAN', 'b.ID_PERUSAHAAN')
			->groupBy('b.ID_PERUSAHAAN')
			->get();

		// Check if there are no results
		if ($perusahaan->count() == 0) {
			// Redirect back to the login page with a flash message
			return redirect('/login')->with('error', 'ID_PERUSAHAAN not found.');
		}

		// return view('badan_usaha.index', compact('perusahaan'));
		return view('badanUsaha.auth.index', compact('perusahaan'));
	}


	// public function indexEvaluator()
	// {
	// 	return view('evaluator.login');
	// }




}
