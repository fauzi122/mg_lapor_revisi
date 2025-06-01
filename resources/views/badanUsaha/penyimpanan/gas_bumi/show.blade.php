@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Laporan Penyimpanan Gas Bumi</h3>
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

@include('badanUsaha.penyimpanan.gas_bumi.modal')

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row">
            <div class="col-12">
                <div class="card mb-5 mb-xl-8 shadow">
                    <div class="card-header bg-light p-5">
                        <div class="row w-100">
                            <div class="col-lg-6">
                                <h5>Gas Bumi</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-end gap-2">
                                    @php
                                        $id = Crypt::encryptString($pecah[0] . ',' . $pecah[1] . ',' . $pecah[2]);
                                    @endphp

                                    @if ($statusx == 1)
                                        <button type="button" class="btn btn-sm btn-info" disabled>
                                            <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary" disabled>
                                            <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success" disabled>
                                            <i class="fas fa-upload"></i> Import Excel
                                        </button>
                                    @elseif ($statusx == 2)
                                        <form action="{{ url('/submit_bulan_pggb') }}/{{ $id }}" method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-info" onclick="kirimData($(this).closest('form'))">
                                                <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-primary" disabled>
                                            <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success" disabled>
                                            <i class="fas fa-upload"></i> Import Excel
                                        </button>
                                    @else
                                        <form action="{{ url('/submit_bulan_pggb') }}/{{ $id }}" method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-info" onclick="kirimData($(this).closest('form'))">
                                                <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi(); kab_kota(); tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal" data-bs-target="#myModal">
                                            <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success" onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal" data-bs-target="#excelpggb">
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
                                    <input type="hidden" class="export-title" value="Laporan Penyimpanan Minyak Bumi" />
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
                                            <th>No Tangki</th>
                                            <th>Produk</th>
                                            <th>Kabupaten Kota</th>
                                            <th>Volume Stok Awal</th>
                                            <th>Volume Supply</th>
                                            <th>Volume Output</th>
                                            <th>Volume Stok Akhir</th>
                                            <th>Satuan</th>
                                            <th>Utilasi Tangki</th>
                                            <th>Pengguna</th>
                                            <th>Jangka Waktu Penggunaan</th>
                                            <th>Tarif Penyimpanan</th>
                                            <th>Satuan Tarif</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pggb as $pggb)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ getBulan($pggb->bulan) }}</td>
                                                <td>{{ getTahun($pggb->bulan) }}</td>
                                                <td>
                                                    @if ($pggb->status == 1 && $pggb->catatan)
                                                        <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pggb->status == 1)
                                                        <span class="badge badge-success">Diterima</span>
                                                    @elseif ($pggb->status == 2)
                                                        <span class="badge badge-danger">Revisi</span>
                                                    @elseif ($pggb->status == 0)
                                                        <span class="badge badge-info">Draf</span>
                                                    @elseif($pggb->status == 3)
                                                        <span class="badge badge-primary">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pggb->catatan }}</td>
                                                <td>{{ $pggb->no_tangki }}</td>
                                                <td>{{ $pggb->produk }}</td>
                                                <td>{{ $pggb->kab_kota }}</td>
                                                <td>{{ $pggb->volume_stok_awal }}</td>
                                                <td>{{ $pggb->volume_supply }}</td>
                                                <td>{{ $pggb->volume_output }}</td>
                                                <td>{{ $pggb->volume_stok_akhir }}</td>
                                                <td>{{ $pggb->satuan }}</td>
                                                <td>{{ $pggb->utilasi_tangki }}</td>
                                                <td>{{ $pggb->pengguna }}</td>
                                                <td>{{ $pggb->jangka_waktu_penggunaan }}</td>
                                                <td>{{ $pggb->tarif_penyimpanan }}</td>
                                                <td>{{ $pggb->satuan_tarif }}</td>
                                                <td class="text-center">
                                                    @if($pggb->status == "0")
                                                        <button type="button" class="btn btn-sm btn-info editpggb mb-2" id="editCompany" 
                                                            onclick="editpggb('{{ $pggb->id }}', '{{ $pggb->kab_kota }}' , '{{ $pggb->produk }}' )" 
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $pggb->id }}">
                                                            <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                        </button>
                                                        <form action="{{ url('/hapus_pggb') }}/{{ $pggb->id }}" method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger mb-2" onclick="hapusData($(this).closest('form'))">
                                                                <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                            onclick="lihat_pggb('{{ $pggb->id }}')" 
                                                            data-bs-target="#lihat-pggb" data-id="{{ $pggb->id }}">
                                                            <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                        </button>
                                                    @elseif($pggb->status == "1")
                                                        <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                            onclick="lihat_pggb('{{ $pggb->id }}')" 
                                                            data-bs-target="#lihat-pggb" data-id="{{ $pggb->id }}">
                                                            <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                        </button>
                                                    @elseif($pggb->status == "2")
                                                        <button type="button" class="btn btn-sm btn-info editpggb mb-2" id="editCompany" 
                                                            onclick="editpggb('{{ $pggb->id }}', '{{ $pggb->kab_kota }}' , '{{ $pggb->produk }}' )" 
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $pggb->id }}">
                                                            <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-info mb-2" id="" data-bs-toggle="modal" 
                                                            onclick="lihat_pggb('{{ $pggb->id }}')" 
                                                            data-bs-target="#lihat-pggb" data-id="{{ $pggb->id }}">
                                                            <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                        </button>
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
    </div>
</div>

@endsection