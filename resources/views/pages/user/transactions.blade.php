@extends('layouts.account')

@section('content')
    <div class="section-title">
        <h1>transaction history</h1>
    </div>
    @if ($user->transactions->count() > 0)
        <table class="table table-striped table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>amount</th>
                    <th>type</th>
                    <th>date</th>
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
    @else
        <div class="text-center alert alert-success">
            <i class="fas fa-info-circle"></i>
            You have done no transactions at the moment.
        </div>
    @endif
@endsection
