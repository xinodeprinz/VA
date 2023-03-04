@extends('layouts.account')

@section('content')
    <div class="d-lg-none">
        <div class="section-title text-center pt-5">
            <h1>video progress</h1>
        </div>
    </div>
    <div class="progress mb-2">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
            aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">75%
        </div>
    </div>
    <div class="d-none d-lg-block">
        <div class="ratio ratio-21x9">
            <iframe src="https://www.youtube.com/embed/{{ $video->url }}" title="YouTube video" allowfullscreen></iframe>
        </div>
    </div>
    <div class="d-lg-none mobile-video">
        <div class="ratio ratio-1x1">
            <iframe src="https://www.youtube.com/embed/{{ $video->url }}" title="YouTube video" allowfullscreen></iframe>
        </div>
    </div>
@endsection
