<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga_bbm_jbu;
use App\Models\HargaLPG;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Importhargabbmjbu;
use App\Imports\Importhargalpg;
use App\Models\Meping;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Mews\Purifier\Facades\Purifier;

class HargabbmController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index($id)
  {
    // dd(auth()->user()->npwp);
    // dd($id);
    $pecah = explode(',', Crypt::decryptString($id));
    // dd($pecah);
    $hargaLPG = [];
    $hargabbmjbu = [];

    if ($pecah[3] == 1) { // Kategori = Gas

      $sqLpg = DB::table('harga_l_p_g_s')
      ->select(
          '*',
          DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
          DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
          DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
      )
      ->where('npwp', Auth::user()->npwp)
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2]);

      $hargaLPG = DB::table(DB::raw("({$sqLpg->toSql()}) as sub"))
      ->mergeBindings($sqLpg)
      ->where('rn', 1)
      ->get();
    } 

    if ($pecah[3] == 2) { // Kategori = Minyak
      
      $sqJbu = DB::table('harga_bbm_jbus')
      ->select(
          '*',
          DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
          DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
          DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
      )
      ->where('npwp', Auth::user()->npwp)
      ->where('id_permohonan', $pecah[0])
      ->where('id_sub_page', $pecah[2]);
  
      $hargabbmjbu = DB::table(DB::raw("({$sqJbu->toSql()}) as sub"))
      ->mergeBindings($sqJbu)
      ->where('rn', 1)
      ->get();
    }

    $sub_page = Meping::select('nama_opsi')
    ->where('id_sub_page', $pecah[2])
    ->where('id_template', $pecah[4])
    ->first();

    // return view('badan_usaha.niaga.harga.index', compact(
    return view('badanUsaha.niaga.harga.index', compact(
      'hargabbmjbu',
      'hargaLPG',
      'pecah',
      'sub_page'
    ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function show_niagahargax($id, $harga, $filter = null)
  {
    $hargax = $harga;
    $pecah = explode(',', Crypt::decryptString($id));
    $npwp = Auth::user()->npwp;

    // Mapping nilai
    $bulan = $pecah[3];
    $npwp_decrypted = $pecah[1];
    $id_permohonan = $pecah[0];
    $id_sub_page = $pecah[2];

    // Cek data utama dari DB
    $bulan_ambil_hargabbmjbu = DB::table('harga_bbm_jbus')
      ->where('npwp', $npwp)
      ->where('bulan', $bulan)
      ->where('id_permohonan', $id_permohonan)
      ->where('id_sub_page', $id_sub_page)
      ->orderBy('status', 'desc')
      ->first();

    $bulan_ambil_hargalpg = DB::table('harga_l_p_g_s')
      ->where('npwp', $npwp)
      ->where('bulan', $bulan)
      ->where('id_permohonan', $id_permohonan)
      ->where('id_sub_page', $id_sub_page)
      ->orderBy('status', 'desc')
      ->first();

    $bulan_ambil_hargabbmjbux = $bulan_ambil_hargabbmjbu ? substr($bulan_ambil_hargabbmjbu->bulan, 0, 7) : '';
    $statushargabbmjbux = $bulan_ambil_hargabbmjbu->status ?? '';

    $bulan_ambil_hargalpgx = $bulan_ambil_hargalpg ? substr($bulan_ambil_hargalpg->bulan, 0, 7) : '';
    $statushargalpgx = $bulan_ambil_hargalpg->status ?? '';

    // Cek filter
    if ($filter && $filter === "tahun") {
      $filterBy = substr($bulan, 0, 4); // ambil dari bulan
    } else {
      $filterBy = substr($bulan, 0, 7); // ambil tahun-bulan saja
    }

    // Ambil data utama
    $hargabbmjbu = Harga_bbm_jbu::where([
      ['bulan', 'like', "%" . $filterBy . "%"],
      'npwp' => $npwp_decrypted,
      'id_permohonan' => $id_permohonan,
      'id_sub_page' => $id_sub_page,
    ])->orderBy('status', 'desc')->get();

    $hargalpg = HargaLPG::where([
      ['bulan', 'like', "%" . $filterBy . "%"],
      'npwp' => $npwp_decrypted,
      'id_permohonan' => $id_permohonan,
      'id_sub_page' => $id_sub_page,
    ])->orderBy('status', 'desc')->get();

    // return view kalau sudah jalan semua
    return view('badanUsaha.niaga.harga.show', compact(
      'hargabbmjbu',
      'hargalpg',
      'bulan_ambil_hargabbmjbux',
      'bulan_ambil_hargalpgx',
      'statushargabbmjbux',
      'statushargalpgx',
      'hargax',
      'pecah'
    ));
  }

  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // dd($request->all());
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
      'sektor.required' => 'sektor masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'volume.required' => 'volume masih kosong',
      'biaya_perolehan.required' => 'biaya_perolehan masih kosong',
      'biaya_distribusi.required' => 'biaya_distribusi masih kosong',
      'biaya_penyimpanan.required' => 'biaya_penyimpanan masih kosong',
      'margin.required' => 'margin masih kosong',
      'ppn.required' => 'ppn masih kosong',
      'pbbkp.required' => 'pbbkp masih kosong',
      'harga_jual.required' => 'harga_jual masih kosong',
      'formula_harga.required' => 'formula harga masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'npwp' => 'required',
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'sektor' => 'required',
      'provinsi' => 'required',
      'volume' => 'required',
      'biaya_perolehan' => 'required',
      'biaya_distribusi' => 'required',
      'biaya_penyimpanan' => 'required',
      'margin' => 'required',
      'ppn' => 'required',
      'pbbkp' => 'required',
      'harga_jual' => 'required',
      'formula_harga' => 'required',
      'keterangan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $sanitizedData = fullySanitizeInput($validatedData);
    // dd($sanitizedData);

    // $validatedData = Harga_bbm_jbu::create([
    //   'badan_usaha_id' =>  $request->badan_usaha_id,
    //   'izin_id' => $request->izin_id,
    //   'bulan' => $request->bulan.'-01',
    //   'produk' => $request->produk,
    //   'sektor' => $request->sektor,
    //   'provinsi' => $request->provinsi,
    //   'volume' => $request->volume,
    //   'biaya_perolehan' => $request->biaya_perolehan,
    //   'biaya_distribusi' => $request->biaya_distribusi,
    //   'biaya_penyimpanan' => $request->biaya_penyimpanan,
    //   'margin' => $request->margin,
    //   'ppn' => $request->ppn,
    //   'pbbkp' => $request->pbbkp,
    //   'harga_jual' => $request->harga_jual,
    // ]);
    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('harga_bbm_jbus')
      ->where('npwp', $npwp)
      ->where('bulan', $request->bulan)
      ->where('id_sub_page', $request->id_sub_page)
      ->where('id_permohonan', $request->id_permohonan)
      ->orderBy('status', 'desc')
      ->first();

    if (isset($cekdb) == 1) {
        if ($cekdb->status == 1) {
            Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
            return back();
        }
    }

    Harga_bbm_jbu::create($sanitizedData);

    if ($sanitizedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal berhasil ditambahkan');
      return back();
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    // echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $ekport = $id;
    $pesan = [
      // 'npwp.required' => 'npwp masih kosong',
      // 'id_pemohonan.required' => 'id_pemohonan masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'produk.required' => 'produk masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'volume.required' => 'volume masih kosong',
      'biaya_perolehan.required' => 'biaya_perolehan masih kosong',
      'biaya_distribusi.required' => 'biaya_distribusi masih kosong',
      'biaya_penyimpanan.required' => 'biaya_penyimpanan masih kosong',
      'margin.required' => 'margin masih kosong',
      'ppn.required' => 'ppn masih kosong',
      'pbbkp.required' => 'pbbkp masih kosong',
      'harga_jual.required' => 'harga_jual masih kosong',
      'formula_harga.required' => 'formula_harga masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
    ];

    $rules = [
      // 'npwp' => 'required',
      // 'id_pemohonan' => 'required',
      'bulan' => 'required',
      'produk' => 'required',
      'sektor' => 'required',
      'provinsi' => 'required',
      'volume' => 'required',
      'biaya_perolehan' => 'required',
      'biaya_distribusi' => 'required',
      'biaya_penyimpanan' => 'required',
      'margin' => 'required',
      'ppn' => 'required',
      'pbbkp' => 'required',
      'harga_jual' => 'required',
      'formula_harga' => 'required',
      'keterangan' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    $sanitizedData = fullySanitizeInput($validatedData);


    Harga_bbm_jbu::where('id', $ekport)
      ->update($sanitizedData);

    if ($sanitizedData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    Harga_bbm_jbu::destroy($id);
    if ($id) {
      //redirect dengan pesan sukses
      Alert::success('success', 'Data berhasil dihapus');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('error', 'Data berhasil dihapus');
      return back();

      // return redirect('/show/hasil-olahan/minyak-bumi')->with(['success' => 'Data excel berhasil diupload']);
    }
  }

  public function importhargajbux(Request $request)
  {
    $request->validate([
      'file' => [
        'required',
        'file',
        'mimes:xlsx,xls,csv',
        // Sanitasi Excel
        function ($attribute, $value, $fail) {
          validateExcelUpload($attribute, $value, $fail);
        },
      ],
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
      'bulan' => 'required',
    ]);

    $id_permohonan = $request->id_permohonan;
    $id_sub_page = $request->id_sub_page;
    $bulan = $request->bulan . "-01";
    $npwp = Auth::user()->npwp;
    
    $cekdb = DB::table('harga_bbm_jbus')
        ->where('$npwp', $npwp)
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
    // $import = Excel::import(new Importhargabbmjbu($bulan, $id_permohonan, $id_sub_page), request()->file('file'));

    // if ($import) {
    //   //redirect dengan pesan sukses
    //   Alert::success('success', 'Data excel berhasil diupload');
    //   return back();
    // } else {
    //   //redirect dengan pesan error
    //   Alert::error('error', 'Data excel gagal diupload');
    //   return back();

    //   // return redirect('/show/hasil-olahan/minyak-bumi')->with(['success' => 'Data excel berhasil diupload']);
    // }
    try {
      Excel::import(
        new Importhargabbmjbu($bulan, $id_permohonan, $id_sub_page),
        $request->file('file')
      );

      Alert::success('Success', 'Data excel berhasil diupload');
      return back();
    } catch (\Exception $e) {
      Alert::error('Error', 'Data excel gagal diupload');
      return back();
    }
  }
  public function importhargalpgx(Request $request)
  {
    $request->validate([
      'file' => [
        'required',
        'file',
        'mimes:xlsx,xls,csv',
        // Sanitasi Excel
        function ($attribute, $value, $fail) {
          validateExcelUpload($attribute, $value, $fail);
        },
      ],
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
      'bulan' => 'required',
    ]);

    $id_permohonan = $request->id_permohonan;
    $id_sub_page = $request->id_sub_page;
    $bulan = $request->bulan . "-01";
    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('harga_l_p_g_s')
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
    // $import = Excel::import(new Importhargalpg($bulan, $id_permohonan, $id_sub_page), request()->file('file'));

    // if ($import) {
    //   //redirect dengan pesan sukses
    //   Alert::success('success', 'Data excel berhasil diupload');
    //   return back();
    // } else {
    //   //redirect dengan pesan error
    //   Alert::error('error', 'Data excel gagal diupload');
    //   return back();

    //   // return redirect('/show/hasil-olahan/minyak-bumi')->with(['success' => 'Data excel berhasil diupload']);
    // }
    try {
      Excel::import(
        new Importhargalpg($bulan, $id_permohonan, $id_sub_page),
        $request->file('file')
      );

      Alert::success('Success', 'Data excel berhasil diupload');
      return back();
    } catch (\Exception $e) {
      Alert::error('Error', 'Data excel gagal diupload');
      return back();
    }
  }

  public function get_harga_bbm($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks WHERE produks.jenis_komuditas = 'BBM' GROUP BY produks.name");
    // $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['sektor'] = DB::select("SELECT sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
    // $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
    $data['provinsi'] = DB::select("SELECT DISTINCT ON (name) id, name FROM provinces ORDER BY name, id");
    $data['find'] = Harga_bbm_jbu::find($id);
    return response()->json(['data' => $data]);
  }

  public function update_hargabbm(Request $request, $id)
  {
  }

  public function submit_harga_bbm_jbux(Request $request, $id)
  {
    $idx = $id;
    $now = Carbon::now();
    $validatedData = DB::update("update harga_bbm_jbus set status='1', tgl_kirim='$now' where id='$idx'");

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

  public function simpan_harga_lpg(Request $request)
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
      'sektor.required' => 'sektor masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'biaya_perolehan.required' => 'biaya_perolehan masih kosong',
      'biaya_distribusi.required' => 'biaya_distribusi masih kosong',
      'biaya_penyimpanan.required' => 'biaya_penyimpanan masih kosong',
      'margin.required' => 'margin masih kosong',
      'ppn.required' => 'ppn masih kosong',
      'harga_jual.required' => 'harga_jual masih kosong',
      'formula_harga.required' => 'formula_harga masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
      // 'status.required' => 'status masih kosong',
      // 'catatan.required' => 'catatan masih kosong',
      // 'petugas.required' => 'petugas masih kosong',
    ];

    $validatedData = $request->validate([
      'npwp' => 'required',
      'id_permohonan' => 'required',
      'id_sub_page' => 'required',
      'bulan' => 'required',
      'sektor' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'biaya_perolehan' => 'required',
      'biaya_distribusi' => 'required',
      'biaya_penyimpanan' => 'required',
      'margin' => 'required',
      'ppn' => 'required',
      'harga_jual' => 'required',
      'formula_harga' => 'required',
      'keterangan' => 'required',
      // 'status' => 'required',
      // 'catatan' => 'required',
      // 'petugas' => 'required',
    ], $pesan);

    $sanitizedData = fullySanitizeInput($validatedData);

    $npwp = Auth::user()->npwp;

    $cekdb = DB::table('harga_l_p_g_s')
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


    $created = HargaLPG::create($sanitizedData);
    if ($created) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil ditambahkan');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal ditambahkan');
      return back();
    }
  }

  public function get_harga_lpg($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['sektor'] = DB::select("SELECT sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
    $data['provinsi'] = DB::select("SELECT DISTINCT ON (name) id, name FROM provinces ORDER BY name, id");
    $data['find'] = HargaLPG::find($id);
    return response()->json(['data' => $data]);
  }

  public function get_kota($kabupaten_kota)
  {
    // $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.kabupaten_kota = '$kabupaten_kota'");
    $data = DB::select(" SELECT nama_kota FROM kotas WHERE id_prov = 
      (
        SELECT id_prov 
        FROM kotas 
        WHERE nama_kota = :nama_kota
        LIMIT 1
      )", ['nama_kota' => $kabupaten_kota]);
    // $data = Produk::get();
    return response()->json(['data' => $data]);
  }

  public function update_harga_lpg(Request $request, $id)
  {
    // echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
      'bulan.required' => 'bulan masih kosong',
      'sektor.required' => 'sektor masih kosong',
      'provinsi.required' => 'provinsi masih kosong',
      'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
      'volume.required' => 'volume masih kosong',
      'biaya_perolehan.required' => 'biaya_perolehan masih kosong',
      'biaya_distribusi.required' => 'biaya_distribusi masih kosong',
      'biaya_penyimpanan.required' => 'biaya_penyimpanan masih kosong',
      'margin.required' => 'margin masih kosong',
      'ppn.required' => 'ppn masih kosong',
      'harga_jual.required' => 'harga_jual masih kosong',
      'formula_harga.required' => 'formula_harga masih kosong',
      'keterangan.required' => 'keterangan masih kosong',
    ];

    $rules = [
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
      'bulan' => 'required',
      'sektor' => 'required',
      'provinsi' => 'required',
      'kabupaten_kota' => 'required',
      'volume' => 'required',
      'biaya_perolehan' => 'required',
      'biaya_distribusi' => 'required',
      'biaya_penyimpanan' => 'required',
      'margin' => 'required',
      'ppn' => 'required',
      'harga_jual' => 'required',
      'formula_harga' => 'required',
      'keterangan' => 'required',
    ];

    $validatedData = $request->validate($rules, $pesan);

    $sanitizedData = fullySanitizeInput($validatedData);

    $updateHarga = HargaLPG::where('id', $id)->update($sanitizedData);

    if ($updateHarga) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil diupdate');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data gagal diupdate');
      return back();
    }
  }

  public function hapus_harga_lpg(string $id)
  {
    $hapusData = HargaLPG::destroy($id);
    if ($hapusData) {
      //redirect dengan pesan sukses
      Alert::success('Success', 'Data berhasil dihapus');
      return back();
    } else {
      //redirect dengan pesan error
      Alert::error('Error', 'Data berhasil dihapus');
      return back();

      // return redirect('/show/hasil-olahan/minyak-bumi')->with(['success' => 'Data excel berhasil diupload']);
    }
  }

  public function submit_harga_lpg(Request $request, $id)
  {
    $now = Carbon::now();
    $validatedData = DB::table('harga_l_p_g_s')->where('id', $id)->update(['status' => "1", 'tgl_kirim' => $now]);
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
  public function hapusbulanHargabbmjbux(Request $request, $id)
    {
      
      $pecah = explode(',', Crypt::decryptString($id));
      $bulanx = $pecah[3];
      $npwp = $pecah[1];
      $id_permohonan = $pecah[0];
      $id_sub_page = $pecah[2];
        
      $validatedData = DB::table('harga_bbm_jbus')
        ->where('npwp', $npwp)
        ->where('bulan', $bulanx)
        ->where('id_permohonan', $id_permohonan)
        ->where('id_sub_page', $id_sub_page)
        ->delete();
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
  public function hapus_bulan_harga_lpg(Request $request, $id)
    {
      $pecah = explode(',', Crypt::decryptString($id));
      $bulanx = $pecah[3];
      $npwp = $pecah[1];
      $id_permohonan = $pecah[0];
      $id_sub_page = $pecah[2];
        
      $validatedData = DB::table('harga_l_p_g_s')
        ->where('npwp', $npwp)
        ->where('bulan', $bulanx)
        ->where('id_permohonan', $id_permohonan)
        ->where('id_sub_page', $id_sub_page)
        ->delete();
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
  public function submit_bulan_harga_bbm_jbux(Request $request, $id)
    {
      $pecah = explode(',', Crypt::decryptString($id));
      $bulanx = $pecah[3];
      $npwp = $pecah[1];
      $id_permohonan = $pecah[0];
      $id_sub_page = $pecah[2];
      $now = Carbon::now();
  
      // Menggunakan parameter binding untuk keamanan
      $validatedData = DB::table('harga_bbm_jbus')
          ->where('bulan', $bulanx)
          ->where('npwp', $npwp)
          ->where('id_permohonan', $id_permohonan)
          ->where('id_sub_page', $id_sub_page)
          ->update(['status' => '1', 'tgl_kirim' => $now]);

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
  public function submit_bulan_harga_lpg(Request $request, $id)
    {
      $pecah = explode(',', Crypt::decryptString($id));
      $bulanx = $pecah[3];
      $npwp = $pecah[1];
      $id_permohonan = $pecah[0];
      $id_sub_page = $pecah[2];
      $now = Carbon::now();
  
      // Menggunakan parameter binding untuk keamanan
      $validatedData = DB::table('harga_l_p_g_s')
          ->where('bulan', $bulanx)
          ->where('npwp', $npwp)
          ->where('id_permohonan', $id_permohonan)
          ->where('id_sub_page', $id_sub_page)
          ->update(['status' => '1', 'tgl_kirim' => $now]);

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
