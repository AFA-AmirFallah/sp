@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')

@section('MainContent')
    <nav class="breadcrumb-nav mb-6">
        <div class="container">
            <ul class="breadcrumb">
                <li><a>صفحه اصلی </a></li>
                <li><a>وبلاگ </a></li>
                <li>لیست</li>
            </ul>
        </div>
    </nav>

    <div class="page-content mb-10 pb-2">
        <div class="container">
            <div class="row gutter-lg">
                <div class="main-content">
                    @foreach ($Article as $ArticleTarget)
                        <article class="post post-list post-listing mb-md-10 mb-6 pb-2 overlay-zoom mb-4">
                            <figure class="post-media br-sm">
                                <a href="{{ route('ShowNewsItem', ['NewsId' => $ArticleTarget->id]) }}">
                                    <img src="{{ $ArticleTarget->MainPic }}" width="930" height="500"
                                        alt="{{ $ArticleTarget->Titel }}">
                                </a>
                            </figure>
                            <div class="post-details">
                                <h4 class="post-title">
                                    <a
                                        href="{{ route('ShowNewsItem', ['NewsId' => $ArticleTarget->id]) }}">{{ $ArticleTarget->Titel }}</a>
                                </h4>
                                <div class="post-content">
                                    <p>{!! Str::limit(strip_tags($ArticleTarget->Content), 400) !!}</p>

                                    <a href="{{ route('ShowNewsItem', ['NewsId' => $ArticleTarget->id]) }}"
                                        class="btn btn-link btn-primary">(ادامه مطلب )</a>
                                </div>
                                <div class="post-meta">
                                    توسط <a href="#" class="post-author"> {{ $ArticleTarget->Writer }} </a>
                                    - <a href="#"
                                        class="post-date">{{ $Persian->MyPersianDate($ArticleTarget->CrateDate) }}</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <!-- End of Main Content -->
                <aside class="sidebar right-sidebar blog-sidebar sidebar-fixed sticky-sidebar-wrapper">
                    <div class="sidebar-overlay">
                        <a href="#" class="sidebar-close">
                            <i class="close-icon"></i>
                        </a>
                    </div>
                    <a href="#" class="sidebar-toggle">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <div class="sidebar-content">
                        <div class="sticky-sidebar">

                            <div class="widget widget-posts">
                                <h3 class="widget-title bb-no"> مطالب پر بازدید </h3>
                                <div class="widget-body">
                                    @foreach ($DataSource->MostViewPosts() as $LastPost)
                                        <div class="post-widget mb-4">
                                            <figure class="post-media br-sm">
                                                <img src="{{ $LastPost->MainPic }}" alt="" height="150" />
                                            </figure>
                                            <div class="post-details">
                                                <div class="post-meta">
                                                    <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}"
                                                        class="post-date">{{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                                                    </a>
                                                </div>
                                                <h4 class="post-title">
                                                    <a
                                                        href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                            @foreach ($DataSource->AdPosts() as $AdPostitem)
                                <div class="div" style="margin-top: 10px">
                                    @if ($AdPostitem->adds == 2)
                                        @php
                                            $BannerLink = strip_tags($AdPostitem->Titel);
                                        @endphp
                                        @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                            <a style="float: left;" href="{{ route('EditNews', [$AdPostitem->id]) }}"><i
                                                    class="fa fa-pencil"></i></a>
                                            <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i>
                                            </a>
                                        @endif

                                        <a href="{{ $BannerLink }}">
                                            <img class="banner img-responsive" src="{{ $AdPostitem->MainPic }}"
                                                alt="">
                                        </a>
                                    @elseif ($AdPostitem->adds == 1)
                                        @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                            <a style="float: left;" href="{{ route('EditNews', [$AdPostitem->id]) }}"><i
                                                    class="fa fa-pencil"></i></a>
                                            <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i>
                                            </a>
                                        @endif
                                        <a
                                            href="{{ route('ShowNewsItem', ['NewsId' => $AdPostitem->id, 'newsitem' => $AdPostitem->Titel]) }}">
                                            <img class="banner img-responsive" src="{{ $AdPostitem->MainPic }}"
                                                alt="">
                                        </a>
                                    @endif

                                </div>
                            @endforeach
                            <div class="widget widget-posts">
                                <h3 class="widget-title bb-no"> جدید ترین مطالب </h3>
                                <div class="widget-body">
                                    @foreach ($DataSource->LastPosts() as $LastPost)
                                        <div class="post-widget mb-4">
                                            <figure class="post-media br-sm">
                                                <img src="{{ $LastPost->MainPic }}" alt="" height="150" />
                                            </figure>
                                            <div class="post-details">
                                                <div class="post-meta">
                                                    <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}"
                                                        class="post-date">{{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                                                    </a>
                                                </div>
                                                <h4 class="post-title">
                                                    <a
                                                        href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>




                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection
