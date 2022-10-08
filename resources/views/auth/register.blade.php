@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Register'])

    <main id="main">

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Create your account now</h2>
                </div>

                <div class="row">

                    <div class="col-md-6 offset-md-3 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <form action="{{ route('register') }}" method="post" role="form" class="php-email-form">
                            @csrf

                            @if (Session::has('referral'))
                                <div class="form-group">
                                    <label for="referral">Referral</label>
                                    <input type="text" value="{{ Session::get('referral') }}" class="form-control"
                                        id="referral" readonly>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" value="{{ old('username') }}"
                                    class="form-control @error('username')
                                    is-invalid
                                @enderror"
                                    name="username" id="username" placeholder="John">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text"
                                    class="form-control @error('email')
                                is-invalid
                            @enderror"
                                    name="email" id="email" value="{{ old('email') }}"
                                    placeholder="example@gmail.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <select name="country" value="{{ old('country') }}" id="country" name="country"
                                    class="form-select @error('country')
                                is-invalid
                            @enderror">
                                    <option value="">Select...</option>
                                    @foreach ($countries as $c)
                                        <option value="{{ $c }}" {{ $c === old('country') ? 'selected' : '' }}>
                                            {{ $c }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <select name="code" value="{{ old('code') }}" class="code" id="code">
                                            @foreach ($codes as $code)
                                                <option value="{{ $code }}"
                                                    {{ $code == old('code') ? 'selected' : '' }}>
                                                    +{{ $code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <input type="number" value="{{ old('phone_number') }}"
                                        class="form-control @error('phone_number')
                                    is-invalid
                                @enderror"
                                        name="phone_number" id="phone_number">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" value="{{ old('password') }}"
                                    class="form-control @error('password')
                                is-invalid
                            @enderror"
                                    name="password" id="password" placeholder="12345@345">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div
                                class="form-group checkbox @error('terms')
                            checkbox_error
                        @enderror">
                                <input name="terms" type="checkbox" value="1" id="terms"
                                    {{ old('terms') ? 'checked' : '' }}>
                                <label for="terms">
                                    I accept the <a href="{{ route('terms') }}" target="_blank" class="btn-link">terms and
                                        conditions</a>
                                </label>
                            </div>
                            <button type="submit">Register</button>
                        </form>
                    </div>

                    <div class="text-center mt-3">
                        <span>Already have an account?</span>
                        <a href="{{ route('login') }}" class="btn-link">Login</a>
                    </div>

                </div>

            </div>
        </section>
        <!-- End Contact Section -->

    </main>
    <!-- End #main -->
@endsection
