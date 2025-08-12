<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsEvController extends Controller
{
    public function index()
    {
        $logs = Logs::get();
        return view('logs.index', compact('logs'));
    }

    public function periode()
    {
        $logsPeriode = Logs::selectRaw("MAX(created_at) as created_at")
            ->groupByRaw("DATE_TRUNC('month', created_at)")
            ->orderByRaw("MAX(created_at) DESC")
            ->get();

        return view('logs.periode', compact('logsPeriode'));
    }

    public function show(Request $request)
    {
        $filter = $request->query('filter'); // 'bulan' atau 'tahun'
        $value = $request->query('value');   // misal '08' atau '2025'

        $query = Logs::select(
            DB::raw("properties::jsonb ->> 'npwp' AS npwp"),
            DB::raw("properties::jsonb ->> 'id_permohonan' AS id_permohonan"),
            DB::raw("properties::jsonb ->> 'bulan' AS bulan"),
            DB::raw("properties::jsonb ->> 'produk' AS produk"),
            DB::raw("properties::jsonb ->> 'sektor' AS sektor"),
            DB::raw("properties::jsonb ->> 'provinsi' AS provinsi"),
            DB::raw("properties::jsonb ->> 'volume' AS volume"),
            DB::raw("properties::jsonb ->> 'biaya_perolehan' AS biaya_perolehan"),
            DB::raw("properties::jsonb ->> 'biaya_distribusi' AS biaya_distribusi"),
            DB::raw("properties::jsonb ->> 'biaya_penyimpanan' AS biaya_penyimpanan"),
            DB::raw("properties::jsonb ->> 'margin' AS margin"),
            DB::raw("properties::jsonb ->> 'ppn' AS ppn"),
            DB::raw("properties::jsonb ->> 'pbbkp' AS pbbkp"),
            DB::raw("properties::jsonb ->> 'harga_jual' AS harga_jual"),
            DB::raw("properties::jsonb ->> 'formula_harga' AS formula_harga"),
            DB::raw("properties::jsonb ->> 'keterangan' AS keterangan"),
            'created_at as tanggal'
        )
            ->whereRaw("jsonb_typeof(properties::jsonb) = 'object'")

            // Pastikan npwp, id_permohonan dan bulan tidak kosong/null
            ->whereRaw("
        (properties::jsonb ->> 'npwp') IS NOT NULL AND trim(properties::jsonb ->> 'npwp') != '' AND
        (properties::jsonb ->> 'id_permohonan') IS NOT NULL AND trim(properties::jsonb ->> 'id_permohonan') != '' AND
        (properties::jsonb ->> 'bulan') IS NOT NULL AND trim(properties::jsonb ->> 'bulan') != ''
    ");

        if ($filter === 'bulan' && $value) {
            $query->whereMonth('created_at', '=', $value);
        }

        if ($filter === 'tahun' && $value) {
            $query->whereYear('created_at', '=', $value);
        }


        $logsShow = $query->get();

        return view('logs.show', compact('logsShow'));
    }
}
