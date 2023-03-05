@extends('layouts.account')

@section('content')
    <div class="d-lg-none">
        <div class="section-title text-center pt-5">
            <h1>video progress</h1>
        </div>
    </div>
    <div class="progress mb-4 mb-lg-2">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
            aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" id="video-progress">
        </div>
    </div>
    <div id="player-container">
        <div id="player"></div>
    </div>

    <form action="{{ route('video-reward') }}" method="post" id="form">
        @csrf
    </form>
@endsection
