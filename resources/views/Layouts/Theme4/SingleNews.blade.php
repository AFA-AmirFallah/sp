@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme4.Layout.mian_layout_shafatel')
@section('MainTitle')
    {{ $posts->Titel }}
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
@section('description')
    {{ $posts->description }}
@endsection
@section('MainContent')
    <div class="st-blog-wrap st-section" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="post">
                        <header class="entry-header">
                            @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                <a style="float: left;" href="{{ route('EditNews', [$posts->id]) }}"><i
                                        class="fa fa-pencil"></i>ویرایش</a>
                                <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i>افزودن </a>
                            @endif
                            <div class="post-thumbnail">
                                <img src="{{ $posts->MainPic }}" alt="{{ $posts->Titel }}">
                            </div>
                            <div class="post-details-wrap-outer">
                                <div class="post-details-wrap">
                                    <h2 class="entry-title">{{ $posts->Titel }}</h2>
                                    <div class="byline">
                                        <span class="author">
                                            <a href="" class=""><i
                                                    class="fa fa-user"></i>{{ $posts->ExtWriter ?? 'تیم تولید محتوا' }}</a>
                                        </span>
                                        <span class="posted-on"><i
                                                class="fa fa-calendar"></i>{{ $Persian->MyPersianDate($posts->CrateDate) }}</span>
                                        @if ($Tags != null)
                                            <span><i class="fa fa-tag"></i>
                                                @foreach ($Tags as $Tag)
                                                    <a href="{{ route('newscat', ['newscat' => $Tag->Name]) }}">
                                                        #{{ $Tag->Name }}</a>
                                                @endforeach
                                            </span>
                                        @endif

                                    </div>
                                </div>
                            </div><!-- .post-details-wrap-outer -->
                        </header><!-- .entry-header -->
                        @if ($posts->Abstract != null)
                            <blockquote class="text-center mb-8">
                                <i class="fas fa-quote-left"></i>
                                <p class="font-weight-bold text-dark mt-1 mb-2">{!! $posts->Abstract !!}</p>
                            </blockquote>
                        @endif
                        <div class="entry-content">
                            @if (!Auth::check() && $posts->ContentAccessLevel == 0)
                                {!! $posts->Content !!}
                            @elseif (Auth::check() && $posts->ContentAccessLevel <= Auth::user()->Role)
                                @if ($for_buy_news['is_buyable'] && !$for_buy_news['buy_before'])
                                    <div class="col-xl mb-lg-0 lg-4">
                                        <div class="card border border-2 border-primary">
                                            <div class="card-body">
                                                <div
                                                    class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                                    <h5 class="text-start text-uppercase mb-0">دسترسی به محتوای این صفحه
                                                        نیاز به پرداخت دارد</h5>
                                                    <span class="badge bg-primary rounded-pill">محتوای قابل خرید</span>
                                                </div>

                                                <div class="text-center position-relative mb-4 pb-3">
                                                    <div class="d-flex">
                                                        <h1 class="price-toggle text-primary price-yearly mb-0">
                                                            {{ number_format($for_buy_news['price']) }} <small>ریال</small>
                                                        </h1>

                                                        <sub class="h5 text-muted pricing-duration mt-auto mb-3"> /
                                                            دسترسی نا محدود</sub>
                                                    </div>
                                                    <small
                                                        class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">با
                                                        یک بار پرداخت میتوانید به صورت نامحدود این صفحه را بازدید
                                                        کنید!</small>
                                                </div>
                                                <p>امکانات این صفحه پس از پرداخت</p>

                                                <hr>

                                                <ul class="list-unstyled pt-2 pb-1 lh-1-85">
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        بازدید نا محدود از این صفحه
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        بازدید از تغییرات و به روز رسانی های این صفحه
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        پشتیبانی در صورت بروز مشکل
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        استفاده دیگر کاربران
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        اشتراک گذاشتن محتوا یا کپی از آن
                                                    </li>
                                                </ul>
                                                <form method="POST">
                                                    @csrf
                                                    <button class="btn btn-primary d-grid w-100" type="submit"
                                                        name="submit" value="pay">پرداخت</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                @elseif($for_buy_news['is_buyable'] && $for_buy_news['buy_before'])
                                    <span class="badge bg-success rounded-pill">خریداری شده</span>
                                    {!! $posts->Content !!}
                                @else
                                    {!! $posts->Content !!}
                                @endif
                            @else
                                <div class="alert alert-warning" role="alert">
                                    <h6 class="alert-heading mb-1">متن خبر برای کاربران ويژه می باشد!</h6>
                                    <span>جهت نمایش خبر
                                        <a href="{{ route('login') }}"> از اینجا</a>
                                        وارد سامانه شوید</span>
                                </div>
                            @endif
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
                        </div>
                    </article>
                </div>
                <aside class="col-lg-4">
                    <div class="st-sidebar st-right-sidebar">
                        <div class="widget widget_search">
                            <form method="get" class="search-form" action="#">
                                <label>
                                    <input type="search" class="search-field" placeholder="جستجو...">
                                </label>
                                <input type="submit" class="search-submit" value="Search">
                            </form>
                        </div><!-- .widget -->
                        <div class="widget widget_recent_entries">
                            <h2 class="widget-title">آخرین مطالب</h2>
                            <ul>
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
                                    <li>
                                        <a href="{{ $news_route }}">
                                            <img src="{{ $LastPost->MainPic }}" alt="{{ $LastPost->Titel }}">
                                            <div class="r-post-head">
                                                <h2>{{ strip_tags($LastPost->Titel) }}</h2>
                                                <span>{{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- .widget -->
                        <div class="widget widget_recent_entries">
                            <h2 class="widget-title">پربازدید ترین</h2>
                            <ul>
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
                                    <li>
                                        <a href="{{ $news_route }}">
                                            <img src="{{ $LastPost->MainPic }}" alt="{{ $LastPost->Titel }}">
                                            <div class="r-post-head">
                                                <h2>{{ strip_tags($LastPost->Titel) }}</h2>
                                                <span>{{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- .widget -->
                    </div>
                </aside>
            </div>
        </div>
    </div>




@endsection
