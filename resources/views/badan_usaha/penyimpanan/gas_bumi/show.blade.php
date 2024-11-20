@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Penyimpanan Gas Bumi</h4>
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
                                <h5 class="mb-0">Gas Bumi</h5>
                                <div>
                                    <a href="javascript:history.back()"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                    @if ($statusx == 1)
                                        <form action="{{ url('/submit_bulan_pggb') }}/{{ $bulan_ambilx . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))" disabled>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); kab_kota(); tambahPMB('{{ $bulan_ambilx }}' )"
                                            data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan
                                            {{ dateIndonesia($bulan_ambilx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                            data-bs-target="#excelpggb" disabled>Import Excel</button>
                                    @elseif ($statusx == 2)
                                        <form action="{{ url('/submit_bulan_pggb') }}/{{ $bulan_ambilx . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))">
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); kab_kota(); tambahPMB('{{ $bulan_ambilx }}' )"
                                            data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan
                                            {{ dateIndonesia($bulan_ambilx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                            data-bs-target="#excelpggb" disabled>Import Excel</button>
                                    @else
                                        <form action="{{ url('/submit_bulan_pggb') }}/{{ $bulan_ambilx . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))">
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="produk(); provinsi(); kab_kota(); tambahPMB('{{ $bulan_ambilx }}' )"
                                            data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan
                                            {{ dateIndonesia($bulan_ambilx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            onclick="tambahPMB('{{ $bulan_ambilx }}' )" data-bs-toggle="modal"
                                            data-bs-target="#excelpggb">Import Excel</button>
                                    @endif
                                    <!-- Include modal content -->
                                    @include('badan_usaha.penyimpanan.gas_bumi.modal')
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
                                            <th>No Tangki</th>
                                            <th>Produk</th>
                                            <th>Aksi</th>
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

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pggb as $pggb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ getBulan($pggb->bulan) }}</td>
                                                <td>{{ getTahun($pggb->bulan) }}</td>
                                                <td>
                                                    @if ($pggb->status == 1 && $pggb->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pggb->status == 1)
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($pggb->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($pggb->status == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @elseif($pggb->status == 3)
                                                        <span class="badge bg-primary">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pggb->catatan }}</td>
                                                <td>{{ $pggb->no_tangki }}</td>
                                                <td>{{ $pggb->produk }}</td>
                                                <td>

                                                    <?php
                                            $status=$pggb->status;
                                            if ($status=="0"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editpggb"
                                                            id="editCompany"
                                                            onclick="editpggb('{{ $pggb->id }}', '{{ $pggb->kab_kota }}' , '{{ $pggb->produk }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                            data-id="{{ $pggb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit"></i></button>
                                                        <form action="{{ url('/hapus_pggb') }}/{{ $pggb->id }}"
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
                                                            onclick="lihat_pggb('{{ $pggb->id }}')"
                                                            data-bs-target="#lihat-pggb" data-id="{{ $pggb->id }}"> <i
                                                                class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>

                                                    <?php 
                                            }elseif ($status=="1"){ ?>

                                                    <center><button type="button" class="btn btn-sm btn-info "
                                                            id="" data-bs-toggle="modal"
                                                            onclick="lihat_pggb('{{ $pggb->id }}')"
                                                            data-bs-target="#lihat-pggb" data-id="{{ $pggb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>
                                                    <?php 
                                            }elseif ($status=="2"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editpggb"
                                                            id="editCompany"
                                                            onclick="editpggb('{{ $pggb->id }}', '{{ $pggb->kab_kota }}' , '{{ $pggb->produk }}' )"
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                            data-id="{{ $pggb->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-info "
                                                            id="" data-bs-toggle="modal"
                                                            onclick="lihat_pggb('{{ $pggb->id }}')"
                                                            data-bs-target="#lihat-pggb" data-id="{{ $pggb->id }}">
                                                            <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                                    </center>
                                                    <?php 
                                            } ?>
                                                </td>
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
