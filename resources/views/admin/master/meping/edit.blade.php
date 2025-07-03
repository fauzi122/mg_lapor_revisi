@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Input Izin</h3>
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
                        <a href="#" class="text-muted text-hover-primary">Jenis Izin</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <li class="breadcrumb-item text-muted">Edit Izin</li>
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
                <form method="post" action="/master/meping/izin/{{ $meping->id }}" class="form-material m-t-40" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- untuk spoofing method PUT -->
                    <input type="hidden" name="id_induk_izin" value="{{ $meping->id_induk_izin }}">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Id Sub Page</label>
                                <input class="form-control form-control-solid" placeholder="Masukan Id Sub Page" type="text" name="id_sub_page" value="{{ old('id_sub_page', $meping->id_sub_page) }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Id Template</label>
                                <input class="form-control form-control-solid" placeholder="Masukan Id Template" type="text" name="id_template" value="{{ old('id_template', $meping->id_template) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Opsi</label>
                                <input class="form-control form-control-solid" placeholder="Masukan Opsi" type="text" name="nama_opsi" value="{{ old('nama_opsi', $meping->nama_opsi) }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Menu</label>
                                <input class="form-control form-control-solid" placeholder="Masukan Nama Menu" type="text" name="nama_menu" value="{{ old('nama_menu', $meping->nama_menu) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="kategori" class="form-label fw-semibold">Nama Kategori</label>
                                <select
                                    name="kategori"
                                    id="kategori"
                                    class="form-control select20 mb-2"
                                    style="width: 100%;"
                                    required>
                                    
                                    <option value="">Pilih Kategori</option>
                                    <option value="1" {{ old('kategori', $meping->kategori ?? '') == '1' ? 'selected' : '' }}>Gas</option>
                                    <option value="2" {{ old('kategori', $meping->kategori ?? '') == '2' ? 'selected' : '' }}>Minyak</option>
                                </select>
                            </div>
                        </div>                        

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Url</label>
                                <input class="form-control form-control-solid" placeholder="Masukan Url" type="text" name="url" value="{{ old('url', $meping->url) }}">
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
