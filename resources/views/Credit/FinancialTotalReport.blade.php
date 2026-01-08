@php
    $Persian= new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section("page-header-left")

@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{__("Financial report")}}
                            <small>{{__("Total report")}}</small>
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
    @if($DaramadGraph == null )
        <form method="post">
            @csrf
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        {{__("Total report in date zone" )}}
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-xl-2 col-md-4">{{__('Start report date')}}  </label>
                            <input class="form-control col-xl-2 col-md-3" type="text" name="StartDate"
                                   value="{{old('StartDate')}}"
                                   autocomplete="off"
                                   onfocus="Mh1PersianDatePicker.Show(this,'{{$Persian->MyPersianDate(date("Y-m-d"),false,"n")}}',)"
                                   placeholder="{{__('Start report date')}}"/>
                            <label class="col-xl-2 col-md-4">{{__("Financial index")}}  </label>
                            <select name="CreditMod" class="form-control col-xl-4 col-md-3">
                                <option value="0">{{__("--select--")}}</option>
                                    @foreach($UserCreditModMeta as $UserCreditModMetaItem)
                                        @if($UserCreditModMetaItem->ID == old('CreditMod') && old('CreditMod') != 0 )
                                            <option value="{{$UserCreditModMetaItem->ID}}"
                                                    selected>{{$UserCreditModMetaItem->ModName}}</option>

                                        @else
                                            <option
                                                value="{{$UserCreditModMetaItem->ID}}">{{$UserCreditModMetaItem->ModName}}</option>
                                        @endif
                                    @endforeach
                            </select>

                        </div>
                        <div class="form-group row">
                            <label class="col-xl-2 col-md-4">{{__('End report date')}}  </label>
                            <input class="form-control col-xl-2 col-md-3" type="text" name="EndDate"
                                   value="{{old('EndDate')}}"
                                   autocomplete="off"
                                   onfocus="Mh1PersianDatePicker.Show(this,'{{$Persian->MyPersianDate(date("Y-m-d"),false,"n")}}',)"
                                   placeholder="{{__('End report date')}}"/>
                            <label class="col-xl-2 col-md-4">{{__("Report present")}}  </label>
                            <select name="Showtype" class="form-control col-xl-4 col-md-3">
                                <option disabled value="1">{{__("Show graph")}}</option>
                                <option value="2" selected>{{__("Show Table")}}</option>
                            </select>

                        </div>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-default" name="submit"
                                    value="DaramadGraph">{{__("Show")}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        @if($showtype == 2 )

            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    {{$Description}}
                    <a style="float: left" href="{{route('FinancialTotalReport')}}">{{__('Back')}}</a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                            <thead>
                            <tr>
                                <th>{{__("No.")}}</th>
                                <th>{{__("Service")}}</th>
                                <th>{{__("Credite")}}</th>
                                <th>{{__("Get price")}}</th>
                                <th>{{__("Pay price")}}</th>
                                <th>{{__("Benefit")}}</th>
                                <th>{{__('Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $Rowno = 1;
$index = null;
$input = 0;
$output = 0;
$daramad =0;
                            @endphp
                            @foreach($Report as $ReportItem)
                                @if($index == null || $index == $ReportItem->IndexName)

                                    @php
                                        if($index == null)
                                            $index = $ReportItem->IndexName;
                                    @endphp

                                @else
                                    <tr style="background-color: aqua;">
                                        <td> -</td>
                                        <td>** {{$index}} **</td>
                                        <td>{{__('Sum of service index')}} </td>
                                        <td>{{ number_format($input) }}</td>
                                        <td>{{ number_format($output) }}</td>
                                        <td>{{ number_format($daramad) }}</td>
                                        <td>--</td>
                                    </tr>
                                    @php
                                        $index = $ReportItem->IndexName;
    $input = 0;
    $output = 0;
    $daramad =0;
                                    @endphp
                                @endif
                                <tr>
                                    <td>{{$Rowno++}}</td>
                                    <td>{{$ReportItem->IndexName}}</td>
                                    <td>{{$ReportItem->ModName}}</td>
                                    <td>{{ number_format($ReportItem->input) }}</td>
                                    <td>{{ number_format($ReportItem->output) }}</td>
                                    <td>{{ number_format($ReportItem->daramad) }}</td>
                                    <td>{{ $Persian->MyPersianDate($ReportItem->Confirmdate)}}</td>
                                </tr>
                                @php
                                    $input += $ReportItem->input;
                                    $output += $ReportItem->output;
                                    $daramad +=$ReportItem->daramad;
                                @endphp
                            @endforeach
                            @if($input != 0)
                                <tr style="background-color: aqua;">
                                    <td> -</td>
                                    <td>** {{$index}} **</td>
                                    <td>{{__('Sum of service index')}} </td>
                                    <td>{{ number_format($input) }}</td>
                                    <td>{{ number_format($output) }}</td>
                                    <td>{{ number_format($daramad) }}</td>
                                    <td>--</td>
                                </tr>

                            @endif

                            </tbody>

                        </table>

                    </div>
                </div>
                @else

                    <div class=" col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">{{$Description}}</div>
                                <div id="TargetChart"></div>
                            </div>
                        </div>
                    </div>

                @endif
                @endif
            <!-- Container-fluid Ends-->

                @endsection
                @section('page-js')


                <!-- page script -->
                    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

                    <script>
                        $('#ul-contact-list').DataTable();
                    </script>

                    <script src="{{url('/')}}/persian-datepicker/Mh1PersianDatePicker.js"></script>
                    <script src="{{asset('assets/js/vendor/apexcharts.min.js')}}"></script>
                    <script src="{{asset('assets/js/vendor/apexcharts.dataseries.js')}}"></script>
                    <script src="{{asset('assets/js/es5/apexChart.script.min.js')}}"></script>


                @endsection
                @section('bottom-js')
                    @if($DaramadGraph != null )
                        <script>
                            data = {
                                chart: {height: 350, type: "line", zoom: {enabled: !1}},
                                dataLabels: {enabled: !1},
                                stroke: {width: [5, 7, 5], curve: "smooth", dashArray: [0, 8, 5]},
                                series: [ @php
                                    echo $DaramadGraph;
                                @endphp],
                                markers: {size: 0, hover: {sizeOffset: 6}},
                                xaxis: {
                                    categories: [@php
                                        echo $DateList;
                                    @endphp]
                                },
                                tooltip: {
                                    y: [{
                                        title: {
                                            formatter: function (e) {
                                                return e
                                            }
                                        }
                                    }, {
                                        title: {
                                            formatter: function (e) {
                                                return e
                                            }
                                        }
                                    }, {
                                        title: {
                                            formatter: function (e) {
                                                return e
                                            }
                                        }
                                    }]
                                },
                                grid: {borderColor: "#f1f1f1"}
                            };
                            new ApexCharts(document.querySelector("#TargetChart"), data).render();


                        </script>
        @endif


@endsection

