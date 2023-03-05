@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.Not Found')])
    <div class="container pt-4 text-center">
        <div class="section-title">
            <h1>{{ __('main.page not found') }}</h1>
        </div>
        <div class="fs-4">404 || {{ __("main.Opps!! The page you're looking for does not exists.") }}</div>
        <a href="{{ route('index') }}" class="btn btn-main text-capitalize mt-2">{{ __('main.go to homepage') }}</a>
    </div>
@endsection
