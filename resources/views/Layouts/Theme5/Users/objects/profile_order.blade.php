@php
    $Persian = new App\Functions\persian();
@endphp
<div id="all_orders" class="row">
    <div class="col-12">
        <div class="section-title text-sm-title mb-1 no-after-dt-sl mb-2 px-res-1">
            <h2>همه سفارش‌ها</h2>
        </div>
        <div class="dt-sl">
            <div class="table-responsive">
                <table class="table table-order">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>شماره سفارش</th>
                            <th>تاریخ ثبت سفارش</th>
                            <th>هزینه حمل و نقل</th>
                            <th>مبلغ کل</th>
                            <th>وضعیت سفارش</th>
                            <th>جزییات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_src as $order_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>DDC-{{ $order_item->id }}</td>
                                <td>{{ $Persian->PersianDateText($order_item->created_at) }}</td>
                                <td>{{ number_format($order_item->shipping_total) }} ریال </td>
                                <td>{{ number_format($order_item->total_sales) }} ریال </td>
                                <td>{{ $orders->get_order_status_txt($order_item->status) }}</td>
                                <td class="details-link">
                                    <a onclick="load_order({{$order_item->id}})">
                                        <i class="mdi mdi-chevron-left"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="order_detail" class="row">

</div>
