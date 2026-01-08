@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')
    <style>
        div.suported {
            width: 120px;
            background-color: #2b4c4f !important;
        }

        i.suported {
            font-size: 40px;
            color: #39da8a !important
        }

        p.suported {
            color: #39da8a !important
        }

        div.unsuported {
            width: 120px;
        }

        i.unsuported {
            font-size: 40px;
            color: #69809a !important
        }

        p.unsuported {
            color: #69809a !important
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">بررسی هوشمند /</span>
            {{ $curencySrc->MainName }}</h4>
        <div class="row">
            <div
                class="card icon-card cursor-pointer text-center mb-4 mx-2 {{ $curencySrc->status == 10 ? 'suported' : 'unsuported' }} ">
                <div class="card-body">
                    <i class="bx bx-trending-up mb-2 {{ $curencySrc->status == 10 ? 'suported' : 'unsuported' }}"></i>
                    <p
                        class="icon-name text-capitalize text-truncate mb-0 {{ $curencySrc->status == 10 ? 'suported' : 'unsuported' }} ">
                        spot</p>
                </div>
            </div>
            <div
                class="card icon-card cursor-pointer text-center mb-4 mx-2 {{ $curencySrc->future ? 'suported' : 'unsuported' }}">
                <div class="card-body">
                    <i class="bx bxs-directions mb-2 {{ $curencySrc->future ? 'suported' : 'unsuported' }}"></i>
                    <p
                        class="icon-name text-capitalize text-truncate mb-0 {{ $curencySrc->future ? 'suported' : 'unsuported' }}">
                        future</p>
                </div>
            </div>
            <div
                class="card icon-card cursor-pointer text-center mb-4 mx-2 {{ $curencySrc->isMarginEnabled ? 'suported' : 'unsuported' }}">
                <div class="card-body">
                    <i class="bx bxs-tachometer mb-2  {{ $curencySrc->isMarginEnabled ? 'suported' : 'unsuported' }}"></i>
                    <p
                        class="icon-name text-capitalize text-truncate mb-0  {{ $curencySrc->isMarginEnabled ? 'suported' : 'unsuported' }}">
                        Margin</p>
                </div>
            </div>
            <div class="card icon-card cursor-pointer text-center mb-4 mx-2 unsuported">
                <div class="card-body">
                    <i class="bx bxs-cctv mb-2 unsuported"></i>
                    <p class="icon-name text-capitalize text-truncate mb-0  unsuported">Monitor</p>
                </div>
            </div>

        </div>
        
        <div class="row">

            <div class="col-xl-4 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <!-- Order Summary -->

                        <!-- Sales History -->
                        <div class="col-md-12 col-12 px-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">موقعیت در کانال {{ $curencySrc->MainName }}</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mt-1">موقعیت قیمت در کانال </h6>
                                <p class="mb-4">نمایشگر موقعت قرار گرفتن قیمت در بازه کانال قیمتی </p>
                                <ul class="list-unstyled m-0 pt-0">
                                    <li class="mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar avatar-sm flex-shrink-0 me-2">
                                                <span id="daypositon_icon_span" class="avatar-initial rounded "> <i
                                                        class="bx bx-dizzy"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-muted text-nowrap">پیشنهاد معامله در تایم فریم روزانه
                                                </p>
                                                <small id="daypositon_txt" class="fw-semibold text-nowrap">0%</small>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 6px">
                                            <div id="daypositon_bar" class="progress-bar bg-primary" style="width: 41%"
                                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </li>
                                    <li>

                                        قرار گرفتن قیمت، نسبت به نوسان قیمت در ۲۴ ساعت گذشته
                                        <p>درصد اعلام شده بر اساس فاصله از ۵۰٪ کندل روزانه است</p>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <div class="col-md-12 col-12 px-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">بررسی میزان رشد {{ $curencySrc->MainName }}</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mt-1">میزان رشد رمز ارز</h6>
                                <p class="mb-4">نمایشگر میزان رشد نمایش دهنده رشد کلی ارز است</p>
                                <ul style="text-align: center" class="list-unstyled m-0 pt-0">
                                    <div id="IncreasementAnl_loader" style="text-align: center;display: inline-block;"
                                        class="col">
                                        <div class="sk-wave sk-primary">
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                        </div>
                                    </div>
                                    <div id="IncreasementAnl" class="chartobj mb-2"></div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <div class="col-md-12 col-12 px-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">بررسی حجمی {{ $curencySrc->MainName }}</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mt-1">میزان رشد رمز ارز</h6>
                                <p class="mb-4">نمایشگر میزان رشد نمایش دهنده رشد کلی ارز است</p>
                                <ul style="text-align: center" class="list-unstyled m-0 pt-0">
                                    <div id="UnderSpace_loader" style="text-align: center;display: inline-block;"
                                        class="col">
                                        <div class="sk-wave sk-primary">
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                        </div>
                                    </div>
                                    <div id="UnderSpace" class="chartobj mb-2"></div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <div class="col-md-12 col-12 px-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">گراف قیمت {{ $curencySrc->MainName }}</h5>
                            </div>
                            <div style="height: 500px;" class="card-body">
                                <iframe id="tradingview_4c8ef"
                                    src="https://s.tradingview.com/widgetembed/?frameElementId=tradingview_4c8ef&amp;symbol={{ $curencySrc->MainName }}USDT&amp;interval=H&amp;hidesidetoolbar=0&amp;symboledit=0&amp;saveimage=1&amp;toolbarbg=f4f7f9&amp;studies=%5B%5D&amp;hideideas=1&amp;theme=dark&amp;timezone=Asia%2FTehran&amp;withdateranges=1&amp;studies_overrides=%7B%7D&amp;overrides=%7B%7D&amp;enabled_features=%5B%22header_fullscreen_button%22%2C%22side_toolbar_in_fullscreen_mode%22%2C%22header_in_fullscreen_mode%22%2C%22header_undo_redo%22%2C%22header_settings%22%5D&amp;disabled_features=%5B%22header_saveload%22%5D&amp;locale=en&amp;utm_source=finoward.com&amp;utm_medium=widget&amp;utm_campaign=chart&amp"
                                    style="width: 100%; height: 100%; margin: 0 !important; padding: 0 !important;"
                                    frameborder="0" allowtransparency="true" scrolling="no" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <!-- Order Summary -->

                        <!-- Sales History -->
                        <div class="col-md-12 col-12 px-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">آنالیزور Tradingview</h5>
                            </div>
                            <div style="height: 500px;" class="card-body">
                                <iframe id="data" scrolling="no" allowtransparency="true"
                                    style="box-sizing: border-box; display: block; height: 100%; width: 100%;"
                                    src="https://s.tradingview.com/embed-widget/technical-analysis/?locale=en#%7B%22frameElementId%22%3A%22data%22%2C%22symbol%22%3A%22{{ $curencySrc->MainName }}usdt%22%2C%22width%22%3A%22100%25%22%2C%22colorTheme%22%3A%22dark%22%2C%22interval%22%3A%221h%22%2C%22height%22%3A%22100%25%22%2C%22isTransparent%22%3Afalse%2C%22showIntervalTabs%22%3Atrue%2C%22utm_source%22%3A%22finoward.com%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22technical-analysis%22%2C%22page-uri%22%3A%22finoward.com%2Fmarkets%2Fshib%2Fanalysis-chart%22%7D"
                                    frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        if (isDarkStyle) {

        } else {

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
            // $('.chartobj').html($loader);
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

                    if (status == 'success') {
                        analyzeworker(data);
                    } else {
                        alert('ارتباط با سرور مقدور نیست لطفا بعدا تلاش کنید!');

                    }
                });

        }

        function analyzeloader($CurencyID) {
            loader_set();
            $Result = ajaxcall('analayzeresult', $CurencyID);
            // ajaxcall('volanalyze', $CurencyID);
            // ajaxcall('IncreasementAnl', $CurencyID);
            //  ajaxcall('UnderSpace', $CurencyID);

        }

        function analyzeworker(FurmolaResult) {
            if (FurmolaResult != null) {
                loadgraph('#IncreasementAnl', FurmolaResult['f2']);
                loadgraph('#UnderSpace', FurmolaResult['f3']);
                $('#daypositon_txt').html(FurmolaResult['f1'] + '%');
                $("#daypositon_bar").css("width", FurmolaResult['f1'] + '%');
                if (FurmolaResult['f1'] < 20) {
                    $('#daypositon_icon_span').addClass('bg-label-danger');
                } else {
                    if (FurmolaResult['f1'] < 40) {
                        $('#daypositon_icon_span').addClass('bg-label-warning');
                    } else {
                        if (FurmolaResult['f1'] < 50) {
                            $('#daypositon_icon_span').addClass('bg-label-primary');
                        } else {
                            if (FurmolaResult['f1'] < 60) {
                                $('#daypositon_icon_span').addClass('bg-label-primary');
                            } else {
                                if (FurmolaResult['f1'] < 70) {
                                    $('#daypositon_icon_span').addClass('bg-label-info');
                                } else {
                                    $('#daypositon_icon_span').addClass('bg-label-success');
                                }

                            }

                        }

                    }
                }
            }

        }



        $(document).ready(function() {
            $CurencyID = <?php echo $curencySrc->id; ?>;
            analyzeloader($CurencyID);
        });



        //  loadgraph('#statisticsRadialChart',20)


        function loadgraph(GraphName, PercentVal) {
            $(GraphName + '_loader').addClass('nested');
            $(GraphName + '_loader').css("display", "none");;
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
                                image: '<?php echo $curencySrc->pic; ?>',
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
