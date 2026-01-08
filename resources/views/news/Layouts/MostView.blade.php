<style>
    @media (min-width:992px) {
        .sidebar-most-view {}
    }

    @media (min-width:768px) {
        @media (max-width:992px) {
            .sidebar-most-view {}

        }
    }

    @media (max-device-width:768px) {
        .sidebar-most-view {}
    }
</style>
<div class="sidebar-most-view col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="sidebar sidebar-right">
        <div class="widget color-default">
            <h3 class="block-title"><span>اخبار پربازدید </span></h3>
            @php
                $StartMostView = true;
            @endphp
            @foreach ($DataSource->MostViewPosts() as $LastPost)
                @if ($StartMostView)
                    <div class="post-overaly-style clearfix">
                        <div class="post-thumb">
                            <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}">
                                <img class="img-responsive" src="{{ $LastPost->MainPic }}" alt="">
                            </a>
                        </div>

                        <div class="post-content">
                            <h2 class="post-title title-small">
                                <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->UpTitel) }}
                                    {{ strip_tags($LastPost->Titel) }}</a>
                            </h2>
                            @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                <a style="float: left;" href="{{ route('EditNews', [$LastPost->id]) }}"><i
                                        class="fa fa-pencil"></i></a>
                                <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                            @endif
                            <div class="post-meta">
                                <span style="font-size: 8px"
                                    class="post-date">{{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                            </div>
                        </div><!-- Post content end -->
                    </div><!-- Post Overaly Article end -->
                    <div class="list-post-block">
                        <ul class="list-post">

                            @php
                                $StartMostView = false;
                            @endphp
                        @else
                            <li class="clearfix">
                                <div class="post-block-style post-float clearfix">
                                    <div class="post-content">
                                        <h2 class="post-title title-small">
                                            <a
                                                href="{{ route('ShowNewsItem', ['NewsId' => $LastPost->id, 'newsitem' => $LastPost->Titel]) }}">{{ strip_tags($LastPost->UpTitel) }}
                                                {{ strip_tags($LastPost->Titel) }}</a>
                                        </h2>
                                        <div class="post-meta">
                                            <span style="font-size: 8px" class="post-date">تاریخ
                                                {{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                                        </div>
                                        @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                            <a style="float: left;" href="{{ route('EditNews', [$LastPost->id]) }}"><i
                                                    class="fa fa-pencil"></i></a>
                                            <a href="{{ route('MakeNews') }}" target="_blank"> <i
                                                    class="fa fa-plus"></i> </a>
                                        @endif

                                    </div><!-- Post content end -->
                                </div><!-- Post block style end -->
                            </li><!-- Li 1 end -->
                @endif
            @endforeach
            </ul><!-- List post end -->
        </div><!-- List post block end -->

    </div><!-- Popular news widget end -->
    <div style="margin-top:-35px" class="widget text-center">

        @foreach ($DataSource->AdPosts() as $AdPostitem)
            <div class="div" style="margin-top: 10px">
                @if ($AdPostitem->adds == 2)
                    @php
                        $BannerLink = strip_tags($AdPostitem->Titel);
                    @endphp
                    @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                        <a style="float: left;" href="{{ route('EditNews', [$AdPostitem->id]) }}"><i
                                class="fa fa-pencil"></i></a>
                        <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                    @endif

                    <a href="{{ $BannerLink }}">
                        <img class="banner img-responsive" src="{{ $AdPostitem->MainPic }}" alt="">
                    </a>
                @elseif ($AdPostitem->adds == 1)
                    @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                        <a style="float: left;" href="{{ route('EditNews', [$AdPostitem->id]) }}"><i
                                class="fa fa-pencil"></i></a>
                        <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                    @endif
                    <a
                        href="{{ route('ShowNewsItem', ['NewsId' => $AdPostitem->id, 'newsitem' => $AdPostitem->Titel]) }}">
                        <img class="banner img-responsive" src="{{ $AdPostitem->MainPic }}" alt="">
                    </a>
                @endif

            </div>
        @endforeach
    </div><!-- Sidebar Ad end -->
    <div class="widget color-default">
        <h3 class="block-title"><span>جدیدترین مطالب </span></h3>
        @php
            $Startlastpost = true;
        @endphp

        @foreach ($DataSource->LastPosts() as $LastPost)
            @if ($Startlastpost)
                <div class="post-overaly-style clearfix">
                    <div class="post-thumb">
                        <a href="#">
                            <img class="img-responsive" src="{{ $LastPost->MainPic }}" alt="">
                        </a>
                    </div>

                    <div class="post-content">
                        <h2 class="post-title title-small">
                            <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->UpTitel) }}
                                {{ strip_tags($LastPost->Titel) }}</a>
                        </h2>
                        @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                            <a style="float: left;" href="{{ route('EditNews', [$LastPost->id]) }}"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                        @endif
                        <div class="post-meta">
                            <span style="font-size: 8px"
                                class="post-date">{{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                        </div>
                    </div><!-- Post content end -->
                </div><!-- Post Overaly Article end -->
                @php
                    $Startlastpost = false;
                @endphp
                <div class="list-post-block">
                    <ul class="list-post">
                    @else
                        <li class="clearfix">
                            <div class="post-block-style post-float clearfix">
                                <div class="post-thumb">

                                    <a href="#">
                                        <img class="img-responsive" src="{{ $LastPost->MainPic }}" alt="">
                                    </a>

                                </div><!-- Post thumb end -->

                                <div class="post-content">
                                    <div style="margin-bottom:-16px;">
                                        <h2 class="post-title title-small">
                                            <a
                                                href="{{ route('ShowNewsItem', ['NewsId' => $LastPost->id, 'newsitem' => $LastPost->Titel]) }}">{{ strip_tags($LastPost->UpTitel) }}
                                                {{ strip_tags($LastPost->Titel) }}</a>
                                        </h2>
                                    </div>
                                  
                                    <div class="post-meta">
                                        <span style="font-size: 8px" class="post-date">تاریخ
                                            {{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                                    </div>
                                    @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                        <a style="float: left;" href="{{ route('EditNews', [$LastPost->id]) }}"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="{{ route('MakeNews') }}" target="_blank"> <i
                                                class="fa fa-plus"></i> </a>
                                    @endif

                                </div><!-- Post content end -->
                            </div><!-- Post block style end -->
                        </li><!-- Li 1 end -->
            @endif
        @endforeach
        @foreach ($DataSource->LastPosts() as $LastPost)
        @endforeach

        </ul><!-- List post end -->
    </div><!-- List post block end -->

</div><!-- Popular news widget end -->



<div class="widget m-bottom-0">
    <h3 class="block-title"><span>خبرنامه</span></h3>
    <div style="margin-top: -35px;padding-bottom: 1px;border-radius: 8px 0px 8px 8px;" class="ts-newsletter">
        <div style="margin-top: 15px" class="newsletter-introtext">
            <h4>با ما به‌روز باشید!</h4>
            <p style="font-size: 10px">با عضویت در خبرنامه جدیدترین اخبار را در ایمیل خود دریافت کنید!</p>
        </div>

        <div class="newsletter-form">
            <form action="#" method="post">
                <div class="form-group">
                    <input
                        style="text-align: left;
                            height: 22px;
                            background-color: #f7f7f7;direction:ltr"
                        type="email" name="email" id="newsletter-form-email"
                        class="form-control form-control-lg" placeholder="Email:" autocomplete="off">
                    <button
                        style="
                            height: 18px;
                            border-radius: 4px;
                            width: 52px;
                            padding:0px;
                            font-size: 10px;
                            text-align: center;
                            margin-top: 5px;
                        "
                        class="btn btn-primary">ثبت</button>
                </div>
            </form>
        </div>
    </div><!-- Newsletter end -->
</div><!-- Newsletter widget end -->

</div><!-- Sidebar right end -->

</div><!-- Sidebar Col end -->
