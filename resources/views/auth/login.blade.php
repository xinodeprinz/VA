@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Login'])

    <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Welcome back</h2>
                </div>

                <div class="row">

                    <div class="col-md-6 offset-md-3 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <form action="{{ route('login') }}" method="post" role="form" class="php-email-form">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" value="{{ old('email') }}" placeholder="exmaple@gmail.com"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                    name="email" id="email" placeholder="">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password"
                                    class="form-control @error('password')
                                is-invalid
                            @enderror"
                                    name="password" id="password" placeholder="12345@345">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group checkbox">
                                <input name="remember" type="checkbox" id="remember_me">
                                <label for="remember_me">
                                    Remember me
                                </label>
                            </div>
                            <button type="submit">Login</button>
                        </form>
                    </div>
                    <div class="text-center mt-3">
                        <span>Don't have an account?</span>
                        <a href="{{ route('register') }}" class="btn-link">Register</a>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif

                </div>

            </div>
        </section>
        <!-- End Contact Section -->

    </main>
    <!-- End #main -->
@endsection
