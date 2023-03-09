@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.login')])

    <div class="login mt-4">
        <div class="container">
            <div class="section-title text-center">
                <h1>{{ __('main.welcome back') }}</h1>
            </div>
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                    <div class="form">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-text">+237</div>
                                <input type="number" placeholder="{{ __('main.Phone (MTN or Orange)') }}"
                                    value="{{ old('phone_number') }}" name="phone_number"
                                    class="form-control @error('phone_number')
                                    is-invalid
                                @enderror" />
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" placeholder="{{ __('main.Password') }}" name="password"
                                    class="form-control @error('password')
                                is-invalid
                            @enderror"
                                    id="password" />
                                <div class="input-group-text toggle-password" onclick="togglePasword(this)">
                                    <i class="fas fa-eye"></i>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="remember" type="checkbox" id="remember" />
                                    <label class="form-check-label" for="remember">
                                        {{ __('main.Keep me logged in') }}
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-main text-capitalize" type="submit">{{ __('main.login') }}</button>
                                <a href="{{ route('password.request') }}"
                                    class="text-capitalize">{{ __('main.forgot password?') }}</a>
                            </div>
                        </form>
                        <div class="text-center mt-2">
                            {{ __("main.Don't have an account?") }} <a href="{{ route('register') }}"
                                class="text-capitalize">{{ __('main.register') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
