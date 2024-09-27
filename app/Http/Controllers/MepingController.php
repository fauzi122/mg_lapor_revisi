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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $meping = Meping::where('id_induk_izin', $id)->get();
        return view('admin.master.meping.index', compact('meping'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
