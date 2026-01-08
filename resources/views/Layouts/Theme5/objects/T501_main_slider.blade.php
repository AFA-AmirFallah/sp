<div class="top-slider-121837347 row mb-5">
    <aside class="sidebar col-lg-4 hidden-md order-2 pr-0 hidden-md">
        <!-- Start banner -->
        @foreach ($mobile_banners as $mobile_banner_sub)
            @if ($mobile_banner_sub->theme == 503)
                <div class="sidebar-inner dt-sl">
                    <div class="sidebar-banner">
                        <div class="row">
                            <div class="col-12 mb-1">
                                <div class="widget-banner">
                                    <a target="_blank"
                                        href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link1') }}">
                                        <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic1') }}"
                                            alt="side pic">
                                    </a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="widget-banner">
                                    <a target="_blank"
                                        href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link2') }}">
                                        <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic2') }}"
                                            alt="side pic 2">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <!-- End banner -->
    </aside>
    <div class="col-lg-8 col-md-12 order-1">
        @php
            $pic1 = App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic1');
            $pic2 = App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic2');
            $pic3 = App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic3');
            $pic_count = 0;
            if ($pic1 != '#') {
                $pic_count++;
            }
            if ($pic2 != '#') {
                $pic_count++;
            }
            if ($pic3 != '#') {
                $pic_count++;
            }

        @endphp
        <!-- Start main-slider -->
        <section id="main-slider" class="main-slider main-slider-cs mt-1 carousel slide carousel-fade card hidden-sm"
            data-ride="carousel">
            <ol class="carousel-indicators">
                @for ($counter = 0; $counter <= 2; $counter++)
                    @if ($counter == 0)
                        <li data-target="#main-slider" data-slide-to="{{$counter}}" class="active"></li>
                    @else
                        <li data-target="#main-slider" data-slide-to="{{$counter}}"></li>
                    @endif
                @endfor
            </ol>
            <div class="carousel-inner">
                @if ($pic1 != '#')
                    <div class="carousel-item active">
                        <a target="_blank" class="main-slider-slide"
                            href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link1') }}">
                            <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic1') }}"
                                alt="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'text1') }}"
                                class="img-fluid">
                        </a>
                    </div>
                @endif
                @if ($pic2 != '#')
                    <div class="carousel-item ">
                        <a target="_blank" class="main-slider-slide"
                            href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link2') }}">
                            <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic2') }}"
                                alt="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'text2') }}"
                                class="img-fluid">
                        </a>
                    </div>
                @endif
                @if ($pic3 != '#')
                    <div class="carousel-item ">
                        <a target="_blank" class="main-slider-slide"
                            href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link3') }}">
                            <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic3') }}"
                                alt="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'text3') }}"
                                class="img-fluid">
                        </a>
                    </div>
                @endif

            </div>
            <a class="carousel-control-prev" href="#main-slider" role="button" data-slide="prev">
                <i class="mdi mdi-chevron-right"></i>
            </a>
            <a class="carousel-control-next" href="#main-slider" data-slide="next">
                <i class="mdi mdi-chevron-left"></i>
            </a>
        </section>
        @foreach ($mobile_banners as $mobile_banner_sub)
            @if ($mobile_banner_sub->theme == 502)
                <section id="main-slider-res" class="main-slider carousel slide carousel-fade card d-none show-sm"
                    data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#main-slider-res" data-slide-to="0" class="active"></li>
                        <li data-target="#main-slider-res" data-slide-to="1"></li>
                        <li data-target="#main-slider-res" data-slide-to="2"></li>

                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a target="_blank" class="main-slider-slide"
                                href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link1') }}">
                                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic1') }}"
                                    alt="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'text1') }}"
                                    class="img-fluid">
                            </a>
                        </div>
                        <div class="carousel-item ">
                            <a target="_blank" class="main-slider-slide"
                                href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link2') }}">
                                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic2') }}"
                                    alt="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'text2') }}"
                                    class="img-fluid">
                            </a>
                        </div>
                        <div class="carousel-item ">
                            <a target="_blank" class="main-slider-slide"
                                href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link3') }}">
                                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic3') }}"
                                    alt="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'text3') }}"
                                    class="img-fluid">
                            </a>
                        </div>

                    </div>
                    <a class="carousel-control-prev" href="#main-slider-res" role="button" data-slide="prev">
                        <i class="mdi mdi-chevron-right"></i>
                    </a>
                    <a class="carousel-control-next" href="#main-slider-res" data-slide="next">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>
                </section>
            @endif
        @endforeach
        <!-- End main-slider -->
    </div>
</div>
<!-- End Main-Slider -->
</div>
