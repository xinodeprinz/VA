<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Alerts -->
    @include('components.alerts')
    <div class="row g-0">
        <div class="col-lg-4 col-xl-3 d-none d-lg-block">
            <!-- Sidebar -->
            <aside class="sidebar py-3">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <img src="/storage/images/logo.jpg" alt="{{ config('app.name') }}" class="logo" />
                        <span>{{ config('app.name') }}</span>
                    </a>
                    <ul class="sidebar-nav" id="sidebar-nav">
                        @include('components.account-links')
                    </ul>
                </div>
            </aside>
        </div>
        <div class="col-lg-8 col-xl-9">
            <!-- Navbar -->
            <header class="dashboard">
                <nav class="navbar navbar-expand-lg">
                    <div class="container">
                        <div class="navbar-brand">user dashboard</div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <div class="d-lg-none">
                                    @include('components.account-links')
                                </div>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle username" data-bs-toggle="dropdown"
                                        href="#">{{ $user->username }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <!-- End of navbar -->

            <main>
                <div class="container">
                    @yield('content')
                </div>
            </main>
            <!-- Footer -->
            <footer class="dash-footer py-3">
                <div class="container text-center">
                    {{ config('app.name') }} &copy; copyright {{ \Carbon\Carbon::now()->format('Y') }}, All rights
                    reserved.
                </div>
            </footer>
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/all.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="/js/functions.js"></script>
    <script src="/js/time.js"></script>
    <script src="/js/video.js"></script>
</body>

</html>
