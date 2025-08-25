@php
    $isMasterActive = request()->is('master/*');
@endphp

<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isMasterActive ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="ki-duotone ki-folder">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </span>
        <span class="menu-title">Master Data</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion mt-2">
        <div class="menu-item">
            <a href="{{ url('/master/produk') }}"
                class="menu-link {{ request()->is('master/produk') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Keterangan Produk</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/inco-term') }}"
                class="menu-link {{ request()->is('master/inco-term') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Inco Term</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/port') }}"
                class="menu-link {{ request()->is('master/port') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Port</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/negara') }}"
                class="menu-link {{ request()->is('master/negara') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Negara</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/intake_kilangs') }}"
                class="menu-link {{ request()->is('master/intake_kilangs') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Intake Kilang</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/izin-usaha') }}"
                class="menu-link {{ request()->is('master/izin-usaha') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Izin Usaha</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/meping') }}"
                class="menu-link {{ request()->is('master/meping') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Meping</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/jabatan') }}"
                class="menu-link {{ request()->is('master/jabatan') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Jabatan</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ url('/master/email') }}"
                class="menu-link {{ request()->is('master/email') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Email</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ url('/master/sektor') }}"
                class="menu-link {{ request()->is('master/sektor') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Sektor</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
