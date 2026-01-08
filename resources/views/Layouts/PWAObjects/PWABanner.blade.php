@if (\App\myappenv::SiteTheme == 'kookbaz')
    <style>
        .kookbaz_banner {
            margin-bottom: 20px;
        }

    </style>
@endif

@if (\App\myappenv::SiteTheme == 'kookbaz')
    <div class="row kookbaz_banner">
    @else
        <div class="row" style="margin-bottom: 20px">
@endif

<div class="carousel_wrap col-md-12">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        @if (\App\myappenv::SiteTheme == 'kookbaz')
            <div class="carousel-inner">
            @else
                <div class="carousel-inner" style="border-radius: 10px">
        @endif
            @php
                $bannerCount = 0;
                $initslide = true;
            @endphp
            @foreach ($mobile_banners as $mobile_banner)
                @if ($mobile_banner->theme == 1)
                    @php
                        $bannerCount++;
                    @endphp
                    @if ($initslide)
                        <div class="carousel-item active">
                            <a href="{{ $mobile_banner->link }}">
                                <img class="d-block w-100" src="{{ $mobile_banner->pic }}"
                                    alt="{{ $mobile_banner->title }}">
                            </a>
                        </div>
                        @php
                            $initslide = false;
                        @endphp
                    @else
                        <div class="carousel-item">
                            <a href="{{ $mobile_banner->link }}">
                                <img class="d-block w-100" src="{{ $mobile_banner->pic }}"
                                    alt="{{ $mobile_banner->title }}">
                            </a>
                        </div>
                    @endif
                @endif
            @endforeach

        </div>
        <ol class="carousel-indicators">

        </ol>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">قبلی</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">بعدی</span>
        </a>
    </div>
</div>
</div>
