@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Input Izin Usaha</h3>
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
                    <li class="breadcrumb-item text-muted">
                        <li class="breadcrumb-item text-muted">Input Izin Usaha</li>
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
                <form method="post" action="{{ url('/master/izin-usaha') }}" class="form-material m-t-40" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="example-text-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Id Sub Page</label>
                                    <input class="form-control form-control-solid" placeholder="Masukan Id Template" type="number" id="example-text-input" name="id_sub_page" value="{{ old('id_sub_page') }}">
                                    @error('id_sub_page')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback text-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="example-text-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Id Template</label>
                                    <input class="form-control form-control-solid" placeholder="Masukan Id Template" type="number" id="example-text-input" name="id_template" value="{{ old('id_template') }}">
                                    @error('id_template')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback text-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    
                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <label for="example-date-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Jenis Izin</label>
                                    <input class="form-control form-control-solid" placeholder="Masukan Jenis Izin" type="text" id="example-text-input" name="jenis_izin" value="{{ old('jenis_izin') }}">
                                    @error('jenis_izin')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback text-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="example-text-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Opsi</label>
                                    <input class="form-control form-control-solid" placeholder="Masukan Nama Opsi" type="text" id="example-text-input" name="nama_opsi" value="{{ old('nama_opsi') }}">
                                    @error('nama_opsi')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback text-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <label for="example-date-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Id Ref</label>
                                    <input class="form-control form-control-solid" placeholder="Masukan Id Ref" type="number" id="example-text-input" name="id_ref" value="{{ old('id_ref') }}">
                                    @error('id_ref')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback text-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="example-text-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Jenis</label>
                                    <input class="form-control form-control-solid" placeholder="Masukan Jenis" type="text" id="example-text-input" name="jenis" value="{{ old('jenis') }}">
                                    @error('jenis')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback text-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <label for="example-date-input" class="d-flex align-items-center fs-6 fw-semibold mb-2">Kategori</label>
                                    <input class="form-control form-control-solid" placeholder="Masukan Kategori" type="text" id="example-text-input" name="kategori_izin" value="{{ old('kategori_izin') }}">
                                    @error('kategori_izin')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback text-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
