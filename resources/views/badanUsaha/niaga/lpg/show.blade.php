@extends('layouts.main.master')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Laporan LPG</h3>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="javascript:history.back()" type="button" class="btn btn-sm btn-secondary">
                        <i class="ki-duotone ki-left-square">
                            <span class="path1"></span><span class="path2"></span>
                        </i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
        <div id="kt_app_content_container" class="app-container container-xxl">
            {{-- Penjualan LPG --}}
            @if ($statuspenjualan_lpgx != '' and $lpgx == 'penjualan')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Penjualan LPG</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submit_bulan_penjualan_lpg') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statuspenjualan_lpgx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lpgx }}');"
                                                data-bs-toggle="modal" data-bs-target="#input_jualLPG"
                                                {{ $statuspenjualan_lpgx == 1 || $statuspenjualan_lpgx == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lpgx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lpgx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excel_jualLPG"
                                                {{ $statuspenjualan_lpgx == 1 || $statuspenjualan_lpgx == 2 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title" value="Laporan Penjualan LPG" />
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
                                                    <th>Catatan</th>
                                                    <th>Produk</th>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten/Kota</th>
                                                    <th>Sektor</th>
                                                    <th>Kemasan</th>
                                                    <th>Volume</th>
                                                    <th>Satuan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lpgs as $lpg)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
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
                                                        <td>{{ $lpg->provinsi }}</td>
                                                        <td>{{ $lpg->kabupaten_kota }}</td>
                                                        <td>{{ $lpg->sektor }}</td>
                                                        <td>{{ $lpg->kemasan }}</td>
                                                        <td>{{ $lpg->volume }}</td>
                                                        <td>{{ $lpg->satuan }}</td>

                                                        <td class="text-center">
                                                            @if ($lpg->status == '0' || $lpg->status == '-' || $lpg->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPenjualan mb-2"
                                                                    onclick="edit_harga('{{ $lpg->id }}', '{{ $lpg->produk }}' , '{{ $lpg->kabupaten_kota }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_jualLPG"
                                                                    data-id="{{ $lpg->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form action="{{ url('/hapus_lpg') }}/{{ $lpg->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger mb-2"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ url('/submit_penjualan_lpg') }}/{{ $lpg->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-info mb-2"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif($lpg->status == '1')
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPenjualanLPG('{{ $lpg->id }}' )"
                                                                    data-bs-target="#lihat-jualLPG"
                                                                    data-id="{{ $lpg->id }}">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($lpg->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_harga('{{ $lpg->id }}', '{{ $lpg->produk }}' , '{{ $lpg->kabupaten_kota }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_jualLPG"
                                                                    data-id="{{ $lpg->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submit_penjualan_lpg') }}/{{ $lpg->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-info mb-2"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-send"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form>
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
            @endif
            {{-- Pasokan LPG --}}
            @if ($statuspasok_lpgx != '' and $lpgx == 'pasok')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Pasokan LPG</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submit_bulan_pasokan_lpg') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statuspasok_lpgx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_pasok_lpgx }}');"
                                                data-bs-toggle="modal" data-bs-target="#input_pasokanLPG"
                                                {{ $statuspasok_lpgx == 1 || $statuspasok_lpgx == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lpgx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lpgx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excel_pasokanLPG"
                                                {{ $statuspasok_lpgx == 1 || $statuspasok_lpgx == 2 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title" value="Laporan Pasokan LPG" />
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
                                                    <th>Catatan</th>
                                                    <th>Nama Pemasok</th>
                                                    <th>Kategori Pemasok</th>
                                                    <th>Volume</th>
                                                    <th>Satuan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pasokan as $pasokan)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        {{-- <td>{{ dateIndonesia($pasokan->bulan) }}</td> --}}

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
                                                        <td>{{ $pasokan->satuan }}</td>
                                                        <td class="text-center">
                                                            @if ($pasokan->status == '0' || $pasokan->status == '-' || $pasokan->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="editPasokanLPG('{{ $pasokan->id }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_pasokanLPG"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pasokanLPG') }}/{{ $pasokan->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger mb-2"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-trash"
                                                                            title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ url('/submit_pasokan_lpg') }}/{{ $pasokan->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-info mb-2"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-send"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif($pasokan->status == '1')
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatPasokanLPG('{{ $pasokan->id }}' )"
                                                                    data-bs-target="#lihat-pasokanLPG"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($pasokan->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPasokan mb-2"
                                                                    onclick="editPasokanLPG('{{ $pasokan->id }}')"
                                                                    id="editpasokan" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_pasokanLPG"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submit_pasokan_lpg') }}/{{ $pasokan->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-info mb-2"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-send"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form>
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
            @endif
        </div>
    </div>

    @include('badanUsaha.niaga.lpg.modal')

@endsection
