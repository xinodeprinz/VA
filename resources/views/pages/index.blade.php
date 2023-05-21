@extends('layouts.web')

@section('content')
    <!-- Hero section -->
    <div class="hero">
        <div class="container">
            <h1>{{ config('app.name') }}</h1>
            <p>{{ __("main.Africa's video paying platform") }}</p>
            <div>
                <a href="{{ route('register') }}" class="btn btn-main">{{ __('main.get started') }}</a>
                <a href="{{ route('invest') }}" class="btn btn-sec ms-2">{{ __('main.Start earning') }}</a>
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
                        {{ __('main.aboutOne') }}
                    </p>
                    <p>
                        {{ __('main.aboutTwo') }}
                    </p>
                    <p>
                        {{ __('main.aboutThree') }}
                    </p>
                    <div class="d-lg-none text-center mb-2 text-capitalize">
                        <a href="{{ route('invest') }}" class="btn btn-link">{{ __('main.invest now') }}</a>
                    </div>
                    <div class="d-none d-lg-block">
                        <a href="{{ route('about') }}" class="btn btn-main mb-2">{{ __('main.Learn More') }}</a>
                        <hr />
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="/images/about.jpg" class="img-fluid" alt="{{ config('app.name') }}">
                </div>
            </div>
            <div class="d-lg-none">
                <a href="{{ route('about') }}" class="btn btn-main mt-2">{{ __('main.Learn More') }}</a>
                <hr />
            </div>
        </div>
    </section>
    <!-- End of about us -->
    <!--Video-->
    @if ($video)
        <section class="video my-4">
            <div class="container">
                <div class="section-title">
                    <h1>{{ __('main.example video') }}</h1>
                </div>
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/{{ $video->url }}" title="YouTube video"
                        allowfullscreen></iframe>
                </div>
            </div>
        </section>
    @endif
    <!--End of video-->
    <!--Invest-->
    <section class="invest my-4">
        <div class="container">
            <div class="section-title">
                <h1>{{ __('main.Start earning') }}</h1>
            </div>
            <p>{{ __('main.invest-text') }}</p>
            <a href="{{ route('invest') }}" class="btn btn-lg btn-main">{{ __('main.invest now') }}</a>
        </div>
    </section>
    <!--End of invest-->
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
                                {{-- {{ __('main.You can also') }} <a href="{{ env('TELEGRAM') }}"
                                    target="_blank">{{ __('main.join our telegram group') }}</a> {{ __('main.fa2-b') }} --}}
                            </p>
                            <p>
                                {{ __('main.fa2-c') }} <a href="{{ route('contact') }}"
                                    target="_blank">{{ __('main.filling the form on the contact page.') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
        </div>
    </section>
    <!-- End of FAQs -->
    <!-- Newsletter -->
    <section class="newsletter my-4">
        <div class="container p-4">
            <div class="section-title">
                <h1>{{ __('main.subscribe to our newsletter') }}</h1>
            </div>
            <div class="row">
                <div class="col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                    <form action="{{ route('newsletter') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="email"
                                class="form-control @error('email')
                                is-invalid
                            @enderror"
                                value="{{ old('email') }}" placeholder="{{ __('main.person@example.com') }}">
                            <button class="btn text-capitalize" type="submit">{{ __('main.subscribe') }}</button>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Newsletter -->
@endsection
