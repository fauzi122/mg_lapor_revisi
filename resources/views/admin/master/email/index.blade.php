@extends('layouts.blackand.app')

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Data Email</h3>
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
                        <li class="breadcrumb-item text-muted">Data Email</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card-body p-3">
                <div class="card mb-5 mb-xl-8 shadow">
                    {{-- <div class="card-header bg-light p-5">
                        <div class="row w-100">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ url('/master/email/create') }}" class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Input Email">
                                        <i class="ki-duotone ki-plus"></i> Input Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
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
                                    <input type="hidden" class="export-title" value="Negara" />
                                </div>
                            </div>
                            <table class="kt-datatable table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr class="fw-bold text-uppercase">
                                        <th class="text-center">No</th>
                                        <th class="text-center">SUbject</th>
                                        <th class="text-center">Content</th>
                                        <th class="text-center">Event</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach ($emails as $email)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $email->subject }}</td>
                                            <td>{{ $email->content }}</td>
                                            <td>
                                                <p>
                                                    @if ($email->event === 'SUBMIT')
                                                        Saat Badan Usaha mengirim laporan
                                                    @endif
                                                    @if ($email->event === 'REVISI')
                                                        Saat Evaluator mengirim revisi atas laporan Badan Usaha
                                                    @endif
                                                    @if ($email->event === 'PERBAIKAN')
                                                        Saat Badan Usaha mengirim perbaikan revisi laporan
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="text-nowrap" align="center">
                                                <a href="{{ url('/master/email/' . $email->id . '/edit') }}">
                                                    <button type="button" class="btn btn-icon btn-sm btn-info mb-2"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                {{-- <form action="{{ url('/master/email/' . $email->id) }}" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-icon btn-sm btn-danger mb-2"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus data?')">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form> --}}
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
