<div style="width:90%;margin:auto;overflow:hidden">
    <h4>Hello <span style="font-weight:bold;text-transform:capitalize">{{ $data['username'] }}</span></h4>
    <br>
    To continue your withdrawal, click on the button below
    <div style="margin-top:1.5rem">
        <a href="{{ config('app.url') }}/mobile-money/withdrawal/{{ $data['token'] }}">
            {{ config('app.url') }}/mobile-money/withdrawal/{{ $data['token'] }}
        </a>
    </div>
</div>
