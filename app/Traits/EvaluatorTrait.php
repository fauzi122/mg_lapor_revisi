<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait EvaluatorTrait
{
    public function indexQuery(string $tableName)
    {
        return DB::table($tableName . ' as h')
            ->join('izin_migas as i', 'i.npwp', '=', 'h.npwp')
            ->join('users as u', 'u.npwp', '=', 'i.npwp')
            ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
            ->select(
                'u.name as nama_perusahaan',
                'i.npwp',
                DB::raw("(d ->> 'Id_Permohonan')::int as id_permohonan"),
                DB::raw("MIN(d ->> 'No_SK_Izin') as no_sk_izin"),
                DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tanggal_izin"),
                DB::raw("MIN(d ->> 'Kode_Izin_Desc') as kode_izin_desc"),
                DB::raw("MIN(d ->> 'Jenis_Izin_Desc') as jenis_izin_desc"),
                DB::raw("MIN(d ->> 'Jenis_Pengesahan') as jenis_pengesahan"),
                DB::raw("MIN(d ->> 'Status_Pengesahan') as status_pengesahan"),
                DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tanggal_pengesahan"),
                DB::raw("MIN((d ->> 'Tanggal_Berakhir_izin')::date) as tanggal_berakhir_izin")
            )
            ->whereColumn(DB::raw("(d ->> 'Id_Permohonan')::int"), 'h.id_permohonan')
            ->whereIn(DB::raw('h.status::int'), [1, 2, 3])
            ->groupBy('u.name', 'i.npwp', DB::raw("(d ->> 'Id_Permohonan')::int"));
    }

    public function periodeQuery(string $tableName, $data, $colBulan = 'bulan')
    {
        return DB::table($tableName . ' as a')
            ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
            ->selectRaw('
                MAX(a.npwp) as npwp, 
                MAX(a.id_permohonan) as id_permohonan, 
                a.'. $colBulan . ', 
                MAX(a.status) as status, 
                MAX(a.catatan) as catatan, 
                MAX(u.name) as nama_perusahaan,
                MAX(u.badan_usaha_id) as badan_usaha_id
                ')
            ->where('a.npwp', $data[0])
            ->where('a.id_permohonan', $data[1])
            ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
            ->groupBy('a.'. $colBulan);
    }

    public function showQuery (string $tableName, $npwp, $id_permohonan, $filter, $colBulan = 'bulan')
    {

        return DB::table($tableName . ' as a')
                ->leftJoin('users as u', 'a.npwp', '=', 'u.npwp')
                // ->leftJoin('mepings as m', DB::raw("CAST(a.id_sub_page AS TEXT)"), '=', DB::raw("m.id_sub_page"))
                // ->select('a.*', 'u.name as nama_perusahaan', 'm.nama_opsi')
                ->select('a.*', 'u.name as nama_perusahaan')
                ->where('a.npwp', $npwp)
                ->where('a.id_permohonan', $id_permohonan)
                ->where('a.'. $colBulan, 'like', $filter)
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3]);
    }

    public function perusahaanQuery(string $tableName, $colBulan = 'bulan')
    {
        return DB::table($tableName . ' as a')
                ->leftJoin('users as u', 'u.npwp', '=', 'a.npwp')
                ->leftJoin('izin_migas as i', 'i.npwp', '=', 'u.npwp')
                ->crossJoin(DB::raw("jsonb_array_elements(i.data_izin::jsonb) as d"))
                ->whereIn(DB::raw('a.status::int'), [1, 2, 3])
                ->groupBy(
                    'u.name',
                    'i.npwp'
                )
                ->select(
                    DB::raw("MAX(a.".$colBulan.") as bulan_terbaru"),
                    'u.name as nama_perusahaan',
                    'i.npwp',
                    DB::raw("MIN(d ->> 'No_SK_Izin') as nomor_izin"),
                    DB::raw("MIN((d ->> 'Tanggal_Pengesahan')::timestamp) as tgl_disetujui"),
                    DB::raw("MIN((d ->> 'Tanggal_izin')::date) as tgl_pengajuan")
                );
    }    
}