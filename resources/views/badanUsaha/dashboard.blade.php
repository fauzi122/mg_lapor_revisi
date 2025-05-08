@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Dashboard</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Dashboards</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3"></div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        {{-- Card Total Izin --}}
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-xxl-8">
                <div class="row g-5 g-xl-10">
                    @php
                        $cards = [
                            [
                                'bg' => 'bg-primary', 
                                'title' => 'Jumlah Izin Niaga', 
                                'value' => Session::get('j_niaga')],
                            [
                                'bg' => 'bg-success',
                                'title' => 'Jumlah Izin Pengolahan',
                                'value' => Session::get('j_pengolahan'),
                            ],
                            [
                                'bg' => 'bg-info',
                                'title' => 'Jumlah Izin Penyimpanan',
                                'value' => Session::get('j_penyimpanan'),
                            ],
                            [
                                'bg' => 'bg-danger',
                                'title' => 'Jumlah Izin Pengangkutan',
                                'value' => Session::get('j_pengangkutan'),
                            ],
                        ];
                    @endphp
                    @foreach ($cards as $card)
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100 {{ $card['bg'] }}">
                                <div class="card-header flex-nowrap">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="fw-semibold fs-5 text-white">{{ $card['title'] }}</span>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5">
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-white">{{ $card['value'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Table --}}
    </div>
</div>

@endsection