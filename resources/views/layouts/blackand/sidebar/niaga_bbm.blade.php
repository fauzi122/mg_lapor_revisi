@php
    $isNiagaBbmActive = request()->is('laporan/penjualan-jbkp') || request()->is('laporan/penjualan-jbt') || request()->is('laporan/penjualan-jbu') || request()->is('laporan/penjualan-bbm');
@endphp

<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isNiagaBbmActive ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-file-earmark-fill"></i>
        </span>
        <span class="menu-title">Niaga - BBM</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion mt-2">
        <div class="menu-item menu-accordion">
            <a href="{{ url('/laporan/penjualan-jbkp') }}"
               class="menu-link {{ request()->is('laporan/penjualan-jbkp') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Penjualan JBKP</span>
            </a>
        </div>
        <div class="menu-item menu-accordion">
            <a href="{{ url('/laporan/penjualan-jbt') }}"
               class="menu-link {{ request()->is('laporan/penjualan-jbt') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Penjualan JBT</span>
            </a>
        </div>
        <div class="menu-item menu-accordion">
            <a href="{{ url('/laporan/penjualan-jbu') }}"
               class="menu-link {{ request()->is('laporan/penjualan-jbu') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Penjualan JBU</span>
            </a>
        </div>
        <div class="menu-item menu-accordion">
            <a href="{{ url('/laporan/penjualan-bbm') }}"
               class="menu-link {{ request()->is('laporan/penjualan-bbm') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Penjualan BBM</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
