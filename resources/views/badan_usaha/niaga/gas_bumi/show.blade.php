@extends('layouts.frontand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan Gas Bumi Melalui Pipa</h4>
                </div>
            </div>
        </div>
        {{-- penjualan --}}
        @if ($statuspenjualan_gbpx != '' and $gbpxy=='penjualan')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Penjualan Gas Bumi</h5>
                            <div>
                                <a href="/gas-bumi-pipa"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                @if ($statuspenjualan_gbpx == 1)
                                <form action="/submit_bulan_gbp/{{ $bulan_ambil_penjualan_gbpx . '-01' }}" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))" disabled>
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); sektor();" data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_penjualan_gbpx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelgbp" disabled>Import Excel</button>
                                @elseif ($statuspenjualan_gbpx == 2)
                                <form action="/submit_bulan_gbp/{{ $bulan_ambil_penjualan_gbpx . '-01' }}" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_gbpx }}');" data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_penjualan_gbpx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_penjualan_gbpx }}');" data-bs-toggle="modal" data-bs-target="#excelgbp" disabled>Import Excel</button>
                                @else
                                <form action="/submit_bulan_gbp/{{ $bulan_ambil_penjualan_gbpx . '-01' }}" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_gbpx }}');" data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan {{ dateIndonesia($bulan_ambil_penjualan_gbpx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_penjualan_gbpx }}');" data-bs-toggle="modal" data-bs-target="#excelgbp">Import Excel</button>
                                @endif
                                <!-- Include modal content -->
                                @include('badan_usaha.niaga.gas_bumi.modal')
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
                                        <th>Provinsi</th>
                                        <th>Kabupaten/Kota</th>
                                        <th>Sektor</th>
                                        <th>Aksi</th>
                                        <th>Konsumen</th>
                                        <th>Jumlah Hari Penyaluran</th>
                                        <th>GHV</th>
                                        <th>Volume MMBTU</th>
                                        <th>Volume MSCF</th>
                                        <th>Volume M3</th>
                                        <th>Harga</th>
                                        <th>Keterangan</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gbp as $gbp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ dateIndonesia($gbp->bulan) }}</td>
                                        <td>
                                            @if ($gbp->status == 1 && $gbp->catatan)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($gbp->status == 1)
                                                <span class="badge bg-success">Kirim</span>
                                            @elseif ($gbp->status == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($gbp->status == 0)
                                                <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $gbp->catatan }}</td>
                                        <td>{{ $gbp->provinsi }}</td>
                                        <td>{{ $gbp->kabupaten_kota }}</td>
                                        <td>{{ $gbp->sektor }}</td>
                                        <td>
                                            
                                            <?php
                                            $status=$gbp->status;
                                            if ($status=="0"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info editPenjualan" id="editCompany" onclick="edit_penjualan_gbp('{{ $gbp->id }}' , '{{ $gbp->kabupaten_kota }}')" data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $gbp->id }}"> <i class="bx bx-edit-alt" title="Edit data."></i></button>
                                                <form action="/hapus_gbp/{{ $gbp->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_penjualan_gbp('{{ $gbp->id }}')" data-bs-target="#lihat-penjualan" data-id="{{ $gbp->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                                </center>
                                                
                                            <?php 
                                            }elseif ($status=="1"){ ?>
                                                        <form action="/submit_gbp/{{ $gbp->id }}" method="post" class="d-inline">
                                                        @csrf
                                                        <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_penjualan_gbp('{{ $gbp->id }}')" data-bs-target="#lihat-penjualan" data-id="{{ $gbp->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                                        </form>
                                            <?php 
                                            }elseif ($status=="2"){ ?>
                                                        <center><button type="button" class="btn btn-sm btn-info editPenjualan" id="editCompany" onclick="edit_penjualan_gbp('{{ $gbp->id }}' , '{{ $gbp->kabupaten_kota }}')" data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $gbp->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>  
                                                        <form action="/submit_gbp/{{ $gbp->id }}" method="post" class="d-inline">
                                                        @method('PUT')
                                                        @csrf
                                                            <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                            <?php 
                                            } ?>
                                        </td>
                                        <td>{{ $gbp->konsumen }}</td>
                                        <td>{{ $gbp->jumlah_hari_penyaluran }}</td>
                                        <td>{{ $gbp->ghv }}</td>
                                        <td>{{ $gbp->volume_mmbtu }}</td>
                                        <td>{{ $gbp->volume_mscf }}</td>
                                        <td>{{ $gbp->volume_m3 }}</td>
                                        <td>{{ $gbp->harga }}</td>
                                        <td>{{ $gbp->keterangan }}</td>
                                        
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
        @else
        <div class="row"></div>
        @endif
        {{-- pasokan --}}
        @if ($statuspasok_gbpx != '' and $gbpxy=='pasok')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pasokan Gas Bumi</h5>
                            <div>
                                <a href="/gas-bumi-pipa"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                @if ($statuspasok_gbpx == 1)
                                <form action="/submit_bulan_pasok_gbp/{{ $bulan_ambil_pasok_gbpx . '-01' }}" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))" disabled>
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#inputpasokgbp" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_pasok_gbpx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelgbppasok" disabled>Import Excel</button>
                                @elseif ($statuspasok_gbpx == 2)
                                <form action="/submit_bulan_pasok_gbp/{{ $bulan_ambil_pasok_gbpx . '-01' }}" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_gbpx }}');" data-bs-toggle="modal" data-bs-target="#inputpasokgbp" disabled>Buat Laporan {{ dateIndonesia($bulan_ambil_pasok_gbpx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_pasok_gbpx }}');" data-bs-toggle="modal" data-bs-target="#excelgbppasok" disabled>Import Excel</button>
                                @else
                                <form action="/submit_bulan_pasok_gbp/{{ $bulan_ambil_pasok_gbpx . '-01' }}" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))">
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_gbpx }}');" data-bs-toggle="modal" data-bs-target="#inputpasokgbp">Buat Laporan {{ dateIndonesia($bulan_ambil_pasok_gbpx) }}</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="tambahPMB('{{ $bulan_ambil_pasok_gbpx }}');" data-bs-toggle="modal" data-bs-target="#excelgbppasok">Import Excel</button>
                                @endif
                                @include('badan_usaha.niaga.gas_bumi.modal')
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Nama Pemasok</th>
                                        <th>Volume MMBTU</th>
                                        <th>Volume MSCF</th>
                                        <th>Aksi</th>
                                        <th>Volume M3</th>
                                        <th>Harga</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pasokan as $pasokan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ dateIndonesia($pasokan->bulan) }}</td>
                                        <td>
                                            @if ($pasokan->status == 1 && $pasokan->catatan)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($pasokan->status == 1)
                                                <span class="badge bg-success">Kirim</span>
                                            @elseif ($pasokan->status == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($pasokan->status == 0)
                                                <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $pasokan->catatan }}</td>
                                        <td>{{ $pasokan->nama_pemasok }}</td>
                                        <td>{{ $pasokan->volume_mmbtu }}</td>
                                        <td>{{ $pasokan->volume_mscf }}</td>
                                        <td>
                                        <?php
                                            $status=$pasokan->status;
                                            if ($status=="0"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_pasokan_gbp('{{ $pasokan->id }}')" data-bs-target="#edit-pasokan" data-id="{{ $pasokan->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <form action="/hapus_pasok_gbp/{{ $pasokan->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_pasokan_gbp('{{ $pasokan->id }}')" data-bs-target="#lihat-pasokan" data-id="{{ $pasokan->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button>
                                                </center>
                                                
                                            <?php }elseif ($status=="1"){ ?>
                                                <form action="/submit_pasok_gbp/{{ $pasokan->id }}" method="post" class="d-inline">
                                                @csrf
                                                <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_pasokan_gbp('{{ $pasokan->id }}')" data-bs-target="#lihat-pasokan" data-id="{{ $pasokan->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                                </form>
                                            <?php }elseif ($status=="2"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_pasokan_gbp('{{ $pasokan->id }}')" data-bs-target="#edit-pasokan" data-id="{{ $pasokan->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_pasokan_gbp('{{ $pasokan->id }}')" data-bs-target="#lihat-pasokan" data-id="{{ $pasokan->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                            <?php } ?>
                                        </td>
                                        <td>{{ $pasokan->volume_m3 }}</td>
                                        <td>{{ $pasokan->harga }}</td>
                                        
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
        @else
        <div class="row"></div>
        @endif
       
</div>
{{--  <script>
    document.querySelector('.btn-primary').addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>  --}}
@endsection
