<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {

      $jabatan = Jabatan::all();
      return view('admin.master.jabatan.index', ['jabatan' => $jabatan,]);
    }

    public function create()
    {
        return view('admin.master.jabatan.create');
    }
    public function store(Request $request)
    {
      $pesan = [
        'nm_jabatan.required' => 'Nama jabatan masih kosong',
        
      ];

      $validatedData = $request->validate([
        'nm_jabatan' => 'required',
      ], $pesan);

      Jabatan::create($validatedData);
        return redirect('/master/jabatan')->with(['success' => 'Data berhasil ditambahkan']);

    }
    public function edit($id)
    {
        $jabatan = Jabatan::where('id', $id)->first();
        return view('admin.master.jabatan.edit', [
          'jabatan' => $jabatan
        ]);
    }
    public function update(Request $request, $id)
    {
      $jabatan = $id;
      $pesan = [
        'nm_jabatan.required' => 'nama jabatan masih kosong',
      ];

      $rules = [
        'nm_jabatan' => 'required',

      ];

      $validatedData = $request->validate($rules, $pesan);

      Jabatan::where('id', $jabatan)
      ->update($validatedData);
      return redirect('/master/jabatan')->with(['success' => 'Data berhasil diupdate']);
    }
    public function destroy(Request $request, $id)
    {
      // dd($id);
      Jabatan::destroy($id);
      return redirect('/master/jabatan')->with(['success' => 'Data berhasil dihapus']);
    }
}
