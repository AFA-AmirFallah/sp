<div class="title-link-wrapper mb-3">
    <h2 class="title title-link mb-0 pt-2 pb-2">{{ $mobile_banner->title }}</h2>
    <a href="{{ route('ShowProduct', ['Tags' => App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID')]) }}"
        class="mb-0">محصولات بیشتر <i class="w-icon-long-arrow-left"></i></a>
</div>
<div class="owl-carousel owl-theme product-deals-wrapper appear-animate mb-7 owl-loaded owl-drag fadeIn appear-animation-visible"
    data-owl-options="{
    'nav': false,
    'dots': true,
    'items': 5,
    'autoplay': false,
    'margin': 20,
    'responsive': {
        '0': {
            'items': 2,
            'nav': false
        },
        '576': {
            'items': 3
        },
        '768': {
            'items': 4
        },
        '992': {
            'items': 5
        }
    }
}"
    style="animation-duration: 1.2s;">
    <div class="owl-stage-outer">
        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1380px;">
            @foreach ($DashboardClass->GetProductListFromIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit')) as $ProductItem)
                @php
                    $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
                    $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
                    $MinPrice = $Product->GetTargetPrice($ProductItem->MinPrice, $ProductItem->tax_status);
                    $MaxPrice = $Product->GetTargetPrice($ProductItem->MaxPrice, $ProductItem->tax_status);
                @endphp
                <div class="owl-item active" style="width: 255.998px; margin-right: 20px;">
                    <div class="product-wrap  product-image-gap ">
                        <div class="product text-center">
                            <figure class="product-media">
                                <a
                                    href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                    <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                                        alt="{{ $ProductItem->NameFa }}" width="300" height="338">
                                </a>
                                @if ($BasePrice != $Price)
                                    <div class="product-label-group">
                                        @if ($ProductItem->PricePlan == null)
                                            <label
                                                class="product-label label-discount">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label>
                                        @else
                                            <label
                                                class="product-label label-discount">{{ ceil((($BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $BasePrice) }}%</label>
                                        @endif
                                    </div>
                                @endif
                            </figure>
                            <div class="product-details">
                                <h4 class="product-name"><a
                                        href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ $ProductItem->NameFa }}</a>
                                </h4>


                                <div class="product-price">
                                    @if ($ProductItem->MinPrice != 0)
                                        @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductItem->MaxPrice == 0)
                                            <ins class="new-price">
                                                {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            </ins>
                                        @else
                                            <ins class="new-price"> از
                                                {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                تا
                                                {{ number_format($MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            </ins>
                                        @endif
                                    @else
                                        <ins class="new-price">
                                            {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        </ins>
                                    @endif

                                    @if ($BasePrice != $Price && $BasePrice != 0)
                                        <del class="old-price">{{ $BasePrice }} </del>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
<script>
    function addtobasket(wgid, ProductID) {
        $CountValu = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'AddToBasketStepper',
                ProductId: ProductID,
                pw_id: wgid,
                OrderQty: $CountValu,
            },

            function(data, status) {

            });
    }

    function GetPercent(BasePrice, Price, Remain) {
        if (parseInt(Remain) > 0) {
            BasePrice = parseInt(BasePrice);
            Price = parseInt(Price);
            if (BasePrice == 0) {
                return '';
            }
            $Percent = Math.round(((BasePrice - Price) * 100) / BasePrice);
            return $Percent;
        } else {
            return '';
        }
    }
</script>
