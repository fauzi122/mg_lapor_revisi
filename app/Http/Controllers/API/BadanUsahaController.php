<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class BadanUsahaController extends BaseController
{
    public function registerBU(Request $request){
		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
			'npwp' => 'required',
        ]);
		
		if($validator->fails()){
            return $this->sendError('Eror Validasi.', $validator->errors());       
        }
		
		$input = $request->all();
        $input['password'] = bcrypt('-');
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
			'npwp' => $request->npwp,
            'password' => $input['password'],
            'role' => 'Badan Usaha'
        ]);
        $success['token'] =  $user->createToken('pelaporan')->accessToken;
        $success['name'] =  $user->name;
		$success['npwp'] =  $user->npwp;
   
        return $this->sendResponse($success, 'Sukses Registrasi Badan Usaha.');
	}
}
