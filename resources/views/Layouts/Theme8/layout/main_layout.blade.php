@php
    if (Auth::check()) {
        $user_role = Auth::user()->Role;
    } else {
        $user_role = 0;
    }

@endphp
<!DOCTYPE html>
<html lang="fa" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    @if (View::hasSection('page-title'))
        <title> @yield('page-title')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ \App\myappenv::CenterName }}">
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">
    <meta name="description" content="{{ \App\myappenv::description }}">

    <link rel="shortcut icon" href="{{ \App\myappenv::FavIcon }}" type="image/x-icon">
    <link rel="icon" href="{{ \App\myappenv::FavIcon }}" type="image/x-icon">
    <!-- Latest compiled and minified CSS -->
    @vite(['resources/js/app.js'])

    @yield('before-css')
    <link rel="stylesheet" href="/Theme8/assets/css/bootstrap.min.css">
    <script src="/Theme8/assets/js/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="/Theme8/assets/css/swiper-bundle.min.css">

    <link rel="stylesheet" href="/Theme8/assets/css/style.css">
    {!! \App\myappenv::googlealaliticscr !!}
    {!! \App\myappenv::Yektanet !!}
    @yield('page-css')

    <!-- jQuery library -->
    <script src="/Theme8/assets/js/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="/Theme8/assets/js/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="/Theme8/assets/js/bootstrap.min.js"></script>


    <!--my stlyes-->



</head>

<body>

    <section class="navigation mb-4">
        <div class="container">


            <div class="d-xl-none">
                @if (!Auth::check())
                    <div class="d-flex align-items-center justify-content-end pt-3 mb-2">
                        <a href="{{ route('login') }}" class="btn-lang">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.8971 11.4156C14.6201 10.2377 15.0019 8.8822 15 7.50014V7.49987C15.0019 6.11779 14.6201 4.76231 13.8971 3.58442L13.893 3.57799C13.2222 2.48474 12.2823 1.58176 11.1631 0.955346C10.0438 0.32893 8.78265 5.24122e-06 7.50003 0C6.21741 -5.2411e-06 4.95622 0.32891 3.83696 0.955316C2.71771 1.58172 1.77779 2.48469 1.10703 3.57793L1.10286 3.58445C0.381657 4.76315 5.35321e-06 6.11814 0 7.49998C-5.3531e-06 8.88182 0.381635 10.2368 1.10283 11.4155L1.10707 11.4221C1.77784 12.5154 2.71775 13.4183 3.837 14.0447C4.95624 14.6711 6.21742 15 7.50003 15C8.78264 15 10.0438 14.6711 11.1631 14.0447C12.2823 13.4183 13.2222 12.5153 13.893 11.4221L13.8971 11.4156ZM8.45868 13.7146C8.31576 13.8525 8.15126 13.9661 7.9717 14.0509C7.82431 14.121 7.66318 14.1573 7.5 14.1573C7.33682 14.1573 7.17569 14.121 7.0283 14.0509C6.68659 13.8764 6.39407 13.619 6.1775 13.3022C5.73519 12.6631 5.40741 11.9519 5.2088 11.2004C5.97176 11.1535 6.7355 11.1296 7.5 11.1287C8.26419 11.1287 9.02797 11.1526 9.79133 11.2004C9.6814 11.5868 9.54408 11.9649 9.38043 12.3317C9.16494 12.8477 8.85197 13.3172 8.45868 13.7146ZM0.85736 7.92135H3.88247C3.90217 8.76547 3.99367 9.60638 4.15597 10.435C3.32902 10.5078 2.50419 10.6077 1.68146 10.7348C1.19969 9.87047 0.918069 8.90902 0.85736 7.92135ZM1.68146 4.26519C2.50386 4.39263 3.32898 4.4926 4.15684 4.56509C3.99421 5.39363 3.90252 6.23453 3.88274 7.07866H0.85736C0.918065 6.09098 1.19969 5.12953 1.68146 4.26519ZM6.54132 1.28539C6.68424 1.14749 6.84873 1.03388 7.0283 0.949052C7.17569 0.879021 7.33682 0.842687 7.5 0.842687C7.66318 0.842687 7.82431 0.879021 7.9717 0.949052C8.31341 1.1236 8.60593 1.38101 8.8225 1.69776C9.2648 2.3369 9.59258 3.04809 9.79119 3.79955C9.02823 3.8465 8.2645 3.87042 7.5 3.8713C6.73582 3.87129 5.97204 3.84737 5.20866 3.79954C5.3186 3.41318 5.45592 3.03513 5.61957 2.66828C5.83506 2.15235 6.14803 1.68281 6.54132 1.28539ZM14.1426 7.07866H11.1175C11.0978 6.23454 11.0063 5.39362 10.844 4.56502C11.671 4.49225 12.4958 4.3923 13.3185 4.26518C13.8003 5.12953 14.0819 6.09098 14.1426 7.07866ZM5.00352 10.3695C4.83872 9.56324 4.74565 8.744 4.72539 7.92135H10.2747C10.2546 8.744 10.1617 9.56324 9.99707 10.3695C9.16563 10.3149 8.33327 10.2871 7.5 10.286C6.66734 10.286 5.83518 10.3138 5.00352 10.3695ZM9.99647 4.63053C10.1613 5.43676 10.2543 6.256 10.2746 7.07866H4.7253C4.74537 6.256 4.83828 5.43675 5.00292 4.63049C5.83437 4.68504 6.66673 4.71288 7.5 4.71399C8.33267 4.71399 9.16483 4.68617 9.99647 4.63053ZM11.1172 7.92135H14.1426C14.0819 8.90903 13.8003 9.87047 13.3185 10.7348C12.4961 10.6074 11.671 10.5074 10.8432 10.4349C11.0058 9.60637 11.0975 8.76547 11.1172 7.92135ZM12.8133 3.48957C12.0942 3.59331 11.373 3.67545 10.6497 3.73597C10.5197 3.25194 10.352 2.77883 10.1482 2.32095C9.96214 1.8996 9.72801 1.50115 9.45048 1.13354C10.7917 1.54487 11.9686 2.36946 12.8133 3.48957ZM2.79256 2.79256C3.56192 2.02246 4.50845 1.45284 5.54917 1.13364C5.53338 1.15409 5.51714 1.17363 5.50157 1.19451C4.96665 1.96456 4.577 2.82592 4.35186 3.7361C3.62847 3.67484 2.90676 3.59266 2.18673 3.48957C2.37243 3.2436 2.57485 3.01071 2.79256 2.79256ZM2.18672 11.5104C2.90576 11.4067 3.62696 11.3245 4.35031 11.264C4.48032 11.7481 4.64799 12.2212 4.85179 12.6791C5.03787 13.1004 5.27199 13.4988 5.54952 13.8665C4.20831 13.4551 3.03135 12.6305 2.18672 11.5104ZM12.2074 12.2074C11.4381 12.9775 10.4915 13.5472 9.45083 13.8664C9.46662 13.8459 9.48285 13.8264 9.49843 13.8055C10.0334 13.0354 10.423 12.1741 10.6482 11.2639C11.3715 11.3252 12.0933 11.4073 12.8133 11.5104C12.6276 11.7564 12.4252 11.9893 12.2074 12.2074Z"
                                    fill="white" />
                            </svg>
                            <span>
                                ورود
                            </span>
                        </a>
                    </div>
                @else
                <div class="d-flex align-items-center justify-content-end pt-3 mb-2">
                    <a href="{{ route('login') }}" class="btn-lang">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.8971 11.4156C14.6201 10.2377 15.0019 8.8822 15 7.50014V7.49987C15.0019 6.11779 14.6201 4.76231 13.8971 3.58442L13.893 3.57799C13.2222 2.48474 12.2823 1.58176 11.1631 0.955346C10.0438 0.32893 8.78265 5.24122e-06 7.50003 0C6.21741 -5.2411e-06 4.95622 0.32891 3.83696 0.955316C2.71771 1.58172 1.77779 2.48469 1.10703 3.57793L1.10286 3.58445C0.381657 4.76315 5.35321e-06 6.11814 0 7.49998C-5.3531e-06 8.88182 0.381635 10.2368 1.10283 11.4155L1.10707 11.4221C1.77784 12.5154 2.71775 13.4183 3.837 14.0447C4.95624 14.6711 6.21742 15 7.50003 15C8.78264 15 10.0438 14.6711 11.1631 14.0447C12.2823 13.4183 13.2222 12.5153 13.893 11.4221L13.8971 11.4156ZM8.45868 13.7146C8.31576 13.8525 8.15126 13.9661 7.9717 14.0509C7.82431 14.121 7.66318 14.1573 7.5 14.1573C7.33682 14.1573 7.17569 14.121 7.0283 14.0509C6.68659 13.8764 6.39407 13.619 6.1775 13.3022C5.73519 12.6631 5.40741 11.9519 5.2088 11.2004C5.97176 11.1535 6.7355 11.1296 7.5 11.1287C8.26419 11.1287 9.02797 11.1526 9.79133 11.2004C9.6814 11.5868 9.54408 11.9649 9.38043 12.3317C9.16494 12.8477 8.85197 13.3172 8.45868 13.7146ZM0.85736 7.92135H3.88247C3.90217 8.76547 3.99367 9.60638 4.15597 10.435C3.32902 10.5078 2.50419 10.6077 1.68146 10.7348C1.19969 9.87047 0.918069 8.90902 0.85736 7.92135ZM1.68146 4.26519C2.50386 4.39263 3.32898 4.4926 4.15684 4.56509C3.99421 5.39363 3.90252 6.23453 3.88274 7.07866H0.85736C0.918065 6.09098 1.19969 5.12953 1.68146 4.26519ZM6.54132 1.28539C6.68424 1.14749 6.84873 1.03388 7.0283 0.949052C7.17569 0.879021 7.33682 0.842687 7.5 0.842687C7.66318 0.842687 7.82431 0.879021 7.9717 0.949052C8.31341 1.1236 8.60593 1.38101 8.8225 1.69776C9.2648 2.3369 9.59258 3.04809 9.79119 3.79955C9.02823 3.8465 8.2645 3.87042 7.5 3.8713C6.73582 3.87129 5.97204 3.84737 5.20866 3.79954C5.3186 3.41318 5.45592 3.03513 5.61957 2.66828C5.83506 2.15235 6.14803 1.68281 6.54132 1.28539ZM14.1426 7.07866H11.1175C11.0978 6.23454 11.0063 5.39362 10.844 4.56502C11.671 4.49225 12.4958 4.3923 13.3185 4.26518C13.8003 5.12953 14.0819 6.09098 14.1426 7.07866ZM5.00352 10.3695C4.83872 9.56324 4.74565 8.744 4.72539 7.92135H10.2747C10.2546 8.744 10.1617 9.56324 9.99707 10.3695C9.16563 10.3149 8.33327 10.2871 7.5 10.286C6.66734 10.286 5.83518 10.3138 5.00352 10.3695ZM9.99647 4.63053C10.1613 5.43676 10.2543 6.256 10.2746 7.07866H4.7253C4.74537 6.256 4.83828 5.43675 5.00292 4.63049C5.83437 4.68504 6.66673 4.71288 7.5 4.71399C8.33267 4.71399 9.16483 4.68617 9.99647 4.63053ZM11.1172 7.92135H14.1426C14.0819 8.90903 13.8003 9.87047 13.3185 10.7348C12.4961 10.6074 11.671 10.5074 10.8432 10.4349C11.0058 9.60637 11.0975 8.76547 11.1172 7.92135ZM12.8133 3.48957C12.0942 3.59331 11.373 3.67545 10.6497 3.73597C10.5197 3.25194 10.352 2.77883 10.1482 2.32095C9.96214 1.8996 9.72801 1.50115 9.45048 1.13354C10.7917 1.54487 11.9686 2.36946 12.8133 3.48957ZM2.79256 2.79256C3.56192 2.02246 4.50845 1.45284 5.54917 1.13364C5.53338 1.15409 5.51714 1.17363 5.50157 1.19451C4.96665 1.96456 4.577 2.82592 4.35186 3.7361C3.62847 3.67484 2.90676 3.59266 2.18673 3.48957C2.37243 3.2436 2.57485 3.01071 2.79256 2.79256ZM2.18672 11.5104C2.90576 11.4067 3.62696 11.3245 4.35031 11.264C4.48032 11.7481 4.64799 12.2212 4.85179 12.6791C5.03787 13.1004 5.27199 13.4988 5.54952 13.8665C4.20831 13.4551 3.03135 12.6305 2.18672 11.5104ZM12.2074 12.2074C11.4381 12.9775 10.4915 13.5472 9.45083 13.8664C9.46662 13.8459 9.48285 13.8264 9.49843 13.8055C10.0334 13.0354 10.423 12.1741 10.6482 11.2639C11.3715 11.3252 12.0933 11.4073 12.8133 11.5104C12.6276 11.7564 12.4252 11.9893 12.2074 12.2074Z"
                                fill="white" />
                        </svg>
                        <span>
                            ورود به پنل
                        </span>
                    </a>
                </div>
                    <a class="btn-login" href="{{ route('changeview', ['Target' => 'Dashboard']) }}">ورود به پنل
                        {{ Auth::user()->Name }}
                        {{ Auth::user()->Family }}</a>
                @endif

            </div>
            <div class="row align-items-center">
                <div class="col-xl-3 col-9">
                    <a href="" class="logo">
                        <div class="img">
                            <img src="/Theme8/assets/img/logo.png">
                        </div>
                        <div class="text text-blue-dark">
                            <div class="title">
                                بیمارستان مجازی نوین
                            </div>
                            <div class="subtitle">
                                اولین بیمارستان مجازی کشور
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3 d-xl-none">
                    <div class="text-left">
                        <button class="btn-open-navigation">
                            <svg fill="none" height="30" viewBox="0 0 24 24" width="30"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <clipPath id="a">
                                    <path d="m0 .000977h24v24h-24z" />
                                </clipPath>
                                <g clip-path="url(#a)">
                                    <path d="m3 6.00098h18m-18 6.00002h18m-18 6h18" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="navigation-links-holder">

                        <!--overlay-->
                        <div class="navigation-overlay"></div>

                        <div class="navigation-links">

                            <div class="d-flex justify-content-end py-3">
                                <button class="btn-close-navigation">
                                    <svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.5">
                                            <path d="m19 4.99994-14 13.99996" />
                                            <path d="m5 4.99994 14 13.99996" />
                                        </g>
                                    </svg>
                                </button>
                            </div>

                            <a href="" class="logo mb-4">
                                <div class="img">
                                    <img src="/Theme8/assets/img/logo.png">
                                </div>
                                <div class="text text-blue-dark">
                                    <div class="title">
                                        بیمارستان مجازی نوین
                                    </div>
                                    <div class="subtitle">
                                        اولین بیمارستان مجازی کشور
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('home') }}" class="n-link">
                                خانه
                            </a>
                            <a href="https://parastarbank.com" class="n-link">
                                استعلام پزشک یا پرستار و سایر کادر درمان
                            </a>
                            <a href="{{ route('NewsHome') }}" class="n-link">
                                مجله سلامت
                            </a>
                            <a href="{{ route('shop') }}" class="n-link">
                                فروشگاه کالا
                            </a>

                            @if (!Auth::check())
                                <a href="{{ route('login') }}" class="btn-login">
                                    ورود / ثبت نام
                                </a>
                            @else
                                <a class="btn-login" href="{{ route('changeview', ['Target' => 'Dashboard']) }}">ورود به پنل
                                    {{ Auth::user()->Name }}
                                    {{ Auth::user()->Family }}</a>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('Layouts.ErrorHandler')
    @yield('content')






    <footer class="pt-md-5 pt-4 pb-4">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-12">
                    <div class="mb-lg-0 mb-md-5 mb-4">
                        <a href="" class="logo mb-4">
                            <div class="img">
                                <img src="/Theme8/assets/img/logo.png">
                            </div>
                            <div class="text text-blue-dark">
                                <div class="title">
                                    بیمارستان مجازی نوین
                                </div>
                                <div class="subtitle">
                                    اولین بیمارستان مجازی کشور
                                </div>
                            </div>
                        </a>

                        <div class="mb-4">
                            بیمارستان مجازی نوین به عنوان اولین بیمارستان مجازی کشور به عنوان یک مرکزموفق
                            در عرضه خدمات پزشکی و پرستاری در منزل توانسته
                            است سهم بسزایی در رونق این کسب و کار داشته باشد
                        </div>

                        <div class="phone-number text-blue-dark mb-4">
                            <svg width="14" height="14" viewBox="0 0 19 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.7071 11.7071L17.3552 14.3552C17.7113 14.7113 17.7113 15.2887 17.3552 15.6448C15.43 17.57 12.3821 17.7866 10.204 16.153L8.62857 14.9714C6.88504 13.6638 5.33622 12.115 4.02857 10.3714L2.84701 8.79601C1.21341 6.61788 1.43001 3.56999 3.35523 1.64477C3.71133 1.28867 4.28867 1.28867 4.64477 1.64477L7.29289 4.29289C7.68342 4.68342 7.68342 5.31658 7.29289 5.70711L6.27175 6.72825C6.10946 6.89054 6.06923 7.13846 6.17187 7.34373C7.35853 9.71706 9.28294 11.6415 11.6563 12.8281C11.8615 12.9308 12.1095 12.8905 12.2717 12.7283L13.2929 11.7071C13.6834 11.3166 14.3166 11.3166 14.7071 11.7071Z"
                                    stroke="#003959" stroke-width="2" />
                            </svg>
                            <span class="pt">1508</span>
                        </div>

                        <div class="socials-network">
                            <a href="#" class="socials-network">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16 32C7.16344 32 0 24.8366 0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16C32 24.8366 24.8366 32 16 32ZM16.6919 12.0074C15.2589 12.6034 12.3949 13.8371 8.09992 15.7083C7.40248 15.9856 7.03714 16.257 7.00388 16.5223C6.94767 16.9706 7.50915 17.1472 8.27374 17.3876C8.37774 17.4203 8.4855 17.4542 8.59598 17.4901C9.34822 17.7346 10.3601 18.0207 10.8862 18.0321C11.3633 18.0424 11.8959 17.8457 12.4839 17.4419C16.4968 14.7331 18.5683 13.3639 18.6983 13.3344C18.7901 13.3136 18.9172 13.2874 19.0034 13.3639C19.0895 13.4405 19.0811 13.5855 19.0719 13.6244C19.0163 13.8615 16.8123 15.9106 15.6717 16.971C15.3161 17.3015 15.0639 17.536 15.0124 17.5896C14.8969 17.7096 14.7791 17.823 14.666 17.9321C13.9672 18.6058 13.4431 19.111 14.695 19.936C15.2967 20.3325 15.7781 20.6603 16.2584 20.9874C16.7829 21.3446 17.306 21.7009 17.9829 22.1446C18.1554 22.2576 18.3201 22.375 18.4805 22.4894C19.0909 22.9246 19.6393 23.3155 20.3168 23.2532C20.7105 23.217 21.1172 22.8468 21.3237 21.7427C21.8118 19.1335 22.7712 13.4801 22.9929 11.1505C23.0123 10.9464 22.9879 10.6851 22.9683 10.5705C22.9486 10.4558 22.9076 10.2924 22.7586 10.1715C22.582 10.0283 22.3095 9.99805 22.1877 10.0001C21.6335 10.01 20.7834 10.3056 16.6919 12.0074Z"
                                        fill="#003959" />
                                </svg>
                            </a>
                            <a href="#" class="socials-network">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16 18.8C14.5 18.8 13.2 17.6 13.2 16C13.2 14.5 14.4 13.2 16 13.2C17.5 13.2 18.8 14.4 18.8 16C18.8 17.5 17.5 18.8 16 18.8Z"
                                        fill="#003959" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M19.4 9.2H12.6C11.8 9.3 11.4 9.4 11.1 9.5C10.7 9.6 10.4 9.8 10.1 10.1C9.86261 10.3374 9.75045 10.5748 9.61489 10.8617C9.57916 10.9373 9.5417 11.0166 9.5 11.1C9.48453 11.1464 9.46667 11.1952 9.44752 11.2475C9.34291 11.5333 9.2 11.9238 9.2 12.6V19.4C9.3 20.2 9.4 20.6 9.5 20.9C9.6 21.3 9.8 21.6 10.1 21.9C10.3374 22.1374 10.5748 22.2495 10.8617 22.3851C10.9374 22.4209 11.0165 22.4583 11.1 22.5C11.1464 22.5155 11.1952 22.5333 11.2475 22.5525C11.5333 22.6571 11.9238 22.8 12.6 22.8H19.4C20.2 22.7 20.6 22.6 20.9 22.5C21.3 22.4 21.6 22.2 21.9 21.9C22.1374 21.6626 22.2495 21.4252 22.3851 21.1383C22.4209 21.0626 22.4583 20.9835 22.5 20.9C22.5155 20.8536 22.5333 20.8048 22.5525 20.7525C22.6571 20.4667 22.8 20.0762 22.8 19.4V12.6C22.7 11.8 22.6 11.4 22.5 11.1C22.4 10.7 22.2 10.4 21.9 10.1C21.6626 9.86261 21.4252 9.75045 21.1383 9.61488C21.0627 9.57918 20.9833 9.54167 20.9 9.5C20.8536 9.48453 20.8048 9.46666 20.7525 9.44752C20.4667 9.3429 20.0762 9.2 19.4 9.2ZM16 11.7C13.6 11.7 11.7 13.6 11.7 16C11.7 18.4 13.6 20.3 16 20.3C18.4 20.3 20.3 18.4 20.3 16C20.3 13.6 18.4 11.7 16 11.7ZM21.4 11.6C21.4 12.1523 20.9523 12.6 20.4 12.6C19.8477 12.6 19.4 12.1523 19.4 11.6C19.4 11.0477 19.8477 10.6 20.4 10.6C20.9523 10.6 21.4 11.0477 21.4 11.6Z"
                                        fill="#003959" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16C32 24.8366 24.8366 32 16 32C7.16344 32 0 24.8366 0 16ZM12.6 7.7H19.4C20.3 7.8 20.9 7.9 21.4 8.1C22 8.4 22.4 8.6 22.9 9.1C23.4 9.6 23.7 10.1 23.9 10.6C24.1 11.1 24.3 11.7 24.3 12.6V19.4C24.2 20.3 24.1 20.9 23.9 21.4C23.6 22 23.4 22.4 22.9 22.9C22.4 23.4 21.9 23.7 21.4 23.9C20.9 24.1 20.3 24.3 19.4 24.3H12.6C11.7 24.2 11.1 24.1 10.6 23.9C10 23.6 9.6 23.4 9.1 22.9C8.6 22.4 8.3 21.9 8.1 21.4C7.9 20.9 7.7 20.3 7.7 19.4V12.6C7.8 11.7 7.9 11.1 8.1 10.6C8.4 10 8.6 9.6 9.1 9.1C9.6 8.6 10.1 8.3 10.6 8.1C11.1 7.9 11.7 7.7 12.6 7.7Z"
                                        fill="#003959" />
                                </svg>
                            </a>
                            <a href="#" class="socials-network">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.6 16L14.4 13.6V18.4L18.6 16Z" fill="#003959" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16C32 24.8366 24.8366 32 16 32C7.16344 32 0 24.8366 0 16ZM22.2 10.7C22.9 10.9 23.4 11.4 23.6 12.1C24 13.4 24 16 24 16C24 16 24 18.6 23.7 19.9C23.5 20.6 23 21.1 22.3 21.3C21 21.6 16 21.6 16 21.6C16 21.6 10.9 21.6 9.7 21.3C9 21.1 8.5 20.6 8.3 19.9C8 18.6 8 16 8 16C8 16 8 13.4 8.2 12.1C8.4 11.4 8.90001 10.9 9.60001 10.7C10.9 10.4 15.9 10.4 15.9 10.4C15.9 10.4 21 10.4 22.2 10.7Z"
                                        fill="#003959" />
                                </svg>
                            </a>
                            <a href="#" class="socials-network">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16C32 24.8366 24.8366 32 16 32C7.16344 32 0 24.8366 0 16ZM16 8C20.4 8 24 11.6 24 16C24 20 21.1 23.4 17.1 24V18.3H19L19.4 16H17.2V14.5C17.2 13.9 17.5 13.3 18.5 13.3H19.5V11.3C19.5 11.3 18.6 11.1 17.7 11.1C15.9 11.1 14.7 12.2 14.7 14.2V16H12.7V18.3H14.7V23.9C10.9 23.3 8 20 8 16C8 11.6 11.6 8 16 8Z"
                                        fill="#003959" />
                                </svg>
                            </a>
                            <a href="#" class="socials-network">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.6 21.7C13.6 22.3 14.8 22.6 16 22.6C19.7 22.6 22.6 19.6 22.6 16.1C22.6 14.3 22 12.7 20.7 11.4C19.4 10.2 17.8 9.5 16 9.5C12.4 9.5 9.39999 12.5 9.39999 16.1C9.39999 17.3 9.7 18.5 10.4 19.6L10.6 19.9L9.89999 22.3L12.4 21.6L12.6 21.7ZM18.2 17C18.4 17 19.4 17.5 19.6 17.6C19.6311 17.6156 19.6623 17.6287 19.6931 17.6417C19.8599 17.7121 20.0156 17.7779 20.1 18.2C20.2 18.2 20.2 18.6 20 19.1C19.9 19.5 19.1 20 18.7 20C18.6322 20 18.5673 20.0057 18.498 20.0119C18.1582 20.0419 17.712 20.0814 16.3 19.5C14.5475 18.799 13.3325 17.0999 12.9913 16.6228C12.9431 16.5554 12.9124 16.5124 12.9 16.5C12.883 16.466 12.8485 16.4116 12.8031 16.3399C12.5819 15.9906 12.1 15.2297 12.1 14.4C12.1 13.4 12.6 12.9 12.8 12.7C13 12.5 13.2 12.5 13.3 12.5H13.7C13.8 12.5 14 12.5 14.1 12.8C14.3 13.2 14.7 14.2 14.7 14.3C14.7 14.3333 14.7111 14.3667 14.7222 14.4C14.7445 14.4667 14.7667 14.5333 14.7 14.6C14.65 14.65 14.625 14.7 14.6 14.75C14.575 14.8 14.55 14.85 14.5 14.9L14.2 15.2C14.1 15.3 14 15.4 14.1 15.6C14.2 15.8 14.6 16.5 15.2 17C15.8751 17.5907 16.4078 17.8254 16.6778 17.9443C16.7278 17.9663 16.7688 17.9844 16.8 18C17 18 17.1 18 17.2 17.9C17.25 17.8 17.375 17.65 17.5 17.5C17.625 17.35 17.75 17.2 17.8 17.1C17.9 16.9 18 16.9 18.2 17Z"
                                        fill="#003959" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16C32 24.8366 24.8366 32 16 32C7.16344 32 0 24.8366 0 16ZM16 8C18.1 8 20.1 8.8 21.6 10.3C23.1 11.8 24 13.8 24 15.9C24 20.3 20.4 23.9 16 23.9C14.7 23.9 13.4 23.5 12.2 22.9L8 24L9.10001 20C8.40001 18.8 8 17.4 8 16C8 11.6 11.6 8 16 8Z"
                                        fill="#003959" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer-title mb-3">
                        لینک‌های مفید
                    </div>
                    <ul class="links mb-md-0 mb-4">
                        <li class="link">
                            <a href="">
                                درباره ما
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                تماس با ما
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                لیست بیمارستان ها
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                درباره نمایندگان
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                درخواست نمایندگی
                            </a>
                        </li>
                        <li class="link">
                            <a href="{{ route('NewsHome') }}">
                                مجله سلامت
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="footer-title mb-3">
                        پرمخاطب‌ترین بخش ها
                    </div>
                    <ul class="links mb-md-0 mb-4">
                        <li class="link">
                            <a href="">
                                نوبت دهی
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                مشاوره
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                آزمایشگاه
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                داروخانه
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                پرستاری
                            </a>
                        </li>
                        <li class="link">
                            <a href="">
                                فروشگاه
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-5 col-12">
                    <div class="footer-title mb-3">
                        <div class="footer-title mb-3">
                            مجوزها
                        </div>

                        <div class="symbols">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <a href="#" class="symbol mb-4">
                                        <img src="/Theme8/assets/img/namd1.png">
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="symbol mb-4">
                                        <img src="/Theme8/assets/img/namd3.png">
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="symbol mb-4">
                                        <img src="/Theme8/assets/img/namd4.png">
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="symbol mb-4">
                                        <img src="/Theme8/assets/img/namd5.png">
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <div class="pt-md-3">
                        Copyright © 2024 - 2025 | All rights reserved
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!--global js-->
    <script src="/Theme8/assets/js/global.js"></script>
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

    @yield('end-js')


</body>

</html>
