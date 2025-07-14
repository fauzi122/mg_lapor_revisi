@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Update Izin Usaha</h3>
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
                        <a href="{{ url('/master/izin-usaha') }}" class="text-muted text-hover-primary">Izin Usaha</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Update Izin Usaha</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-8 shadow">
            <div class="card-body p-4">
                <form method="post" action="{{ url('/master/izin-usaha/' . $IzinUsaha->id) }}" class="form-material m-t-40" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="example-text-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Id Sub Page</label>
                                <input class="form-control form-control-solid" placeholder="Masukan Id Template" type="number" id="example-text-input" name="id_sub_page" value="{{ old('id_sub_page', $IzinUsaha->id_sub_page) }}">
                                @error('id_sub_page')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback text-danger">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="fs-6 fw-semibold mb-2">ID Template</label>
                                <input type="number" name="id_template" class="form-control form-control-solid" value="{{ old('id_template', $IzinUsaha->id_template) }}">
                                @error('id_template')
                                    <div class="form-control-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="fs-6 fw-semibold mb-2">Jenis Izin</label>
                                <input type="text" name="jenis_izin" class="form-control form-control-solid" value="{{ old('jenis_izin', $IzinUsaha->jenis_izin) }}">
                                @error('jenis_izin')
                                    <div class="form-control-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="fs-6 fw-semibold mb-2">Nama Opsi</label>
                                <input type="text" name="nama_opsi" class="form-control form-control-solid" value="{{ old('nama_opsi', $IzinUsaha->nama_opsi) }}">
                                @error('nama_opsi')
                                    <div class="form-control-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="fs-6 fw-semibold mb-2">ID Ref</label>
                                <input type="number" name="id_ref" class="form-control form-control-solid" value="{{ old('id_ref', $IzinUsaha->id_ref) }}">
                                @error('id_ref')
                                    <div class="form-control-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="fs-6 fw-semibold mb-2">Jenis</label>
                                <input type="text" name="jenis" class="form-control form-control-solid" value="{{ old('jenis', $IzinUsaha->jenis) }}">
                                @error('jenis')
                                    <div class="form-control-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="fs-6 fw-semibold mb-2">Kategori Izin</label>
                                <input type="text" name="kategori_izin" class="form-control form-control-solid" value="{{ old('kategori_izin', $IzinUsaha->kategori_izin) }}">
                                @error('kategori_izin')
                                    <div class="form-control-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-md">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
