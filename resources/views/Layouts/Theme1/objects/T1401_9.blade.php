    <h2 class="title text-left pt-1 mb-5 appear-animate">{{ $mobile_banner->title }}</h2>
    <div class="category-wrapper owl-carousel owl-theme row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2 appear-animate"
        data-owl-options="{
'nav': false,
'dots': true,
'margin': 20,
'responsive': {
    '0': {
        'items': 2
    },
    '576': {
        'items': 3
    },
    '768': {
        'items': 4
    },
    '992': {
        'items': 5
    },
    '1200': {
        'items': 6
    }
}
}">
        @foreach (App\Functions\Themes::get_l3_same(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit')) as $TagTarget)
            <div class="category category-ellipse">
                <figure class="category-media">
                    <a href="{{ route('ShowProduct', ['Tags' => $TagTarget->UID]) }}">
                        <img src="{{ $TagTarget->img }}" alt="{{ $TagTarget->Name }}" width="190" height="190"
                            style="background-color:{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Backcolor') }} ;" />
                    </a>
                </figure>
                <div class="category-content">
                    <h4 class="category-name">
                        <a href="{{ route('ShowProduct', ['Tags' => $TagTarget->UID]) }}">{{ $TagTarget->Name }}
                        </a>
                    </h4>
                </div>
            </div>
        @endforeach

    </div>
