@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Pengangkutan Minyak Bumi</h4>
                    </div>
                </div>
            </div>
            {{-- penjualan --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Minyak Bumi</h5>
                                <div>

                                    <a href="/pengangkutan-minyak-bumi"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                    <form action="/submit_bulan_pengmb/{{ $bulan_ambilx . '-01' }}" method="post"
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
                                        data-bs-target="#excelPengangkutanMB">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengangkutan.minyak_bumi.modal')
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
                                                <td>{{ dateIndonesia($pgb->bulan) }}</td>
                                                <td>
                                                    @if ($pgb->status == 1 && $pgb->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pgb->status == 1)
                                                        <span class="badge bg-success">Kirim</span>
                                                    @elseif ($pgb->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($pgb->status == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pgb->catatan }}</td>
                                                <td>{{ $pgb->produk }}</td>
                                                {{-- <td>{{ $pgb->jenis_moda }}</td> --}}
                                                <td>
                                                    @foreach (explode('"', json_encode($pgb->jenis_moda)) as $jenis)
                                                        @foreach (explode('\\', $jenis) as $moda)
                                                            {{ $moda }}
                                                        @endforeach
                                                    @endforeach
                                                </td>
                                                {{-- <td>{!! json_encode($pgb->jenis_moda) !!}</td> --}}
                                                <td>{{ $pgb->node_asal }}</td>
                                                <td>
                                                    <?php
                                            $status=$pgb->status;
                                            if ($status=="0"){ ?>
                                                    <center>
                                                        <button type="button" class="btn btn-sm btn-info editPMB"
                                                            id="editCompany" onclick="editpengmb('{{ $pgb->id }}', '{{ $pgb->produk }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#edit-pengmb"
                                                            data-id="{{ $pgb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit Data"></i>
                                                        </button>
                                                        <form action="/hapus_pengmb/{{ $pgb->id }}" method="post"
                                                            class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        {{-- <form action="/submit_pengmb/{{ $pgb->id }}" method="post"
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
                                                            onclick="lihat_pengmb('{{ $pgb->id }}')"
                                                            data-bs-target="#lihat-pengmb" data-id="{{ $pgb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i>
                                                        </button>
                                                    </center>
                                                    <?php } elseif ($status=="1"){ ?>

                                                    <center><button type="button" class="btn btn-sm btn-info "
                                                            id="" data-bs-toggle="modal"
                                                            onclick="lihat_pengmb('{{ $pgb->id }}')"
                                                            data-bs-target="#lihat-pengmb" data-id="{{ $pgb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>

                                                    <?php 
                                            }elseif ($status=="2"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editPMB"
                                                            id="editCompany" onclick="editpengmb('{{ $pgb->id }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#edit-pengmb"
                                                            data-id="{{ $pgb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit Data"></i></button>
                                                        {{-- <form action="/submit_pengmb/{{ $pgb->id }}" method="post"
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
                                                            onclick="lihat_pengmb('{{ $pgb->id }}')"
                                                            data-bs-target="#lihat-pengmb" data-id="{{ $pgb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>

                                                    <?php 
                                            } ?>
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
