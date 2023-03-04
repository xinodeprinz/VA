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
                    <h4>account balance</h4>
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
                    <h4>Total Deposit</h4>
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
                    <h4>Total Withdrawal</h4>
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
                        <h4>Current Plan: <span>{{ $user->plan->title }}</span></h4>
                        <h4>Expires in:
                            <span>{{ $user->planDaysLeft }} {{ Str::plural('day', $user->planDaysLeft) }}</span>
                        </h4>
                    @else
                        <h4>Current Plan</h4>
                        <div>None</div>
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
                    <h4>Min withdrawal</h4>
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
                    <h4>referrals</h4>
                    <div>{{ number_format($user->referrals->count(), 0) }}</div>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('momo', ['type' => 'deposit']) }}" class="dash-btn bg-main p-2">deposit</a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('momo', ['type' => 'withdrawal']) }}" class="dash-btn bg-primary p-2">withdraw</a>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <a href="{{ route('video') }}" class="dash-btn bg-dark p-2">watch video</a>
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
                        <h4>time to next watch</h4>
                        <div id="show-time"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
