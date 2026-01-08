@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')
@section('MainTitle')
    {{ $CatName }} | {{ \App\myappenv::CenterName }}
@endsection
@if ($CoverPost != null)
    @section('OG')
        <meta property="og:locale" content="fa_IR" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ $CatName }}" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:image" content="{{ $CoverPost->MainPic }}" />
        <meta property="og:image:width" content="600" />
        <meta property="og:image:height" content="600" />
        <meta property="article:modified_time"
            content="{{ Carbon\Carbon::parse($CoverPost->updated_at)->format('Y-m-d\TH:i:s+03:30') }}" />
        <meta name="twitter:card" content="summary_large_image" />
        <link rel="canonical" href="{{ Request::url() }}">
    @endsection
    @if ($CoverPost->description != null)
        @section('description')
            {{ $CoverPost->description }}
        @endsection
    @endif
@else
    @section('OG')
        <meta property="og:locale" content="fa_IR" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:image" content="" />
        <meta property="og:image:width" content="600" />
        <meta property="og:image:height" content="600" />
        <meta name="twitter:card" content="summary_large_image" />
    @endsection
@endif

@section('content')
    <section class="all-page-banner item-one">
        <div class="d-table">
            <div class="d-tablecell">
                <div class="container">
                    <div class="banner-text text-center">
                        <h1>{{ $CatName }}</h1>
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">صفحه اصلی</a>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                            </li>
                            <li>{{ $CatName }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Start Blog Section -->
    <section class="news-section ptb-100">
        <div class="container">
            @if ($CoverPost != null)
                <div class="top-larget-post clearfix">
                    @if ($DataSource->IsAdminLogin())
                        <h5 style="float: left">
                            <a href="{{ route('EditTagCover', ['TagID' => $CoverPost->id]) }}" target="_blank"> <i
                                    class="fa fa-pencil"></i> </a>
                        </h5>
                    @endif
                    <div class="article-image">
                        <img src="{{ $CoverPost->MainPic }}" alt="{{ $CoverPost->Titel }}">
                    </div>
                    <div class="article-content">
                        {!! $CoverPost->Content !!}
                    </div>
                </div><!-- Post Block style end -->
                <hr>
                @php
                    $posts = $CoverPost;
                @endphp
            @endif
            <div class="row">
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
                    <div class="col-md-6 col-lg-4">
                        <div class="single-news single-news-2">
                            <div class="image">
                                <a href="{{$news_route}}">
                                    <img src="{{ $RelatedPost->MainPic }}" alt="{{ $RelatedPost->Name }}">
                                </a>
                            </div>
                            <div class="image-cap">
                                <span>
                                    <i class="fa fa-calendar"></i>
                                    {{ $Persian->MyPersianDate($RelatedPost->CrateDate) }}
                                </span>
                                <a href="{{ $news_route }}">
                                    <h3> {{ $RelatedPost->Titel }}</h3>
                                </a>
                                <p>{!! str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($RelatedPost->Content), 400)) !!}</p>
                                <a href="{{$news_route }}"
                                    class="read-more">بیشتر بخوانید</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            @include('news.Layouts.SocialLinks')


        </div>
    </section>
    <!-- Blog Section -->
@endsection
