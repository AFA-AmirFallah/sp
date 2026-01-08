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
                            <small>تمام شده</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

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
                        @foreach ($DoneOrder as $DoneOrderTarget)
                            <tr>
                                <td>{{ $Counter++ }}</td>
                                <td>{{ $DoneOrderTarget->id }}</td>
                                <td>{{ $DoneOrderTarget->customername }} {{ $DoneOrderTarget->customerfamily }}</td>
                                <td>{{ $DoneOrderTarget->MobileNo }}</td>
                                <td>{{ $Persian->MyPersianDate($DoneOrderTarget->created_at, true) }}</td>
                                <td>{{ $DoneOrderTarget->num_items_sold }}</td>
                                <td>{{ number_format($DoneOrderTarget->total_sales + $DoneOrderTarget->tax_total) }}
                                </td>
                                <td>{{ number_format($DoneOrderTarget->net_total) }}</td>
                                <td>
                                    @if ($DoneOrderTarget->DeviceContract == null || $DoneOrderTarget->DeviceContract == $DoneOrderTarget->id)
                                        @if ($DoneOrderTarget->status == 100)
                                            اتمام سفارش
                                        @endif
                                    @endif

                                </td>

                                <td>
                                    <a target="_blank"
                                        href="{{ route('EditOrder', ['OrderID' => $DoneOrderTarget->id]) }}"
                                        title="ویرایش سفارش">
                                        <i style="font-size: 20px" class="i-Edit"></i>
                                    </a>
                                    <a target="_blank"
                                        href="{{ route('Invoice', ['Invoice' => $DoneOrderTarget->id . '?type=p']) }}"
                                        title="صورت حساب">
                                        <i style="font-size: 20px" class="i-File-Horizontal-Text"></i>
                                    </a>
                                    @if ($DoneOrderTarget->DeviceContract != null)
                                        <a target="_blank"
                                            href="{{ route('Invoice', ['Invoice' => $DoneOrderTarget->DeviceContract . 'SD']) }}"
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
