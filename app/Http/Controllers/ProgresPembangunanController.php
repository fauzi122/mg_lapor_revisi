<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\ProgresPembangunan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class ProgresPembangunanController extends Controller
{
  public function show_izinSementara($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));

    // Code lama
    // $ProgresPembangunan = ProgresPembangunan::get();

    $ProgresPembangunan = ProgresPembangunan::where('npwp', Auth::user()->npwp)
    ->where('id_permohonan', $pecah[0])
    ->where('id_sub_page', $pecah[2])
    ->get();
    // return view('badan_usaha.progres_pembangunan.show', compact(
    return view('badanUsaha.progres_pembangunan.show', compact(
      'ProgresPembangunan',
      'pecah'
    ));
  }

  public function hapus_izinSementara(Request $request, $id) 
  {
    try {
      ProgresPembangunan::destroy($id);

      Alert::success('success', 'Data berhasil dihapus');
      return back();
    } catch (\Throwable $th) {
      //throw $th;
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal dihapus');
      return back();
    }
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
      'npwp.required' => 'npwp masih kosong',
      'id_permohonan.required' => 'id_permohonan masih kosong',
      'id_sub_page.required' => 'id_sub_page masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'npwp' => 'required',
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
      'prosentase_pembangunan' => 'required',
      'realisasi_investasi' => 'required',
      'matrik_bobot_pembangunan' => 'required|mimes:doc,docx,dot,pdf|max:2048',
      'bukti_progres_pembangunan' => 'required|mimes:doc,docx,dot,pdf|max:2048',
      'tkdn' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $tgl = Carbon::now();
    // 3. Upload matrik
    $validatedData['matrik_bobot_pembangunan'] = $request->file('matrik_bobot_pembangunan')->getClientOriginalName();
    $validatedData['path_matrik_bobot_pembangunan'] = simpanDokumenBu($tgl, $request->file('matrik_bobot_pembangunan'), "pp");

    // 3. Upload Bukti
    $validatedData['bukti_progres_pembangunan'] = $request->file('bukti_progres_pembangunan')->getClientOriginalName();
    $validatedData['path_bukti_progres_pembangunan'] = simpanDokumenBu($tgl, $request->file('bukti_progres_pembangunan'), "pp");

    // 5. Sanitasi
    $sanitizedData = fullySanitizeInput($validatedData);

    // $name_matrik = $request->file('matrik_bobot_pembangunan')->getClientOriginalName();
    // $path_matrik = $request->file('matrik_bobot_pembangunan')->store('public/izin_sementara/matrik');
    // $name_bukti = $request->file('bukti_progres_pembangunan')->getClientOriginalName();
    // $path_bukti = $request->file('bukti_progres_pembangunan')->store('public/izin_sementara/bukti');

    $simpan = ProgresPembangunan::create($sanitizedData);

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

  public function update_izinSementara(Request $request, $id)
  {
    $pesan = [
      'npwp.required' => 'npwp masih kosong',
      'id_permohonan.required' => 'id_permohonan masih kosong',
      'id_sub_page.required' => 'id_sub_page masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'npwp' => 'required',
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
      'prosentase_pembangunan' => 'required',
      'realisasi_investasi' => 'required',
      'matrik_bobot_pembangunan' => 'mimes:doc,docx,dot,pdf|max:2048',
      'bukti_progres_pembangunan' => 'mimes:doc,docx,dot,pdf|max:2048',
      'tkdn' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $tgl = Carbon::now();

    if ($request->hasFile('matrik_bobot_pembangunan')) {
      $validatedData['matrik_bobot_pembangunan'] = $request->file('matrik_bobot_pembangunan')->getClientOriginalName();
      $validatedData['path_matrik_bobot_pembangunan'] = simpanDokumenBu($tgl, $request->file('matrik_bobot_pembangunan'), "pp");
    }
    if ($request->hasFile('bukti_progres_pembangunan')) {
      $validatedData['bukti_progres_pembangunan'] = $request->file('bukti_progres_pembangunan')->getClientOriginalName();
      $validatedData['path_bukti_progres_pembangunan'] = simpanDokumenBu($tgl, $request->file('bukti_progres_pembangunan'), "pp");
    }

    $sanitizedData = fullySanitizeInput($validatedData);

    $updated = ProgresPembangunan::findOrFail($id);
    $updated->update($sanitizedData);

    if ($updated) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal diupdate');
      return back();
    }
  }

  public function submit_izinSementara(Request $request, $id)
  {
    $now = Carbon::now();

    $validatedData = ProgresPembangunan::findOrFail($id);
    $validatedData->update([
        'status' => '1',
        'tgl_kirim' => $now
    ]);

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

  public function get_izinSementara($id)
  {
    $data['find'] = ProgresPembangunan::findOrFail($id);

    return response()->json(['data' => $data]);
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
