<div style="width:90%;margin:auto;overflow:hidden">
    <h4>Hello <span style="font-weight:bold;text-transform:capitalize">{{ $user->username }}</span></h4>
    To finalize your withdrawal of <strong>{{ number_format($amount, 0) }} FCFA</strong>,
    to the phone number <strong>(+237) {{ $user->phone_number }}</strong>,
    use the code below as your withdrawal code.
    <div style="margin-top:1.5rem;margin-bottom:0.5rem;font-size:25px;font-weight:bold">
        {{ $code }}
    </div>

    <div>Code expires in {{ env('SESSION_LIFETIME') }} minutes.</div>

    <div style="margin-top:0.5rem">
        <span><em>Regards,</em></span>
        <div style="font-weight:bold"><em>{{ config('app.name') }}</em></div>
    </div>
</div>
