@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div id="licens_view" class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <a onclick="loadpage('AddCampin')">
                <div id="AddCampin" class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                    <i class="i-Add-Window text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white"> ثبت کمپین جدید </h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                <i class="i-Address-Book text-32 mr-3"></i>
                <div>
                    <h4 class="text-18 mb-1 text-white"> پیامک انبوه</h4>
                </div>
            </div>
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
        function changeselectors(TargetPage){
            $('.selectors').removeClass('bg-success');
            $('.selectors').addClass('bg-primary');           
            $('#'+TargetPage).addClass('bg-success');
            $('#'+TargetPage).removeClass('bg-primary');
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
        function loadpage_with_data(TargetPage,data) {
            $.ajax({
                url: '?page=' + TargetPage +'&data=' + data,
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
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
    <script>
        function numbertotext(nember) {

            document.getElementById('amountext').innerHTML = nember.toPersianLetter() + ' تومان ';
        }
    </script>
    <script>
        onload = function() {
            var e = document.getElementById('amount');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }

        };
    </script>
@endsection
