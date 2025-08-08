<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {

      $produk = DB::select("select * from produks");
      return view('admin.master.produk.index', ['produk' => $produk,]);
    }
    public function create()
    {
        return view('admin.master.produk.create');
    }
    public function store(Request $request)
    {
      $pesan = [
        'name.required' => 'nama masih kosong',
        'jenis_bbm.required' => 'jenis bbm masih kosong',
        'jenis_komuditas.required' => 'jenis komuditas masih kosong',
        'satuan.required' => 'satuan masih kosong',
        'petugas.required' => 'petugas masih kosong',
        
      ];

      $validatedData = $request->validate([
        'name' => 'required',
        'jenis_bbm' => 'required',
        'jenis_komuditas' => 'required',
        'satuan' => 'required',
        'petugas' => 'required',
      ], $pesan);

      // Sanitasi Input
    $sanitizedData = fullySanitizeInput($validatedData);

    Produk::create($sanitizedData);
        return redirect('/master/produk')->with(['success' => 'Data berhasil ditambahkan']);

    }
    public function edit($id)
    {
        $produk = Produk::where('id', $id)->first();
        return view('admin.master.produk.edit', [
          'produk' => $produk
        ]);
    }
    public function update(Request $request, $id)
    {
      $produk = $id;
      $pesan = [
        'name.required' => 'nama masih kosong',
        'jenis_bbm.required' => 'jenis bbm masih kosong',
        'jenis_komuditas.required' => 'jenis komuditas masih kosong',
        'satuan.required' => 'satuan masih kosong',
        'petugas.required' => 'petugas masih kosong',
      ];

      $rules = [
        'name' => 'required',
        'jenis_bbm' => 'required',
        'jenis_komuditas' => 'required',
        'satuan' => 'required',
        'petugas' => 'required',

      ];

      $validatedData = $request->validate($rules, $pesan);

      $sanitizedData = fullySanitizeInput($validatedData);

    Produk::where('id', $produk)
      ->update($sanitizedData);
      return redirect('/master/produk')->with(['success' => 'Data berhasil diupdate']);
    }
    public function destroy(Request $request, $id)
    {
      // dd($id);
      Produk::destroy($id);
      return redirect('/master/produk')->with(['success' => 'Data berhasil dihapus']);
    }
}
