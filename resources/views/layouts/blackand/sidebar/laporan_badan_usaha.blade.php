@php
    $laporanPaths = [
        'laporan/jual-hasil-olahan',
        'laporan/pasokan-hasil-olahan',
        'laporan/harga-bbm',
        'laporan/harga-lpg',
        'laporan/jual/lng-cng-bbg',
        'laporan/pasok/lng-cng-bbg',
        'laporan/jual/lpg',
        'laporan/pasok/lpg',
        'laporan/jual/gbmp',
        'laporan/pasok/gbmp',
        'laporan/produksi/mb',
        'laporan/pasokan/mb',
        'laporan/distribusi/mb',
        'laporan/produksi/gb',
        'laporan/pasokan/gb',
        'laporan/distribusi/gb',
        'laporan/expor/exim',
        'laporan/impor/exim',
        'laporan/penyimpanan/mb',
        'laporan/penyimpanan/gb',
        'laporan/pengangkutan/mb',
        'laporan/pengangkutan/gb',
    ];
    $isLaporanBUActive = request()->is($laporanPaths);

@endphp




<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isLaporanBUActive ? 'show here' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-file-earmark-text-fill"></i>
        </span>
        <span class="menu-title">Laporan Badan Usaha</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->

    {{-- Hasil Olahan/Minyak bumi --}}

    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        @can('Minyak Bumi')
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/jual-hasil-olahan', 'laporan/pasokan-hasil-olahan') ? 'show here' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Hasil Olahan/Minyak Bumi</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/jual-hasil-olahan') ? 'active shadow' : '' }}" href="{{ url('/laporan/jual-hasil-olahan') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Penjualan Hasil Olahan/Minyak Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pasokan-hasil-olahan') ? 'active shadow' : '' }}" href="{{ url('/laporan/pasokan-hasil-olahan') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pasokan Hasil Olahan/Minyak Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
            </div>
        @endcan
    </div>

    {{-- Harga --}}

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/harga-bbm', 'laporan/harga-lpg') ? 'show here' : '' }} ">
            <!--begin:Menu link-->
            <span class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Harga</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->

            {{-- Harga BBM --}}

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <!--begin:Menu item-->
                @can('Minyak Bumi')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/harga-bbm') ? 'active shadow' : '' }}" href="{{ url('/laporan/harga-bbm') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Harga BBM JBU</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endcan

                {{-- Harga LPG --}}
                <!--begin:Menu item-->
                @can('LPG/GAS')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/harga-lpg') ? 'active shadow' : '' }}" href="{{ url('/laporan/harga-lpg') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Harga LPG</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
            </div>
        </div>
    </div>
    
    
    @can('LPG/GAS')

        {{-- LNG/CNG/BNG --}}

        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion">
            <!--begin:Menu item-->

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/jual/lng-cng-bbg', 'laporan/pasok/lng-cng-bbg') ? 'show here' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">LNG/CNG/BNG</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->

                {{-- Penjualan LNG/CNG/BNG --}}

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/jual/lng-cng-bbg') ? 'active shadow' : '' }}" href="{{ url('/laporan/jual/lng-cng-bbg') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Penjualan LNG/CNG/BNG</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    {{-- Pasokan LNG/CNG/BNG --}}
                    
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pasok/lng-cng-bbg') ? 'active shadow' : '' }}" href="{{ url('/laporan/pasok/lng-cng-bbg') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pasokan LNG/CNG/BNG</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
            </div>
        </div>
        
        
        {{-- LPG --}}

        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion">
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/jual/lpg', 'laporan/pasok/lpg') ? 'show here' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">LPG</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->

                {{-- Penjualan LPG --}}

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/jual/lpg') ? 'active shadow' : '' }}" href="{{ url('/laporan/jual/lpg') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Penjualan LPG</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    {{-- Pasokan LPG --}}
                    
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pasok/lpg') ? 'active shadow' : '' }}" href="{{ url('/laporan/pasok/lpg') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pasokan LPG</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Gas Bumi Melalui Pipa --}}

        <div class="menu-sub menu-sub-accordion">
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/jual/gbmp', 'laporan/pasok/gbmp') ? 'show here' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Gas Bumi Melalui Pipa</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->

                {{-- Penjualan Gas Bumi --}}

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/jual/gbmp') ? 'active shadow' : '' }}" href="{{ url('/laporan/jual/gbmp') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Penjualan Gas Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    {{-- Pasokan Gas Bumi --}}
                    
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pasok/gbmp') ? 'active shadow' : '' }}" href="{{ url('/laporan/pasok/gbmp') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pasokan Gas Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
            </div>
        </div>
    @endcan
    

    @can('Minyak Bumi')
        {{-- Pengelolaan Minyak Bumi --}}

        <div class="menu-sub menu-sub-accordion">
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/produksi/mb', 'laporan/pasokan/mb', 'laporan/distribusi/mb') ? 'show here' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pengelolaan Minyak Bumi</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->

                {{-- Produksi Kilang --}}

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/produksi/mb') ? 'active shadow' : '' }}" href="{{ url('/laporan/produksi/mb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Produksi Kilang</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    {{-- Pasokan Kilang --}}
                    
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pasokan/mb') ? 'active shadow' : '' }}" href="{{ url('/laporan/pasokan/mb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pasokan Kilang</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

                    {{-- Distribusi/Penjualan Dosmetik kilang --}}

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/distribusi/mb') ? 'active shadow' : '' }}" href="{{ url('/laporan/distribusi/mb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Distribusi/Penjualan Dosmetik Kilang</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
            </div>
        </div>
    @endcan
    

    @can('LPG/GAS')
        {{-- Pengelolaan Gas Bumi --}}

        <div class="menu-sub menu-sub-accordion">
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/produksi/gb', 'laporan/pasokan/gb', 'laporan/distribusi/gb') ? 'show here' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pengelolaan Gas Bumi</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->

                {{-- Produksi Kilang --}}

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/produksi/gb') ? 'active shadow' : '' }}" href="{{ url('/laporan/produksi/gb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Produksi Kilang</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    {{-- Pasokan Kilang --}}
                    
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pasokan/gb') ? 'active shadow' : '' }}" href="{{ url('/laporan/pasokan/gb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pasokan Kilang</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

                    {{-- Distribusi/Penjualan Dosmetik kilang --}}

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/distribusi/gb') ? 'active shadow' : '' }}" href="{{ url('/laporan/distribusi/gb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Distribusi/Penjualan Dosmetik Kilang</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>
            </div>
        </div>
    @endcan
    


    {{-- Ekspor - Impor --}}

    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/expor/exim', 'laporan/impor/exim') ? 'show here' : '' }}">
            <!--begin:Menu link-->
            <span class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Ekspor - Impor</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->

            {{-- Ekspor --}}

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <!--begin:Menu item-->
                @can('Minyak Bumi')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/expor/exim') ? 'active shadow' : '' }}" href="{{ url('/laporan/expor/exim') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Ekspor</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endcan
                
                @can('LPG/GAS')
                    {{-- Impor --}}
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/impor/exim') ? 'active shadow' : '' }}" href="{{ url('/laporan/impor/exim') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Impor</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                
            </div>
        </div>
    </div>


    {{-- Penyimpanan --}}
    
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/penyimpanan/mb', 'laporan/penyimpanan/gb') ? 'show here' : '' }}">
            <!--begin:Menu link-->
            <span class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Penyimpanan</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->

            {{-- Minyak Bumi --}}

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                @can('Minyak Bumi')
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/penyimpanan/mb') ? 'active shadow' : '' }}" href="{{ url('/laporan/penyimpanan/mb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Minyak Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endcan

                @can('LPG/GAS')
                    {{-- Gas Bumi --}}
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/penyimpanan/gb') ? 'active shadow' : '' }}" href="{{ url('/laporan/penyimpanan/gb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Gas Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                
            </div>
        </div>
    </div>


    {{-- Pengangkutan --}}
    
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('laporan/pengangkutan/mb', 'laporan/pengangkutan/gb') ? 'show here' : '' }}">
            <!--begin:Menu link-->
            <span class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Pengangkutan</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->

            {{-- Minyak Bumi --}}

            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                @can('Minyak Bumi')
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pengangkutan/mb') ? 'active shadow' : '' }}" href="{{ url('/laporan/pengangkutan/mb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Minyak Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endcan

                @can('LPG/GAS')
                    {{-- Gas Bumi --}}
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('laporan/pengangkutan/gb') ? 'active shadow' : '' }}" href="{{ url('/laporan/pengangkutan/gb') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Gas Bumi</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>