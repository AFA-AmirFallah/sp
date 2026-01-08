@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme7.layout.main_layout')
@section('MainTitle')
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
    <meta property="article:modified_time"
        content="{{ Carbon\Carbon::parse($posts->updated_at)->format('Y-m-d\TH:i:s+03:30') }}" />
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
@section('content')
    <div class="page-content bg-white">

        <!-- inner page banner END -->
        <div class="content-area">
            <div class="container">
                <div style="width: 100% !important;margin-right:0px !important;margin-left:0px!important;" class="row">
                    <!-- Left part start -->
                    <div class="col-lg-8 col-md-7 m-b10">
                        <!-- blog start -->
                        <div class="blog-post blog-single blog-style-1">
                            <div class="dez-post-meta">

                            </div>
                            <div class="dez-post-title">
                                <h1 class="post-title m-t0">{{ $posts->Titel }}</h1>

                            </div>
                            <div class="dez-post-media dez-img-effect zoom-slow m-t20"> <a href="#"><img
                                        src="{{ $posts->MainPic }}" alt="{{ $posts->Titel }}"></a> </div>
                            @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                <a style="float: left;" href="{{ route('EditNews', [$posts->id]) }}"><i
                                        class="fa fa-pencil"></i></a>
                                <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                            @endif
                            <div class="dez-post-text">
                                {!! $posts->Content !!}
                            </div>
                            <div class="dez-post-tags clear">
                                <div class="post-tags">
                                    @foreach ($Tags as $Tag)
                                        <a href="{{ route('newscat', ['newscat' => $Tag->Name]) }}">{{ $Tag->Name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="dez-divider bg-gray-dark op4"><i class="icon-dot c-square"></i></div>
                            <div class="share-details-btn">
                                <ul>
                                    <li>
                                        <h5 class="m-a0">اشتراک گذاری پست</h5>
                                    </li>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                            target="_blank" class="site-button facebook button-sm"><i
                                                class="fa fa-facebook"></i> فیسبوک</a></li>
                                    <li><a href="javascript:void(0);" class="site-button google-plus button-sm"><i
                                                class="fa fa-google-plus"></i> گوگل پلاس</a></li>
                                    <li><a href="javascript:void(0);" class="site-button linkedin button-sm"><i
                                                class="fa fa-linkedin"></i> لینکیدین</a></li>
                                    <li><a href="https://www.instagram.com/?url={{ url()->current() }}" target="_blank"
                                            class="site-button instagram button-sm"><i class="fa fa-instagram"></i>
                                            اینستاگرام</a></li>
                                    <li><a target="_blank"
                                            href="http://twitter.com/share?url={{ url()->current() }}&text={{ $posts->UpTitel . ' ' . $posts->Titel }}&hashtags=simplesharebuttons"
                                            class="site-button twitter button-sm"><i class="fa fa-twitter"></i> توییتر</a>
                                    </li>
                                    <li><a href="javascript:void(0);" class="site-button whatsapp button-sm"><i
                                                class="fa fa-whatsapp"></i> واتس آپ</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- blog END -->
                    </div>
                    <!-- Left part END -->
                    <!-- Side bar start -->
                    <div class="col-lg-4 col-md-5 sticky-top">
                        <aside class="side-bar">
                            <div class="widget recent-posts-entry">
                                <h6 class="widget-title" style="font-family: pelak;"> مطالب اخیر</h6>
                                <div class="widget-post-bx">
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

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="widget recent-posts-entry">
                                <h6 class="widget-title" style="font-family: pelak;"> مطالب پر بازدید</h6>
                                <div class="widget-post-bx">
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
    </div>
@endsection
