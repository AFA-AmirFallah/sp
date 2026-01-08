<!DOCTYPE html>
<html lang="fa" dir="rtl" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \App\myappenv::CenterName }}</title>

    <!-- manifest meta -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/Theme9/assets/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="/Theme9/assets/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/Theme9/assets/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="/Theme9/assets/vendor/swiperjs-6.6.2/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="/Theme9/assets/css/style.css" rel="stylesheet" id="style">
    <link rel="stylesheet" href="/Theme9/assets/fonts/vazir/Farsi-Digits/Vazirmatn-FD-font-face.css">
    <link rel="stylesheet" href="/Theme9/assets/css/custom_rtl.css">
</head>

<body dir="rtl" class="body-scroll rtl" data-page="index">

    <!-- loader section -->
    <div class="container-fluid loader-wrap">
        <div class="row h-100">
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto text-center align-self-center">
                <div class="loader-cube-wrap mx-auto">
                    <div class="loader-cube1 loader-cube"></div>
                    <div class="loader-cube2 loader-cube"></div>
                    <div class="loader-cube4 loader-cube"></div>
                    <div class="loader-cube3 loader-cube"></div>
                </div>
                <p>در حال بارگزاری!<br><strong>لطفاً صبور باشید...</strong></p>
            </div>
        </div>
    </div>
    <!-- loader section ends -->

    <!-- Sidebar main menu -->
    <div class="sidebar-wrap  sidebar-overlay">
        <!-- Add pushcontent or fullmenu instead overlay -->
        <div class="closemenu text-muted">بستن منو</div>
        <div class="sidebar">
            <div class="row">
                <div class="col-auto mx-auto text-center">
                    <figure class="avatar avatar-120 rounded-circle mx-auto mb-3">
                        <img src="" alt="">
                    </figure>
                    <h6 class="mb-1">{{ Auth::user()->Name }} - {{ Auth::user()->Family }} </h6>
                    {{-- <p class="text-muted">ایران ، مشهد</p> --}}
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-house-door"></i></div>
                                <div class="col">داشبورد</div>
                                <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                            </a>
                        </li>

                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                aria-expanded="false">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-shop"></i></div>
                                <div class="col">فروشگاه</div>
                                <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item nav-link" href="shop.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-bag"></i></div>
                                        <div class="col">صفحه اصلی فروشگاه</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="product.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-binoculars"></i>
                                        </div>
                                        <div class="col">محصول</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="cart.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-basket3"></i></div>
                                        <div class="col">سبد خرید</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="payment.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-credit-card"></i>
                                        </div>
                                        <div class="col">پرداخت</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="my-orders.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-box-seam"></i>
                                        </div>
                                        <div class="col">سفارشات من</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                            </ul>
                        </li> --}}
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                role="button" aria-expanded="false">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar-check"></i></div>
                                <div class="col">لیست TODO</div>
                                <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item nav-link" href="task.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar2"></i>
                                        </div>
                                        <div class="col">صفحه اصلی TODO</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="taskcalander.html">
                                        <div class="avatar avatar-40 rounded icon"><i
                                                class="bi bi-calendar-check"></i></div>
                                        <div class="col">تقویم وظایف</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="todaystask.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar-date"></i>
                                        </div>
                                        <div class="col">وظایف امروز</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="events.html">
                                        <div class="avatar avatar-40 rounded icon"><i
                                                class="bi bi-calendar-event"></i></div>
                                        <div class="col">رویدادها</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="event-details.html">
                                        <div class="avatar avatar-40 rounded icon"><i
                                                class="bi bi-calendar2-day-fill"></i></div>
                                        <div class="col">جزئیات رویداد</div>
                                        <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                                    </a></li>

                            </ul>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="chat.html" tabindex="-1" aria-disabled="true">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-chat-text"></i></div>
                                <div class="col">پروفایل</div>
                                <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('add_file') }}" tabindex="-1" aria-disabled="true">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-bell"></i></div>
                                <div class="col">ثبت آگهی</div>
                                <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('deal_search') }}" tabindex="-1" aria-disabled="true">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-gear"></i></div>
                                <div class="col">آگهی های من</div>
                                <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div class="col">بیمه</div>
                                <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" tabindex="-1" aria-disabled="true">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-box-arrow-right"></i></div>
                                <div class="col">خروج</div>
                                <div class="arrow"><i class="bi bi-arrow-left"></i></div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar main menu ends -->

    <!-- Begin page -->
    <main class="h-100 has-header has-footer">

        <!-- Header -->
        <header class="container-fluid header">
            <div class="row">
                <div class="col-auto">
                    <button type="button" class="btn btn-link menu-btn">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="col pl-0">
                    <div class="form-group search-header">
                        <input class="form-control border-0" placeholder="جستجو">
                        <button type="button" class="btn btn-link tooltip-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-auto align-self-center">
                    <a href="profile.html" class="position-relative d-block ml-3">
                        <span
                            class="position-absolute top-0 end-75  translate-middle badge border border-light rounded-circle bg-danger p-1 mt-2 ml-2"><span
                                class="visually-hidden">پیام های خوانده نشده</span></span>
                        <figure class="avatar avatar-36 rounded-circle">
                            <img src="/Theme9/assets/img/user1.jpg" alt="">
                        </figure>
                    </a>
                </div>
            </div>
        </header>
        <!-- Header ends -->

        <!-- main page content -->
        @yield('content')

        <!-- main page content ends -->


    </main>
    <!-- Page ends-->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        <span>
                            <i class="nav-icon bi bi-house"></i>
                            <span class="nav-text">خانه</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="stats.html">
                        <span>
                            <i class="nav-icon bi bi-laptop"></i>
                            <span class="nav-text">آمار</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pinned.html">
                        <span>
                            <i class="nav-icon bi bi-bookmarks"></i>
                            <span class="nav-text">پین شده</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="style.html">
                        <span>
                            <i class="nav-icon bi bi-palette"></i>
                            <span class="nav-text">استایل</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.html">
                        <span>
                            <i class="nav-icon bi bi-person"></i>
                            <span class="nav-text">پروفایل</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- Footer ends-->




    <!-- Required jquery and libraries -->
    <script src="/Theme9/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/Theme9/assets/js/popper.min.js"></script>
    <script src="/Theme9/assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- cookie js -->
    <script src="/Theme9/assets/js/jquery.cookie.js"></script>

    <!-- Customized jquery file  -->
    <script src="/Theme9/assets/js/main.js"></script>
    <script src="/Theme9/assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <script src="/Theme9/assets/js/pwa-services.js"></script>


    <!-- Progress circle js script -->
    <script src="/Theme9/assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="/Theme9/assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>

    @yield('page-js')

</body>



</html>
