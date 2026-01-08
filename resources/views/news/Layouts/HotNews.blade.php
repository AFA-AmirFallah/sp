<div class="trending-bar hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="trending-slide" class="owl-carousel owl-theme trending-slide col-md-10">
                    @foreach ($DataSource->HotNews() as $hotPost)
                        <div class="item">
                            <div style="height: 40px;" class="post-content">
                                <h2 style="font-size: 9px;color:#000000 !importatnt;padding-top:25px"
                                    class="post-title title-small">
                                    <a
                                        href="{{ route('ShowNewsItem', ['NewsId' => $hotPost->id, 'newsitem' => $hotPost->Titel]) }}">{{ $hotPost->Titel }}</a>
                                </h2>
                            </div><!-- Post content end -->
                        </div><!-- Item 1 end -->
                    @endforeach
                </div><!-- Carousel end -->
                <div class="col-md-2" style="float: left;z-index: 100000;">

                    @if (!Auth::check())
                        <div style="font-size: 15px ;margin-top: -29px; ">
                            <a style="color: #000000" href="{{ route('login') }}"> ورود <i style="color: white"
                                    class="fa fa-sign-in"></i></a>

                            /
                            <a style="color: #000000" href="{{ route('register') }}">
                                عضویت <i style="color: white" class="fa fa-unlock-alt"></i>
                            </a>
                        </div>
                    @else
                        <div
                            style="
                        position: relative;
                        bottom: 14px;
                        color: white;
                        left:80px;
                    ">
                            {{ Auth::user()->Name }} {{ Auth::user()->Family }} خوش آمدی!
                        </div>

                        <li style="display: block" class="dropdown">
                            <img class="dropdown-toggle" data-toggle="dropdown"
                                style="border-radius: 50%;
                            width: 35px;
                            height:35px;
                            position: absolute;
                            top: -38px;
                            left: 0px;"
                                src="    @if (Auth::user()->avatar == null) {{ asset('assets/images/avtar/useravatar.png') }} @else
                            {{ Auth::user()->avatar }} @endif"
                                alt="">
                            <ul style="
                            left: 0px;
                            margin-top: -3px;
                            min-width: 26px !important;
                            padding: 0px;
                            padding-top: 5px;
                            border-radius: 6px;
                        "
                                class="dropdown-menu">
                                <li><a href="{{ route('UserProfile') }}">{{ Auth::user()->Name }}
                                        {{ Auth::user()->Family }}
                                        -
                                        @switch(Auth::user()->Role)
                                            @case(10)
                                                <small>کاربر مهمان</small>
                                            @break

                                            @case(30)
                                                <small>فروشنده</small>
                                            @break

                                            @case(40)
                                                <small>کاربر نقره ای</small>
                                            @break

                                            @case(41)
                                                <small>کاربر طلایی</small>
                                            @break

                                            @case(42)
                                                <small>کاربر الماس</small>
                                            @break

                                            @case(80)
                                                <small>کاربر ادمین</small>
                                            @break

                                            @case(100)
                                                <small>کاربر مدیر کل</small>
                                            @break

                                            @default
                                        @endswitch

                                    </a></li>
                                @if (Auth::user()->Role > \App\myappenv::role_customer)
                                    <li><a href="{{ route('changeview',['Target'=>'Dashboard']) }}">پنل مدیریتی</a></li>
                                @else
                                    <li><a>میزان موجودی {{ number_format(Session::get('UserCredit')) }} ریال</a></li>
                                    <li><a href="{{ route('SpecialAccount') }}">ارتقا حساب کاربری</a></li>
                                @endif
                                <li><a href="{{ route('logout') }}">خروج</a></li>

                            </ul>
                        </li>
                    @endif
                </div>

            </div><!-- Col end -->
        </div>
        <!--/ Row end -->
    </div>
    <!--/ Container end -->
</div>

<!--/ Trending end -->
