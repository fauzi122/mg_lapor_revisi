@extends('layouts.blackand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                            <h4>{{ $per->nama_badan_usaha }}</h4>

                        </div>

                    </div>
                </div>
            </div>

            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Periode Bulan {{ bulan($per->bulan) }}</h4>

                                    <div>
                                        <a href="{{ url('laporan/penjualan-bbm/periode') . '/' . \Illuminate\Support\Facades\Crypt::encryptString($per->npwp_badan_usaha) }}"
                                            class="btn btn-danger btn-sm btn-rounded"><i class='bx bx-arrow-back'></i>
                                            Kembali</a>
                                    </div>


                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Produk</th>
                                                <th>Sumber</th>
                                                <th>Supplier</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $bbm)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ bulan($bbm->bulan) }}</td>
                                                    <td>{{ $bbm->tahun }}</td>
                                                    <td>{{ $bbm->produk }}</td>
                                                    <td>{{ $bbm->sumber }}</td>
                                                    <td>{{ $bbm->supplier }}</td>
                                                    <td>{{ $bbm->volume }}</td>
                                                    <td>{{ $bbm->satuan }}</td>
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
            @endif
        </div>
    </div>

@endsection
