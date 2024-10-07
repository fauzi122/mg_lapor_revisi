<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga_bbm_jbu;
use App\Models\HargaLPG;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Importhargabbmjbu;
use App\Imports\Importhargalpg;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class HargabbmController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    
    $hargabbmjbu = DB::table('harga_bbm_jbus')
    ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
    ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
    ->groupBy('bulan')
    ->get();

    $hargaLPG = DB::table('harga_l_p_g_s')
    ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
    ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
    ->groupBy('bulan')
    ->get();

    return view('badan_usaha.niaga.harga.index', compact(
      'hargabbmjbu',
      'hargaLPG'
    ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function show_niagahargax($id, $harga, $filter = null)
  {
      // dd($harga);
      // die;
      $hargax = $harga;
      $pecah = explode(',', Crypt::decryptString($id));
      $badan_usaha_id = Auth::user()->badan_usaha_id;

      $bulan_ambil_hargabbmjbu = DB::table('harga_bbm_jbus')
              ->where('badan_usaha_id', $badan_usaha_id)
              ->orderBy('status', 'desc')
              ->where('bulan', $pecah[0])
              ->first();

      $bulan_ambil_hargalpg = DB::table('harga_l_p_g_s')
              ->where('badan_usaha_id', $badan_usaha_id)
              ->orderBy('status', 'desc')
              ->where('bulan', $pecah[0])
              ->first();
      
      

      // Mengambil substring dari bulan
      $bulan_ambil_hargabbmjbux = $bulan_ambil_hargabbmjbu ? substr($bulan_ambil_hargabbmjbu->bulan, 0, 7) : '';
      $statushargabbmjbux = $bulan_ambil_hargabbmjbu->status ?? '';

      $bulan_ambil_hargalpgx = $bulan_ambil_hargalpg ? substr($bulan_ambil_hargalpg->bulan, 0, 7) : '';
      $statushargalpgx = $bulan_ambil_hargalpg->status ?? '';

      // dd($harga);
      // die;

      if ($filter && $filter === "tahun") {
        $filterBy = substr($pecah[0], 0, 4);
      } else {
        $filterBy = $pecah[0];
      }

      $hargabbmjbu = Harga_bbm_jbu::where([
        ['bulan', 'like', "%". $filterBy ."%"],
        'badan_usaha_id' => $pecah[1]
      ])->orderBy('status', 'desc')->get();

      $hargalpg = HargaLPG::where([
        ['bulan', 'like', "%". $filterBy ."%"],
        'badan_usaha_id' => $pecah[1]
      ])->orderBy('status', 'desc')->get();

      // dd($harga);
      // die;

      return view('badan_usaha.niaga.harga.show', compact(
        'hargabbmjbu',
        'hargalpg',
        'bulan_ambil_hargabbmjbux',
        'bulan_ambil_hargalpgx',
        'statushargabbmjbux',
        'statushargalpgx',
        'hargax'
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
    // echo json_encode($request->all());exit;
    $request->merge([
      'bulan' => $request->bulan . '-01',
    ]);

    $pesan = [
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
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
      'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
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
    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $cekdb = DB::table('harga_bbm_jbus')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $request->bulan)
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

    Harga_bbm_jbu::create($validatedData);

    if ($validatedData) {
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
      // 'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      // 'izin_id.required' => 'izin_id masih kosong',
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
      // 'badan_usaha_id' => 'required',
      // 'izin_id' => 'required',
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

    Harga_bbm_jbu::where('id', $ekport)
      ->update($validatedData);

    if ($validatedData) {
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
    $bulan = $request->bulan . "-01";
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('harga_bbm_jbus')
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
    $import = Excel::import(new Importhargabbmjbu($bulan), request()->file('file'));

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
  public function importhargalpgx(Request $request)
  {
    $bulan = $request->bulan . "-01";
    $badan_usaha_id = Auth::user()->badan_usaha_id;
    $cekdb = DB::table('harga_l_p_g_s')
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
    $import = Excel::import(new Importhargalpg($bulan), request()->file('file'));

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

  public function get_harga_bbm($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks WHERE produks.jenis_komuditas = 'BBM' GROUP BY produks.name");
    // $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['sektor'] = DB::select("SELECT sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
    $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
    $data['find'] = Harga_bbm_jbu::find($id);
    return response()->json(['data' => $data]);
  }

  public function update_hargabbm(Request $request, $id)
  {
  }

  public function submit_harga_bbm_jbux(Request $request, $id)
  {
    $idx = $id;
    $validatedData = DB::update("update harga_bbm_jbus set status='1' where id='$idx'");

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
      'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
      'izin_id.required' => 'izin_id masih kosong',
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
      'badan_usaha_id' => 'required',
      'izin_id' => 'required',
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

    $badan_usaha_id = Auth::user()->badan_usaha_id;

    $cekdb = DB::table('harga_l_p_g_s')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $request->bulan)
            ->orderBy('status', 'desc')
            ->first();

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }


    HargaLPG::create($validatedData);
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

  public function get_harga_lpg($id)
  {
    $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
    $data['sektor'] = DB::select("SELECT sektors.nama_sektor FROM sektors GROUP BY sektors.nama_sektor");
    $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
    $data['find'] = HargaLPG::find($id);
    return response()->json(['data' => $data]);
  }

  public function get_kota($kabupaten_kota)
  {
    // $data = DB::select("SELECT kotas.nama_kota FROM kotas WHERE kotas.kabupaten_kota = '$kabupaten_kota'");
    $data = DB::select("SELECT kotas.`nama_kota` FROM  kotas WHERE kotas.`id_prov` = (SELECT kotas.`id_prov` FROM kotas WHERE kotas.`nama_kota` = '$kabupaten_kota')");
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

    HargaLPG::where('id', $id)->update($validatedData);

    if ($validatedData) {
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
    $validatedData = DB::table('harga_l_p_g_s')->where('id', $id)->update(['status' => "1"]);
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
  public function hapusbulanHargabbmjbux(Request $request, $bulan)
    {
        $bulanx = $bulan;
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("DELETE FROM harga_bbm_jbus WHERE badan_usaha_id='$badan_usaha_id' AND bulan='$bulanx'");
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
  public function hapus_bulan_harga_lpg(Request $request, $bulan)
    {
        $bulanx = $bulan;
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("DELETE FROM harga_l_p_g_s WHERE badan_usaha_id='$badan_usaha_id' AND bulan='$bulanx'");
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
  public function submit_bulan_harga_bbm_jbux(Request $request, $bulan)
    {
        $bulanx = $bulan;
        // dd($bulanx);
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("update harga_bbm_jbus set status='1' where bulan='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
  public function submit_bulan_harga_lpg(Request $request, $bulan)
    {
        $bulanx = $bulan;
        // dd($bulanx);
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("update harga_l_p_g_s set status='1' where bulan='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
