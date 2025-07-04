<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\induk_izin;
use App\Models\Meping;


class MepingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $izin = induk_izin::get();
        return view('admin.master.induk_izin.index', compact('izin'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.master.induk_izin.create');
    }

    public function create_JIzin($id)
    {
        return view('admin.master.meping.create', compact('id'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'izin' => 'required|string',
            'nm_izin' => 'required|string'
        ]);

        induk_izin::create([
            'izin' => $validated['izin'],
            'nm_izin' => $validated['nm_izin']
        ]);

        return redirect('/master/meping')->with('success', 'Data berhasil disimpan!');
    }

    public function store_JIzin(Request $request)
    {
        $validated = $request->validate([
            'id_sub_page' => 'required|string|',
            'id_template' => 'required|string|',
            'nama_opsi' => 'required|string|',
            'nama_menu' => 'required|string|',
            'kategori' => 'required|in:1,2',
            'url' => 'required|string|',
            'id_induk_izin' => 'required'
        ]);
        // dd($request->all());

        Meping::create([
            'id_induk_izin' => $validated['id_induk_izin'],
            'id_sub_page' => $validated['id_sub_page'],
            'id_template' => $validated['id_template'],
            'nama_opsi' => $validated['nama_opsi'],
            'nama_menu' => $validated['nama_menu'],
            'kategori' => $validated['kategori'],
            'url' => $validated['url'],
            'status' => 1, // default aktif
        ]);

        return redirect('/master/meping/' . $validated['id_induk_izin'] . '/show')
            ->with('success', 'Data berhasil ditambahkan!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $meping = Meping::where('id_induk_izin', $id)->get();
        return view('admin.master.meping.index', compact('meping', 'id'));
    }

    public function show_menu(string $id)
    {

        $meping = Meping::where('id_induk_izin', $id)->get();
        return view('admin.master.meping.show', compact('meping'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $izin = induk_izin::findOrFail($id);
        return view('admin.master.induk_izin.edit', compact('izin'));
    }

    public function edit_Jizin(string $id)
    {
        $meping = Meping::findOrFail($id); // ambil data izin berdasarkan id
        return view('admin.master.meping.edit', compact('meping'));
    }

    public function update_Jizin(Request $request, string $id)
    {
        $validated = $request->validate([
            'id_sub_page' => 'required|string|max:255',
            'id_template' => 'required|string|max:255',
            'nama_opsi' => 'required|string|max:255',
            'nama_menu' => 'required|string|max:255',
            'kategori' => 'required|in:1,2',
            'url' => 'required|string|max:255',
        ]);

        $meping = Meping::findOrFail($id);
        $meping->update($validated);

        return redirect('/master/meping/' . $meping->id_induk_izin . '/show')
            ->with('success', 'Data berhasil diperbarui!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'izin' => 'required|string',
            'nm_izin' => 'required|string'
        ]);

        $izin = induk_izin::findOrFail($id);

        $izin->update($validated);

        return redirect('/master/meping')->with('success', 'Data berhasil disimpan!');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        try {
            $kutipan = Meping::find($id);
            $kutipan->status = $status;
            $kutipan->save();

            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating status'], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */

    public function destroy_Dizin(string $id)
    {
        $izin = induk_izin::findOrFail($id);
        $izin->delete();

        return redirect('/master/meping')->with('success', 'Data berhasil disimpan!');
    }
    public function destroy(string $id)
    {
        $meping = Meping::findOrFail($id);
        $meping->delete();

        return redirect('/master/meping/' . $meping->id_induk_izin . '/show')
            ->with('success', 'Data berhasil dihapus');
    }
}
