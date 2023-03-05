@extends('layouts.account')

@section('content')
    <div class="section-title">
        <h1>{{ __('main.our appreciations') }}</h1>
    </div>
    <p>{{ __('main.thanks-1') }}</p>
    <p>{{ __('main.thanks-2') }}</p>
    <div class="text-center">
        @include('components.social-media')
    </div>
@endsection
