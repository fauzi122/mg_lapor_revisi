@extends('layouts.frontand.app')

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
                    {{-- <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">
                            <h3>Data Perizinan {{Auth::user()->NAMA_PERUSAHAAN}}</h3>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="penjualan">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <tr>
                                                   
                                                    <td>NAMA_PERUSAHAAN</td>
                                                    <td>ALAMAT</td>
                                                    <td>nama_provinsi</td>
                                                    <td>nama_kota</td>
                                                    <td>EMAIL_PERUSAHAAN</td>
                                                    <td>EMAIL_PERUSAHAAN</td>
                                                    <td>TELEPON</td>
                                                    <td>ID_TEMPLATE</td>
                                                    <td>NAMA_TEMPLATE</td>
                                                    <td>SUB_PAGE</td> 
                                                    <td>TGL_DISETUJUI</td>
                                                    <td>NOMOR_IZIN</td>
                                                    <td>FILE_IZIN</td>
                                                  </tr>
                                                  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            // $filteredResults = collect($result)
                                            //     ->unique('SUB_PAGE')
                                            //     ->map(function ($resultItem) use ($sub_page) {
                                            //         $matchedSubPage = collect($sub_page)->firstWhere('id_sub_page', $resultItem->SUB_PAGE);
                                            //         return [
                                            //             'NAMA_PERUSAHAAN' => $resultItem->NAMA_PERUSAHAAN,
                                            //             'ALAMAT'          => $resultItem->ALAMAT,
                                            //             'ID_PROVINSI'     => $resultItem->ID_PROVINSI,
                                            //             'nama_provinsi'   => $resultItem->nama_provinsi,
                                            //             'ID_KABKOT'       => $resultItem->ID_KABKOT,
                                            //             'nama_kota'       => $resultItem->nama_kota,
                                            //             'EMAIL_PERUSAHAAN'=> $resultItem->EMAIL_PERUSAHAAN,
                                            //             'NAMA_TEMPLATE'   => $resultItem->NAMA_TEMPLATE,
                                            //             'TELEPON'         => $resultItem->TELEPON,
                                            //             'FILE_IZIN'       => $resultItem->FILE_IZIN,
                                            //             'SUB_PAGE'        => $resultItem->SUB_PAGE,
                                            //             'TGL_DISETUJUI'   => $resultItem->TGL_DISETUJUI,
                                            //             'NOMOR_IZIN'      => $resultItem->NOMOR_IZIN,
                                            //             'nama_opsi'       => $matchedSubPage->nama_opsi ?? 'N/A',
                                            //             'url'             => $matchedSubPage->url ?? '#'
                                            //         ];
                                            //     });
                                            // @endphp

                                            @foreach($result as $item)
                                                <tr>
                                                    <td>{{ $item['NAMA_PERUSAHAAN'] }}</td>
                                                    <td>{{ $item['ALAMAT'] }}</td>
                                                    <td>{{ $item['nama_provinsi'] }}</td>
                                                    <td>{{ $item['nama_kota'] }}</td>
                                                    <td>{{ $item['EMAIL_PERUSAHAAN'] }}</td>
                                                    <td>{{ $item['TELEPON'] }}</td>
                                                    <td>{{ $item['NAMA_TEMPLATE'] }}</td>
                                                    <td>{{ $item['SUB_PAGE'] }}</td>
                                                    <td>{{ $item['nama_opsi'] }}</td>
                                                    <td>{{ $item['TGL_DISETUJUI'] }}</td>
                                                    <td>{{ $item['NOMOR_IZIN'] }}</td>
                                                    <td>{{ $item['FILE_IZIN'] }}</td>
                                                    
                                                    <td>
                                                        <a href="{{ $item['url'] }}">Lihat Laporan</a>
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
    <!-- container-fluid -->
</div>
@endsection
