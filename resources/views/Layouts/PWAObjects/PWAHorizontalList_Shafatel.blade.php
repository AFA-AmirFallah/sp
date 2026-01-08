@if (\App\myappenv::MainOwner == 'sepehrmall')
    <style>
        .product-card-img {
            height: 165px;
            margin: auto;
        }

        .item-title {
            height: 7px;
        }

        .picutre_fixer {
            height: 167px;
        }

        .list_continer {
            margin-bottom: -31px;
            padding-right: 14px;
        }

        .list_show_all {
            position: absolute;
            left: 32px;
            margin-top: -24px;
            font-size: 14px;
            font-weight: 600;
        }

        .percentbox {
            color: white;
            background: rgb(204, 0, 0);
            border-radius: 3 px;
            padding: 2 px;
            font-size: 13px;
            font-weight: 800;
        }

        .list_title {
            font-size: 14px;
            font-weight: 600;
            color: white;
            position: absolute;
            margin-top: -23px;
        }

    </style>
@else
    <style>
        .item-title {
            text-align: center;
            height: 45px;
        }
        .list_continer {
            margin-bottom: -58px;
            padding-right: 14px;
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
            color: white;
            background: red;
            border-radius: 3 px;
            padding: 2 px;
            font-size: 13px;
            font-weight: 800;
        }

        .list_title {
            font-size: 14px;
            font-weight: 600;
            color: white;
            position: absolute;
            margin-top: -23px;
        }

    </style>
@endif
@php
$Title = json_decode($mobile_banner->title);
@endphp
<div style="
margin-top:28px;
margin-bottom: 20px;
">
    <div class="br_div"></div>
    <div class="list_continer">
        <div class="list_title">
            {{ $Title->Title }}
        </div>
        <div class="list_show_all">
            @if (\App\myappenv::MainOwner == 'sepehrmall')
                <a style="color: white;margin-left: 3px"
                    href="{{ route('ShowProduct', ['Tags' => $Title->TagUID]) }}">
                    همه></a>
            @else
            <a style="color: white;margin-left: 3px"
            href="{{ route('ShowProduct', ['Tags' => $Title->TagUID]) }}">
            همه></a>
    @endif
        </div>
    </div>
    @if (\App\myappenv::MainOwner == 'sepehrmall')
        <div style="height: 342px;border-radius:7px;padding-right:10px; padding-top: 40px;background-color: {{ $Title->Backcolor }}"
            class="horizental-list ">
        @else
        <div style="border-radius:7px;padding-right:10px; padding-top: 40px;background-color: {{ $Title->Backcolor }}"
            class="horizental-list ">
    @endif
    @foreach ($DashboardClass->GetProductListFromIndex($Title->TagUID, $Title->Limit) as $ProductItem)
        <div class="horizantal-list-item">
            <div class="max-card card o-hidden mb-4 d-flex flex-column">
                <div class="list-thumb d-flex picutre_fixer">
                    <img class="lazy product-card-img" alt="{{ $ProductItem->NameFa }}"
                        data-src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}" src="{{ \App\myappenv::PictuerLoader }}">
                </div>
                <div class="flex-grow-1 d-bock">
                    @if (\App\myappenv::MainOwner == 'sepehrmall')
                        <div style="margin-bottom: -5px;"
                            class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                            <div style="text-align: center;margin-top:-16px;" class="item-title">
                                {{ Str::substr($ProductItem->NameFa, 0, 20) }}@if (Str::length($ProductItem->NameFa) > 20)
                                    ...
                                @endif
                            </div>
                            <div style="text-align: center">
                            </div>
                            <div class="br_div"></div>
                            <div class="nested" id="desc_{{ $ProductItem->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'DiscText') !!}
                            </div>
                            <div class="nested" id="text_{{ $ProductItem->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'MainText') !!}
                            </div>
                            <div class="row">

                                <div style="width: 148px">
                                    <div style="
                                margin-right: -3px;
                            ">
                                        @if ($ProductItem->PricePlan == null)
                                            <label
                                                style="font-size: 12px;text-align:center; margin-right:8px;border-radius: 3px;padding-top: 6px;padding-right: 2px;width: 31px;height: 31px;"
                                                class="percentbox">{{ ceil((($ProductItem->BasePrice - $ProductItem->Price) * 100) / $ProductItem->BasePrice) }}%</label>
                                        @else
                                            <label
                                                style="font-size: 12px;text-align:center;margin-right:8px;border-radius: 3px;padding-top: 6px;padding-right: 2px;width: 31px;height: 31px;"
                                                class="percentbox">{{ ceil((($ProductItem->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) *100) /$ProductItem->BasePrice) }}%</label>
                                        @endif
                                        <del style="position: absolute;margin-top: -4px;
                                    padding-right: 7px;
                                " class="text-secondary">
                                            {{ number_format($ProductItem->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>

                                    </div>
                                    <div style="margin-top: -23px;padding-right: 2px;">
                                        <p style="padding-right: 41px;" class="m-0 text-muted text-small w-15 w-sm-100">
                                            @if ($ProductItem->PricePlan == null)
                                                {{ number_format($ProductItem->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            @else
                                                از
                                                {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan) /App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                تا
                                                {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($ProductItem->PricePlan) /App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            @endif
                                        </p>

                                    </div>
                                </div>
                                <div>
                                    <a onclick="SelectProduct('{{ $ProductItem->NameFa }}' , '{{ $ProductItem->wgid }}', '{{ $ProductItem->id }}' ,'{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}', {{ $ProductItem->Price }} ,  {{ $ProductItem->BasePrice }}, '{{ $ProductItem->PricePlan }}' )"
                                        data-toggle="modal" data-target=".bd-example-modal-lg">
                                        <p class="m-0 text-muted text-small w-15 w-sm-100">
                                            <button
                                                style="margin-top: 2px;width: 113px;margin-right: 92px;border-radius: 0px 25px 25px 0px;background-color: rgb(51, 102, 102);border-width: 0px;"
                                                class="btn btn-success btn-block"> خرید</button>

                                        </p>
                                    </a>
                                </div>
                            </div>

                        </div>
                    @else
                        <div style="margin-top: -20px;"
                            class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                            <div class="item-title">
                                {{ Str::substr($ProductItem->NameFa, 0, 30) }}@if (Str::length($ProductItem->NameFa) > 30)
                                    ...
                                @endif
                            </div>
                            <div style="text-align: center">
                                @if ($ProductItem->PricePlan == null)
                                    <label style="border-radius: 3px;padding:2px;"
                                        class="percentbox">{{ ceil((($ProductItem->BasePrice - $ProductItem->Price) * 100) / $ProductItem->BasePrice) }}%</label>
                                @else
                                    <label style="border-radius: 3px;padding:2px;"
                                        class="percentbox">{{ ceil((($ProductItem->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) *100) /$ProductItem->BasePrice) }}%</label>
                                @endif
                                <del class="text-secondary">
                                    {{ number_format($ProductItem->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>

                                <p class="m-0 text-muted text-small w-15 w-sm-100">
                                    @if ($ProductItem->PricePlan == null)
                                        {{ number_format($ProductItem->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    @else
                                        از
                                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan) /App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        تا
                                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($ProductItem->PricePlan) /App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    @endif


                                </p>
                                <p class="m-0 text-muted text-small w-15 w-sm-100 item-badges">
                                    <span
                                        class="badge badge-primary">{{ number_format(($ProductItem->BasePrice - $ProductItem->Price) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }} تخفیف</span>
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
                                <a onclick="SelectProduct('{{ $ProductItem->NameFa }}' , '{{ $ProductItem->wgid }}', '{{ $ProductItem->id }}' ,'{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}', {{ $ProductItem->Price }} ,  {{ $ProductItem->BasePrice }}, '{{ $ProductItem->PricePlan }}' )"
                                    data-toggle="modal" data-target=".bd-example-modal-lg">
                                    <p class="m-0 text-muted text-small w-15 w-sm-100">
                                        <button class="btn btn-success btn-block"> اجاره</button>
                                    </p>
                                </a>
                            @else
                                <a onclick="SelectProduct('{{ $ProductItem->NameFa }}' , '{{ $ProductItem->wgid }}', '{{ $ProductItem->id }}' ,'{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}', {{ $ProductItem->Price }} ,  {{ $ProductItem->BasePrice }}, '{{ $ProductItem->PricePlan }}' )"
                                    data-toggle="modal" data-target=".bd-example-modal-lg">
                                    <p class="m-0 text-muted text-small w-15 w-sm-100">
                                        <button class="btn btn-success btn-block"> خرید</button>
                                    </p>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
</div>

