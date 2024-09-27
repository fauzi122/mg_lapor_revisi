@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data User Badan Usaha</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Data User Badan Usaha</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
		@if(session('success'))
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <div class="d-flex justify-content-end mb-3">
                            <!-- Button trigger modal -->
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-filter">
							  Data Filter
							</button>

							<!-- Modal -->

                        </div>
                        <ul class="nav nav-tabs"> --}}
                         
                           
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="penjualan">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Badan Usaha</th>
                                                <th>Email</th>
                                                <th>Npwp</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user_bu as $data)
											<tr>

												<td>{{ $data->name }}</td>
												<td>{{ $data->email }}</td>
												<td>{{ $data->npwp }}</td>
												<td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        Lihat
                                                    </a>

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
        </div>
    </div>
</div>

@endsection
