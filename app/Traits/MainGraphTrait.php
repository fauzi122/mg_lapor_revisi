<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait MainGraphTrait
{
    public function getCountMinyakBumi($date){
        // Query count untuk kategori #NIAGA
        $niagaCounts = [
            DB::table('jual_hasil_olah_bbms')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('pasokan_hasil_olah_bbms')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('harga_bbm_jbus')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('ekspors')
                ->where(DB::raw("DATE_FORMAT(bulan_peb, '%Y-%m')"), $date)
                ->count(),

            DB::table('impors')
                ->where(DB::raw("DATE_FORMAT(bulan_pib, '%Y-%m')"), $date)
                ->count(),

            DB::table('penyminyakbumis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGOLAHAN
        $pengolahanCounts = [
            DB::table('harga_bbm_jbus')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('pengolahan_minyak_bumi_produksis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('pengolahan_minyak_bumi_pasokans')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('pengolahan_minyak_bumi_distribusis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('ekspors')
                ->where(DB::raw("DATE_FORMAT(bulan_peb, '%Y-%m')"), $date)
                ->count(),

            DB::table('impors')
                ->where(DB::raw("DATE_FORMAT(bulan_pib, '%Y-%m')"), $date)
                ->count(),

            DB::table('penyminyakbumis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGANGKUTAN
        $pengangkutanCounts = [
            DB::table('pengangkutan_minyakbumis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENYIMPANAN
        $penyimpananCounts = [
            DB::table('penyminyakbumis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),
        ];

        // Kembalikan hasil sebagai array yang dikelompokkan
        return [
            array_sum($niagaCounts),
            array_sum($pengolahanCounts),
            array_sum($pengangkutanCounts),
            array_sum($penyimpananCounts)
        ];
    }

    public function getCountGas($date)
    {
        // Query count untuk kategori #NIAGA
        $niagaCounts = [
            DB::table('setum_kop.harga_l_p_g_s')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('setum_kop.penjualan_lngs')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('setum_kop.pasokanlngs')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('setum_kop.penjualan_lpgs')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('setum_kop.pasokan_l_p_g_s')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),

            DB::table('setum_kop.ekspors')
                ->where(DB::raw("DATE_FORMAT(bulan_peb, '%Y-%m')"), $date)
                ->count(),

            DB::table('setum_kop.impors')
                ->where(DB::raw("DATE_FORMAT(bulan_pib, '%Y-%m')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGOLAHAN
        $pengolahanCounts = [
            DB::table('setum_kop.pengolahans')
                ->where('jenis', 'Gas Bumi')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGANGKUTAN
        $pengangkutanCounts = [
            DB::table('setum_kop.pengangkutan_gaskbumis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENYIMPANAN
        $penyimpananCounts = [
            DB::table('setum_kop.penygasbumis')
                ->where(DB::raw("DATE_FORMAT(bulan, '%Y-%m')"), $date)
                ->count(),
        ];

        // Jumlahkan hasil dari setiap kategori
        return [
            array_sum($niagaCounts),
            array_sum($pengolahanCounts),
            array_sum($pengangkutanCounts),
            array_sum($penyimpananCounts),
        ];
    }
}
