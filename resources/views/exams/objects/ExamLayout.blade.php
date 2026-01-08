<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \App\myappenv::CenterName }}</title>
    @if (\App\myappenv::Captcha == 'google')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onSubmit(token) {
                document.getElementById("login-form").submit();
            }
        </script>
    @endif
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    @if (\App\myappenv::SiteTheme == 'kookbaz')
        <link id="gull-theme" rel="stylesheet" href="{{ asset('assets/styles/css/themes/kookbaz.min.css') }}">
    @else
        <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
    @endif
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
    <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<style>
    .question {
        text-align: right;
    }
</style>

<body>
    @yield('Content')



</body>
<script src="/assets/js/common-bundle-script.js"></script>
@yield('page-js')
<script src="/assets/js/script.js"></script>
<script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>
<script src="{{ asset('assets/js/customizer.script.js') }}"></script>
<script src="{{ asset('assets/js/num2persian.js') }}"></script>
<script src="{{ url('/') }}/assets/js/select2.min.js"></script>
<script src="{{ url('/') }}/assets/js/jquery-confirm.js"></script>
<script src="{{ url('/') }}/assets/js/jquery-confirm.js"></script>

@yield('scripts')

</html>
