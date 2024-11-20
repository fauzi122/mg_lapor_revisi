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
use App\Imports\ImportPengolahanMBProduksi;
use App\Imports\ImportPengolahanMBPasokan;
use App\Imports\ImportPengolahanMBDistribusi;
use App\Imports\ImportPengolahanGBProduksi;
use App\Imports\ImportPengolahanGBPasokan;
use App\Imports\ImportPengolahanGBDistribusi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;


class PengolahanController extends Controller
{
  public function index($id)
  {
   
    $pecah = explode(',', Crypt::decryptString($id));
  // dd($pecah);
    $pengolahanProduksiMB = DB::table('pengolahans')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Produksi')
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();
      // dd($pengolahanProduksiMB);

    $pengolahanPasokanMB = DB::table('pengolahans')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Pasokan')
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();

    $pengolahanDistribusiMB = DB::table('pengolahans')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Distribusi')
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();

    // Pengolahan Gas Bumi
    $pengolahanProduksiGB = DB::table('pengolahans')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Produksi')
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();

    $pengolahanPasokanGB = DB::table('pengolahans')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Pasokan')
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();

    $pengolahanDistribusiGB = DB::table('pengolahans')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Distribusi')
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->groupBy('bulan')
      ->get();

    return view('badan_usaha.pengolahan.minyak_bumi.index', compact(
      'pengolahanProduksiMB',
      'pengolahanPasokanMB',
      'pengolahanDistribusiMB',
      'pengolahanProduksiGB',
      'pengolahanPasokanGB',
      'pengolahanDistribusiGB',
      'pecah'
    ));
  }

  public function show_mb_ho($id, $jenis, $filter = null)
  {
    $pecah = explode(',', Crypt::decryptString($id));
    // dd($pecah);
    $badan_usaha_id = Auth::user()->badan_usaha_id;

    // Mengambil bulan dari tabel pengolahans sesuai ID badan usaha dan bulan yang ditemukan
    $bulan_ambil_produksi = DB::table('pengolahans')
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Produksi')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->orderBy('status', 'desc')
      ->first();
    $bulan_ambil_pasokan = DB::table('pengolahans')
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Pasokan')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->orderBy('status', 'desc')
      ->first();
    $bulan_ambil_distribusi = DB::table('pengolahans')
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Distribusi')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->orderBy('status', 'desc')
      ->first();

    // Mengambil substring dari bulan
    $bulan_ambil_produksix = $bulan_ambil_produksi ? substr($bulan_ambil_produksi->bulan, 0, 7) : '';
    $status_produksix = $bulan_ambil_produksi->status ?? '';
    $bulan_ambil_pasokanx = $bulan_ambil_pasokan ? substr($bulan_ambil_pasokan->bulan, 0, 7) : '';
    $status_pasokanx = $bulan_ambil_pasokan->status ?? '';
    $bulan_ambil_distribusix = $bulan_ambil_distribusi ? substr($bulan_ambil_distribusi->bulan, 0, 7) : '';
    $status_distribusix = $bulan_ambil_distribusi->status ?? '';

    if ($filter && $filter === "tahun") {
      $filterBy = substr($pecah[0], 0, 4);
    } else {
      $filterBy = $pecah[0];
    }
    
    $pengolahanProduksiMB = Pengolahan::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'badan_usaha_id' => $pecah[1],
      'jenis' => 'Minyak Bumi',
      'tipe' => 'Produksi',
    ])->orderBy('status', 'desc')->get();
    
    $pengolahanPasokanMB = Pengolahan::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'badan_usaha_id' => $pecah[1],
      'jenis' => 'Minyak Bumi',
      'tipe' => 'Pasokan',
    ])->orderBy('status', 'desc')->get();
    $pengolahanDistribusiMB = Pengolahan::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'badan_usaha_id' => $pecah[1],
      'jenis' => 'Minyak Bumi',
      'tipe' => 'Distribusi',
    ])->orderBy('status', 'desc')->get();
    // echo json_encode($jenis);
    // exit;
    // echo json_encode($pgb[3]->jenis_moda);exit;

    return view('badan_usaha.pengolahan.minyak_bumi.show', compact(
      'jenis',
      'pengolahanProduksiMB',
      'pengolahanPasokanMB',
      'pengolahanDistribusiMB',
      'bulan_ambil_produksix',
      'bulan_ambil_pasokanx',
      'bulan_ambil_distribusix',
      'status_produksix',
      'status_pasokanx',
      'status_distribusix',
      'pecah',
    ));

    // $pengolahanProduksiMB = Pengolahan::where("jenis", "=", "Minyak Bumi")
    //   ->where("tipe", "=", "Produksi")
    //   ->where('badan_usaha_id', Auth::user()->badan_usaha_id)->get();

    // $pengolahanPasokanMB = Pengolahan::where("jenis", "=", "Minyak Bumi")
    //   ->where("tipe", "=", "Pasokan")
    //   ->where('badan_usaha_id', Auth::user()->badan_usaha_id)->get();

    // $pengolahanDistribusiMB = Pengolahan::where("jenis", "=", "Minyak Bumi")
    //   ->where("tipe", "=", "Distribusi")
    //   ->where('badan_usaha_id', Auth::user()->badan_usaha_id)->get();

    // return view('badan_usaha.pengolahan.minyak_bumi.show', compact(
    //   'pengolahanProduksiMB',
    //   'pengolahanPasokanMB',
    //   'pengolahanDistribusiMB'
    // ));
  }

  public function show_gb($id, $jenis, $filter = null)
  {
    $pecah = explode(',', Crypt::decryptString($id));
    $badan_usaha_id = Auth::user()->badan_usaha_id;

    // Mengambil bulan dari tabel pengolahans sesuai ID badan usaha dan bulan yang ditemukan
    $bulan_ambil_produksi = DB::table('pengolahans')
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Produksi')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->orderBy('status', 'desc')
      ->first();
    $bulan_ambil_pasokan = DB::table('pengolahans')
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Pasokan')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->orderBy('status', 'desc')
      ->first();
    $bulan_ambil_distribusi = DB::table('pengolahans')
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Distribusi')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $pecah[0])
      ->orderBy('status', 'desc')
      ->first();

    // Mengambil substring dari bulan
    $bulan_ambil_produksix = $bulan_ambil_produksi ? substr($bulan_ambil_produksi->bulan, 0, 7) : '';
    $status_produksix = $bulan_ambil_produksi->status ?? '';
    $bulan_ambil_pasokanx = $bulan_ambil_pasokan ? substr($bulan_ambil_pasokan->bulan, 0, 7) : '';
    $status_pasokanx = $bulan_ambil_pasokan->status ?? '';
    $bulan_ambil_distribusix = $bulan_ambil_distribusi ? substr($bulan_ambil_distribusi->bulan, 0, 7) : '';
    $status_distribusix = $bulan_ambil_distribusi->status ?? '';


    if ($filter && $filter === "tahun") {
      $filterBy = substr($pecah[0], 0, 4);
    } else {
      $filterBy = $pecah[0];
    }
    
    $pengolahanProduksiGB = Pengolahan::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'badan_usaha_id' => $pecah[1],
      'jenis' => 'Gas Bumi',
      'tipe' => 'Produksi',
    ])->orderBy('status', 'desc')->get();
    $pengolahanPasokanGB = Pengolahan::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'badan_usaha_id' => $pecah[1],
      'jenis' => 'Gas Bumi',
      'tipe' => 'Pasokan',
    ])->orderBy('status', 'desc')->get();
    $pengolahanDistribusiGB = Pengolahan::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'badan_usaha_id' => $pecah[1],
      'jenis' => 'Gas Bumi',
      'tipe' => 'Distribusi',
    ])->orderBy('status', 'desc')->get();
    // echo json_encode($jenis);
    // exit;
    // echo json_encode($pgb[3]->jenis_moda);exit;

    return view('badan_usaha.pengolahan.gas_bumi.show', compact(
      'jenis',
      'pengolahanProduksiGB',
      'pengolahanPasokanGB',
      'pengolahanDistribusiGB',
      'bulan_ambil_produksix',
      'bulan_ambil_pasokanx',
      'bulan_ambil_distribusix',
      'status_produksix',
      'status_pasokanx',
      'status_distribusix',
      'pecah',
    ));
  }

  public function show_gb_old()
  {
    $pengolahanProduksiGB = Pengolahan::where("jenis", "=", "Gas Bumi")
      ->where("tipe", "=", "Produksi")
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)->get();

    $pengolahanPasokanGB = Pengolahan::where("jenis", "=", "Gas Bumi")
      ->where("tipe", "=", "Pasokan")
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)->get();

    $pengolahanDistribusiGB = Pengolahan::where("jenis", "=", "Gas Bumi")
      ->where("tipe", "=", "Distribusi")
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)->get();

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
    $data['sektor'] = DB::select("SELECT sektors.id, sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
    return response()->json(['data' => $data]);
  }

  // Pengolahan Minyak Bumi Produksi Kilang
  public function simpan_pengolahan_minyak_bumi_produksi(Request $request)
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
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
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
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Produksi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

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
    // echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'keterangan' => 'required',
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

  public function hapus_bulan_pengolahan_minyak_bumi_produksi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM pengolahans WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Minyak Bumi' AND tipe='Produksi'");
    // Pengolahan::destroy($bulan);
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

  public function submit_bulan_pengolahan_minyak_bumi_produksi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("UPDATE pengolahans SET status='1' WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Minyak Bumi' AND tipe='Produksi'");

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

  public function import_pengolahan_minyak_bumi_produksi(Request $request)
  {
    $bulan = $request->bulan . "-01";

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Produksi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $import = Excel::import(new ImportPengolahanMBProduksi($bulan), request()->file('file'));

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

  // ===========================================================================================
  // Pengolahan Minyak Bumi Pasokan Kilang
  public function simpan_pengolahan_minyak_bumi_pasokan(Request $request)
  {
    // echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

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
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan' => 'required',
      'kategori_pemasok' => 'required',
      'intake_kilang' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required|array',
      'volume' => 'required',
      'keterangan' => 'required',
      'jenis' => 'required',
      'tipe' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Pasokan')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    foreach ($request->kabupaten_kota as $kota) {
      $validatedData['kabupaten_kota'] = $kota;
      Pengolahan::create($validatedData);
    }

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
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'intake_kilang.required' => 'intake_kilang masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'kategori_pemasok' => 'required',
      'intake_kilang' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
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

  public function hapus_bulan_pengolahan_minyak_bumi_pasokan(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM pengolahans WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Minyak Bumi' AND tipe='Pasokan'");
    // Pengolahan::destroy($bulan);
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

  public function submit_bulan_pengolahan_minyak_bumi_pasokan(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("UPDATE pengolahans SET status='1' WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Minyak Bumi' AND tipe='Pasokan'");

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

  public function import_pengolahan_minyak_bumi_pasokan(Request $request)
  {
    $bulan = $request->bulan . "-01";

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Pasokan')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $import = Excel::import(new ImportPengolahanMBPasokan($bulan), request()->file('file'));

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

  // =============================================================================================
  // Pengolahan Minyak Bumi Distribusi Kilang
  public function simpan_pengolahan_minyak_bumi_distribusi(Request $request)
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
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
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
      'nama' => 'nullable',
      'nama_bu_niaga' => 'nullable',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Distribusi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

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
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'volume' => 'required',
      'keterangan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
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

  public function hapus_bulan_pengolahan_minyak_bumi_distribusi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM pengolahans WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Minyak Bumi' AND tipe='Distribusi'");
    // Pengolahan::destroy($bulan);
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

  public function submit_bulan_pengolahan_minyak_bumi_distribusi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("UPDATE pengolahans SET status='1' WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Minyak Bumi' AND tipe='Distribusi'");

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

  public function import_pengolahan_minyak_bumi_distribusi(Request $request)
  {
    $bulan = $request->bulan . "-01";

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->where('jenis', 'Minyak Bumi')
      ->where('tipe', 'Distribusi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $import = Excel::import(new ImportPengolahanMBDistribusi($bulan), request()->file('file'));

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

  // Pengolahan Gas Bumi Produksi Kilang
  public function simpan_pengolahan_gas_bumi_produksi(Request $request)
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
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
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
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Produksi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

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
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
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

  public function hapus_bulan_pengolahan_gas_bumi_produksi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM pengolahans WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Gas Bumi' AND tipe='Produksi'");
    // Pengolahan::destroy($bulan);
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

  public function submit_bulan_pengolahan_gas_bumi_produksi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("UPDATE pengolahans SET status='1' WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Gas Bumi' AND tipe='Produksi'");

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

  public function import_pengolahan_gas_bumi_produksi(Request $request)
  {
    $bulan = $request->bulan . "-01";

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Produksi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $import = Excel::import(new ImportPengolahanGBProduksi($bulan), request()->file('file'));

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

  // Pengolahan Gas Bumi Pasokan Kilang
  public function simpan_pengolahan_gas_bumi_pasokan(Request $request)
  {
    // echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

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
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
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
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Pasokan')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

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
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'intake_kilang.required' => 'intake_kilang masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'intake_kilang' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
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

  public function hapus_bulan_pengolahan_gas_bumi_pasokan(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM pengolahans WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Gas Bumi' AND tipe='Pasokan'");
    // Pengolahan::destroy($bulan);
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

  public function submit_bulan_pengolahan_gas_bumi_pasokan(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("UPDATE pengolahans SET status='1' WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Gas Bumi' AND tipe='Pasokan'");

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

  public function import_pengolahan_gas_bumi_pasokan(Request $request)
  {
    $bulan = $request->bulan . "-01";

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Pasokan')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $import = Excel::import(new ImportPengolahanGBPasokan($bulan), request()->file('file'));

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

  // Pengolahan Gas Bumi Distribusi Kilang
  public function simpan_pengolahan_gas_bumi_distribusi(Request $request)
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
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      'jenis.required' => 'jenis masih kosong',
      'tipe.required' => 'tipe masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
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
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $request->bulan)
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Distribusi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

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
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'volume.required' => 'volume masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'volume' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
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

  public function hapus_bulan_pengolahan_gas_bumi_distribusi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("DELETE FROM pengolahans WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Gas Bumi' AND tipe='Distribusi'");
    // Pengolahan::destroy($bulan);
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

  public function submit_bulan_pengolahan_gas_bumi_distribusi(Request $request, $bulan)
  {
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("UPDATE pengolahans SET status='1' WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id' AND jenis='Gas Bumi' AND tipe='Distribusi'");

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

  public function import_pengolahan_gas_bumi_distribusi(Request $request)
  {
    $bulan = $request->bulan . "-01";

    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('pengolahans')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan', $bulan)
      ->where('jenis', 'Gas Bumi')
      ->where('tipe', 'Distribusi')
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb->status);
    // die;

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $import = Excel::import(new ImportPengolahanGBDistribusi($bulan), request()->file('file'));

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
}
