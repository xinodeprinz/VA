@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Verify'])

    <div class="login mt-4">
        <div class="container">
            <div class="section-title text-center">
                <h1>{{ __('main.verify your email address') }}</h1>
            </div>
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                    <p class="text-center">
                        {{ __('main.Enter the 5 digit code sent to your email address in the input field below.') }}
                    </p>
                    <div class="form">
                        <form action="{{ route('verify-code') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="number" value="{{ old('code') }}"
                                    placeholder="{{ __('main.5 digit code') }}" name="code"
                                    class="form-control @error('code')
                                        is-invalid
                                    @enderror" />
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-main" type="submit">{{ __('main.Verify') }}</button>
                        </form>
                        <div class="text-center mt-2">
                            <form method="POST" action="{{ route('resend-code') }}">
                                @csrf
                                <span>{{ __("Didn't receive message?") }}</span>
                                <button type="submit" class="btn btn-link m-0 p-0">{{ __('main.Send Again') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
