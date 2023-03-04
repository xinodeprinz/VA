@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Register'])

    <div class="login mt-4">
        <div class="container">
            <div class="section-title text-center">
                <h1>create account</h1>
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
                                    <input type="text" value="Referred by: {{ session('referral') }}"
                                        class="form-control" readonly />
                                </div>
                            @endif
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" placeholder="Username" value="{{ old('username') }}" name="username"
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
                                <input type="text" placeholder="Email" value="{{ old('email') }}" name="email"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror" />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                            <button class="btn btn-main" type="submit">Register</button>
                        </form>
                        <div class="text-center mt-2">
                            Already have an account? <a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
