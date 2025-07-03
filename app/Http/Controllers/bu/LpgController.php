<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjualan_lpg;
use App\Models\PasokanLPG;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Crypt;
use App\Imports\Importlpgpenjualan;
use App\Imports\Importlpgpasok;
use App\Models\Meping;
use Carbon\Carbon;

class LpgController extends Controller
{

  public function index($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));
      // dd($pecah);

    $qLpgPenjualan = DB::table('penjualan_lpgs')
        ->select(
            '*',
            DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
            DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
            DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
        )
        ->where('npwp', Auth::user()->npwp)
        ->where('id_permohonan', $pecah[0])
        ->where('id_sub_page', $pecah[2]);

    $lpgpenjualan = DB::table(DB::raw("({$qLpgPenjualan->toSql()}) as sub"))
        ->mergeBindings($qLpgPenjualan)
        ->where('rn', 1)
        ->get();

    $qLpgPasok = DB::table('pasokan_l_p_g_s')
        ->select(
            '*',
            DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
            DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
            DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
        )
        ->where('npwp', Auth::user()->npwp)
        ->where('id_permohonan', $pecah[0])
        ->where('id_sub_page', $pecah[2]);

    $lpgasok = DB::table(DB::raw("({$qLpgPasok->toSql()}) as sub"))
        ->mergeBindings($qLpgPasok)
        ->where('rn', 1)
        ->get();

    $sub_page = Meping::select('nama_opsi')
    ->where('id_sub_page', $pecah[2])
    ->where('id_template', $pecah[4])
    ->first();

    return view('badanUsaha.niaga.lpg.index', compact(
      'lpgpenjualan',
      'lpgasok',
      'pecah',
      'sub_page'
    ));
  }

  public function simpan_Penjualan_Ho()
  {
    // Implementasi fungsi simpan_Penjualan_Ho()
  }

  public function show_lpg($id, $lpg, $filter = null)
  {
    $lpgx = $lpg;
    $pecah = explode(',', Crypt::decryptString($id));
    $npwp = Auth::user()->npwp;

    $bulan_ambil_penjualan_lpg = DB::table('penjualan_lpgs')
      ->where('npwp', $npwp)
      ->where('bulan', $pecah[3])
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2])
      ->orderBy('status', 'desc')
      ->first();
      

    $bulan_ambil_pasok_lpg = DB::table('pasokan_l_p_g_s')
      ->where('npwp', $npwp)
      ->where('bulan', $pecah[3])
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2])
      ->orderBy('status', 'desc')
      ->first();
      

    // Mengambil substring dari bulan
    $bulan_ambil_penjualan_lpgx = $bulan_ambil_penjualan_lpg ? substr($bulan_ambil_penjualan_lpg->bulan, 0, 7) : '';
    $statuspenjualan_lpgx = $bulan_ambil_penjualan_lpg->status ?? '';

    $bulan_ambil_pasok_lpgx = $bulan_ambil_pasok_lpg ? substr($bulan_ambil_pasok_lpg->bulan, 0, 7) : '';
    $statuspasok_lpgx = $bulan_ambil_pasok_lpg->status ?? '';

    if ($filter && $filter === "tahun") {
      $filterBy = substr($pecah[3], 0, 4);
    } else {
      $filterBy = $pecah[3];
    }
    
    $lpgs = Penjualan_lpg::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'npwp' => $pecah[1],
      'id_permohonan' => $pecah[0],
      'id_sub_page' => $pecah[2],
    ])->orderBy('status', 'desc')->get();

    $pasokan = PasokanLPG::where([
      ['bulan', 'like', "%". $filterBy ."%"],
      'npwp' => $pecah[1],
      'id_permohonan' => $pecah[0],
      'id_sub_page' => $pecah[2],
    ])->orderBy('status', 'desc')->get();

    $produk = Produk::get();

    return view('badanUsaha.niaga.lpg.show', compact(
      'lpgs',
      'pasokan',
      'produk',
      'bulan_ambil_penjualan_lpgx',
      'bulan_ambil_pasok_lpgx',
      'statuspenjualan_lpgx',
      'statuspasok_lpgx',
      'lpgx',
      'pecah'
    ));
  }

  public function simpan_lpg(Request $request)
  {
    // echo json_encode($request->all());exit;
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
      'kemasan.required' => 'kemasan masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
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
      'kemasan' => 'required',
      'volume' => 'required',
      'satuan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    // echo json_encode($request->all());exit;

    // $simpan = Penjualan_lpg::create($request->all());
    $npwp = Auth::user()->npwp;
    // dd($npwp);
    // exit();
    $cekdb = DB::table('penjualan_lpgs')
      ->where('npwp', $npwp)
      ->where('id_permohonan', $request->id_permohonan)
      ->where('id_sub_page', $request->id_sub_page)
      ->where('bulan', $request->bulan)
      ->orderBy('status', 'desc')
      ->first();
    // dd($cekdb);
    // exit();

    if (isset($cekdb) == 1) {
      if ($cekdb->status == 1) {
        Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
        return back();
      }
    }
    $simpan = Penjualan_lpg::create($validatedData);

    if ($simpan) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function hapus_lpg(Request $request, $id)
  {
    Penjualan_lpg::destroy($id);
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

  public function edit($id)
  {
    $show_lpg = Penjualan_lpg::find($id);
    return response()->json([
      'data' => $show_lpg
    ]);
  }

  public function get_penjualan_lpg($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['provinsi'] = DB::select("SELECT DISTINCT ON (name) id, name FROM provinces ORDER BY name, id");
    $data['sektor'] = DB::select("SELECT sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
    $data['find'] = Penjualan_lpg::find($id);
    return response()->json(['data' => $data]);

    // $data = Penjualan_lng::find($id);
    // return response()->json(['data' => $data]);
  }

  public function importlpgx(Request $request)
  {
    $id_permohonan = $request->id_permohonan;
    $id_sub_page = $request->id_sub_page;
    $bulan = $request->bulan . "-01";
    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('penjualan_lpgs')
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
    $import = Excel::import(new Importlpgpenjualan($bulan, $id_permohonan, $id_sub_page), request()->file('file'));

    if ($import) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data excel berhasil diupload');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data excel gagal diupload');
      return back();
    }
  }
  public function importlpg_pasokx(Request $request)
  {
    $id_permohonan = $request->id_permohonan;
    $id_sub_page = $request->id_sub_page;
    $bulan = $request->bulan . "-01";
    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('pasokan_l_p_g_s')
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
    $import = Excel::import(new Importlpgpasok($bulan, $id_permohonan, $id_sub_page), request()->file('file'));

    if ($import) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data excel berhasil diupload');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data excel gagal diupload');
      return back();
    }
  }

  public function update_lpg(Request $request, $id)
  {
    $id_lpg = $id;
    //echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'id.required' => 'id masih kosong',
      // 'npwp.required' => 'npwp masih kosong',
      // 'id_permohonan.required' => 'id_permohonan masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'satuan.required' => 'satuan masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'kemasan.required' => 'kemasan masih kosong',
      'volume.required' => 'volume masih kosong',
      //'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      // 'id' => 'required',
      // 'npwp' => 'required',
      // 'id_permohonan' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'satuan' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'sektor' => 'required',
      'kemasan' => 'required',
      'volume' => 'required',
      //'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',

    ];

    $validatedData = $request->validate($rules, $pesan);

    $update = Penjualan_lpg::where('id', $id_lpg)
      ->update($validatedData);

    if ($update) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function get_produk(Request $request)
  {
    $where = $request->get('jenis_komuditas');
    if ($where <> '') {
      $data = DB::select("SELECT produks.name FROM produks WHERE produks.jenis_komuditas = '$where' GROUP BY produks.name");
    } else {
      $data = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    }
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

  // public function get_kota($id_prov)
  // {
  //   $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.id_prov = '$id_prov'");
  //   // $data = Produk::get();
  //   return response()->json(['data' => $data]);
  // }

  public function get_kota($kabupaten_kota)
  {
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

  public function simpan_pasokanLPG(Request $request)
  {
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      'npwp.required' => 'npwp masih kosong',
      'id_permohonan.required' => 'id_permohonan masih kosong',
      'id_sub_page.required' => 'id_sub_page masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'nama_pemasok.required' => 'nama_pemasok masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'npwp' => 'required',
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
      'bulan' => 'required',
      'nama_pemasok' => 'required',
      'kategori_pemasok' => 'required',
      'volume' => 'required',
      'satuan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    // echo json_encode($request->all());exit;
    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('pasokan_l_p_g_s')
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

    $simpan = PasokanLPG::create($validatedData);

    if ($simpan) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function hapus_pasokanLPG(Request $request, $id)
  {
    PasokanLPG::destroy($id);
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

  public function getPasokanLPG($id)
  {
    $data['find'] = PasokanLPG::find($id);
    return response()->json(['data' => $data]);
  }

  public function update_pasokanLPG(Request $request, $id)
  {
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'npwp.required' => 'npwp masih kosong',
      // 'id_permohonan.required' => 'id_permohonan masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'nama_pemasok.required' => 'nama_pemasok masih kosong',
      'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
      'volume.required' => 'volume masih kosong',
      'satuan.required' => 'satuan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $rules = [
      // 'npwp' => 'required',
      // 'id_permohonan' => 'required',
      'bulan' => 'required',
      'nama_pemasok' => 'required',
      'kategori_pemasok' => 'required',
      'volume' => 'required',
      'satuan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    $update = PasokanLPG::where('id', $id)
      ->update($validatedData);

    if ($update) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function submit_penjualan_lpg(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $now = Carbon::now();
    $validatedData = DB::table('penjualan_lpgs')->where('id', $id)->update(['status' => "1", 'tgl_kirim' => $now]);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dikirim');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal dikirim');
      return back();
    }
  }
  public function submit_bulan_penjualan_lpgx(Request $request, $id)
  {
    $pecah = explode(',', Crypt::decryptString($id));
    $bulanx = $pecah[3];
    $npwp = $pecah[1];
    $id_permohonan = $pecah[0];
    $id_sub_page = $pecah[2];
    $now = Carbon::now();

    // $validatedData = DB::update("update penjualan_lpgs set status='1', tgl_kirim='$now' where bulan='$bulanx' and npwp='$npwp'");

    $affected = DB::table('penjualan_lpgs')
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

  public function submit_pasokan_lpg(Request $request, $id)
  {
    // $validatedData = DB::update("update pengangkutan_minyakbumis set status='1' where id='$idx'");
    $now = Carbon::now();
    $validatedData = DB::table('pasokan_l_p_g_s')->where('id', $id)->update(['status' => "1", 'tgl_kirim' => $now]);

    if ($validatedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dikirim');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal dikirim');
      return back();
    }
  }
  public function submit_bulan_pasokan_lpgx(Request $request, $id)
  {
    $pecah = explode(',', Crypt::decryptString($id));
    $bulanx = $pecah[3];
    $npwp = $pecah[1];
    $id_permohonan = $pecah[0];
    $id_sub_page = $pecah[2];
    $now = Carbon::now();

    // $validatedData = DB::update("update penjualan_lpgs set status='1', tgl_kirim='$now' where bulan='$bulanx' and npwp='$npwp'");

    $affected = DB::table('pasokan_l_p_g_s')
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
  public function hapus_bulan_lpg(Request $request, $id)
  {
    // Dekripsi ID dan pecah menjadi array
    $pecah = explode(',', Crypt::decryptString($id));
    $bulanx = $pecah[3];
    $npwp = $pecah[1];
    $id_permohonan = $pecah[0];
    $id_sub_page = $pecah[2];

    // Menggunakan query builder untuk menghapus data
    $affected = DB::table('penjualan_lpgs')
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
  public function hapus_bulan_pasokanLPG(Request $request, $id)
  {
    // Dekripsi ID dan pecah menjadi array
    $pecah = explode(',', Crypt::decryptString($id));
    $bulanx = $pecah[3];
    $npwp = $pecah[1];
    $id_permohonan = $pecah[0];
    $id_sub_page = $pecah[2];

    // Menggunakan query builder untuk menghapus data
    $affected = DB::table('pasokan_l_p_g_s')
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
