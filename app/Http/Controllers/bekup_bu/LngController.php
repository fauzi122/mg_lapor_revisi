<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan_lng;
use Illuminate\Http\Request;
use App\Models\Harga_bbm_jbu;
use App\Models\Pasokanlng;
use App\Models\Izin;
use App\Models\Ekspor;
use App\Models\Impor;

class LngController extends Controller
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
  
      return view('badan_usaha.niaga.lng.index', compact('izin'));
    }
    public function show_lngx()
    {
        $lng = Penjualan_lng::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        $pasok_lng = Pasokanlng::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        $hargabbmjbu = Harga_bbm_jbu::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        $expor = Ekspor::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        $impor = Impor::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        return view ('badan_usaha.niaga.lng.show', compact(
            'lng',
            'pasok_lng',
            'hargabbmjbu',
            'expor',
            'impor'
        ));
    }
    public function simpan_lngx(Request $request)
    {
        $pesan = [
            
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            'produk.required' => 'produk masih kosong',
            'konsumen.required' => 'konsumen masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'biaya_kompresi.required' => 'biaya_kompresi masih kosong',
            'biaya_penyimpanan.required' => 'biaya_penyimpanan masih kosong',
            'biaya_pengangkutan.required' => 'biaya_pengangkutan masih kosong',
            'harga_jual.required' => 'harga_jual masih kosong',
            'biaya_niaga.required' => 'biaya_niaga masih kosong',
        ];

        $validatedData = $request->validate([
        
            'badan_usaha_id' => 'required',
            'bulan' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'produk' => 'required',
            'konsumen' => 'required',
            'sektor' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'biaya_kompresi' => 'required',
            'biaya_penyimpanan' => 'required',
            'biaya_pengangkutan' => 'required',
            'harga_jual' => 'required',
            'biaya_niaga' => 'required',
        ], $pesan);

        Penjualan_lng::create($validatedData);

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
    public function hapus_lngx(Request $request, $id)
    {
        Penjualan_lng::destroy($id);
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
    public function edit($id)
    {
        $show_lng = Penjualan_lng::find($id);
        return response()->json([
            'data' => $show_lng
        ]);
    }
    public function get_penjualan_lng($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = Penjualan_lng::find($id);
        return response()->json(['data' => $data]);

        // $data = Penjualan_lng::find($id);
        // return response()->json(['data' => $data]);
    }
    public function update_lngx(Request $request, $id)
    {
        $penjualan_lng = $id;
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            'produk.required' => 'produk masih kosong',
            'konsumen.required' => 'konsumen masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'biaya_kompresi.required' => 'biaya_kompresi masih kosong',
            'biaya_penyimpanan.required' => 'biaya_penyimpanan masih kosong',
            'biaya_pengangkutan.required' => 'biaya_pengangkutan masih kosong',
            'harga_jual.required' => 'harga_jual masih kosong',
            'biaya_niaga.required' => 'biaya_niaga masih kosong',
        ];

        $rules = [
            'badan_usaha_id' => 'required',
            'bulan' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'produk' => 'required',
            'konsumen' => 'required',
            'sektor' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'biaya_kompresi' => 'required',
            'biaya_penyimpanan' => 'required',
            'biaya_pengangkutan' => 'required',
            'harga_jual' => 'required',
            'biaya_niaga' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        Penjualan_lng::where('id', $penjualan_lng)
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

    public function simpan_pasokan_lngx(Request $request)
    {
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'nama_pemasok.required' => 'nama_pemasok masih kosong',
            'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'harga_gas.required' => 'harga_gas masih kosong',
        ];

        $validatedData = $request->validate([
            'badan_usaha_id' => 'required',
            'bulan' => 'required',
            'produk' => 'required',
            'nama_pemasok' => 'required',
            'kategori_pemasok' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'harga_gas' => 'required',
        ], $pesan);

        Pasokanlng::create($validatedData);

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
    public function hapus_pasok_lngx(Request $request, $id)
    {
        Pasokanlng::destroy($id);
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
    public function get_pasok_lng($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['find'] = Pasokanlng::find($id);
        return response()->json(['data' => $data]);
    }
    public function update_pasok_lngx(Request $request, $id)
    {
        $penjualan_lng = $id;
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'nama_pemasok.required' => 'nama_pemasok masih kosong',
            'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'harga_gas.required' => 'harga_gas masih kosong',
        ];

        $rules = [
            'badan_usaha_id' => 'required',
            'bulan' => 'required',
            'produk' => 'required',
            'nama_pemasok' => 'required',
            'kategori_pemasok' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'harga_gas' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        Pasokanlng::where('id', $penjualan_lng)
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
    public function get_kota($kabupaten_kota)
    {
        // $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.kabupaten_kota = '$kabupaten_kota'");
        $data = DB::select("SELECT kotas.`nama_kota` FROM  kotas WHERE kotas.`id_prov` = (SELECT kotas.`id_prov` FROM kotas WHERE kotas.`nama_kota` = '$kabupaten_kota')");
        // $data = Produk::get();
        return response()->json(['data' => $data]);
    }
}
