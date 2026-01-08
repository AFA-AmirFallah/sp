@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')
@section('MainTitle')
    {{ $posts->Titel }} | {{ \App\myappenv::CenterName }}
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
    <!-- Start All Page Banner -->
    <section class="all-page-banner item-two">
        <div class="d-table">
            <div class="d-tablecell">
                <div class="container">
                    <div class="banner-text text-center">
                        <h1>{{ $posts->Titel }}</h1>
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">صفحه اصلی</a>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                            </li>
                            <li>اخبار</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End All Page Banner -->

    <!-- Start Blog Details Area -->
    <section class="blog-details-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="blog-details">
                        <div class="article-image">
                            <img src="{{ $posts->MainPic }}" alt="{{ $posts->Titel }}">
                            @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                <a style="float: left;" href="{{ route('EditNews', [$posts->id]) }}"><i
                                        class="fa fa-pencil"></i></a>
                                <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                            @endif
                        </div>

                        <div class="article-content">
                            <div class="entry-meta">
                                <ul>
                                    <li>
                                        <i class="fa fa-user"></i>
                                        توسط: <a href="">{{ $posts->ExtWriter }}</a>
                                    </li>

                                    <li>{{ $Persian->MyPersianDate($posts->CrateDate) }}</li>

                                    <li><a href="#">{{ $posts->CommentCount }} نظر</a></li>
                                </ul>
                            </div>
                            @if ($posts->Abstract != null)
                                <blockquote class="wp-block-quote">
                                    <p>{!! $posts->Abstract !!}</p>
                                </blockquote>
                            @endif
                            {!! $posts->Content !!}

                            <div class="article-footer">
                                <div class="article-tags">
                                    <span><i class="fa fa-bookmark"></i></span>
                                    @foreach ($Tags as $Tag)
                                        <a href="{{ route('newscat', ['newscat' => $Tag->Name]) }}"
                                            class="tag">{{ $Tag->Name }} </a>
                                    @endforeach
                                </div>

                                <div class="article-share">
                                    <ul class="social">
                                        <li><a href="whatsapp://send?text={{ url()->current() . '   ' . $posts->Titel }}"
                                                target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="http://twitter.com/share?url={{ url()->current() }}&text={{ $posts->Titel }}&hashtags=simplesharebuttons"
                                                target="_blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="https://www.instagram.com/?url={{ url()->current() }}"
                                                target="_blank"><i class="fa fa-instagram"></i></a></li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                        <hr>
                        @if ('test' == '12')
                            <div class="row">
                                @php
                                    $file_src = App\Deal\DealBase::get_deals_with_cat($posts->MainIndex);
                                    $file_id = 0;
                                @endphp
                                @foreach ($file_src as $file_item)
                                    @if ($file_item->id != $file_id)
                                        @include('Layouts.Theme6.Layout.deal_item', ['height' => 6])


                                        @php
                                            $file_id = $file_item->id;
                                        @endphp
                                    @else
                                    @endif
                                @endforeach
                                @if ($file_id == 0)
                                @endif
                            </div>
                        @endif

                        <div class="comments-area">
                            @if ($Views == null)
                                <div class="comments-title">
                                    هنوز دیدگاهی ثبت نشده است!
                                </div>
                            @else
                                <div class="comment-list">

                                    @foreach ($Views as $View)
                                        <form method="POST" id="comment_form" class="comment-form">
                                            @csrf
                                            <div class="comment">
                                                <div class="comment-body">
                                                    <footer class="comment-meta">
                                                        <div class="comment-author vcard">
                                                            <img src="/news/images/news/user1.png" class="avatar"
                                                                alt="image">
                                                            <b class="fn">
                                                                @if ($View->name == null)
                                                                    {{ $View->RegsterUserName }}
                                                                    {{ $View->RegsterUserFamily }}
                                                                @else
                                                                    {{ $View->name }}
                                                                @endif
                                                            </b>
                                                            <span class="says">می گوید:</span>
                                                        </div>

                                                        <div class="comment-metadata">
                                                            <a href="#">
                                                                <span>{{ $Persian->MyPersianDate($View->created_at, false) }}</span>
                                                            </a>
                                                        </div>
                                                    </footer>
                                                    <div class="comment-content">
                                                        <p>{{ $View->message }}</p>
                                                    </div>
                                                    @if ($UserLogin == 'admin')
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
                                                                type="submit" name="Delete_view"
                                                                value="{{ $View->id }}"><i class="fa fa-ban"></i>
                                                            </button>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </form>
                                    @endforeach
                                </div>
                            @endif

                            <div class="comment-respond">
                                <h3 class="comment-reply-title">نظر دهید</h3>

                                <form method="POST" id="comment_form" class="comment-form">
                                    @csrf
                                    <p class="comment-notes">
                                        <span id="email-notes">آدرس ایمیل شما منتشر نخواهد شد.</span>
                                        قسمتهای موردنیاز مشخص شده اند
                                        <span class="required">*</span>
                                    </p>
                                    <p class="comment-form-comment">
                                        <label>نظر <span style="color: red" class="required">*</span></label>
                                        <textarea name="message" id="comment" cols="45" rows="5" maxlength="65525" required></textarea>
                                    </p>
                                    <p class="comment-form-author">
                                        <label>نام <span style="color: red" class="required">*</span></label>
                                        <input type="text" id="author" name="name" required>
                                    </p>
                                    <p class="comment-form-email">
                                        <label>تلفن همراه <span style="color: red" class="required">*</span></label>
                                        <input type="text" inputmode="numeric" id="email" name="MobileNumber"
                                            required>
                                    </p>
                                    <p class="form-submit">
                                        <button class="custom-btn2" name="view_submit" value="{{ $posts->id }}"
                                            type="submit">
                                            ارسال دیدگاه
                                        </button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-lg-4">
                    <div class="right-shop">
                        <div class="top-rated-products">
                            <div class="products-box">
                                <div class="pro-title">
                                    <h3>پربازدیدترین مطالب</h3>
                                </div>
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
                                    @if ($posts->id != $LastPost->id)
                                        <div class="product-wrapper">
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <div class="single-product">
                                                        <a href="{{ $news_route }}">
                                                            <h3>{{ strip_tags($LastPost->Titel) }}</h3>
                                                        </a>
                                                        <div class="price">
                                                            <span>{{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="single-product single-product-image">
                                                        <img class="lazy" data-src="{{ $LastPost->MainPic }}"
                                                            alt="{{ strip_tags($LastPost->Titel) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="top-rated-products">
                            <div class="products-box">
                                <div class="pro-title">
                                    <h3>جدید ترین مطالب</h3>
                                </div>
                                @foreach ($DataSource->LastPosts() as $LastPost)
                                    @if ($posts->id != $LastPost->id)
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
                                        <div class="product-wrapper">
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <div class="single-product">
                                                        <a href="{{ $news_route }}">
                                                            <h3>{{ strip_tags($LastPost->Titel) }}</h3>
                                                        </a>
                                                        <div class="price">
                                                            <span>{{ $Persian->MyPersianDate($LastPost->CrateDate) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="single-product single-product-image">
                                                        <img class="lazy" data-src="{{ $LastPost->MainPic }}"
                                                            alt="{{ strip_tags($LastPost->Titel) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


@endsection
