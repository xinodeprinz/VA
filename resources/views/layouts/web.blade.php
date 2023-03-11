<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.meta')
    @include('components.favicons')
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
                                href="{{ $item === 'home' ? '/' : route($item) }}">{{ __('main.' . $item) }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="btn btn-sec text-capitalize"
                            href="{{ route('login') }}">{{ Auth::check() ? __('main.dashboard') : __('main.login') }}</a>
                    </li>
                    <li class="nav-item dropdown languages">
                        <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle">
                            <img src="/storage/images/{{ App::currentLocale() === 'fre' ? 'french' : 'english' }}.png"
                                alt="{{ App::currentLocale() === 'fre' ? 'French' : 'UK' }} Flag" class="flag">
                            <span>{{ App::currentLocale() === 'fre' ? __('main.french') : __('main.english') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('language.change', ['locale' => 'en']) }}" class="dropdown-item">
                                <img src="/storage/images/english.png" alt="UK Flag" class="flag">
                                <span>{{ __('main.english') }}</span>
                            </a>
                            <a href="{{ route('language.change', ['locale' => 'fre']) }}" class="dropdown-item">
                                <img src="/storage/images/french.png" alt="French Flag" class="flag">
                                <span>{{ __('main.french') }}</span>
                            </a>
                        </div>
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
                            <h1>{{ __('main.contact us') }}</h1>
                        </div>
                        <div>
                            <a href="mailto:{{ env('EMAIL') }}" style="text-transform: lowercase"><i
                                    class="fas fa-envelope"></i>
                                {{ env('EMAIL') }}</a>
                        </div>
                        <a href="{{ env('TELEGRAM') }}" target="_blank"><i class="fab fa-telegram"></i>
                            {{ __('main.Join Telegram group') }}</a>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="section-title">
                            <h1>{{ __('main.our aim') }}</h1>
                        </div>
                        <p>
                            {{ __('main.footer-desc') }}
                        </p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="section-title">
                            <h1>{{ __('main.useful links') }}</h1>
                        </div>
                        <ul>
                            <li><a href="{{ route('register') }}">{{ __('main.register') }}</a></li>
                            <li><a href="{{ route('home') }}">{{ __('main.dashboard') }}</a></li>
                            <li><a href="{{ route('plans') }}">{{ __('main.buy plan') }}</a></li>
                            <li><a href="{{ route('momo-deposit') }}">{{ __('main.deposit') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright py-3">
            {{ config('app.name') }} &copy; {{ \Carbon\Carbon::now()->format('Y') }}
            {{ __('main.all rights reserved.') }}
        </div>
    </footer>
    <!-- End of footer -->
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/all.js"></script>
    <script src="/js/functions.js"></script>
    <script src="/js/sw-starter.js"></script>
    <script src="/sw.js"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
</body>

</html>
