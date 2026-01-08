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
    <input class="nested" id="confirmcode">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="pwa_h1_title">
                        <h2 class="pwa_h2_title"> <a href="{{ route('mainpage') }}">صفحه اصلی</a> >
                        </h2>
                    </h1>
                </div>
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{ \App\myappenv::FavIcon }}" style="width: 25px">
                        {{ \App\myappenv::CenterName }}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <img id='modal_product_img'
                                    src="{{ App\Functions\Images::GetPicture($TargetGood->ImgURL, 1) }}" alt="">
                            </div>
                            <h6 id="Modal_product_name" class="CustomerServiceCardHeader m-0">{{ $TargetGood->NameFa }}
                            </h6>
                            @if ($PricePlan == null)
                                <h5 id="Modal_product_price" style="padding-top: 30px;"
                                    class="CustomerServiceCardHeader m-0">
                                    قیمت: {{ number_format($ProductTarget->Price) }} ریال
                                </h5>
                                <input class="nested" id="PricePlan" value="no" type="text">
                            @else
                                قیمت :
                                {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($PricePlan)) }}
                                تا
                                {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($PricePlan)) }}
                                ریال
                                <input class="nested" id="PricePlan" value="{{ $ProductTarget->PricePlan }}"
                                    type="text">
                            @endif
                            <del id="Modal_product_base_price" class="text-secondary">قیمت:
                                {{ number_format($ProductTarget->BasePrice) }} ریال</del>
                            <div id="Attrebute">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'DiscText') !!}</div>
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
                            @if ($UnitPlan != null)
                                @foreach ($UnitPlan as $UnitPlanTarget)
                                    <input
                                        onclick="changeUnitPlan({{ $UnitPlanTarget->multiple }} , '{{ $UnitPlanTarget->UnitName }}')"
                                        type="radio" class="from-group " @if ($ProductTarget->Remian < $UnitPlanTarget->multiple)
                                    disabled
                                @endif
                                id="unitplan_{{ $UnitPlanTarget->multiple }}"
                                name="UnitPlan" value="{{ $UnitPlanTarget->multiple }}">
                                <label for="html">{{ $UnitPlanTarget->UnitName }}</label><br>
                                <input type="text" id="unitimg_{{ $UnitPlanTarget->multiple }}" class="nested"
                                    value="{{ $UnitPlanTarget->img }}">

                            @endforeach
                            @endif
                            @if ($ProductTarget->Remian > 0)
                                <div id="addtobasketdiv" class="form-group row">

                                    <div style="margin-top:10px;text-align:center" class="col-sm-12"
                                        style="text-align: center">
                                        <h5 style="display: contents" class="CustomerServiceCardHeader m-0">
                                            تعداد:
                                        </h5>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button onclick="decQty()" type="button"
                                                style="border-radius: 0px 10px 10px 0px;width: 80px;padding: 0px; color: red !important;padding-top: 3px;font-size:22px;"
                                                class="btn btn-secondary">-</button>
                                            <input type="button" id="Qty" value="1" class="btn btn-secondary" />
                                            <button onclick="incQty()" type="button"
                                                style="border-radius: 10px 0px 0px 10px;width: 70px;padding: 0px; color: green !important;padding-top: 3px;font-size:17px;"
                                                class="btn btn-secondary">+</button>
                                        </div>
                                        <h5 id="UnitShow" style="display: contents"
                                            class="nested CustomerServiceCardHeader m-0">

                                        </h5>
                                    </div>
                                    <input type="number" class="nested" id="TotalQty"
                                        value="{{ $ProductTarget->Remian }}">
                                    <div style="margin-top: 10px">
                                        @if ($PricePlan != null)
                                            <h6 id="totoall_base_div">مبلغ پایه </h6>
                                        @endif
                                        <h6 id="totoall_div">مجموع : {{ number_format($ProductTarget->Price) }} ریال
                                        </h6>
                                        <br>
                                        <h6 id="totall_benefit">سود شما از خرید :
                                            {{ number_format($ProductTarget->BasePrice - $ProductTarget->Price) }} ریال
                                        </h6>

                                    </div>

                                    <button id="AddToBasketbtn" onclick="AddToBasket()" type="button"
                                        class="btn btn-block btn-primary m-1" name="submit"
                                        value="{{ $ProductTarget->id }}">افرودن به
                                        سبد خرید
                                    </button>
                                </div>
                            @else
                                <div id="addtobasketdiv" class="form-group row">
                                    <h6>
                                        اتمام موجودی!
                                    </h6>

                                </div>
                            @endif

                            <div id="buyalert" class="alert alert-success nested" role="alert">
                                <h4> {{ __('success alert') }}</h4>
                                <li>محصول به سبد خرید اضافه شد!</li>
                            </div>
                            <a href="{{ route('checkout') }}" id="Basketlink" style="color: white"
                                class="btn btn-block btn-primary m-1 nested">سبد خرید</a>

                            <hr>
                            <div id="Description">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'MainText') !!} </div>
                        </form>
                    </div>
                </div>

                <script>
                    function incQty() {
                        $TotalQty = parseInt($('#TotalQty').val());
                        $CurentQty = parseInt($('#Qty').val());
                        $TargetQty = $CurentQty + 1
                        if (($TargetQty * window.multiple) < $TotalQty) {
                            $('#Qty').val($TargetQty);
                            if ($('#PricePlan').val() == 'no') {
                                $Totall = window.Price * window.multiple * $TargetQty;
                                $Benefit = window.Benefit * window.multiple * $TargetQty;
                                $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                                $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');
                            } else {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.post('<?php echo e(route('ajax')); ?>', {
                                        AjaxType: 'GetInformolaPrice',
                                        JsonPlan: $('#PricePlan').val(),
                                        Qty: $TargetQty * window.multiple,
                                    },
                                    function(data, status) {
                                        $basePrice = data;
                                        $TargetBase = $basePrice;
                                        $Totall = data * window.multiple * $TargetQty;
                                        $Benefit = window.BasePrice * window.multiple * $TargetQty - $Totall;
                                        $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                                        $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');

                                    });
                                $.post('<?php echo e(route('ajax')); ?>', {
                                        AjaxType: 'GetBaseInformolaPrice',
                                        JsonPlan: $('#PricePlan').val(),
                                        Qty: $TargetQty * window.multiple,
                                    },
                                    function(data, status) {
                                        $basePrice = "مبلغ پایه: " + '<del id="Modal_product_base_price" class="text-secondary"> ' +
                                            number_format(window.BasePrice) + ' ریال</del>';
                                        $basePrice += data;
                                        $basePrice += number_format($TargetBase) + ' ریال';
                                        $("#totoall_base_div").html($basePrice);

                                    });


                            }
                        }
                    }

                    function decQty() {
                        if (parseInt($('#Qty').val()) == 1) {} else {
                            $('#Qty').val(parseInt($('#Qty').val()) - 1);
                            if ($('#PricePlan').val() == 'no') {
                                $Totall = window.Price * parseInt($('#Qty').val());
                                $Benefit = window.Benefit * parseInt($('#Qty').val());
                                $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                                $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');
                            } else {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.post('<?php echo e(route('ajax')); ?>', {
                                        AjaxType: 'GetInformolaPrice',
                                        JsonPlan: $('#PricePlan').val(),
                                        Qty: parseInt($('#Qty').val()),
                                    },
                                    function(data, status) {
                                        $basePrice = data;
                                        $TargetBase = $basePrice;
                                        $Totall = data * parseInt($('#Qty').val());
                                        $Benefit = window.BasePrice * parseInt($('#Qty').val()) - $Totall;
                                        $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                                        $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');

                                    });
                                $.post('<?php echo e(route('ajax')); ?>', {
                                        AjaxType: 'GetBaseInformolaPrice',
                                        JsonPlan: $('#PricePlan').val(),
                                        Qty: parseInt($('#Qty').val()),
                                    },
                                    function(data, status) {
                                        $basePrice = "مبلغ پایه: " + '<del id="Modal_product_base_price" class="text-secondary"> ' +
                                            number_format(window.BasePrice) + ' ریال</del>';
                                        $basePrice += data;
                                        $basePrice += number_format($TargetBase) + ' ریال';
                                        $("#totoall_base_div").html($basePrice);

                                    });


                            }
                        }

                    }
                </script>
                <script>
                    window.Price = <?php echo $ProductTarget->Price; ?>;
                    window.BasePrice = <?php echo $ProductTarget->BasePrice; ?>;
                    window.Benefit = window.BasePrice - window.Price;
                    window.multiple = 1;


                    function SelectProduct(ProductName, ProductWarehouseID, GoodID, Image, Price, BasePrice) {
                        window.Price = Price;
                        window.BasePrice = BasePrice;
                        window.Benefit = BasePrice - Price;
                        $("#Modal_product_name").text('نام محصول : ' + ProductName);
                        $("#Modal_product_price").text('مبلغ : ' + number_format(Price) + ' ریال ');
                        $("#totoall_div").text('مجموع : ' + number_format(Price) + ' ریال ');
                        if (Price != BasePrice) {
                            $("#Modal_product_base_price").text('مبلغ : ' + number_format(BasePrice) + ' ریال ');
                            $("#totall_benefit").text('سود شما از خرید : ' + number_format(BasePrice - Price) + ' ریال ');
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
                                $('#TotalQty').val($TotalQty * 1);
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
                                $('#index_table_loader').addClass('nested');
                                $('#index_table').removeClass('nested');
                            });
                        $("body").attr("style", "padding-right: -15px;");

                    }
                </script>
                <script>
                    function AddToBasket() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $Qty = parseInt($('#Qty').val()) * window.multiple;
                        $.post('<?php echo e(route('ajax')); ?>', {
                                AjaxType: 'AddToBasket',
                                ProductId: $('#AddToBasketbtn').val(),
                                OrderQty: $Qty,
                            },

                            function(data, status) {
                                if (data) {
                                    document.getElementById("basketnumber").innerHTML = data;
                                    $("#basketnumber").removeClass("nested");
                                    $('#modal').modal('toggle');
                                    ProductId = $('#AddToBasketbtn').val();
                                    $('#ProductBox_' + ProductId).addClass('BuyedProduct');
                                    $('#buyalert').removeClass('nested');
                                    $('#Basketlink').removeClass('nested');
                                    $('#addtobasketdiv').addClass('nested');

                                }
                            });
                    }
                </script>
                <script>
                    function ChangeQty() {
                        //todo quty function applay
                    }

                    function loading() {
                        alert('salam');
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
                $('#UnitShow').removeClass('nested');
                $('#UnitShow').text($UnitName);
                $('#Qty').val(0);
                window.multiple = $multiple;
                incQty();

            }


        }
    </script>
    <script>
        $(document).ready(function() {
            incQty();
            decQty();
        });
    </script>


@endsection
