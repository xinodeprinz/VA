<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.meta')
</head>

<body>
    <!-- Alerts -->
    @include('components.alerts')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="/storage/images/logo.jpg" alt="{{ config('app.name') }}" class="logo" />
                <span>{{ config('app.name') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @foreach (['home', 'about', 'plans', 'contact'] as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($item) || (request()->routeIs('index') && $item === 'home') ? 'active' : '' }}"
                                href="{{ $item === 'home' ? '/' : route($item) }}">{{ $item }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="btn btn-sec"
                            href="{{ route('login') }}">{{ Auth::check() ? 'Dashboard' : 'Login' }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of navbar -->

    @yield('content')

    <!-- Footer -->
    <footer class="footer mt-4">
        <div class="widget pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="section-title">
                            <h1>contact us</h1>
                        </div>
                        <div>
                            <a href="mailto:{{ env('EMAIL') }}"><i class="fas fa-envelope"></i>
                                {{ env('EMAIL') }}</a>
                        </div>
                        <a href="{{ env('TELEGRAM') }}" target="_blank"><i class="fab fa-telegram"></i> Join Telegram
                            group</a>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="section-title">
                            <h1>our aim</h1>
                        </div>
                        <p>
                            We aim to increase our YouTube watch hours and subscribers so as to get paid. Subscribe
                            to a plan now and start earning money as you watch short YouTube videos of averagely 2
                            minutes long daily.
                        </p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="section-title">
                            <h1>useful links</h1>
                        </div>
                        <ul>
                            <li><a href="{{ route('register') }}">register</a></li>
                            <li><a href="{{ route('home') }}">my account</a></li>
                            <li><a href="{{ route('plans') }}">buy plan</a></li>
                            <li><a href="{{ route('momo-deposit') }}">deposit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright py-3">
            {{ config('app.name') }} &copy; {{ \Carbon\Carbon::now()->format('Y') }} all rights reserved.
        </div>
    </footer>
    <!-- End of footer -->
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/all.js"></script>
    <script src="/js/functions.js"></script>
</body>

</html>
