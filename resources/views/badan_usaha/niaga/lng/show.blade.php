@extends('layouts.main.master')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Laporan LNG/CNG/BNG</h3>
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
            {{-- Penjualan LNG --}}
            @if ($statuspenjualan_lngx != '' and $lngx == 'penjualan')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Penjualan LNG/CNG/BNG</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submit_bulan_lng') }}/{{ $id }}" method="post"
                                                class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statuspenjualan_lngx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lngx }}');"
                                                data-bs-toggle="modal" data-bs-target="#input_jualLNG"
                                                {{ $statuspenjualan_lngx == 1 || $statuspenjualan_lngx == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lngx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excel_jualLNG"
                                                {{ $statuspenjualan_lngx == 1 || $statuspenjualan_lngx == 2 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title"
                                                value="Laporan Penjualan LNG/CNG/BBG" />
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
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten/Kota</th>
                                                    <th>Produk</th>
                                                    <th>Konsumen</th>
                                                    <th>Sektor</th>
                                                    <th>Volume</th>
                                                    <th>Satuan (MMBTU)</th>
                                                    <th>Biaya Kompresi/Regasifikasi (USD/MMBTU)</th>
                                                    <th>Biaya Penyimpanan (USD/MMBTU)</th>
                                                    <th>Biaya Pengangkutan (USD/MMBTU)</th>
                                                    <th>Biaya Niaga (USD/MMBTU)</th>
                                                    <th>Harga Bahan Baku (USD/MMBTU)</th>
                                                    <th>Pajak</th>
                                                    <th>Harga Jual (USD/MMBTU)</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lng as $lng)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ getBulan($lng->bulan) }}</td>
                                                        <td>{{ getTahun($lng->bulan) }}</td>
                                                        <td>
                                                            @if ($lng->status == 1 && $lng->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($lng->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
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
                                                        <td>{{ $lng->konsumen }}</td>
                                                        <td>{{ $lng->sektor }}</td>
                                                        <td>{{ $lng->volume }}</td>
                                                        <td>{{ $lng->satuan }}</td>
                                                        <td>{{ $lng->satuan_biaya_kompresi }} {{ $lng->biaya_kompresi }}
                                                        </td>
                                                        <td>{{ $lng->satuan_biaya_penyimpanan }}
                                                            {{ $lng->biaya_penyimpanan }}
                                                        </td>
                                                        <td>{{ $lng->satuan_biaya_pengangkutan }}
                                                            {{ $lng->biaya_pengangkutan }}</td>
                                                        <td>{{ $lng->satuan_biaya_niaga }} {{ $lng->biaya_niaga }}</td>
                                                        <td>{{ $lng->satuan_harga_bahan_baku }}
                                                            {{ $lng->harga_bahan_baku }}
                                                        </td>
                                                        <td>{{ $lng->satuan_pajak }} {{ $lng->pajak }}</td>
                                                        <td>{{ $lng->satuan_harga_jual }} {{ $lng->harga_jual }}</td>

                                                        <td class="text-center">
                                                            @if ($lng->status == '0' || $lng->status == '-' || $lng->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPenjualan mb-2"
                                                                    onclick="edit_penjualan_lng('{{ $lng->id }}', '{{ $lng->produk }}' , '{{ $lng->kabupaten_kota }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_jualLNG"
                                                                    data-id="{{ $lng->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form action="{{ url('/hapus_lng') }}/{{ $lng->id }}"
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
                                                                    action="{{ url('/submit_lng') }}/{{ $lng->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-info mb-2"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif($lng->status == '1')
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihat_lng('{{ $lng->id }}')"
                                                                    data-bs-target="#lihat_jualLNG"
                                                                    data-id="{{ $lng->id }}">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($lng->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_penjualan_lng('{{ $lng->id }}', '{{ $lng->produk }}' , '{{ $lng->kabupaten_kota }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_jualLNG"
                                                                    data-id="{{ $lng->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submit_lng') }}/{{ $lng->id }}"
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
            {{-- Pasokan LNG/CNG --}}
            @if ($statuspasok_lngx != '' and $lngx == 'pasok')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Pasokan LNG/CNG/BNG</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submit_bulan_pasok_lng') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statuspasok_lngx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_pasok_lngx }}');"
                                                data-bs-toggle="modal" data-bs-target="#input_pasokanLNG"
                                                {{ $statuspasok_lngx == 1 || $statuspasok_lngx == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lngx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excel_pasokanLNG"
                                                {{ $statuspasok_lngx == 1 || $statuspasok_lngx == 2 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title"
                                                value="Laporan Pasokan LNG/CNG/BNG" />
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
                                                    <th>Nama Pemasok</th>
                                                    <th>Kategori Pemasok</th>
                                                    <th>Volume</th>
                                                    <th>Satuan</th>
                                                    <th>Harga Gas</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pasok_lng as $pasok)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        {{-- <td>{{ dateIndonesia($pasokan->bulan) }}</td> --}}

                                                        <td>{{ getBulan($pasok->bulan) }}</td>
                                                        <td>{{ getTahun($pasok->bulan) }}</td>
                                                        <td>
                                                            @if ($pasok->status == 1 && $pasok->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($pasok->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
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
                                                        <td>{{ $pasok->volume }}</td>
                                                        <td>{{ $pasok->satuan }}</td>
                                                        <td>{{ $pasok->satuan_harga_gas }} {{ $pasok->harga_gas }}</td>
                                                        <td class="text-center">
                                                            @if ($pasok->status == '0' || $pasok->status == '-' || $pasok->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_pasokan_lng('{{ $pasok->id }}', '{{ $pasok->produk }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_pasokanLNG"
                                                                    data-id="{{ $pasok->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pasok_lng') }}/{{ $pasok->id }}"
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
                                                                    action="{{ url('/submit_pasok_lng') }}/{{ $pasok->id }}"
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
                                                            @elseif($pasok->status == '1')
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihat_pasok_lng('{{ $pasok->id }}')"
                                                                    data-bs-target="#lihat_pasokanLNG"
                                                                    data-id="{{ $pasok->id }}">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($pasok->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_pasokan_lng('{{ $pasok->id }}', '{{ $pasok->produk }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit_pasokanLNG"
                                                                    data-id="{{ $pasok->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submit_pasok_lng') }}/{{ $pasok->id }}"
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

    @include('badan_usaha.niaga.lng.modal')

@endsection
