<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php

$route = Route::currentRouteName() ?? __('main.Not Found');

$desc = __('main.site-desc');

if ($route === 'index') {
    $route = 'Home';
} elseif ($route === 'home') {
    $route = 'Dashboard';
}

$route = ucfirst($route);

?>

<title>{{ config('app.name') }} | {{ $route }}</title>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="canonical" href="{{ url()->current() }}" />

<meta name="description" content="{{ $desc }}">
{{-- <meta name="keywords" content="{{ config('app.name') }}, Money Adds, Ads, Money, Investment"> --}}
<meta name="author" content="{{ config('app.name') }}">

<meta property="og:title" content="{{ config('app.name') }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:url" content="{{ config('app.url') }}" />
<meta property="og:type" content="website" />
<meta property="og:description" content="{{ $desc }}" />
<meta property="og:image" content="{{ config('app.url') }}/storage/images/logo.jpg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />

{{-- Twitter meta tags --}}
<meta name=”twitter:card” content=”summary” />
<meta property="twitter:title" content="{{ config('app.name') }}" />
<meta property="twitter:description" content="{{ $desc }}" />
<meta property="twitter:url" content="{{ config('app.url') }}" />
<meta property="twitter:image" content="{{ config('app.url') }}/storage/images/logo.jpg" />

<link rel="stylesheet" href="/css/bootstrap.css" />
<link rel="stylesheet" href="/css/style.css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- PWA  -->
<meta name="theme-color" content="#356735" />
<link rel="apple-touch-icon" href="/storage/images/favicons/ms-icon-310x310.png">
<link rel="manifest" href="/manifest.json">
