@extends('layouts.main.master')
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Dashboard</h3>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
        <div id="kt_app_content_container" class="app-container container-xxl">
            {{-- Card Total Izin --}}
            <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="ki-duotone ki-information fs-2hx text-info me-4"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Informasi</h4>
                          <span>Status NPWP atas nama {{ Auth::user()->name }}: 
                <b>
                        {{ substr(Auth::user()->npwp, 0, 2) . '.' .
                        substr(Auth::user()->npwp, 2, 3) . '.' .
                        substr(Auth::user()->npwp, 5, 3) . '.' .
                        substr(Auth::user()->npwp, 8, 1) . '-' .
                        substr(Auth::user()->npwp, 9, 3) . '.' .
                        substr(Auth::user()->npwp, 12, 3) }}
                        {{ $firstStatusDjp }}
                    </b>
                </span>
                </div>
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </button>
                    </div>
                </div>
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                @php
                    $cards = [
                        [
                            'bg' => 'bg-primary',
                            'title' => 'Jumlah Izin Niaga',
                            'value' => Session::get('j_niaga'),
                        ],
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
                    <div class="col-lg-3">
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

            {{-- Table --}}
            <div class="row">
                <div class="col-12">
                    <div class="card mb-5 mb-xl-8 shadow">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Data Perizinan</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">"{{ Auth::user()->name }}"</span>
                            </h3>
                        </div>

                        {{-- Start --}}
                        <div class="card-body p-3">
                            <div class="card">
                                <div class="card-header align-items-center px-2">
                                    <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                    <div class="card-title flex-row-fluid justify-content-end gap-5">
                                        <input type="hidden" class="export-title" value="Data Perizinan" />
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    @include('badanUsaha.table_dashboard')
                                </div>
                            </div>
                        </div>
                        {{-- Finish --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
