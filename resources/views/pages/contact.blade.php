@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Contact us'])

    <div class="contact mt-4">
        <div class="container">
            <div class="section-title text-center">
                <h1>stay connected</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="shadow contact-box p-3 d-flex align-items-center">
                        <div class="icon"><i class="fas fa-envelope"></i></div>
                        <div class="ms-2">
                            <h4>email us</h4>
                            <a href="mailto:{{ env('EMAIL') }}">{{ env('EMAIL') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="shadow contact-box p-3 d-flex align-items-center">
                        <div class="icon"><i class="fab fa-telegram"></i></div>
                        <div class="ms-2">
                            <h4>telegram channel</h4>
                            <a href="{{ env('TELEGRAM') }}" target="_blank">Join Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="shadow contact-box p-3 d-flex align-items-center">
                        <div class="icon"><i class="fas fa-business-time"></i></div>
                        <div class="ms-2">
                            <h4>business hours</h4>
                            <div class="text">Everyday (24/7)</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <div class="form">
                <form action="{{ route('contact') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" value="{{ old('name') }}" placeholder="Name" name="name"
                                class="form-control @error('name')
                                    is-invalid
                                @enderror" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" placeholder="Email" value="{{ old('email') }}" name="email"
                                class="form-control @error('email')
                                is-invalid
                            @enderror" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" placeholder="Subject" value="{{ old('subject') }}" name="subject"
                                class="form-control @error('subject')
                                is-invalid
                            @enderror" />
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea name="message" cols="30" rows="10" placeholder="Message"
                                class="form-control @error('message')
                            is-invalid
                        @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <button class="btn btn-main" type="submit">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
