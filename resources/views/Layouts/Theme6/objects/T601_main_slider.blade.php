<section class="main-slider owl-carousel owl-theme">
    @foreach ($mobile_banners as $mobile_banner_sub)
        @if ($mobile_banner_sub->theme == 601)
            @php
                $pic_1 = App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic1');
            @endphp
            @if ($pic_1 != '#')
                <div style="background-image: url({{ $pic_1 }})" class="single-slider-item">
                    <div class="d-table">
                        <div class="d-tablecell">
                            <div class="container">
                                <div class="slider-text">
                                    <div class="d-table">
                                        <div class="d-tablecell">
                                            <h1>{!! App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'text1') !!}</h1>

                                        </div>
                                    </div>
                                    <div class="slider-button">
                                        <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link1') }}"
                                            class="custom-btn1">ادامه مطلب</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @php
                $pic_2 = App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic2');
            @endphp
            @if ($pic_2 != '#')
                <div style="background-image: url({{ $pic_2 }})" class="single-slider-item">
                    <div class="d-table">
                        <div class="d-tablecell">
                            <div class="container">
                                <div class="slider-text">
                                    <div class="d-table">
                                        <div class="d-tablecell">
                                            <h1>{!! App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'text2') !!}</h1>

                                        </div>
                                    </div>
                                    <div class="slider-button">
                                        <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link2') }}"
                                            class="custom-btn1">ادامه مطلب</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @php
                $pic_3 = App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic3');
            @endphp
            @if ($pic_3 != '#')
                <div style="background-image: url({{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'pic3') }})"
                    class="single-slider-item">
                    <div class="d-table">
                        <div class="d-tablecell">
                            <div class="container">
                                <div class="slider-text">
                                    <div class="d-table">
                                        <div class="d-tablecell">
                                            <h1>{!! App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'text3') !!}</h1>

                                        </div>
                                    </div>
                                    <div class="slider-button">
                                        <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner_sub->pic, 'link3') }}"
                                            class="custom-btn1">ادامه مطلب</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach

</section>
