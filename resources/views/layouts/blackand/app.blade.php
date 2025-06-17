<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard Evaluator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <!-- Include Choices.js from CDN for demonstration -->

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    {{-- <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- twitter-bootstrap-wizard css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.css') }}">
    <!-- plugin css -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    {{--  <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css')}}" type="text/css" />  --}}

    <!-- Bootstrap Css -->
    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    {{-- Begin --}}

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!-- APP CSS-->
    <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}"/>
    <!-- DATATABLE -->
    <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/custom/datatables/datatables.bundle.css') }}" />
    <!-- GLOBAL CSS-->
    <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/global/plugins.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assetsMetronic/css/style.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assetsMetronic/css/flatpickr.css') }}" />
    <!-- CHOICES CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" />
    <!-- CUSTOM CSS-->
    <link rel="stylesheet" href="{{ asset('assetsMetronic/css/custom.css') }}" />

    <!-- JAVASCRIPT -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <style>
        html[data-bs-theme="light"] .app-sidebar-secondary {
            background-color: #ffffff !important;
        }

        html[data-bs-theme="dark"] .app-sidebar-secondary {
            background-color: #121212 !important;
        }

    </style>

</head>

<body id="kt_app_body" 
data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" 
data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" 
data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" 
data-kt-app-sidebar-stacked="true" data-kt-app-sidebar-secondary-enabled="true" class="app-default">

    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            {{-- Header --}}
            @include('layouts.blackand.header')

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--Sidebar-->
                @include('layouts.blackand.menu')

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
        {{-- header end --}}
    </div>

    
    {{-- <div id="layout-wrapper">


        <!-- ========== Header Start ========== -->
        @include('layouts.blackand.header')
        <!-- Header End -->


        <!-- ========== Left Sidebar Start ========== -->
        @include('layouts.blackand.menu')
        <!-- Left Sidebar End -->


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <section class="content">
            <div class="main-content">

                @yield('content')
                {{--  @include('sweetalert::alert')  --}}
                {{-- @include('layouts.blackand.footer')
            </div>
        </section>
        <!-- end main content-->

    </div> --}}
    <!-- END layout-wrapper -->


    <!-- Right Sidebar -->
    {{-- @include('layouts.blackand.rightmenu') --}}
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    {{-- <div class="rightbar-overlay"></div> --}}

    <!-- JAVASCRIPT -->
    {{-- <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script> --}}
    <!-- pace js -->
    {{-- <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script> --}}
    <!-- Required datatable js -->
    {{-- <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script> --}}
    <!-- Buttons examples -->
    {{-- <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script> --}}

    <!-- Responsive examples -->
    {{-- <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
    <!-- dashboard init -->
    <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
    <!-- twitter-bootstrap-wizard js -->
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>

    <!-- App Css-->
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <!-- form wizard init -->
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script> --}}


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}

    <!--begin::Javascript-->
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="{{ asset('assetsMetronic/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/flatpickr.js') }}"></script>
        <!--end::Global Javascript Bundle-->

        <!-- Datatable-->
        <script src="{{ asset('assetsMetronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/initdatatable.js') }}"></script>
        
        <!-- choices js -->
        <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
        
        <!-- searchInput-->
        <script src="{{ asset('assetsMetronic/js/custom/searchInput.js') }}"></script>

        <!--begin::Vendors Javascript(used for this page only)-->
        <script src="{{ asset('assetsMetronic/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
        <!--end::Vendors Javascript-->

        <!--begin::Custom Javascript(used for this page only)-->
        <script src="{{ asset('assetsMetronic/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/create-app.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/new-target.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/users-search.js') }}"></script>
        <!--end::Custom Javascript-->
        <!--end::Javascript-->

    <script>
        // Pastikan Anda telah memuat library jQuery dan Select2 sebelum menggunakan script ini.

        $(document).ready(function() {
            // Inisialisasi Select2 untuk elemen dengan class select20
            $('.select2').select2();

            // Tambahkan inisialisasi select2 setelah modal muncul
            $('.modal-select').on('shown.bs.modal', function() {
                $('.select20').select2({
                    dropdownParent: $(this).find('.modal-content')
                });
            });

            // Hapus inisialisasi select2 di luar modal (jika ada)
            $('.modal-select').on('hidden.bs.modal', function() {
                $('.select20').select2('destroy');
            });
        });
    </script>
    <script>
        // Hapus pesan flash setelah 5 detik
        setTimeout(function() {
            $(".alert-container").fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);

        // Tampilkan SweetAlert2 jika sesuai dengan kondisi
        @if (session('sweet_error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('sweet_error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('sweet_success'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('sweet_success') }}",
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>


    @yield('script')
    <!-- Modal -->
    <div class="modal fade confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="bx bx-check-circle display-4 text-success"></i>
                        </div>
                        <h5>Confirm Save Changes</h5>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light w-md" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary w-md" data-bs-dismiss="modal">Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

</body>

</html>
