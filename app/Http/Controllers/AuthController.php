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
		->join('t_perusahaan as b', 'a.id_perusahaan', '=', 'b.id_perusahaan')
		->whereIn('a.id_template', function ($query) {
			$query->select(DB::raw('CAST(id_template AS INTEGER)'))
				->from('mepings')
				->groupBy('id_template');
		})
		->where('a.id_curr_proses', 140)
		->groupBy('b.id_perusahaan', 'b.nama_perusahaan', 'b.email_perusahaan')
		->select('b.nama_perusahaan', 'b.email_perusahaan', 'b.id_perusahaan')
		->get();

		// Check if there are no results
		if ($perusahaan->count() == 0) {
			// Redirect back to the login page with a flash message
			return redirect('/login')->with('error', 'id_perusahaan not found.');
		}

		// return view('badan_usaha.index', compact('perusahaan'));
		return view('badanUsaha.auth.index', compact('perusahaan'));
	}


	// public function indexEvaluator()
	// {
	// 	return view('evaluator.login');
	// }




}
