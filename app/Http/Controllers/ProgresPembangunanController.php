<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\ProgresPembangunan;

class ProgresPembangunanController extends Controller
{
  public function show_izinSementara()
  {
    $ProgresPembangunan = ProgresPembangunan::get();
    return view('badan_usaha.progres_pembangunan.show', compact(
      'ProgresPembangunan',
    ));
  }

  public function simpan_izinSementara(Request $request)
  {
    // dd($request->file());exit;
    // dd($request->all());exit;
    // $request->validate([
    //   'matrik_bobot_pembangunan' => 'required|mimes:doc,docx,dot,pdf|max:2048',
    //   'bukti_progres_pembangunan' => 'required|mimes:doc,docx,dot,pdf|max:2048',
    // ]);
    // echo json_encode($request->badan_usaha_id);exit;

    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',

      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'prosentase_pembangunan' => 'required',
      'realisasi_investasi' => 'required',
      'matrik_bobot_pembangunan' => 'required|mimes:doc,docx,dot,pdf|max:2048',
      'bukti_progres_pembangunan' => 'required|mimes:doc,docx,dot,pdf|max:2048',
      'tkdn' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ], $pesan);

    $name_matrik = $request->file('matrik_bobot_pembangunan')->getClientOriginalName();
    $path_matrik = $request->file('matrik_bobot_pembangunan')->store('public/izin_sementara/matrik');
    $name_bukti = $request->file('bukti_progres_pembangunan')->getClientOriginalName();
    $path_bukti = $request->file('bukti_progres_pembangunan')->store('public/izin_sementara/bukti');

    $simpan = ProgresPembangunan::create([
      'badan_usaha_id' => $request->badan_usaha_id,
      'izin_id' => $request->izin_id,
      'prosentase_pembangunan' => $request->prosentase_pembangunan,
      'realisasi_investasi' => $request->realisasi_investasi,
      'matrik_bobot_pembangunan' => $name_matrik,
      'path_matrik_bobot_pembangunan' => $path_matrik,
      'bukti_progres_pembangunan' => $name_bukti,
      'path_bukti_progres_pembangunan' => $path_bukti,
      'tkdn' => $request->tkdn,
      'status' => $request->status,
      'catatan' => $request->catatan,
      'petugas' => $request->petugas,
    ]);

    if ($simpan) {
      // $name = $request->file('matrik_bobot_pembangunan')->getClientOriginalName();
      // $path = $request->file('matrik_bobot_pembangunan')->store('public/izin_sementara/matrik');

      // $save = new ProgresPembangunan;
      // $save->matrik_bobot_pembangunan = $name;
      // $save->path_matrik_bobot_pembangunan = $path;
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    }

    // echo json_encode($request->all());
    // exit;
    // $request->merge([
    //     'bulan' => $request->bulan . '-01',
    // ]);

    // $pesan = [
    //     'bulan.required' => 'bulan masih kosong',
    //     'provinsi.required' => 'provinsi masih kosong',
    //     'volume.required' => 'volume masih kosong',
    //     'jenis.required' => 'jenis masih kosong',
    // ];

    // $validatedData = $request->validate([
    //     'bulan' => 'required',
    //     'provinsi' => 'required',
    //     'volume' => 'required',
    //     'jenis' => 'required',
    // ], $pesan);

    // Subsidilpg::create($validatedData);

    // if ($validatedData) {
    //     //redirect dengan pesan sukses
    //     Alert::success('Success', 'Data berhasil ditambahkan');
    //     return back();
    // } else {
    //     //redirect dengan pesan error
    //     Alert::error('Error', 'Data gagal ditambahkan');
    //     return back();
    // }
  }

  public function hapus_lgpsubx(Request $request, $id)
  {
    Subsidilpg::destroy($id);
    if ($id) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dihapus');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal dihapus');
      return back();
    }
  }

  public function submit_lgpsubx(Request $request, $id)
  {
    $idx = $id;
    $validatedData = DB::update("update subsidilpgs set status='1' where id='$idx'");

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil dikirim');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal dikirim');
      return back();
    }
  }

  public function get_lgpsub($id)
  {
    $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
    $data['find'] = Subsidilpg::find($id);
    return response()->json(['data' => $data]);
  }

  public function update_lgpsubx(Request $request, $id)
  {
    $lgpsub = $id;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);
    $pesan = [
      'bulan.required' => 'bulan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'volume.required' => 'volume masih kosong',
      'jenis.required' => 'jenis masih kosong',
    ];

    $rules = [
      'bulan' => 'required',
      'provinsi' => 'required',
      'volume' => 'required',
      'jenis' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    Subsidilpg::where('id', $lgpsub)
      ->update($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal diupdate');
      return back();
    }
  }
}
