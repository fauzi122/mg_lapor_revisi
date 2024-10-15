@extends('layouts.frontand.app')
{{-- tes --}}
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan Ekspor Impor</h4>
                </div>
            </div>
        </div>
        {{-- ekspor --}}
        {{-- ekspor --}}
        @if ($statusbulan_ambil_eksporsx != '' and $eixx == 'ekspor')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Ekspor</h5>
                            <div>
                                <a href="/eksport-import" class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                @if ($statusbulan_ambil_eksporsx == 1)
                                <form action="/submit_bulan_export/{{ $bulan_ambil_eksporsx . '-01' }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info" onclick="kirimData($(this).closest('form'))" disabled>
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_eksporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_eksporsx }}');" data-bs-toggle="modal" data-bs-target="#excelexpor" disabled>Import Excel</button>
                                @elseif ($statusbulan_ambil_eksporsx == 2)
                                <form action="/submit_bulan_export/{{ $bulan_ambil_eksporsx . '-01' }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info" onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_eksporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_eksporsx }}');" data-bs-toggle="modal" data-bs-target="#excelexpor" disabled>Import Excel</button>
                                @else
                                <form action="/submit_bulan_export/{{ $bulan_ambil_eksporsx . '-01' }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info" onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan {{ dateIndonesia($bulan_ambil_eksporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_eksporsx }}');" data-bs-toggle="modal" data-bs-target="#excelexpor">Import Excel</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan PEB</th>
                                        <th>Tahun PEB</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Produk</th>
                                        <th>HS Code</th>
                                        <th>Volume PEB</th>
                                        <th>Aksi</th>
                                        <th>Satuan</th>
                                        <th>Invoice Amount Nilai Pabean</th>
                                        <th>Invoice Amount Final</th>
                                        <th>Nama Konsumen</th>
                                        <th>Pelabuhan Muat</th>
                                        <th>Negara Tujuan</th>
                                        <th>Vessel Name</th>
                                        <th>Tanggal BL</th>
                                        <th>BL No</th>
                                        <th>No Pendaftaran PEB</th>
                                        <th>Tanggal Pendaftaran PEB</th>
                                        <th>Incoterms</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expor as $expor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ getBulan($expor->bulan_peb) }}</td>
                                        <td>{{ getTahun($expor->bulan_peb) }}</td>
                                        <td>
                                            @if ($expor->status == 1 && $expor->catatan)
                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($expor->status == 1)
                                            <span class="badge bg-success">Kirim</span>
                                            @elseif ($expor->status == 2)
                                            <span class="badge bg-danger">Revisi</span>
                                            @elseif ($expor->status == 0)
                                            <span class="badge bg-info">Draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $expor->catatan }}</td>
                                        <td>{{ $expor->produk }}</td>
                                        <td>{{ $expor->hs_code }}</td>
                                        <td>{{ $expor->volume_peb }}</td>
                                        <td>
                                            @if ($expor->status == "0")
                                            <center>
                                                <button type="button" class="btn btn-sm btn-info editEkpor" onclick="edit_ekpor('{{ $expor->id }}', '{{ $expor->produk }}', '{{ $expor->negara_tujuan }}')" data-bs-toggle="modal" data-bs-target="#modal-edit"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <form action="/hapus_export/{{ $expor->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-info" onclick="lihat_ekspor('{{ $expor->id }}', '{{ $expor->produk }}')" data-bs-toggle="modal" data-bs-target="#lihat-ekspor"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                            </center>
                                            @elseif ($expor->status == "1")
                                            <center>
                                                <button type="button" class="btn btn-sm btn-info" onclick="lihat_ekspor('{{ $expor->id }}', '{{ $expor->produk }}')" data-bs-toggle="modal" data-bs-target="#lihat-ekspor"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                            </center>
                                            @elseif ($expor->status == "2")
                                            <center>
                                                <button type="button" class="btn btn-sm btn-info editPenjualan" onclick="edit_ekpor('{{ $expor->id }}', '{{ $expor->produk }}', '{{ $expor->negara_tujuan }}')" data-bs-toggle="modal" data-bs-target="#modal-edit"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <button type="button" class="btn btn-sm btn-info" onclick="lihat_ekspor('{{ $expor->id }}', '{{ $expor->produk }}')" data-bs-toggle="modal" data-bs-target="#lihat-ekspor"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                            </center>
                                            @endif
                                        </td>
                                        <td>{{ $expor->satuan }}</td>
                                        <td>{{ $expor->invoice_amount_nilai_pabean }}</td>
                                        <td>{{ $expor->invoice_amount_final }}</td>
                                        <td>{{ $expor->nama_konsumen }}</td>
                                        <td>{{ $expor->pelabuhan_muat }}</td>
                                        <td>{{ $expor->negara_tujuan }}</td>
                                        <td>{{ $expor->vessel_name }}</td>
                                        <td>{{ $expor->tanggal_bl }}</td>
                                        <td>{{ $expor->bl_no }}</td>
                                        <td>{{ $expor->no_pendaf_peb }}</td>
                                        <td>{{ $expor->tanggal_pendaf_peb }}</td>
                                        <td>{{ $expor->incoterms }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"></div>
        @endif

        {{-- impor --}}
        {{-- impor --}}
        @if ($statusbulan_ambil_imporsx != '' and $eixx == 'impor')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Impor</h5>
                            <div>
                                <a href="/eksport-import" class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                @if ($statusbulan_ambil_imporsx == 1)
                                <form action="/submit_bulan_import/{{ $bulan_ambil_imporsx . '-01' }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info" onclick="kirimData($(this).closest('form'))" disabled>
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#inputimpor" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_imporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelimport" disabled>Import Excel</button>
                                @elseif ($statusbulan_ambil_imporsx == 2)
                                <form action="/submit_bulan_import/{{ $bulan_ambil_imporsx . '-01' }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info" onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#inputimpor" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_imporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_imporsx }}');" data-bs-toggle="modal" data-bs-target="#excelimport" disabled>Import Excel</button>
                                @else
                                <form action="/submit_bulan_import/{{ $bulan_ambil_imporsx . '-01' }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info" onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#inputimpor">Buat Laporan {{ dateIndonesia($bulan_ambil_imporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_imporsx }}');" data-bs-toggle="modal" data-bs-target="#excelimport">Import Excel</button>
                                @endif
                                @include('badan_usaha.ekspor_impor.modal')
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan PIB</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Produk</th>
                                        <th>HS Code</th>
                                        <th>Volume PIB</th>
                                        <th>Aksi</th>
                                        <th>Satuan</th>
                                        <th>Invoice Amount Nilai Pabean</th>
                                        <th>Invoice Amount Final</th>
                                        <th>Nama Supplier</th>
                                        <th>Negara Asal</th>
                                        <th>Pelabuhan Muat</th>
                                        <th>Pelabuhan Bongkar</th>
                                        <th>Vessel Name</th>
                                        <th>Tanggal BL</th>
                                        <th>BL NO</th>
                                        <th>No Pendaftaran PIB</th>
                                        <th>Tanggal Pendaftaran PIB</th>
                                        <th>Incoterms</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($impor as $impor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ dateIndonesia($impor->bulan_pib) }}</td>
                                        <td>
                                            @if ($impor->status == 1 && $impor->catatan)
                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($impor->status == 1)
                                            <span class="badge bg-success">Kirim</span>
                                            @elseif ($impor->status == 2)
                                            <span class="badge bg-danger">Revisi</span>
                                            @elseif ($impor->status == 0)
                                            <span class="badge bg-info">Draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $impor->catatan }}</td>
                                        <td>{{ $impor->produk }}</td>
                                        <td>{{ $impor->hs_code }}</td>
                                        <td>{{ $impor->volume_pib }}</td>
                                        <td>
                                            @if ($impor->status == "0")
                                            <center>
                                                <button type="button" class="btn btn-sm btn-info" onclick="edit_impor('{{ $impor->id }}','{{ $impor->produk }}' ,'{{ $impor->negara_asal }}')" data-bs-toggle="modal" data-bs-target="#edit-impor"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <form action="/hapus_import/{{ $impor->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-info" onclick="lihat_import('{{ $impor->id }}', '{{ $impor->produk }}')" data-bs-toggle="modal" data-bs-target="#lihat-import"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                            </center>
                                            @elseif ($impor->status == "1")
                                            <center>
                                                <button type="button" class="btn btn-sm btn-info" onclick="lihat_import('{{ $impor->id }}')" data-bs-toggle="modal" data-bs-target="#lihat-import"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                            </center>
                                            @elseif ($impor->status == "2")
                                            <center>
                                                <button type="button" class="btn btn-sm btn-info" onclick="edit_impor('{{ $impor->id }}','{{ $impor->produk }}','{{ $impor->negara_asal }}')" data-bs-toggle="modal" data-bs-target="#edit-pasokan"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <button type="button" class="btn btn-sm btn-info" onclick="lihat_import('{{ $impor->id }}')" data-bs-toggle="modal" data-bs-target="#lihat-import"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                            </center>
                                            @endif
                                        </td>
                                        <td>{{ $impor->satuan }}</td>
                                        <td>{{ $impor->invoice_amount_nilai_pabean }}</td>
                                        <td>{{ $impor->invoice_amount_final }}</td>
                                        <td>{{ $impor->nama_supplier }}</td>
                                        <td>{{ $impor->negara_asal }}</td>
                                        <td>{{ $impor->pelabuhan_muat }}</td>
                                        <td>{{ $impor->pelabuhan_bongkar }}</td>
                                        <td>{{ $impor->vessel_name }}</td>
                                        <td>{{ $impor->tanggal_bl }}</td>
                                        <td>{{ $impor->bl_no }}</td>
                                        <td>{{ $impor->no_pendaf_pib }}</td>
                                        <td>{{ $impor->tanggal_pendaf_pib }}</td>
                                        <td>{{ $impor->incoterms }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"></div>
        @endif

        {{-- impor --}}
        @if ($statusbulan_ambil_imporsx != '' and $eixx == 'impor')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Impor</h5>
                            <div>
                                <a href="/eksport-import"
                                    class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                @if ($statusbulan_ambil_imporsx == 1)
                                <form action="/submit_bulan_import/{{ $bulan_ambil_imporsx . '-01' }}"
                                    method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))" disabled>
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    onclick="produk(); provinsi(); negara(); pelabuhan(); incoterms();" data-bs-toggle="modal"
                                    data-bs-target="#inputimpor" disabled>Buat Laporan
                                    {{ dateIndonesia($bulan_ambil_imporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#excelimport" disabled>Import
                                    Excel</button>
                                @elseif ($statusbulan_ambil_imporsx == 2)
                                <form action="/submit_bulan_import/{{ $bulan_ambil_imporsx . '-01' }}"
                                    method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    onclick="produk(); provinsi(); negara(); pelabuhan(); incoterms(); tambahPMB('{{ $bulan_ambil_imporsx }}');"
                                    data-bs-toggle="modal" data-bs-target="#inputimpor" disabled>Buat Laporan
                                    {{ dateIndonesia($bulan_ambil_imporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light"
                                    onclick="tambahPMB('{{ $bulan_ambil_imporsx }}');" data-bs-toggle="modal"
                                    data-bs-target="#excelimport" disabled>Import Excel</button>
                                @else
                                <form action="/submit_bulan_import/{{ $bulan_ambil_imporsx . '-01' }}"
                                    method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    onclick="produk(); provinsi(); negara(); pelabuhan(); incoterms(); tambahPMB('{{ $bulan_ambil_imporsx }}');"
                                    data-bs-toggle="modal" data-bs-target="#inputimpor">Buat Laporan
                                    {{ dateIndonesia($bulan_ambil_imporsx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light"
                                    onclick="tambahPMB('{{ $bulan_ambil_imporsx }}');" data-bs-toggle="modal"
                                    data-bs-target="#excelimport">Import Excel</button>
                                @endif
                                @include('badan_usaha.ekspor_impor.modal')
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan PIB</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Produk</th>
                                        <th>HS Code</th>
                                        <th>Volume PIB</th>
                                        <th>Aksi</th>
                                        <th>Satuan</th>
                                        <th>Invoice Amount Nilai Pabean</th>
                                        <th>Invoice Amount Final</th>
                                        <th>Nama Supplier</th>
                                        <th>Negara Asal</th>
                                        <th>Pelabuhan Muat</th>
                                        <th>Pelabuhan Bongkar</th>
                                        <th>Vessel Name</th>
                                        <th>Tanggal BL</th>
                                        <th>BL NO</th>
                                        <th>No Pendaftaran PIB</th>
                                        <th>Tanggal Pendaftaran PIB</th>
                                        <th>Incoterms</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($impor as $impor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ dateIndonesia($impor->bulan_pib) }}</td>
                                        <td>
                                            @if ($impor->status == 1 && $impor->catatan)
                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($impor->status == 1)
                                            <span class="badge bg-success">Kirim</span>
                                            @elseif ($impor->status == 2)
                                            <span class="badge bg-danger">Revisi</span>
                                            @elseif ($impor->status == 0)
                                            <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $impor->catatan }}</td>
                                        <td>{{ $impor->produk }}</td>
                                        <td>{{ $impor->hs_code }}</td>
                                        <td>{{ $impor->volume_pib }}</td>
                                        <td>
                                            <?php
                                            $status = $impor->status;
                                            if ($status == "0") { ?>
                                                <center><button type="button" class="btn btn-sm btn-info "
                                                        id="" data-bs-toggle="modal"
                                                        onclick="edit_impor('{{ $impor->id }}','{{ $impor->produk }}' ,'{{ $impor->negara_asal }}')"
                                                        data-bs-target="#edit-impor"
                                                        data-id="{{ $impor->id }}"> <i class="bx bx-edit-alt"
                                                            title="Edit data"></i></button>
                                                    <form action="/hapus_import/{{ $impor->id }}"
                                                        method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="hapusData($(this).closest('form'))">
                                                            <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-info "
                                                        id="" data-bs-toggle="modal"
                                                        onclick="lihat_import('{{ $impor->id }}' ,'{{ $impor->produk }}')"
                                                        data-bs-target="#lihat-import"
                                                        data-id="{{ $impor->id }}"> <i class="bx bx-show-alt"
                                                            title="Lihat data"></i></button>
                                                </center>


                                            <?php } elseif ($status == "1") { ?>

                                                <center><button type="button" class="btn btn-sm btn-info "
                                                        id="" data-bs-toggle="modal"
                                                        onclick="lihat_import('{{ $impor->id }}')"
                                                        data-bs-target="#lihat-import"
                                                        data-id="{{ $impor->id }}"> <i class="bx bx-show-alt"
                                                            title="Lihat data"></i></button></center>

                                            <?php } elseif ($status == "2") { ?>
                                                <center><button type="button" class="btn btn-sm btn-info "
                                                        id="" data-bs-toggle="modal"
                                                        onclick="edit_impor('{{ $impor->id }}','{{ $impor->produk }}' ,'{{ $impor->negara_asal }}')"
                                                        data-bs-target="#edit-pasokan"
                                                        data-id="{{ $impor->id }}"> <i class="bx bx-edit-alt"
                                                            title="Edit data"></i></button>
                                                    <button type="button" class="btn btn-sm btn-info "
                                                        id="" data-bs-toggle="modal"
                                                        onclick="lihat_import('{{ $impor->id }}')"
                                                        data-bs-target="#lihat-import"
                                                        data-id="{{ $impor->id }}"> <i class="bx bx-show-alt"
                                                            title="Lihat data"></i></button>
                                                </center>
                                            <?php } ?>
                                        </td>
                                        <td>{{ $impor->satuan }}</td>
                                        <td>{{ $impor->invoice_amount_nilai_pabean }}</td>
                                        <td>{{ $impor->invoice_amount_final }}</td>
                                        <td>{{ $impor->nama_supplier }}</td>
                                        <td>{{ $impor->negara_asal }}</td>
                                        <td>{{ $impor->pelabuhan_muat }}</td>
                                        <td>{{ $impor->pelabuhan_bongkar }}</td>
                                        <td>{{ $impor->vessel_name }}</td>
                                        <td>{{ $impor->tanggal_bl }}</td>
                                        <td>{{ $impor->bl_no }}</td>
                                        <td>{{ $impor->no_pendaf_pib }}</td>
                                        <td>{{ $impor->tanggal_pendaf_pib }}</td>
                                        <td>{{ $impor->incoterms }}</td>

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
        @else
        <div class="row"></div>
        @endif

    </div>
    {{-- <script>
    document.querySelector('.btn-primary').addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>  --}}
    @endsection