@extends('layouts.main.master')
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Laporan Penyimpanan Minyak Bumi</h3>
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

    @include('badan_usaha.pengangkutan.minyak_bumi.modal')

    <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-5 mb-xl-8 shadow">
                        <div class="card-header bg-light p-5">
                            <div class="row w-100">
                                <div class="col-lg-6">
                                    <h5>Minyak Bumi</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-end gap-2">
                                        @php
                                            $id = Crypt::encryptString(
                                                $pecah[0] . ',' . $pecah[1] . ',' . $pecah[2] . ',' . $pecah[3],
                                            );
                                        @endphp
                                
                                        @if ($statusx == 1)
                                            {{-- Jika status sudah terkirim, tombol hanya ditampilkan tapi disabled --}}
                                            <button type="button" class="btn btn-sm btn-info" disabled>
                                                <i class="ki-solid ki-send"></i>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                
                                        @elseif ($statusx == 2)
                                            {{-- Jika status revisi, kirim aktif tapi tambah laporan/excel nonaktif --}}
                                            <form action="{{ url('/submit_bulan_pengmb') }}/{{ $id }}" method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i>
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                
                                        @else
                                            {{-- Jika draf, semua tombol aktif --}}
                                            <form action="{{ url('/submit_bulan_pengmb') }}/{{ $id }}" method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i>
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambilx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal">
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                                data-bs-target="#excelPengangkutanMB">
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
                                        <input type="hidden" class="export-title"
                                            value="Laporan Pengangkutan Minyak Bumi" />
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <table class="kt-datatable table table-bordered table-hover">
                                        <thead class="bg-light align-top" style="white-space: nowrap;">
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>Jenis Moda</th>
                                                <th>Mode Asal</th>
                                                <th>Aksi</th>
                                                <th>Provinsi Asal</th>
                                                <th>Node Tujuan</th>
                                                <th>Provinsi Tujuan</th>
                                                <th>Volume Supply</th>
                                                <th>Satuan Volume Supply</th>
                                                <th>Volume Angkut</th>
                                                <th>Satuan Volume Angkut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pgb as $pgb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($pgb->bulan) }}</td>
                                                    <td>{{ getTahun($pgb->bulan) }}</td>
                                                    <td>
                                                        @if ($pgb->status == 1 && $pgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($pgb->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($pgb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($pgb->status == 0)
                                                            <span class="badge bg-info">Draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $pgb->catatan }}</td>
                                                    <td>{{ $pgb->produk }}</td>
                                                    <td>
                                                        @foreach (explode('"', json_encode($pgb->jenis_moda)) as $jenis)
                                                            @foreach (explode('\\', $jenis) as $moda)
                                                                {{ $moda }}
                                                            @endforeach
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $pgb->node_asal }}</td>
                                                    <td class="text-center">
                                                        @if ($pgb->status == '0')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info editPMB mb-2"
                                                                    onclick="editpengmb('{{ $pgb->id }}', '{{ $pgb->produk }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#edit-pengmb">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <form action="{{ url('hapus_pengmb') }}/{{ $pgb->id }}" method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger mb-2"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    onclick="lihat_pengmb('{{ $pgb->id }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#lihat-pengmb">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @elseif ($pgb->status == '1')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    onclick="lihat_pengmb('{{ $pgb->id }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#lihat-pengmb">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @elseif ($pgb->status == '2')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info editPMB mb-2"
                                                                    onclick="editPMB('{{ $pgb->id }}', '{{ $pgb->kab_kota }}', '{{ $pgb->produk }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#edit-pengmb">
                                                                    <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-info mb-2"
                                                                    onclick="lihat_pengmb('{{ $pgb->id }}')"
                                                                    data-bs-toggle="modal" data-bs-target="#lihat-pengmb">
                                                                    <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @endif
                                                    </td>
                                                    <td>{{ $pgb->provinsi_asal }}</td>
                                                    <td>{{ $pgb->node_tujuan }}</td>
                                                    <td>{{ $pgb->provinsi_tujuan }}</td>
                                                    <td>{{ $pgb->volume_supply }}</td>
                                                    <td>{{ $pgb->satuan_volume_supply }}</td>
                                                    <td>{{ $pgb->volume_angkut }}</td>
                                                    <td>{{ $pgb->satuan_volume_angkut }}</td>
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
