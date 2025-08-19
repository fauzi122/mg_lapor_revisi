<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsEvaluatorController extends Controller
{
    public function index()
    {
      $logs = Logs::select(
                'logs.bu_name',
                'logs.bu_id',
                'users.name as user_name',
                DB::raw('COUNT(*) as total')
            )
            ->join('users', 'logs.bu_id', '=', 'users.id')
            ->groupBy('logs.bu_name', 'logs.bu_id', 'users.name')
            ->where('users.role','ADM')
            ->get();

        return view('logs_evaluator.index', compact('logs'));

    }

    public function periode($bu_id)
    {
        $logsPeriode = Logs::selectRaw("MAX(created_at) as created_at")
            ->where('bu_id', $bu_id)
            ->groupByRaw("DATE_TRUNC('month', created_at)")
            ->orderByRaw("MAX(created_at) DESC")
            ->get();

        return view('logs_evaluator.periode', compact('logsPeriode', 'bu_id'));
    }


    public function show($bu_id, Request $request, $filter = null, $value = null)
    {
        $query = Logs::select(
            'id',
            'action',
            'bu_id',
            'bu_name',
            'method',
            'url',
            'ip_address',
            'description',
            'created_at as tanggal'
        );

        // filter per bu_id
        if ($bu_id) {
            $query->where('bu_id', $bu_id);
        }

        // filter per bulan/tahun
        if ($filter === 'bulan' && $value) {
            $query->whereMonth('created_at', $value);
        }

        if ($filter === 'tahun' && $value) {
            $query->whereYear('created_at', $value);
        }

        $logsShow = $query->get();

        return view('logs_evaluator.show', compact('logsShow'));
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

        return view('logs_evaluator.properties', compact('properties'));
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

        return view('logs_evaluator.old_properties', compact('properties'));
    }
}
