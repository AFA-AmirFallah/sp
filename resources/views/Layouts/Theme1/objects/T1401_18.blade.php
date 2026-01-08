<style>
    .Discount_Percent {
        position: absolute;
        left: 6px;
        top: 6px;
        background: red;
        border-radius: 3px;
        color: white;
        padding: 3px;
        font-size: large;

    }

    .Discount_Percent label {
        padding-bottom: 0px;
        margin-bottom: 0px;

    }
</style>
<div class="title-link-wrapper mb-3">
    <h2 class="title title-link mb-0 pt-2 pb-2">{{ $mobile_banner->title }}</h2>
    <a href="{{ route('ShowProduct', ['Tags' => App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID')]) }}"
        class="mb-0">محصولات بیشتر <i class="w-icon-long-arrow-left"></i></a>
</div>
<div class="owl-carousel owl-theme product-wrapper row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2"
    data-owl-options="{
    'nav': false,
    'dots': true,
    'loop': false,
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
            'items': 5
        }
    }
}">
    @foreach ($DashboardClass->GetProductListFromIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit')) as $ProductItem)
        @php
            $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
            $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
            $MinPrice = $Product->GetTargetPrice($ProductItem->MinPrice, $ProductItem->tax_status);
            $MaxPrice = $Product->GetTargetPrice($ProductItem->MaxPrice, $ProductItem->tax_status);
        @endphp
        <div class="product product-simple text-center"
            style="border: 1px solid #e0e0e2;>
            <figure class="product-media">
            <a
                href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                    alt="{{ $ProductItem->NameFa }}" width="260" height="291" />
            </a>

            <div class="product-action">
                <a href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}"
                    class="btn-product btn-quickview" title="نمایش سریع">نمایش محصول </a>
            </div>
            @if ($BasePrice != $Price)
                <div class="Discount_Percent">
                    @if ($ProductItem->PricePlan == null)
                        <label style="border-radius: 3px;padding:2px;"
                            class="percentbox">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label>
                    @else
                        <label style="border-radius: 3px;padding:2px;"
                            class="percentbox">{{ ceil((($BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $BasePrice) }}%</label>
                    @endif
                </div>
            @endif
            </figure>
            <div class="product-details">
                <h4 class="product-name"><a
                        href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ $ProductItem->NameFa }}</a>
                </h4>
                <div class="product-pa-wrapper">
                    <div class="product-price">
                        @if ($ProductItem->MinPrice != 0)
                            @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductItem->MaxPrice == 0)
                                <ins class="new-price">
                                    {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </ins>
                            @else
                                <ins class="new-price"> از
                                    {{ number_format($MinPrice  / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
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
    @endforeach
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

</div>
