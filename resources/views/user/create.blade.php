@extends('layouts.blackand.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">
        @if (session('pesan'))
            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                <i class="mdi mdi-check-all label-icon"></i>
                <strong>Success</strong> - {{ session('pesan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add New User</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Evaluator</a></li>
                            <li class="breadcrumb-item active">Add User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       
                        <a href="{{ url('/user') }}" class="btn btn-secondary waves-effect waves-light">
                            <i class="mdi mdi-arrow-left"></i> Back to User List
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="/user" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="username">NIP</label>
                                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Enter NIP"
                                            class="form-control @error('username') is-invalid @enderror" id="username">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email"
                                            class="form-control @error('email') is-invalid @enderror" id="email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter user name"
                                            class="form-control @error('name') is-invalid @enderror" id="name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="jabatan">Jabatan Struktural</label>
                                        <select class="form-control @error('id_jabatan') is-invalid @enderror" name="id_jabatan" id="jabatan">
                                            <option value="ADM">Evaluator</option>
                                            <option value="MHS">Mahasiswa</option>
                                            <option value="BSI3">Administrasi</option>
                                            <option value="BSI6">Dosen Honorer</option> 
                                        </select>
                                        @error('id_jabatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nik">NIK</label>
                                        <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Enter NIK"
                                            class="form-control @error('nik') is-invalid @enderror" id="nik">
                                        @error('nik')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tingkat">Tingkat</label>
                                        <input type="text" name="tingkat" value="{{ old('tingkat') }}" placeholder="Enter Tingkat"
                                            class="form-control @error('tingkat') is-invalid @enderror" id="tingkat">
                                        @error('tingkat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" value="{{ old('password') }}" placeholder="Enter password"
                                                    class="form-control @error('password') is-invalid @enderror" id="password">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input type="password" name="password_confirmation" placeholder="Confirm password"
                                                    class="form-control" id="password_confirmation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Role Section -->
                            <div class="form-group mb-4">
                                <label for="role" class="font-weight-bold">Role</label>
                                <div class="row">
                                    @foreach ($roles as $role)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="role[]" value="{{ $role->name }}" id="check-{{ $role->id }}">
                                                <label class="form-check-label" for="check-{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-paper-plane"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fa fa-redo"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
