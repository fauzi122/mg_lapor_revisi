@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Data izin Usaha</h3>
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
                    <li class="breadcrumb-item text-muted">Data Izin Usaha</li>
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
                                <a href="/master/izin-usaha/create" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Input Izin Usaha">
                                    <i class="ki-duotone ki-plus"></i> Input Izin Usaha
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
                                <input type="hidden" class="export-title" value="Izin Usaha"/>
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th style="text-align: center; vertical-align: middle;">No</th>
                                    <th style="text-align: center; vertical-align: middle;">ID Sub Pgae</th>
                                    <th style="text-align: center; vertical-align: middle;">ID Template</th>
                                    <th style="text-align: center; vertical-align: middle;">Jenis Izin</th>
                                    <th style="text-align: center; vertical-align: middle;">Nama Opsi</th>
                                    <th style="text-align: center; vertical-align: middle;">Id Ref</th>
                                    <th style="text-align: center; vertical-align: middle;">Jenis</th>
                                    <th style="text-align: center; vertical-align: middle;">Kategori Izin</th>
                                    <th style="text-align: center; vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($IzinUsaha as $izinusaha)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $izinusaha->id_sub_page }}</td>
                                        <td>{{ $izinusaha->id_template }}</td>
                                        <td>{{ $izinusaha->jenis_izin }}</td>
                                        <td>{{ $izinusaha->nama_opsi }}</td>
                                        <td>{{ $izinusaha->id_ref }}</td>
                                        <td>{{ $izinusaha->jenis }}</td>
                                        <td>{{ $izinusaha->kategori_izin }}</td>
                                        <td class="text-nowrap" align="center">
                                            <a href="/master/izin-usaha/{{ $izinusaha->id }}/edit">
                                                <button type="button" class="btn btn-icon btn-sm btn-info mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            <form action="/master/izin-usaha/{{ $izinusaha->id }}" method="post"
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
@endsection
