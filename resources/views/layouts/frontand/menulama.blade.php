<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>
                <li>
                    <a href="/">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                @if (Session::get('j_niaga') > 0)
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Niaga</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            {{--  <li>
                            <a href="/niaga/bbm">
                                <span data-key="t-calendar">BBM</span>
                            </a>
                        </li>  --}}
                            <li>
                                @foreach($result as $resultItem)
                                {{-- {{ $resultItem->SUB_PAGE }} --}}
                                @foreach($sub_page as $subPageItem)
                                @if ($subPageItem->id_sub_page == $resultItem->SUB_PAGE)
                                   {{-- {{ $subPageItem->nama_opsi }} --}}
                                @endif
                            @endforeach
                            @foreach($sub_page as $subPageItem)
                            @if ($subPageItem->id_sub_page == $resultItem->SUB_PAGE)
                            <a href="{{ $subPageItem->url }}">
                                <span data-key="t-calendar">{{ $subPageItem->nama_menu }}</span>
                            </a>
                                {{-- <a href="{{ $subPageItem->url }}">{{ $subPageItem->nama_menu }}</a> --}}
                            @endif
                        @endforeach
                        @endforeach

                            </li>
                            <li>
                                <a href="/lng/cng">
                                    <span data-key="t-chat">LNG/CNG/BBG</span>
                                </a>
                            </li>
                            <li>
                                <a href="/niaga/lpg">
                                    <span data-key="t-chat">LPG</span>
                                </a>
                            </li>
                            <li>
                                <a href="/gas-bumi-pipa">
                                    <span data-key="t-chat">Gas Bumi Melalui Pipa</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if (Session::get('j_pengolahan') > 0)
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-authentication">Pengolahan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="auth-login.html" data-key="t-login">Minyak Bumi</a></li>
                            <li><a href="auth-register.html" data-key="t-register">Gas Bumi</a></li>
                        </ul>
                    </li>
                @endif

                {{-- <li>
                    <a href="javascript:void(0);" class="has-arrow">
                        <i data-feather="folder"></i>
                        <span data-key="t-pages">Ekspor-Impor</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/eksport-import" data-key="t-starter-page">Ekspor-Impor</a></li>
                    </ul>
                </li> --}}

                @if (Session::get('j_penyimpanan') > 0)
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="briefcase"></i>
                            <span data-key="t-pages">Penyimpanan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/penyimpanan-minyak-bumi" data-key="t-starter-page">Minyak Bumi</a></li>
                            <li><a href="/penyimpanan-gas-bumi" data-key="t-starter-page">Gas Bumi</a></li>
                        </ul>
                    </li>
                @endif

                @if (Session::get('j_pengangkutan') > 0)
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="box"></i>
                            <span data-key="t-pages">Pengangkutan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="pages-starter.html" data-key="t-starter-page">Gas Bumi Melalui Pipa</a></li>
                            <li><a href="pages-starter.html" data-key="t-starter-page">Minyak Bumi</a></li>
                            <li><a href="pages-starter.html" data-key="t-starter-page">Gas Bumi</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>

    
        <!-- Sidebar -->
    </div>
</div>
