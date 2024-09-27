<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjualan_lpg;
use App\Models\PasokanLPG;
use Illuminate\Support\Facades\DB;
use App\Imports\Importjualhasil;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Izin;
use App\Model\province;

class LpgController extends Controller
{

  public function index()
  {
    $izin = Izin::join('badan_usahas', 'izins.badan_usaha_id', "=", 'badan_usahas.id')
      ->select(
        'badan_usahas.id',
        'badan_usahas.nama_badan_usaha',
        'badan_usahas.npwp',
        'izins.key',
        'izins.tgl_ajuan_izin',
        'jenis_izin'
      )
      ->where('badan_usahas.id', Auth::user()->badan_usaha_id)
      ->get();

    return view('badan_usaha.niaga.lpg.index', compact('izin'));
  }

  public function simpan_Penjualan_Ho()
  {
    // Implementasi fungsi simpan_Penjualan_Ho()
  }

  public function show_lpg()
  {
    $lpgs = DB::select("SELECT * FROM penjualan_lpgs");
    $pasokan = PasokanLPG::get();
    $produk = Produk::get();

    return view('badan_usaha.niaga.lpg.show', compact(
      'lpgs',
      'pasokan',
      // 'hargabbmjbu',
      'produk'
    ));
  }

  public function simpan_lpg(Request $request)
  {
    // $pesan = [
    //   'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
    //   'izin_id.required' => 'izin_id masih kosong',
    //   'bulan.required' => 'bulan masih kosong',
    //   'produk.required' => 'produk masih kosong',
    //   'provinsi.required' => 'provinsi masih kosong',
    //   'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
    //   'sektor.required' => 'sektor masih kosong',
    //   'volume.required' => 'volume masih kosong',
    //   'satuan.required' => 'satuan masih kosong',
    //   'status.required' => 'status masih kosong',
    //   'catatan.required' => 'catatan masih kosong',
    //   'petugas.required' => 'petugas masih kosong',
    // ];

    // $validatedData = $request->validate([
    //   'badan_usaha_id' => 'required',
    //   'izin_id' => 'required',
    //   'bulan' => 'required',
    //   'produk' => 'required',
    //   'provinsi' => 'required',
    //   'kabupaten_kota' => 'required',
    //   'sektor' => 'required',
    //   'volume' => 'required',
    //   'satuan' => 'required',
    //   'status' => 'required',
    //   'catatan' => 'required',
    //   'petugas' => 'required',
    // ], $pesan);

    // echo json_encode($request->all());exit;

    $simpan = Penjualan_lpg::create($request->all());

    if ($simpan) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function hapus_lpg(Request $request, $id)
  {
    Penjualan_lpg::destroy($id);
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

  public function edit($id)
  {
    $show_lpg = Penjualan_lpg::find($id);
    return response()->json([
      'data' => $show_lpg
    ]);
  }

  public function get_penjualan_lpg($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
    $data['find'] = Penjualan_lpg::find($id);
    return response()->json(['data' => $data]);

    // $data = Penjualan_lng::find($id);
    // return response()->json(['data' => $data]);
  }

  public function importjholbx()
  {
    $import = Excel::import(new Importjualhasil, request()->file('file'));

    if ($import) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data excel berhasil diupload');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data excel gagal diupload');
      return back();
    }
  }

  public function update_lpg(Request $request, $id)
  {
    $id_lpg = $id;
    // echo json_encode($request->all());exit;
    $pesan = [
      'id.required' => 'id masih kosong',
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'kemasan.required' => 'kemasan masih kosong',
      'volume.required' => 'volume masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'id' => 'required',
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'kemasan' => 'required',
      'volume' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',

    ];

    $validatedData = $request->validate($rules, $pesan);

    $update = Penjualan_lpg::where('id', $id_lpg)
      ->update($validatedData);

    if ($update) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function get_produk()
  {

    $data = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function get_satuan($name)
  {
    $data = DB::select("SELECT produks.satuan FROM produks WHERE produks.name = '$name'");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function get_provinsi()
  {
    $data = DB::select("SELECT provinces.id, provinces.name FROM provinces");
    // $data = province::get();
    return response()->json(['data' => $data]);
  }

  // public function get_kota($id_prov)
  // {
  //   $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.id_prov = '$id_prov'");
  //   // $data = Produk::get();
  //   return response()->json(['data' => $data]);
  // }

  public function get_kota($kabupaten_kota)
  {
    // $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.kabupaten_kota = '$kabupaten_kota'");
    $data = DB::select("SELECT kotas.`nama_kota` FROM  kotas WHERE kotas.`id_prov` = (SELECT kotas.`id_prov` FROM kotas WHERE kotas.`nama_kota` = '$kabupaten_kota')");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function simpan_pasokanLPG(Request $request)
  {
    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'nama_pemasok.required' => 'nama_pemasok masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'nama_pemasok' => 'required',
      'kategori_pemasok' => 'required',
      'volume' => 'required',
      'satuan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    // echo json_encode($request->all());exit;

    $simpan = PasokanLPG::create($validatedData);

    if ($simpan) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function hapus_pasokanLPG(Request $request, $id)
  {
    PasokanLPG::destroy($id);
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

  public function getPasokanLPG($id)
  {
    $data['find'] = PasokanLPG::find($id);
    return response()->json(['data' => $data]);
  }

  public function update_pasokanLPG(Request $request, $id)
  {
    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'nama_pemasok.required' => 'nama_pemasok masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
       // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'nama_pemasok' => 'required',
      'kategori_pemasok' => 'required',
      'volume' => 'required',
      'satuan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    $update = PasokanLPG::where('id', $id)
      ->update($validatedData);

    if ($update) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }
}
