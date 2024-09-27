@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Negara</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Data Negara</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (session()->has('success'))
                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                        <script>
                                        swal("{{ session('success') }}", "", "success");
                        </script>
                    @endif
                    <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="/master/negara/create" class="btn btn-primary">Input Negara</a>
                        </div>
                        <ul class="nav nav-tabs">
                           
                           
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="penjualan">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Id Negara</th>
                                                <th>Nama Negara</th>
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($negara as $negara)
                                            <tr>
                                                <td>{{ $negara->id_negara }}</td>
                                                <td>{{ $negara->nm_negara }}</td>
                                                <td class="text-nowrap" align="center">
                                                    <a href="/master/negara/{{ $negara->id }}/edit">
                                                        <button type="button" class="btn btn-info waves-effect waves-light">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <form action="/master/negara/{{ $negara->id }}" method="post"
                                                            class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button class="btn btn-danger waves-effect waves-light"
                                                                onclick="return confirm('Yakin ingin menghapus data?')">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </button>
                                                    </form>
                                                </td>
                                             
                                            </tr>
                                        @endforeach
                                            <!-- Add more rows as needed -->
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
