<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\Penyminyakbumi;
use App\Models\Penygasbumi;


class PenyMinyakbumiController extends Controller
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
  
      return view('badan_usaha.penyimpanan.minyak_bumi.index', compact('izin'));
    }
    public function index_pggb()
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
  
      return view('badan_usaha.penyimpanan.gas_bumi.index', compact('izin'));
    }
    public function show_pmbx()
    {
        $pmb = Penyminyakbumi::get();
        $pggb = Penyminyakbumi::get();
        return view ('badan_usaha.penyimpanan.minyak_bumi.show', compact(
            'pmb',
            'pggb'
        ));
    }
    public function show_pggbx()
    {
        $pggb = Penygasbumi::get();
        return view ('badan_usaha.penyimpanan.gas_bumi.show', compact(
            'pggb'
        ));
    }
    public function simpan_pmbx(Request $request)
    {
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'jenis_fasilitas.required' => 'jenis_fasilitas masih kosong',
            'no_tangki.required' => 'no_tangki masih kosong',
            'jenis_komoditas.required' => 'jenis komoditas masih kosong',
            'produk.required' => 'produk masih kosong',
            'kab_kota.required' => 'kab kota masih kosong',
            'kategori_supplai.required' => 'kategori supplai masih kosong',
            'volume_stok_awal.required' => 'volume stok_awal masih kosong',
            'volume_supply.required' => 'volume supply masih kosong',
            'volume_output.required' => 'volume output masih kosong',
            'volume_stok_akhir.required' => 'volume stok akhir masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'utilasi_tangki.required' => 'utilasi tangki masih kosong',
            'pengguna.required' => 'pengguna masih kosong',
            'jangka_waktu_penggunaan.required' => 'jangka waktu penggunaan masih kosong',
            'tarif_penyimpanan.required' => 'tarif_penyimpanan masih kosong',
            'satuan_tarif.required' => 'satuan tarif masih kosong',
            'keterangan.required' => 'keterangan masih kosong',
        ];

        $validatedData = $request->validate([
            'bulan' => 'required',
            'jenis_fasilitas' => 'required',
            'no_tangki' => 'required',
            'jenis_komoditas' => 'required',
            'produk' => 'required',
            'kab_kota' => 'required',
            'kategori_supplai' => 'required',
            'volume_stok_awal' => 'required',
            'volume_supply' => 'required',
            'volume_output' => 'required',
            'volume_stok_akhir' => 'required',
            'satuan' => 'required',
            'utilasi_tangki' => 'required',
            'pengguna' => 'required',
            'jangka_waktu_penggunaan' => 'required',
            'tarif_penyimpanan' => 'required',
            'satuan_tarif' => 'required',
            'keterangan' => 'required',
            'jangka_waktu_penggunaan' => 'required',
            'status' => 'required',
        ], $pesan);

        Penyminyakbumi::create($validatedData);

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
    public function simpan_pggbx(Request $request)
    {
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'no_tangki.required' => 'no_tangki masih kosong',
            'produk.required' => 'produk masih kosong',
            'kab_kota.required' => 'kab kota masih kosong',
            'volume_stok_awal.required' => 'volume stok_awal masih kosong',
            'volume_supply.required' => 'volume supply masih kosong',
            'volume_output.required' => 'volume output masih kosong',
            'volume_stok_akhir.required' => 'volume stok akhir masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'utilasi_tangki.required' => 'utilasi tangki masih kosong',
            'pengguna.required' => 'pengguna masih kosong',
            'jangka_waktu_penggunaan.required' => 'jangka waktu penggunaan masih kosong',
            'tarif_penyimpanan.required' => 'tarif_penyimpanan masih kosong',
            'satuan_tarif.required' => 'satuan tarif masih kosong',
        ];

        $validatedData = $request->validate([
            'bulan' => 'required',
            'no_tangki' => 'required',
            'produk' => 'required',
            'kab_kota' => 'required',
            'volume_stok_awal' => 'required',
            'volume_supply' => 'required',
            'volume_output' => 'required',
            'volume_stok_akhir' => 'required',
            'satuan' => 'required',
            'utilasi_tangki' => 'required',
            'pengguna' => 'required',
            'jangka_waktu_penggunaan' => 'required',
            'tarif_penyimpanan' => 'required',
            'satuan_tarif' => 'required',
            'status' => 'required',
        ], $pesan);

        Penygasbumi::create($validatedData);

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
    public function hapus_pmbx(Request $request, $id)
    {
        Penyminyakbumi::destroy($id);
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
    public function hapus_pggbx(Request $request, $id)
    {
        Penygasbumi::destroy($id);
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
    public function submit_pmbx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update penyminyakbumis set status='1' where id='$idx'");

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
    public function submit_pggbx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update penygasbumis set status='1' where id='$idx'");

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
    public function get_pmb($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = Penyminyakbumi::find($id);
        return response()->json(['data' => $data]);
    }
    public function get_pggb($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = Penygasbumi::find($id);
        return response()->json(['data' => $data]);
    }
    public function update_pmbx(Request $request, $id)
    {
        $pmb = $id;
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'jenis_fasilitas.required' => 'jenis_fasilitas masih kosong',
            'no_tangki.required' => 'no_tangki masih kosong',
            'jenis_komoditas.required' => 'jenis komoditas masih kosong',
            'produk.required' => 'produk masih kosong',
            'kab_kota.required' => 'kab kota masih kosong',
            'kategori_supplai.required' => 'kategori supplai masih kosong',
            'volume_stok_awal.required' => 'volume stok_awal masih kosong',
            'volume_supply.required' => 'volume supply masih kosong',
            'volume_output.required' => 'volume output masih kosong',
            'volume_stok_akhir.required' => 'volume stok akhir masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'utilasi_tangki.required' => 'utilasi tangki masih kosong',
            'pengguna.required' => 'pengguna masih kosong',
            'jangka_waktu_penggunaan.required' => 'jangka waktu penggunaan masih kosong',
            'tarif_penyimpanan.required' => 'tarif_penyimpanan masih kosong',
            'satuan_tarif.required' => 'satuan tarif masih kosong',
            'keterangan.required' => 'keterangan masih kosong',
        ];

        $rules = [
            'bulan' => 'required',
            'jenis_fasilitas' => 'required',
            'no_tangki' => 'required',
            'jenis_komoditas' => 'required',
            'produk' => 'required',
            'kab_kota' => 'required',
            'kategori_supplai' => 'required',
            'volume_stok_awal' => 'required',
            'volume_supply' => 'required',
            'volume_output' => 'required',
            'volume_stok_akhir' => 'required',
            'satuan' => 'required',
            'utilasi_tangki' => 'required',
            'pengguna' => 'required',
            'jangka_waktu_penggunaan' => 'required',
            'tarif_penyimpanan' => 'required',
            'satuan_tarif' => 'required',
            'keterangan' => 'required',
            'jangka_waktu_penggunaan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        Penyminyakbumi::where('id', $pmb)
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
