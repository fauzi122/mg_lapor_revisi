<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Inco_term;
use Illuminate\Support\Facades\DB;
class IncotermCOntroller extends Controller

{

    public function index()
    {
      $inco =Inco_term::get();
      return view('admin.master.incoterm.index', ['inco' => $inco,]);
    }
    public function create()
    {
        return view('admin.master.incoterm.create');
    }

    public function store(Request $request)
    {
      $pesan = [
        'incoterm.required' => 'incoterm masih kosong',
        'ket.required' => 'ket masih kosong',
      ];
      $validatedData = $request->validate([

        'incoterm' => 'required',

        'ket' => 'required',

      ], $pesan);
      Inco_term::create($validatedData);

        return redirect('/master/inco-term')->with(['success' => 'Data berhasil ditambahkan']);
    }

    public function edit($id)

    {
        $inco = Inco_term::where('id', $id)->first();
        return view('admin.master.incoterm.edit', [
          'inco' => $inco
        ]);
    }
    public function update(Request $request, $id)
    {
      $inco = $id;
      $pesan = [
        'incoterm.required' => 'incoterm masih kosong',
        'ket.required' => 'ket masih kosong',
      ];
      $rules = [
        'incoterm' => 'required',
        'ket' => 'required',
      ];
      $validatedData = $request->validate($rules, $pesan);
      Inco_term::where('id', $inco)
      ->update($validatedData);
      return redirect('/master/inco-term')->with(['success' => 'Data berhasil diupdate']);
    }

    public function destroy(Request $request, $id)
    {
     Inco_term::destroy($id);
      return redirect('/master/inco-term')->with(['success' => 'Data berhasil dihapus']);

    }

    

}

