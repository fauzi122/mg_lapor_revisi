@extends('layouts.blackand.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- Success Message Alert -->
        @if (session('pesan'))
            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                <i class="mdi mdi-check-all label-icon"></i>
                <strong>Success</strong> - {{ session('pesan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Title and Breadcrumbs -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Role Access</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">PPIC</a></li>
                            <li class="breadcrumb-item active">Edit Role Access</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Edit Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url('/role/create') }}" class="btn btn-primary waves-effect waves-light">Back to Role</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="/role/update/{{ $role->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="name">NAMA ROLE</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" placeholder="Masukkan Nama Role"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
 
                            <div class="form-group">
                                <br>
                                <br>
                                <label class="font-weight-bold">PERMISSIONS</label>
                                <br> <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>BBM dan Minyak Bumi</h5>
                                        @foreach ($permissions as $permission)
                                            @if (in_array($permission->name, ['Laporan Badan Usaha Minyak', 'Investasi Minyak Bumi', 'Fasilitas Pengangkutan Minyak Bumi', 'Subsidi BBM','Minyak Bumi']))
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" id="check-{{ $permission->id }}" value="{{ $permission->name }}"
                                                        @if($role->permissions->contains($permission)) checked @endif>
                                                    <label class="form-check-label" for="check-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Gas dan LPG</h5>
                                        @foreach ($permissions as $permission)
                                            @if (in_array($permission->name, ['Investasi Minyak Gas', 'Fasilitas Pengangkutan Gas Bumi', 'Subsidi LPG','LPG/GAS']))
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" id="check-{{ $permission->id }}" value="{{ $permission->name }}"
                                                        @if($role->permissions->contains($permission)) checked @endif>
                                                    <label class="form-check-label" for="check-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <br>
                                        <h5>Administrator</h5>
                                        @foreach ($permissions as $permission)
                                            @if (in_array($permission->name, ['user', 'permission', 'role', 'Master Data']))
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" id="check-{{ $permission->id }}" value="{{ $permission->name }}"
                                                        @if($role->permissions->contains($permission)) checked @endif>
                                                    <label class="form-check-label" for="check-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> UPDATE</button>
                            <button class="btn btn-danger btn-reset" type="reset"><i class="fa fa-remove"></i> RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
