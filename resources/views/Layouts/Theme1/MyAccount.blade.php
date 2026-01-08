@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')

@section('MainContent')
    <style>
        #wallet_item {
            display: flex;
            justify-content: space-between;
        }

        .loader276 {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: -0.125em;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin .75s linear infinite;
        }
    </style>
    <div class="my-account">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="demo1.html">صفحه اصلی </a></li>
                    <li>حساب کاربری من</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->
        <!-- begin::modal -->


        <!-- end::modal -->
        <!-- Start of PageContent -->
        <div class="page-content pt-2">
            <div class="container">
                <div class="tab tab-vertical row gutter-lg">
                    <ul class="nav nav-tabs mb-6" role="tablist">
                        <li class="nav-item">
                            <a href="#account-dashboard" class="nav-link active">داشبورد </a>
                        </li>
                        <li class="nav-item">
                            <a href="#account-details" class="nav-link">جزئیات حساب کاربری </a>
                        </li>
                        <li class="nav-item">
                            <a href="#account-orders" class="nav-link">سفارشات </a>
                        </li>

                        <li class="nav-item">
                            <a href="#account-addresses" class="nav-link">آدرس‌ها </a>
                        </li>

                        <li class="nav-item">
                            <a href="#account-ticket" class="nav-link">پیام ها </a>
                        </li>
                        <li class="nav-item">
                            <a href="#account-wallet" class="nav-link" onclick="ShowItems('walet')"> کیف پول </a>
                        </li>
                        {{--   <li class="nav-item">
                            <a href="#account-password" class="nav-link"> رمز عبور </a>
                        </li> --}}
                        <li class="link-item">
                            <a href="{{ route('logout') }}">خروج</a>
                        </li>
                    </ul>

                    <div class="tab-content mb-6">
                        <div class="tab-pane active in" id="account-dashboard">
                            <p class="greeting"> سلام
                                <span class="text-dark font-weight-bold">{{ Auth::user()->Name }} {{ Auth::user()->Family }}
                                    @if (Auth::user()->CreditePlan == 1)
                                        <img class="line-btn" src="{{ asset('assets/images/medal.png') }}" alt="medal">
                                        <small>کاربر ویژه</small>
                                    @endif
                                </span>

                            </p>
                            @if (\App\myappenv::MainOwner == 'kookbaz')
                                @if (Auth::user()->CreditePlan == null)
                                    @if (Auth::user()->MelliID == null)
                                        <h6 class=" text-secondary font-size-md font-weight-bolder p-relative mr-3 lh-2">

                                            برای تکمیل اطلاعات ؛ استفاده از خدمات فروش اقساطی
                                            و کاربری ویژه
                                            (در صورتی که عضو سازمان بازنشستگی
                                            نیروهای مسلح هستید) کد ملی خود را ثبت کنید
                                        </h6>




                                        <h6 class="lh-2">*
                                            هر کد ملی تنها برای یک شماره تماس قابل ثبت است و یک شخص با کد ملی خود
                                            نمی‌تواند
                                            با 2 شماره تماس یا بیشتر در سامانه ثبت‌نام نماید.
                                        </h6>
                                        <h6 class="lh-2">*
                                            شماره تماس وارد شده هنگام ثبت نام باید با شماره تماس ثبت شده در سامانه
                                            بازنشستگان یکسان باشد. در صورت مغایرت باید با پشتیبانی سایت کوکباز تماس حاصل
                                            نمایید. </h6>
                                        <h6 class="lh-2">*
                                            در صورت هر گونه مشکل در قسمت کاربر ویژه شما میتوانید در قسمت پیام ها با واحد
                                            فنی
                                            در میان بگذارید
                                        </h6>
                                        <div class="">
                                            @if (Auth::user()->MelliID == null)
                                                <form method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mellicode"> کدملی *</label>
                                                                <input type="number" required
                                                                    class="form-control form-control-md" name="mellicode">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <small class="important">لطفا کد ملی خود را به صورت دقیق با صفحه
                                                        کلید لاتین
                                                        وارد
                                                        فرمایید!</small>
                                                    <hr>
                                                    <button class="btn btn-dark btn-rounded btn-sm mb-4" name="submit"
                                                        value="UpdateMellidCode" type="submit">
                                                        ثبت کد ملی</button>



                                                </form>
                                            @else
                                            @endif
                                        </div>
                                    @else
                                        <p id="textspcial"
                                            class="text-secondary font-size-normal  font-weight-bolder p-relative mr-3 lh-2">

                                            جهت استعلام اطلاعات از سامانه بازنشستگان و تایید کاربری ویژه کلیک کنید.

                                        </p>
                                        <button onclick="tavanpardakhtfn()" id="btm1"
                                            class="btn btn-dark btn-rounded btn-sm mb-4" type="button">تایید کد
                                            هویت</button>
                                    @endif
                                @else
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                            <a href="#account-orders" class="link-to-tab">
                                                <div class="icon-box text-center">
                                                    <span class="icon-box-icon icon-orders">
                                                        <i class="w-icon-orders"></i>
                                                    </span>
                                                    <div class="icon-box-content">
                                                        <p class="text-uppercase mb-0">سفارشات </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                            <a href="#account-downloads" class="link-to-tab">
                                                <div class="icon-box text-center">
                                                    <span class="icon-box-icon icon-download">
                                                        <i class="w-icon-star-square-full"></i> </span>
                                                    <div class="icon-box-content">
                                                        <p class="text-uppercase mb-0">کاربر ویژه </p>
                                                    </div>

                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                            <a href="#account-addresses" class="link-to-tab">
                                                <div class="icon-box text-center">
                                                    <span class="icon-box-icon icon-address">
                                                        <i class="w-icon-map-marker"></i>
                                                    </span>
                                                    <div class="icon-box-content">
                                                        <p class="text-uppercase mb-0">آدرسها </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                            <a href="#account-details" class="link-to-tab">
                                                <div class="icon-box text-center">
                                                    <span class="icon-box-icon icon-account">
                                                        <i class="w-icon-user"></i>
                                                    </span>
                                                    <div class="icon-box-content">
                                                        <p class="text-uppercase mb-0">جزئیات حساب </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                            <a href="#account-ticket" class="link-to-tab">
                                                <div class="icon-box text-center">
                                                    <span class="icon-box-icon icon-wishlist">
                                                        <i class="w-icon-heart"></i>
                                                    </span>
                                                    <div class="icon-box-content">
                                                        <p class="text-uppercase mb-0">پیام ها </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                            <a href="{{ route('logout') }}">
                                                <div class="icon-box text-center">
                                                    <span class="icon-box-icon icon-logout">
                                                        <i class="w-icon-logout"></i>
                                                    </span>
                                                    <div class="icon-box-content">

                                                        <p class="text-uppercase mb-0">خروج </p>

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if (Auth::user()->CreditePlan == 1)
                                @else
                                    <div id="loader_tavan" class=" nested">
                                        <div class="d-flex justify-content-center">
                                            <div class="loader276 "></div>
                                            <p class="font-weight-bolder font-size-normal ">
                                                در حال دریافت اطلاعات از مرکز لطفا منتظر بمانید
                                            </p>
                                        </div>
                                    </div>

                                    <div id="tavan" class="nested">
                                        <form method="POST">
                                            @csrf
                                            <p class="font-weight-bold font-size-normal "
                                                style="font-size: 17px;font-weight: 500;position: relative;margin-left: 6px;">
                                                کاربر گرامی لطفا کد اعتباری سنجی پیامک شده به شماره موبایل ثبت شده را
                                                وارد نمایید </p>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group">
                                                        <input type="number" required name="confirmcode"
                                                            class="form-control credit">
                                                    </div>
                                                </div>

                                            </div>
                                            <button class="btn btn-dark btn-rounded btn-sm mb-4" name="submit"
                                                value="tavnpardakht" type="submit">تایید کد
                                                اعتبارسنجی</button>

                                        </form>

                                    </div>


                                    <div id="notvalidtavan" class="nested">
                                        <div class="col-md-12">
                                            <div class="alert alert-icon alert-error alert-bg alert-inline">
                                                <h4 class="alert-title">
                                                </h4> کدملی مورد نظر در سامانه یافت نشد
                                                لطفا طی 24 ساعت آینده مجددا تلاش کنید
                                                و یا با پشتیبانی به شماره 0212811119 تماس بگیرید
                                            </div>
                                        </div>


                                        </form>

                                    </div>
                                @endif
                            @else
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                        <a href="#account-orders" class="link-to-tab">
                                            <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-orders">
                                                    <i class="w-icon-orders"></i>
                                                </span>
                                                <div class="icon-box-content">
                                                    <p class="text-uppercase mb-0">سفارشات </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                        <a href="#account-downloads" class="link-to-tab">
                                            <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-download">
                                                    <i class="w-icon-star-square-full"></i> </span>
                                                <div class="icon-box-content">
                                                    <p class="text-uppercase mb-0">کاربر ویژه </p>
                                                </div>

                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                        <a href="#account-addresses" class="link-to-tab">
                                            <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-address">
                                                    <i class="w-icon-map-marker"></i>
                                                </span>
                                                <div class="icon-box-content">
                                                    <p class="text-uppercase mb-0">آدرسها </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                        <a href="#account-details" class="link-to-tab">
                                            <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-account">
                                                    <i class="w-icon-user"></i>
                                                </span>
                                                <div class="icon-box-content">
                                                    <p class="text-uppercase mb-0">جزئیات حساب </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                        <a href="#account-ticket" class="link-to-tab">
                                            <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-wishlist">
                                                    <i class="w-icon-heart"></i>
                                                </span>
                                                <div class="icon-box-content">
                                                    <p class="text-uppercase mb-0">پیام ها </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                        <a href="{{ route('logout') }}">
                                            <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-logout">
                                                    <i class="w-icon-logout"></i>
                                                </span>
                                                <div class="icon-box-content">

                                                    <p class="text-uppercase mb-0">خروج </p>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane mb-4" id="account-orders">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-orders">
                                    <i class="w-icon-orders"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">سفارشات </h4>
                                </div>
                            </div>
                            @if (sizeof($Orders) == 0)
                                <p>تا کنون سفارشی ثبت نشده است!</p>
                            @endif

                            <table class="shop-table account-orders-table mb-6">
                                <thead>
                                    <tr>
                                        <th class="order-id">کد سفارش</th>
                                        <th class="order-date">تاریخ </th>
                                        <th class="order-status">وضعیت </th>
                                        <th class="order-total">مجموع </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Orders as $Order)
                                        <tr>
                                            <td class="order-id">{{ $Order->id }}</td>
                                            <td class="order-date">{{ $Persian->MyPersianDate($Order->created_at) }} </td>
                                            <td class="order-status">
                                                @if ($Order->status == 1)
                                                    در انتظار پردازش
                                                @elseif($Order->status == 2)
                                                    در حال پردازش
                                                @elseif($Order->status == 10)
                                                    در دست اقدام
                                                @elseif($Order->status == 20)
                                                    ارسال به انبار
                                                @elseif($Order->status == 30)
                                                    درحال بسته بندی
                                                @elseif($Order->status == 40)
                                                    ارسال به پست
                                                @elseif($Order->status == 60)
                                                    لغو سفارش
                                                @elseif($Order->status == 70)
                                                    تحویل سفارش
                                                @elseif($Order->status = 100)
                                                    تکمیل سفارش
                                                @endif
                                            </td>
                                            <td class="order-total">
                                                <span class="order-price">
                                                    {{ number_format($Order->total_sales + $Order->tax_total / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span> برای
                                                <span class="order-quantity"> {{ $Order->num_items_sold }}</span> آیتم
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <a href="{{ route('ShowProduct') }}" class="btn btn-dark btn-rounded btn-icon-right">برو
                                فروشگاه<i class="w-icon-long-arrow-left"></i></a>
                        </div>

                        <div class="tab-pane" id="account-downloads">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-downloads mr-2">
                                    <i class="w-icon-star-square-full"></i> </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title ls-normal">کاربر ویژه</h4>
                                    <p>تغییر وضیعت به کاربر ويژه</p>
                                </div>
                            </div>
                            <div>
                                {{--       @if (Auth::user()->CreditePlan == null)
                                    <div class="col-md-12 mb-6">
                                        <p class="alert alert-error alert-bg alert-block alert-inline">
                                            <i class="i-Information"
                                                style="font-size: 17px;font-weight: 500;position: relative;margin-left: 6px; "></i>
                                            برای استفاده از امکانات کاربر ویژه در صورتی که عضو سازمان بازنشستگی نیروهای مسلح
                                            هستید کد هویتی خود
                                            را
                                            تایید کنید
                                        </p>
                                    </div>

                            @endif --}}






                            </div>
                            <div class="modal-body">
                                @if (Auth::user()->MelliID == null)
                                    <div class="col-md-12 mb-6">
                                        <p class="alert alert-error alert-bg alert-block alert-inline">
                                            <i class="i-Information"
                                                style="font-size: 17px;font-weight: 500;position: relative;margin-left: 6px; "></i>
                                            برای استفاده از امکانات کاربر ویژه در صورتی که عضو سازمان بازنشستگی نیروهای مسلح
                                            هستید ابتدا مشخصات خود از قبیل کدملی، شماره بازنشستگی و نام پدر را در قسمت حساب
                                            کاربری تکمیل کنید
                                            و مجددا به این قسمت مراجعه فرمایید
                                        </p>
                                    </div>
                                @else
                                    @if (Auth::user()->CreditePlan == 1)
                                        <div class="alert alert-icon alert-success alert-bg alert-inline">
                                            <h4 class="alert-title">
                                                <i class="fas fa-check"></i>انجام شد!
                                            </h4> شما کاربر ویژه هستید.
                                        </div>
                                    @else
                                        <h6>*
                                            هر کد ملی تنها برای یک شماره تماس قابل ثبت است و یک شخص با کد ملی خود نمی‌تواند
                                            با 2 شماره تماس یا بیشتر در سامانه ثبت‌نام نماید.
                                        </h6>
                                        <h6>*
                                            شماره تماس وارد شده هنگام ثبت نام باید با شماره تماس ثبت شده در سامانه
                                            بازنشستگان یکسان باشد. در صورت مغایرت باید با پشتیبانی سایت کوکباز تماس حاصل
                                            نمایید. </h6>
                                        <h6>*
                                            در صورت هر گونه مشکل در قسمت کاربر ویژه شما میتوانید در قسمت پیام ها با واحد فنی
                                            در میان بگذارید
                                        </h6>

                                        <div id="loader_tavan" class="mainloader_21">
                                            <div class="d-flex justify-content-center">
                                                <div class="loader276 "></div>
                                                <p>
                                                    در حال دریافت اطلاعات از مرکز لطفا منتظر بمانید
                                                </p>
                                            </div>
                                        </div>


                                        <div id="tavan" class="nested">
                                            <form method="POST">
                                                @csrf
                                                <p class="important"><i class="i-Information"
                                                        style="font-size: 17px;font-weight: 500;position: relative;margin-left: 6px;"></i>
                                                    کاربر گرامی لطفا کد اعتباری سنجی پیامک شده به شماره موبایل ثبت شده را
                                                    وارد نمایید </p>

                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <input type="number" required name="confirmcode"
                                                                class="form-control credit">
                                                        </div>
                                                    </div>

                                                </div>
                                                <button class="btn btn-dark btn-rounded btn-sm mb-4" name="submit"
                                                    value="tavnpardakht" type="submit">تایید کد
                                                    اعتبارسنجی</button>

                                            </form>

                                        </div>
                                        <div id="notvalidtavan" class="nested">
                                            <div class="alert alert-icon alert-error alert-bg alert-inline">
                                                <h4 class="alert-title">
                                                    <i class="w-icon-exclamation-triangle"></i>
                                                </h4>
                                                کدملی مورد نظر در سامانه یافت نشد
                                                لطفا طی 24 ساعت آینده مجددا تلاش کنید
                                                و یا با پشتیبانی به شماره 0212811119 تماس بگیرید
                                            </div>



                                            </form>

                                        </div>
                                    @endif
                                @endif

                                <div>

                                </div>
                                <div class="ul-card-list__modal">
                                    <div class="modal fade bd-example-modal-lg" style="margin-right: 20%" tabindex="-1"
                                        role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="account-addresses">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-map-marker">
                                    <i class="w-icon-map-marker"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal">آدرس ها </h4>
                                </div>
                            </div>
                            <p>آدرس های زیر به طور پیش فرض در صفحه پرداخت استفاده می شود.</p>
                            <div class="row">
                                <div class="col-sm-6 mb-6">
                                    <div class="ecommerce-address billing-address pr-lg-8">
                                        @foreach ($Locations as $Location)
                                            <h4 class="title title-underline ls-25 font-weight-bold">آدرس
                                                {{ $Location->name }} </h4>
                                            <address class="mb-4">
                                                <table class="address-table">

                                                    <tbody>

                                                        <tr>
                                                            <th>نام :</th>
                                                            <td>{{ $Location->recivername }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>استان:</th>
                                                            <td> {{ $Location->Province }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>شهر:</th>
                                                            <td>{{ $Location->City }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>خیابان :</th>
                                                            <td>{{ $Location->Street }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>آدرس:</th>
                                                            <td>{{ $Location->OthersAddress }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th> پلاک:</th>
                                                            <td>{{ $Location->Pelak }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>تلفن:</th>
                                                            <td>{{ $Location->reciverphone }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </address>
                                            <a href="#"
                                                class="btn btn-link btn-underline btn-icon-right text-primary">آدرس
                                                صورتحساب خود را ویرایش کنید<i class="w-icon-long-arrow-left"></i></a>
                                            <hr>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane" id="account-details">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-account mr-2">
                                    <i class="w-icon-user"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal">جزئیات حساب </h4>
                                </div>
                            </div>

                            <form class="form account-details-form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">نام کوچک *</label>
                                            <input type="text" id="firstname" name="Name"
                                                value="{{ Auth::user()->Name }}" class="form-control form-control-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">نام خانوادگی *</label>
                                            <input type="text" id="lastname" name="Family"
                                                value="{{ Auth::user()->Family }}" class="form-control form-control-md">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_1">آدرس ایمیل</label>
                                            @if (str_contains(Auth::user()->Email, 'nomail'))
                                                <input type="email" id="email_1" name="Email" value=""
                                                    autocomplete="off" placeholder="ایمیل"
                                                    class="form-control form-control-md">
                                            @else
                                                <input type="email" id="email_1" name="Email"
                                                    value="{{ Auth::user()->Email }}"
                                                    class="form-control form-control-md">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            @if (Auth::user()->CreditePlan != 1)
                                                <label for="lastname"> شماره موبایل *</label>

                                                <input type="text" class="form-control form-control-md"
                                                    name="MobileNo" value="{{ Auth::user()->MobileNo }}">
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <label for="lastname"> شماره موبایل *</label>
                                                    <div
                                                        class="bg-success br-lg text-white pl-2 pr-2 font-size-sm font-weight-bolder ">
                                                        تایید شده
                                                    </div>

                                                </div>

                                                <input type="text" class="form-control form-control-md"
                                                    name="DisabledMobileNo" value="{{ Auth::user()->MobileNo }}" disabled>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_1">تاریخ تولد *</label>
                                            <input placeholder="{{ Auth::user()->Birthday }}" value=""
                                                type="text" id="Birthday" name="Birthday"
                                                class="form-control form-control-md" autocomplete="off"
                                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                type="text" name="Birthday" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            @if (Auth::user()->CreditePlan != 1)
                                                <label for="MelliID"> کدملی *</label>
                                                <input type="text" id="MelliID" name="MelliID" required
                                                    value="{{ Auth::user()->MelliID }}"
                                                    class="form-control form-control-md">
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <label for="MelliID"> کدملی *</label>
                                                    <div
                                                        class="bg-success br-lg text-white pl-2 pr-2 font-size-sm font-weight-bolder ">
                                                        تایید شده
                                                    </div>

                                                </div>

                                                <input type="text" class="form-control form-control-md" name="DisabledMelliID"
                                                    value="{{ Auth::user()->MelliID }}" disabled>
                                            @endif

                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_1"> شماره بازنشستگی </label>
                                            <input type="text" id="extranote" name="extranote"
                                                value="{{ Auth::user()->extranote }}"
                                                class="form-control form-control-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname"> نام پدر</label>
                                            <input type="text" id="fathername" name="fathername"
                                                value="{{ Auth::user()->fathername }}"
                                                class="form-control form-control-md">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_1"> کد بازاریابی </label>
                                            <input type="text" id="Ext" name="Ext" readonly
                                                value="{{ Auth::user()->Ext }}" class="form-control form-control-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname"> رمز عبور جدید </label>
                                            <input type="text" name="new_password"
                                                class="form-control form-control-md">
                                        </div>
                                    </div>

                                </div>




                                <button type="submit" name="submit" value="updateUserInfo"
                                    class="btn btn-dark btn-rounded btn-sm mb-4">ذخیره تغییرات
                                </button>
                            </form>
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-account mr-2">
                                    <i class=" w-icon-money"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal"> اطلاعات بانکی </h4>
                                </div>
                            </div>
                            <table class="shop-table account-orders-table mb-6">
                                <thead>
                                    <tr>
                                        <th class="order-id">ردیف </th>
                                        <th class="order-date">نام بانک </th>
                                        <th class="order-status">شماره کارت </th>
                                        <th class="order-total">وضعیت </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Conter = 0;
                                    @endphp
                                    @foreach ($Banks as $BankTarget)
                                        @php
                                            $Conter++;
                                        @endphp

                                        <tr>
                                            <td>{{ $Conter }}</td>
                                            <td>{{ $BankTarget->‌BankName }}</td>
                                            <td>{{ $BankTarget->CardNo }}</td>
                                            @if ($BankTarget->Status == 1)
                                                <td>در انتظار تایید </td>
                                            @else
                                                <td>فعال</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a onclick="shaba();" class="btn btn-dark btn-rounded btn-icon-right">
                                افزودن اطلاعات بانکی</a>
                        </div>
                        <div class="tab-pane" id="account-ticket">
                            <div id="Ticket">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal mb-0">پیام ها </h4>
                                    </div>
                                </div>


                                <table class="shop-table account-orders-table mb-6">
                                    <thead>
                                        <tr>
                                            <th class="order-id">کد </th>
                                            <th class="order-date">تاریخ </th>
                                            <th class="order-status">اولویت </th>
                                            <th class="order-total">موضوع </th>
                                            <th class="order-actions">وضعیت </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Tickets as $Ticket)
                                            <tr id="tr_{{ $Ticket->TicketID }}">
                                                <td class="order-id" id="id_{{ $Ticket->TicketID }}">
                                                    <a href="{{ route('tikets', $Ticket->TicketID) }}">
                                                        {{ $Ticket->TicketID }}
                                                    </a>
                                                </td>

                                                <td id="CreateDate_{{ $Ticket->TicketID }} "class="order-date"
                                                    name="{{ $Ticket->CreateDate }}">
                                                    {{ $Persian->MyPersianDate($Ticket->CreateDate) }} </td>
                                                <td id="Priority_{{ $Ticket->TicketID }} "
                                                    name="{{ $Ticket->Priority }}" class="order-status">
                                                    @foreach (\App\myappenv::TicketPeriority as $Periority)
                                                        @if ($Periority[0] == $Ticket->Priority)
                                                            {{ __($Periority[1]) }}
                                                        @endif
                                                    @endforeach
                                                </td>


                                                <td class="order-total" id="Subject_{{ $Ticket->TicketID }}"
                                                    name="{{ $Ticket->Subject }}">{{ $Ticket->Subject }}</td>

                                                <td class="order-action" id="State_{{ $Ticket->State }} "
                                                    name="{{ $Ticket->State }}">
                                                    @foreach (\App\myappenv::TicketState as $State)
                                                        @if ($State[0] == $Ticket->State)
                                                            {{ __($State[1]) }}
                                                        @endif
                                                    @endforeach
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <a onclick="ShowItems('SendTicket')" class="btn btn-dark btn-rounded btn-icon-right">
                                    ارسال پیام<i class="w-icon-long-arrow-left"></i></a>

                            </div>
                            <div id="SendTicket" class="ItemsMain nested">
                                <div style="display:flex; justify-content: space-between;">
                                    <div class="icon-box icon-box-side icon-box-light">
                                        <span class="icon-box-icon icon-orders">
                                            <i class="w-icon-orders"></i>
                                        </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title text-capitalize ls-normal mb-0"> ارسال پیام </h4>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="icon-box-icon icon-orders">
                                            <i onclick="ReturnTicket();" class=" w-icon-long-arrow-left"></i>
                                        </span>
                                    </div>
                                </div>


                                <div class="row">


                                    <form action="{{ route('tikets') }}" method="post">
                                        @csrf
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group row">
                                                <input style="visibility:hidden" id="tableID" name="tableid">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group row">
                                                <label for="inputName"
                                                    class="col-sm-2 col-form-label">{{ __('Receiver') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="ToUser" class="form-control">

                                                        @foreach ($ticket_recivers as $ticket_reciver)
                                                            <option value="{{ $ticket_reciver->id }}">
                                                                {{ $ticket_reciver->TicketText }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group row">
                                                <label for="inputName"
                                                    class="col-sm-2 col-form-label">{{ __('Topic') }}</label>
                                                <div class="col-sm-10">

                                                    <input type="text" class="form-control" name="subject"
                                                        id="" placeholder="{{ __('Ticket subject') }}"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group row">
                                                <label for="inputName"
                                                    class="col-sm-2 col-form-label">{{ __('Priority') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="TicketPeriority" class="form-control">
                                                        @foreach (\App\myappenv::TicketPeriority as $Periority)
                                                            <option value="{{ $Periority[0] }}">
                                                                {{ __($Periority[1]) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group row">
                                                <label for="inputName"
                                                    class="col-sm-2 col-form-label">{{ __('TicketText') }}</label>
                                                <div class="input-right-icon">
                                                    <textarea name="ce" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group row">
                                                <div class="captcha">
                                                    <span>{!! captcha_img() !!}</span>
                                                    <button type="button" class="btn btn-danger" class="refresh-captcha"
                                                        id="refresh-captcha">
                                                        &#x21bb;
                                                    </button>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input required id="captcha" type="text" autocomplete="off"
                                                        required class="form-control form-control-rounded"
                                                        placeholder="کد امنیتی را وارد فرمایید!" name="captcha">
                                                </div>
                                                <div class="col-sm-10">
                                                    <button id="addelement" type="submit" name="submit" value="add"
                                                        class="btn btn-dark btn-rounded btn-sm mb-4">{{ __('Send') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>


                            </div>
                        </div>
                        {{--    <div class="tab-pane mb-4" id="account-password">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-orders">
                                    <i class="w-icon-orders"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">تغییر رمز عبور </h4>
                                </div>
                            </div>
                            <br>
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group">
                                        <label class="text-dark" for="cur-password">گذرواژه فعلی
                                        </label>
                                        <input type="password" class="form-control form-control-md" id="cur-password"
                                            autocomplete="new-password" name="cur_password">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark" for="new-password">گذرواژه جدید</label>
                                        <input type="password" class="form-control form-control-md" id="new-password"
                                            name="new_password">
                                    </div>
                                    <div class="form-group mb-10">
                                        <label class="text-dark" for="conf-password"> تکرار گذرواژه جدید </label>
                                        <input type="password" class="form-control form-control-md" id="conf-password"
                                            name="conf_password">
                                    </div>

                                </div>

                                <button type="submit" name="submit" value="updateUserInfo"
                                    class="btn btn-dark btn-rounded btn-sm mb-4">ذخیره تغییرات
                                </button>
                            </form>
                        </div> --}}
                        <div class="tab-pane mb-4" id="account-wallet">
                            <input type="text" id="TargetUserName" class="nested" value="{{ Auth::id() }}">
                            <div id="walet" class="ItemsMain">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-wallet"></i>
                                    </span>

                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal mb-0"> کیف پول </h4>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12 mb-4">

                                        <div id="wallet_item" class="alert alert-warning alert-button">
                                            <div class="wallet-item">
                                                <p class="wallet-name ">اعتبار نقدی</p>

                                            </div>
                                            <div id="Cach_val" class="btn btn-warning btn-rounded">0


                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div id="wallet_item" class="alert alert-error alert-button">
                                            <div class="wallet-item">
                                                <p class="wallet-name">اعتبار سازمانی (توان پرداخت)</p>

                                            </div>
                                            <div onclick="ShowItems('PeriodicCredit')" id="Cach_val_Tavan"
                                                class="btn btn-error  btn-rounded">
                                                @if (Auth::user()->extradata != null)
                                                    @php
                                                        $extranote = json_decode(Auth::user()->extradata);
                                                        if (isset($extranote->tavg)) {
                                                            $tavg = $extranote->tavg;
                                                        } else {
                                                            $tavg = '0';
                                                        }
                                                    @endphp



                                                    {{ number_format($tavg) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            </div>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div id="wallet_item" class="alert alert-success  alert-button">
                                            <div class="wallet-item">
                                                <p class="wallet-name">اعتبار فروشندگی</p>

                                            </div>
                                            <div id="Cach_val_Seller" class="btn btn-success  btn-rounded">0</div>
                                        </div>
                                    </div>

                                </div>



                                <div class="wallet-credit">

                                    <button onclick="ShowItems('Increment')"
                                        class="btn btn-dark btn-rounded btn-sm mb-4"><i class="w-icon-plus"></i>

                                        افزایش موجودی </button>
                                    <button onclick="ShowItems('Decrement')"
                                        class="btn btn-dark btn-rounded btn-sm mb-4"><i class="w-icon-minus"></i>
                                        برداشت موجودی</button>


                                </div>



                            </div>

                        </div>
                        <div id="Increment" class="ItemsMain nested">
                            <div style="display: flex; justify-content: space-between;">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-wallet"></i>
                                    </span>

                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal mb-0"> افزایش موجودی </h4>

                                    </div>
                                </div>
                                <div>
                                    <span class="icon-box-icon icon-orders">
                                        <i onclick="ReturnWallet();" class=" w-icon-long-arrow-left"></i>
                                    </span>
                                </div>

                            </div>
                            <p>افزایش موجودی کیف پول از طریق درگاه بانکی</p>
                            <div class="row">
                                <form action="{{ route('DoDirectPay') }}" method="post">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-row ">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4"
                                                    class="ul-form__label">{{ __('Credite mony real') }}:</label>
                                                <input type="number" id="amount" autocomplete="off"
                                                    class="form-control" name="Amount" value="{{ old('Amount') }}"
                                                    placeholder="{{ __('Credite transfer to user account') }}">
                                                <div id="amountext"></div>
                                                <small class="ul-form__text form-text ">
                                                    {{ __('Credite transfer to user account') }}
                                                </small>
                                            </div>
                                            @if (\app\myappenv::MainOwner == 'shafatel')
                                                <div class="row" style="text-align: center">
                                                    <label style="margin: 10px" class="radio radio-outline-primary">
                                                        <input type="radio" checked name="radio" value="pep"
                                                            formcontrolname="radio">
                                                        <span>بانک پاسارگاد</span>
                                                        <img style="max-width: 80px;"
                                                            src="{{ asset('assets/images/favicon/pep.png') }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label style="margin: 10px" class="radio radio-outline-primary">
                                                        <input type="radio" name="radio" value="ic"
                                                            formcontrolname="radio">
                                                        <span>کارت اعتباری ایرانیان</span>
                                                        <img style="max-width: 80px;"
                                                            src="{{ asset('assets/images/favicon/IC.png') }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            @endif
                                            <div class="form-group col-md-12">
                                                <label class="ul-form__label">{{ __('Note') }}</label>
                                                <textarea name="Note" rows="3" class="form-control" required>{{ old('Note') }}</textarea>

                                            </div>
                                        </div>


                                    </div>



                                    <button type="submit" name="submit" value="Trnsfer"
                                        class="btn btn-dark btn-rounded btn-sm mb-4">{{ __('Add credite') }}</button>



                            </div>
                            </form>


                        </div>
                        <div id="Decrement" class="ItemsMain nested">
                            <div style="display: flex; justify-content: space-between;">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-wallet"></i>
                                    </span>

                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal mb-0">برداشت موجودی</h4>

                                    </div>
                                </div>
                                <div>
                                    <span class="icon-box-icon icon-orders">
                                        <i onclick="ReturnWallet();" class=" w-icon-long-arrow-left"></i>
                                    </span>
                                </div>

                            </div>
                            <p>واریز به شماره شبا تعریف شده در سیستم انجام میگیرد</p>

                            <div class="row">
                                <div class="row">
                                    <form action="{{ route('DoDirectPay') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-row ">
                                                <div class="form-group col-md-12">
                                                    <label for="inputEmail4" class="ul-form__label">مبلغ برداشت از کیف
                                                        پول:</label>
                                                    <input type="number" id="amount1" autocomplete="off"
                                                        class="form-control" name="Amount" value="{{ old('Amount') }}"
                                                        placeholder="مبلغ واریزی به حساب بانکی">
                                                    <div id="amountext1"></div>
                                                    <small class="ul-form__text form-text ">
                                                        واریز به شماره شبا تعریف شده در سیستم
                                                    </small>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="ul-form__label">توضیحات برداشت</label>
                                                    <textarea name="Note" rows="3" class="form-control">{{ old('Note') }}</textarea>
                                                    <small>درصورتی که نیاز به توضیحات برداشت دارید این فیلد را پر
                                                        کنید</small>
                                                </div>
                                            </div>
                                            <div class="custom-separator"></div>

                                        </div>

                                        <div class="card-footer bg-transparent">
                                            <div class="mc-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="submit" name="submit" value="Decrease_free"
                                                            class="btn btn-dark btn-rounded btn-sm mb-4">انتقال در
                                                            چهارشنبه های بی
                                                            کارمزد</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                </div>

                            </div>
                        </div>
                        <div id="PeriodicCredit" class="ItemsMain nested">

                            <div style="display: flex; justify-content: space-between;">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-wallet"></i>
                                    </span>

                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal mb-0"> اعتبار دوره ای توان
                                            پرداخت</h4>

                                    </div>
                                </div>
                                <div>
                                    <span class="icon-box-icon icon-orders">
                                        <i onclick="ReturnWallet();" class=" w-icon-long-arrow-left"></i>
                                    </span>
                                </div>
                            </div>
                            <table class="shop-table account-orders-table mb-6">
                                <thead>
                                    <tr>
                                        <th class="order-id"> دوره </th>
                                        <th class="order-date">میزان اعتبار </th>
                                        <th class="order-status">اعتبار مصرف شده </th>
                                        <th class="order-total">اعتبار باقی مانده
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($cashier->GetUserPeriodicCredit(Auth::id()) as $Credit)
                                        <tr>
                                            <td class="order-id">{{ $Credit['DateStr'] }}</td>
                                            <td class="order-date">{{ number_format($Credit['BaseMony']) }}</td>
                                            <td class="order-status">{{ number_format($Credit['UsedMony'] * -1) }}</td>
                                            <td class="order-total">
                                                {{ number_format($Credit['BaseMony'] + $Credit['UsedMony']) }}</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>
    <!-- End of PageContent -->
    </div>
    <label for=""></label>

    <script>
        let Conter = 0;
        onload = function() {
            var e = document.getElementById('amount');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }

            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };
        onload = function() {
            var e = document.getElementById('amount1');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext1').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }

            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };

        function tavanpardakhtfn() {
            $TargetUserName = $('#TargetUserName').val();

            $('#loader_tavan').removeClass('nested');
            $('#btm1').addClass('nested');
            $('#textspcial').addClass('nested');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'tavanpardakhtfn',
                    TargetUserName: $TargetUserName
                },

                function(data, status) {
                    if (data == 'notvalid') {
                        $('#loader_tavan').addClass('nested');
                        $('#notvalidtavan').removeClass('nested');
                    } else {
                        $('#loader_tavan').addClass('nested');
                        $('#tavan').removeClass('nested');
                    }
                });

        }




        function shaba() {
            Swal.fire({
                title: 'روش بازگردان وجه مرجوعی',
                html: ' <label for="">شماره شبا</label>' +
                    '<input id="swal-input1" class="swal2-input" >' +
                    ' <label for="">شماره کارت</label>' +
                    '<input id="swal-input2" class="swal2-input">' +
                    ' <label for="">  نام بانک </label>' +
                    '<input id="swal-input3" class="swal2-input">',
                focusConfirm: false,
                confirmButtonText: 'تایید ',
                preConfirm: function() {
                    return new Promise((resolve, reject) => {
                        // get your inputs using their placeholder or maybe add IDs to them
                        resolve({
                            shaba: $('#swal-input1').val(),
                            card: $('#swal-input2').val(),
                            bank: $('#swal-input3').val(),

                        });

                        // maybe also reject() on some condition
                    });
                }
            }).then((data) => {
                // your input data object will be usable from here

                valuess = data.value;
                changeshaba(valuess);
            });


        }

        function changeshaba(value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'CheckShaba',
                    TargetShaba: value.shaba,
                    Targetcard: value.card,
                    Targetbank: value.bank,

                },

                function(data, status) {
                    if (status == 'success') {
                        Swal.fire({
                            title: 'شماره شبا با موفقیت اضافه گردد.',
                            confirmButtonText: 'بستن',
                        })
                    } else {
                        Swal.fire({
                            title: 'بروز مشکل',
                            confirmButtonText: 'بستن',
                        })

                    }
                });



        }

        function number_format(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function WaletShow() {
            $TargetUserName = $('#TargetUserName').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetWalet',
                    TargetUserName: $TargetUserName
                },

                function(data, status) {

                    const obj = JSON.parse(data);
                    Conter = 0;
                    obj.forEach(Itemfunction);

                });

        }

        function Itemfunction($First, $Second, $index) {

            $MonyLimit = 30000000;
            $Mony = $index[Conter]['Mony'];
            $MonyInt = parseInt($Mony);
            $Percent = Math.round($Mony / $MonyLimit * 100);
            $CreditMod = $index[Conter]['CreditMod'];


            //Cach 1
            if ($CreditMod == '1') {
                $('#Cach_val').html(number_format($Mony) + 'ریال');

            }
            if ($CreditMod == '2') {
                $('#Cach_val_Seller').html(number_format($Mony) + 'ریال');

            }

            Conter++;
        }



        function ShowItems($ItemName) {
            $('.ItemsMain').addClass('nested');
            $('#' + $ItemName).removeClass('nested');
            if ($ItemName == 'walet') {
                WaletShow();
            }

        }

        function ReturnWallet($ItemName) {
            $('#PeriodicCredit').addClass('nested');
            $('#Decrement').addClass('nested');
            $('#Increment').addClass('nested');
            $('#walet').removeClass('nested');

        }

        function ReturnTicket($ItemName) {
            $('#SendTicket').addClass('nested');
            $('#Ticket').removeClass('nested');

        }
    </script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection
