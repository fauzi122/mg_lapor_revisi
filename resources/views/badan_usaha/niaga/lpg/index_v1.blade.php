@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">LPG</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">LPG</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Juli 2023</td>
                                            <td>Olahan A</td>
                                            <td>Jawa Timur</td>
                                            <td>Surabaya</td>
                                            <td>Sektor XYZ</td>
                                            <td>1000</td>
                                            <td>Liter</td>
                                            <td><a href="/lpg/show" class="btn btn-sm btn-primary">Buat Laporan</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Agustus 2023</td>
                                            <td>Olahan B</td>
                                            <td>Jawa Barat</td>
                                            <td>Bandung</td>
                                            <td>Sektor ABC</td>
                                            <td>500</td>
                                            <td>Kilogram</td>
                                            <td><a href="/lpg/show" class="btn btn-sm btn-primary">Buat Laporan</a></td>
                                        </tr>
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
@endsection
