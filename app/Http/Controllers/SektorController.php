<?php

namespace App\Http\Controllers;

use App\Models\Sektor;
use Illuminate\Http\Request;

class SektorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sektor = Sektor::get();
        return view('admin.master.sektor.index', compact('sektor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.master.sektor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pesan = [
            'nama_sektor.required' => 'Nama sektor tidak boleh kosong'
        ];

        $validatedData = $request->validate([
            'nama_sektor' => 'required'
        ], $pesan);

        $sanitizedData = fullySanitizeInput($validatedData);

        Sektor::create($sanitizedData);

        return redirect('/master/sektor')->with(['success' => 'Data berhasil ditambahkan']);
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
        $sektor = Sektor::where('id', $id)->first();
        return view('admin.master.sektor.edit', compact('sektor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sektor = $id;
        $pesan = [
            'nama_sektor.required' => 'Nama Sektor masih kosong',
            
        ];
        $rules = [
            'nama_sektor' => 'required',
        ];
        $validatedData = $request->validate($rules, $pesan);

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        $update = Sektor::where('id', $sektor)->firstOrFail();
        $update->update($sanitizedData);
        return redirect('/master/sektor')->with(['success' => 'Data berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Sektor::destroy($id);
        return redirect('/master/sektor')->with(['success' => 'Data berhasil dihapus']);
    }
}
