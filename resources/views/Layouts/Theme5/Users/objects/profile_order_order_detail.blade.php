@php
    $Persian = new App\Functions\persian();
@endphp
<div class="col-12">
    <div class="profile-navbar">
        <a href="javascript:return_to_orders()" class="profile-navbar-btn-back">بازگشت</a>
        <h4>سفارش <span class="font-en">DDC-{{ $order_main->id }}</span><span>ثبت شده در تاریخ
                {{ $Persian->PersianDateText($order_main->created_at) }}</span></h4>
    </div>
</div>
<div class="col-12 mb-4">
    <div class="dt-sl dt-sn border">
        <div class="row table-draught px-3">
            <div class="col-md-6 col-sm-12">
                <span class="title">تعداد کالا:</span>
                <span class="value">{{ $order_main->num_items_sold }}</span>
            </div>
            <div class="col-md-6 col-sm-12">
                <span class="title"> سود مشتری از خرید:</span>
                <span class="value">{{ number_format($order_main->customer_benefit_total) }} ریال</span>
            </div>
            <div class="col-md-6 col-sm-12">
                <span class="title">هزینه ارسال:</span>
                <span class="value">
                    @if ($order_main->shipping_total == 0)
                        رایگان
                    @else
                        {{ number_format($order_main->shipping_total) }} ریال
                    @endif
                </span>
            </div>
            <div class="col-md-6 col-sm-12">
                <span class="title"> وضعیت سفارش:</span>
                <span class="value">{{ $orders->get_order_status_txt($order_main->status) }}</span>
            </div>
            <div class="col-12 text-center pb-0">
                <span class="title">مبلغ این مرسوله:</span>
                <span class="value"> {{ number_format($order_main->total_sales) }} ریال</span>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="section-title text-sm-title mb-1 no-after-dt-sl mb-2 px-res-1">
        <h2>جزئیات سفارش</h2>
    </div>
    <div class="dt-sl">
        <div class="table-responsive">
            <table class="table table-order table-order-details">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام محصول</th>
                        <th>تعداد</th>
                        <th>قیمت واحد</th>
                        <th>قیمت پس از تخفیف</th>
                        <th>تخفیف</th>
                        <th>قیمت نهایی</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_detail as $order_item)
                        <tr>
                            <td>{{ $loop->iteration }} </td>
                            <td>
                                <div class="details-product-area">
                                    <img src="{{ App\Functions\Images::GetPicture($order_item->ImgURL, 1) }}"
                                        class="thumbnail-product" alt="">
                                    <h5 class="details-product">
                                        <span>{{ $order_item->NameFa }}</span>
                                    </h5>
                                </div>
                            </td>
                            <td>{{ $order_item->product_qty }}</td>
                            <td>{{ number_format($order_item->main_unit_price) }} ریال </td>
                            <td>{{ number_format($order_item->unit_Price) }} ریال </td>
                            <td>{{ number_format($order_item->customer_benefit_total) }} ریال </td>
                            <td>{{ number_format($order_item->total_sales) }} ریال </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>
