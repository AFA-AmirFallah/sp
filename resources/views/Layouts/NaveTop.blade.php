@php
    $User = new \App\Users\UserClass();
@endphp
<div class="main-header">
    @if (Auth::check())
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
    @if (Auth::check())
        <div class="menu-toggle">
            <div></div>
            <div></div>
            <div></div>
        </div>
    @endif
    <div class="d-flex align-items-center">

    </div>

    <div style="margin: auto">
        <h3 id="fadeshow1">
            @php
                $branch_src = \App\branchenv::get_branch();
            @endphp
            {{ $branch_src['CenterName'] }}
        </h3>
    </div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->
        @if (\App\myappenv::CoustomerType == 'Partner')

            <div class="dropdown widget_dropdown">
                <img style="width: 30px;border-radius: 30px" src="{{ url('/') . \App\myappenv::ShafatelIcon }}"
                    role="button" id="dropdownMenuButton" data-toggle="dropdown" alt="">
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class="menu-icon-grid">
                        @if (Session::get('shafatelunmanagedcustomers') > 0)
                            <a href="#"><i style="color: red" class="i-Checked-User"></i>
                                {{ __('customers') }}</a>
                        @else
                            <a href="#"><i class="i-Checked-User"></i> {{ __('customers') }}</a>
                        @endif
                        <a href="#"><i class="i-Shop-4"></i> {{ __('My Shafatel') }}</a>
                        <a href="#"><i class="i-Library"></i> {{ __('Electronic document') }}</a>
                        <a href="#"><i class="i-Drop"></i> {{ __('Labs') }}</a>
                        <a href="#"><i class="i-Luggage-2"></i> {{ __('devices') }}</a>

                        <a href="#"><i class="i-Ambulance"></i> {{ __('Services') }}</a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Notificaiton -->
        <!-- Notificaiton End -->

        <!-- User avatar dropdown -->

        @if (\App\myappenv::Lic['hiring'] && Auth::user()->Role == \App\myappenv::role_worker)
        @else
            @if (Auth::check())
                @if (Auth::user()->Role > 50 && \App\myappenv::Lic['Voip'])
                    <a href="javascript:open_phone()" class="link external"> <i
                            style="font-size: 27px;color: blue !important;"
                            class="i-Telephone text-muted header-icon"></i>
                    </a>
                @endif
            @endif
            <a href="{{ route('changeview', ['Target' => 'site']) }}" class="link external"> <i
                    style="font-size: 27px;color: blue !important;" class="i-Internet text-muted header-icon"></i>
            </a>
        @endif
        <a id="dark-btn" onclick="darkfunction()" class="link external"> <i
                style="font-size: 27px;color: blue !important;" class="i-Light-Bulb text-muted header-icon"></i>
        </a>
        @if (\App\myappenv::Lic['hiring'] && Auth::user()->Role == \App\myappenv::role_worker)
        @else
            <div id="phone_main_div" class="phone_in_app nested">
                <button id="close-phone" onclick="close_phone()" class="close">X</button>
                @include('voip/phone')
            </div>
        @endif
        @if (Auth::check())
            <div id="alertapp">
                <Basefunction-Tikets></Basefunction-Tikets>
            </div>
            <div class="dropdown">
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
                                href="{{ route('UserProfile') }}">{{ __('Account settings') }}</a>
                            @if (\App\myappenv::Lic['hiring'] && Auth::user()->Role == \App\myappenv::role_worker)
                            @else
                                <a class="dropdown-item" href="{{ route('MyTransfersReport') }}">{{ __('my credit') }}
                                    : {{ number_format(Session::get('UserCredit')) }} ریال </a>
                            @endif
                        @endif
                        @if (\App\myappenv::Lic['hozorgheyab'] && Auth::user()->Role > \App\myappenv::role_customer)
                            @if (Session::has('Entrance') && Session::get('Entrance'))
                                <a class="dropdown-item" href="{{ route('entrance') }}">{{ __('Exit enter') }}</a>
                            @else
                                <a class="dropdown-item" href="{{ route('entrance') }}">{{ __('Entrance enter') }}</a>
                            @endif
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}">{{ __('Sign out') }}</a>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}">
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <i class="i-Data-Key" style="font-size: 35px;"></i>
                    </div>
                </div>

            </a>

        @endif


    </div>

</div>
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
<!-- header top menu end -->
