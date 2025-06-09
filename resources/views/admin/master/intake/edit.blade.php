@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Update Intake Kilang</h3>
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
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master/intake_kilangs') }}" class="text-muted text-hover-primary">Intake Kilang</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <li class="breadcrumb-item text-muted">Update Intake Kilang</li>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-8 shadow">
            <div class="card-body p-4">
                <form method="post" action="/master/intake_kilangs/{{ $intake->id }}" class="form-material m-t-40" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Produk</label>
                                        <input class="form-control form-control-solid" placeholder="Masukan Nama" type="text" id="example-text-input" name="nm_produk" value="{{ old('nm_produk', $intake->nm_produk) }}">
                                        @error('nm_produk')
                                            <div class="form-group has-danger mb-0">
                                                <div class="form-control-feedback">{{ $message }}</div>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="example-date-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Satuan</label>
                                        <input class="form-control form-control-solid" placeholder="Masukan Satuan" type="text" id="example-text-input" name="satuan" value="{{ old('satuan', $intake->satuan) }}">
                                        @error('satuan')
                                            <div class="form-group has-danger mb-0">
                                                <div class="form-control-feedback">{{ $message }}</div>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

{{-- <div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Update Intake Kilang</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Update Intake Kilang</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"></h4>
                                        <p class="card-title-desc"></p>
                                    </div>
                                    <div class="card-body p-4">
                                    <form method="post" action="/master/intake_kilangs/{{ $intake->id }}" class="form-material m-t-40" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Nama Produk</label>
                                                        <input class="form-control" type="text" id="example-text-input" name="nm_produk" value="{{ old('nm_produk', $intake->nm_produk) }}">
                                                        @error('nm_produk')
                                                            <div class="form-group has-danger mb-0">
                                                                <div class="form-control-feedback">{{ $message }}</div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mt-3 mt-lg-0">
                                                    <div class="mb-3">
                                                        <label for="example-date-input" class="form-label">Satuan</label>
                                                        <input class="form-control" type="text" id="example-text-input" name="satuan" value="{{ old('satuan', $intake->satuan) }}">
                                                        @error('satuan')
                                                            <div class="form-group has-danger mb-0">
                                                                <div class="form-control-feedback">{{ $message }}</div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
    </div>
</div> --}}
@endsection
