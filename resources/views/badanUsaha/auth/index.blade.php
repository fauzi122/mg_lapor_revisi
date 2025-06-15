<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Pelaporan MIGAS | ESDM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ asset('assets/images/logo-esdm.png') }}">
		<meta name="description" content="" />
		<meta name="keywords" content="" />

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/custom/datatables/datatables.bundle.css') }}" />
        <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/global/plugins.bundle.css') }}" />
        <link rel="stylesheet" href="{{ asset('assetsMetronic/css/style.bundle.css') }}" />
	</head>
    
	<body id="kt_body" class="app-blank">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="d-flex flex-column flex-lg-row flex-column-fluid" style="background-color: #e7f0fd;">

                <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                        <div class="card shadow mb-5">
                            <form class="formLoad" method="POST" action="{{ url('/login/post-login') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="w-lg-500px p-10">
                                    <div class="card-header">
                                        <div class="text-center mb-11">
                                            <h1 class="text-dark fw-bolder mb-3">Pelaporan Migas</h1>
                                            <div class="text-gray-600 fw-semibold fs-6">Silakan pilih perusahaan Anda untuk melanjutkan</div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <select name="perusahaan" data-control="select2" class="form-select form-select-solid shadow-lg" required>
                                            <option value="" disabled selected>-- Pilih Nama Perusahaan --</option>
                                            @foreach ($perusahaan as $item)
                                                <option value="{{ $item->id_perusahaan }}">{{ $item->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center justify-content-center w-100 w-sm-auto mt-5">
                                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary" onclick="handleSubmit(this)">
                                                <span class="me-2 btn-text">Lanjut</span>
                                                <i class="ki-outline ki-arrow-right fs-3 btn-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.querySelectorAll(".formLoad").forEach(function (form) {
                                    form.addEventListener("submit", function (event) {
                                        if (!this.checkValidity()) {
                                            event.preventDefault();
                                            return false;
                                        }
                                        var submitButton = this.querySelector('button[type="submit"]');
                                        if (submitButton) {
                                            submitButton.disabled = true;
                                            submitButton.innerHTML =
                                                'Mohon Tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> ';
                                        }
                                        return true;
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <div class="text-gray-500 text-center fw-semibold fs-6 mt-auto py-4">
                        <span>&copy; ESDM {{ date('Y') }}</span>
                    </div>
                </div>
                
                <!-- Right Side Image Panel -->
                <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url('/assetsMetronic/media/auth/bg4.jpg')">
                    <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                        <a href="#" class="mb-0 mb-lg-12">
                            <img alt="Logo" src="{{ asset('assets/images/logo-esdm.png') }}" class="h-60px h-lg-75px" />
                        </a>
                        <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="assets/media/misc/auth-screens.png" alt="" />
                        <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-5">Sistem Pelaporan Migas</h1>
                        <p class="d-none d-lg-block text-white fs-5 text-center">Platform digital untuk pelaporan dan pemantauan kegiatan migas <br> secara efisien dan terintegrasi.</p>
                    </div>
                </div>
                
			</div>
		</div>

        <script src="{{ asset('assetsMetronic/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('assetsMetronic/js/custom/authentication/sign-in/general.js') }}"></script>

		<!--begin::Vendors Javascript(used for this page only)-->
        <script src="{{ asset('assetsMetronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <!--end::Vendors Javascript-->

        <!--begin::Custom Javascript(used for this page only)-->
        <script src="{{ asset('assetsMetronic/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/create-campaign.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/new-address.js') }}"></script>
        <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/users-search.js') }}"></script>
        <!--end::Custom Javascript-->
	</body>
	<!--end::Body-->
</html>