<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Pelaporan MIGAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-esdm.png') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!-- APP CSS-->
    <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/custom/datatables/datatables.bundle.css') }}" />

    <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/global/plugins.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assetsMetronic/css/style.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assetsMetronic/css/flatpickr.css') }}" />

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.dataTables.css" />
    
    {{-- <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/custom/datatables/datatables.bundle.css') }}" /> --}}
</head>

<body id="kt_app_body" 
    data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" 
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" 
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" 
    data-kt-app-sidebar-stacked="true" data-kt-app-sidebar-secondary-enabled="true" class="app-default">

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div id="kt_app_header" class="app-header">
                <div class="app-header-brand ps-6">
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-color-gray-500 btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-outline ki-abstract-14 fs-2"></i>
                        </div>
                    </div>
                    <a class="app-sidebar-secondary-collapse-d-none" href="#">
                        <img alt="Logo" src="{{ asset('assets/images/logo-esdm.png') }}" class="h-30px"/> <span class="fw-bold text-dark"> | Pelaporan Migas</span>
                    </a>
                    <button id="kt_app_sidebar_secondary_toggle" class="btn btn-sm btn-icon bg-body btn-color-gray-400 btn-active-color-primary d-none d-lg-flex ms-2" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-secondary-collapse">
                        <i class="ki-outline ki-menu fs-1"></i>
                    </button>
                </div>
                <div class="app-header-wrapper">
                    <div class="app-container container-fluid">
                        <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1">
                            <div id="kt_header_search" class="header-search d-flex align-items-center w-lg-275px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="true" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">
                                <div data-kt-search-element="toggle" class="search-toggle-mobile d-flex d-lg-none align-items-center">
                                    <div class="d-flex">
                                        <i class="ki-outline ki-magnifier fs-1"></i>
                                    </div>
                                </div>
                                <form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                                    <input type="hidden" />
                                    <i class="ki-outline ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"></i>
                                    <input type="text" class="search-input form-control form-control-solid ps-13" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
                                    <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
                                        <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                                    </span>
                                    <span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
                                        <i class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
                                    </span>
                                </form>
                            </div>
                        </div>

                        <div class="app-navbar flex-shrink-0">
                            <div class="app-navbar-item ms-1 ms-md-3">
                                <div class="app-navbar-item ms-1 ms-md-3 position-relative" id="calendar_wrapper">
                                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="calendar_trigger">
                                        <i class="ki-outline ki-calendar fs-1"></i>
                                    </div>
                                    <div id="calendar_popup">
                                        <div class="calendar_inline"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="app-navbar-item">
                                <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px ms-1 ms-md-3" id="kt_drawer_chat_toggle">
                                    <i class="ki-outline ki-notification-on fs-1"></i>
                                </div>
                            </div>
                            <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                                <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                    @if(Auth::user()->role == 'BU')
                                        <img src="{{ asset('assetsMetronic/media/company_img.png')}}" alt="user"/>
                                    @else
                                        <img src="{{ asset('assets/images/users/avatar-1.jpg')}}" alt="user"/>
                                    @endif
                                </div>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <div class="symbol symbol-50px me-5">
                                                @if(Auth::user()->role == 'BU')
                                                    <img alt="Logo" src="{{ asset('assetsMetronic/media/company_img.png')}}"/>
                                                @else
                                                    <img alt="Logo" src="{{ asset('assets/images/users/avatar-1.jpg')}}"/>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}
                                                    <span class="badge badge-light-success fw-bold fs-9 px-2 py-1 ms-2">{{ Auth::user()->role }}</span>
                                                </div>
                                                <a href="#" class="fw-semibold text-muted text-hover-primary fs-10">{{ Auth::user()->email }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-2"></div>
                                    <div class="menu-item px-5">
                                        <a href="#" class="menu-link px-5">My Profile</a>
                                    </div>
                                    <div class="separator my-2"></div>
                                    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                        <a href="#" class="menu-link px-5">
                                            <span class="menu-title position-relative">Mode
                                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                                <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                            </span></span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <i class="ki-outline ki-night-day fs-2"></i>
                                                    </span>
                                                    <span class="menu-title">Light</span>
                                                </a>
                                            </div>
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <i class="ki-outline ki-moon fs-2"></i>
                                                    </span>
                                                    <span class="menu-title">Dark</span>
                                                </a>
                                            </div>
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                        <i class="ki-outline ki-screen fs-2"></i>
                                                    </span>
                                                    <span class="menu-title">System</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="menu-item px-5">
                                        @if (Auth::user()->role == 'BU')
                                            <a class="menu-link px-5" href="{{ url('/logoutBU') }}">Sign Out</a>
                                        @else
                                            <a class="menu-link px-5" href="{{ url('/logout') }}">Sign Out</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--Sidebar-->
                @include('layouts.main.sidebar.index')

                <!--Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        @yield('content')
                    </div>
                    <!--Footer-->
                    <div id="kt_app_footer" class="app-footer">
                        <div class="app-container container-xxl d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
                                <a href="#" class="text-gray-800 text-hover-primary">Aplikasi Pelaporan Migas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.colVis.min.js"></script>

    <script>
        new DataTable('#tableWithExport', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
                }
            }
        });
    </script>

    {{-- <script src="{{ asset('assetsMetronic/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assetsMetronic/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/flatpickr.js') }}"></script>
    <!--end::Global Javascript Bundle-->
</body>

</html>