@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.' . $title)])

    <div class="login mt-4">
        <div class="container">
            <div class="section-title text-center">
                <h1>{{ __('main.payment methods') }}</h1>
            </div>
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                    <div class="d-flex align-items-center mb-3 justify-content-center">
                        <img src="/storage/images/mtn.png" class="p-method" alt="MTN" />
                        <img src="/storage/images/orange.png" class="p-method ms-2" alt="Orange" />
                    </div>
                    <div class="form">
                        @if ($plan)
                            <div class="mb-3 amount-bar">{{ __('main.Amount') }}:
                                <span>{{ number_format($plan->amount, 0) }} FCFA</span>
                            </div>
                        @endif
                        <div class="mb-3 amount-bar">{{ __('main.Tel:') }}
                            <span>(+237) {{ $phone_number }}</span>
                        </div>
                        @if ($type === 'withdrawal')
                            <div class="mb-3 amount-bar">{{ __('main.Min withdrawal') }}:
                                <span>{{ number_format($user->plan->min_withdrawal, 0) }} FCFA</span>
                            </div>
                        @endif
                        <form action="{{ route('momo-' . $type) }}" method="POST">
                            @csrf
                            @if ($type !== 'plan')
                                <div class="input-group mb-3">
                                    <input type="number" placeholder="{{ __('main.Amount') }}" value="{{ old('amount') }}"
                                        name="amount"
                                        class="form-control @error('amount')
                                        is-invalid
                                    @enderror" />
                                    <div class="input-group-text">FCFA</div>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            <button class="btn btn-main" type="submit">{{ __('main.Process') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
