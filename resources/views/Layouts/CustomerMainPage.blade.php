<!DOCTYPE html>
<style>
    body {
        padding-right: 0 !important
    }
</style>


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    @if (\App\myappenv::SiteAddress == 'https://shafatel.com')
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-5PLZN37');
        </script>
        <!-- End Google Tag Manager -->
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('MainTitle')
        <title>{{ \App\myappenv::CenterName }} - @yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif
    <meta name="description" content="{{ \App\myappenv::description }}">
    @hasSection('OG')
        @yield('OG')
    @endif
    @hasSection('ExtraTags')
        @yield('ExtraTags')
    @endif


    <meta name="keywords" content="{{ \App\myappenv::CenterName }}">
    <meta name="author" content="Shafatel">
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ url('/') . \App\myappenv::FavIcon }}">
    <link rel="shortcut icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
    @yield('before-css')

    @if (\App\myappenv::MainOwner == 'sepehrmall')
        <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/Customersepehrmall.min.css') }}">
        <link rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
        <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
        <link rel="stylesheet" href="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/select2.min.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/CustomWPA.css') }}">
    @elseif (\App\myappenv::SiteTheme == 'kookbaz')
        <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/Customerkookbaz.min.css') }}">
        <link rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
        <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
        <link rel="stylesheet" href="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/select2.min.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/CustomWPA_kookbaz.css') }}">
        <link rel="stylesheet" href="{{ url('/') }}/assets/OWL/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/OWL/assets/owl.theme.default.min.css">
    @else
        <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/Customershafatel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app_shafatel.css') }}">
    @endif

    {!! \App\myappenv::googlealaliticscr !!}
    @yield('page-css')
</head>

<body class="newbody text-left">
    @if (Auth::check() && Auth::user()->Role != app\myappenv::role_customer)
        <nav class="navbar navbar-expand-lg navbar-light bg-light admin-navbar ">
            <a class="navbar-brand" href="#">مدیر فروشگاه</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarNav" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('changeview', ['Target' => 'Dashboard']) }}">داشبورد
                            کاربری <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('OpenOrders') }}">سفارشات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ProductLsit') }}">محصولات من</a>
                    </li>
                </ul>
            </div>
        </nav>
    @endif
    @if (\App\myappenv::SiteAddress == 'https://shafatel.com')
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5PLZN37" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
    @if (\App\myappenv::SiteAddress == 'https://pwa.sepehrmall.com')
        <style>
            @media (min-width: 440px) {
                .TopBenefit {
                    position: fixed;
                    float: left;
                    top: 0px;
                    left: 0px;
                    z-index: 900;
                    background-color: #339a99;
                    color: white;
                    padding: 8px;
                    border-radius: 0px 0px 7px 7px;
                    text-align: center;
                    width: 100px;
                    right: calc(((96vw - var(--shafate-max-width)) / 2) + var(--shafate-max-width) - 107px);
                }
            }

            @media (max-width: 440px) {
                .TopBenefit {
                    position: absolute;
                    float: left;
                    top: 0px;
                    z-index: 900;
                    background-color: #339a99;
                    color: white;
                    padding: 8px;
                    border-radius: 0px 0px 7px 7px;
                    text-align: center;
                    width: 100px;
                    left: 3px;
                }
            }



            .TopBannerContent {}

            p.TopBannerContent {}

            small.TopBannerContent {
                background-color: var(--sm_green);
                padding: 1px 4px 1px 4px;
                color: white;
                border-radius: 5px;
                font-size: 11px;
                font-weight: 800;
            }
        </style>
        <div class="TopBenefit">
            <div class="TopBannerContent">
                @php
                    $GetUserBenefit = \App\Http\Controllers\woocommerce\buy::BuyBenefit();
                @endphp
                <p id="UserBenefitText" class="TopBannerContent">
                    {{ number_format($GetUserBenefit / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                <input class="nested" id="UserBenefitValue" value="{{ $GetUserBenefit }}" type="text">
                <small class="TopBannerContent">مجموع سود شما</small>
            </div>
        </div>
    @elseif(\App\myappenv::MainOwner == 'kookbaz')
    @else
        <div class="top-heder-pic" id='topbannerpic'>
            <img class="top-heder-pic" src="{{ asset(\App\myappenv::pwa_heder) }}" alt="pwa_heder">
        </div>
        <div class="top-heder-pic nested" id="overtopbannerpic">
            <img class="top-heder-pic" src="{{ asset(\App\myappenv::pwa_Line) }}" alt="pwa_Line">
        </div>
    @endif
    <div class='loadscreen' id="preloader">
        @if (\App\myappenv::MainOwner == 'shafatel')
            <div class="loader spinner-bubble spinner-bubble-primary">

            </div>
            <div style="position: absolute;top:calc(50vh - 59px);left: 0;right: 0;margin: auto;max-width:37px">
                <img style="margin-top:-5px;" src="{{ url('/') . \App\myappenv::Sitelogo }}" alt="sitelogo">
            </div>
        @else
            <div class="loader  loader-bubble loader-bubble-primary ">

            </div>
            <div style="position: absolute;top: 50vh;left: 0;right: 0;margin: auto;max-width:60px">
                <img style="margin-top:-5px;" src="{{ url('/') . \App\myappenv::Sitelogo }}" alt="sitelogo">
            </div>
        @endif


    </div>
    <div class="ul-card-list__modal">
        <div class="modal MenuModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
        <div class="card">
            <div class="modal-header">
                <h5 class="modal-title" id="device_model_title">منو</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="
            display: grid">
                    <a class="menu-item" href="{{ url('/') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/> <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/> </svg>
                        خانه</a>
                    <a class="menu-item" href="{{ url('https://kookbaz.ir/RegisterForm/11') }}"><svg style='height: 16px; width: 16px; color:#0000FF' role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Home Assistant Community Store</title><path d="M1.63.47a.393.393 0 0 0-.39.39v2.417c0 .212.177.39.39.39h20.74c.213 0 .39-.178.39-.39V.859a.393.393 0 0 0-.39-.39zm-.045 4.126a.41.41 0 0 0-.407.337l-1.17 6.314C0 11.274 0 11.3 0 11.327v2.117c0 .23.186.416.416.416h23.168c.23 0 .416-.186.416-.416v-2.126c0-.027 0-.053-.009-.08l-1.169-6.305a.41.41 0 0 0-.407-.337zM1.7 14.781a.457.457 0 0 0-.46.46v7.829c0 .257.203.46.46.46h14.108c.257 0 .46-.203.46-.46v-6.589c0-.257.204-.46.461-.46h4.02c.258 0 .461.203.461.46v6.589c0 .257.204.46.46.46h.62a.456.456 0 0 0 .461-.46v-7.829a.458.458 0 0 0-.46-.46zm1.842 1.55h7.847c.212 0 .39.177.39.39V21.6c0 .212-.178.39-.39.39H3.542a.393.393 0 0 1-.39-.39v-4.88c0-.221.178-.39.39-.39Z"/></svg>

                        فروشنده شوید
                    </a>
                    <a class="menu-item" href="{{ url('https://kookbaz.ir/RegisterForm/12') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16"> <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/> <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/> </svg>
                        خرید اقساطی</a>
                    <a class="menu-item" href="{{ url('https://kookbaz.ir/Product/348/%D8%A7%D8%B3%D9%86%D9%88%D8%A7%D8%8C%D8%AF%D9%88%D9%88') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16"> <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/> </svg>
                        اسنوا - دوو </a>
                    <a class="menu-item" href="{{ url('https://kookbaz.ir/Product?sort=expensive') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16"> <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/> </svg>
                        همه محصولات</a>
                  
            </div>
        </div>
        </div>
    </div>
    @if (\App\myappenv::MainOwner == 'kookbaz')
        <style>
            .menu_btn_kookbaz {
                position: absolute;
                top: 10px;
                border: none;
                left: 10px;
                font-size: 22px;
            }
            @media (min-width: 768px) {
                .menu_btn_kookbaz{
                    display: none;
                }
            }
        </style>

        <button type="button" data-toggle="modal" data-target=".MenuModal"
            class="menu_btn_kookbaz btn btn-primary btn-md m-1" title="Edit">
            <svg style="height: 40px; width: 40px; color: rgb(255, 255, 255);" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" zoomAndPan="magnify" viewBox="0 0 30 30.000001" height="40" preserveAspectRatio="xMidYMid meet" version="1.0"><rect width="100%" height="100%" fill="#30bfb4"></rect><defs><clipPath id="id1"><path d="M 3.386719 7.164062 L 26.613281 7.164062 L 26.613281 22.40625 L 3.386719 22.40625 Z M 3.386719 7.164062 " clip-rule="nonzero" fill="#ffffff"></path></clipPath></defs><g clip-path="url(#id1)"><path fill="#ffffff" d="M 3.398438 22.40625 L 26.601562 22.40625 L 26.601562 19.867188 L 3.398438 19.867188 Z M 3.398438 16.054688 L 26.601562 16.054688 L 26.601562 13.515625 L 3.398438 13.515625 Z M 3.398438 7.164062 L 3.398438 9.703125 L 26.601562 9.703125 L 26.601562 7.164062 Z M 3.398438 7.164062 " fill-opacity="1" fill-rule="nonzero"></path></g></svg>

        </button>
    @endif
    <div class="app-admin-wrap layout-sidebar-large clearfix">
        @include('Layouts.CustomerNaveTop')
        <div class="main-content-wrap  d-flex flex-column">
            <div class="pwa_Mian_Content main-content">
                @include('Layouts.ErrorHandler')
                @yield('MainCountent')
                @if (\App\myappenv::call_whatsapp)
                    <div class="call_whatsapp">
                        <a class="call_whatsapp" target="_blank"
                            href="{{ \App\myappenv::call_whatsapp_address }}"><img class="call_whatsapp"
                                src="{{ asset('assets/images/Whatsapp.png') }}" alt="WatsApp"></a>
                    </div>
                    <div class="call_phone">
                        <a class="call_phone" target="_blank" href="tel:{{ \App\myappenv::CenterPhone }}"><img
                                class="call_phone" src="{{ asset('assets/images/call.png') }}" alt="phone"></a>
                    </div>
                @endif
            </div>

            @include('Layouts.customerfooter')
        </div>
    </div>
    <script src="/assets/js/common-bundle-script.js"></script>
    <script>
        function number_format(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
    @yield('page-js')
    @if (\App\myappenv::MainOwner != 'shafatel')
        <script src="/assets/js/script.js"></script>
        <script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>
        <script src="{{ asset('assets/js/customizer.script.js') }}"></script>
        <script src="{{ asset('assets/js/num2persian.js') }}"></script>
        <script src="{{ url('/') }}/assets/js/select2.min.js"></script>
        <script src="{{ url('/') }}/assets/js/jquery-confirm.js"></script>
        <script src="{{ asset('assets/js/jquery.lazy.js') }}"></script>
        <script src="{{ url('/') }}/assets/OWL/owl.carousel.min.js"></script>
    @else
        <script src="{{ asset('js/app_shafatel.js') }}"></script>
    @endif
    <script>
        $("#dropdownMenuButton").css("background-color", "red");
        setInterval(function() {
            $("#dropdownMenuButton").css("background-color", function() {
                this.switch = !this.switch
                return this.switch ? "red" : ""
            });
        }, 1000);
    </script>

    <script>
        $(window).scroll(function() {
            if ($(window).scrollTop() < 10) {
                $("#overtopbannerpic").addClass('nested');
                $("#topbannerpic").removeClass('nested');
            } else {
                $("#topbannerpic").addClass('nested');
                $("#overtopbannerpic").removeClass('nested');

            }
        });
    </script>
    <script>
        $(window).on('load', function() {

            $('.lazy').lazy();
        });
    </script>

    @yield('bottom-js')
</body>

</html>
