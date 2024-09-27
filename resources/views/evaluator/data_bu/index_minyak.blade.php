@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Izin Badan Usaha</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Data Izin Badan Usaha</a></li>
                            <li class="breadcrumb-item active">Data Izin Badan Usaha</li>
                        </ol>
                    </div>
                </div>                
            </div>
        </div>
        <!-- end page title -->

        <!-- stats section -->


        <!-- table section -->
        <div class="row">
            <div class="col-12">
                <div class="card">          
                    <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">
                            <h3>Data Izin Badan Usaha Minyak Bumi</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="penjualan">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <tr>
                                                   
                                                    <td>NAMA_PERUSAHAAN</td>
                                                    
                                                    <td>nama_provinsi</td>
                                                    <td>nama_kota</td>
                                                    <td>EMAIL_PERUSAHAAN</td>
                                                    <td>TELEPON</td>
                                                    <td>IZIN</td>
                                                    <td>ALAMAT</td>
                                                    <td>Jenis IZIN</td>
                                                    <td>Nama Opsi</td>
                                                    <td>TGL_DISETUJUI</td> 
                                                    <td>NOMOR_IZIN</td>
                                                    <td>FILE_IZIN</td>
                                                    
                                                  </tr>
                                                  
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($result as $item)
                                                <tr>
                                                    <td>{{ $item->NAMA_PERUSAHAAN }}</td>
                                                    
                                                    <td>{{ $item->nama_provinsi }}</td>
                                                    <td>{{ $item->nama_kota }}</td>
                                                    <td>{{ $item->EMAIL_PERUSAHAAN }}</td>
                                                    <td>{{ $item->TELEPON }}</td>
                                                    <td>{{ $item->NAMA_TEMPLATE }}</td>
                                                    <td>{{ $item->ALAMAT }}</td>
                                                    <td>{{ $item->SUB_PAGE }}</td>
                                                    <td>{{ $item->nama_opsi }}</td>
                                                    <td>{{ $item->TGL_DISETUJUI }}</td>
                                                    <td>{{ $item->NOMOR_IZIN }}</td>
                                                    <td>{{ $item->FILE_IZIN }}</td>
                                                    

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
    <!-- container-fluid -->
</div>
@endsection
