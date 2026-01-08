@php
    $Persian = new App\Functions\persian();
    $ShopInfo = $Product->GetProductShop($TargetGood->id);
    $ContInBasket = app\Http\Controllers\woocommerce\product::IsProductInBasket(
        $ProductTarget->id,
        $ProductTarget->wgid,
    );
    $Price = $Product->GetTargetPrice($ProductTarget->Price, $TargetGood->tax_status);
    $BasePrice = $Product->GetTargetPrice($ProductTarget->BasePrice, $TargetGood->tax_status);
@endphp
@php
    if ($ProductTarget->PricePlan != null) {
        $steps = true;
        $Price = $MyProduct->GetTargetPriceFromPricePlan($ProductTarget->PricePlan, 1);
        $price_plan_arr = $MyProduct->get_product_plan_array($ProductTarget->PricePlan);
        $PricePlan = $ProductTarget->PricePlan;
    } else {
        $steps = false;
        $Price = $ProductTarget->Price;
        $price_plan_arr = [];
        $PricePlan = '';
    }
    $max_qty = $ProductTarget->Remian;

    $BasePrice = $MyProduct->GetTargetPrice($ProductTarget->BasePrice, $ProductTarget->tax_status);
@endphp
@php
    $unit_count = 0;
    $image_unit_count = 0;
    if ($ProductTarget->Remian > 0) {
        if ($ProductTarget->UnitPlan != null && $ProductTarget->UnitPlan != '') {
            $unit_plan = json_decode($ProductTarget->UnitPlan);
            $unit_count = count($unit_plan);
        }
    }

@endphp
@extends('Layouts.Theme5.layout.main_layout')
@section('MainTitle')
    {{ $TargetGood->NameFa }}
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="{{ $TargetGood->NameFa }}" />
    <meta name="description" content="{{ $TargetGood->NameFa }}">
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="{{ \App\myappenv::CenterName }}" />
    <meta property="og:image" content="{{ App\Functions\Images::GetPicture($TargetGood->ImgURL, 1) }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection
@section('ExtraTags')
    <meta name="productid" content="{{ $TargetGood->id }}">
    <meta name="productname" content="{{ $TargetGood->NameFa }}">

    @if ($PricePlan == null)
        <meta name="productprice" content="{{ $Price / 10 }}">
    @else
        <meta name="productprice"
            content="{{ $MyProduct->GetTargetPriceFromPricePlan($ProductTarget->PricePlan, 'max') / 10 }}">
    @endif
    <meta name="productoldprice" content="{{ $BasePrice / 10 }}">
    @if ($ProductTarget->Remian > 0)
        <meta name="availability" content="instock">
    @else
        <meta name="availability" content="outofstock">
    @endif
@endsection
@section('content')
    <style>
        .active_td {
            background-color: #f44336;
            color: white;
        }

        .ui-variant-shape {
            background-color: #f6f6f6;
        }

        .ui-variant-shape.active {
            background-color: #f44336 !important;
        }
    </style>
    <main class="main-content dt-sl mb-3">
        <div class="container main-container">
            <!-- Start title - breadcrumb -->
            <div class="title-breadcrumb-special dt-sl mb-3">
                <div class="breadcrumb dt-sl">
                    <nav>
                        <a href="{{ route('home') }}">صفحه اصلی </a>
                        @foreach ($MyProduct->get_product_map($TargetGood->id) as $product_index)
                            <a
                                href="{{ route('ShowProduct', ['TagName' => $product_index->Name, 'Tags' => $product_index->UID]) }}">{{ $product_index->Name }}</a>
                        @endforeach
                        
                        <a href="#">{{ $TargetGood->NameFa }}</a>
                    </nav>
                </div>
            </div>
            <!-- End title - breadcrumb -->
            <!-- Start Product -->
            <div class="dt-sn mb-5 dt-sl">
                <div class="row">
                    <!-- Product Gallery-->
                    @if ($ProductTarget->Remian > 0)
                        <div class="col-lg-4 col-md-6 ps-relative">
                            <!-- Product Options-->
                            <ul class="gallery-options">
                                <li>
                                    @if (Auth::Check())
                                        @php
                                            $is_marked = $mark->is_marked_before(Auth::id(), $TargetGood->id, 1);
                                        @endphp
                                        @if ($is_marked)
                                            <button id="{{ $TargetGood->id }}" class="add-favorites favorites"><i
                                                    class="mdi mdi-heart"></i></button>
                                        @else
                                            <button id="{{ $TargetGood->id }}" class="add-favorites"><i
                                                    class="mdi mdi-heart"></i></button>
                                        @endif
                                    @else
                                        <button id="{{ $TargetGood->id }}" class="add-favorites"><i
                                                class="mdi mdi-heart"></i></button>
                                    @endif
                                    <span class="tooltip-option">افزودن به علاقمندی</span>
                                </li>

                            </ul>
                            @if ($steps)
                                <h5 class="modal-title" id="productname">
                                    <div class="steps_icon  rating-stars">
                                        <p class="steps_sddjf"> تخفیف پلکانی</p>
                                    </div>
                                </h5>
                            @endif

                            <div class="product-gallery">
                                @php
                                    $PicSource = json_decode($TargetGood->ImgURL);
                                    $img_count = 0;
                                @endphp
                                <div class="product-carousel owl-carousel" data-slider-id="1">
                                    @foreach ($PicSource as $PicItem)
                                        @if ($PicItem->PicUrl != null && $PicItem->PicUrl != 'null')
                                            <div style="max-height: 334px" class="item  {{ $loop->index }} ">
                                                <a class="gallery-item" href="{{ $PicItem->PicUrl }}"
                                                    data-fancybox="gallery1">
                                                    <img src="{{ $PicItem->PicUrl }}" alt="{{ $TargetGood->NameFa }}">
                                                </a>
                                            </div>
                                            @php
                                                $img_count++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if ($unit_count != 0)
                                        @foreach ($unit_plan as $unit_plan_item)
                                            @php
                                                $image_unit_count++;
                                            @endphp
                                            @if ($unit_plan_item->img != null && $unit_plan_item->img != 'null')
                                                <div style="max-height: 334px" class="item {{ $loop->index }}">
                                                    <a class="gallery-item unit_{{ $unit_plan_item->multiple }} "
                                                        href="{{ $unit_plan_item->img }}" data-fancybox="gallery1">
                                                        <img src="{{ $unit_plan_item->img }}"
                                                            alt="{{ $TargetGood->NameFa }}">
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <input class="d-none" value="{{ $img_count }}" id="base_img_count">


                                <div class="d-flex justify-content-center flex-wrap">
                                    <ul class="product-thumbnails owl-thumbs ml-2" data-slider-id="1">
                                        @foreach ($PicSource as $PicItem)
                                            @if ($PicItem->PicUrl != null && $PicItem->PicUrl != 'null')
                                                @if ($loop->first)
                                                    <li class="owl-thumb-item active">
                                                    @else
                                                    <li class="owl-thumb-item ">
                                                @endif
                                                <a>
                                                    <img src="{{ $PicItem->PicUrl }}" alt="{{ $TargetGood->NameFa }}">
                                                </a>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if ($unit_count != 0)
                                            @foreach ($unit_plan as $unit_plan_item)
                                                @if ($unit_plan_item->img != null && $unit_plan_item->img != 'null')
                                                    @php
                                                        $image_unit_count++;
                                                    @endphp

                                                    <li class="owl-thumb-item unit_{{ $unit_plan_item->multiple }}">
                                                        <a>
                                                            <img src="{{ $unit_plan_item->img }}"
                                                                alt="{{ $TargetGood->NameFa }}">
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif

                                    </ul>


                                </div>
                                <div>
                                    <div style="text-align:center;background-color: #f44336;color:white">
                                        اگر این محصول را می‌پسندید از طریق لینک‌های زیر در شبکه‌های اجتماعی به سایر علاقه
                                        مندان همرسانی کنید!
                                    </div>
                                    <div style="
                                    padding-top: 0px;
                                    margin-top: 7px;
                                    "
                                        class="share-items clearfix">
                                        <ul style="text-align:center" class="unstyled footer-social">
                                            <li style="font-size: 30px">
                                                <a title="Facebook"
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="mdi mdi-facebook"></i></span>
                                                </a>
                                                <a title="Twitter"
                                                    href="http://twitter.com/share?url={{ url()->current() }}&text={{ $TargetGood->NameFa }}&hashtags=simplesharebuttons"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="mdi mdi-twitter"></i></span>
                                                </a>
                                                <a title="Google+"
                                                    href="https://plus.google.com/share?url={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="mdi mdi-google-plus"></i></span>
                                                </a>

                                                <a title="Linkdin"
                                                    href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="mdi mdi-linkedin"></i></span>
                                                </a>
                                                <a target="_blank" title="whatsapp"
                                                    href="whatsapp://send?text={{ url()->current() . '   ' . $TargetGood->NameFa }}">
                                                    <span class="social-icon"><i class="mdi mdi-whatsapp"></i></span>
                                                </a>
                                                <a title="pinterest"
                                                    href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
                                                    <span class="social-icon"><i class="mdi mdi-pinterest"></i></span>
                                                </a>
                                                <a title="instagram"
                                                    href="https://www.instagram.com/?url={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="mdi mdi-instagram"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- Share items end -->
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-4 col-md-6 ps-relative">


                            <ul class="gallery-options">
                                <li>
                                    <button class="add-favorites"><i class="mdi mdi-heart"></i></button>
                                    <span class="tooltip-option">افزودن به علاقمندی</span>
                                </li>

                            </ul>
                            <div class="product-timeout position-relative pt-5 mb-3">
                                <div class="promotion-badge not-available">
                                    ناموجود
                                </div>
                            </div>
                            <div class="product-gallery">
                                @php
                                    $PicSource = json_decode($TargetGood->ImgURL);
                                @endphp
                                <div class="product-carousel owl-carousel" data-slider-id="1">
                                    @foreach ($PicSource as $PicItem)
                                        @if ($PicItem->PicUrl != null)
                                            <div style="max-height: 334px" class="item">
                                                <a class="gallery-item" href="{{ $PicItem->PicUrl }}"
                                                    data-fancybox="gallery1">
                                                    <img src="{{ $PicItem->PicUrl }}" alt="{{ $TargetGood->NameFa }}">
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-center flex-wrap">
                                    <ul class="product-thumbnails owl-thumbs ml-2" data-slider-id="1">
                                        @foreach ($PicSource as $PicItem)
                                            @if ($PicItem->PicUrl != null)
                                                @if ($loop->first)
                                                    <li class="owl-thumb-item active">
                                                    @else
                                                    <li class="owl-thumb-item ">
                                                @endif
                                                <a href="">
                                                    <img src="{{ $PicItem->PicUrl }}" alt="{{ $TargetGood->NameFa }}">
                                                </a>
                                                </li>
                                            @endif
                                        @endforeach

                                    </ul>

                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Product Info -->
                    <div class="col-lg-8 col-md-6 py-2">
                        <div class="product-info dt-sl">
                            <div class="product-title dt-sl">
                                <h1 class="product-variant-name">{{ $TargetGood->NameFa }}</h1>
                                @if ($management)
                                    <a role="button" href="{{ route('EditProduct', ['id' => $TargetGood->id]) }}"
                                        direction="right" font-size="1.4" height="3"><i class="mdi mdi-pencil"></i>
                                    </a>
                                @endif
                                <div class="brand_div">
                                    برند:
                                    @foreach ($Tags as $target_tag)
                                        <a href="{{ route('brand', ['TagName' => $target_tag->L3Name]) }}"
                                            class="brand_link">{{ $target_tag->L3Name }}
                                        </a>
                                    @endforeach

                                </div>
                            </div>


                            <div class="product-params dt-sl">
                                @if ($showTable)
                                    @php
                                        $sourceIndex = $Product->GetProductIndexes($TargetGood->id);

                                    @endphp


                                    @if ($ProductTarget->MainDescription != null)
                                        <ul data-title="ویژگی‌های محصول">
                                            {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'DiscText') !!}
                                        </ul>
                                        <div class="sum-more">
                                            <span class="show-more btn-link-border">
                                                + موارد بیشتر
                                            </span>
                                            <span class="show-less btn-link-border">
                                                - بستن
                                            </span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <h3 class="product-variant-name">کد محصول: {{ $ProductTarget->SKU }}</h3>
                            <hr>
                        </div>
                        <div class="row col-12 buy-section">
                            <div class="col-lg-6 col-12  discount_aria">
                                <div class="discount-single">
                                    <del>{{ number_format($BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    </del>
                                    <label class="didfjf" style="margin-right: 24px;"
                                        id="dis_percent">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label>
                                </div>
                                <div class="target_price">
                                    <div style="display:contents;" id="target_price">
                                        {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    </div>
                                    <small>{{ App\Http\Controllers\Credit\currency::GetCurrency() }}</small>
                                </div>
                            </div>


                            <div class="flex col-lg-6 col-12 justify-content-start row">
                                @if ($ProductTarget->Remian > 0)
                                    @if ($unit_count != 0)
                                        <div class="product-variant dt-sl">
                                            <div class="section-title text-sm-title title-wide no-after-title-wide mb-0">
                                                <h2 style="direction: rtl">انتخاب بسته:</h2>
                                            </div>
                                            <ul style="direction: rtl" class="product-variants float-right ml-3">
                                                <li onclick="set_unit({{ $ProductTarget->Unit ?? 1 }},1)"
                                                    class="ui-variant">
                                                    <label style="direction: rtl" class="ui-variant ui-variant--color">
                                                        <span id="span_unit_1" class="ui-variant-shape active"></span>
                                                        <input type="radio" value="4" name="color"
                                                            checked="" class="variant-selector unit_checkbox">
                                                        <span
                                                            class="ui-variant--check">{{ $ProductTarget->unit_name ?? 'تک' }}</span>
                                                    </label>
                                                </li>
                                                @php
                                                    $unit_no = 2;
                                                @endphp
                                                @foreach ($unit_plan as $unit_plan_item)
                                                    <li onclick="set_unit({{ $unit_plan_item->multiple }},{{ $unit_no }})"
                                                        class="ui-variant">
                                                        <label class="ui-variant ui-variant--color">
                                                            <span id="span_unit_{{ $unit_plan_item->multiple }}"
                                                                class="ui-variant-shape"></span>
                                                            <input type="radio" value="1" name="color"
                                                                class="variant-selector unit_checkbox">
                                                            <span
                                                                class="ui-variant--check">{{ $unit_plan_item->UnitName }}</span>
                                                        </label>
                                                    </li>
                                                    @php
                                                        $unit_no++;
                                                    @endphp
                                                @endforeach

                                            </ul>
                                        </div>
                                    @endif
                                    <div class="fdjhd row">
                                        <div style="height: 33px;" class="col-6 number-input">
                                            <button onclick="step_down()"></button>
                                            <input onkeyup="checkvaue()" id="quantity_in" class="quantity"
                                                min="0" name="quantity"
                                                value="{{ $ContInBasket == 0 ? 1 : $ContInBasket }}" type="number">
                                            <button onclick="step_up()" class="plus"></button>
                                        </div>

                                        <div class="col-6">
                                            @if ($ContInBasket > 0)
                                                <button type="button" onclick="ProductAddToBasket()"
                                                    class=" fkehf btn-primary-cm btn-with-icon mx-auto w-100">به روز رسانی
                                                    سبد</button>
                                            @else
                                                <button type="button" onclick="ProductAddToBasket()"
                                                    class=" fkehf btn-primary-cm btn-with-icon mx-auto w-100">افزودن
                                                    به سبد</button>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    @if (Auth::check())
                                        @php
                                            $alerted = App\Shop\ProductAlert::is_user_alerted_to_product(
                                                $TargetGood->id,
                                                Auth::id(),
                                            );
                                        @endphp
                                        <a id="product_alert" href="javascript:add_product_alert({{ $TargetGood->id }})"
                                            style="position: absolute;background-color:#336666 !important"
                                            class="btn-primary-cm bg-secondary btn-with-icon @if ($alerted) d-none @endif ">
                                            موجود شد به من خبر بده
                                        </a>
                                        <div class="@if (!$alerted) d-none @endif" id="product_alerted"
                                            style="background-color: #6ce3f1;border-radius:5px;padding:10px;font-weight: 800;">
                                            در صورت موجود شدن اطلاع رسانی خواهد شد
                                        </div>
                                    @else
                                        <a id="product_alert" href="{{ route('login') }}"
                                            style="position: absolute;background-color:#336666 !important"
                                            class="btn-primary-cm bg-secondary btn-with-icon  ">
                                            موجود شد به من خبر بده
                                        </a>
                                    @endif
                                @endif
                            </div>



                        </div>

                        @if ($ProductTarget->Remian > 0)
                            @if ($steps)
                                <hr>
                                <div class="product-collateral">

                                    <div class="tier-prices">
                                        <div class="title">
                                            <strong><i id="Products.TierPrices" class="EL"></i>هر چی بیشتر
                                                سفارش
                                                بدی
                                                قیمت
                                                کمتر
                                                میشه</strong>
                                        </div>
                                        <div class="table">
                                            <div class="tr">
                                                <div class="th">تعداد</div>
                                                @php
                                                    $inactive = false;
                                                @endphp
                                                @foreach ($price_plan_arr as $price_plan_item)
                                                    @if ($inactive)
                                                        @if ($loop->first)
                                                            <div id="top_row_{{ $price_plan_item->ToNumber }}"
                                                                class="td inactive">
                                                            @else
                                                                <div id="top_row_{{ $price_plan_item->ToNumber }}"
                                                                    class="td inactive">
                                                        @endif
                                                    @else
                                                        @if ($loop->first)
                                                            <div id="top_row_{{ $price_plan_item->ToNumber }}"
                                                                class="td active_td">
                                                            @else
                                                                <div id="top_row_{{ $price_plan_item->ToNumber }}"
                                                                    class="td">
                                                        @endif
                                                    @endif
                                                    @if ($price_plan_item->ToNumber > $max_qty)
                                                        @php
                                                            $inactive = true;
                                                        @endphp
                                                    @endif
                                                    @if ($loop->first)
                                                        پایه
                                                        @php
                                                            $count = $price_plan_item->ToNumber;
                                                        @endphp
                                                    @else
                                                        {{ $count }}+
                                                        @php
                                                            $count = $price_plan_item->ToNumber;
                                                        @endphp
                                                    @endif
                                            </div>
                            @endforeach
                        @endif
                        @endif



                    </div>

                    <div class="tr">
                        @php
                            $inactive = false;
                        @endphp
                        @foreach ($price_plan_arr as $price_plan_item)
                            @if ($inactive)
                                @if ($loop->first)
                                    <div class="th">مبلغ</div>
                                    <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td inactive">
                                    @else
                                        <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td inactive">
                                @endif
                            @else
                                @if ($loop->first)
                                    <div class="th">مبلغ</div>
                                    <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td active_td">
                                    @else
                                        <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td">
                                @endif
                            @endif
                            @if ($price_plan_item->ToNumber > $max_qty)
                                @php
                                    $inactive = true;
                                @endphp
                            @endif


                            {{ number_format($price_plan_item->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="dt-sn mb-5 px-0 dt-sl pt-0">
            <!-- Start tabs -->
            <section class="tabs-product-info mb-3 dt-sl">
                <div class="ah-tab-wrapper border-bottom dt-sl">
                    <div class="ah-tab dt-sl">
                        <a class="ah-tab-item" data-ah-tab-active="true" href=""><i
                                class="mdi mdi-glasses"></i>نقد
                            و بررسی</a>
                    </div>
                </div>
                <div class="ah-tab-content-wrapper product-info px-4 dt-sl">
                    <div class="ah-tab-content dt-sl" data-ah-tab-active="true">
                        <div class="section-title text-sm-title no-after-mb-0 dt-sl">
                            <h2>نقد و بررسی</h2>
                        </div>
                        <div class="description-product dt-sl mt-3 mb-3">
                            <div style="direction: rtl" class="container">
                                {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'MainText') !!}
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- End tabs -->
        </div>

        </div>
    </main>
@endsection
@section('end_script')
    <script>
        var $multiple = 1;

        function set_unit(multiple, unit_no) {
            $('.ui-variant-shape').removeClass('active');
            $('#span_unit_' + multiple).addClass('active');
            $('#quantity_in').val(1);
            $multiple = multiple;
            if ($paln_arr != null) {
                light_table();
            }
            $('.owl-thumb-item').removeClass('active');
            $('.unit_' + multiple).addClass('active');
            base_img_count = $('#base_img_count').val();
            var owl = $('.owl-carousel');
            index = parseInt(unit_no) + parseInt(base_img_count) - 1; // index of the slide you want to go to (0-based)  
            if (index == 1) {
                index = 0;
            }
            owl.trigger('to.owl.carousel', [index,
                300
            ]); // Change to slide with transition speed of 300ms  



        }
    </script>
    <script>
        $(window).on('load', function() {
            light_table();
        });
    </script>
    <script>
        window.RemainQty = <?php echo $ProductTarget->Remian; ?>;
        window.ProductId = <?php echo $ProductTarget->id; ?>;
        window.wgid = <?php echo $ProductTarget->wgid; ?>;
        window.Price = <?php echo $Price; ?>;
        window.BasePrice = <?php echo $BasePrice; ?>;
        window.Benefit = window.BasePrice - window.Price;
        window.Qty = 1;
        window.multiple = 1;
        window.Tashim = 0;





        function add_product_alert(product_id) {
            $CountValu = $('#quantity_in').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/ajax', {
                    ajax: true,
                    AjaxType: 'AddProductAlert',
                    ProductID: product_id
                },

                function(data, status) {
                    if (data) {
                        $('#product_alerted').removeClass('d-none');
                        $('#product_alert').addClass('d-none');
                    } else {
                        alert('مشکل در برقرار ارتباط لطفا دقایقی دیگر تلاش کنید!');

                    }
                });


        }

        function ProductAddToBasket() {
            $CountValu = $('#quantity_in').val();
            $CountValu = $CountValu * $multiple;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'AddToBasket',
                    ProductId: window.ProductId,
                    pw_id: window.wgid,
                    OrderQty: $CountValu,
                    Tashim: window.Tashim
                },

                function(data, status) {
                    if (data == 'typemismatch') {
                        alert('کالای شما با کالای سبدخریدتان مغایرت دارد.ابتدا سبدخرید خود را تسویه فرمایید!');
                    } else {
                        $('#basket_on_top').html(data);
                        $('#basket_on_top').removeClass('nested');
                        //  document.getElementById("basketnumber").innerHTML = data;
                        $("#basketnumber").removeClass("nested");
                        location.reload();
                    }
                });


        }

        function reserveTashim($ProductId, $PWID, $Tashim) {
            window.Tashim = $Tashim;
        }


        function view_stepper() {
            $('#add_to_basket_continner').addClass('nested');
            $('#main_stepper').removeClass('nested');
            $('#cont_value').val('1');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'AddToBasketStepper',
                    ProductId: window.ProductId,
                    pw_id: window.wgid,
                    OrderQty: 1,
                },
                function(data, status) {
                    if (data == 'typemismatch') {
                        alert('کالای شما با کالای سبدخریدتان مغایرت دارد.ابتدا سبدخرید خود را تسویه فرمایید!');
                    } else {
                        $('#basket_on_top').html(data);
                        $('#basket_on_top').removeClass('nested');
                        document.getElementById("basketnumber").innerHTML = data;
                        $("#basketnumber").removeClass("nested");
                    }
                });
        }
    </script>
    <script>
        $max_qty = {{ $max_qty }};
        $price_type = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
        $old_number = 1;
        $BasePrice = {{ $BasePrice }};
        $plan = <?php echo json_encode($PricePlan); ?>;

        if ($plan != '') {
            var $paln_arr = jQuery.parseJSON($plan);
        } else {
            var $paln_arr = null;
        }
        //ToNumber
        //Price


        function checkvaue() {

            curent_qty = $('#quantity_in').val();
            curent_qty = $multiple * curent_qty;
            if (curent_qty > $max_qty) {
                $('#quantity_in').val($max_qty);

            }
        }

        function change_number() {
            $('#dis_percent').html();
            percent = Math.round((($BasePrice - $new_price) * 100) / $BasePrice);
            $('#dis_percent').html(percent + '%');
            $('#target_price').html(number_format($new_price / $price_type));

        }

        function light_table() {
            target_val = $('#quantity_in').val();
            target_val = target_val * $multiple;
            $.each($paln_arr, function(key, value) {
                if (value.ToNumber > parseInt(target_val)) {
                    $target_number = value.ToNumber;
                    $new_price = value.Price;
                    return false; // breaks
                }
            });
            if ($old_number != $target_number) {
                $('.td').removeClass('active_td');
                $('#top_row_' + $target_number).addClass('active_td');
                $('#down_row_' + $target_number).addClass('active_td');
                $old_number = $target_number;
                change_number();
            }


        }

        function step_up() {
            curent_qty = $('#quantity_in').val();
            curent_qty = curent_qty * $multiple;
            if (curent_qty < $max_qty) {
                document.getElementById("quantity_in").stepUp();
                if ($paln_arr != null) {
                    light_table();
                }

            } else {
                alert('اتمام موجودی');

            }

        }

        function step_down() {
            document.getElementById("quantity_in").stepDown();
            if ($paln_arr != null) {
                light_table();
            }
        }
    </script>
@endsection
