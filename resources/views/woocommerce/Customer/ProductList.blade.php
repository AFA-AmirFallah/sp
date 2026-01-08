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
@section('MainTitle')
    {{ $TagName }}
@endsection
@section('MainCountent')
    <style>
        .Shafatel17 {
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0px 0px 0px 1.8rem;
            font-size: 14px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            color: rgb(103, 106, 112);
            padding: 0.3rem 0px;
        }

        .Shafatel18 {
            margin-top: 26px;
            position: relative;
            background: darkgrey;
        }

        .Shafatel19 {
            margin-top: 0px;
            position: relative;
            background: #f0eeee;
        }

        .active {
            border-width: 3px;
            border-color: blue;
            background: blue;
            color: white;
            border-radius: 6px;
            padding-right: 5px;
            padding-left: 5px;
        }

        .Discount_Percent {
            position: absolute;
            left: 6px;
            top: 6px;
            background: red;
            border-radius: 3px;
            color: white;
            padding: 3px;
            font-size: large;

        }

        .Discount_Percent label {
            padding-bottom: 0px;
            margin-bottom: 0px;

        }

        .navigation {


            border-width: 0px 0px 1px 0px;
            border-style: solid;
            width: 100%;
            border-color: darkgray;
            font-size: 13px;
        }

    </style>
    <input class="nested" id="confirmcode">
    <h1 style="font-size: 12px" >{{ $TagName }}</h1>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="nested navigation">
                    <a>دسته محصولات</a><i class="i-Arrow-Left"></i> <a>دسته اصلی</a>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
                @include('Layouts.PWAProductModal')
                <div class="row">
                    @foreach ($Goods as $Good)

                        <div id="ProductBox_{{ $Good->id }}" style="padding-left: 5px ;padding-right: 5px"
                            class="wpa-md6 col-md-6
                            @if (in_array($Good->id, $BuyArray))
                                BuyedProduct
                            @endif
                            ">
                            <div class="nested" id="desc_{{ $Good->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($Good->MainDescription, 'DiscText') !!}</div>
                            <div class="nested" id="text_{{ $Good->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($Good->MainDescription, 'MainText') !!}</div>
                            <a onclick="SelectProduct('{{ $Good->NameFa }}' , '{{ $Good->wgid }}', '{{ $Good->id }}' ,'{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}',{{ $Good->Price }},{{ $Good->BasePrice }},'{{ $Good->PricePlan }}')"
                                data-toggle="modal" data-target=".bd-example-modal-lg">
                                <div class=" card card-ecommerce-3 o-hidden mb-4">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="Discount_Percent">
                                            @if ($Good->PricePlan == null)
                                                <label>
                                                    {{ ceil((($Good->BasePrice - $Good->Price) * 100) / $Good->BasePrice) }}%
                                                </label>
                                            @else
                                                <label>
                                                    {{ ceil((($Good->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($Good->PricePlan)) * 100) /$Good->BasePrice) }}%
                                                </label>

                                            @endif
                                        </div>
                                        <div class="">
                                            <img @if ($Good->Remian == 0) style="filter: opacity(0.5);" @endif class=" card-img-left"
                                                src="{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}"
                                                alt="{{ $Good->NameFa }}">
                                        </div>
                                        <div class="flex-grow-1 p-4">
                                            <h6 style="white-space: normal;height: 60px;" class="CustomerServiceCardHeader m-0">
                                                {{ $Good->NameFa }}</h6>
                                            <hr class="CustomerServiceCardHr">
                                            @if ($Good->Remian > 0)
                                                <p class="m-0 text-small text-muted">
                                                    @if ($Good->BasePrice > 0 && $Good->BasePrice != $Good->Price)
                                                        <del class="text-secondary">{{ number_format($Good->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }} {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>
                                                    @endif
                                                    <br>
                                                    @if ($Good->PricePlan == null)
                                                        {{ number_format($Good->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }} {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    @else
                                                        از
                                                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($Good->PricePlan)/ App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        تا
                                                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($Good->PricePlan)/ App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    @endif
                                                </p>
                                            @else
                                                <p style="color: red !important" class="m-0 text-small text-muted">
                                                    تمام شده! </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection
@section('page-js')
    <script>
        $("#viewContainer span").on("click", function() {
            $("#viewContainer span").removeClass("active");
            $("#sub_tags").removeClass("nested");
            $(this).addClass("active");
            $("#viewContainer").scrollCenter(".active", 300);
        });

        jQuery.fn.scrollCenter = function(elem, speed) {

            // this = #timepicker
            // elem = .active

            var active = jQuery(this).find(elem); // find the active element
            //var activeWidth = active.width(); // get active width
            var activeWidth = active.width() / 2; // get active width center

            //alert(activeWidth)

            //var pos = jQuery('#timepicker .active').position().left; //get left position of active li
            // var pos = jQuery(elem).position().left; //get left position of active li
            //var pos = jQuery(this).find(elem).position().left; //get left position of active li
            var pos = active.position().left + activeWidth; //get left position of active li + center position
            var elpos = jQuery(this).scrollLeft(); // get current scroll position
            var elW = jQuery(this).width(); //get div width
            //var divwidth = jQuery(elem).width(); //get div width
            pos = pos + elpos - elW / 2; // for center position if you want adjust then change this

            jQuery(this).animate({
                scrollLeft: pos
            }, speed == undefined ? 1000 : speed);
            return this;
        };

        jQuery.fn.scrollCenterORI = function(elem, speed) {
            jQuery(this).animate({
                scrollLeft: jQuery(this).scrollLeft() - jQuery(this).offset().left + jQuery(elem).offset().left
            }, speed == undefined ? 1000 : speed);
            return this;
        };
    </script>
    <script>
        $(document).ready(function() {
            $("#viewContainer").scrollCenter(".active", 300);
        });
    </script>


@endsection
