<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\induk_izin;
use App\Models\IzinUsaha;
use App\Models\Menu_Item;
use App\Models\Meping;
use Illuminate\Validation\Rule;

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

    public function create_JIzin($id, $jenis_izin)
    {
        
        $izin_usaha = IzinUsaha::get();

        $menu_items = Menu_Item::get();
        return view('admin.master.meping.create', compact('id', 'izin_usaha', 'jenis_izin', 'menu_items'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'izin' => 'required|string',
            'nm_izin' => 'required|string'
        ]);

        // induk_izin::create([
        //     'izin' => $validated['izin'],
        //     'nm_izin' => $validated['nm_izin']
        // ]);

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        induk_izin::create($sanitizedData);

        return redirect('/master/meping')->with('success', 'Data berhasil disimpan!');
    }

    public function store_JIzin(Request $request)
    {
        $validated = $request->validate([
            'id_sub_page' => [
                'required',
                'string',
                Rule::unique('mepings')->where(function ($query) use ($request) {
                    return $query->where('id_induk_izin', $request->id_induk_izin);
                }),
            ],
            'id_template' => 'required|string',
            'nama_opsi' => 'required|string|',
            'nama_menu' => 'required|string|',
            'kategori' => 'required|in:1,2',
            'url' => 'required|string|',
            'id_induk_izin' => 'required',
            'jenis_izin' => 'required',
            'kusus' => 'nullable|in:0,2',
        ],[
            'id_sub_page.required' => 'ID Sub Page wajib diisi.',
            'id_sub_page.unique' => 'ID Sub Page sudah digunakan.',
            'nama_menu.required' => 'Nama Menu wajib dipilih.'
        ]);
        // dd($request->all());

        // Meping::create([
        //     'id_induk_izin' => $validated['id_induk_izin'],
        //     'id_sub_page' => $validated['id_sub_page'],
        //     'id_template' => $validated['id_template'],
        //     'nama_opsi' => $validated['nama_opsi'],
        //     'nama_menu' => $validated['nama_menu'],
        //     'kategori' => $validated['kategori'],
        //     'url' => $validated['url'],
        //     'jenis_izin' => $validated['jenis_izin'],
        //     'status' => 1, // default aktif
        // ]);
        $sanitizedData = fullySanitizeInput($validated);

        Meping::create($sanitizedData);


        return redirect('/master/meping/' . $validated['id_induk_izin'] . '/show/' .$validated['jenis_izin'])
            ->with('success', 'Data berhasil ditambahkan!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id, string $jenis_izin)
    {
        $meping = Meping::where('id_induk_izin', $id)
            ->where('jenis_izin', $jenis_izin)
            ->get();
        return view('admin.master.meping.index', compact('meping', 'id', 'jenis_izin'));
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
        $meping = Meping::findOrFail($id); // data yang sedang di-edit

        $izin_usaha = IzinUsaha::get(); // untuk dropdown jenis izin
        $menu_items = Menu_Item::get(); // untuk dropdown nama menu

        $jenis_izin = $meping->jenis_izin; // ambil dari data meping yang sedang di-edit

        return view('admin.master.meping.edit', compact('meping', 'izin_usaha', 'menu_items', 'jenis_izin'));
    }


    public function update_Jizin(Request $request, string $id)
    {
        $validated = $request->validate([
            'id_sub_page' => [
                'required',
                'string',
                Rule::unique('mepings', 'id_sub_page')
                    ->where(fn($q) => $q->where('id_induk_izin', $request->id_induk_izin))
                    ->ignore($id),
            ],
            'id_template' => 'required|string',
            'nama_opsi' => 'required|string',
            'nama_menu' => 'required|string',
            'kategori' => 'required|in:1,2',
            'url' => 'required|string',
            'id_induk_izin' => 'required',
            'kusus' => 'nullable|in:0,2',
            'jenis_izin' => 'required'
        ], [
            'id_sub_page.required' => 'ID Sub Page wajib diisi.',
            'id_sub_page.unique' => 'ID Sub Page sudah digunakan.',
            'nama_menu.required' => 'Nama Menu wajib dipilih.',
        ]);

        $meping = Meping::findOrFail($id);

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validated);

        $meping->update($sanitizedData);

        return redirect('/master/meping/' . $validated['id_induk_izin'] . '/show/' . $validated['jenis_izin'])
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

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validated);

        $izin->update($sanitizedData);

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

        return redirect('/master/meping/' . $meping->id_induk_izin . '/show/'. $meping->jenis_izin)
            ->with('success', 'Data berhasil dihapus');
    }
}
