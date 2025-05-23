<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ url('/master') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                @can('Master Data')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="folder"></i>
                            <span data-key="t-authentication">Master Data</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ url('/master/produk') }}" data-key="t-login">Keterangan Produk</a></li>
                            <li><a href="{{ url('/master/inco-term') }}" data-key="t-register">INCO Term</a></li>
                            <li><a href="{{ url('/master/port') }}" data-key="t-recover-password">Port</a></li>
                            <li><a href="{{ url('/master/negara') }}" data-key="t-lock-screen">Negara</a></li>
                            <li><a href="{{ url('/master/intake_kilangs') }}" data-key="t-logout">Intake Kilang</a></li>
                            <li><a href="{{ url('/master/meping') }}" data-key="t-logout">Meping</a></li>
                            <li><a href="{{ url('/master/jabatan') }}" data-key="t-logout">Jabatan</a></li>
                        </ul>
                    </li>
                @endcan
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Laporan Badan Usaha</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Minyak Bumi')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span data-key="t-invoices">Hsl Olahan/Minyak Bumi</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/laporan/jual-hasil-olahan') }}"
                                            data-key="t-invoice-list">Penjualan Hasil Olahan/Minyak Bumi</a></li>
                                    <li><a href="{{ url('/laporan/pasokan-hasil-olahan') }}"
                                            data-key="t-invoice-detail">Pasokan Hasil Olahan/Minyak Bumi</a></li>
                                </ul>
                            </li>
                        @endcan
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-contacts">Harga</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('Minyak Bumi')
                                    <li><a href="{{ url('/laporan/harga-bbm') }}" data-key="t-user-grid">Harga BBM JBU</a>
                                    </li>
                                @endcan
                                @can('LPG/GAS')
                                    <li><a href="{{ url('/laporan/harga-lpg') }}" data-key="t-user-list">Harga LPG</a></li>
                                @endcan
                            </ul>
                        </li>
                        @can('LPG/GAS')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span data-key="t-blog">LNG/CNG/BBG</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/laporan/jual/lng-cng-bbg') }}" data-key="t-blog-grid">Penjualan
                                            LNG/CNG/BBG</a></li>
                                    <li><a href="{{ url('/laporan/pasok/lng-cng-bbg') }}" data-key="t-blog-list">Pasokan
                                            LNG/CNG/BBG</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span data-key="t-blog">LPG</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/laporan/jual/lpg') }}" data-key="t-blog-grid">Penjualan LPG</a>
                                    </li>
                                    <li><a href="{{ url('/laporan/pasok/lpg') }}" data-key="t-blog-list">Pasokan LPG</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span data-key="t-blog">Gas Bumi Melalui Pipa</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/laporan/jual/gbmp') }}" data-key="t-blog-grid">Penjualan Gas
                                            Bumi</a></li>
                                    <li><a href="{{ url('/laporan/pasok/gbmp') }}" data-key="t-blog-list">Pasokan Gas
                                            Bumi</a></li>
                                </ul>
                            </li>
                        @endcan
                        @can('Minyak Bumi')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span data-key="t-blog">Pengolahan Minyak Bumi</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/laporan/produksi/mb') }}" data-key="t-blog-grid">Produksi
                                            Kilang</a></li>
                                    <li><a href="{{ url('/laporan/pasokan/mb') }}" data-key="t-blog-list">Pasokan
                                            Kilang</a></li>
                                    <li><a href="{{ url('/laporan/distribusi/mb') }}"
                                            data-key="t-blog-list">Distribusi/Penjualan Domestik Kilang </a></li>
                                </ul>
                            </li>
                        @endcan
                        @can('LPG/GAS')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span data-key="t-blog">Pengolahan Gas Bumi</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/laporan/produksi/gb') }}" data-key="t-blog-grid">Produksi
                                            Kilang</a></li>
                                    <li><a href="{{ url('/laporan/pasokan/gb') }}" data-key="t-blog-list">Pasokan
                                            Kilang</a></li>
                                    <li><a href="{{ url('/laporan/distribusi/gb') }}"
                                            data-key="t-blog-list">Distribusi/Penjualan Domestik Kilang </a></li>
                                </ul>
                            </li>
                        @endcan
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Ekspor - Impor</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('Minyak Bumi')
                                    <li><a href="{{ url('/laporan/expor/exim') }}" data-key="t-blog-grid">Ekspor</a></li>
                                @endcan
                                @can('LPG/GAS')
                                    <li><a href="{{ url('/laporan/impor/exim') }}" data-key="t-blog-list">Impor</a></li>
                                @endcan
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Penyimpanan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('Minyak Bumi')
                                    <li><a href="{{ url('/laporan/penyimpanan/mb') }}" data-key="t-blog-list">Minyak
                                            Bumi</a></li>
                                @endcan
                                @can('LPG/GAS')
                                    <li><a href="{{ url('/laporan/penyimpanan/gb') }}" data-key="t-blog-list">Gas
                                            Bumi</a></li>
                                @endcan
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Pengangkutan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('Minyak Bumi')
                                    <li><a href="{{ url('/laporan/pengangkutan/mb') }}" data-key="t-blog-list">Minyak
                                            Bumi</a></li>
                                @endcan
                                @can('LPG/GAS')
                                    <li><a href="{{ url('/laporan/pengangkutan/gb') }}" data-key="t-blog-list">Gas
                                            Bumi</a></li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file"></i>
                        <span data-key="t-apps">Daftar Badan Usaha</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Minyak Bumi')
                            <li>
                                <a href="{{ url('/data-izin/badan-usaha/minyak-bumi') }}">
                                    <span data-key="t-chat">Minyak Bumi</span>
                                </a>
                            </li>
                        @endcan
                        @can('LPG/GAS')
                            <li>
                                <a href="{{ url('/data-izin/badan-usaha/gas') }}">
                                    <span data-key="t-chat">Gas Bumi</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @can('LPG/GAS')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="file-text"></i>
                            <span data-key="t-pages">Subsidi LPG</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/data-subsidi-lpg/verified" data-key="t-starter-page">LPG Subsidi Verified</a>
                            </li>
                            <li><a href="/data-kuota-subsidi-lpg" data-key="t-maintenance">Kuota LPG Subsidi</a></li>

                        </ul>
                    </li>
                @endcan
                <li class="menu-title mt-2" data-key="t-components">BPH Inline</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Niaga - BBM </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('/laporan/penjualan-jbkp') }}" data-key="t-starter-page">Penjualan
                                JBKP</a></li>
                        <li><a href="{{ url('/laporan/penjualan-jbt') }}" data-key="t-maintenance">Penjualan JBT</a>
                        </li>
                        <li><a href="{{ url('/laporan/penjualan-jbu') }}" data-key="t-maintenance">Penjualan JBU</a>
                        </li>
                        <li><a href="{{ url('/laporan/penjualan-bbm') }}" data-key="t-maintenance">Penjualan BBM</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Subsidi BBM</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html" data-key="t-starter-page">JBT Kuota</a></li>
                        <li><a href="pages-starter.html" data-key="t-starter-page">JBKP Kuota</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Gas Bumi Melalui Pipa</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('/laporan/penjualan-gas-bumi') }}" data-key="t-starter-page">Penjualan
                                Gas Bumi</a></li>
                        <li><a href="{{ url('/laporan/pasokan-gas-bumi') }}" data-key="t-maintenance">Pasokan Gas
                                Bumi</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Gas Bumi Melalui Pipa</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('/laporan/pengangkutan-gas') }}" data-key="t-starter-page">Pengangkutan
                                Gas</a></li>

                    </ul>
                </li>
                @can('Master Data')
                    <li class="menu-title mt-2" data-key="t-components">Administrasi</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-components">User Managemen</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ url('/user-badan-usaha') }}" data-key="t-alerts">User Badan Usaha</a></li>
                            @can('user')
                                <li><a href="{{ url('/user') }}" data-key="t-buttons">User Evaluator</a></li>
                            @endcan
                            <li><a href="{{ url('/role') }}" data-key="t-cards">Role</a></li>
                            @can('permission')
                                <li><a href="{{ url('/permission') }}" data-key="t-carousel">Permission</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
