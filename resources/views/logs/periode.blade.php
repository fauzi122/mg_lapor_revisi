@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Logs Periode</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Logs</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Logs Periode</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@if ($logsPeriode)
<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card-body mt-4">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url('/logs') }}"
                                    class="btn btn-danger waves-effect waves-light">
                                    <i class='bi bi-arrow-left'></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Logs Periode" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th style="text-align: center; vertical-align: middle;">No</th>
                                    <th style="text-align: center; vertical-align: middle;">Bulan</th>
                                    <th style="text-align: center; vertical-align: middle;">Tahun</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($logsPeriode as $periode)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><b><a href="{{ url('/logs/show/bulan/' . getBulan($periode->created_at)) }}">
                                                {{ getBulan($periode->created_at) }}
                                                <i class="bi bi-check" title="Lihat laporan per bulan"></i>
                                            </a></b></td>
                                    <td><b><a href="{{ url('/logs/show/tahun/' . getTahun($periode->created_at)) }}">
                                                {{ getTahun($periode->created_at) }}
                                                <i class="bi bi-check" title="Lihat laporan per tahun"></i>
                                            </a></b></td>
                                </tr>
                                    
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
