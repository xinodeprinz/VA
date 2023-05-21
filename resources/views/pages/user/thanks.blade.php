@extends('layouts.account')

@section('content')
    <div class="alert alert-info text-center">
        {{ __('main.You have watched your videos for today. Please wait till tomorrow to watch again.') }}
    </div>
    <div class="text-center">
        <a href="{{ route('home') }}" class="btn btn-main text-capitalize">{{ __('main.go to dashboard') }}</a>
        {{-- @include('components.social-media') --}}
        {{-- <div class="mt-3">
            <a href="{{ env('WHATSAPP') }}" class="btn btn-main" target="_blank">
                <i class="fab fa-whatsapp"></i>
                {{ __('main.Join WhatsApp group') }}
            </a>
        </div> --}}
    </div>
@endsection
