<!DOCTYPE html>
<html lang="fa">

<head>
    <!-- Basic Page Needs
================================================== -->
    <meta charset="utf-8">
    @if (View::hasSection('page-title'))
        <title> @yield('page-title')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif

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
        <meta name="description" content="{{ \App\myappenv::CenterName }}">
        <meta name="og:description" content="{{ \App\myappenv::CenterName }}">
    @endif

    <!-- Mobile Specific Metas
================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!--Favicon-->
    <link rel="shortcut icon" href="{{ \App\myappenv::FavIcon }}" type="image/x-icon">
    <link rel="icon" href="{{ \App\myappenv::FavIcon }}" type="image/x-icon">

    <!-- CSS
================================================== -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('news/css/bootstrap.min.css') }}">
    <!-- Template styles-->
    <link rel="stylesheet" href="{{ asset('news/css/style.css') }}">
    <!-- Responsive styles-->
    <link rel="stylesheet" href="{{ asset('news/css/responsive.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('news/css/font-awesome.min.css') }}">
    <!-- Animation -->
    <link rel="stylesheet" href="{{ asset('news/css/animate.css') }}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('news/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('news/css/owl.theme.default.min.css') }}">
    <!-- Colorbox -->
    <link rel="stylesheet" href="{{ asset('news/css/colorbox.css') }}">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="{{ asset('news/js/html5shiv.js') }}"></script>
    <script src="{{ asset('news/js/respond.min.js') }}"></script>
    <![endif]-->
    @yield('end_css')

</head>

<body>


    <div class="body-inner">

        <!-- <div class="preload"></div> -->
        @yield('trending')
        @include('news.Layouts.top-bar')
        <!-- Header start -->
        <style>
            @media (min-width:992px) {
                .customlogo {}

                .login-mobile {
                    display: none;
                }
            }

            @media (min-width:768px) {
                @media (max-width:992px) {
                    .customlogo {
                        float: right;
                        margin: auto;
                    }

                    .login-mobile {
                        margin-top: 10px;
                        float: left;
                    }

                }
            }

            @media (max-device-width:768px) {
                .customlogo {
                    float: right;
                    margin: auto;
                }

                .login-mobile {
                    margin-top: 10px;
                    float: left;
                }
            }
        </style>

        <header id="header" class="header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="login-mobile">
                            @if (!Auth::check())
                                <div>
                                    <a style="color: #000000" href="{{ route('login') }}"> ورود <i style="color: white"
                                            class="fa fa-sign-in"></i></a>

                                    /
                                    <a style="color: #000000" href="{{ route('register') }}">
                                        عضویت <i style="color: white" class="fa fa-unlock-alt"></i>
                                    </a>
                                </div>
                            @else
                                <a href="{{ route('UserProfile') }}">ورود به پنل {{ Auth::user()->Name }}
                                    {{ Auth::user()->Family }}</a>
                            @endif
                        </div>
                        <div class="customlogo logo">
                            <a href="{{ route('home') }}">
                                <img class="logo-image-style" src="{{ asset(\App\myappenv::Sitelogo) }}"
                                    alt="">
                            </a>
                        </div>

                    </div><!-- logo col end -->
                    <div class="col-xs-12 col-sm-9 col-md-9 header-right">
                        <div class="ad-banner pull-right">
                            @php
                                $adscounter = 0;
                            @endphp
                            @foreach ($DataSource->AdPosts() as $AdPostitem)
                                @if ($AdPostitem->adds == 3)
                                    @php
                                        $adscounter++;
                                        $BannerLink = strip_tags($AdPostitem->Titel);
                                    @endphp
                                    <div id="adds_{{ $adscounter }}" class="nested ads_countiner ">
                                        <a href="{{ $BannerLink }}">
                                            <img class="banner img-responsive" src="{{ $AdPostitem->MainPic }}"
                                                alt="carpetour ads">
                                        </a>
                                        @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                            <a style="float: left;"
                                                href="{{ route('EditNews', [$AdPostitem->id]) }}"><i
                                                    class="fa fa-pencil"></i></a>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div><!-- header right end -->
                </div><!-- Row end -->
            </div><!-- Logo and banner area end -->
        </header>
        <!--/ Header end -->


        @include('news.Layouts.menu')
        <section class="block-wrapper" @if (isset($homepage)) style="background-color: #4b4949" @endif>
            <div class="container">
                @yield('container')
            </div><!-- Container end -->
        </section><!-- First block end -->
        <footer id="footer" class="footer">
            <div class="footer-info text-center" style="
            margin-bottom: -60px;
        ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <div style="margin-bottom: -29px;" class="footer-logo">
                                <img style="max-width: 100px" class="img-responsive"
                                    src="{{ asset(\App\myappenv::Sitelogo) }}" alt="">
                            </div>
                            <p style="line-height:200%;">{!! \App\myappenv::CenterFootertext !!}</p>
                            <a style="color: #969696" href="malito:{{ \App\myappenv::CenterEmail }}">
                                <ul style="margin: -4px;"><i class="fa fa-envelope-o"></i></ul>

                                <p class="footer-info-email" style="letter-spacing: 1px;font-size:12px;"> <span
                                        class="ltr_text">{{ \App\myappenv::CenterEmail }}</span>
                                </p>
                            </a>
                            <ul class="unstyled footer-social">
                                <li>
                                    <a title="Facebook" target="_blank"
                                        href="https://www.facebook.com/hicarpetour-122367702492975">
                                        <span class="social-icon"><i class="fa fa-facebook"></i></span>
                                    </a>

                                    <a title="Instagram" target="_blank"
                                        href="https://www.instagram.com/hicarpetour/">
                                        <span class="social-icon"><i class="fa fa-instagram"></i></span>
                                    </a>
                                    <a title="whatsapp" href="https://wa.me/09123050003">
                                        <span class="social-icon"><img
                                                src="{{ asset('assets/images/carpetour_whatsapp.png') }}"
                                                alt="whatsapp"></span>
                                    </a>
                                    <a title="Telegram" target="_blank" href="http://t.me/hicarpetour">
                                        <span class="social-icon"><img
                                                src="{{ asset('assets/images/carpetour_telegram.png') }}"
                                                alt="telegram"></span>
                                    </a>
                                </li>
                            </ul>
                        </div><!-- Footer info content end -->
                    </div><!-- Col end -->
                </div><!-- Row end -->
            </div><!-- Container end -->
    </div><!-- Footer info end -->
    <div style="
    margin-top: -145px;
    border-radius: 16px;
    margin-right: 10px;
    background: aliceblue;
    position: absolute;
    z-index: 99999;
"
        class="namad">{!! \App\myappenv::Namad !!}</div>

    </footer><!-- Footer end -->

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="copyright-info">
                        <span>تمامی حقوق برای این وب سایت محفوظ است <a style="color: floralwhite;margin: 6px;"
                                href="https://dgkar.com">قدرت گرفته از پلتفرم جامع کسب و کار دیجی کار</a></span>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="footer-menu">
                        <ul class="nav unstyled">
                            <li><a
                                    href="https://carpetour.net/news/583/%D9%82%D9%88%D8%A7%D9%86%DB%8C%D9%86%20%D9%88%20%D9%85%D9%82%D8%B1%D8%B1%D8%A7%D8%AA">قوانین
                                    سایت</a></li>
                            <li><a
                                    href="https://carpetour.net/news/373/%D8%AF%D8%B1%D8%A8%D8%A7%D8%B1%D9%87%20%D9%85%D8%A7">درباره
                                    ما</a></li>
                            <li><a
                                    href="https://carpetour.net/news/543/%D8%AA%D9%85%D8%A7%D8%B3%20%D8%A8%D8%A7%20%D9%85%D8%A7">تماس
                                    با ما</a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- Row end -->
            <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top affix">
                <button class="btn btn-primary" title="Back to Top">
                    <i class="fa fa-angle-up"></i>
                </button>
            </div>

        </div><!-- Container end -->
    </div><!-- Copyright end -->


    <!-- Javascript Files
================================================== -->

    <!-- initialize jQuery Library -->
    <script type="text/javascript" src="{{ asset('news/js/jquery.js') }}"></script>
    <!-- Bootstrap jQuery -->
    <script type="text/javascript" src="{{ asset('news/js/bootstrap.min.js') }}"></script>
    <!-- Owl Carousel -->
    <script type="text/javascript" src="{{ asset('news/js/owl.carousel.min.js') }}"></script>
    <!-- Counter -->
    <script type="text/javascript" src="{{ asset('news/js/jquery.counterup.min.js') }}"></script>
    <!-- Waypoints -->
    <script type="text/javascript" src="{{ asset('news/js/waypoints.min.js') }}"></script>
    <!-- Color box -->
    <script type="text/javascript" src="{{ asset('news/js/jquery.colorbox.js') }}"></script>
    <!-- Isotope -->
    <script type="text/javascript" src="{{ asset('news/js/isotope.js') }}"></script>
    <script type="text/javascript" src="{{ asset('news/js/ini.isotope.js') }}"></script>
    <script>
        $(window).on('load', function() {
            $AdCount = 0;
            $('.ads_countiner').each(function(i, obj) {
                $AdCount = i + 1;

            });
            $RandomID = Math.floor(Math.random() * ($AdCount - 1 + 1) + 1)
            $('#adds_' + $RandomID).removeClass('nested');
        });

        $('#search_input').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {

                window.location.replace($('#searchpagesrc').val() + $('#search_input').val());
            }
        });
    </script>
    <!-- Template custom -->
    <script type="text/javascript" src="{{ asset('news/js/custom.js') }}"></script>

    </div><!-- Body inner end -->
</body>

</html>
