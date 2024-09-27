<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\induk_izin;
class IndukizinController extends Controller
{
    public function index_evaluator()
    {
        // $meping = induk_izin::get();
        return view('admin.master.dashboard');
    }




}
