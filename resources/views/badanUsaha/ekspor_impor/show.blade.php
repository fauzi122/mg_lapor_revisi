@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Laporan Ekspor Impor</h3>
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
        {{-- ekspor --}}
        @if ($statusbulan_ambil_eksporsx != '' and $eixx == 'ekspor')
            <div class="row">
                <div class="col-12">
                    <div class="card mb-5 mb-xl-8 shadow">
                        <div class="card-header bg-light p-5">
                            <div class="row w-100">
                                <div class="col-lg-6">
                                    <h5>Ekspor</h5>
                                    @php
                                        $id = Crypt::encryptString($pecah[0] . ',' . $pecah[1] . ',' . $pecah[2]);
                                    @endphp
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if ($statusbulan_ambil_eksporsx == 1)
                                            <button type="button" class="btn btn-sm btn-info" disabled>
                                                <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambil_eksporsx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @elseif ($statusbulan_ambil_eksporsx == 2)
                                            <form action="{{ url('/submit_bulan_export') }}/{{ $id }}" method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info" onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambil_eksporsx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @else
                                            <form action="{{ url('/submit_bulan_export') }}/{{ $id }}" method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info" onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi(); negara();"
                                                data-bs-toggle="modal" data-bs-target="#myModal">
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambil_eksporsx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" onclick="tambahPMB('{{ $bulan_ambil_eksporsx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excelexpor">
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="card">
                                <div class="card-header align-items-center px-2">
                                    <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                    <div class="card-title flex-row-fluid justify-content-end gap-5">
                                        <input type="hidden" class="export-title" value="Laporan Ekspor" />
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <table class="kt-datatable table table-bordered table-hover">
                                        <thead class="bg-light align-top" style="white-space: nowrap;">
                                            <tr class="fw-bold">
                                                <th class="text-center">No</th>
                                                <th>Bulan PEB</th>
                                                <th>Tahun PEB</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>HS Code</th>
                                                <th>Volume PEB</th>
                                                <th class="text-center">Aksi</th>
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
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($expor->bulan_peb) }}</td>
                                                    <td>{{ getTahun($expor->bulan_peb) }}</td>
                                                    <td>
                                                        @if ($expor->status == 1 && $expor->catatan)
                                                            <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                        @elseif ($expor->status == 1)
                                                            <span class="badge badge-success">Diterima</span>
                                                        @elseif ($expor->status == 2)
                                                            <span class="badge badge-danger">Revisi</span>
                                                        @elseif ($expor->status == 0)
                                                            <span class="badge badge-info">Draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $expor->catatan }}</td>
                                                    <td>{{ $expor->produk }}</td>
                                                    <td>{{ $expor->hs_code }}</td>
                                                    <td>{{ $expor->volume_peb }}</td>
                                                    <td class="text-center">
                                                        @if ($expor->status == '0')
                                                            <button type="button" class="btn btn-sm btn-info editEkpor mb-2"
                                                                onclick="edit_ekpor('{{ $expor->id }}', '{{ $expor->produk }}', '{{ $expor->negara_tujuan }}')" 
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit">
                                                                <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                            </button>
                                                            <form action="{{ url('/hapus_export') }}/{{ $expor->id }}" method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))">
                                                                    <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                                onclick="lihat_ekspor('{{ $expor->id }}', '{{ $expor->produk }}')" 
                                                                data-bs-target="#lihat-ekspor">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
                                                        @elseif ($expor->status == '1')
                                                            <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                                onclick="lihat_ekspor('{{ $expor->id }}', '{{ $expor->produk }}')" 
                                                                data-bs-target="#lihat-ekspor">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
                                                        @elseif ($expor->status == '2')
                                                            <button type="button" class="btn btn-sm btn-info editEkpor mb-2"
                                                                onclick="edit_ekpor('{{ $expor->id }}', '{{ $expor->produk }}', '{{ $expor->negara_tujuan }}')" 
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit">
                                                                <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                                onclick="lihat_ekspor('{{ $expor->id }}', '{{ $expor->produk }}')" 
                                                                data-bs-target="#lihat-ekspor">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
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
            </div>
        @endif
        {{-- impor --}}
        @if ($statusbulan_ambil_imporsx != '' and $eixx == 'impor')
            <div class="row">
                <div class="col-12">
                    <div class="card mb-5 mb-xl-8 shadow">
                        <div class="card-header bg-light p-5">
                            <div class="row w-100">
                                <div class="col-lg-6">
                                    <h5>Impor</h5>
                                    @php
                                        $id = Crypt::encryptString($pecah[0] . ',' . $pecah[1] . ',' . $pecah[2]);
                                    @endphp
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if ($statusbulan_ambil_imporsx == 1)
                                            <button type="button" class="btn btn-sm btn-info" disabled>
                                                <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambil_imporsx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @elseif ($statusbulan_ambil_imporsx == 2)
                                            <form action="{{ url('/submit_bulan_import') }}/{{ $id }}" method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info" onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambil_imporsx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @else
                                            <form action="{{ url('/submit_bulan_import') }}/{{ $id }}" method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info" onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi(); negara();"
                                                data-bs-toggle="modal" data-bs-target="#inputimpor">
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambil_imporsx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" onclick="tambahPMB('{{ $bulan_ambil_imporsx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excelimport">
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="card">
                                <div class="card-header align-items-center px-2">
                                    <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                    <div class="card-title flex-row-fluid justify-content-end gap-5">
                                        <input type="hidden" class="export-title" value="Laporan Impor" />
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <table class="kt-datatable table table-bordered table-hover">
                                        <thead class="bg-light align-top" style="white-space: nowrap;">
                                            <tr class="fw-bold">
                                                <th class="text-center">No</th>
                                                <th>Bulan PIB</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>HS Code</th>
                                                <th>Volume PIB</th>
                                                <th class="text-center">Aksi</th>
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
                                            @foreach ($imporx as $impor)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ dateIndonesia($impor->bulan_pib) }}</td>
                                                    <td>
                                                        @if ($impor->status == 1 && $impor->catatan)
                                                            <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                        @elseif ($impor->status == 1)
                                                            <span class="badge badge-success">Diterima</span>
                                                        @elseif ($impor->status == 2)
                                                            <span class="badge badge-danger">Revisi</span>
                                                        @elseif ($impor->status == 0)
                                                            <span class="badge badge-info">Draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $impor->catatan }}</td>
                                                    <td>{{ $impor->produk }}</td>
                                                    <td>{{ $impor->hs_code }}</td>
                                                    <td>{{ $impor->volume_pib }}</td>
                                                    <td class="text-center">
                                                        @if ($impor->status == '0')
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                onclick="edit_impor('{{ $impor->id }}','{{ $impor->produk }}' ,'{{ $impor->negara_asal }}')" 
                                                                data-bs-toggle="modal" data-bs-target="#edit-impor">
                                                                <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                            </button>
                                                            <form action="{{ url('/hapus_import') }}/{{ $impor->id }}" method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))">
                                                                    <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                                onclick="lihat_import('{{ $impor->id }}', '{{ $impor->produk }}')" 
                                                                data-bs-target="#lihat-import">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
                                                        @elseif ($impor->status == '1')
                                                            <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                                onclick="lihat_import('{{ $impor->id }}', '{{ $impor->produk }}')" 
                                                                data-bs-target="#lihat-import">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
                                                        @elseif ($impor->status == '2')
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                onclick="edit_impor('{{ $impor->id }}','{{ $impor->produk }}' ,'{{ $impor->negara_asal }}')" 
                                                                data-bs-toggle="modal" data-bs-target="#edit-impor">
                                                                <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                                onclick="lihat_import('{{ $impor->id }}', '{{ $impor->produk }}')" 
                                                                data-bs-target="#lihat-import">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
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
            </div>
        @endif
    </div>
</div>

@include('badanUsaha.ekspor_impor.modal')

@endsection