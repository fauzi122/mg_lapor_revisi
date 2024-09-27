@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Update Negara</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Update Negara</li>
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
                                    <form method="post" action="/master/negara/{{ $negara->id }}" class="form-material m-t-40" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">ID Negara</label>
                                                        <input class="form-control" type="text" id="example-text-input" name="id_negara" value="{{ old('id_negara', $negara->id_negara) }}">
                                                        @error('id_negara')
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
                                                        <label for="example-date-input" class="form-label">Nama Negara</label>
                                                        <input class="form-control" type="text" id="example-text-input" name="nm_negara" value="{{ old('nm_negara', $negara->nm_negara) }}">
                                                        @error('nm_negara')
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
