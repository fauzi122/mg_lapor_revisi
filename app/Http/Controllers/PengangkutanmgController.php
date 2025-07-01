<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Izin;
use App\Models\pengangkutan_gaskbumi;
use App\Models\pengangkutan_minyakbumi;
use App\Imports\ImportPengangkutanMB;
use App\Imports\ImportPengangkutanGB;
use Carbon\Carbon;
use App\Models\Meping;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;


class PengangkutanmgController extends Controller
{
    public function index($id)
    {
     
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $query = DB::table('pengangkutan_minyakbumis')
            ->select(
                '*',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY bulan ORDER BY status DESC) as rn'),
                DB::raw('MAX(status) OVER (PARTITION BY bulan) as status_tertinggi'),
                DB::raw('MAX(catatan) OVER (PARTITION BY bulan) as catatanx')
            )
            ->where('npwp', Auth::user()->npwp)
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2]);

        $pm = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->where('rn', 1)
            ->get();

        $sub_page = Meping::select('nama_opsi')
        ->where('id_sub_page', $pecah[2])
        ->where('id_template', $pecah[4])
        ->first();

       
        return view('badan_usaha.pengangkutan.minyak_bumi.index', compact('pm', 'pecah','sub_page'));
    }
    public function index_pgb($id)
    {
        // $pm = pengangkutan_gaskbumi::where('badan_usaha_id', Auth::user()->badan_usaha_id)
        //     ->groupBy('bulan')->get();

        $pecah = explode(',', Crypt::decryptString($id));

        $pm = DB::table('pengangkutan_gaskbumis')
            ->select('*', DB::raw('MAX(status) as status_tertinggi'), DB::raw('MAX(catatan) as catatanx'))
            ->where('badan_usaha_id', Auth::user()->badan_usaha_id)
            ->where('izin_id', $pecah[0])
            ->groupBy('bulan')
            ->get();

        return view('badan_usaha.pengangkutan.gas_bumi.index', compact('pm', 'pecah'));
    }

    public function show_pengmbx($id, $filter = null)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $npwp = Auth::user()->npwp;
        // Mengambil bulan dari tabel pengangkutan_minyakbumis sesuai ID badan usaha dan bulan yang ditemukan
        $bulan_ambil = DB::table('pengangkutan_minyakbumis')
            ->where('npwp', $npwp)
            ->orderBy('status', 'desc')
            ->where('bulan', $pecah[3])
            ->where('id_permohonan', $pecah[0])
            ->where('id_sub_page', $pecah[2])
            ->orderBy('status', 'desc')
            ->first();

        // Mengambil substring dari bulan
        $bulan_ambilx = $bulan_ambil ? substr($bulan_ambil->bulan, 0, 7) : '';
        $statusx = $bulan_ambil->status;

       if ($filter && $filter === "tahun") {
            $filterBy = substr($pecah[3], 0, 4);
          } else {
            $filterBy = $pecah[3];
          }

        $pgb = pengangkutan_minyakbumi::where([
            ['bulan', 'like', "%". $filterBy ."%"],
            'npwp' => $pecah[1],
            'id_permohonan' => $pecah[0],
            'id_sub_page' => $pecah[2],
        ])->orderBy('status', 'desc')->get();

        // echo json_encode($pgb[3]->jenis_moda);exit;

        return view('badan_usaha.pengangkutan.minyak_bumi.show', compact(
            'pgb',
            'bulan_ambilx',
            'statusx',
            'pecah'
        ));
    }

    public function simpan_pengmbx(Request $request)
    {
        // echo json_encode(gettype($request->jenis_moda));exit;
        $request->merge([
            'bulan' => $request->bulan . '-01',
        ]);
        $pesan = [
            'npwp.required' => 'npwp masih kosong',
            'id_permohonan.required' => 'id_permohonan masih kosong',
            'id_sub_page.required' => 'id_sub_page masih kosong',
            'bulan.required' => 'bulan masih kosong',
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
        ];

        $validatedData = $request->validate([
             'npwp' => 'required',
            'id_permohonan' => 'required',
            'id_sub_page' => 'required',
            'bulan' => 'required',

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

        ], $pesan);

        $npwp = Auth::user()->npwp;

        $cekdb = DB::table('pengangkutan_minyakbumis')
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

        pengangkutan_minyakbumi::create($validatedData);

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

    public function hapus_pengmbx(Request $request, $id)
    {
        pengangkutan_minyakbumi::destroy($id);
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

    public function submit_pengmbx(Request $request, $id)
    {
        $idx = $id;
        $now = Carbon::now();
        $validatedData = DB::update("update pengangkutan_minyakbumis set status='1', tgl_kirim='$now' where id='$idx'");

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

    public function get_pengmb($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
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
            Alert::success('Success', 'Data berhasil diupdate');
            return back();
        } else {
            //redirect dengan pesan error
            Alert::error('Error', 'Data gagal diupdate');
            return back();
        }
    }

    public function importPengangkutanMB(Request $request)
    {
        $izin_id = $request->izin_id;
        $bulan = $request->bulan . "-01";

        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $cekdb = DB::table('pengangkutan_minyakbumis')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $bulan)
            ->orderBy('status', 'desc')
            ->first();
        // dd($cekdb->status);
        // die;

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

        $import = Excel::import(new ImportPengangkutanMB($bulan,$izin_id), request()->file('file'));

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

    public function show_pgbx($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        // Mengambil bulan dari tabel pengangkutan_minyakbumis sesuai ID badan usaha dan bulan yang ditemukan
        $bulan_ambil = DB::table('pengangkutan_gaskbumis')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $pecah[0])
            ->where('izin_id', $pecah[2])
            ->orderBy('status', 'desc')
            ->first();

        // Mengambil substring dari bulan
        $bulan_ambilx = $bulan_ambil ? substr($bulan_ambil->bulan, 0, 7) : '';
        $statusx = $bulan_ambil->status;

        if (count($pecah) == 4) {
            $filterBy = substr($pecah[0], 0, 4);
        } else {
        $filterBy = $pecah[0];
        }

        $pgb = pengangkutan_gaskbumi::where([
            ['bulan', 'like', "%". $filterBy ."%"],
            'badan_usaha_id' => $pecah[1],
            'izin_id' => $pecah[2]
        ])->orderBy('status', 'desc')->get();

        return view('badan_usaha.pengangkutan.gas_bumi.show', compact(
            'pgb',
            'bulan_ambilx',
            'statusx',
            'pecah'
        ));
    }

    public function simpan_pgbx(Request $request)
    {
        // dd($request->all());
        $request->merge([
            'bulan' => $request->bulan . '-01',
        ]);
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'izin_id.required' => 'izin_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'node_asal.required' => 'node asal masih kosong',
            'provinsi_asal.required' => 'provinsi asal masih kosong',
            'node_tujuan.required' => 'node tujuan masih kosong',
            'provinsi_tujuan.required' => 'provinsi tujuan masih kosong',
            // 'volume_supply.required' => 'volume supply masih kosong',
            // 'satuan_volume_supply.required' => 'satuan volume_supply masih kosong',
            'volume_angkut.required' => 'volume angkut masih kosong',
            'satuan_volume_angkut.required' => 'satuan volume angkut masih kosong',
        ];

        $validatedData = $request->validate([
            'badan_usaha_id' => 'required',
            'izin_id' => 'required',
            'bulan' => 'required',
            'produk' => 'required',
            'node_asal' => 'required',
            'provinsi_asal' => 'required',
            'node_tujuan' => 'required',
            'provinsi_tujuan' => 'required',
            // 'volume_supply' => 'required',
            // 'satuan_volume_supply' => 'required',
            'volume_angkut' => 'required',
            'satuan_volume_angkut' => 'required',

        ], $pesan);

        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $cekdb = DB::table('pengangkutan_gaskbumis')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $request->bulan)
            // ->where('bulan', '2023-09-01')
            ->orderBy('status', 'desc')
            ->first();

        // dd(isset($cekdb->status));
        // dd(($cekdb->status));
        // die;

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

        pengangkutan_gaskbumi::create($validatedData);

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

    public function hapus_pgbx(Request $request, $id)
    {
        pengangkutan_gaskbumi::destroy($id);
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

    public function submit_pgbx(Request $request, $id)
    {
        $idx = $id;
        $now = Carbon::now();
        $validatedData = DB::update("update pengangkutan_gaskbumis set status='1', tgl_kirim='$now' where id='$idx'");

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

    public function get_pgb($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
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
            Alert::success('Success', 'Data berhasil diupdate');
            return back();
        } else {
            //redirect dengan pesan error
            Alert::error('Error', 'Data gagal diupdate');
            return back();
        }
    }

    public function importPengangkutanGB(Request $request)
    {
        $izin_id = $request->izin_id;
        $bulan = $request->bulan . "-01";

        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $cekdb = DB::table('pengangkutan_gaskbumis')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $bulan)
            ->orderBy('status', 'desc')
            ->first();
        // dd($cekdb->status);
        // die;

        if (isset($cekdb) == 1) {
            if ($cekdb->status == 1) {
                Alert::error('Error', 'Bulan yang anda pilih sedang status kirim / revisi');
                return back();
            }
        }

        $import = Excel::import(new ImportPengangkutanGB($bulan,$izin_id), request()->file('file'));

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

    public function hapus_bulan_pengmbx(Request $request, $id)
    {
        // dd($bulan);
        // die;
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[0];
        $badan_usaha_id = $pecah[1];
        $izin_id = $pecah[2];
            
        $validatedData = DB::table('pengangkutan_minyakbumis')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $bulanx)
            ->where('izin_id', $izin_id)
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

    public function submit_bulan_pengmbx(Request $request, $id)
    {
      $pecah = explode(',', Crypt::decryptString($id));
      $bulanx = $pecah[0];
      $badan_usaha_id = $pecah[1];
      $izin_id = $pecah[2];
      $now = Carbon::now();
  
      // Menggunakan parameter binding untuk keamanan
      $validatedData = DB::table('pengangkutan_minyakbumis')
          ->where('bulan', $bulanx)
          ->where('badan_usaha_id', $badan_usaha_id)
          ->where('izin_id', $izin_id)
          ->update(['status' => '1', 'tgl_kirim' => $now]);

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

    public function hapus_bulan_pgbx(Request $request, $id)
    {
        // dd($bulan);
        // die;
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[0];
        $badan_usaha_id = $pecah[1];
        $izin_id = $pecah[2];
            
        $validatedData = DB::table('pengangkutan_gaskbumis')
            ->where('badan_usaha_id', $badan_usaha_id)
            ->where('bulan', $bulanx)
            ->where('izin_id', $izin_id)
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

    public function submit_bulan_pgbx(Request $request, $id)
    {
      $pecah = explode(',', Crypt::decryptString($id));
      $bulanx = $pecah[0];
      $badan_usaha_id = $pecah[1];
      $izin_id = $pecah[2];
      $now = Carbon::now();
  
      // Menggunakan parameter binding untuk keamanan
      $validatedData = DB::table('pengangkutan_gaskbumis')
          ->where('bulan', $bulanx)
          ->where('badan_usaha_id', $badan_usaha_id)
          ->where('izin_id', $izin_id)
          ->update(['status' => '1', 'tgl_kirim' => $now]);

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
}
