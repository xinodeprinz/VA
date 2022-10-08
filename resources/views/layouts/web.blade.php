<!DOCTYPE html>
<html lang="en">

<head>

    @include('components.meta')



    <!-- Favicons -->
    @include('components.favicons')


    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/web/vendor/aos/aos.css" rel="stylesheet">
    <link href="/web/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/web/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/web/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/web/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/web/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/web/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/web/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha - v4.9.0
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    {{-- Content enters here --}}
    @include('components.alerts')

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto">
                <a href="index.html">
                    <img src="/storage/images/logo.jpg" alt="Money Adds Logo">
                    <span class="ms-2">{{ config('app.name') }}</span>
                </a>
            </h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto"><img src="/web/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    @foreach (['index', 'about', 'plans', 'contact'] as $page)
                        <li class="text-capitalize">
                            <?php
                            $active = '';
                            if (($page === 'index' && request()->is('/')) || ($page !== 'index' && request()->is($page))) {
                                $active = 'active';
                            }
                            
                            ?>
                            <a class="nav-link scrollto {{ $active }}"
                                href="{{ route($page) }}">{{ $page === 'index' ? 'home' : $page }}
                            </a>
                        </li>
                    @endforeach

                    <li class="text-capitalize">
                        <a class="getstarted scrollto" href="{{ route('login') }}">
                            {{ Auth::check() ? 'Dashboard' : 'Login' }}
                        </a>
                    </li>

                    {{-- Currency --}}
                    <li class="nav-item ms-3">
                        <form action="{{ route('currency') }}" method="POST" id="currency-form">
                            @csrf
                            <select name="currency" class="form-control" onchange="changeCurrency()"
                                style="cursor: pointer">
                                @foreach (['USD', 'FCFA'] as $currency)
                                    <option value="{{ $currency }}"
                                        {{ session('currency') === $currency ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->

        </div>
    </header>
    <!-- End Header -->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>{{ config('app.name') }}</h3>
                        <p>
                            <strong>Location:</strong> {{ env('LOCATION') }}<br><br>
                            <strong>Phone:</strong> {{ env('PHONE1') }}<br>
                            <strong>Email:</strong> {{ env('EMAIL') }}<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Social Networks</h4>
                        <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container footer-bottom clearfix">
            <div class="text-center">
                &copy; Copyright <strong><span>{{ config('app.name') }}</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="/web/vendor/aos/aos.js"></script>
    <script src="/web/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/web/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="/web/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="/web/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="/web/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="/account/vendor/jquery/jquery.min.js"></script>
    <script src="/js/functions.js"></script>

    <!-- Template Main JS File -->
    <script src="/web/js/main.js"></script>

    @include('sweetalert::alert')

</body>

</html>
