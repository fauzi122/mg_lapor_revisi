<?php

namespace App\Http\Controllers;

use App\Models\IzinUsaha;
use Illuminate\Http\Request;

class IzinUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $IzinUsaha = IzinUsaha::get();
        return view('admin.master.izin_usaha.index', compact('IzinUsaha'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.master.izin_usaha.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pesan = [
            'id_sub_page.required' => 'id sub page masih kosong',
            'id_sub_page.unique' => 'Id Sub Page telah digunakan',
            'id_template.required' => 'id template masih kosong',
            'jenis_izin.required' => 'Jenis Izin masih kosong',
            'nama_opsi.required' => 'Nama Opsi masih kosong',
            'id_ref.required' => 'Id Ref masih kosong',
            'jenis.required' => 'Jenis masih kosong',
            'kategori_izin.max' => 'Jenis maksimal 1 karakter',
            'kategori_izin.required' => 'Kategori Izin masih kosong',
        ];

        $validatedData = $request->validate([
            'id_sub_page' => 'required|unique:izin_usaha,id_sub_page',
            'id_template' => 'required',
            'jenis_izin' => 'required',
            'nama_opsi' => 'required',
            'id_ref' => 'required',
            'jenis' => 'required',
            'kategori_izin' => 'required|max:1',
        ], $pesan);

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        IzinUsaha::create($sanitizedData);

        return redirect('/master/izin-usaha')->with(['success' => 'Data berhasil ditambahkan']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $IzinUsaha = IzinUsaha::where('id', $id)->first();
        return view('admin.master.izin_usaha.edit', compact('IzinUsaha'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $IzinUsaha = $id;
        $pesan = [
            'id_sub_page.required' => 'id sub pahe masih kosong',
            'id_sub_page.unique' => 'Id Sub Page telah digunakan',
            'id_template.required' => 'id template masih kosong',
            'jenis_izin.required' => 'Jenis Izin masih kosong',
            'nama_opsi.required' => 'Nama Opsi masih kosong',
            'id_ref.required' => 'Id Ref masih kosong',
            'jenis.required' => 'Jenis masih kosong',
            'kategori_izin.max' => 'Jenis maksimal 1 karakter',
            'kategori_izin.required' => 'Kategori Izin masih kosong',
        ];

        $rules = [
            'id_sub_page' => 'required|unique:izin_usaha,id_sub_page,' . $id,
            'id_template' => 'required',
            'jenis_izin' => 'required',
            'nama_opsi' => 'required',
            'id_ref' => 'required',
            'jenis' => 'required',
            'kategori_izin' => 'required|max:1',
        ];

        $validatedData = $request->validate($rules, $pesan);

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        $update = IzinUsaha::where('id', $IzinUsaha)->firstOrFail();
        $update->update($sanitizedData);
        return redirect('/master/izin-usaha')->with(['success' => 'Data berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        IzinUsaha::destroy($id);
        return redirect('/master/izin-usaha')->with(['success' => 'Data berhasil dihapus']);
    }
}
