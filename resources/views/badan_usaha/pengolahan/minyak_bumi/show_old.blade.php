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
            {{-- Pengolahan Minyak Bumi Produksi Kilang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Produksi Kilang</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#buat-pengolahan-produksi-mb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
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
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanProduksiMB as $ppmb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ppmb->bulan }}</td>
                                                <td>{{ $ppmb->produk }}</td>
                                                <td>{{ $ppmb->provinsi }}</td>
                                                <td>{{ $ppmb->kabupaten_kota }}</td>
                                                <td>{{ $ppmb->volume }}</td>
                                                <td>{{ $ppmb->satuan }}</td>
                                                <td>{{ $ppmb->keterangan }}</td>
                                                <td>
                                                    @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-produksi-mb"
                                                                onclick="editPengolahanProduksiMB('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-produksi-mb"
                                                                data-id="{{ $ppmb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/hapus_pengolahan_minyak_bumi_produksi/{{ $ppmb->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="/submit_pengolahan_minyak_bumi_produksi/{{ $ppmb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppmb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($ppmb->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahanProduksiMB('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-produksi-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($ppmb->status == '2')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-produksi-mb"
                                                                onclick="editPengolahanProduksiMB('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-produksi-mb"
                                                                data-id="{{ $ppmb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/submit_pengolahan_minyak_bumi_produksi/{{ $ppmb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppmb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif
                                                </td>
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

            {{-- Pengolahan Minyak Bumi Pasokan Kilang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Pasokan Kilang</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="intake_kilang(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#buat-pengolahan-pasokan-mb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
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
                                            <th>Kategori Pemasok</th>
                                            <th>Intake Kilang</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanPasokanMB as $ppmb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ppmb->bulan }}</td>
                                                <td>{{ $ppmb->kategori_pemasok }}</td>
                                                <td>{{ $ppmb->intake_kilang }}</td>
                                                <td>{{ $ppmb->provinsi }}</td>
                                                <td>{{ $ppmb->kabupaten_kota }}</td>
                                                <td>{{ $ppmb->volume }}</td>
                                                <td>{{ $ppmb->satuan }}</td>
                                                <td>{{ $ppmb->keterangan }}</td>
                                                <td>
                                                    @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-pasokan-mb"
                                                                onclick="editPengolahanPasokanMB('{{ $ppmb->id }}', '{{ $ppmb->intake_kilang }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-pasokan-mb"
                                                                data-id="{{ $ppmb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/hapus_pengolahan_minyak_bumi_pasokan/{{ $ppmb->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="/submit_pengolahan_minyak_bumi_pasokan/{{ $ppmb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppmb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($ppmb->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahanPasokanMB('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-pasokan-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($ppmb->status == '2')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-pasokan-mb"
                                                                onclick="editPengolahanPasokanMB('{{ $ppmb->id }}', '{{ $ppmb->intake_kilang }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-pasokan-mb"
                                                                data-id="{{ $ppmb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/submit_pengolahan_minyak_bumi_pasokan/{{ $ppmb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppmb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif
                                                </td>
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

            {{-- Pengolahan Minyak Bumi Distribusi Kilang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Distribusi/Penjualan Domestik Kilang</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#buat-pengolahan-distribusi-mb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
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
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanDistribusiMB as $ppmb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ppmb->bulan }}</td>
                                                <td>{{ $ppmb->produk }}</td>
                                                <td>{{ $ppmb->provinsi }}</td>
                                                <td>{{ $ppmb->kabupaten_kota }}</td>
                                                <td>{{ $ppmb->sektor }}</td>
                                                <td>{{ $ppmb->volume }}</td>
                                                <td>{{ $ppmb->satuan }}</td>
                                                <td>{{ $ppmb->keterangan }}</td>
                                                <td>
                                                    @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-distribusi-mb"
                                                                onclick="editPengolahanDistribusiMB('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-distribusi-mb"
                                                                data-id="{{ $ppmb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/hapus_pengolahan_minyak_bumi_distribusi/{{ $ppmb->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="/submit_pengolahan_minyak_bumi_distribusi/{{ $ppmb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppmb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($ppmb->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahanDistribusiMB('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-distribusi-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($ppmb->status == '2')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-distribusi-mb"
                                                                onclick="editPengolahanDistribusiMB('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-distribusi-mb"
                                                                data-id="{{ $ppmb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/submit_pengolahan_minyak_bumi_distribusi/{{ $ppmb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppmb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif
                                                </td>
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
        </div>
    </div>
@endsection
