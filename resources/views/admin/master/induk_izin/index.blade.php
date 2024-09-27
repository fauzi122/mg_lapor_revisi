@extends('layouts.blackand.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Data Izin</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                        <li class="breadcrumb-item active">Data Izin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                 {{--  @if (session()->has('success'))
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script>
                                    swal("{{ session('success') }}", "", "success");
                    </script>
                @endif
                <div class="card-header">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="/master/produk/create" class="btn btn-primary">Input Izin</a>
                    </div>
                    <ul class="nav nav-tabs">
                     
                       
                    </ul>
                </div>  --}}
             
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="penjualan">
                            <div class="table-responsive">
    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
        <thead>
            <tr>
              
                <th>Kode</th>
                <th>Nama Izin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($izin as $izin)
            <tr>
    
                <td>{{ $izin->izin }}</td>
                <td>{{ $izin->nm_izin }}</td>

                <td class="text-nowrap" align="center">
                    <a href="/master/meping/{{ $izin->izin }}/show">
                        <button type="button" class="btn btn-info waves-effect waves-light" title="show jenis izin">
                            Jenis Izin
                        </button>
                    </a>
                    {{-- <a href="/master/meping/{{ $izin->izin }}/show">
                        <button type="button" class="btn btn-danger waves-effect waves-light">
                            Menu Izin
                        </button>
                    </a> --}}

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
@endsection


