@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Port</h3>
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
                    <li class="breadcrumb-item text-muted">Port</li>
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
                                <a href="/master/port/create" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Input Port">
                                    <i class="ki-duotone ki-plus"></i> Input Port
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Keterangan Produk" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Port</th>
                                    <th class="text-center">Lokasi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($port as $port)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $port->nm_port }}</td>
                                        <td>{{ $port->lokasi }}</td>
                                        <td class="text-nowrap" align="center">
                                            <a href="/master/port/{{ $port->id }}/edit">
                                                <button type="button" class="btn btn-icon btn-sm btn-info mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            <form action="/master/port/{{ $port->id }}" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-icon btn-sm btn-danger mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus data?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Port</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Data Port</li>
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
                            <a href="/master/port/create" class="btn btn-primary">Input Port</a>
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
                                                <th>Nama Port</th>
                                                <th>Lokasi</th>
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($port as $port)
                                            <tr>
                                                <td>{{ $port->nm_port }}</td>
                                                <td>{{ $port->lokasi }}</td>
                                                <td class="text-nowrap" align="center">
                                                    <a href="/master/port/{{ $port->id }}/edit">
                                                        <button type="button" class="btn btn-info waves-effect waves-light">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <form action="/master/port/{{ $port->id }}" method="post"
                                                        class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-danger waves-effect waves-light"
                                                            onclick="return confirm('Yakin ingin menghapus data?')">
                                                            <i class="bx bx-trash-alt"></i>
                                                        </button>
                                                    </form>
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
            </div>
        </div>
    </div>
</div> --}}
@endsection
