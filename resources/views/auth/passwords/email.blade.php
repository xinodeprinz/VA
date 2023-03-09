@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.forgot password')])

    <div id="contact" class="contact my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!session('status'))
                        <form method="POST" class="php-email-form" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="{{ __('main.Email') }}"
                                        autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main">
                                {{ __('main.Send Password Reset Link') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
