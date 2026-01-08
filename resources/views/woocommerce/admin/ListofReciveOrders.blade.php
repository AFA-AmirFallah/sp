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
                        <h3>سفارشات
                            <small> تحویل داده شده </small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <li><a class="glyphicon glyphicon-export" onclick="exportAllPages()" href="#">خروجی
            اکسل</a></li>
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
                            <th> شماره موبایل مشتری</th>
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
                        @foreach ($reciveOrder as $reciveOrderTarget)
                            <tr>
                                <td>{{ $Counter++ }}</td>
                                <td>{{ $reciveOrderTarget->id }}</td>
                                <td>{{ $reciveOrderTarget->customername }} {{ $reciveOrderTarget->customerfamily }}</td>
                                <td>{{ $reciveOrderTarget->MobileNo }}</td>
                                <td>{{ $Persian->MyPersianDate($reciveOrderTarget->created_at, true) }}</td>
                                <td>{{ $reciveOrderTarget->num_items_sold }}</td>
                                <td>{{ number_format($reciveOrderTarget->total_sales + $reciveOrderTarget->tax_total) }}
                                </td>
                                <td>{{ number_format($reciveOrderTarget->net_total) }}</td>
                                <td>
                                    @if ($reciveOrderTarget->DeviceContract == null || $reciveOrderTarget->DeviceContract == $reciveOrderTarget->id)
                                        @if ($reciveOrderTarget->status == 70)
                                            در انتظار تایید مالی
                                        @endif
                                        @if ($reciveOrderTarget->status == 80)
                                            ثبت صورتحساب
                                        @endif
                                    @endif

                                </td>

                                <td>
                                    <a target="_blank"
                                        href="{{ route('EditOrder', ['OrderID' => $reciveOrderTarget->id]) }}"
                                        title="ویرایش سفارش">
                                        <i style="font-size: 20px" class="i-Edit"></i>
                                    </a>
                                    <a target="_blank"
                                        href="{{ route('Invoice', ['Invoice' => $reciveOrderTarget->id . '?type=p']) }}"
                                        title="صورت حساب">
                                        <i style="font-size: 20px" class="i-File-Horizontal-Text"></i>
                                    </a>
                                    @if ($reciveOrderTarget->DeviceContract != null)
                                        <a target="_blank"
                                            href="{{ route('Invoice', ['Invoice' => $reciveOrderTarget->DeviceContract . 'SD']) }}"
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

<script>
    function exportAllPages() {
        $("#ul-order-list").tableExport({

            formats: ["csv", "xlsx"],
            fileName: "table_data",
            position: "top",
            ignoreColumn: [0], // exclude the first column from export
            ignoreRows: null,
            trimWhitespace: true,
            RTL: false,
            sheetName: "Sheet1",
            exportButtons: true,
            pageSize: "all" // export all pages

        });
    }
</script>
