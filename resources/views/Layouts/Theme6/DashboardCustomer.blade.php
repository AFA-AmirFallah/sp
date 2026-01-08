@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')
@section('content')
    <style>
        .main-slider .single-slider-item.item-bg-two {
            background-image: url(../img/slider/2.jpg)
        }
    </style>

    @foreach ($mobile_banners as $mobile_banner)
        @if ($mobile_banner->theme == 1)
            <div class="item">
                @if ($DataSource->IsAdminLogin())
                    <a style="position: absolute;left: 32px;z-index: 20;" href="{{ route('BannerManagement') }}"
                        target="_blank"> <i class="fa fa-pencil"></i> </a>
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
    @foreach ($mobile_banners as $mobile_banner)
        @if ($mobile_banner->theme == 601)
            <!-- Top Sliders -->
            @include('Layouts.Theme6.objects.T601_main_slider')
        @endif
    @endforeach

    <!-- End Main Slider -->

    <!-- Start Offer Section -->
    <section class="offer-section pt-100 pb-70">
        <div class="container">
            <div class="row">
                {!! App\Functions\AppSetting::get_html_obj('Theme6_3box') !!}
            </div>
        </div>
    </section>
    <!-- End Section -->

    <!-- Start About Section -->
    <section class="about-section pb-100">
        {!! App\Functions\AppSetting::get_html_obj('Theme6_aboutUs') !!}
    </section>
    <!-- End About Section -->

    <!-- Start Recently Added -->


    <!-- End Recently Added -->

    <!-- Start Latest Motors -->
    @php
        $dial_src = App\Deal\DealFiles::get_deal_info(4, 'DESC');

    @endphp
    <section class="latest-motors pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>جدید ترین آگهی های رایان دیزل</h2>
                <p>خودروهای کارشناسی شده رایان دیزل را مشاهده کنید</p>
                <span>لیست خودرو</span>
            </div>
            <div class="row">
                @foreach ($dial_src as $file_item)
                    @include('Layouts.Theme6.Layout.deal_item')
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Latest Motors -->

    <!-- Start Services Section -->
    @php
        $section_content = App\Functions\AppSetting::get_html_obj('Theme6_OurServices');

    @endphp
    @if ($section_content != null)
        <section class="services-section2 ptb-100">
            {!! $section_content !!}
        </section>
    @endif
    <!-- End Services Section  -->

    <!-- Start Mission Section  -->
    @php
        $section_content = App\Functions\AppSetting::get_html_obj('Theme6_MissionSection');

    @endphp
    @if ($section_content != null)
        <section class="mission-section ptb-100">
            {!! $section_content !!}
        </section>
    @endif
    <!-- End Mission Section  -->

    <!-- Start News Section -->
    <section class="news-section ptb-100">
        <div class="container">
            <div class="section-title text-center">
                <h2>پربازدید ترین خبر ها</h2>
                <p>پر بازدید ترین و مهم ترین اخبار در حوزه ماشین های سنگین و تجاری</p>
                <span>آخرین اخبار</span>
            </div>
            <div class="news-slider owl-carousel owl-theme">
                @php
                    $mostviewconter = 1;
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
                    <div class="single-news">
                        <div class="image">
                            <a href="{{ $news_route }}">
                                <img src="{{ $LastPost->MainPic }}" alt="{{ strip_tags($LastPost->Titel) }}">
                            </a>
                        </div>
                        <div class="image-cap">
                            <span>
                                <i class="fa fa-calendar"></i>
                                {{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                            </span>
                            <a href="{{ $news_route }}">
                                <h3>{{ strip_tags($LastPost->Titel) }}</h3>
                            </a>
                            <p>{{ $LastPost->description }}</p>
                            <a href="{{ $news_route }}" class="read-more">بیشتر بخوانید</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End News Section -->

    <!-- Start Logo Section -->
    <div class="logo-section">
        <div class="container">
            <div class="logo-slider owl-carousel owl-theme">
                <div class="single-logo">
                    <a href="https://rayandiesel.co/newscat/%DA%A9%D8%B4%D9%86%D8%AF%D9%87%20%D9%81%D9%88%D8%AA%D9%88%D9%86"
                        target="_blank">
                        <img src="https://rayandiesel.co/storage/photos/car-logo/69c348c4df0a872087ce59137dd5da15.png"
                            alt="foton">
                    </a>

                </div>
                <div class="single-logo">
                    <a
                        href="https://rayandiesel.co/newscat/%DA%A9%D8%A7%D9%85%DB%8C%D9%88%D9%86%D8%AA%20%D9%81%D9%88%D8%B1%D8%B3">
                        <img src="https://rayandiesel.co/storage/photos/car-logo/force_logo.png" alt="لوگوی فورس"></a>

                </div>
                <div class="single-logo">
                    <img src="https://rayandiesel.co/storage/photos/car-logo/%D8%AF%D8%A7%D9%86%DA%AF-%D9%81%D9%86%DA%AF.png"
                        alt="دانگ فنگ">
                </div>
                <div class="single-logo">
                    <img src="https://rayandiesel.co/storage/photos/car-logo/free-volvo-logo-icon-download-in-svg-png-gif-file-formats--brand-car-brands-pack-logos-icons-202923.png"
                        alt="ولوو">
                </div>
                <div class="single-logo">
                    <img src="https://rayandiesel.co/storage/photos/car-logo/scania.png" alt="اسکانیا">
                </div>
                <div class="single-logo">
                    <img src="https://rayandiesel.co/storage/photos/car-logo/بنز.png" alt="بنز">
                </div>
                <div class="single-logo">
                    <img src="https://rayandiesel.co/storage/photos/car-logo/%D9%81%D8%A7%D9%88.jpg" alt="فاو">
                </div>
            </div>
        </div>
    </div>
    <!-- Start End Logo Section -->

    <!-- Start Subscribe Section -->

    <!-- End Subscribe Section -->
@endsection
