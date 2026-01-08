<!DOCTYPE html>
<html class="no-js" lang="fa">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="laralink" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page Title -->
    @hasSection('MainTitle')
        <title>@yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif

    <!-- Favicon Icon -->
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}" />
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/Theme4/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Theme4/assets/css/owlCarousel.min.css" />
    <link rel="stylesheet" href="/Theme4/assets/css/fontawesome.min.css" />
    <link rel="stylesheet" href="/Theme4/assets/css/flaticon.css" />
    <link rel="stylesheet" href="/Theme4/assets/css/animate.css" />
    <link rel="stylesheet" href="/Theme4/assets/css/style.css" />
    {!! \App\myappenv::googlealaliticscr !!}
    {!! \App\myappenv::Yektanet !!}
</head>

<body class="st-blue-color rtl">
    <style>
        .curencylink {
            border: none;
            background: none;
            display: flex;
            margin: 5px;
        }

        .sticky-content.fixed55 {
            position: fixed;
            right: 0;
            left: 0;
            opacity: 1;
            transform: translateY(0);
            z-index: 1051;
            box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="page-wrapper">
        <!-- Start of Header -->
        <header class="header">
            @if (Auth::check() && Auth::user()->Role != app\myappenv::role_customer)
                <div style="background: black;color:white" class="header-top">
                    <div class="container" style="display: flex;">
                        <a class="nav-link" href="{{ route('changeview', ['Target' => 'Dashboard']) }}">داشبورد
                            کاربری <span class="sr-only">(current)</span></a>
                        <a class="nav-link" href="{{ route('OpenOrders') }}">سفارشات</a>
                        <a class="nav-link" href="{{ route('ProductLsit') }}">محصولات من</a>

                    </div>
                </div>
            @endif
            @php

                if (Route::has('home')) {
                    $Route = true;
                } else {
                    $Route = false;
                }
            @endphp

    </div>
    <div class="st-content">
        @yield('content')
        <!-- Start Hero Slider -->

    </div>

    <!-- Start Footer Seciton -->
    <footer class="st-site-footer st-style1 st-sticky-footer">
        <div class="st-main-footer text-center">
            <div class="container">
                @if (\App\myappenv::version >= 3)
                    <div style="
                background-color: blue;
                border-radius: 28px;
                padding-top: 3px;
                padding-bottom: 3px;
            "
                        class="st-footer-logo">
                        <img src="{{ \App\myappenv::Sitelogo }}" alt="demo">
                    </div>
                @else
                    <div class="st-footer-logo">
                        <img src="{{ \App\myappenv::Sitelogo }}" alt="demo">
                        <img width="200px" src="https://novin.hospital/storage/photos/Logo/logo-tak-copy.jpg" alt="انجمن ملی هوم کر">
                    </div>
                    <div style="
                    margin-top: -145px;
                    border-radius: 16px;
                    margin-right: 10px;
                    background: aliceblue;
                    position: absolute;
                    z-index: 99999;
                "
                        class="namad">{!! \App\myappenv::Namad !!}</div>
                @endif
                
                <div class="st-footer-text">{!! \App\myappenv::CenterFootertext !!}</div>
                <div class="st-footer-social">
                    <ul class="st-footer-social-btn st-flex st-mp0">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="st-copyright text-center">
            <div class="st-copyright-text">قدرت گرفته از پلتفرم کسب و کار <a href="https://dgkar.com">دیجی‌کار</a>
            </div>
        </div>
    </footer>
    <!-- End Footer Seciton -->
    <!-- Start Video Popup -->
    <div class="st-video-popup">
        <div class="st-video-popup-overlay"></div>
        <div class="st-video-popup-content">
            <div class="st-video-popup-layer"></div>
            <div class="st-video-popup-container">
                <div style="left: 0px !important;" class="st-video-popup-align">
                    <div class="embed-responsive embed-responsive-16by9">

                        <iframe class="embed-responsive-item" src="" allow="autoplay" allowFullScreen="true"
                            webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                    </div>
                </div>
                <div class="st-video-popup-close"></div>
            </div>
        </div>
    </div>
    <!-- End Video Popup -->
    <!-- Scripts -->
    <script src="/Theme4/assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="/Theme4/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="/Theme4/assets/js/mailchimp.min.js"></script>
    <script src="/Theme4/assets/js/owlCarousel.min.js"></script>
    <script src="/Theme4/assets/js/tamjid-counter.min.js"></script>
    <script src="/Theme4/assets/js/wow.min.js"></script>
    <script src="/Theme4/assets/js/isotope.pkg.min.js"></script>
    <script src="/Theme4/assets/js/main.js"></script>
    @php
        $goftino_main = App\Functions\CacheData::GetSetting('goftino_id');
    @endphp
    <script type="text/javascript">
        ! function() {
            var i = "<?php echo $goftino_main; ?>",
                a = window,
                d = document;

            function g() {
                var g = d.createElement("script"),
                    s = "https://www.goftino.com/widget/" + i,
                    l = localStorage.getItem("goftino_" + i);
                g.async = !0, g.src = l ? s + "?o=" + l : s;
                d.getElementsByTagName("head")[0].appendChild(g);
            }
            "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !
                1);
        }();
    </script>
</body>

</html>
