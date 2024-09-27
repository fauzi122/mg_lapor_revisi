@extends('layouts.frontand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>                
            </div>
        </div>
        <!-- end page title -->

        <!-- stats section -->
        <div class="row text-center">
            @php
            $cards = [
       
                ['bg' => 'bg-primary', 'title' => 'Jumlah Izin Niaga', 'value' => Session::get('j_niaga')],
                ['bg' => 'bg-success', 'title' => 'Jumlah Izin Pengolahan', 'value' => Session::get('j_pengolahan')],
                ['bg' => 'bg-info', 'title' => 'Jumlah Izin Penyimpanan', 'value' => Session::get('j_penyimpanan')],
                ['bg' => 'bg-danger', 'title' => 'Jumlah Izin Pengangkutan', 'value' => Session::get('j_pengangkutan')]
            ];
            @endphp

            @foreach($cards as $card)
            <div class="col-xl-3 col-md-6">
                <div class="card {{ $card['bg'] }} text-white-50">
                    <div class="card-body">
                        <h5 class="mb-3 text-white">{{ $card['title'] }}</h5>
                        <h1 class="card-text text-white mb-3">{{ $card['value'] }}</h1>
                    </div>
                </div>
            </div>
            @endforeach
        </div><!-- end row -->

        <!-- table section -->
        <div class="row">
            <div class="col-12">
                <div class="card">          
                    <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">
                            <h3>Data Perizinan {{Auth::user()->NAMA_PERUSAHAAN}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="penjualan">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Izin</th>
                                                {{-- <th>Jenis Izin</th> --}}
                                                <th>Jenis Izin</th>
                                               
                                                <th>Tanggal ACC</th>
                                                <th>Nomer Izin</th>
                                                 <th>Laporan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $filteredResults = collect($result)
                                                ->unique('SUB_PAGE')
                                                ->map(function ($resultItem) use ($sub_page) {
                                                    $matchedSubPage = collect($sub_page)->firstWhere('id_sub_page', $resultItem->SUB_PAGE);
                                                    return [
                                                        'NAMA_TEMPLATE' => $resultItem->NAMA_TEMPLATE,
                                                        'SUB_PAGE' => $resultItem->SUB_PAGE,
                                                        'TGL_DISETUJUI' => $resultItem->TGL_DISETUJUI,
                                                        'NOMOR_IZIN' => $resultItem->NOMOR_IZIN,
                                                        'nama_opsi' => $matchedSubPage->nama_opsi ?? 'N/A',
                                                        'url' => $matchedSubPage->url ?? '#'
                                                    ];
                                                });
                                            @endphp

                                            @foreach($filteredResults as $item)
                                                <tr>
                                                    <td>{{ $item['NAMA_TEMPLATE'] }}</td>
                                                    {{-- <td>{{ $item['SUB_PAGE'] }}</td> --}}
                                                    <td>{{ $item['nama_opsi'] }}</td>
                                                    <td>{{ $item['TGL_DISETUJUI'] }}</td>
                                                    <td>{{ $item['NOMOR_IZIN'] }}</td>
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
