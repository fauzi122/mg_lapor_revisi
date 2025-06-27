@php
    $isGasBumiActive = request()->is('laporan/penjualan-gas-bumi') || request()->is('laporan/pasokan-gas-bumi');
@endphp

<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isGasBumiActive ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-file-earmark-fill"></i>
        </span>
        <span class="menu-title">Niaga - Gas Bumi Melalui Pipa</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion mt-2">
        <div class="menu-item menu-accordion">
            <a href="{{ url('/laporan/penjualan-gas-bumi') }}"
                class="menu-link {{ request()->is('laporan/penjualan-gas-bumi') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Penjualan Gas Bumi</span>
            </a>
        </div>
        <div class="menu-item menu-accordion">
            <a href="{{ url('/laporan/pasokan-gas-bumi') }}"
                class="menu-link {{ request()->is('laporan/pasokan-gas-bumi') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Pasokan Gas Bumi</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
