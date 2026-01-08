@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#dashboard">
    <input class="nested" id="sub-menu" value="#dashboard">
    <!-- Container-fluid Ends-->
    <div id="app">
        @if (app\myappenv::version > 3)
            <Superadmin></Superadmin>
        @else
            <Superadmin_branch></Superadmin_branch>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 mb-5">
            <div class="card">
                <div style="text-align: center" class="card-header green">
                    @if (app\myappenv::MainOwner == 'Carpetour')
                        <div class="card-title">کاربران هفت روز گذشته <i class="i-Checked-User"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> </div>
                    @else
                        <div class="card-title"> <i class="i-Checked-User"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> کاربران ۲۴ ساعت گذشته</div>
                    @endif
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table" id="basic-1" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>نام خانوادگی</th>
                                    <th>موبایل</th>
                                    <th> شعبه </th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (app\myappenv::MainOwner == 'Carpetour')
                                    @foreach ($DashboardClass->Last7DaysUsers() as $User)
                                        <tr>
                                            <td>{{ $User->Name }}</td>
                                            <td>{{ $User->Family }}</td>
                                            <td>{{ $User->MobileNo }}</td>
                                            <td>{{ $User->BranchName }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($DashboardClass->Last24Users() as $User)
                                        <tr>
                                            <td>{{ $User->Name }}</td>
                                            <td>{{ $User->Family }}</td>
                                            <td>{{ $User->MobileNo }}</td>
                                            <td>{{ $User->BranchName }}</td>

                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if (\App\myappenv::Lic['hozorgheyab'])
            <div class=" col-lg-6 col-md-12 mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header teal">
                        <div class="card-title"><i class="i-Business-Mens"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i>پرسنل مشغول به کار </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>ساعت شروع</th>
                                        <th>از مبدا</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hozorgheyabs as $hozorgheyab)
                                        <tr>
                                            <td>{{ $hozorgheyab->Name }} {{ $hozorgheyab->Family }}</td>
                                            <td>{{ $hozorgheyab->entertime }} </td>
                                            <td>{{ $hozorgheyab->enterip }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>

    <div class="col-md-12 mb-5">
        <div class="card ">
            <div style="text-align: center" class="card-header pink">
                <div class="card-title"><i class="i-Coins" style="font-size: 30px;display: inherit;color: cornsilk;"></i>
                    {{ __('Benefit in last 10 days') }}
                </div>
            </div>
            <div class="card-body">
                <div id="mygraph" style="height: 300px;"></div>
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
@endsection
