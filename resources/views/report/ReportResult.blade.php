@php
    $Persian = new App\Functions\persian();
    $maxfeild = 0;
@endphp
@extends('Layouts.MainPage')
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('page-header-left')
    <h3>{{ $report_src->report_name}}
        <small>{{ $report_src->description}}</small>
    </h3>
@endsection
@section('MainCountent')
    <div class="d-sm-flex mb-5" data-view="print">
        <span class="m-auto"></span>
        <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
    </div>
    <div class="row">
        <div class="card-body">
            <div class="card-title">{{ __('Benefit') }} {{ __('from Date:') }}
                {{ $Persian->MyPersianDate($StartDate) }} {{ __('to Date:') }}
                {{ $Persian->MyPersianDate($EndDate) }}
                <a href="{{ route('DaramadReport') }}">{{ __('Back') }}</a>
            </div>
            <div id="print-area">
                <div class="table-responsive">
                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                @foreach ($data_src[0] as $column_name => $col_value)
                                    <th>{{ $column_name }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $Rowno = 1;
                            @endphp
                            @foreach ($data_src as $data_name)
                                <tr>
                                    @foreach ($data_name as $data_item)
                                        <td>{{ $data_item }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>

    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>


    @include('Layouts.SearchUserInput_Js')
@endsection
