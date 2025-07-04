<?php

namespace App\Http\Controllers\bu;

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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Importlngpenjualan;
use App\Imports\Importlngpasok;
use App\Models\Meping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class LngController extends Controller
{
    public function index($id)
    {
        // $pm = Penjualan_lng::where('npwp', Auth::user()->npwp)
        //     ->groupBy('bulan')->get();
        $pecah = explode(',', Crypt::decryptString($id));
        
        // dd($pecah);
        $qLngPenjualan = DB::table('penjualan_lngs')
            ->select(
                '*',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
                DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
                DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
            )
            ->where('npwp', Auth::user()->npwp)
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2]);

        $lngpenjualan = DB::table(DB::raw("({$qLngPenjualan->toSql()}) as sub"))
            ->mergeBindings($qLngPenjualan)
            ->where('rn', 1)
            ->get();
        
        $qLngPasok = DB::table('pasokanlngs')
            ->select(
                '*',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
                DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
                DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
            )
            ->where('npwp', Auth::user()->npwp)
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2]);

        $pasoklng = DB::table(DB::raw("({$qLngPasok->toSql()}) as sub"))
            ->mergeBindings($qLngPasok)
            ->where('rn', 1)
            ->get();
            
        $sub_page = Meping::select('nama_opsi')
        ->where('id_sub_page', $pecah[2])
        ->where('id_template', $pecah[4])
        ->first();

        return view('badan_usaha.niaga.lng.index', compact(
            'lngpenjualan',
            'pasoklng',
            'pecah',
            'sub_page'
        ));
    }
    public function show_lngx($id, $lng, $filter = null)
    {
        $lngx = $lng;

        // dd($lngx);
        // die;
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $npwp = Auth::user()->npwp;

        $bulan_ambil_penjualan_lng = DB::table('penjualan_lngs')
            ->where('npwp', $npwp)
            ->where('bulan', $pecah[3])
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2])
            ->orderBy('status', 'desc')
            ->first();

        $bulan_ambil_pasok_lng = DB::table('pasokanlngs')
            ->where('npwp', $npwp)
            ->where('bulan', $pecah[3])
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2])
            ->orderBy('status', 'desc')
            ->first();

        // Mengambil substring dari bulan
        $bulan_ambil_penjualan_lngx = $bulan_ambil_penjualan_lng ? substr($bulan_ambil_penjualan_lng->bulan, 0, 7) : '';
        $statuspenjualan_lngx = $bulan_ambil_penjualan_lng->status ?? '';

        $bulan_ambil_pasok_lngx = $bulan_ambil_pasok_lng ? substr($bulan_ambil_pasok_lng->bulan, 0, 7) : '';
        $statuspasok_lngx = $bulan_ambil_pasok_lng->status ?? '';

        if ($filter && $filter === "tahun") {
            $filterBy = substr($pecah[3], 0, 4);
        } else {
            $filterBy = $pecah[3];
        }

        $lng = Penjualan_lng::where([
            ['bulan', 'like', "%". $filterBy ."%"],
            'npwp' => $pecah[1],
            'id_permohonan' => $pecah[0],
            'id_sub_page' => $pecah[2],
            
        ])->orderBy('status', 'desc')->get();

        $pasok_lng = Pasokanlng::where([
            ['bulan', 'like', "%". $filterBy ."%"],
            'npwp' => $pecah[1],
            'id_permohonan' => $pecah[0],
            'id_sub_page' => $pecah[2],
        ])->orderBy('status', 'desc')->get();


        return view('badan_usaha.niaga.lng.show', compact(
            'lng',
            'pasok_lng',
            'bulan_ambil_penjualan_lngx',
            'bulan_ambil_pasok_lngx',
            'statuspenjualan_lngx',
            'statuspasok_lngx',
            'lngx',
            'pecah'
        ))->with('id_permohonan', $pecah[2]);
    }
    public function simpan_lngx(Request $request)
    {
        // dd($request->all());

        $pesan = [
            'npwp.required' => 'npwp masih kosong',
            'id_permohonan.required' => 'id_permohonan masih kosong',
            'id_sub_page.required' => 'id_sub_page masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten / kota masih kosong',
            'produk.required' => 'produk masih kosong',
            'konsumen.required' => 'konsumen masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'biaya_kompresi.required' => 'biaya kompresi masih kosong',
            'satuan_biaya_kompresi.required' => 'satuan biaya kompresi masih kosong',
            'biaya_penyimpanan.required' => 'biaya penyimpanan masih kosong',
            'satuan_biaya_penyimpanan.required' => 'satuan biaya penyimpanan masih kosong',
            'biaya_pengangkutan.required' => 'biaya pengangkutan masih kosong',
            'satuan_biaya_pengangkutan.required' => 'satuan biaya pengangkutan masih kosong',
            'biaya_niaga.required' => 'biaya niaga masih kosong',
            'satuan_biaya_niaga.required' => 'satuan biaya niaga masih kosong',
            'harga_bahan_baku' => 'Harga bahan baku masih kosong',
            'satuan_harga_bahan_baku.required' => 'satuan harga bahan baku masih kosong',
            'pajak.required' => 'pajak masih kosong',
            'satuan_pajak.required' => 'satuan pajak masih kosong',
            'harga_jual.required' => 'harga jual masih kosong',
            'satuan_harga_jual.required' => 'satuan harga jual masih kosong',
        ];

        $validatedData = $request->validate([

            'npwp' => 'required',
            'id_permohonan' => 'required',
            'id_sub_page' => 'required',
            'bulan' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'produk' => 'required',
            'konsumen' => 'required',
            'sektor' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'biaya_kompresi' => 'required',
            'satuan_biaya_kompresi' => 'required',
            'biaya_penyimpanan' => 'required',
            'satuan_biaya_penyimpanan' => 'required',
            'biaya_pengangkutan' => 'required',
            'satuan_biaya_pengangkutan' => 'required',
            'biaya_niaga' => 'required',
            'satuan_biaya_niaga' => 'required',
            'harga_bahan_baku' => 'required',
            'satuan_harga_bahan_baku' => 'required',
            'pajak' => 'required',
            'satuan_pajak' => 'required',
            'harga_jual' => 'required',
            'satuan_harga_jual' => 'required',
        ], $pesan);

        $npwp = Auth::user()->npwp;

        $cekdb = DB::table('penjualan_lngs')
            ->where('npwp', $npwp)
            ->where('id_permohonan', $request->id_permohonan)
            ->where('bulan', $request->bulan . '-01')
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }
        $validatedData = Penjualan_lng::create([
            'npwp' =>  $request->npwp,
            'id_permohonan' =>  $request->id_permohonan,
            'id_sub_page' =>  $request->id_sub_page,
            'bulan' => $request->bulan . '-01',
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'produk' => $request->produk,
            'konsumen' => $request->konsumen,
            'sektor' => $request->sektor,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
            'biaya_kompresi' => $request->biaya_kompresi,
            'satuan_biaya_kompresi' => $request->satuan_biaya_kompresi,
            'biaya_penyimpanan' => $request->biaya_penyimpanan,
            'satuan_biaya_penyimpanan' => $request->satuan_biaya_penyimpanan,
            'biaya_pengangkutan' => $request->biaya_pengangkutan,
            'satuan_biaya_pengangkutan' => $request->satuan_biaya_pengangkutan,
            'biaya_niaga' => $request->biaya_niaga,
            'satuan_biaya_niaga' => $request->satuan_biaya_niaga,
            'harga_bahan_baku' => $request->harga_bahan_baku,
            'satuan_harga_bahan_baku' => $request->satuan_harga_bahan_baku,
            'pajak' => $request->pajak,
            'satuan_pajak' => $request->satuan_pajak,
            'harga_jual' => $request->harga_jual,
            'satuan_harga_jual' => $request->satuan_harga_jual,

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
        $data['provinsi'] = DB::select("SELECT DISTINCT ON (name) id, name FROM provinces ORDER BY name, id");
        $data['sektor'] = DB::select("SELECT sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
        $data['find'] = Penjualan_lng::find($id);
        return response()->json(['data' => $data]);

        // $data = Penjualan_lng::find($id);
        // return response()->json(['data' => $data]);
    }
    public function update_lngx(Request $request, $id)
    {
        // echo json_encode($request->all());exit;
        $penjualan_lng = $id;
        $pesan = [
            // 'npwp.required' => 'npwp masih kosong',
            // 'bulan.required' => 'bulan masih kosong',
            'provinsi.required' => 'provinsi masih kosong',
            'kabupaten_kota.required' => 'kabupaten / kota masih kosong',
            'produk.required' => 'produk masih kosong',
            'konsumen.required' => 'konsumen masih kosong',
            'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'biaya_kompresi.required' => 'biaya kompresi masih kosong',
            'satuan_biaya_kompresi.required' => 'satuan biaya kompresi masih kosong',
            'biaya_penyimpanan.required' => 'biaya penyimpanan masih kosong',
            'satuan_biaya_penyimpanan.required' => 'satuan biaya penyimpanan masih kosong',
            'biaya_pengangkutan.required' => 'biaya pengangkutan masih kosong',
            'satuan_biaya_pengangkutan.required' => 'satuan biaya pengangkutan masih kosong',
            'biaya_niaga.required' => 'biaya niaga masih kosong',
            'satuan_biaya_niaga.required' => 'satuan biaya niaga masih kosong',
            'harga_bahan_baku' => 'Harga bahan baku masih kosong',
            'satuan_harga_bahan_baku.required' => 'satuan harga bahan baku masih kosong',
            'pajak.required' => 'pajak masih kosong',
            'satuan_pajak.required' => 'satuan pajak masih kosong',
            'harga_jual.required' => 'harga jual masih kosong',
            'satuan_harga_jual.required' => 'satuan harga jual masih kosong',
        ];

        $rules = [
            // 'npwp' => 'required',
            // 'bulan' => 'required',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'produk' => 'required',
            'konsumen' => 'required',
            'sektor' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'biaya_kompresi' => 'required',
            'satuan_biaya_kompresi' => 'required',
            'biaya_penyimpanan' => 'required',
            'satuan_biaya_penyimpanan' => 'required',
            'biaya_pengangkutan' => 'required',
            'satuan_biaya_pengangkutan' => 'required',
            'biaya_niaga' => 'required',
            'satuan_biaya_niaga' => 'required',
            'harga_bahan_baku' => 'required',
            'satuan_harga_bahan_baku' => 'required',
            'pajak' => 'required',
            'satuan_pajak' => 'required',
            'harga_jual' => 'required',
            'satuan_harga_jual' => 'required',
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
        // echo json_encode($request->all());exit;
        $pesan = [
            'npwp.required' => 'npwp masih kosong',
            'id_permohonan.required' => 'id_permohonan masih kosong',
            'id_sub_page.required' => 'id_sub_page masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'nama_pemasok.required' => 'nama_pemasok masih kosong',
            'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'harga_gas.required' => 'harga_gas masih kosong',
            'satuan_harga_gas.required' => 'Satuan harga gas masih kosong',
        ];

        $validatedData = $request->validate([
            'npwp' => 'required',
            'id_permohonan' => 'required',
            'id_sub_page' => 'required',
            'bulan' => 'required',
            'produk' => 'required',
            'nama_pemasok' => 'required',
            'kategori_pemasok' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'harga_gas' => 'required',
            'satuan_harga_gas' => 'required',
        ], $pesan);

        $npwp = Auth::user()->npwp;

        $cekdb = DB::table('pasokanlngs')
            ->where('npwp', $npwp)
            ->where('id_permohonan', $request->id_permohonan)
            ->where('bulan', $request->bulan . '-01')
            ->orderBy('status', 'desc')
            ->first();
        // echo json_encode($cekdb);
        // exit;

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }


        $validatedData = Pasokanlng::create([
            'npwp' =>  $request->npwp,
            'id_permohonan' =>  $request->id_permohonan,
            'id_sub_page' =>  $request->id_sub_page,
            'bulan' => $request->bulan . '-01',
            'produk' => $request->produk,
            'nama_pemasok' => $request->nama_pemasok,
            'kategori_pemasok' => $request->kategori_pemasok,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
            'harga_gas' => $request->harga_gas,
            'satuan_harga_gas' => $request->satuan_harga_gas,

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
        // echo json_encode($request->all());exit;
        $penjualan_lng = $id;
        $pesan = [
            // 'npwp.required' => 'npwp masih kosong',
            // 'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'nama_pemasok.required' => 'nama_pemasok masih kosong',
            'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
            'volume.required' => 'volume masih kosong',
            'satuan.required' => 'satuan masih kosong',
            'harga_gas.required' => 'harga_gas masih kosong',
            'satuan_harga_gas.required' => 'Satuan harga gas masih kosong',
        ];

        $rules = [
            // 'npwp' => 'required',
            // 'bulan' => 'required',
            'produk' => 'required',
            'nama_pemasok' => 'required',
            'kategori_pemasok' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'harga_gas' => 'required',
            'satuan_harga_gas' => 'required',
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
        $data = DB::select(
            "SELECT nama_kota 
            FROM kotas 
            WHERE id_prov = (
                SELECT id_prov 
                FROM kotas 
                WHERE nama_kota = ?
            )",
            [$kabupaten_kota]
        );
        // $data = Produk::get();
        return response()->json(['data' => $data]);
    }
    public function submit_lngx(Request $request, $id)
    {
        $idx = $id;
        $now = Carbon::now();
        $validatedData = DB::update("update penjualan_lngs set status='1', tgl_kirim='$now' where id='$idx'");

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
    public function submit_pasok_lngx(Request $request, $id)
    {
        $idx = $id;
        $now = Carbon::now();
        $validatedData = DB::update("update pasokanlngs set status='1', tgl_kirim='$now' where id='$idx'");

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
    public function importlngpenx(Request $request)
    {
        $id_permohonan = $request->id_permohonan;
        $id_sub_page = $request->id_sub_page;
        $bulan = $request->bulan . "-01";
        $npwp = Auth::user()->npwp;
        $cekdb = DB::table('penjualan_lngs')
            ->where('npwp', $npwp)
            ->where('bulan', $bulan)
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }
        $import = Excel::import(new Importlngpenjualan($bulan,$id_permohonan,$id_sub_page), request()->file('file'));

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
    public function importlngpasokx(Request $request)
    {
        $id_permohonan = $request->id_permohonan;
        $id_sub_page = $request->id_sub_page;
        $bulan = $request->bulan . "-01";
        $npwp = Auth::user()->npwp;
        $cekdb = DB::table('pasokanlngs')
            ->where('npwp', $npwp)
            ->where('bulan', $bulan)
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }
        $import = Excel::import(new Importlngpasok($bulan,$id_permohonan, $id_sub_page), request()->file('file'));

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
    public function submit_bulan_lngx(Request $request, $id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];
        $now = Carbon::now();
    
        // Update data penjualan_lngs dengan id_permohonan
        $affected = DB::table('penjualan_lngs')
            ->where('bulan', $bulanx)
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

    public function submit_bulan_pasok_lngx(Request $request, $id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];
        $now = Carbon::now();
    
        // Update data pasokanlngs dengan id_permohonan
        $affected = DB::table('pasokanlngs')
            ->where('bulan', $bulanx)
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
    
    public function hapus_bulan_lngx(Request $request, $id)
    {
        // Dekripsi ID dan pecah menjadi array
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];
    
        // Menggunakan query builder untuk menghapus data
        $affected = DB::table('penjualan_lngs')
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

    public function hapus_bulan_pasok_lngx(Request $request, $id)
    {
        // Dekripsi ID dan pecah menjadi array
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];

        // Menggunakan query builder untuk menghapus data
        $affected = DB::table('pasokanlngs')
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
