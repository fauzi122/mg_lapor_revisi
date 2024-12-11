@extends('layouts.frontand.app')
@section('content')
    {{-- tes --}}
    {{-- @dd($impor) --}}

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18"> Ekspor/Impor</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active"> Ekspor/Impor</li>
                            </ol>
                        </div>
                    </div>
                    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-3"
                        role="alert">
                        <i class="mdi mdi-alert-circle-outline label-icon"></i>
                        <strong>Informasi:</strong> Nomor izin yang anda laporkan adalah <b>{{ $pecah[1] }}</b>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Ekspor</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi(); negara(); pelabuhan(); incoterms();"
                                        data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelexpor">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.ekspor_impor.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Status</th>
                                            <th>Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ekspor as $data)
                                            @php
                                                $id = Crypt::encryptString(
                                                    $data->bulan_peb .
                                                        ',' .
                                                        $data->badan_usaha_id .
                                                        ',' .
                                                        $data->izin_id,
                                                );
                                            @endphp
                                            <tr>
                                              
                                                <td>{{ $loop->iteration }}</td>
                                                <td><b><a
                                                            href="{{ url('/eksport-import/show') }}/{{ $id }}/ekspor">{{ getBulan($data->bulan_peb) }}<i
                                                                class="bx bx-check" title="lihat data laporan"></i></a><b>
                                                </td>
                                                <td><b><a
                                                            href="{{ url('/eksport-import/show') }}/{{ $id }}/ekspor/tahun">{{ getTahun($data->bulan_peb) }}<i
                                                                class="bx bx-check" title="lihat data laporan"></i></a><b>
                                                </td>
                                                <td>
                                                    @if ($data->status_tertinggi == 1 && $data->catatanx)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($data->status_tertinggi == 1)
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($data->status_tertinggi == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($data->status_tertinggi == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <!-- <td>{{ $data->catatan }}</td> -->
                                                @if ($data->status_tertinggi == 1)
                                                    <td>
                                                        <form
                                                            action="{{ url('/hapus_bulan_export') }}/{{ $data->bulan_peb }}"
                                                            method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                           
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))" disabled>
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ url('/submit_bulan_export') }}/{{ $id }}"
                                                            method="post" class="d-inline"
                                                            data-id="{{ $data->bulan_peb }}">
                                                            @method('PUT')
                                                            @csrf
                                                           
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))" disabled>
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form
                                                            action="{{ url('/hapus_bulan_export') }}/{{ $id }}"
                                                            method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ url('/submit_bulan_export') }}/{{ $id }}"
                                                            method="post" class="d-inline"
                                                            data-id="{{ $data->bulan_peb }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                                        <a href="{{ url('/eksport-import/show') }}/{{ $id }}/ekspor"
                                                            class="btn btn-sm btn-info"><i class="bx bx-edit"
                                                                title="Revisi"></i></a>
                                                    </td>
                                                @endif
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Impor</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi(); negara(); pelabuhan(); incoterms();"
                                        data-bs-toggle="modal" data-bs-target="#inputimpor">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelimport">Import Excel</button>
                                    <!-- Include modal content -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($impor as $data)
                                            @php
                                                $id = Crypt::encryptString(
                                                    $data->bulan_pib .
                                                        ',' .
                                                        $data->badan_usaha_id .
                                                        ',' .
                                                        $data->izin_id,
                                                );
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><b><a
                                                            href="{{ url('/eksport-import/show') }}/{{ $id }}/impor">{{ getBulan($data->bulan_pib) }}<i
                                                                class="bx bx-check" title="lihat data laporan"></i></a><b>
                                                </td>
                                                <td><b><a
                                                            href="{{ url('/eksport-import/show') }}/{{ $id }}/impor/tahun">{{ getTahun($data->bulan_pib) }}<i
                                                                class="bx bx-check" title="lihat data laporan"></i></a><b>
                                                </td>
                                                <td>
                                                    @if ($data->status_tertinggi == 1 && $data->catatanx)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($data->status_tertinggi == 1)
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($data->status_tertinggi == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($data->status_tertinggi == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <!-- <td>{{ $data->catatan }}</td> -->
                                                @if ($data->status_tertinggi == 1)
                                                    <td>
                                                        <form
                                                            action="{{ url('/hapus_bulan_import') }}/{{ $id }}"
                                                            method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))" disabled>
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ url('/submit_bulan_import') }}/{{ $id }}"
                                                            method="post" class="d-inline"
                                                            data-id="{{ $data->bulan_pib }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))" disabled>
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form
                                                            action="{{ url('/hapus_bulan_import') }}/{{ $id }}"
                                                            method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ url('/submit_bulan_import') }}/{{ $id }}"
                                                            method="post" class="d-inline"
                                                            data-id="{{ $data->bulan_pib }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                                        <a href="{{ url('/eksport-import/show') }}/{{ $id }}/impor"
                                                            class="btn btn-sm btn-info"><i class="bx bx-edit"
                                                                title="Revisi"></i></a>
                                                    </td>
                                                @endif
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
        </div>
    </div>
@endsection
