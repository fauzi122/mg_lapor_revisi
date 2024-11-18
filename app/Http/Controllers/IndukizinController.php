<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\induk_izin;
use App\Traits\DetailGraphTrait;
use Illuminate\Support\Carbon;
use App\Traits\MainGraphTrait;

class IndukizinController extends Controller
{
    use MainGraphTrait, DetailGraphTrait;

    public function index_evaluator(Request $request)
    {
        //dd($request->all());
        // $meping = induk_izin::get();
        $period = $request->period;

        if ($period == '') {
            $date   = Carbon::now()->format('Y-m');
        }
        else{
            $date = $period;
        }

        $period = Carbon::createFromFormat('Y-m', $date)->format('F Y');
        
        $countMB = $this->getCountMinyakBumi($date);
        $countGAS = $this->getCountGas($date);

        return view('admin.master.dashboard', compact('date', 'period', 'countMB', 'countGAS'));
    }

    public function chartDetail($series, $category, $date){
        $period = Carbon::createFromFormat('Y-m', $date)->format('F Y');
        
        if($series == 'Minyak Bumi'){
            if($category == 'Niaga'){
                $result     = $this->getDetailNiagaMB($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            elseif($category == 'Pengolahan'){
                $result     = $this->getDetailPengolahanMB($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            elseif($category == 'Pengangkutan'){
                $result     = $this->getDetailPengangkutanMB($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            elseif($category == 'Penyimpanan'){
                $result     = $this->getDetailPenyimpananMB($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            else{
                $result     = [];
                $categories = [];
                $data       = [];
            }
        }
        elseif($series == 'Gas'){
            if($category == 'Niaga'){
                $result     = $this->getDetailNiagaGas($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            elseif($category == 'Pengolahan'){
                $result     = $this->getDetailPengolahanGas($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            elseif($category == 'Pengangkutan'){
                $result     = $this->getDetailPengangkutanGas($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            elseif($category == 'Penyimpanan'){
                $result     = $this->getDetailPenyimpananGas($date);
                $categories = $result['categories'];
                $data       = $result['data'];
            }
            else{
                $result     = [];
                $categories = [];
                $data       = [];
            }
        }
        
        //dd($series, $category, $date, $period, $categories, $data);
        return view('admin.master.charts.chart_detail',compact('series', 'category', 'date', 'period', 'categories', 'data'));
    }
}
