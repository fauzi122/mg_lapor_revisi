<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Intake_Kilang;
use Illuminate\Support\Facades\DB;


class IntakeCOntroller extends Controller
{
    public function index()
    {

      $intake = DB::select("select * from intake_kilangs");
      return view('admin.master.intake.index', ['intake' => $intake,]);
    }
    public function create()
    {
        return view('admin.master.intake.create');
    }
    public function store(Request $request)
    {
  
      $pesan = [
        'nm_produk.required' => 'nama produk masih kosong',
        'satuan.required' => 'satuan masih kosong',
        
      ];

      $validatedData = $request->validate([
        'nm_produk' => 'required',
        'satuan' => 'required',
      ], $pesan);

      // Sanitasi Input
    $sanitizedData = fullySanitizeInput($validatedData);

    Intake_Kilang::create($sanitizedData);
        return redirect('/master/intake_kilangs')->with(['success' => 'Data berhasil ditambahkan']);

    }
    public function edit($id)
    {
        $intake = Intake_Kilang::where('id', $id)->first();
        return view('admin.master.intake.edit', [
          'intake' => $intake
        ]);
    }
    public function update(Request $request, $id)
    {
      $intake = $id;
      $pesan = [
        'nm_produk.required' => 'nama produk masih kosong',
        'satuan.required' => 'satuan masih kosong',
      ];

      $rules = [
        'nm_produk' => 'required',
        'satuan' => 'required',

      ];

      $validatedData = $request->validate($rules, $pesan);

      // Sanitasi Input
    $sanitizedData = fullySanitizeInput($validatedData);

    $update = Intake_Kilang::where('id', $intake)->firstOrFail();
    $update->update($sanitizedData);
      return redirect('/master/intake_kilangs')->with(['success' => 'Data berhasil diupdate']);
    }
    public function destroy(Request $request, $id)
    {
      // dd($id);
      Intake_Kilang::destroy($id);
      return redirect('/master/intake_kilangs')->with(['success' => 'Data berhasil dihapus']);
    }
    
}
