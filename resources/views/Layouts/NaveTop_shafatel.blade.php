@php
    $User = new \App\Users\UserClass();
@endphp
<div class="main-header">
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    @if (\App\myappenv::MainOwner == 'shafatel')
        <div class="site-logo">
            <a href="{{ \App\myappenv::brandlink }}">
                <img src="{{ \App\myappenv::Sitelogo }}" alt="لوگوی شفاتل">
            </a>
        </div>
    @else
        @if (\Illuminate\Support\Facades\Auth::check())
            <div class="logo">
                <a href="{{ \App\myappenv::brandlink }}">
                    <img src=" {{ \App\branchenv::get_base_info('avatar') }}" alt="">
                </a>
            </div>
        @else
            <div class="logo">
                <a href="{{ \App\myappenv::brandlink }}">
                    <img src="{{ \App\myappenv::MainIcon }}" alt="">
                </a>
            </div>
        @endif
    @endif

    <div class="d-flex align-items-center">

    </div>

    <div style="margin: auto">
        <h3 id="fadeshow1">
            @if (\Illuminate\Support\Facades\Auth::check())
                {{ \App\branchenv::getenv('DefultPageTitr') ?? \App\myappenv::CenterName }}
            @else
                {{ \App\myappenv::CenterName }}
            @endif
        </h3>
    </div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->

        <!-- Notificaiton -->
        <!-- Notificaiton End -->

        <!-- User avatar dropdown -->

        <script>
            function darkfunction() {
                var element = document.body;
                element.classList.toggle("dark-theme");
                if (localStorage.dark == 'true') {
                    localStorage.dark = 'false';

                } else {
                    localStorage.dark = 'true';

                }

            }
        </script>
        @if (\Illuminate\Support\Facades\Auth::check())


            <div id="alertapp">
                <Basefunction-Tikets></Basefunction-Tikets>
            </div>
            <div id="main-top-avatar" class="dropdown">
                <div class="user col align-self-end">
                    @if (Auth::user()->avatar != null)
                        <img src="{{ Auth::user()->avatar }}" id="userDropdown" alt="" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" />
                    @else
                        <a id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                style="font-size: 40px" class="i-Male-21"></i></a>
                    @endif
                    <div class="dropdown-menu dropdown-menu-right" style="text-align: right"
                        aria-labelledby="userDropdown">
                        <div class="dropdown-header">
                            <i class="i-Lock-User mr-1"></i> {{ Auth::User()->Name }} {{ Auth::User()->Family }}
                        </div>
                        @if (\App\myappenv::MainOwner != 'kookbaz')
                            <a class="dropdown-item"
                                href="{{ route('MyTransfersReport') }}">{{ __('Account settings') }}</a>
                            <a class="dropdown-item" href="{{ route('MyTransfersReport') }}">{{ __('my credit') }}
                                : {{ number_format(Session::get('UserCredit')) }} ریال </a>
                        @endif
                        @if (\App\myappenv::Lic['hozorgheyab'] && \Illuminate\Support\Facades\Auth::user()->Role > \App\myappenv::role_customer)
                            @if (Session::has('Entrance') && Session::get('Entrance'))
                                <a class="dropdown-item" href="{{ route('entrance') }}">{{ __('Exit enter') }}</a>
                            @else
                                <a class="dropdown-item" href="{{ route('entrance') }}">{{ __('Entrance enter') }}</a>
                            @endif
                        @endif
                        <a class="dropdown-item" href="{{ route('MyTransfersReport') }}"> <i class="i-Internet"> </i>
                            تغییر وضعیت نمایش</a>

                        <a id="dark-btn" class="dropdown-item" onclick="darkfunction()"> <i class="i-Light-Bulb"></i>
                            وضعیت تیره
                            روشن
                        </a>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="i-Door"></i>
                            {{ __('Sign out') }}</a>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}">
                <a href="{{ route('login') }}" class="dropdown">
                    <div style="font-size: 0.9rem" class="user col align-self-end text-white">
                        ورود | ثبت نام
                    </div>
                </a>

            </a>

        @endif


    </div>

</div>
<!-- header top menu end -->
