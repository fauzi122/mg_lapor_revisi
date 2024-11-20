@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan LPG</h4>
                    </div>
                </div>
            </div>
            {{-- penjualan --}}

            @if ($statuspenjualan_lpgx != '' and $lpgx == 'penjualan')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Penjualan LPG</h5>
                                    <div>
                                        <a href="javascript:history.back()"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        <form
                                            action="{{ url('/submit_bulan_penjualan_lpg') }}/{{ $bulan_ambil_penjualan_lpgx . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))"
                                                {{ $statuspenjualan_lpgx == 1 ? 'disabled' : '' }}>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); sektor();" data-bs-toggle="modal"
                                            data-bs-target="#myModal"
                                            {{ $statuspenjualan_lpgx == 1 || $statuspenjualan_lpgx == 2 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_penjualan_lpgx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_penjualan_lpgx }}' )" data-bs-toggle="modal"
                                            data-bs-target="#excelpho"
                                            {{ $statuspenjualan_lpgx == 1 || $statuspenjualan_lpgx == 2 ? 'disabled' : '' }}>Import
                                            Excel</button>
                                        <!-- Include modal content -->
                                        @include('badan_usaha.niaga.lpg.modal')
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
                                                <th>Aksi</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Sektor</th>
                                                <th>Kemasan</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lpgs as $lpg)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($lpg->bulan) }}</td>
                                                    <td>{{ getTahun($lpg->bulan) }}</td>
                                                    <td>
                                                        @if ($lpg->status == 1 && $lpg->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($lpg->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($lpg->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($lpg->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $lpg->catatan }}</td>
                                                    <td>{{ $lpg->produk }}</td>
                                                    <td>
                                                        @if ($lpg->status == '0' || $lpg->status == '' || $lpg->status == '-')
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPenjualan"
                                                                    id="editCompany"
                                                                    onclick="edit_harga('{{ $lpg->id }}', '{{ $lpg->produk }}' , '{{ $lpg->kabupaten_kota }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                    data-id="{{ $lpg->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <form action="/hapus_lpg/{{ $lpg->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPenjualanLPG('{{ $lpg->id }}' )"
                                                                    data-bs-target="#lihatPenjualanLPG"
                                                                    data-id="{{ $lpg->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @elseif($lpg->status == '1')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPenjualanLPG('{{ $lpg->id }}' )"
                                                                    data-bs-target="#lihatPenjualanLPG"
                                                                    data-id="{{ $lpg->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @elseif($lpg->status == '2')
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPenjualan"
                                                                    id="editCompany"
                                                                    onclick="edit_harga('{{ $lpg->id }}', '{{ $lpg->produk }}' , '{{ $lpg->kabupaten_kota }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                    data-id="{{ $lpg->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPenjualanLPG('{{ $lpg->id }}' )"
                                                                    data-bs-target="#lihatPenjualanLPG"
                                                                    data-id="{{ $lpg->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @endif

                                                        <center>
                                                            @if ($lpg->status == 1 && $lpg->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($lpg->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($lpg->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $lpg->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center>
                                                    </td>
                                                    <td>{{ $lpg->provinsi }}</td>
                                                    <td>{{ $lpg->kabupaten_kota }}</td>
                                                    <td>{{ $lpg->sektor }}</td>
                                                    <td>{{ $lpg->kemasan }}</td>
                                                    <td>{{ $lpg->volume }}</td>
                                                    <td>{{ $lpg->satuan }}</td>

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
            {{-- pasokan --}}
            @if ($statuspasok_lpgx != '' and $lpgx == 'pasok')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Pasokan LPG</h5>
                                    <div>
                                        <a href="javascript:history.back()"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        <form action="/submit_bulan_pasokan_lpg/{{ $bulan_ambil_pasok_lpgx . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))"
                                                {{ $statuspasok_lpgx == 1 ? 'disabled' : '' }}>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_lpgx }}');"
                                            data-bs-toggle="modal" data-bs-target="#inputPasokanLPG"
                                            {{ $statuspasok_lpgx == 1 || $statuspasok_lpgx == 2 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_pasok_lpgx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambil_pasok_lpgx }}');" data-bs-toggle="modal"
                                            data-bs-target="#excelPasokanLPG"
                                            {{ $statuspasok_lpgx == 1 || $statuspasok_lpgx == 2 ? 'disabled' : '' }}>Import
                                            Excel</button>
                                        @include('badan_usaha.niaga.lpg.modal')
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
                                                <th>Nama Pemasok</th>
                                                <th>Kategori Pemasok</th>
                                                <th>Volume</th>
                                                <th>Aksi</th>
                                                <th>Satuan</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pasokan as $pasokan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($pasokan->bulan) }}</td>
                                                    <td>{{ getTahun($pasokan->bulan) }}</td>
                                                    <td>
                                                        @if ($pasokan->status == 1 && $pasokan->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($pasokan->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($pasokan->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($pasokan->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $pasokan->catatan }}</td>
                                                    <td>{{ $pasokan->nama_pemasok }}</td>
                                                    <td>{{ $pasokan->kategori_pemasok }}</td>
                                                    <td>{{ $pasokan->volume }}</td>
                                                    <td>
                                                        @if ($pasokan->status == '0' || $pasokan->status == '' || $pasokan->status == '-')
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPasokan"
                                                                    id="editpasokan"
                                                                    onclick="editPasokanLPG('{{ $pasokan->id }}')"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editPasokanLPG"
                                                                    data-id="{{ $pasokan->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <form action="/hapus_pasokanLPG/{{ $pasokan->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPasokanLPG('{{ $pasokan->id }}' )"
                                                                    data-bs-target="#lihatPasokanLPG"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>

                                                            </center>
                                                        @elseif($pasokan->status == '1')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPasokanLPG('{{ $pasokan->id }}' )"
                                                                    data-bs-target="#lihatPasokanLPG"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @elseif($pasokan->status == '2')
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPasokan"
                                                                    id="editpasokan"
                                                                    onclick="editPasokanLPG('{{ $pasokan->id }}')"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editPasokanLPG"
                                                                    data-id="{{ $pasokan->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPasokanLPG('{{ $pasokan->id }}' )"
                                                                    data-bs-target="#lihatPasokanLPG"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @endif

                                                        <center>
                                                            @if ($pasokan->status == 1 && $pasokan->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($pasokan->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($pasokan->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $pasokan->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center>
                                                    </td>
                                                    <td>{{ $pasokan->satuan }}</td>

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
    </div>
@endsection
