@php
    $isLpgActive = request()->is('data-subsidi-lpg/*') || request()->is('data-kuota-subsidi-lpg');
@endphp

<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isLpgActive ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-file-earmark-fill"></i>
        </span>
        <span class="menu-title">Subsidi LPG</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion mt-2">
        <div class="menu-item menu-accordion">
            <a href="{{ url('/data-subsidi-lpg/verified') }}"
               class="menu-link {{ request()->is('data-subsidi-lpg/verified') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">LPG Subsidi Verified</span>
            </a>
        </div>
        <div class="menu-item menu-accordion">
            <a href="{{ url('/data-kuota-subsidi-lpg') }}"
               class="menu-link {{ request()->is('data-kuota-subsidi-lpg') ? 'active shadow' : '' }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">Kuota LPG Subsidi</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
