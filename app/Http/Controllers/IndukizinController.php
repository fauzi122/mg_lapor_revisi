<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\induk_izin;
use Illuminate\Support\Carbon;
use App\Traits\MainGraphTrait;

class IndukizinController extends Controller
{
    use MainGraphTrait;

    public function index_evaluator()
    {
        // $meping = induk_izin::get();
        $date   = Carbon::now()->format('Y-m');
        $period = Carbon::now()->format('F Y');
        
        $countMB = $this->getCountMinyakBumi($date);
        $countGAS = $this->getCountGas($date);

        return view('admin.master.dashboard', compact('date', 'period', 'countMB', 'countGAS'));
    }

    public function chartDetail($series, $category, $date){
        //dd($series, $category, $date);

        return view('admin.master.charts.chart_detail');
    }
}
