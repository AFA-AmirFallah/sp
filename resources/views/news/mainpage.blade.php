@php
    $Persian = new App\Functions\persian();
@endphp
@extends('news.Layouts.MainLayout')
@section('trending')
    @include('news.Layouts.HotNews')
@endsection
@section('page-title')
@endsection
@section('container')


    <style>
        /*   computer size     */
        @media (min-width:992px) {
            .show-items {
                margin-right: -30px;

            }

            .show-items-largs {
                margin-right: -45px;
                margin-left: -28px;
            }

            .list-news-wrapper-2x {
                margin-left: 0px;
            }

            .article-picture-div {
                height: 411px;
                padding-right: 0px;
                padding-left: 5px;
            }

            .article-text-aria {
                position: absolute;
                bottom: 0;
                padding-left: 10px
            }

            .article-div {
                background-color: #656363;
                padding: 1em;
                height: 427px;
                align-items: stretch;
                justify-content: space-around;
                margin-bottom: 10px;
                padding-left: 0px;
            }

            .pic-fixer {
                height: 427px;
            }

            .article-picture-text {
                position: absolute;
                color: white;
                bottom: 42px;
                margin-right: 42px;
                max-width: 280px;
                text-align: justify;
            }



        }

        /*   Tablet size     */
        @media (min-width:768px) {
            @media (max-width:992px) {
                .show-items-largs {
                    margin-right: -45px;
                    margin-left: -28px;
                }

                .show-items {
                    margin-right: -30px;
                    margin-left: -15px;
                }

                .list-news-wrapper-2x {
                    margin-left: 0px;
                }

                .article-picture-text {
                    position: absolute;
                    color: white;
                    bottom: 42px;
                    margin-right: 42px;
                    max-width: 280px;
                    text-align: justify;
                }

                .article-picture-div {
                    padding-right: 0px;
                    padding-left: 0px;
                }

                .article-text-aria {
                    position: relative;
                    bottom: 0;
                    padding-left: 10px
                }

                .article-div {
                    background-color: #656363;
                    padding: 1em;
                    align-items: stretch;
                    justify-content: space-around;
                    margin-bottom: 10px;
                    padding-left: 0px;
                }
            }
        }

        /*   mobile size     */
        @media (max-device-width:768px) {
            .show-items-largs {
                margin-right: -45px;
                margin-left: -60px;
            }

            .show-items {
                margin-left: -45px;
                margin-right: -30px;
            }


            .list-news-wrapper-2x {
                margin-left: 0px;
            }

            .article-picture-div {
                padding-right: 0px;
                padding-left: 0px;
            }

            .article-text-aria {
                position: relative;
                bottom: 0;
                padding-left: 10px
            }

            .article-div {
                background-color: #656363;
                padding: 1em;
                align-items: stretch;
                justify-content: space-around;
                margin-bottom: 10px;
                padding-left: 0px;
            }

            .article-picture-text {
                position: absolute;
                color: white;
                margin-left: 42px;
                max-width: 280px;
                text-align: justify;
                background-color: #0000007d;
                padding: 10px;
                border-radius: 12px;
            }


        }

        .slides-continner {
            padding-top: 30px;
        }



        .article-text {
            text-align: justify;
            padding-right: 10px;
            padding-left: 10px;
            color: rgb(250, 247, 242);
        }

        .article-title {
            padding-right: 10px;
            color: rgb(250, 247, 242);
        }

        .side-article {
            width: 100%;
        }


        .article-avatar {
            width: 80px;
            background-color: whitesmoke;
            border-radius: 50px;
            padding: 4px;
        }

        @media (max-width: 991px) {
            .main-slider {
                display: none;
            }

            .small-pic-continner {
                margin-top: 22px !important;
                padding-left: 0px;
            }

            .list-news-wrapper {
                margin-left: -15px;
            }


            .article-div {
                background-color: #656363;
                padding: 1em;
                align-items: stretch;
                justify-content: space-around;
                margin-bottom: 10px;
                padding-left: 0px;
            }


        }



        .article-continner {
            padding-left: 11px;
        }

        .slider-div {
            background-color: #a6a6a6;
        }

        .text-mian {
            color: #ffffff !important;
        }

        .post-meta .post-author a {
            color: #ffffff !important;
        }

        .article-titr {
            color: #ffffff;
            font-size: 20px;
        }

        .article-outher {
            color: #ffffff;
        }



        .article-text-div {
            margin-right: 6px;
        }
    </style>
    <!-- Article-->
    <div class="row">
        <div class="article-continner col-md-12 col-xs-12 col-sm-12">
            <div class="article-div col-md-4 col-xs-12 col-sm-12 ">
                @if ($Article == null)
                    سرمقاله تعریف نشده است!
                @else
                    <div class="article-avatar-div">
                        <img class="article-avatar" src="{{ $ArticleWriterPic }}" alt="{{ $Article->Titel }}">
                        <div class="article-text-div">
                            <h4 class="article-titr">یادداشت</h5>
                                <h6 class="article-outher">{{ $ArticleWriterName }}</h6>
                        </div>
                    </div>
                    <div class="article-text-aria">
                        @if ($DataSource->IsAdminLogin())
                            <h5 style="float: left">
                                <a href="{{ route('EditNews', ['NewsID' => $Article->id]) }}" target="_blank"> <i
                                        class="fa fa-pencil"></i> </a>
                                <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                            </h5>
                        @endif
                        <div style="height: 10px"></div>
                        <h4 style="font-size:15px;line-height: 20px;margin-top: -26px;position: absolute;"
                            class="article-title">{{ $Article->Titel }}</h4>
                        <div style="height: 10px"></div>
                        <p class="article-text">
                            @if ($Article->article == 1)
                                {!! str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($Article->Abstract), 400)) !!}

                                @if (strlen($Article->Abstract) > 400)
                                    <a href="{{ route('ShowNewsItem', [$Article->id]) }}">ادامه مطلب </a>
                                @endif
                            @elseif ($Article->article == 3)
                                {!! str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($Article->Abstract), 400)) !!}
                            @endif
                        </p>
                    </div>
                @endif
            </div>
            @foreach ($mobile_banners as $mobile_banner)
                @if ($mobile_banner->theme == 7)
                    @if ($DataSource->IsAdminLogin())
                        <a style="position: absolute;left: 32px;z-index: 20;" href="{{ route('ArticlePicManagement') }}"
                            target="_blank"> <i class="fa fa-pencil"></i> </a>
                    @endif
                    <a href="{{ $mobile_banner->link }}">
                        <div class="article-picture-div col-md-8 col-xs-12 col-sm-12">

                            <div class="article-picture-text">

                                @php
                                    $var = preg_split('#/#', $mobile_banner->title);
                                @endphp
                                <h6 style="color: white;font-size:20px;">{{ $var[0] }}</h6>
                                <p>
                                    @if (isset($var[1]))
                                        {{ $var[1] }}
                                    @endif
                                </p>
                            </div>
                            <img class="side-article pic-fixer" src="{{ $mobile_banner->pic }}" alt="">

                        </div>

                    </a>
                @endif
            @endforeach

        </div>
    </div>
    <!-- End Article -->
    <!-- Main Pics 4 elements-->
    <section style="margin-bottom: 5px;margin-right:-16px" class="featured-post-area no-padding">
        <div class="container">
            <div class="row">
                <div class="main-slider col-md-7 col-xs-12 ">
                    <div id="featured-slider" class="owl-carousel owl-theme featured-slider">
                        @foreach ($mobile_banners as $mobile_banner)
                            @if ($mobile_banner->theme == 1)
                                <div class="item">
                                    @if ($DataSource->IsAdminLogin())
                                        <a style="position: absolute;left: 32px;z-index: 20;"
                                            href="{{ route('BannerManagement') }}" target="_blank"> <i
                                                class="fa fa-pencil"></i> </a>
                                    @endif
                                    <img src="{{ $mobile_banner->pic }}" alt="">
                                    <div class="featured-post">
                                        <div class="post-content">
                                            <h2 class="post-title title-extra-large">
                                                <a href="{{ $mobile_banner->link }}">{{ $mobile_banner->title }}</a>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div><!-- Featured owl carousel end-->
                </div>

                <div class="small-pic-continner col-md-5 col-xs-12 pad-l">
                    <div class="row">
                        <div class="col-sm-12">
                            @foreach ($mobile_banners as $mobile_banner)
                                @if ($mobile_banner->theme == 4)
                                    @if ($DataSource->IsAdminLogin())
                                        <a style="position: absolute;left: 32px;z-index: 20;"
                                            href="{{ route('PosterManagement') }}" target="_blank"> <i
                                                class="fa fa-pencil"></i> </a>
                                    @endif
                                    <div class="post-overaly-style contentTop hot-post-top clearfix">

                                        <div class="post-thumb">
                                            <a href="#"><img class="img-responsive" src="{{ $mobile_banner->pic }}"
                                                    alt=""></a>
                                        </div>
                                        <div class="post-content">
                                            <h2 class="post-title title-large">
                                                <a href="{{ $mobile_banner->link }}">{{ $mobile_banner->title }}</a>
                                            </h2>
                                        </div><!-- Post content end -->
                                    </div><!-- Post Overaly end -->
                                @endif
                            @endforeach
                        </div><!-- Col end -->

                        @foreach ($mobile_banners as $mobile_banner)
                            @if ($mobile_banner->theme == 6)
                                <div class="col-sm-6 pad-r-small">
                                    @if ($DataSource->IsAdminLogin())
                                        <a style="position: absolute;left: 32px;z-index: 20;"
                                            href="{{ route('SmallPicManagement') }}" target="_blank"> <i
                                                class="fa fa-pencil"></i> </a>
                                    @endif
                                    <div class="post-overaly-style contentTop hot-post-bottom clearfix">
                                        <div class="post-thumb">
                                            <a href="{{ $mobile_banner->link }}"><img class="img-responsive"
                                                    src="{{ $mobile_banner->pic }}" alt=""></a>
                                        </div>
                                        <div class="post-content">
                                            <h2 class="post-title title-medium">
                                                <a href="{{ $mobile_banner->link }}">{{ $mobile_banner->title }}</a>
                                            </h2>
                                        </div><!-- Post content end -->
                                    </div><!-- Post Overaly end -->
                                </div><!-- Col end -->
                            @endif
                        @endforeach
                    </div>
                </div><!-- Col 5 end -->

            </div><!-- Row end -->
        </div><!-- Container end -->
    </section>
    <!-- End Main Pics 4 elements-->

    @foreach ($mobile_banners as $mobile_banner)
        @if ($mobile_banner->theme == 8)
            <div class="gap-20"></div>

            <a href="{{ $mobile_banner->link }}">
                <div style="width: 100%;padding-left: 0px;padding-right: 0px;" class="col-md-12 col-xs-12 col-sm-12">
                    <div class="article-picture-text">
                        @if ($DataSource->IsAdminLogin())
                            <a style="position: absolute;left: 32px;z-index: 20;" href="{{ route('SinglePicManagement') }}"
                                target="_blank"> <i class="fa fa-pencil"></i>
                            </a>
                        @endif

                        @php
                            $var = preg_split('#/#', $mobile_banner->title);
                        @endphp
                        <h6 style="color: white;font-size:20px;">{{ $var[0] }}</h6>
                        <p>
                            @if (isset($var[1]))
                                {{ $var[1] }}
                            @endif
                        </p>
                    </div>
                    <img class="side-article" src="{{ $mobile_banner->pic }}" alt="">

                </div>

            </a>
            <div class="gap-20"></div>
        @elseif ($mobile_banner->theme == 9)
            @php
                $var = preg_split('#/#', $mobile_banner->title);
            @endphp

            @if (isset($var[1]))
                <section class="list-news-wrapper-2x block-wrapper">
                    <div>
                        <div>
                            <div class="slider-div col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="latest-news block">
                                    @if ($DataSource->IsAdminLogin())
                                        <a style="position: absolute;left: 32px;z-index: 20;"
                                            href="{{ route('IndexListManagement') }}" target="_blank"> <i
                                                class="fa fa-pencil"></i> </a>
                                    @endif

                                    <h3 class="block-title"><span>{{ $var[1] }}</span></h3>

                                    <div id="latest-news-slide"
                                        class="slides-continner owl-carousel owl-theme latest-news-slide">
                                        @php
                                            $mostviewconter = 1;
                                        @endphp
                                        @foreach ($DataSource->NewsListByIndexName($var[0]) as $LastPost)
                                            @if ($mostviewconter % 2 != 0)
                                                <div class="item">
                                                    <ul class="list-post">
                                                        <li class="clearfix">
                                                            <div class="post-block-style clearfix">
                                                                <div class="post-thumb">
                                                                    <a
                                                                        href="{{ route('ShowNewsItem', [$LastPost->id]) }}"><img
                                                                            class="img-responsive"
                                                                            src="{{ $LastPost->MainPic }}"
                                                                            alt=""></a>
                                                                </div>
                                                                <div class="post-content" style="height: 55px;">
                                                                    <h2 class="text-mian post-title title-medium">
                                                                        <a class="text-mian"
                                                                            href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                                    </h2>
                                                                </div><!-- Post content end -->
                                                            </div><!-- Post Block style end -->
                                                        </li><!-- Li end -->
                                                    @else
                                                        <div class="gap-20"></div>

                                                        <li class="clearfix">
                                                            <div class="post-block-style clearfix">
                                                                <div class="post-thumb">
                                                                    <a
                                                                        href="{{ route('ShowNewsItem', [$LastPost->id]) }}"><img
                                                                            class="img-responsive"
                                                                            src="{{ $LastPost->MainPic }}"
                                                                            alt=""></a>
                                                                </div>
                                                                <div class="post-content" style="height: 55px;">
                                                                    <h2 class="text-mian post-title title-medium">
                                                                        <a class="text-mian"
                                                                            href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                                    </h2>
                                                                </div><!-- Post content end -->
                                                            </div><!-- Post Block style end -->
                                                        </li><!-- Li end -->
                                                    </ul><!-- List post 1 end -->

                                                </div><!-- Item 1 end -->
                                            @endif
                                            @php
                                                $mostviewconter++;
                                            @endphp
                                        @endforeach

                                    </div><!-- Latest News owl carousel end-->
                                </div>
                                <!--- Latest news end -->

                            </div><!-- Content Col end -->

                        </div><!-- Row end -->
                    </div><!-- Container end -->
                </section><!-- First block end -->
            @elseif($var[0] == 'mostviews')
                <div class="gap-20"></div>
                @include('news.Layouts.MostViewFistPage')
            @elseif($var[0] == 'LastPosts')
                <div class="gap-20"></div>
                @include('news.Layouts.LastPostFirstPage')
            @endif
        @endif
    @endforeach

    @php
        $MiniCounter = 0;
    @endphp
    <section>
        <div class="container">
            <div style="margin-left: 0px" class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="latest-news block color-red">
                        <div>
                            @php
                                $MiniRow = 1;
                            @endphp
                            @foreach ($Minis as $Mini)
                                @if ($MiniRow == 1)
                                    @php
                                        $MiniRow = 1;
                                    @endphp
                                    <div class=" show-items row">
                                @endif

                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                    <div class="item">
                                        <ul class="list-post">
                                            <li class="clearfix">
                                                <div class="post-block-style clearfix">
                                                    <div class="post-thumb">
                                                        <a href="{{ route('ShowNewsItem', ['NewsId' => $Mini->id]) }}"><img
                                                                class="img-responsive" src="{{ $Mini->MainPic }}"
                                                                alt=""></a>
                                                    </div>
                                                    <div class="post-content">
                                                        <h2 class="text-mian post-title title-medium">
                                                            <a
                                                                href="{{ route('ShowNewsItem', ['NewsId' => $Mini->id]) }}">
                                                                {{ $Mini->Titel }}
                                                            </a>
                                                        </h2>
                                                        <div class="post-meta">
                                                            <span class="text-mian post-author"
                                                                style="font-size: 9px"><a>{{ $Mini->Writer }}</a></span>
                                                            <span class="text-mian post-date"
                                                                style="font-size: 9px">{{ $Persian->MyPersianDate($Mini->CrateDate) }}</span>
                                                        </div>
                                                    </div><!-- Post content end -->
                                                </div><!-- Post Block style end -->
                                            </li><!-- Li end -->
                                        </ul><!-- List post 1 end -->

                                    </div><!-- Item 1 end -->
                                </div>
                                @if ($MiniRow == 6)
                        </div>
                        @php
                            $MiniRow = 1;
                        @endphp
                    @else
                        @php
                            $MiniRow++;
                        @endphp
                        @endif
                        @endforeach

                    </div><!-- Latest News owl carousel end-->
                </div>
                <div class="gap-20"></div>
                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="show-items-largs">
                        @foreach ($Largs as $Larg)
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="post-block-style clearfix">
                                    <div class="post-thumb">
                                        <a href="{{ route('ShowNewsItem', ['NewsId' => $Larg->id]) }}">
                                            <img class="img-responsive" src="{{ $Larg->MainPic }}" alt="">
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <h2 class="post-title title-medium">
                                            <a
                                                href="{{ route('ShowNewsItem', ['NewsId' => $Larg->id]) }}">{{ $Larg->Titel }}</a>
                                        </h2>
                                        <div class="post-meta">
                                            <span class="text-mian post-author" style="font-size: 9px"><a
                                                    href="#">{{ $Larg->Writer }}</a></span>
                                            <span class="text-mian post-date"
                                                style="font-size: 9px">{{ $Persian->MyPersianDate($Larg->CrateDate) }}</span>
                                        </div>
                                        <p class="text-mian" style="text-align: justify;max-height: 169px;">
                                            {!! str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($Larg->Content), 400)) !!}
                                        </p>
                                    </div><!-- Post content end -->
                                </div><!-- Post Block style end -->
                            </div><!-- Col end -->
                        @endforeach
                    </div>
                </div>
            </div>

            <!--- Latest news end -->
        </div><!-- Container end -->
    </section><!-- First block end -->


@endsection
