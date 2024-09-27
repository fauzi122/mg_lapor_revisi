<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="/master">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="folder"></i>
                        <span data-key="t-authentication">Master Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/master/produk" data-key="t-login">Keterangan Produk</a></li>
                        <li><a href="/master/inco-term" data-key="t-register">INCO Term</a></li>
                        <li><a href="/master/port" data-key="t-recover-password">Port</a></li>
                        <li><a href="/master/negara" data-key="t-lock-screen">Negara</a></li>
                        <li><a href="/master/intake_kilangs" data-key="t-logout">Intake Kilang</a></li>
                        <li><a href="/master/meping" data-key="t-logout">Meping</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Laporan Badan Usaha</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                       
                        {{-- <li>
                            <a href="/niaga/bbm">
                                <span data-key="t-chat">BBM</span>
                            </a>
                        </li> --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-invoices">Hsl Olahan/Minyak Bumi</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/jual-hasil-olahan" data-key="t-invoice-list">Penjualan Hasil Olahan/Minyak Bumi</a></li>
                                <li><a href="/laporan/pasokan-hasil-olahan" data-key="t-invoice-detail">Pasokan Hasil Olahan/Minyak Bumi</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-contacts">Harga</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/harga-bbm" data-key="t-user-grid">Harga BBM JBU</a></li>
                                <li><a href="/laporan/harga-lpg" data-key="t-user-list">Harga LPG</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">LNG/CNG/BBG</span>
                                {{--  <span class="badge rounded-pill badge-soft-danger float-end" key="t-new">New</span>  --}}
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/jual/lng-cng-bbg" data-key="t-blog-grid">Penjualan LNG/CNG/BBG</a></li>
                                <li><a href="/laporan/pasok/lng-cng-bbg" data-key="t-blog-list">Pasokan LNG/CNG/BBG</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">LPG</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/jual/lpg" data-key="t-blog-grid">Penjualan LPG</a></li>
                                <li><a href="/laporan/pasok/lpg" data-key="t-blog-list">Pasokan LPG</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Gas Bumi Melalui Pipa</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/jual/gbmp" data-key="t-blog-grid">Penjualan Gas Bumi</a></li>
                                <li><a href="/laporan/pasok/gbmp" data-key="t-blog-list">Pasokan Gas Bumi</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Pengolahan Minyak Bumi</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/produksi/mb" data-key="t-blog-grid">Produksi Kilang</a></li>
                                <li><a href="/laporan/pasokan/mb" data-key="t-blog-list">Pasokan Kilang</a></li>
                                <li><a href="/laporan/distribusi/mb" data-key="t-blog-list">Distribusi/Penjualan Domestik Kilang </a></li>
                            </ul>
                        </li>
                                                <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Pengolahan Gas Bumi</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/produksi/gb" data-key="t-blog-grid">Produksi Kilang</a></li>
                                <li><a href="/laporan/pasokan/gb" data-key="t-blog-list">Pasokan Kilang</a></li>
                                <li><a href="/laporan/distribusi/gb" data-key="t-blog-list">Distribusi/Penjualan Domestik Kilang </a></li>
                            </ul>
                        </li>
                                                <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Ekspor - Impor</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/expor/exim" data-key="t-blog-grid">Ekspor</a></li>
                                <li><a href="/laporan/impor/exim" data-key="t-blog-list">Impor</a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Penyimpanan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">

                                <li><a href="/laporan/penyimpanan/mb" data-key="t-blog-list">Minyak Bumi</a></li>
                                <li><a href="/laporan/penyimpanan/gb" data-key="t-blog-list">Gas Bumi</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-blog">Pengangkutan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/laporan/pengangkutan/mb" data-key="t-blog-list">Minyak Bumi</a></li>
                                <li><a href="/laporan/pengangkutan/gb" data-key="t-blog-list">Gas Bumi</a></li>
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

                       
                        <li>
                            <a href="/data-izin/badan-usaha/minyak-bumi">
                                <span data-key="t-chat">Minyak Bumi</span>
                            </a>
                        </li>

                        <li>
                            <a href="/data-izin/badan-usaha/gas">
                                <span data-key="t-chat">Gas Bumi</span>
                            </a>
                        </li>
                        
                        
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Subsidi LPG</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/data-subsidi-lpg/verified" data-key="t-starter-page">LPG Subsidi Verified</a></li>
                        <li><a href="/data-kuota-subsidi-lpg" data-key="t-maintenance">Kuota LPG Subsidi</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Subsidi BBM </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html" data-key="t-starter-page">JBT Kuota</a></li>
                        <li><a href="pages-maintenance.html" data-key="t-maintenance">JBKP Kuota</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Fasilitas Pengangkutan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html" data-key="t-starter-page">Minyak Bumi</a></li>
                        <li><a href="pages-maintenance.html" data-key="t-maintenance">Gas Bumi</a></li>
                        <li><a href="pages-maintenance.html" data-key="t-maintenance">Gas Bumi melalui Pipa</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">Investasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html" data-key="t-starter-page">Minyak Bumi</a></li>
                        <li><a href="pages-maintenance.html" data-key="t-maintenance">Gas Bumi</a></li>

                    </ul>
                </li>


                <li class="menu-title mt-2" data-key="t-components">Administrasi</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-components">User Managemen</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/data-user/bu" data-key="t-alerts">Akun Badan Usaha</a></li>
                        <li><a href="/data-user/adm" data-key="t-buttons">Akun Staff</a></li>
                        <li><a href="ui-cards.html" data-key="t-cards">Izin</a></li>
                        <li><a href="ui-carousel.html" data-key="t-carousel">Pengaturan Akun</a></li>
                        <li><a href="ui-dropdowns.html" data-key="t-dropdowns">Intake Kilang</a></li>

                    </ul>
                </li>

                
            </ul>

            {{--  <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                        <a href="#!" class="btn btn-primary mt-2">Upgrade Now</a>
                    </div>
                </div>
            </div>  --}}
        </div>
        <!-- Sidebar -->
    </div>
</div>