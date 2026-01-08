@php
    $Persian= new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section("page-header-left")

@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div style="float: left;" class="row">
        <button  class="btn btn-primary mb-sm-0 mb-3 print-invoice">پرینت گزارش</button>
    </div>
    <div id="print-area">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{__('Financial report')}}
                            <small>{{__('tafzili report')}}</small>
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
    <hr>
    <p> {{__("tafzili report")}} {{__("from Date:")}} {{$Persian->MyPersianDate($StartDate)}}  {{__("to Date:")}}  {{$Persian->MyPersianDate($EndDate)}}  </p>
       <div class="card-body">
            @php
                $reportdate = '';
$Counter = 1;
            @endphp
            @if($MoeinCreditReport != [])

                @foreach($MoeinCreditReport as $MoeinCredit)

                    @if($MoeinCredit->ReportConfirmdate != $reportdate)
                        @php
                            $reportdate =$MoeinCredit->ReportConfirmdate ;
    $Counter = 1;
                        @endphp

                        <div class="table-responsive">
                            <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>خدمت</th>
                                    <th>مبلغ دریافتی</th>
                                    <th>مبلغ پرداختی</th>
                                    <th>درآمد</th>
                                    <th>اعتبار</th>
                                    <th>تاریخ</th>
                                    <th>کد مرجع</th>
                                </tr>
                                </thead>
                                <tbody>

                                @endif
                                <tr>
                                    <td>{{$Counter++}}</td>
                                    <td>{{$MoeinCredit->RespnsTypeName}}</td>
                                    <td>{{number_format($MoeinCredit->input)}}</td>
                                    <td>{{number_format($MoeinCredit->output)}}</td>
                                    <td>{{number_format($MoeinCredit->daramad)}}</td>
                                    <td>{{$MoeinCredit->ModName}}</td>
                                    <td> {{$Persian->MyPersianDate($MoeinCredit->ReportConfirmdate)}}   </td>
                                    <td> {{$MoeinCredit->RelatedCredite}}  <br>کارفرما:    {{$MoeinCredit->OwnerName}}  <br>نیرو:   {{$MoeinCredit->workername}}    </td>
                                </tr>
                                @endforeach

                                </tbody>

                            </table>
                        </div>
                    @else
                        @include("Layouts.nodata")
                    @endif
        </div>
    </div>
@endsection
@section('page-js')

    <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
    <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('assets/js/invoice.script.js')}}"></script>
@endsection
