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
                        <h3>مدیریت
                            <small> آزمون ها</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-3">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div id="licens_view" class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <a onclick="loadpage('AddExam')">
                <div id="AddExam" class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                    <i class="i-Add-Window text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white">آزمون جدید</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <a onclick="loadpage('ExamList')">
                <div id="ExamList" class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                    <i class="i-Address-Book text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white">لیست آزمون ها</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <a onclick="loadpage('CampinLsit')">
                <div id="CampinLsit" class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                    <i class="i-Myspace text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white">لیست کمپین ها </h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                <i class="i-Newspaper-2 text-32 mr-3"></i>
                <div>
                    <h4 class="text-18 mb-1 text-white">سایت خبری</h4>

                </div>
            </div>
        </div>
    </div>
    <hr>
    <div id="main_content">

    </div>
@endsection
@section('page-js')
    <script>
        function changeselectors(TargetPage) {
            $('.selectors').removeClass('bg-success');
            $('.selectors').addClass('bg-primary');
            $('#' + TargetPage).addClass('bg-success');
            $('#' + TargetPage).removeClass('bg-primary');
        }

        function loadpage(TargetPage) {
            changeselectors(TargetPage);
            $.ajax({
                url: '?page=' + TargetPage,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#main_content').html(response);

                },
                error: function() {
                    alert('can not');
                }
            });
        }


        function loadpage_with_data(TargetPage, data) {
            $.ajax({
                url: '?page=' + TargetPage + '&data=' + data,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#main_content').html(response);

                },
                error: function() {
                    alert('can not');
                }
            });
        }
    </script>
    @include('Layouts.FilemanagerScripts')
@endsection
