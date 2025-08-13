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
            'id',
            'action',
            'bu_id',
            'bu_name',
            'method',
            'url',
            'ip_address',
            'description',
            'created_at as tanggal',
            'old_properties',
            'properties'
        );

        if ($filter === 'bulan' && $value) {
            $query->whereMonth('created_at', '=', $value);
        }

        if ($filter === 'tahun' && $value) {
            $query->whereYear('created_at', '=', $value);
        }


        $logsShow = $query->get();

        return view('logs.show', compact('logsShow'));
    }

    public function properties($id)
    {
        $log = Logs::select('properties')->where('id', $id)->first();

        if (!$log) {
            abort(404, 'Data tidak ditemukan');
        }

        // Decode JSON
        $properties = json_decode($log->properties, true);

        // Kalau decode-nya gagal atau null, buat jadi array kosong
        if (!is_array($properties)) {
            $properties = [];
        }

        // Ganti null jadi string kosong, tapi hanya kalau ada isi
        $properties = array_map(fn($v) => $v ?? '', $properties);

        return view('logs.properties', compact('properties'));
    }

    public function properties_old($id)
    {
        $log = Logs::select('old_properties')->where('id', $id)->first();

        if (!$log) {
            abort(404, 'Data tidak ditemukan');
        }

        // Decode JSON
        $properties = json_decode($log->old_properties, true);

        // Kalau decode-nya gagal atau null, buat jadi array kosong
        if (!is_array($properties)) {
            $properties = [];
        }

        // Ganti null jadi string kosong, tapi hanya kalau ada isi
        $properties = array_map(fn($v) => $v ?? '', $properties);

        return view('logs.old_properties', compact('properties'));
    }
}
