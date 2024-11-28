<?php

namespace App\Http\Controllers\bu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\PenjualanGBP;
use App\Models\pasokanGBP;
use App\Imports\Importgbppenjualan;
use App\Imports\Importgbppasok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class GBPController extends Controller
{
    public function index()
    {   
        $gbp = DB::table('penjualan_g_b_p_s')
        ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
        ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
        ->groupBy('bulan')
        ->get();

        $gbp_pasok = DB::table('pasokan_g_b_p_s')
        ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
        ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
        ->groupBy('bulan')
        ->get();

        return view('badan_usaha.niaga.gas_bumi.index', compact(
            'gbp',
            'gbp_pasok'));
    }
    public function show_gbpx($id,$gbpx)
    {
        // dd('tes');
        // die;
        $gbpxy=$gbpx;

        $pecah = explode(',', Crypt::decryptString($id));
        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $bulan_ambil_penjualan_gbp = DB::table('penjualan_g_b_p_s')
        ->where('badan_usaha_id', $badan_usaha_id)
        ->where('bulan', $pecah[0])
        ->first();

        $bulan_ambil_pasok_gbp = DB::table('pasokan_g_b_p_s')
        ->where('badan_usaha_id', $badan_usaha_id)
        ->where('bulan', $pecah[0])
        ->first();

        // Mengambil substring dari bulan
        $bulan_ambil_penjualan_gbpx = $bulan_ambil_penjualan_gbp ? substr($bulan_ambil_penjualan_gbp->bulan, 0, 7) : '';
        $statuspenjualan_gbpx = $bulan_ambil_penjualan_gbp->status ?? '';

        $bulan_ambil_pasok_gbpx = $bulan_ambil_pasok_gbp ? substr($bulan_ambil_pasok_gbp->bulan, 0, 7) : '';
        $statuspasok_gbpx = $bulan_ambil_pasok_gbp->status ?? '';

        $gbp = PenjualanGBP::where([
            'bulan' => $pecah[0],
            'badan_usaha_id' => $pecah[1]
        ])->orderBy('status', 'desc')->get();

        $pasokan = pasokanGBP::where([
            'bulan' => $pecah[0],
            'badan_usaha_id' => $pecah[1]
        ])->orderBy('status', 'desc')->get();

        return view ('badan_usaha.niaga.gas_bumi.show', compact(
            'gbp',
            'pasokan',
            'bulan_ambil_penjualan_gbpx',
            'bulan_ambil_pasok_gbpx',
            'statuspenjualan_gbpx',
            'statuspasok_gbpx',
            'gbpxy'
        ));
    }
    public function simpan_gbpx(Request $request)
    {
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
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
            'badan_usaha_id' => 'required',
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

        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $cekdb = DB::table('penjualan_g_b_p_s')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $request->bulan . '-01')
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

            $validatedData = PenjualanGBP::create([
                'badan_usaha_id' => $request->badan_usaha_id,
                'bulan' => $request->bulan.'-01',
                'provinsi' => $request->provinsi,
                'kabupaten_kota' => $request->kabupaten_kota,
                'sektor' => $request->sektor,
                'konsumen' => $request->konsumen,
                'jumlah_hari_penyaluran' => $request->jumlah_hari_penyaluran,
                'ghv' => $request->ghv,
                'volume_mmbtu' => $request->volume_mmbtu,
                'volume_mscf' => $request->volume_mscf,
                'volume_m3' => $request->volume_m3,
                'harga' => $request->harga,
                'keterangan' => $request->keterangan,
            
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
    public function hapus_bulan_gbpx(Request $request, $bulan)
    {
        $bulanx = $bulan;
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("delete from penjualan_g_b_p_s where badan_usaha_id='$badan_usaha_id' and bulan='$bulanx'");
        if ($validatedData) {
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
        $data['sektor'] = DB::select("SELECT sektors.id, sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
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
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'nama_pemasok.required' => 'nama pemasok masih kosong',
            'volume_mmbtu.required' => 'volume mmbtu masih kosong',
            'volume_mscf.required' => 'volume mscf masih kosong',
            'volume_m3.required' => 'volume m3 masih kosong',
            'harga.required' => 'harga masih kosong',
        ];

        $validatedData = $request->validate([
            'badan_usaha_id' => 'required',
            'bulan' => 'required',
            'nama_pemasok' => 'required',
            'volume_mmbtu' => 'required',
            'volume_mscf' => 'required',
            'volume_m3' => 'required',
            'harga' => 'required',
        ], $pesan);

        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $cekdb = DB::table('pasokan_g_b_p_s')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $request->bulan . '-01')
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

            $validatedData = pasokanGBP::create([
                'badan_usaha_id' => $request->badan_usaha_id,
                'bulan' => $request->bulan.'-01',
                'nama_pemasok' => $request->nama_pemasok,
                'volume_mmbtu' => $request->volume_mmbtu,
                'volume_mscf' => $request->volume_mscf,
                'volume_m3' => $request->volume_m3,
                'harga' => $request->harga,
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
    public function hapus_pasok_bulan_gbpx(Request $request, $bulan)
    {
        // pasokanGBP::destroy($id);
        // dd('tes');
        // die;
        $bulanx = $bulan;
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("delete from pasokan_g_b_p_s where badan_usaha_id='$badan_usaha_id' and bulan='$bulanx'");
        if ($validatedData) {
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
       $now = Carbon::now();
        $validatedData = DB::update("update pasokan_g_b_p_s set status='1', tgl_kirim='$now' where id='$idx'");

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
       $now = Carbon::now();
        $validatedData = DB::update("update penjualan_g_b_p_s set status='1', tgl_kirim='$now' where id='$idx'");

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
    public function import_gbpx(Request $request)
    {
        $bulan = $request->bulan . "-01";
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $cekdb = DB::table('penjualan_g_b_p_s')
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
        $import = Excel::import(new Importgbppenjualan, request()->file('file'));

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
    public function import_gbp_pasokx(Request $request)
    {
        $bulan = $request->bulan . "-01";
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
        $import = Excel::import(new Importgbppasok, request()->file('file'));

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
    public function submit_bulan_gbpx(Request $request, $bulan)
    {
        $bulanx = $bulan;
        // dd($bulanx);
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $now = Carbon::now();
        $validatedData = DB::update("update penjualan_g_b_p_s set status='1', tgl_kirim='$now' where bulan='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
    public function submit_bulan_pasok_gbpx(Request $request, $bulan)
    {
        $bulanx = $bulan;
        // dd($bulanx);
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $now = Carbon::now();
        $validatedData = DB::update("update pasokan_g_b_p_s set status='1', tgl_kirim='$now' where bulan='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
