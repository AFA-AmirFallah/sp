@php
$Persian = new App\Functions\persian();
$BenefitTotall = 0;
$LocationInit = 0;
$IsUse = false;
@endphp
@extends('Layouts.CustomerMainPage')
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('before-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_arrows.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_circles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_dots.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <style type="text/css">
        .tashim_product903 {
            position: absolute;
            z-index: 9;
            color: green;
            transform: rotate(10deg);
            margin: 10px;
            font-weight: 500;
            font-size: 18px;
        }

        .btnactive {
            background-color: #4CAF50;
            border: none;
            cursor: pointer;
            padding: 12px 30px;
            display: inline-block;
            border-radius: 5px;
            color: #fff;
            outline: none;
        }

        .btndeactive {
            background-color: #363836;
            border: none;
            cursor: pointer;
            padding: 12px 30px;
            display: inline-block;
            border-radius: 5px;
            color: #fff;
            outline: none;
        }

        .tick {
            display: inline-block;
            position: relative;
        }

        .tick:after {
            content: '';
            position: absolute;
            right: 11px;
            top: 8px;
            display: block;
            width: 5px;
            height: 9px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
    <input class="nested" id="confirmcode">
    <div style="width: 100%" class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pwa_h1_title">
                        <svg style="margin-left: 6px;margin-top: 10px;" width="12" height="2" viewBox="0 0 12 2"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" width="9" height="2" rx="1" fill="#30BFB4" />
                            <rect width="2" height="2" rx="1" fill="#30BFB4" />
                        </svg>
                        <h2 class="pwa_h2_title"> سبد خرید</h2>
                        <svg style="margin-right: 6px;margin-top: 10px;" width="30" height="2" viewBox="0 0 30 2"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" width="27" height="2" rx="1" fill="#30BFB4" />
                            <rect width="2" height="2" rx="1" fill="#30BFB4" />
                        </svg>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>


            </div>
        </div>
        @php
            $DeleverCondition = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('BuyCondition');
            $FreeDelever = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('FreeDelever');
            $FreeDeleverText = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('FreeDeleverText');
            
        @endphp
        @if ($DeleverCondition != null && $DeleverCondition != '#')
            <div class="modal fade" id="notloginmodal" tabindex="-1" role="dialog" aria-labelledby="notloginmodalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notloginmodalLabel">شرایط و قوانین سایت</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! $DeleverCondition !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="top_into76 continer_base">
        <div class="top_into76 continer_sub">
            <hr class="top_into76">
            <div id="step_1" class="StepViewer top_into76 Item_base active">
                <div class="top_into76 item_sub">
                    ۱
                </div>
                <p class="top_into76">
                    سبد خرید

                </p>

            </div>
            <div id="step_2" style="margin-left: 10%;margin-right: 10%;"
                class="StepViewer top_into76 Item_base deactive">
                <div class="top_into76 item_sub">
                    ۲
                </div>
                <p class="top_into76 ">
                    ثبت درخواست
                </p>

            </div>
            <div id="step_3" class="StepViewer top_into76 Item_base deactive">
                <div class="top_into76 item_sub">
                    ۳
                </div>
                <p class="top_into76 ">
ثبت سفارش                </p>
            </div>
        </div>
    </div>
    @if ($OrderDetials == null)
        <div class="card wpa_cards checkout" style="margin-top: 10px;">
            <div class="checkout78_emty svg ">
                <svg width="130" height="130" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M64.9997 79.1309C54.464 79.1309 44.4286 83.5933 37.4594 91.3763C36.4194 92.5406 36.5184 94.3239 37.6799 95.3667C38.2168 95.85 38.8923 96.0874 39.5649 96.0874C40.3392 96.0874 41.1136 95.7709 41.6703 95.1463C47.5684 88.5587 56.0721 84.783 64.9997 84.783C73.9301 84.783 82.4338 88.5587 88.329 95.1463C89.369 96.3106 91.1579 96.4067 92.3194 95.3667C93.481 94.3267 93.5799 92.5406 92.5399 91.3763C85.5736 83.5961 75.5381 79.1309 64.9997 79.1309Z"
                        fill="#30BFB4" />
                    <path
                        d="M65 0C29.1567 0 0 29.1596 0 65C0 100.84 29.1567 130 65 130C100.843 130 130 100.84 130 65C130 29.1596 100.843 0 65 0ZM65 124.348C32.2767 124.348 5.65217 97.7261 5.65217 65C5.65217 32.2739 32.2767 5.65217 65 5.65217C97.7233 5.65217 124.348 32.2739 124.348 65C124.348 97.7261 97.7233 124.348 65 124.348Z"
                        fill="#A6A4A4" />
                    <path
                        d="M98.9128 45.2178C97.35 45.2178 96.0867 46.4839 96.0867 48.0439C96.0867 52.7182 92.2828 56.5221 87.6085 56.5221C82.9341 56.5221 79.1302 52.7182 79.1302 48.0439C79.1302 46.4839 77.8669 45.2178 76.3041 45.2178C74.7413 45.2178 73.478 46.4839 73.478 48.0439C73.478 55.8354 79.8169 62.1743 87.6085 62.1743C95.4 62.1743 101.739 55.8354 101.739 48.0439C101.739 46.4839 100.476 45.2178 98.9128 45.2178Z"
                        fill="#A6A4A4" />
                    <path
                        d="M56.5216 48.0439C56.5216 46.4839 55.2583 45.2178 53.6955 45.2178C52.1327 45.2178 50.8694 46.4839 50.8694 48.0439C50.8694 52.7182 47.0655 56.5221 42.3912 56.5221C37.7168 56.5221 33.9129 52.7182 33.9129 48.0439C33.9129 46.4839 32.6497 45.2178 31.0868 45.2178C29.524 45.2178 28.2607 46.4839 28.2607 48.0439C28.2607 55.8354 34.5997 62.1743 42.3912 62.1743C50.1827 62.1743 56.5216 55.8354 56.5216 48.0439Z"
                        fill="#A6A4A4" />
                </svg>
            </div>
            <div class="checkout78_emty text">
                در سبدخرید شما کالایی موجود نیست
            </div>
            <div class="checkout78_emty text">
                برای مشاهده کالاها به صفحه اصلی سایت مراجعه کنید.
            </div>
            <div class="checkout78_emty">
                <a style="color: white" href="{{ route('home') }}" class="btn add_to_basket" id="AddToBasketbtn"
                    onclick="view_stepper()" type="button" name="submit" value="5477">

                    بازگشت به صفحه اصلی سایت </a>
            </div>

        </div>
    @else
        <div id="ListOFProduct">
            @php
                $count = 0;
                $TOPayTotall = 0;
            @endphp
            <div class="checkoutContineer91">

                <div class="product_continer_91 main">


                    @foreach ($OrderDetials as $MyOrderTarget)
                        @php
                            $count++;
                        @endphp
                        <div id="ProductRow_HasProduct" class="card product_continer_91">
                            <div class="product_continer_91 titel">
                                <button onclick="RemoveOrder({{ $MyOrderTarget['Product']->id }})" class="OrderClose"
                                    type="button">
                                    <span aria-hidden="true"> <svg width="18" height="18" viewBox="0 0 18 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.96484 0C13.9082 0 18 4.02152 18 8.96484C18 13.9082 13.9082 18 8.96484 18C4.02152 18 0 13.9082 0 8.96484C0 4.02152 4.02152 0 8.96484 0ZM4.52742 11.9106C4.11609 12.3219 4.11609 12.9909 4.52742 13.4026C4.93559 13.8104 5.60461 13.8171 6.01945 13.4026L8.96484 10.4562L11.9809 13.403C12.3922 13.8143 13.0613 13.8143 13.4729 13.403C13.8843 12.9916 13.8843 12.3226 13.4729 11.9109L10.5268 8.96484L13.4729 6.01875C13.8843 5.60707 13.8843 4.93805 13.4729 4.52672C13.0613 4.11539 12.3922 4.11539 11.9809 4.52672L8.96484 7.47352L6.01945 4.52672C5.60883 4.11609 4.93981 4.11469 4.52742 4.52672C4.11609 4.93805 4.11609 5.60707 4.52742 6.01875L7.47351 8.96484L4.52742 11.9106Z"
                                                fill="#F8384E" />
                                        </svg></span>
                                </button>

                            </div>
                            <div class="product_continer_91 mainbody">
                                <div class="product_continer_91 right_element">
                                    <img class="product_continer_91"
                                        src="{{ App\Functions\Images::GetPicture($MyOrderTarget['Product']->ImgURL, 1) }}"
                                        alt="{{ $MyOrderTarget['Product']->NameFa }}">
                                </div>
                                <div class="product_continer_91 left_element">
                                    <h6 class="product_continer_91">{{ $MyOrderTarget['Product']->NameFa }}</h6>
                                    <div id="ProductRow_{{ $MyOrderTarget['Product']->id }}">

                                        <div style="margin-right: 14px;padding-left: 61px;margin-bottom: 15px;"
                                            class="row">
                                            <div class="col-sm-3">


                                            </div>

                                        </div>
                                        <div style="display: flex;flex-wrap: wrap;" class="col-sm-12 ">
                                            @php
                                                $TashimRes = $MyProduct->TashimBlade($MyOrderTarget['Product']->id, $MyOrderTarget['ProductInWarehouse']->Price);
                                            @endphp
                                            <p class="product_continer_91">قیمت واحد :</p>
                                            @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0)
                                                @if ($TashimRes[0] == null)
                                                    <strong class="product_continer_91">
                                                        {{ number_format($MyOrderTarget['ProductInWarehouse']->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </strong>
                                                @else
                                                    {{ number_format($TashimRes[1] / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    <small>{{ $TashimRes[0] }}</small>
                                                @endif
                                            @else
                                                @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == $MyOrderTarget['ProductInWarehouse']->MaxPrice || $MyOrderTarget['ProductInWarehouse']->MaxPrice == 0)
                                                    {{ number_format($MyOrderTarget['ProductInWarehouse']->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                @else
                                                    از
                                                    {{ number_format($MyOrderTarget['ProductInWarehouse']->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    تا
                                                    {{ number_format($MyOrderTarget['ProductInWarehouse']->MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                @endif
                                            @endif
                                        </div>
                                        <input id="ProductMax_{{ $MyOrderTarget['Product']->id }}" class="nested"
                                            value="                                           @if ($MyOrderTarget['ProductInWarehouse']->Remian > $MyOrderTarget['ProductInWarehouse']->SaleLimit) {{ $MyOrderTarget['ProductInWarehouse']->SaleLimit }} @else
                                        {{ $MyOrderTarget['ProductInWarehouse']->Remian }} @endif " />

                                    </div>
                                    @php
                                        if ($MyOrderTarget['ProductInWarehouse']->PricePlan == null) {
                                            
                                            if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0) {
                                                if (isset($TashimRes[0]) && $TashimRes[0] != '') {
                                                    $UnitPrice = $TashimRes[1];
                                                } else {
                                                    $UnitPrice = $MyOrderTarget['ProductInWarehouse']->Price;
                                                }
                                                $ItemTotall = $UnitPrice * $MyOrderTarget['ProductQty'];
                                                $ItemBenefit = $MyOrderTarget['ProductInWarehouse']->BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;
                                                $BenefitTotall += $ItemBenefit;
                                                $TOPayTotall += $ItemTotall;
                                            }
                                            else{
                                            $ItemTotall = $MyOrderTarget['ProductInWarehouse']->MinPrice * $MyOrderTarget['ProductQty'];
                                            $ItemBenefit = $MyOrderTarget['ProductInWarehouse']->BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;
                                            $BenefitTotall += $ItemBenefit;
                                            $TOPayTotall += $ItemTotall; 
                                            }
                                        } else {
                                            $ItemTotall = $MyOrderTarget['ProductInWarehouse']->MinPrice * $MyOrderTarget['ProductQty'];
                                            $ItemBenefit = $MyOrderTarget['ProductInWarehouse']->BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;
                                            $BenefitTotall += $ItemBenefit;
                                            $TOPayTotall += $ItemTotall;
                                           
                                        }
                                    @endphp
                                    @if ($TashimRes[0] == null)
                                        <div style="display: flex;flex-wrap: wrap;" class="col-sm-12">
                                            <p class="product_continer_91"> سود خرید نقدی این محصول:</p>
                                            @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0)
                                                <strong style="color: red" class="product_continer_91">
                                                    {{ number_format($ItemBenefit / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                </strong>
                                            @else
                                                <strong style="color: red" class="product_continer_91">
                                                    پس از استعلام
                                                </strong>
                                            @endif
                                        </div>
                                    @else
                                        <div style="display: flex;flex-wrap: wrap;" class="col-sm-12">

                                        </div>
                                    @endif


                                    <form method="POST">
                                        @csrf
                                        <input type="text" class="nested" name="pwid"
                                            value="{{ $MyOrderTarget['ProductInWarehouse']->id }}">
                                        <input type="text" class="nested" name="ProductId"
                                            value="{{ $MyOrderTarget['Product']->id }}">
                                        @if ($MyOrderTarget['Tashims'] != [])
                                            <div style="display: grid">
                                                <h6 class="titr-checkout">نوع خرید: </h6>
                                                @php
                                                    $HasTashim = false;
                                                    
                                                @endphp

                                                @foreach ($MyOrderTarget['Tashims'] as $TashimItem)
                                                    @php
                                                        $IsUse = false;
                                                    @endphp
                                                    @if ($TashimSession != null)
                                                        @foreach ($TashimSession as $TashimSessionItem)
                                                            @if ($TashimSessionItem->ProductId == $MyOrderTarget['Product']->id && $TashimSessionItem->Tashim == $TashimItem->TashimID)
                                                                @php
                                                                    $IsUse = true;
                                                                    $HasTashim = true;
                                                                    $TargetProduct = $TashimSessionItem->ProductId;
                                                                    $TargetTashim = $TashimItem->TashimID;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if ($IsUse)
                                                        <span style="padding-top:10px;" class="tick"><button
                                                                type="submit" name="Tashim" class="btnactive "
                                                                value="{{ $TashimItem->TashimID }}">
                                                                {{ $TashimItem->Name }}
                                                            </button> </span>
                                                    @else
                                                        <span style="padding-top:10px;"class=""><button
                                                                type="submit" name="Tashim"
                                                                class="btndeactive kookbaz-color-deactive22"
                                                                value="{{ $TashimItem->TashimID }}">
                                                                {{ $TashimItem->Name }}
                                                            </button> </span>
                                                    @endif
                                                @endforeach
                                                @if ($HasTashim)
                                                    <span style="padding-top:10px;" class=""><button type="submit"
                                                            name="Tashim" class="btndeactive kookbaz-color-deactive22"
                                                            value="0">
                                                            خرید نقدی
                                                        </button> </span>
                                                @else
                                                    <span style="padding-top:10px;" class="tick"><button type="submit"
                                                            name="Tashim" class="btnactive" value="0">
                                                            خرید نقدی
                                                        </button> </span>
                                                @endif
                                                <hr>
                                                @if ($HasTashim)
                                                    <p class="titr-checkout">روش پرداخت:</p>
                                                    @php
                                                        $TashimInfo = $TashimWork->CustomerTashimInfo($TargetProduct, $TargetTashim);
                                                    @endphp
                                                    @foreach ($TashimInfo as $TashimInfoTarget)
                                                        @if ($TashimInfoTarget['TargetUser'] == 'buyer')
                                                            <p>{{ $TashimInfoTarget['Note'] }} :
                                                                {{ number_format(($TashimInfoTarget['Amount'] * -1) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                @endif


                                            </div>
                                        @endif
                                    </form>


                                    <br>
                                </div>
                            </div>
                            <div class="product_continer_91 minfooter">
                                @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0)
                                    <div class="product_continer_91 footer_right">
                                        {{ number_format($ItemTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        <small>{{ App\Http\Controllers\Credit\currency::GetCurrency() }}</small>
                                    </div>
                                @else
                                    <div class="product_continer_91 footer_right">
                                        مبلغ نهایی پس از استعلام اعلام خواهد شد
                                    </div>
                                @endif
                                <div class="product_continer_91 footer_left">
                                    <div id="main_stepper" class="stepper303">
                                        <div class="fixer303">
                                            @if ($MyOrderTarget['ProductQty'] > 1)
                                                <button id="dec_count" type="button" onclick="decrease_qty()"
                                                    class="stepper303 decrese"><svg width="10" height="1"
                                                        viewBox="0 0 10 1" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="10" height="1" rx="0.5"
                                                            fill="#30BFB4" />
                                                    </svg></button>

                                                <button id="remove_count" type="button" onclick="cancel_buy()"
                                                    class="stepper303 decrese nested"><svg style="color: red"
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                        <path fill-rule="evenodd"
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                    </svg></button>
                                            @else
                                                <button id="dec_count" type="button" onclick="decrease_qty()"
                                                    class="nested stepper303 decrese"><svg width="10" height="1"
                                                        viewBox="0 0 10 1" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="10" height="1" rx="0.5"
                                                            fill="#30BFB4" />
                                                    </svg></button>

                                                <button id="remove_count" type="button" onclick="cancel_buy()"
                                                    class="stepper303 decrese"><svg style="color: red"
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                        <path fill-rule="evenodd"
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                    </svg></button>
                                            @endif
                                            @if ($MyOrderTarget['ProductQty'] > 0)
                                                <input id="cont_value" type="text" class="stepper303"
                                                    value="{{ $MyOrderTarget['ProductQty'] }}">
                                            @else
                                                <input id="cont_value" type="text" class="stepper303" value="1">
                                            @endif
                                            <button type="button" onclick="increase_qty()"
                                                class="stepper303 increas"><svg width="14" height="14"
                                                    viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.51175 1.21692C7.51166 0.871768 7.23191 0.592018 6.88671 0.591886C6.54155 0.591886 6.26171 0.871724 6.26167 1.21692L6.26167 6.25868L1.21991 6.25868C0.874755 6.25868 0.594917 6.53852 0.594873 6.88372C0.594917 7.0563 0.664833 7.21257 0.777926 7.32566C0.891019 7.43875 1.04729 7.50867 1.21987 7.50871L6.26172 7.50871L6.26171 12.5505C6.26176 12.7231 6.33168 12.8793 6.44477 12.9924C6.55786 13.1055 6.71413 13.1754 6.88671 13.1755C7.23187 13.1755 7.5117 12.8956 7.51175 12.5504L7.51175 7.50867L12.5535 7.50867C12.8987 7.50867 13.1785 7.22883 13.1785 6.88363C13.1785 6.53848 12.8987 6.25873 12.5535 6.2586L7.51175 6.25868L7.51175 1.21692Z"
                                                        fill="#30BFB4" />
                                                </svg></button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($count > 0)
                    <div class="card wpa_cards order_summery_191">
                        <div class="order_summery_191" class="col-sm-12">
                            <div class="row">
                                <p class="order_summery_191">قیمت تقریبی کل   کالاها
                                </p>
                                <p style="color: var(--kookbaz_green);font-size: 15px;font-weight: 700;">
                                    
                                    ({{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() }})</p>
                                <strong style="display: flex" class="order_summery_191 value">
                                    <div id="kool_price">
                                        {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    </div>
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </strong>

                            </div>
                            
                            <hr class="order_summery_191">
                         
              
                            <small>
قیمت نهایی کالا پس از ثبت پیش فاکتور اعلام خواهد شد                                !</small>
                            <hr class="order_summery_191">
                            <div style="padding-left: 11px;">
                                @if (Auth::Check())
                                    <button style="font-size:14px" onclick="steper('ListOFProduct')" type="button"
                                        id="contenubtn" class="btn btn-primary btn-block m-1 mb-3">ادامه فرایند
                                        خرید</button>
                                    <button style="font-size:14px" type="submit" id="UpdateBasket" name="submit"
                                        value="updatebasket" class=" nested btn btn-primary btn-block m-1 mb-3">بروز
                                        رسانی سبد
                                        خرید</button>
                                @else
                                    <a type="button" href="{{ route('login') }}" style="font-size:14px"
                                        class="btn btn-primary btn-block m-1 mb-3">ورود و ادامه</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="nested" style="width: 90%;margin-right: 5%;" id="ShowRegistedAddress">
            <div class="checkoutContineer91">
                <div class="product_continer_91 main">
                    <div class="card wpa_cards">
                        <div class="card-title">انتخاب محل تحویل</div>
                        <span onclick="steper('ShowRegistedAddress_Back')"
                            style="left: 10px;text-align: left;position: absolute;font-size: 22px;" aria-hidden="true"><i
                                class="i-Arrow-Out-Right"></i></span>
                        <hr>
                        @php
                            $Loccounter = 1;
                        @endphp
                    </div>

                    @foreach ($UserLocations as $UserLocation)
                        @php
                            $Loccounter++;
                        @endphp
                        <div style="margin-top: 10px;margin-bottom:10px;" class="card wpa_cards">
                            <button class="deleteaddress" type="submit" name="deleteaddress"
                                value="{{ $UserLocation->id }}">
                                <svg class="w-4 h-4 " width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path
                                        d="M6.97266 0C10.8175 0 14 3.12785 14 6.97266C14 10.8175 10.8175 14 6.97266 14C3.12785 14 0 10.8175 0 6.97266C0 3.12785 3.12785 0 6.97266 0ZM3.52133 9.26379C3.20141 9.58371 3.20141 10.1041 3.52133 10.4243C3.83879 10.7414 4.35914 10.7466 4.6818 10.4243L6.97266 8.13258L9.31848 10.4245C9.6384 10.7445 10.1588 10.7445 10.4789 10.4245C10.7989 10.1046 10.7989 9.58426 10.4789 9.26406L8.18754 6.97266L10.4789 4.68125C10.7989 4.36105 10.7989 3.8407 10.4789 3.52078C10.1588 3.20086 9.6384 3.20086 9.31848 3.52078L6.97266 5.81273L4.6818 3.52078C4.36242 3.20141 3.84207 3.20031 3.52133 3.52078C3.20141 3.8407 3.20141 4.36105 3.52133 4.68125L5.81273 6.97266L3.52133 9.26379Z"
                                        fill="#F8384E"></path>
                                </svg>
                            </button>
                            <div class="address_checkout319 card-content card-content-padding ">
                                <div class="address_checkout319 right">
                                    @if ($Loccounter == 2)
                                        @php
                                            $LocationInit = $UserLocation->id;
                                        @endphp
                                        <input id="radio_{{ $UserLocation->id }}" type="radio" class="nested"
                                            checked name="Location" value="{{ $UserLocation->id }}">
                                        <div onclick="radio_click({{ $UserLocation->id }})" class="radio_btn">
                                            <div id="radio_point_{{ $UserLocation->id }}"
                                                class="radio_btn active radiochecker">
                                            </div>
                                        </div>
                                    @else
                                        <input id="radio_{{ $UserLocation->id }}" type="radio" class="nested"
                                            name="Location" value="{{ $UserLocation->id }}">
                                        <div onclick="radio_click({{ $UserLocation->id }})" class="radio_btn">
                                            <div id="radio_point_{{ $UserLocation->id }}"
                                                class="radio_btn deactive radiochecker"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="address_checkout319 left">
                                    <input class="nested" type="text" id="LocationProvince_{{ $UserLocation->id }}"
                                        value="{{ $UserLocation->ProvinceID }}">
                                    <p class="order_summery_191">{{ $UserLocation->name }}</p>
                                    <p class="order_summery_191"><svg width="20" height="20" viewBox="0 0 20 20"
                                            fill="none">
                                            <g clip-path="url(#clip0)">
                                                <path
                                                    d="M10.1437 9.63408C8.82019 9.63408 7.67425 9.15938 6.73767 8.22279C5.80139 7.28636 5.32654 6.14058 5.32654 4.81689C5.32654 3.49365 5.80124 2.34771 6.73782 1.41098C7.67441 0.4747 8.82034 0 10.1437 0C11.4674 0 12.6132 0.4747 13.5497 1.41113C14.4861 2.34756 14.9609 3.49349 14.9609 4.81689C14.9609 6.14058 14.4861 7.28652 13.5497 8.22295C12.6129 9.15922 11.467 9.63408 10.1437 9.63408ZM12.7208 2.23983C12.0023 1.5213 11.1594 1.17203 10.1437 1.17203C9.12826 1.17203 8.28522 1.5213 7.56653 2.23983C6.84799 2.95852 6.49856 3.80157 6.49856 4.81689C6.49856 5.83251 6.84799 6.6754 7.56653 7.39409C8.28522 8.11278 9.12826 8.46205 10.1437 8.46205C11.1591 8.46205 12.002 8.11263 12.7208 7.39409C13.4395 6.67555 13.7889 5.83251 13.7889 4.81689C13.7889 3.80157 13.4395 2.95852 12.7208 2.23983Z"
                                                    fill="#4A4A4A"></path>
                                                <path
                                                    d="M1.71371 15.3784C1.74072 14.9887 1.79535 14.5636 1.87576 14.1146C1.95694 13.6624 2.06146 13.2348 2.18658 12.844C2.31598 12.4401 2.49161 12.0413 2.70905 11.6591C2.93442 11.2623 3.19931 10.9169 3.49655 10.6326C3.80737 10.3352 4.18793 10.0961 4.62799 9.92169C5.06653 9.7482 5.55252 9.66031 6.07239 9.66031C6.27655 9.66031 6.474 9.74408 6.85532 9.99234C7.09 10.1454 7.3645 10.3224 7.6709 10.5182C7.93289 10.6851 8.28781 10.8415 8.7262 10.9831C9.1539 11.1215 9.58817 11.1917 10.0169 11.1917C10.4454 11.1917 10.8797 11.1215 11.3077 10.9831C11.7456 10.8416 12.1007 10.6852 12.3622 10.5183C12.6657 10.3244 12.9404 10.1474 13.1786 9.99219C13.5596 9.74393 13.757 9.66016 13.9612 9.66016C14.4812 9.66016 14.967 9.7482 15.4054 9.92184C15.8452 10.0959 16.2259 10.3351 16.537 10.6327C16.8343 10.9172 17.0992 11.2625 17.3244 11.6591C17.5415 12.0413 17.7173 12.44 17.8467 12.8442C17.9716 13.235 18.0762 13.6624 18.1573 14.1146C18.2379 14.5629 18.2924 14.9882 18.3194 15.3788C18.3459 15.7608 18.3594 16.1583 18.3594 16.5599C18.3594 17.6039 18.0275 18.449 17.373 19.0724C16.7267 19.6875 15.8716 19.9993 14.8314 19.9993H5.20126C4.16138 19.9993 3.30627 19.6875 2.65976 19.0724C2.00516 18.4495 1.67328 17.604 1.67328 16.5597C1.67343 16.1567 1.68701 15.7592 1.71371 15.3784ZM3.46786 18.2232C3.89496 18.6297 4.46198 18.8273 5.20142 18.8273H14.8314C15.571 18.8273 16.138 18.6297 16.5649 18.2234C16.9838 17.8247 17.1873 17.2804 17.1873 16.5599C17.1873 16.1851 17.175 15.8151 17.1503 15.4599C17.1262 15.1113 17.0769 14.7285 17.0038 14.3217C16.9316 13.9199 16.8398 13.5429 16.7305 13.2016C16.6257 12.8743 16.4827 12.5502 16.3054 12.238C16.1362 11.9404 15.9415 11.6851 15.7266 11.4795C15.5257 11.287 15.2724 11.1296 14.9739 11.0115C14.6979 10.9022 14.3877 10.8424 14.0509 10.8334C14.0099 10.8552 13.9368 10.8969 13.8184 10.9741C13.5774 11.1311 13.2997 11.3102 12.9927 11.5063C12.6466 11.727 12.2008 11.9262 11.6681 12.0982C11.1235 12.2743 10.5681 12.3637 10.0168 12.3637C9.46548 12.3637 8.90991 12.2743 8.36563 12.0984C7.83249 11.9261 7.38678 11.727 7.04025 11.506C6.72607 11.3052 6.45615 11.1313 6.21521 10.9741C6.0968 10.897 6.02371 10.8552 5.98267 10.8334C5.64575 10.8424 5.33554 10.9022 5.05936 11.0115C4.76105 11.1296 4.50775 11.2872 4.30679 11.4795C4.09195 11.685 3.89725 11.9403 3.72803 12.2381C3.55057 12.5502 3.40744 12.8744 3.30276 13.2014C3.19336 13.5432 3.10135 13.9201 3.02933 14.3216C2.95639 14.7291 2.90695 15.1121 2.88284 15.46V15.4603C2.85797 15.8142 2.84546 16.184 2.84531 16.5599C2.84546 17.2805 3.04901 17.8247 3.46786 18.2232Z"
                                                    fill="#4A4A4A"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0">
                                                    <rect width="20" height="20" fill="white"
                                                        transform="matrix(-1 0 0 1 20 0)">
                                                    </rect>
                                                </clipPath>
                                            </defs>
                                        </svg> {{ $UserLocation->recivername }}</p>
                                    <p class="order_summery_191"><svg width="20" height="20" viewBox="0 0 20 20"
                                            fill="none">
                                            <path
                                                d="M19.0983 14.5686L16.1326 12.0468C16.1189 12.0352 16.1044 12.0245 16.0893 12.0149C15.3112 11.5196 14.3122 11.6293 13.6599 12.2815L12.043 13.8983C11.931 14.0105 11.7639 14.0436 11.6174 13.9832C9.79153 13.2278 8.29159 12.0908 7.15923 10.6038C6.29574 9.46991 5.98446 8.56888 5.94341 8.44193C5.93853 8.41477 5.93075 8.38776 5.91976 8.36136C5.85919 8.21488 5.8923 8.0481 6.0046 7.9361L7.62142 6.31882C8.27374 5.66651 8.38329 4.66752 7.88799 3.88947C7.88403 3.88321 7.87991 3.87711 7.87563 3.87101L5.73391 0.89478C5.06008 -0.150599 3.59234 -0.308528 2.71145 0.57221L2.38766 0.896001C2.38751 0.896306 2.3872 0.896611 2.3869 0.896764L1.23089 2.05277C-0.147589 3.4314 -0.373114 5.50293 0.578882 8.04383C1.39431 10.2203 3.0267 12.6024 5.17529 14.751C7.37469 16.9504 9.82113 18.613 12.0639 19.4325C14.2837 20.2435 16.645 20.3435 18.3163 18.672L19.4065 17.5819C20.2835 16.7049 20.1304 15.2467 19.0983 14.5686ZM15.6486 12.6605L18.6117 15.1802C18.6253 15.1918 18.6398 15.2025 18.6549 15.2121C19.2878 15.6151 19.3837 16.5001 18.854 17.0296L18.7732 17.1106L13.7193 13.3267L14.2123 12.8339C14.5976 12.4484 15.1847 12.3787 15.6486 12.6605ZM5.08129 1.32401C5.08526 1.33027 5.08938 1.33652 5.09365 1.34247L7.23446 4.31763C7.52529 4.78318 7.458 5.37751 7.06905 5.76645L6.5913 6.24436L3.17211 1.21628L3.26382 1.12458C3.79559 0.592809 4.67983 0.693364 5.08129 1.32401ZM12.3318 18.6987C10.1937 17.9175 7.84832 16.3193 5.72765 14.1986C3.65612 12.1272 2.08737 9.84406 1.31024 7.76978C0.726892 6.21277 0.335504 4.05289 1.78326 2.60529L2.60983 1.77857L6.02902 6.80664L5.45239 7.38358C5.12432 7.71103 5.02117 8.19565 5.1849 8.62717C5.30819 9.13315 5.87551 10.1834 6.44787 10.9573C7.29015 12.0963 8.81893 13.6708 11.3188 14.705C11.7581 14.8868 12.259 14.787 12.5953 14.4508L13.1613 13.8847L18.2151 17.6686L17.7639 18.1197C16.212 19.6718 13.9534 19.2912 12.3318 18.6987Z"
                                                fill="#4A4A4A"></path>
                                        </svg> {{ $UserLocation->reciverphone }}</p>
                                    <small> {{ $UserLocation->City }} - {{ $UserLocation->Street }}
                                        {{ $UserLocation->OthersAddress }} پلاک: {{ $UserLocation->Pelak }} </small>
                                    <div style="display: flex">
                                        <a onclick="showaddress({{ $UserLocation->id }})"
                                            style="display: flex;font-size: 15px;margin-top: 15px;margin-bottom: 15px;color: var(--kookbaz_green);cursor: pointer;">تغییر
                                            یا ویرایش آدرس
                                            <div class="left_arrow"></div>
                                        </a>
                                        <a onclick="hideaddress({{ $UserLocation->id }})"
                                            id="hode_address_{{ $UserLocation->id }}" class="nested"
                                            style="display: flex;font-size: 15px;margin-top: 15px;margin-bottom: 15px;cursor: pointer;color: red;padding-right: 14px;padding-top: 3px;">
                                            انصراف</a>
                                    </div>
                                    <form method="post">
                                        @csrf
                                        <div dir="rtl" class="nested" id="ChandeAddress_{{ $UserLocation->id }}"
                                            style="text-align: center">
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18">نام محل : (خانه ، شرکت و ....)</label>
                                                    <input autocomplete="false" value="{{ $UserLocation->name }}"
                                                        name="LocationName" class="inputContiner18" type="text">
                                                    <small class="inputContiner18 text-red">فیلد الزامی است</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18">خیابان :</label>
                                                    <input autocomplete="false" value="{{ $UserLocation->Street }}"
                                                        name="Street" class="inputContiner18" type="text">
                                                    <small class="inputContiner18 text-red">فیلد الزامی است</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18">کوچه :</label>
                                                    <input autocomplete="false"
                                                        value="{{ $UserLocation->OthersAddress }}" name="OthersAddress"
                                                        class="inputContiner18" type="text">
                                                    <small class="inputContiner18"></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18">پلاک :</label>
                                                    <input autocomplete="false" autocomplete="false" autocomplete="false"
                                                        value="{{ $UserLocation->Pelak }}" name="Pelak"
                                                        class="inputContiner18" type="text">
                                                    <small class="inputContiner18 text-red">فیلد الزامی است</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18"> کد پستی :</label>
                                                    <input autocomplete="false" value="{{ $UserLocation->PostalCode }}"
                                                        name="PostalCode" class="inputContiner18" type="text">
                                                    <small class="inputContiner18 text-red"></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18">نام تحویل گیرنده :</label>
                                                    <input autocomplete="false"
                                                        value="{{ $UserLocation->recivername }}" name="recivername"
                                                        class="inputContiner18" type="text">
                                                    <small class="inputContiner18 text-red"></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18">تلفن :</label>
                                                    <input autocomplete="false"
                                                        value="{{ $UserLocation->reciverphone }}" name="reciverphone"
                                                        class="inputContiner18" type="text">
                                                    <small class="inputContiner18 text-red"></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="inputContiner18">
                                                    <label class="inputContiner18">توضیحات :</label>
                                                    <input autocomplete="false" value="{{ $UserLocation->ExtraNote }}"
                                                        name="ExtraNote" class="inputContiner18" type="text">
                                                    <small class="inputContiner18 text-red"></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <button type="submit" name="ChangeAddress"
                                                    value="{{ $UserLocation->id }}" class="btn btn-kookbaz">ثبت
                                                    آدرس</button>
                                            </div>
                                        </div>


                                    </form>
                                    <input class="nested" type="text" id="LocationCity_{{ $UserLocation->id }}"
                                        value="{{ $UserLocation->CityID }}">


                                </div>
                            </div>
                        </div>
                    @endforeach
                    <form method="POST">
                        @csrf
                        <input class="nested" id="Location" name="Location" value="{{ $LocationInit }}">
                        <div style="margin-top: 10px;margin-bottom:10px;" class="card wpa_cards">
                            <div onclick="add_new_location_select()" style="padding-top: 6px;padding-bottom: 18px;"
                                class="card-content card-content-padding ">
                                <p class="order_summery_191 address"> <svg class="mr-4" width="21" height="27"
                                        viewBox="0 0 21 27" fill="none">
                                        <path
                                            d="M3.03968 19.0039L10.2232 26.6347C10.2587 26.6724 10.3016 26.7024 10.3492 26.723C10.3968 26.7435 10.4481 26.7542 10.5 26.7542C10.5519 26.7542 10.6032 26.7435 10.6508 26.723C10.6984 26.7024 10.7413 26.6724 10.7768 26.6347L17.9603 19.0039C19.0537 17.8424 19.859 16.5679 20.3537 15.216C20.8585 13.859 21.0715 12.4114 20.9789 10.967C20.8048 8.32691 19.6783 5.83893 17.8077 3.96281C16.8491 3.00387 15.7102 2.24302 14.4562 1.72387C13.2022 1.20473 11.8578 0.9375 10.5 0.9375C9.14225 0.9375 7.79784 1.20473 6.54384 1.72387C5.28984 2.24302 4.15091 3.00387 3.19233 3.96281C1.32167 5.83893 0.195203 8.32691 0.0210909 10.967C-0.0715061 12.4114 0.141499 13.859 0.646279 15.216C1.14096 16.5679 1.94625 17.8424 3.03968 19.0039ZM0.778554 11.0172C0.94048 8.55968 1.98888 6.24368 3.73003 4.49715C4.61809 3.60879 5.67323 2.90395 6.83495 2.42302C7.99668 1.94209 9.24216 1.69453 10.5 1.69453C11.7578 1.69453 13.0033 1.94209 14.165 2.42302C15.3268 2.90395 16.3819 3.60879 17.27 4.49715C19.0112 6.24374 20.0596 8.55985 20.2214 11.0174C20.3069 12.3565 20.109 13.6986 19.6405 14.9564C19.1813 16.2119 18.4298 17.3993 17.4069 18.4857L10.5 25.8226L3.59313 18.4856C2.57024 17.3991 1.81872 16.2117 1.35946 14.9563C0.89106 13.6985 0.693141 12.3565 0.778554 11.0174V11.0172Z"
                                            fill="#4A4A4A"></path>
                                        <path
                                            d="M10.5 19.712C14.8423 19.712 18.375 16.0271 18.375 11.4976C18.375 6.96811 14.8423 3.2832 10.5 3.2832C6.15769 3.2832 2.625 6.96818 2.625 11.4976C2.625 16.027 6.15769 19.712 10.5 19.712ZM10.5 4.04602C14.4288 4.04602 17.625 7.38874 17.625 11.4976C17.625 15.6064 14.4288 18.9492 10.5 18.9492C6.57125 18.9492 3.375 15.6064 3.375 11.4976C3.375 7.38874 6.57125 4.04602 10.5 4.04602Z"
                                            fill="#4A4A4A"></path>
                                        <path
                                            d="M7.37891 11.8947H10.1289V14.6427C10.1289 14.7421 10.1684 14.8374 10.2387 14.9077C10.3091 14.978 10.4045 15.0175 10.5039 15.0175C10.6034 15.0175 10.6987 14.978 10.7691 14.9077C10.8394 14.8374 10.8789 14.7421 10.8789 14.6427V11.8947H13.6289C13.7284 11.8947 13.8237 11.8552 13.8941 11.785C13.9644 11.7147 14.0039 11.6194 14.0039 11.52C14.0039 11.4206 13.9644 11.3253 13.8941 11.255C13.8237 11.1847 13.7284 11.1453 13.6289 11.1453H10.8789V8.35129C10.8789 8.25191 10.8394 8.15659 10.7691 8.08632C10.6987 8.01604 10.6034 7.97656 10.5039 7.97656C10.4045 7.97656 10.3091 8.01604 10.2387 8.08632C10.1684 8.15659 10.1289 8.25191 10.1289 8.35129V11.1453H7.37891C7.27945 11.1453 7.18407 11.1847 7.11374 11.255C7.04341 11.3253 7.00391 11.4206 7.00391 11.52C7.00391 11.6194 7.04341 11.7147 7.11374 11.785C7.18407 11.8552 7.27945 11.8947 7.37891 11.8947Z"
                                            fill="#30BFB4"></path>
                                    </svg>
                                    افزودن آدرس جدید
                                </p>
                                @if ($Loccounter == 1)
                                    @php
                                        $LocationInit = 0;
                                    @endphp
                                    <input autocomplete="false" id="AddLocation" type="radio"
                                        class="pwa_radio nested " checked name="Location" value="0">
                                @else
                                    <input autocomplete="false" id="AddLocation" type="radio" class="pwa_radio nested"
                                        name="Location" value="0">
                                @endif
                                <div onclick="add_new_location_select()" style="float: left;margin-left: 20px;"
                                    class="left_arrow"></div>
                            </div>
                        </div>
                        <hr>
                        <div style="display: flex" class="col-lg-12">




                        </div>
                </div>
                @if ($count > 0)
                    <div class="card wpa_cards order_summery_191">
                        <div class="order_summery_191" class="col-sm-12">
                            <div class="row">
                                <p class="order_summery_191">قیمت کل کالاها
                                </p>
                                <p style="color: var(--kookbaz_green);font-size: 15px;font-weight: 700;">
                                    ({{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() }})</p>
                                <strong style="display: flex" class="order_summery_191 value">
                                    <div id="kool_price">
                                        {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    </div>
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </strong>

                            </div>
                            <div class="row">
                                <p class="order_summery_191">سود شما از خرید</p>
                                <input class="nested" id="benefit_price"
                                    value="{{ $BenefitTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate() }}"
                                    type="text">
                                <strong style="color: red" class="order_summery_191 value">
                                    {{ number_format($BenefitTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</strong>

                            </div>
                            <hr class="order_summery_191">
                            <div class="row topay">
                                <p class="order_summery_191">مبلغ قابل پرداخت
                                </p>
                                <input id="topay_price" class="nested"
                                    value="{{ $TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate() }}"
                                    type="text">
                                <strong class="order_summery_191 value">
                                    {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</strong>

                            </div>
                            <hr class="order_summery_191">
                            <small>هزینه ارسال براساس آدرس، زمان تحویل، وزن و حجم مرسوله شما محاسبه خواهد
                                شد!</small>
                            <hr class="order_summery_191">
                            <div style="padding-left: 11px;">

                                <div class="col-lg-6">
                                    <a onclick="steper('ShowRegistedAddress')" type="button"
                                        style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                                        class="btn btn-primary btn-block">مرحله بعد</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
        <div class="nested" style="width: 90%;margin-right: 5%;" id="InputAddress">
            <div class="card wpa_cards">

                <div class="card-title">ثبت آدرس


                </div>

                <span onclick="steper('InputAddress_Back')"
                    style="left: 10px;text-align: left;position: absolute;font-size: 22px;" aria-hidden="true"><i
                        class="i-Arrow-Out-Right"></i></span>
                <hr>
                <div class="card-body">
                    <div dir="rtl" style="text-align: center">
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">نام محل : (خانه ، شرکت و ....)</label>
                                <input autocomplete="false" id="location_name" name="LocationName"
                                    class="inputContiner18" type="text">
                                <small class="inputContiner18 text-red">فیلد الزامی است</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18"> استان :</label>
                                <select name="Province" id="Province" onchange="LoadCitys(this.value)"
                                    class="inputContiner18">
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($Provinces as $ProvincesTarget)
                                        <option value="{{ $ProvincesTarget->id }}">
                                            {{ $ProvincesTarget->ProvinceName }}</option>
                                    @endforeach
                                </select>
                                <small class="inputContiner18 text-red">فیلد الزامی است</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18"> شهرستان :</label>
                                <select id="Shahrestan" name="Saharestan" class="inputContiner18">
                                </select>
                                <small class="inputContiner18 text-red">فیلد الزامی است</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">خیابان :</label>
                                <input autocomplete="false" id="Street" name="Street" class="inputContiner18"
                                    type="text">
                                <small class="inputContiner18 text-red">فیلد الزامی است</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">کوچه :</label>
                                <input autocomplete="false" id="OthersAddress" name="OthersAddress"
                                    class="inputContiner18" type="text">
                                <small class="inputContiner18 text-red">فیلد الزامی است</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">پلاک :</label>
                                <input autocomplete="false" id="Pelak" name="Pelak" class="inputContiner18"
                                    type="text">
                                <small class="inputContiner18 text-red">فیلد الزامی است</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">کد پستی :</label>
                                <input autocomplete="false" id="PostalCode" name="PostalCode" class="inputContiner18"
                                    type="text">
                                <small class="inputContiner18 text-red"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">نام تحویل گیرنده :</label>
                                <input autocomplete="false" name="recivername" class="inputContiner18" type="text">
                                <small class="inputContiner18 text-red"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">تلفن :</label>
                                <input autocomplete="false" name="reciverphone" class="inputContiner18" type="text">
                                <small class="inputContiner18 text-red"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputContiner18">
                                <label class="inputContiner18">توضیحات :</label>
                                <input autocomplete="false" id="ExtraNote" name="ExtraNote" class="inputContiner18"
                                    type="text">
                                <small class="inputContiner18 text-red">فیلد الزامی است</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex" class="col-lg-12">
                    <div class="col-lg-6">
                        <a onclick="steper('InputAddress_Back')" type="button"
                            style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                            class="btn btn-primary btn-block">مرحله قبل</a>
                    </div>
                    <div class="col-lg-6">
                        <a onclick="steper('InputAddress')" type="button"
                            style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                            class="btn btn-primary btn-block">مرحله
                            بعد</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="nested" style="width: 90%;margin-right: 5%;" id="shipping">
            <div class="checkoutContineer91">
                <div class="product_continer_91 main">
                    <div class="card wpa_cards">
                        <div class="card-title">روش ارسال</div>

                        <span onclick="steper('shipping_Back')"
                            style="left: 10px;text-align: left;position: absolute;font-size: 22px;" aria-hidden="true"><i
                                class="i-Arrow-Out-Right"></i></span>
                        <hr>

                        @if ($FreeDeleverText != null && $FreeDeleverText != '#')
                            <p style="color: red">{{ $FreeDeleverText }}</p>
                        @endif

                    </div>

                    <div style="margin-top: 10px;margin-bottom:10px;" class="card wpa_cards">
                        <div class="address_checkout319 card-content card-content-padding ">
                            <div class="address_checkout319 right">
                                <input id="radio_non" type="radio" class="nested" name="shipping" value="non">
                                <div onclick="PeykDelever()" class="radio_btn ">
                                    <div id="radio_point_non" class="radio_btn radiochecker1 deactive">
                                    </div>
                                </div>
                            </div>
                            <div class="address_checkout319 left">
                                <strong class="order_summery_191"><i class="i-Scooter"
                                        style="font-size: 27px;color: var(--kookbaz_green);margin-top: -2px;margin-right: -30px;position: absolute;"></i>
                                    ارسال با پیک / تیپاکس</strong>
                            </div>
                        </div>
                        <div class="address_checkout319 card-content card-content-padding ">
                            <div class="address_checkout319 right">
                                <input id="radio_shipping" type="radio" class="nested" name="shipping"
                                    value="post">
                                <div onclick="AutoDelever()" class="radio_btn ">
                                    <div id="radio_point_shipping" class="radio_btn radiochecker1 deactive">
                                    </div>
                                </div>

                            </div>
                            <div class="address_checkout319 left">
                                <strong class="order_summery_191"><i class="i-Stamp-2"
                                        style="font-size: 20px;color: var(--kookbaz_green);margin-top: -1px;margin-right: -30px;position: absolute;"></i>
                                    ارسال با پست پیشتاز</strong>
                            </div>
                        </div>
                        <div class="address_checkout319 card-content card-content-padding ">
                            <div class="address_checkout319 right ">
                                <input id="radio_callend" type="radio" class="nested" name="shipping"
                                    value="callend">
                                <div onclick="AskAndDelever()" class="radio_btn ">
                                    <div id="radio_point_callend" class="radio_btn radiochecker1 deactive">
                                    </div>
                                </div>
                            </div>
                            <div class="address_checkout319 left">
                                <strong class="order_summery_191"><i class="i-Support"
                                        style="font-size: 20px;color: var(--kookbaz_green);margin-top: -1px;margin-right: -30px;position: absolute;"></i>
                                    تحویل حضوری</strong>
                            </div>
                        </div>


                    </div>
                    <hr>



                </div>
                @if ($count > 0)
                    <div class="card wpa_cards order_summery_191">
                        <div class="order_summery_191" class="col-sm-12">
                            <div class="row">
                                <p class="order_summery_191">قیمت کل کالاها
                                </p>
                                <p style="color: var(--kookbaz_green);font-size: 15px;font-weight: 700;">
                                    ({{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() }})</p>
                                <strong style="display: flex" class="order_summery_191 value">
                                    <div id="kool_price">
                                        {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    </div>
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </strong>

                            </div>
                            <div class="row">
                                <p class="order_summery_191">سود شما از خرید</p>
                                <input class="nested" id="benefit_price"
                                    value="{{ $BenefitTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate() }}"
                                    type="text">
                                <strong style="color: red" class="order_summery_191 value">
                                    {{ number_format($BenefitTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</strong>

                            </div>
                            <hr class="order_summery_191">
                            <div class="row topay">
                                <p class="order_summery_191">مبلغ قابل پرداخت
                                </p>
                                <input id="topay_price" class="nested"
                                    value="{{ $TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate() }}"
                                    type="text">
                                <strong class="order_summery_191 value">
                                    {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</strong>

                            </div>
                            <hr class="order_summery_191">
                            <h6 id="DeleverNote"></h6>
                            <hr class="order_summery_191">
                            <div style="padding-left: 11px;">
                                <div style="display: flex" class="col-lg-12">

                                    <div class="col-lg-6">
                                        <a onclick="steper('shipping')" type="button"
                                            style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                                            id="shippingbtn" class="btn btn-primary  disabled ">ادامه</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="nested" style="width: 90%;margin-right: 5%;" id="FinalizeOrder">
            <div class="checkoutContineer91">
                <div class="product_continer_91 main">
                    <div class="card wpa_cards">
                        <div class="card-title">نهایی سازی و پرداخت</div>
                        <span onclick="steper('FinalizeOrder_Back')"
                            style="left: 10px;text-align: left;position: absolute;font-size: 22px;" aria-hidden="true"><i
                                class="i-Arrow-Out-Right"></i></span>
                        <hr>
                    </div>
                    <div class="card wpa_cards" style="margin-top: 10px;">
                        <div class="card-title"> خلاصه سفارش</div>
                        <div class="horizental-list">
                            @if ($OrderDetials != null)
                                @foreach ($OrderDetials as $MyOrderTarget)
                                    @if ($TashimSession != null)
                                        @foreach ($TashimSession as $TashimSessionItem)
                                            @if ($TashimSessionItem->ProductId == $MyOrderTarget['Product']->id && $TashimSessionItem->Tashim == $TashimItem->TashimID)
                                                @php
                                                    $HasTashim = true;
                                                    $TashimName = $TashimItem->Name;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                    <div class="horizantal-list-item cart">
                                        @if ($IsUse)
                                            @if (isset($TashimName))
                                                <div class="tashim_product903">
                                                    {{ $TashimName }}
                                                </div>
                                            @endif
                                        @endif

                                        <div class="max-card card o-hidden mb-4 d-flex flex-column">
                                            <div class="list-thumb d-flex picutre_fixer">
                                                <img class="lazy product-card-img"
                                                    src="{{ App\Functions\Images::GetPicture($MyOrderTarget['Product']->ImgURL, 1) }}"
                                                    alt="{{ $MyOrderTarget['Product']->NameFa }}">
                                            </div>
                                            <div class="flex-grow-1 d-bock">
                                                <div style="margin-top: -20px;"
                                                    class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                                    <div class="product_continer_91">
                                                        {{ $MyOrderTarget['Product']->NameFa }}
                                                    </div>
                                                    <div style="text-align: center">
                                                    </div>
                                                    <div class="br_div"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>


                    </div>


               
                    <div class="nested" style="width: 90%;margin-right: 5%;" id="FinalizeOrder">

                        <div class="card wpa_cards">
                            <div class="card-title">نهایی سازی و پرداخت</div>
                            <span onclick="steper('FinalizeOrder_Back')"
                                style="left: 10px;text-align: left;position: absolute;font-size: 22px;"
                                aria-hidden="true"><i class="i-Arrow-Out-Right"></i></span>
                            <hr>
                        </div>
                        <div class="card wpa_cards" style="margin-top: 10px;">
                            <div class="card-title"> خلاصه سفارش</div>
                            <div class="horizental-list">
                                @if ($OrderDetials != null)
                                    @foreach ($OrderDetials as $MyOrderTarget)
                                        @if ($TashimSession != null)
                                            @foreach ($TashimSession as $TashimSessionItem)
                                                @if ($TashimSessionItem->ProductId == $MyOrderTarget['Product']->id && $TashimSessionItem->Tashim == $TashimItem->TashimID)
                                                    @php
                                                        $HasTashim = true;
                                                        $TashimName = $TashimItem->Name;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        <div class="horizantal-list-item cart">
                                            @if ($IsUse)
                                                <div class="tashim_product903">
                                                    {{ $TashimName }}
                                                </div>
                                            @endif

                                            <div class="max-card card o-hidden mb-4 d-flex flex-column">
                                                <div class="list-thumb d-flex picutre_fixer">
                                                    <img class="lazy product-card-img"
                                                        src="{{ App\Functions\Images::GetPicture($MyOrderTarget['Product']->ImgURL, 1) }}"
                                                        alt="{{ $MyOrderTarget['Product']->NameFa }}">
                                                </div>
                                                <div class="flex-grow-1 d-bock">
                                                    <div style="margin-top: -20px;"
                                                        class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                                        <div class="product_continer_91">
                                                            {{ $MyOrderTarget['Product']->NameFa }}
                                                        </div>
                                                        <div style="text-align: center">


                                                        </div>





                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                @endif
                            </div>


                        </div>

                        <div id="payrole" class="payrole card wpa_cards nested" style="margin-top: 10px;">
                            <div class="card-title">روش پرداخت خود را انتخاب کنید</div>
                            <div style="width: 100%;justify-content: center;display: flex;">
                                <div class="card-choose-credit">
                                    <button type="submit" name="submit" value="submit" class="btn-kookbaz598">پرداخت
                                        درگاه بانکی
                                    </button>

                                    <button class="btn-kookbaz598" type="button"
                                        onclick="opencolaps('multiCollapseExample1')">
                                        کیف پول </button>
                                </div>
                            </div>

                        </div>
                        <div class="payrole mycollapse nested" id="collapseExample">
                            <div class="card wpa_cards credit" style="margin-top: 10px;">
                                <div class="card-title">انتخاب درگاه بانکی</div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">ایران کیش </label>
                                </div>
                            </div>
                        </div>
                        <div class="payrole mycollapse nested" id="multiCollapseExample1">
                            <div class="card wpa_cards credit" style="margin-top: 10px;">
                                <div class="card-title">انتخاب کیف پول</div>
                                <div class="card-credit-main">
                                    <div class="main-credit-cards">
                                        <div class="main-credit-content">
                                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_1689_18)">
                                                    <path
                                                        d="M29 7.5H8.5C8.22386 7.5 8 7.72386 8 8C8 8.27614 8.22386 8.5 8.5 8.5H11.5225C9.30354 9.91197 7.97145 12.3701 8 15C7.97145 17.6299 9.30354 20.088 11.5225 21.5H1V8.5H6C6.27614 8.5 6.5 8.27614 6.5 8C6.5 7.72386 6.27614 7.5 6 7.5H1C0.447715 7.5 0 7.94772 0 8.5V21.5C0 22.0523 0.447715 22.5 1 22.5H29C29.5523 22.5 30 22.0523 30 21.5V8.5C30 7.94772 29.5523 7.5 29 7.5ZM9 15C9 11.416 11.6915 8.5 15 8.5C18.3085 8.5 21 11.416 21 15C21 18.584 18.3085 21.5 15 21.5C11.6915 21.5 9 18.584 9 15ZM29 21.5H18.4775C20.6965 20.088 22.0285 17.6299 22 15C22.0285 12.3701 20.6965 9.91197 18.4775 8.5H29V21.5Z"
                                                        fill="white" />
                                                    <path
                                                        d="M26.3682 2.10476C26.1315 1.9863 25.8575 1.96652 25.6062 2.04976L14.8362 5.65926C14.5738 5.74707 14.4324 6.03092 14.5202 6.29326C14.608 6.55559 14.8918 6.69707 15.1542 6.60926L25.9212 2.99976L27.0262 6.29426C27.0829 6.46396 27.2258 6.59051 27.4012 6.62624C27.5765 6.66198 27.7576 6.60146 27.8762 6.46749C27.9948 6.33353 28.0329 6.14646 27.9762 5.97676L26.8707 2.68426C26.7883 2.43116 26.6071 2.22214 26.3682 2.10476Z"
                                                        fill="white" />
                                                    <path
                                                        d="M14.846 23.391L4.07901 27L2.97401 23.7055C2.88633 23.4432 2.60259 23.3016 2.34026 23.3892C2.07792 23.4769 1.93633 23.7607 2.02401 24.023L3.12751 27.3145C3.20929 27.5671 3.38958 27.7761 3.62751 27.894C3.76594 27.9628 3.9184 27.9988 4.07301 27.999C4.18049 27.9991 4.28731 27.9823 4.38951 27.949L15.1595 24.3395C15.4219 24.2517 15.5633 23.9678 15.4755 23.7055C15.3877 23.4432 15.1039 23.3017 14.8415 23.3895L14.846 23.391Z"
                                                        fill="white" />
                                                    <path
                                                        d="M16.5 13.25C16.5 13.5261 16.7239 13.75 17 13.75C17.2761 13.75 17.5 13.5261 17.5 13.25C17.4517 12.1292 16.6108 11.2023 15.5 11.0455V11C15.5 10.7239 15.2761 10.5 15 10.5C14.7239 10.5 14.5 10.7239 14.5 11V11.0455C13.3892 11.2023 12.5483 12.1292 12.5 13.25C12.5483 14.3708 13.3892 15.2977 14.5 15.4545V17.923C13.9436 17.7968 13.5366 17.3194 13.5 16.75C13.5 16.4739 13.2761 16.25 13 16.25C12.7239 16.25 12.5 16.4739 12.5 16.75C12.5483 17.8708 13.3892 18.7977 14.5 18.9545V19C14.5 19.2761 14.7239 19.5 15 19.5C15.2761 19.5 15.5 19.2761 15.5 19V18.9545C16.6108 18.7977 17.4517 17.8708 17.5 16.75C17.4517 15.6292 16.6108 14.7023 15.5 14.5455V12.077C16.0564 12.2032 16.4634 12.6806 16.5 13.25ZM13.5 13.25C13.5366 12.6806 13.9436 12.2032 14.5 12.077V14.423C13.9436 14.2968 13.5366 13.8194 13.5 13.25ZM16.5 16.75C16.4634 17.3194 16.0564 17.7968 15.5 17.923V15.577C16.0564 15.7032 16.4634 16.1806 16.5 16.75Z"
                                                        fill="white" />
                                                    <path
                                                        d="M25.5 20.5H27.5C27.7761 20.5 28 20.2761 28 20V18C28 17.7239 27.7761 17.5 27.5 17.5C27.2239 17.5 27 17.7239 27 18V19.5H25.5C25.2239 19.5 25 19.7239 25 20C25 20.2761 25.2239 20.5 25.5 20.5Z"
                                                        fill="white" />
                                                    <path
                                                        d="M2.5 17.5C2.22386 17.5 2 17.7239 2 18V20C2 20.2761 2.22386 20.5 2.5 20.5H4.5C4.77614 20.5 5 20.2761 5 20C5 19.7239 4.77614 19.5 4.5 19.5H3V18C3 17.7239 2.77614 17.5 2.5 17.5Z"
                                                        fill="white" />
                                                    <path
                                                        d="M4.5 9.5H2.5C2.22386 9.5 2 9.72386 2 10V12C2 12.2761 2.22386 12.5 2.5 12.5C2.77614 12.5 3 12.2761 3 12V10.5H4.5C4.77614 10.5 5 10.2761 5 10C5 9.72386 4.77614 9.5 4.5 9.5Z"
                                                        fill="white" />
                                                    <path
                                                        d="M25.5 10.5H27V12C27 12.2761 27.2239 12.5 27.5 12.5C27.7761 12.5 28 12.2761 28 12V10C28 9.72386 27.7761 9.5 27.5 9.5H25.5C25.2239 9.5 25 9.72386 25 10C25 10.2761 25.2239 10.5 25.5 10.5Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_1689_18">
                                                        <rect width="30" height="30" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <div class="main-credit-title">اعتبار ریالی </div>
                                        </div>
                                        <div class="main-credit-money">
                                            <div class="credit-money-207"> {{ number_format($UserCashCredit) }} ریال
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main-credit-cards second">
                                        <div class="main-credit-content">
                                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_1363_1635)">
                                                    <path
                                                        d="M28.5697 17.5719H28.1208V13.528C28.1208 12.8879 27.8022 12.321 27.3155 11.9766V11.426C27.3155 10.6273 26.6658 9.97756 25.8671 9.97756H25.5319L26.8145 8.09553C27.2444 7.46471 27.0809 6.60168 26.4501 6.17172L17.7471 0.240864C17.4415 0.0325632 17.0732 -0.0443118 16.7097 0.024653C16.3463 0.0935007 16.0315 0.299692 15.8233 0.605317L8.31148 11.6281H6.22115L6.72547 6.52287C6.73115 6.46534 6.76853 6.41547 6.82068 6.39584C7.47043 6.15086 8.03352 5.69336 8.40617 5.10766C8.43553 5.06155 8.4909 5.03518 8.5482 5.04098L11.8268 5.36489C12.0619 5.38768 12.271 5.21647 12.2942 4.98151C12.3174 4.74655 12.1458 4.53731 11.9108 4.51411L8.63223 4.1902C8.25166 4.15293 7.88873 4.3283 7.68482 4.6487C7.41084 5.07936 6.99682 5.41569 6.5191 5.5958C6.15951 5.73139 5.9126 6.05436 5.87463 6.43879L5.36205 11.6281H4.81695L5.61453 3.55364C5.64324 3.26301 5.90264 3.0495 6.19361 3.07862L12.819 3.73311C13.054 3.75579 13.2632 3.58469 13.2864 3.34973C13.3096 3.11477 13.138 2.90553 12.9031 2.88233L6.27764 2.22784C5.51803 2.15289 4.83875 2.70983 4.76369 3.46955L4.1208 9.97756H3.02598C2.22734 9.97756 1.57754 10.6273 1.57754 11.426V11.8016C0.92416 12.1024 0.469238 12.7629 0.469238 13.528V28.1C0.469238 29.1477 1.32154 30 2.36926 30H26.2208C27.2685 30 28.1208 29.1477 28.1208 28.1V24.0562H28.5697C29.0997 24.0562 29.5307 23.6252 29.5307 23.0953V18.5329C29.5308 18.003 29.0997 17.5719 28.5697 17.5719ZM25.8671 10.8326C26.1944 10.8325 26.4606 11.0988 26.4606 11.4261V11.6439C26.382 11.6339 26.3021 11.6282 26.2208 11.6282H24.4071L24.9492 10.8326H25.8671ZM16.5297 1.08672C16.6094 0.969829 16.7298 0.890962 16.8688 0.864594C16.902 0.858325 16.9354 0.855161 16.9685 0.855161C17.0738 0.855161 17.1767 0.886684 17.2656 0.94727L25.9686 6.87813C26.2099 7.0426 26.2725 7.37272 26.108 7.61401L23.3725 11.628H22.7161L24.0572 9.66004C24.2747 9.34088 24.2926 8.93471 24.1038 8.59996C23.8529 8.15524 23.7512 7.63159 23.8174 7.12539C23.8667 6.74881 23.701 6.3812 23.385 6.16592L18.8734 3.09139C18.5574 2.87606 18.1546 2.85631 17.8222 3.03989C17.3754 3.28657 16.8508 3.38342 16.3452 3.31264C15.9702 3.26002 15.5898 3.42936 15.3755 3.74372L10.0026 11.6281H9.34607L16.5297 1.08672ZM16.718 8.34596C14.8564 8.34596 13.3283 9.7975 13.2038 11.6281H11.037L16.0819 4.22518C16.082 4.22518 16.082 4.22518 16.082 4.22518C16.1106 4.18305 16.1581 4.15797 16.2069 4.15797C16.2134 4.15797 16.2199 4.15844 16.2264 4.15932C16.9142 4.25553 17.6276 4.12393 18.2353 3.78836C18.2831 3.76188 18.3446 3.76569 18.3919 3.79791L22.9036 6.8725C22.9508 6.90473 22.9767 6.96051 22.9697 7.01465C22.8796 7.70307 23.018 8.41522 23.3592 9.02002C23.3866 9.0686 23.3833 9.13082 23.3508 9.17858L21.6816 11.628H20.2324C20.1078 9.7975 18.5797 8.34596 16.718 8.34596ZM19.3751 11.6281H14.0609C14.1834 10.2694 15.328 9.20096 16.718 9.20096C18.1081 9.2009 19.2527 10.2694 19.3751 11.6281ZM2.43248 11.426C2.43248 11.0987 2.69867 10.8324 3.02598 10.8324H4.03637L3.95779 11.6281H2.43248V11.426ZM1.32418 13.528C1.32418 12.9518 1.79299 12.483 2.36926 12.483H26.2208C26.7971 12.483 27.2659 12.9518 27.2659 13.528V14.7142H1.32418V13.528ZM27.2659 28.1C27.2659 28.6762 26.7971 29.145 26.2208 29.145H2.36926C1.79299 29.145 1.32418 28.6762 1.32418 28.1V26.9138H3.62938C3.86551 26.9138 4.05682 26.7225 4.05682 26.4864C4.05682 26.2503 3.86545 26.059 3.62938 26.059H1.32418V15.5692H27.2659V17.5719H23.2014H23.2014C21.9208 17.5719 20.8115 18.3184 20.285 19.3989C20.2832 19.4025 20.2812 19.4061 20.2794 19.4097C20.275 19.4189 20.2711 19.4284 20.2668 19.4377C20.2041 19.5709 20.1496 19.7088 20.1052 19.851C20.1051 19.8514 20.105 19.8518 20.1049 19.8522C20.0103 20.1562 19.9592 20.4793 19.9592 20.8141C19.9592 22.6018 21.4136 24.0562 23.2013 24.0562H23.2014H27.2658V26.059H6.36652C6.13039 26.059 5.93908 26.2503 5.93908 26.4864C5.93908 26.7225 6.13045 26.9138 6.36652 26.9138H27.2659V28.1ZM28.6759 23.0952C28.6759 23.1537 28.6283 23.2013 28.5697 23.2013H23.2015C22.2965 23.2013 21.5075 22.6951 21.1028 21.951C21.0844 21.9172 21.0668 21.8829 21.05 21.8481C21.0164 21.7786 20.9861 21.7072 20.9594 21.634C20.8655 21.3782 20.8143 21.102 20.8143 20.8141C20.8143 20.5261 20.8655 20.2499 20.9594 19.9941C20.9862 19.921 21.0165 19.8496 21.05 19.78C21.0668 19.7453 21.0844 19.7109 21.1028 19.6771C21.5075 18.933 22.2965 18.4268 23.2015 18.4268H28.5697C28.6282 18.4268 28.6759 18.4744 28.6759 18.5329V23.0952Z"
                                                        fill="white" />
                                                    <path
                                                        d="M23.3018 19.0801C22.3454 19.0801 21.5674 19.8581 21.5674 20.8144C21.5674 21.7708 22.3454 22.5488 23.3018 22.5488C24.2581 22.5488 25.0361 21.7708 25.0361 20.8144C25.0361 19.8581 24.2581 19.0801 23.3018 19.0801ZM23.3018 21.6938C22.8168 21.6938 22.4223 21.2993 22.4223 20.8144C22.4223 20.3296 22.8168 19.935 23.3018 19.935C23.7867 19.935 24.1812 20.3295 24.1812 20.8144C24.1812 21.2994 23.7867 21.6938 23.3018 21.6938Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_1363_1635">
                                                        <rect width="30" height="30" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <div class="main-credit-title">توان پرداخت</div>
                                            <button class="estelambtn">استعلام ۵۰۰۰۰ ریال</button>
                                        </div>
                                        <div class="main-credit-money">
                                            <div id="estelamresult" class="credit-money-207">---</div>
                                        </div>
                                    </div>

                                    <div class="main-credit-cards third">
                                        <div class="main-credit-content">
                                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_1363_1655)">
                                                    <path
                                                        d="M29.8481 12.2316C29.6495 11.7625 29.2802 11.3989 28.808 11.2076L28.2807 10.994V8.20782C28.2807 7.15624 27.4252 6.30077 26.3736 6.30077H16.6953L11.1446 4.05212C10.9191 3.96071 10.6625 4.06952 10.5712 4.29487C10.4798 4.52022 10.5885 4.77698 10.8139 4.86827L14.35 6.30077H5.14556L6.05769 4.04907C6.27021 3.52448 6.86992 3.27053 7.39445 3.48305L9.18191 4.20715C9.4075 4.29862 9.66408 4.18975 9.75531 3.9644C9.84666 3.73905 9.73791 3.48235 9.51255 3.391L7.72503 2.6669C6.75062 2.2721 5.63634 2.74378 5.24148 3.71837L4.19541 6.30071H3.6264C2.57488 6.30071 1.71941 7.15618 1.71941 8.20776V12.4129L0.140602 16.3103C-0.0507071 16.7824 -0.0466641 17.3008 0.151969 17.7699C0.350543 18.239 0.719918 18.6026 1.19207 18.7939L1.71947 19.0075V21.7937C1.71947 22.8453 2.57494 23.7008 3.62646 23.7008H5.50539C5.74855 23.7008 5.94566 23.5037 5.94566 23.2605C5.94566 23.0173 5.74855 22.8202 5.50539 22.8202H3.62646C3.0605 22.8202 2.60002 22.3598 2.60002 21.7938V13.9246H8.38615C7.36966 14.7277 6.01351 16.1168 5.4417 18.1184C5.37836 18.3402 5.50281 18.5794 5.7206 18.6552C5.95638 18.7372 6.22 18.6001 6.28849 18.3603C6.8824 16.2812 8.48798 14.9116 9.39296 14.2795V22.8202H7.2666C7.02343 22.8202 6.82632 23.0173 6.82632 23.2604C6.82632 23.5036 7.02343 23.7007 7.2666 23.7007H13.3048L17.6797 25.473C17.7339 25.495 17.7898 25.5053 17.8449 25.5053C18.0189 25.5053 18.1837 25.4015 18.2531 25.2302C18.3444 25.0049 18.2358 24.7481 18.0103 24.6568L15.6501 23.7007H24.8545L23.9424 25.9524C23.7299 26.477 23.1299 26.7309 22.6056 26.5184L19.6466 25.3197C19.4211 25.2284 19.1645 25.3371 19.0732 25.5625C18.9818 25.7878 19.0905 26.0446 19.3159 26.1359L22.275 27.3346C22.5088 27.4293 22.7506 27.4741 22.9886 27.4741C23.7427 27.4741 24.4585 27.0239 24.7586 26.2831L25.8047 23.7008H26.3737C27.4252 23.7008 28.2807 22.8453 28.2807 21.7937V17.5886L29.8595 13.6912C30.0507 13.219 30.0467 12.7007 29.8481 12.2316ZM1.52271 17.9777C1.26859 17.8748 1.06978 17.679 0.962848 17.4266C0.855973 17.1741 0.853805 16.8952 0.956754 16.641L1.71941 14.7584V18.0575L1.52271 17.9777ZM5.4755 11.407C5.40004 11.2295 5.34584 10.9458 5.74351 10.5333C5.92662 10.3433 6.15859 10.222 6.42642 10.2624C6.95881 10.3426 7.66164 10.958 8.40566 11.995C8.66412 12.3553 8.88918 12.7132 9.06285 13.0061C7.37546 12.8411 5.79742 12.1645 5.4755 11.407ZM9.39291 11.8668C8.69394 10.817 7.64511 9.55589 6.55814 9.39171C6.02277 9.31085 5.52191 9.4943 5.10953 9.9221C4.79277 10.2506 4.31388 10.9252 4.66504 11.7514C4.88336 12.2651 5.37648 12.7007 6.01785 13.0439H2.60002V8.20776C2.60002 7.64174 3.0605 7.18131 3.62646 7.18131H9.39296V11.8668H9.39291ZM27.4001 21.7937C27.4001 22.3597 26.9396 22.8202 26.3736 22.8202H10.2735V14.2795C11.1785 14.9116 12.7841 16.2812 13.378 18.3603C13.4466 18.6005 13.7099 18.7365 13.9459 18.6552C14.1638 18.5801 14.288 18.3398 14.2248 18.1184C13.653 16.1168 12.2968 14.7277 11.2803 13.9246H27.4001V21.7937ZM10.6034 13.006C10.7754 12.716 10.9981 12.3619 11.2544 12.0039C12.0007 10.9615 12.7058 10.3431 13.2398 10.2625C13.5077 10.2219 13.7398 10.3434 13.923 10.5333C14.3206 10.946 14.2664 11.2296 14.1909 11.407C13.869 12.1645 12.2908 12.8411 10.6034 13.006ZM27.4001 13.044H13.6486C14.2899 12.7007 14.7831 12.2651 15.0014 11.7515C15.3525 10.9253 14.8736 10.2507 14.5569 9.92215C14.1444 9.49424 13.6431 9.31096 13.1082 9.39176C12.0213 9.55594 10.9724 10.8171 10.2735 11.8669V7.18143H26.3736C26.9395 7.18143 27.4 7.64186 27.4 8.20788V13.044H27.4001ZM29.0433 13.3606L28.2807 15.2432V11.9441L28.4774 12.0238C28.7315 12.1267 28.9303 12.3225 29.0372 12.575C29.1441 12.8274 29.1463 13.1064 29.0433 13.3606Z"
                                                        fill="white" />
                                                    <path
                                                        d="M22.5095 20.6211V21.0435C22.5095 21.2866 22.7066 21.4837 22.9498 21.4837C23.193 21.4837 23.3901 21.2866 23.3901 21.0435V20.6332C23.722 20.5628 23.9494 20.412 24.095 20.2748C24.3824 20.0044 24.5539 19.5963 24.5539 19.1831C24.5539 18.8446 24.4485 18.5383 24.2491 18.2971C23.9817 17.9737 23.5619 17.7784 23.0012 17.7165C22.4785 17.6589 22.4005 17.3895 22.4005 17.2341C22.4005 17.1424 22.427 16.6847 22.9498 16.6847C23.2864 16.6847 23.4321 16.8855 23.4681 16.9454C23.5341 17.1059 23.6918 17.2189 23.8761 17.2189C24.2078 17.2189 24.3992 16.8738 24.2722 16.5832C24.1674 16.3554 23.8788 16.0046 23.39 15.8651V15.4344C23.39 15.1913 23.1929 14.9941 22.9498 14.9941C22.7066 14.9941 22.5095 15.1913 22.5095 15.4344V15.8639C22.2097 15.95 21.9597 16.1274 21.7842 16.3839C21.5389 16.7423 21.5199 17.1253 21.5199 17.2341C21.5199 17.79 21.8826 18.4791 22.9046 18.5919C23.6733 18.6767 23.6733 19.0446 23.6733 19.1831C23.6733 19.3182 23.6256 19.5075 23.4915 19.6336C23.364 19.7536 23.1663 19.8065 22.9041 19.7904C22.3485 19.7565 22.2225 19.4104 22.21 19.3711L22.2098 19.3712C22.1621 19.179 21.989 19.0364 21.7821 19.0364C21.4793 19.0364 21.2633 19.3474 21.369 19.6314C21.414 19.7724 21.6663 20.4296 22.5095 20.6211Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_1363_1655">
                                                        <rect width="30" height="30" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>


                                            <div class="main-credit-title">اعتبار همکاری </div>
                                        </div>
                                        <div class="main-credit-money">
                                            <div class="credit-money-207"> ریال 0</div>
                                        </div>
                                    </div>
                                    <div class="main-credit-cards four">
                                        <div class="main-credit-content">
                                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_1363_1673)">
                                                    <path
                                                        d="M26.798 16.835V7.88173C26.798 5.70559 25.026 3.93359 22.8498 3.93359H3.94854C1.7724 3.93359 0.000402877 5.70559 0.000402877 7.88173V18.9489C-0.0306848 21.1251 1.74131 22.8971 3.94854 22.8971H20.767C21.4198 24.7313 23.1918 26.068 25.2436 26.068C27.855 26.068 30 23.923 30 21.3116C30 19.2287 28.6632 17.4567 26.798 16.835ZM0.995209 7.88173C0.995209 6.26517 2.30089 4.9284 3.94854 4.9284H22.8498C24.4664 4.9284 25.8032 6.26517 25.8032 7.88173V8.16152H0.995209V7.88173ZM0.995209 9.15632H25.7721V11.4257H0.995209V9.15632ZM20.5183 21.9023H3.94854C2.33198 21.9023 0.995209 20.5655 0.995209 18.9489V12.4516H25.7721V16.5863C25.5856 16.5552 25.4301 16.5552 25.2436 16.5552C22.6322 16.5552 20.4872 18.7002 20.4872 21.3116C20.4872 21.4981 20.5183 21.7157 20.5183 21.9023ZM25.2125 25.0732C23.4716 25.0732 22.0416 23.8919 21.6063 22.3064C21.5131 21.9955 21.482 21.6536 21.482 21.3116C21.482 19.2287 23.1607 17.55 25.2436 17.55C27.2954 17.5811 28.9741 19.2598 28.9741 21.3116C28.9741 23.3945 27.2954 25.0732 25.2125 25.0732Z"
                                                        fill="white" />
                                                    <path
                                                        d="M7.86515 14.9062H3.10873C2.82894 14.9062 2.61133 15.1239 2.61133 15.4036C2.61133 15.6834 2.82894 15.901 3.10873 15.901H7.86515C8.14494 15.901 8.36255 15.6834 8.36255 15.4036C8.36255 15.1239 8.14494 14.9062 7.86515 14.9062Z"
                                                        fill="white" />
                                                    <path
                                                        d="M12.6846 14.9062H10.0111C9.73129 14.9062 9.51367 15.1239 9.51367 15.4036C9.51367 15.6834 9.73129 15.901 10.0111 15.901H12.6846C12.9644 15.901 13.182 15.6834 13.182 15.4036C13.182 15.1239 12.9644 14.9062 12.6846 14.9062Z"
                                                        fill="white" />
                                                    <path
                                                        d="M27.8551 19.7556C27.6996 19.538 27.3887 19.4758 27.14 19.6313L24.1867 21.7763L23.4717 20.595C23.3163 20.3463 23.0054 20.2841 22.7878 20.4085C22.5391 20.5639 22.4769 20.8437 22.6012 21.0924L23.596 22.8022C23.6582 22.9266 23.7826 23.0198 23.938 23.0509C23.9691 23.0509 24.0002 23.0509 24.0313 23.0509C24.1245 23.0509 24.2489 23.0198 24.3421 22.9576L27.7307 20.4706C27.9483 20.3152 28.0105 20.0043 27.8551 19.7556Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_1363_1673">
                                                        <rect width="30" height="30" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                            <div class="main-credit-title">اعتبار فروشندگان </div>
                                        </div>
                                        <div class="main-credit-money">
                                            <div class="credit-money-207"> ریال 0</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>


                </div>
                @if ($count > 0)
                    <div class="card wpa_cards order_summery_191">
                        <div class="order_summery_191" class="col-sm-12">
                            <input class="nested" name="TotalPrice" id='TotalPrice' value="{{ $TotalPrice }}">
                            <input class="nested" name="TotalWight" id='Totalweight' value="{{ $TotalWight }}">
                            <input id="TotalDeleveryPriceFinalInput" name="TotalDeleveryPriceFinalInput"
                                class="nested">
                            <div class="row">
                                <p class="order_summery_191">قیمت کل کالاها
                                </p>
                                <p style="color: var(--kookbaz_green);font-size: 15px;font-weight: 700;">
                                    ({{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() }})</p>
                                <strong style="display: flex" class="order_summery_191 value">
                                    <div id="kool_price">
                                        {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    </div>
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </strong>

                            </div>
                      
                          
                            <hr class="order_summery_191">
                            <div class="row topay">
                                <p class="order_summery_191" id="TotalTopay">مجموع:
                                    {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                                @if ($DeleverCondition != null && $DeleverCondition != '#')
                                @endif

                            </div>
                            <div class="form-check">
                                <input onchange="ConditionChange()" class="form-check-input" type="checkbox"
                                    value="" id="conditioncheck" />
                                <label style="margin-right: 20px;" class="form-check-label" for="flexCheckDefault">من
                                    <a style="color: blue" data-toggle="modal" data-target="#notloginmodal"> شرایط و
                                        مقررات
                                        سایت </a>را خوانده و می پذیرم</label>
                            </div>
                            <div style="width: 100%;justify-content: center;display: flex;">
                                @if ($TotalPrice)
                                    <div style="display: flex;">
                                        <button type="submit" name="submit" value="submit"
                                            class="btn-kookbaz598">پرداخت
                                            درگاه بانکی
                                        </button>
                                    </div>

                                    @if ($UserCashCredit >= $TotalPrice)
                                        @if ($DeleverCondition != null && $DeleverCondition != '#')
                                            <button style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                                                type="submit" name="submit" value="PayFromCredit"
                                                class="btn btn-primary btn-block m-1 mb-3">پرداخت از
                                                کیف پول
                                            </button>
                                        @else
                                            <button style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                                                type="submit" name="submit" value="PayFromCredit" disabled
                                                class="btn btn-primary btn-block m-1 mb-3">پرداخت از کیف پول
                                            </button>
                                        @endif
                                    @endif
                                @else
                                    <button style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                                        type="submit" name="submit" value="SubmitOrder"
                                        class="btn btn-primary btn-block m-1 mb-3">ثبت سفارش</button>
                                @endif
                            </div>
                        </div>
                    </div>

                @endif
            </div>

    @endif

    </form>
@endsection
@section('page-js')
    <script>


        function add_new_location_select() {
            $('#AddLocation').prop("checked", true);
            $('.radiochecker').removeClass('active');
            $('.radiochecker').addClass('deactive');
            $('#Location').val(0);

            steper('ShowRegistedAddress')

        }

        function radio_click_adv($ClickID, $ClassName) {
            $('#radio_' + $ClickID).prop("checked", true);
            $($ClassName).removeClass('active');
            $($ClassName).addClass('deactive');
            $('#radio_point_' + $ClickID).addClass('active');
            $('#radio_point_' + $ClickID).removeClass('deactive');
        }

        function radio_click($ClickID) {
            radio_click_adv($ClickID, '.radiochecker');
            $('#Location').val($ClickID);
        }

        window.Province = 0;
        window.CurencyRate = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
        window.CurencyName = '<?php echo App\Http\Controllers\Credit\currency::GetCurrency(); ?>';

        function ConditionChange() {
            if ($('#conditioncheck').is(":checked")) {
                $('#payrole').removeClass('nested');
                $('.buyItems').prop('disabled', false);
            } else {
                $('.buyItems').prop('disabled', true);
                $('.payrole').addClass('nested');
            }
        }

        function steper($Status) {
            if ($Status == 'FinalizeOrder_Back') {
                $('#FinalizeOrder').addClass('nested');
                $('#ListOFProduct').removeClass('nested');
                $('.StepViewer').removeClass('active');
                $('.StepViewer').addClass('deactive');
                $('#step_2').removeClass('deactive');
                $('#step_2').addClass('active');
            }
            if ($Status == 'shipping_Back') {
                $('#shipping').addClass('nested');
                $('#ShowRegistedAddress').removeClass('nested');
                $('.StepViewer').removeClass('active');
                $('.StepViewer').addClass('deactive');
                $('.StepViewer').removeClass('active');
                $('.StepViewer').addClass('deactive');
                $('#step_2').removeClass('deactive');
                $('#step_2').addClass('active');
            }
            if ($Status == 'InputAddress_Back') {
                $('#InputAddress').addClass('nested');
                $('#ShowRegistedAddress').removeClass('nested');
                $('.StepViewer').removeClass('active');
                $('.StepViewer').addClass('deactive');
                $('.StepViewer').removeClass('active');
                $('#step_2').removeClass('deactive');
                $('#step_2').addClass('active');
            }
            if ($Status == 'ShowRegistedAddress_Back') {

                $('#FinalizeOrder').addClass('nested');
                $('#ListOFProduct').removeClass('nested');
                $('.StepViewer').removeClass('active');
                $('.StepViewer').addClass('deactive');
                $('#step_1').removeClass('deactive');
                $('#step_1').addClass('active');
            }
            if ($Status == 'ListOFProduct') {
                $('#ListOFProduct').addClass('nested');
                $('#FinalizeOrder').removeClass('nested');
                $('.StepViewer').removeClass('active');
                $('.StepViewer').addClass('deactive');
                $('#step_2').removeClass('deactive');
                $('#step_2').addClass('active');
            }
            if ($Status == 'ShowRegistedAddress') {
                var radioValue = $("input[name='Location']:checked").val();
                window.Province = $('#LocationProvince_' + radioValue).val();
                $('#ShowRegistedAddress').addClass('nested');
                if ($('#AddLocation').is(':checked')) {
                    $('#InputAddress').removeClass('nested');
                } else {
                    $('#shipping').removeClass('nested');
                    if (window.Province == 1) {
                        $('#tehrandelever').removeClass('nested');
                    } else {
                        $('#tehrandelever').addClass('nested');
                    }
                }
            }
            if ($Status == 'InputAddress') {
                if ($('#location_name').val() == '') {
                    alert('لطفا برای استفاده از این آدرس در سفارشات بعدی نام محل را وارد فرمایید!');
                } else if ($('#Province').val() == '0') {
                    alert('لطفا استان را مشخص فرمایید!');
                } else if ($('#Shahrestan').val() == '') {
                    alert('لطفا شهر را مشخص فرمایید!');
                } else if ($('#Street').val() == '') {
                    alert('لطفا خیابان را مشخص فرمایید!');
                } else if ($('#Pelak').val() == '') {
                    alert('لطفا پلاک را مشخص فرمایید!');
                } else {
                    window.Province = $('#Province').val();
                    $('#InputAddress').addClass('nested');
                    $('#shipping').removeClass('nested');
                    if (window.Province == 1) {
                        $('#tehrandelever').removeClass('nested');
                    } else {
                        $('#tehrandelever').addClass('nested');
                    }
                }
            }
            if ($Status == 'shipping') {
                $('#shipping').addClass('nested');
                $('#FinalizeOrder').removeClass('nested');
                $('.StepViewer').removeClass('active');
                $('.StepViewer').addClass('deactive');
                $('#step_3').removeClass('deactive');
                $('#step_3').addClass('active');

            }
        }

        function showaddress($LocationID) {
            $('#ChandeAddress_' + $LocationID).removeClass('nested');
            $('#hode_address_' + $LocationID).removeClass('nested');
        }

        function hideaddress($LocationID) {
            $('#ChandeAddress_' + $LocationID).addClass('nested');
            $('#hode_address_' + $LocationID).addClass('nested');
        }

        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    $("#Shahrestan").append(data);
                });
        }
    </script>
    <script>
        window.DeleverPyek = 0;

        function RemoveOrder(ProductId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'RemoveFromOrder',
                    ProductId: ProductId,
                },
                function(data, status) {
                    if (data > 0) {
                        document.getElementById("basketnumber").innerHTML = data;
                    } else {
                        $("#basketnumber").addClass("nested");
                        $("#ProductRow_HasProduct").addClass("nested");
                        $("#ProductRow_Empty").removeClass("nested");
                    }
                });
            $("body").attr("style", "padding-right: -15px;");
            $("#ProductRow_" + ProductId).addClass("nested");
            location.reload();
        }

        function incQty(ProductId) {
            //alert(ProductId);
            if (parseInt($('#ProductCount_' + ProductId).val()) < parseInt($('#ProductMax_' + ProductId).val())) {
                $('#ProductCount_' + ProductId).val(parseInt($('#ProductCount_' + ProductId).val()) + 1);
                $('#UpdateBasket').removeClass('nested');
                $('#contenubtn').addClass('nested');

            }

        }

        function decQty(ProductId) {
            if (parseInt($('#ProductCount_' + ProductId).val()) == 1) {} else {
                $('#ProductCount_' + ProductId).val(parseInt($('#ProductCount_' + ProductId).val()) - 1);
                $('#UpdateBasket').removeClass('nested');
                $('#contenubtn').addClass('nested');
            }

        }
    </script>
    <script>
        function PeykDelever() {
            $('#DeleverNote').html('هزینه ارسال به صورت پس کرایه و حداقل ۳۰ هزار تومان به بالا.');
            $('#TotalDeleveryPriceFinal').html(window.CurencyName);
            window.DeleverPyek = 0;
            $TotalTopay = $('#TotalPrice').val();
            $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
            $('#TotalTopay').html('مجموع: ' + $TotalTopay + window.CurencyName);
            $('#shippingbtn').removeClass('disabled');
            radio_click_adv('non', '.radiochecker1');
        }

        function AskAndDelever() {
            $('#DeleverNote').html(' با مراجعه حضوری به مرکز کوکباز  می‌توانید سفارش خود را دریافت کنید');
            $('#TotalDeleveryPriceFinal').html(' هماهنگ خواهد شد ');
            window.DeleverPyek = 0;
            $TotalTopay = $('#TotalPrice').val();
            $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
            $('#TotalTopay').html('مجموع: ' + $TotalTopay + window.CurencyName);
            $('#shippingbtn').removeClass('disabled');
            radio_click_adv('callend', '.radiochecker1');
        }

        function AutoDelever() {
            $LocationCode = $('input[name="Location"]:checked').val();
            if ($LocationCode != 0) { //Old Place
                $LocationProvince = $('#LocationProvince_' + $LocationCode).val();
                $LocationCity = $('#LocationCity_' + $LocationCode).val();
            } else { //New Place
                $LocationProvince = $('#Province').val();
                $LocationCity = $('#Shahrestan').val();
            }

            TotalPrice = $('#TotalPrice').val();
            Totalweight = $('#Totalweight').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetDeleverPrice',
                    rate_type: 'tapin',
                    price: TotalPrice,
                    weight: Totalweight,
                    pay_type: '1',
                    to_province: $LocationProvince,
                    from_province: '1',
                    to_city: $LocationCity,
                    from_city: '1',

                },

                function(data, status) {
                    window.DeleverPyek = data;
                    mod = data % 5000;
                    if (mod > 0) {
                        data = data - mod + 5000;
                    }
                    $Price = formatCurrency(data / window.CurencyRate);

                    $('#TotalDeleveryPriceFinalInput').val(data);
                    $('#DeleverNote').html(' مبلغ' + $Price + ' ' + window.CurencyName +
                        '  جهت ارسال به فاکتور اضافه خواهد شد ');
                    $('#TotalDeleveryPriceFinal').html($Price + ' ' + window.CurencyName);
                    $('#TotalDeleveryPriceFinal').removeClass('nested');
                    $TotalTopay = parseInt($('#TotalPrice').val()) + parseInt(data);
                    $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
                    $('#TotalTopay').html('مجموع: ' + $TotalTopay + ' ' + window.CurencyName);
                    $('#shippingbtn').removeClass('disabled');

                });
            radio_click_adv('shipping', '.radiochecker1');
        }
    </script>
    <script>
        function formatCurrency(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection
