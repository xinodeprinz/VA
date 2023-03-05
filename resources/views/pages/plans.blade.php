@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => 'our plans'])

    <div class="plans my-4">
        <div class="container">
            <div class="row">
                @foreach ($plans as $plan)
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <div class="card">
                            <div class="card-header py-4">
                                <div class="title">{{ __('main.' . $plan->title) }}</div>
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
                                <div><span>widthdrawal charge:</span> {{ env('WITHDRAWAL_CHARGES_PERCENTAGE') }}%</div>
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
            {{ $plans->links() }}
        </div>
    </div>
@endsection
