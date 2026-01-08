<style>
    .all_voiew_122:hover {
        background-color: #990000;
        color: white;
    }

    .all_voiew_122 {
        left: 0px;
        position: absolute;
        top: -7px;
        color: black;
        background-color: #ff7e87;
        padding: 4px;
        border-radius: 12px;
        color: white;
    }
</style>
<div class="container main-container">
    <section class="slider-section dt-sl mb-5">
        <div class="row mb-3">
            <div class="col-12">
                <div class=" section-title text-sm-title  ">
                    <h2>{{ $Cats_item->Name }}</h2>
                    <a target="_blank" href="{{ route('ShowProduct', ['Tags' => $Cats_item->UID]) }}" type="button"
                        style="position: absolute;padding-left: 10px !important;left: 2px;top: -10px;text-align: left;padding: 5px;margin-right: 10px !important;width: 93px!important;"
                        class="btn-primary-cm btn-with-icon mx-auto w-100"> مشاهده همه
                    </a>
                </div>
            </div>

            <!-- Start Product-Slider -->
            <div class="col-12">
                <div class="product-carousel carousel-lg owl-carousel owl-theme">
                    @foreach ($DashboardClass->GetProductListFromIndex($Cats_item->UID, 10) as $ProductItem)
                        @php
                            if ($ProductItem->PricePlan != null) {
                                $steps = true;
                                $Price = $MyProduct->GetTargetPriceFromPricePlan($ProductItem->PricePlan, 'max');
                            } else {
                                $steps = false;
                                $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
                            }
                            $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
                        @endphp
                        <div class="item">
                            <div class="product-card mb-3">
                                <div class="product-head">

                                    <div style="margin-top: -3px;margin-right: -20px" class="product-head">

                                        <div class="steps_icon  rating-stars">
                                            @if ($steps)
                                                <p class="steps_sddjf"> تخفیف پلکانی</p>
                                            @else
                                                <div style="height: 22px"></div>
                                            @endif
                                        </div>

                                    </div>

                                    @if ($BasePrice != $Price)
                                        <div style="z-index: 2" class="discount">
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
                                    <h5 class="product-title">
                                        <a style="color: black"
                                            href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}}">{{ Str::limit($ProductItem->NameFa, 50) }}</a>
                                    </h5>
                                    @if ($BasePrice != $Price && $BasePrice != 0)
                                        <div class="product-price old-price">
                                            <del class="old-price">{{ number_format($BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>
                                        </div>
                                    @endif
                                    @if ($steps)
                                        <span class="product-price">از
                                            {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                                    @else
                                        <span
                                            class="product-price">{{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                                    @endif

                                    <div class="add-to-card fast-buy-div-new">
                                        <button type="button" role="button"
                                            onclick="load_fast_buy({{ $ProductItem->id }})" data-toggle="modal"
                                            data-target="#product_fast_show"
                                            class="btn btn-primary p-2 rounded-circle fast-buy-btn-new"><i
                                                class="mdi mdi-cart-plus fast-buy-i-new"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End Product-Slider -->

        </div>
    </section>
    <!-- End Product-Slider -->

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
