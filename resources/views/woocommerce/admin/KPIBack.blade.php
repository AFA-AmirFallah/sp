@php
    $Persian = new App\Functions\persian();
    
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')


    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">تعداد کاربران</div>
                    <div id="userstatistic" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title"> تعداد کل غرفه ها</div>
                    <div id="storestatistic" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
   0 <!-- end of row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Basic Bar chart</div>
                    <div id="basicBar" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Multiple Bar chart</div>
                    <div id="multipleBar" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Multiple Bar chart 2</div>
                    <div id="multipleBar2" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Zoom Bar</div>
                    <div id="zoomBar" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of row -->

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Basic Doughnut</div>
                    <div id="basicDoughnut" style="height: 400px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Gauge Chart</div>
                    <div id="gaugeChart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Basic Area Chart</div>
                    <div id="basicArea" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Stacked Area Chart</div>
                    <div id="stackedArea" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Stacked Area Chart with Pointer</div>
                    <div id="stackedPointerArea" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Solid Area</div>
                    <div id="solidArea" style="height: 300px;"></div>
                </div>
            </div>
        </div>


    </div>
    <!-- end of row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Basic Pie Chart</div>
                    <div id="basicPie" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Stacked Pie Chart</div>
                    <div id="productscats" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of row -->

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Bubble Chart</div>
                    <div id="bubbleChart" style="height: 400px;"></div>
                </div>
            </div>
        </div>


    </div>
    <!-- end of row -->




    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/es5/echarts.script.js') }}"></script>
     --}}


    <script>
        $(document).ready(function() {
            AjaXArr_x = [];
            AjaXArr_y = [];
            $.ajax({
                url: '?page=userstatistic',
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    var $AjaXArr = jQuery.parseJSON(response);

                    $AjaXArr.forEach(element => {
                        AjaXArr_x.push(element['axis_x']);
                        AjaXArr_y.push(element['axis_y']);

                    });
                    var basicLineElem = document.getElementById('userstatistic');
                    if (basicLineElem) {

                        var userstatistic = echarts.init(basicLineElem);
                        userstatistic.setOption({
                            tooltip: {
                                show: true,
                                trigger: 'axis',
                                axisPointer: {
                                    type: 'line',
                                    animation: true
                                }
                            },
                            grid: {
                                top: '10%',
                                left: '40',
                                right: '40',
                                bottom: '40'
                            },
                            xAxis: {
                                type: 'category',
                                data: AjaXArr_x,
                                axisLine: {
                                    show: false
                                },
                                axisLabel: {
                                    show: true
                                },
                                axisTick: {
                                    show: false
                                }
                            },
                            yAxis: {
                                type: 'value',
                                axisLine: {
                                    show: false
                                },
                                axisLabel: {
                                    show: true
                                },
                                axisTick: {
                                    show: false
                                },
                                splitLine: {
                                    show: true
                                }
                            },
                            series: [{
                                data: AjaXArr_y,
                                type: 'line',
                                showSymbol: true,
                                smooth: true,
                                color: '#639',
                                lineStyle: {
                                    opacity: 1,
                                    width: 2
                                }
                            }]
                        });
                        $(window).on('resize', function() {
                            setTimeout(function() {
                                userstatistic.resize();
                            }, 500);
                        });
                    }


                },
                error: function() {
                    alert('can not');
                }
            });
           
        });

    </script>
    <script>
        $(document).ready(function() {
            AjaXArr_x = [];
            AjaXArr_y = [];
            $.ajax({
                url: '?page=storestatistic',
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    var $AjaXArr = jQuery.parseJSON(response);

                    $AjaXArr.forEach(element => {
                        AjaXArr_x.push(element['axis_x']);
                        AjaXArr_y.push(element['axis_y']);

                    });
                    var basicLineElem = document.getElementById('storestatistic');
                    if (basicLineElem) {

                        var userstatistic = echarts.init(basicLineElem);
                        userstatistic.setOption({
                            tooltip: {
                                show: true,
                                trigger: 'axis',
                                axisPointer: {
                                    type: 'line',
                                    animation: true
                                }
                            },
                            grid: {
                                top: '10%',
                                left: '40',
                                right: '40',
                                bottom: '40'
                            },
                            xAxis: {
                                type: 'category',
                                data: AjaXArr_x,
                                axisLine: {
                                    show: false
                                },
                                axisLabel: {
                                    show: true
                                },
                                axisTick: {
                                    show: false
                                }
                            },
                            yAxis: {
                                type: 'value',
                                axisLine: {
                                    show: false
                                },
                                axisLabel: {
                                    show: true
                                },
                                axisTick: {
                                    show: false
                                },
                                splitLine: {
                                    show: true
                                }
                            },
                            series: [{
                                data: AjaXArr_y,
                                type: 'line',
                                showSymbol: true,
                                smooth: true,
                                color: '#639',
                                lineStyle: {
                                    opacity: 1,
                                    width: 2
                                }
                            }]
                        });
                        $(window).on('resize', function() {
                            setTimeout(function() {
                                userstatistic.resize();
                            }, 500);
                        });
                    }


                },
                error: function() {
                    alert('can not');
                }
            });
           
        });

    </script>
  

    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-order-list').DataTable();
    </script>

    <script>
        AjaXArr_x = [];
        AjaXArr_y = [];
        $ArrData = [];
        $ArrDataback = [{
            value: 335,
            name: 'ddddd'
        }, {
            value: 310,
            name: 'dddddd'
        }, {
            value: 274,
            name: 'Alliance advertising'
        }, {
            value: 235,
            name: 'Video Ads'
        }, {
            value: 400,
            name: 'Search Engine'
        }].sort(function(a, b) {
            return a.value - b.value;
        });
        $.ajax({
            url: '?page=productstatisic',
            type: 'get',
            beforeSend: function() {

            },
            success: function(response) {
                var $AjaXArr = jQuery.parseJSON(response);

                $AjaXArr.forEach(element => {
                    $ArrData.push({
                        value: element['cc'],
                        Name: element['Name']
                    })

                });
                console.log($ArrData);
                var stackedPieElem = document.getElementById('productscats');
                if (stackedPieElem) {
                    var productscats = echarts.init(stackedPieElem);
                    productscats.setOption({
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        color: ['#639', '#63845', '#ebcb37', '#a1b968', '#0d94bc', '#135bba'],

                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },

                        visualMap: {
                            show: false,
                            min: 80,
                            max: 600,
                            inRange: {
                                colorLightness: [0, 1]
                            }
                        },
                        series: [{
                            name: 'Source',
                            type: 'pie',
                            radius: '85%',
                            center: ['50%', '50%'],
                            data: $ArrData,
                            roseType: 'radius',
                            label: {
                                normal: {
                                    textStyle: {
                                        color: '#333'
                                    }
                                }
                            },
                            labelLine: {
                                normal: {
                                    lineStyle: {
                                        color: '#333'
                                    },
                                    smooth: 0.2,
                                    length: 10,
                                    length2: 20
                                }
                            },
                            itemStyle: {
                                normal: {
                                    color: 'rgb(102, 51, 153)',
                                    shadowBlur: 200,
                                    shadowColor: 'rgba(0, 0, 0, 0.0)'
                                }
                            },

                            animationType: 'scale',
                            animationEasing: 'elasticOut',
                            animationDelay: function animationDelay(idx) {
                                return Math.random() * 200;
                            }
                        }]
                    });
                    $(window).on('resize', function() {
                        setTimeout(function() {
                            productscats.resize();
                        }, 500);
                    });
                }


            },
            error: function() {
                alert('can not');
            }
        });
    </script>
   
@endsection
