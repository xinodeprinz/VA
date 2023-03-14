<div style="width:90%;margin:auto;overflow:hidden">
    <h4>{{ __('main.Hello') }} <span style="font-weight:bold;text-transform:capitalize">{{ $user->username }}</span></h4>

    {!! $data['message'] !!}

    <div style="margin-top:0.5rem">
        <span><em>{{ __('main.Regards') }},</em></span>
        <div style="font-weight:bold"><em>{{ config('app.name') }}</em></div>
    </div>
</div>
