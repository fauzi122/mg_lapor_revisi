@extends('layouts.main.master')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Laporan Harga</h3>
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
            {{-- Harga BBM JBU/Hasil Olahan/Minyak Bumi --}}
            @if ($statushargabbmjbux != '' and $hargax == 'bbmjbu')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Harga BBM JBU/Hasil Olahan/Minyak Bumi</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                            // $decrypted = explode(',', Crypt::decryptString($id));
                                        @endphp
                                        {{-- <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <div><strong>ID Permohonan:</strong> {{ $decrypted[0] }}</div>
                                            <div><strong>NPWP:</strong> {{ $decrypted[1] }}</div>
                                            <div><strong>ID Sub Page:</strong> {{ $decrypted[2] }}</div>
                                            <div><strong>Bulan:</strong> {{ $decrypted[3] }}</div>
                                        </div> --}}
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submit_bulan_harga-bbm-jbu') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statushargabbmjbux == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk('BBM'); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_hargabbmjbux }}');"
                                                data-bs-toggle="modal" data-bs-target="#input_HargaBBM"
                                                {{ $statushargabbmjbux == 1 || $statushargabbmjbux == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_hargabbmjbux) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_hargabbmjbux }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excelhbjbu"
                                                {{ $statushargabbmjbux == 1 || $statushargabbmjbux == 2 ? 'disabled' : '' }}>
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
                                                value="Laporan Harga BBM JBU/Hasil Olahan/Minyak Bumi" />
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <table class="kt-datatable table table-bordered table-hover">
                                            <thead class="bg-light align-top" style="white-space: nowrap;">
                                                <tr class="fw-bold">
                                                    <th class="text-center">No</th>
                                                    <th>Bulan</th>
                                                    <th>Tahun</th>
                                                    <th>Sektor</th>
                                                    <th>Produk</th>
                                                    <th>Provinsi</th>
                                                    <th>Komponen Harga (Rp/KL)</th>
                                                    <th>Volume (KL)</th>
                                                    <th>Harga Jual (Rp/KL)</th>
                                                    <th>Formula</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Catatan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($hargabbmjbu as $hargabbmjbu)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ getBulan($hargabbmjbu->bulan) }}</td>
                                                        <td>{{ getTahun($hargabbmjbu->bulan) }}</td>
                                                        <td>{{ $hargabbmjbu->sektor }}</td>
                                                        <td>{{ $hargabbmjbu->produk }}</td>
                                                        <td>{{ $hargabbmjbu->provinsi }}</td>
                                                        <td>
                                                            <h6>Biaya Perolehan : <span
                                                                    class="text-info">{{ $hargabbmjbu->biaya_perolehan }}</span>
                                                            </h6>
                                                            <h6>Biaya Distribusi : <span
                                                                    class="text-info">{{ $hargabbmjbu->biaya_distribusi }}</span>
                                                            </h6>
                                                            <h6>Biaya Penyimpanan : <span
                                                                    class="text-info">{{ $hargabbmjbu->biaya_penyimpanan }}</span>
                                                            </h6>
                                                            <h6>Margin : <span
                                                                    class="text-info">{{ $hargabbmjbu->margin }}</span>
                                                            </h6>
                                                            <h6>PPN : <span
                                                                    class="text-info">{{ $hargabbmjbu->ppn }}</span></h6>
                                                            <h6>PBBKP : <span
                                                                    class="text-info">{{ $hargabbmjbu->pbbkp }}</span></h6>
                                                        </td>
                                                        <td>{{ $hargabbmjbu->volume }}</td>
                                                        <td>{{ $hargabbmjbu->harga_jual }}</td>
                                                        <td>{{ $hargabbmjbu->formula_harga }}</td>
                                                        <td>{{ $hargabbmjbu->keterangan }}</td>
                                                        <td>
                                                            @if ($hargabbmjbu->status == 1 && $hargabbmjbu->catatan)
                                                                <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                            @elseif ($hargabbmjbu->status == 1)
                                                                <span class="badge badge-success">Diterima</span>
                                                            @elseif ($hargabbmjbu->status == 2)
                                                                <span class="badge badge-danger">Revisi</span>
                                                            @elseif ($hargabbmjbu->status == 0)
                                                                <span class="badge badge-info">draf</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $hargabbmjbu->catatan }}</td>

                                                        <td class="text-center">
                                                            @if ($hargabbmjbu->status == '0' || $hargabbmjbu->status == '-' || $hargabbmjbu->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_hargabbmx('{{ $hargabbmjbu->id }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-hargabbm"
                                                                    data-id="{{ $hargabbmjbu->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/harga-bbm-jbu') }}/{{ $hargabbmjbu->id }}"
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
                                                                    action="{{ url('/submit_harga-bbm-jbu') }}/{{ $hargabbmjbu->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-info mb-2"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-send" title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif($hargabbmjbu->status == '1')
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatHargaBBM('{{ $hargabbmjbu->id }}')"
                                                                    data-bs-target="#lihat-harga-bbm"
                                                                    data-id="{{ $hargabbmjbu->id }}">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($hargabbmjbu->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_hargabbmx('{{ $hargabbmjbu->id }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-hargabbm"
                                                                    data-id="{{ $hargabbmjbu->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submit_harga-bbm-jbu') }}/{{ $hargabbmjbu->id }}"
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
            {{-- Harga LPG --}}
            @if ($statushargalpgx != '' and $hargax == 'hargalpg')
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-5 mb-xl-8 shadow">
                            <div class="card-header bg-light p-5">
                                <div class="row w-100">
                                    <div class="col-lg-6">
                                        <h5>Harga LPG</h5>
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ url('/submitbulanHargaLPG') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))"
                                                    {{ $statushargalpgx == 1 ? 'disabled' : '' }}>
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_hargalpgx }}');"
                                                data-bs-toggle="modal" data-bs-target="#inputHargaLPG"
                                                {{ $statushargalpgx == 1 || $statushargalpgx == 2 ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i> Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_hargalpgx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambil_hargalpgx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excelHargaLPG"
                                                {{ $statushargalpgx == 1 || $statushargalpgx == 2 ? 'disabled' : '' }}>
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
                                            <input type="hidden" class="export-title" value="Laporan Harga LPG" />
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <table class="kt-datatable table table-bordered table-hover">
                                            <thead class="bg-light align-top" style="white-space: nowrap;">
                                                <tr class="fw-bold">
                                                    <th class="text-center">No</th>
                                                    <th>Bulan</th>
                                                    <th>Sektor</th>
                                                    <th>Provinsi</th>
                                                    <th>Komponen Harga</th>
                                                    <th>Kabupaten / Kota</th>
                                                    <th>Volume</th>
                                                    <th>Harga Jual</th>
                                                    <th>Formula</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($hargalpg as $hargaLPG)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ dateIndonesia($hargaLPG->bulan) }}</td>
                                                        <td>{{ $hargaLPG->sektor }}</td>
                                                        <td>{{ $hargaLPG->provinsi }}</td>
                                                        <td>
                                                            <h6>Biaya Perolehan : <span
                                                                    class="text-info">{{ $hargaLPG->biaya_perolehan }}</span>
                                                            </h6>
                                                            <h6>Biaya Penyimpanan : <span
                                                                    class="text-info">{{ $hargaLPG->biaya_penyimpanan }}</span>
                                                            </h6>
                                                            <h6>Biaya Distribusi : <span
                                                                    class="text-info">{{ $hargaLPG->biaya_distribusi }}</span>
                                                            </h6>
                                                            <h6>Margin : <span
                                                                    class="text-info">{{ $hargaLPG->margin }}</span></h6>
                                                            <h6>PPN : <span class="text-info">{{ $hargaLPG->ppn }}</span>
                                                            </h6>
                                                        </td>
                                                        <td>{{ $hargaLPG->kabupaten_kota }}</td>
                                                        <td>{{ $hargaLPG->volume }}</td>
                                                        <td>{{ $hargaLPG->harga_jual }}</td>
                                                        <td>{{ $hargaLPG->formula_harga }}</td>
                                                        <td>{{ $hargaLPG->keterangan }}</td>
                                                        <td>
                                                            @if ($hargaLPG->status == 1 && $hargaLPG->catatan)
                                                                <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                            @elseif ($hargaLPG->status == 1)
                                                                <span class="badge badge-success">Diterima</span>
                                                            @elseif ($hargaLPG->status == 2)
                                                                <span class="badge badge-danger">Revisi</span>
                                                            @elseif ($hargaLPG->status == 0)
                                                                <span class="badge badge-info">draf</span>
                                                            @endif
                                                            {{ $hargaLPG->catatan }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($hargaLPG->status == '0' || $hargaLPG->status == '-' || $hargaLPG->status == '')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_hargaLPG('{{ $hargaLPG->id }}', '{{ $hargaLPG->kabupaten_kota }}'); tambahPMB('{{ $bulan_ambil_hargalpgx }}');"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#editHargaLPG"
                                                                    data-id="{{ $hargaLPG->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/hapusHargaLPG') }}/{{ $hargaLPG->id }}"
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
                                                                    action="{{ url('/submitHargaLPG') }}/{{ $hargaLPG->id }}"
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
                                                            @elseif($hargaLPG->status == '1')
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    id="" data-bs-toggle="modal"
                                                                    onclick="lihatHargaLPG('{{ $hargaLPG->id }}')"
                                                                    data-bs-target="#lihat-harga-lpg"
                                                                    data-id="{{ $hargaLPG->id }}">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            @elseif($hargaLPG->status == '2')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga mb-2"
                                                                    onclick="edit_hargaLPG('{{ $hargaLPG->id }}', '{{ $hargaLPG->kabupaten_kota }}'); tambahPMB('{{ $bulan_ambil_hargalpgx }}');"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#editHargaLPG"
                                                                    data-id="{{ $hargaLPG->id }}">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form
                                                                    action="{{ url('/submitHargaLPG') }}/{{ $hargaLPG->id }}"
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

    @include('badanUsaha.niaga.harga.modal')

@endsection
