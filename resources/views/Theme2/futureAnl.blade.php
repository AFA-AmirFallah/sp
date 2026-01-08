@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Gamification Card -->
            <div class="col-md-6 col-lg-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 class="card-title mb-2">سیگنال خرید روزانه ورژن 3.1
                        </h3>
                        <span class="d-block mb-4 text-nowrap primary-font">بررسی و تحلیل شده با معتبر ترین
                            اندیکاتورها</span><h2 style="text-align: center" class="text-warning">درحال تست</h2>

                    </div>
                    @php
                        $LastTime = $Crypto->GetLastMaIndicator();
                    @endphp
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-6">
                                <div style="display: flex;align-items: baseline;">
                                    <span class="badge bg-label-danger">{{ $LastTime['date'] }} </span>
                                    <h1 class="display-6 text-primary mb-2 pt-3 pb-2"> {{ $LastTime['time'] }}</h1>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <img src="https://finoward.com/storage/photos/admin/app/undertest.png" width="100%" 
                                    class="rounded-start" alt="View Sales">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Gamification Card -->

            <!-- Latest Update -->

            @php
                $MarketSrc = $Crypto->formola_v3_1(5, 'sup', 'short');
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 style="color:red" class="card-title m-0 me-2">پیشنهاد خرید short</h5>
                        <small>کمترین مساحت زیر نمودار</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-2 lh-inherit">
                            <tbody>
                                @foreach ($MarketSrc as $MarketItem)
                                    <tr>
                                        <td class="pt-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img src="{{ $MarketItem->pic }}" alt="coin" width="44"
                                                    class="me-2">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0">{{ $MarketItem->MainName }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="article-votes" style="display: flex;direction:rtl">
                                                @if ($MarketItem->meta_key == 'like')
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bxs-like"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bx-like"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($MarketItem->meta_key == 'dislike')
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bxs-dislike"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bx-dislike"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                <a class="badge bg-label-primary p-2" style="margin-right: 10px" target="_blank"
                                                    href="{{ route('analyze', ['curency' => $MarketItem->MainName]) }}"> بررسی
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @php
                $MarketSrc = $Crypto->formola_v3_1(5, 'Growth', 'short');
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 style="color:red" class="card-title m-0 me-2">پیشنهاد خرید short</h5>
                        <small>روند رشد</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-2 lh-inherit">
                            <tbody>
                                @foreach ($MarketSrc as $MarketItem)
                                    <tr>
                                        <td class="pt-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img src="{{ $MarketItem->pic }}" alt="coin" width="44"
                                                    class="me-2">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0">{{ $MarketItem->MainName }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="article-votes" style="display: flex;direction:rtl">
                                                @if ($MarketItem->meta_key == 'like')
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bxs-like"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bx-like"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($MarketItem->meta_key == 'dislike')
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bxs-dislike"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bx-dislike"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                <a class="badge bg-label-primary p-2" style="margin-right: 10px"  target="_blank"
                                                    href="{{ route('analyze', ['curency' => $MarketItem->MainName]) }}"> بررسی
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @php
                $MarketSrc = $Crypto->formola_v3_1(5, 'sup', 'long');
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 style="color:green"  class="card-title m-0 me-2">پیشنهاد خرید long</h5>
                        <small>کمترین مساحت زیر نمودار</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-2 lh-inherit">
                            <tbody>
                                @foreach ($MarketSrc as $MarketItem)
                                    <tr>
                                        <td class="pt-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img src="{{ $MarketItem->pic }}" alt="coin" width="44"
                                                    class="me-2">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0">{{ $MarketItem->MainName }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="article-votes" style="display: flex;direction:rtl">
                                                @if ($MarketItem->meta_key == 'like')
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bxs-like"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bx-like"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($MarketItem->meta_key == 'dislike')
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bxs-dislike"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bx-dislike"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                <a class="badge bg-label-primary p-2" style="margin-right: 10px"  target="_blank"
                                                    href="{{ route('analyze', ['curency' => $MarketItem->MainName]) }}"> بررسی
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @php
                $MarketSrc = $Crypto->formola_v3_1(5, 'Growth', 'long');
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 style="color:green"  class="card-title m-0 me-2">پیشنهاد خرید long</h5>
                        <small>روند صعودی</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-2 lh-inherit">
                            <tbody>
                                @foreach ($MarketSrc as $MarketItem)
                                    <tr>
                                        <td class="pt-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img src="{{ $MarketItem->pic }}" alt="coin" width="44"
                                                    class="me-2">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0">{{ $MarketItem->MainName }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="article-votes" style="display: flex;direction:rtl">
                                                @if ($MarketItem->meta_key == 'like')
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bxs-like"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bx-like"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($MarketItem->meta_key == 'dislike')
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bxs-dislike"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bx-dislike"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                <a class="badge bg-label-primary p-2" style="margin-right: 10px"  target="_blank"
                                                    href="{{ route('analyze', ['curency' => $MarketItem->MainName]) }}"> بررسی
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Latest Update -->

            <!-- History -->
        </div>
    </div>
    <script></script>
@endsection
@section('EndScripts')
    <script>
        const $DangerLoader = `<div class="spinner-border spinner-border-sm text-danger">`;
        const $SuccessLoader = `<div class="spinner-border spinner-border-sm text-success">`;
        const $ActiveLike = ` <i class="bx bxs-like"></i>`;
        const $DeActiveLike = ` <i class="bx bx-like"></i>`;
        const $ActiveDislike = `<i class="bx bxs-dislike"></i>`;
        const $DeactiveDislike = `<i class="bx bx-dislike"></i>`;
        const $loader = `<div style="text-align: center;display: inline-block;" class="col">
                                        <div class="sk-wave sk-primary">
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                        </div>
                                    </div>`;
        let cardColor, headingColor, borderColor, shadeColor;
        if (isDarkStyle) {
            headingColor = config.colors_dark.axisColor;
            borderColor = config.colors_dark.borderColor;
            shadeColor = 'dark';
        } else {
            headingColor = config.colors.axisColor;
            borderColor = config.colors.borderColor;
            shadeColor = 'light';
        }

        function like($CurencyID) {
            $idStr = $CurencyID.toString();
            $('.like_' + $idStr).html($SuccessLoader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'like',
                    sumnumber: '1',
                    Curency: $CurencyID
                },

                function(data, status) {

                    if (data[0] == 'change') {
                        output = '';
                        output += data[2];
                        if (data[1]) {
                            output += $ActiveLike;
                        } else {
                            output += $DeActiveLike;
                        }
                        $('.like_' + $idStr).html(output);
                    }
                    if (data[3] == 'change') {
                        output = '';
                        output += data[5];
                        if (data[4]) {
                            output += $ActiveLike;
                        } else {
                            output += $DeActiveLike;
                        }
                        $('.dislike_' + $idStr).html(output);
                    }


                });

        }

        function dislike($ID) {
            $idStr = $ID.toString();
            $('.dislike_' + $idStr).html($DangerLoader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'like',
                    sumnumber: '-1',
                    Curency: $idStr
                },

                function(data, status) {
                    if (data[0] == 'change') {
                        output = '';
                        output += data[2];
                        if (data[1]) {
                            output += $ActiveLike;
                        } else {
                            output += $DeActiveLike;
                        }
                        $('.like_' + $idStr).html(output);
                    }
                    if (data[3] == 'change') {
                        output = '';
                        output += ' ' + data[5] + ' ';
                        if (data[4]) {
                            output += $ActiveDislike;
                        } else {
                            output += $DeactiveDislike;
                        }
                        $('.dislike_' + $idStr).html(output);
                    }

                });


        }

        function loader_set() {
            $('.modaltext').html('');
            $('.chartobj').html($loader);
        }

        function ajaxcall($procedure, $CurencyID) {
            $oUTpUT = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: $procedure,
                    Curency: $CurencyID
                },

                function(data, status) {
                    loadgraph('#' + $procedure, data);
                });


        }

        function analyzeloader($CurencyID) {
            loader_set();
            ajaxcall('volanalyze', $CurencyID);
            ajaxcall('IncreasementAnl', $CurencyID);
            ajaxcall('linepercents', $CurencyID);

        }




        //  loadgraph('#statisticsRadialChart',20)


        function loadgraph(GraphName, PercentVal) {
            if (PercentVal <= 20) {
                TargetColor = config.colors.danger;
            }
            if (PercentVal > 20 && PercentVal <= 50) {
                TargetColor = config.colors.warning;
            }
            if (PercentVal > 50 && PercentVal <= 70) {
                TargetColor = config.colors.info;
            }
            if (PercentVal > 70) {
                TargetColor = config.colors.success;
            }
            statisticsRadialChartEl = document.querySelector(GraphName),
                statisticsRadialChartConfig = {
                    series: [PercentVal],
                    labels: ['پیشنهاد خرید'],
                    chart: {
                        height: 190,
                        type: 'radialBar',
                        sparkline: {
                            enabled: true
                        }
                    },
                    colors: [TargetColor],
                    plotOptions: {
                        radialBar: {
                            offsetY: 0,
                            startAngle: -140,
                            endAngle: 140,
                            hollow: {
                                size: '78%',
                                image: assetsPath + 'img/icons/unicons/rocket.png',
                                imageWidth: 24,
                                imageHeight: 24,
                                imageOffsetY: -40,
                                imageClipped: false
                            },
                            track: {
                                strokeWidth: '100%',
                                background: borderColor
                            },
                            dataLabels: {
                                value: {
                                    offsetY: -5,
                                    color: headingColor,
                                    fontSize: '2rem',
                                    fontWeight: '500'
                                },
                                name: {
                                    offsetY: 40,
                                    color: config.colors.secondary,
                                    fontSize: '0.938rem',
                                    fontWeight: '400'
                                }
                            }
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    grid: {
                        padding: {
                            top: -7,
                            bottom: 8
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        },
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    }
                };
            if (typeof statisticsRadialChartEl !== undefined && statisticsRadialChartEl !== null) {
                const statisticsRadialChart = new ApexCharts(statisticsRadialChartEl, statisticsRadialChartConfig);
                statisticsRadialChart.render();
            }
        }

        function loadresultchart() {
            const timeSpentGaugeChartEl = document.querySelector('#timeSpentGaugeChart'),
                timeSpentGaugeChartConfig = {
                    series: [90],
                    labels: ['مدت زمان'],
                    chart: {
                        height: 220,
                        type: 'radialBar',
                        sparkline: {
                            enabled: true
                        }
                    },
                    colors: [config.colors.success],
                    plotOptions: {
                        radialBar: {
                            offsetY: 10,
                            startAngle: -140,
                            endAngle: 140,
                            hollow: {
                                size: '55%'
                            },
                            track: {
                                strokeWidth: '100%',
                                background: borderColor
                            },
                            dataLabels: {
                                name: {
                                    offsetY: -10,
                                    color: headingColor,
                                    fontSize: '1.125rem'
                                },
                                value: {
                                    offsetY: 7,
                                    color: config.colors.secondary,
                                    fontSize: '0.938rem',
                                    fontWeight: 500,
                                    formatter: function(val) {
                                        return val + ' دقیقه';
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    grid: {
                        padding: {
                            top: -35,
                            left: -15,
                            right: -15,
                            bottom: 7
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        },
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    }
                };
            if (typeof timeSpentGaugeChartEl !== undefined && timeSpentGaugeChartEl !== null) {
                const timeSpentGaugeChart = new ApexCharts(timeSpentGaugeChartEl, timeSpentGaugeChartConfig);
                timeSpentGaugeChart.render();
            }
        }
    </script>
@endsection
