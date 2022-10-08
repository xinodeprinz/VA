@extends('layouts.account')


@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-3 mb-md-0 text-gray-800">Dashboard</h1>
            <a href="{{ route('plans') }}" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-rocket fa-sm text-white-50"></i> Upgrade Plan</a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Balance</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 money">
                                    {{ session('currency') === 'USD' ? '$' : '' }}
                                    {{ number_format($user->account_balance, 2, '.', ',') }}
                                    {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Deposit</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 money">
                                    {{ session('currency') === 'USD' ? '$' : '' }}
                                    {{ number_format($user->deposits, 2, '.', ',') }}
                                    {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                                    Withdrawal
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 money">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($user->withdrawals, 2, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    My Plan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-capitalize money">
                                    {{ $user->plan ? $user->plan->title : 'No Plan' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Ads Details</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="border border-primary h-100 p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calculator text-primary fa-3x"></i>
                                        <div class="ml-3">
                                            <div class="font-weight-bold text-gray-800">Total clicks</div>
                                            <div>{{ number_format($user->total_clicks, 0, '.', ',') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="border border-primary h-100 p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-arrow-alt-circle-up text-primary fa-3x"></i>
                                        <div class="ml-3">
                                            <div class="font-weight-bold text-gray-800">Today's clicks
                                            </div>
                                            <div>{{ number_format($user->today_clicks, 0, '.', ',') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="border border-primary h-100 p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-primary fa-3x"></i>
                                        <div class="ml-3">
                                            <div class="font-weight-bold text-gray-800">Days left</div>
                                            <div>{{ number_format($user->expires_in, 0, '.', ',') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($user->plan()->exists() && $user->has_clicked_ads)
                                <div class="col-12 mb-3">
                                    <div class="border border-primary h-100 p-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-stopwatch text-primary fa-3x"></i>
                                            <div class="ml-3">
                                                <div class="font-weight-bold text-gray-800">Time to next clicks
                                                </div>
                                                <div id="show-time"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-8 mb-4">

                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Activities</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <a href="{{ route('momo-deposit') }}"
                                    class="card bg-primary text-white shadow text-decoration-none p-3">
                                    <div class="card-body text-center">
                                        <div><i class="fas fa-dollar-sign fa-2x"></i></div>
                                        <div>Deposit Now</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <a href="{{ route('momo-withdrawal') }}"
                                    class="card bg-success text-white shadow text-decoration-none p-3">
                                    <div class="card-body text-center">
                                        <div><i class="fas fa-dollar-sign fa-2x"></i></div>
                                        <div>Withdraw Now</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <a href="{{ route('ads') }}"
                                    class="card bg-dark text-white shadow text-decoration-none p-3">
                                    <div class="card-body text-center">
                                        <div><i class="fas fa-audio-description fa-2x"></i></div>
                                        <div>View Ads</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <a href="{{ route('adverts') }}"
                                    class="card bg-secondary text-white shadow text-decoration-none p-3">
                                    <div class="card-body text-center">
                                        <div><i class="fab fa-react fa-2x"></i></div>
                                        <div>Advertisements</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Plan Details</h6>
                    </div>
                    <div class="card-body text-capitalize">

                        @if (!$user->plan)
                            <div class="mb-0 font-weight-bold text-gray-800 mb-3">No Plan</div>
                            <a href="{{ route('plans') }}" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-rocket fa-sm text-white-50"></i> Upgrade Plan</a>
                        @else
                            <ul class="list-group list-group-flush" id="account-plan">
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-2">Name:</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->plan->title }}</div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-2">Price:</div>
                                        <div class="mb-0 font-weight-bold text-gray-800">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($user->plan->amount, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-2">Daily Ads:</div>
                                        <div class="mb-0 font-weight-bold text-gray-800">{{ $user->plan->daily_ads }}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-2">Cost per ad:</div>
                                        <div class="mb-0 font-weight-bold text-gray-800">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($user->plan->ad_cost, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-2">Daily Earnings:</div>
                                        <div class="mb-0 font-weight-bold text-gray-800">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($user->plan->ad_cost * $user->plan->daily_ads, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-2">Weekly Earnings:</div>
                                        <div class="mb-0 font-weight-bold text-gray-800">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($user->plan->ad_cost * $user->plan->daily_ads * 7, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-2">Monthly Earnings:</div>
                                        <div class="mb-0 font-weight-bold text-gray-800">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($user->plan->ad_cost * $user->plan->daily_ads * 30, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <script src="/js/time.js"></script>
@endsection
