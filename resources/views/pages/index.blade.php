@extends('layouts.web')

@section('content')
    <!-- Hero section -->
    <div class="hero">
        <div class="container">
            <h1>Bridon Production LLC</h1>
            <p>{{ __('main.watch our YouTube videos and get paid') }}</p>
            <div>
                <a href="{{ route('register') }}" class="btn btn-main">{{ __('main.get started') }}</a>
                <a href="{{ route('plans') }}" class="btn btn-sec ms-2">{{ __('main.our plans') }}</a>
            </div>
        </div>
    </div>
    <!-- End of hero section -->

    <!-- About us -->
    <section class="about my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h1>{{ __('main.about us') }}</h1>
                    </div>
                    <p>
                        {{ config('app.name') }}{{ __('main.aboutOne') }} <span class="text-main">Sean
                            Tv</span>{{ __('main.aboutTwo') }}
                    </p>
                    <p>
                        {{ __('main.aboutThree') }}
                    </p>
                    <div class="d-none d-lg-block">
                        <a href="{{ route('about') }}" class="btn btn-main mb-2">{{ __('main.Learn More') }}</a>
                        @include('components.social-media')
                        <hr />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ $video->url }}" title="YouTube video"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="text-center mb-3">
                    @include('components.social-media')
                </div>
                <a href="{{ route('about') }}" class="btn btn-main">{{ __('main.Learn More') }}</a>
                <hr />
            </div>
        </div>
    </section>
    <!-- End of about us -->
    <!-- Plans -->
    <div class="plans my-4">
        <div class="container">
            <div class="section-title">
                <h1>{{ __('main.plans') }}</h1>
            </div>

            <div class="row">
                @foreach ($plans as $plan)
                    @include('components.plan', ['plan' => $plan])
                @endforeach
            </div>
            <a href="{{ route('plans') }}" class="btn btn-main">{{ __('main.More Plans') }}</a>
            <hr />
        </div>
    </div>
    <!-- End of plans -->
    <!-- FAQs -->
    <section class="faqs">
        <div class="container">
            <div class="section-title">
                <h1 style="font-size:23px !important">{{ __('main.frequently asked questions') }}</h1>
            </div>

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ __('main.how do I start earning from') }} {{ config('app.name') }}?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.how-to-earn')
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            {{ __('main.how can I get in touch with') }} {{ config('app.name') }}?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>
                                {{ __('main.fa2-a') }} <a href="mailto:{{ env('EMAIL') }}">{{ env('EMAIL') }}</a>
                                {{ __('main.You can also') }} <a href="{{ env('TELEGRAM') }}"
                                    target="_blank">{{ __('main.join our telegram group') }}</a> {{ __('main.fa2-b') }}
                            </p>
                            <p>
                                {{ __('main.fa2-c') }} <a href="{{ route('contact') }}"
                                    target="_blank">{{ __('main.filling the form on the contact page.') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            {{ __('main.how can I support and thank :name for this financial opportunity?', ['name' => config('app.name')]) }}
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>{{ __('main.Support us by watching and subscribing to our social media videos and channels.') }}
                            </p>
                            <div class="text-center">
                                @include('components.social-media')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
        </div>
    </section>
    <!-- End of FAQs -->
@endsection
