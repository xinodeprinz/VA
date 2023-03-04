@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'about us'])

    <section class="about my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h1>about us</h1>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum facere suscipit nisi modi blanditiis
                        doloremque at error! Amet, quae magni nulla culpa totam deleniti? Consequatur possimus recusandae
                        eos deserunt illo?
                    </p>
                    <p>
                        magni nulla culpa totam deleniti? Consequatur possimus recusandae eos deserunt illo?
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/tgeLvvZYDcU" title="YouTube video"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
