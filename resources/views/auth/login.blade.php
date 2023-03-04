@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Login'])

    <div class="login mt-4">
        <div class="container">
            <div class="section-title text-center">
                <h1>welcome back</h1>
            </div>
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                    <div class="form">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-text">+237</div>
                                <input type="number" placeholder="Phone (MTN or Orange)" value="{{ old('phone_number') }}"
                                    name="phone_number"
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
                                <input type="password" placeholder="Password" name="password"
                                    class="form-control @error('password')
                                is-invalid
                            @enderror" />
                                <div class="toggle-pass"><i class="fas fa-eye"></i></div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="remember" type="checkbox" id="remember" />
                                    <label class="form-check-label" for="remember">
                                        Keep me logged in
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-main" type="submit">Login</button>
                        </form>
                        <div class="text-center mt-2">
                            Don't have an account? <a href="{{ route('register') }}">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
