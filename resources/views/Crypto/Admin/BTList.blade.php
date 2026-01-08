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
                        <h3>عملیات رمز ارزها
                            <small>لیست بک تست های فعال</small>
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
    </div>

    <div id="graph_price" class="col-md-12 mb-5 nested">
        <div class="card ">
            <div style="text-align: center" class="card-header pink">
                <div class="card-title text-white"><i class="i-Coins"
                        style="font-size: 30px;display: inherit;color: cornsilk;"></i>
                    <div id="graph_title"></div>
                </div>
            </div>
            <div class="card-body">
                <div id="mygraph" style="height: 300px;"></div>
            </div>
        </div>
    </div>


    <div class="row">

        <!-- end of col-->

        <div id="table-continer" class=" col-md-12">
            <form method="post">
                <div class="card o-hidden mb-4">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 id="Table-card-header" class="w-50 float-left card-title m-0"> {{ $pageType }} </h3>
                        <div class="dropdown dropleft text-right w-50 float-right">
                            <button class="btn bg-gray-100" type="button" id="dropdownMenuButton_table_1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="nav-icon i-Gear-2"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table_1">
                                <button class="btn" name="submit" value="updatecurencys">به روز رسانی لیست
                                    ارزها</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">


                        <form method="post">

                            @csrf
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>تاریخ شروع</th>
                                                <th>نام ارز</th>
                                                <th>۵ دقیفه</th>
                                                <th>۱۵ دقیقه</th>
                                                <th>۳۰ دقیقه</th>
                                                <td>۱ ساعته</td>
                                                <td>۲ ساعته</td>
                                                <td>۴ ساعته</td>
                                                <td>۲۴ ساعته</td>
                                                <th>وضعیت</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $Rowno = 1;
                                            @endphp
                                            @foreach ($Curencys as $CurencyItem)
                                                <tr>
                                                    <td> {{ $Persian->MyPersianDate($CurencyItem->created_at, true) }}
                                                    </td>
                                                    <td> <img width="20px" src="{{ $CurencyItem->pic }}" alt="CoinPic">
                                                        {{ $CurencyItem->curency }} </td>
                                                    @if ($CurencyItem->C5MuinPercent == '')
                                                        <td>مقداردهی نشده</td>
                                                    @elseif($CurencyItem->C5MuinPercent < 0)
                                                        <td class="text-danger">{{ $CurencyItem->C5MuinPercent }} % </td>
                                                    @else
                                                        <td class="text-success">{{ $CurencyItem->C5MuinPercent }} % </td>
                                                    @endif
                                                    @if ($CurencyItem->C15MuinPercent == '')
                                                        <td>مقداردهی نشده</td>
                                                    @elseif($CurencyItem->C15MuinPercent < 0)
                                                        <td class="text-danger">{{ $CurencyItem->C15MuinPercent }} % </td>
                                                    @else
                                                        <td class="text-success">{{ $CurencyItem->C15MuinPercent }} % </td>
                                                    @endif
                                                    @if ($CurencyItem->C30MuinPercent == '')
                                                        <td>مقداردهی نشده</td>
                                                    @elseif($CurencyItem->C30MuinPercent < 0)
                                                        <td class="text-danger">{{ $CurencyItem->C30MuinPercent }} % </td>
                                                    @else
                                                        <td class="text-success">{{ $CurencyItem->C30MuinPercent }} % </td>
                                                    @endif
                                                    @if ($CurencyItem->C1HourPercent == '')
                                                        <td>مقداردهی نشده</td>
                                                    @elseif($CurencyItem->C1HourPercent < 0)
                                                        <td class="text-danger">{{ $CurencyItem->C1HourPercent }} % </td>
                                                    @else
                                                        <td class="text-success">{{ $CurencyItem->C1HourPercent }} % </td>
                                                    @endif
                                                    @if ($CurencyItem->C2HourPercent == '')
                                                        <td>مقداردهی نشده</td>
                                                    @elseif($CurencyItem->C2HourPercent < 0)
                                                        <td class="text-danger">{{ $CurencyItem->C2HourPercent }} % </td>
                                                    @else
                                                        <td class="text-success">{{ $CurencyItem->C2HourPercent }} % </td>
                                                    @endif

                                                    @if ($CurencyItem->C4HourPercent == '')
                                                        <td>مقداردهی نشده</td>
                                                    @elseif($CurencyItem->C4HourPercent < 0)
                                                        <td class="text-danger">{{ $CurencyItem->C4HourPercent }} % </td>
                                                    @else
                                                        <td class="text-success">{{ $CurencyItem->C4HourPercent }} % </td>
                                                    @endif

                                                    @if ($CurencyItem->C24HourPercent == '')
                                                        <td>مقداردهی نشده</td>
                                                    @elseif($CurencyItem->C24HourPercent < 0)
                                                        <td class="text-danger">{{ $CurencyItem->C24HourPercent }} % </td>
                                                    @else
                                                        <td class="text-success">{{ $CurencyItem->C24HourPercent }} % </td>
                                                    @endif

                                                    <td>
                                                        @switch($CurencyItem->status)
                                                            @case(0)
                                                                شروع تست
                                                            @break

                                                            @case(1)
                                                                بک تست ۵ دقیقه
                                                            @break

                                                            @case(2)
                                                                بک تست ۱۵ دقیقه
                                                            @break

                                                            @case(3)
                                                                بک تست ۳۰ دقیقه
                                                            @break

                                                            @case(4)
                                                                بک تست ۱ ساعت
                                                            @break

                                                            @case(5)
                                                                بک تست ۲ ساعت
                                                            @break

                                                            @case(6)
                                                                بک تست ۴ ساعت
                                                            @break

                                                            @case(7)
                                                                بک تست ۲۴ ساعت
                                                            @break

                                                            @default
                                                        @endswitch




                                                    </td>
                                                    <td> 
                                                        <p> V:{{ $CurencyItem->OfferType }}</p>
                                                        <a
                                                            href="{{ route('CurencyProfile', ['RequestCurency' => 12]) }}">ویرایش</a>
                                                        <button
                                                            onclick="load_graph(`{{ $CurencyItem->candate }}`,`{{ $CurencyItem->curency }}` )"
                                                            type="button" class="btn btn-success">گراف</button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </form>
        </div>
        <!-- end of col-->
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script>
        function selectalloptions() {
            $(".user-select").prop('checked', true);

        }

        function deselecttalloptions() {
            $(".user-select").prop('checked', false);
        }

        function multiselect() {
            $('#ul-contact-list').DataTable().destroy();
            $('.action-div').addClass('nested');
            $('.select-div').removeClass('nested');
            $('#multi-user-option').removeClass('nested');
        }
    </script>
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
    </script>

    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
            });
        }
    </script>
    <script>
        var selected = new Array();
        $(document).ready(function() {

            $("input[type='checkbox']").on('change', function() {
                // check if we are adding, or removing a selected item
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                } else {
                    for (var i = 0; i < selected.length; i++) {
                        if (selected[i] == $(this).val()) {
                            // remove the item from the array
                            selected.splice(i, 1);
                        }
                    }
                }

                // output selected
                var output = "";
                for (var o = 0; o < selected.length; o++) {
                    if (output.length) {
                        output += ", " + selected[o];
                    } else {
                        output += selected[o];
                    }
                }

                $(".taid").val(output);

            });

        });
    </script>
    <script>
        $(document).ready(function() {
                    $("#L1").change(function() {
                        var num = this.value;
                        $("#L11").css("display", "none");
                    });
    </script>
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>
@endsection


@section('bottom-js')
    <script>
        var values = [];
        var times = [];
        var maxval = 0;
        var minval = 10000000000;

        function load_graph(crypto_candate, crypto_name) {
            $('#graph_price').removeClass('nested');
            $('#graph_title').html(crypto_name);
            $('html, body').animate({
                scrollTop: $("#graph_price").offset().top
            }, 2000);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    AjaxType: 'get_crypto_graph',
                    candate: crypto_candate,
                    curency: crypto_name,
                },
                function(data, status) {
                    data.forEach(myFunction)


                    function myFunction(item, index, arr) {

                        $.each(item, function(index, value) {
                            if (value > maxval) {
                                maxval = value;
                            }
                            if (value < minval) {
                                minval = value;
                            }
                            values.push(value);
                            mydate = new Date(index * 1000);
                            mydate = mydate.toString();
                            [a, b,c,d,eee] = mydate.split(' ');
                            times.push(eee);

                        });

                    }
                    console.log(values);
                    console.log(times);
                    add_graph_to_screen(values, times, minval, maxval)
                });
        }
    </script>
    <script>
        function add_graph_to_screen(values, times, minval, maxval) {
            maxval = maxval + (maxval * 3 / 100);
            minval = minval - (minval * 3 / 100);
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
                        data: times,
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
                        min: minval, // fill by min
                        max: maxval, // fill by max
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
                        name: "قیمت",
                        type: "line",
                        smooth: !0,
                        data: values,
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
        }
    </script>
@endsection
