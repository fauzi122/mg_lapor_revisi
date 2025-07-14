@extends('layouts.main.master')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Laporan Hasil Olahan/Minyak Bumi</h3>
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
            {{-- Penjualan data --}}
            @if ($statuspenjualan_hasilolahx != '' and $hasilolahx == 'penjualan')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Penjualan Hasil Olahan/Minyak Bumi</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submit_bulan_jholb') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statuspenjualan_hasilolahx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_hasilolahx }}');"
                                                data-bs-toggle="modal" data-bs-target="#myModal"
                                                {{ $statuspenjualan_hasilolahx == 1 || $statuspenjualan_hasilolahx == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_hasilolahx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_hasilolahx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excelpho"
                                                {{ $statuspenjualan_hasilolahx == 1 || $statuspenjualan_hasilolahx == 2 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title" value="Laporan Penjualan data" />
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <table class="kt-datatable table table-bordered table-hover">
                                            <thead class="bg-light align-top" style="white-space: nowrap;">
                                                <tr class="fw-bold">
                                                    <th class="text-center">No</th>
                                                    <th>No</th>
                                                    <th>Bulan</th>
                                                    <th>Status</th>
                                                    <th>Catatan</th>
                                                    <th>Produk</th>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten/Kota</th>
                                                    <th>Sektor</th>
                                                    <th>Volume</th>
                                                    <th>Satuan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($show_jholbx as $data)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ getBulan($data->bulan) }}</td>
                                                        <td>{{ getTahun($data->bulan) }}</td>
                                                        <td>
                                                            @if ($data->status == 1 && $data->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($data->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($data->status == 2)
                                                                <span class="badge bg-danger">Revisi</span>
                                                            @elseif ($data->status == 0)
                                                                <span class="badge bg-info">draf</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $data->catatan }}</td>
                                                        <td>{{ $data->produk }}</td>
                                                        <td>{{ $data->provinsi }}</td>
                                                        <td>{{ $data->kabupaten_kota }}</td>
                                                        <td>{{ $data->sektor }}</td>
                                                        <td>{{ $data->volume }}</td>
                                                        <td>{{ $data->satuan }}</td>

                                                        <td class="text-center">
                                                            @if ($data->status == '0' || $data->status == '-' || $data->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPenjualan"
                                                                    id="editCompany"
                                                                    onclick="editPenjualan('{{ $data->id }}', '{{ $data->produk }}' , '{{ $data->kabupaten_kota }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                    data-id="{{ $data->id }}"> <i
                                                                        class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form action="/hapus_jholb/{{ $data->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihat_jholb('{{ $data->id }}', '{{ $data->produk }}' , '{{ $data->kabupaten_kota }}')"
                                                                    data-bs-target="#lihat-penjualan"
                                                                    data-id="{{ $data->id }}"> <i
                                                                        class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($data->status == '1')
                                                                <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihat_jholb('{{ $data->id }}', '{{ $data->produk }}' , '{{ $data->kabupaten_kota }}')"
                                                                    data-bs-target="#lihat-penjualan"
                                                                    data-id="{{ $data->id }}"> <i
                                                                        class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($data->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPenjualan"
                                                                    id="editCompany"
                                                                    onclick="editPenjualan('{{ $data->id }}', '{{ $data->produk }}' , '{{ $data->kabupaten_kota }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                    data-id="{{ $data->id }}"> <i
                                                                        class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submit_jholb') }}/{{ $data->id }}"
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

                                                            <br>
                                                            @if ($data->status == 1 && $data->catatan)
                                                                <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                            @elseif ($data->status == 1)
                                                                <span class="badge badge-success">Diterima</span>
                                                            @elseif ($data->status == 2)
                                                                <span class="badge badge-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $data->id }}">
                                                                    Cek Revisi
                                                                </span>
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
            {{-- Pasokan data --}}
            @if ($statuspasok_hsilolahx != '' and $hasilolahx == 'pasok')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Pasokan Hasil Olahan/Minyak Bumi</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submit_bulan_pasokan-olah') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statuspasok_hsilolahx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_pasok_hasilolahx }}');"
                                                data-bs-toggle="modal" data-bs-target="#inputpho"
                                                {{ $statuspasok_hsilolahx == 1 || $statuspasok_hsilolahx == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_hasilolahx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_hasilolahx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excelpholb"
                                                {{ $statuspasok_hsilolahx == 1 || $statuspasok_hsilolahx == 2 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title" value="Laporan Pasokan data" />
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
                                                        <td class="text-center">
                                                            @if ($pasokan->status == '0' || $pasokan->status == '-' || $pasokan->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPasokan mb-2"
                                                                    onclick="editPasokan('{{ $pasokan->id }}', '{{ $pasokan->produk }}' , '{{ $pasokan->kabupaten_kota }}')"
                                                                    id="editpasokan" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pasokan"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/pasokan-olah') }}/{{ $pasokan->id }}"
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
                                                                <form {{-- action="{{ url('/submit_pasokan-olah') }}/{{ $pasokan->id }}" --}} method="post"
                                                                    class="d-inline">
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
                                                                    onclick="lihatPasokan('{{ $pasokan->id }}', '{{ $pasokan->produk }}' , '{{ $pasokan->kabupaten_kota }}')"
                                                                    data-bs-target="#lihat-pasokan-olah"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($pasokan->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editPasokan mb-2"
                                                                    onclick="editPasokan('{{ $pasokan->id }}', '{{ $pasokan->produk }}' , '{{ $pasokan->kabupaten_kota }}')"
                                                                    id="editpasokan" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pasokan"
                                                                    data-id="{{ $pasokan->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submit_pasokan-olah') }}/{{ $pasokan->id }}"
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

                                                            <br>
                                                            @if ($pasokan->status == 1 && $pasokan->catatan)
                                                                <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                            @elseif ($pasokan->status == 1)
                                                                <span class="badge badge-success">Diterima</span>
                                                            @elseif ($pasokan->status == 2)
                                                                <span class="badge badge-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $pasokan->id }}">
                                                                    Cek Revisi
                                                                </span>
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

    @include('badan_usaha.niaga.hasil_olahan.modal')

@endsection
