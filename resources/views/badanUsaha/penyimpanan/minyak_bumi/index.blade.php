@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Penyimpanan Minyak Bumi</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Penyimpanan Minyak Bumi</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3"></div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        {{-- Table --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-5 mb-xl-8 shadow">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Data Perizinan </span>
                            <span class="text-muted mt-1 fw-semibold fs-7">"{{ Auth::user()->name }}"</span>
                        </h3>
                    </div>
                    <hr>
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dt-responsive w-100" id="tableWithExport">
                                <thead class="table-secondary">
                                    <tr class="fw-bold">
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pm as $data)
                                        @php
                                            $id = Crypt::encryptString(
                                                $data->bulan . ',' . $data->badan_usaha_id . ',' . $data->izin_id,
                                            );
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><b><a
                                                        href="{{ url('/penyimpanan-minyak-bumi/show') }}/{{ $id }}">{{ getBulan($data->bulan) }}<i
                                                            class="bx bx-check" title="lihat data laporan"></i></a><b>
                                            </td>
                                            <td><b><a
                                                        href="{{ url('/penyimpanan-minyak-bumi/show') }}/{{ $id }}/tahun">{{ getTahun($data->bulan) }}<i
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
                                                    <form action="{{ url('/hapus_bulan_pmb') }}/{{ $id }}"
                                                        method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="hapusData($(this).closest('form'))" disabled>
                                                            <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}"
                                                        method="post" class="d-inline" data-id="{{ $data->bulan }}">
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
                                                    <form action="{{ url('/hapus_bulan_pmb') }}/{{ $id }}"
                                                        method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="hapusData($(this).closest('form'))">
                                                            <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}"
                                                        method="post" class="d-inline" data-id="{{ $data->bulan }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="kirimData($(this).closest('form'))">
                                                            <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                        </button></center>
                                                    </form>
                                                    <a href="{{ url('/penyimpanan-minyak-bumi/show') }}/{{ $id }}"
                                                        class="btn btn-sm btn-info"><i class="bx bx-edit"
                                                            title="Revisi"></i></a>
                                                </td>
                                            @endif
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

@endsection