@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="loadscreen" id="preloader1" style="display: none;">
        <div class="loader spinner-bubble spinner-bubble-primary">
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>استعلام
                            <small>توان پرداخت</small>
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
    <form method="post">
        @csrf
        <div class="row">
            <div class="col-md-6 card ">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    استعلام توان پرداخت بازنشستگان
                </div>
                <div class="card-body">
                    <h5 class="card-title">لطفا کد ملی بازنشسته را با وضعیت کیبورد انگلیسی وارد فرمایید</h5>
                    <input type="number" class="form-control" name="CodeMelli">
                    <p class="card-text">دقت نمایید کد ملی باید شامل ۱۰ کاراکتر عددی باشد</p>
                    <button type="submit" name="submit" class="btn btn-danger" value="estelam">استعلام</button>
                </div>
            </div>
            @if ($response != null)
                <div class="col-md-6 card ">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        نتیجه استعلام
                    </div>
                    @if ($response == 'notvalid')
                        <p style="color: red">کد ملی وارد شده در سیستم وجود ندارد</p>
                    @else
                        <div class="card-body">
                            <li> نام و نام خانوادگی: {{ $response->fullName }} </li>
                            @if ($response->personType == 'PENSIONER')
                                <li> نوع پرسنلی: مستمری بگیر </li>
                            @else
                                <li> نوع پرسنلی: بازنشسته </li>
                            @endif
                            <li> کد بازنشستگی: {{ $response->identificationCode }} </li>
                            <li> حقوق: {{ number_format($response->hogs) }} ریال </li>
                            <li> مبلغ پرداختی: {{ number_format($response->pard) }} ریال</li>
                            <li> توان پرداخت: {{ number_format($response->tavg) }} ریال</li>
                            <li> مجموع حقوق و مزایا: {{ number_format($response->hogm) }} ریال</li>
                            <li> شماره موبایل: {{ $response->tham }} </li>
                        </div>
                    @endif
                </div>
            @endif
        </div>




    </form>
    <div class="col-md-6 card mt-5">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            استعلام توان پرداخت به صورت گروهی
        </div>
        <div class="card-body">
            <input type="file" id="excel-file" e>
            <button class="btn btn-success" type="button" id="import-excel-btn">استعلام</button>
        </div>
    </div>
    <div class="col-md-12 card mt-5">
        <li><a class="glyphicon glyphicon-export" onclick="exportAllPages()" href="#">خروجی
            اکسل</a></li>
        <div class="card-body">

            <div class="table-responsive">
                <table id="tavanpardakht-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>

                            <th> نام و نام خانوادگی</th>
                            <th> نام</th>
                            <th> نام خانوادگی</th>
                            <th>موبایل</th>
                            <th>توان پرداخت</th>


                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        @endsection
        @section('page-js')
            <script>
                $(function() {
                    $('#import-excel-btn').click(function() {
                        var file = $('#excel-file')[0].files[0];
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var data = e.target.result;
                            var workbook = XLSX.read(data, {
                                type: 'binary'
                            });
                            var sheet_name_list = workbook.SheetNames;
                            var json_data = XLSX.utils.sheet_to_json(workbook.Sheets[sheet_name_list[0]]);
                            $('#preloader1').removeAttr("style");
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.post('<?php echo e(route('ajax')); ?>', {
                                    AjaxType: 'TavanPardakhtGroup',
                                    data: JSON.stringify(json_data),
                                    dataType: 'json',
                                },

                                function(data, status) {
                                    var html="";
                                    $.each(data.data, function(key, value) {
                                        html += "<tr>";
                                        html += "<td>" + value.ExtraInfo + "</td>";
                                        html += "<td>" + value.Name + "</td>";
                                        html += "<td>" + value.Family + "</td>";
                                        html += "<td>" + value.MobileNo + "</td>";
                                        html += "<td>" + value.Tavan + "</td>";
                                        html += "</tr>";
                                    });
                                    $("#tavanpardakht-list tbody").html(html);
                                    $('#preloader1').attr("style", "display: none;");
                                });

                        };

                        reader.readAsBinaryString(file);
                    });
                });
            </script>
             <script>
                function exportAllPages() {
                    $("#tavanpardakht-list").tableExport({

                        formats: ["xlsx"],
                        fileName: "table_data",
                        position: "top",
                        ignoreColumn: [0], // exclude the first column from export
                        ignoreRows: null,
                        trimWhitespace: true,
                        RTL: false,
                        sheetName: "Sheet1",
                        exportButtons: true,
                        pageSize: "all" // export all pages

                    });
                }
            </script>
        @endsection
