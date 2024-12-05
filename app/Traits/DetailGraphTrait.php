<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait DetailGraphTrait
{
    public function getDetailNiagaMB($date){
        $results = DB::select("
            SELECT 'Penjualan Hasil Olahan/Minyak Bumi/BBM' as name, count(*) as count FROM jual_hasil_olah_bbms where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Pasokan Hasil Olahan/Minyak Bumi/BBM' as name, count(*) as count FROM pasokan_hasil_olah_bbms where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Harga BBM JBU/Hasil Olahan/Minyak Bumi' as name, count(*) as count FROM harga_bbm_jbus where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Ekspor' as name, count(*) as count FROM ekspors where date_format(bulan_peb, '%Y-%m') = ?
            union
            SELECT 'Impor' as name, count(*) as count FROM impors where date_format(bulan_pib, '%Y-%m') = ?
            union
            SELECT 'Penyimpanan Minyak Bumi/BBM/Hasil Olahan' as name, count(*) as count FROM penyminyakbumis where date_format(bulan, '%Y-%m') = ?
        ", [$date, $date, $date, $date, $date, $date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }

    public function getDetailPengolahanMB($date){
        $results = DB::select("
            SELECT 'Harga BBM JBU/Hasil Olahan/Minyak Bumi' as name, count(*) as count FROM harga_bbm_jbus where date_format(bulan,'%Y-%m') = ? union
            SELECT 'Minyak Bumi/Hasil Olahan Produksi Kilang' as name, count(*) as count FROM pengolahan_minyak_bumi_produksis where date_format(bulan,'%Y-%m') = ? union
            SELECT 'Minyak Bumi/Hasil Olahan Pasokan Kilang' as name, count(*) as count FROM pengolahan_minyak_bumi_pasokans where date_format(bulan,'%Y-%m') = ? union
            SELECT 'Minyak Bumi/Hasil Olahan Distribusi/Penjualan Domestik Kilang ' as name, count(*) as count FROM pengolahan_minyak_bumi_distribusis where date_format(bulan,'%Y-%m') = ? union
            SELECT 'Ekspor' as name, count(*) as count FROM ekspors where date_format(bulan_peb,'%Y-%m') = ? union
            SELECT 'Impor' as name, count(*) as count FROM impors where date_format(bulan_pib,'%Y-%m') = ? union
            SELECT 'Penyimpanan Minyak Bumi/BBM/Hasil Olahan' as name, count(*) as count FROM penyminyakbumis where date_format(bulan,'%Y-%m') = ?
        ", [$date, $date, $date, $date, $date, $date, $date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }

    public function getDetailPengangkutanMB($date){
        $results = DB::select("
            SELECT 'Pengangkutan Minyak Bumi' as name, count(*) as count FROM pengangkutan_minyakbumis where date_format(bulan,'%Y-%m') = ?
        ", [$date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }

    public function getDetailPenyimpananMB($date){
        $results = DB::select("
            SELECT 'Penyimpanan Minyak Bumi' as name, count(*) as count FROM penyminyakbumis where date_format(bulan,'%Y-%m') = ?
        ", [$date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }

    public function getDetailNiagaGas($date){
        $results = DB::select("
            SELECT 'Harga LPG' as name, count(*) as count FROM harga_l_p_g_s where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Penjualan LNG/CNG' as name, count(*) as count FROM penjualan_lngs where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Pasokan LNG' as name, count(*) as count FROM pasokanlngs where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Penjualan LPG' as name, count(*) as count FROM penjualan_lpgs where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Pasokan LPG' as name, count(*) as count FROM pasokan_l_p_g_s where date_format(bulan, '%Y-%m') = ?
            union
            SELECT 'Ekspor' as name, count(*) as count FROM ekspors where date_format(bulan_peb, '%Y-%m') = ?
            union
            SELECT 'Impor' as name, count(*) as count FROM impors where date_format(bulan_pib, '%Y-%m') = ?
        ", [$date, $date, $date, $date, $date, $date, $date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }

    public function getDetailPengolahanGas($date){
        $results = DB::select("
            SELECT 'Pengolahan Gas' as name, count(*) as count FROM pengolahans where jenis='Gas Bumi' and date_format(bulan,'%Y-%m') = ?
        ", [$date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }

    public function getDetailPengangkutanGas($date){
        $results = DB::select("
            SELECT 'Pengangkutan Gas Bumi' as name, count(*) as count FROM pengangkutan_gaskbumis where date_format(bulan,'%Y-%m') = ?
        ", [$date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }

    public function getDetailPenyimpananGas($date){
        $results = DB::select("
            SELECT 'Penyimpanan Gas Bumi' as name, count(*) as count FROM penygasbumis where date_format(bulan,'%Y-%m') = ?
        ", [$date]);

        $categories = array_map(fn($row) => $row->name, $results);
        $data = array_map(fn($row) => $row->count, $results);

        return compact('categories', 'data');
    }
}
