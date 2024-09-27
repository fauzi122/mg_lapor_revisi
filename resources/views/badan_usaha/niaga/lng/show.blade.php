@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan LNG/CNG/BBG </h4>
                    </div>
                </div>
            </div>

            {{-- Penjualan LNG/CNG --}}
            @if ($statuspenjualan_lngx != '' and $lngx == 'penjualan')
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Penjualan LNG/CNG/BBG</h5>
                                    <div>
                                        <a href="/lng/cng" class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        @if ($statuspenjualan_lngx == 1)
                                            <form action="/submit_bulan_lng/{{ $bulan_ambil_penjualan_lngx . '-01' }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))" disabled>
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng" disabled>Import
                                                Excel</button>
                                        @elseif ($statuspenjualan_lngx == 2)
                                            <form action="/submit_bulan_lng/{{ $bulan_ambil_penjualan_lngx . '-01' }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng" disabled>Import
                                                Excel</button>
                                        @else
                                            <form action="/submit_bulan_lng/{{ $bulan_ambil_penjualan_lngx . '-01' }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng">Import Excel</button>
                                        @endif
                                        @include('badan_usaha.niaga.lng.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Produk</th>
                                                <th>Aksi</th>
                                                <th>Konsumen</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan (MMBTU)</th>
                                                <th>Biaya Kompresi/Regasifikasi (USD/MMBTU)</th>
                                                <th>Biaya Penyimpanan (USD/MMBTU)</th>
                                                <th>Biaya Pengangkutan (USD/MMBTU)</th>
                                                <th>Biaya Niaga (USD/MMBTU)</th>
                                                <th>Harga Jual (USD/MMBTU)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lng as $lng)
                                                <tr>
                                                    <td>{{ dateIndonesia($lng->bulan) }}</td>
                                                    <td>
                                                        @if ($lng->status == 1 && $lng->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($lng->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($lng->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($lng->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $lng->catatan }}</td>
                                                    <td>{{ $lng->provinsi }}</td>
                                                    <td>{{ $lng->kabupaten_kota }}</td>
                                                    <td>{{ $lng->produk }}</td>
                                                    <td>
                                                        <?php $status=$lng->status;
                                                        if ($status=="0") { ?>
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editPenjualan"
                                                                id="editCompany"
                                                                onclick="edit_penjualan_lng('{{ $lng->id }}', '{{ $lng->produk }}' , '{{ $lng->kabupaten_kota }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                data-id="{{ $lng->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i>
                                                            </button>
                                                            <form action="/hapus_lng/{{ $lng->id }}" method="post"
                                                                class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_lng('{{ $lng->id }}')"
                                                                data-bs-target="#lihat-lng" data-id="{{ $lng->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                        <?php } elseif ($status=="1") { ?>
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_lng('{{ $lng->id }}')"
                                                                data-bs-target="#lihat-lng"
                                                                data-id="{{ $lng->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                        <?php } elseif ($status=="2") { ?>
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info editPenjualan" id="editCompany"
                                                                onclick="edit_penjualan_lng('{{ $lng->id }}', '{{ $lng->produk }}' , '{{ $lng->kabupaten_kota }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                data-id="{{ $lng->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i>
                                                            </button>
                                                            {{-- <form action="/submit_lng/{{ $lng->id }}" method="post"
                                                                class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form> --}}
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_lng('{{ $lng->id }}')"
                                                                data-bs-target="#lihat-lng"
                                                                data-id="{{ $lng->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                        <?php } ?>
                                                    </td>
                                                    <td>{{ $lng->konsumen }}</td>
                                                    <td>{{ $lng->sektor }}</td>
                                                    <td>{{ $lng->volume }}</td>
                                                    <td>{{ $lng->satuan }}</td>
                                                    <td>{{ $lng->biaya_kompresi }}</td>
                                                    <td>{{ $lng->biaya_penyimpanan }}</td>
                                                    <td>{{ $lng->biaya_pengangkutan }}</td>
                                                    <td>{{ $lng->biaya_niaga }}</td>
                                                    <td>{{ $lng->harga_jual }}</td>

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
            {{-- Pasokan LNG/CNG --}}
            @if ($statuspasok_lngx != '' and $lngx == 'pasok')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Pasokan LNG/CNG/BBG</h5>
                                    <div>
                                        <a href="/lng/cng" class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        @if ($statuspasok_lngx == 1)
                                            <form action="/submit_bulan_pasok_lng/{{ $bulan_ambil_pasok_lngx . '-01' }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))" disabled>
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#pasokan_lng" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lngx) }}
                                            </button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng_pasok" disabled>Import
                                                Excel
                                            </button>
                                        @elseif ($statuspasok_lngx == 2)
                                            <form action="/submit_bulan_pasok_lng/{{ $bulan_ambil_pasok_lngx . '-01' }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#pasokan_lng" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng_pasok" disabled>Import
                                                Excel</button>
                                        @else
                                            <form action="/submit_bulan_pasok_lng/{{ $bulan_ambil_pasok_lngx . '-01' }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#pasokan_lng">Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lngx) }}
                                            </button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng_pasok">Import
                                                Excel</button>
                                        @endif
                                        @include('badan_usaha.niaga.lng.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>Nama Pemasok</th>
                                                <th>Kategori Pemasok</th>
                                                <th>Aksi</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Harga Gas</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pasok_lng as $pasok)
                                                <tr>
                                                    <td>{{ dateIndonesia($pasok->bulan) }}</td>
                                                    <td>
                                                        @if ($pasok->status == 1 && $pasok->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($pasok->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($pasok->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($pasok->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $pasok->catatan }}</td>
                                                    <td>{{ $pasok->produk }}</td>
                                                    <td>{{ $pasok->nama_pemasok }}</td>
                                                    <td>{{ $pasok->kategori_pemasok }}</td>
                                                    <td>
                                                        <?php
                                            $status=$pasok->status;
                                            if ($status=="0"){ ?>
                                                        <center><button type="button"
                                                                class="btn btn-sm btn-info editPasok" id="editCompany"
                                                                onclick="edit_pasokan_lng('{{ $pasok->id }}', '{{ $pasok->produk }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit-pasok"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i></button>
                                                            <form action="/hapus_pasok_lng/{{ $pasok->id }}"
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
                                                                onclick="lihat_pasok_lng('{{ $pasok->id }}')"
                                                                data-bs-target="#lihat-pasok-lng"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button>
                                                        </center>

                                                        <?php 
                                            }elseif ($status=="1"){ ?>

                                                        <center><button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pasok_lng('{{ $pasok->id }}')"
                                                                data-bs-target="#lihat-pasok-lng"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button></center>

                                                        <?php 
                                            }elseif ($status=="2"){ ?>
                                                        <center><button type="button"
                                                                class="btn btn-sm btn-info editPasok" id="editCompany"
                                                                onclick="edit_pasokan_lng('{{ $pasok->id }}', '{{ $pasok->produk }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit-pasok"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i></button>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pasok_lng('{{ $pasok->id }}')"
                                                                data-bs-target="#lihat-pasok-lng"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button>
                                                        </center>
                                                        <?php 
                                            } ?>
                                                    </td>
                                                    <td>{{ $pasok->volume }}</td>
                                                    <td>{{ $pasok->satuan }}</td>
                                                    <td>{{ $pasok->harga_gas }}</td>

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


            {{-- expor impor --}}
            {{-- expor --}}
            {{-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Ekspor</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#modal-ekspor">Buat Laporan.</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
                                <!-- Include modal content -->
                                @include('badan_usaha.ekspor_impor.modal')
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table3" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan PEB</th>
                                        <th>Produk</th>
                                        <th>HS Code</th>
                                        <th>Volume PEB</th>
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expor as $expor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $expor->bulan_peb }}</td>
                                        <td>{{ $expor->produk }}</td>
                                        <td>{{ $expor->hs_code }}</td>
                                        <td>{{ $expor->volume_peb }}</td>
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
                                        <td>
                                            
                                            <?php
                                            $status=$expor->status;
                                            if ($status=="0"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info editEkpor" id="editCompany" onclick="edit_ekpor('{{ $expor->id }}', '{{ $expor->produk }}' )" data-bs-toggle="modal" data-bs-target="#modal-edit-ekspor" data-id="{{ $expor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <form action="/hapus_export/{{ $expor->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_export/{{ $expor->id }}" method="post" class="d-inline" data-id="{{ $expor->id }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                                
                                            <?php 
                                            }elseif ($status=="1"){ ?>
                                                      
                                                        <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_ekspor('{{ $expor->id }}' , '{{ $expor->produk }}')" data-bs-target="#lihat-ekspor" data-id="{{ $expor->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                                      
                                            <?php 
                                            }elseif ($status=="2"){ ?>
                                                        <center><button type="button" class="btn btn-sm btn-info editPenjualan" id="editCompany" onclick="edit_penjualan_gbp('{{ $expor->id }}' )" data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $exporexpor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>  
                                                        <form action="/submit_export/{{ $expor->id }}" method="post" class="d-inline">
                                                        @method('PUT')
                                                        @csrf
                                                            <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                            <?php 
                                            } ?>
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
        </div> --}}
            {{-- impor --}}
            {{-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Impor</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#inputimpor">Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelpholb">Import Excel</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table4" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan PIB</th>
                                        <th>Produk</th>
                                        <th>HS Code</th>
                                        <th>Volume PIB</th>
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($impor as $impor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $impor->bulan_pib }}</td>
                                        <td>{{ $impor->produk }}</td>
                                        <td>{{ $impor->hs_code }}</td>
                                        <td>{{ $impor->volume_pib }}</td>
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
                                        <td>
                                        <?php
                                        $status=$impor->status;
                                        if ($status=="0"){ ?>
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_impor('{{ $impor->id }}','{{ $expor->produk }}')" data-bs-target="#edit-impor" data-id="{{ $impor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                            <form action="/hapus_import/{{ $impor->id }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                </button>
                                            </form>
                                            <form action="/submit_import/{{ $impor->id }}" method="post" class="d-inline" data-id="{{ $impor->id }}">
                                            @method('PUT')
                                            @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                            
                                       <?php }elseif ($status=="1"){ ?>
                                            
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_import('{{ $impor->id }}')" data-bs-target="#lihat-import" data-id="{{ $impor->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                            
                                       <?php }elseif ($status=="2"){ ?>
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_pasokan_gbp('{{ $impor->id }}')" data-bs-target="#edit-pasokan" data-id="{{ $impor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                            <form action="/submit_import/{{ $impor->id }}" method="post" class="d-inline">
                                            @method('PUT')
                                            @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                       <?php } ?>
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
        </div> --}}

        </div>
    </div>

    <script>
        document.querySelector('.btn-primary').addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    </script>
@endsection
