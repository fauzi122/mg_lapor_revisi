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
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Data Izin</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                {{-- @php
                                $displayedUrls = [];
                                @endphp

                                @foreach($result as $resultItem)
                                    @foreach($sub_page as $subPageItem)
                                        @if ($subPageItem->id_sub_page == $resultItem->SUB_PAGE)
                                            @if(!in_array($subPageItem->url, $displayedUrls))
                                                <a href="{{ $subPageItem->url }}">
                                                    <span data-key="t-calendar">{{ $subPageItem->nama_menu }}</span>
                                                </a>
                                                @php
                                                $displayedUrls[] = $subPageItem->url;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach --}}

                            @php
                                $filteredUrls = collect($sub_page)
                                    ->whereIn('id_sub_page', collect($result)->pluck('SUB_PAGE'))
                                    ->pluck('url')
                                    ->unique()
                                    ->toArray();
                            @endphp

                            @php
                                $flterid_menu = collect($sub_page)
                                    ->whereIn('id_sub_page', collect($result)->pluck('SUB_PAGE'))
                                    ->pluck('id_sub_menu')
                                    ->unique()
                                    ->toArray();
                            @endphp


                            @foreach($filteredUrls as $url)
                                <a href="{{ $url }}">
                                    <span data-key="t-calendar">{{ $sub_page->firstWhere('url', $url)->nama_menu }}</span>
                                </a>
                            @endforeach

                                
                            </li>

                            @php
                        $matchedSubPage = collect($sub_page)
                            ->whereIn('id_sub_page', collect($result)->pluck('SUB_PAGE'))
                            ->firstWhere('kategori', 2);

                        $matchedSubPage1 = collect($sub_page)
                            ->whereIn('id_sub_page', collect($result)->pluck('SUB_PAGE'))
                            ->firstWhere('kategori', 1);

                        $kusus= collect($sub_page)
                            ->whereIn('id_sub_page', collect($result)->pluck('SUB_PAGE'))
                            ->firstWhere('id_sub_menu', 1);
                    @endphp

                            {{-- pengolahan --}}
                    @if(Session::get('j_pengolahan') > 0)
                   
                        @if($matchedSubPage)
                            <li>
                                <a href="/penyimpananMinyakBumi" data-key="t-starter-page">Penyimpanan Minyak Bumi</a>
                            </li>
                            <li>
                                <a href="/eksport-import" data-key="t-starter-page">Ekspor-Impor</a>
                            </li>
                            <li>
                                <a href="/harga-bbm-jbu" data-key="t-starter-page">Harga BBM JBU</a>
                            </li>
                        @endif

                        {{-- @if($kusus)

                        <li>
                            <a href="/penyimpanan-gas-bumi" data-key="t-starter-page">Penyimpanan Gas Bumi</a>
                        </li>
                    @endif --}}


                    @endif

                    {{-- niaga --}}

                    @if(Session::get('j_niaga') > 0)
                  
                    @if($matchedSubPage)
                    <li>
                        <a href="/penyimpananMinyakBumi" data-key="t-starter-page">Penyimpanan Minyak Bumi</a>
                    </li>
                    <li>
                        <a href="/eksport-import" data-key="t-starter-page">Ekspor-Impor</a>
                    </li>
                    <li>
                        <a href="/harga-bbm-jbu" data-key="t-starter-page">Harga BBM JBU</a>
                    </li>
                @endif

                @if($matchedSubPage1)

                    <li>
                        <a href="/eksport-import" data-key="t-starter-page">Ekspor-Impor</a>
                    </li>
                @endif

                    @endif

            @if(Session::get('j_pengangkutan') > 0)

                        @if($kusus)

                        <li>
                            <a href="/penyimpanan-gas-bumi" data-key="t-starter-page">Penyimpanan Gas Bumi</a>
                        </li>
                    @endif


                    @endif

            @if(Session::get('j_niaga_s') > 0)         

                <li>
                    <a href="/progres-pembangunan/show" data-key="t-starter-page">Progres Pembangunan </a>
                </li>
            @endif


                  

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
