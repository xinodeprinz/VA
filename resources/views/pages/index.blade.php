@extends('layouts.web')


@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    <h1>Earn extra money by working online</h1>
                    <h2>Allow us to help you achieve the future you want for yourself and your family.</h2>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="{{ route('register') }}" class="btn-get-started scrollto">Get Started</a>
                        <a href="{{ route('plans') }}" class="ms-3 btn-get-started scrollto ouline-white">Our Plans</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="/web/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section>
    <!-- End Hero -->

    <main id="main">

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>About Us</h2>
                </div>

                <div class="row content">
                    <div class="col-lg-6">
                        <p>
                            {{ config('app.name') }} is a global online community with numerous earning options. Begin
                            earning money right
                            away by clicking on ads.

                        <div class="pt-1">
                            These are simple ways to reach your financial goals:
                        </div>
                        </p>
                        <ul>
                            <li><i class="ri-check-double-line"></i> Earn cash daily by clicking on ads. You make a minimum
                                of 450 FCFA daily by just clicking on ads. withdrawal is automatic.
                            </li>
                            <li><i class="ri-check-double-line"></i> Increase your earnings by sharing your MoneyAdds link
                                with your friends. You can earn up to 10% of the earnings of your referrals!
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0">
                        <p>
                            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                            occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                            id est laborum.
                        </p>
                        <p>For more info, contact us at</p>
                        <div class="d-flex align-items-end">
                            <div class="me-4">
                                <a href="mailTo: {{ env('EMAIL') }}"
                                    class="d-inline-block bg-money text-white p-2 small-round">
                                    {{ env('EMAIL') }}
                                </a>
                            </div>
                            <a href="{{ route('about') }}" class="btn-learn-more">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End About Us Section -->


        <!-- ======= Plans Section ======= -->
        <section id="pricing" class="pricing">
            <div class="container" data-aos="fade-up">

                <div class="section-title" style="margin-bottom:-3rem !important">
                    <h2>Our Plans</h2>
                </div>

                <div class="row">
                    @foreach ($plans as $plan)
                        <div class="col-md-4 col-sm-6 mb-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="card shadow">
                                <div class="card-header bg-money text-white">
                                    <h3 class="text-center fs-2 pt-3 text-capitalize" style="color:white !important">
                                        {{ $plan->title }}
                                    </h3>
                                </div>
                                <div class="card-body bg-white">
                                    <h5 class="text-money fs-3 text-center">
                                        {{ session('currency') === 'USD' ? '$' : '' }}
                                        {{ number_format($plan->amount, $dp, '.', ',') }}
                                        {{ session('currency') === 'FCFA' ? session('currency') : '' }}</h5>
                                    <ul class="text-capitalize ps-0 ps-sm-4 plan">
                                        <li><i class="bx bx-check"></i> Daily Ads: <span
                                                class="text-money fw-bold">{{ $plan->daily_ads }}</span>
                                        </li>
                                        <li><i class="bx bx-check"></i> Cost per ad: <span class="text-money fw-bold">
                                                {{ session('currency') === 'USD' ? '$' : '' }}
                                                {{ number_format($plan->ad_cost, $dp, '.', ',') }}
                                                {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                            </span>
                                        </li>
                                        <li><i class="bx bx-check"></i> Daily earnings: <span class="text-money fw-bold">
                                                {{ session('currency') === 'USD' ? '$' : '' }}
                                                {{ number_format($plan->ad_cost * $plan->daily_ads, $dp, '.', ',') }}
                                                {{ session('currency') === 'FCFA' ? session('currency') : '' }}
                                            </span></li>
                                        <li><i class="bx bx-check"></i> Weekly earnings: <span class="text-money fw-bold">
                                                {{ session('currency') === 'USD' ? '$' : '' }}
                                                {{ number_format($plan->ad_cost * $plan->daily_ads * 7, $dp, '.', ',') }}
                                                {{ session('currency') === 'FCFA' ? session('currency') : '' }}</span>
                                        </li>
                                        <li><i class="bx bx-check"></i> Monthly earnings: <span class="text-money fw-bold">
                                                {{ session('currency') === 'USD' ? '$' : '' }}
                                                {{ number_format($plan->ad_cost * $plan->daily_ads * 30, $dp, '.', ',') }}
                                                {{ session('currency') === 'FCFA' ? session('currency') : '' }}</span>
                                        </li>
                                        <li><i class="bx bx-check"></i> Validity: <span
                                                class="text-money fw-bold">{{ $plan->duration }}
                                                days</span></li>
                                        <li><i class="bx bx-check"></i> Withdrawal: <span
                                                class="text-money fw-bold">Automatic</span></li>
                                    </ul>
                                    <form action="{{ route('buy-plan') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <div class="text-center">
                                            <button type="submit"
                                                class="buy-btn bg-money text-white">{{ Auth::check() && Auth::user()->plan_id ? 'Upgrade Now' : 'Buy Now' }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('plans') }}" class="buy-btn mt-3">More Plans</a>

            </div>
        </section>
        <!-- End Plans Section -->


        <!-- ======= Services Section ======= -->
        <section id="services" class="services section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Services</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi
                        quidem hic quas.</p>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bxl-dribbble"></i></div>
                            <h4><a href="">Lorem Ipsum</a></h4>
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
                        data-aos-delay="200">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-file"></i></div>
                            <h4><a href="">Sed ut perspici</a></h4>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
                        data-aos-delay="300">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                            <h4><a href="">Magni Dolores</a></h4>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
                        data-aos-delay="400">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-layer"></i></div>
                            <h4><a href="">Nemo Enim</a></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- End Services Section -->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Our Team Members</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi
                        quidem hic quas.</p>
                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="100">
                            <div class="pic"><img src="/web/img/team/team-1.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>Walter White</h4>
                                <span>Chief Executive Officer</span>
                                <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4 mt-lg-0">
                        <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="200">
                            <div class="pic"><img src="/web/img/team/team-2.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>Sarah Jhonson</h4>
                                <span>Product Manager</span>
                                <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4">
                        <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="300">
                            <div class="pic"><img src="/web/img/team/team-3.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>William Anderson</h4>
                                <span>CTO</span>
                                <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4">
                        <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="400">
                            <div class="pic"><img src="/web/img/team/team-4.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                                <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- End Team Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="why-us" class="why-us section-bg">
            <div class="container-fluid" data-aos="fade-up">

                <div class="row">

                    <div
                        class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

                        <div class="content">
                            <h3 class="text-capitalize">Frequently Asked Questions</h3>
                        </div>

                        <div class="accordion-list">
                            <ul>
                                <li>
                                    <a data-bs-toggle="collapse" class="collapse"
                                        data-bs-target="#accordion-list-1"><span>01</span> How do I get referrals for
                                        {{ config('app.name') }}? <i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                                        <p>
                                            Access your moneyadds.com account. Once logged in, your own referral link will
                                            be listed on your main screen. Send potential referrals your referral link. If a
                                            new member is brought to {{ config('app.name') }} via your referral link, your
                                            account will
                                            be credited instantly with 10% of his/her deposits.
                                        </p>
                                    </div>
                                </li>

                                <li>
                                    <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2"
                                        class="collapsed"><span>02</span>
                                        When and how will I get paid (Withdraw)? <i
                                            class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                                        <p>
                                            You will receive your payment anytime you request for it. To request for
                                            payment, click on the WITHDRAW button then choose what method of payment you
                                            want. withdrawal is very rapid and automatic.
                                        </p>
                                    </div>
                                </li>

                                <li>
                                    <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3"
                                        class="collapsed"><span>03</span>
                                        How much money can I make per day? <i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                                        <p>
                                            The amount of money you make daily depends on your plan. The bigger your plan,
                                            the more money you get. E.g If your plan is 25000 FCFA plan, you’ll be making
                                            132 FCFA per ad times 17 ads giving a total of 2244FCFA daily While a person on
                                            a 50000 FCFA plan has 449 FCFA per ad times 10 ads giving a total of 4490 FCFA
                                            daily.
                                        </p>
                                    </div>
                                </li>

                                <li>
                                    <a data-bs-toggle="collapse" data-bs-target="#accordion-list-4"
                                        class="collapsed"><span>04</span>
                                        There are several people in our house. Can each of us have our own account? <i
                                            class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
                                        <p>
                                            Yes, each person in your house may have their own account. For a person to have
                                            more than one account is against our terms of service. Please email us if you
                                            have any questions about your account.
                                        </p>
                                    </div>
                                </li>

                            </ul>
                        </div>

                    </div>

                    <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img"
                        style='background-image: url("/web/img/why-us.png");' data-aos="zoom-in" data-aos-delay="150">
                        &nbsp;</div>
                </div>

            </div>
        </section>
        <!-- End Frequently Asked Questions Section -->


        <section id="testimonials">
            <div class="container">

                <div class="section-title">
                    <h2>What People say about us</h2>
                </div>

                <div id="testimonial-slider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div data-aos="fade-up" class="carousel-item active">


                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div data-aos="fade-up" class="carousel-item">


                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div data-aos="fade-up" class="carousel-item">


                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="shadow bg-white p-4 rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="/web/img/testimonials/testimonials-1.jpg" alt="testimonials"
                                                class="img-round">
                                            <div class="ms-3">
                                                <h4 class="text-money text-capitalize">John Martins</h4>
                                                <small class="text-muted">CEO & Founder</small>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ad in
                                            architecto odit, aliquam dicta ducimus illum ipsa reprehenderit doloribus?
                                            Veniam ad nam repellendus voluptas?
                                        </p>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>



            </div>
        </section>

    </main>
    <!-- End #main -->
@endsection
