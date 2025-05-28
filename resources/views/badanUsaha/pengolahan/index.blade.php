@extends('layouts.main.master')
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Laporan Pengolahan Minyak Bumi/Hasil Olahan & Gas Bumi</h3>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Minyak Bumi/Hasil Olahan & Gas Bumi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="ki-duotone ki-information fs-2hx text-info me-4"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Informasi</h4>
                            <span>Nomor izin yang anda laporkan adalah <b>{{ $pecah[1] }}</b></span>
                        </div>
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span class="path2"></span></i>
                        </button>
                    </div>
                </div>

                <!-- Nav tabs -->
                <div class="col-12">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item h3">
                            <a class="nav-link active py-4" data-bs-toggle="tab" href=".minyak-bumi" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-oil-can"></i> Minyak Bumi</span>
                                <span class="d-none d-sm-block"><i class="fas fa-oil-can"></i> Minyak Bumi/Hasil Olahan</span>
                            </a>
                        </li>
                        <li class="nav-item h3">
                            <a class="nav-link py-4" data-bs-toggle="tab" href=".gas-bumi" role="tab" aria-selected="false" tabindex="-1">
                                <span class="d-block d-sm-none"><i class="fas fa-gas-pump"></i> Gas Bumi</span>
                                <span class="d-none d-sm-block"><i class="fas fa-gas-pump"></i> Gas Bumi</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active show minyak-bumi" role="tabpanel">
                        @include('badanUsaha.pengolahan.minyak_bumi.modal')
                        <div class="row">
                            <!-- Pengolahan Minyak Bumi Produksi Kilang -->
                            <div class="col-12">
                                <div class="card mb-5 mb-xl-8 shadow">
                                    <div class="card-header bg-light p-5">
                                        <div class="row w-100">
                                            <div class="col-lg-6">
                                                <h5>Produksi Kilang [Minyak Bumi/Hasil Olahan]</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#buat-pengolahan-produksi-mb">
                                                        <i class="fas fa-plus"></i> Buat Laporan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#excelPengolahanMBProduksi">
                                                        <i class="fas fa-upload"></i> Import Excel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="card">
                                            <div class="card-header align-items-center px-2">
                                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                                    <input type="hidden" class="export-title" value="Laporan Produksi Kilang [Minyak Bumi/Hasil Olahan]" />
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <table class="kt-datatable table table-bordered table-hover">
                                                    <thead class="bg-light align-top" style="white-space: nowrap;">
                                                        <tr class="fw-bold">
                                                            <th class="text-center">No</th>
                                                            <th>Bulan</th>
                                                            <th>Tahun</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengolahanProduksiMB as $ppmb)
                                                            @php
                                                                $id = Crypt::encryptString($ppmb->bulan . ',' . $ppmb->badan_usaha_id . ',' . $ppmb->izin_id);
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/produksi">
                                                                        {{ getBulan($ppmb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/produksi/tahun">
                                                                        {{ getTahun($ppmb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if ($ppmb->status_tertinggi == 1 && $ppmb->catatanx)
                                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                                    @elseif ($ppmb->status_tertinggi == 1)
                                                                        <span class="badge badge-success">Diterima</span>
                                                                    @elseif ($ppmb->status_tertinggi == 2)
                                                                        <span class="badge badge-danger">Revisi</span>
                                                                    @elseif ($ppmb->status_tertinggi == 0)
                                                                        <span class="badge badge-info">Draf</span>
                                                                    @elseif($ppmb->status == 3)
                                                                        <span class="badge badge-primary">Selesai</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ url('/hapus_bulan_pengolahan_minyak_bumi_produksi') }}/{{ $id }}" method="post" class="d-inline">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))"
                                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ url('/submit_bulan_pengolahan_minyak_bumi_produksi') }}/{{ $id }}" method="post" class="d-inline" data-id="{{ $ppmb->bulan }}">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-success mb-2" onclick="kirimData($(this).closest('form'))"
                                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                        </button>
                                                                    </form>
                                                                    @if ($ppmb->status_tertinggi != 1)
                                                                        <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/produksi" class="btn btn-icon btn-sm btn-info mb-2">
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
                            <!-- Pengolahan Minyak Bumi Pasokan Kilang -->
                            <div class="col-12 mt-n2">
                                <div class="card mb-5 mb-xl-8 shadow">
                                    <div class="card-header bg-light p-5">
                                        <div class="row w-100">
                                            <div class="col-lg-6">
                                                <h5>Pasokan Kilang [Minyak Bumi/Hasil Olahan]</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="intake_kilang(); provinsi();" data-bs-toggle="modal" data-bs-target="#buat-pengolahan-pasokan-mb">
                                                        <i class="fas fa-plus"></i> Buat Laporan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#excelPengolahanMBPasokan">
                                                        <i class="fas fa-upload"></i> Import Excel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="card">
                                            <div class="card-header align-items-center px-2">
                                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                                    <input type="hidden" class="export-title" value="Laporan Pasokan Kilang [Minyak Bumi/Hasil Olahan]" />
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <table class="kt-datatable table table-bordered table-hover">
                                                    <thead class="bg-light align-top" style="white-space: nowrap;">
                                                        <tr class="fw-bold">
                                                            <th class="text-center">No</th>
                                                            <th>Bulan</th>
                                                            <th>Tahun</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengolahanPasokanMB as $ppmb)
                                                            @php
                                                                $id = Crypt::encryptString($ppmb->bulan . ',' . $ppmb->badan_usaha_id . ',' . $ppmb->izin_id);
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/pasokan">
                                                                        {{ getBulan($ppmb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/pasokan/tahun">
                                                                        {{ getTahun($ppmb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if ($ppmb->status_tertinggi == 1 && $ppmb->catatanx)
                                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                                    @elseif ($ppmb->status_tertinggi == 1)
                                                                        <span class="badge badge-success">Diterima</span>
                                                                    @elseif ($ppmb->status_tertinggi == 2)
                                                                        <span class="badge badge-danger">Revisi</span>
                                                                    @elseif ($ppmb->status_tertinggi == 0)
                                                                        <span class="badge badge-info">Draf</span>
                                                                    @elseif($ppmb->status == 3)
                                                                        <span class="badge badge-primary">Selesai</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ url('/hapus_bulan_pengolahan_minyak_bumi_pasokan') }}/{{ $id }}" method="post" class="d-inline">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))"
                                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ url('/submit_bulan_pengolahan_minyak_bumi_pasokan') }}/{{ $id }}" method="post" class="d-inline" data-id="{{ $ppmb->bulan }}">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-success mb-2" onclick="kirimData($(this).closest('form'))"
                                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                        </button>
                                                                    </form>
                                                                    @if ($ppmb->status_tertinggi != 1)
                                                                        <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/pasokan" class="btn btn-icon btn-sm btn-info mb-2">
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
                            <!-- Pengolahan Minyak Bumi Distribusi Kilang -->
                            <div class="col-12 mt-n2">
                                <div class="card mb-5 mb-xl-8 shadow">
                                    <div class="card-header bg-light p-5">
                                        <div class="row w-100">
                                            <div class="col-lg-6">
                                                <h5>Distribusi/Penjualan Domestik Kilang [Minyak Bumi/Hasil Olahan]</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi(); sektor();" data-bs-toggle="modal" data-bs-target="#buat-pengolahan-distribusi-mb">
                                                        <i class="fas fa-plus"></i> Buat Laporan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#excelPengolahanMBDistribusi">
                                                        <i class="fas fa-upload"></i> Import Excel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="card">
                                            <div class="card-header align-items-center px-2">
                                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                                    <input type="hidden" class="export-title" value="Laporan Distribusi/Penjualan Domestik Kilang [Minyak Bumi/Hasil Olahan]" />
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <table class="kt-datatable table table-bordered table-hover">
                                                    <thead class="bg-light align-top" style="white-space: nowrap;">
                                                        <tr class="fw-bold">
                                                            <th class="text-center">No</th>
                                                            <th>Bulan</th>
                                                            <th>Tahun</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengolahanDistribusiMB as $ppmb)
                                                            @php
                                                                $id = Crypt::encryptString($ppmb->bulan . ',' . $ppmb->badan_usaha_id . ',' . $ppmb->izin_id);
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/distribusi">
                                                                        {{ getBulan($ppmb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/distribusi/tahun">
                                                                        {{ getTahun($ppmb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if ($ppmb->status_tertinggi == 1 && $ppmb->catatanx)
                                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                                    @elseif ($ppmb->status_tertinggi == 1)
                                                                        <span class="badge badge-success">Diterima</span>
                                                                    @elseif ($ppmb->status_tertinggi == 2)
                                                                        <span class="badge badge-danger">Revisi</span>
                                                                    @elseif ($ppmb->status_tertinggi == 0)
                                                                        <span class="badge badge-info">Draf</span>
                                                                    @elseif($ppmb->status == 3)
                                                                        <span class="badge badge-primary">Selesai</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ url('/hapus_bulan_pengolahan_minyak_bumi_distribusi') }}/{{ $id }}" method="post" class="d-inline">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))"
                                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ url('/submit_bulan_pengolahan_minyak_bumi_distribusi') }}/{{ $id }}" method="post" class="d-inline" data-id="{{ $ppmb->bulan }}">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-success mb-2" onclick="kirimData($(this).closest('form'))"
                                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                        </button>
                                                                    </form>
                                                                    @if ($ppmb->status_tertinggi != 1)
                                                                        <a href="{{ url('/pengolahan-minyak-bumi-hasil-olah/show') }}/{{ $id }}/distribusi" class="btn btn-icon btn-sm btn-info mb-2">
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
                    <div class="tab-pane gas-bumi" role="tabpanel">
                        @include('badanUsaha.pengolahan.gas_bumi.modal')
                        <div class="row">
                            <!-- Pengolahan Gas Bumi Produksi Kilang -->
                            <div class="col-12">
                                <div class="card mb-5 mb-xl-8 shadow">
                                    <div class="card-header bg-light p-5">
                                        <div class="row w-100">
                                            <div class="col-lg-6">
                                                <h5>Produksi Kilang [Gas Bumi]</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#buat-pengolahan-produksi-gb">
                                                        <i class="fas fa-plus"></i> Buat Laporan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#excelPengolahanGBProduksi">
                                                        <i class="fas fa-upload"></i> Import Excel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="card">
                                            <div class="card-header align-items-center px-2">
                                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                                    <input type="hidden" class="export-title" value="Laporan Produksi Kilang [Gas Bumi]" />
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <table class="kt-datatable table table-bordered table-hover">
                                                    <thead class="bg-light align-top" style="white-space: nowrap;">
                                                        <tr class="fw-bold">
                                                            <th class="text-center">No</th>
                                                            <th>Bulan</th>
                                                            <th>Tahun</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengolahanProduksiGB as $ppgb)
                                                            @php
                                                                $id = Crypt::encryptString($ppgb->bulan . ',' . $ppgb->badan_usaha_id . ',' . $ppgb->izin_id);
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/produksi">
                                                                        {{ getBulan($ppgb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/produksi/tahun">
                                                                        {{ getTahun($ppgb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if ($ppgb->status_tertinggi == 1 && $ppgb->catatanx)
                                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                                    @elseif ($ppgb->status_tertinggi == 1)
                                                                        <span class="badge badge-success">Diterima</span>
                                                                    @elseif ($ppgb->status_tertinggi == 2)
                                                                        <span class="badge badge-danger">Revisi</span>
                                                                    @elseif ($ppgb->status_tertinggi == 0)
                                                                        <span class="badge badge-info">Draf</span>
                                                                    @elseif($ppgb->status == 3)
                                                                        <span class="badge badge-primary">Selesai</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ url('/hapus_bulan_pengolahan_gas_bumi_produksi') }}/{{ $id }}" method="post" class="d-inline">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))"
                                                                            {{ $ppgb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ url('/submit_bulan_pengolahan_gas_bumi_produksi') }}/{{ $id }}" method="post" class="d-inline" data-id="{{ $ppgb->bulan }}">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-success mb-2" onclick="kirimData($(this).closest('form'))"
                                                                            {{ $ppgb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                        </button>
                                                                    </form>
                                                                    @if ($ppgb->status_tertinggi != 1)
                                                                        <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/produksi" class="btn btn-icon btn-sm btn-info mb-2">
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
                            <!-- Pengolahan Gas Bumi Pasokan Kilang -->
                            <div class="col-12 mt-n2">
                                <div class="card mb-5 mb-xl-8 shadow">
                                    <div class="card-header bg-light p-5">
                                        <div class="row w-100">
                                            <div class="col-lg-6">
                                                <h5>Pasokan Kilang [Gas Bumi]</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="intake_kilang(); provinsi();" data-bs-toggle="modal" data-bs-target="#buat-pengolahan-pasokan-gb">
                                                        <i class="fas fa-plus"></i> Buat Laporan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#excelPengolahanGBPasokan">
                                                        <i class="fas fa-upload"></i> Import Excel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="card">
                                            <div class="card-header align-items-center px-2">
                                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                                    <input type="hidden" class="export-title" value="Laporan Pasokan Kilang [Gas Bumi]" />
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <table class="kt-datatable table table-bordered table-hover">
                                                    <thead class="bg-light align-top" style="white-space: nowrap;">
                                                        <tr class="fw-bold">
                                                            <th class="text-center">No</th>
                                                            <th>Bulan</th>
                                                            <th>Tahun</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengolahanPasokanGB as $ppgb)
                                                            @php
                                                                $id = Crypt::encryptString($ppgb->bulan . ',' . $ppgb->badan_usaha_id . ',' . $ppgb->izin_id);
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/pasokan">
                                                                        {{ getBulan($ppgb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/pasokan/tahun">
                                                                        {{ getTahun($ppgb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if ($ppgb->status_tertinggi == 1 && $ppgb->catatanx)
                                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                                    @elseif ($ppgb->status_tertinggi == 1)
                                                                        <span class="badge badge-success">Diterima</span>
                                                                    @elseif ($ppgb->status_tertinggi == 2)
                                                                        <span class="badge badge-danger">Revisi</span>
                                                                    @elseif ($ppgb->status_tertinggi == 0)
                                                                        <span class="badge badge-info">Draf</span>
                                                                    @elseif($ppgb->status == 3)
                                                                        <span class="badge badge-primary">Selesai</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ url('/hapus_bulan_pengolahan_gas_bumi_pasokan') }}/{{ $id }}" method="post" class="d-inline">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))"
                                                                            {{ $ppgb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ url('/submit_bulan_pengolahan_gas_bumi_pasokan') }}/{{ $id }}" method="post" class="d-inline" data-id="{{ $ppgb->bulan }}">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-success mb-2" onclick="kirimData($(this).closest('form'))"
                                                                            {{ $ppgb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                        </button>
                                                                    </form>
                                                                    @if ($ppgb->status_tertinggi != 1)
                                                                        <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/pasokan" class="btn btn-icon btn-sm btn-info mb-2">
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
                            <!-- Pengolahan Gas Bumi Distribusi Kilang -->
                            <div class="col-12 mt-n2">
                                <div class="card mb-5 mb-xl-8 shadow">
                                    <div class="card-header bg-light p-5">
                                        <div class="row w-100">
                                            <div class="col-lg-6">
                                                <h5>Distribusi/Penjualan Domestik Kilang [Gas Bumi]</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi(); sektor();" data-bs-toggle="modal" data-bs-target="#buat-pengolahan-distribusi-gb">
                                                        <i class="fas fa-plus"></i> Buat Laporan
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#excelPengolahanGBDistribusi">
                                                        <i class="fas fa-upload"></i> Import Excel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="card">
                                            <div class="card-header align-items-center px-2">
                                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                                    <input type="hidden" class="export-title" value="Laporan Distribusi/Penjualan Domestik Kilang [Gas Bumi]" />
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <table class="kt-datatable table table-bordered table-hover">
                                                    <thead class="bg-light align-top" style="white-space: nowrap;">
                                                        <tr class="fw-bold">
                                                            <th class="text-center">No</th>
                                                            <th>Bulan</th>
                                                            <th>Tahun</th>
                                                            <th>Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengolahanDistribusiGB as $ppgb)
                                                            @php
                                                                $id = Crypt::encryptString($ppgb->bulan . ',' . $ppgb->badan_usaha_id . ',' . $ppgb->izin_id);
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/distribusi">
                                                                        {{ getBulan($ppgb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/distribusi/tahun">
                                                                        {{ getTahun($ppgb->bulan) }}
                                                                        <i class="ki-solid ki-check" title="lihat data laporan"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if ($ppgb->status_tertinggi == 1 && $ppgb->catatanx)
                                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                                    @elseif ($ppgb->status_tertinggi == 1)
                                                                        <span class="badge badge-success">Diterima</span>
                                                                    @elseif ($ppgb->status_tertinggi == 2)
                                                                        <span class="badge badge-danger">Revisi</span>
                                                                    @elseif ($ppgb->status_tertinggi == 0)
                                                                        <span class="badge badge-info">Draf</span>
                                                                    @elseif($ppgb->status == 3)
                                                                        <span class="badge badge-primary">Selesai</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ url('/hapus_bulan_pengolahan_gas_bumi_distribusi') }}/{{ $id }}" method="post" class="d-inline">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))"
                                                                            {{ $ppgb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ url('/submit_bulan_pengolahan_gas_bumi_distribusi') }}/{{ $id }}" method="post" class="d-inline" data-id="{{ $ppgb->bulan }}">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-icon btn-sm btn-success mb-2" onclick="kirimData($(this).closest('form'))"
                                                                            {{ $ppgb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                                            <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                        </button>
                                                                    </form>
                                                                    @if ($ppgb->status_tertinggi != 1)
                                                                        <a href="{{ url('/pengolahan-gas-bumi/show') }}/{{ $id }}/distribusi" class="btn btn-icon btn-sm btn-info mb-2">
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
            </div>
        </div>
    </div>
@endsection
