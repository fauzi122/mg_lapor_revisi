@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Pengolahan Minyak Bumi/Hasil Olahan</h4>
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
                                        <a href="javascript:history.back()"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>

                                        <form
                                            action="{{ url('/submit_bulan_pengolahan_minyak_bumi_produksi') }}/{{ $bulan_ambil_produksix . '-01' }}"
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
                                            data-bs-toggle="modal" data-bs-target="#buat-pengolahan-produksi-mb"
                                            {{ $status_produksix != 0 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_produksix) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_produksix }}' );" data-bs-toggle="modal"
                                            data-bs-target="#excelPengolahanMBProduksi"
                                            {{ $status_produksix != 0 ? 'disabled' : '' }}>Import Excel</button>
                                        <!-- Include modal content -->
                                        @include('badan_usaha.pengolahan.minyak_bumi.modal')
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
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Aksi</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengolahanProduksiMB as $ppmb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($ppmb->bulan) }}</td>
                                                    <td>{{ getTahun($ppmb->bulan) }}</td>
                                                    <td>
                                                        @if ($ppmb->status == 1 && $ppmb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppmb->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($ppmb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($ppmb->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @elseif($ppmb->status == 3)
                                                            <span class="badge bg-primary">Selesai</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ppmb->catatan }}</td>
                                                    <td>{{ $ppmb->produk }}</td>
                                                    <td>{{ $ppmb->provinsi }}</td>
                                                    <td>{{ $ppmb->kabupaten_kota }}</td>
                                                    <td>
                                                        <center>
                                                            @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-produksi-mb"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-produksi-mb"
                                                                    data-id="{{ $ppmb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pengolahan_minyak_bumi_produksi') }}/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_minyak_bumi_produksi/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                    </button>
                                                                </form> --}}
                                                            @elseif($ppmb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-produksi-mb"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-produksi-mb"
                                                                    data-id="{{ $ppmb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_minyak_bumi_produksi/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppmb->id }}">
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
                                                                onclick="lihatPengolahan('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-produksi-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>

                                                        {{-- <center>
                                                            @if ($ppmb->status == 1 && $ppmb->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppmb->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($ppmb->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $ppmb->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center> --}}
                                                    </td>
                                                    <td>{{ $ppmb->volume }}</td>
                                                    <td>{{ $ppmb->satuan }}</td>
                                                    <td>{{ $ppmb->keterangan }}</td>
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

            @if ($status_pasokanx != '' and $jenis == 'pasokan')
                {{-- Pengolahan Minyak Bumi Pasokan Kilang --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Pasokan Kilang</h5>
                                    <div>
                                        <a href="javascript:history.back()"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>

                                        <form
                                            action="{{ url('/submit_bulan_pengolahan_minyak_bumi_pasokan') }}/{{ $bulan_ambil_pasokanx . '-01' }}"
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
                                            data-bs-toggle="modal" data-bs-target="#buat-pengolahan-pasokan-mb"
                                            {{ $status_pasokanx != 0 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_pasokanx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_distribusix }}' );" data-bs-toggle="modal"
                                            data-bs-target="#excelPengolahanMBPasokan"
                                            {{ $status_pasokanx != 0 ? 'disabled' : '' }}>Import Excel
                                        </button>
                                        <!-- Include modal content -->
                                        @include('badan_usaha.pengolahan.minyak_bumi.modal')
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
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Kategori Pemasok</th>
                                                <th>Intake Kilang</th>
                                                <th>Aksi</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengolahanPasokanMB as $ppmb)
                                                @php
                                                    $kabKota = json_decode($ppmb->kabupaten_kota);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($ppmb->bulan) }}</td>
                                                    <td>{{ getTahun($ppmb->bulan) }}</td>
                                                    <td>
                                                        @if ($ppmb->status == 1 && $ppmb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppmb->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($ppmb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($ppmb->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ppmb->catatan }}</td>
                                                    <td>{{ $ppmb->kategori_pemasok }}</td>
                                                    <td>{{ $ppmb->intake_kilang }}</td>
                                                    <td>
                                                        <center>
                                                            @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-pasokan-mb"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->intake_kilang }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-pasokan-mb"
                                                                    data-id="{{ $ppmb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pengolahan_minyak_bumi_pasokan') }}/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_minyak_bumi_pasokan/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form> --}}
                                                            @elseif($ppmb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-pasokan-mb"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->intake_kilang }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-pasokan-mb"
                                                                    data-id="{{ $ppmb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                {{-- <form
                                                                    action="/submit_pengolahan_minyak_bumi_pasokan/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppmb->id }}">
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
                                                                onclick="lihatPengolahan('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-pasokan-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>

                                                        {{--  <center>
                                                            @if ($ppmb->status == 1 && $ppmb->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppmb->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($ppmb->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $ppmb->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center>  --}}
                                                    </td>
                                                    <td>{{ $ppmb->provinsi }}</td>
                                                    <td>{{ $ppmb->kabupaten_kota }}</td>
                                                    <td>{{ $ppmb->volume }}</td>
                                                    <td>{{ $ppmb->satuan }}</td>
                                                    <td>{{ $ppmb->keterangan }}</td>
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

            @if ($status_distribusix != '' and $jenis == 'distribusi')
                {{-- Pengolahan Minyak Bumi Distribusi Kilang --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Distribusi/Penjualan Domestik Kilang</h5>
                                    <div>
                                        <a href="javascript:history.back()"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>

                                        <form
                                            action="{{ url('/submit_bulan_pengolahan_minyak_bumi_distribusi') }}/{{ $bulan_ambil_distribusix . '-01' }}"
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
                                            data-bs-toggle="modal" data-bs-target="#buat-pengolahan-distribusi-mb"
                                            {{ $status_distribusix != 0 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_distribusix) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_distribusix }}' );"
                                            data-bs-toggle="modal" data-bs-target="#excelPengolahanMBDistribusi"
                                            {{ $status_distribusix != 0 ? 'disabled' : '' }}>Import Excel
                                        </button>
                                        <!-- Include modal content -->
                                        @include('badan_usaha.pengolahan.minyak_bumi.modal')
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
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Aksi</th>
                                                <th>Sektor</th>
                                                <th>Nama</th>
                                                <th>Nama Badan Usaha</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengolahanDistribusiMB as $ppmb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($ppmb->bulan) }}</td>
                                                    <td>{{ getTahun($ppmb->bulan) }}</td>
                                                    <td>
                                                        @if ($ppmb->status == 1 && $ppmb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppmb->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($ppmb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($ppmb->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ppmb->catatan }}</td>
                                                    <td>{{ $ppmb->produk }}</td>
                                                    <td>{{ $ppmb->provinsi }}</td>
                                                    <td>{{ $ppmb->kabupaten_kota }}</td>
                                                    <td>
                                                        <center>
                                                            @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-distribusi-mb"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-distribusi-mb"
                                                                    data-id="{{ $ppmb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pengolahan_minyak_bumi_distribusi') }}/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                {{--  <form
                                                                    action="/submit_pengolahan_minyak_bumi_distribusi/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form>  --}}
                                                            @elseif($ppmb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-distribusi-mb"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-distribusi-mb"
                                                                    data-id="{{ $ppmb->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit Data"></i>
                                                                </button>
                                                                {{--  <form
                                                                    action="/submit_pengolahan_minyak_bumi_distribusi/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form>  --}}
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-distribusi-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>

                                                        {{--  <center>
                                                            @if ($ppmb->status == 1 && $ppmb->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppmb->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($ppmb->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $ppmb->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center>  --}}
                                                    </td>
                                                    <td>{{ $ppmb->sektor }}</td>
                                                    <td>{{ $ppmb->nama }}</td>
                                                    <td>{{ $ppmb->nama_bu_niaga }}</td>
                                                    <td>{{ $ppmb->volume }}</td>
                                                    <td>{{ $ppmb->satuan }}</td>
                                                    <td>{{ $ppmb->keterangan }}</td>
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
