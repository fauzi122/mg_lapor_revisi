<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjualan_lpg;
use App\Models\PasokanLPG;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Crypt;
use App\Imports\Importlpgpenjualan;
use App\Imports\Importlpgpasok;


class LpgController extends Controller
{

  public function index()
  {
    $lpgpenjualan = DB::table('penjualan_lpgs')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();

    $lpgasok = DB::table('pasokan_l_p_g_s')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();

    return view('badan_usaha.niaga.lpg.index', compact(
      'lpgpenjualan',
      'lpgasok'
    ));
  }

  public function simpan_Penjualan_Ho()
  {
    // Implementasi fungsi simpan_Penjualan_Ho()
  }

  public function show_lpg($id, $lpg)
  {
    $lpgx = $lpg;
    $pecah = explode(',', Crypt::decryptString($id));
    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $bulan_ambil_penjualan_lpg = DB::table('penjualan_lpgs')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->first();

    $bulan_ambil_pasok_lpg = DB::table('pasokan_l_p_g_s')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->first();

    // Mengambil substring dari bulan
    $bulan_ambil_penjualan_lpgx = $bulan_ambil_penjualan_lpg ? substr($bulan_ambil_penjualan_lpg->bulan, 0, 7) : '';
    $statuspenjualan_lpgx = $bulan_ambil_penjualan_lpg->status ?? '';

    $bulan_ambil_pasok_lpgx = $bulan_ambil_pasok_lpg ? substr($bulan_ambil_pasok_lpg->bulan, 0, 7) : '';
    $statuspasok_lpgx = $bulan_ambil_pasok_lpg->status ?? '';

    $lpgs = Penjualan_lpg::where([
      'bulan' => $pecah[0],
      'badan_usaha_id' => $pecah[1]
    ])->orderBy('status', 'desc')->get();

    $pasokan = PasokanLPG::where([
      'bulan' => $pecah[0],
      'badan_usaha_id' => $pecah[1]
    ])->orderBy('status', 'desc')->get();

    $produk = Produk::get();

    return view('badan_usaha.niaga.lpg.show', compact(
      'lpgs',
      'pasokan',
      'produk',
      'bulan_ambil_penjualan_lpgx',
      'bulan_ambil_pasok_lpgx',
      'statuspenjualan_lpgx',
      'statuspasok_lpgx',
      'lpgx'
    ));
  }

  public function simpan_lpg(Request $request)
  {
    // echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'kemasan.required' => 'kemasan masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'kemasan' => 'required',
      'volume' => 'required',
      'satuan' => 'required',
      'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    // echo json_encode($request->all());exit;

    // $simpan = Penjualan_lpg::create($request->all());
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    // dd($badan_usaha_id);
    // exit();
    $cekdb = DB::table('penjualan_lpgs')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb);
    // exit();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $simpan = Penjualan_lpg::create($validatedData);

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
    $data['sektor'] = DB::select("SELECT sektors.id, sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
    $data['find'] = Penjualan_lpg::find($id);
    return response()->json(['data' => $data]);

    // $data = Penjualan_lng::find($id);
    // return response()->json(['data' => $data]);
  }

  public function importlpgx(Request $request)
  {
    $bulan = $request->bulan . "-01";
    // dd($bulan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $cekdb = DB::table('penjualan_lpgs')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $import = Excel::import(new Importlpgpenjualan($bulan), request()->file('file'));

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
  public function importlpg_pasokx(Request $request)
  {
    $bulan = $request->bulan . "-01";
    // dd($bulan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $cekdb = DB::table('pasokan_l_p_g_s')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $import = Excel::import(new Importlpgpasok($bulan), request()->file('file'));

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
    //echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'id.required' => 'id masih kosong',
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
      //'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      // 'id' => 'required',
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
      //'status' => 'required',
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

  public function get_produk(Request $request)
  {
    $where = $request->get('jenis_komuditas');
    if ($where <> '') {
      $data = DB::select("SELECT produks.name FROM produks WHERE produks.jenis_komuditas = '$where' GROUP BY produks.name");
    } else {
      $data = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    }
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
    $data = DB::select("SELECT provinces.id, provinces.name FROM provinces ORDER BY provinces.name ASC");
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
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'nama_pemasok.required' => 'nama_pemasok masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'nama_pemasok' => 'required',
      'kategori_pemasok' => 'required',
      'volume' => 'required',
      'satuan' => 'required',
      'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    // echo json_encode($request->all());exit;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pasokan_l_p_g_s')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

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
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'nama_pemasok.required' => 'nama_pemasok masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'status.required' => 'status masih kosong',
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
      'status' => 'required',
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

  public function submit_penjualan_lpg(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('penjualan_lpgs')->where('id', $id)->update(['status' => "1"]);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dikirim');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal dikirim');
      return back();
    }
  }
  public function submit_bulan_penjualan_lpgx(Request $request, $bulan)
  {
    $bulanx = $bulan;
    // dd($bulanx);
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("update penjualan_lpgs set status='1' where bulan='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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

  public function submit_pasokan_lpg(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('pasokan_l_p_g_s')->where('id', $id)->update(['status' => "1"]);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dikirim');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal dikirim');
      return back();
    }
  }
  public function submit_bulan_pasokan_lpgx(Request $request, $bulan)
  {
    $bulanx = $bulan;
    // dd($bulanx);
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("update pasokan_l_p_g_s set status='1' where bulan='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
  public function hapus_bulan_lpg(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM penjualan_lpgs WHERE badan_usaha_id='$badan_usaha_id' AND bulan='$bulanx'");
    // pengangkutan_minyakbumi::destroy($bulan);
    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dihapus');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal dihapus');
      return back();
    }
  }
  public function hapus_bulan_pasokanLPG(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM pasokan_l_p_g_s WHERE badan_usaha_id='$badan_usaha_id' AND bulan='$bulanx'");
    // pengangkutan_minyakbumi::destroy($bulan);
    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dihapus');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal dihapus');
      return back();
    }
  }
}
