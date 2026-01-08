@php
    $Persian = new App\Functions\persian();

    $GetBasketItemsBrif = App\Http\Controllers\woocommerce\buy::GetBasketItemsBrif();
    $order_count = count($GetBasketItemsBrif);

@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .nodata {
            background-image: url('https://panel.shafatel.com/storage/photos/icon/nodata.jpeg');
            height: 200px;
            background-repeat: no-repeat;


        }
    </style>
    <!-- Container-fluid starts-->
    <input class="nested" id="main-menu" value="#Dashboard">
    <input class="nested" id="sub-menu" value="#Dashboard">
    <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
    <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
    <div id="app">
        <patascustomer></patascustomer>
    </div>

    <div class="row">
        @if ($order_count > 0)
            <div class="col-lg-12  col-md-12  mb-5">
                <div class="alert alert-primary" role="alert">
                    در سبد خرید شما تعداد {{ $order_count }} محصول موجود است لطفا جهت نهایی سازی خرید اقدام فرمائید. ثبت
                    سفارش
                    <a href="{{ route('checkout') }}">ثبت سفارش</a>
                </div>
            </div>
        @endif
        <div class="col-lg-6  col-md-12  mb-5">
            <div class="card">
                <div style="text-align: center" class="card-header orange">
                    <div class="card-title"> <i class="i-Mail-Money"
                            style="font-size: 30px;display: inherit;color: cornsilk;"></i>
                        صورت حسابهای در انتظار پرداخت</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($OpenBills == [])
                            <div class="nodata"> <i class="i-Folder-Open"></i> داده ای برای نمایش وجود ندارد!</div>
                        @else
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>کد تراکنش</th>
                                        <th> توضیحات </th>
                                        <th> زمان صدور </th>
                                        <th> مبلغ(ریال) </th>
                                        <th> عملیات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($OpenBills as $billItem)
                                        <tr>
                                            <td> {{ $billItem->ID }} </td>
                                            <td> {{ $billItem->Note }} </td>
                                            <td> {{ $Persian->MyPersianDate($billItem->Date, true) }} </td>
                                            <td>{{ number_format($billItem->Mony) }} </td>
                                            <td> <a href="{{ route('selfpay', ['id' => $billItem->ID]) }}">پرداخت</a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-5">
            <div class="card">
                <div style="text-align: center" class="card-header green">

                    <div class="card-title"> <i class="i-Check"
                            style="font-size: 30px;display: inherit;color: cornsilk;"></i>خدمات من </div>
                </div>
                <div class="card-body">


                    <div class="table-responsive">
                        @if ($MyServices == [])
                            <div class="nodata"> <i class="i-Folder-Open"></i> داده ای برای نمایش وجود ندارد!</div>
                        @else
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>کد</th>
                                        <th> نوع خدمت </th>
                                        <th> زمان شروع </th>
                                        <th> زمان پایان </th>
                                        <th> وضعیت </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($MyServices as $service_item)
                                        <tr>
                                            <td> {{ $service_item->id }} </td>
                                            <td> {{ $service_item->Description }} </td>
                                            <td> {{ $Persian->MyPersianDate($service_item->StartRespns, true) }} </td>
                                            <td> {{ $Persian->MyPersianDate($service_item->EndRespns, true) }} </td>
                                            <td>
                                                @switch($service_item->status)
                                                    @case('notactive')
                                                        <span class="badge badge-info"> شروع نشده</span>
                                                    @break

                                                    @case('active')
                                                        <span class="badge badge-success"> درحال انجام</span>
                                                    @break

                                                    @case('finish')
                                                        <span class="badge badge-warning"> درانتظار تایید</span>
                                                    @break

                                                    <span class="badge badge-danger"> نامشخص</span>

                                                    @default
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @php
            $active_order_src = $orders->get_active_orders();
        @endphp
        <div class="col-lg-6 col-md-12 mb-5">
            <div class="card">
                <div style="text-align: center" class="card-header blue">
                    <div class="card-title text-success"><i class="i-Notepad"
                            style="font-size: 30px;display: inherit;color: cornsilk;"></i> درخواست‌های من</div>
                </div>
                <div class="card-body">

                    @if ($active_order_src == [])
                        <div class="nodata"> <i class="i-Folder-Open"></i> داده ای برای نمایش وجود ندارد!</div>
                    @else
                        <table class="table" id="basic-1" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>کد</th>
                                    <th> نوع درخواست </th>
                                    <th> زمان درخواست </th>
                                    <th> آخرین تغییرات </th>
                                    <th> وضعیت </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($active_order_src as $order_item)
                                    <tr>
                                        <td> {{ $order_item->id }} </td>
                                        <td> {{ $order_item->Cat }} </td>
                                        <td> {{ $Persian->MyPersianDate($order_item->created_at, true) }} </td>
                                        <td> {{ $Persian->MyPersianDate($order_item->updated_at, true) }} </td>
                                        <td>
                                            {{ $order_item->StatusName }}

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-lg-6 col-md-12 mb-5">
            <div class="card">
                <div style="text-align: center" class="card-header purple">
                    <div class="card-title"> <i class="i-Fluorescent"
                            style="font-size: 30px;display: inherit;color: cornsilk;"></i> تجهیزات اجاره شده</div>
                </div>
                <div class="card-body">

                    <div class="nodata"> <i class="i-Folder-Open"></i> داده ای برای نمایش وجود ندارد!</div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-js')
    <script>
        window.targetpage = 'Dashboard';
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
    </script>
@endsection

@section('bottom-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#request_table').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    </script>

    <script>
        function ChangeOrderStatus($OrderID, $TargetStatus, $TargetStatusName) {
            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            var $oldvalue = $('#status_' + $OrderID).html();
            $('#status_' + $OrderID).html($loader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'ChangeOrderStatus',
                    OrderID: $OrderID,
                    TargetStatus: $TargetStatus,
                },

                function(data, status) {
                    if (data == '1') {
                        $('#status_' + $OrderID).html($TargetStatusName);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                        $('#status_' + $OrderID).html($oldvalue);
                    }
                });


        }

        function DeleteMessage($MessageId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'RemoveSMS',
                    MessageId: $MessageId,
                },

                function(data, status) {
                    if (data == true) {
                        $("#SmsRow_" + $MessageId).addClass("nested");
                    } else {
                        alert('بروز مشکل در انجام عملیات!');

                    }
                });



        }
    </script>
@endsection
