<style>
    @keyframes placeHolderShimmer {
        0% {
            background-position: -800px 0
        }

        100% {
            background-position: 800px 0
        }
    }

    @media only screen and (min-width: 768px) {
        .sticky-content-wrapper {
            display: none !important;
        }


    }

    @media only screen and (max-width: 768px) {
        .topbar-left {
            margin-left: -16px;
        }

        .button,
        .btn-menu {
            display: none !important;
        }

        .footer_items {
            margin-bottom: 40px;
        }

    }

    .sticky-link-active {
        color: #336666 !important;
        font-weight: 900;
    }

    .sticky-content-wrapper {
        background-color: white;
        bottom: 0px;
        z-index: 1051;
        position: fixed;
        right: 0;
        left: 0;
        opacity: 1;
        direction: rtl;
        transform: translateY(0);

        box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.1);
    }

    .sticky-link {
        color: #336666;
    }

    .sticky-content.fixed55 {
        display: inline-flex;

    }

    .list-group-item-spm {
        color: #f44336;
        background-color: white;
    }

    .sticky-content {
        text-align: center;

    }

    .animated-background {
        color: transparent !important;
        animation-duration: 2s;
        animation-fill-mode: forwards;
        animation-iteration-count: infinite;
        animation-name: placeHolderShimmer;
        animation-timing-function: linear;
        background-color: #f6f7f8;
        background: linear-gradient(to right, #eeeeee 8%, #bbbbbb 18%, #eeeeee 33%);
        background-size: 800px 104px;
        height: 70px;
        position: relative;
    }

    .steps_icon i {
        margin-left: 5px;
        margin-right: 4px;
        font-size: 17px;
    }

    .steps_icon p {
        margin: 0px;
        padding-left: 6px;
        padding-right: 6px;
    }

    .steps_icon {
        color: white;
        display: inline-flex;
        border-style: solid;
        border-radius: 11px;
        border-width: 1px;
        background-color: #f44336;

    }

    .add-to-card {
        left: 10px;
        position: absolute;
        bottom: 0px;
    }

    .add-to-card button {
        background-color: transparent;
        border-color: #336666;
        border-style: double;
        color: #336666;
        border-style: none;
        font-size: 24px;
    }

    .product_title {
        display: block;
        font-weight: 500;
    }

    .lader {
        width: fit-content;
        border-color: darkgray;
        border-width: 2px;
        border-radius: 8px;
        padding: 4px;
        border: 0.1rem solid rgba(35, 71, 251, 0.12);
        margin-bottom: 1.2rem;
        color: blue;
        font-weight: 600;
    }

    .lader i {
        font-weight: 400;
    }

    .discount label {
        background-color: #f44336;
        color: white;
        border-radius: 10px;
        width: 42px;
        padding: 2px 6px 0px 6px;
        font-size: 16px;
        font-weight: 500;
    }

    .discount del {
        margin-right: 4px;
        font-size: 16px;
        font-weight: 600;
    }

    .add-to-card {
        left: 10px;
        bottom: 18px;
        position: absolute;
    }

    .add-to-card button {
        background-color: transparent;
        border-color: #336666;
        border-style: double;
        color: #336666;
        font-size: 26px;
        border-style: none;
    }

    .discount strong {}

    .jdRqnI {
        display: flex;
    }

    .single-product-card {
        border-style: solid;
        border-width: 1px;
        border-color: #ccd2d7;
    }

    .prices-row {
        display: flex;
    }

    .prices-table {
        border-style: solid;
        border-radius: 5px;
        text-align: center;
    }

    .table {
        display: table;
        width: 100%
    }

    .tr {
        display: table-row;
        text-align: center;
    }

    .td {
        display: table-cell;
        border: 1px solid #ccc;
        padding: 5px;

    }

    .th {
        display: table-cell;
        border: 1px solid #ccc;
        padding: 5px;
        font-weight: 600;
    }

    .step-number {
        border-style: hidden;
        background-color: transparent;
        text-align: center;
    }

    .step_btn {
        border-radius: 50%;
        padding: 10px;
        padding-top: 15px;
        width: 40px;
        height: 40px;
        text-align: center;
    }

    .main-price-box {
        padding-top: 1.4rem;
        margin-top: 0.2rem;
    }

    .pic-holder {
        border-style: solid;
        border-width: 0 0 0 1px;
        border-color: #ccc;
    }

    .swiper-full {
        width: 100%;
    }

    .swiper-full img {
        border-radius: 20px;
        width: 100%;
        margin: 0 0 15px 0;
    }

    .fast_img {
        width: -webkit-fill-available;
    }



    @media (max-width: 768px) {
        .pic-holder {
            border-style: none;

        }

        .tr {
            display: block;
            float: right;
            width: 50%;
            text-align: center;

        }

        .th {
            display: block;
        }

        .td {
            display: block;
        }
    }
</style>
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f44336">
    <meta name="msapplication-navbutton-color" content="#f44336">
    <meta name="apple-mobile-web-app-status-bar-style" content="#f44336">
    @hasSection('MainTitle')
        <title>@yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif
    <meta name="keywords" content="{{ \App\myappenv::CenterName }}">
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
    @hasSection('OG')
        @yield('OG')
    @endif
    @hasSection('ExtraTags')
        @yield('ExtraTags')
    @endif
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">
    @yield('before-css')
    @hasSection('ExtraTags')
        @yield('ExtraTags')
    @endif
    <link rel="stylesheet" href="/storage/sepehrmall-css/css/main.css">
    <link rel="stylesheet" href="/storage/sepehrmall-css/css/sepehrmall.css">
    @vite(['resources/js/app.js'])
    {!! \App\myappenv::googlealaliticscr !!}
    {!! \App\myappenv::Yektanet !!}
    @yield('page-css')
</head>


<style>
    .fast-buy-btn-new:hover {
        background-color: #336666 !important;
        color: white !important;
    }

    .fast-buy-btn-new {
        height: 40px;
        width: 40px;
        border-color: #336666 !important;
        border-style: groove !important;
        border-width: 1px;
    }

    .fast-buy-div-new {
        border-style: none;
    }

    .fast-buy-i-new {
        padding: 0px 1px 0px 1px;
        font-size: 19px;
    }

    .steps_discount {
        position: absolute;
        top: 7px;
        font-size: 12px;
        padding: 2px 6px 2px 6px;
        color: white !important;
        background-color: #f44336;
        display: inline-flex;
        border-style: solid;
        border-radius: 11px;
        border-width: 1px;
        z-index: 2;
    }

    .swal2-html-container {
        direction: rtl;
    }
</style>



<body>
    <div id="main_spm_loader">
        <div class="loader-container">
            <div class="flipping-cards">
                <div class="card">N</div>
                <div class="card">O</div>
                <div class="card">V</div>
                <div class="card">I</div>
                <div class="card">N</div>
                <div class="card">H</div>
                <div class="card">O</div>
                <div class="card">S</div>
                <div class="card">P</div>
                <div class="card">I</div>
                <div class="card">T</div>
                <div class="card">A</div>
                <div class="card">L</div>
            </div>
        </div>
    </div>

    <div style="direction: rtl;" class="modal fade" id="product_fast_show" tabindex="-1"
        aria-labelledby="product_fast_show_Label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div id="fast_buy_modal_content" class="modal-content">

            </div>
        </div>
    </div>
    <div class="wrapper">
        <!-- Start header -->
        <header class="main-header">
            <!-- Start ads -->
            {!! App\Functions\AppSetting::get_html_obj('Theme5_header_ads') !!}

            <!-- End ads -->
            <!-- Start topbar -->
            <div  class="container main-container">
                <div class="topbar dt-sl">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="logo-area">
                                <!-- best size 128 X 36 -->
                                <a href="{{ \App\myappenv::brandlink }}">
                                    <img style="max-height: 38px;margin-right:11px " src="{{ \App\myappenv::Sitelogo }}"
                                        alt="{{ \App\myappenv::CenterName }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-5 hidden-sm" style="max-height: 36px;margin-top:7px;width:30px ">
                            <div class="search-area dt-sl">
                                <form id="main_search_form" action="/search" method="get" style="max-height: 30px"
                                    class="search">
                                    <input name="q" id="search_input" type="text"
                                        placeholder="نام کالا، برند و یا دسته مورد نظر خود را جستجو کنید…">
                                    <i onclick="do_search()" class="far fa-search search-icon"></i>
                                    <button class="close-search-result" onclick="celar_search()" type="button"><i
                                            style="font-size: 24px;position: absolute;margin-top: -17px;margin-right: -12px;" class="mdi mdi-close"></i></button>

                                </form>
                            </div>
                        </div>
                        <script>
                            function celar_search() {
                                $('#search_input').val('');
                            }

                            function do_search() {
                                $('#main_search_form').submit();
                            }
                        </script>
                        <div style="display: flex;left: 10px;position: fixed;">

                            @if (Auth::check())
                                <div class="col-md-4 col-6 topbar-left "
                                    style="
                                margin-top: -8px;
                            ">
                                    <ul class="nav">
                                        <li style="border-style: none;margin-left: 10px;"
                                            class="nav-item account dropdown">
                                            <a class="nav-link" style="display: flex;margin-top: 3px" href="#"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i style="font-size: 28px" class="mdi mdi-account-outline "></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-left">

                                                <a class="dropdown-item" href="{{ route('UserProfile') }}">
                                                    <i style="font-size: 24px" class="mdi mdi-edit-outline"></i>
                                                    @if ((Auth::user()->Name == Auth::user()->Family) == Auth::user()->MobileNo)
                                                        <div class="text-warning">ثبت نام ناقص</div>
                                                    @else
                                                        <div>{{ Auth::user()->Name }} {{ Auth::user()->Family }}
                                                        </div>
                                                    @endif

                                                </a>
                                                <a class="dropdown-item" href="{{ route('UserProfile') }}">
                                                    <i style="font-size: 24px" class="mdi mdi-edit-outline"></i>
                                                    <div>ویرایش حساب کاربری </div>

                                                </a>
                                                <div class="dropdown-divider" role="presentation"></div>
                                                @if (Auth::user()->Role == \App\myappenv::role_admin || Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                                    <a class="dropdown-item"
                                                        href="{{ route('changeview', ['Target' => 'Dashboard']) }}">
                                                        <i style="font-size: 24px"
                                                            class="mdi mdi-account-card-details-outline"></i>
                                                        <div
                                                            style="
                                                            padding-top: 8px;
                                                        ">
                                                            داشبورد
                                                            مدیریت
                                                        </div>

                                                    </a>
                                                @endif
                                                <a class="dropdown-item" href="{{ route('logout') }}">
                                                    <i style="font-size: 24px" class="mdi mdi-logout-variant"></i>
                                                    <div
                                                        style="
                                                    padding-top: 8px;
                                                ">
                                                        خروج
                                                    </div>

                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <div class="col-md-4 col-6 topbar-left" style="margin-top: -8px;">
                                    <ul style="margin-left: 20px" class="nav ">
                                        <li style="border-style: none" class="nav-item account dropdown">
                                            <a class="nav-link" style="margin-top: 3px" href="{{ route('login') }}">
                                                <span class="label-dropdown"></span>
                                                <i style="font-size: 28px" class="mdi mdi-account-outline "></i>
                                            </a>

                                        </li>
                                    </ul>
                                </div>
                            @endif
                            @include('Layouts.Theme5.objects.mian_basket')
                        </div>

                    </div>
                </div>
            </div>
            <!-- End topbar -->

            <!-- Start bottom-header -->
            <div class="bottom-header dt-sl mb-sm-bottom-header">
                <div class="container main-container">
                    <!-- Start Main-Menu -->
                    <nav class="site-menu main-menu d-flex justify-content-md-between justify-content-end dt-sl">
                        <ul class="list hidden-sm">
                            <li class="list-item category-list">
                                <a href="#"><i class="fal fa-bars ml-1"></i>دسته بندی کالاها</a>
                                
                                {!! App\Functions\CacheData::get_theme_options('Theme6_top_menu') !!}

                            </li>
                            <!-- mega menu 3 column -->
                            <li class="list-item ">
                                <a class="nav-link" href="{{ route('home') }}"> صفحه اصلی</a>
                            </li>

                            <li class="list-item">
                                <a class="nav-link" href="{{ route('ShowProduct') }}">همه محصولات</a>
                            </li>
                        </ul>
                        <button class="btn-menu">
                            <div class="align align__justify">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                        <div class="side-menu">
                            <div class="logo-nav-res dt-sl text-center">
                                <a href="#">
                                    <img src="/Theme5/assets/img/logo.png" alt="">
                                </a>
                            </div>
                            <div class="search-box-side-menu dt-sl text-center mt-2 mb-3">
                                <form action="">
                                    <input type="text" name="s" placeholder="جستجو کنید...">
                                    <i class="mdi mdi-magnify"></i>
                                </form>
                            </div>
                            <ul class="navbar-nav dt-sl">
                                <li class="sub-menu">
                                    <a href="#">کالای دیجیتال</a>
                                    <ul>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو چهار</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">عنوان دسته</a>
                                        </li>
                                        <li>
                                            <a href="#">عنوان دسته</a>
                                        </li>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو چهار</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sub-menu">
                                    <a href="#">بهداشت و سلامت</a>
                                    <ul>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو چهار</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">عنوان دسته</a>
                                        </li>
                                        <li>
                                            <a href="#">عنوان دسته</a>
                                        </li>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو چهار</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sub-menu">
                                    <a href="#">ابزار و اداری</a>
                                    <ul>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو چهار</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">عنوان دسته</a>
                                        </li>
                                        <li>
                                            <a href="#">عنوان دسته</a>
                                        </li>
                                        <li class="sub-menu">
                                            <a href="#">عنوان دسته</a>
                                            <ul>
                                                <li>
                                                    <a href="#">زیر منو یک</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو دو</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو سه</a>
                                                </li>
                                                <li>
                                                    <a href="#">زیر منو چهار</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">مد و پوشاک</a>
                                </li>
                                <li>
                                    <a href="#">خانه و آشپزخانه</a>
                                </li>
                                <li>
                                    <a href="#">ورزش و سفر</a>
                                </li>
                            </ul>
                        </div>
                        <div class="overlay-side-menu">
                        </div>
                    </nav>
                    <!-- End Main-Menu -->
                </div>
            </div>
            <!-- End bottom-header -->
        </header>
        <!-- End header -->
        <!-- Start main-content -->

        @if (Route::current()->getName() != 'search')
            <form id="main_search_form" action="/search" method="get">
                <div class="col-lg-3 col-md-12 col-sm-12 sticky-sidebar filter-options-sidebar">
                    <div class="d-md-none">
                        <div style="margin-top: 10px;" class="header-filter-options">
                            <span style="margin-top: 8px;font-size: 16px;font-weight: 800;">جستجوی محصولات</span>
                            <button type="button" class="btn-close-filter-sidebar add-to-card buy_new"
                                data-dismiss="modal" aria-label="Close"
                                style="border-style: none;background-color: transparent;box-shadow: none;top: 5px;left: 11px;">
                                <i style="font-size: 27px;" class="mdi mdi-close-circle-outline"></i>
                            </button>
                        </div>
                    </div>
                    <div style="margin-top: 20px" class="dt-sn dt-sn--box mb-3">
                        <form action="">
                            <div class="col-12 mb-3">
                                <div class="widget-search">
                                    <input type="text" name="q"
                                        placeholder="نام کالا یا برند مورد نظر را در  بیمارستان مجازی  جستجو کنید">
                                    <button class="btn-search-widget">
                                        <img src="/Theme5/assets/img/theme/search.png" alt="">
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </form>
        @endif

        @yield('content')
        <!-- End main-content -->
        <!-- Start footer -->
        <div class="sticky-content-wrapper">
            <button id="advnace_search_btn" class="d-none btn-filter-sidebar">
                جستجوی پیشرفته <i class="fad fa-sliders-h"></i>
            </button>
            <div class="col-12 sticky-footer sticky-content fix-bottom fixed55">
                <div class="col-3 ">
                    <a href="{{ route('home') }}" class="sticky-link-active">
                        <i style="font-size: 24px" class="mdi mdi-home-outline"></i>
                        <p>خانه</p>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{ route('ProductCat') }}" class="sticky-link">
                        <i style="font-size: 24px" class="mdi mdi-apps"></i>
                        <p>دسته‌بندی</p>
                    </a>
                </div>
                <div class="col-3">
                    <div onclick="search_a()" class="sticky-link">
                        <i style="font-size: 24px" class="mdi mdi-magnify"></i>
                        <p>جستجو</p>
                    </div>

                </div>
                <div class="col-3">
                    <a href="{{ route('ShowProduct') }}" class="sticky-link">
                        <i style="font-size: 24px" class="mdi mdi-store"></i>
                        <p>فروشگاه</p>
                    </a>
                </div>
            </div>
        </div>
        <script>
            function search_a() {
                $('#advnace_search_btn').click();
            }
        </script>
        <footer class="main-footer dt-sl">

            <div class="description">
                <div class="container main-container">
                    <div class="row">
                        <div class="footer_items col-12 col-lg-3">
                            <ul class="list-group">
                                <li id="about_sec" onclick="open_sub_menu('#about_sec')"
                                    class="list-group-item list-group-item-primary"
                                    style="text-align:center;display: ruby;color: black;background-color:white">
                                    <div style="color: #f44336" id="about_sec_icon_o">
                                        <i class="mdi mdi-chevron-double-down"></i>
                                    </div>
                                    درباره فروشگاه بیمارستان مجازی
                                    <div style="color: #f44336" id="about_sec_icon_e">
                                        <i class="mdi mdi-chevron-double-down"></i>
                                    </div>

                                </li>
                                <ul id="about_sec_list" class="list-group d-none sub_menue_cus">
                                    <li class="list-group-item list-group-item-spm">نقشه سایت</li>
                                    <li class="list-group-item list-group-item-spm">تماس با ما</li>
                                    <li class="list-group-item list-group-item-spm">جستجو</li>
                                    <li class="list-group-item list-group-item-spm">محصولات جدید</li>
                                    <li class="list-group-item list-group-item-spm">درباره بیمارستان مجازی</li>
                                </ul>
                                <li id="manaul_buy"
                                    style="text-align:center;display: ruby;color: black;background-color:white"
                                    onclick="open_sub_menu('#manaul_buy')"
                                    class="list-group-item list-group-item-primary">
                                    <div style="color: #f44336" id="manaul_buy_icon_o">
                                        <i class="mdi mdi-chevron-double-down"></i>
                                    </div>
                                    راهنمای خرید از بیمارستان مجازی
                                    <div style="color: #f44336" id="manaul_buy_icon_e">
                                        <i class="mdi mdi-chevron-double-down"></i>
                                    </div>
                                </li>
                                <ul id="manaul_buy_list" class="list-group d-none sub_menue_cus">
                                    <li class="list-group-item list-group-item-spm">نحوه ثبت سفارش</li>
                                    <li class="list-group-item list-group-item-spm">رویه ارسال سفارش</li>
                                    <li class="list-group-item list-group-item-spm">شیوه‌های پرداخت</li>
                                    <li class="list-group-item list-group-item-spm">رویه‌های بازگرداندن کالا</li>
                                    <li class="list-group-item list-group-item-spm">قوانین و مقررات</li>
                                </ul>
                            </ul>

                        </div>
                        <script>
                            function open_sub_menu(object) {

                                icon_val = jQuery.trim($(object + '_icon_o').html());
                                if (icon_val == `<i class="mdi mdi-chevron-double-down"></i>`) { // to open
                                    $('.sub_menue_cus').addClass('d-none');
                                    $(object + '_list').removeClass('d-none');
                                    $(object + '_icon_o').html(`<i class="mdi mdi-chevron-double-up"></i>`);
                                    $(object + '_icon_e').html(`<i class="mdi mdi-chevron-double-up"></i>`);
                                } else { // to close
                                    $('.sub_menue_cus').addClass('d-none');
                                    $(object + '_icon_o').html(`<i class="mdi mdi-chevron-double-down"></i>`);
                                    $(object + '_icon_e').html(`<i class="mdi mdi-chevron-double-down"></i>`);
                                }
                            }
                        </script>
                        <div class="footer_items site-description col-12 col-lg-7">
                            <h1 class="site-title">فروشگاه اینترنتی بیمارستان مجازی</h1>
                            <p style="text-align: right">
                                فروشگاه اینترنتی بیمارستان مجازی فعالیت خود را از سال ۱۳۹۸ به عنوان تامین کننده مواد غذایی خارجی
                                و محصولات بهداشتی خارجی آغاز کرده است . هدف اصلی فروشگاه اینترنتی بیمارستان مجازی ارائه محصولات
                                اصل خارجی با بهترین قیمت و بیشترین تاریخ مصرف است و نهایتا رضایت مشتری است . ما در
                                فروشگاه اینترنتی بیمارستان مجازی هدف خود را ارائه بهترین محصولات به مشتریان محترم قرارداده ایم
                                به طوری که برای هر سلیقه ای محصولی متفاوت در این فروشگاه اینرنتی وجود داشته باشد . از
                                دیگر اهداف ما در این مجموعه ارائه محصولات خارجی متنوع به صورت بدون واسطه و با قیمتی
                                کاملا رقابتی است
                            </p>
                        </div>

                        <div style="margin-top: -8px" class="footer_items symbol col-12 col-lg-2">
                            <a href="https://trustseal.enamad.ir/?id=165551&amp;Code=cfiJIMiNkgcF4gxAlllc"
                                referrerpolicy="origin"
                                src="https://Trustseal.eNamad.ir/logo.aspx?id=165551&amp;Code=cfiJIMiNkgcF4gxAlllc"
                                target="_blank"><img src="/Theme5/assets/img/symbol-02.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div class="container main-container">
                    <p>
                        استفاده از مطالب فروشگاه اینترنتی بیمارستان مجازی فقط برای مقاصد غیرتجاری و با ذکر منبع بلامانع است.
                        کلیه حقوق این سایت متعلق
                        (فروشگاه آنلاین بیمارستان مجازی) می‌باشد.
                    </p>
                </div>
            </div>
        </footer>
        <!-- End footer -->
    </div>
    <!-- Core JS Files -->
    @yield('start_script')
    <script src="/storage/sepehrmall-css/js/main.js"></script>
    <script src="/storage/sepehrmall-css/js/sepehrmall.js"></script>

    @php
        $goftino_main = App\Functions\CacheData::GetSetting('goftino_id');

        $app_version = App\myappenv::version;
        if ($app_version < 3) {
            $goftino_branch = App\Functions\CacheData::GetSetting('goftino_id');
        } else {
            $goftino_branch = App\branchenv::getenv('center_goftino');
        }
    @endphp

    @if ($app_version < 3)

        @if ($goftino_main && $user_role < App\myappenv::role_SuperAdmin)
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
    @else
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

    @endif

    @yield('end_script')
</body>

</html>
