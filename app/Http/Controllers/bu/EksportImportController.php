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
use App\Models\Meping;
use App\Models\Negara;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
// s

class EksportImportController extends Controller
{
  public function index($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));

    $queryEkspor = DB::table('ekspors')
      ->select(
        '*',
        DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan_peb ORDER BY status DESC) as rn'),
        DB::raw('MAX(status) OVER (PARTITION BY bulan_peb) as status_tertinggi'),
        DB::raw('MAX(catatan) OVER (PARTITION BY bulan_peb) as catatanx')
      )
      ->where('npwp', Auth::user()->npwp)
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2]);

    $ekspor = DB::table(DB::raw("({$queryEkspor->toSql()}) as sub"))
      ->mergeBindings($queryEkspor)
      ->where('rn', 1)
      ->get();

    $queryImpor = DB::table('impors')
      ->select(
        '*',
        DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan_pib ORDER BY status DESC) as rn'),
        DB::raw('MAX(status) OVER (PARTITION BY bulan_pib) as status_tertinggi'),
        DB::raw('MAX(catatan) OVER (PARTITION BY bulan_pib) as catatanx')
      )
      ->where('npwp', Auth::user()->npwp)
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2]);

    $impor = DB::table(DB::raw("({$queryImpor->toSql()}) as sub"))
      ->mergeBindings($queryImpor)
      ->where('rn', 1)
      ->get();

           $sub_page = Meping::select('nama_opsi')
        ->where('id_sub_page', $pecah[2])
        ->where('id_template', $pecah[4])
        ->first();
 
    return view('badanUsaha.ekspor_impor.index', compact(
      'ekspor',
      'impor',
      'pecah',
      'sub_page'
    ));
  }
  public function show_eix($id, $eix, $filter = null)
  {
    
    $eixx = $eix;

    $pecah = explode(',', Crypt::decryptString($id));
    $npwp = Auth::user()->npwp;

    $bulan_ambil_ekspors = DB::table('ekspors')
      ->where('npwp', $npwp)
      ->where('bulan_peb', $pecah[3])
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2])
      ->orderBy('status', 'desc')
      ->first();

    $bulan_ambil_impors = DB::table('impors')
      ->where('npwp', $npwp)
      ->where('bulan_pib', $pecah[3])
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2])
      ->orderBy('status', 'desc')
      ->first();

    // Mengambil substring dari bulan
    $bulan_ambil_eksporsx = $bulan_ambil_ekspors ? substr($bulan_ambil_ekspors->bulan_peb, 0, 7) : '';
    $statusbulan_ambil_eksporsx = $bulan_ambil_ekspors->status ?? '';

    $bulan_ambil_imporsx = $bulan_ambil_impors ? substr($bulan_ambil_impors->bulan_pib, 0, 7) : '';
    $statusbulan_ambil_imporsx = $bulan_ambil_impors->status ?? '';

    if ($filter && $filter === "tahun") {
      $filterBy = substr($pecah[3], 0, 4);
    } else {
      $filterBy = $pecah[3];
    }
    
    $expor = Ekspor::where([
      ['bulan_peb', 'like', "%" . $filterBy . "%"],
      'npwp' => $pecah[1],
      'id_permohonan' => $pecah[0],
      'id_sub_page' => $pecah[2]
    ])->orderBy('status', 'desc')->get();

    $imporx = Impor::where([
      ['bulan_pib', 'like', "%" . $filterBy . "%"],
      'npwp' => $pecah[1],
      'id_permohonan' => $pecah[0],
      'id_sub_page' => $pecah[2]
    ])->orderBy('status', 'desc')->get();
    // dd($impor);
    // return view('badan_usaha.ekspor_impor.show', compact(
    return view('badanUsaha.ekspor_impor.show', compact(
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
  // public function simpan_exportx(Request $request)
  // {
  //   $pesan = [
  //     'npwp.required' => 'npwp masih kosong',
  //     'id_permohonan.required' => 'id_permohonan masih kosong',
  //     'id_sub_page.required' => 'id_sub_page masih kosong',
  //     'produk.required' => 'produk masih kosong',
  //     'hs_code.required' => 'hs code masih kosong',
  //     'volume_peb.required' => 'volume peb masih kosong',
  //     'satuan.required' => 'satuan masih kosong',
  //     'invoice_amount_nilai_pabean.required' => 'invoice amount nilai pabean masih kosong',
  //     'invoice_amount_final.required' => 'invoice amount final masih kosong',
  //     'nama_konsumen.required' => 'nama konsumen masih kosong',
  //     'pelabuhan_muat.required' => 'pelabuhan muat masih kosong',
  //     'negara_tujuan.required' => 'negara tujuan masih kosong',
  //     'vessel_name.required' => 'vessel name masih kosong',
  //     'tanggal_bl.required' => 'tanggal bl masih kosong',
  //     'bl_no.required' => 'bl no masih kosong',
  //     'no_pendaf_peb.required' => 'no pendaf peb masih kosong',
  //     'tanggal_pendaf_peb.required' => 'tanggal pendaf peb masih kosong',
  //     'incoterms.required' => 'incoterms masih kosong',
  //   ];

  //   $validatedData = $request->validate([
  //     'npwp' => 'required',
  //     'id_permohonan' => 'required',
  //     'id_sub_page' => 'required',
  //     'bulan_peb' => 'required',
  //     'produk' => 'required',
  //     'hs_code' => 'required',
  //     'volume_peb' => 'required',
  //     'satuan' => 'required',
  //     'invoice_amount_nilai_pabean' => 'required',
  //     'invoice_amount_final' => 'required',
  //     'nama_konsumen' => 'required',
  //     'pelabuhan_muat' => 'required',
  //     'negara_tujuan' => 'required',
  //     'vessel_name' => 'required',
  //     'tanggal_bl' => 'required',
  //     'bl_no' => 'required',
  //     'no_pendaf_peb' => 'required',
  //     'tanggal_pendaf_peb' => 'required',
  //     'incoterms' => 'required',
  //   ], $pesan);

  //   $npwp = Auth::user()->npwp;

  //   $cekdb = DB::table('ekspors')
  //     ->where('npwp', $npwp)
  //     ->where('id_permohonan', $request->id_permohonan)
  //     ->where('id_sub_page', $request->id_sub_page)
  //     ->where('bulan_peb', $request->bulan_peb . '-01')
  //     ->orderBy('status', 'desc')
  //     ->first();

  //   if (isset($cekdb) == 1) {
  //     if ($cekdb->status == 1) {
  //       Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
  //       return back();
  //     }
  //   }

  //   $validatedData = Ekspor::create([
  //     'npwp' =>  $request->npwp,
  //     'id_permohonan' =>  $request->id_permohonan,
  //     'id_sub_page' =>  $request->id_sub_page,
  //     'bulan_peb' => $request->bulan_peb . '-01',
  //     'produk' => $request->produk,
  //     'hs_code' => $request->hs_code,
  //     'volume_peb' => $request->volume_peb,
  //     'satuan' => $request->satuan,
  //     'invoice_amount_nilai_pabean' => $request->invoice_amount_nilai_pabean,
  //     'invoice_amount_final' => $request->invoice_amount_final,
  //     'nama_konsumen' => $request->nama_konsumen,
  //     'pelabuhan_muat' => $request->pelabuhan_muat,
  //     'negara_tujuan' => $request->negara_tujuan,
  //     'vessel_name' => $request->vessel_name,
  //     'tanggal_bl' => $request->tanggal_bl,
  //     'bl_no' => $request->bl_no,
  //     'no_pendaf_peb' => $request->no_pendaf_peb,
  //     'tanggal_pendaf_peb' => $request->tanggal_pendaf_peb,
  //     'incoterms' => $request->incoterms,
  //   ]);

  //   if ($validatedData) {
  //     //redirect dengan pesan sukses
  //     Alert::success('success', 'Data berhasil ditambahkan');
  //     return back();
  //   } else {
  //     //redirect dengan pesan error
  //     Alert::error('error', 'Data gagal berhasil ditambahkan');
  //     return back();
  //   }
  // }

  // Ekspor
  public function simpan_exportx(Request $request)
  {
    $pesan = [
      'npwp.required' => 'npwp masih kosong',
      'id_permohonan.required' => 'id_permohonan masih kosong',
      'id_sub_page.required' => 'id_sub_page masih kosong',
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
      'npwp' => 'required',
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
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

    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('ekspors')
      ->where('npwp', $npwp)
      ->where('id_permohonan', $request->id_permohonan)
      ->where('id_sub_page', $request->id_sub_page)
      ->where('bulan_peb', $request->bulan_peb . '-01')
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $validatedData['bulan_peb'] = $request->bulan_peb . '-01';

    $sanitizedData = fullySanitizeInput($validatedData);
    
    $createdData = Ekspor::create($sanitizedData);

    if ($createdData) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data gagal berhasil ditambahkan');
      return back();
    }
  }

  // public function simpan_importx(Request $request)
  // {
  //   $pesan = [
  //     'npwp.required' => 'npwp masih kosong',
  //     'id_permohonan.required' => 'id_permohonan masih kosong',
  //     'id_sub_page.required' => 'id_sub_page masih kosong',
  //     'bulan_pib.required' => 'bulan pib masih kosong',
  //     'produk.required' => 'produk masih kosong',
  //     'hs_code.required' => 'hs code masih kosong',
  //     'volume_pib.required' => 'volume pib masih kosong',
  //     'satuan.required' => 'satuan masih kosong',
  //     'invoice_amount_nilai_pabean.required' => 'invoice amount nilai pabean masih kosong',
  //     'invoice_amount_final.required' => 'invoice amount final masih kosong',
  //     'nama_supplier.required' => 'nama supplier masih kosong',
  //     'negara_asal.required' => 'nama supplier masih kosong',
  //     'pelabuhan_muat.required' => 'pelabuhan muat masih kosong',
  //     'pelabuhan_bongkar.required' => 'pelabuhan bongkar masih kosong',
  //     'vessel_name.required' => 'vessel name masih kosong',
  //     'tanggal_bl.required' => 'tanggal bl masih kosong',
  //     'bl_no.required' => 'bl no masih kosong',
  //     'no_pendaf_pib.required' => 'no pendaf peb masih kosong',
  //     'tanggal_pendaf_pib.required' => 'tanggal pendaf peb masih kosong',
  //     'incoterms.required' => 'incoterms masih kosong',
  //     'status.required' => 'status masih kosong',
  //   ];

  //   $validatedData = $request->validate([
  //     'npwp' => 'required',
  //     'id_permohonan' => 'required',
  //     'id_sub_page' => 'required',
  //     'bulan_pib' => 'required',
  //     'produk' => 'required',
  //     'hs_code' => 'required',
  //     'volume_pib' => 'required',
  //     'satuan' => 'required',
  //     'invoice_amount_nilai_pabean' => 'required',
  //     'invoice_amount_final' => 'required',
  //     'nama_supplier' => 'required',
  //     'negara_asal' => 'required',
  //     'pelabuhan_muat' => 'required',
  //     'pelabuhan_bongkar' => 'required',
  //     'vessel_name' => 'required',
  //     'tanggal_bl' => 'required',
  //     'bl_no' => 'required',
  //     'no_pendaf_pib' => 'required',
  //     'tanggal_pendaf_pib' => 'required',
  //     'incoterms' => 'required',
  //     'status' => 'required',
  //   ], $pesan);

  //   $npwp = Auth::user()->npwp;

  //   $cekdb = DB::table('impors')
  //     ->where('npwp', $npwp)
  //     ->where('id_permohonan', $request->id_permohonan)
  //     ->where('id_sub_page', $request->id_sub_page)
  //     ->where('bulan_pib', $request->bulan_pib . '-01')
  //     ->orderBy('status', 'desc')
  //     ->first();

  //   if (isset($cekdb) == 1) {
  //     if ($cekdb->status == 1) {
  //       Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
  //       return back();
  //     }
  //   }

  //   $validatedData = Impor::create([
  //     'npwp' =>  $request->npwp,
  //     'id_permohonan' =>  $request->id_permohonan,
  //     'id_sub_page' =>  $request->id_sub_page,
  //     'bulan_pib' => $request->bulan_pib . '-01',
  //     'produk' => $request->produk,
  //     'hs_code' => $request->hs_code,
  //     'volume_pib' => $request->volume_pib,
  //     'satuan' => $request->satuan,
  //     'invoice_amount_nilai_pabean' => $request->invoice_amount_nilai_pabean,
  //     'invoice_amount_final' => $request->invoice_amount_final,
  //     'nama_supplier' => $request->nama_supplier,
  //     'negara_asal' => $request->negara_asal,
  //     'pelabuhan_muat' => $request->pelabuhan_muat,
  //     'pelabuhan_bongkar' => $request->pelabuhan_bongkar,
  //     'vessel_name' => $request->vessel_name,
  //     'tanggal_bl' => $request->tanggal_bl,
  //     'bl_no' => $request->bl_no,
  //     'no_pendaf_pib' => $request->no_pendaf_pib,
  //     'tanggal_pendaf_pib' => $request->tanggal_pendaf_pib,
  //     'incoterms' => $request->incoterms,
  //     'status' => $request->status,

  //   ]);

  //   if ($validatedData) {
  //     //redirect dengan pesan sukses
  //     Alert::success('success', 'Data berhasil ditambahkan');
  //     return back();
  //   } else {
  //     //redirect dengan pesan error
  //     Alert::error('error', 'Data gagal berhasil ditambahkan');
  //     return back();
  //   }
  // }

  // Impor
  public function simpan_importx(Request $request)
  {
    $pesan = [
      'npwp.required' => 'npwp masih kosong',
      'id_permohonan.required' => 'id_permohonan masih kosong',
      'id_sub_page.required' => 'id_sub_page masih kosong',
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
      'npwp' => 'required',
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
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

    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('impors')
      ->where('npwp', $npwp)
      ->where('id_permohonan', $request->id_permohonan)
      ->where('id_sub_page', $request->id_sub_page)
      ->where('bulan_pib', $request->bulan_pib . '-01')
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }

    $validatedData['bulan_pib'] = $request->bulan_pib . '-01';

    // Sanitasi

    $sanitizedData = fullySanitizeInput($validatedData);

    $createdData = Impor::create($sanitizedData);

    // Cek data masuk atau tidak

    if ($createdData) {
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
      'npwp.required' => 'npwp masih kosong',
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
      'npwp' => 'required',
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

    $sanitizedData = fullySanitizeInput($validatedData);


    Ekspor::where('id', $ekport)
      ->update($sanitizedData);

    if ($sanitizedData) {
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
      'npwp.required' => 'npwp masih kosong',
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
      'npwp' => 'required',
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

    // Sanitasi input mencegah serangan xss

    $sanitizedData = fullySanitizeInput($validatedData);

    // Update Impor
    Impor::where('id', $import)
      ->update($sanitizedData);

    if ($sanitizedData) {
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

    $data = DB::select("SELECT * FROM ports ORDER BY lokasi ASC");
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }
  public function get_incoterms()
  {


    $data = DB::select("SELECT * FROM inco_terms ORDER BY incoterm");

    $data = DB::select("SELECT * FROM inco_terms ORDER BY incoterm ASC");

    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }
  public function import_eksportx(Request $request)
  {

    $id_permohonan = $request->id_permohonan;
    $id_sub_page = $request->id_sub_page;
    $bulan = $request->bulan . "-01";
    $npwp = Auth::user()->npwp;
    
    $cekdb = DB::table('ekspors')
      ->where('npwp', $npwp)
      ->where('id_permohonan', $id_permohonan)
      ->where('id_sub_page', $id_sub_page)
      ->where('bulan_peb', $bulan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $import = Excel::import(new Importekspor($bulan, $id_permohonan, $id_sub_page), request()->file('file'));

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
    $id_permohonan = $request->id_permohonan;
    $id_sub_page = $request->id_sub_page;
    $bulan = $request->bulan . "-01";
    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('impors')
      ->where('npwp', $npwp)
      ->where('id_permohonan', $id_permohonan)
      ->where('id_sub_page', $id_sub_page)
      ->where('bulan_pib', $bulan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $import = Excel::import(new Importimport($bulan, $id_permohonan, $id_sub_page), request()->file('file'));

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

  public function submit_bulan_exportx(Request $request, $id)
  {
      $pecah = explode(',', Crypt::decryptString($id));
      // dd($pecah);
      $bulanx = $pecah[3]; // Mengambil bulan_peb dari hasil dekripsi
      $id_permohonan = $pecah[0]; // Mengambil id_permohonan dari hasil dekripsi
  
      $npwp = Auth::user()->npwp;
      $id_sub_page = $pecah[2];
      $now = Carbon::now();
  
      // Update data ekspors dengan id_permohonan dan bulan_peb
      $affected = DB::table('ekspors')
          ->where('bulan_peb', $bulanx)
          ->where('npwp', $npwp)
          ->where('id_permohonan', $id_permohonan)
          ->where('id_sub_page', $id_sub_page)
          ->update(['status' => '1', 'tgl_kirim' => $now]);
  
      if ($affected) {
          // Redirect dengan pesan sukses
          Alert::success('success', 'Data berhasil dikirim');
      } else {
          // Redirect dengan pesan error
          Alert::error('error', 'Data gagal dikirim');
      }
  
      return back();
  }
  
  public function submit_bulan_importx(Request $request, $id)
  {
      $pecah = explode(',', Crypt::decryptString($id));
      $bulan_pib = $pecah[3];
      $npwp = $pecah[1];
      $id_permohonan = $pecah[0];
      $id_sub_page = $pecah[2];
      $now = Carbon::now();
  
      // Menggunakan parameter binding untuk keamanan
      $affected = DB::table('impors')
          ->where('bulan_pib', $bulan_pib)
          ->where('npwp', $npwp)
          ->where('id_permohonan', $id_permohonan)
          ->where('id_sub_page', $id_sub_page)
          ->update(['status' => '1', 'tgl_kirim' => $now]);
  
      if ($affected) {
          // Redirect dengan pesan sukses
          Alert::success('success', 'Data berhasil dikirim');
      } else {
          // Redirect dengan pesan error
          Alert::error('error', 'Data gagal dikirim');
      }
  
      return back();
  }
  

  public function hapus_bulan_exportx(Request $request, $id)
  {
      // Dekripsi ID dan pecah menjadi array
      $pecah = explode(',', Crypt::decryptString($id));

      // Siapkan query untuk menghapus data
      $affected = DB::table('ekspors')
          ->where('npwp', $pecah[1])
          ->where('bulan_peb', $pecah[3])
          ->where('id_permohonan', $pecah[0])
          ->delete();

      // Cek hasil penghapusan dan tampilkan pesan sesuai
      if ($affected) {
          Alert::success('Success', 'Data berhasil dihapus');
      } else {
          Alert::error('Error', 'Data gagal dihapus');
      }

      return back();
  }


  public function hapus_bulan_importx(Request $request, $id)
  {
      // Dekripsi ID dan pecah menjadi array
      $pecah = explode(',', Crypt::decryptString($id));
      $bulan_pib = $pecah[3];
      $npwp = $pecah[1];
      $id_permohonan = $pecah[0];
  
      // Menggunakan query builder untuk menghapus data
      $affected = DB::table('impors')
          ->where('npwp', $npwp)
          ->where('bulan_pib', $bulan_pib)
          ->where('id_permohonan', $id_permohonan)
          ->delete();
  
      // Cek hasil penghapusan dan tampilkan pesan sesuai
      if ($affected) {
          // Redirect dengan pesan sukses
          Alert::success('Success', 'Data berhasil dihapus');
      } else {
          // Redirect dengan pesan error
          Alert::error('Error', 'Data gagal dihapus');
      }
  
      return back();
  }
  
}
