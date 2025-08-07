<?php

namespace App\Http\Controllers\bu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasokan_hasil_olah_bbm;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Importpasokanhasil;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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
        $request->merge([
            'bulan' => $request->bulan . '-01',
        ]);

        $pesan = [
            'npwp.required' => 'npwp masih kosong',
            'id_permohonan.required' => 'id_permohonan masih kosong',
            'id_sub_page.required' => 'id_sub_page masih kosong',
            'bulan.required' => 'bulan masih kosong',
            'produk.required' => 'produk masih kosong',
            'nama_pemasok.required' => 'provinsi masih kosong',
            'kategori_pemasok.required' => 'sektor masih kosong',
            'volume.required' => 'volume masih kosong',
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
        ], $pesan);

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        $npwp = Auth::user()->npwp;

        $cekdb = DB::table('pasokan_hasil_olah_bbms')
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
        // $validatedData = Pasokan_hasil_olah_bbm::create([
        //     'npwp' =>  $request->npwp,
        //     'id_permohonan' => $request->id_permohonan,
        //     'id_sub_page' => $request->id_sub_page,
        //     'bulan' => $request->bulan.'-01',
        //     'produk' => $request->produk,
        //     'nama_pemasok' => $request->nama_pemasok,
        //     'kategori_pemasok' => $request->kategori_pemasok,
        //     'volume' => $request->volume,
         
        //   ]);
        $created = Pasokan_hasil_olah_bbm::create($sanitizedData);

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
        // dd($request->all());
        $pasokan_olah = $id;
        $pesan = [
            // 'id.required' => 'id masih kosong',
            // 'npwp.required' => 'npwp masih kosong',
            // 'id_permohonan.required' => 'id_permohonan masih kosong',
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
            // 'npwp' => 'required',
            // 'id_permohonan' => 'required',
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

        // Sanitasi Input
        $sanitizedData = fullySanitizeInput($validatedData);

        Pasokan_hasil_olah_bbm::where('id', $pasokan_olah)
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
        $npwp = Auth::user()->npwp;
        $id_permohonan = $request->id_permohonan;
        $id_sub_page = $request->id_sub_page;

        $cekdb = DB::table('pasokan_hasil_olah_bbms')
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

            $import = Excel::import(new Importpasokanhasil($bulan, $id_permohonan, $id_sub_page), request()->file('file'));

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
        $data['provinsi'] = DB::select("SELECT DISTINCT ON (name) id, name FROM provinces ORDER BY name, id");
        $data['find'] = Pasokan_hasil_olah_bbm::find($id);
        return response()->json(['data' => $data]);
    }
    public function submit_pasokan_olahx(Request $request, $id)
    {
       $idx=$id;
       
       $now = Carbon::now();
        $validatedData = DB::update("update pasokan_hasil_olah_bbms set status='1', tgl_kirim='$now' where id='$idx'");

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
    public function submit_bulan_pasokan_olahx(Request $request, $id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];
        $now = Carbon::now();

        $affected = DB::table('pasokan_hasil_olah_bbms')
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

    public function hapus_bulan_pasokanx(Request $request, $id)
    {
        // Dekripsi ID dan pecah menjadi array
        $pecah = explode(',', Crypt::decryptString($id));
        $bulanx = $pecah[3];
        $npwp = $pecah[1];
        $id_permohonan = $pecah[0];
        $id_sub_page = $pecah[2];

        // Menggunakan query builder untuk menghapus data
        $affected = DB::table('pasokan_hasil_olah_bbms')
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
