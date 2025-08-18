@php
    $isSubsidiBBMActive =
        request()->is('laporan/kuota-jbt') ||
        request()->is('laporan/kuota-jbkp');
@endphp
<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $isSubsidiBBMActive ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-file-earmark-fill"></i>
        </span>
        <span class="menu-title">Subsidi BBM</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item menu-accordion">
            <!--begin:Menu link-->
            <a href="{{ url('/laporan/kuota-jbt') }}"
                class="menu-link {{ request()->is('laporan/kuota-jbt') ? 'active shadow' : '' }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">JBT Kuota</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item menu-accordion">
            <!--begin:Menu link-->
            <a href="{{ url('/laporan/kuota-jbkp') }}"
                class="menu-link {{ request()->is('laporan/kuota-jbkp') ? 'active shadow' : '' }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">JBKP Kuota</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>
