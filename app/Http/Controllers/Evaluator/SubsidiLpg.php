<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\province;
use App\Models\lpg_subsidi_verified;
use App\Models\kuota_lpg_subsidi;
use Illuminate\Support\Facades\DB;
use Random\CryptoSafeEngine;


class SubsidiLpg extends Controller
{
    public function index(){

        $provinsi=province::get();
        $lpg_subsidi= DB::table('lpg_subsidi_verifieds as a')
            ->leftJoin('provinces as b', 'a.provinsi', '=', 'b.id')
            ->select('a.*', 'b.name')
            ->orderBy('a.id','desc')
            ->get();
        return view('evaluator.subsidi_lpg.lpg_subsidi.index', compact('lpg_subsidi','provinsi'));

    }


    public function index_kuota(){
        $provinsi=province::get();
        $lpg_subsidi=DB::table('kuota_lpg_subsidis as a')
            ->leftJoin('provinces as b', 'a.provinsi', '=', 'b.id')
            ->leftJoin('t_kabkot as c', 'a.kabupaten_kota', '=', 'c.ID_KABKOT')
            ->select('a.*', 'b.name', 'c.NAMA_KABKOT')
            ->orderBy('a.id','desc')
            ->get();
        return view('evaluator.subsidi_lpg.kuota_subsidi.index', compact('lpg_subsidi','provinsi'));

    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'bulan' => 'required|date',
            'provinsi' => 'required|string',
            'volume' => 'required|numeric',
        ]);



        $data = [
            'bulan' => $request->input('bulan'),
            'provinsi'=>$request->input('provinsi'),
            'volume'=>$request->input('volume'),
            'created_at'=>Carbon::now()
        ];

//        var_dump($data);die();

        DB::table('lpg_subsidi_verifieds')->insert($data);

        // Return a response or redirect
        return redirect()->back()->with('sweet_success', 'Data has been stored successfully!');
    }
    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'bulan' => 'required|date',
            'provinsi' => 'required|string',
            'volume' => 'required|numeric',
        ]);



        $data = [
            'bulan' => $request->input('bulan'),
            'provinsi'=>$request->input('provinsi'),
            'volume'=>$request->input('volume'),
            'updated_at'=>Carbon::now()
        ];

//        var_dump($data);die();

        DB::table('lpg_subsidi_verifieds')->where('id', $request->input('id'))->update($data);

        // Return a response or redirect
        return redirect()->back()->with('sweet_success', 'Data has been update successfully!');
    }

    public function delete($id){
        $item = DB::table('lpg_subsidi_verifieds')->where('id',$id)->delete();

        if (!$item) {
            return response()->json(['message' => 'Item not found.'], 404);
        }
        return response()->json(['message' => 'Item deleted successfully.']);
    }



    public function storekuota(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'bulan' => 'required|date',
            'provinsi' => 'required|string',
            'volume' => 'required|numeric',
        ]);



        $data = [
            'tahun' => $request->input('bulan'),
            'provinsi'=>$request->input('provinsi'),
            'kabupaten_kota'=>$request->input('kabkot'),
            'volume'=>$request->input('volume'),
            'created_at'=>Carbon::now()
        ];

//        var_dump($data);die();

        DB::table('kuota_lpg_subsidis')->insert($data);

        // Return a response or redirect
        return redirect()->back()->with('sweet_success', 'Data has been stored successfully!');
    }
    public function updatekuota(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'bulan' => 'required|date',
            'provinsi' => 'required|string',
            'volume' => 'required|numeric',
        ]);



        $data = [
            'tahun' => $request->input('bulan'),
            'provinsi'=>$request->input('provinsi'),
            'kabupaten_kota'=>$request->input('kabkot'),
            'volume'=>$request->input('volume'),
            'updated_at'=>Carbon::now()
        ];

//        var_dump($data);die();

        DB::table('kuota_lpg_subsidis')->where('id', $request->input('id'))->update($data);

        // Return a response or redirect
        return redirect()->back()->with('sweet_success', 'Data has been update successfully!');
    }

    public function deletekuota($id){
        $item = DB::table('kuota_lpg_subsidis')->where('id',$id)->delete();

        if (!$item) {
            return response()->json(['message' => 'Item not found.'], 404);
        }
        return response()->json(['message' => 'Item deleted successfully.']);
    }

    public function getKabkot($id)
    {
        $kabkot = DB::table('t_kabkot')->where('ID_PROVINSI', $id)->get();

        return response()->json($kabkot);
    }



}
