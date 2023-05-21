@extends('layouts.account')

@section('content')
    <div class="row">
        <!-- Box -->
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="bg-main box shadow p-3 d-flex align-items-center">
                <div class="icon text-main">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="ms-2">
                    <h4>{{ __('main.account balance') }}</h4>
                    <div>{{ number_format($user->balance, 0) }} FCFA</div>
                </div>
            </div>
        </div>
        <!-- Box -->
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="bg-primary box shadow p-3 d-flex align-items-center">
                <div class="icon text-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="ms-2">
                    <h4>{{ __('main.Total Deposit') }}</h4>
                    <div>{{ number_format($user->deposits, 0) }} FCFA</div>
                </div>
            </div>
        </div>
        <!-- Box -->
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="bg-secondary box shadow p-3 d-flex align-items-center">
                <div class="icon text-secondary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="ms-2">
                    <h4>{{ __('main.Total Withdrawal') }}</h4>
                    <div>{{ number_format($user->withdrawals, 0) }} FCFA</div>
                </div>
            </div>
        </div>
        <!-- Box -->
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="bg-warning box shadow p-3 d-flex align-items-center">
                <div class="icon text-warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="ms-2">
                    <h4>{{ __('main.invested amount') }}</h4>
                    <div>{{ number_format($user->investment ? $user->investment->amount : 0) }} FCFA</div>
                </div>
            </div>
        </div>
        <!-- Box -->
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="bg-dark box shadow p-3 d-flex align-items-center">
                <div class="icon text-dark">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="ms-2">
                    <h4>{{ __('main.Min withdrawal') }}</h4>
                    <div>{{ $user->investment ? number_format($user->investment->min_withdrawal, 0) : 0 }} FCFA</div>
                </div>
            </div>
        </div>
        <!-- Box -->
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="bg-dark box shadow p-3 d-flex align-items-center">
                <div class="icon text-dark icon-yoo">
                    <i class="fas fa-users"></i>
                </div>
                <div class="ms-2">
                    <h4>{{ __('main.referrals') }}</h4>
                    <div>{{ number_format($user->referrals->count(), 0) }}</div>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('momo', ['type' => 'deposit']) }}" class="dash-btn bg-main p-2">{{ __('main.deposit') }}</a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('momo', ['type' => 'withdrawal']) }}"
                class="dash-btn bg-primary p-2">{{ __('main.withdraw') }}</a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('video') }}" class="dash-btn bg-dark p-2">{{ __('main.watch video') }}</a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('invest') }}" class="dash-btn bg-warning p-2">{{ __('main.upgrade') }}</a>
        </div>
    </div>
    <hr />
    <div class="row">
        <!--Investment days left-->
        @if ($user->investment)
            <div class="{{ $showTimer ? 'col-md-6 mb-3' : 'col-md-8 col-lg-6 offset-md-2 offset-lg-3 mb-3' }}">
                <div class="bg-main box shadow text-center p-3">
                    <h4>{{ __('main.investment days left') }}</h4>
                    <div class="fs-5">{{ $user->investmentDaysLeft }}</div>
                </div>
            </div>
        @endif
        <!-- Timer -->
        @if ($showTimer)
            <div class="col-md-6 mb-3">
                <div class="bg-danger box shadow p-3 d-flex align-items-center justify-content-center">
                    <div class="icon clock-icon text-danger">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="ms-2">
                        <h4>{{ __('main.time to next watch') }}</h4>
                        <div id="show-time"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <hr>
    <!--Chart-->
    <canvas id="chartId" aria-label="chart" class="chart"></canvas>
@endsection
