@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Dashboard</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        {{-- Card Total Izin --}}
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            @php
                $cards = [
                    [
                        'bg' => 'bg-primary', 
                        'title' => 'Jumlah Izin Niaga', 
                        'value' => Session::get('j_niaga')],
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
                <div class="col-lg-3">
                    <div class="card card-flush h-xl-100 {{ $card['bg'] }}">
                        <div class="card-header flex-nowrap">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-semibold fs-5 text-white">{{ $card['title'] }}</span>
                            </h3>
                        </div>
                        <div class="card-body text-center pt-5">
                            <div class="text-start">
                                <span class="d-block fw-bold fs-1 text-white">{{ $card['value'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Table --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-5 mb-xl-8 shadow">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Data Perizinan </span>
                            <span class="text-muted mt-1 fw-semibold fs-7">"{{ Auth::user()->name }}"</span>
                        </h3>
                    </div>
                    {{-- Start --}}
                    <div class="card-body p-3">
                        <div class="card">
                            <div class="card-header align-items-center px-2">
                                <div class="card-toolbar"></div> <!-- Export & Col Visible Table -->
                                <div class="card-title flex-row-fluid justify-content-end gap-5">
                                    <input type="hidden" class="export-title" value="Data Perizinan" />
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <table class="kt-datatable table table-bordered table-hover">
                                    <thead class="bg-light">
                                        <tr class="fw-bold text-uppercase">
                                            <th>Izin</th>
                                            <th>Tanggal ACC</th>
                                            <th>Nomor Izin</th>
                                            <th>Menu Laporan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($result as $item)
                                            <tr class="align-top">
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
                                                                <li>
                                                                    <a href="{{ url($url) }}/{{ $show }}">{{ $sub_page->firstWhere('url', $url)->nama_menu }}</a>
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
                                                                <li>
                                                                    <a href="{{ url('/penyimpananMinyakBumi') }}/{{ $show }}">Penyimpanan Minyak Bumi</a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ url('/eksport-import') }}/{{ $show }}">Ekspor-Impor</a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ url('/harga-bbm-jbu') }}/{{ $show }}">Harga BBM JBU</a>
                                                                </li>
                                                            @endif
                                                            @if ($kusus)
                                                                <li>
                                                                    <a href="{{ url('/penyimpanan-gas-bumi') }}/{{ $show }}">Penyimpanan Gas Bumi</a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                        {{-- Niaga --}}
                                                        @if (Session::get('j_niaga') > 0)
                                                            @if ($matchedSubPage)
                                                                <li>
                                                                    <a href="{{ url('/penyimpananMinyakBumi') }}/{{ $show }}">Penyimpanan Minyak Bumi</a></li>
                                                                <li>
                                                                    <a href="{{ url('/eksport-import') }}/{{ $show }}">Ekspor-Impor</a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ url('/harga-bbm-jbu') }}/{{ $show }}">Harga BBM JBU</a>
                                                                </li>
                                                            @endif
                                                            @if ($matchedSubPage1)
                                                                <li>
                                                                    <a href="{{ url('/eksport-import') }}/{{ $show }}">Ekspor-Impor</a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                        {{-- Pengangkutan --}}
                                                        @if (Session::get('j_pengangkutan') > 0 && $kusus)
                                                            <li>
                                                                <a href="{{ url('/penyimpanan-gas-bumi') }}/{{ $show }}">Penyimpanan Gas Bumi</a>
                                                            </li>
                                                        @endif
                                                        {{-- Niaga S --}}
                                                        @if (Session::get('j_niaga_s') > 0)
                                                            <li>
                                                                <a href="{{ url('/progres-pembangunan/show') }}/{{ $show }}">Progres Pembangunan</a>
                                                            </li>
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
                    {{-- Finish --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection