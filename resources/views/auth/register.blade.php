@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.register')])

    <div class="login mt-4">
        <div class="container">
            <div class="section-title text-center">
                <h1>{{ __('main.create account') }}</h1>
            </div>
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                    <div class="form">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            @if (Session::has('referral'))
                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <input type="text" value="{{ __('main.Referred by:') }} {{ session('referral') }}"
                                        class="form-control" readonly />
                                </div>
                            @endif
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" placeholder="{{ __('main.Username') }}" value="{{ old('username') }}"
                                    name="username"
                                    class="form-control @error('username')
                                        is-invalid
                                    @enderror" />
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input type="text" placeholder="{{ __('main.Email') }}" value="{{ old('email') }}"
                                    name="email"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror" />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                </div>
                                <select value="{{ old('country') ?? $countries[0] }}" name="country"
                                    onchange="countryCode(this)"
                                    class="form-select text-capitalize @error('country')
                                    is-invalid
                                @enderror">
                                    {{-- <option value="">{{ __('main.Select...') }}</option> --}}
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}"
                                            {{ old('country') === $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-text" id="c-code">+256</div>
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
                            <button class="btn btn-main text-capitalize" type="submit">{{ __('main.register') }}</button>
                        </form>
                        <div class="text-center mt-2">
                            {{ __('main.Already have an account?') }} <a href="{{ route('login') }}"
                                class="text-capitalize">{{ __('main.login') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
