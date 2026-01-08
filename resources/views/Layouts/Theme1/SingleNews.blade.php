@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')
@section('MainTitle')
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="{{ $posts->Titel }}" />
    <meta property="og:url" content="{{ \App\myappenv::SiteAddress }}/{{ Request::path() }}" />
    <meta property="og:site_name" content="{{ \App\myappenv::CenterName }}" />
    <meta property="og:image" content="" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection
@section('ExtraTags')
@endsection
@section('MainContent')
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ route('home') }}">صفحه اصلی </a></li>
                <li><a href="{{ route('NewsHome') }}">وبلاگ </a></li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of Page Content -->
    <div class="page-content mb-8">
        <div class="container">
            <div class="row gutter-lg">
                <div class="main-content post-single-content">
                    <div class="post post-grid post-single">
                        <figure class="post-media br-sm">
                            <img src="{{ $posts->MainPic }}" alt="{{ $posts->Titel }}" width="930" height="500" />
                        </figure>
                        <div class="post-details">
                            <div class="post-meta">
                                توسط <a href="#" class="post-author">{{ $posts->ExtWriter }}</a>
                                - <a href="#" class="post-date">{{ $Persian->MyPersianDate($posts->CrateDate) }}</a>
                                <a href="#" class="post-comment"><i
                                        class="w-icon-comments"></i><span>{{ $posts->CommentCount }}</span>نظرات
                                </a>
                            </div>
                            <h2 class="post-title">
                                @if ($posts->UpTitel != null)
                                    <div class="post-uptitle">{{ $posts->UpTitel }}</div>
                                @endif
                                {{ $posts->Titel }}
                                @if ($posts->SubTitel != null)
                                    <div class="post-subtitle">{{ $posts->SubTitel }}</div>
                                @endif
                            </h2>
                            @if ($posts->Abstract != null)
                                <blockquote class="text-center mb-8">
                                    <i class="fas fa-quote-left"></i>
                                    <p class="font-weight-bold text-dark mt-1 mb-2">{!! $posts->Abstract !!}</p>
                                </blockquote>
                            @endif
                            <div style="text-align: justify" class="post-content">
                                {!! $posts->Content !!}
                            </div>
                        </div>
                    </div>
                    @if ($Tags != null)
                        <div class="tags">
                            <label class="text-dark mr-2">برچسب ها :</label>
                            @foreach ($Tags as $Tag)
                                <a href="{{ route('newscat', ['newscat' => $Tag->Name]) }}"
                                    class="tag">{{ $Tag->Name }} </a>
                            @endforeach
                        </div>
                    @endif

             
                    <!-- End Social Links -->
                    @if ($posts->PostContent != null)
                        <div class="post-author-detail">
                            <div class="author-details">
                                <div class="author-name-wrapper flex-wrap mb-2">
                                    <h4 class="author-name font-weight-bold mb-2 pr-4 mr-auto"> پی نوشت:
                                    </h4>
                                </div>
                                <p style="text-align: justify" class="mb-0"> {{ $posts->PostContent }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($Relatednews != null)
                        <h4 class="title title-lg font-weight-bold mt-10 pt-1 mb-5">مطالب مرتبط </h4>
                        <div class="post-slider owl-carousel owl-theme owl-nav-top row cols-lg-3 cols-md-4 cols-sm-3 cols-xs-2 cols-1 pb-2"
                            data-owl-options="{
                                'nav': true,
                                'dots': false,
                                'margin': 20,
                                'responsive': {
                                    '0': {
                                        'items': 1
                                    },
                                    '576': {
                                        'items': 2
                                    },
                                    '768': {
                                        'items': 3
                                    },
                                    '992': {
                                        'items': 2
                                    },
                                    '1200': {
                                        'items': 3
                                    }
                                }
                            }">

                            @foreach ($Relatednews as $RelatednewsItem)
                                <div class="post post-grid">
                                    <figure class="post-media br-sm">
                                        <a href="{{ Route('ShowNewsItem', $RelatednewsItem->id) }}">
                                            <img src="{{ $RelatednewsItem->MainPic }}"
                                                alt="{{ $RelatednewsItem->Titel }}" width="296" height="190"
                                                style="background-color: #bcbcb4;" />
                                        </a>
                                    </figure>
                                    <div class="post-details text-center">
                                        <div class="post-meta">
                                            توسط <a href="#" class="post-author">جعفر عباسیخان</a>
                                            - <a href="#"
                                                class="post-date">{{ $Persian->MyPersianDate($RelatednewsItem->created_at, true) }}</a>
                                        </div>
                                        <h4 class="post-title mb-3"><a
                                                href="{{ Route('ShowNewsItem', $RelatednewsItem->id) }}">{{ $RelatednewsItem->Titel }}</a>
                                        </h4>
                                        <a href="{{ Route('ShowNewsItem', $RelatednewsItem->id) }}"
                                            class="btn btn-link btn-dark btn-underline font-weight-normal">ادامه مطلب <i
                                                class="w-icon-long-arrow-left"></i></a>
                                    </div>
                                </div>
                            @endforeach

                        </div><!-- Carousel end -->
                    @endif


                    @if ($UserLogin != 'admin')
                        <ul class="comments list-style-none pl-0">
                            @if ($Views == null)
                                <div style="font-size: 9px;color: #7b7b7b;" class="entry-content">
                                    هنوز دیدگاهی ثبت نشده است!
                                </div>
                            @else
                                @foreach ($Views as $View)
                                    <li class="comment">
                                        <div class="comment-body">
                                            <figure class="comment-avatar">
                                                <img src="/news/images/news/user1.png" alt="Avatar" width="90"
                                                    height="90" />
                                            </figure>
                                            <div class="comment-content">
                                                <h4 class="comment-author font-weight-bold">
                                                    <a href="#">
                                                        @if ($View->name == null)
                                                            {{ $View->RegsterUserName }}
                                                            {{ $View->RegsterUserFamily }}
                                                        @else
                                                            {{ $View->name }}
                                                        @endif
                                                    </a>
                                                    <span
                                                        class="comment-date">{{ $Persian->MyPersianDate($View->created_at, false) }}
                                                    </span>
                                                </h4>
                                                <p>{{ $View->message }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    @else
                        @foreach ($Views as $View)
                            <form method="post">
                                @csrf
                                <li class="comment">
                                    <div class="comment-body">
                                        <figure class="comment-avatar">
                                            <img src="/news/images/news/user1.png" alt="Avatar" width="90"
                                                height="90" />
                                        </figure>
                                        <div class="comment-content">
                                            <h4 class="comment-author font-weight-bold">
                                                <a href="#">
                                                    @if ($View->name == null)
                                                        {{ $View->RegsterUserName }}
                                                        {{ $View->RegsterUserFamily }}
                                                    @else
                                                        {{ $View->name }}
                                                    @endif
                                                </a>
                                                <span
                                                    class="comment-date">{{ $Persian->MyPersianDate($View->created_at, false) }}
                                                </span>
                                            </h4>
                                            <p>{{ $View->message }}</p>
                                            <div class="text-right">
                                                @if ($View->Status == 1)
                                                    <button type="submit" name="publish_view"
                                                        value="{{ $View->id }}">انتشار
                                                    </button>
                                                    <button type="submit"
                                                        style="color: red;border: none;background: border-box;"
                                                        name="Delete_view" value="{{ $View->id }}"><i
                                                            class="fa fa-ban"></i>
                                                    </button>
                                                @elseif($View->Status == 100)
                                                    <textarea class="form-control required-field" name="message" id="message" placeholder="پاسخ شما" required></textarea>
                                                    <button type="submit"
                                                        style="color: green;border: none;background: border-box;"
                                                        name="publish_answer" value="{{ $View->id }}"><i
                                                            class="fa fa-check"></i></button>
                                                    <button style="color: red;border: none;background: border-box;"
                                                        type="submit" name="Delete_view" value="{{ $View->id }}"><i
                                                            class="fa fa-ban"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>


                            </form>

                        @endforeach
                    @endif
                    <!-- End Comments -->
                    <form class="reply-section pb-4">
                        <h4 class="title title-md font-weight-bold pt-1 mt-10 mb-0">ارسال پیام </h4>
                        <p>آدرس ایمیل شما منتشر نخواهد شد. فیلدهای مورد نیاز علامت گذاری شده است</p>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <input type="text" name="name" required class="form-control" placeholder="نام خود را وارد کنید "
                                    id="name">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <input type="text" required name="WriterEmail" class="form-control" placeholder="ایمیل خود را وارد کنید "
                                    id="email_1">
                            </div>
                        </div>
                        <textarea cols="30" name="message" required rows="6" placeholder="نوشتن  پیام" class="form-control mb-4" id="comment"></textarea>
                        <button type="submit" class="btn btn-dark btn-rounded btn-icon-right btn-comment">ارسال پیام<i
                                class="w-icon-long-arrow-left"></i></button>
                    </form>
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
                           
                            <!-- End of Widget categories -->
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
                            <!-- End of Widget posts -->
                            
                            <!-- End of Widget custom block -->
                         
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <!-- End of Page Content -->
@endsection
