<div class="row grid grid-float pt-2 banner-grid mb-9 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
    <div class="grid-item col-lg-6 height-x2">
        <div class="banner banner-fixed banner-lg br-sm">
            <figure>
                <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link1') }}">

                    <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic1') }}" alt="Banner" width="670" height="450" style="background-color: #E3E7EA;">

                </a>

            </figure>

        </div>
    </div>
    <div class="grid-item col-lg-6 height-x1">
        <div class="banner banner-fixed banner-md br-sm">
            <figure>
                <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link2') }}">

                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic2') }}" alt="Banner" width="670" height="450" style="background-color: #2D2E32;">
                </a>
            </figure>

        </div>
    </div>
    <div class="grid-item col-sm-6 col-lg-3 height-x1">
        <div class="banner banner-fixed banner-sm br-sm">
            <figure>
                <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link3') }}">

                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic3') }}" alt="Banner" width="330" height="215" style="background-color: #181818;">
                </a>
            </figure>

        </div>
    </div>
    <div class="grid-item col-sm-6 col-lg-3 height-x1">
        <div class="banner banner-fixed banner-sm br-sm">
            <figure>
                <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link4') }}">

                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic4') }}" alt="Banner" width="330" height="215" style="background-color: #A3A8A6;">
                </a>
            </figure>

        </div>
    </div>
</div>






