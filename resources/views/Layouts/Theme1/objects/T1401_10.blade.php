<!--    140110 -->
@php
$Title = json_decode($mobile_banner->title);
@endphp
<div class="container mt-10 pt-2">
    <div class="title-link-wrapper mb-4 appear-animate">
        <h2 class="title mb-0 ls-normal appear-animate pb-1">{{ $Title->Title }}</h2>
        <a href="{{ route('ShowProduct', ['Tags' => $Title->TagUID]) }}" class="font-weight-bold ls-25">
            محصولات بیشتر <i class="w-icon-long-arrow-left"></i></a>
    </div>
    <div class="owl-carousel owl-theme owl-shadow-carousel appear-animate row cols-xl-8 cols-lg-6 cols-md-4 cols-2 mb-10 pb-2"
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
                                'items': 5
                            },
                            '992': {
                                'items': 6
                            },
                            '1200': {
                                'items': 8,
                                'dots': false
                            }
                        }
                    }">
        @foreach ($DashboardClass->GetProductListFromIndex($Title->TagUID, $Title->Limit) as $ProductItem)
            <div class="product-wrap mb-0">
                <div class="product text-center product-absolute">
                    <figure class="product-media">
                        <a href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                            <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}" alt="{{ $ProductItem->NameFa }}"
                                width="213" height="238" style="background-color: #fff" />
                        </a>
                    </figure>
                    <h4 class="product-name">
                        <a href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ Str::substr($ProductItem->NameFa, 0, 30) }}@if (Str::length($ProductItem->NameFa) > 30)
                            ...
                        @endif</a>
                    </h4>
                </div>
            </div>
        @endforeach
        <!-- End of Product Wrap -->
        <div class="product-wrap mb-0">
            <div class="product text-center product-absolute">
                <figure class="product-media">
                    <a href="#">
                        <img src="Theme1/assets/images/demos/demo8/product/5-5.jpg" alt="Category image" width="213"
                            height="238" style="background-color: #fff" />
                    </a>
                </figure>
                <h4 class="product-name">
                    <a href="product-default.html">روسری </a>
                </h4>
            </div>
        </div>
        <!-- End of Product Wrap -->
        <div class="product-wrap mb-0">
            <div class="product text-center product-absolute">
                <figure class="product-media">
                    <a href="#">
                        <img src="Theme1/assets/images/demos/demo8/product/5-3.jpg" alt="Category image" width="213"
                            height="238" style="background-color: #fff" />
                    </a>
                </figure>
                <h4 class="product-name">
                    <a href="product-default.html">ساعت طلا</a>
                </h4>
            </div>
        </div>
        <!-- End of Product Wrap -->
        <div class="product-wrap mb-0">
            <div class="product text-center product-absolute">
                <figure class="product-media">
                    <a href="#">
                        <img src="Theme1/assets/images/demos/demo8/product/3-6.jpg" alt="Category image" width="260"
                            height="291" style="background-color: #fff" />
                    </a>
                </figure>
                <h4 class="product-name">
                    <a href="product-default.html">کیف مسافرتی مردانه</a>
                </h4>
            </div>
        </div>
        <!-- End of Product Wrap -->
        <div class="product-wrap mb-0">
            <div class="product text-center product-absolute">
                <figure class="product-media">
                    <a href="#">
                        <img src="Theme1/assets/images/demos/demo8/product/2-2.jpg" alt="Category image" width="138"
                            height="155" style="background-color: #fff" />
                    </a>
                </figure>
                <h4 class="product-name">
                    <a href="product-default.html">کلاه ایمنی برتر</a>
                </h4>
            </div>
        </div>
        <!-- End of Product Wrap -->
        <div class="product-wrap mb-0">
            <div class="product text-center product-absolute">
                <figure class="product-media">
                    <a href="#">
                        <img src="Theme1/assets/images/demos/demo8/product/4-7.jpg" alt="Category image" width="260"
                            height="291" style="background-color: #fff" />
                    </a>
                </figure>
                <h4 class="product-name">
                    <a href="product-default.html">شراب ارگانیک </a>
                </h4>
            </div>
        </div>
        <!-- End of Product Wrap -->
        <div class="product-wrap mb-0">
            <div class="product text-center product-absolute">
                <figure class="product-media">
                    <a href="#">
                        <img src="Theme1/assets/images/demos/demo8/product/5-4.jpg" alt="Category image" width="213"
                            height="238" style="background-color: #fff" />
                    </a>
                </figure>
                <h4 class="product-name">
                    <a href="product-default.html">مینی هدفون بی سیم</a>
                </h4>
            </div>
        </div>
        <!-- End of Product Wrap -->
        <div class="product-wrap mb-0">
            <div class="product text-center product-absolute">
                <figure class="product-media">
                    <a href="#">
                        <img src="Theme1/assets/images/demos/demo8/product/4-3.jpg" alt="Category image" width="260"
                            height="291" style="background-color: #fff" />
                    </a>
                </figure>
                <h4 class="product-name">
                    <a href="product-default.html">زندگی عالی </a>
                </h4>
            </div>
        </div>
        <!-- End of Product Wrap -->
    </div>
    <!-- End of Reviewed Producs -->
</div>
<!--   end 140110 -->
