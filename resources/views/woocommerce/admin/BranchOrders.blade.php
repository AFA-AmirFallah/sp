@php
    $Persian = new App\Functions\persian();

@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->


    <div class="main_forme ">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>لیست
                                <small>غرفه دار</small>
                            </h3>
                            <li><a class="glyphicon glyphicon-export" onclick="exportAllPages()" href="#">خروجی
                                اکسل</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <th>نام غرفه دار</th>
                                <th>نام کالا فروخته شده</th>
                                <th>مبلغ خرید  (ریال) </th>
                                <th> مبلغ فروش (ریال) </th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $Counter = 1;
                            @endphp
                            @foreach ($BranchOrders as $BranchOrdersTarget)
                                <tr>
                                    <td>{{ $Counter++ }}</td>
                                    <td> <a
                                            href="{{ route('EditOrder', ['OrderID' => $BranchOrdersTarget->id]) }}" target="_blank">{{ $BranchOrdersTarget->id }}</a>
                                    </td>
                                    <td>{{ $BranchOrdersTarget->customername }} {{ $BranchOrdersTarget->customerfamily }}
                                    </td>
                                    <td>{{ $BranchOrdersTarget->MobileNo }}
                                    </td>
                                    <td>{{ $BranchOrdersTarget->Name }} {{ $BranchOrdersTarget->Phone }}</td>
                                    <td>
                                        <a href="{{ Route('EditProduct', ['id' => $BranchOrdersTarget->goodid]) }}" target="_blank">  {{ $BranchOrdersTarget->NameFa }}</a>
                                      </td>
                                    <td> {{ number_format($BranchOrdersTarget->unit_Price) }}</td>
                                    <td> {{ number_format($BranchOrdersTarget->unit_sales) }}</td>
                                    <td> {{ $Persian->MyPersianDate($BranchOrdersTarget->created_at, true) }}</td>
                                    <td>

                                        @if ($BranchOrdersTarget->status == 0)
                                            <p class="red text-white"> در انتظار پرداخت</p>
                                        @elseif ($BranchOrdersTarget->status == 1)
                                            پرداخت شده
                                        @elseif($BranchOrdersTarget->status == 10)
                                            در دست اقدام
                                        @elseif($BranchOrdersTarget->status == 20)
                                            ارسال به انبار
                                        @elseif($BranchOrdersTarget->status == 30)
                                            درحال بسته بندی
                                        @elseif($BranchOrdersTarget->status == 40)
                                            ارسال به پست
                                        @elseif($BranchOrdersTarget->status == 50)
                                            ثبت شده در تاپین <br>
                                            بارکد پستی:
                                            {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                        @elseif($BranchOrdersTarget->status == 51)
                                            ارسال شده به تاپین <br>
                                            بارکد پستی:
                                            {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                        @elseif($BranchOrdersTarget->status == 60)
                                            لغو سفارش
                                        @elseif($BranchOrdersTarget->status == 70)
                                            تحویل سفارش و در انتظار تایید مالی
                                        @elseif($BranchOrdersTarget->status == 80)
                                            ثبت صورتحساب
                                        @elseif($BranchOrdersTarget->status = 100)
                                            اتمام سفارش
                                        @endif

                                    </td>





                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </form>
    </div>

    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-order-list').DataTable();
    </script>

      <script>
        function exportAllPages() {
            $("#tavanpardakht-list").tableExport({

                formats: ["xlsx"],
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
@endsection
