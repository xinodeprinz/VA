@extends('layouts.web')

@section('content')
    <!-- Hero section -->
    <div class="hero">
        <div class="container">
            <h1>Bridon Production LLC</h1>
            <p>watch our YouTube videos and get paid</p>
            <div>
                <a href="{{ route('register') }}" class="btn btn-main">get started</a>
                <a href="{{ route('plans') }}" class="btn btn-sec ms-2">our plans</a>
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
                        <h1>about us</h1>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum
                        facere suscipit nisi modi blanditiis doloremque at error! Amet,
                        quae magni nulla culpa totam deleniti? Consequatur possimus
                        recusandae eos deserunt illo?
                    </p>
                    <p>
                        magni nulla culpa totam deleniti? Consequatur possimus recusandae
                        eos deserunt illo?
                    </p>
                    <div class="d-none d-lg-block">
                        <a href="{{ route('about') }}" class="btn btn-main mb-2">Learn More</a>
                        <div class="social-media">
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-tiktok"></i></a>
                        </div>
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
                <div class="social-media mb-3 text-center">
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
                <a href="{{ route('about') }}" class="btn btn-main">Learn More</a>
                <hr />
            </div>
        </div>
    </section>
    <!-- End of about us -->
    <!-- Plans -->
    <div class="plans my-4">
        <div class="container">
            <div class="section-title">
                <h1>plans</h1>
            </div>

            <div class="row">
                @foreach ($plans as $plan)
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <div class="card">
                            <div class="card-header py-4">
                                <div class="title">{{ $plan->title }}</div>
                                <div class="price">{{ number_format($plan->amount, 0) }} FCFA</div>
                            </div>
                            <div class="card-body">
                                <div><span>videos per day:</span> {{ $plan->videos }}</div>
                                <div><span>video cost:</span> {{ number_format($plan->video_cost, 0) }} FCFA</div>
                                <div>
                                    <span>duration:</span> {{ $plan->duration }} {{ Str::plural('day', $plan->duration) }}
                                </div>
                                <div><span>total earn:</span> {{ number_format($plan->total_earn, 0) }} FCFA</div>
                                <div><span>withdrawal:</span> automatic</div>
                                <div><span>min widthdrawal:</span> {{ number_format($plan->min_withdrawal, 0) }} FCFA</div>
                                <form action="{{ route('buy-plan') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <button class="btn btn-main text-capitalize w-100 mt-2">subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('plans') }}" class="btn btn-main">More Plans</a>
            <hr />
        </div>
    </div>
    <!-- End of plans -->
    <!-- FAQs -->
    <section class="faqs">
        <div class="container">
            <div class="section-title">
                <h1>frequently asked questions</h1>
            </div>

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Accordion Item #1
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is
                            shown by default, until the collapse plugin adds the appropriate
                            classes that we use to style each element. These classes control
                            the overall appearance, as well as the showing and hiding via
                            CSS transitions. You can modify any of this with custom CSS or
                            overriding our default variables. It's also worth noting that
                            just about any HTML can go within the
                            <code>.accordion-body</code>, though the transition does limit
                            overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Accordion Item #2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is
                            hidden by default, until the collapse plugin adds the
                            appropriate classes that we use to style each element. These
                            classes control the overall appearance, as well as the showing
                            and hiding via CSS transitions. You can modify any of this with
                            custom CSS or overriding our default variables. It's also worth
                            noting that just about any HTML can go within the
                            <code>.accordion-body</code>, though the transition does limit
                            overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Accordion Item #3
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is
                            hidden by default, until the collapse plugin adds the
                            appropriate classes that we use to style each element. These
                            classes control the overall appearance, as well as the showing
                            and hiding via CSS transitions. You can modify any of this with
                            custom CSS or overriding our default variables. It's also worth
                            noting that just about any HTML can go within the
                            <code>.accordion-body</code>, though the transition does limit
                            overflow.
                        </div>
                    </div>
                </div>
            </div>
            <hr />
        </div>
    </section>
    <!-- End of FAQs -->
@endsection
