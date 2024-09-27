<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\Pengolahan;
use App\Models\PengolahanMinyakBumiProduksi;
use App\Models\PengolahanMinyakBumiPasokan;
use App\Models\PengolahanMinyakBumiDistribusi;


class PengolahanController extends Controller
{
  public function index()
  {
    echo "Pengolahan";
  }

  public function show_mb_ho()
  {
    $pengolahanProduksiMB = Pengolahan::where("jenis", "=", "Minyak Bumi")
    ->where("tipe", "=", "Produksi")
    ->where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();

    $pengolahanPasokanMB = Pengolahan::where("jenis", "=", "Minyak Bumi")
    ->where("tipe", "=", "Pasokan")
    ->where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();

    $pengolahanDistribusiMB = Pengolahan::where("jenis", "=", "Minyak Bumi")
    ->where("tipe", "=", "Distribusi")
    ->where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();

    return view('badan_usaha.pengolahan.minyak_bumi.show', compact(
      'pengolahanProduksiMB',
      'pengolahanPasokanMB',
      'pengolahanDistribusiMB'
    ));
  }

  public function show_gb()
  {
    $pengolahanProduksiGB = Pengolahan::where("jenis", "=", "Gas Bumi")
    ->where("tipe", "=", "Produksi")
    ->where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
    
    $pengolahanPasokanGB = Pengolahan::where("jenis", "=", "Gas Bumi")
    ->where("tipe", "=", "Pasokan")
    ->where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
    
    $pengolahanDistribusiGB = Pengolahan::where("jenis", "=", "Gas Bumi")
    ->where("tipe", "=", "Distribusi")
    ->where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
    
    return view('badan_usaha.pengolahan.gas_bumi.show', compact(
      'pengolahanProduksiGB',
      'pengolahanPasokanGB',
      'pengolahanDistribusiGB'
    ));
  }

  public function get_intakeKilang()
  {
    $data = DB::select("SELECT intake_kilangs.nm_produk FROM intake_kilangs GROUP BY intake_kilangs.nm_produk");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function get_satuanIntakeKilang($name)
  {
    $data = DB::select("SELECT intake_kilangs.satuan FROM intake_kilangs WHERE intake_kilangs.nm_produk = '$name'");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function get_kota_pengolahan($kabupaten_kota)
  {
    // $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.kabupaten_kota = '$kabupaten_kota'");
    $data = DB::select("SELECT kotas.`nama_kota` FROM  kotas WHERE kotas.`id_prov` = (SELECT kotas.`id_prov` FROM kotas WHERE kotas.`nama_kota` = '$kabupaten_kota')");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function get_satuan($name)
  {
    $data['satuan_produk'] = DB::select("SELECT produks.satuan FROM produks WHERE produks.name = '$name'");
    $data['satuan_intake'] = DB::select("SELECT intake_kilangs.satuan FROM intake_kilangs WHERE intake_kilangs.nm_produk = '$name'");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function get_Pengolahan($id)
  {
    $data['find'] = Pengolahan::find($id);
    $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['intake'] = DB::select("SELECT intake_kilangs.nm_produk FROM intake_kilangs GROUP BY intake_kilangs.nm_produk");
    $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
    return response()->json(['data' => $data]);
  }

  // Pengolahan Minyak Bumi Produksi Kilang
  public function simpan_pengolahan_minyak_bumi_produksi(Request $request)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      'jenis' => 'required',
      'tipe' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ], $pesan);

    Pengolahan::create($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function update_pengolahan_minyak_bumi_produksi(Request $request, $id)
  {
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'keterangan' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    Pengolahan::where('id', $id)->update($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function hapus_pengolahan_minyak_bumi_produksi(Request $request, $id)
  {
    Pengolahan::destroy($id);
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

  public function submit_pengolahan_minyak_bumi_produksi(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('pengolahans')->where('id', $id)->update(['status' => "1"]);

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

  // Pengolahan Minyak Bumi Pasokan Kilang
  public function simpan_pengolahan_minyak_bumi_pasokan(Request $request)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'intake_kilang.required' => 'intake_kilang masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'kategori_pemasok' => 'required',
      'intake_kilang' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      'jenis' => 'required',
      'tipe' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ], $pesan);

    Pengolahan::create($validatedData);
    // $validatedData = PengolahanMinyakBumiPasokan::create(['badan_usaha_id' => '3','izin_id' => '10']);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function update_pengolahan_minyak_bumi_pasokan(Request $request, $id)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'intake_kilang.required' => 'intake_kilang masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'kategori_pemasok' => 'required',
      'intake_kilang' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    Pengolahan::where('id', $id)->update($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function hapus_pengolahan_minyak_bumi_pasokan(Request $request, $id)
  {
    Pengolahan::destroy($id);
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

  public function submit_pengolahan_minyak_bumi_pasokan(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('pengolahans')->where('id', $id)->update(['status' => "1"]);

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

  // Pengolahan Minyak Bumi Distribusi Kilang
  public function simpan_pengolahan_minyak_bumi_distribusi(Request $request)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      'jenis' => 'required',
      'tipe' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ], $pesan);

    Pengolahan::create($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function update_pengolahan_minyak_bumi_distribusi(Request $request, $id)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    Pengolahan::where('id', $id)->update($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function hapus_pengolahan_minyak_bumi_distribusi(Request $request, $id)
  {
    Pengolahan::destroy($id);
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

  public function submit_pengolahan_minyak_bumi_distribusi(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('pengolahans')->where('id', $id)->update(['status' => "1"]);

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

  // Pengolahan Gas Bumi Produksi Kilang
  public function simpan_pengolahan_gas_bumi_produksi(Request $request)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'jenis' => 'required',
      'tipe' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ], $pesan);

    Pengolahan::create($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function update_pengolahan_gas_bumi_produksi(Request $request, $id)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    Pengolahan::where('id', $id)->update($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function hapus_pengolahan_gas_bumi_produksi(Request $request, $id)
  {
    Pengolahan::destroy($id);
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

  public function submit_pengolahan_gas_bumi_produksi(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('pengolahans')->where('id', $id)->update(['status' => "1"]);

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

  // Pengolahan Gas Bumi Pasokan Kilang
  public function simpan_pengolahan_gas_bumi_pasokan(Request $request)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'intake_kilang.required' => 'intake_kilang masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'intake_kilang' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'jenis' => 'required',
      'tipe' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ], $pesan);

    Pengolahan::create($validatedData);
    // $validatedData = PengolahanMinyakBumiPasokan::create(['badan_usaha_id' => '3','izin_id' => '10']);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function update_pengolahan_gas_bumi_pasokan(Request $request, $id)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'intake_kilang.required' => 'intake_kilang masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'intake_kilang' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    Pengolahan::where('id', $id)->update($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function hapus_pengolahan_gas_bumi_pasokan(Request $request, $id)
  {
    Pengolahan::destroy($id);
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

  public function submit_pengolahan_gas_bumi_pasokan(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('pengolahans')->where('id', $id)->update(['status' => "1"]);

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

  // Pengolahan Gas Bumi Distribusi Kilang
  public function simpan_pengolahan_gas_bumi_distribusi(Request $request)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'volume' => 'required',
      'jenis' => 'required',
      'tipe' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ], $pesan);

    Pengolahan::create($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function update_pengolahan_gas_bumi_distribusi(Request $request, $id)
  {
    // echo json_encode($request->all());exit;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      'status.required' => 'status masih kosong',
      'catatan.required' => 'catatan masih kosong',
      'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'volume' => 'required',
      'status' => 'required',
      'catatan' => 'required',
      'petugas' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    Pengolahan::where('id', $id)->update($validatedData);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function hapus_pengolahan_gas_bumi_distribusi(Request $request, $id)
  {
    Pengolahan::destroy($id);
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

  public function submit_pengolahan_gas_bumi_distribusi(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $validatedData = DB::table('pengolahans')->where('id', $id)->update(['status' => "1"]);

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
}
