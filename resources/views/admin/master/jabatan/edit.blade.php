@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Input Jabatan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Input Jabatan</li>
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
                                    <form method="post" action="/master/jabatan/{{ $jabatan->id }}" class="form-material m-t-40" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Nama jabatan</label>
                                                        <input class="form-control" type="text" id="example-text-input" name="nm_jabatan" value="{{ old('nm_jabatan',$jabatan->nm_jabatan) }}">
                                                        @error('nm_jabatan')
                                                            <div class="form-group has-danger mb-0">
                                                                <div class="form-control-feedback">{{ $message }}</div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                    <button type="submit" class="btn btn-primary w-md">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
    </div>
</div>
@endsection
