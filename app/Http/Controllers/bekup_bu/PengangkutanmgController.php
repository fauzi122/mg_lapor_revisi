<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\pengangkutan_gaskbumi;
use App\Models\pengangkutan_minyakbumi;


class PengangkutanmgController extends Controller
{
    public function show_pengmbx()
    {
        $pgb = pengangkutan_minyakbumi::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        $pengmb = pengangkutan_gaskbumi::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        return view ('badan_usaha.pengangkutan.minyak_bumi.show', compact(
            'pgb',
            'pengmb'
        ));
    }
    public function simpan_pengmbx(Request $request)
    {
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'produk.required' => 'produk masih kosong',
            'jenis_moda.required' => 'jenis moda masih kosong',
            'node_asal.required' => 'node asal masih kosong',
            'provinsi_asal.required' => 'provinsi asal masih kosong',
            'node_tujuan.required' => 'node tujuan masih kosong',
            'provinsi_tujuan.required' => 'provinsi tujuan masih kosong',
            'volume_supply.required' => 'volume supply masih kosong',
            'satuan_volume_supply.required' => 'satuan volume_supply masih kosong',
            'volume_angkut.required' => 'volume angkut masih kosong',
            'satuan_volume_angkut.required' => 'satuan volume angkut masih kosong',
            'status.required' => 'status masih kosong',
        ];

        $validatedData = $request->validate([
            'badan_usaha_id' => 'required',
            'produk' => 'required',
            'jenis_moda' => 'required',
            'node_asal' => 'required',
            'provinsi_asal' => 'required',
            'node_tujuan' => 'required',
            'provinsi_tujuan' => 'required',
            'volume_supply' => 'required',
            'satuan_volume_supply' => 'required',
            'volume_angkut' => 'required',
            'satuan_volume_angkut' => 'required',
            'status' => 'required',
            
        ], $pesan);

        pengangkutan_minyakbumi::create($validatedData);

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
    public function hapus_pengmbx(Request $request, $id)
    {
        pengangkutan_minyakbumi::destroy($id);
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
    public function submit_pengmbx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");

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
    public function get_pengmb($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = pengangkutan_minyakbumi::find($id);
        return response()->json(['data' => $data]);
    }
    public function update_pengmbx(Request $request, $id)
    {
        $pmb = $id;
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'produk.required' => 'produk masih kosong',
            'jenis_moda.required' => 'jenis moda masih kosong',
            'node_asal.required' => 'node asal masih kosong',
            'provinsi_asal.required' => 'provinsi asal masih kosong',
            'node_tujuan.required' => 'node tujuan masih kosong',
            'provinsi_tujuan.required' => 'provinsi tujuan masih kosong',
            'volume_supply.required' => 'volume supply masih kosong',
            'satuan_volume_supply.required' => 'satuan volume_supply masih kosong',
            'volume_angkut.required' => 'volume angkut masih kosong',
            'satuan_volume_angkut.required' => 'satuan volume angkut masih kosong',
            'status.required' => 'status masih kosong',
        ];

        $rules = [
            'badan_usaha_id' => 'required',
            'produk' => 'required',
            'jenis_moda' => 'required',
            'node_asal' => 'required',
            'provinsi_asal' => 'required',
            'node_tujuan' => 'required',
            'provinsi_tujuan' => 'required',
            'volume_supply' => 'required',
            'satuan_volume_supply' => 'required',
            'volume_angkut' => 'required',
            'satuan_volume_angkut' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        pengangkutan_minyakbumi::where('id', $pmb)
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
    public function show_pgbx()
    {
        $pengmb = pengangkutan_minyakbumi::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        $pgb = pengangkutan_gaskbumi::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();
        return view ('badan_usaha.pengangkutan.gas_bumi.show', compact(
            'pgb',
            'pengmb'
        ));
    }
    public function simpan_pgbx(Request $request)
    {
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'produk.required' => 'produk masih kosong',
            'node_asal.required' => 'node asal masih kosong',
            'provinsi_asal.required' => 'provinsi asal masih kosong',
            'node_tujuan.required' => 'node tujuan masih kosong',
            'provinsi_tujuan.required' => 'provinsi tujuan masih kosong',
            'volume_supply.required' => 'volume supply masih kosong',
            'satuan_volume_supply.required' => 'satuan volume_supply masih kosong',
            'volume_angkut.required' => 'volume angkut masih kosong',
            'satuan_volume_angkut.required' => 'satuan volume angkut masih kosong',
            'status.required' => 'status masih kosong',
        ];

        $validatedData = $request->validate([
            'badan_usaha_id' => 'required',
            'produk' => 'required',
            'node_asal' => 'required',
            'provinsi_asal' => 'required',
            'node_tujuan' => 'required',
            'provinsi_tujuan' => 'required',
            'volume_supply' => 'required',
            'satuan_volume_supply' => 'required',
            'volume_angkut' => 'required',
            'satuan_volume_angkut' => 'required',
            'status' => 'required',
            
        ], $pesan);

        pengangkutan_gaskbumi::create($validatedData);

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
    public function hapus_pgbx(Request $request, $id)
    {
        pengangkutan_gaskbumi::destroy($id);
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
    public function submit_pgbx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update pengangkutan_gaskbumis set status='1' where id='$idx'");

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
    public function get_pgb($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = pengangkutan_gaskbumi::find($id);
        return response()->json(['data' => $data]);
    }
    public function update_pgbx(Request $request, $id)
    {
        $pmb = $id;
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'produk.required' => 'produk masih kosong',
            'node_asal.required' => 'node asal masih kosong',
            'provinsi_asal.required' => 'provinsi asal masih kosong',
            'node_tujuan.required' => 'node tujuan masih kosong',
            'provinsi_tujuan.required' => 'provinsi tujuan masih kosong',
            'volume_supply.required' => 'volume supply masih kosong',
            'satuan_volume_supply.required' => 'satuan volume_supply masih kosong',
            'volume_angkut.required' => 'volume angkut masih kosong',
            'satuan_volume_angkut.required' => 'satuan volume angkut masih kosong',
            'status.required' => 'status masih kosong',
        ];

        $rules = [
            'badan_usaha_id' => 'required',
            'produk' => 'required',
            'node_asal' => 'required',
            'provinsi_asal' => 'required',
            'node_tujuan' => 'required',
            'provinsi_tujuan' => 'required',
            'volume_supply' => 'required',
            'satuan_volume_supply' => 'required',
            'volume_angkut' => 'required',
            'satuan_volume_angkut' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        pengangkutan_gaskbumi::where('id', $pmb)
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
