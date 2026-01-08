@php
    $Persian = new App\Functions\persian();
@endphp
@extends('news.Layouts.MainLayout')
@section('trending')
    @include('news.Layouts.HotNews')
@endsection
@section('page-title')
    {{ $posts->Titel }}
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $posts->Titel }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ $posts->MainPic }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta property="article:modified_time" content="{{ Carbon\Carbon::parse($posts->updated_at)->format('Y-m-d\TH:i:s+03:30') }}" />
    <meta name="keywords"
        content="@foreach ($Tags as $Tag)@if ($loop->first){{ $Tag->Name }}@else,{{ $Tag->Name }}@endif @endforeach">
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="canonical" href="{{ Request::url() }}">
@endsection
@if ($posts->description != null)
    @section('description')
        {{ $posts->description }}
    @endsection
@endif
@section('container')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="single-post">

                <div style="margin-top: -3px" class="post-title-area">
                    <a style="background-color: #a7a7a7;color: #fff;font-size: 10px;" href="#">{{ $CatName }}</a>
                    @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                        <a style="float: left;" href="{{ route('EditNews', [$posts->id]) }}"><i class="fa fa-pencil"></i></a>
                        <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                    @endif
                    @if ($posts->UpTitel != null)
                        <h2
                            style="font-size: 10px;font-weight: 500;margin-bottom: -42px;margin-top:-10px;line-height: 500%;">
                            {{ $posts->UpTitel }} </h2>
                    @endif
                    <h1
                        style="
                                                                                            font-size: 20px;
                                                                                            line-height:1.4;
                                                                                            @if ($posts->UpTitel == null) margin-top:-10px; @endif
                                                                                            @if ($posts->SubTitel != null) margin-bottom: -13px; @endif">
                        {{ $posts->Titel }}
                    </h1>
                    @if ($posts->SubTitel != null)
                        <h3
                            style="
                                                                                            font-size: 12px;
                                                                                            color: #848383;
                                                                                            font-style: normal;
                                                                                        ">
                            {{ $posts->SubTitel }}</h3>
                    @endif

                    <div style="margin-top: -8px;                                              " class="post-meta">
                        <span style="font-size: 8px" class="post-author">
                            نویسنده <a href="#">{{ $posts->ExtWriter }} </a>
                        </span>
                        <span style="font-size: 8px" class="post-date"><i
                                class="fa fa-clock-o"></i>{{ $Persian->MyPersianDate($posts->CrateDate) }}</span>
                        @if (Auth::check())
                            @if (Auth::user()->Role == 100)
                                <span style="font-size: 8px" class="post-hits"><i class="fa fa-eye"></i>
                                    {{ $posts->ViewCount }}</span>
                            @endif
                        @endif
                        <span style="font-size: 8px" class="post-comment"><i class="fa fa-comments-o"></i>
                            <a href="#" class="comments-link"><span>{{ $posts->CommentCount }}</span></a></span>
                        @if ($posts->RefName != null)
                            @if ($posts->RefLink != null)
                                <span style="font-size: 8px;float: left;" class="post-comment">
                                    منبع: <a style="color: black" href="{{ $posts->RefLink }}">{{ $posts->RefName }}</a>
                                </span>
                            @else
                                <span style="font-size: 8px;float: left;" class="post-comment">
                                    منبع: <a style="color: black">{{ $posts->RefName }}</a>
                                </span>
                            @endif
                        @endif
                    </div>

                </div><!-- Post title end -->

                <div class="post-content-area">
                    <div class="post-media post-audio" style="text-align: center">
                        <div class="embed-responsive"
                            style="width:100%;height:fit-content;padding:0px;">
                            <!-- Change the url -->
                            <img style="width: 100%" src="{{ $posts->MainPic }}">
                        </div>
                    </div><!-- Media end -->
                    @if ($posts->Abstract != null)
                        <div style="text-align: justify" class="Abstract">
                            {!! $posts->Abstract !!}
                        </div>
                    @endif

                    <div class="entry-content">
                        @if (!Auth::check() && $posts->ContentAccessLevel == 0)
                            {!! $posts->Content !!}
                        @elseif (Auth::check() && $posts->ContentAccessLevel <= Auth::user()->Role)
                            {!! $posts->Content !!}
                        @else
                            متن خبر برای کاربران ويژه می باشد!
                        @endif

                    </div><!-- Entery content end -->
                    @if ($posts->PostContent != null)
                        <div class="Abstract">
                            <h6
                                style="
                                                                                        margin-bottom: -2px;margin-top: 0px;
                                                                                    ">
                                پی‌نوشت:</h6>
                            {{ $posts->PostContent }}
                        </div>
                    @endif
                    @if ($Tags != null)
                        <div>
                            <div>
                                <span
                                    style="background: #d0d0d0;
                                                                                        color: #7b7b7b;
                                                                                        height: 30px;
                                                                                        line-height: 30px;
                                                                                        padding: 1px 15px;font-size:10px">برچسب
                                    ها:</span>
                                @foreach ($Tags as $Tag)
                                    <a style="color: #7b7b7b;font-size:10px"
                                        href="{{ route('newscat', ['newscat' => $Tag->Name]) }}"> {{ $Tag->Name }} -
                                    </a>
                                @endforeach
                            </div>
                        </div><!-- Tags end -->
                    @endif
                    @include('news.Layouts.SocialLinks')
                </div><!-- post-content end -->
            </div><!-- Single post end -->
            <div class="related-posts block">
                @if ($Relatednews != null)
                    <h3 class="block-title"><span>مطالب مرتبط</span></h3>

                    <div id="latest-news-slide" class="owl-carousel owl-theme latest-news-slide">

                        @foreach ($Relatednews as $RelatednewsItem)
                            <div class="item">
                                <div class="post-block-style clearfix">
                                    <div class="post-thumb">
                                        <a href="{{ Route('ShowNewsItem', $RelatednewsItem->id) }}"><img
                                                class="img-responsive" src="{{ $RelatednewsItem->MainPic }}"
                                                alt="{{ $RelatednewsItem->Titel }}"></a>
                                    </div>
                                    <div class="post-content">
                                        <div style="margin-bottom:-16px;">
                                            <h2 class="post-title title-small">
                                                <a
                                                    href="{{ Route('ShowNewsItem', $RelatednewsItem->id) }}">{{ $RelatednewsItem->Titel }}</a>
                                            </h2>
                                        </div>
                                        <div class="post-meta">

                                            <span style="font-size: 8px;"
                                                class="post-date">{{ $Persian->MyPersianDate($RelatednewsItem->created_at, true) }}</span>
                                        </div>
                                    </div><!-- Post content end -->
                                </div><!-- Post Block style end -->
                            </div><!-- Item 1 end -->
                        @endforeach

                    </div><!-- Carousel end -->
                @endif
            </div><!-- Related posts end -->
            @if ($posts->CommentCount != -1)
                @include('news.Layouts.CommntsForm')
            @endif
        </div><!-- Content Col end -->

        @include('news.Layouts.MostView')

    </div><!-- Row end -->
@endsection
