<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengolahan;

class RealTimeDataController extends Controller
{
  public function index()
  {
    return view('realtime_data');
  }

  public function getData()
  {
    // Ambil data dari database
    $data = Pengolahan::get(); // Sesuaikan query Anda di sini

    return response()->json($data);
  }
}
