@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .container {

            position: relative;

        }

        .center {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>
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


            </div>

        </div>
        <hr>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Token- text-warning"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">فروش امروز</p>

                            <p class="text-primary text-24 line-height-1 mb-2 mt-1">
                                {{ number_format($Product->TodaySale()) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Cash-Register text-success"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0"> فروش هفته</p>
                            <p class="text-primary text-24 line-height-1 mb-2">{{ number_format($Product->LastWeekSale()) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card o-hidden mb-4">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 class="w-50 float-left card-title m-0">سفارش های در انتظار تایید مالی </h3>
                        <div class="dropdown dropleft text-right w-50 float-right">
                            <button class="btn bg-gray-100" type="button" id="dropdownMenuButton_table1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="nav-icon i-Gear-2"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table1" x-placement="left-start"
                                style="position: absolute; transform: translate3d(177px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="{{ route('OpenOrders') }}">مشاهده همه سفارشات  </a>


                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام</th>
                                        <th scope="col"> شماره موبایل</th>
                                        <th scope="col"> تاریخ خرید</th>
                                        <th scope="col">وضعیت</th>
                                        <th scope="col">عملیات</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Counter = 1;
                                    @endphp
                                    @foreach ($MyOrders as $MyOrdersTarget)
                                        <tr>
                                            <th scope="row"> {{ $Counter++ }}</th>
                                            <td>{{ $MyOrdersTarget->customername }} {{ $MyOrdersTarget->customerfamily }}
                                            </td>
                                            <td>
                                                {{ $MyOrdersTarget->MobileNo }}
                                            </td>


                                            <td>{{ $Persian->MyPersianDate($MyOrdersTarget->created_at, true) }}</td>
                                            <td><span class="badge badge-success">
                                                    @if ($MyOrdersTarget->DeviceContract == null || $MyOrdersTarget->DeviceContract == $MyOrdersTarget->id)
                                                        @if ($MyOrdersTarget->status == 70)
                                                            تحویل سفارش
                                                        @endif
                                                    @endif
                                                </span></td>
                                                <td>
                                                    <a target="_blank"
                                                        href="{{ route('EditOrder', ['OrderID' => $MyOrdersTarget->id]) }}"
                                                        title="ویرایش سفارش">
                                                        <i style="font-size: 20px" class="i-Edit"></i>
                                                    </a>
                                                    <a target="_blank"
                                                        href="{{ route('Invoice', ['Invoice' => $MyOrdersTarget->id . '?type=p']) }}"
                                                        title="صورت حساب">
                                                        <i style="font-size: 20px" class="i-File-Horizontal-Text"></i>
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
            <!-- end of col-->

            <div class="col-md-6">
                <div class="card o-hidden mb-4">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 class="w-50 float-left card-title m-0">لیست بدهکاران </h3>
                        <div class="dropdown dropleft text-right w-50 float-right">
                            <button class="btn bg-gray-100" type="button" id="dropdownMenuButton_table2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="nav-icon i-Gear-2"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                                <a class="dropdown-item" href="#">Add new user</a>
                                <a class="dropdown-item" href="#">View All users</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table  text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Date</th>

                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Watch</td>
                                        <td>

                                            12-10-2019

                                        </td>

                                        <td>$30</td>
                                        <td><span class="badge badge-success">Delivered</span></td>

                                        <td>
                                            <a href="#" class="text-success mr-2">
                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </a>
                                            <a href="#" class="text-danger mr-2">
                                                <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                            </a>
                                        </td>
                                    </tr>
                                 


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of col-->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-10">
                    <div class="card-body">
                        <div class="card-title">{{ __('Benefit in last 10 days') }}</div>
                        <div id="mygraph" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>
@endsection

@section('bottom-js')
    <script>
        var w = document.getElementById("mygraph");
        if (w) {
            var g = echarts.init(w);
            g.setOption({
                tooltip: {
                    trigger: "axis",
                    axisPointer: {
                        animation: !0
                    }
                },
                grid: {
                    left: "4%",
                    top: "4%",
                    right: "3%",
                    bottom: "10%"
                },
                xAxis: {
                    type: "category",
                    boundaryGap: !1,
                    data: [
                        @php
                            $counter = 0;
                            $maxfeild = 0;
                        @endphp
                        @foreach ($DaramadGraph as $Daramadfeild)
                            @if ($counter != 0)
                                , "{{ $Persian->MyPersianDate($Daramadfeild->confirmdate) }}"
                                @if ($maxfeild < $Daramadfeild->mony)
                                    @php
                                        $maxfeild = $Daramadfeild->mony;
                                    @endphp
                                @endif
                            @else
                                "{{ $Persian->MyPersianDate($Daramadfeild->confirmdate) }}"
                                @php
                                    $counter = 1;
                                    $maxfeild = $Daramadfeild->mony;
                                @endphp
                            @endif
                        @endforeach
                    ],
                    axisLabel: {
                        formatter: "{value}",
                        color: "#666",
                        fontSize: 12,
                        fontStyle: "normal",
                        fontWeight: 400
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    axisTick: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    splitLine: {
                        show: !1,
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    }
                },
                yAxis: {
                    type: "value",
                    min: 0,
                    max: {{ $maxfeild }},
                    interval: 10000000,
                    axisLabel: {
                        formatter: "{value}",
                        color: "#666",
                        fontSize: 12,
                        fontStyle: "normal",
                        fontWeight: 400
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    axisTick: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: "#ddd",
                            width: 1,
                            opacity: .5
                        }
                    }
                },
                series: [{
                    name: "درآمد",
                    type: "line",
                    smooth: !0,
                    data: [
                        @php
                            $counter = 0;
                        @endphp
                        @foreach ($DaramadGraph as $Daramadfeild)
                            @if ($counter != 0)
                                , "{{ $Daramadfeild->mony }}"
                            @else
                                "{{ $Daramadfeild->mony }}"
                                @php
                                    $counter = 1;
                                @endphp
                            @endif
                        @endforeach
                    ],
                    symbolSize: 8,
                    showSymbol: !1,
                    lineStyle: {
                        color: "rgb(255, 87, 33)",
                        opacity: 1,
                        width: 1.5
                    },
                    itemStyle: {
                        show: !1,
                        color: "#ff5721",
                        borderColor: "#ff5721",
                        borderWidth: 1.5
                    },
                    areaStyle: {
                        normal: {
                            color: {
                                type: "linear",
                                x: 0,
                                y: 0,
                                x2: 0,
                                y2: 1,
                                colorStops: [{
                                    offset: 0,
                                    color: "rgba(255, 87, 33, 1)"
                                }, {
                                    offset: .3,
                                    color: "rgba(255, 87, 33, 0.7)"
                                }, {
                                    offset: 1,
                                    color: "rgba(255, 87, 33, 0)"
                                }]
                            }
                        }
                    }
                }]
            }), $(window).on("resize", function() {
                setTimeout(function() {
                    g.resize()
                }, 500)
            })
        }
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
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection
