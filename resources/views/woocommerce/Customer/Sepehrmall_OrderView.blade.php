@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
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
    <style>
        .OrderClose {
            outline: none !important;
        }

        .pwa_radio2 {
            margin-top: 2px;
            float: left;
            width: 34px;
            height: 17px;
            vertical-align: middle;
        }

        .lioneline1234 {
            margin-top: 9px;
        }

    </style>
    <input class="nested" id="confirmcode">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="pwa_h1_title">
                        <h2 class="pwa_h2_title"> سبد خرید</h2>
                    </h1>
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
                        <div style="text-align: justify" class="modal-body">
                            {!! $DeleverCondition !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($OrderDetials == null)
            <div class="alert alert-card alert-danger" role="alert">
                سبد خرید خالی است!
            </div>
        @else
            <div id="ProductRow_Empty" class="nested alert alert-card alert-danger" role="alert">
                سبد خرید خالی است!
            </div>
            <form method="post">
                @csrf
                <div id="ListOFProduct">
                    @php
                        $count = 0;
                        $TOPayTotall = 0;
                    @endphp
                    @foreach ($OrderDetials as $MyOrderTarget)
                        @php
                            $count++;
                        @endphp
                        <div id="ProductRow_HasProduct" class="card wpa_cards">
                            <div id="ProductRow_{{ $MyOrderTarget['Product']->id }}">
                                <button onclick="RemoveOrder({{ $MyOrderTarget['Product']->id }})" class="OrderClose"
                                    type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div style="margin-right: 14px;padding-left: 61px;margin-bottom: 15px;"
                                    class="row">
                                    <div class="col-sm-3">

                                        <img class="OrderImg"
                                            src="{{ App\Functions\Images::GetPicture($MyOrderTarget['Product']->ImgURL, 1) }}"
                                            alt="{{ $MyOrderTarget['Product']->NameFa }}">

                                    </div>
                                    <div style="padding-top: 16px;" class="col-sm-9">
                                        {{ $MyOrderTarget['Product']->NameFa }}
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    @if ($MyOrderTarget['ProductInWarehouse']->PricePlan == null)
                                        <strong>هر قلم :</strong>
                                        {{ number_format($MyOrderTarget['ProductInWarehouse']->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    @else
                                        @if (isset($MyOrderTarget['BaseUnit']['UnitName']))
                                            <strong>هر @if ($MyOrderTarget['BaseUnit']['UnitName'] == 'تک')
                                                    قلم @else{{ $MyOrderTarget['BaseUnit']['UnitName'] }}
                                                @endif : </strong>
                                            {{ number_format($MyProduct->GetTargetPriceFromPricePlanJson($MyOrderTarget['ProductInWarehouse']->PricePlan,$MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @else
                                            <strong>هر قلم : {{ $MyOrderTarget['BaseUnit']['UnitName'] }} </strong>
                                            {{ number_format($MyProduct->GetTargetPriceFromPricePlanJson($MyOrderTarget['ProductInWarehouse']->PricePlan,$MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @endif
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    @if (isset($MyOrderTarget['UnitPlan']['UnitName']))
                                        @if (str_contains($MyOrderTarget['UnitPlan']['UnitName'], 'ماه') || str_contains($MyOrderTarget['UnitPlan']['UnitName'], 'هفته') || str_contains($MyOrderTarget['UnitPlan']['UnitName'], 'روز'))
                                            <strong> مدت :</strong>
                                        @else
                                            <strong> تعداد :</strong>
                                        @endif
                                    @else
                                        <strong> تعداد :</strong>
                                    @endif
                                    @if ($MyOrderTarget['UnitPlan'] != null)
                                        @php
                                            $ProductQty = $MyOrderTarget['ProductQty'];
                                            $DefMod = $ProductQty % $MyOrderTarget['UnitPlan']['Multiple'];
                                        @endphp
                                        {{ ($ProductQty - $DefMod) / $MyOrderTarget['UnitPlan']['Multiple'] }}
                                        {{ $MyOrderTarget['UnitPlan']['UnitName'] }}
                                        @if($DefMod > 0)
                                        و  {{$DefMod}}  {{ $MyOrderTarget['BaseUnit']['UnitName'] }}
                                        @endif
                                    @else
                                        {{ $MyOrderTarget['ProductQty'] }}
                                    @endif
                                    <button style="left: 17px;margin-top:16px;" name="Edit"
                                        value="{{ $MyOrderTarget['Product']->id }}" class="OrderClose" type="submit">
                                        ویرایش سفارش
                                    </button>
                                </div>

                                <input id="ProductMax_{{ $MyOrderTarget['Product']->id }}" class="nested"
                                    value="                                           @if ($MyOrderTarget['ProductInWarehouse']->Remian > $MyOrderTarget['ProductInWarehouse']->SaleLimit) {{ $MyOrderTarget['ProductInWarehouse']->SaleLimit }} @else
                                {{ $MyOrderTarget['ProductInWarehouse']->Remian }} @endif " />

                            </div>
                            @php
                                if ($MyOrderTarget['ProductInWarehouse']->PricePlan == null) {
                                    $ItemTotall = $MyOrderTarget['ProductInWarehouse']->Price * $MyOrderTarget['ProductQty'];
                                    $BenefitTotall = $MyOrderTarget['ProductInWarehouse']->BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;
                                    $TOPayTotall += $ItemTotall;
                                } else {
                                    $ItemTotall = $MyProduct->GetTargetPriceFromPricePlanJson($MyOrderTarget['ProductInWarehouse']->PricePlan, $MyOrderTarget['ProductQty']) * $MyOrderTarget['ProductQty'];
                                    $BenefitTotall = $MyOrderTarget['ProductInWarehouse']->BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;
                                    $TOPayTotall += $ItemTotall;
                                }
                            @endphp
                            <div class="col-sm-12">
                                <strong> سود خرید این محصول:</strong>
                                {{ number_format($BenefitTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                            </div>
                            <div class="nested col-sm-12">
                                <strong>مبلغ کل: </strong>
                                {{ number_format($ItemTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                            </div>
                            <div style="height: 10px"></div>
                        </div>
                    @endforeach
                    @if ($count > 0)
                        <div style="margin-top: 20px" class="card wpa_cards">
                            <div class="col-sm-12">
                                <strong>جمع کل
                                    :</strong>{{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                <br>
                                @php
                                    $GetUserBenefit = \App\Http\Controllers\woocommerce\buy::BuyBenefit();
                                @endphp
                                <strong>سود خرید
                                    :</strong>{{ number_format($GetUserBenefit / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                            </div>
                        </div>
                    @endif
                    <br>
                    <div class="col-sm-12">
                        @if (Auth::Check())
                            <button onclick="steper('ListOFProduct')" type="button" id="contenubtn"
                                class="btn btn-primary btn-block m-1 mb-3">ادامه</button>
                            <button type="submit" id="UpdateBasket" name="submit" value="updatebasket"
                                class=" nested btn btn-primary btn-block m-1 mb-3">بروز رسانی سبد خرید</button>
                        @else
                            <a type="button" href="{{ route('login') }}" style="color: white"
                                class="btn btn-primary btn-block m-1 mb-3">ورود و ادامه</a>
                        @endif

                    </div>
                    <div class="col-sm-12">
                        <button type="submit" name="submit" value="deleteorder"
                            class="btn btn-danger btn-block m-1 mb-3">حذف
                            سفارش</button>
                    </div>
                </div>

    </div>
    <div class="nested" style="width: 90%;margin-right: 5%;" id="ShowRegistedAddress">
        <div class="card wpa_cards">

            <div class="card-title">انتخاب محل تحویل</div>
            <span onclick="steper('ShowRegistedAddress_Back')"
                style="left: 10px;text-align: left;position: absolute;font-size: 22px;" aria-hidden="true"><i
                    class="i-Arrow-Out-Right"></i></span>
            <hr>
            @php
                $Loccounter = 1;
            @endphp
            @foreach ($UserLocations as $UserLocation)
                @php
                    $Loccounter++;
                @endphp

                <div class="card-content card-content-padding pwa_option_box">
                    <li>{{ $UserLocation->name }} </li>
                    <small> {{ $UserLocation->City }} - {{ $UserLocation->Street }}
                        {{ $UserLocation->OthersAddress }} پلاک: {{ $UserLocation->Pelak }} </small>
                    <input type="radio" class="pwa_radio select_Location" checked name="Location"
                        value="{{ $UserLocation->id }}">
                    <input class="nested" type="text" id="LocationCity_{{ $UserLocation->id }}"
                        value="{{ $UserLocation->CityID }}">
                    <input class="nested" type="text" id="LocationProvince_{{ $UserLocation->id }}"
                        value="{{ $UserLocation->ProvinceID }}">
                </div>
            @endforeach
            <div class="card-content card-content-padding pwa_option_box">
                <li>ثبت محل جدید</li>
                <small> افزودن آدرس جدید!!</small>
                @if ($Loccounter == 1)
                    <input id="AddLocation" type="radio" class="pwa_radio" checked name="Location" value="0">
                @else
                    <input id="AddLocation" type="radio" class="pwa_radio" name="Location" value="0">
                @endif
            </div>
            <hr>
            <div style="display: flex" class="col-lg-12">

                <div class="col-lg-6">
                    <a onclick="steper('ShowRegistedAddress_Back')" type="button"
                        style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                        class="btn btn-primary btn-block">مرحله قبل</a>
                </div>
                <div class="col-lg-6">
                    <a onclick="steper('ShowRegistedAddress')" type="button"
                        style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                        class="btn btn-primary btn-block">مرحله بعد</a>
                </div>


            </div>

        </div>
    </div>
    <div class="nested" style="width: 90%;margin-right: 5%;" id="InputAddress">
        <div class="card wpa_cards">
            <div class="card-title">تعیین آدرس سفارش</div>
            <span onclick="steper('InputAddress_Back')"
                style="left: 10px;text-align: left;position: absolute;font-size: 22px;" aria-hidden="true"><i
                    class="i-Arrow-Out-Right"></i></span>
            <hr>
            <div class="card-body">
                <div dir="rtl" style="text-align: center">
                    <div class="row">
                        <label> نام محل : (خانه ، شرکت و ....)</label>
                        <input id="location_name" type="text" name="LocationName" class="form-control">
                    </div>

                    <div class="row">
                        <label> استان :<span title="ضروری" style="color: red">*</span></label>
                        <select name="Province" id="Province" onchange="LoadCitys(this.value)" class="form-control">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($Provinces as $ProvincesTarget)
                                <option value="{{ $ProvincesTarget->id }}">
                                    {{ $ProvincesTarget->ProvinceName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <label> شهرستان :<span title="ضروری" style="color: red">*</span></label>
                        <select class="form-control" id="Shahrestan" name="Saharestan">
                        </select>
                    </div>
                    <div class="row">
                        <label>خیابان :<span title="ضروری" style="color: red">*</span></label>
                        <input type="text" id="Street" name="Street" class="form-control">
                    </div>
                    <div class="row">
                        <label> کوچه :</label>
                        <input type="text" name="OthersAddress" class="form-control">
                    </div>
                    <div class="row">
                        <label> پلاک : <span title="ضروری" style="color: red">*</span></label>
                        <input type="text" id="Pelak" name="Pelak" class="form-control">
                    </div>
                    <div class="row">
                        <label> کد پستی :</label>
                        <input type="number" name="PostalCode" class="form-control">
                    </div>
                    <div class="row">
                        <label> توضیحات :</label>
                        <input type="text" name="ExtraNote" class="form-control">
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
        <div class="card wpa_cards">
            <div class="card-title">روش ارسال</div>

            <span onclick="steper('shipping_Back')" style="left: 10px;text-align: left;position: absolute;font-size: 22px;"
                aria-hidden="true"><i class="i-Arrow-Out-Right"></i></span>
            <hr>
            <div class="card-body">
                @if ($FreeDeleverText != null && $FreeDeleverText != '#')
                    <p style="color: red">{{ $FreeDeleverText }}</p>
                @endif
                <div class="card-content card-content-padding pwa_option_box">
                    <li class="lioneline1234"> ارسال با پست پیشتاز
                        <input onclick="AutoDelever()" type="radio" class="pwa_radio2" name="shipping" value="post">
                    </li>

                </div>
                <div class="card-content card-content-padding pwa_option_box">
                    <li class="lioneline1234">ارسال با پیک
                        <input onclick="PeykDelever()" type="radio" class="pwa_radio2" name="shipping" value="non">

                    </li>
                </div>
                <div id="tehrandelever" class="nested card-content card-content-padding pwa_option_box">
                    <li class="lioneline1234">تحویل حضوری
                        <input onclick="AskAndDelever()" type="radio" class="pwa_radio2" name="shipping" value="non">

                    </li>
                </div>
                <br>
                <h6 id="DeleverNote"></h6>
            </div>
            <div style="display: flex" class="col-lg-12">
                <div class="col-lg-6">
                    <a onclick="steper('shipping_Back')" type="button"
                        style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;"
                        class="btn btn-primary btn-block">مرحله قبل</a>
                </div>
                <div class="col-lg-6">
                    <a onclick="steper('shipping')" type="button"
                        style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;" id="shippingbtn"
                        class="btn btn-primary  disabled ">مرحله بعد</a>
                </div>
            </div>
        </div>
    </div>
    <div class="nested" style="width: 90%;margin-right: 5%;" id="FinalizeOrder">
        <div class="card wpa_cards">
            <div class="card-title">نهایی سازی و پرداخت</div>
            <span onclick="steper('FinalizeOrder_Back')"
                style="left: 10px;text-align: left;position: absolute;font-size: 22px;" aria-hidden="true"><i
                    class="i-Arrow-Out-Right"></i></span>

            <hr>
            <div class="card-body">
                <input class="nested" name="TotalPrice" id='TotalPrice' value="{{ $TotalPrice }}">
                <input class="nested" name="TotalWight" id='Totalweight' value="{{ $TotalWight }}">
                <input class="nested" name="TotalDeleveryPriceFinalInput" id='TotalDeleveryPriceFinalInput'
                    value="">
                <p id="TotalPriceFinal">مبلغ کل:
                    {{ number_format($TotalPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                @if (App\Http\Controllers\Credit\currency::GetCurrency() == 0)
                    <p class="nested" id="TotalDeleveryPriceFinal">هزینه ارسال :
                        {{ number_format($TotalPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                @else
                    <p id="TotalDeleveryPriceFinal">هزینه ارسال :
                        {{ number_format($TotalPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                @endif
                <input class="nested" id="TotalPrice" value="{{ $TotalPrice }}">
                <p id="TotalTopay">مجموع:
                    {{ number_format($TotalPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                @if ($DeleverCondition != null && $DeleverCondition != '#')
                    <div class="form-check">
                        <input onchange="ConditionChange()" class="form-check-input" type="checkbox" value=""
                            id="conditioncheck" />
                        <label style="margin-right: 20px;" class="form-check-label" for="flexCheckDefault">من
                            <a style="color: blue" data-toggle="modal" data-target="#notloginmodal"> شرایط و مقررات
                                سایت </a>را خوانده و می پذیرم</label>
                    </div>
                @endif
            </div>
            <div style="display: flex;width: 94%;" class="col-lg-12">
                <div class="col-lg-6">
                    <a onclick="steper('FinalizeOrder_Back')" type="button"
                        style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;margin-top:3px;"
                        class="btn btn-primary btn-block">مرحله قبل</a>
                </div>
                @if ($DeleverCondition != null && $DeleverCondition != '#')
                    <div class="col-lg-6">
                        <button style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;" type="submit"
                            name="submit" value="submit" class="buyItems btn btn-primary btn-block m-1 mb-3 "
                            disabled>پرداخت از
                            درگاه
                        </button>
                    </div>
                @else
                    <button style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;" type="submit"
                        name="submit" value="submit" class="btn btn-primary btn-block m-1 mb-3  ">پرداخت از درگاه
                    </button>
                @endif
            </div>
            @if ($UserCashCredit >= $TotalPrice)
                @if ($DeleverCondition != null && $DeleverCondition != '#')
                    <button style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;" type="submit"
                        name="submit" value="PayFromCredit" disabled class="btn btn-primary btn-block m-1 mb-3">پرداخت از
                        کیف پول
                    </button>
                @else
                    <button style="color: white;margin-bottom: 10px;width: 90%;margin-right: 4%;" type="submit"
                        name="submit" value="PayFromCredit" class="btn btn-primary btn-block m-1 mb-3">پرداخت از کیف پول
                    </button>
                @endif
            @endif
        </div>
    </div>

    </form>
    @endif



    </div>


@endsection
@section('page-js')
    <script>
        window.Province = 0;
        window.CurencyRate = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
        window.CurencyName = '<?php echo App\Http\Controllers\Credit\currency::GetCurrency(); ?>';

        function ConditionChange() {
            if ($('#conditioncheck').is(":checked")) {
                $('.buyItems').prop('disabled', false);
            } else {
                $('.buyItems').prop('disabled', true);
            }
        }

        function steper($Status) {
            if ($Status == 'FinalizeOrder_Back') {
                $('#FinalizeOrder').addClass('nested');
                $('#ShowRegistedAddress').removeClass('nested');

            }
            if ($Status == 'shipping_Back') {
                $('#shipping').addClass('nested');
                $('#ShowRegistedAddress').removeClass('nested');

            }
            if ($Status == 'InputAddress_Back') {
                $('#InputAddress').addClass('nested');
                $('#ShowRegistedAddress').removeClass('nested');

            }
            if ($Status == 'ShowRegistedAddress_Back') {

                $('#ShowRegistedAddress').addClass('nested');
                $('#ListOFProduct').removeClass('nested');

            }
            if ($Status == 'ListOFProduct') {
                $('#ListOFProduct').addClass('nested');
                $('#ShowRegistedAddress').removeClass('nested');
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
            }

        }
    </script>
    <script>
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
            $('#DeleverNote').html('هزینه ارسال به صورت پس کرایه و حداقل ۳۰ هزار تومان به بالا');
            $('#TotalDeleveryPriceFinal').html(' هزینه ارسال : ' + "۰" + window.CurencyName);
            window.DeleverPyek = 0;
            $TotalTopay = $('#TotalPrice').val();
            $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
            $('#TotalTopay').html('مجموع: ' + $TotalTopay + window.CurencyName);
            $('#shippingbtn').removeClass('disabled');
        }

        function AskAndDelever() {
            $('#DeleverNote').html('بعد از آماده شدن سفارش جهت تحویل سفارش با شما تماس میگیریم');
            $('#TotalDeleveryPriceFinal').html(' هزینه ارسال' + ' هماهنگ خواهد شد ');
            window.DeleverPyek = 0;
            $TotalTopay = $('#TotalPrice').val();
            $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
            $('#TotalTopay').html('مجموع: ' + $TotalTopay + window.CurencyName);
            $('#shippingbtn').removeClass('disabled');
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
                    $('#TotalDeleveryPriceFinal').html('هزینه ارسال' + ': ' + $Price + ' ' + window.CurencyName);
                    $('#TotalDeleveryPriceFinal').removeClass('nested');
                    $TotalTopay = parseInt($('#TotalPrice').val()) + parseInt(window.DeleverPyek);
                    $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
                    $('#TotalTopay').html('مجموع: ' + $TotalTopay + ' ' + window.CurencyName);
                    $('#shippingbtn').removeClass('disabled');

                });

        }
    </script>
    <script>
        function formatCurrency(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection
