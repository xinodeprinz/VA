@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'about us'])

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
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.
                        </p>
                        <ul>
                            <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat
                            </li>
                            <li><i class="ri-check-double-line"></i> Duis aute irure dolor in reprehenderit in voluptate
                                velit</li>
                            <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0">
                        <p>
                            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
                            in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                            id est laborum.
                        </p>
                        <p>For more info, contact us at</p>
                        <div class="d-flex align-items-end">
                            <div class="me-4">
                                <a href="mailTo: info@moneyadds.com"
                                    class="d-inline-block bg-money text-white p-2 small-round">
                                    info@moneyadds.com
                                </a>
                            </div>
                            <a href="#" class="btn-learn-more">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End About Us Section -->
    </main>
    <!-- End #main -->
@endsection
