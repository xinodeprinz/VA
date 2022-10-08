@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'terms and conditions'])

    <main id="main">

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <h2 class="text-center text-money">Welcome</h2>

                <p>
                    Please carefully read the following Terms and Conditions before using this Site. By using this
                    Site, you agree to follow and be bound by these Terms and conditions, which govern your use of the Site.
                    {{ config('app.name') }} may periodically modify these Terms and Conditions, and any such modifications
                    will be
                    effective immediately upon posting. We suggest that you periodically check these Terms and Conditions
                    for modifications. If you do not agree to these Terms and Conditions, do not use this Site.
                </p>

                <h2 class="fs-4 text-capitalize text-money">Your account</h2>
                <p>
                    With respect to creation of an account with Money Adds ( to register), you will be
                    required to provide your full name, email address, password, and phone number (the “ Registration
                    Credentials ”). You must ensure that your Registration Credentials are accurate, truthful and updated.
                    We reserve the right to block the creation of your Account based on our inability to confirm the
                    authenticity of your Registration Credentials.Please note that your email address and password which you
                    provide as part of the <strong>Registration Credentials</strong> will be used to login into your
                    Account. You will be
                    solely responsible for maintaining the confidentiality of your email address and password and must
                    immediately notify us of any unauthorized use of your Account.
                </p>

                <h2 class="fs-4 text-capitalize text-money">Plan</h2>
                <p>
                    Money deposited for a plan provides you with a daily amount derived from clicks, which can be withdrawn
                    automatically if it reaches 1000 FCFA. Let’s also note that all plans are only valid for one month.
                </p>

                <h2 class="fs-4 text-capitalize text-money">Refunds & Payments:</h2>
                <p>
                    When you choose a plan, your aim is to earn more money and we work extremely hard to satisfy you hence,
                    there is no direct refund of money once it enters your account. Payments are made daily and the minimum
                    amount of money to be withdrawn is 1000 FCFA. Once your money is greater than or equal to 1000 FCFA ,
                    you can place your withdrawal and your money will be instantly sent to you. To know more about payments,
                    email us at {{ env('EMAIL') }}.
                </p>

                <h2 class="fs-4 text-capitalize text-money">What you shouldn’t do:</h2>
                <p>
                <ul class="terms-points">
                    <li><i class="ri-check-double-line"></i> create and/or use multiple Accounts (i.e. only one Account is
                        permitted per person);

                    </li>
                    <li><i class="ri-check-double-line"></i> communicate with our customer support representatives in a
                        disrespectful, belligerent or inappropriate manner;
                    </li>
                </ul>
                </p>

                <h2 class="fs-4 text-capitalize text-money">Contact Us:</h2>
                <p>
                    If you have any questions or concerns regarding these Terms or your use of MoneyAdds please contact us
                    by using the “Contact Us”.
                </p>

            </div>
        </section>
        <!-- End About Us Section -->
    </main>
    <!-- End #main -->
@endsection
