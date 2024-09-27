<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasokan_hasil_olah_bbm;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Importpasokanhasil;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PasokanHasilolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pesan = [
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            'izin_id.required' => 'izin_id masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'nama_pemasok.required' => 'provinsi masih kosong',
            'kategori_pemasok.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
        ];

        $validatedData = $request->validate([
            'badan_usaha_id' => 'required',
            'izin_id' => 'required',
            'bulan' => 'required',
            'produk' => 'required',
            'nama_pemasok' => 'required',
            'kategori_pemasok' => 'required',
            'volume' => 'required',
        ], $pesan);
        $badan_usaha_id = Auth::user()->badan_usaha_id;

        $cekdb = DB::table('pasokan_hasil_olah_bbms')
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
        $validatedData = Pasokan_hasil_olah_bbm::create([
            'badan_usaha_id' =>  $request->badan_usaha_id,
            'izin_id' => $request->izin_id,
            'bulan' => $request->bulan.'-01',
            'produk' => $request->produk,
            'nama_pemasok' => $request->nama_pemasok,
            'kategori_pemasok' => $request->kategori_pemasok,
            'volume' => $request->volume,
         
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
    public function update_pasokan(Request $request, $id)
    {
        // dd($id);
        $pasokan_olah = $id;
        $pesan = [
            // 'id.required' => 'id masih kosong',
            'badan_usaha_id.required' => 'badan_usaha_id masih kosong',
            // 'izin_id.required' => 'izin_id masih kosong',
            // 'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'nama_pemasok.required' => 'nama_pemasok masih kosong',
            'kategori_pemasok.required' => 'kategori_pemasok masih kosong',
            // 'provinsi.required' => 'provinsi masih kosong',
            // 'kabupaten_kota.required' => 'kabupaten_kota masih kosong',
            // 'sektor.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
            // 'satuan.required' => 'satuan masih kosong',
            // 'status.required' => 'status masih kosong',
            // 'catatan.required' => 'catatan masih kosong',
            // 'petugas.required' => 'petugas masih kosong',
        ];

        $rules = [
            // 'id' => 'required',
            'badan_usaha_id' => 'required',
            // 'izin_id' => 'required',
            // 'bulan' => 'required',
            'produk' => 'required',
            'nama_pemasok' => 'required',
            'kategori_pemasok' => 'required',
            // 'provinsi' => 'required',
            // 'kabupaten_kota' => 'required',
            // 'sektor' => 'required',
            'volume' => 'required',
            // 'satuan' => 'required',
            // 'status' => 'required',
            // 'catatan' => 'required',
            // 'petugas' => 'required', 

        ];

        $validatedData = $request->validate($rules, $pesan);

        Pasokan_hasil_olah_bbm::where('id', $pasokan_olah)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pasokan_hasil_olah_bbm::destroy($id);
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
    public function importpasokanx(Request $request)
    {
        $bulan = $request->bulan . "-01";
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $cekdb = DB::table('pasokan_hasil_olah_bbms')
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

            $import = Excel::import(new Importpasokanhasil($bulan), request()->file('file'));

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
    public function get_pasokan_ho($id)
    {
        $data['produk'] = DB::select("SELECT produks.name FROM produks GROUP BY produks.name");
        $data['provinsi'] = DB::select("SELECT provinces.id, provinces.name FROM provinces GROUP BY provinces.name");
        $data['find'] = Pasokan_hasil_olah_bbm::find($id);
        return response()->json(['data' => $data]);
    }
    public function submit_pasokan_olahx(Request $request, $id)
    {
       $idx=$id;
        $validatedData = DB::update("update pasokan_hasil_olah_bbms set status='1' where id='$idx'");

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
    public function submit_bulan_pasokan_olahx(Request $request, $bulan)
    {
        $bulanx = $bulan;
        // dd($bulanx);
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("update pasokan_hasil_olah_bbms set status='1' where bulan='$bulanx' and badan_usaha_id='$badan_usaha_id'");

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
    public function hapus_bulan_pasokanx(Request $request, $bulan)
    {
        $bulanx = $bulan;
        $badan_usaha_id = Auth::user()->badan_usaha_id;
        $validatedData = DB::update("DELETE FROM pasokan_hasil_olah_bbms WHERE badan_usaha_id='$badan_usaha_id' AND bulan='$bulanx'");
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
