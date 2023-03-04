@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'about us'])

    <section class="about my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <p>
                        {{ config('app.name') }} also known as <span class="text-main">Sean Tv</span> is a group of
                        Cameroonian comedians that act short funny videos and upload them on their social media channels
                        such as Facebook, YouTube, Instagram and TikTok so as to earn money as people watch and subscribe to
                        them.
                    </p>
                    <p>
                        Our aim is to increase our YouTube watch hours and subscribers so as to get paid. Subscribe to a
                        plan now and start earning money as you watch videos of this sort daily.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ $video->url }}" title="YouTube video"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <hr>
            <div class="section-title">
                <h1>how do I start earning from {{ config('app.name') }}?</h1>
            </div>
            @include('components.how-to-earn')
        </div>
    </section>
@endsection
