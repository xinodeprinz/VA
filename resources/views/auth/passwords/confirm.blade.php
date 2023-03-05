@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.Confirm Password')])

    <div id="contact" class="contact mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="section-title text-center">
                        <h1 style="font-size:17px !important">
                            {{ __('main.Please confirm your password before continuing.') }}
                        </h1>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="current-password" placeholder="{{ __('main.Password') }}">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <button type="submit" class="btn btn-main">
                                {{ __('main.Confirm Password') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('main.forgot password') }}?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
