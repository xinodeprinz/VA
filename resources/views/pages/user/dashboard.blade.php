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
                <div class="icon text-warning icon-yoo">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="ms-2">
                    @if ($user->plan)
                        <h4>{{ __('main.Current Plan:') }} <span>{{ $user->plan->title }}</span></h4>
                        <h4>{{ __('main.Expires in:') }}
                            <span>{{ $user->planDaysLeft }} {{ Str::plural('day', $user->planDaysLeft) }}</span>
                        </h4>
                    @else
                        <h4>{{ __('main.Current Plan:') }}</h4>
                        <div>{{ __('main.None') }}</div>
                    @endif
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
                    <div>{{ $user->plan ? number_format($user->plan->min_withdrawal, 0) : 0 }} FCFA</div>
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
            <a href="{{ route('plans') }}" class="dash-btn bg-warning p-2">upgrade plan</a>
        </div>
    </div>
    <hr />
    <div class="row">
        <!-- Timer -->
        @if ($showTimer)
            <div class="col-12">
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
@endsection
