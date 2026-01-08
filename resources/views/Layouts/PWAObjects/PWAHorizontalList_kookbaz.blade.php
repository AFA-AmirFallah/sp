<style>
    .item-title {
        text-align: center;
        height: 45px;
    }

    @media (min-width: 438px) {
        .list_continer {
            display: none;
        }
    }

    @media (max-width: 438px) {
        .list_continer {
            display: flex;
            margin-bottom: -58px;
            padding-right: 14px;
        }
    }




    .product-card-img {
        height: 140px;
        margin: auto;
    }

    .picutre_fixer {
        height: 140px;
    }

    .list_show_all {
        position: absolute;
        left: 32px;
        margin-top: -24px;
        font-size: 14px;
        font-weight: 600;
    }

    .percentbox {
        background: red;
        width: 2.25rem;
        --tw-text-opacity: 1;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
        text-align: center;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        font-size: .75rem;
        line-height: 1rem;
        justify-content: center;
        height: 1.25rem;
        border-radius: 9999px;
    }

    .list_title {
        font-size: 14px;
        font-weight: 600;
        color: white;
        position: absolute;
        margin-top: -23px;
    }

    .TaakhfifDiv {
        display: flex;
        direction: ltr;
    }
</style>

@php
$Title = json_decode($mobile_banner->title);
$DataSorce = $DashboardClass->GetProductListFromIndex($Title->TagUID, $Title->Limit);
$DataSample = null;
foreach ($DataSorce as $DataItems) {
    $DataSample = $DataItems;
}
@endphp
<div style="
margin-top:40px;
margin-bottom: 20px;
">
    <div style="margin-bottom: -52px;" class="list_continer">
        <div class="list_title">
            {{ $Title->Title }}
        </div>
        <div class="list_show_all">
            <a style="color: white;margin-left: 3px" href="{{ route('ShowProduct', ['Tags' => $Title->TagUID]) }}">
                همه></a>
        </div>
    </div>
    <div style="border-radius:7px;padding-right:10px; padding-top: 40px;background-color: {{ $Title->Backcolor }}"
        class="horizental-list ">

        @php
            $Counter = 1;
        @endphp
        @foreach ($DataSorce as $ProductItem)
            @if (!isset($DataSample) || $DataSample->img == '')
            @else
                @if ($Counter == 1)
                    @if ($ProductItem->img != '' || $ProductItem->img != null)
                    @endif

                    <div class="horizantal-list-item list-icon icon-title-98">
                        <p class="icon-title-98">
                            {{ $Title->Title }}
                        </p>

                        <img class="lazy product-card-img icon-title-98" src="{{ $ProductItem->img }}">

                        <a class="icon-title-98" href="{{ route('ShowProduct', ['Tags' => $Title->TagUID]) }}">
                            مشاهده همه<svg
                                style="
                            transform: rotate(180deg);
                            width: 16px;
                            margin-right: 10px !important;
                        "
                                class="transform rotate-180 mr-4 w-3" width="26" height="31" viewBox="0 0 26 31"
                                fill="none">
                                <path d="M10.9099 1.89038L24.9647 15.9452L10.9099 30" stroke="#30BFB4" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <rect x="6.625" y="9.72168" width="9.36988" height="9.36988" rx="0.7"
                                    transform="rotate(45 6.625 9.72168)" fill="#29A0A8"></rect>
                            </svg></a>


                    </div>
                    @php
                        $Counter++;
                    @endphp
                @endif
            @endif

            <div class="horizantal-list-item">
                <div class="max-card card o-hidden mb-4 d-flex flex-column">
                    <div class="list-thumb d-flex picutre_fixer">
                        <img class="lazy product-card-img" alt="{{ $ProductItem->NameFa }}"
                            data-src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                            src="{{ \App\myappenv::PictuerLoader }}">
                    </div>
                    <div class="flex-grow-1 d-bock">
                        <div style="margin-top: -20px;"
                            class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                            <div class="item-title">
                                {{ Str::substr($ProductItem->NameFa, 0, 30) }}@if (Str::length($ProductItem->NameFa) > 30)
                                    ...
                                @endif
                            </div>
                            <div style="text-align: center">
                                @if ($ProductItem->BasePrice != $ProductItem->Price && $ProductItem->BasePrice != 0)
                                    <div class="TaakhfifDiv">
                                        @if ($ProductItem->PricePlan == null)
                                            <label
                                                class="percentbox">{{ ceil((($ProductItem->BasePrice - $ProductItem->Price) * 100) / $ProductItem->BasePrice) }}%</label>
                                        @else
                                            <label
                                                class="percentbox">{{ ceil((($ProductItem->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $ProductItem->BasePrice) }}%</label>
                                        @endif
                                        <div class="discount_main">
                                            <div class="discount"></div>
                                            <p class="discounttext">
                                                {{ number_format($ProductItem->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <p class="PriceStyle m-0 text-muted text-small w-15 w-sm-100">
                                    @if ($ProductItem->MinPrice != 0)
                                        @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductItem->MaxPrice == 0)
                                            {{ number_format($ProductItem->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @else
                                            از
                                            {{ number_format($ProductItem->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            تا
                                            {{ number_format($ProductItem->MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @endif
                                    @else
                                        @if ($ProductItem->PricePlan == null)
                                            {{ number_format($ProductItem->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            <small
                                                class="PriceStyle">{{ App\Http\Controllers\Credit\currency::GetCurrency() }}</small>
                                        @else
                                            <small class="PriceStyle"> از</small>
                                            {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            <small class="PriceStyle">تا</small>
                                            {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($ProductItem->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            <small
                                                class="PriceStyle">{{ App\Http\Controllers\Credit\currency::GetCurrency() }}</small>
                                        @endif
                                    @endif


                                </p>
                            </div>
                            <div class="br_div"></div>
                            <div class="nested" id="desc_{{ $ProductItem->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'DiscText') !!}
                            </div>
                            <div class="nested" id="text_{{ $ProductItem->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'MainText') !!}
                            </div>
                            @php
                                
                                if ($ProductItem->UnitPlan == '' || $ProductItem->UnitPlan == null) {
                                    $TargetUnit = '';
                                } else {
                                    $Units = json_decode($ProductItem->UnitPlan);
                                    foreach ($Units as $Unit) {
                                        $TargetUnit = $Unit->UnitName;
                                    }
                                }
                            @endphp

                            @if (str_contains($TargetUnit ?? '', 'ماه') || str_contains($TargetUnit ?? '', 'سال') || str_contains($TargetUnit ?? '', 'هفته') || str_contains($TargetUnit ?? '', 'روز'))
                                <a
                                    href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                    <p class="m-0 text-muted text-small w-15 w-sm-100">
                                        <button class="btn btn-success btn-block"> اجاره</button>
                                    </p>
                                </a>
                            @else
                                <a
                                    href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                    <p class="m-0 text-muted text-small w-15 w-sm-100">
                                        <button class="btn btn-success btn-block"> خرید</button>
                                    </p>
                                </a>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
