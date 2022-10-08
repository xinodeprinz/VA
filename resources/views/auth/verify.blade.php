@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Verify your email'])

    <div id="contact" class="contact mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="php-email-form">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form method="POST" action="{{ route('verification.send') }}" class="mt-3">
                            @csrf
                            <button type="submit">{{ __('click here to request another') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
