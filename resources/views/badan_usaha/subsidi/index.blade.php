@extends('layouts.frontand.app')



@section('content')

<div class="page-content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                    <h4 class="mb-sm-0 font-size-18"> Subsidi LPG</h4>



                    <div class="page-title-right">

                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>

                            <li class="breadcrumb-item active"> Subsidi LPG</li>

                        </ol>

                    </div>



                </div>

            </div>

        </div>



        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">LPG Subsidi Verified</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excellpgsubsidi">Import Excel</button>
                                <!-- Include modal content -->
                                @include('badan_usaha.subsidi.modal')
                            </div>
                        </div>
                    </div> 

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">

                                <thead>

                                    <tr>

                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Provinsi</th>
                                            <th>Volume</th>
                                            <th>Aksi</th>
                                        </tr>

                                </thead>

                                <tbody>

                                    @foreach ($lgpsub as $lgpsub)
                                    @php    
                                    $id=Crypt::encryptString($lgpsub->bulan);                                    
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b><a href="/lpg-subsidi/show/{{$id}}/subsidi_verified">{{dateIndonesia($lgpsub->bulan)}}<i class="bx bx-check" title="lihat data laporan"></i></a><b></td>
                                        <td>
                                            @if ($lgpsub->status_tertinggi == 1 && $lgpsub->catatan)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($lgpsub->status_tertinggi == 1)
                                                <span class="badge bg-success">Kirim</span>
                                            @elseif ($lgpsub->status_tertinggi == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($lgpsub->status_tertinggi == 0)
                                                <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $lgpsub->provinsi }}</td>
                                        <td>{{ $lgpsub->volume }}</td>

                                        @if ($lgpsub->status_tertinggi == 1)
                                            <td>
                                                <form action="/hapus_bulan_lgpsub/{{ $lgpsub->bulan }}subsidi_verified" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="hapusData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_bulan_lgpsub/{{ $lgpsub->bulan }}subsidi_verified" method="post"
                                                    class="d-inline" data-id="{{ $lgpsub->bulan }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="kirimData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <form action="/hapus_bulan_lgpsub/{{ $lgpsub->bulan }}subsidi_verified" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_bulan_lgpsub/{{ $lgpsub->bulan }}subsidi_verified" method="post"
                                                    class="d-inline" data-id="{{ $lgpsub->bulan }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                                <a href="/lpg-subsidi/show/{{$id}}/subsidi_verified"
                                                    class="btn btn-sm btn-info"><i class="bx bx-edit"
                                                        title="Revisi"></i></a>
                                            </td>
                                        @endif
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

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Kuota LPG Subsidi</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); negara();" data-bs-toggle="modal" data-bs-target="#inputklpg">Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelkuotasubsidi">Import Excel</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">

                                <thead>

                                    <tr>

                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Status</th>
                                            <th>Provinsi</th>
                                            <th>Kab / Kota</th>
                                            <th>Volume</th>
                                            <th>Aksi</th>
                                        </tr>

                                </thead>

                                <tbody>

                                    @foreach ($klpgs as $klpgs)
                                    @php    
                                    $id=Crypt::encryptString($klpgs->bulan);                                    
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b><a href="/lpg-subsidi/show/{{$id}}/kuota_subsidi">{{dateIndonesia($klpgs->bulan)}}<i class="bx bx-check" title="lihat data laporan"></i></a><b></td>
                                        <td>
                                            @if ($klpgs->status_tertinggi == 1 && $klpgs->catatan)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($klpgs->status_tertinggi == 1)
                                                <span class="badge bg-success">Kirim</span>
                                            @elseif ($klpgs->status_tertinggi == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($klpgs->status_tertinggi == 0)
                                                <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $klpgs->provinsi }}</td>
                                        <td>{{ $klpgs->kab_kota }}</td>
                                        <td>{{ $klpgs->volume }}</td>

                                        @if ($klpgs->status_tertinggi == 1)
                                            <td>
                                                <form action="/hapus_bulan_klpgs/{{ $klpgs->bulan }}kuota_subsidi" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="hapusData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_bulan_klpgs/{{ $klpgs->bulan }}kuota_subsidi" method="post"
                                                    class="d-inline" data-id="{{ $klpgs->bulan }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="kirimData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <form action="/hapus_bulan_klpgs/{{ $klpgs->bulan }}kuota_subsidi" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_bulan_klpgs/{{ $klpgs->bulan }}kuota_subsidi" method="post"
                                                    class="d-inline" data-id="{{ $klpgs->bulan }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                                <a href="/lpg-subsidi/show/{{$id}}/kuota_subsidi"
                                                    class="btn btn-sm btn-info"><i class="bx bx-edit"
                                                        title="Revisi"></i></a>
                                            </td>
                                        @endif
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

</div>

@endsection

