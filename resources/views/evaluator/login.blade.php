<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Evaluator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-esdm.png') }}">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="stylesheet" href="{{ asset('assetsMetronic/plugins/global/plugins.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assetsMetronic/css/style.bundle.css') }}" />
    <link href="{{ asset('assetsMetronic/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assetsMetronic/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid" style="background-color: #e7f0fd;">
            
            <!-- Form Login Panel -->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="card shadow mb-5">
                        <form class="formLoad" method="POST" action="{{ url('/evaluator/login/post-login') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="w-lg-500px p-10">
                                <!-- Header -->
                                <div class="card-header">
                                    <div class="text-center mb-11">
                                        <div class="d-flex justify-content-center align-items-center mb-3">
                                            <img src="{{ asset('assets/images/logo-esdm.png') }}" alt="Logo ESDM" height="40" class="me-2">
                                            <h1 class="logo-txt mb-0 fs-1">Pelaporan Migas</h1>
                                        </div>
                                        <div class="text-center mt-10">
                                            <h5 class="mb-0">Selamat Datang</h5>
                                            <p class="text-muted mt-2">
                                                Untuk Single Sign On Pada Kementrian ESDM,
                                                <a href="{{ url('/evaluator/login_sso') }}">klik disini</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Masukan Username" required>
                                    </div>

                                    <div class="mb-3" data-kt-password-meter="true">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Password</label>
                                            </div>
                                            <div class="flex-shrink-0">
                                                {{-- <a href="#" class="text-muted">Forgot password?</a> --}}
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
											<input class="form-control bg-transparent" type="password" placeholder="Masukan Password" name="password" autocomplete="off" required/>
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="ki-outline ki-eye-slash fs-2"></i>
												<i class="ki-outline ki-eye fs-2 d-none"></i>
											</span>
										</div>
                                    </div>

                                    {{-- Peringatan login --}}
                                    @if($errors->has('login_error'))
                                    <div class="alert alert-danger" id="status-alert">
                                        {{ $errors->first('login_error') }}
                                    </div>
                                    @endif

                                    @if(session('statusLogin'))
                                        <div class="alert alert-success" id="status-alert">
                                            {{ session('statusLogin') }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Footer -->
                                <div class="card-footer">
                                    <div class="d-flex align-items-center justify-content-center w-100 w-sm-auto mt-5">
                                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                            <span class="me-2 btn-text">Login</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Loader Script -->
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

                <!-- Footer -->
                <div class="text-gray-500 text-center fw-semibold fs-6 mt-auto py-4">
                    <span>&copy; ESDM {{ date('Y') }}</span>
                </div>
            </div>

            <!-- Right Side Image Panel -->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" 
            style="background-image: url('/assetsMetronic/media/auth/bg4.jpg')"{{ asset('assetsMetronic/media/auth/bg4.jpg') }}>
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="#" class="mb-0 mb-lg-12">
                        <img alt="Logo" src="{{ asset('assets/images/logo-esdm.png') }}" class="h-60px h-lg-75px" />
                    </a>
                    {{-- <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="assets/media/misc/auth-screens.png" alt="" /> --}}
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-5">Sistem Pelaporan Migas</h1>
                    <p class="d-none d-lg-block text-white fs-5 text-center">
                        Platform digital untuk pelaporan dan pemantauan kegiatan migas <br>
                        secara efisien dan terintegrasi.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assetsMetronic/js/scripts.bundle.js') }}"></script>

    <!-- Custom JS (optional for this page) -->
    <script src="{{ asset('assetsMetronic/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/create-campaign.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/new-address.js') }}"></script>
    <script src="{{ asset('assetsMetronic/js/custom/utilities/modals/users-search.js') }}"></script>
	<script src="{{ asset('assetsMetronic/js/custom/authentication/sign-in/i18n.js') }}"></script>

    <script>
        // Setelah 3 detik, sembunyikan alert
        setTimeout(function() {
            var alertBox = document.getElementById('status-alert');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
        }, 3000); // 3000 ms = 3 detik
    </script>

</body>
</html>
