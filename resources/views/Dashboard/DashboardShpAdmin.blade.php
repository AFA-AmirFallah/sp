@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Dashboard') }}
                            <small>{{ __('Dashboard') }}</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center green">
                        <i class="i-Present text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class=" mt-2 mb-0 text-white">محصولات</p>
                            <p class="text-white text-24 line-height-1 mb-2">{{ $Product->GetCountProduct() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary red o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Financial text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class="text-white  mt-2 mb-0"> تمام شده </p>
                            <p class="text-white text-24 line-height-1 mb-2">{{ $Product->GetfinishProductcount() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 orange">
                    <div class="card-body text-center">
                        <i class="i-Checkout-Basket text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class="text-white mt-2 mb-0 boldness">سفارشات</p>
                            <p class="text-white text-24 line-height-1 mb-2">{{ $Product->GetOrderProductcount() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 blue">
                    <div class="card-body text-center">
                        <i class="i-Shop text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class="text-white mt-2 mb-0">فروشگاه ها</p>
                            <p class="text-white text-24 line-height-1 mb-2">{{ $Product->GetShopcount() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Aim text-warning"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">فروش امروز</p>
                            <p class="text-primary text-24 line-height-1 mb-2">{{ $Product->TodayOrder() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Add-UserStar text-info"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0"> کاربران امروز </p>
                            <p class="text-primary text-24 line-height-1 mb-2">
                                {{ $Product->TodayUser() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Cash-Register text-success"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0"> فروش امروز</p>
                            <p class="text-primary text-24 line-height-1 mb-2">{{ $Product->TodayOrder() }} </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Ambulance text-danger"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">بررسی ها</p>
                            <p class="text-primary text-24 line-height-1 mb-2">{{ $Product->UnsuccessBuy() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-list">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card text-left">
                            <div class="card-header text-right bg-transparent" style="text-align: right">
                                <h5 style="text-align: right;">{{ __('Request Orders') }}</h5>
                                <li><a class="glyphicon glyphicon-export" onclick="exportAllPages()" href="#">خروجی
                                        اکسل</a></li>

                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}"
                                        style="width:100%">
                                        <thead>

                                            <tr>
                                                <th>{{ __('Number') }}</th>
                                                <th>{{ __('Request person') }}</th>
                                                <th>مشتری</th>
                                                <th>{{ __('Mobile No') }}</th>
                                                <th>{{ __('Date of enter') }}</th>
                                                <th>{{ __('service type') }}</th>
                                                <th>{{ __('address') }}</th>
                                                <th>{{ __('Note') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                @if (Auth::user()->branch == null || Auth::user()->branch == \App\myappenv::Branch)
                                                    <th>{{ __('Actions') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($MyOrders as $MyOrder)
                                                @php
                                                    $OutPut = json_decode($MyOrder->Extranote);

                                                @endphp
                                                <tr>
                                                    <td>{{ $MyOrder->ID }}</td>
                                                    <td>{{ $MyOrder->ordername }} {{ $MyOrder->orderfamily }} </td>
                                                    <td>{{ $MyOrder->BimarName }} {{ $MyOrder->Bimarfamily }} </td>
                                                    <td>{{ $MyOrder->BimarMobile }}</td>
                                                    <td>{{ $Persian->MyPersianDate($MyOrder->CreateDatew, true) }}</td>
                                                    <td>{{ $MyOrder->Cat }}</td>
                                                    <td>
                                                        {{ $MyOrder->Address }}
                                                    </td>
                                                    <td>
                                                        @if (is_object($OutPut))
                                                            @foreach ($OutPut as $OutPutItem)
                                                                {{ $OutPutItem[0] }} : {{ $OutPutItem[1] }} <br>
                                                            @endforeach
                                                        @else
                                                            {{ $MyOrder->Extranote }}
                                                        @endif
                                                    </td>
                                                    <td id="status_{{ $MyOrder->ID }}" name="{{ $MyOrder->status }}">
                                                        {{ $MyOrder->status }}</td>
                                                    @if (Auth::user()->branch == null || Auth::user()->branch == \App\myappenv::Branch)
                                                        <td>
                                                            <button type="button" class="btn bg-white _r_btn border-0"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <span class="_dot _inline-dot bg-primary"></span>
                                                                <span class="_dot _inline-dot bg-primary"></span>
                                                                <span class="_dot _inline-dot bg-primary"></span>
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; text-align: right; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                @foreach ($orderstatus as $orderstatusItem)
                                                                    <a class="dropdown-item ul-widget__link--font"
                                                                        onclick="ChangeOrderStatus({{ $MyOrder->ID }},{{ $orderstatusItem->ID }},'{{ $orderstatusItem->status }}')">
                                                                        <i class="i-Data-Save"> </i>
                                                                        {{ $orderstatusItem->status }}
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                @endforeach


                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
    </section>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>
@endsection

@section('bottom-js')
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
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script>
        $('#ul-contact-list').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    </script>
    <script>
        function exportAllPages() {
            $("#ul-contact-list").tableExport({

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
