
<header class="nav-container">
    <nav class="sina-nav mobile-sidebar navbar-fixed" data-top="60">
        <div class="container">

            <div class="extension-nav">
                <ul class="pt-2">
                    @if (Auth::check())
                    <li>
                        <a id="loginbtn" href="{{ route('MyAccount') }}" class="btn btn-link p-1 ml-2">
                            <img src="/Mosahvereh/Images/Svg/user.svg" />
                            {{ Auth::user()->Name }} {{ Auth::user()->Family }}
                        </a>
                    </li>
                   
                @else
                   
                    <li>
                        <a id="loginbtn" href="{{ route('login') }}" class="btn btn-link p-1 ml-2">
                            <img src="/Mosahvereh/Images/Svg/user.svg" />ورود / ثبت نام 
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="sina-nav-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="sina-brand pl-4" href="{{ route('Consulting') }}">
                    <img width="50px" src="{{ url('/') . \App\myappenv::FavIcon }}" class="img-fluid" />
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="sina-menu sina-menu-center IRANSansWeb">
                    <li><a href="{{ route('Consulting') }}">صفحه اصلی</a></li>
                    <li><a href="{{ route('shop') }}">فروشگاه </a></li>
                    <li><a href="{{ route('NewsHome') }}">وبلاگ</a></li>
                   {{--  <li><a href="{{ route('Faq') }}">پرسش و پاسخ</a></li>
                    <li><a href="{{ route('AboutUs') }}">درباره ما</a></li> --}}
                    <li><a href="{{ route('ContactUs') }}">ارتباط با ما</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>