@php
    $isGasPipa2Active = request()->is('laporan/pengangkutan-gas');
@endphp

<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isGasPipa2Active ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-file-earmark-fill"></i>
        </span>
        <span class="menu-title">Pengangkutan - Gas Bumi Melalui Pipa</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion mt-2">
        <div class="menu-item menu-accordion">
            <a href="{{ url('/laporan/pengangkutan-gas') }}"
                class="menu-link {{ request()->is('laporan/pengangkutan-gas') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Pengangkutan Gas</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
