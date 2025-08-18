<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Port;
use Illuminate\Support\Facades\DB;


class PortCOntroller extends Controller
{
    public function index()
    {

      $port = DB::select("select * from ports");
      return view('admin.master.port.index', ['port' => $port,]);
    }
    public function create()
    {
        return view('admin.master.port.create');
    }
    public function store(Request $request)
    {
      $pesan = [
        'nm_port.required' => 'nm_port masih kosong',
        'lokasi.required' => 'lokasi masih kosong',
        
      ];

      $validatedData = $request->validate([
        'nm_port' => 'required',
        'lokasi' => 'required',
      ], $pesan);

    // Sanitasi Input
    $sanitizedData = fullySanitizeInput($validatedData);

      Port::create($sanitizedData);
        return redirect('/master/port')->with(['success' => 'Data berhasil ditambahkan']);

    }
    public function edit($id)
    {
        $port = Port::where('id', $id)->first();
        return view('admin.master.port.edit', [
          'port' => $port
        ]);
    }
    public function update(Request $request, $id)
    {
      $port = $id;
      $pesan = [
        'nm_port.required' => 'nama port masih kosong',
        'lokasi.required' => 'lokasi masih kosong',
      ];

      $rules = [
        'nm_port' => 'required',
        'lokasi' => 'required',

      ];

      $validatedData = $request->validate($rules, $pesan);
    // Sanitasi Input
    $sanitizedData = fullySanitizeInput($validatedData);

      $update = Port::where('id', $port)->firstOrFail();
      $update->update($sanitizedData);
      return redirect('/master/port')->with(['success' => 'Data berhasil diupdate']);
    }
    public function destroy(Request $request, $id)
    {
      // dd($id);
      Port::destroy($id);
      return redirect('/master/port')->with(['success' => 'Data berhasil dihapus']);
    }
    
}
