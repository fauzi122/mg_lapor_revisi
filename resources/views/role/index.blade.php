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
                    <li class="breadcrumb-item text-muted">List Role</li>
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
                                    <h5 class="card-title">List Role</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url('/role/create') }}" class="btn btn-primary waves-effect waves-light">
                                    <i class="bi bi-file-earmark-plus fs-4"></i> Add New Role
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="List Role" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th th class="text-center">No.</th>
                                    <th class="text-center">Nama Role</th>
                                    <th class="text-center">Permissions</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($roles as $no => $role)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                        
                                    <td>
                                        @foreach($role->getPermissionNames() as $permission)
                                            @if(Str::contains($permission, '_ujian'))

                                            <button class="btn btn-sm btn-warning mb-1 mt-1 mr-1">{{ $permission }}</button>

                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        {{-- @can('PPIC_role.edit')  --}}
                                        <a href="/role/edit/{{ $role->id }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </a>
                                        {{-- @endcan  --}}
                                        {{-- @can('PPIC_role.delete')  --}}
                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $role->id }}">
                                            <i class="bi bi-trash3-fill"></i> Delete
                                        </button>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    <h4 class="mb-sm-0 font-size-18"> List Role</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">PPIC</a></li>
                            <li class="breadcrumb-item active"> List Role</li>
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
                                <a href="{{ url('/role/create') }}" class="btn btn-primary waves-effect waves-light">Add New Role</a>
                                
                                <!-- Include modal content -->
                               
                            </div>
                        </div>
                    </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center; width: 6%">No.</th>
                            <th scope="col" style="width: 15%">Nama Role</th>
                            <th scope="col">Permissions</th>
                           
                            <th scope="col" style="text-align: center; width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $no => $role)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                             
                            <td>
                                @foreach($role->getPermissionNames() as $permission)
                                @if(Str::contains($permission, '_ujian'))
                                <button class="btn btn-sm btn-warning mb-1 mt-1 mr-1">{{ $permission }}</button>
                                @endif
                                @endforeach
                            </td>
                            <td class="text-center"> --}}
                                {{-- @can('PPIC_role.edit')  --}}
                                {{-- <a href="/role/edit/{{ $role->id }}" class="btn btn-sm btn-primary">Edit --}}
                                    {{-- <i class="icon-pencil"></i> --}}
                                {{-- </a> --}}
                                {{-- @endcan  --}}
                                {{-- @can('PPIC_role.delete')  --}}
                                {{-- <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $role->id }}"> --}}
                                    {{-- <i class="icon-trash"></i> Delete --}}
                                {{-- </button> --}}
                                {{-- @endcan --}}
                            {{-- </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row --> --}}

@endsection
