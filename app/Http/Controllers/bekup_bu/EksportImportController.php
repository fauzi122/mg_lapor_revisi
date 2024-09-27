<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Ekspor;
use App\Models\Impor;
use App\Models\Izin;

class EksportImportController extends Controller
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
  
      return view('badan_usaha.ekspor_impor.index', compact('izin'));
    }
    public function show_eix()
    {
        $expor = Ekspor::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        $impor = Impor::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        return view ('badan_usaha.ekspor_impor.show', compact(
            'expor',
            'impor'
        ));
    }
    public function simpan_exportx(Request $request)
    {
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
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

        Ekspor::create($validatedData);

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

        Impor::create($validatedData);

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
       $idx=$id;
        $validatedData = DB::update("update ekspors set status='1' where id='$idx'");

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
       $idx=$id;
        $validatedData = DB::update("update impors set status='1' where id='$idx'");

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
   
        $data = DB::select("SELECT negaras.nm_negara FROM negaras");
        // $data = Produk::get();
        return response()->json(['data' => $data]);
    }
}
