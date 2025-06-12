<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2">
    <!--begin:Menu link-->
    <span class="menu-link active">
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
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/jual-hasil-olahan') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/pasokan-hasil-olahan') }}">
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
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/harga-bbm') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/harga-lpg') }}">
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

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/jual/lng-cng-bbg') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/pasok/lng-cng-bbg') }}">
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
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/jual/lpg') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/pasok/lpg') }}">
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
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/jual/gbmp') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/pasok/gbmp') }}">
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
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/produksi/mb') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/pasokan/mb') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/distribusi/mb') }}">
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
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/produksi/gb') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/pasokan/gb') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/distribusi/gb') }}">
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
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/expor/exim') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/impor/exim') }}">
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
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="{{ url('/laporan/penyimpanan/mb') }}">
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
                        <a class="menu-link" href="{{ url('/laporan/penyimpanan/gb') }}">
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
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <a class="menu-link" href="#">
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
                        <a class="menu-link" href="#">
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