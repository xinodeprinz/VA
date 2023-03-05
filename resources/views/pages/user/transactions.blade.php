@extends('layouts.account')

@section('content')
    <div class="section-title">
        <h1>{{ __('main.transaction history') }}</h1>
    </div>
    @if ($user->transactions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('main.Amount') }}</th>
                        <th>{{ __('main.type') }}</th>
                        <th>{{ __('main.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->transactions as $id => $item)
                        <tr>
                            <td>{{ ++$id }}</td>
                            <td>{{ number_format($item->amount, 0) }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->created_at->format('M d, Y H:i a') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center alert alert-success">
            <i class="fas fa-info-circle"></i>
            {{ __('main.You have done no transactions at the moment.') }}
        </div>
    @endif
@endsection
