<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // view()->composer('layouts.frontand.menu', function ($view) {
        //     if (!Auth::check()) {
        //         // Jika belum login, arahkan ke halaman /login
        //         return Redirect::to('/login');
        //     }

        //     $meping = DB::table('mepings')->groupBy('id_template')->get();
        //     $sub_page = DB::table('mepings')->groupBy('id_sub_page')->get();
        //     $sub_menu = DB::table('mepings')->groupBy('id_sub_menu')->get();

        //     $max = 10; // Ini bisa disesuaikan dengan kebutuhan Anda

        //     $queries = [];
        //     for($i = 1; $i <= $max; $i++) {
        //         $queries[] = "SELECT $i AS n";
        //     }
            
        //     $unionQuery = implode(" UNION ALL ", $queries);
        //     $numbers = DB::table(DB::raw("($unionQuery) AS numbers"));
            
        //     $subQuery = DB::table('r_permohonan_izin as a')
        //         ->join('t_perusahaan as b', 'a.ID_PERUSAHAAN', '=', 'b.ID_PERUSAHAAN')
        //         ->join('fgen_r_template_izin as c', 'a.ID_TEMPLATE', '=', 'c.ID_TEMPLATE')
        //         ->joinSub($numbers, 'numbers', function($join) {
        //             $join->on(DB::raw('CHAR_LENGTH(REPLACE(a.LIST_SUB_PAGE, "-", ",")) - CHAR_LENGTH(REPLACE(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", ""))'), '>=', DB::raw('numbers.n - 1'));
        //         })
        //         ->where('a.ID_CURR_PROSES', '=', '140')
        //         ->where('a.ID_PERUSAHAAN', '=', Auth::user()->badan_usaha_id)
        //         ->whereIn('a.ID_TEMPLATE', function($query) {
        //             $query->select(DB::raw('DISTINCT id_template'))
        //                 ->from('mepings');
        //         })
        //         ->select([
        //             'a.ID_PERUSAHAAN',
        //             'b.NAMA_PERUSAHAAN',
        //             'a.ID_TEMPLATE',
        //             'c.NAMA_TEMPLATE',
        //             DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(a.LIST_SUB_PAGE, "-", ","), ",", numbers.n), ",", -1) AS SUB_PAGE'),
        //             'a.ID_CURR_PROSES'
        //         ]);
            
        //         $result = DB::table(DB::raw("({$subQuery->toSql()}) as k"))
        //         ->mergeBindings($subQuery) // penting! agar bindings dapat digunakan dengan benar
        //         ->join('mepings as d', 'k.SUB_PAGE', '=', 'd.id_sub_page')
        //         ->whereIn('SUB_PAGE', function($query) {
        //             $query->select(DB::raw('DISTINCT id_sub_page'))
        //                 ->from('mepings')
        //                 ->where('STATUS', '=', 1);
        //         })
        //         ->select([
        //             'k.ID_PERUSAHAAN',
        //             'k.NAMA_PERUSAHAAN',
        //             'k.NAMA_TEMPLATE',
        //             'k.SUB_PAGE',
        //             'd.nama_opsi',
        //             'd.id_sub_menu'
        //         ])
        //         ->get();
        //         // dd($result);

        //     $view->with(compact('meping', 'sub_page', 'sub_menu', 'result'));
        // });
    }
}
