@extends('layouts.frontand.app')



@section('content')

<div class="page-content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                    <h4 class="mb-sm-0 font-size-18"> Gas Bumi</h4>



                    <div class="page-title-right">

                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>

                            <li class="breadcrumb-item active"> Gas Bumi</li>

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
                            <h5 class="mb-0">Penjualan Gas Bumi</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi(); sektor();" data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelgbp">Import Excel</button>
                                <!-- Include modal content -->
                                @include('badan_usaha.niaga.gas_bumi.modal')
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
                                          
                                            <th>Aksi</th>
                                        </tr>

                                </thead>

                                <tbody>

                                    @foreach ($gbp as $data)

                                    @php    
                                    $id=Crypt::encryptString($data->bulan.','.$data->badan_usaha_id);                                    
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b><a href="/gas-bumi-pipa/show/{{$id}}/penjualan">{{dateIndonesia($data->bulan)}}<i class="bx bx-check" title="lihat data laporan"></i></a><b></td>
                                        <td>		
                                        @if ($data->status_tertinggi == 1 && $data->catatanx)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($data->status_tertinggi == 1)
                                                 <span class="badge bg-success">Diterima</span> 
                                            @elseif ($data->status_tertinggi == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($data->status_tertinggi == 0)
                                                <span class="badge bg-info">draf</span>
                                        @endif
                                        </td>
                                        <!-- <td>{{ $data->catatan }}</td> -->

                                        @if ($data->status_tertinggi == 1)
                                        <td><form action="/hapus_bulan_gbp/{{ $data->bulan }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                            </form>
                                            <form action="/submit_bulan_gbp/{{$data->bulan }}" method="post" class="d-inline" data-id="{{ $data->bulan }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form></td>
                                        @else
                                        <td><form action="/hapus_bulan_gbp/{{ $data->bulan }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                            </form>
                                            <form action="/submit_bulan_gbp/{{$data->bulan }}" method="post" class="d-inline" data-id="{{ $data->bulan }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                            <a href="/gas-bumi-pipa/show/{{$id}}/penjualan" class="btn btn-sm btn-info"><i class="bx bx-edit" title="Revisi"></i></a>
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
                            <h5 class="mb-0">Pasokan Gas Bumi</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#inputpasokgbp">Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelgbppasok">Import Excel</button>
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
                                          
                                            <th>Aksi</th>
                                        </tr>

                                </thead>

                                <tbody>

                                    @foreach ($gbp_pasok as $data)

                                    @php    
                                    $id=Crypt::encryptString($data->bulan.','.$data->badan_usaha_id);                                    
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b><a href="/gas-bumi-pipa/show/{{$id}}/pasok">{{dateIndonesia($data->bulan)}}<i class="bx bx-check" title="lihat data laporan"></i></a><b></td>
                                        <td>		
                                        @if ($data->status_tertinggi == 1 && $data->catatanx)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($data->status_tertinggi == 1)
                                                 <span class="badge bg-success">Diterima</span> 
                                            @elseif ($data->status_tertinggi == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($data->status_tertinggi == 0)
                                                <span class="badge bg-info">draf</span>
                                        @endif
                                        </td>
                                        <!-- <td>{{ $data->catatan }}</td> -->

                                        @if ($data->status_tertinggi == 1)
                                        <td><form action="/hapus_pasok_bulan_gbp/{{ $data->bulan }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                            </form>
                                            <form action="/submit_bulan_pasok_gbp/{{$data->bulan }}" method="post" class="d-inline" data-id="{{ $data->bulan }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form></td>
                                        @else
                                        <td><form action="/hapus_pasok_bulan_gbp/{{ $data->bulan }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                            </form>
                                            <form action="/submit_bulan_pasok_gbp/{{$data->bulan }}" method="post" class="d-inline" data-id="{{ $data->bulan }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                            <a href="/gas-bumi-pipa/show/{{$id}}/pasok" class="btn btn-sm btn-info"><i class="bx bx-edit" title="Revisi"></i></a>
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

