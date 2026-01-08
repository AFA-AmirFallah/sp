@if (\App\myappenv::MainOwner == 'sepehrmall')
    <style>
        .CatImg {
            width: 38px;
        }

        .Title_card {}

        .sht198 {
            border-width: 1px;
            border-style: solid;
            border-color: blue;
            margin-right: 10px;
            white-space: nowrap;
            margin-bottom: 13px;
            padding: 4px;
            font-size: 15px;
            border-radius: 10px;
            margin-top: 0px;
        }

        .cats-header {
            font-size: 13px;
            font-weight: 500;
            margin: 0px 0px 1.6rem;
        }

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
            color: black;
            position: absolute;
            margin-top: -23px;
        }
    </style>
@else
    <style>
        .item-title {
            text-align: center;
            color: #47404f;
            height: 50px;
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
            left: 10px;
            margin-top: -30px;
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

        .CatImg {
            width: 38px;
        }

        .Title_card {}

        .list_title {
            position: absolute;
            right: 10px;
            margin-top: -39px;
            font-size: 14px;
            font-weight: 600;
        }

        .sht198 {
            border-width: 1px;
            border-style: solid;
            border-color: blue;
            margin-right: 10px;
            white-space: nowrap;
            margin-bottom: 13px;
            padding: 4px;
            font-size: 15px;
            border-radius: 10px;
            margin-top: 0px;
        }

        .cats-header {
            font-size: 13px;
            font-weight: 500;
            margin: 0px 0px 1.6rem;
        }

        .product_card {
            margin-top: 20px;
        }
    </style>
@endif

@foreach ($Tags as $Tag)
    @php
        if (\App\myappenv::MainOwner == 'sepehrmall') {
            $Source = $DashboardClass->GetProductListFromIndex($Tag->UID, 2);
        } else {
            $Source = $DashboardClass->GetProductListFromIndex($Tag->UID, 10);
        }
    @endphp
    @if ($Source != [])
        @foreach ($Source as $ProductItem)
            @php
                $ProductSample = $ProductItem;
            @endphp
        @break
    @endforeach
    @if ($ProductSample->WorkCat < 1000)
        <div class="product_card card col-12">
            @if (\App\myappenv::MainOwner == 'sepehrmall')
                <div style="margin-top: -30px;" class="card-body">
                @else
                    <div class="card-body">
            @endif
            <div id="sub_tags" direction="row" class="Shafatel19 horizental-list">
                <div class="row">
                    <div class="Title_card">
                        <div class="list_title">
                            @if ($Tag->L3img != '' && $Tag->L3img != null)
                                <img class="CatImg" src="{{ $Tag->L3img }}" alt="{{ $Tag->L3Name }}">
                            @endif
                            {{ $Tag->L3Name }}
                        </div>
                        <div class="list_show_all">
                            @if (\App\myappenv::MainOwner == 'sepehrmall')
                                <a style="color:black;margin-left: 3px"
                                    href="{{ route('ShowProduct', ['Tags' => $Tag->UID]) }}">
                                    همه ></a>
                            @else
                                <a style="color: #47404f;"
                                    href="{{ route('ShowProduct', ['Tags' => $Tag->UID]) }}">همه ></a>
                            @endif
                        </div>
                    </div>
                    <div class="br_div"></div>
                    <div class="horizental-list">
                        @foreach ($Source as $ProductItem)
                            <div class="horizantal-list-item">
                                <div class="max-card card o-hidden mb-4 d-flex flex-column">
                                    <div class="list-thumb d-flex picutre_fixer">
                                        <img class="product-card-img" alt=""
                                            src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}">
                                    </div>
                                    <div class="flex-grow-1 d-bock">
                                        @if (\App\myappenv::MainOwner == 'sepehrmall')
                                            <div style="margin-bottom: -5px;"
                                                class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                                <div style="text-align: center;margin-top:-16px;"
                                                    class="item-title">
                                                    {{ Str::substr($ProductItem->NameFa, 0, 20) }}@if (Str::length($ProductItem->NameFa) > 20)
                                                        ...
                                                    @endif
                                                </div>
                                                <div style="text-align: center">
                                                </div>
                                                <div class="br_div"></div>
                                                <div class="nested" id="desc_{{ $ProductItem->id }}">
                                                    {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'DiscText') !!}
                                                </div>
                                                <div class="nested" id="text_{{ $ProductItem->id }}">
                                                    {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'MainText') !!}
                                                </div>
                                                <div class="row">

                                                    <div style="width: 148px">
                                                        <div
                                                            style="
                                            margin-right: -3px;
                                        ">
                                                            @if ($ProductItem->PricePlan == null)
                                                                <label
                                                                    style="font-size: 12px;text-align:center; margin-right:8px;border-radius: 3px;padding-top: 6px;padding-right: 2px;width: 31px;height: 31px;"
                                                                    class="percentbox">{{ ceil((($ProductItem->BasePrice - $ProductItem->Price) * 100) / $ProductItem->BasePrice) }}%</label>
                                                            @else
                                                                <label
                                                                    style="font-size: 12px;text-align:center;margin-right:8px;border-radius: 3px;padding-top: 6px;padding-right: 2px;width: 31px;height: 31px;"
                                                                    class="percentbox">{{ ceil((($ProductItem->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $ProductItem->BasePrice) }}%</label>
                                                            @endif
                                                            <del style="position: absolute;margin-top: -4px;
                                                padding-right: 7px;
                                            "
                                                                class="text-secondary">
                                                                {{ number_format($ProductItem->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>

                                                        </div>
                                                        <div style="margin-top: -23px;padding-right: 2px;">
                                                            <p style="padding-right: 41px;"
                                                                class="m-0 text-muted text-small w-15 w-sm-100">
                                                                @if ($ProductItem->PricePlan == null)
                                                                    {{ number_format($ProductItem->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                @else
                                                                    از
                                                                    {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    تا
                                                                    {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($ProductItem->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
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
                                            <div
                                                class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                                <a class="w-40 w-sm-100" href="">
                                                    <div class="item-title">
                                                        {{ Str::substr($ProductItem->NameFa, 0, 30) }}
                                                        @if (Str::length($ProductItem->NameFa) > 30)
                                                            ...
                                                        @endif
                                                    </div>
                                                </a>
                                                <div style="text-align: center">
                                                    @if ($ProductItem->BasePrice != $ProductItem->Price && $ProductItem->BasePrice != 0)
                                                        @if ($ProductItem->PricePlan == null)
                                                            @if ($ProductItem->MinPrice == 0)
                                                                <label style="border-radius: 3px;padding:2px;"
                                                                    class="percentbox">{{ ceil((($ProductItem->BasePrice - $ProductItem->Price) * 100) / $ProductItem->BasePrice) }}%</label>
                                                            @endif
                                                        @else
                                                            <label style="border-radius: 3px;padding:2px;"
                                                                class="percentbox">{{ ceil((($ProductItem->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $ProductItem->BasePrice) }}%</label>
                                                        @endif
                                                        <del class="text-secondary">
                                                            {{ number_format($ProductItem->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>
                                                    @endif

                                                    <p class="m-0 text-muted text-small w-15 w-sm-100">
                                                        @if ($ProductItem->PricePlan == null)
                                                            @if ($ProductItem->MinPrice == 0)
                                                                {{ number_format($ProductItem->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                            @else
                                                                @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductTarget->MaxPrice == 0)
                                                                    {{ number_format($ProductItem->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                @else
                                                                    از
                                                                    {{ number_format($ProductItem->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    تا
                                                                    {{ number_format($ProductItem->MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                @endif

                                                            @endif
                                                        @else
                                                            از
                                                            {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                            تا
                                                            {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($ProductItem->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                        @endif
                                                    </p>
                                                    <p class="m-0 text-muted text-small w-15 w-sm-100 item-badges">
                                                        @if ($ProductItem->MinPrice == 0)
                                                            <span
                                                                class="badge badge-primary">{{ number_format(($ProductItem->BasePrice - $ProductItem->Price) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                تخفیف</span>
                                                        @endif
                                                    </p>

                                                </div>
                                                <div class="br_div"></div>
                                                <div class="nested" id="desc_{{ $ProductItem->id }}">
                                                    {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'DiscText') !!}
                                                </div>
                                                <div class="nested" id="text_{{ $ProductItem->id }}">
                                                    {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductItem->MainDescription, 'MainText') !!}
                                                </div>

                                                @isset($sender)
                                                    @if ($ProductItem->MinPrice == 0)
                                                        <a
                                                            href="{{ route('SingleProduct', ['productID' => App\myappenv::PreProductTag . $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                                                <button class="btn btn-success btn-block"> خرید</button>
                                                            </p>
                                                        </a>
                                                    @else
                                                        <a
                                                            href="{{ route('SingleProduct', ['productID' => App\myappenv::PreProductTag . $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                                                <button class="btn btn-success btn-block">
                                                                    استعلام</button>
                                                            </p>
                                                        </a>
                                                    @endif
                                                @else
                                                    @if ($ProductItem->MinPrice == 0)
                                                        <a onclick="SelectProduct('{{ $ProductItem->NameFa }}' , '{{ $ProductItem->wgid }}', '{{ $ProductItem->id }}' ,'{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}', {{ $ProductItem->Price }} ,  {{ $ProductItem->BasePrice }}, '{{ $ProductItem->PricePlan }}' )"
                                                            data-toggle="modal" data-target=".bd-example-modal-lg">
                                                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                                                <button class="btn btn-success btn-block"> خرید</button>
                                                            </p>
                                                        </a>
                                                    @else
                                                        <a onclick="SelectProduct('{{ $ProductItem->NameFa }}' , '{{ $ProductItem->wgid }}', '{{ $ProductItem->id }}' ,'{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}', {{ $ProductItem->Price }} ,  {{ $ProductItem->BasePrice }}, '{{ $ProductItem->PricePlan }}' )"
                                                            data-toggle="modal" data-target=".bd-example-modal-lg">
                                                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                                                <button class="btn btn-success btn-block">
                                                                    استعلام</button>
                                                            </p>
                                                        </a>
                                                    @endif
                                                @endisset


                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div
                            class="horizantal-list-item     @if ($Tag->L3img != '' && $Tag->L3img != null) @else  nested @endif
                    ">
                            <div style="height: 94.5%" class="max-card card o-hidden mb-4 d-flex flex-column">
                                <div class="list-thumb d-flex picutre_fixer">
                                    <img alt="" src="{{ $Tag->L3img }}">
                                </div>
                                <div class="flex-grow-1 d-bock">
                                    <div
                                        class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                        <a class="w-40 w-sm-100" href="">
                                            <div class="item-title">
                                                دسته بندی
                                                <div class="br_div"></div>
                                                {{ $Tag->L3Name }}
                                            </div>
                                        </a>
                                        <div class="br_div"></div>
                                        <a href="{{ route('ShowProduct', ['Tags' => $Tag->UID]) }}"
                                            style="bottom: 18px;position: absolute;left: 10px;width: 88%;">
                                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                                <button class="btn btn-success btn-block"> نمایش همه </button>
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    @endif
@endif
@endforeach
