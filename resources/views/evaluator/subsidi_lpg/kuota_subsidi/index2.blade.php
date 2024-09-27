@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Kuota LPG Subsidi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Data Kuota LPG Subsidi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Data table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">
                            <!-- Add data button -->
                            {{-- <a href="/create/subsidi-lpg" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-filter">Tambah Data</button> --}}
                            <a href="/create/kuota/subsidi-lpg" type="button" class="btn btn-primary">Tambah Data</a>

                            <!-- Input Modal -->
                            {{-- @include('evaluator.subsidi_lpg.lpg_subsidi.input-modal') --}}

                            <!-- Edit Modal -->
                             {{-- @include('evaluator.subsidi_lpg.lpg_subsidi.edit-modal') --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="penjualan">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Volume</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lpg_subsidi as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->tahun }}</td>
                                                    <td>{{ $data->provinsi }}</td>
                                                    <td>{{ $data->kabupaten/kota }}</td>
                                                    <td>{{ $data->volume }}</td>
                                                    <td>
                                                       <a href="" class="btn btn-primary btn-sm edit-btn" data-id="{{ $data->id }}">Edit</a>

                                                        <a href="" class="btn btn-danger btn-sm delete-btn" data-id="{{ $data->id }}">Hapus</a>
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
</div>

@endsection

