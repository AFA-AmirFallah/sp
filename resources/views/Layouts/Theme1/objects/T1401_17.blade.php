<div class="intro-wrapper mt-4">
    <div class="owl-carousel owl-theme owl-dot-inner animation-slider row cols-1 gutter-no"
        data-owl-options="{
        'nav':  false,
        'dots': true,
        'autoplay': true,
        'autoplayTimeout': 8000,
        'loop': true,
        'margin': 0,
        'responsive': {
            '0': {
                'items': 1
            }
        }
    }"
        style="animation-duration: 0.8s;">
        <div class="banner banner-fixed  br-sm">
            <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link1') }}">

                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic1') }}"
                    style=" background-color:{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'color1') }} ;">
            </a>
            <div class="banner-content y-50 text-right">
                <div class="slide-animate"
                    data-animation-options="{
                    'name': 'fadeInUpShorter', 'duration': '1s'
                }">
                    {!! App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'text1') !!}
                </div>
            </div>
        </div>
        <div class="banner banner-fixed  br-sm">
            <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link2') }}">
                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic2') }}"
                    style=" background-color:{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'color2') }} ;">
            </a>
            <div class="banner-content y-50 text-right">
                <div class="slide-animate"
                    data-animation-options="{
                    'name': 'fadeInUpShorter', 'duration': '1s'
                }">
                    {!! App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'text2') !!}
                </div>
            </div>
        </div>
        <div class="banner banner-fixed  br-sm">
            <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link3') }}">
                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic3') }}"
                    style=" background-color:{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'color3') }} ;">
            </a>
            <div class="banner-content y-50 text-right">
                <div class="slide-animate"
                    data-animation-options="{
                    'name': 'fadeInUpShorter', 'duration': '1s'
                }">
                    {!! App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'text3') !!}
                </div>
            </div>
        </div>




    </div>
    <!-- End of Owl Carousel -->
</div>
