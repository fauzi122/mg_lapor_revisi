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

    @include('badanUsaha.penyimpanan.minyak_bumi.modal')

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
                                            <button type="button" class="btn btn-sm btn-info" disabled>
                                                <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                    Semua</span>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @elseif ($statusx == 2)
                                            <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}" method="post"
                                                class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-upload"></i> Import Excel
                                            </button>
                                        @else
                                            <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}" method="post"
                                                class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim
                                                        Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambilx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal">
                                                <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                                data-bs-target="#excelpmb">
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
                                            value="Laporan Penyimpanan Minyak Bumi" />
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
                                                <th>No Tangki</th>
                                                <th>Kapasitas Tangki</th>
                                                <th>Pengguna</th>
                                                <th>Jenis Fasilitas</th>
                                                <th class="text-center">Aksi</th>
                                                <th>Jenis Komoditas</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten Kota</th>
                                                <th>Kategori Supplai</th>
                                                <th>Volume Stok Awal</th>
                                                <th>Volume Supply</th>
                                                <th>Volume Output</th>
                                                <th>Volume Stok Akhir</th>
                                                <th>Kapasitas Penyewaan</th>
                                                <th>Utilisasi Tangki</th>
                                                <th>Satuan</th>
                                                <th>Jangka Waktu Penggunaan</th>
                                                <th>Tarif Penyimpanan</th>
                                                <th>Satuan Tarif</th>
                                                <th>Keterangan</th>
                                                <th>Commingle</th>
                                                <th>Jumlah Badan Usaha</th>
                                                <th>Nama Penyewa</th>
                                                <th class="text-center">Dokumen Kontrak Penyewa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pmb as $pmb)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($pmb->bulan) }}</td>
                                                    <td>{{ getTahun($pmb->bulan) }}</td>
                                                    <td>
                                                        @if ($pmb->status == 1 && $pmb->catatan)
                                                            <span class="badge badge-warning">Sudah Diperbaiki</span>
                                                        @elseif ($pmb->status == 1)
                                                            <span class="badge badge-success">Diterima</span>
                                                        @elseif ($pmb->status == 2)
                                                            <span class="badge badge-danger">Revisi</span>
                                                        @elseif ($pmb->status == 0)
                                                            <span class="badge badge-info">Draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $pmb->catatan }}</td>
                                                    <td>{{ $pmb->produk }}</td>
                                                    <td>{{ $pmb->no_tangki }}</td>
                                                    <td>{{ $pmb->kapasitas_tangki }}</td>
                                                    <td>{{ $pmb->pengguna }}</td>
                                                    <td>{{ $pmb->jenis_fasilitas }}</td>
                                                    <td class="text-center">
                                                        @if ($pmb->status == '0')
                                                            <button type="button" class="btn btn-sm btn-info editPMB mb-2"
                                                                id="editCompany"
                                                                onclick="editPMB('{{ $pmb->id }}' , '{{ $pmb->kab_kota }}' , '{{ $pmb->produk }}' )"
                                                                data-bs-toggle="modal" data-bs-target="#edit-pmb"
                                                                data-id="{{ $pmb->id }}">
                                                                <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                            </button>
                                                            <form action="{{ url('/hapus_pmb') }}/{{ $pmb->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger mb-2"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="ki-solid ki-trash" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pmb('{{ $pmb->id }}')"
                                                                data-bs-target="#lihat-pmb"
                                                                data-id="{{ $pmb->id }}">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
                                                        @elseif($pmb->status == '1')
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pmb('{{ $pmb->id }}')"
                                                                data-bs-target="#lihat-pmb"
                                                                data-id="{{ $pmb->id }}">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
                                                        @elseif($pmb->status == '2')
                                                            <button type="button"
                                                                class="btn btn-sm btn-info editPMB mb-2" id="editCompany"
                                                                onclick="editPMB('{{ $pmb->id }}' , '{{ $pmb->kab_kota }}' , '{{ $pmb->produk }}' )"
                                                                data-bs-toggle="modal" data-bs-target="#edit-pmb"
                                                                data-id="{{ $pmb->id }}">
                                                                <i class="ki-solid ki-pencil" title="Edit Data"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-info mb-2"
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pmb('{{ $pmb->id }}')"
                                                                data-bs-target="#lihat-pmb"
                                                                data-id="{{ $pmb->id }}">
                                                                <i class="ki-solid ki-eye" title="Lihat data"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td style="white-space: nowrap;">
                                                        <ol>
                                                            @foreach ($pmb->jenis_komoditas as $jenis)
                                                                <li> {{ $jenis }}</li>
                                                            @endforeach
                                                        </ol>
                                                    </td>
                                                    <td>{{ $pmb->provinsi }}</td>
                                                    <td>{{ $pmb->kab_kota }}</td>
                                                    <td>{{ $pmb->kategori_supplai }}</td>
                                                    <td>{{ $pmb->volume_stok_awal }}</td>
                                                    <td>{{ $pmb->volume_supply }}</td>
                                                    <td>{{ $pmb->volume_output }}</td>
                                                    <td>{{ $pmb->volume_stok_akhir }}</td>
                                                    <td>{{ $pmb->kapasitas_penyewaan }}</td>
                                                    <td>{{ $pmb->utilisasi_tangki }}%</td>
                                                    <td>{{ $pmb->satuan }}</td>
                                                    <td style="white-space: nowrap;">
                                                        <ul>
                                                            <li>
                                                                <b>Tanggal Awal :</b><br>
                                                                {{ $pmb->tanggal_awal ? \Carbon\Carbon::parse($pmb->tanggal_awal)->format('d-M-Y') : '-' }}
                                                            </li>
                                                            <br>
                                                            <li>
                                                                <b>Tanggal Akhir :</b><br>
                                                                {{ $pmb->tanggal_akhir ? \Carbon\Carbon::parse($pmb->tanggal_akhir)->format('d-M-Y') : '-' }}
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td>{{ $pmb->tarif_penyimpanan }}</td>
                                                    <td>{{ $pmb->satuan_tarif }}</td>
                                                    <td>{{ $pmb->keterangan }}</td>
                                                    <td>{{ $pmb->commingle }}</td>
                                                    <td>{{ $pmb->jumlah_bu }}</td>
                                                    <td>{{ $pmb->nama_penyewa }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ asset('storage/' . $pmb->kontrak_sewa) }}"
                                                            class="btn btn-sm btn-success" download>
                                                            <i class="fas fa-download"></i> Unduh Dokumen
                                                        </a>
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
