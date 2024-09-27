@extends('layouts.frontand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Bahan Bakar Minyak</h4>
                </div>
            </div>
        </div>

        {{-- Penjualan JBKP --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Penjualan JBKP</h5>
                            {{-- Add your buttons or actions here if needed --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="mb-3"> <!-- Add some bottom margin -->
                                <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
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
                                            {{-- Add more table columns if needed --}}
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
                                            {{-- Add more table cells if needed --}}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        {{-- Penjualan JBT --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Penjualan JBT</h5>
                            {{-- Add your buttons or actions here if needed --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                <!-- Table header content goes here -->
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
                                        {{-- Add more table columns if needed --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table rows with data go here -->
                                    <tr>
                                        <td>1</td>
                                        <td>Juli 2023</td>
                                        <td>Olahan A</td>
                                        <td>Jawa Timur</td>
                                        <td>Surabaya</td>
                                        <td>Sektor XYZ</td>
                                        <td>1000</td>
                                        <td>Liter</td>
                                        {{-- Add more table cells if needed --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Penjualan JBU --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Penjualan JBU</h5>
                            {{-- Add your buttons or actions here if needed --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table3" class="table table-bordered dt-responsive nowrap w-100">
                                <!-- Table header content goes here -->
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
                                        {{-- Add more table columns if needed --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table rows with data go here -->
                                    <tr>
                                        <td>1</td>
                                        <td>Juli 2023</td>
                                        <td>Olahan A</td>
                                        <td>Jawa Timur</td>
                                        <td>Surabaya</td>
                                        <td>Sektor XYZ</td>
                                        <td>1000</td>
                                        <td>Liter</td>
                                        {{-- Add more table cells if needed --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pasokan BBM --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pasokan BBM</h5>
                            {{-- Add your buttons or actions here if needed --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table4" class="table table-bordered dt-responsive nowrap w-100">
                                <!-- Table header content goes here -->
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
                                        {{-- Add more table columns if needed --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table rows with data go here -->
                                    <tr>
                                        <td>1</td>
                                        <td>Juli 2023</td>
                                        <td>Olahan A</td>
                                        <td>Jawa Timur</td>
                                        <td>Surabaya</td>
                                        <td>Sektor XYZ</td>
                                        <td>1000</td>
                                        <td>Liter</td>
                                        {{-- Add more table cells if needed --}}
                                    </tr>
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

