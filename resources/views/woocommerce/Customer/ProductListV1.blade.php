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
    </style>

    <div class="main_countent_88">
        <div class="SearchConsole88">
            <div class="box_88">
                <div class="box_header_88">
                    فیلترهای اعمال شده
                    <a href="" class="box_header_88">حذف</a>
                    <hr class="box_header_88">
                </div>
                ندارد
            </div>
            <div class="box_88">
                <label class="switch switch-green">
                    @if (isset($SearchArray['remained']))
                        <input id="remained" onchange="changepage('condition','remained')" checked type="checkbox">
                        <span class="slider"></span>
                    @else
                        <input id="remained" onchange="changepage('condition','remained')" type="checkbox">
                        <span class="slider"></span>
                    @endif

                </label>
                کالاهای موجود
            </div>
            <div class="box_88">
                <label class="switch switch-green">
                    @if (isset($SearchArray['deleverbyseller']))
                        <input id="deleverbyseller" onchange="changepage('condition','deleverbyseller')" checked
                            type="checkbox">
                        <span class="slider"></span>
                    @else
                        <input id="deleverbyseller" onchange="changepage('condition','deleverbyseller')" type="checkbox">
                        <span class="slider"></span>
                    @endif
                </label>
                امکان ارسال توسط فروشنده
            </div>
            <div class="box_88">
                <label onchange="changepage('condition','withDiscount')" class="switch switch-green">
                    @if (isset($SearchArray['withDiscount']))
                        <input id="withDiscount" onchange="changepage('condition','withDiscount')" checked type="checkbox">
                        <span class="slider"></span>
                    @else
                        <input id="withDiscount" onchange="changepage('condition','withDiscount')" type="checkbox">
                        <span class="slider"></span>
                    @endif
                </label>
                تخفیف دار
            </div>
            <div style="overflow-y: scroll;max-height: 500px;" class="box_88">
                <div class="box_header_88">
                    دسته بندی نتایج
                    <hr class="box_header_88">
                </div>
                {!! App\Functions\Indexes::HTMLVerticalMenu() !!}
            </div>
            <form action="" method="get">
                <div id="PriceFilter" class="box_88">
                    <div class="box_header_88">
                        قیمت
                        <hr class="box_header_88">
                    </div>
                    <div style="display: flex">
                        <div style="text-align: center" class="col ">
                            <p class="text-center">از</p>
                            <input id="fromprice" name="from_price" class="form-control text-center fromfeild"
                                type="number">
                            <p class="text-center">تومان</p>
                        </div>
                        <div class="col">
                            <p class="text-center">تا</p>
                            <input class="form-control text-center" name="to_price" type="text">
                            <p class="text-center">تومان</p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">اعمال فیلتر قیمت</button>
                </div>
            </form>
        </div>
        <div class="container-fluid main-menu">
            <div class="page-header">
                <div class="row">
                    <div style="display: flex" class="navigation_88">
                        <a>دسته محصولات</a><i class="i-Arrow-Left"></i>
                        <h1 style="font-size: 12px">{{ $TagName }}</h1>
                        <button class="menu-filter-160"> فیلتر <i class="i-Filter-2 menu-filter-160"></i></button>
                    </div>
                    @if ($TagName == 'جستجو')
                        <div style="height: 30px;display: flex;position: sticky;width: 100%;"></div>
                    @else
                        <div class="ProductContinerMenu161">
                            مرتب سازی بر اساس:
                            @if (isset($SearchArray['sort']) && $SearchArray['sort'] == 'last')
                                <a class="sort_items161 selected" href="?sort=last">آخرین محصولات</a>
                            @else
                                <a class="sort_items161" href="?sort=last">آخرین محصولات</a>
                            @endif
                            @if (isset($SearchArray['sort']) && $SearchArray['sort'] == 'offers')
                                <a class="sort_items161 selected" href="?sort=offers">پیشنهادات ویژه</a>
                            @else
                                <a class="sort_items161" href="?sort=offers">پیشنهادات ویژه</a>
                            @endif
                            @if (isset($SearchArray['sort']) && $SearchArray['sort'] == 'view')
                                <a class="sort_items161 selected" href="?sort=view">پربازدیدها</a>
                            @else
                                <a class="sort_items161" href="?sort=view">پربازدیدها</a>
                            @endif
                            @if (isset($SearchArray['sort']) && $SearchArray['sort'] == 'new')
                                <a class="sort_items161 selected" href="?sort=new">جدیدترین ها</a>
                            @else
                                <a class="sort_items161" href="?sort=new">جدیدترین ها</a>
                            @endif
                            @if (isset($SearchArray['sort']) && $SearchArray['sort'] == 'expensive')
                                <a class="sort_items161 selected" href="?sort=expensive">گران ترین ها</a>
                            @else
                                <a class="sort_items161" href="?sort=expensive">گران ترین ها</a>
                            @endif
                            @if (isset($SearchArray['sort']) && $SearchArray['sort'] == 'cheap')
                                <a class="sort_items161 selected" href="?sort=cheap">ارزان ترین ها</a>
                            @else
                                <a class="sort_items161" href="?sort=cheap">ارزان ترین ها</a>
                            @endif
                            <ol class="breadcrumb pull-right">
                                @include('Layouts.AddressBar')
                            </ol>
                        </div>
                    @endif


                    @include('Layouts.PWAProductModal')
                    @if ($Goods == null)
                        <div style="width: 100%; text-align: center;">
                            <svg width="70" height="70" viewBox="0 0 70 70" fill="none">
                                <path
                                    d="M35.0011 42.6094C29.328 42.6094 23.9243 45.0122 20.1717 49.2031C19.6117 49.83 19.665 50.7902 20.2904 51.3518C20.5795 51.612 20.9432 51.7398 21.3054 51.7398C21.7224 51.7398 22.1393 51.5694 22.4391 51.2331C25.615 47.6859 30.1939 45.6529 35.0011 45.6529C39.8097 45.6529 44.3887 47.6859 47.563 51.2331C48.123 51.86 49.0863 51.9118 49.7117 51.3518C50.3371 50.7918 50.3904 49.83 49.8304 49.2031C46.0793 45.0137 40.6756 42.6094 35.0011 42.6094Z"
                                    fill="#A6A4A4"></path>
                                <path
                                    d="M35 0C15.6998 0 0 15.7013 0 35C0 54.2987 15.6998 70 35 70C54.3002 70 70 54.2987 70 35C70 15.7013 54.3002 0 35 0ZM35 66.9565C17.3798 66.9565 3.04348 52.6217 3.04348 35C3.04348 17.3783 17.3798 3.04348 35 3.04348C52.6202 3.04348 66.9565 17.3783 66.9565 35C66.9565 52.6217 52.6202 66.9565 35 66.9565Z"
                                    fill="#A6A4A4"></path>
                                <path
                                    d="M53.2601 24.3477C52.4186 24.3477 51.7384 25.0294 51.7384 25.8694C51.7384 28.3864 49.6901 30.4346 47.1732 30.4346C44.6562 30.4346 42.6079 28.3864 42.6079 25.8694C42.6079 25.0294 41.9277 24.3477 41.0862 24.3477C40.2447 24.3477 39.5645 25.0294 39.5645 25.8694C39.5645 30.0648 42.9777 33.4781 47.1732 33.4781C51.3686 33.4781 54.7819 30.0648 54.7819 25.8694C54.7819 25.0294 54.1016 24.3477 53.2601 24.3477Z"
                                    fill="#A6A4A4"></path>
                                <path
                                    d="M30.4342 25.8694C30.4342 25.0294 29.754 24.3477 28.9124 24.3477C28.0709 24.3477 27.3907 25.0294 27.3907 25.8694C27.3907 28.3864 25.3424 30.4346 22.8255 30.4346C20.3085 30.4346 18.2603 28.3864 18.2603 25.8694C18.2603 25.0294 17.5801 24.3477 16.7385 24.3477C15.897 24.3477 15.2168 25.0294 15.2168 25.8694C15.2168 30.0648 18.6301 33.4781 22.8255 33.4781C27.0209 33.4781 30.4342 30.0648 30.4342 25.8694Z"
                                    fill="#A6A4A4"></path>
                            </svg>
                            <p>هیچ کالایی موجود نیست</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($Goods as $Good)
                                <div id="ProductBox_{{ $Good->id }}"
                                    class="ProductBox_88
                                @if (in_array($Good->id, $BuyArray)) BuyedProduct @endif
                                ">
                                    <div class="nested" id="desc_{{ $Good->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($Good->MainDescription, 'DiscText') !!}</div>
                                    <div class="nested" id="text_{{ $Good->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($Good->MainDescription, 'MainText') !!}</div>
                                    <a href="{{ route('SingleProduct', ['productID' => $Good->id]) }}">
                                        <div class=" card card-ecommerce-3 o-hidden mb-4">
                                            <div class="d-flex flex-column flex-sm-row">

                                                @if ($Good->PricePlan == null)
                                                    @if ($Good->BasePrice > $Good->Price)
                                                        <div class="Discount_Percent">
                                                            <label>
                                                                {{ ceil((($Good->BasePrice - $Good->Price) * 100) / $Good->BasePrice) }}%
                                                            </label>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="Discount_Percent">
                                                        <label>
                                                            {{ ceil((($Good->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($Good->PricePlan)) * 100) / $Good->BasePrice) }}%
                                                        </label>
                                                    </div>
                                                @endif
                                                <div class="">
                                                    <img @if ($Good->Remian == 0) style="filter: opacity(0.5);" @endif
                                                        class=" card-img-left"
                                                        src="{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}"
                                                        alt="{{ $Good->NameFa }}">
                                                </div>
                                                <div class="flex-grow-1 p-4">
                                                    <h6 style="white-space: normal;height: 60px; overflow:hidden;"
                                                        class="CustomerServiceCardHeader min-menu m-0">
                                                        {{ $Good->NameFa }}</h6>
                                                    <hr class="CustomerServiceCardHr">
                                                    @if ($Good->Remian > 0)
                                                        <div style="float:left;white-space: nowrap;">
                                                            @if ($Good->BasePrice > 0 && $Good->BasePrice != $Good->Price)
                                                                <div class="discount_main">
                                                                    <div class="discount"></div>
                                                                    <p class="discounttext">
                                                                        {{ number_format($Good->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                            @if ($Good->MinPrice != 0)
                                                                @if ($Good->MinPrice == $Good->MaxPrice || $Good->MaxPrice == 0)
                                                                    {{ number_format($Good->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                @else
                                                                    از
                                                                    {{ number_format($Good->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    تا
                                                                    {{ number_format($Good->MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                @endif
                                                            @else
                                                                @if ($Good->PricePlan == null)
                                                                    {{ number_format($Good->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                @else
                                                                    از
                                                                    {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($Good->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    تا
                                                                    {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($Good->PricePlan) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                                @endif
                                                            @endif

                                                        </div>
                                                    @else
                                                        <p style="color: red !important"
                                                            class="m-0 text-small text-muted">
                                                            تمام شده! </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
@section('page-js')
    <script>
        function changepage($keyGet, $GetVal) {
            if ($('#' + $GetVal).is(":checked")) {
                window.location.href = "?" + $keyGet + '=' + $GetVal + '&value=yes';
            } else {
                window.location.href = "?" + $keyGet + '=' + $GetVal + '&value=no';
            }

        }
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
