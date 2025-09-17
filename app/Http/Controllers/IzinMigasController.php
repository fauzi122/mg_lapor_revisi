<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SaveIzinMigasJob;
use Illuminate\Support\Facades\Validator;

class IzinMigasController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->npwp);
        $validator = Validator::make($request->all(), [
            'npwp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Parameter NPWP tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $npwp = $request->query('npwp');

        try {
            $result = SaveIzinMigasJob::dispatchSync($npwp);
            dd($result);
            return response()->json([
                'status' => $result['status'],
                'message' => $result['message']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan internal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
