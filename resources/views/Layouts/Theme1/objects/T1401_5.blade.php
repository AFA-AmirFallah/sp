<div class="owl-carousel owl-theme row cols-md-4 cols-sm-3 cols-1 icon-box-wrapper appear-animate br-sm mb-5 appear-animate mt-5"
    data-owl-options="{
'nav': false,
'dots': false,
'loop': true,
'autoplay': true,
'autoplayTimeout': 8000,
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
        'items': 3
    },
    '1200': {
        'items': 4
    }
}
}">
    <div class="icon-box icon-box-side text-dark">
        <span class="icon-box-icon icon-shipping">
            <i class="w-icon-truck"></i>
        </span>
        <div class="icon-box-content">
            <h4 class="icon-box-title"> {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title4') }} </h4>
            <p class="text-default">{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'subtitle4') }}     </p>
        </div>
    </div>
    <div class="icon-box icon-box-side text-dark">
        <span class="icon-box-icon icon-payment">
            <i class="w-icon-bag"></i>
        </span>
        <div class="icon-box-content">
            <h4 class="icon-box-title">{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title3') }}   </h4>
            <p class="text-default">     {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'subtitle3') }} </p>
        </div>
    </div>
    <div class="icon-box icon-box-side text-dark icon-box-money">
        <span class="icon-box-icon icon-money">
            <i class="w-icon-money"></i>
        </span>
        <div class="icon-box-content">
            <h4 class="icon-box-title">  {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title2') }} </h4>
            <p class="text-default">      {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'subtitle2') }} </p>
        </div>
    </div>
    <div class="icon-box icon-box-side text-dark icon-box-chat">
        <span class="icon-box-icon icon-chat">
            <i class="w-icon-chat"></i>
        </span>
        <div class="icon-box-content">
            <h4 class="icon-box-title"> {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title1') }} </h4>
            <p class="text-default">    {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'subtitle1') }}   </p>
        </div>
    </div>
</div>
