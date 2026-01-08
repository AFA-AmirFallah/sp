@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme7.layout.main_layout')
@section('trending')
@endsection
@section('page-title')
@endsection
@section('content')
    <div class="content-area">
        <div class="dez-bnr-inr overlay-black-middle" style="background-image:url(images/banner/bnr1.jpg);">
            <div class="container">
                <div class="dez-bnr-inr-entry">
                    <h1 class="text-white">{{ $CatName }}</h1>
                    <!-- Breadcrumb row -->
                    <div class="breadcrumb-row">
                        <ul class="list-inline">
                            <li><a href="/">خانه</a></li>
                        </ul>
                    </div>
                    <!-- Breadcrumb row END -->
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <!-- Left part start -->
                <div class="col-xl-9 col-lg-8 col-md-7 m-b10">
                    @if ($RelatedPosts == null)
                        <div class="post-block-style post-list clearfix">
                            <br>
                            @if ($searchmode)
                                <div style="margin-right: 10px" class="row">
                                    نتیجه ای برای جستجو وجود ندارد!
                                </div><!-- 1st row end -->
                            @else
                                <div style="margin-right: 10px" class="row">
                                    در این دسته محتوایی وارد نشده است!
                                </div><!-- 1st row end -->
                            @endif
                        </div><!-- 1st Post list end -->
                    @else
                        @foreach ($RelatedPosts as $RelatedPost)
                            @php
                                if ($RelatedPost->OutLink == null) {
                                    $news_route = route('ShowNewsItem', [
                                        'NewsId' => $RelatedPost->id,
                                        'newsitem' => $RelatedPost->Titel,
                                    ]);
                                } else {
                                    $news_route = route('ShowNewsItem', ['NewsId' => $RelatedPost->OutLink]);
                                }

                            @endphp
                            <div class="blog-post blog-md clearfix">
                                <div class="dez-post-media dez-img-effect zoom-slow radius-sm"> <a
                                        href="{{ $news_route }}"><img src="{{ $RelatedPost->MainPic }}"
                                            alt=""></a> </div>
                                <div class="dez-post-info">
                                    <div class="dez-post-meta">
                                        <ul class="d-flex align-items-center">
                                            <li class="post-date"><i
                                                    class="fa fa-calendar"></i>{{ $Persian->MyPersianDate($RelatedPost->CrateDate) }}
                                            </li>
                                            <li class="post-author"><i class="fa fa-user"></i>توسط <a
                                                    href="#">{{ $RelatedPost->CreatorName }}
                                                    {{ $RelatedPost->CreatorFamily }}</a> </li>
                                            <li class="post-comment"><i class="fa fa-comments-o"></i><a
                                                    href="#">{{ $RelatedPost->CommentCount }}</a> </li>
                                        </ul>
                                    </div>
                                    @if ($DataSource->IsAdminLogin())
                                        <h5 style="float: left">
                                            <a href="{{ route('EditNews', ['NewsID' => $RelatedPost->id]) }}"
                                                target="_blank"> <i class="fa fa-pencil"></i> </a>
                                            <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i>
                                            </a>
                                        </h5>
                                    @endif
                                    @php
                                        if ($RelatedPost->OutLink == null) {
                                            $news_route = route('ShowNewsItem', [
                                                'NewsId' => $RelatedPost->id,
                                                'newsitem' => $RelatedPost->Titel,
                                            ]);
                                        } else {
                                            $news_route = route('ShowNewsItem', ['NewsId' => $RelatedPost->OutLink]);
                                        }

                                    @endphp
                                    <div class="dez-post-title ">
                                        <h4 class="post-title font-24"><a href="{{ $news_route }}">
                                                {{ $RelatedPost->Titel }}</a></h4>
                                    </div>
                                    <div class="dez-post-text">
                                        <p>{!! str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($RelatedPost->Content), 400)) !!}</p>
                                    </div>
                                    <div class="dez-post-readmore blog-share">
                                        <a href="{{ $news_route }}" title="اطلاعات بیشتر" rel="bookmark"
                                            class="site-button-link"><span class="fw6">اطلاعات بیشتر</span></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <!-- Left part END -->
                <!-- Side bar start -->
                <div class="col-xl-3 col-lg-4 col-md-5 sticky-top">
                    <aside class="side-bar">
                        <div class="widget recent-posts-entry">
                            <h6 class="widget-title style-1">پست های پر بازدید</h6>
                            <div class="widget-post-bx">
                                @php
                                    $StartMostView = true;
                                @endphp
                                @foreach ($DataSource->MostViewPosts() as $LastPost)
                                    @php
                                        if ($LastPost->OutLink == null) {
                                            $news_route = route('ShowNewsItem', [
                                                'NewsId' => $LastPost->id,
                                                'newsitem' => $LastPost->Titel,
                                            ]);
                                        } else {
                                            $news_route = route('ShowNewsItem', ['NewsId' => $LastPost->OutLink]);
                                        }

                                    @endphp
                                    <div class="widget-post clearfix">
                                        <div class="dez-post-media"> <img src="{{ $LastPost->MainPic }}" width="200"
                                                height="143" alt="{{ strip_tags($LastPost->Titel) }}"> </div>
                                        <div class="dez-post-info">
                                            <div class="dez-post-header">
                                                <h6 class="post-title"><a
                                                        href="{{ $news_route }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                </h6>
                                            </div>
                                            <div class="dez-post-meta">
                                                <ul class="d-flex align-items-center">
                                                    <li class="post-date"><i
                                                            class="fa fa-calendar"></i>{{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="widget recent-posts-entry">
                            <h6 class="widget-title style-1">پست های اخیر</h6>
                            <div class="widget-post-bx">
                                @php
                                    $StartMostView = true;
                                @endphp
                                @foreach ($DataSource->LastPosts() as $LastPost)
                                    @php
                                        if ($LastPost->OutLink == null) {
                                            $news_route = route('ShowNewsItem', [
                                                'NewsId' => $LastPost->id,
                                                'newsitem' => $LastPost->Titel,
                                            ]);
                                        } else {
                                            $news_route = route('ShowNewsItem', ['NewsId' => $LastPost->OutLink]);
                                        }

                                    @endphp
                                    <div class="widget-post clearfix">
                                        <div class="dez-post-media"> <img src="{{ $LastPost->MainPic }}" width="200"
                                                height="143" alt="{{ strip_tags($LastPost->Titel) }}"> </div>
                                        <div class="dez-post-info">
                                            <div class="dez-post-header">
                                                <h6 class="post-title"><a
                                                        href="{{ $news_route }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                </h6>
                                            </div>
                                            <div class="dez-post-meta">
                                                <ul class="d-flex align-items-center">
                                                    <li class="post-date"><i
                                                            class="fa fa-calendar"></i>{{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                    </aside>
                </div>
                <!-- Side bar END -->
            </div>
        </div>
    </div>
@endsection
