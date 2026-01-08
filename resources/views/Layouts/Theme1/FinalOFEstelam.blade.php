@php
    $Persian = new App\Functions\persian();
    $OrderDetials = $Myorder->get_order_detials_with_ID($ResNum);
@endphp
@extends('Layouts.Theme1.MainLayout')
@section('MainTitle')
@endsection
<style>
    .order .order-table {
    padding: 0.6rem 3rem 3rem;
    border: 1px solid var(--color_palet_3);
    border-collapse: separate;
}
</style>
@section('MainContent')
    <div class="page-content mb-10 pb-2">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="passed"><a>سبد خرید فروشگاه </a></li>
                    <li class="passed"><a>پرداخت </a></li>
                    <li class="active"><a>اتمام خرید </a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="order-success text-center font-weight-bolder text-dark">
                <i class="fas fa-check"></i>
                .متشکرم. درخواست استعلام شما دریافت شد.
            </div>
            <div class="alert alert-icon alert-inline mb-5">
                <i style="color: #799b5a;"  class="w-icon-exclamation-triangle"></i>
                <strong>توجه:  </strong>درخواست استعلام شما به منزله ثبت سفارش نیست. همکاران ما پس از بررسی درخواست شما جهت بررسی و اعلام قیمت نهایی و ثبت سفارش در اسرع وقت با شما تماس خواهند گرفت.
            </div>
            <!-- End of Order Success -->

            <ul class="order-view list-style-none">
                <li>
                    <label>شماره درخواست</label>
                    <strong>{{ $ResNum }}</strong>
                </li>
                <li>
                    <label>وضعیت</label>
                    <strong>{{ $Myorder->get_order_status_txt($product_order->status) }}</strong>
                </li>
                <li>
                    <label>تاریخ</label>
                    <strong>{{ $Persian->MyPersianDate($product_order->created_at) }}</strong>
                </li>
                <li>
                    <label>مجموع</label>

                    <strong>{{ number_format(($product_order->total_sales + $product_order->shipping_total + $product_order->tax_total) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</strong>
                </li>
                <li>
                    <label>روش پرداختی</label>
                    <strong>درخواست خرید کالا </strong>
                </li>
            </ul>
            <!-- End of Order View -->

            <div class="order order-details-wrapper mb-5">
                <h4 class="title text-uppercase ls-25 mb-5">جزئیات درخواست </h4>
                <div id='maincontent'>
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th class="text-dark">محصول </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($OrderDetials as $MyOrderTarget)
                                <tr>
                                    <td>
                                        <a href="{{ route('SingleProduct', ['productID' => $MyOrderTarget->product_id]) }}"
                                            target="_blank"> {{ $MyOrderTarget->NameFa }}</a>&nbsp;<strong>x
                                            {{ $MyOrderTarget->product_qty }}</strong><br>

                                    </td>
                                    <td>
                                        {{ number_format(($MyOrderTarget->total_sales + $MyOrderTarget->tax_total) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                            <tr>
                                <th>حمل و نقل :</th>
                                <td>{{ number_format($product_order->shipping_total / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}{{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </td>
                            </tr>
                            <tr>
                                <th> زمان ارسال :</th>
                                <td>کارشناسان جهت هماهنگی زمان ارسال با شما تماس خواهند گرفت
                                </td>
                            </tr>
                            <tr class="total">
                                <th class="border-no">مجموع :</th>
                                <td id="TotalTopay">
                                    {{ number_format(($product_order->total_sales + $product_order->shipping_total + $product_order->tax_total) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}{{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>


        </div>
    </div>
@endsection
