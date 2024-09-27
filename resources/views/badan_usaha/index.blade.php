<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <title>Coming Soon</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />

    <meta content="Themesbrand" name="author" />

    <!-- App favicon -->

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">



    <!-- swiper css -->

    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">



    <!-- preloader css -->

    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />



    <!-- Bootstrap Css -->

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->

    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->

    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />



    <!-- choices css -->

    <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>



<body>



    <!-- <body data-layout="horizontal"> -->

    <div class="preview-img">

        <div class="swiper-container preview-thumb">

            <div class="swiper-wrapper">

                <div class="swiper-slide">

                    <div class="slide-bg" style="background-image: url(./assets/images/bg-4.jpg);"></div>

                </div>

                {{-- <div class="swiper-slide">

                    <div class="slide-bg" style="background-image: url(./assets/images/bg-2.jpg);"></div>

                </div>

                <div class="swiper-slide">

                    <div class="slide-bg" style="background-image: url(./assets/images/bg-3.jpg);"></div>

                </div> --}}

            </div>

        </div>

        <!-- preview-thumb -->

        {{-- <div class="swiper-container preview-thumbsnav">

            <div class="swiper-wrapper">

                <div class="swiper-slide">

                    <div>

                        <img src="{{ asset('assets/images/bg-1.jpg') }}" alt=""
                            class="avatar-sm nav-img rounded-circle">

                    </div>

                </div>

                <div class="swiper-slide">

                    <div>

                        <img src="{{ asset('assets/images/bg-2.jpg') }}" alt=""
                            class="avatar-sm nav-img rounded-circle">

                    </div>

                </div>

                <div class="swiper-slide">

                    <div>

                        <img src="{{ asset('assets/images/bg-3.jpg') }}" alt=""
                            class="avatar-sm nav-img rounded-circle">

                    </div>

                </div>

            </div>

        </div> --}}

        <!-- preview-thumb -->

    </div>

    <!-- preview bg -->



    <div class="coming-content min-vh-100 py-4 px-3 py-sm-5">

        {{-- <div class="bg-overlay bg-primary"></div> --}}

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <div class="text-right">

                        <div class="text-center">

                            <div class="mb-5">

                                <a href="#">
                                    <img src="{{ asset('assets/images/logo-esdm.png') }}" alt="" height="40"
                                        class="me-2"><span class="logo-txt font-size-20">Pelaporan Migas</span>
                                </a>
                            </div>

                            <h5 class="mt-5">Pilih Perusahaan</h5>

                        </div>
                        <form class="row gx-3 gy-2 align-items-center mx-auto" style="max-width: 80%" method="POST"
                            action="{{ url('/login/post-login') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="hstack gap-3">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="perusahaan">
                                    <option value="">- PILIH PERUSAHAAN -</option>
                                    @foreach ($perusahaan as $p)
                                        <option value="{{ $p->ID_PERUSAHAAN }}">{{ $p->NAMA_PERUSAHAAN }}</option>
                                    @endforeach
                                </select>
                                {{-- <button type="reset" class="btn btn-outline-danger">Reset</button> --}}
                                <button class="btn btn-primary" type="submit"><i
                                        class="bx bx-paper-plane align-middle"></i></button>
                            </div>
                        </form>
                        {{-- <form class="app-search mt-1 mx-auto" style="max-width: 70%" method="POST"
                            action="{{ url('/login/post-login') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="position-relative">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="perusahaan">
                                    <option value="">- PILIH PERUSAHAAN -</option>
                                    @foreach ($perusahaan as $p)
                                        <option value="{{ $p->ID_PERUSAHAAN }}">{{ $p->NAMA_PERUSAHAAN }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="submit"><i
                                        class="bx bx-paper-plane align-middle"></i></button>
                            </div>
                        </form> --}}
                        @if (session('statusLogin'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ session('statusLogin') }}</strong>
                            </div>
                        @endif

                    </div>

                </div>

                <!-- end col -->

            </div>

            <!-- end row -->

        </div>

        <!-- end container -->

    </div>

    <!-- coming-content -->



    <!-- swiper js -->

    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>



    <!-- Countdown js -->

    <script src="{{ asset('assets/js/pages/coming-soon.init.js') }}"></script>



    <!-- choices js -->

    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>



    <!-- init js -->

    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>



    {{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}

</body>

<script>
    $(document).ready(function() {

        $('.select2').select2({

            closeOnSelect: false

        });

    });
</script>



</html>
