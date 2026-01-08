<!DOCTYPE html>
<html lang="fa" class="light-style" dir="rtl" data-theme="theme-default" data-assets-path="/T1assets/"
    data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    @hasSection('MainTitle')
        <title>@yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif
    @hasSection('description')
        <meta name="description" content="@yield('description')">
    @else
        <meta name="description" content="{{ \App\myappenv::description }}">
    @endif


    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ \App\myappenv::FavIcon }}">
    <link rel="apple-touch-icon" href="{{ \App\myappenv::FavIcon }}">

    @hasSection('ExtraTags')
        @yield('ExtraTags')
    @endif
    <!-- Icons -->
    <link rel="stylesheet" href="/T1assets/vendor/fonts/boxicons.css">
    <link rel="stylesheet" href="/T1assets/vendor/fonts/fontawesome.css">
    <link rel="stylesheet" href="/T1assets/vendor/fonts/flag-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="/T1assets/vendor/css/rtl/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="/T1assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css">
    <link rel="stylesheet" href="/T1assets/css/demo.css">
    <link rel="stylesheet" href="/T1assets/vendor/css/rtl/rtl.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/T1assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/apex-charts/apex-charts.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/spinkit/spinkit.css">
    <link rel="canonical" href="{{ url()->current() }}">



    <!-- Page CSS -->
    @yield('PageCSS')
    <!-- Helpers -->
    @vite(['resources/js/app.js'])
    <script src="/T1assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/T1assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/T1assets/js/config.js"></script>
    {!! \App\myappenv::googlealaliticscr !!}
    {!! \App\myappenv::Yektanet !!}
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->

            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-xxl">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                        <a href="{{ route('home') }}" class="app-brand-link gap-2">

                            <img style="width: 50px" src="{{ \App\myappenv::MainIcon }}"
                                alt="{{ \App\myappenv::CenterName }}">
                            <span class="app-brand-text demo menu-text fw-bold">{{ \App\myappenv::CenterName }}</span>
                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i class="bx bx-x bx-sm align-middle"></i>
                        </a>
                    </div>

                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Search -->
                            <li class="nav-item navbar-search-wrapper me-2 me-xl-0">
                                <a class="nav-item nav-link search-toggler" href="javascript:void(0);">
                                    <i class="bx bx-search bx-sm"></i>
                                </a>
                            </li>
                            <!-- /Search -->

                            <!-- Style Switcher -->

                            <li class="nav-item me-2 me-xl-0">
                                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                                    <i class="bx bx-sm"></i>
                                </a>
                            </li>
                            <!--/ Style Switcher -->



                            <!-- Notification -->
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="bx bx-bell bx-sm"></i>
                                    <span class="badge bg-success rounded-pill badge-notifications">0</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end py-0">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h5 class="text-body mb-0 me-auto secondary-font">اعلان‌ها</h5>
                                            <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="علامت خوانده شده به همه"><i
                                                    class="bx fs-4 bx-envelope-open"></i></a>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container">
                                        <ul class="list-group list-group-flush">

                                        </ul>
                                    </li>
                                    <li class="dropdown-menu-footer border-top">
                                        <a href="javascript:void(0);"
                                            class="dropdown-item d-flex justify-content-center p-3">
                                            اعلانی وجود ندارد
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ Notification -->
                            @if (Auth::check())
                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown">

                                        @if (Auth::user()->avatar == null)
                                            <div class="avatar me-2 avatar-online">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-success">{{ Str::substr(Auth::user()->Name, 0, 1) }}
                                                    {{ Str::substr(Auth::user()->Family, 0, 1) }}</span>
                                            </div>
                                        @else
                                            <div class="avatar avatar-online">
                                                <img src="{{ Auth::user()->avatar }} " alt="avatar"
                                                    class="rounded-circle">
                                            </div>
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        @if (Auth::user()->avatar == null)
                                                            <div class="avatar me-2 ">
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-success">{{ Str::substr(Auth::user()->Name, 0, 1) }}
                                                                    {{ Str::substr(Auth::user()->Family, 0, 1) }}</span>
                                                            </div>
                                                        @else
                                                            <div class="avatar ">
                                                                <img src="{{ Auth::user()->avatar }} " alt="avatar"
                                                                    class="rounded-circle">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-semibold d-block lh-1">
                                                            {{ Auth::user()->Name }}
                                                            {{ Auth::user()->Family }} </span>
                                                        <small>کاربر</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('myprofile') }}">
                                                <i class="bx bx-user me-2"></i>
                                                <span class="align-middle">پروفایل من</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('cryptoAccount') }}">
                                                <i class="bx bx-cog me-2"></i>
                                                <span class="align-middle">تنظیمات</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-account-settings-billing.html">
                                                <span class="d-flex align-items-center align-middle">
                                                    <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                                    <span class="flex-grow-1 align-middle">صورتحساب</span>
                                                    <span
                                                        class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">0</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-help-center-landing.html">
                                                <i class="bx bx-support me-2"></i>
                                                <span class="align-middle">راهنمایی</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-faq.html">
                                                <i class="bx bx-help-circle me-2"></i>
                                                <span class="align-middle">سوالات متداول</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-pricing.html">
                                                <i class="bx bx-dollar me-2"></i>
                                                <span class="align-middle">قیمت گذاری</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" target="_blank">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">خروج</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <a class="footer-link fw-semibold" href="{{ route('login') }}">ورود/ثبت نام</a>

                            @endif
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
                        <input type="text" class="form-control search-input border-0" placeholder="جستجو ..."
                            aria-label="Search...">
                        <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                    </div>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    <aside id="layout-menu"
                        class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
                        <div class="container-xxl d-flex h-100">
                            <ul class="menu-inner">
                                {!! App\Functions\AppSetting::get_html_obj('Theme2_TopMenu') !!}
                            </ul>
                        </div>
                    </aside>
                    <!-- / Menu -->

                    <!-- Content -->
                    @include('Layouts.ErrorHandler')
                    @yield('Content')
                    @yield('MainContent')
                    <!--/ Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                طراحی شده با ❤️ توسط تیم
                                <a href="https://dgkar.com" target="_blank" class="footer-link fw-semibold">دیجی
                                    کار</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    @yield('BeginScripts')
    <!---start GOFTINO code--->
    @if (App\myappenv::MainOwner != 'arzonline')
        <script type="text/javascript">
            ! function() {
                var i = "fDFqGs",
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
    <!---end GOFTINO code--->
    <script>
        function number_format(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
    <script src="/T1assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/T1assets/vendor/libs/popper/popper.js"></script>
    <script src="/T1assets/vendor/js/bootstrap.js"></script>
    <script src="/T1assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/T1assets/vendor/libs/hammer/hammer.js"></script>

    <script src="/T1assets/vendor/libs/i18n/i18n.js"></script>
    <script src="/T1assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="/T1assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/T1assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/T1assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/T1assets/js/dashboards-ecommerce.js"></script>
    <!-- Vendors JS -->
    <script src="/T1assets/vendor/libs/toastr/toastr.js"></script>



    <!-- Page JS -->
    <script src="/T1assets/js/ui-toasts.js"></script>
    @yield('EndScripts')
</body>

</html>
