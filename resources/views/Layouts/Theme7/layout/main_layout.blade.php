@php
    if (Auth::check()) {
        $user_role = Auth::user()->Role;
    } else {
        $user_role = 0;
    }

@endphp
<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:site_name" content="{{ \App\myappenv::CenterName }}" />
    <meta name="keywords" content="{{ \App\myappenv::CenterName }}">
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">
    @hasSection('OG')
        @yield('OG')
    @else
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ \App\myappenv::CenterName }}" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:image" content="{{ \App\myappenv::FavIcon }}" />
        <meta property="og:image:width" content="36" />
        <meta property="og:image:height" content="34" />
        <meta property="og:image:type" content="image/png" />
        <meta name="twitter:card" content="summary_large_image" />
    @endif
    @hasSection('description')
        <meta property="og:description" content="@yield('description')" />
        <meta name="description" content="@yield('description')">
    @else
        <meta property="og:description" content="{{ \App\myappenv::description }}" />
        <meta name="description" content="{{ \App\myappenv::description }}">
    @endif
    @hasSection('ExtraTags')
        @yield('ExtraTags')
    @endif
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON -->
    <link rel="icon" href="/Theme7/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="/Theme7/images/favicon.png">

    <!-- PAGE TITLE HERE -->
    @hasSection('MainTitle')
        <title>@yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('before-css')
    <link rel="stylesheet" type="text/css" href="/Theme7/css/main.css">
    <link rel="stylesheet" type="text/css" href="/Theme7/fonts/pelak/css/pelak.css">
    <link rel="stylesheet" type="text/css" href="/Theme7/plugins/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/Theme7/plugins/themify/themify-icons.css">
    <link rel="apple-touch-icon" href="/Theme7/images/favicon.png">
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/sweetalert/sweetalert2.min.css">
    @vite(['resources/js/app.js'])
    @yield('page-css')
</head>

<body id="bg">
    <div id="loading-area"></div>
    <div class="page-wraper">
        <!-- header -->
        <header class="site-header mo-left header fullwidth">
            <!-- main header -->
            <div class="sticky-header main-bar-wraper navbar-expand-lg">
                <div class="main-bar clearfix">
                    <div class="container clearfix">
                        <!-- website logo -->
                        <div class="logo-header mostion">
                            <a href="{{ route('home') }}"><img src="https://parastarbank.com/Theme7/images/logo.png"
                                    class="logo" alt="{{ \App\myappenv::CenterName }}"></a>
                        </div>
                        <!-- nav toggle button -->
                        <!-- nav toggle button -->
                        <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                            data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <div class="header-nav navbar-collapse collapse justify-content-start" id="navbarNavDropdown">
                            <ul class="nav navbar-nav">
                                <li class="{{ request()->is('/') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}"><i style="font-size: 18px;margin-left:10px;"
                                            class="fa fa-home"></i> خانه</a>
                                </li>
                                <li class="{{ request()->is('add_experience') ? 'active' : '' }}">
                                    <a href="{{ route('add_experience') }}"><i
                                            style="font-size: 18px;margin-left:10px;" class="fa fa-book"></i> ثبت نظر
                                    </a>
                                <li class="{{ request()->is('search_staff') ? 'active' : '' }}">
                                    <a href="{{ route('search_staff') }}"><i style="font-size: 18px;margin-left:10px;"
                                            class="fa fa-search"></i>جستجوی
                                        درمانگر - پرستار</a>
                                </li>
                                @if (Auth::check())
                                    <li>
                                        <a href="{{ route('experience_list') }}"><i
                                                style="font-size: 18px;margin-left:10px;" class="fa fa-list"></i>گزارشات
                                            من</a>
                                    </li>
                                    @if (Auth::user()->Role > \App\myappenv::role_trader)
                                        <li>
                                            <a href="{{ route('changeview', ['Target' => 'Dashboard']) }}"><i
                                                    style="font-size: 18px;margin-left:10px;"
                                                    class="fa fa-dashboard"></i>داشبورد</a>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <a href="{{ route('login') }}"><i style="font-size: 18px;margin-left:10px;"
                                                class="fa fa-lock"></i>ثبت نام / ورود </a>
                                    </li>

                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- main header END -->
        </header>
        <!-- header END -->
        <!-- Content -->
        <div class="page-content">
            @include('Layouts.ErrorHandler')
            @yield('content')
            <!-- Section Banner -->

            <!-- Our Latest Blog -->
        </div>
        <!-- Content END-->
        <!-- Modal Box -->

        <!-- Modal Box End -->
        <!-- Footer -->
        <footer class="site-footer">
            <div style="background-color: #3396d1" class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-4 col-md-12 col-sm-12">
                            <div style="display: ruby" class="widget">
                                <img src="/Theme7/images/favicon.png" width="50px" class="m-b15"
                                    alt="{{ \App\myappenv::CenterName }}">
                                <ul class="list-2 list-line">
                                    <p style="font-size:16px; margin-bottom: 7px;text-align:justify;"
                                        class="text-capitalize text-white m-b20">پرستار بانک یک سامانه ثبت نظر و
                                        استعلام خدمات
                                        دهندگان مراقبتی- درمانی در منزل است که با هدف بالابردن کیفیت خدمت رسانی در منزل،
                                        افزایش آگاهی خانواده ها و شرکت های متقاضی استخدام نیروی پرستار قبل از آغاز به
                                        کار طراحی شده است. </p>
                                    <p style="font-size:16px; margin-bottom: 7px;"
                                        class="text-capitalize text-white m-b20">ارتباط با ما:</p>
                                    <p style="font-size:16px; margin-bottom: 7px;margin-top: 1px;"
                                        class=" text-white text-capitalize m-b20">تهـــران، خیـــابـــان آزادی،
                                        خیـــابـــان حبیب
                                        الله خیابان قاسمی،جنب جهاد دانشگاهی شریف پلاک ۷۹ </p>
                                    <p style="font-size:16px;color:white;" class=" text-capitalize text-white m-b20">
                                        شماره تماس : <a class="text-white"
                                            style="direction: ltr;position: absolute;font-size:16px;"
                                            href="tel:02128428457">(021)28428457</a> </p>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-8 col-md-12 col-sm-8 col-12">
                            <div class="widget border-0">
                                <h5 class="m-b30 text-white"> دسترسی سریع:</h5>
                                <ul class="list-2 list-line">
                                    <li><a style="font-size:16px;color:white;"
                                            href="https://parastarbank.com/news/about-parstarbank">درباره
                                            پرستاربانک</a></li>

                                    <li style="font-size:16px;color:white;"><a style="font-size:16px;color:white;"
                                            href="https://parastarbank.com/news/what-is-parstarbank">پرستاربانک
                                            چیست؟</a></li>

                                    <li><a style="font-size:16px;color:white;"
                                            href="https://parastarbank.com/news/services">شرایط استفاده از خدمات
                                            پرستاربانک</a>
                                    </li>

                                    <li><a style="font-size:16px;color:white;"
                                            href="https://parastarbank.com/news/condition">شرایط استفاده از خدمات برای
                                            مشتریان</a></li>
                                    <li><a style="font-size:16px;color:white;"
                                            href="https://parastarbank.com/news/doc-service">شرایط استفاده از خدمات
                                            برای
                                            پزشکان</a></li>
                                    <li><a style="font-size:16px;color:white;"
                                            href="https://parastarbank.com/news/nurse-service">شرایط استفاده از خدمات
                                            برای
                                            پرستاران</a></li>
                                </ul>
                            </div>
                        </div>
                        <a referrerpolicy='origin' target='_blank'
                            href='https://trustseal.enamad.ir/?id=519245&Code=AoIIGlYopULbubuG9tXH8UWJyXxWNiyG'><img
                                referrerpolicy='origin'
                                src='https://trustseal.enamad.ir/logo.aspx?id=519245&Code=AoIIGlYopULbubuG9tXH8UWJyXxWNiyG'
                                alt='نماد {{ \App\myappenv::CenterName }}' style='cursor:pointer'
                                code='AoIIGlYopULbubuG9tXH8UWJyXxWNiyG'></a>

                    </div>
                </div>
            </div>
            <!-- footer bottom part -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <span> © کپی رایت 1400 با <i class="fa fa-heart m-lr5 text-red heart"></i>
                                <a href="https://dgkar.com">dgkar </a> همه حقوق محفوظ
                                است.</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer END -->
        <!-- scroll top button -->
        <button class="scroltop fa fa-arrow-up"></button>
    </div>
    <!-- JAVASCRIPT FILES ========================================= -->
    <script src="/Theme7/js/combining.js"></script><!-- COMBINING JS  -->
    @php
        $goftino_main = App\Functions\CacheData::GetSetting('goftino_id');
    @endphp
    <script src="{{ url('/') }}/Theme1/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>
    <script src="{{ url('/') }}/Theme1/assets/vendor/sweetalert/sweetalert2.min.js"></script>
    @if ($goftino_main && ($user_role <= App\myappenv::role_ShopOwner || $user_role == 0))
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
    @endif
    <script>
        function alert(msg) {
            Swal.fire({
                title: 'خطا',
                text: msg,
                icon: 'error',
                confirmButtonText: 'تائید'
            })
        }
    </script>
    <script>
        var elements = document.getElementsByClassName("english_limit");
        var myFunction = function() {
            var attribute = this.getAttribute("data-myattribute");
            alert(attribute);
        };

        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('keypress', (e) => {

                const allowed_chars = ['‌', ' ', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd',
                    'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', '.', '-', '_',
                    'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K',
                    'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'
                ];
                if (!allowed_chars.includes(e.key)) {
                    alert('لطفا فقط از حروف انگلیسی استفاده کنید');
                    e.preventDefault();
                }
                return;

            });
        }
        var elements = document.getElementsByClassName("persian_limit");
        var myFunction = function() {
            var attribute = this.getAttribute("data-myattribute");
            alert(attribute);
        };

        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('keypress', (e) => {

                const allowed_chars = ['‌', ' ', 'آ', 'ا', 'ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'د', 'ذ', 'ر',
                    'ز', '.', ',', '.', '،', 'ء',
                    'ژ', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'گ', 'ل', 'م', 'ن', 'و', 'ه',
                    'ی', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '۰', '۱', '۲', '۳', '۴', '۵', '۶',
                    '۷', '۸', '۹',
                    'ي', 'ك', 'ة'
                ];
                if (!allowed_chars.includes(e.key)) {
                    alert('لطفا فقط از حروف فارسی استفاده کنید');
                    e.preventDefault();
                }
                return;

            });
        }
        var elements = document.getElementsByClassName("number_only");
        var myFunction = function() {
            var attribute = this.getAttribute("data-myattribute");
            alert(attribute);
        };

        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('keypress', (e) => {
                const allowed_chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                if (!allowed_chars.includes(e.key)) {
                    alert('لطفا فقط از  اعداد استفاده کنید');
                    e.preventDefault();
                }
                return;
            });
        }
        var elements = document.getElementsByClassName("number_only_date");
        var myFunction = function() {
            var attribute = this.getAttribute("data-myattribute");
            alert(attribute);
        };

        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('keypress', (e) => {
                const allowed_chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '/'];
                if (!allowed_chars.includes(e.key)) {
                    alert('فرمت صحیح ورود تاریخ به صورت ۱۴۰۱/۰۵/۰۱ است.');
                    e.preventDefault();
                }
                return;
            });
        }
    </script>
    @yield('page-js')
</body>

</html>
