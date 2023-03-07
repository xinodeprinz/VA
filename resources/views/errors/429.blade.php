@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.too many attemps')])
    <div class="container pt-4 text-center">
        <div class="fs-4">{{ __("main.Opps!! You've attemped so many times; please try again later.") }}</div>
        <a href="{{ route('home') }}" class="btn btn-main text-capitalize mt-2">{{ __('main.go to account') }}</a>
    </div>
@endsection
