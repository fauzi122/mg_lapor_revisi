<div id="kt_app_sidebar" class="app-sidebar" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div class="app-sidebar-secondary w-100">
        <div id="kt_app_sidebar_secondary_wrapper" class="hover-scroll-y" data-kt-scroll="true"
            data-kt-scroll-activate="{default: true, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-wrappers=".kt_app_sidebar_secondary_menu, #kt_app_sidebar_secondary_tags"
            data-kt-scroll-offset="5px">

            <div class="app-sidebar-menu menu menu-sub-indention menu-rounded menu-column kt_app_sidebar_secondary_menu"
                data-kt-menu="true">
                {{-- Dashboard --}}
                @include('layouts.blackand.sidebar.dashboards')

                {{-- End Dashboard --}}

                {{-- Master Data --}}
                @include('layouts.blackand.sidebar.master_data')
                {{-- End master Data --}}

                {{-- Laporan Badan Usaha --}}
                @include('layouts.blackand.sidebar.laporan_badan_usaha')
                {{-- End Laporan Badan Usaha --}}

                {{-- Daftar Badan Usaha --}}
                @include('layouts.blackand.sidebar.daftar_badan_usaha')
                {{-- End Daftar Badan Usaha --}}

                {{-- Subsidi LPG --}}
                @include('layouts.blackand.sidebar.subsidi_lpg')
                {{-- End Subsidi LPG --}}
            </div>

            <div class="separator"></div>

            <div class="app-sidebar-menu menu menu-sub-indention menu-rounded menu-column kt_app_sidebar_secondary_menu"
                data-kt-menu="true">
                {{-- Niaga - BBM --}}
                @include('layouts.blackand.sidebar.niaga_bbm')
                {{-- End Niaga - BBM --}}

                {{-- Subsidi BBM --}}
                @include('layouts.blackand.sidebar.subsidi_bbm')
                {{-- End Subsidi BBM --}}

                {{-- Niaga - Gas Bumi Melalui Pipa 1 --}}
                @include('layouts.blackand.sidebar.gas_bumi_pipa1')
                {{-- End Gas Bumi Melalui Pipa 1 --}}

                {{-- Pengangkutan - Gas Bumi Melalui Pipa 2 --}}
                @include('layouts.blackand.sidebar.gas_bumi_pipa2')
                {{-- End Gas Bumi Melalui Pipa 2 --}}
            </div>

            <div class="separator"></div>

            <div class="app-sidebar-menu menu menu-sub-indention menu-rounded menu-column kt_app_sidebar_secondary_menu"
                data-kt-menu="true">
                {{-- User Managemen --}}
                @include('layouts.blackand.sidebar.user_managemen')
                {{-- End User Managemen --}}
            </div>

        </div>
    </div>
</div>
