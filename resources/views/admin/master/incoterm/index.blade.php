@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Incoterm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Incoterm</li>
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
                            <a href="/master/inco-term/create" class="btn btn-primary">Input Incoterm</a>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#penjualan">Incoterm</a>
                            </li>
                           
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="penjualan">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Incoterm</th>
                                                <th>Keterangan</th>
                                                <th>Action</th>
                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($inco as $inco)
                                            <tr>
                                                <td>{{ $inco->incoterm }}</td>
                                                <td>{{ $inco->ket }}</td>
                                                <td class="text-nowrap" align="center">
                                                    <a href="/master/inco-term/{{ $inco->id }}/edit">
                                                        <button type="button" class="btn btn-info waves-effect waves-light">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <form action="/master/inco-term/{{ $inco->id }}" method="post"
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
