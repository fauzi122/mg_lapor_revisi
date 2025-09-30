@extends('layouts.blackand.app')


@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Create Permissions</h3>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">User Managemen</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Permissions</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Create Permissions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if (session('pesan'))
                <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                    <i class="mdi mdi-check-all label-icon"></i><strong>Success</strong> - {{ session('pesan') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-body mt-4">
                <div class="card mb-5 mb-xl-8 shadow">
                    <div class="card-header bg-light p-5">
                        <div class="row w-100">
                            <div class="col-12">
                                <div class="d-flex justify-content-start">
                                    <div class="d-flex justify-content-start">
                                        <h5 class="card-title">Add New Permissions</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ url('/permission') }}" class="btn btn-primary waves-effect waves-light">
                                        <i class="bi bi-arrow-left"></i> Back to Permissions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="card p-3">
                            <form action="{{ url('/permission') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span>Nama Permission</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Masukkan Nama Role"
                                        class="form-control form-control-solid @error('title') is-invalid @enderror">

                                    @error('name')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <BR>
                                <div class="d-flex justify-content-end mb-3 p-3">
                                    <button class="btn btn-primary mr-1 btn-submit me-3" type="submit"><i
                                            class="fa fa-paper-plane"></i>
                                        SIMPAN</button>
                                    <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i>
                                        RESET</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="page-content">
    <div class="container-fluid">
    @if (session('pesan'))
        <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="mdi mdi-check-all label-icon"></i><strong>Success</strong> - {{ session('pesan') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
     @endif

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18"> Create Permissions</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">PPIC</a></li>
                            <li class="breadcrumb-item active"> Create Permissions</li>
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

                            <div>
                                <a href="{{url('/permission') }}" class="btn btn-primary waves-effect waves-light">Back to Permissions</a>
                                
                                <!-- Include modal content -->
                               
                            </div>
                        </div>
                    </div>

            <div class="card-body">

                <form action="/permission" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nama Permission</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Role"
                            class="form-control @error('title') is-invalid @enderror">

                        @error('name')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <BR>
                    <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                        SIMPAN</button>
                    <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                </form>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row --> --}}
@endsection
