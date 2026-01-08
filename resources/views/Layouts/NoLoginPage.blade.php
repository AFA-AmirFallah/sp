<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{\App\myappenv::CenterName}}</title>
    <meta name="keywords"
          content="{{\App\myappenv::CenterName}}">
    <meta name="author" content="Shafatel">
    <link rel="icon" href="{{url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('/') . \App\myappenv::FavIcon}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    @yield('before-css')
    <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/shafatel.min.css')}}">
    <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{url('/')}}/persian-datepicker/Mh1PersianDatePicker.css"/>
    <link href="{{url('/')}}/assets/css/select2.min.css" rel="stylesheet" />
    <link href="{{url('/')}}/assets/css/bootstrap-clockpicker.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{url('/')}}/assets/css/jquery-confirm.css">
    @yield('page-css')
</head>
<body class="text-left">
@php
    $layout = session('layout');
@endphp
<div class='loadscreen' id="preloader">
    <div class="loader spinner-bubble spinner-bubble-primary">
    </div>
</div>
@if ($layout=="compact")
@elseif($layout=="horizontal")

    <div class="app-admin-wrap layout-horizontal-bar clearfix">

        <div class="main-content-wrap  d-flex flex-column">
            <div class="main-content">
                @yield('MainCountent')
            </div>
            @include('Layouts.footer')
        </div>
    </div>
    @include('layouts.horizontal-customizer')
@elseif($layout=="normal")
    @include('layouts.large-sidebar-customizer')
@else

    <div class="app-admin-wrap layout-sidebar-large clearfix">
        <div class="main-header">


            <div class="d-flex align-items-center">

            </div>

            <div style="margin: auto"><h3 id="fadeshow1">{{\App\myappenv::CenterName}}</h3></div>

            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
                <!-- Grid menu Dropdown -->

            <!-- Notificaiton -->
                <!-- Notificaiton End -->

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">

                        <img src="{{\App\myappenv::MainIcon}}" data-toggle="dropdown" aria-haspopup="true"
                             aria-expanded="false">

                    </div>
                </div>
            </div>

        </div>

        <div class="main-content-wrap">
            <div class="main-content">
                @include("Layouts.ErrorHandler")
                @yield('MainCountent')
            </div>
            @include('Layouts.footer')
        </div>
    </div>
@endif
<script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
@yield('page-js')
<script src="{{asset('assets/js/script.js')}}"></script>
@if ($layout=='compact')
    <script src="{{asset('assets/js/sidebar.compact.script.js')}}"></script>
@elseif($layout=='normal')
    <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>
@elseif($layout=='horizontal')
    <script src="{{asset('assets/js/sidebar-horizontal.script.js')}}"></script>
@else
    <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>
@endif
<script src="{{asset('assets/js/customizer.script.js')}}"></script>
<script src="{{asset('assets/js/num2persian.js')}}"></script>
<script src="{{url('/')}}/assets/js/select2.min.js"></script>
<script src="{{url('/')}}/assets/js/jquery-confirm.js"></script>
<script src="{{url('/')}}/assets/js/jquery-confirm.js"></script>
<script>
    $("#dropdownMenuButton").css("background-color","red");
    setInterval(function () {
        $("#dropdownMenuButton").css("background-color", function () {
            this.switch = !this.switch
            return this.switch ? "red" : ""
        });
    }, 1000);
</script>
@yield('bottom-js')
</body>
</html>
