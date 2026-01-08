@php
    $Persian = new App\Functions\persian();
    $ShopInfo = $Product->GetProductShop($TargetGood->id);
    $ContInBasket = app\Http\Controllers\woocommerce\product::IsProductInBasket($ProductTarget->id, $ProductTarget->wgid);
    $Price = $Product->GetTargetPrice($ProductTarget->Price, $TargetGood->tax_status);
    $BasePrice = $Product->GetTargetPrice($ProductTarget->BasePrice, $TargetGood->tax_status);
@endphp
@extends('Layouts.Theme1.MainLayout')
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

    @if ($PricePlan == null)
        <meta name="productprice" content="{{ $Price / 10 }}">
    @else
        <meta name="productprice" content=" {{ \App\Http\Controllers\woocommerce\product::GetMinPrice($PricePlan) / 10 }}">
    @endif
    <meta name="productoldprice" content="{{ $BasePrice / 10 }}">
    @if ($ProductTarget->Remian > 0)
        <meta name="availability" content="instock">
    @else
        <meta name="availability" content="outofstock">
    @endif
@endsection
@section('MainContent')
    <nav class="breadcrumb-nav container">
        <ul class="breadcrumb bb-no">
            <li><a href="{{ route('home') }}">صفحه اصلی </a></li>
            <li>محصولات </li>
        </ul>

    </nav>

    @php
        $Shop = $Product->GetProductShop($TargetGood->id);
        if ($Shop == null) {
            $ShopLogo = \App\myappenv::FavIcon;
            $ShopName = \App\myappenv::CenterName;
        } else {
            $ShopLogo = $Shop->Pic;
            $ShopName = $Shop->Name;
        }
    @endphp
    <div class="page-content">
        <div class="container">
            <div class="row gutter-lg">
                <div class="main-content">
                    <div class="product product-single row mb-2">
                        <div class="col-md-6 mb-4 mb-md-8">
                            <div class="product-gallery product-gallery-sticky">
                                <div
                                    class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">

                                    @php
                                        $PicSource = json_decode($TargetGood->ImgURL);

                                    @endphp

                                    @foreach ($PicSource as $PicItem)
                                        @if ($PicItem->PicUrl != null)
                                            <figure class="product-image">
                                                <img src="{{ $PicItem->PicUrl }}" data-zoom-image="{{ $PicItem->PicUrl }}"
                                                    alt="{{ $TargetGood->NameFa }}" width="800" height="900">
                                            </figure>
                                        @endif
                                    @endforeach

                                </div>
                                <div class="product-label-group">
                                    @if ($BasePrice != $Price)
                                        <label class="product-label label-discount">
                                            {{ round((($BasePrice - $Price) / $BasePrice) * 100) }}
                                            % تخفیف </label>
                                    @endif

                                </div>
                                <div class="product-thumbs-wrap">
                                    <div class="product-thumbs row cols-4 gutter-sm">
                                        @foreach ($PicSource as $PicItem)
                                            @if ($PicItem->PicUrl != null)
                                                <div class="product-thumb active">
                                                    <img src="{{ $PicItem->PicUrl }}" alt="{{ $TargetGood->NameFa }}"
                                                        width="800" height="900">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <button class="thumb-up disabled"><i class="w-icon-angle-left"></i></button>
                                    <button class="thumb-down disabled"><i class="w-icon-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-6 mb-md-8">
                            <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                <h1 class="product-title"> {{ $TargetGood->NameFa }}</h1>
                                <div class="product-bm-wrapper">
                                    <figure class="brand">
                                        <img src="{{ $ShopLogo }}" alt="{{ $ShopName }}" width="106"
                                            height="48" />
                                    </figure>
                                    <div class="product-meta">
                                        <div class="product-categories">
                                            فروشنده:
                                            <span class="product-category"><a href="#">{{ $ShopName }}
                                                </a></span>
                                        </div>
                                        <div class="product-sku">
                                            کد محصول: <span>{{ $ProductTarget->SKU }}</span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="product-divider">

                                <div class="product-price">
                                    @if ($ProductTarget->Remian > 0)
                                        @if ($BasePrice != $Price)
                                            <div class="discount_main">
                                                <del class="old-price">
                                                    {{ number_format($BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                </del>
                                            </div>
                                        @endif
                                        <div class="discount_main">
                                            @if ($ProductTarget->MinPrice != 0)
                                                @php
                                                    $MinPrice = $Product->GetTargetPrice($ProductTarget->MinPrice, $ProductTarget->tax_status);
                                                    $MaxPrice = $Product->GetTargetPrice($ProductTarget->MaxPrice, $ProductTarget->tax_status);
                                                @endphp

                                                @if ($ProductTarget->MinPrice == $ProductTarget->MaxPrice || $ProductTarget->MaxPrice == 0)
                                                    <ins class="new-price">
                                                        {{ number_format($MinPrice/ App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @else
                                                    <ins class="new-price"> از
                                                        {{ number_format($MinPrice/ App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        تا
                                                        {{ number_format($MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @endif

                                                <input class="nested" id="PricePlan" value="{{ $PricePlan }}"
                                                    type="text">
                                            @else
                                                <ins class="new-price">
                                                    {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                </ins>
                                                <input class="nested" id="PricePlan" value="no" type="text">
                                            @endif
                                        </div>
                                    @endif




                                </div>


                                <div class="product-short-desc">
                                    <ul class="list-type-check list-style-none">
                                        <li>{{ $ProductTarget->Description }}</li>

                                    </ul>
                                    <hr>
                                    @if ($ProductTarget->extra != null)
                                        <ul class="list-type-check list-style-none">
                                            <li>{{ $ProductTarget->extra }}</li>

                                        </ul>
                                    @endif
                                    @if ($showTable)
                                        @php
                                            $sourceIndex = $Product->GetProductIndexes($TargetGood->id);

                                        @endphp
                                        @if (count($sourceIndex) > 0)
                                            <h6 class="title">ویژگی‌ها</h6>
                                            @foreach ($sourceIndex as $ProductIndex)
                                                <div class="product-form product-variation-form product-color-swatch">
                                                    <label>{{ $ProductIndex->l2name }}: </label>
                                                    <a style="    font-size: 14px;"> {{ $ProductIndex->l3name }}</a>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                    @if ($Tashims != [])
                                        <div class="product-form product-variation-form product-size-swatch">
                                            <h6 class="title">روش پرداخت</h6>

                                            <div class="flex-wrap d-flex align-items-center product-variations">
                                                @php
                                                    $NewDefualt = false;
                                                    foreach ($Tashims as $TashimItem) {
                                                        if ($TashimItem->FormolStr == 'Default') {
                                                            $NewDefualt = true;
                                                        }
                                                    }
                                                @endphp

                                                @foreach ($Tashims as $TashimItem)
                                                    @if ($loop->first && !$NewDefualt)
                                                        <a href="#"
                                                            onclick="reserveTashim({{ $ProductTarget->id }},{{ $ProductTarget->wgid }},0)"
                                                            class="size">پرداخت نقدی </a>
                                                    @endif
                                                    @if ($TashimItem->Operation == 1)
                                                        <a href="#"
                                                            onclick="reserveTashim({{ $ProductTarget->id }},{{ $ProductTarget->wgid }},{{ $TashimItem->id }})"
                                                            class="size">{{ $TashimItem->Name }} </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="fix-bottom product-sticky-content sticky-content">
                                    <div class="product-form container">
                                        @if ($ProductTarget->MinPrice != 0)
                                            @if ($ContInBasket > 0)
                                                <button style="float: left;" onclick="view_stepper()"id="AddToBasketbtn"
                                                    class="btn btn-primary btn-cart" type="button" name="submit"
                                                    value="{{ $ProductTarget->id }}">
                                                    <i class="w-icon-cart"></i>
                                                    <span> درخواست استعلام</span>
                                                </button>
                                            @else
                                                <button style="float: left;" onclick="view_stepper()"id="AddToBasketbtn"
                                                    class="btn btn-primary btn-cart" type="button" name="submit"
                                                    value="{{ $ProductTarget->id }}">
                                                    <i class="w-icon-cart"></i>
                                                    <span> درخواست استعلام </span>
                                                </button>
                                            @endif
                                        @else
                                            @if ($ContInBasket > 0)

                                                <a href="{{ route('checkout') }}" class="btn btn-warning  ">
                                                    <i class="w-icon-cart"></i>
                                                    <span>مشاهده سبد خرید </span>
                                                </a>


                                                <a>
                                                    <div class="alert alert-icon alert-success alert-bg alert-inline">
                                                        این محصول در سبد خرید شما قرار گرفته است</div>
                                                </a>
                                            @else
                                                @if ($ProductTarget->Remian > 0)
                                                    <div class="product-qty-form">
                                                        <div class="input-group">
                                                            @if ($ContInBasket > 1)
                                                                <input id="steperinput" class="quantity form-control"
                                                                    type="number" min="1"
                                                                    value="{{ $ContInBasket }}"
                                                                    max="{{ $ProductTarget->Remian }}">
                                                            @else
                                                                <input id="steperinput" class="quantity form-control"
                                                                    type="number" min="1"
                                                                    max="{{ $ProductTarget->Remian }}">
                                                            @endif

                                                            <button class="quantity-plus w-icon-plus"></button>
                                                            <button class="quantity-minus w-icon-minus"></button>
                                                        </div>
                                                    </div>

                                                    <button onclick="ProductAddToBasket()"
                                                        class="btn btn-primary btn-cart">
                                                        <i class="w-icon-cart"></i>
                                                        <span>افزودن به سبد </span>
                                                    </button>
                                                @else
                                                    <div class="product-qty-form">
                                                        <div class="input-group">
                                                            @if ($ContInBasket > 1)
                                                                <input id="steperinput" class="quantity form-control"
                                                                    type="number" min="1"
                                                                    value="{{ $ContInBasket }}"
                                                                    max="{{ $ProductTarget->Remian }}">
                                                            @else
                                                                <input id="steperinput" class="quantity form-control"
                                                                    type="number" min="1"
                                                                    max="{{ $ProductTarget->Remian }}">
                                                            @endif

                                                            <button class="quantity-plus w-icon-plus"></button>
                                                            <button class="quantity-minus w-icon-minus"></button>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-cart disabled" disabled>
                                                        <i class="w-icon-cart"></i>
                                                        <span>ناموجود </span>
                                                    </button>
                                    </div>

                                    <div id="addtobasketdiv" class="form-group row">
                                        <h6>
                                            برای اطلاع از قیمت و موجودی با شماره <a style="color: red"
                                                href="tel:021-28111119">{{ App\myappenv::InvoiceData['Phone'] }}
                                            </a>تماس بگیرید
                                        </h6>
                                    </div>
                                    @endif
                                    @endif
                                    @endif
                                </div>
                            </div>

                            <div class="social-links-wrapper">
                                <div class="social-links">
                                    <div class="">
                                        <div class="">
                                            <a class="social" target="_blank"
                                                href="whatsapp://send?text={{ url()->current() }}"> <svg width="29"
                                                    height="30" viewBox="0 0 24 25" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M20.5039 3.50391C18.2461 1.24609 15.2461 0 12.0508 0C5.46484 0 0.101562 5.35937 0.101562 11.9453C0.097656 14.0508 0.648438 16.1055 1.69531 17.918L0 24.1094L6.33594 22.4453C8.07813 23.3984 10.0469 23.8984 12.0469 23.9023H12.0508C18.6367 23.9023 23.9961 18.543 24 11.9531C24 8.76172 22.7578 5.76172 20.5039 3.50391ZM12.0508 21.8828H12.0469C10.2656 21.8828 8.51563 21.4023 6.99219 20.5L6.62891 20.2852L2.86719 21.2695L3.87109 17.6055L3.63672 17.2305C2.64063 15.6484 2.11719 13.8203 2.11719 11.9453C2.11719 6.47266 6.57422 2.01953 12.0547 2.01953C14.707 2.01953 17.1992 3.05469 19.0742 4.92969C20.9492 6.80859 21.9805 9.30078 21.9805 11.9531C21.9805 17.4297 17.5234 21.8828 12.0508 21.8828ZM17.4961 14.4453C17.1992 14.2969 15.7305 13.5742 15.457 13.4766C15.1836 13.375 14.9844 13.3281 14.7852 13.625C14.5859 13.9258 14.0156 14.5977 13.8398 14.7969C13.668 14.9922 13.4922 15.0195 13.1953 14.8711C12.8945 14.7227 11.9336 14.4062 10.793 13.3867C9.90625 12.5977 9.30469 11.6172 9.13281 11.3203C8.95703 11.0195 9.11328 10.8594 9.26172 10.7109C9.39844 10.5781 9.5625 10.3633 9.71094 10.1875C9.85938 10.0156 9.91016 9.89063 10.0117 9.69141C10.1094 9.49219 10.0586 9.31641 9.98438 9.16797C9.91016 9.01953 9.3125 7.54687 9.0625 6.94922C8.82031 6.36719 8.57422 6.44922 8.39062 6.4375C8.21875 6.42969 8.01953 6.42969 7.82031 6.42969C7.62109 6.42969 7.29688 6.50391 7.02344 6.80469C6.75 7.10156 5.98047 7.82422 5.98047 9.29297C5.98047 10.7617 7.05078 12.1836 7.19922 12.3828C7.34766 12.5781 9.30469 15.5937 12.3008 16.8867C13.0117 17.1953 13.5664 17.3789 14 17.5156C14.7148 17.7422 15.3672 17.7109 15.8828 17.6367C16.457 17.5508 17.6484 16.9141 17.8984 16.2148C18.1445 15.5195 18.1445 14.9219 18.0703 14.7969C17.9961 14.6719 17.7969 14.5977 17.4961 14.4453Z"
                                                        fill="#50CD5E" />
                                                </svg></a>
                                            <a class="social" target="_blank"
                                                href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}"><svg
                                                    width="30" height="30" viewBox="0 0 30 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M8.20358 24.7852H6.44577C5.79849 24.7852 5.2739 24.2606 5.2739 23.6133V12.7148C5.2739 12.0676 5.79849 11.543 6.44577 11.543H8.20358C8.85086 11.543 9.37546 12.0676 9.37546 12.7148V23.6133C9.37546 24.2606 8.85086 24.7852 8.20358 24.7852ZM9.7847 7.32399C9.7847 5.99808 8.70895 4.92188 7.38373 4.92188C6.05347 4.92188 4.98047 5.99808 4.98047 7.32399C4.98047 8.65036 6.05347 9.72656 7.38373 9.72656C8.70895 9.72656 9.7847 8.65036 9.7847 7.32399ZM24.7266 23.6133V17.4998C24.7266 13.9451 23.9756 11.3086 19.823 11.3086C17.8276 11.3086 16.4882 12.3065 15.9414 13.3443H15.9375V12.7148C15.9375 12.0676 15.4129 11.543 14.7656 11.543H13.125C12.4777 11.543 11.9531 12.0676 11.9531 12.7148V23.6133C11.9531 24.2606 12.4777 24.7852 13.125 24.7852H14.7656C15.4129 24.7852 15.9375 24.2606 15.9375 23.6133V18.2103C15.9375 16.4884 16.3758 14.8203 18.5101 14.8203C20.6154 14.8203 20.6836 16.7894 20.6836 18.3197V23.6133C20.6836 24.2606 21.2082 24.7852 21.8555 24.7852H23.5547C24.202 24.7852 24.7266 24.2606 24.7266 23.6133ZM30 25.3125C30 24.6652 29.4754 24.1406 28.8281 24.1406C28.1808 24.1406 27.6562 24.6652 27.6562 25.3125C27.6562 26.6048 26.6048 27.6562 25.3125 27.6562H4.6875C3.39523 27.6562 2.34375 26.6048 2.34375 25.3125V4.6875C2.34375 3.39523 3.39523 2.34375 4.6875 2.34375H25.3125C26.6048 2.34375 27.6562 3.39523 27.6562 4.6875V19.3945C27.6562 20.0418 28.1808 20.5664 28.8281 20.5664C29.4754 20.5664 30 20.0418 30 19.3945V4.6875C30 2.10274 27.8973 0 25.3125 0H4.6875C2.10274 0 0 2.10274 0 4.6875V25.3125C0 27.8973 2.10274 30 4.6875 30H25.3125C27.8973 30 30 27.8973 30 25.3125Z"
                                                        fill="url(#paint0_linear_3342_10)" />
                                                    <defs>
                                                        <linearGradient id="paint0_linear_3342_10" x1="0"
                                                            y1="15" x2="30" y2="15"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#00F2FE" />
                                                            <stop offset="0.0208" stop-color="#03EFFE" />
                                                            <stop offset="0.2931" stop-color="#24D2FE" />
                                                            <stop offset="0.5538" stop-color="#3CBDFE" />
                                                            <stop offset="0.7956" stop-color="#4AB0FE" />
                                                            <stop offset="1" stop-color="#4FACFE" />
                                                        </linearGradient>
                                                    </defs>
                                                </svg></a>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="tab tab-nav-boxed tab-nav-underline product-tabs mt-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#product-tab-description" class="nav-link active">توضیحات </a>
                            </li>
                            <li class="nav-item">
                                <a href="#product-tab-specification" class="nav-link">مشخصات </a>
                            </li>
                            <li class="nav-item">
                                <a href="#product-tab-reviews" class="nav-link">دیدگاه ها
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#product-tab-vendor" class="nav-link">اطلاعات فروشنده</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="product-tab-description">
                                <div class="row mb-4">

                                    {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'MainText') !!}


                                </div>

                            </div>
                            <div class="tab-pane" id="product-tab-specification">

                                {!! App\Http\Controllers\woocommerce\product::GetJsonFeild($ProductTarget->MainDescription, 'DiscText') !!}


                            </div>
                            <div class="tab-pane" id="product-tab-reviews">
                                <div class="row mb-4">
                                    <div class="card">

                                        <div class="card-body collapsed" id="product-tab-reviews">
                                            <div class="row mb-4">

                                                <div class="col-xl-8 col-lg-7 mb-4">
                                                    <div class="review-form-wrapper">

                                                        <p class="font-weight-bolder mb-3"> دیگران را با نوشتن نظرات خود،
                                                            برای انتخاب این محصول راهنمایی کنید.

                                                        </p>
                                                        @if (Auth::check())
                                                            <form method="post" class="review-form">
                                                                @csrf
                                                                <textarea onkeyup="how_many_chars()" name="comment"cols="30" rows="6"
                                                                    placeholder="نظر خود را اینجا بنویسید..." class="form-control" id="review"></textarea>

                                                                <div class="row gutter-md">

                                                                    <div class="col-md-6">
                                                                        <input type="text" name="name"
                                                                            class="form-control" required
                                                                            placeholder="نام شما" id="author">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="email" name="email"
                                                                            class="form-control" required
                                                                            placeholder="ایمیل شما" id="email_1">
                                                                    </div>
                                                                </div>
                                                                <button type="submit" name="submit" value="AddComment"
                                                                    class="btn btn-primary">ارسال نظر </button>
                                                            </form>
                                                        @else
                                                            <a
                                                                href="{{ route('login') }}"class="btn btn-primary btn-outline btn-ellipse">
                                                                ثبت دیدگاه</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 mb-4">
                                                    <div class="review-form-wrapper mt-10">
                                                        <div class="widget-icon-box ">
                                                            هرگونه نقد و نظر در خصوص سایت، مشکلات دریافت خدمات و درخواست
                                                            را
                                                            در بخش پیام ها
                                                            و
                                                            یا
                                                            با شماره‌ی 28111119 - ۰۲۱ در میان بگذارید
                                                            و
                                                            از نوشتن آن‌ها در بخش نظرات خودداری کنید.
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                            <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
                                                {{--  <ul class="nav nav-tabs" role="tablist">
                                                   <li class="nav-item">
                                                        <a href="#show-all" class="nav-link active">نمایش همه </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#helpful-positive" class="nav-link">مفیدترین مثبت</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#helpful-negative" class="nav-link">مفیدترین منفی</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#highest-rating" class="nav-link">بالاترین رتبه </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#lowest-rating" class="nav-link">پایین ترین رتبه </a>
                                                    </li>
                                                </ul> --}}
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="show-all">
                                                        <ul class="comments list-style-none">
                                                            @if (count($PostComments) > 0)
                                                                @foreach ($PostComments as $PostCommentsItem)
                                                                    <li class="comment">
                                                                        <div class="comment-body">
                                                                            <figure class="comment-avatar">
                                                                                <img src="{{ \App\myappenv::LoginUserAvatarPic }}"
                                                                                    alt="{{ $PostCommentsItem->name }}pic"
                                                                                    width="90" height="90">
                                                                            </figure>
                                                                            <div class="comment-content">
                                                                                <h4 class="comment-author">
                                                                                    <a>{{ $PostCommentsItem->name }}
                                                                                    </a>
                                                                                    <span class="comment-date">
                                                                                        {{ $Persian->MyPersianDate($PostCommentsItem->created_at) }}
                                                                                    </span>
                                                                                </h4>

                                                                                <p>
                                                                                    {{ $PostCommentsItem->message }}
                                                                                </p>

                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            @endif

                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="product-tab-vendor">
                                <div class="row mb-3">

                                    <div class="col-md-6 pl-2 pl-md-6 mb-4">
                                        <div class="vendor-user">
                                            <figure class="vendor-logo mr-4">
                                                <a href="#">
                                                    <img src="{{ $Shop->Pic }}" alt="{{ $Shop->Name }}"
                                                        width="80" height="80" />
                                                </a>
                                            </figure>
                                            <div>
                                                <div class="vendor-name"><a href="#">{{ $Shop->Name }}</a>
                                                </div>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 90%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="vendor-info list-style-none pl-0">
                                            <li class="store-name">
                                                <label>نام فروشگاه :</label>
                                                <span class="detail">{{ $Shop->Name }}</span>
                                            </li>
                                            <li class="store-address">
                                                <label>آدرس :</label>
                                                <span class="detail">{{ $Shop->Address }}</span>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                                {!! $Shop->Description !!}
                            </div>

                        </div>
                    </div>

                </div>

                @include('Layouts.Theme1.objects.ProductListItems')

            </div>

            @if (\App\myappenv::MainOwner == 'kookbaz')
                <aside id="tbl" class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                </aside>
            @endif
        </div>
        <!-- End of Main Content -->
        {{-- <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                    <div class="sidebar-overlay"></div>
                    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                    <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
                    <div class="sidebar-content scrollable">
                        {!! App\Functions\AppSetting::getcache('BuyCondition') !!}
                    </div>
                </aside> --}}

        <!-- End of Sidebar -->
    </div>

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

        function valid_qty() {
            $CountValu = $('#steperinput').val();
            if (window.RemainQty == $CountValu) {
                alert("درخواست شما بیشتر از موجودی انبار است");
            }
        }

        function ProductAddToBasket() {
            $CountValu = $('#steperinput').val();

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
                        document.getElementById("basketnumber").innerHTML = data;
                        $("#basketnumber").removeClass("nested");
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

@endsection
@section('bottom-js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('', {
                    ajax: true,
                    procedure: 'tblview',
                },
                function(data, status) {
                    $('#tbl').html(data);

                });

        });
    </script>
    <script>
        window.ProductId = <?php echo $ProductTarget->id; ?>;

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('', {
                    ajax: true,
                    ProductId: window.ProductId,
                    procedure: 'userindex',
                },
                function(data, status) {
                    // alert('salam');

                });

        });
    </script>
@endsection
