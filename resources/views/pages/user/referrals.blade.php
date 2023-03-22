@extends('layouts.account')

@section('content')
    <div class="section-title">
        <h1>{{ __('main.referrals') }}</h1>
    </div>
    <p class="mb-3 mt-2">
        {{ __('main.ref-notice', ['percent' => env('REFERRAL_BONUS_PERCENTAGE') . '%']) }}
    </p>

    <p class="mb-0 mt-2 bg-main text-sec p-2 d-flex justify-content-between">
        <span id="copy">{{ config('app.url') }}/register/{{ str_replace(' ', '-', $user->username) }}</span>
        <span style="cursor: pointer" onclick="copy()">
            <i class="far fa-copy"></i>
        </span>
    </p>

    <div class="table-responsive">
        <table class="table table-bordered mt-4" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('main.Username') }}</th>
                    <th>{{ __('main.Email') }}</th>
                    <th>{{ __('main.Phone') }}</th>
                    <th>{{ __('main.date') }}</th>
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
    </div>
@endsection
