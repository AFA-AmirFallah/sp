@php
    $Conter = 0;
@endphp
<style>
    @media (max-width: 575px) {
        .product-head {
            display: list-item;
        }
    }
</style>
@php
    $TargetLayer = 0;
@endphp


@foreach ($Goods as $Good)
    @php
        if ($Good->PricePlan != null) {
            $steps = true;
            //echo($Good->PricePlan);
            $Price = $MyProduct->GetTargetPriceFromPricePlan($Good->PricePlan, 'max');
        } else {
            $steps = false;
            $Price = $Good->Price;
        }

        $Conter++;
    @endphp

    <div class="col-lg-2 col-md-4 col-sm-6 col-12 px-10 mb-1 px-res-0">
        <div style="margin-top: 7px;padding-bottom: 11px;" class="product-card mb-2 mx-res-0">

            <div class="promotion">


            </div>
            <div class="product-head">
                @if ($steps)
                    <p class="steps_discount"> تخفیف پلکانی</p>
                @endif

                @if ($Good->BasePrice != $Price)
                    <div class="fwejjf">
                        <span>{{ ceil((($Good->BasePrice - $Price) * 100) / $Good->BasePrice) }}%</span>

                    </div>
                @endif

            </div>
            <a class="product-thumb" href="{{ route('SingleProduct', ['productID' => $Good->id]) }}">
                <img src="{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}"
                    onerror="this.onerror=null; this.src='https:\/\/sepehrmall.com/storage/photos/images/default-image.png'"
                    alt="{{ Str::limit($Good->NameFa, 50) }}">
            </a>
            <div class="product-card-body">
                <h5 class="product-title">
                    <a style="color: black;"
                        href="{{ route('SingleProduct', ['productID' => $Good->id]) }}">{{ Str::limit($Good->NameFa, 50) }}</a>
                </h5>

                @php
                    $BasePrice = App\Http\Controllers\woocommerce\ProductClass::GetTargetPrice(
                        $Good->BasePrice,
                        $Good->tax_status,
                    );
                    $Price = App\Http\Controllers\woocommerce\ProductClass::GetTargetPrice($Price, $Good->tax_status);

                @endphp
                @if ($Good->BasePrice - $Price != 0)
                    <div class="discount_main">

                        <del class="old-price">
                            {{ number_format($BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        </del>
                    </div>
                @endif

                @if ($management)
                    <a role="button" href="{{ route('EditProduct', ['id' => $Good->id]) }}" direction="right"
                        font-size="1.4" height="3"><i class="mdi mdi-pencil"></i>
                    </a>
                @endif
                @if ($Good->Remian > 0)
                    @if ($Good->MinPrice != 0)
                        <span class="product-price">

                            {{ number_format($Good->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                        </span>
                    @else
                        <span class="product-price">
                            @if ($steps)
                                از
                                {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                            @else
                                {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                            @endif
                        </span>
                    @endif

                    <div class="add-to-card fast-buy-div-new">
                        <button type="button" role="button" onclick="load_fast_buy({{ $Good->id }})"
                            data-toggle="modal" data-target="#product_fast_show"
                            class="btn btn-primary p-2 rounded-circle fast-buy-btn-new"><i
                                class="mdi mdi-cart-plus fast-buy-i-new"></i></button>
                    </div>
                @else
                    <span class="product-price">
                        <p style="color: red !important" class="m-0 text-small text-muted">
                            تمام شده! </p>
                    </span>
                @endif
            </div>

        </div>
    </div>
@endforeach


@if ($Conter == 0)
    <script>
        show_moredata(2);
    </script>
@elseif ($Conter == 10)
    <script>
        window.loaddatainit = true;
        show_moredata(1);
    </script>
@else
    <script>
        window.loaddatainit = true;
        show_moredata(3);
    </script>
@endif
