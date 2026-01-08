@php
$Persian = new App\Functions\persian();
$maxfeild = 0;
@endphp
@extends("Layouts.MainPage")
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('page-header-left')
    <h3>{{ __('Assign shift') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    @if (!isset($DaramadGraph))
        <form method="post">
            @csrf
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        گزارش 
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-xl-3 col-md-4">{{ __('Start report date') }} </label>
                            <input class="form-control col-xl-4 col-md-3"  required type="text" name="StartDate"
                                value="{{ old('StartDate') }}" autocomplete="off"
                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                placeholder="{{ __('Start report date') }}" />
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-md-4">{{ __('End report date') }} </label>
                            <input class="form-control col-xl-4 col-md-3" required type="text" name="EndDate"
                                value="{{ old('EndDate') }}" autocomplete="off"
                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                placeholder="{{ __('End report date') }}" />

                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-md-4">{{ __('Type of report') }} </label>
                            <select class="form-control col-xl-4 col-md-3" name="ReportType" class="form-control">
                                <option value="0" selected>{{ __("--select--") }}</option>

                            </select>

                        </div>
                        <div class="form-group row col-md-3"></div>
                        <div class="form-group row col-md-6">
                            <button type="submit" class="btn btn-green" name="submit"
                                value="DaramadTable">نمایش</button>
                        </div>
                        <div class="form-group row col-md-3"></div>
                    </div>
                </div>
            </div>
        </form>
    @else
        @if ($showtype == 'DaramadGraph')
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-10">
                        <div class="card-body">
                            <div class="card-title">{{ __('Benefit') }} {{ __('from Date:') }}
                                {{ $Persian->MyPersianDate($StartDate) }} {{ __('to Date:') }}
                                {{ $Persian->MyPersianDate($EndDate) }}
                                <a href="{{ route('DaramadReport') }}">{{ __('Back') }}</a>
                            </div>
                            <div id="mygraph" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="card-body">
                    <div class="card-title">{{ __('Benefit') }} {{ __('from Date:') }}
                        {{ $Persian->MyPersianDate($StartDate) }} {{ __('to Date:') }}
                        {{ $Persian->MyPersianDate($EndDate) }}
                        <a href="{{ route('DaramadReport') }}">{{ __('Back') }}</a>
                    </div>

                    <div class="table-responsive">
                        <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Benefit') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $Rowno = 1;
                                @endphp
                                @foreach ($DaramadGraph as $DaramadGraphTarget)

                                    <tr @if ($DaramadGraphTarget->mony < 0)
                                        class="table-row-danger"
                                @endif
                                >
                                <th>{{ $Rowno++ }}</th>
                                <td>{{ $Persian->MyPersianDate($DaramadGraphTarget->confirmdate) }}</td>
                                <td>{{ number_format($DaramadGraphTarget->mony) }}</td>
                                </tr>
        @endforeach

        </tbody>
        <h3>جزییات درآمد:</h3>

        </table>
        </div>
        <div class="table-responsive">
            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Date') }}</th>
                        <th>تاریخ ثبت </th>
                        <th>{{ __('Transaction code') }}</th>
                        <th>مبلغ </th>
                        <th>{{ __('Note') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $Rowno = 1;
                    @endphp
                    @foreach ($DaramadDetail as $DaramadDetailT)
                        <th>{{ $Rowno++ }}</th>
                        <td>{{ $Persian->MyPersianDate($DaramadDetailT->Date, true ) }}</td>
                        <td>{{ $DaramadDetailT->ID }}</td>
                        <td>{{ $Persian->MyPersianDate($DaramadDetailT->ConfirmdateD) }}</td>
                        <td>{{ number_format($DaramadDetailT->Mony) }}</td>
                        <td>{{ $DaramadDetailT->Note }}</td>
                        </tr>
                    @endforeach



    </tbody>

    </table>
    </div>

    </div>
    </div>

    @endif
    @endif

@endsection


@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>

    @include("Layouts.SearchUserInput_Js")
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
    @if (isset($DaramadGraph))
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
    @endif

@endsection
