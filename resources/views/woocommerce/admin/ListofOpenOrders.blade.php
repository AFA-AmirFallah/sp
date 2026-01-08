@php
    $Persian = new App\Functions\persian();
@endphp


    <div class="main_forme ">
        <!-- Container-fluid starts-->
        <div class="container-fluid ">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>لیست
                                <small>سفارشات</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
        @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)
            <form method="post">
                @csrf

                <button type="submit" name="submit" value="SendPointAll" class="btn btn-primary">ارسال پیامک نظرسنجی برای
                    تمام سفارشات </button>

            </form>
        @endif
        <!-- Container-fluid starts-->
        <form method="post">
            @csrf
            <div class="card-body">

                <div class="table-responsive">
                    <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>شماره سفارش</th>
                                <th>نام مشتری</th>
                                <th> شماره تماس مشتری</th>
                                <th>تاریخ خرید</th>
                                <th>اقلام</th>
                                <th>مبلغ</th>
                                <th>سود</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $Counter = 1;
                            @endphp
                            @foreach ($OpenOrder as $OpenOrderTarget)
                                <tr>
                                    <td>{{ $Counter++ }}</td>
                                    <td>{{ $OpenOrderTarget->id }}</td>
                                    <td>{{ $OpenOrderTarget->customername }} {{ $OpenOrderTarget->customerfamily }}</td>
                                    <td>{{ $OpenOrderTarget->MobileNo }}</td>
                                    <td>{{ $Persian->MyPersianDate($OpenOrderTarget->created_at, true) }}</td>
                                    <td>{{ $OpenOrderTarget->num_items_sold }}</td>
                                    <td>{{ number_format($OpenOrderTarget->total_sales + $OpenOrderTarget->tax_total) }}
                                    </td>
                                    <td>{{ number_format($OpenOrderTarget->net_total) }}</td>
                                    <td>
                                        @if ($OpenOrderTarget->DeviceContract == null || $OpenOrderTarget->DeviceContract == $OpenOrderTarget->id)
                                            @if ($OpenOrderTarget->status == 1)
                                                پرداخت شده
                                            @elseif($OpenOrderTarget->status == 10)
                                                در دست اقدام
                                            @elseif($OpenOrderTarget->status == 20)
                                                ارسال به انبار
                                            @elseif($OpenOrderTarget->status == 30)
                                                درحال بسته بندی
                                            @elseif($OpenOrderTarget->status == 40)
                                                ارسال به پست
                                            @elseif($OpenOrderTarget->status == 50)
                                                ثبت شده در تاپین
                                            @elseif($OpenOrderTarget->status == 51)
                                                ارسال شده به تاپین
                                            @elseif($OpenOrderTarget->status == 60)
                                                انصراف مشتری
                                                @elseif($OpenOrderTarget->status == 70)
                                                تحویل مشتری
                                            @endif
                                        @else
                                            درخواست استعلام
                                        @endif
                                    </td>

                                    <td>
                                        <a target="_blank"
                                            href="{{ route('EditOrder', ['OrderID' => $OpenOrderTarget->id]) }}"
                                            title="ویرایش سفارش">
                                            <i style="font-size: 20px" class="i-Edit"></i>
                                        </a>
                                        <a target="_blank"
                                            href="{{ route('Invoice', ['Invoice' => $OpenOrderTarget->id . '?type=p']) }}"
                                            title="صورت حساب">
                                            <i style="font-size: 20px" class="i-File-Horizontal-Text"></i>
                                        </a>
                                        @if ($OpenOrderTarget->DeviceContract != null)
                                            <a target="_blank"
                                                href="{{ route('Invoice', ['Invoice' => $OpenOrderTarget->DeviceContract . 'SD']) }}"
                                                title="صورت حساب هوشمند">
                                                <i style="font-size: 20px;color:red;" class="i-File-Horizontal-Text"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </form>
        <!-- Container-fluid Ends-->
    </div>
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-order-list').DataTable();
    </script>


