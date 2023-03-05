@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.our plans')])

    <div class="plans my-4">
        <div class="container">
            <div class="row">
                @foreach ($plans as $plan)
                    @include('components.plan', ['plan' => $plan])
                @endforeach
            </div>
            {{ $plans->links() }}
        </div>
    </div>
@endsection
