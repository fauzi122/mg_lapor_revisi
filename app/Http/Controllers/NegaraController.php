<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Negara;
use Illuminate\Support\Facades\DB;


class NegaraCOntroller extends Controller
{
    public function index()
    {

      $negara = DB::select("select * from negaras");
      return view('admin.master.negara.index', ['negara' => $negara,]);
    }
    public function create()
    {
        return view('admin.master.negara.create');
    }
    public function store(Request $request)
    {
      $pesan = [
        'id_negara.required' => 'id negara masih kosong',
        'nm_negara.required' => 'nama negara masih kosong',
        
      ];

      $validatedData = $request->validate([
        'id_negara' => 'required',
        'nm_negara' => 'required',
      ], $pesan);

      // Sanitasi Input
    $sanitizedData = fullySanitizeInput($validatedData);

    Negara::create($sanitizedData);
        return redirect('/master/negara')->with(['success' => 'Data berhasil ditambahkan']);

    }
    public function edit($id)
    {
        $negara = Negara::where('id', $id)->first();
        return view('admin.master.negara.edit', [
          'negara' => $negara
        ]);
    }
    public function update(Request $request, $id)
    {
      $negara = $id;
      $pesan = [
        'id_negara.required' => 'Id Negara masih kosong',
        'nm_negara.required' => 'Nama Negara masih kosong',
      ];

      $rules = [
        'id_negara' => 'required',
        'nm_negara' => 'required',

      ];

      $validatedData = $request->validate($rules, $pesan);

      // Sanitasi Input
    $sanitizedData = fullySanitizeInput($validatedData);

    Negara::where('id', $negara)
      ->update($sanitizedData);
      return redirect('/master/negara')->with(['success' => 'Data berhasil diupdate']);
    }
    public function destroy(Request $request, $id)
    {
      // dd($id);
      Negara::destroy($id);
      return redirect('/master/negara')->with(['success' => 'Data berhasil dihapus']);
    }
    
}
