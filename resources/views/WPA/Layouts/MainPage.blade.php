<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#2196f3">
    <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{\App\myappenv::CenterName}}</title>
    <link rel="stylesheet" href="{{url('/') . '/WPA/'}}css/framework7.bundle.min.css">
    <link rel="stylesheet" href="{{url('/') . '/WPA/'}}css/app.css">
    <link rel="stylesheet" href="{{url('/') . '/WPA/'}}css/style.css">
    <link rel="apple-touch-icon" href="{{url('/') . \App\myappenv::FavIcon }}">
    <link rel="icon" href="{{url('/') . \App\myappenv::FavIcon }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @vite(['resources/js/app.js'])
</head>
<body >
   
<div id="app">
    <div class="view  view-main view-init safe-areas" data-master-detail-breakpoint="800" data-url="/">
        <div class="row no-gutters vh-100 loader-screen">
            <div class="col align-self-center text-white text-align-center">
                <div class="logo-icon">
                    <img src="{{ App\myappenv::Sitelogo }}" alt="" width="200%" />
                </div>
                <div class="laoderhorizontal">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        @include("WPA.Layouts.ErrorHandler")
        @yield('MainCountent')
    </div>
</div>
@yield('page-js')
<script src="{{url('/') . '/WPA/'}}js/framework7.bundle.min.js"></script>
<script src="{{url('/') . '/WPA/'}}js/framework7.debug.js"></script>
<script src="{{url('/') . '/WPA/'}}js/app.js"></script>
<script src="{{url('/') . '/WPA/'}}js/routes.js"></script>

@yield('bottom-js')
</body>
</html>
