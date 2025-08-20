@extends('layouts.blackand.app')

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">Edit Email</h3>
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
                            <a href="{{ url('/master/email') }}" class="text-muted text-hover-primary">Email</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                        <li class="breadcrumb-item text-muted">Edit Email</li>
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
                    <form method="post" action="{{ url('/master/email/' . $email->id) }}" class="form-material m-t-40"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="example-text-input"
                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">Subject</label>
                                    <textarea class="form-control form-control-solid" name="subject" cols="30" rows="5">{{ old('subject', $email->subject) }}</textarea>
                                    @error('subject')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="example-text-input"
                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">Content</label>
                                    <textarea class="form-control form-control-solid" name="content" cols="30" rows="5">{{ old('content', $email->content) }}</textarea>
                                    @error('content')
                                        <div class="form-group has-danger mb-0">
                                            <div class="form-control-feedback">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
