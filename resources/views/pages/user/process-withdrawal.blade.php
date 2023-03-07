@extends('layouts.account')

@section('content')
    <div class="section-title text-center">
        <h1>{{ __('main.finalize withdrawal') }}</h1>
    </div>
    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
            <p class="text-center">
                {{ __('main.Enter the 5 digit code sent to your email address in the input field below.') }}
            </p>
            <div class="form">
                <form action="{{ route('process-withdrawal') }}" onsubmit="disableWithBtn()" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="number" value="{{ old('code') }}" placeholder="{{ __('main.5 digit code') }}"
                            name="code"
                            class="form-control @error('code')
                            is-invalid
                        @enderror" />
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-main" type="submit" id="withBtn">{{ __('main.Verify') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
