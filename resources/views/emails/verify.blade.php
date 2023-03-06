<div style="width:90%;margin:auto;overflow:hidden">
    <h4>{{ __('main.Hello') }} <span style="font-weight:bold;text-transform:capitalize">{{ $user->username }}</span></h4>
    {{ __('main.To finalize your account creation, use the code below as your registration code.') }}
    <div style="margin-top:1.5rem;margin-bottom:0.5rem;font-size:25px;font-weight:bold">
        {{ $code }}
    </div>

    <div>{{ __('main.Code expires in :minutes minutes.', ['minutes' => env('SESSION_LIFETIME')]) }}</div>

    <div style="margin-top:0.5rem">
        <span><em>{{ __('main.Regards') }},</em></span>
        <div style="font-weight:bold"><em>{{ config('app.name') }}</em></div>
    </div>
</div>
