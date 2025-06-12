@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">User Access</h3>
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
                    <li class="breadcrumb-item text-muted">User Access</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Edit Access</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        @if (session('pesan'))
            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                <i class="mdi mdi-check-all label-icon"></i>
                <strong>Success</strong> - {{ session('pesan') }}
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
                                    <h5 class="card-title">Edit Users</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url('/user') }}" class="btn btn-primary waves-effect waves-light">
                                    <i class="bi bi-arrow-left"></i> Back to User List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        <form action="{{ url('/user/update/admin') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="encrypted_id" value="{{ $encryptedId }}">
                            <div class="row p-4">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nip" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">NIP</span>
                                        </label>
                                        
                                        <input type="text" name="nip" value="{{ old('nip', optional($user->profilAdmin)->nip) }}" class="form-control @error('nip') is-invalid @enderror" id="nip">
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Email</span>
                                        </label>
                                        <input type="email" name="email" value="{{ old('email', optional($user->profilAdmin)->email) }}" class="form-control @error('email') is-invalid @enderror" id="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Name</span>
                                        </label>
                                        <input type="text" name="name" value="{{ old('name', optional($user->profilAdmin)->name) }}" class="form-control @error('name') is-invalid @enderror" id="name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="jabatan" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Jabatan Struktural</span>
                                        </label>
                                        <select class="form-control @error('id_jabatan') is-invalid @enderror" name="id_jabatan" id="jabatan">
                                            @foreach ($jabatan as $item)
                                                <option value="{{ $item->id }}" {{ old('id_jabatan', optional($user->profilAdmin)->id_jabatan) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nm_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nik" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">NIK</span>
                                        </label>
                                        <input type="number" name="nik" value="{{ old('nik', optional($user->profilAdmin)->nik) }}" class="form-control @error('nik') is-invalid @enderror" id="nik">
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tingkat" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Tingkat</span>
                                        </label>
                                        <input type="text" name="tingkat" value="{{ old('tingkat', optional($user->profilAdmin)->tingkat) }}" class="form-control @error('tingkat') is-invalid @enderror" id="tingkat">
                                        @error('tingkat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Password</span>
                                        </label>
                                        <input type="password" name="password" placeholder="Leave blank if not changing" class="form-control @error('password') is-invalid @enderror" id="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tte" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">TTE</span>
                                        </label>
                                        <select class="form-control @error('tte') is-invalid @enderror" name="tte" id="tte">
                                            <option value="iya" {{ old('tte', optional($user->profilAdmin)->tte) == 'iya' ? 'selected' : '' }}>Iya</option>
                                            <option value="tidak" {{ old('tte', optional($user->profilAdmin)->tte) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                        @error('tte')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="sso" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">SSO</span>
                                        </label>
                                        <select class="form-control @error('sso') is-invalid @enderror" name="sso" id="sso">
                                            <option value="non sso" {{ old('sso', optional($user->profilAdmin)->sso) == 'non sso' ? 'selected' : '' }}>Non SSO</option>
                                            <option value="sso" {{ old('sso', optional($user->profilAdmin)->sso) == 'sso' ? 'selected' : '' }}>SSO</option>
                                        </select>
                                        @error('sso')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4 p-4">
                                <label for="role" class="font-weight-bold">Role</label>
                                <div class="row">
                                    @foreach ($roles as $role)
                                        <div class="col-md-4 p-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="role[]" value="{{ $role->name }}"
                                                    id="check-{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="check-{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mb-3 p-3">
                                <button type="submit" class="btn btn-primary me-2"><i class="fa fa-paper-plane"></i> Update</button>
                                <a href="{{ url('/user') }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
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
                <i class="mdi mdi-check-all label-icon"></i>
                <strong>Success</strong> - {{ session('pesan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit User</h4>
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
                        <form action="{{ url('/user/update/admin') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="encrypted_id" value="{{ $encryptedId }}">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nip">NIP*</label>
                                        <input type="text" name="nip" value="{{ old('nip', optional($user->profilAdmin)->nip) }}" class="form-control @error('nip') is-invalid @enderror" id="nip">
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email">Email*</label>
                                        <input type="email" name="email" value="{{ old('email', optional($user->profilAdmin)->email) }}" class="form-control @error('email') is-invalid @enderror" id="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name">Name*</label>
                                        <input type="text" name="name" value="{{ old('name', optional($user->profilAdmin)->name) }}" class="form-control @error('name') is-invalid @enderror" id="name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="jabatan">Jabatan Struktural*</label>
                                        <select class="form-control @error('id_jabatan') is-invalid @enderror" name="id_jabatan" id="jabatan">
                                            @foreach ($jabatan as $item)
                                                <option value="{{ $item->id }}" {{ old('id_jabatan', optional($user->profilAdmin)->id_jabatan) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nm_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nik">NIK*</label>
                                        <input type="number" name="nik" value="{{ old('nik', optional($user->profilAdmin)->nik) }}" class="form-control @error('nik') is-invalid @enderror" id="nik">
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tingkat">Tingkat*</label>
                                        <input type="text" name="tingkat" value="{{ old('tingkat', optional($user->profilAdmin)->tingkat) }}" class="form-control @error('tingkat') is-invalid @enderror" id="tingkat">
                                        @error('tingkat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" placeholder="Leave blank if not changing" class="form-control @error('password') is-invalid @enderror" id="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tte">TTE*</label>
                                        <select class="form-control @error('tte') is-invalid @enderror" name="tte" id="tte">
                                            <option value="iya" {{ old('tte', optional($user->profilAdmin)->tte) == 'iya' ? 'selected' : '' }}>Iya</option>
                                            <option value="tidak" {{ old('tte', optional($user->profilAdmin)->tte) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                        @error('tte')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="sso">SSO*</label>
                                        <select class="form-control @error('sso') is-invalid @enderror" name="sso" id="sso">
                                            <option value="non sso" {{ old('sso', optional($user->profilAdmin)->sso) == 'non sso' ? 'selected' : '' }}>Non SSO</option>
                                            <option value="sso" {{ old('sso', optional($user->profilAdmin)->sso) == 'sso' ? 'selected' : '' }}>SSO</option>
                                        </select>
                                        @error('sso')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="role" class="font-weight-bold">Role</label>
                                <div class="row">
                                    @foreach ($roles as $role)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="role[]" value="{{ $role->name }}"
                                                    id="check-{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="check-{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2"><i class="fa fa-paper-plane"></i> Update</button>
                                <a href="{{ url('/user') }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
