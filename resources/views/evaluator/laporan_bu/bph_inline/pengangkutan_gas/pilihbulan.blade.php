@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">{{ $title }}</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Niaga BBM</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/laporan/pengangkutan-gas') }}" class="text-muted text-hover-primary">Laporan Pengangkutan Gas</a></li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $per->nama_badan_usaha }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card-body p-3">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">{{ $per->nama_badan_usaha }}</h4>
                                
                                <a href="{{ url('laporan/pengangkutan-gas/periode') . '/' . \Illuminate\Support\Facades\Crypt::encryptString($per->npwp_badan_usaha) }}" class="btn btn-danger btn-sm btn-rounded">
                                    <i class='bi bi-arrow-left'></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($query)
                    <div class="card-body p-2">
                        <div class="card">
                            <div class="card-header align-items-center px-2">
                                <div class="card-toolbar"></div> 
                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                    <input type="hidden" class="export-title" value="Laporan Pasokan Gas Bumi {{ bulan($per->bulan) }}" />
                                </div>
                            </div>
                            <table class="kt-datatable table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr class="fw-bold text-uppercase">
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Ruas Angkut</th>
                                        <th>Diameter</th>
                                        <th>Shipper</th>
                                        <th>Tarif MSCF</th>
                                        <th>Volume MSCF</th>
                                        <th>Satuan MSCF</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach ($query as $pg)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ bulan($pg->bulan) }}</td>
                                            <td>{{ $pg->tahun }}</td>
                                            <td>{{ $pg->ruas_angkut }}</td>
                                            <td>{{ $pg->diameter }}</td>
                                            <td>{{ $pg->shipper }}</td>
                                            <td>{{ $pg->tarif_mscf }}</td>
                                            <td>{{ $pg->volume_mscf }}</td>
                                            <td>{{ $pg->satuan_mscf }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

    {{-- <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                            <h4>{{ $per->nama_badan_usaha }}</h4>

                        </div>

                    </div>
                </div>
            </div>

            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Periode Bulan {{ bulan($per->bulan) }}</h4>

                                    <div>
                                        <a href="{{ url('laporan/pengangkutan-gas/periode') . '/' . \Illuminate\Support\Facades\Crypt::encryptString($per->npwp_badan_usaha) }}"
                                            class="btn btn-danger btn-sm btn-rounded"><i class='bx bx-arrow-back'></i>
                                            Kembali</a>
                                    </div>


                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Ruas Angkut</th>
                                                <th>Diameter</th>
                                                <th>Shipper</th>
                                                <th>Tarif MSCF</th>
                                                <th>Volume MSCF</th>
                                                <th>Satuan MSCF</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $pg)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ bulan($pg->bulan) }}</td>
                                                    <td>{{ $pg->tahun }}</td>
                                                    <td>{{ $pg->ruas_angkut }}</td>
                                                    <td>{{ $pg->diameter }}</td>
                                                    <td>{{ $pg->shipper }}</td>
                                                    <td>{{ $pg->tarif_mscf }}</td>
                                                    <td>{{ $pg->volume_mscf }}</td>
                                                    <td>{{ $pg->satuan_mscf }}</td>
                                                </tr>
                                            @endforeach
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div> --}}

@endsection
