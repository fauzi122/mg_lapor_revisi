<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Ekspor;
use App\Models\Impor;
use App\Models\Izin;
use App\Imports\Importekspor;
use App\Imports\Importimport;
use App\Models\Negara;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
// s

class EksportImportController extends Controller
{
  public function index($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));

    $ekspor = DB::table('ekspors')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->where('izin_id', $pecah[0])
      ->groupBy('bulan_peb')
      ->get();

    $impor = DB::table('impors')
      ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
      ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
      ->where('izin_id', $pecah[0])
      ->groupBy('bulan_pib')
      ->get();
    // dd($impor);
    return view('badan_usaha.ekspor_impor.index', compact(
      'ekspor',
      'impor',
      'pecah'
    ));
  }
  public function show_eix($id, $eix, $filter = null)
  {
    
    $eixx = $eix;

    $pecah = explode(',', Crypt::decryptString($id));
    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $bulan_ambil_ekspors = DB::table('ekspors')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan_peb', $pecah[0])
      ->where('izin_id', $pecah[2])
      ->orderBy('status', 'desc')
      ->first();

    $bulan_ambil_impors = DB::table('impors')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan_pib', $pecah[0])
      ->where('izin_id', $pecah[2])
      ->orderBy('status', 'desc')
      ->first();

    // Mengambil substring dari bulan
    $bulan_ambil_eksporsx = $bulan_ambil_ekspors ? substr($bulan_ambil_ekspors->bulan_peb, 0, 7) : '';
    $statusbulan_ambil_eksporsx = $bulan_ambil_ekspors->status ?? '';

    $bulan_ambil_imporsx = $bulan_ambil_impors ? substr($bulan_ambil_impors->bulan_pib, 0, 7) : '';
    $statusbulan_ambil_imporsx = $bulan_ambil_impors->status ?? '';

    if ($filter && $filter === "tahun") {
      $filterBy = substr($pecah[0], 0, 4);
    } else {
      $filterBy = $pecah[0];
    }
    
    $expor = Ekspor::where([
      ['bulan_peb', 'like', "%" . $filterBy . "%"],
      'badan_usaha_id' => $pecah[1],
      'izin_id' => $pecah[2]
    ])->orderBy('status', 'desc')->get();

    $imporx = Impor::where([
      ['bulan_pib', 'like', "%" . $filterBy . "%"],
      'badan_usaha_id' => $pecah[1],
      'izin_id' => $pecah[2]
    ])->orderBy('status', 'desc')->get();
    // dd($impor);
    return view('badan_usaha.ekspor_impor.show', compact(
      'expor',
      'imporx',
      'bulan_ambil_eksporsx',
      'bulan_ambil_imporsx',
      'statusbulan_ambil_eksporsx',
      'statusbulan_ambil_imporsx',
      'eixx',
      'pecah'

    ));
  }
  public function simpan_exportx(Request $request)
  {
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'produk.required' => 'produk masih kosong',
      'hs_code.required' => 'hs code masih kosong',
      'volume_peb.required' => 'volume peb masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'invoice_amount_nilai_pabean.required' => 'invoice amount nilai pabean masih kosong',
      'invoice_amount_final.required' => 'invoice amount final masih kosong',
      'nama_konsumen.required' => 'nama konsumen masih kosong',
      'pelabuhan_muat.required' => 'pelabuhan muat masih kosong',
      'negara_tujuan.required' => 'negara tujuan masih kosong',
      'vessel_name.required' => 'vessel name masih kosong',
      'tanggal_bl.required' => 'tanggal bl masih kosong',
      'bl_no.required' => 'bl no masih kosong',
      'no_pendaf_peb.required' => 'no pendaf peb masih kosong',
      'tanggal_pendaf_peb.required' => 'tanggal pendaf peb masih kosong',
      'incoterms.required' => 'incoterms masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan_peb' => 'required',
      'produk' => 'required',
      'hs_code' => 'required',
      'volume_peb' => 'required',
      'satuan' => 'required',
      'invoice_amount_nilai_pabean' => 'required',
      'invoice_amount_final' => 'required',
      'nama_konsumen' => 'required',
      'pelabuhan_muat' => 'required',
      'negara_tujuan' => 'required',
      'vessel_name' => 'required',
      'tanggal_bl' => 'required',
      'bl_no' => 'required',
      'no_pendaf_peb' => 'required',
      'tanggal_pendaf_peb' => 'required',
      'incoterms' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $cekdb = DB::table('ekspors')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan_peb', $request->bulan_peb . '-01')
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $validatedData = Ekspor::create([
      'badan_usaha_id' =>  $request->badan_usaha_id,
      'izin_id' =>  $request->izin_id,
      'bulan_peb' => $request->bulan_peb . '-01',
      'produk' => $request->produk,
      'hs_code' => $request->hs_code,
      'volume_peb' => $request->volume_peb,
      'satuan' => $request->satuan,
      'invoice_amount_nilai_pabean' => $request->invoice_amount_nilai_pabean,
      'invoice_amount_final' => $request->invoice_amount_final,
      'nama_konsumen' => $request->nama_konsumen,
      'pelabuhan_muat' => $request->pelabuhan_muat,
      'negara_tujuan' => $request->negara_tujuan,
      'vessel_name' => $request->vessel_name,
      'tanggal_bl' => $request->tanggal_bl,
      'bl_no' => $request->bl_no,
      'no_pendaf_peb' => $request->no_pendaf_peb,
      'tanggal_pendaf_peb' => $request->tanggal_pendaf_peb,
      'incoterms' => $request->incoterms,
    ]);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal berhasil ditambahkan');
      return back();
    }
  }

  public function simpan_importx(Request $request)
  {
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
      'bulan_pib.required' => 'bulan pib masih kosong',
      'produk.required' => 'produk masih kosong',
      'hs_code.required' => 'hs code masih kosong',
      'volume_pib.required' => 'volume pib masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'invoice_amount_nilai_pabean.required' => 'invoice amount nilai pabean masih kosong',
      'invoice_amount_final.required' => 'invoice amount final masih kosong',
      'nama_supplier.required' => 'nama supplier masih kosong',
      'negara_asal.required' => 'nama supplier masih kosong',
      'pelabuhan_muat.required' => 'pelabuhan muat masih kosong',
      'pelabuhan_bongkar.required' => 'pelabuhan bongkar masih kosong',
      'vessel_name.required' => 'vessel name masih kosong',
      'tanggal_bl.required' => 'tanggal bl masih kosong',
      'bl_no.required' => 'bl no masih kosong',
      'no_pendaf_pib.required' => 'no pendaf peb masih kosong',
      'tanggal_pendaf_pib.required' => 'tanggal pendaf peb masih kosong',
      'incoterms.required' => 'incoterms masih kosong',
      'status.required' => 'status masih kosong',
    ];

    $validatedData = $request->validate([
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
      'bulan_pib' => 'required',
      'produk' => 'required',
      'hs_code' => 'required',
      'volume_pib' => 'required',
      'satuan' => 'required',
      'invoice_amount_nilai_pabean' => 'required',
      'invoice_amount_final' => 'required',
      'nama_supplier' => 'required',
      'negara_asal' => 'required',
      'pelabuhan_muat' => 'required',
      'pelabuhan_bongkar' => 'required',
      'vessel_name' => 'required',
      'tanggal_bl' => 'required',
      'bl_no' => 'required',
      'no_pendaf_pib' => 'required',
      'tanggal_pendaf_pib' => 'required',
      'incoterms' => 'required',
      'status' => 'required',
    ], $pesan);

    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $cekdb = DB::table('impors')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan_pib', $request->bulan_pib . '-01')
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $validatedData = Impor::create([
      'badan_usaha_id' =>  $request->badan_usaha_id,
      'izin_id' =>  $request->izin_id,
      'bulan_pib' => $request->bulan_pib . '-01',
      'produk' => $request->produk,
      'hs_code' => $request->hs_code,
      'volume_pib' => $request->volume_pib,
      'satuan' => $request->satuan,
      'invoice_amount_nilai_pabean' => $request->invoice_amount_nilai_pabean,
      'invoice_amount_final' => $request->invoice_amount_final,
      'nama_supplier' => $request->nama_supplier,
      'negara_asal' => $request->negara_asal,
      'pelabuhan_muat' => $request->pelabuhan_muat,
      'pelabuhan_bongkar' => $request->pelabuhan_bongkar,
      'vessel_name' => $request->vessel_name,
      'tanggal_bl' => $request->tanggal_bl,
      'bl_no' => $request->bl_no,
      'no_pendaf_pib' => $request->no_pendaf_pib,
      'tanggal_pendaf_pib' => $request->tanggal_pendaf_pib,
      'incoterms' => $request->incoterms,
      'status' => $request->status,

    ]);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal berhasil ditambahkan');
      return back();
    }
  }
  public function hapus_exportx(Request $request, $id)
  {
    Ekspor::destroy($id);
    if ($id) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil dihapus');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal dihapus');
      return back();
    }
  }
  public function hapus_importx(Request $request, $id)
  {
    Impor::destroy($id);
    if ($id) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil dihapus');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal dihapus');
      return back();
    }
  }
  public function submit_exportx(Request $request, $id)
  {
    $idx = $id;
    $now = Carbon::now();
    $validatedData = DB::update("update ekspors set status='1', tgl_kirim='$now' where id='$idx'");

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
  public function submit_importx(Request $request, $id)
  {
    $idx = $id;
    $now = Carbon::now();
    $validatedData = DB::update("update impors set status='1', tgl_kirim='$now' where id='$idx'");

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
  public function get_export($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['negara_tujuan'] = DB::select("SELECT negaras.nm_negara FROM negaras");
    $data['pelabuhan'] = DB::select("SELECT ports.nm_port, ports.lokasi FROM ports");
    $data['find'] = Ekspor::find($id);
    return response()->json(['data' => $data]);
  }
  public function update_exportx(Request $request, $id)
  {
    $ekport = $id;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'bulan_peb.required' => 'bulan peb masih kosong',
      'produk.required' => 'produk masih kosong',
      'hs_code.required' => 'hs code masih kosong',
      'volume_peb.required' => 'volume peb masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'invoice_amount_nilai_pabean.required' => 'invoice amount nilai pabean masih kosong',
      'invoice_amount_final.required' => 'invoice amount final masih kosong',
      'nama_konsumen.required' => 'nama konsumen masih kosong',
      'pelabuhan_muat.required' => 'pelabuhan muat masih kosong',
      'negara_tujuan.required' => 'negara tujuan masih kosong',
      'vessel_name.required' => 'vessel name masih kosong',
      'tanggal_bl.required' => 'tanggal bl masih kosong',
      'bl_no.required' => 'bl no masih kosong',
      'no_pendaf_peb.required' => 'no pendaf peb masih kosong',
      'tanggal_pendaf_peb.required' => 'tanggal pendaf peb masih kosong',
      'incoterms.required' => 'incoterms masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'bulan_peb' => 'required',
      'produk' => 'required',
      'hs_code' => 'required',
      'volume_peb' => 'required',
      'satuan' => 'required',
      'invoice_amount_nilai_pabean' => 'required',
      'invoice_amount_final' => 'required',
      'nama_konsumen' => 'required',
      'pelabuhan_muat' => 'required',
      'negara_tujuan' => 'required',
      'vessel_name' => 'required',
      'tanggal_bl' => 'required',
      'bl_no' => 'required',
      'no_pendaf_peb' => 'required',
      'tanggal_pendaf_peb' => 'required',
      'incoterms' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    $validatedData['bulan_peb'] = $request->bulan_peb . '-01';

    Ekspor::where('id', $ekport)
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
  public function get_import($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['negara_asal'] = DB::select("SELECT negaras.nm_negara FROM negaras");
    $data['pelabuhan'] = DB::select("SELECT ports.nm_port, ports.lokasi FROM ports");
    $data['find'] = Impor::find($id);
    return response()->json(['data' => $data]);
  }
  public function update_importx(Request $request, $id)
  {
    $import = $id;
    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'bulan_pib.required' => 'bulan pib masih kosong',
      'produk.required' => 'produk masih kosong',
      'hs_code.required' => 'hs code masih kosong',
      'volume_pib.required' => 'volume pib masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'invoice_amount_nilai_pabean.required' => 'invoice amount nilai pabean masih kosong',
      'invoice_amount_final.required' => 'invoice amount final masih kosong',
      'nama_supplier.required' => 'nama supplier masih kosong',
      'negara_asal.required' => 'nama supplier masih kosong',
      'pelabuhan_muat.required' => 'pelabuhan muat masih kosong',
      'pelabuhan_bongkar.required' => 'pelabuhan bongkar masih kosong',
      'vessel_name.required' => 'vessel name masih kosong',
      'tanggal_bl.required' => 'tanggal bl masih kosong',
      'bl_no.required' => 'bl no masih kosong',
      'no_pendaf_pib.required' => 'no pendaf peb masih kosong',
      'tanggal_pendaf_pib.required' => 'tanggal pendaf peb masih kosong',
      'incoterms.required' => 'incoterms masih kosong',
      'status.required' => 'status masih kosong',
    ];

    $rules = [
      'badan_usaha_id' => 'required',
      'bulan_pib' => 'required',
      'produk' => 'required',
      'hs_code' => 'required',
      'volume_pib' => 'required',
      'satuan' => 'required',
      'invoice_amount_nilai_pabean' => 'required',
      'invoice_amount_final' => 'required',
      'nama_supplier' => 'required',
      'negara_asal' => 'required',
      'pelabuhan_muat' => 'required',
      'pelabuhan_bongkar' => 'required',
      'vessel_name' => 'required',
      'tanggal_bl' => 'required',
      'bl_no' => 'required',
      'no_pendaf_pib' => 'required',
      'tanggal_pendaf_pib' => 'required',
      'incoterms' => 'required',
      'status' => 'required',
    ];
    

    $validatedData = $request->validate($rules, $pesan);

    $validatedData['bulan_pib'] = $request->bulan_pib . '-01';

    Impor::where('id', $import)
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
  public function get_negara()
  {

    // $data = DB::select("SELECT negaras.nm_negara FROM negaras");
    $data = Negara::select('nm_negara')->orderBy('nm_negara')->get();
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }
  public function get_pelabuhan()
  {

    $data = DB::select("SELECT * FROM `ports` ORDER BY lokasi ASC");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }
  public function get_incoterms()
  {


    $data = DB::select("SELECT * FROM `inco_terms` ORDER BY incoterm");

    $data = DB::select("SELECT * FROM `inco_terms` ORDER BY incoterm ASC");

    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }
  public function import_eksportx(Request $request)
  {
    $izin_id = $request->izin_id;
    $bulan = $request->bulan . "-01";
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('ekspors')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan_peb', $bulan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $import = Excel::import(new Importekspor($bulan,$izin_id), request()->file('file'));

    if ($import) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data excel berhasil diupload');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data excel gagal diupload');
      return back();
    }
  }
  public function import_importx(Request $request)
  {
    $izin_id = $request->izin_id;
    $bulan = $request->bulan . "-01";
    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $cekdb = DB::table('impors')
      ->where('badan_usaha_id', $badan_usaha_id)
      ->where('bulan_pib', $bulan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $import = Excel::import(new Importimport($bulan,$izin_id), request()->file('file'));

    if ($import) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data excel berhasil diupload');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data excel gagal diupload');
      return back();
    }
  }
  public function submit_bulan_exportx(Request $request, $bulan)
  {
    $bulanx = $bulan;
    // dd($bulanx);
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $now = Carbon::now();
    $validatedData = DB::update("update ekspors set status='1', tgl_kirim='$now' where bulan_peb='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
  public function submit_bulan_importx(Request $request, $bulan)
  {
    $bulanx = $bulan;
    // dd($bulanx);
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $now = Carbon::now();
    $validatedData = DB::update("update impors set status='1', tgl_kirim='$now' where bulan_pib='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
  public function hapus_bulan_exportx(Request $request, $bulan)
  {
    // dd($bulan);
    // die;
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("delete from ekspors where badan_usaha_id='$badan_usaha_id' and bulan_peb='$bulanx'");
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
  public function hapus_bulan_importx(Request $request, $bulan)
  {
    // dd($bulan);
    // die;
    $bulanx = $bulan;
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $validatedData = DB::update("delete from impors where badan_usaha_id='$badan_usaha_id' and bulan_pib='$bulanx'");
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
