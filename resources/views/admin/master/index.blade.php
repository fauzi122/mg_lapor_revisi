@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan Hasil Olahan/Minyak Bumi</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Laporan Hasil Olahan/Minyak Bumi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="/create/hasil-olahan/minyak-bumi" class="btn btn-primary">Buat Laporan</a>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#penjualan">Penjualan Hasil Olahan/Minyak Bumi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#pasokan">Pasokan Hasil Olahan/Minyak Bumi</a>
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
                                                <th>Bulan</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Juli 2023</td>
                                                <td>Olahan A</td>
                                                <td>Jawa Timur</td>
                                                <td>Surabaya</td>
                                                <td>Sektor XYZ</td>
                                                <td>1000</td>
                                                <td>Liter</td>
                                            </tr>
                                            <tr>
                                                <td>Agustus 2023</td>
                                                <td>Olahan B</td>
                                                <td>Jawa Barat</td>
                                                <td>Bandung</td>
                                                <td>Sektor ABC</td>
                                                <td>500</td>
                                                <td>Kilogram</td>
                                            </tr>
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pasokan">
                                <div class="table-responsive">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Cari...">
                                    </div>
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Juli 2023</td>
                                                <td>Olahan C</td>
                                                <td>Jawa Tengah</td>
                                                <td>Semarang</td>
                                                <td>Sektor PQR</td>
                                                <td>800</td>
                                                <td>Liter</td>
                                            </tr>
                                            <tr>
                                                <td>Agustus 2023</td>
                                                <td>Olahan D</td>
                                                <td>Jawa Barat</td>
                                                <td>Bandung</td>
                                                <td>Sektor XYZ</td>
                                                <td>600</td>
                                                <td>Kilogram</td>
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
    </div>
</div>
@endsection
