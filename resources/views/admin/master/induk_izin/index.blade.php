@extends('layouts.blackand.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Data Izin</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Master Data</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Data Izin</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card-body p-3">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url('/master/meping/create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Input Data Izin">
                                    <i class="ki-duotone ki-plus"></i> Input Data Izin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        @if (session()->has('success'))
                            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                            <script>
                            swal("{{ session('success') }}", "", "success");
                            </script>
                        @endif
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Data Izin"/>
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama Izin</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($izin as $izin)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $izin->izin }}</td>
                                    <td>{{ $izin->nm_izin }}</td>
                                    <td class="text-nowrap" align="center">
                                        <a href="{{ url('/master/meping/' . $izin->izin . '/show/' . $izin->jenis_izin) }}">
                                            <button type="button" class="btn btn-info waves-effect waves-light" title="show jenis izin" data-bs-toggle="tooltip" data-bs-placement="top" title="Jenis Izin">
                                                <i class="bi bi-file-earmark-text fs-4"></i>Jenis Izin
                                            </button>
                                        </a>

                                        <a href="{{ url('/master/meping/edit/' . $izin->id) }}">
                                            <button type="button" class="btn btn-warning waves-effect waves-light" title="edit" data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                                                <i class="fa fa-edit"></i>Edit
                                            </button>
                                        </a>

                                        <form action="{{ url('/master/meping/destroy_izin/' . $izin->id) }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus data?')">
                                                <i class="bi bi-trash3-fill"></i> Hapus
                                            </button>
                                        </form>

                                        {{-- <a href="/master/meping/{{ $izin->izin }}/show">
                                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Menu Izin">
                                                Menu Izin
                                            </button>
                                        </a> --}}
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



{{-- <div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Data Izin</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                        <li class="breadcrumb-item active">Data Izin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                  @if (session()->has('success'))
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script>
                                    swal("{{ session('success') }}", "", "success");
                    </script>
                @endif
                <div class="card-header">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="/master/produk/create" class="btn btn-primary">Input Izin</a>
                    </div>
                    <ul class="nav nav-tabs">
                     
                       
                    </ul>
                </div> 
             
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="penjualan">
                            <div class="table-responsive">
    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
        <thead>
            <tr>
              
                <th>Kode</th>
                <th>Nama Izin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($izin as $izin)
            <tr>
    
                <td>{{ $izin->izin }}</td>
                <td>{{ $izin->nm_izin }}</td>

                <td class="text-nowrap" align="center">
                    <a href="/master/meping/{{ $izin->izin }}/show">
                        <button type="button" class="btn btn-info waves-effect waves-light" title="show jenis izin">
                            Jenis Izin
                        </button>
                    </a>
                    <a href="/master/meping/{{ $izin->izin }}/show">
                        <button type="button" class="btn btn-danger waves-effect waves-light">
                            Menu Izin
                        </button>
                    </a>

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
</div> --}}
@endsection


