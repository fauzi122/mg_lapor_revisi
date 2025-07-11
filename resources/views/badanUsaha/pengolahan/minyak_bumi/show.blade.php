@extends('layouts.main.master')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Laporan Pengolahan Minyak Bumi/Hasil Olahan</h3>
                    @php
                        $id = Crypt::encryptString($pecah[0] . ',' . $pecah[1] . ',' . $pecah[2]. ',' . $pecah[3]);
                    @endphp
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

            {{-- Pengolahan Minyak Bumi Produksi Kilang --}}
            @if ($status_produksix != '' and $jenis == 'produksi')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Produksi Kilang</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form
                                                action="{{ url('/submit_bulan_pengolahan_minyak_bumi_produksi') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $status_produksix == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_produksix }}' );"
                                                data-bs-toggle="modal" data-bs-target="#buat-pengolahan-produksi-mb"
                                                {{ $status_produksix != 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_produksix) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_produksix }}' )" data-bs-toggle="modal"
                                                data-bs-target="#excelPengolahanMBProduksi"
                                                {{ $status_produksix != 0 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title" value="Laporan Produksi Kilang" />
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
                                                    <th>Volume</th>
                                                    <th>Satuan</th>
                                                    <th>Keterangan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengolahanProduksiMB as $ppmb)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ getBulan($ppmb->bulan) }}</td>
                                                        <td>{{ getTahun($ppmb->bulan) }}</td>
                                                        <td>
                                                            @if ($ppmb->status == 1 && $ppmb->catatan)
                                                                <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppmb->status == 1)
                                                                <span class="badge badge-success">Diterima</span>
                                                            @elseif ($ppmb->status == 2)
                                                                <span class="badge badge-danger">Revisi</span>
                                                            @elseif ($ppmb->status == 0)
                                                                <span class="badge badge-info">Draf</span>
                                                            @elseif($ppmb->status == 3)
                                                                <span class="badge badge-primary">Selesai</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $ppmb->catatan }}</td>
                                                        <td>{{ $ppmb->produk }}</td>
                                                        <td>{{ $ppmb->provinsi }}</td>
                                                        <td>{{ $ppmb->kabupaten_kota }}</td>
                                                        <td>{{ $ppmb->volume }}</td>
                                                        <td>{{ $ppmb->satuan }}</td>
                                                        <td>{{ $ppmb->keterangan }}</td>
                                                        <td class="text-center">
                                                            @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-produksi-mb mb-2"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-produksi-mb"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pengolahan_minyak_bumi_produksi') }}/{{ $ppmb->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger mb-2"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif($ppmb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-produksi-mb mb-2"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-produksi-mb"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-produksi-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
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

            {{-- Pengolahan Minyak Bumi Pasokan Kilang --}}
            @if ($status_pasokanx != '' and $jenis == 'pasokan')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Pasokan Kilang</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form
                                                action="{{ url('/submit_bulan_pengolahan_minyak_bumi_pasokan') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $status_pasokanx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="intake_kilang(); provinsi(); tambahPMB('{{ $bulan_ambil_pasokanx }}' );"
                                                data-bs-toggle="modal" data-bs-target="#buat-pengolahan-pasokan-mb"
                                                {{ $status_pasokanx != 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasokanx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasokanx }}' );"
                                                data-bs-toggle="modal" data-bs-target="#excelPengolahanMBPasokan"
                                                {{ $status_pasokanx != 0 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title" value="Laporan Pasokan Kilang" />
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
                                                    <th>Kategori Pemasok</th>
                                                    <th>Intake Kilang</th>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten/Kota</th>
                                                    <th>Volume</th>
                                                    <th>Satuan</th>
                                                    <th>Keterangan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengolahanPasokanMB as $ppmb)
                                                    @php
                                                        $kabKota = json_decode($ppmb->kabupaten_kota);
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ getBulan($ppmb->bulan) }}</td>
                                                        <td>{{ getTahun($ppmb->bulan) }}</td>
                                                        <td>
                                                            @if ($ppmb->status == 1 && $ppmb->catatan)
                                                                <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppmb->status == 1)
                                                                <span class="badge badge-success">Diterima</span>
                                                            @elseif ($ppmb->status == 2)
                                                                <span class="badge badge-danger">Revisi</span>
                                                            @elseif ($ppmb->status == 0)
                                                                <span class="badge badge-info">Draf</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $ppmb->catatan }}</td>
                                                        <td>{{ $ppmb->kategori_pemasok }}</td>
                                                        <td>{{ $ppmb->intake_kilang }}</td>
                                                        <td>{{ $ppmb->provinsi }}</td>
                                                        <td>{{ $ppmb->kabupaten_kota }}</td>
                                                        <td>{{ $ppmb->volume }}</td>
                                                        <td>{{ $ppmb->satuan }}</td>
                                                        <td>{{ $ppmb->keterangan }}</td>
                                                        <td class="text-center">
                                                            @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-pasokan-mb mb-2"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->intake_kilang }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-pasokan-mb"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pengolahan_minyak_bumi_pasokan') }}/{{ $ppmb->id }}"
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
                                                            @elseif($ppmb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-pasokan-mb mb-2"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->intake_kilang }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-pasokan-mb"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-pasokan-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
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

            {{-- Pengolahan Minyak Bumi Distribusi Kilang --}}
            @if ($status_distribusix != '' and $jenis == 'distribusi')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Distribusi/Penjualan Domestik Kilang</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form
                                                action="{{ url('/submit_bulan_pengolahan_minyak_bumi_distribusi') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $status_distribusix == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_distribusix }}' ); sektor();"
                                                data-bs-toggle="modal" data-bs-target="#buat-pengolahan-distribusi-mb"
                                                {{ $status_distribusix != 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_distribusix) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_distribusix }}' );"
                                                data-bs-toggle="modal" data-bs-target="#excelPengolahanMBDistribusi"
                                                {{ $status_distribusix != 0 ? 'disabled' : '' }}>
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
                                                value="Laporan Distribusi/Penjualan Domestik Kilang" />
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
                                                    <th>Nama</th>
                                                    <th>Nama Badan Usaha</th>
                                                    <th>Volume</th>
                                                    <th>Satuan</th>
                                                    <th>Keterangan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengolahanDistribusiMB as $ppmb)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ getBulan($ppmb->bulan) }}</td>
                                                        <td>{{ getTahun($ppmb->bulan) }}</td>
                                                        <td>
                                                            @if ($ppmb->status == 1 && $ppmb->catatan)
                                                                <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                            @elseif ($ppmb->status == 1)
                                                                <span class="badge badge-success">Diterima</span>
                                                            @elseif ($ppmb->status == 2)
                                                                <span class="badge badge-danger">Revisi</span>
                                                            @elseif ($ppmb->status == 0)
                                                                <span class="badge badge-info">Draf</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $ppmb->catatan }}</td>
                                                        <td>{{ $ppmb->produk }}</td>
                                                        <td>{{ $ppmb->provinsi }}</td>
                                                        <td>{{ $ppmb->kabupaten_kota }}</td>
                                                        <td>{{ $ppmb->sektor }}</td>
                                                        <td>{{ $ppmb->nama }}</td>
                                                        <td>{{ $ppmb->nama_bu_niaga }}</td>
                                                        <td>{{ $ppmb->volume }}</td>
                                                        <td>{{ $ppmb->satuan }}</td>
                                                        <td>{{ $ppmb->keterangan }}</td>
                                                        <td class="text-center">
                                                            @if ($ppmb->status == '0' || $ppmb->status == '' || $ppmb->status == '-')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-distribusi-mb mb-2"
                                                                    onclick="sektor(); editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' );"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-distribusi-mb"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapus_pengolahan_minyak_bumi_distribusi') }}/{{ $ppmb->id }}"
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
                                                            @elseif($ppmb->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info edit-pengolahan-distribusi-mb mb-2"
                                                                    onclick="editPengolahan('{{ $ppmb->id }}', '{{ $ppmb->produk }}', '{{ $ppmb->kabupaten_kota }}', '{{ $ppmb->status }}' )"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit-pengolahan-distribusi-mb"
                                                                    data-id="{{ $ppmb->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppmb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-distribusi-mb"
                                                                data-id="{{ $ppmb->id }}">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
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

    @include('badanUsaha.pengolahan.minyak_bumi.modal')

@endsection
