@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Pengolahan Gas Bumi</h4>
                    </div>
                </div>
            </div>

            @if ($status_produksix != '' and $jenis == 'produksi')
                {{-- Pengolahan Minyak Bumi Produksi Kilang --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Produksi Kilang</h5>
                                    <div>
                                        <a href="/pengolahan-minyak-bumi-hasil-olah"
                                            class="btn btn-secondary waves-effect waves-light">Kembali
                                        </a>
                                        <form
                                            action="/submit_bulan_pengolahan_gas_bumi_produksi/{{ $bulan_ambil_produksix . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))"
                                                {{ $status_produksix == 1 ? 'disabled' : '' }}>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_produksix }}' );"
                                            data-bs-toggle="modal" data-bs-target="#buat-pengolahan-produksi-gb"
                                            {{ $status_produksix != 0 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_produksix) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_produksix }}' );" data-bs-toggle="modal"
                                            data-bs-target="#excelPengolahanGBProduksi"
                                            {{ $status_produksix != 0 ? 'disabled' : '' }}>Import Excel</button>
                                        <!-- Include modal content -->
                                        @include('badan_usaha.pengolahan.gas_bumi.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Aksi</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengolahanProduksiGB as $ppgb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('F Y', strtotime($ppgb->bulan)) }}</td>
                                                    <td>
                                                        @if ($ppgb->status == 1 && $ppgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppgb->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($ppgb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($ppgb->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ppgb->catatan }}</td>
                                                    <td>{{ $ppgb->produk }}</td>
                                                    <td>{{ $ppgb->provinsi }}</td>
                                                    <td>{{ $ppgb->kabupaten_kota }}</td>
                                                    <td>
                                                        <center>
                                                            @if ($ppgb->status == '0' || $ppgb->status == '' || $ppgb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-produksi-gb"
                                                                    onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-produksi-gb"
                                                                    data-id="{{ $ppgb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="/hapus_pengolahan_gas_bumi_produksi/{{ $ppgb->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- <form
                                                                action="/submit_pengolahan_gas_bumi_produksi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form> --}}
                                                            @elseif($ppgb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-produksi-gb"
                                                                    onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-produksi-gb"
                                                                    data-id="{{ $ppgb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                {{-- <form
                                                                action="/submit_pengolahan_gas_bumi_produksi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form> --}}
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppgb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-produksi-gb"
                                                                data-id="{{ $ppgb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>

                                                        {{-- <center>
                                                        @if ($ppgb->status == 1 && $ppgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppgb->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($ppgb->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $ppgb->id }}">
                                                                Cek Revisi
                                                            </span>
                                                        @endif
                                                    </center> --}}
                                                    </td>
                                                    <td>{{ $ppgb->volume }}</td>
                                                    <td>{{ $ppgb->satuan }}</td>
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
                {{-- Pengolahan Minyak Bumi Produksi Kilang --}}
            @endif

            @if ($status_produksix != '' and $jenis == 'pasokan')
                {{-- Pengolahan Minyak Bumi Pasokan Kilang --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Pasokan Kilang</h5>
                                    <div>
                                        <a href="/pengolahan-minyak-bumi-hasil-olah"
                                            class="btn btn-secondary waves-effect waves-light">Kembali
                                        </a>
                                        <form
                                            action="/submit_bulan_pengolahan_gas_bumi_pasokan/{{ $bulan_ambil_pasokanx . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))"
                                                {{ $status_pasokanx == 1 ? 'disabled' : '' }}>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="intake_kilang(); provinsi(); tambahPMB('{{ $bulan_ambil_pasokanx }}' );"
                                            data-bs-toggle="modal" data-bs-target="#buat-pengolahan-pasokan-gb"
                                            {{ $status_pasokanx != 0 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_pasokanx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_pasokanx }}' );" data-bs-toggle="modal"
                                            data-bs-target="#excelPengolahanGBPasokan"
                                            {{ $status_pasokanx != 0 ? 'disabled' : '' }}>Import Excel</button>
                                        <!-- Include modal content -->
                                        @include('badan_usaha.pengolahan.gas_bumi.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Intake Kilang</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Aksi</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengolahanPasokanGB as $ppgb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('F Y', strtotime($ppgb->bulan)) }}</td>
                                                    <td>
                                                        @if ($ppgb->status == 1 && $ppgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppgb->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($ppgb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($ppgb->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ppgb->catatan }}</td>
                                                    <td>{{ $ppgb->intake_kilang }}</td>
                                                    <td>{{ $ppgb->provinsi }}</td>
                                                    <td>{{ $ppgb->kabupaten_kota }}</td>
                                                    <td>
                                                        <center>
                                                            @if ($ppgb->status == '0' || $ppgb->status == '' || $ppgb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-pasokan-gb"
                                                                    onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->intake_kilang }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-pasokan-gb"
                                                                    data-id="{{ $ppgb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="/hapus_pengolahan_gas_bumi_pasokan/{{ $ppgb->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_gas_bumi_pasokan/{{ $ppgb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppgb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form> --}}
                                                            @elseif($ppgb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-pasokan-gb"
                                                                    onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->intake_kilang }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-pasokan-gb"
                                                                    data-id="{{ $ppgb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_gas_bumi_pasokan/{{ $ppgb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppgb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form> --}}
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppgb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-pasokan-gb"
                                                                data-id="{{ $ppgb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>

                                                        {{-- <center>
                                                            @if ($ppgb->status == 1 && $ppgb->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppgb->status == 1)
                                                                <span class="badge bg-success">Kirim</span>
                                                            @elseif ($ppgb->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $ppgb->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center> --}}
                                                    </td>
                                                    <td>{{ $ppgb->volume }}</td>
                                                    <td>{{ $ppgb->satuan }}</td>
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
                {{-- Pengolahan Minyak Bumi Pasokan Kilang --}}
            @endif

            @if ($status_produksix != '' and $jenis == 'distribusi')
                {{-- Pengolahan Minyak Bumi Distribusi Kilang --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Distribusi/Penjualan Domestik Kilang</h5>
                                    <div>
                                        <a href="/pengolahan-minyak-bumi-hasil-olah"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        <form
                                            action="/submit_bulan_pengolahan_gas_bumi_distribusi/{{ $bulan_ambil_distribusix . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))"
                                                {{ $status_distribusix == 1 ? 'disabled' : '' }}>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_distribusix }}' ); sektor();"
                                            data-bs-toggle="modal" data-bs-target="#buat-pengolahan-distribusi-gb"
                                            {{ $status_distribusix != 0 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_distribusix) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_distribusix }}' );"
                                            data-bs-toggle="modal" data-bs-target="#excelPengolahanGBDistribusi"
                                            {{ $status_distribusix != 0 ? 'disabled' : '' }}>Import Excel
                                        </button>
                                        <!-- Include modal content -->
                                        @include('badan_usaha.pengolahan.gas_bumi.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table3" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Aksi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengolahanDistribusiGB as $ppgb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('F Y', strtotime($ppgb->bulan)) }}</td>
                                                    <td>
                                                        @if ($ppgb->status == 1 && $ppgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppgb->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($ppgb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($ppgb->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ppgb->catatan }}</td>
                                                    <td>{{ $ppgb->produk }}</td>
                                                    <td>{{ $ppgb->provinsi }}</td>
                                                    <td>{{ $ppgb->kabupaten_kota }}</td>
                                                    <td>
                                                        <center>
                                                            @if ($ppgb->status == '0' || $ppgb->status == '' || $ppgb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-distribusi-gb"
                                                                    onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-distribusi-gb"
                                                                    data-id="{{ $ppgb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="/hapus_pengolahan_gas_bumi_distribusi/{{ $ppgb->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_gas_bumi_distribusi/{{ $ppgb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppgb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form> --}}
                                                            @elseif($ppgb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-distribusi-gb"
                                                                    onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-distribusi-gb"
                                                                    data-id="{{ $ppgb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_gas_bumi_distribusi/{{ $ppgb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppgb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form> --}}
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppgb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-distribusi-gb"
                                                                data-id="{{ $ppgb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>

                                                        {{-- <center>
                                                            @if ($ppgb->status == 1 && $ppgb->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppgb->status == 1)
                                                                <span class="badge bg-success">Kirim</span>
                                                            @elseif ($ppgb->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $ppgb->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center> --}}
                                                    </td>
                                                    <td>{{ $ppgb->sektor }}</td>
                                                    <td>{{ $ppgb->volume }}</td>
                                                    <td>{{ $ppgb->satuan }}</td>
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
                {{-- Pengolahan Minyak Bumi Produksi Kilang --}}
            @endif
        </div>
    </div>
@endsection
