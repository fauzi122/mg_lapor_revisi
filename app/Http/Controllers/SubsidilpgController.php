<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\Subsidilpg;
use App\Models\kuota_lpg_subsidi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Importsubsidi;
use Illuminate\Support\Facades\Crypt;

class SubsidilpgController extends Controller
{
    public function index()
    {
        $lgpsub = DB::table('subsidilpgs')
        ->select('*', DB::raw('MAX(status) as status_tertinggi'))
        ->where("jenis", "=", "LPG Subsidi Verified")
        ->groupBy('bulan')
        ->get();

        $klpgs = DB::table('subsidilpgs')
        ->select('*', DB::raw('MAX(status) as status_tertinggi'))
        ->where("jenis", "=", "Kuota LPG Subsidi")
        ->groupBy('bulan')
        ->get();

      return view('badan_usaha.subsidi.index', compact(
        'lgpsub',
        'klpgs'));
    }
    public function show_lgpsubx($id, $jenis)
    {
        $jenisx = $jenis;
        if ($jenisx=='subsidi_verified') {
            $jenis_subsidi='LPG Subsidi Verified';
        }elseif ($jenisx=='kuota_subsidi') {
            $jenis_subsidi='Kuota LPG Subsidi';
        }
        $pecah = explode(',', Crypt::decryptString($id));

        $bulan_ambil = DB::table('subsidilpgs')
            ->where("jenis", "=", $jenis_subsidi)
            ->orderBy('status', 'desc')
            ->where('bulan', $pecah[0])
            ->first();

            // Mengambil substring dari bulan
        $bulan_ambilx = $bulan_ambil ? substr($bulan_ambil->bulan, 0, 7) : '';
        $statusx = $bulan_ambil->status ?? '';

        $lgpsub = Subsidilpg::where("jenis", "=", "LPG Subsidi Verified")->get();
        $klpg = Subsidilpg::where("jenis", "=", "Kuota LPG Subsidi")->get();
        return view ('badan_usaha.subsidi.show', compact(
            'lgpsub',
            'klpg',
            'bulan_ambilx',
            'statusx',
            'jenisx'
        ));
    }
    public function simpan_lgpsubx(Request $request)
    {
        // echo json_encode($request->all());exit;
        $request->merge([
        'bulan' => $request->bulan . '-01',
        ]);

        $pesan = [
        'bulan.required' => 'bulan masih kosong',
        'provinsi.required' => 'provinsi masih kosong',
        'volume.required' => 'volume masih kosong',
        'jenis.required' => 'jenis masih kosong',
        ];

        $validatedData = $request->validate([
        'bulan' => 'required',
        'provinsi' => 'required',
        'volume' => 'required',
        'jenis' => 'required',
        ], $pesan);

        Subsidilpg::create($validatedData);

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
    public function hapus_lgpsubx(Request $request, $id)
    {
        Subsidilpg::destroy($id);
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
    public function submit_lgpsubx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update subsidilpgs set status='1' where id='$idx'");

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
    public function get_lgpsub($id)
    {
        $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = Subsidilpg::find($id);
        return response()->json(['data' => $data]);
    }
    public function update_lgpsubx(Request $request, $id)
    {
        $lgpsub = $id;
        $request->merge([
            'bulan' => $request->bulan . '-01',
            ]);
        $pesan = [
            'bulan.required' => 'bulan masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'volume.required' => 'volume masih kosong',
            'jenis.required' => 'jenis masih kosong',
        ];

        $rules = [
            'bulan' => 'required',
            'provinsi' => 'required',
            'volume' => 'required',
            'jenis' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        Subsidilpg::where('id', $lgpsub)
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
    public function simpan_klpgsx(Request $request)
    {

        $pesan = [
        'tahun.required' => 'tahun masih kosong',
        'provinsi.required' => 'provinsi masih kosong',
        'kab_kota.required' => 'kab kota masih kosong',
        'volume.required' => 'volume masih kosong',
        'jenis.required' => 'jenis masih kosong',
        ];

        $validatedData = $request->validate([
        'tahun' => 'required',
        'provinsi' => 'required',
        'kab_kota' => 'required',
        'volume' => 'required',
        'jenis' => 'required',
        ], $pesan);

        Subsidilpg::create($validatedData);

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
    public function hapus_klpgsx(Request $request, $id)
    {
        Subsidilpg::destroy($id);
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
    public function submit_klpgsx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update subsidilpgs set status='1' where id='$idx'");

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
    public function get_klpgs($id)
    {
        $data['provinsi'] = DB::select("SELECT provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = Subsidilpg::find($id);
        return response()->json(['data' => $data]);
    }
    public function get_kota($kab_kota)
    {
        // $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.kabupaten_kota = '$kabupaten_kota'");
        $data = DB::select("SELECT kotas.`nama_kota` FROM  kotas WHERE kotas.`id_prov` = (SELECT kotas.`id_prov` FROM kotas WHERE kotas.`nama_kota` = '$kab_kota')");
        // $data = Produk::get();
        return response()->json(['data' => $data]);
    }
    public function update_klpgsx(Request $request, $id)
    {
        $klpgs = $id;
        $pesan = [
            'tahun.required' => 'tahun masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kab_kota.required' => 'kab kota masih kosong',
            'volume.required' => 'volume masih kosong',
            'jenis.required' => 'jenis masih kosong',
        ];

        $rules = [
            'tahun' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'volume' => 'required',
            'jenis' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        Subsidilpg::where('id', $klpgs)
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
    public function import_lgpsubx()
    {
        $import = Excel::import(new Importsubsidi, request()->file('file'));

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
    public function import_klpgsx()
    {
        $import = Excel::import(new Importsubsidikuota, request()->file('file'));

        if ($import) {
            //redirect dengan pesan sukses
            Alert::success('success', 'Data excel berhasil diupload');
            return back();
        } else {
            //redirect dengan pesan error
            Alert::error('error', 'Data excel gagal diupload');
            return back();

            // return redirect('/show/hasil-olahan/minyak-bumi')->with(['success' => 'Data excel berhasil diupload']);
        }
    }
    public function submit_bulan_lgpsubx(Request $request, $bulan)
    {
        $bulanx = substr($bulan, 0,10);
        $jenisx = substr($bulan, 10,30);

        $jenis_subsidi='';
        if ($jenisx=='subsidi_verified') {
            $jenis_subsidi='LPG Subsidi Verified';
        }elseif ($jenisx=='kuota_subsidi') {
            $jenis_subsidi='Kuota LPG Subsidi';
        }
         $validatedData = DB::update("update subsidilpgs set status='1' where bulan='$bulanx' and jenis='$jenis_subsidi'");


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
    public function submit_bulan_klpgsx(Request $request, $bulan)
    {
        $bulanx = substr($bulan, 0,10);
        $jenisx = substr($bulan, 10,30);

        $jenis_subsidi='';
        if ($jenisx=='subsidi_verified') {
            $jenis_subsidi='LPG Subsidi Verified';
        }elseif ($jenisx=='kuota_subsidi') {
            $jenis_subsidi='Kuota LPG Subsidi';
        }
         $validatedData = DB::update("update subsidilpgs set status='1' where bulan='$bulanx' and jenis='$jenis_subsidi'");


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
    public function hapus_bulan_lgpsubx(Request $request, $bulan)
    {
        $bulanx = substr($bulan, 0,10);
        $jenisx = substr($bulan, 10,30);

        $jenis_subsidi='';
        if ($jenisx=='subsidi_verified') {
            $jenis_subsidi='LPG Subsidi Verified';
        }elseif ($jenisx=='kuota_subsidi') {
            $jenis_subsidi='Kuota LPG Subsidi';
        }
        $validatedData = DB::update("DELETE FROM subsidilpgs WHERE jenis='$jenis_subsidi' AND bulan='$bulanx'");
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
    public function hapus_bulan_klpgsx(Request $request, $bulan)
    {
        $bulanx = substr($bulan, 0,10);
        $jenisx = substr($bulan, 10,30);

        $jenis_subsidi='';
        if ($jenisx=='subsidi_verified') {
            $jenis_subsidi='LPG Subsidi Verified';
        }elseif ($jenisx=='kuota_subsidi') {
            $jenis_subsidi='Kuota LPG Subsidi';
        }
        $validatedData = DB::update("DELETE FROM subsidilpgs WHERE jenis='$jenis_subsidi' AND bulan='$bulanx'");
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
