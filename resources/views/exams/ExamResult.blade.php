@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>آزمون
                            <small> آزمون‌های من</small>
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
        <hr>
        <div class="row">
            @foreach ($MyExamsSrc as $MyExamsItem)
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title"> آزمون : {{ $MyExamsItem->NameFa }}</h3>
                        </div>

                        <form method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        {{ $MyExam->get_exam_order_status_txt($MyExamsItem->status) }}
                                    </div>
                                    @if ($MyExamsItem->exam_result != null)
                                        @foreach ($MyExam->get_result($MyExamsItem->exam_result) as $Point)
                                            {{ $Point['PointName'] }} : {{ $Point['Pointvalue'] }}
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" name="Print" value="{{ $MyExamsItem->id }}"
                                                class="btn  btn-primary m-1">دانلود نتیجه آزمون</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- end::form -->
                    </div>

                </div>
            @endforeach



        </div>
    </div>
@endsection
@section('page-js')
@endsection
