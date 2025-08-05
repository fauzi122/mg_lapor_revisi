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
use App\Models\Meping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class HasilolahController extends Controller
{

    public function index($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
      // dd($pecah);

        $sqPenjualan = DB::table('jual_hasil_olah_bbms')
            ->select(
                '*',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
                DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
                DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
            )
            ->where('npwp', Auth::user()->npwp)
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2]);

        $penjualan = DB::table(DB::raw("({$sqPenjualan->toSql()}) as sub"))
            ->mergeBindings($sqPenjualan)
            ->where('rn', 1)
            ->get();

        $sqPasok = DB::table('pasokan_hasil_olah_bbms')
            ->select(
                '*',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
                DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
                DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
            )
            ->where('npwp', Auth::user()->npwp)
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2]);

        $pasok = DB::table(DB::raw("({$sqPasok->toSql()}) as sub"))
            ->mergeBindings($sqPasok)
            ->where('rn', 1)
            ->get();

        $sub_page = Meping::select('nama_opsi')
            ->where('id_sub_page', $pecah[2])
            ->where('id_template', $pecah[4])
            ->first();
        
        return view('badan_usaha.niaga.hasil_olahan.index', compact(
            'penjualan',
            'pasok', 
            'pecah', 
            'sub_page'
        ));
    }

    public function simpan_Penjualan_Ho()
    {
        // Implementasi fungsi simpan_Penjualan_Ho()
    }

    public function show_jholbx($id, $hasilolah)
    {
        $hasilolahx = $hasilolah;
        $pecah = explode(',', Crypt::decryptString($id));
        $npwp = Auth::user()->npwp;

        $bulan_ambil_penjualan_hasilolah = DB::table('jual_hasil_olah_bbms')
        ->where('npwp', $npwp)
        ->where('bulan', $pecah[3])
        ->where('id_permohonan', $pecah[0])
        ->where('id_sub_page', $pecah[2])
        ->orderBy('status', 'desc')
        ->first();
        

        $bulan_ambil_pasok_hasilolah = DB::table('pasokan_hasil_olah_bbms')
        ->where('npwp', $npwp)
        ->where('bulan', $pecah[3])
        ->where('id_permohonan', $pecah[0])
        ->where('id_sub_page', $pecah[2])
        ->orderBy('status', 'desc')
        ->first();

        // Mengambil substring dari bulan
        $bulan_ambil_penjualan_hasilolahx = $bulan_ambil_penjualan_hasilolah ? substr($bulan_ambil_penjualan_hasilolah->bulan, 0, 7) : '';
        $statuspenjualan_hasilolahx = $bulan_ambil_penjualan_hasilolah->status ?? '';

        $bulan_ambil_pasok_hasilolahx = $bulan_ambil_pasok_hasilolah ? substr($bulan_ambil_pasok_hasilolah->bulan, 0, 7) : '';
        $statuspasok_hsilolahx = $bulan_ambil_pasok_hasilolah->status ?? '';

        if (count($pecah) > 4) {
            $filterBy = substr($pecah[3], 0, 4);
        } else {
            $filterBy = $pecah[3];
        }

        $show_jholbx = Jual_hasil_olah_bbm::where([
            ['bulan', 'like', "%". $filterBy ."%"],
            'npwp' => $pecah[1],
            'id_permohonan' => $pecah[0],
            'id_sub_page' => $pecah[2],
        ])->orderBy('status', 'desc')->get();

        $pasokan = Pasokan_hasil_olah_bbm::where([
            ['bulan', 'like', "%". $filterBy ."%"],
            'npwp' => $pecah[1],
            'id_permohonan' => $pecah[0],
            'id_sub_page' => $pecah[2],
        ])->orderBy('status', 'desc')->get();

        $hargabbmjbu = Harga_bbm_jbu::where('npwp',Auth::user()->npwp)->get();

        return view('badan_usaha.niaga.hasil_olahan.show', compact(
            'show_jholbx',
            'pasokan',
            'hargabbmjbu',
            'bulan_ambil_penjualan_hasilolahx',
            'bulan_ambil_pasok_hasilolahx',
            'statuspenjualan_hasilolahx',
            'statuspasok_hsilolahx',
            'hasilolahx',
            'pecah'
        ));
    }

    // Fungsi untuk menyimpan data penjualan hasil olahan BBM
    public function simpan_jholbx(Request $request)
    {
        $request->merge([
            'bulan' => $request->bulan . '-01',
        ]);

        $pesan = [
            'npwp.required' => 'npwp masih kosong',
            'id_permohonan.required' => 'id_permohonan masih kosong',
            'id_sub_page.required' => 'id_sub_page masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',

        ];

        $validatedData = $request->validate([
            'npwp' => 'required',
            'id_permohonan' => 'required',
            'id_sub_page' => 'required',
            'bulan' => 'required',
            'produk' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'sektor' => 'required',
            'volume' => 'required',
            'satuan' => 'required',

        ], $pesan);

        
        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        // var_dump($request->bulan.'01');
        // die;
        $npwp = Auth::user()->npwp;

        $cekdb = DB::table('jual_hasil_olah_bbms')
            ->where('npwp', $npwp)
            ->where('id_permohonan', $request->id_permohonan)
            ->where('id_sub_page', $request->id_sub_page)
            ->where('bulan', $request->bulan)
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

        // $validatedData = Jual_hasil_olah_bbm::create([
        //     'npwp' =>  $request->npwp,
        //     'id_permohonan' => $request->id_permohonan,
        //     'id_sub_page' => $request->id_sub_page,
        //     'bulan' => $request->bulan.'-01',
        //     'produk' => $request->produk,
        //     'provinsi' => $request->provinsi,
        //     'kabupaten_kota' => $request->kabupaten_kota,
        //     'sektor' => $request->sektor,
        //     'volume' => $request->volume,
        //     'satuan' => $request->satuan,

        //   ]);

        $created = Jual_hasil_olah_bbm::create($sanitizedData);

        if ($created) {
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
        $npwp = Auth::user()->npwp;
        $id_permohonan = $request->id_permohonan;
        $id_sub_page = $request->id_sub_page;

        $cekdb = DB::table('jual_hasil_olah_bbms')
            ->where('npwp', $npwp)
            ->where('id_permohonan', $id_permohonan)
            ->where('id_sub_page', $id_sub_page)
            ->where('bulan', $bulan)
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

            $import = Excel::import(new Importjualhasil($bulan, $id_permohonan, $id_sub_page), request()->file('file'));
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
        $data['provinsi'] = DB::select("SELECT DISTINCT ON (name) id, name FROM provinces ORDER BY name, id");
        $data['sektor'] = DB::select("SELECT sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
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
            // 'npwp.required' => 'npwp masih kosong',
            // 'id_permohonan.required' => 'id_permohonan masih kosong',
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
            // 'npwp' => 'required',
            // 'id_permohonan' => 'required',
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

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        Jual_hasil_olah_bbm::where('id', $Jual_hasil_olah_bbm)
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

    public function submit_bulan_jholbx(Request $request, $id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];
        $now = Carbon::now();

        $affected = DB::table('jual_hasil_olah_bbms')
            ->where('bulan', $bulanx)
            ->where('npwp', $npwp)
            ->where('id_permohonan', $id_permohonan)
            ->where('id_sub_page', $id_sub_page)
            ->update(['status' => '1', 'tgl_kirim' => $now]);

        if ($affected) {
        //redirect dengan pesan sukses
        Alert::success('success', 'Data berhasil dikirim');
        return back();
        } else {
        //redirect dengan pesan error
        Alert::error('error', 'Data gagal dikirim');
        return back();
        }
    }

    public function hapus_bulan_jholbx(Request $request, $id)
    {
        // Dekripsi ID dan pecah menjadi array
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];

        // Menggunakan query builder untuk menghapus data
        $affected = DB::table('jual_hasil_olah_bbms')
            ->where('npwp', $npwp)
            ->where('bulan', $bulanx)
            ->where('id_permohonan', $id_permohonan)
            ->where('id_sub_page', $id_sub_page)
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
