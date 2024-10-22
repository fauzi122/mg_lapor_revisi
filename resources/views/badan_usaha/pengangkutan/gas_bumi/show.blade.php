@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Pengangkutan Gas Bumi</h4>
                    </div>
                </div>
            </div>
            {{-- penjualan --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Gas Bumi</h5>
                                <div>
                                    <a href="/pengangkutan-gas-bumi"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                    <form action="/submit_bulan_pgb/{{ $bulan_ambilx . '-01' }}" method="post"
                                        class="d-inline">
                                        @method('put')
                                        @csrf
                                        <button type="button" class="btn btn-info"
                                            onclick="kirimData($(this).closest('form'))"
                                            {{ $statusx == 1 ? 'disabled' : '' }}>
                                            <span title="Kirim semua data">Kirim Semua</span>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambilx }}' )"
                                        data-bs-toggle="modal" data-bs-target="#myModal"
                                        {{ $statusx == 1 || $statusx == 2 ? 'disabled' : '' }}>Buat Laporan
                                        {{ dateIndonesia($bulan_ambilx) }}</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                        data-bs-target="#excelPengangkutanGB"
                                        {{ $statusx == 1 || $statusx == 2 ? 'disabled' : '' }}>Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengangkutan.gas_bumi.modal')
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
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Produk</th>
                                            <th>Node Asal</th>
                                            <th>Provinsi Asal</th>
                                            <th>Aksi</th>
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
                                                <td>{{ dateIndonesia($pgb->bulan) }}</td>
                                                <td>
                                                    @if ($pgb->status == 1 && $pgb->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pgb->status == 1)
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($pgb->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($pgb->status == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pgb->catatan }}</td>
                                                <td>{{ $pgb->produk }}</td>
                                                <td>{{ $pgb->node_asal }}</td>
                                                <td>{{ $pgb->provinsi_asal }}</td>
                                                <td>

                                                    <?php
                                            $status=$pgb->status;
                                            if ($status=="0"){ ?>
                                                    <center>
                                                        <button type="button" class="btn btn-sm btn-info editpgb"
                                                            id="editCompany"
                                                            onclick="editpgb('{{ $pgb->id }}', '{{ $pgb->kabupaten_kota }}' , '{{ $pgb->produk }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit-pgb"
                                                            data-id="{{ $pgb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit"></i>
                                                        </button>
                                                        <form action="/hapus_pgb/{{ $pgb->id }}" method="post"
                                                            class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        {{-- <form action="/submit_pgb/{{ $pgb->id }}" method="post"
                                                            class="d-inline" data-id="{{ $pgb->id }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button>
                                                        </form> --}}
                                                        <button type="button" class="btn btn-sm btn-info " id=""
                                                            data-bs-toggle="modal"
                                                            onclick="lihat_pgb('{{ $pgb->id }}')"
                                                            data-bs-target="#lihat-pgb" data-id="{{ $pgb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i>
                                                        </button>
                                                    </center>

                                                    <?php 
                                            }elseif ($status=="1"){ ?>
                                                    <center>
                                                        <button type="button" class="btn btn-sm btn-info " id=""
                                                            data-bs-toggle="modal"
                                                            onclick="lihat_pgb('{{ $pgb->id }}')"
                                                            data-bs-target="#lihat-pgb" data-id="{{ $pgb->id }}"> <i
                                                                class="bx bx-show-alt" title="Lihat data"></i>
                                                        </button>
                                                    </center>
                                                    <?php 
                                            }elseif ($status=="2"){ ?>
                                                    <center>
                                                        <button type="button" class="btn btn-sm btn-info editpgb"
                                                            id="editCompany"
                                                            onclick="editpgb('{{ $pgb->id }}', '{{ $pgb->kabupaten_kota }}' , '{{ $pgb->produk }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit-pgb"
                                                            data-id="{{ $pgb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit"></i>
                                                        </button>
                                                        {{-- <form action="/submit_pgb/{{ $pgb->id }}" method="post"
                                                            class="d-inline">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button>
                                                        </form> --}}
                                                        <button type="button" class="btn btn-sm btn-info " id=""
                                                            data-bs-toggle="modal"
                                                            onclick="lihat_pgb('{{ $pgb->id }}')"
                                                            data-bs-target="#lihat-pgb" data-id="{{ $pgb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i>
                                                        </button>
                                                    </center>
                                                    <?php 
                                            } ?>
                                                </td>
                                                <td>{{ $pgb->node_tujuan }}</td>
                                                <td>{{ $pgb->provinsi_tujuan }}</td>
                                                <td>{{ $pgb->volume_supply }}</td>
                                                <td>{{ $pgb->satuan_volume_supply }}</td>
                                                <td>{{ $pgb->volume_angkut }}</td>
                                                <td>{{ $pgb->satuan_volume_angkut }}</td>


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
