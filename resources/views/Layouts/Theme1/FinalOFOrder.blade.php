@php
    $Persian = new App\Functions\persian();
    $OrderDetials = $Myorder->get_order_detials_with_ID($ResNum);
    $OrderPayStatus = $Myorder->get_order_pay_status($ResNum);
@endphp
<style>
    .container237 {
        display: flex;
        justify-content: center;
        align-items: center;

    }
</style>
@extends('Layouts.Theme1.MainLayout')
@section('MainTitle')
@endsection
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
                <i style="color: #799b5a;" class="fas fa-check"></i>
                متشکرم.سفارش شما دریافت شد
            </div>
            <!-- End of Order Success -->

            <ul class="order order-view list-style-none">
                <li>
                    <label>شماره سفارش</label>
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
                    <strong>
                        {{ number_format(($product_order->total_sales + $product_order->shipping_total + $product_order->tax_total) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}


                    </strong>
                </li>
                <li>
                    <label>روش پرداختی</label>

                    @if ($OrderPayStatus->CreditMod == 3)
                        <strong> پرداخت از طریق فیش حقوقی</strong>
                    @else
                        <strong> پرداخت از طریق درگاه پرداخت </strong>
                    @endif
                </li>

            </ul>
            <!-- End of Order View -->

            <div class="order-details-wrapper mb-5">
                <h4 class="title text-uppercase ls-25 mb-5">جزئیات سفارش </h4>
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
                                <td>
                                    @if ($product_order->shipping_total == 0)
                                        @foreach (json_decode($product_order->extra) as $extranote)
                                            @if (isset($extranote->UserDeliverReport))
                                                {{ $extranote->note }}
                                            @endif
                                        @endforeach
                                    @else
                                        {{ number_format($product_order->shipping_total / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}{{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    @endif
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

            @if ($OrderPayStatus->CreditMod == 3)
                <div class="sub-orders mb-10">
                    <h4 class="title mb-5 font-weight-bold ls-25">توضیحات تکمیلی </h4>
                    <div class="alert alert-icon alert-inline mb-5">
                        <i style="color: #799b5a;" class="w-icon-exclamation-triangle"></i>
                        <strong>یادداشت: </strong>این سفارش به صورت اقساطی است. بنابراین لازم است گواهی کسر از حقوق را
                        پرینت
                        گرفته و در نزد خود نگه دارید لازم به ذکر است سفارشات بالای شش میلیون تومان گواهی کسر از حقوق امضا
                        شده به
                        همراه فیش حقوقی باید برای کارشناسان کوکباز ارسال گردد.

                    </div>

                </div>
                <div class="container237">
                    <a target="_blank" class="btn btn-warning btn-rounded" style="margin-right: 20px"
                        href="{{ route('Kasrazhoghogh', ['Kasrazhoghogh' => $product_order->id . '?case=K']) }}"
                        title="صدور کسر از حقوق">
                        صدور کسر از حقوق
                    </a>

                </div>
            @endif

        </div>
    </div>
@endsection
@section('bottom-js')
    <script>
        window.ProductId = <?php echo $MyOrderTarget->product_id; ?>;

        $(document).ready(function() {
            $.ajax({
                url: '?userindex&ProductId=' + window.ProductId,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    //

                },
                error: function() {
                    //
                }
            });
        });
    </script>
@endsection
