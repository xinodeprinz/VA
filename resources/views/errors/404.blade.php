@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'Not Found'])

    <main id="main">

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="text-money text-center fw-bold">
                    <div class="fs-2">404</div>
                    <div class="fs-4">Opps!! The page you're looking for does not exists.</div>
                </div>

            </div>
        </section>
        <!-- End About Us Section -->
    </main>
    <!-- End #main -->
@endsection
