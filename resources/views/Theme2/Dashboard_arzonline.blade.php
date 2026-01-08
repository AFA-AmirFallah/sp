@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')
    <style>
        .curency_price_header {
            display: inline-flex;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            @php
                $bannerCount = 0;
                $initslide = true;
            @endphp
            @foreach ($today_src as $today_item)
                <div class="col-md-6 col-lg-4 mb-4 order-0">
                    <div class=" card h-100">
                        <div class="curency_price_header flex-shrink-0">
                            <img src="{{ $today_item->pic }}" alt="dolar" style="height: 120px;" >

                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h3 class="card-title mb-2">قیمت {{ $today_item->FaName }}</h3>
                                <span class="d-block mb-4 text-nowrap prima.ry-font">قیمت واقعی
                                    {{ $today_item->FaName }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h1 class="display-6 text-primary mb-2 pt-3 pb-2">
                                        {{ number_format($today_item->ClosePrice) }} تومان</h1>
                                    @if ($today_item->Percent > 0)
                                        <small class="d-block mb-3 lh-1-85">{{ $today_item->FaName }} امروز
                                            {{ $today_item->Percent }}% کاهش <br> داشته است.</small>
                                    @elseif($today_item->Percent < 0)
                                        <small class="d-block mb-3 lh-1-85">{{ $today_item->FaName }} امروز
                                            {{ $today_item->Percent }}% کاهش <br> داشته است.</small>
                                    @else
                                        <small class="d-block mb-3 lh-1-85">{{ $today_item->FaName }} امروز <br> بدون
                                            تغییر.</small>
                                    @endif

                                    <a href="{{route('wizard_ex',['CoinId'=>$today_item->curency])}}" class="btn btn-sm btn-primary">درخواست خرید</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-xl-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <!-- Order Summary -->
                        <div class="col-md-12 col-12 pe-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">دلار به تومان</h5>
                                <span></span>
                                <h5 id="orderSummaryChart_usd_p"></h5>

                            </div>
                            <div class="card-body p-0">
                                <div id="orderSummaryChart_usd"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <!-- Order Summary -->
                        <div class="col-md-12 col-12 pe-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">درهم به تومان</h5>
                                <span></span>
                                <h5 id="orderSummaryChart_derham_p"></h5>

                            </div>
                            <div class="card-body p-0">
                                <div id="orderSummaryChart_derham"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <!-- Order Summary -->
                        <div class="col-md-12 col-12 pe-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">تتر به تومان</h5>
                                <span></span>
                                <h5 id="orderSummaryChart_usdt_p"></h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="orderSummaryChart_usdt"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @foreach ($Minis as $Mini)
                @if ($Mini->mini == 1)
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        {!! $Mini->Content !!}
                    </div>
                @elseif ($Mini->larg == 1)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <img class="card-img-top" src="{{ $Mini->MainPic }}" alt="{{ $Mini->Name }}">
                            <div class="card-header primary-font">
                                <div class="d-flex align-items-start">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar me-3">
                                            <img src="{{ $Mini->avatar }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div class="me-2">
                                            <h5 class="mb-1"><a
                                                    href="{{ route('ShowNewsItem', ['NewsId' => $Mini->id]) }}"
                                                    class="h5 stretched-link">{{ $Mini->UpTitel }}</a></h5>
                                            <div class="client-info d-flex align-items-center text-nowrap">
                                                <h6 class="mb-0 me-1">نویسنده:</h6>
                                                <span>{{ $Mini->Name }}
                                                    {{ $Mini->Family }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $Mini->Titel }}</h5>
                                <p style="text-align: justify" class="card-text">
                                    {{ $Mini->SubTitel }}
                                </p>
                                <a href="{{ route('ShowNewsItem', ['NewsId' => $Mini->id]) }}"
                                    class="btn btn-outline-primary">متن مطلب</a>
                                <p style="float: left;display: flex;">
                                    {{ $Persian->MyPersianDate($Mini->CrateDate) }} </p>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach


            <!--/ Marketing Campaigns -->
        </div>
    </div>
@endsection
@section('EndScripts')
    <script>
        $series = [];
        $categories = [];
        $minVal = 1000000;
        $maxVal = 0;
        $lastPrice = 0;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('/ajax', {
                ajax: true,
                AjaxType: 'totallMarketIndexChart_usd'
            },

            function(data, status) {
                console.log(data);
                $USD_TMN = data['USD_TMN'];
                $minVal = 1000000;
                $maxVal = 0;
                $USD_TMN.forEach(graphloader);
                loadgraph('#orderSummaryChart_usd');
                $USDT_TMN = data['USDT_TMN'];
                $minVal = 1000000;
                $maxVal = 0;
                $USDT_TMN.forEach(graphloader);
                loadgraph('#orderSummaryChart_usdt');
                $DRH_TMN = data['DRH_TMN'];
                $minVal = 1000000;
                $maxVal = 0;
                $DRH_TMN.forEach(graphloader);
                loadgraph('#orderSummaryChart_derham');
            });


        function graphloader(item, index) {

            $lastPrice = item['ClosePrice'];
            $series.push(item['ClosePrice']);
            if (item['ClosePrice'] < $minVal) {
                $minVal = item['ClosePrice'];
            }
            if (item['ClosePrice'] > $maxVal) {
                $maxVal = item['ClosePrice'];
            }
            $categories.push(item['candate_p']);
        }

        function LoadTotallIndex() {
            let cardColor, axisColor, borderColor, shadeColor;
            if (isDarkStyle) {
                axisColor = config.colors_dark.axisColor;
                borderColor = config.colors_dark.borderColor;
                shadeColor = 'dark';
            } else {
                axisColor = config.colors.axisColor;
                borderColor = config.colors.borderColor;
                shadeColor = 'light';
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var $Yvalue = [];
            var $Xvalue = [];
            var $indaicator = 0;

            $.post('/ajax', {
                    ajax: true,
                    AjaxType: 'totallMarketIndexChart_usd'
                },

                function(data, status) {

                    i = 9;
                    $.each(data, function(key, value) {
                        $Yvalue[i] = value['ClosePrice'];
                        $Xvalue[i] = value['candate_p'];
                        $indaicator = value['ClosePrice'];
                        i--;
                    });
                    $indaicatorInt = parseInt($indaicator);

                    if ($indaicatorInt > 30) {
                        $('#indicatorstatus').html('بازار صعودی عالی');
                        line_color = config.colors.success;
                    } else if ($indaicatorInt > 10) {
                        $('#indicatorstatus').html('بازار صعودی مناسب');
                        line_color = config.colors.success;
                    } else if ($indaicatorInt > 0) {
                        $('#indicatorstatus').html('بازار صعودی ملایم');
                        line_color = config.colors.warning;
                    } else if ($indaicatorInt < -20) {
                        $('#indicatorstatus').html('بازار نزولی  خیلی خطرناک');
                        line_color = config.colors.danger;
                    } else if ($indaicatorInt < -10) {
                        $('#indicatorstatus').html('بازار نزولی خطرناک');
                        line_color = config.colors.danger;
                    } else if ($indaicatorInt < 0) {
                        $('#indicatorstatus').html('بازار نزولی ');
                        line_color = config.colors.warning;
                    }
                    const totallMarketIndexChartEl = document.querySelector('#totallMarketIndexChart_usd'),
                        totallMarketIndexChartConfig = {
                            series: [{
                                name: 'شاخص',
                                data: $Yvalue
                            }],
                            chart: {
                                height: 120,
                                parentHeightOffset: 0,
                                parentWidthOffset: 0,
                                type: 'line',
                                toolbar: {
                                    show: false
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                width: 3,
                                curve: 'straight'
                            },
                            grid: {
                                show: false,
                                padding: {
                                    top: -30,
                                    left: 2,
                                    right: 0,
                                    bottom: -10
                                }
                            },
                            colors: [line_color],
                            xaxis: {
                                show: false,
                                categories: $Xvalue,
                                axisBorder: {
                                    show: true,
                                    color: borderColor
                                },
                                axisTicks: {
                                    show: true,
                                    color: borderColor
                                },
                                labels: {
                                    show: true,
                                    style: {
                                        fontSize: '0.813rem',
                                        colors: axisColor
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    show: false
                                }
                            }
                        };
                    if (typeof totallMarketIndexChartEl !== undefined && totallMarketIndexChartEl !== null) {
                        const totallMarketIndexChart = new ApexCharts(totallMarketIndexChartEl,
                            totallMarketIndexChartConfig);
                        totallMarketIndexChart.render();
                    }



                });


            //$('#indicatorstatus').html('ریزش خطرناک');

        }

        function loadgraph($graph_id, $price_tag) {

            LoadTotallIndex();

            $maxVal = parseInt($maxVal);
            $maxVal += 100;
            $minVal = parseInt($minVal);
            $minVal -= 100;
            let cardColor, axisColor, borderColor, shadeColor;
            if (isDarkStyle) {
                axisColor = config.colors_dark.axisColor;
                borderColor = config.colors_dark.borderColor;
                shadeColor = 'dark';
            } else {
                axisColor = config.colors.axisColor;
                borderColor = config.colors.borderColor;
                shadeColor = 'light';
            }
            const orderSummaryEl = document.querySelector($graph_id),
                orderSummaryConfig = {
                    chart: {
                        height: 264,
                        type: 'area',
                        toolbar: false,
                        dropShadow: {
                            enabled: true,
                            top: 18,
                            left: 2,
                            blur: 3,
                            color: config.colors.primary,
                            opacity: 0.15
                        }
                    },
                    markers: {
                        size: 6,
                        colors: 'transparent',
                        strokeColors: 'transparent',
                        strokeWidth: 4,
                        discrete: [{
                            fillColor: cardColor,
                            seriesIndex: 0,
                            dataPointIndex: 9,
                            strokeColor: config.colors.primary,
                            strokeWidth: 4,
                            size: 6,
                            radius: 2
                        }],
                        hover: {
                            size: 7
                        }
                    },
                    series: [{
                        name: 'قیمت ',
                        data: $series
                    }],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        lineCap: 'round'
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: shadeColor,
                            shadeIntensity: 0.8,
                            opacityFrom: 0.7,
                            opacityTo: 0.25,
                            stops: [0, 95, 100]
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: borderColor,
                        padding: {
                            top: -15,
                            bottom: -10,
                            left: 15,
                            right: 10
                        }
                    },
                    xaxis: {
                        categories: $categories,
                        labels: {
                            offsetX: 0,
                            style: {
                                colors: axisColor,
                                fontSize: '13px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            offsetX: 7,
                            formatter: function(val) {
                                return val + ' تومان';
                            },
                            style: {
                                fontSize: '13px',
                                colors: axisColor
                            }
                        },
                        min: $minVal,
                        max: $maxVal,
                        tickAmount: 4
                    }
                };
            if (typeof orderSummaryEl !== undefined && orderSummaryEl !== null) {
                const orderSummary = new ApexCharts(orderSummaryEl, orderSummaryConfig);
                orderSummary.render();
            }
            $series = [];
            $($graph_id + '_p').html(number_format($lastPrice) + ' تومان ');

        }
    </script>
    <script src="/T1assets/js/cards-statistics.js"></script>
@endsection
