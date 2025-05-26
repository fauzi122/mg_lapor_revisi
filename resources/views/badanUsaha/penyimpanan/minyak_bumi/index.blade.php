@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Penyimpanan Minyak Bumi</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Penyimpanan Minyak Bumi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@include('badanUsaha.penyimpanan.minyak_bumi.modal')

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="ki-duotone ki-information fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">Informasi</h4>
                        <span>Nomor izin yang anda laporkan adalah <b>{{ $pecah[1] }}</b></span>
                    </div>
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>                
            </div>
            <div class="col-12">
                <div class="card mb-5 mb-xl-8 shadow">
                    <div class="card-header bg-light p-5">
                        <div class="row w-100">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi(); kab_kota();" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <i class="fas fa-plus"></i> Buat Laporan
                                    </a>
                                    <a type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#excelpmb">
                                        <i class="fas fa-upload"></i> Import Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="card">
                            <div class="card-header align-items-center px-2">
                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                    <input type="hidden" class="export-title" value="Laporan Penyimpanan Minyak Bumi" />
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <table class="kt-datatable table table-bordered table-hover">
                                    <thead class="bg-light">
                                        <tr class="fw-bold text-uppercase">
                                            <th class="text-center">No</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($pm as $data)
                                            @php
                                                $id = Crypt::encryptString($data->bulan . ',' . $data->badan_usaha_id . ',' . $data->izin_id);
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ url('/penyimpanan-minyak-bumi/show') }}/{{ $id }}">
                                                        {{ getBulan($data->bulan) }}
                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/penyimpanan-minyak-bumi/show') }}/{{ $id }}/tahun">
                                                        {{ getTahun($data->bulan) }}
                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($data->status_tertinggi == 1 && $data->catatanx)
                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                    @elseif ($data->status_tertinggi == 1)
                                                        <span class="badge badge-success">Diterima</span>
                                                    @elseif ($data->status_tertinggi == 2)
                                                        <span class="badge badge-danger">Revisi</span>
                                                    @elseif ($data->status_tertinggi == 0)
                                                        <span class="badge badge-info">Draf</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($data->status_tertinggi == 1)
                                                        <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" disabled>
                                                            <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-icon btn-sm btn-success mb-2" disabled>
                                                            <i class="ki-solid ki-send" title="Kirim data"></i>
                                                        </button>
                                                    @else
                                                        <form action="{{ url('/hapus_bulan_pmb') }}/{{ $id }}" method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))">
                                                                <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}" method="post" class="d-inline" data-id="{{ $data->bulan }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-icon btn-sm btn-success mb-2" onclick="kirimData($(this).closest('form'))">
                                                                <i class="ki-solid ki-send" title="Revisi"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ url('/penyimpanan-minyak-bumi/show') }}/{{ $id }}" class="btn btn-icon btn-sm btn-info mb-2">
                                                            <i class="ki-solid ki-pencil" title="Detail / Edit Data"></i>
                                                        </a>
                                                    @endif
                                                </td>
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
    </div>
</div>

@endsection