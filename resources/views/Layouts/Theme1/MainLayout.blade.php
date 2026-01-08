<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    @hasSection('MainTitle')
        <title>@yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif
    <!--  Todo: handle keywords   -->
    <meta name="keywords" content="{{ \App\branchenv::getenv('Description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ \App\myappenv::description }}">
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">
    <link rel="icon" type="image/png" href="{{ url('/') . \App\myappenv::FavIcon }}">
    @hasSection('OG')
        @yield('OG')
    @endif
    @hasSection('ExtraTags')
        @yield('ExtraTags')
    @endif
    <script>
        WebFontConfig = {
            google: {
                families: ['Poppins:400,500,600,700,800', ]
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];

            wf.src = '/Theme1/assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <link rel="preload" href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ url('/') }}/Theme1/assets/fonts/wolmart87d5.ttf?png09e" as="font"
        type="font/ttf" crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/Swiper/swiper-bundle.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/Theme1/assets/vendor/animate/animate.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/magnific-popup/magnific-popup.min.css">
    @if (\Request::is('/'))
        <link rel="stylesheet" type="text/css"
            href="{{ url('/') }}/Theme1/assets/css/{{ App\myappenv::StylePreName }}miainstyle.min.css">
    @else
        <link rel="stylesheet" type="text/css"
            href="{{ url('/') }}/Theme1/assets/css/{{ App\myappenv::StylePreName }}style.min.css">
    @endif
    @vite(['resources/js/app.js'])
    {!! \App\myappenv::googlealaliticscr !!}
    {!! \App\myappenv::Yektanet !!}


</head>

<body>
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
                    <div class="container">
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


            <!-- End of Header Top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left mr-md-4">
                        <a href="#" class="mobile-menu-toggle text-white w-icon-hamburger">
                        </a>
                        @if ($Route)
                            <a href="{{ route('home') }}" class="logo ml-lg-0">
                                <img src="{{ asset(App\myappenv::Sitelogo) }}" alt="lo\go" width="144"
                                    height="45" />
                            </a>
                        @endif
                        @if ($Route)
                            <form method="get" action="{{ route('search') }}"
                                class="input-wrapper header-search hs-expanded hs-round d-none d-md-flex">

                                <input type="text" class="form-control bg-white" name="q" id="search"
                                    placeholder="جستجو ..." required />
                                <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="header-right ml-4 ">
                        <div class="header-call d-xs-show d-lg-flex align-items-center  header-login " style="">
                            @if ($Route)
                                <form class="nested" id="curencyform" action="{{ route('changecurrency') }}"
                                    method="POST">
                                    @csrf
                                    <input id="Currencybtn" name="Currency">
                                </form>
                            @endif
                            <input id="curency_name" class="nested"
                                value="{{ App\Http\Controllers\Credit\currency::GetCurrency() }}">
                            <input id="curency_rate" class="nested"
                                value="{{ App\Http\Controllers\Credit\currency::GetCurrencyRate() }}">
                            <div class="dropdown mr-5 pr-5" style="border-left:1px solid">
                                <a>واحد
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }} </a>
                                <div class="dropdown-box">
                                    <a style="cursor: pointer;" onclick="ChangeCurency('Toman')">
                                        <img src="{{ url('/') }}/Theme1/assets/images/flags/eng.png"
                                            alt="ENG Flag" width="14" height="8" class="dropdown-image" />
                                        تومان </a>
                                    <a style="cursor: pointer;" onclick="ChangeCurency('Rial')">
                                        <img src="{{ url('/') }}/Theme1/assets/images/flags/eng.png"
                                            alt="FRA Flag" width="14" height="8" class="dropdown-image" />
                                        ریال </a>
                                </div>
                            </div>
                            @if ($Route)
                                <div class="">

                                    @if (Auth::check())
                                        <a href="{{ route('MyAccount') }}"
                                            class="d-lg-show">{{ Auth::user()->Name }}
                                            {{ Auth::user()->Family }}</a>
                                    @else
                                        <a href="{{ route('login') }}" class="link d-lg-show">ورود
                                            / ثبت نام </a>
                                    @endif

                                </div>
                            @endif


                        </div>

                        <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                            <div class="cart-overlay"></div>
                            <a onclick="load_basket()" class="cart-toggle label-down link text-white"
                                style="color:white">

                                @if (\App\Http\Controllers\woocommerce\buy::BasketItems() != null)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="30"
                                        fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z" />
                                    </svg>
                                    <span class="cart-count">
                                        {{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() }}</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="30"
                                        fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z" />
                                    </svg>
                                    <span class=" cart-count nested"></span>
                                @endif


                                <span class="cart-label">سبد خرید </span>
                            </a>
                            <div class="dropdown-box" style="padding-left:0.5rem">
                                <div class="cart-header">
                                    <span>سبد خرید فروشگاه </span>
                                    <a href="#" class="btn-close">بستن <i
                                            class="w-icon-long-arrow-left"></i></a>
                                </div>

                                <div id="basket_product_continner"></div>

                                <div id="emtycheckout" class="row gutter-lg mb-10  nested">
                                    <div class="text-center font-weight-bolder text-dark">

                                        <svg width="70" height="70" viewBox="0 0 161 160" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_140_30)">
                                                <path
                                                    d="M78.6067 75.1768L78.7837 75L78.6067 74.8231L67.1367 63.3632C67.1367 63.3632 67.1367 63.3631 67.1367 63.3631C66.695 62.9215 66.3447 62.3972 66.1057 61.8201C65.8667 61.2431 65.7437 60.6246 65.7437 60C65.7437 59.3754 65.8667 58.7569 66.1057 58.1798C66.3447 57.6027 66.6951 57.0784 67.1367 56.6367C67.5784 56.1951 68.1027 55.8447 68.6798 55.6057C69.2569 55.3667 69.8754 55.2437 70.5 55.2437C71.1246 55.2437 71.7431 55.3667 72.3201 55.6057C72.8972 55.8447 73.4215 56.195 73.8631 56.6367C73.8631 56.6367 73.8632 56.6367 73.8632 56.6367L85.3231 68.1067L85.5 68.2837L85.6768 68.1067L97.1367 56.6367C97.1368 56.6367 97.1368 56.6367 97.1368 56.6367C98.0288 55.7447 99.2386 55.2437 100.5 55.2437C101.761 55.2437 102.971 55.7448 103.863 56.6367C104.755 57.5287 105.256 58.7385 105.256 60C105.256 61.2614 104.755 62.4712 103.863 63.3632L92.3933 74.8231L92.2163 75L92.3933 75.1768L103.863 86.6367C104.755 87.5287 105.256 88.7385 105.256 90C105.256 91.2614 104.755 92.4712 103.863 93.3632C102.971 94.2552 101.761 94.7563 100.5 94.7563C99.2385 94.7563 98.0287 94.2552 97.1367 93.3632L85.6768 81.8933L85.5 81.7163L85.3231 81.8933L73.8632 93.3632C73.4215 93.8049 72.8972 94.1552 72.3201 94.3942C71.7431 94.6333 71.1246 94.7563 70.5 94.7563C69.8754 94.7563 69.2569 94.6333 68.6798 94.3942C68.1027 94.1552 67.5784 93.8049 67.1367 93.3632C66.6951 92.9215 66.3447 92.3972 66.1057 91.8201C65.8667 91.2431 65.7437 90.6246 65.7437 90C65.7437 89.3754 65.8667 88.7569 66.1057 88.1798C66.3447 87.6028 66.695 87.0785 67.1367 86.6368C67.1367 86.6368 67.1367 86.6368 67.1367 86.6367L78.6067 75.1768Z"
                                                    fill="#E8E8E8" stroke="black" stroke-width="0.5" />
                                                <path
                                                    d="M16.8426 19.9395L16.7953 19.75H16.6H5.5C4.24022 19.75 3.03204 19.2496 2.14124 18.3588C1.25045 17.468 0.75 16.2598 0.75 15C0.75 13.7402 1.25045 12.532 2.14124 11.6412C3.03204 10.7504 4.24022 10.25 5.5 10.25L20.4999 10.25C20.5 10.25 20.5 10.25 20.5 10.25C21.5595 10.2503 22.5885 10.6048 23.4234 11.2572C24.2582 11.9096 24.851 12.8224 25.1074 13.8505L25.1075 13.8506L29.1575 30.0606L29.2048 30.25H29.4H145.5C146.197 30.2506 146.886 30.4049 147.517 30.7017C148.148 30.9986 148.706 31.4308 149.152 31.9676C149.597 32.5045 149.918 33.1328 150.093 33.8079C150.268 34.4831 150.293 35.1885 150.164 35.8739L135.164 115.874C134.961 116.962 134.383 117.946 133.531 118.653C132.679 119.361 131.607 119.749 130.5 119.75H120.5H50.5H40.5002C39.3928 119.749 38.3206 119.361 37.4689 118.653C36.6172 117.946 36.0395 116.962 35.8357 115.874L35.8357 115.874L20.8557 36.0239L20.8544 36.0166L20.8526 36.0095L16.8426 19.9395ZM44.4043 110.046L44.4425 110.25H44.65H126.35H126.557L126.596 110.046L139.726 40.0461L139.781 39.75H139.48H31.52H31.2187L31.2743 40.0461L44.4043 110.046ZM36.5346 126.035C40.2385 122.331 45.262 120.25 50.5 120.25C55.738 120.25 60.7615 122.331 64.4654 126.035C68.1692 129.738 70.25 134.762 70.25 140C70.25 145.238 68.1692 150.262 64.4654 153.965C60.7615 157.669 55.738 159.75 50.5 159.75C45.262 159.75 40.2385 157.669 36.5346 153.965C32.8308 150.262 30.75 145.238 30.75 140C30.75 134.762 32.8308 129.738 36.5346 126.035ZM106.535 126.035C110.238 122.331 115.262 120.25 120.5 120.25C125.738 120.25 130.762 122.331 134.465 126.035C138.169 129.738 140.25 134.762 140.25 140C140.25 145.238 138.169 150.262 134.465 153.965C130.762 157.669 125.738 159.75 120.5 159.75C115.262 159.75 110.238 157.669 106.535 153.965C102.831 150.262 100.75 145.238 100.75 140C100.75 134.762 102.831 129.738 106.535 126.035ZM57.7478 147.248C59.6701 145.326 60.75 142.718 60.75 140C60.75 137.282 59.6701 134.674 57.7478 132.752C55.8256 130.83 53.2185 129.75 50.5 129.75C47.7815 129.75 45.1744 130.83 43.2522 132.752C41.3299 134.674 40.25 137.282 40.25 140C40.25 142.718 41.3299 145.326 43.2522 147.248C45.1744 149.17 47.7815 150.25 50.5 150.25C53.2185 150.25 55.8256 149.17 57.7478 147.248ZM127.748 147.248C129.67 145.326 130.75 142.718 130.75 140C130.75 137.282 129.67 134.674 127.748 132.752C125.826 130.83 123.218 129.75 120.5 129.75C117.782 129.75 115.174 130.83 113.252 132.752C111.33 134.674 110.25 137.282 110.25 140C110.25 142.718 111.33 145.326 113.252 147.248C115.174 149.17 117.782 150.25 120.5 150.25C123.218 150.25 125.826 149.17 127.748 147.248Z"
                                                    fill="#E8E8E8" stroke="black" stroke-width="0.5" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_140_30">
                                                    <rect width="160" height="160" fill="white"
                                                        transform="translate(0.5)" />
                                                </clipPath>
                                            </defs>
                                        </svg>


                                        <p class="font-weight-bolder">در سبد خرید شما کالایی موجود نیست</p>


                                    </div>
                                </div>

                            </div>
                            <!-- End of Dropdown Box -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header Middle -->

            <div class="header-bottom sticky-content fix-top sticky-header has-dropdown">
                <div class="container">
                    <div class="inner-wrap">
                        <div class="header-left">
                            <!-- main page whith show-dropdown other page  no -->

                            @if (isset($page) && $page == 1)
                                <div class="dropdown category-dropdown has-border show-dropdown" data-visible="true">
                                    <a href="#" class="category-toggle text-dark bg-white text-capitalize"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true" data-display="static" title="جستجوی دسته بندیها">
                                        <i class="w-icon-category"></i>
                                        <span>دسته بندی محصولات</span>
                                    </a>
                                @else
                                    <div class="dropdown category-dropdown has-border" data-visible="true">
                                        <a href="#" class="category-toggle text-dark bg-white text-capitalize"
                                            role="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true" data-display="static" title="جستجوی دسته بندی ها">
                                            <i class="w-icon-category"></i>
                                            <span>دسته بندی محصولات</span>
                                        </a>
                            @endif

                            <div class="dropdown-box text-default">
                                {!! App\Functions\AppSetting::get_html_obj('Theme1_RightMenu') !!}
                            </div>
                        </div>
                        <nav class="main-nav">
                            <ul class="menu">
                                {!! App\Functions\AppSetting::get_html_obj('Theme1_TopMenu') !!}
                            </ul>
                        </nav>
                    </div>
                    {{-- <div class="header-right">
                        <a href="#" class="d-xl-show"><i class="w-icon-map-marker mr-1"></i>پیگیری
                            سفارش</a>
                        <a href="#"><i class="w-icon-sale"></i>فروش ویژه </a>
                    </div> --}}
                </div>
            </div>
    </div>
    </header>
    <main class="main">
        <div class="container pb-2">
            @include('Layouts.Theme1.objects.ErrorHanderler')
            @yield('MainContent')

        </div>
        </div>
    </main>

    <footer class="footer appear-animate" data-animation-options="{'name': 'fadeIn'}">
        <div class="container">
            <div class="footer-top">
                <div class="row">
                    {!! App\Functions\AppSetting::get_html_obj('Theme1_footer') !!}
                </div>
            </div>

        </div>
        <div class="footer-bottom">
            <div class="container">
                <div style="display: block ; text-align:center" class="footer-left">
                    <p class="copyright">{!! App\myappenv::copyright !!}</p>
                    <small>powerd by: <a href="https://dgkar.com">DGKAR</a> </small>
                </div>
                <div class="footer-right">

                    <figure class="payment">
                        <a referrerpolicy="origin" target="_blank" href="{{ App\myappenv::Namad }}">
                            <img style="width: 60px;" src="{{ url('/') }}/assets/images/nemad.png"
                                alt="اینماد" />
                        </a>

                    </figure>

                    <img referrerpolicy="origin" id='jxlzsizpfukzapfuesgtapfu' style='cursor:pointer; height: 84px;'
                        onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=196505&p=rfthpfvlgvkadshwobpddshw", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
                        alt='logo-samandehi' src="{{ asset('assets/images/perNemad.png') }}" />

                </div>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
    </div>
    <!-- End of Page-wrapper -->

    <!-- Start of Sticky Footer -->
    @if (\App\myappenv::MainOwner == 'shafatel')

        <div class="sticky-footer sticky-content fix-bottom fixed55">
            <a style="
                font-size: 10px;
                font-weight: 1000 !important;
            "
                id="patiantworks_text" class="sticky-link active" href="/">
                <i style="font-size: 25px;font-weight: bold;" class="sidebar-icon-style nav-icon w-icon-home"></i>
                <span class="nav-text">خانه</span>
            </a>
            <a style="
                font-size: 10px;
                font-weight: 1000 !important;
            "
                href="https://shafatel.com" class="sticky-link active">
                <i style="font-size: 25px;font-weight: bold;" class="sidebar-icon-style nav-icon w-icon-category"></i>
                <p> خدمات</p>
            </a>
            <a style="
                font-size: 10px;
                font-weight: 1000 !important;
            "
                href="https://shafatel.com/Product" class="sticky-link">
                <i style="font-size: 25px;font-weight: bold;" class="sidebar-icon-style nav-icon w-icon-store"></i>
                <p>فروش کالا</p>
            </a>
            <a style="
                font-size: 10px;
                font-weight: 1000 !important;
            "
                href="http://shafatel.com" class="sticky-link">
                <i style="font-size: 25px;font-weight: bold;" class="sidebar-icon-style nav-icon w-icon-support"></i>
                <p>اجاره تجهیزات </p>
            </a>
        </div>
    @else
        <div class="sticky-footer sticky-content fix-bottom fixed55">
            @if ($Route)
                <a href="{{ route('home') }} " class="sticky-link active">
                    <i class="w-icon-home"></i>
                    <p>خانه </p>
                </a>


                <a href="{{ route('ShowProduct') }}" class="sticky-link">
                    <i class="w-icon-category"></i>
                    <p>فروشگاه </p>
                </a>
                <a href="{{ route('MyAccount') }}" class="sticky-link">
                    <i class="w-icon-account"></i>
                    <p>حساب کاربری </p>
                </a>
                <div class="cart-dropdown dir-up">
                    <a onclick="load_basket()" class="sticky-link">
                        <i class="w-icon-cart"></i>
                        <p>سبد خرید </p>
                    </a>
                    <div class="dropdown-box">
                        <div id="basket_product_continner_mobile" class="products">

                        </div>

                        <div id="basket_product_summery_mobile" class="cart-total">

                        </div>

                        <div class="cart-action">
                            <a href="{{ route('checkout') }}" class="btn btn-dark btn-outline btn-rounded">نمایش سبد
                            </a>
                        </div>

                    </div>
            @endif
            <!-- End of Dropdown Box -->
        </div>
        @if ($Route)
            <div class="header-search hs-toggle dir-up">
                <a href="#" class="search-toggle sticky-link">
                    <i class="w-icon-search"></i>
                    <p>جستجو </p>
                </a>
                <form method="GET" action="{{ route('search') }}" class="input-wrapper">
                    <input type="text" class="form-control" name="q" autocomplete="off"
                        placeholder="جستجو" required />
                    <button class="btn btn-search" type="submit">
                        <i class="w-icon-search"></i>
                    </button>
                </form>
            </div>
        @endif
    @endif
    </div>
    <!-- End of Sticky Footer -->

    <!-- Start of Scroll Top -->
    <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i
            class="fas fa-chevron-up"></i></a>
    <!-- End of Scroll Top -->

    <!-- Start of Mobile Menu -->
    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-overlay"></div>
        <!-- End of .mobile-menu-overlay -->

        <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
        <!-- End of .mobile-menu-close -->

        <div class="mobile-menu-container scrollable">

            @if ($Route)
                <form method="GET" action="{{ route('search') }}" class="input-wrapper">
                    <input type="search" class="form-control" name="q" autocomplete="off"
                        placeholder="جستجو" />
                    <button class="btn btn-search" type="submit">
                        <i class="w-icon-search"></i>
                    </button>
                </form>
            @endif
            {!! App\Functions\AppSetting::get_html_obj('Theme1_MobileMenu') !!}
        </div>
    </div>


    <script src="{{ url('/') }}/Theme1/assets/vendor/jquery/jquery.min.js"></script>
    @yield('page-js')
    <script src="{{ url('/') }}/Theme1/assets/vendor/parallax/parallax.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/jquery.plugin/jquery.plugin.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/skrollr/skrollr.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/zoom/jquery.zoom.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/jquery.countdown/jquery.countdown.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/sweetalert/sweetalert2.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/Swiper/swiper-bundle.min.js"></script>
    <script>
        window.CurencyRate = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
        window.CurencyName = '<?php echo App\Http\Controllers\Credit\currency::GetCurrency(); ?>';

        function load_basket() {
            $('#basket_product_continner').html('.');
            $('#basket_product_continner').addClass('loading');
            $('#basket_product_continner_mobile').html('.');
            $('#basket_product_continner_mobile').addClass('loading');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php if ($Route) {
                echo e(route('ajax'));
            } ?>', {
                    AjaxType: 'GetBasketBref',
                },

                function(data, status) {
                    if (data == '') {
                        $('#emtycheckout').removeClass('nested');
                        $('.cart-action').addClass('nested');


                    } else {
                        $('#basket_product_continner').html(data);
                        $('#basket_product_continner_mobile').html(data);

                        $('#basket_product_continner').removeClass('loading');
                        $('#basket_product_continner_mobile').removeClass('loading');
                    }


                });

        }


        function removeitemmainlayout($ProductID) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php if ($Route) {
                echo e(route('ajax'));
            } ?>', {

                    AjaxType: 'removeitem',
                    ProductID: $ProductID,

                },

                function(data, status) {
                    load_basket();


                });

        }
    </script>
    <script>
        function ChangeCurency($Rate) {
            $('#Currencybtn').val($Rate);
            $('#curencyform').submit();
        }
    </script>
    <!-- Main JS -->
    <script src="{{ url('/') }}/Theme1/assets/js/main.min.js"></script>
    <script>
        window.CurencyRate = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
        window.CurencyName = '<?php echo App\Http\Controllers\Credit\currency::GetCurrency(); ?>';
    </script>

    <script>
        function addtobasket(wgid, ProductID) {
            $CountValu = 1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php if ($Route) {
                echo e(route('ajax'));
            } ?>', {
                    AjaxType: 'AddToBasketStepper',
                    ProductId: ProductID,
                    pw_id: wgid,
                    OrderQty: $CountValu,
                },

                function(data, status) {

                });
        }

        function GetPercent(BasePrice, Price, Remain) {
            if (parseInt(Remain) > 0) {
                BasePrice = parseInt(BasePrice);
                Price = parseInt(Price);
                if (BasePrice == 0) {
                    return '';
                }
                $Percent = Math.round(((BasePrice - Price) * 100) / BasePrice);
                return $Percent;
            } else {
                return '';
            }
        }
    </script>
    <script type="text/javascript">
        ! function() {
            var i = "Vtbxzk",
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


    @yield('bottom-js')
</body>


</html>
