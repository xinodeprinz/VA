@extends('layouts.account')

@section('content')
    <div class="section-title">
        <h1>referrals</h1>
    </div>
    <p class="mb-3 mt-2">
        Refer people and get {{ env('REFERRAL_BONUS_PERCENTAGE') }}% of every deposit they do.
    </p>

    <p class="mb-0 mt-2 bg-main text-sec p-2 d-flex justify-content-between">
        <span id="copy">{{ config('app.url') }}/register/{{ $user->username }}</span>
        <span style="cursor: pointer" onclick="copy()">
            <i class="far fa-copy"></i>
        </span>
    </p>

    <table class="table table-bordered mt-4" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($user->referrals as $id => $r)
                <tr>
                    <td>{{ ++$id }}</td>
                    <td class="text-capitalize">{{ $r->username }}</td>
                    <td>{{ $r->email }}</td>
                    <td>+237{{ $r->phone_number }}</td>
                    <td>{{ Carbon\Carbon::parse($r->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
