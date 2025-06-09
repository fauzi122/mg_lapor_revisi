@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Data Izin Badan Usaha</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Daftar Badan Usaha</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Data Izin Badan Usaha</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card-body p-3">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <h3>Data Izin Badan Usaha Gas</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Data Izin Badan Usaha Gas" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th class="text-center">No</th>
                                    <td class="text-center">Nama Perusahaan</td>                                               
                                    <td class="text-center">Nama Provinsi</td>
                                    <td class="text-center">Nama Kota</td>
                                    <td class="text-center">Email Perusahaan</td>
                                    <td class="text-center">Telepon</td>
                                    <td class="text-center">Izin</td>
                                    <td class="text-center">Alamat</td>
                                    <td class="text-center">Jenis Izin</td>
                                    <td class="text-center">Nama Opsi</td>
                                    <td class="text-center">Tanggal Disetujui</td> 
                                    <td class="text-center">Nomor Izin</td>
                                    <td class="text-center">File Izin</td>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach($result as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
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



{{-- <div class="page-content">
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
                            <h3>Data Izin Badan Usaha Gas</h3>
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
</div> --}}
@endsection
