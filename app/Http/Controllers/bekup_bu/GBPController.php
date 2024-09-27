<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\PenjualanGBP;
use App\Models\pasokanGBP;

class GBPController extends Controller
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

        return view('badan_usaha.niaga.gas_bumi.index', compact('izin'));
    }
    public function show_gbpx()
    {
        $gbp = PenjualanGBP::get();
        $pasokan = pasokanGBP::get();
        return view ('badan_usaha.niaga.gas_bumi.show', compact(
            'gbp',
            'pasokan'
        ));
    }
    public function simpan_gbpx(Request $request)
    {
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'konsumen.required' => 'konsumen masih kosong',
            'jumlah_hari_penyaluran.required' => 'jumlah hari penyaluran masih kosong',
            'ghv.required' => 'ghv masih kosong',
            'volume_mmbtu.required' => 'volume mmbtu masih kosong',
            'volume_mscf.required' => 'volume mscf masih kosong',
            'volume_m3.required' => 'volume m3 masih kosong',
            'harga.required' => 'harga masih kosong',
            'keterangan.required' => 'keterangan masih kosong',
        ];

        $validatedData = $request->validate([
            'bulan' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'sektor' => 'required',
            'konsumen' => 'required',
            'jumlah_hari_penyaluran' => 'required',
            'ghv' => 'required',
            'volume_mmbtu' => 'required',
            'volume_mscf' => 'required',
            'volume_m3' => 'required',
            'harga' => 'required',
            'keterangan' => 'required',
        ], $pesan);

        PenjualanGBP::create($validatedData);

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
    public function hapus_gbpx(Request $request, $id)
    {
        PenjualanGBP::destroy($id);
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
        $show_gbp = PenjualanGBP::find($id);
        return response()->json([
            'data' => $show_gbp
        ]);
    }
    public function get_penjualan_gbp($id)
    {
        $data['provinsi'] = DB::select("SELECT provinces.name, provinces.id FROM provinces");
        $data['find'] = PenjualanGBP::find($id);
        return response()->json(['data' => $data]);
    }
    public function get_kota($kabupaten_kota)
    {
        $data = DB::select("SELECT kotas.`nama_kota` FROM  kotas WHERE kotas.`id_prov` = (SELECT kotas.`id_prov` FROM kotas WHERE kotas.`nama_kota` = '$kabupaten_kota')");
        return response()->json(['data' => $data]);
    }
    public function update_gbpx(Request $request, $id)
    {
        $penjualan_gbp = $id;
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'konsumen.required' => 'konsumen masih kosong',
            'jumlah_hari_penyaluran.required' => 'jumlah hari penyaluran masih kosong',
            'ghv.required' => 'ghv masih kosong',
            'volume_mmbtu.required' => 'volume mmbtu masih kosong',
            'volume_mscf.required' => 'volume mscf masih kosong',
            'volume_m3.required' => 'volume m3 masih kosong',
            'harga.required' => 'harga masih kosong',
            'keterangan.required' => 'keterangan masih kosong',
        ];

        $rules = [
            'bulan' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'sektor' => 'required',
            'konsumen' => 'required',
            'jumlah_hari_penyaluran' => 'required',
            'ghv' => 'required',
            'volume_mmbtu' => 'required',
            'volume_mscf' => 'required',
            'volume_m3' => 'required',
            'harga' => 'required',
            'keterangan' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        PenjualanGBP::where('id', $penjualan_gbp)
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
    public function simpan_pasokan_gbpx(Request $request)
    {
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'nama_pemasok.required' => 'nama pemasok masih kosong',
            'volume_mmbtu.required' => 'volume mmbtu masih kosong',
            'volume_mscf.required' => 'volume mscf masih kosong',
            'volume_m3.required' => 'volume m3 masih kosong',
            'harga.required' => 'harga masih kosong',
        ];

        $validatedData = $request->validate([
            'bulan' => 'required',
            'nama_pemasok' => 'required',
            'volume_mmbtu' => 'required',
            'volume_mscf' => 'required',
            'volume_m3' => 'required',
            'harga' => 'required',
        ], $pesan);

        pasokanGBP::create($validatedData);

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
    public function hapus_pasok_gbpx(Request $request, $id)
    {
        pasokanGBP::destroy($id);
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
    public function get_pasok_gbp($id)
    {
        $data['find'] = pasokanGBP::find($id);
        return response()->json(['data' => $data]);
    }
    public function update_pasok_gbpx(Request $request, $id)
    {
        $penjualan_gbp = $id;
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'nama_pemasok.required' => 'nama pemasok masih kosong',
            'volume_mmbtu.required' => 'volume mmbtu masih kosong',
            'volume_mscf.required' => 'volume mscf masih kosong',
            'volume_m3.required' => 'volume m3 masih kosong',
            'harga.required' => 'harga masih kosong',
        ];

        $rules = [
            'bulan' => 'required',
            'nama_pemasok' => 'required',
            'volume_mmbtu' => 'required',
            'volume_mscf' => 'required',
            'volume_m3' => 'required',
            'harga' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        pasokanGBP::where('id', $penjualan_gbp)
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
    public function submit_pasok_gbpx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update pasokan_g_b_p_s set status='1' where id='$idx'");

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
    public function submit_gbpx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update penjualan_g_b_p_s set status='1' where id='$idx'");

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
}
