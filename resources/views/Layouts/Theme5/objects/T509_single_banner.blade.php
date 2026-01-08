<section class="slider-section mb-5 amazing-section"
    style="background: {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Backcolor') }}">

    <div class="container main-container">
        <div class="row mb-3">
            <!-- Start Product-Slider -->
            <div class="col-12">
                <div class="product-carousel carousel-lg owl-carousel owl-theme">
                    <div class="item">
                        <div class="amazing-product text-center pt-5">
                            <a href="{{ route('ShowProduct', ['Tags' => App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID')]) }}">
                                <img src="{{ $mobile_banner->title }}" alt="">
                            </a>
                            <a href="{{ route('ShowProduct', ['Tags' => App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID')]) }}"
                                class="view-all-amazing-btn">
                                مشاهده همه
                            </a>
                        </div>
                    </div>
                    @foreach ($DashboardClass->GetProductListFromIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit')) as $ProductItem)
                        @php
                            $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
                            $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
                            $MinPrice = $Product->GetTargetPrice($ProductItem->MinPrice, $ProductItem->tax_status);
                            $MaxPrice = $Product->GetTargetPrice($ProductItem->MaxPrice, $ProductItem->tax_status);
                        @endphp
                        <div class="item">
                            <div class="product-card mb-3">
                                <div class="product-head">
                                    <div class="product-head">
                                        <div class="steps_icon  rating-stars">
                                            <p> تخفیف پلکانی</p>
                                        </div>
                                    </div>
                                    @if ($BasePrice != $Price)
                                        <div class="discount">
                                            @if ($ProductItem->PricePlan == null)
                                                <span>{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</span>
                                            @else
                                                <span>{{ ceil((($BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $BasePrice) }}%</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <a class="product-thumb"
                                    href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                    <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                                        alt="{{ $ProductItem->NameFa }}">
                                </a>
                                <div class="product-card-body">
                                    <h5 style="text-align: justify" class="product-title">
                                        <a
                                            href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}}">{{ Str::limit($ProductItem->NameFa, 50) }}</a>
                                    </h5>
                                    @if ($BasePrice != $Price && $BasePrice != 0)
                                        <div class="product-price old-price">
                                            <del class="old-price">{{ number_format($BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>
                                        </div>
                                    @endif
                                    <span
                                        class="product-price">{{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                                    <div class="add-to-card fast-buy-div-new">
                                        <button type="button" role="button"
                                            onclick="load_fast_buy({{ $ProductItem->id }})" data-toggle="modal"
                                            data-target="#product_fast_show"
                                            class="btn btn-primary p-2 rounded-circle fast-buy-btn-new"><i
                                                class="mdi mdi-cart-plus fast-buy-i-new"></i></button>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
            <!-- End Product-Slider -->

        </div>
    </div>
</section>














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
