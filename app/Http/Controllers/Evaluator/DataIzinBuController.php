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
        $meping = Meping::groupBy('id_template')->get();
        $sub_page = Meping::groupBy('id_sub_page')->get();
        $sub_menu = Meping::groupBy('id_sub_menu')->get();
    
        $max = 10;
    
        $queries = [];
        for ($i = 1; $i <= $max; $i++) {
            $queries[] = "SELECT $i AS n";
        }
    
        $unionQuery = implode(" UNION ALL ", $queries);
        $numbers = DB::table(DB::raw("($unionQuery) AS numbers"));
    
        $subQuery = DB::table('r_permohonan_izin as a')
            ->join('t_perusahaan as b', 'a.ID_PERUSAHAAN', '=', 'b.ID_PERUSAHAAN')
            ->join('fgen_r_template_izin as c', 'a.ID_TEMPLATE', '=', 'c.ID_TEMPLATE')
            ->join('provinces as prov', 'b.ID_PROVINSI', '=', 'prov.id') // Join with provinces
            ->join('kotas as kot', 'b.ID_KABKOT', '=', 'kot.id') // Join with kotas
            ->joinSub($numbers, 'numbers', function ($join) {
                $join->on(DB::raw('CHAR_LENGTH(REPLACE(a.LIST_SUB_PAGE, "-", ",")) - CHAR_LENGTH(REPLACE(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", ""))'), '>=', DB::raw('numbers.n - 1'));
            })
            ->where('a.ID_CURR_PROSES', '=', '140')
           
            ->whereIn('a.ID_TEMPLATE', function ($query) {
                $query->select(DB::raw('DISTINCT id_template'))
                    ->from('mepings');
            })
            ->select([
                'a.ID_PERUSAHAAN',
                'b.NAMA_PERUSAHAAN',
                'b.ALAMAT',
                'b.ID_PROVINSI',
                'prov.name AS nama_provinsi',
                'b.ID_KABKOT',
                'kot.nama_kota',
                'b.EMAIL_PERUSAHAAN',
                'b.TELEPON',
                'a.ID_TEMPLATE',
                'c.NAMA_TEMPLATE',
                DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", numbers.n), ",", -1) AS SUB_PAGE'),
                'a.ID_CURR_PROSES',
                'a.TGL_DISETUJUI',
                'a.NOMOR_IZIN',
                'a.FILE_IZIN',
            ]);
    
        $result = DB::table(DB::raw("({$subQuery->toSql()}) as k"))
            ->mergeBindings($subQuery) // Important! To use bindings correctly
            ->join('mepings as d', 'k.SUB_PAGE', '=', 'd.id_sub_page')
            ->whereIn('SUB_PAGE', function ($query) {
                $query->select(DB::raw('DISTINCT id_sub_page'))
                    ->from('mepings')
                    ->where('STATUS', '=', 1)
                    ->where('kategori', '=', 2);
            })
            ->select([
                'k.ID_PERUSAHAAN',
                'k.NAMA_PERUSAHAAN',
                'k.ALAMAT',
                'k.ID_PROVINSI',
                'k.nama_provinsi',
                'k.ID_KABKOT',
                'k.nama_kota',
                'k.EMAIL_PERUSAHAAN',
                'k.TELEPON',
                'k.ID_TEMPLATE',
                'k.NAMA_TEMPLATE',
                'k.SUB_PAGE',
                'k.TGL_DISETUJUI',
                'k.NOMOR_IZIN',
                'k.FILE_IZIN',
                'd.nama_opsi',
            ])->get();

            // dd($result);
    
        return view('evaluator.data_bu.index_minyak', compact(
            'result',
            'meping',
            'sub_page',
            'sub_menu'
        ));
    }

    public function index_gas()
    {
        $meping = Meping::groupBy('id_template')->get();
        $sub_page = Meping::groupBy('id_sub_page')->get();
        $sub_menu = Meping::groupBy('id_sub_menu')->get();
    
        $max = 10;
    
        $queries = [];
        for ($i = 1; $i <= $max; $i++) {
            $queries[] = "SELECT $i AS n";
        }
    
        $unionQuery = implode(" UNION ALL ", $queries);
        $numbers = DB::table(DB::raw("($unionQuery) AS numbers"));
    
        $subQuery = DB::table('r_permohonan_izin as a')
            ->join('t_perusahaan as b', 'a.ID_PERUSAHAAN', '=', 'b.ID_PERUSAHAAN')
            ->join('fgen_r_template_izin as c', 'a.ID_TEMPLATE', '=', 'c.ID_TEMPLATE')
            ->join('provinces as prov', 'b.ID_PROVINSI', '=', 'prov.id') // Join with provinces
            ->join('kotas as kot', 'b.ID_KABKOT', '=', 'kot.id') // Join with kotas
            ->joinSub($numbers, 'numbers', function ($join) {
                $join->on(DB::raw('CHAR_LENGTH(REPLACE(a.LIST_SUB_PAGE, "-", ",")) - CHAR_LENGTH(REPLACE(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", ""))'), '>=', DB::raw('numbers.n - 1'));
            })
            ->where('a.ID_CURR_PROSES', '=', '140')
           
            ->whereIn('a.ID_TEMPLATE', function ($query) {
                $query->select(DB::raw('DISTINCT id_template'))
                    ->from('mepings');
            })
            ->select([
                'a.ID_PERUSAHAAN',
                'b.NAMA_PERUSAHAAN',
                'b.ALAMAT',
                'b.ID_PROVINSI',
                'prov.name AS nama_provinsi',
                'b.ID_KABKOT',
                'kot.nama_kota',
                'b.EMAIL_PERUSAHAAN',
                'b.TELEPON',
                'a.ID_TEMPLATE',
                'c.NAMA_TEMPLATE',
                DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", numbers.n), ",", -1) AS SUB_PAGE'),
                'a.ID_CURR_PROSES',
                'a.TGL_DISETUJUI',
                'a.NOMOR_IZIN',
                'a.FILE_IZIN',
            ]);
    
        $result = DB::table(DB::raw("({$subQuery->toSql()}) as k"))
            ->mergeBindings($subQuery) // Important! To use bindings correctly
            ->join('mepings as d', 'k.SUB_PAGE', '=', 'd.id_sub_page')
            ->whereIn('SUB_PAGE', function ($query) {
                $query->select(DB::raw('DISTINCT id_sub_page'))
                    ->from('mepings')
                    ->where('STATUS', '=', 1)
                    ->where('kategori', '=', 1);
            })
            ->select([
                'k.ID_PERUSAHAAN',
                'k.NAMA_PERUSAHAAN',
                'k.ALAMAT',
                'k.ID_PROVINSI',
                'k.nama_provinsi',
                'k.ID_KABKOT',
                'k.nama_kota',
                'k.EMAIL_PERUSAHAAN',
                'k.TELEPON',
                'k.ID_TEMPLATE',
                'k.NAMA_TEMPLATE',
                'k.SUB_PAGE',
                'k.TGL_DISETUJUI',
                'k.NOMOR_IZIN',
                'k.FILE_IZIN',
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
