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
                        [
                            'bg' => 'bg-success',
                            'title' => 'Jumlah Izin Pengolahan',
                            'value' => Session::get('j_pengolahan'),
                        ],
                        [
                            'bg' => 'bg-info',
                            'title' => 'Jumlah Izin Penyimpanan',
                            'value' => Session::get('j_penyimpanan'),
                        ],
                        [
                            'bg' => 'bg-danger',
                            'title' => 'Jumlah Izin Pengangkutan',
                            'value' => Session::get('j_pengangkutan'),
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
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
                                <h3>Data Perizinan {{ Auth::user()->NAMA_PERUSAHAAN }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="penjualan">
                                    <div class="table-responsive">
                                        <table id="datatable-buttons"
                                            class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Izin</th>

                                                    <th>Tanggal ACC</th>
                                                    <th>Nomor Izin</th>
                                                    <th>Menu Laporan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($result as $item)
                                                    <tr>
                                                        <td>{{ $item->NAMA_TEMPLATE }}
                                                            <br>
                                                            <b>Jenis Izin:</b> {{ $item->nama_opsi ?? 'N/A' }}
                                                        </td>

                                                        <td>{{ $item->TGL_DISETUJUI }}</td>
                                                        <td>{{ $item->NOMOR_IZIN }}</td>
                                                        <td>
                                                            @php

                                                                $show = Crypt::encryptString(
                                                                    $item->ID_PERMOHONAN . ',' . $item->NOMOR_IZIN,
                                                                );
                                                                $filteredUrls = collect($sub_page)
                                                                    ->whereIn(
                                                                        'id_sub_page',
                                                                        collect($result)->pluck('SUB_PAGE'),
                                                                    )
                                                                    ->pluck('url')
                                                                    ->unique()
                                                                    ->toArray();
                                                            @endphp

                                                            <ul class="sub-menu" aria-expanded="false">
                                                                {{-- URL Dinamis --}}
                                                                @foreach ($filteredUrls as $url)
                                                                    @if (!empty($url))
                                                                        <!-- Pastikan URL tidak kosong -->
                                                                        <li><a
                                                                                href="{{ url($url) }}/{{ $show }}">{{ $sub_page->firstWhere('url', $url)->nama_menu }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach

                                                                {{-- Kondisi Khusus --}}
                                                                @php
                                                                    $matchedSubPage = collect($sub_page)
                                                                        ->whereIn(
                                                                            'id_sub_page',
                                                                            collect($result)->pluck('SUB_PAGE'),
                                                                        )
                                                                        ->firstWhere('kategori', 2);
                                                                    $matchedSubPage1 = collect($sub_page)
                                                                        ->whereIn(
                                                                            'id_sub_page',
                                                                            collect($result)->pluck('SUB_PAGE'),
                                                                        )
                                                                        ->firstWhere('kategori', 1);
                                                                    $kusus = collect($sub_page)
                                                                        ->whereIn(
                                                                            'id_sub_page',
                                                                            collect($result)->pluck('SUB_PAGE'),
                                                                        )
                                                                        ->firstWhere('id_sub_menu', 1);
                                                                @endphp

                                                                {{-- Pengolahan --}}
                                                                @if (Session::get('j_pengolahan') > 0)
                                                                    @if ($matchedSubPage)
                                                                        <li><a
                                                                                href="{{ url('/penyimpananMinyakBumi') }}/{{ $show }}">Penyimpanan
                                                                                Minyak Bumi</a></li>
                                                                        <li><a
                                                                                href="{{ url('/eksport-import') }}/{{ $show }}">Ekspor-Impor</a>
                                                                        </li>
                                                                        <li><a
                                                                                href="{{ url('/harga-bbm-jbu') }}/{{ $show }}">Harga
                                                                                BBM JBU</a></li>
                                                                    @endif
                                                                    @if ($kusus)
                                                                        <li><a
                                                                                href="{{ url('/penyimpanan-gas-bumi') }}/{{ $show }}">Penyimpanan
                                                                                Gas Bumi</a></li>
                                                                    @endif
                                                                @endif

                                                                {{-- Niaga --}}
                                                                @if (Session::get('j_niaga') > 0)
                                                                    @if ($matchedSubPage)
                                                                        <li><a
                                                                                href="{{ url('/penyimpananMinyakBumi') }}/{{ $show }}">Penyimpanan
                                                                                Minyak Bumi</a></li>
                                                                        <li><a
                                                                                href="{{ url('/eksport-import') }}/{{ $show }}">Ekspor-Impor</a>
                                                                        </li>
                                                                        <li><a
                                                                                href="{{ url('/harga-bbm-jbu') }}/{{ $show }}">Harga
                                                                                BBM JBU</a></li>
                                                                    @endif
                                                                    @if ($matchedSubPage1)
                                                                        <li><a
                                                                                href="{{ url('/eksport-import') }}/{{ $show }}">Ekspor-Impor</a>
                                                                        </li>
                                                                    @endif
                                                                @endif

                                                                {{-- Pengangkutan --}}
                                                                @if (Session::get('j_pengangkutan') > 0 && $kusus)
                                                                    <li><a
                                                                            href="{{ url('/penyimpanan-gas-bumi') }}/{{ $show }}">Penyimpanan
                                                                            Gas Bumi</a></li>
                                                                @endif

                                                                {{-- Niaga S --}}
                                                                @if (Session::get('j_niaga_s') > 0)
                                                                    <li><a
                                                                            href="{{ url('/progres-pembangunan/show') }}/{{ $show }}">Progres
                                                                            Pembangunan</a></li>
                                                                @endif
                                                            </ul>
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
