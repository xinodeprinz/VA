@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => $data->title])

    <main id="main">

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Payment methods accepted</h2>
                </div>

                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <div class="d-flex justify-content-around align-items-end mb-5">
                            <div>
                                <div class="text-center">
                                    <img src="/web/img/mtn.png" alt="MTN" class="img-round">
                                    <div>MTN Momo</div>
                                </div>
                            </div>
                            <div>
                                <div class="text-center">
                                    <img src="/web/img/orange.png" alt="Orange" class="img-round">
                                    <div>Orange Money</div>
                                </div>
                            </div>
                            <div>
                                <div class="text-center">
                                    <img src="/web/img/paypal.png" alt="Paypal" class="img-round">
                                    <div>PayPal</div>
                                </div>
                            </div>
                        </div>

                        <!-- Select a payment method -->
                        <div class="mb-3">
                            <h4 class="text-center text-money">Choose payment method</h4>
                            <div class="row">
                                <div class="col-6 offset-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="method" id="mobile_money"
                                            {{ $data->isMomo ? 'checked' : '' }} onclick="momo('{{ $data->type }}')">
                                        <label class="form-check-label" for="mobile_money">
                                            Mobile Money
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="method" id="paypal"
                                            {{ !$data->isMomo ? 'checked' : '' }} onclick="paypal('{{ $data->type }}')">
                                        <label class="form-check-label" for="paypal">
                                            PayPal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">

                    <div class="col-md-6 offset-md-3 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <form action="{{ route($data->isMomo ? "momo-{$data->type}" : "paypal-{$data->type}") }}"
                            method="post" role="form" class="php-email-form">
                            @csrf
                            @if ($data->type === 'plan')
                                <div class="form-group">
                                    <div class="fs-4">Amount: <span class="text-money">
                                            {{ !$data->isMomo ? '$' : '' }} {{ number_format($data->amount, 2, '.', ',') }}
                                            {{ $data->isMomo ? 'FCFA' : '' }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if (!$data->isMomo && $data->type === 'withdrawal')
                                <div class="form-group">
                                    <label for="email">Paypal Email</label>
                                    <input type="text"
                                        class="form-control @error('email')
                                is-invalid
                            @enderror"
                                        value="{{ old('email') }}" name="email" id="email"
                                        placeholder="example@gmail.com">

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            @if ($data->type !== 'plan')
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <div class="input-group">
                                        @if (!$data->isMomo)
                                            <span class="input-group-text">$</span>
                                        @endif
                                        <input type="text"
                                            class="form-control @error('amount')
                                            is-invalid
                                        @enderror"
                                            value="{{ old('amount') }}" name="amount" id="amount">
                                        @if ($data->isMomo)
                                            <span class="input-group-text">FCFA</span>
                                        @endif
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            @if ($data->isMomo)
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            +{{ $data->type === 'withdrawal' ? $data->code : '237' }}
                                        </span>
                                        <input type="number"
                                            class="form-control @error('phone_number')
                                            is-invalid
                                        @enderror"
                                            value="{{ $data->phone_number ?? old('phone_number') }}" name="phone_number"
                                            id="phone_number" {{ $data->type === 'withdrawal' ? 'readonly' : '' }}>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <button type="submit">{{ $data->btnText }}</button>
                        </form>
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
