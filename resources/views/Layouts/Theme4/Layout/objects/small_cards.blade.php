@dd($mobile_banner)
<h2 class=" title  title-center mb-5">{{ $mobile_banner->title }}</h2>
<div class="owl-carousel owl-theme owl-shadow-carousel row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2 pb-10"
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
        <div class="category-wrap">
            <div class="category category-classic category-absolute overlay-zoom br-sm">
                <a href="{{ route('ShowProduct',['Tags'=>$TagTarget->UID]) }}">
                    <figure class="category-media">
                        <img src="{{ $TagTarget->img }}" alt="{{ $TagTarget->Name }}" width="213"
                            height="213" />
                    </figure>
                </a>
                <div class="category-content">
                    <h4 class="category-name ls-normal">{{ $TagTarget->Name }} </h4>
                    <a href="{{ route('ShowProduct',['Tags'=>$TagTarget->UID]) }}" class="btn btn-primary btn-link btn-underline">اکنون بخرید
                    </a>
                </div>
            </div>
        </div>
    @endforeach

</div>