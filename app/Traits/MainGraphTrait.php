<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait MainGraphTrait
{
    public function getCountMinyakBumi($date){
        // Query count untuk kategori #NIAGA
        $niagaCounts = [
            DB::table('jual_hasil_olah_bbms')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('pasokan_hasil_olah_bbms')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('harga_bbm_jbus')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('ekspors')
                ->where(DB::raw("TO_CHAR(bulan_peb, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('impors')
                ->where(DB::raw("TO_CHAR(bulan_pib, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('penyminyakbumis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGOLAHAN
        $pengolahanCounts = [
            DB::table('harga_bbm_jbus')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('pengolahan_minyak_bumi_produksis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('pengolahan_minyak_bumi_pasokans')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('pengolahan_minyak_bumi_distribusis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('ekspors')
                ->where(DB::raw("TO_CHAR(bulan_peb, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('impors')
                ->where(DB::raw("TO_CHAR(bulan_pib, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('penyminyakbumis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGANGKUTAN
        $pengangkutanCounts = [
            DB::table('pengangkutan_minyakbumis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENYIMPANAN
        $penyimpananCounts = [
            DB::table('penyminyakbumis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
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
            DB::table('harga_l_p_g_s')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('penjualan_lngs')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('pasokanlngs')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('penjualan_lpgs')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('pasokan_l_p_g_s')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('ekspors')
                ->where(DB::raw("TO_CHAR(bulan_peb, 'YYYY-MM')"), $date)
                ->count(),

            DB::table('impors')
                ->where(DB::raw("TO_CHAR(bulan_pib, 'YYYY-MM')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGOLAHAN
        $pengolahanCounts = [
            DB::table('pengolahans')
                ->where('jenis', 'Gas Bumi')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENGANGKUTAN
        $pengangkutanCounts = [
            DB::table('pengangkutan_gaskbumis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
                ->count(),
        ];

        // Query count untuk kategori #PENYIMPANAN
        $penyimpananCounts = [
            DB::table('penygasbumis')
                ->where(DB::raw("TO_CHAR(bulan, 'YYYY-MM')"), $date)
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
