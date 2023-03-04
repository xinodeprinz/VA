@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Withdrawal'])

    <main id="main">

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>Complete Withdrawal</h2>
                </div>

                <div class="row">

                    <div class="col-md-6 offset-md-3 mt-5 mt-lg-0">

                        <div class="php-email-form">
                            <div class="form-group mb-3">
                                <div class="fs-4">Amount: <span class="text-money">
                                        {{ number_format($withdrawal['amount'], 0) }} FCFA
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="fs-4">Tel: <span class="text-money">
                                        (+237) {{ $withdrawal['phone_number'] }}
                                    </span>
                                </div>
                            </div>

                            <form action="{{ route('complete-momo-withdrawal', ['token' => $withdrawal['token']]) }}"
                                method="post" role="form">
                                @csrf

                                <button type="submit" class="mt-3">Complete Now</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 offset-md-3 mt-3">
                        <div class="text-end">
                            <button onclick="window.history.back()" class="btn btn-link">Go Back</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Contact Section -->

    </main>
    <!-- End #main -->
@endsection
