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
                            <a href="{{ url('/laporan/penjualan-jbkp') }}" class="text-muted text-hover-primary">Penjualan
                                JBT</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                <i class="mdi mdi-alert-circle-outline label-icon"></i>
                <strong>Informasi:</strong> Data yang ditampilkan di halaman ini adalah data untuk bulan berjalan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="card-body mt-4">
                <div class="card mb-5 mb-xl-8 shadow">
                    <div class="card-header bg-light p-5">
                        <div class="row w-100">
                            <div class="col-12">
                                <div class="d-flex justify-content-start">
                                    <h4>Periode {{ $periode }}</h4>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ url('/laporan/penjualan-jbt') }}"
                                        class="btn btn-danger waves-effect waves-light">
                                        <i class='bi bi-arrow-left'></i> Kembali
                                    </a>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_filter">
                                        <i class='bi bi-funnel'></i> Filter
                                    </button>


                                    <div class="modal fade" id="kt_modal_filter" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content rounded">
                                                <!--begin::Modal header-->
                                                <div class="modal-header" id="kt_modal_filter_header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Filter</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div id="kt_modal_filter_close"
                                                        class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-bs-dismiss="modal">
                                                        <i class="ki-outline ki-cross fs-1"></i>
                                                    </div>
                                                    <!--end::Close-->
                                                </div>

                                                <form action="{{ url('laporan/penjualan-jbt-lihat-semua-data') }}"
                                                    method="GET">
                                                    @csrf
                                                    <div class="modal-body py-10 px-lg-17">
                                                        <!--begin::Scroll-->
                                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_target_scroll"
                                                            data-kt-scroll="true"
                                                            data-kt-scroll-activate="{default: false, lg: true}"
                                                            data-kt-scroll-max-height="auto"
                                                            data-kt-scroll-dependencies="#kt_modal_new_target_header"
                                                            data-kt-scroll-wrappers="#kt_modal_new_target_scroll"
                                                            data-kt-scroll-offset="300px">

                                                            <div class="fv-row mb-7">
                                                                <label for="example-text-input"
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama
                                                                    Perusahaan</label>
                                                                <select class="form-control select20 mb-2"
                                                                    style="width: 100%;" name="perusahaan" required>
                                                                    <option value="all" selected>--Pilih Perusahaan--
                                                                    </option>
                                                                    <option value="all">Semua Perusahaan</option>
                                                                    @foreach ($perusahaan as $p)
                                                                        <option value="{{ $p->id_badan_usaha }}">
                                                                            {{ $p->nama_badan_usaha }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="fv-row mb-7">
                                                                <label for="example-text-input"
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Tanggal Awal</span>
                                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                                        title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                                                        <i class="ki-outline ki-information fs-7"></i>
                                                                    </span>
                                                                </label>
                                                                <input class="form-control flatpickr" name="t_awal"
                                                                    type="month" required>
                                                            </div>
                                                            <div class="fv-row mb-7">
                                                                <label for="example-text-input"
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Tanggal Akhir</span>
                                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                                        title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                                                        <i class="ki-outline ki-information fs-7"></i>
                                                                    </span>
                                                                </label>
                                                                <input class="form-control flatpickr" name="t_akhir"
                                                                    type="month" required>
                                                            </div>
                                                            <div class="modal-footer flex-center">
                                                                <button type="submit" data-bs-dismiss="modal"
                                                                    class="btn btn-primary">Proses</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="card">
                            <div class="card-header align-items-center px-2">
                                <div class="card-toolbar ms-auto">
                                    <form method="GET" action="{{ url('laporan/penjualan-jbt-lihat-semua-data') }}" class="d-flex" role="search">
                                        <input type="hidden" name="t_awal" value="{{ request('t_awal') }}">
                                        <input type="hidden" name="t_akhir" value="{{ request('t_akhir') }}">
                                        <input type="hidden" name="perusahaan" value="{{ request('perusahaan', 'all') }}">
                                        
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control form-control-sm me-2"
                                            placeholder="Cari...">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <thead class="bg-light">
                                        <tr class="fw-bold text-uppercase text-center">
                                            <th style="width: 70px;">No</th>
                                            <th>Nama Badan Usaha</th>
                                            <th>NPWP Badan Usaha</th>
                                            <th>Izin Usaha</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($query as $pgb)
                                            <tr>
                                                <td class="text-center">{{ ($query->currentPage() - 1) * $query->perPage() + $loop->iteration }}</td>
                                                <td>{{ $pgb->nama_badan_usaha }}</td>
                                                <td>{{ $pgb->npwp_badan_usaha }}</td>
                                                <td class="text-start">
                                                    @php $izinList = json_decode($pgb->izin_usaha, true); @endphp
                                                    @if (is_array($izinList))
                                                        <ul class="mb-0 ps-3">
                                                            @foreach ($izinList as $izin)
                                                                <li>ID: {{ $izin['id_izin_usaha'] ?? '-' }} -
                                                                    Nomor: {{ $izin['nomor_izin_usaha'] ?? '-' }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">Tidak ada data</span>
                                                    @endif
                                                </td>
                                                <td>{{ bulan($pgb->bulan) }}</td>
                                                <td>{{ $pgb->tahun }}</td>
                                                <td>{{ $pgb->produk }}</td>
                                                <td>{{ $pgb->provinsi }}</td>
                                                <td>{{ $pgb->kabupaten_kota }}</td>
                                                <td>{{ $pgb->sektor }}</td>
                                                <td>{{ $pgb->volume }}</td>
                                                <td>{{ $pgb->satuan }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center text-muted">
                                                    Data tidak ditemukan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                            <!--end::Datatable wrapper-->

                            <div class="d-flex justify-content-end mt-3">
                                {{ $query->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Index Lama --}}
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

            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0"
                                    role="alert">
                                    <i class="mdi mdi-alert-circle-outline label-icon"></i>
                                    <strong>Informasi:</strong> Data yang ditampilkan di halaman ini adalah data untuk bulan
                                    berjalan.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Periode {{ $periode }}</h4>
                                    <div>
                                        <a href="{{ url('/laporan/penjualan-jbt') }}"
                                            class="btn btn-danger waves-effect waves-light">
                                            <i class='bx bx-arrow-back'></i> Kembali
                                        </a>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">
                                            <i class='bx bx-filter-alt'></i> Filter
                                        </button>


                                        <!-- Modal cetak -->
                                        <div class="modal fade modal-select bs-example-modal-center" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Filter</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('laporan/penjualan-jbt-lihat-semua-data') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Nama
                                                                    Perusahaan</label>
                                                                <select
                                                                    class="form-control select20 select2-hidden-accessible mb-2"
                                                                    style="width: 100%;" name="perusahaan" required>
                                                                    <option value="all" selected>--Pilih Perusahaan--
                                                                    </option>
                                                                    <option value="all">Semua Perusahaan</option>
                                                                    @foreach ($perusahaan as $p)
                                                                        <option value="{{ $p->id_badan_usaha }}">
                                                                            {{ $p->nama_badan_usaha }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Tanggal
                                                                    Awal</label>
                                                                <input class="form-control" name="t_awal" type="month"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Tanggal
                                                                    Akhir</label>
                                                                <input class="form-control" name="t_akhir" type="month"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <button type="submit" data-bs-dismiss="modal"
                                                                    class="btn btn-primary">Proses</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons"
                                        class="table table-bordered table-striped dt nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Badan Usaha</th>
                                                <th>NPWP Badan Usaha</th>
                                                <th>Izin Usaha</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $pgb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pgb->nama_badan_usaha }}</td>
                                                    <td>{{ $pgb->npwp_badan_usaha }}</td>
                                                    <td>
                                                        @php
                                                            $izinList = json_decode($pgb->izin_usaha, true); // jika izin_usaha disimpan dalam bentuk JSON string
                                                        @endphp

                                                        @if (is_array($izinList))
                                                            <ul style="margin: 0; padding-left: 15px;">
                                                                @foreach ($izinList as $izin)
                                                                    <li>ID: {{ $izin['id_izin_usaha'] ?? '-' }} - Nomor:
                                                                        {{ $izin['nomor_izin_usaha'] ?? '-' }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <span class="text-muted">Tidak ada data</span>
                                                        @endif
                                                    </td>

                                                    <td>{{ bulan($pgb->bulan) }}</td>
                                                    <td>{{ $pgb->tahun }}</td>
                                                    <td>{{ $pgb->produk }}</td>
                                                    <td>{{ $pgb->provinsi }}</td>
                                                    <td>{{ $pgb->kabupaten_kota }}</td>
                                                    <td>{{ $pgb->sektor }}</td>
                                                    <td>{{ $pgb->volume }}</td>
                                                    <td>{{ $pgb->satuan }}</td>
                                                </tr>
                                            @endforeach
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
