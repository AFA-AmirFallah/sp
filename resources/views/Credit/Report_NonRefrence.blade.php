@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')

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
                            <h3>{{ __('Financial report') }}
                                <small>دریافت و پرداخت های بدون مرجع</small>
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
        <p> دریافت پرداخت بدون مرجع {{ __('from Date:') }} {{ $Persian->MyPersianDate($StartDate) }}
            {{ __('to Date:') }}
            {{ $Persian->MyPersianDate($EndDate) }} </p>
        <div class="card-body">
            @php
                $reportdate = '';
                $Counter = 1;
            @endphp
            @if ($NorefrenceCreditReport != [])

                @foreach ($NorefrenceCreditReport as $NorefrenceCredit)
                    @php
                        $phpdate = strtotime($NorefrenceCredit->Confirmdate);
                        $NewDate = date('Y-m-d', $phpdate);
                    @endphp


                    @if ($NewDate != $reportdate)

                        @php
                            $reportdate = $NewDate;
                            $Counter = 1;
                        @endphp

                        <div class="table-responsive">
                            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>کد تراکنش</th>
                                        <th>نام</th>
                                        <th>مبلغ دریافتی</th>
                                        <th>مبلغ پرداختی</th>
                                        <th>اعتبار</th>
                                        <th>توضیحات</th>
                                        <th>تاریخ</th>
                                    </tr>
                                </thead>
                                <tbody>

                    @endif
                    <tr>
                        <td>{{ $Counter++ }}</td>
                        <td>{{ $NorefrenceCredit->ID }}</td>
                        <td>{{ $NorefrenceCredit->Name }} {{ $NorefrenceCredit->Family }}</td>
                        <td>
                            @if ($NorefrenceCredit->Mony > 0)
                                {{ number_format($NorefrenceCredit->Mony) }}
                            @endif
                        </td>
                        <td>
                            @if ($NorefrenceCredit->Mony < 0)
                                {{ number_format($NorefrenceCredit->Mony) }}
                            @endif
                        </td>
                        <td> {{ $NorefrenceCredit->ModName }} </td>
                        <td>{{ $NorefrenceCredit->Note }}</td>
                        <td> {{ $Persian->MyPersianDate($NorefrenceCredit->Confirmdate) }} </td>
                    </tr>

                @endforeach

                </tbody>

                </table>
        </div>
    </div>
@else
    @include("Layouts.nodata")
    @endif
    </div>
@endsection
@section('page-js')

    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>
@endsection
