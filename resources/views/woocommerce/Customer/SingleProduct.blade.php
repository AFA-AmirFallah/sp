@php
$Persian = new App\Functions\persian();
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
@section('MainTitle')
    {{ $TargetGood->NameFa }}
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="{{ $TargetGood->NameFa }}" />
    <meta property="og:url" content="{{ \App\myappenv::SiteAddress }}/{{ Request::path() }}" />
    <meta property="og:site_name" content="{{ \App\myappenv::CenterName }}" />
    <meta property="og:image" content="{{ App\Functions\Images::GetPicture($TargetGood->ImgURL, 1) }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .add_btn {
            font-size: 15px;
            background-color: rgb(51, 102, 102);
            width: -webkit-fill-available;
            border-radius: 5px;
            color: white;
            border-width: 0px;
            height: -webkit-fill-available;
            outline: none !important;
        }

        .add_btn:hover {
            color: #fff;
        }

        .totall_benefit {
            font-size: 12px;
            border-radius: 5px;
            padding: 10px;
            color: #fff;
            display: initial;
            background-color: rgb(204, 0, 0);
            width: 150px;
            margin-bottom: 0px;
        }

        .totall_benefit_txt {
            font-size: 12px;
            border-radius: 5px;
            padding: 10px;
            color: #fff;
            display: initial;
            background-color: var(--sm_green);
            width: 104px;
        }

        .takhfif {
            margin-top: 6px;
            text-align: center;
            font-size: 23px;
            font-variant: contextual;
            text-decoration-line: line-through;
        }

        .requestNumber {
            border: none;
            height: 100%;
            background-color: transparent;
            color: #fff;
            -moz-text-align-last: center;
            text-align-last: center;
            margin: 0 40 px 0 12 px;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1 px;
        }

        .SelectStyle1106 {
            width: 128px;
            margin-right: -9px;
            margin-left: -17px;
            background-color: rgb(51, 102, 102);
            color: white;
            border-radius: 6px 0px 0px 6px;
            border-width: 0;
            direction: rtl;
            padding-right: 25px;
            text-align: center;
            height: 100%;
            appearance: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            outline: none;
        }

        .SelectStyle1106:hover {
            background-color: rgb(51, 102, 102);
            border-width: 0px;
        }

        option.SelectStyle1106 {
            color: white;
            background-color: rgb(51, 102, 102);
        }

        .CustomerServiceCardHeader {
            width: calc(100% + 28px);
            font-size: 15px !important;
            text-align: right;
            display: block;
            margin-top: 28px !important;
            margin-right: -32px !important;
        }

        h5.CustomerServiceCardHeader {
            width: calc(100% + 28px);
            font-size: 20px !important;
            text-align: center;
            display: block;
            margin-top: -5px !important;
            padding-right: 42px;
        }

        .pricesume {
            text-align: center;
            color: green;
            background: darkgrey;
            padding: 10px;
            width: fit-content;
            font-size: 17px;
            border-radius: 5px;
            border-color: chartreuse;
            border-width: 10px;
            display: initial;
        }

        .percentdiv {
            background-color: rgb(204, 0, 0);
            color: white;
            text-align: center;
            font-size: 12px;
            border-radius: 5px;
            padding: 10px;
            width: 80px;
            margin-right: 7px;
            height: 35px;
        }

        .sumdiv {
            background-color: var(--sm_green);
            color: white;
            text-align: center;
            font-size: 12px;
            border-radius: 5px;
            padding: 10px;
            width: 134px;
            margin-right: 7px;
            height: 35px;
        }

        .productName {
            font-size: 16px;
            padding-bottom: 12px;
        }



        .unitSelect {}

        .info-table {
            width: 100%;
            border-spacing: 7px;
            border-collapse: inherit;
        }

        .redrow {
            background: var(--sm_red);
            height: 35px;
            text-align: center;

        }

        td.redrow {
            border-radius: 5px;
            border-style: inherit;
            color: #fff;
            height: 15px;

        }

        .greenrow {
            background: var(--sm_green);
            height: 35px;
            text-align: center;

        }

        td.greenrow {
            border-radius: 5px;
            border-style: inherit;
            color: #fff;
            height: 15px;

        }

        .darkgreenrow {
            background: var(--sm_darkgreen);
            height: 35px;
            text-align: center;

        }

        td.darkgreenrow {
            border-radius: 5px;
            border-style: inherit;
            color: #fff;
            height: 15px;

        }

        .radio-green [type="radio"]:checked+label:after {
            border-color: #00C851;
            background-color: #00C851;
        }
    </style>

    <input class="nested" id="confirmcode">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div style="border-width: 0px" class="modal-content">
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <img style="width: 100%;" id='modal_product_img'
                                    src="{{ App\Functions\Images::GetPicture($TargetGood->ImgURL, 1) }}" alt="">
                            </div>
                            <h6 id="Modal_product_name" class="productName m-0">
                                {{ $TargetGood->NameFa }}
                            </h6>
                            @if ($UnitPlan != null)
                                @foreach ($UnitPlan as $UnitPlanTarget)
                                    <input
                                        onclick="changeUnitPlan({{ $UnitPlanTarget->multiple }} , '{{ $UnitPlanTarget->UnitName }}')"
                                        type="radio" class="from-group radio_sp "
                                        @if ($ProductTarget->Remian < $UnitPlanTarget->multiple) disabled @endif
                                        @if ($UnitPlanTarget->multiple == 1) checked @endif
                                        id="unitplan_{{ $UnitPlanTarget->multiple }}" name="UnitPlan"
                                        value="{{ $UnitPlanTarget->multiple }}">

                                    <label class="unitSelect" for="html">{{ $UnitPlanTarget->UnitName }}</label><br>
                                    <input type="text" id="unitimg_{{ $UnitPlanTarget->multiple }}" class="nested"
                                        value="{{ $UnitPlanTarget->img }}">
                                @endforeach
                            @endif
                            @if ($PricePlan != null)
                                <div class="takhfif">
                                    <del class="Modal_product_base_price takhfif text-secondary">
                                        {{ number_format($ProductTarget->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}</del>
                                </div>
                                <div style="display: block;width:100%;text-align:center;margin:0px;" class="row">
                                    <h6 style="display: inline;color:blue" id="totoall_base_div"></h6>
                                </div>
                            @else
                                @if ($ProductTarget->BasePrice != $ProductTarget->Price)
                                    <div style="margin-bottom: 10px;" class="takhfif">

                                        <del class="Modal_product_base_price takhfif text-secondary">
                                            {{ number_format($ProductTarget->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        </del>
                                    </div>
                                @endif
                            @endif
                            @if ($PricePlan == null)
                                <h5 id="Modal_product_price" class="CustomerServiceCardHeader ">
                                    {{ number_format($ProductTarget->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                </h5>
                                <input class="nested" id="PricePlan" value="no" type="text">
                            @else
                                <h5 id="Modal_product_price" class="CustomerServiceCardHeader ">

                                    {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    تا
                                    {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}

                                </h5>
                                <input class="nested" id="PricePlan" value="{{ $ProductTarget->PricePlan }}"
                                    type="text">
                            @endif
                            <table class="info-table">
                                <tr class="redrow">
                                    <td id="totall_benefit" class="redrow">
                                        سود شما :
                                        {{ number_format(($ProductTarget->BasePrice - $ProductTarget->Price) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}

                                    </td>
                                    <td id="percenttext" class="redrow">4% </td>
                                </tr>
                                <tr class="darkgreenrow">
                                    <td class="darkgreenrow"> <button class="add_btn " id="AddToBasketbtn"
                                            onclick="AddToBasket()" type="button" name="submit"
                                            value="{{ $ProductTarget->id }}">
                                            افزودن به سبد خرید </button>
                                    </td>
                                    <td class="darkgreenrow SelectAria">
                                        <div style="margin-right:-3px" dir="ltr" class="btn-group SelectAria">
                                            <label for="requestNumber"
                                                style="border-width:0px;height: 35px; background: rgb(51,102,102);border-radius: 4px;"
                                                class="btn btn-dark m-0 p-0 text-center SelectAria">
                                                <span class="arrow">
                                                    <i style="
                                                                                                                                                                                                                                                                    display: flow-root;
                                                                                                                                                                                                                                                                    position: absolute;
                                                                                                                                                                                                                                                                    right: 3px;
                                                                                                                                                                                                                                                                    font-size: 14px;
                                                                                                                                                                                                                                                                    font-weight: 800;
                                                                                                                                                                                                                                                                    top: 2px;
                                                                                                                                                                                                                                                                    color: white;
                                                                                                                                                                                                                                                                                                                            "
                                                        class="i-Arrow-Up SelectAria">
                                                    </i>
                                                    <i style="display: flow-root;
                                                                                                                                                                                                                                                                            position: absolute;
                                                                                                                                                                                                                                                                            right: 3px;
                                                                                                                                                                                                                                                                            font-size: 14px;
                                                                                                                                                                                                                                                                            font-weight: 800;
                                                                                                                                                                                                                                                                            top: 19px;
                                                                                                                                                                                                                                                                            color: white;
                                                                                                                                                                                                                                                                                                                                "
                                                        class="i-Arrow-Down SelectAria"></i>
                                                </span>
                                                @php
                                                    $UnitSet = false;
                                                @endphp
                                                @if ($UnitPlan != null)
                                                    @php
                                                        $UnitSet = false;
                                                    @endphp
                                                    @foreach ($UnitPlan as $UnitPlanTarget)
                                                        @php
                                                            if ($UnitPlanTarget->multiple == 1) {
                                                                $UnitSet = true;
                                                            }
                                                        @endphp
                                                        @if ($UnitPlanTarget->multiple != 1)
                                                            <select onchange="ChangeQty(this,false)"
                                                                class="select_qty SelectStyle1106  nested " name="Qty"
                                                                id="QtySelect_{{ $UnitPlanTarget->multiple }}">
                                                            @else
                                                                <select onchange="ChangeQty(this,false)"
                                                                    class="select_qty SelectStyle1106" name="Qty"
                                                                    id="QtySelect_{{ $UnitPlanTarget->multiple }}">
                                                        @endif

                                                        @for ($i = 1; $i * $UnitPlanTarget->multiple <= $ProductTarget->Remian; $i++)
                                                            <option class="SelectStyle1106"
                                                                value="{{ $i * $UnitPlanTarget->multiple }}">
                                                                {{ $i }} @if ($UnitPlanTarget->multiple == 1)
                                                                    عدد
                                                                @else
                                                                    @if (str_contains($UnitPlanTarget->UnitName, 'بسته'))
                                                                        بسته
                                                                    @else
                                                                        {{ $UnitPlanTarget->UnitName }}
                                                                    @endif
                                                                @endif
                                                            </option>
                                                        @endfor
                                                        </select>
                                                    @endforeach
                                                @endif
                                                @if (!$UnitSet)
                                                    <select onchange="ChangeQty(this,false)" name="Qty"
                                                        id="QtySelect_1"
                                                        class="select_qty SelectStyle1106  ng-pristine ng-valid ng-touched">
                                                        @for ($i = 1; $i <= $ProductTarget->Remian; $i++)
                                                            <option class="SelectStyle1106" value="{{ $i }}">
                                                                {{ $i }}
                                                                عدد
                                                            </option>
                                                        @endfor
                                                    </select>
                                                @endif
                                            </label>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table style="margin-top: -6px;padding-top: 0px;" class="info-table">
                                <tr class="greenrow">
                                    <td id="totall_benefit" class="greenrow">
                                        مجموع خرید
                                    </td>
                                    <td id="totoall_div" class="greenrow">
                                        {{ number_format($ProductTarget->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    </td>
                                </tr>
                            </table>
                            @if ($showTable)
                                <table style="margin-top: 30px;width: 100%;" id='index_table'
                                    class=" {{ \App\myappenv::MainTableClass }}" style="width: 100%">

                                    <tbody>
                                        @foreach ($Product->GetProductIndexes($TargetGood->id) as $ProductIndex)
                                            <tr>
                                                <td>{{ $ProductIndex->l2name }} </td>
                                                <td>{{ $ProductIndex->l3name }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <hr>
                            @endif

                            @if ($ProductTarget->Remian > 0)
                                <div id="addtobasketdiv" class="form-group row">
                                    <div id="PriceLoader" class="loader  loader-bubble loader-bubble-primary nested ">
                                    </div>
                                    <div style="width: 100%" id="PriceData">
                                        <input type="number" class="nested" id="TotalQty"
                                            value="{{ $ProductTarget->Remian }}">
                                        <input type="number" class="nested" id="pw_id"
                                            value="{{ $ProductTarget->wgid }}">
                                        <div style="margin-top: 30px;width: 100%;">

                                            <div style="text-align: center">

                                            </div>

                                            <br>



                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="addtobasketdiv" class="form-group row">
                                    <h6>
                                        اتمام موجودی
                                    </h6>

                                </div>
                            @endif
                            <div>
                                <div id="buyalert" style="text-align: center" class="alert alert-success nested "
                                    role="alert">
                                    <h4> {{ __('success alert') }}</h4>
                                    <p>محصول به سبد خرید اضافه شد</p>
                                </div>
                                <a href="{{ route('checkout') }}" id="Basketlink"
                                    style="
                                    display: block;
                                    text-align: center;
                                    height: 35px;
                                    margin-top: auto;
                                    padding-top: 5px;
                                "
                                    class="add_btn  nested">سبد خرید</a>

                            </div>

                            <div id="Attrebute">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'DiscText') !!}</div>
                            <hr>
                            <div id="Description">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'MainText') !!} </div>
                        </form>
                    </div>
                </div>
                <script>
                    $(".SelectAria").on('click', function(event) {
                        event.stopPropagation();
                        event.stopImmediatePropagation();
                        $('#QtySelect_1').click();
                    });

                    function SelectClick() {
                        $('#QtySelect_1').click();
                    }
                </script>
                <script>
                    window.CurencyRate = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
                    window.CurencyName = '<?php echo App\Http\Controllers\Credit\currency::GetCurrency(); ?>';
                    window.Price = <?php echo $ProductTarget->Price; ?>;
                    window.BasePrice = <?php echo $ProductTarget->BasePrice; ?>;
                    window.Benefit = window.BasePrice - window.Price;
                    window.Qty = 1;
                    window.UserBenefit = <?php echo $ProductTarget->BasePrice - $ProductTarget->Price; ?>;
                    window.multiple = 1;
                </script>
                <script>
                    function AddToBasket() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post('<?php echo e(route('ajax')); ?>', {

                                AjaxType: 'AddToBasket',
                                ProductId: $('#AddToBasketbtn').val(),
                                Benefit: window.UserBenefit,
                                pw_id: $('#pw_id').val(),
                                OrderQty: window.Qty,
                            },

                            function(data, status) {
                                if (data) {
                                    document.getElementById("basketnumber").innerHTML = data;
                                    $("#basketnumber").removeClass("nested");
                                    $CurentUserBenefit = parseInt($('#UserBenefitValue').val());
                                    $CurentUserBenefit += window.UserBenefit;
                                    $('#UserBenefitValue').val($CurentUserBenefit);
                                    $("#UserBenefitText").text(number_format($CurentUserBenefit / window.CurencyRate) + window
                                        .CurencyName);
                                    $('#modal').modal('toggle');
                                    ProductId = $('#AddToBasketbtn').val();
                                    $('#ProductBox_' + ProductId).addClass('BuyedProduct');
                                    $('#buyalert').removeClass('nested');
                                    $("#AddToBasketbtn").addClass("nested");
                                    $('#Basketlink').removeClass('nested');
                                    $('#addtobasketdiv').addClass('nested');
                                    $('.info-table').addClass('nested');
                                }
                            });
                    }
                </script>
                <script>
                    function formolachangeQty($Qty) {
                        window.Qty = $TargetQty;
                        $TotalQty = parseInt($('#TotalQty').val());
                        $('#PriceData').addClass('nested');
                        $('#PriceLoader').removeClass('nested');
                        if ($('#PricePlan').val() == 'no') {

                            $Totall = window.Price * $TargetQty;
                            $Benefit = window.Benefit * $TargetQty;
                            $("#totoall_div").text(number_format($Totall / window.CurencyRate) + window.CurencyName);
                            window.UserBenefit = $Benefit;
                            $("#totall_benefit").text('سود شما : ' + number_format($Benefit / window.CurencyRate) + window.CurencyName);
                            $Percent = Math.round(((window.BasePrice - window.Price) * 100) / window.BasePrice);
                            $('#percenttext').html($Percent + '%');

                            $('#PriceData').removeClass('nested');
                            $('#PriceLoader').addClass('nested');
                        } else {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.post('<?php echo e(route('ajax')); ?>', {
                                    AjaxType: 'GetInformolaPrice',
                                    JsonPlan: $('#PricePlan').val(),
                                    Qty: $TargetQty,
                                },
                                function(data, status) {
                                    $basePrice = data;
                                    $TargetBase = $basePrice;
                                    $Totall = data * $TargetQty;
                                    $Benefit = window.BasePrice * $TargetQty - $Totall;
                                    $("#totoall_div").text(number_format($Totall / window.CurencyRate) + window
                                        .CurencyName);
                                    window.UserBenefit = $Benefit;
                                    $("#totall_benefit").text('سود شما : ' + number_format($Benefit / window.CurencyRate) + ' ' +
                                        window
                                        .CurencyName);
                                    $Percent = Math.round(((window.BasePrice - $TargetBase) * 100) / window.BasePrice);
                                    $('#percenttext').html($Percent + '%');
                                    $basePrice = number_format($TargetBase / window.CurencyRate) + window.CurencyName;
                                    $("#totoall_base_div").html($basePrice / window.CurencyRate);
                                    $('#PriceData').removeClass('nested');
                                    $('#PriceLoader').addClass('nested');
                                });
                        }
                    }

                    function BasicChangeQty($Qty) {
                        $('#totoall_base_div').addClass('nested');
                        $('#PricePlan').val('no');
                        $("#Modal_product_name").text('نام محصول : ' + ProductName);
                        $("#Modal_product_price").text('مبلغ : ' + number_format(Price / window.CurencyRate) + window.CurencyName);
                        $("#totoall_div").text(number_format(Price / window.CurencyRate) + window.CurencyName);
                        if (Price != BasePrice) {
                            $("#Modal_product_base_price").text('مبلغ : ' + number_format(BasePrice / window.CurencyRate) + window
                                .CurencyName);
                            window.UserBenefit = BasePrice - Price;
                            $("#totall_benefit").text('سود شما از خرید : ' + number_format((BasePrice - Price) / window.CurencyRate) +
                                window.CurencyName);
                        } else {
                            $("#Modal_product_base_price").addClass('nested');
                            $("#totall_benefit").addClass('nested');
                        }
                        $("#modal_product_img").attr("src", Image);;
                        $('#index_table').addClass('nested');
                        $('#index_table_loader').removeClass('nested');
                        $('#AddToBasketbtn').val(GoodID);
                        $('#Qty').val(1);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post('<?php echo e(route('ajax')); ?>', {
                                AjaxType: 'GetProductInfo',
                                ProductWarehouseID: ProductWarehouseID,
                                GoodID: GoodID,
                            },
                            function(data, status) {
                                $JsonIndex = data[0];
                                $TotalQty = data[1];
                                if ($TotalQty > 0) {
                                    $('#TotalQty').val($TotalQty * 1);
                                    $('.buyform').removeClass('nested');
                                    $('#finishproduct').addClass('nested');
                                } else {
                                    $('.buyform').addClass('nested');
                                    $('#finishproduct').removeClass('nested');
                                }
                                if ($JsonIndex != '') {
                                    myArr = JSON.parse($JsonIndex);
                                    $("#index_table > tbody").html("");
                                    $.each(myArr, function() {
                                        $("#index_table").find('tbody')
                                            .append($('<tr>')
                                                .append($('<td>')
                                                    .append($('<p>')
                                                        .text($(this)[0].l2name)
                                                    )
                                                )
                                                .append($('<td>')
                                                    .append($('<p>')
                                                        .text($(this)[0].l3name)
                                                    )
                                                )
                                            );
                                    });

                                }
                                $('#index_table_loader').addClass('nested');
                                $('#index_table').removeClass('nested');
                            });
                        $("body").attr("style", "padding-right: -15px;");

                    }

                    function ChangeQty($Qty, $isvalue) {
                        if ($isvalue) {
                            $TargetQty = parseInt($Qty);
                        } else {

                            $TargetQty = $Qty.value
                        }
                        formolachangeQty($TargetQty);
                    }
                </script>

                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
                <div class="row">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('bottom-js')
    <script>
        function changeUnitPlan($multiple, $UnitName) {
            $ImgSrc = $('#unitimg_' + $multiple).val();
            if ($ImgSrc != '') {
                $('#modal_product_img').attr("src", $ImgSrc);
            }
            window.multiple = $multiple;
            $('.select_qty').addClass('nested');
            $('#QtySelect_' + $multiple).removeClass('nested');
            ChangeQty($multiple, true);
            //ChangeQty($multiple, true);
            $("#QtySelect_" + $multiple).val($multiple);
        }
    </script>
    <script>
        $(document).ready(function() {
            ChangeQty(1, true);
            // ChangeQty(1, true);
        });
    </script>
@endsection
