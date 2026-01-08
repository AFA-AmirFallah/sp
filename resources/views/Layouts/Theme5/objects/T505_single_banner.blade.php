<div class="container main-container">
    <div class="row mt-3 mb-5">
        <div class="col-12">
            <div class="widget-banner">
                <a target="_blank" href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link1') }}">
                    <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic1') }}"
                        alt="{{ $mobile_banner->title }}">
                </a>
            </div>
        </div>
    </div>
</div>
