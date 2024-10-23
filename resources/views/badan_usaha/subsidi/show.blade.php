@extends('layouts.frontand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan Subsidi LPG</h4>
                </div>
            </div>
        </div>
        {{-- LPG Subsidi Verified --}}
        @if ($statusx != '' and $jenisx=='subsidi_verified')
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
                            <h5 class="mb-0">LPG Subsidi Verified</h5>
                            <div>
                                <a href="/lpg-subsidi"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                <form action="/submit_bulan_lgpsub/{{ $bulan_ambilx . '-01' }}subsidi_verified" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))"
                                        {{ $statusx == 1 ? 'disabled' : '' }}>
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#myModal" {{ $statusx == 1 || $statusx == 2 ? 'disabled' : '' }}>Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excellpgsubsidi" {{ $statusx == 1 || $statusx == 2 ? 'disabled' : '' }}>Import Excel</button>
                                <!-- Include modal content -->
                                @include('badan_usaha.subsidi.modal')
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
                                        <th>Volume (ton)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lgpsub as $lgpsub)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('F Y', strtotime($lgpsub->bulan)) }}</td>
                                        <td>
                                            @if ($lgpsub->status == 1 && $lgpsub->catatan)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($lgpsub->status == 1)
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif ($lgpsub->status == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($lgpsub->status == 0)
                                                <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $lgpsub->catatan }}</td>
                                        <td>{{ $lgpsub->provinsi }}</td>
                                        <td>{{ $lgpsub->volume }}</td>
                                        <td>
                                            
                                            <?php
                                            $status=$lgpsub->status;
                                            if ($status=="0"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info editlgpsub" id="editCompany" onclick="edit_lgpsub('{{ $lgpsub->id }}' )" data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $lgpsub->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <form action="/hapus_lgpsub/{{ $lgpsub->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_lgpsub/{{ $lgpsub->id }}" method="post" class="d-inline" data-id="{{ $lgpsub->id }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                                
                                            <?php 
                                            }elseif ($status=="1"){ ?>
                                                      
                                                        <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_lgpsub('{{ $lgpsub->id }}')" data-bs-target="#lihat-lgpsub" data-id="{{ $lgpsub->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                                      
                                            <?php 
                                            }elseif ($status=="2"){ ?>
                                                        <center><button type="button" class="btn btn-sm btn-info editPenjualan" id="editCompany" onclick="edit_ekpor('{{ $lgpsub->id }}', '{{ $lgpsub->produk  }}' , '{{ $lgpsub->negara_tujuan  }}'  )" data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $lgpsub->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>  
                                                        <form action="/submit_lgpsub/{{ $lgpsub->id }}" method="post" class="d-inline">
                                                        @method('PUT')
                                                        @csrf
                                                            <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                            <?php 
                                            } ?>
                                        </td>
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
        {{-- >Kuota LPG Subsidi --}}
        @if ($statusx != '' and $jenisx=='kuota_subsidi')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Kuota LPG Subsidi</h5>
                            <div>
                                <a href="/lpg-subsidi"
                                        class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                <form action="/submit_bulan_klpgs/{{ $bulan_ambilx . '-01' }}kuota_subsidi" method="post"
                                    class="d-inline">
                                    @method('put')
                                    @csrf
                                    <button type="button" class="btn btn-info"
                                        onclick="kirimData($(this).closest('form'))"
                                        {{ $statusx == 1 ? 'disabled' : '' }}>
                                        <span title="Kirim semua data">Kirim Semua</span>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#inputklpg" {{ $statusx == 1 || $statusx == 2 ? 'disabled' : '' }}>Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelkuotasubsidi" {{ $statusx == 1 || $statusx == 2 ? 'disabled' : '' }}>Import Excel</button>
                                @include('badan_usaha.subsidi.modal')
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Provinsi</th>
                                        <th>Kabupaten / Kota</th>
                                        <th>Volume</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($klpg as $klpg)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $klpg->tahun }}</td>
                                        <td>
                                            @if ($klpg->status == 1 && $klpg->catatan)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($klpg->status == 1)
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif ($klpg->status == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($klpg->status == 0)
                                                <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $klpg->catatan }}</td>
                                        <td>{{ $klpg->provinsi }}</td>
                                        <td>{{ $klpg->kab_kota }}</td>
                                        <td>{{ $klpg->volume }}</td>
                    
                                        <td>
                                        <?php
                                        $status=$klpg->status;
                                        if ($status=="0"){ ?>
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_klpg('{{ $klpg->id }}','{{ $klpg->kab_kota }}')" data-bs-target="#edit-klpg" data-id="{{ $klpg->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                            <form action="/hapus_klpgs/{{ $klpg->id }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                </button>
                                            </form>
                                            <form action="/submit_klpgs/{{ $klpg->id }}" method="post" class="d-inline" data-id="{{ $klpg->id }}">
                                            @method('PUT')
                                            @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                            
                                       <?php }elseif ($status=="1"){ ?>
                                            
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_klpg('{{ $klpg->id }}')" data-bs-target="#lihat-klpgs" data-id="{{ $klpg->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                            
                                       <?php }elseif ($status=="2"){ ?>
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_klpg('{{ $klpg->id }}','{{ $klpg->produk }}' ,'{{ $klpg->negara_asal }}')" data-bs-target="#edit-pasokan" data-id="{{ $klpg->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                            <form action="/submit_import/{{ $klpg->id }}" method="post" class="d-inline">
                                            @method('PUT')
                                            @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                       <?php } ?>
                                        </td>
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
