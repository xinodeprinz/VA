@if (session('error'))
    @include('components.sweetalert', ['icon' => 'error', 'message' => session('error')])
@endif
@if (session('success'))
    @include('components.sweetalert', ['icon' => 'success', 'message' => session('success')])
@endif
@if (session('info'))
    @include('components.sweetalert', ['icon' => 'info', 'message' => session('info')])
@endif
