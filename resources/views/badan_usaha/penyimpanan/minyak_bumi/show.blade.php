@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Penyimpanan Minyak Bumi</h4>
                    </div>
                </div>
            </div>
            {{-- penjualan --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{--  @if (session()->has('success'))
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script>
                        swal("{{ session('success') }}", "", "success");
                    </script>
                    @endif  --}}
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Minyak Bumi</h5>
                                <div>
                                    <a href="/penyimpananMinyakBumi"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                @if ($statusx == 1)
                                    <form action="/submit_bulan_pmb/{{ $bulan_ambilx . '-01' }}" method="post"
                                        class="d-inline">
                                        @method('put')
                                        @csrf
                                        <button type="button" class="btn btn-info"
                                            onclick="kirimData($(this).closest('form'))" disabled>
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
                                @elseif ($statusx == 2)
                                    <form action="/submit_bulan_pmb/{{ $bulan_ambilx . '-01' }}" method="post"
                                        class="d-inline">
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
                                    <form action="/submit_bulan_pmb/{{ $bulan_ambilx . '-01' }}" method="post"
                                        class="d-inline">
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
                                    <!-- Include modal content -->
                                    @include('badan_usaha.penyimpanan.minyak_bumi.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Produk</th>
                                            <th>Jenis Fasilitas</th>
                                            <th>No Tangki</th>
                                            <th>Aksi</th>
                                            <th>Jenis Komoditas</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten Kota</th>
                                            <th>Kategori Supplai</th>
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
                                            <th>Keterangan </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pmb as $pmb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ getBulan($pmb->bulan) }}</td>
                                                <td>{{ getTahun($pmb->bulan) }}</td>
                                                <td>
                                                    @if ($pmb->status == 1 && $pmb->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pmb->status == 1)
                                                        <span class="badge bg-success">Kirim</span>
                                                    @elseif ($pmb->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($pmb->status == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pmb->catatan }}</td>
                                                <td>{{ $pmb->produk }}</td>
                                                <td>{{ $pmb->jenis_fasilitas }}</td>
                                                <td>{{ $pmb->no_tangki }}</td>
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
                                                        <form action="/hapus_pmb/{{ $pmb->id }}" method="post"
                                                            class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-info "
                                                                    id="" data-bs-toggle="modal"
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
                                                                data-bs-target="#lihat-pmb"
                                                                data-id="{{ $pmb->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button>
                                                    </center>
                                                    <?php 
                                            } ?>
                                                </td>
                                                <td>
                                                    @foreach (explode('"', json_encode($pmb->jenis_komoditas)) as $jenis)
                                                        {{ $jenis }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $pmb->provinsi }}</td>
                                                <td>{{ $pmb->kab_kota }}</td>
                                                <td>{{ $pmb->kategori_supplai }}</td>
                                                <td>{{ $pmb->volume_stok_awal }}</td>
                                                <td>{{ $pmb->volume_supply }}</td>
                                                <td>{{ $pmb->volume_output }}</td>
                                                <td>{{ $pmb->volume_stok_akhir }}</td>
                                                <td>{{ $pmb->satuan }}</td>
                                                <td>{{ $pmb->utilasi_tangki }}</td>
                                                <td>{{ $pmb->pengguna }}</td>
                                                <td>{{ $pmb->jangka_waktu_penggunaan }}</td>
                                                <td>{{ $pmb->tarif_penyimpanan }}</td>
                                                <td>{{ $pmb->satuan_tarif }}</td>
                                                <td>{{ $pmb->keterangan }}</td>

                                            </tr>
                                        @endforeach
                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        {{--  <script>
    document.querySelector('.btn-primary').addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>  --}}
    @endsection
