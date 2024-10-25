<?php

namespace App\Http\Controllers\Evaluator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\province;
use App\Models\lpg_subsidi_verified;
use App\Models\kuota_lpg_subsidi;
use Illuminate\Support\Facades\DB;
use Random\CryptoSafeEngine;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Importsubsidi;
use App\Imports\Importsubsidikuota;


class SubsidiLpg extends Controller
{
    public function index(){

        $provinsi=province::get();
        $lpg_subsidi= lpg_subsidi_verified::get();
        return view('evaluator.subsidi_lpg.lpg_subsidi.index', compact('lpg_subsidi','provinsi'));
 
    }


    public function index_kuota(){
        $provinsi=province::get();
        $lpg_subsidi=kuota_lpg_subsidi::get();
        return view('evaluator.subsidi_lpg.kuota_subsidi.index', compact('lpg_subsidi','provinsi'));

    }

    public function getKabkot($provinsi)
    {
        $kabkot = DB::table('t_kabkot')
                    ->join('t_provinsi', 't_provinsi.ID_PROVINSI', '=', 't_kabkot.ID_PROVINSI')
                    ->where('t_provinsi.NAMA_PROVINSI', $provinsi)
                    ->select('t_kabkot.NAMA_KABKOT')
                    ->get();
    
        return response()->json($kabkot);
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

//      
        DB::table('lpg_subsidi_verifieds')->insert($data);

        // Return a response or redirect
        return redirect()->back()->with('sweet_success', 'Data has been stored successfully!');
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
      
            $validated = $request->validate([
                'bulan' => 'required',
                'provinsi' => 'required',
                'kabkot' => 'required',
                'volume' => 'required|numeric|min:0',
            ]);
    
            // Assuming you have a model to store the form data
            $kuota = new kuota_lpg_subsidi();
            $kuota->tahun = $validated['bulan'];
            $kuota->provinsi = strtoupper($validated['provinsi']); 
            $kuota->kabupaten_kota = strtoupper($validated['kabkot']); 
            $kuota->volume = $validated['volume'];
            $kuota->save();
    
        // Return a response or redirect
        return redirect()->back()->with('sweet_success', 'Data has been stored successfully!');
    }

    public function update(Request $request, $id)
    {

        // dd($request);
        $validated = $request->validate([
            'bulan' => 'required',
            'provinsi' => 'required',
            'volume' => 'required|numeric|min:0',
        ]);

        // Cari data berdasarkan ID
        $kuota = lpg_subsidi_verified::findOrFail($id);

        // Update data
        $defaultTanggal = $validated['bulan'] . '-01'; 
        $kuota->bulan = $defaultTanggal;
        $kuota->provinsi = $validated['provinsi']; // Simpan provinsi dalam huruf kapital
        $kuota->volume = $validated['volume'];

        $kuota->save(); // Simpan perubahan

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
    public function updatekuota(Request $request, $id)
    {
        $validated = $request->validate([
            'bulan' => 'required',
            'provinsi' => 'required',
            'kabkot' => 'required',
            'volume' => 'required|numeric|min:0',
        ]);
    
        // Cari data berdasarkan ID
        $kuota = kuota_lpg_subsidi::findOrFail($id);
    
        // Update data
        $defaultTanggal = $validated['bulan'] . '-01';  // Use validated 'bulan'
        $kuota->tahun = $defaultTanggal;
        $kuota->provinsi = $validated['provinsi']; // Convert to uppercase
        $kuota->kabupaten_kota = $validated['kabkot']; // Convert to uppercase
        $kuota->volume = $validated['volume'];
    
        $kuota->save(); // Simpan perubahan
    
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
    

    public function deletekuota($id){
        $item = DB::table('kuota_lpg_subsidis')->where('id',$id)->delete();

        if (!$item) {
            return response()->json(['message' => 'Item not found.'], 404);
        }
        return response()->json(['message' => 'Item deleted successfully.']);
    }



    public function storeSubsidi_excel(Request $request)
    {
        // Validate the uploaded file type
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        // Check if the file was uploaded
        if ($request->hasFile('file')) {
            $set = [
                'bulan' => $request->input('bulan'),
                'petugas' => auth()->user()->email,
            ];
            $file = $request->file('file'); // Retrieve the uploaded file
    
            // Create an instance of the import with settings
            $import = new Importsubsidi($set);
            Excel::import($import, $file); // Import the file
    
            // If import is successful, send a notification
            return redirect()->back()->with('success', 'Upload Soal Pilihan Ganda Berhasil.');
        }
    
        // If no file was selected
        return redirect()->back()->with('error', 'Mohon pilih file terlebih dahulu.');
    }

    public function storekuota_excel(Request $request)
    {
        // Validate the uploaded file type
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        // Check if the file was uploaded
        if ($request->hasFile('file')) {
            $set = [
                'tahun' => $request->input('tahun'),
                'petugas' => auth()->user()->email,
            ];
            $file = $request->file('file'); // Retrieve the uploaded file
    
            // Create an instance of the import with settings
            $import = new Importsubsidikuota($set);
            Excel::import($import, $file); // Import the file
    
            // If import is successful, send a notification
            return redirect()->back()->with('success', 'Upload Soal Pilihan Ganda Berhasil.');
        }
    
        // If no file was selected
        return redirect()->back()->with('error', 'Mohon pilih file terlebih dahulu.');
    }
    
    
}
