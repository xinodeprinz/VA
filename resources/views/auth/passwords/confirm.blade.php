@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Confirm Password'])

    <div id="contact" class="contact mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="section-title">
                        <h2 style="font-size:20px">{{ __('Please confirm your password before continuing.') }}</h2>
                    </div>

                    <form method="POST" class="php-email-form" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Confirm Password') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
