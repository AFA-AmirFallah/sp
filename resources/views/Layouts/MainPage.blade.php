<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (Auth::check())
        <title>{{ \App\branchenv::getenv('Name') }}</title>
        <meta name="keywords" content="{{ \App\branchenv::getenv('Description') }}">
        <link rel="icon" href="{{ \App\branchenv::getenv('avatar') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ \App\branchenv::getenv('avatar') }}" type="image/x-icon">
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
        <meta name="keywords" content="{{ \App\myappenv::CenterName }}">
        <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
    @endif
    <meta name="author" content="Shafatel">
    @yield('before-css')
    <link rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
    <link rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
    <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
    <link rel="stylesheet" href="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/select2.min.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/jquery-confirm.css">
    <link rel="stylesheet" href="{{ asset('storage/dashboard_assets/main-dashboard.css') }}">
    @vite(['resources/js/app.js'])

    @yield('page-css')
</head>

<body class="text-left ">


    @php
        if (!isset($layout)) {
            $layout = session('layout');
        }
    @endphp
    <div class='loadscreen' id="preloader">
        <div class="loader spinner-bubble spinner-bubble-primary">
        </div>
    </div>
    @if ($layout == 'iframe')
        <div class="app-admin-wrap layout-sidebar-large clearfix">
            <div class="main-content">
                @include('Layouts.ErrorHandler')
                @yield('MainCountent')
            </div>
        </div>
    @else
        <div class="app-admin-wrap layout-sidebar-large clearfix">
            @include('Layouts.NaveTop')



            @if (\Illuminate\Support\Facades\Auth::check())
                @include('Layouts.NaveSide.NaveSide')
                <div class="main-content-wrap sidenav-open d-flex flex-column">
                @else
                    <div class="main-content-wrap  d-flex flex-column">
            @endif

            <div class="main-content">
                @include('Layouts.ErrorHandler')
                @yield('MainCountent')
            </div>
            @include('Layouts.footer')

        </div>
        </div>
    @endif
    <script src="/assets/js/common-bundle-script.js"></script>
    @yield('page-js')
    <script src="/assets/js/script.js"></script>
    <script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.script.js') }}"></script>
    <script src="{{ asset('assets/js/num2persian.js') }}"></script>
    <script src="{{ url('/') }}/assets/js/select2.min.js"></script>
    <script src="{{ url('/') }}/assets/js/jquery-confirm.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/tabelexport/libs/FileSaver/FileSaver.min.js">
    </script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/tabelexport/libs/js-xlsx/xlsx.core.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/tableexport.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/xlsx.full.min.js"></script>

    <script src="{{ url('/') }}/storage/dashboard_assets/main-dashboard.js"></script>

    <script>
        $('.alert-autoremove').delay(3000).fadeOut('slow');
        $("#dropdownMenuButton").css("background-color", "red");
        setInterval(function() {
            $("#dropdownMenuButton").css("background-color", function() {
                this.switch = !this.switch
                return this.switch ? "red" : ""
            });
        }, 1000);
    </script>
    <script>
        if (localStorage.dark == 'true') {
            var element = document.body;
            element.classList.toggle("dark-theme");
        }

        function CurencyTextRT($Rial, $TargetID) {
            document.getElementById($TargetID).innerHTML = $Rial.toPersianLetter() + ' تومان ';
        }

        function number_format(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $(document).ready(function() {
            main_menu = $('#main-menu').val();
            sub_menu = $('#sub-menu').val();
            $(sub_menu).addClass('open');
            $(main_menu).addClass('main-active');
            $(main_menu + '_text').addClass('main-active');

        });
    </script>
    @php
        $goftino_main = App\Functions\CacheData::GetSetting('goftino_id');
        if (Auth::check()) {
            $user_role = Auth::user()->Role;
        } else {
            $user_role = 0;
        }

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
        @if ($goftino_main && $user_role == App\myappenv::role_ShopOwner)
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

    @yield('bottom-js')

</body>

</html>
