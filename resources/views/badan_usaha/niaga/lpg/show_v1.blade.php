@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan LPG</h4>
                    </div>
                </div>
            </div>

            {{-- Penjualan LNG/CNG --}}
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Penjualan LPG</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan</button>
                                    @include('badan_usaha.niaga.hasil_olahan.modal')
                                    <a href="/create/hasil-olahan/minyak-bumi" class="btn btn-success">Import Excel</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Produk</th>
                                            <th>Konsumen</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan (MMBTU)</th>
                                            <th>Biaya Kompresi/Regasifikasi (USD/MMBTU)</th>
                                            <th>Biaya Penyimpanan (USD/MMBTU)</th>
                                            <th>Biaya Pengangkutan (USD/MMBTU)</th>
                                            <th>Biaya Niaga (USD/MMBTU)</th>
                                            <th>Harga Jual (USD/MMBTU)</th>
                                            <th></th> <!-- Kolom untuk tombol detail -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Juli 2023</td>
                                            <td>Jawa Timur</td>
                                            <td>Surabaya</td>
                                            <td>Olahan A</td>
                                            <td>Konsumen A</td>
                                            <td>Sektor XYZ</td>
                                            <td>1000</td>
                                            <td>Liter</td>
                                            <td>10</td>
                                            <td>5</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>15</td>
                                            <td>
                                                <a href="/detail/1" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Agustus 2023</td>
                                            <td>Jawa Barat</td>
                                            <td>Bandung</td>
                                            <td>Olahan B</td>
                                            <td>Konsumen B</td>
                                            <td>Sektor ABC</td>
                                            <td>500</td>
                                            <td>Kilogram</td>
                                            <td>12</td>
                                            <td>6</td>
                                            <td>3</td>
                                            <td>1.5</td>
                                            <td>18</td>
                                            <td>
                                                <a href="/detail/2" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pasokan LNG/CNG --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Pasokan LNG/CNG</h5>
                                <div>
                                    <a href="/create/hasil-olahan/minyak-bumi" class="btn btn-primary me-2">Buat Laporan</a>
                                    <a href="/create/hasil-olahan/minyak-bumi" class="btn btn-success">Import Excel</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Produk</th>
                                            <th>Konsumen</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan (MMBTU)</th>
                                            <th>Harga Jual (USD/MMBTU)</th>
                                            <th></th> <!-- Kolom untuk tombol detail -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Juli 2023</td>
                                            <td>Jawa Timur</td>
                                            <td>Surabaya</td>
                                            <td>Olahan A</td>
                                            <td>Konsumen A</td>
                                            <td>Sektor XYZ</td>
                                            <td>1000</td>
                                            <td>Liter</td>
                                            <td>15</td>
                                            <td>
                                                <a href="/detail/1" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Agustus 2023</td>
                                            <td>Jawa Barat</td>
                                            <td>Bandung</td>
                                            <td>Olahan B</td>
                                            <td>Konsumen B</td>
                                            <td>Sektor ABC</td>
                                            <td>500</td>
                                            <td>Kilogram</td>
                                            <td>18</td>
                                            <td>
                                                <a href="/detail/2" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pasokan LNG/CNG --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Harga LNG/CNG</h5>
                                <div>
                                    <a href="/create/hasil-olahan/minyak-bumi" class="btn btn-primary me-2">Buat Laporan</a>
                                    <a href="/create/hasil-olahan/minyak-bumi" class="btn btn-success">Import Excel</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table3" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Volume</th>
                                            <th>Biaya Perolehan</th>
                                            <th>Biaya Distribusi</th>
                                            <th>Biaya Penyimpanan</th>
                                            <th>Margin</th>
                                            <th>PPN</th>
                                            <th>PBBKP</th>
                                            <th>Harga Jual</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Juli 2023</td>
                                            <td>Olahan A</td>
                                            <td>Jawa Timur</td>
                                            <td>1000</td>
                                            <td>2000</td>
                                            <td>500</td>
                                            <td>300</td>
                                            <td>800</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>4000</td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-info"><i class="bx bx-edit-alt"
                                                        title="Edit data"></i></a>
                                                <a href="" class="btn btn-sm btn-danger"> <i class="bx bx-trash-alt"
                                                        title="Hapus data"></i></a>
                                            </td>
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

    <script>
        document.querySelector('.btn-primary').addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    </script>
@endsection
