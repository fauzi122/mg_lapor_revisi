<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Support\Facades\DB;
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

    $sanitizedData = fullySanitizeInput($validatedData);

    Jabatan::create($sanitizedData);
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

    $sanitizedData = fullySanitizeInput($validatedData);

    $update = Jabatan::where('id', $jabatan)->firstOrFail();
    $update->update($sanitizedData);
      return redirect('/master/jabatan')->with(['success' => 'Data berhasil diupdate']);
    }

    public function destroy(Request $request, $id)
    {
      // Cek apakah id intake_kilang masih digunakan di tabel produks
      $isUsed = DB::table('profil_admins')->where('id_jabatan', $id)->exists();


      // Jika masih digunakan, batalkan penghapusan dan tampilkan pesan
      if ($isUsed) {
        return redirect('/master/jabatan')->with([
          'sweet_error' => 'Data tidak dapat dihapus karena masih digunakan di tabel produks'
        ]);
      }

      // Jika tidak digunakan, hapus data
      Jabatan::destroy($id);

      return redirect('/master/jabatan')->with([
        'success' => 'Data berhasil dihapus'
      ]);
    }
}
