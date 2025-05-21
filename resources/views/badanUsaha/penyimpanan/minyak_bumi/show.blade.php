@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Laporan Penyimpanan Minyak Bumi</h1>
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
                            <div class="col-6">
                                <h5>Minyak Bumi</h5>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-end gap-2">
                                    @php
                                        $id = Crypt::encryptString($pecah[0] . ',' . $pecah[1] . ',' . $pecah[2]);
                                    @endphp

                                    @if ($statusx == 1)
                                        <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}" method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-info" onclick="kirimData($(this).closest('form'))" disabled>
                                                <i class="ki-solid ki-send"></i><span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal" data-bs-target="#myModal">
                                            <i class="fas fa-plus"></i> Buat Laporan {{ dateIndonesia($bulan_ambilx) }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                            data-bs-target="#excelpmb" disabled>Import Excel</button>
                                    @elseif ($statusx == 2)
                                        <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))">
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambilx }}' )"
                                            data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan
                                            {{ dateIndonesia($bulan_ambilx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                            data-bs-target="#excelpmb" disabled>Import Excel</button>
                                    @else
                                        <form action="{{ url('/submit_bulan_pmb') }}/{{ $id }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))">
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambilx }}' )"
                                            data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan
                                            {{ dateIndonesia($bulan_ambilx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                            data-bs-target="#excelpmb">Import Excel</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="card">
                            <div class="card-header align-items-center px-2">
                                <div class="card-toolbar"></div>
                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                    <input type="hidden" class="export-title" value="Laporan Penyimpanan Minyak Bumi" />
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <table class="kt-datatable table table-bordered table-hover">
                                    <thead class="bg-light align-middle">
                                        <tr class="fw-bold text-uppercase">
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Produk</th>
                                            <th>No Tangki</th>
                                            <th>Kapasitas Tangki</th>
                                            <th>Pengguna</th>
                                            <th>Jenis Fasilitas</th>
                                            <th>Aksi</th>
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
                                            <th>Dokumen Kontrak Penyewa</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($pmb as $pmb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ getBulan($pmb->bulan) }}</td>
                                                <td>{{ getTahun($pmb->bulan) }}</td>
                                                <td>
                                                    @if ($pmb->status == 1 && $pmb->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pmb->status == 1)
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($pmb->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($pmb->status == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pmb->catatan }}</td>
                                                <td>{{ $pmb->produk }}</td>
                                                <td>{{ $pmb->no_tangki }}</td>
                                                <td>{{ $pmb->kapasitas_tangki }}</td>
                                                <td>{{ $pmb->pengguna }}</td>
                                                <td>{{ $pmb->jenis_fasilitas }}</td>
                                                <td>

                                                    <?php
                                            $status=$pmb->status;
                                            if ($status=="0"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editPMB"
                                                            id="editCompany"
                                                            onclick="editPMB('{{ $pmb->id }}' , '{{ $pmb->kab_kota }}' , '{{ $pmb->produk }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#edit-pmb"
                                                            data-id="{{ $pmb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit Data"></i></button>
                                                        <form action="{{ url('/hapus_pmb') }}/{{ $pmb->id }}"
                                                            method="post" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-info " id=""
                                                            data-bs-toggle="modal"
                                                            onclick="lihat_pmb('{{ $pmb->id }}')"
                                                            data-bs-target="#lihat-pmb" data-id="{{ $pmb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>

                                                    <?php 
                                            }elseif ($status=="1"){ ?>

                                                    <center><button type="button" class="btn btn-sm btn-info "
                                                            id="" data-bs-toggle="modal"
                                                            onclick="lihat_pmb('{{ $pmb->id }}')"
                                                            data-bs-target="#lihat-pmb" data-id="{{ $pmb->id }}"> <i
                                                                class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>

                                                    <?php 
                                            }elseif ($status=="2"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editPMB"
                                                            id="editCompany"
                                                            onclick="editPMB('{{ $pmb->id }}' , '{{ $pmb->kab_kota }}' , '{{ $pmb->produk }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#edit-pmb"
                                                            data-id="{{ $pmb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit Data"></i></button>
                                                        <button type="button" class="btn btn-sm btn-info "
                                                            id="" data-bs-toggle="modal"
                                                            onclick="lihat_pmb('{{ $pmb->id }}')"
                                                            data-bs-target="#lihat-pmb" data-id="{{ $pmb->id }}"> <i
                                                                class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>
                                                    <?php 
                                            } ?>
                                                </td>
                                                {{-- @dd($pmb->jenis_komoditas) --}}
                                                <td>
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
                                                <td>
                                                    <ul>
                                                        <li>
                                                            Tanggal Awal :
                                                            {{ \Carbon\Carbon::parse($pmb->tanggal_awal)->format('d-M-Y') }}
                                                        </li>
                                                        <li>
                                                            Tanggal Akhir :
                                                            {{ \Carbon\Carbon::parse($pmb->tanggal_akhir)->format('d-M-Y') }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>{{ $pmb->tarif_penyimpanan }}</td>
                                                <td>{{ $pmb->satuan_tarif }}</td>
                                                <td>{{ $pmb->keterangan }}</td>
                                                <td>{{ $pmb->commingle }}</td>
                                                <td>{{ $pmb->jumlah_bu }}</td>
                                                <td>{{ $pmb->nama_penyewa }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $pmb->kontrak_sewa) }}"
                                                        class="btn btn-success waves-effect waves-light ms-3 p-2"
                                                        download><i class="bx bxs-download me-1"></i>Unduh Dokumen</a>
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