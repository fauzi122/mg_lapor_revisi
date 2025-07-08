<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Pasokan_hasil_olah_bbm;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Jual_hasil_olah_bbm;
use Illuminate\Support\Facades\DB;
use App\Imports\Importjualhasil;
use Illuminate\Http\Request;
use App\Models\Harga_bbm_jbu;
use App\Models\Produk;
use App\Models\Izin;
use App\Model\province;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class HasilolahController extends Controller
{

    public function index()
    {
        // tes
        $penjualan = DB::table('jual_hasil_olah_bbms')
        ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
        ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
        ->groupBy('bulan')
        ->get();

        $pasok = DB::table('pasokan_hasil_olah_bbms')
        ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
        ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
        ->groupBy('bulan')
        ->get();

        return view('badan_usaha.niaga.hasil_olahan.index', compact(
            'penjualan',
            'pasok'));
    }

    public function simpan_Penjualan_Ho()
    {
        // Implementasi fungsi simpan_Penjualan_Ho()
    }

    public function show_jholbx($id,$hasilolah)
    {
        $hasilolahx=$hasilolah;
        $pecah = explode(',', Crypt::decryptString($id));
        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $bulan_ambil_penjualan_hasilolah = DB::table('jual_hasil_olah_bbms')
        ->where('badan_usaha_id', $badan_usaha_id)
        ->where('bulan', $pecah[0])
        ->first();

        $bulan_ambil_pasok_hasilolah = DB::table('pasokan_hasil_olah_bbms')
        ->where('badan_usaha_id', $badan_usaha_id)
        ->where('bulan', $pecah[0])
        ->first();

        // Mengambil substring dari bulan
        $bulan_ambil_penjualan_hasilolahx = $bulan_ambil_penjualan_hasilolah ? substr($bulan_ambil_penjualan_hasilolah->bulan, 0, 7) : '';
        $statuspenjualan_hasilolahx = $bulan_ambil_penjualan_hasilolah->status ?? '';

        $bulan_ambil_pasok_hasilolahx = $bulan_ambil_pasok_hasilolah ? substr($bulan_ambil_pasok_hasilolah->bulan, 0, 7) : '';
        $statuspasok_hsilolahx = $bulan_ambil_pasok_hasilolah->status ?? '';

        $show_jholbx = Jual_hasil_olah_bbm::where([
            'bulan' => $pecah[0],
            'badan_usaha_id' => $pecah[1]
        ])->orderBy('status', 'desc')->get();

        $pasokan = Pasokan_hasil_olah_bbm::where([
            'bulan' => $pecah[0],
            'badan_usaha_id' => $pecah[1]
        ])->orderBy('status', 'desc')->get();

        $hargabbmjbu = Harga_bbm_jbu::where('badan_usaha_id',Auth::user()->badan_usaha_id)->get();

        return view('badan_usaha.niaga.hasil_olahan.show', compact(
            'show_jholbx',
            'pasokan',
            'hargabbmjbu',
            'bulan_ambil_penjualan_hasilolahx',
            'bulan_ambil_pasok_hasilolahx',
            'statuspenjualan_hasilolahx',
            'statuspasok_hsilolahx',
            'hasilolahx'
        ));
    }

    public function simpan_jholbx(Request $request)
    {
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'izin_id.required' => 'izin_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',

        ];

        $validatedData = $request->validate([
            'badan_usaha_id' => 'required',
            'izin_id' => 'required',
            'bulan' => 'required',
            'produk' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'sektor' => 'required',
            'volume' => 'required',
            'satuan' => 'required',

        ], $pesan);

        // var_dump($request->bulan.'01');
        // die;
        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $cekdb = DB::table('jual_hasil_olah_bbms')
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

        $validatedData = Jual_hasil_olah_bbm::create([
            'badan_usaha_id' =>  $request->badan_usaha_id,
            'izin_id' => $request->izin_id,
            'bulan' => $request->bulan.'-01',
            'produk' => $request->produk,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'sektor' => $request->sektor,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
         
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

    public function hapus_jholbx(Request $request, $id)
    {
        Jual_hasil_olah_bbm::destroy($id);
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
        $show_jholbx = Jual_hasil_olah_bbm::find($id);
        return response()->json([
            'data' => $show_jholbx
        ]);
    }

    public function importjholbx(Request $request)
    {
        $bulan = $request->bulan . "-01";
        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $cekdb = DB::table('jual_hasil_olah_bbms')
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

            $import = Excel::import(new Importjualhasil($bulan), request()->file('file'));
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

    public function get_penjualan_ho($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
        $data['sektor'] = DB::select("SELECT sektors.id, sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
        $data['find'] = Jual_hasil_olah_bbm::find($id);
        return response()->json(['data' => $data]);
        // $data = Jual_hasil_olah_bbm::find($id);
        // return response()->json(['data' => $data]);
    }

    public function update_jholbx(Request $request, $id)
    {
        $Jual_hasil_olah_bbm = $id;
        $pesan = [
            // 'id.required' => 'id masih kosong',
            // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            // 'izin_id.required' => 'izin_id masih kosong',
            // 'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            // 'status.required' => 'status masih kosong',
            // 'catatan.required' => 'catatan masih kosong',
            // 'petugas.required' => 'petugas masih kosong',
        ];

        $rules = [
            // 'id' => 'required',
            // 'badan_usaha_id' => 'required',
            // 'izin_id' => 'required',
            // 'bulan' => 'required',
            'produk' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'sektor' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            // 'status' => 'required',
            // 'catatan' => 'required',
            // 'petugas' => 'required',

        ];

        $validatedData = $request->validate($rules, $pesan);

        Jual_hasil_olah_bbm::where('id', $Jual_hasil_olah_bbm)
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

    public function get_produk()
    {
   
        $data = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        // $data = Produk::get();
        return response()->json(['data' => $data]);
    }

    public function get_satuan($name)
    {
        $data = DB::select("SELECT produks.satuan FROM produks WHERE produks.name = '$name'");
        // $data = Produk::get();
        return response()->json(['data' => $data]);
    }

    public function get_provinsi()
    {
        $data = DB::select("SELECT provinces.id, provinces.name FROM provinces ORDER BY provinces.name ASC");
        // $data = province::get();
        return response()->json(['data' => $data]);
    }

    public function get_kota($id_prov)
    {
        $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.id_prov = '$id_prov'");
        // $data = Produk::get();
        return response()->json(['data' => $data]);
    }

    public function submit_jholbx(Request $request, $id)
    {
       $idx=$id;
       $now = Carbon::now();
        $validatedData = DB::update("update jual_hasil_olah_bbms set status='1', tgl_kirim='$now' where id='$idx'");

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

    public function submit_bulan_jholbx(Request $request, $bulan)
    {
        $bulanx = $bulan;
        // dd($bulanx);
        // die;
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $now = Carbon::now();
        $validatedData = DB::update("UPDATE jual_hasil_olah_bbms SET status='1', tgl_kirim='$now' WHERE bulan='$bulanx' AND badan_usaha_id='$badan_usaha_id'");

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

    public function hapus_bulan_jholbx(Request $request, $bulan)
    {
        $bulanx = $bulan;
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("DELETE FROM jual_hasil_olah_bbms WHERE badan_usaha_id='$badan_usaha_id' AND bulan='$bulanx'");
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
