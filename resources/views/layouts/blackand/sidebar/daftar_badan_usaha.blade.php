@php
    $isBadanUsahaActive = request()->is('data-izin/badan-usaha/*');
@endphp

<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isBadanUsahaActive ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-building-fill"></i>
        </span>
        <span class="menu-title">Daftar Badan Usaha</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion mt-2">
        <!--begin:Menu item-->
        <div class="menu-item menu-accordion">
            <a href="{{ url('/data-izin/badan-usaha/minyak-bumi') }}"
               class="menu-link {{ request()->is('data-izin/badan-usaha/minyak-bumi') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Minyak Bumi</span>
            </a>
        </div>
        <div class="menu-item menu-accordion">
            <a href="{{ url('/data-izin/badan-usaha/gas') }}"
               class="menu-link {{ request()->is('data-izin/badan-usaha/gas') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Gas Bumi</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
