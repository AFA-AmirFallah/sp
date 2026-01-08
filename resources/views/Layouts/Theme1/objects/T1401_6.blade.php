@php
$Src = json_decode($mobile_banner->pic);
@endphp
<div class="owl-carousel owl-theme category-banner-3cols row cols-lg-3 cols-sm-2 cols-1 pt-2 pb-10"
    data-owl-options="{
                'nav': false,
                'dots': true,
                'margin': 20,
                'responsive': {
                    '0': {
                        'items': 1
                    },
                    '576': {
                        'items': 2
                    },
                    '992': {
                        'items': 3
                    }
                }
            }">
    <div class="banner banner-fixed category-banner br-sm">
        <figure>
            <img src="{{ $Src->pic1 }}" alt="دسته بنر" width="447" height="230"
                style="background-color: {{ $Src->color1 }};" />
        </figure>
        <div class="banner-content y-50">
            {!! $Src->txt1 !!}
        </div>
    </div>

    <div class="banner banner-fixed category-banner br-sm">
        <figure>
            <img src="{{ $Src->pic2 }}" alt="دسته بنر" width="447" height="230"
                style="background-color: {{ $Src->color2 }};" />
        </figure>
        <div class="banner-content y-50">
            {!! $Src->txt2 !!}
        </div>
    </div>
    <!-- End of Category Banner -->
    <div class="banner banner-fixed category-banner br-sm">
        <figure>
            <img src="{{ $Src->pic3 }}" alt="دسته بنر" width="447" height="230"
                style="background-color: {{ $Src->color3 }};" />
        </figure>
        <div class="banner-content y-50">
            {!! $Src->txt3 !!}
        </div>
    </div>

    <!-- End of Category Banner -->
</div>
<!-- End of Owl Carousel -->
