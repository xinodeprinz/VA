<!DOCTYPE html>
<html lang="en">

<head>

    @include('components.meta')


    <!-- Favicons -->
    @include('components.favicons')

    <!-- Custom fonts for this template-->
    <link href="/account/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/account/css/sb-admin-2.min.css" rel="stylesheet">

    <script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=1a5fdd3651546098c1b8d9"></script>

</head>

<body id="page-top">

    {{-- Content enters here --}}
    @include('components.account-alert')

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('index') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img class="img-profile rounded-circle" alt="Logo" src="/storage/images/logo.jpg"
                        style="height:50px;width:50px">
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ request()->is('history/*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-record-vinyl"></i>
                    <span>Historys</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('deposit-history') }}">Deposit History</a>
                        <a class="collapse-item" href="{{ route('withdrawal-history') }}">Withdrawal History</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ request()->is('ads/*') || request()->is('ads') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ads') }}">
                    <i class="fas fa-fw fa-audio-description"></i>
                    <span>Ads</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ request()->routeIs('referrals') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('referrals') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Referrals</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ request()->is('adverts/*') || request()->is('adverts') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('adverts') }}">
                    <i class="fab fa-fw fa-react"></i>
                    <span>Advertisements</span></a>
            </li>

            @can('admin')
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item {{ request()->is('admin/*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapes-admin"
                        aria-expanded="true" aria-controls="collapes-admin">
                        <i class="fas fa-fw fa-user-circle"></i>
                        <span>Admin</span>
                    </a>
                    <div id="collapes-admin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('admin.users') }}">Users</a>
                            <a class="collapse-item" href="{{ route('admin.ads') }}">Ads</a>
                        </div>
                    </div>
                </li>
            @endcan

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="/account/img/undraw_rocket.svg"
                    alt="Money Adds Rocket">
                <p class="text-center mb-2">Take the step to earn more money daily.</p>
                <a class="btn btn-success btn-sm" href="{{ route('plans') }}">Upgrade Plan</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Website name -->
                    <div class="d-flex align-items-center">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 ml-3">
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
                        </div>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 smal text-capitalize">{{ $user->username }}</span>
                                <img class="img-profile rounded-circle" src="/storage/{{ $user->photo }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; {{ config('app.name') }} 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/account/vendor/jquery/jquery.min.js"></script>
    <script src="/account/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/account/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/account/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/account/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/account/js/demo/chart-area-demo.js"></script>
    <script src="/account/js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="/account/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/account/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/account/js/demo/datatables-demo.js"></script>

    <script src="/js/functions.js"></script>

    <script src="/js/ckeditor.js"></script>

    @include('components.ckeditor')

</body>

</html>
