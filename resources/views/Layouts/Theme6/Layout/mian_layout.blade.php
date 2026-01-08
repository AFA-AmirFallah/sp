@php
    if (Auth::check()) {
        $user_role = Auth::user()->Role;
    } else {
        $user_role = 0;
    }

@endphp
<!doctype html>

<!--f194f35f8b8a910a8d63286d01f41d93-->

<html lang="fa">

<head>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6B7L8MS2WX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-6B7L8MS2WX');
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="dgkar.com">
    <meta property="og:site_name" content="{{ \App\myappenv::CenterName }}" />

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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('MainTitle')
        <title>@yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif
    <link rel="apple-touch-icon" href="{{ \App\myappenv::FavIcon }}">
    <link rel="icon" href="{{ \App\myappenv::FavIcon }}" />
    <!-- All CSS -->
    <link rel="stylesheet" href="/Theme6/assets/css/rayan-main.css">
    <link rel="stylesheet" href="/Theme6/assets/css/fancybox.css">

    <style>
        img.deal-img {
            height: 300px;
            width: max-content;
        }

        div.deal-img {
            text-align: center;
            background-color: #f6f6f6;

        }
    </style>

</head>

<body>
    <!-- Start Preloader -->
    <div class="preloader">
        <div class="loader">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    <!-- Start Navbar Area -->
    <div class="navbar-area">
        <!-- Menu For Mobile Device -->
        <div class="mobile-nav">
            <a href="{{ route('home') }}" class="logo">
                <img src="/Theme6/assets/img/logo.png" alt="Image">
            </a>
        </div>
        <!-- Menu For Desktop Device -->
        <div class="main-nav main-nav2">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <div class="logo logo2">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="/Theme6/assets/img/logo2.png" class="logo-2" alt="Logo">
                        </a>
                        <a class="navbar-brand2" href="{{ route('home') }}">
                            <img src="/Theme6/assets/img/logo.png" class="logo-2" alt="Logo">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav navbar-nav2 m-auto">
                            {!! App\Functions\AppSetting::get_html_obj('Theme6_menu') !!}
                            @if (Auth::check())
                                <li class="nav-item">
                                    <a href="{{ route('changeview', ['Target' => 'Dashboard']) }}" class="nav-link">پنل
                                        کاربری</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link">ورود به سامانه</a>
                                </li>
                            @endif


                        </ul>

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- End Navbar Area -->



    @include('Layouts.Theme1.objects.ErrorHanderler')
    @yield('content')

    <!-- Start Main Banner -->


    <!-- Start Top Footer -->
    <footer class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="single-widget">
                        <div class="logo-image">
                            <a href="{{ route('home') }}">
                                <img src="/Theme6/assets/img/logo.png" alt="Logo">
                            </a>
                        </div>
                        <p style="text-align: justify">رایان دیزل اولین پلتفرم جامع ماشین‌های سنگین در ایران است که با
                            تمرکز بر *تسهیل خرید، فروش و
                            ارائه خدمات* به مشتریان فعالیت می‌کند. این مجموعه با بهره‌گیری از *کارشناسان مجرب، آماده
                            همراهی شما در خرید و فروش خودروهای سنگین با **قیمت مناسب و شرایط مطلوب* است.</p>

                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="single-widget">
                        <h3>آدرس شعب ما </h3>
                        <div class="information">
                            <ul>
                                <li>
                                    <a href="https://maps.app.goo.gl/whL3r3kkFobQdxt7A">
                                        <i class="flaticon-facebook-placeholder-for-locate-places-on-maps"></i>
                                        شعبه ۱ : تهران اتوبان آیت الله سعیدی نرسیده به میدان نماز لاین کندرو روبروی ده
                                        عباس نبش بهرام آباد
                                    </a>
                                </li>
                                <li>
                                    <a href="https://maps.app.goo.gl/whL3r3kkFobQdxt7A">
                                        <i class="flaticon-facebook-placeholder-for-locate-places-on-maps"></i>
                                        شعبه ۲: تهران اتوبان آیت اله سعیدی میدان نماز به سمت چهاردانگه لاین کندرو
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="flaticon-smartphone-call"></i>
                                        021-41484
                                    </a>
                                </li>
                                <li style="display: flex">

                                    <a class="col"
                                        href="https://neshan.org/maps/places/8cb464a2c37a688e6a50c7448b2eda23#c35.572-51.347-11z-0p"><img src="https://rayandiesel.co/storage/photos/icons/neshan.webp" alt="مسیر یاب نشان"></a>
                                    <a class="col"
                                        href="https://balad.ir/p/%D8%B1%D8%A7%DB%8C%D8%A7%D9%86-%D8%AF%DB%8C%D8%B2%D9%84-eslam-shahr_shopping-mall-6FpuFa2i0DOiMO#15/35.57226/51.26715"><img src="https://rayandiesel.co/storage/photos/icons/balad.webp" alt="مسیر یاب بلد"></a>

                                </li>


                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="single-widget">
                        <h3>آدرس دفاتر ما </h3>
                        <div class="information">
                            <ul>

                                <li style="text-align: justify">
                                    <a href="https://maps.app.goo.gl/whL3r3kkFobQdxt7A">
                                        <i class="flaticon-facebook-placeholder-for-locate-places-on-maps"></i>
                                        دفتر لیزینگ و فناوری : تهران - خیابان قائم مقام فرهانی کوچه ۱۰ پلاک ۲۴ واخد ۲۷
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="flaticon-smartphone-call"></i>
                                        <a href="tel:02141484"> 021-41484</a>
                                    </a>
                                </li>



                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="single-widget">
                        <h3> مجوز ها و همکاران ما </h3>
                        <div class="img-list">
                            <ul>
                                <li>
                                    <a referrerpolicy='origin' target='_blank'
                                        href='https://trustseal.enamad.ir/?id=553518&Code=RhGnwvC2Pj489m8s7XRTDaxDPD8Ji7BK'><img
                                            referrerpolicy='origin'
                                            src='https://rayandiesel.co/storage/photos/car-logo/81.png' alt='enamd'
                                            style='cursor:pointer' code='RhGnwvC2Pj489m8s7XRTDaxDPD8Ji7BK'></a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="https://rayandiesel.co/storage/photos/icons/unnamed.png"
                                            alt="Image">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="https://rayandiesel.co/storage/photos/icons/cropped-logo-just-192x192 (1).png"
                                            alt="Image">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <!-- End Top Footer -->

    <!-- Start Bottom Footer -->
    <footer class="footer-bottom">
        <div class="container">
            <p class="envytheme-link">قدرت گرفته از پلتفرم کسب و کار <a href="https://dgkar.com">دیجی‌کار</p>
        </div>
    </footer>
    <!-- End Bottom Footer -->



    <!-- Jquery Min Js -->
    <script src="/Theme6/assets/js/rayan-main.js"></script>
    <script src="/Theme6/assets/js/fancybox.umd.js"></script>
    <script src="{{ asset('assets/js/jquery.lazy.js') }}"></script>

    <script>
        $(document).ready(function() {
            container_run()
        });


        function container_run() {

            let res = document.getElementById('container');

            if (res != null) {
                myTitle = document.getElementById('container').getAttribute('title');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('/container', {
                        type: myTitle,
                    },
                    function(data, status) {
                        res.innerHTML = data;
                    });
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.lazy').Lazy({
                customLoaderName: function(element) {
                    element.html('element handled by "customLoaderName"');
                    element.load();
                },
                asyncLoader: function(element, response) {
                    setTimeout(function() {
                        element.html('element handled by "asyncLoader"');
                        response(true);
                    }, 1000);
                }
            });
        });
    </script>

    @yield('end_script')

    @php
        $goftino_main = App\Functions\CacheData::GetSetting('goftino_id');

        $app_version = App\myappenv::version;
        if ($app_version < 3) {
            $goftino_branch = App\Functions\CacheData::GetSetting('goftino_id');
        } else {
            $goftino_branch = App\branchenv::getenv('center_goftino');
        }
    @endphp


    @if ($goftino_main && ($user_role == App\myappenv::role_ShopOwner || $user_role == 0))
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
    @elseif($goftino_branch != null && $user_role < App\myappenv::role_ShopOwner)
        <script type="text/javascript">
            ! function() {
                var i = "<?php echo $goftino_branch; ?>",
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
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "pua1obc32d");
    </script>

</body>

</html>
