<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\T_perusahaan;
use Illuminate\Support\Str;
use App\Models\Meping;
use App\Models\User;

class DataIzinBuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index_minyak()
    {
        $meping = Meping::select('id_template')->distinct()->get();
        $sub_page = Meping::select('id_sub_page')->distinct()->get();
        $sub_menu = Meping::select('id_sub_menu')->distinct()->get();

        // Buat angka 1–10
        $max = 10;
        $queries = [];
        for ($i = 1; $i <= $max; $i++) {
            $queries[] = "SELECT $i AS n";
        }

        $unionQuery = implode(" UNION ALL ", $queries);
        $numbers = DB::table(DB::raw("($unionQuery) AS numbers"));

        // Subquery utama
        $subQuery = DB::table('r_permohonan_izin as a')
            ->join('t_perusahaan as b', 'a.id_perusahaan', '=', 'b.id_perusahaan')
            ->join('fgen_r_sub_page as c', 'a.id_template', '=', 'c.id_template')
            ->join('provinces as prov', 'b.id_provinsi', '=', 'prov.id')
            ->join('kotas as kot', 'b.id_kabkot', '=', 'kot.id')
            ->joinSub($numbers, 'numbers', function ($join) {
                $join->on(DB::raw("char_length(REPLACE(a.list_sub_page, '-', ',')) - char_length(REPLACE(REPLACE(a.list_sub_page, '-', ','), ',', ''))"), '>=', DB::raw('numbers.n - 1'));
            })
            ->where('a.id_curr_proses', '=', 140)
            ->whereIn('a.id_template', function ($query) {
                $query->select(DB::raw('DISTINCT CAST(id_template AS INTEGER)'))->from('mepings');
            })  
            ->select([
                'a.id_perusahaan as ID_PERUSAHAAN',
                'b.nama_perusahaan as NAMA_PERUSAHAAN',
                'b.alamat as ALAMAT',
                'b.id_provinsi as ID_PROVINSI',
                'prov.name as nama_provinsi',
                'b.id_kabkot as ID_KABKOT',
                'kot.nama_kota',
                'b.email_perusahaan as EMAIL_PERUSAHAAN',
                'b.telepon as TELEPON',
                'a.id_template as ID_TEMPLATE',
                'c.nama_opsi as NAMA_TEMPLATE',
                DB::raw("split_part(REPLACE(a.list_sub_page, '-', ','), ',', numbers.n) AS list_sub_page"),
                'a.id_curr_proses as ID_CURR_PROSES',
                'a.tgl_disetujui as TGL_DISETUJUI',
                'a.nomor_izin as NOMOR_IZIN',
                'a.file_izin as FILE_IZIN',
            ]);

        // Query utama
        $result = DB::table(DB::raw("({$subQuery->toSql()}) as k"))
            ->mergeBindings($subQuery)
            ->join('mepings as d', 'k.list_sub_page', '=', 'd.id_sub_page')
            ->whereIn('k.list_sub_page', function ($query) {
                $query->select(DB::raw('DISTINCT id_sub_page'))
                    ->from('mepings')
                    ->where('status', '=', 1)
                    ->where('kategori', '=', 2);
            })
            ->select([
                'k.ID_PERUSAHAAN as ID_PERUSAHAAN',
                'k.NAMA_PERUSAHAAN as NAMA_PERUSAHAAN',
                'k.ALAMAT as ALAMAT',
                'k.ID_PROVINSI as ID_PROVINSI',
                'k.nama_provinsi',
                'k.ID_KABKOT as ID_KABKOT',
                'k.nama_kota',
                'k.EMAIL_PERUSAHAAN as EMAIL_PERUSAHAAN',
                'k.TELEPON as TELEPON',
                'k.ID_TEMPLATE as ID_TEMPLATE',
                'k.NAMA_TEMPLATE as NAMA_TEMPLATE',
                'k.list_sub_page as SUB_PAGE',
                'k.TGL_DISETUJUI as TGL_DISETUJUI',
                'k.NOMOR_IZIN as NOMOR_IZIN',
                'k.FILE_IZIN as FILE_IZIN',
                'd.nama_opsi',
            ])

            ->get();

        return view('evaluator.data_bu.index_minyak', compact(
            'result',
            'meping',
            'sub_page',
            'sub_menu'
        ));
    }

    public function index_gas()
    {
        $meping = Meping::select('id_template')->distinct()->get();
        $sub_page = Meping::select('id_sub_page')->distinct()->get();
        $sub_menu = Meping::select('id_sub_menu')->distinct()->get();

        $max = 10;

        $queries = [];
        for ($i = 1; $i <= $max; $i++) {
            $queries[] = "SELECT $i AS n";
        }

        $unionQuery = implode(" UNION ALL ", $queries);
        $numbers = DB::table(DB::raw("($unionQuery) AS numbers"));

        $subQuery = DB::table('r_permohonan_izin as a')
            ->join('t_perusahaan as b', 'a.id_perusahaan', '=', 'b.id_perusahaan')
            ->join('fgen_r_sub_page as c', 'a.id_template', '=', 'c.id_template')
            ->join('provinces as prov', 'b.id_provinsi', '=', 'prov.id')
            ->join('kotas as kot', 'b.id_kabkot', '=', 'kot.id')
            ->joinSub($numbers, 'numbers', function ($join) {
                $join->on(DB::raw("char_length(REPLACE(a.list_sub_page, '-', ',')) - char_length(REPLACE(REPLACE(a.list_sub_page, '-', ','), ',', ''))"), '>=', DB::raw('numbers.n - 1'));
            })
            ->where('a.id_curr_proses', '=', 140)
            ->whereIn('a.id_template', function ($query) {
                $query->select(DB::raw('DISTINCT CAST(id_template AS INTEGER)'))->from('mepings');
            })
            ->select([
            'a.id_perusahaan as ID_PERUSAHAAN',
            'b.nama_perusahaan as NAMA_PERUSAHAAN',
            'b.alamat as ALAMAT',
            'b.id_provinsi as ID_PROVINSI',
            'prov.name as nama_provinsi',
            'b.id_kabkot as ID_KABKOT',
            'kot.nama_kota',
            'b.email_perusahaan as EMAIL_PERUSAHAAN',
            'b.telepon as TELEPON',
            'a.id_template as ID_TEMPLATE',
            'c.nama_opsi as NAMA_TEMPLATE',
            DB::raw("split_part(REPLACE(a.list_sub_page, '-', ','), ',', numbers.n) AS list_sub_page"),
            'a.id_curr_proses as ID_CURR_PROSES',
            'a.tgl_disetujui as TGL_DISETUJUI',
            'a.nomor_izin as NOMOR_IZIN',
            'a.file_izin as FILE_IZIN',
            ]);

        $result = DB::table(DB::raw("({$subQuery->toSql()}) as k"))
            ->mergeBindings($subQuery) // Important! To use bindings correctly
            ->join('mepings as d', 'k.list_sub_page', '=', 'd.id_sub_page')
            ->whereIn('k.list_sub_page', function ($query) {
                $query->select(DB::raw('DISTINCT id_sub_page'))
                    ->from('mepings')
                    ->where('status', '=', 1)
                    ->where('kategori', '=', 1);
            })
            ->select([
            'k.ID_PERUSAHAAN as ID_PERUSAHAAN',
            'k.NAMA_PERUSAHAAN as NAMA_PERUSAHAAN',
            'k.ALAMAT as ALAMAT',
            'k.ID_PROVINSI as ID_PROVINSI',
            'k.nama_provinsi',
            'k.ID_KABKOT as ID_KABKOT',
            'k.nama_kota',
            'k.EMAIL_PERUSAHAAN as EMAIL_PERUSAHAAN',
            'k.TELEPON as TELEPON',
            'k.ID_TEMPLATE as ID_TEMPLATE',
            'k.NAMA_TEMPLATE as NAMA_TEMPLATE',
            'k.list_sub_page as SUB_PAGE',
            'k.TGL_DISETUJUI as TGL_DISETUJUI',
            'k.NOMOR_IZIN as NOMOR_IZIN',
            'k.FILE_IZIN as FILE_IZIN',
            'd.nama_opsi',
            ])->get();

            // dd($result);

        return view('evaluator.data_bu.index_gas', compact(
            'result',
            'meping',
            'sub_page',
            'sub_menu'
        ));
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
