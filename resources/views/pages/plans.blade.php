@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'our plans'])

    <!-- ======= Plans Section ======= -->
    <section id="pricing" class="pricing">
        <div class="container" data-aos="fade-up">

            <div class="row">
                @foreach ($plans as $plan)
                    <div class="col-md-4 col-sm-6 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card shadow">
                            <div class="card-header bg-money text-white">
                                <h3 class="text-center fs-2 pt-3 text-capitalize" style="color:white !important">
                                    {{ $plan->title }}
                                </h3>
                            </div>
                            <div class="card-body bg-white">
                                <h5 class="text-money fs-3 text-center">
                                    {{ session('currency') === 'USD' ? '$' : '' }}
                                    {{ number_format($plan->amount, $dp, '.', ',') }}
                                    {{ session('currency') === 'FCFA' ? session('currency') : '' }}</h5>
                                <ul class="text-capitalize ps-0 ps-sm-4 plan">
                                    <li><i class="bx bx-check"></i> Daily Ads: <span
                                            class="text-money fw-bold">{{ $plan->daily_ads }}</span>
                                    </li>
                                    <li><i class="bx bx-check"></i> Cost per ad: <span class="text-money fw-bold">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($plan->ad_cost, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </span>
                                    </li>
                                    <li><i class="bx bx-check"></i> Daily earnings: <span class="text-money fw-bold">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($plan->ad_cost * $plan->daily_ads, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </span></li>
                                    <li><i class="bx bx-check"></i> Weekly earnings: <span class="text-money fw-bold">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($plan->ad_cost * $plan->daily_ads * 7, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </span>
                                    </li>
                                    <li><i class="bx bx-check"></i> Monthly earnings: <span class="text-money fw-bold">
                                            {{ session('currency') === 'USD' ? '$' : '' }}
                                            {{ number_format($plan->ad_cost * $plan->daily_ads * 30, $dp, '.', ',') }}
                                            {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                        </span>
                                    </li>
                                    <li><i class="bx bx-check"></i> Validity: <span
                                            class="text-money fw-bold">{{ $plan->duration }}
                                            days</span></li>
                                    <li><i class="bx bx-check"></i> Withdrawal: <span
                                            class="text-money fw-bold">Automatic</span></li>
                                </ul>
                                <form action="{{ route('buy-plan') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <div class="text-center">
                                        <button type="submit"
                                            class="buy-btn bg-money text-white">{{ Auth::check() && Auth::user()->plan_id ? 'Upgrade Now' : 'Buy Now' }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Plans Section -->
@endsection
