@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')




    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            @php
                $bannerCount = 0;
                $initslide = true;
            @endphp

            <div class="col-xl-12 col-12 mb-12 mb-4">
                <div id="carouselExample-cf" class="carousel carousel-dark slide carousel-fade" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($mobile_banners as $mobile_banner)
                            @if ($mobile_banner->theme == 1 && $mobile_banner->status == 1)
                                @if ($initslide)
                                    <li data-bs-target="#carouselExample-cf" data-bs-slide-to="{{ $bannerCount }}"
                                        class="active"> </li>
                                    @php
                                        $initslide = false;
                                    @endphp
                                @else
                                    <li data-bs-target="#carouselExample-cf" data-bs-slide-to="{{ $bannerCount }}">
                                    </li>
                                @endif
                                @php
                                    $bannerCount++;
                                @endphp
                            @endif
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @php
                            $initslide = true;
                        @endphp
                        @foreach ($mobile_banners as $mobile_banner)
                            @if ($mobile_banner->theme == 1 && $mobile_banner->status == 1)
                                @if ($initslide)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ $mobile_banner->pic }}" alt="First slide">
                                        <div class="carousel-caption d-none d-md-block">
                                            {!! $mobile_banner->title !!}
                                        </div>
                                    </div>
                                    @php
                                        $initslide = false;
                                    @endphp
                                @else
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ $mobile_banner->pic }}" alt="Second slide">
                                        <div class="carousel-caption d-none d-md-block">
                                            {!! $mobile_banner->title !!}
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExample-cf" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">قبلی</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample-cf" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">بعدی</span>
                    </a>
                </div>
            </div>


            @if (Auth::check() &&  \App\myappenv::Lic['crypto'])
                <!-- Weekly Order Summary -->
                <div class="col-xl-8 col-12 mb-4">
                    <div class="card h-100">
                        <div class="row row-bordered m-0">
                            <!-- Order Summary -->
                            <div class="col-md-8 col-12 pe-0">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">تتر به تومان</h5>
                                    <span></span>
                                    <h5 id="lastusdtprice"></h5>

                                </div>
                                <div class="card-body p-0">
                                    <div id="orderSummaryChart"></div>
                                </div>
                            </div>
                            <!-- Sales History -->
                            <div class="col-md-4 col-12 px-0">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">نمای کلی بازار</h5>
                                </div>
                                <div class="card-body">



                                    <h6 class="mt-1">وضعیت امروز بازار</h6>
                                    <p class="mb-4">امروز بازار قابل قبولی در تمامی ارزها داریم</p>
                                    <ul class="list-unstyled m-0 pt-0">
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar avatar-sm flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-primary"><img
                                                            src="/T1assets/img/icons/unicons/TarsTama.svg" alt="nopic">
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="mb-0 text-muted text-nowrap">شاخص ترس به طمع</p>
                                                    <small class="fw-semibold text-nowrap">41%</small>
                                                </div>
                                            </div>
                                            <div class="progress" style="height: 6px">
                                                <div class="progress-bar bg-primary" style="width: 75%" role="progressbar"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar avatar-sm flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-success"><img
                                                            src="/T1assets/img/icons/unicons/temprature.svg"
                                                            alt="nopic"></span>
                                                </div>
                                                <div>
                                                    <p class="mb-0 text-muted text-nowrap">دمای بازار </p>
                                                    <small class="fw-semibold text-nowrap">30 درصد</small>
                                                </div>
                                            </div>
                                            <div class="progress" style="height: 6px">
                                                <div class="progress-bar bg-success" style="width: 75%" role="progressbar"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Weekly Order Summary -->

                <!-- Latest Update -->
                <div class="col-md-6 col-lg-6 col-xl-4 col-xl-4 mb-4">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">شاخص کل بازار</h5> <small id="indicatorstatus"> </small>
                        </div>

                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <div id="totallMarketIndexChart"></div>

                            </ul>
                        </div>

                        <div class="card-header d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">میزان سرمایه گذاری</h5>
                        </div>

                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <div id="expensesLineChart"></div>

                            </ul>
                        </div>
                    </div>
                </div>

                <div id="app" class="container-xxl flex-grow-1 container-p-y">
                    <backtest></backtest>
                </div>
                <!--/ Latest Update -->
                <!-- Gamification Card -->
            @endif
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
        $.post('/dashboard', {
                ajax: true,
                procedure: 'usdt-tmn-10-d'
            },

            function(data, status) {
                console.log(data);
                data.forEach(graphloader);
                loadgraph();

            });


        function graphloader(item, index) {

            $lastPrice = item['meta_value'];
            $series.push(item['meta_value']);
            if (item['meta_value'] < $minVal) {
                $minVal = item['meta_value'];
            }
            if (item['meta_value'] > $maxVal) {
                $maxVal = item['meta_value'];
            }
            $categories.push(item['fgstr']);
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

            $.post('/dashboard', {
                    ajax: true,
                    procedure: 'totallMarketIndexChart'
                },

                function(data, status) {

                    i = 9;
                    $.each(data, function(key, value) {
                        $Yvalue[i] = value['meta_value'];
                        $Xvalue[i] = value['fgstr'];
                        $indaicator = value['meta_value'];
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
                    const totallMarketIndexChartEl = document.querySelector('#totallMarketIndexChart'),
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

        function loadgraph() {

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
            const orderSummaryEl = document.querySelector('#orderSummaryChart'),
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
            $('#lastusdtprice').html(number_format($lastPrice) + ' تومان ');
            $('#lastusdtprice2').html(number_format($lastPrice) + ' تومان ');

        }
    </script>
    <script src="/T1assets/js/cards-statistics.js"></script>
@endsection
