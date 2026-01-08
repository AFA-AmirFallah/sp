@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.CustomerMainPage')

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
@section('ExtraTags')
    <meta name="productid" content="{{ $TargetGood->id }}">
    <meta name="productname" content="{{ $TargetGood->NameFa }}">
    <meta name="priceCurrency" content="IRT">
    @if ($PricePlan == null)
        <meta name="productprice" content="{{ $ProductTarget->Price / 10 }}">
    @else
        <meta name="productprice"
            content=" {{ \App\Http\Controllers\woocommerce\product::GetMinPrice($PricePlan) / 10 }}">
    @endif
    <meta name="productoldprice" content="{{ $ProductTarget->BasePrice / 10 }}">
    @if ($ProductTarget->Remian > 0)
        <meta name="availability" content="instock">
    @else
        <meta name="availability" content="outofstock">
    @endif
@endsection

@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .takhfif {
            margin-top: 6px;
            text-align: center;
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
            background-color: #0a0a0a;
            color: white;
            border-radius: 6px;
            border-width: 0;
            direction: rtl;
            padding-right: 25px;
            text-align: center;
        }

        .CustomerServiceCardHeader {
            font-size: 1.25rem !important;
            text-align: center;
            height: 50px;
        }

        .pricesume {
            text-align: center;
            color: green;
            padding: 10px;
            width: fit-content;
            font-size: 17px;
            border-radius: 5px;
            border-color: chartreuse;
            border-width: 10px;
            display: initial;
        }

        .percentdiv {
            background-color: #2edd2eb5;
            text-align: center;
            font-size: 20px;
            border-radius: 2px;
            text-shadow: 2px 2px 5px red;
            margin-top: -29px;
            padding-top: 21px;
        }

        .takhfifonimg {
            position: absolute;
            background-color: #eb4d4b;
            color: white;
            font-size: 36px;
            border-radius: 5px;
            padding: 3px;
            left: 9px;
        }

        .info-card-header {
            display: flex;
        }

        img.info-card-header {
            width: 25px;
            height: 25px;
            margin-left: 5px;
            height: fit-content;
        }

        .social {
            text-align: center;
        }

        a.social {
            font-size: 20px;
            padding-left: 10px;
        }
    </style>

    <input class="nested" id="confirmcode">
    <div style="margin-top: 0px;" class="product_card card col-12">
        <div style="right:calc((96vw - var(--shafate-max-width)) / 2);" class="modal fade" id="modalComment"
            tabindex="-1" role="dialog" aria-labelledby="modalCommentTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title">افزودن نظر</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-4">
                                <textarea name="comment" class="form-control" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                            <button type="submit" name="submit" value="AddComment" class="btn btn-primary">ثبت
                                دیدگاه</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="info-card-header card-header">
            @php
                $Shop = $Product->GetProductShop($TargetGood->id);
                if ($Shop == null) {
                    $ShopLogo = \App\myappenv::FavIcon;
                    $ShopName = 'فروشگاه: ' . \App\myappenv::CenterName;
                } else {
                    $ShopLogo = $Shop->Pic;
                    $ShopName = 'فروشگاه: ' . $Shop->Name;
                }
            @endphp
            <div style="width: 50px;height: 50px;">
                <img src="{{ $ShopLogo }}" alt="{{ $ShopName }}">

            </div>

            <p style="font-size: 14px;padding: inherit;">{{ $ShopName }}</p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>

        </div>
        <div class="card-body">
            <form method="post">
                @csrf
                <div class="form-group row">
                    <img style="margin: auto;height: 300px;" id='modal_product_img'
                        src="{{ App\Functions\Images::GetPicture($TargetGood->ImgURL, 1) }}"
                        alt="{{ $TargetGood->NameFa }}">
                    <div class="takhfifonimg">
                        <p id="percenttext" style="margin-bottom: -7px;">1%</p>
                    </div>
                </div>
                <div class="social">
                    <div class="">
                        <div class="">
                            <a class="social"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                target="_blank"><i class="i-Facebook"></i></a>
                            <a class="social"
                                href="http://twitter.com/share?url={{ url()->current() }}&text={{ $TargetGood->Name }}&hashtags=simplesharebuttons"
                                target="_blank"><i class="i-Twitter"></i> </a>
                            <a class="social" target="_blank"
                                href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i
                                    class="i-Pinterest"></i></a>
                            <a class="social" target="_blank"
                                href="whatsapp://send?text={{ url()->current() }}"><img
                                    style="width: 21px;margin-top: -8px;" src="{{ asset('assets/images/WhatsApp.png') }}"
                                    alt="WatsApp"></a>
                            <a class="social" target="_blank"
                                href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}"><i
                                    class="i-Linkedin"></i></a>
                        </div>
                    </div>
                    <span class="divider d-xs-show"></span>
                    <div class="product-link-wrapper d-flex">
                        <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                        <a href="#" class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                    </div>
                </div>
                <h1 id="Modal_product_name" class="CustomerServiceCardHeader m-0">
                    {{ $TargetGood->NameFa }}
                </h1>
                @if ($PricePlan != null)
                    <div class="takhfif">
                        <del style="font-size: 29px;color:#8b6cf4 !important;"
                            class="Modal_product_base_price takhfif text-secondary">قیمت:
                            {{ number_format($ProductTarget->BasePrice) }} ریال</del>
                    </div>
                    <div style="display: block;width:100%;text-align:center;margin:0px;" class="row">
                        <h6 style="display: inline;color:blue" id="totoall_base_div"></h6>
                        @php
                            $UnitSet = false;
                        @endphp
                        @foreach ($UnitPlan as $UnitPlanTarget)
                            @if ($UnitPlanTarget->multiple == 1)
                                <p style="display: inline;font-size:10px;color:blue;">هر
                                    {{ $UnitPlanTarget->UnitName }}</p>
                                @php
                                    $UnitSet = true;
                                @endphp
                            @endif
                        @endforeach
                        @if (!$UnitSet)
                            <p style="display: inline;font-size:10px;color:blue;">هر
                                عدد</p>
                        @endif
                    </div>
                @else
                    <div style="margin-bottom: 10px;" class="takhfif">
                        <del style="font-size: 29px;color:#8b6cf4 !important;"
                            class="Modal_product_base_price takhfif text-secondary">قیمت:
                            {{ number_format($ProductTarget->BasePrice) }} ریال</del>
                    </div>
                @endif
                <div style="text-align: center;margin-top:20px;">
                    <h6 style="    border-radius: 5px;
                                                                                                                                                                                        color: #fff;
                                                                                                                                                                                        display: initial;
                                                                                                                                                                                        background-color: #8200f4;
                                                                                                                                                                                        width: fit-content;
                                                                                                                                                                                        padding: 4px;
                                                                                                                                                                                        font-size: 17px;"
                        id="totall_benefit">
                        سود
                        شما :
                        {{ number_format($ProductTarget->BasePrice - $ProductTarget->Price) }}
                        ریال
                    </h6>

                </div>

                @if ($PricePlan == null)
                    <h5 id="Modal_product_price" style="padding-top: 20px;" class="CustomerServiceCardHeader m-0"> قیمت:
                        {{ number_format($ProductTarget->Price) }} ریال
                    </h5>
                    <input class="nested" id="PricePlan" value="no" type="text">
                @else
                    <h5 id="Modal_product_price" style="padding-top: 20px;" class="CustomerServiceCardHeader m-0">
                        قیمت از
                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($PricePlan)) }}
                        تا
                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($PricePlan)) }}
                        ریال
                    </h5>
                    <input class="nested" id="PricePlan" value="{{ $ProductTarget->PricePlan }}" type="text">
                @endif
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
                            type="radio" class="from-group " @if ($ProductTarget->Remian < $UnitPlanTarget->multiple) disabled @endif
                            @if ($UnitPlanTarget->multiple == 1) checked @endif
                            id="unitplan_{{ $UnitPlanTarget->multiple }}" name="UnitPlan"
                            value="{{ $UnitPlanTarget->multiple }}">
                        <label for="html">{{ $UnitPlanTarget->UnitName }}</label><br>
                        <input type="text" id="unitimg_{{ $UnitPlanTarget->multiple }}" class="nested"
                            value="{{ $UnitPlanTarget->img }}">
                    @endforeach
                @endif
                @if ($ProductTarget->Remian > 0)
                    <div id="addtobasketdiv" class="form-group row">
                        <div id="PriceLoader" class="loader  loader-bubble loader-bubble-primary nested ">
                        </div>
                        <div style="width: 100%">
                            <div class="text-center mt-3">
                                <div dir="ltr" class="btn-group">
                                    <label for="requestNumber" class="btn btn-dark m-0 p-0 text-center">
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
                                                class="i-Arrow-Up">
                                            </i>
                                            <i style="display: flow-root;
                                                                                                                                                                                                                                                                    position: absolute;
                                                                                                                                                                                                                                                                    right: 3px;
                                                                                                                                                                                                                                                                    font-size: 14px;
                                                                                                                                                                                                                                                                    font-weight: 800;
                                                                                                                                                                                                                                                                    top: 21px;
                                                                                                                                                                                                                                                                    color: white;
                                                                                                                                                                                                                                                                                                                        "
                                                class="i-Arrow-Down"></i>
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
                                                <select onchange="ChangeQty(this,false)"
                                                    class="select_qty SelectStyle1106 form-control ng-pristine ng-valid ng-touched
                                                @if ($UnitPlanTarget->multiple != 1) nested @endif
                                                "
                                                    name="Qty" id="QtySelect_{{ $UnitPlanTarget->multiple }}">
                                                    @for ($i = 1; $i * $UnitPlanTarget->multiple <= $ProductTarget->Remian; $i++)
                                                        <option value="{{ $i * $UnitPlanTarget->multiple }}">
                                                            {{ $i }} @if ($UnitPlanTarget->multiple == 1)
                                                                {{ $UnitPlanTarget->UnitName }}
                                                            @else
                                                                {{ $UnitPlanTarget->UnitName }}
                                                            @endif
                                                        </option>
                                                    @endfor
                                                </select>
                                            @endforeach
                                        @endif
                                        @if (!$UnitSet)
                                            <select onchange="ChangeQty(this,false)" name="Qty" id="QtySelect_1"
                                                class="select_qty SelectStyle1106 form-control ng-pristine ng-valid ng-touched">
                                                @for ($i = 1; $i <= $ProductTarget->Remian; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}
                                                        عدد
                                                    </option>
                                                @endfor
                                            </select>
                                        @endif
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div style="width: 100%" id="PriceData">
                            <input type="number" class="nested" id="TotalQty"
                                value="{{ $ProductTarget->Remian }}">
                            <input type="number" class="nested" id="pw_id" value="{{ $ProductTarget->wgid }}">
                            <div style="margin-top: 10px;width: 100%;">

                                <div style="text-align: center">
                                    <h6 class="pricesume" id="totoall_div">مجموع :
                                        {{ number_format($ProductTarget->Price) }}
                                        ریال
                                    </h6>
                                </div>

                                <br>

                                <button style="width: 90%;margin-right:5%;" id="AddToBasketbtn" onclick="AddToBasket()"
                                    type="button" name="submit" value="{{ $ProductTarget->id }}" class="btn btn-success">
                                    <img style="width: 25px" src="{{ asset('assets/images/add-to-cart.png') }}" alt="+">
                                    افزودن به سبد خرید </button>

                            </div>

                        </div>
                    </div>
                @else
                    <div id="addtobasketdiv" class="form-group row">
                        <h6>
                            اتمام موجودی!
                        </h6>
                    </div>
                @endif
                <div id="Attrebute">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'DiscText') !!}</div>
                <div id="buyalert" class="alert alert-success nested" role="alert">
                    <h4> {{ __('success alert') }}</h4>
                    <li>محصول به سبد خرید اضافه شد!</li>
                </div>
                <a href="{{ route('checkout') }}" id="Basketlink" style="color: white"
                    class="btn btn-block btn-primary m-1 nested">سبد خرید</a>

                <hr>
                <div id="Description">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'MainText') !!} </div>
            </form>
            @if (Auth::check())
                <button type="button" class="btn btn-primary nested" data-toggle="modal" data-target="#modalComment">
                    دیدگاه اضافه کنید
                </button>
            @endif
        </div>
    </div>
    @include('woocommerce.Customer.ProductListItems', ['sender' => 'single'])
    <script>
        window.Price = <?php echo $ProductTarget->Price; ?>;
        window.BasePrice = <?php echo $ProductTarget->BasePrice; ?>;
        window.Benefit = window.BasePrice - window.Price;
        window.Qty = 1;
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

        function AddToBasket() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'AddToBasket',
                    ProductId: $('#AddToBasketbtn').val(),
                    pw_id: $('#pw_id').val(),
                    OrderQty: window.Qty,
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

        function formolachangeQty($Qty) {
            window.Qty = $TargetQty;
            $TotalQty = parseInt($('#TotalQty').val());
            $('#PriceData').addClass('nested');
            $('#PriceLoader').removeClass('nested');
            if ($('#PricePlan').val() == 'no') {

                $Totall = window.Price * $TargetQty;
                $Benefit = window.Benefit * $TargetQty;
                $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                $mytext = '| 15%';
                $("#totall_benefit").text('سود شما : ' + number_format($Benefit) + ' ریال ');
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
                        $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                        $("#totall_benefit").text('سود شما : ' + number_format($Benefit) + ' ریال ');
                        $Percent = Math.round(((window.BasePrice - $TargetBase) * 100) / window.BasePrice);
                        $('#percenttext').html($Percent + '%');
                        $basePrice = number_format($TargetBase) + ' ریال';
                        $("#totoall_base_div").html($basePrice);
                        $('#PriceData').removeClass('nested');
                        $('#PriceLoader').addClass('nested');
                    });
            }
        }

        function BasicChangeQty($Qty) {
            $('#totoall_base_div').addClass('nested');
            $('#PricePlan').val('no');
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
