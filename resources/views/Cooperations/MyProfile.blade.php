@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <div class="breadcrumb">
        <h1>پروفایل اعضای خانواده </h1>
        @if ($UserInfo != null)
            <small>{{ $UserInfo->Name }} {{ $UserInfo->Family }}</small>
        @endif
    </div>

    <div class="row">
        <div  class="  col-lg-2 col-md-3 col-sm-3">
            <div id="card_base_info" onclick="loadforms('base_info')" class=" loader-cards card card-primary card-icon mb-4">
                <div class="card-body text-center"><i class="i-Information"></i>
                    <p class="mt-2 mb-2">اطلاعات پایه</p>
                </div>
            </div>
        </div>
        <div  class=" col-lg-2 col-md-3 col-sm-3">
            <div  id="card_mgt_contacts" onclick="loadforms('mgt_contacts')" class=" loader-cards card card-icon mb-4 card-primary">
                <div class="card-body text-center"><i class="i-Business-Mens"></i>
                    <p class="mt-2 mb-2">اطلاعات مسئولان شرکت</p>
                </div>
            </div>
        </div>
        <div    class=" col-lg-2 col-md-3 col-sm-3">
            <div id="card_workzones" onclick="loadforms('workzones')" class=" loader-cards card card-primary card-icon mb-4">
                <div class="card-body text-center"><i class="i-Affiliate"></i>
                    <p class="mt-2 mb-2">فعالیت و عضویت</p>
                </div>
            </div>
        </div>
        <div   class=" col-lg-2 col-md-3 col-sm-3">
            <div id="card_editor" onclick="loadeditor()"  class=" loader-cards card card-primary card-icon mb-4">
                <div class="card-body text-center"><i class="i-Notepad"></i>
                    <p class="mt-2 mb-2">توضیحات</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-3">
            <div class="loader-cards card card-primary card-icon mb-4">
                <div class="card-body text-center"><i class="i-Bar-Chart"></i>
                    <p class="mt-2 mb-2">آمار بازدید</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-3">
            <div id="card_setting" onclick="loadforms('setting')"  class="loader-cards card card-primary card-icon mb-4">
                <div class="card-body text-center"><i class="i-Gear-2"></i>
                    <p class="mt-2 mb-2">تنظیمات</p>
                </div>
            </div>
        </div>
    </div>
    <div class="basic-input-groups">
        <div class="container-fluid">
            <!-- begin::main-row -->
            <div class="row">
                <!-- begin::main column -->
                <div class="col-lg-12">
                    <div id="from-content" class="row">
                    </div>
                </div>
                <!-- end::main-column -->
            </div>
            <!-- end::main-row -->
        </div>
    </div>
    <div id="main_editor" class=" nested container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">پروفایل اعضای خانواده </h5>
                        <img id="imagepreviw" style="float: left;max-height: 100px;" src="">
                    </div>
                    <div class="card-body">
                        <form id="mainform" method="post" class="needs-validation user-add" novalidate="">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <h4>اطلاعات تکمیلی عضو</h4>
                                    <hr>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> متن <span
                                            style="color: red">*</span></label>
                                </div>
                                @php
                                    $infoText = $Order->get_data('InfoTxt');
                                @endphp
                                @if (Auth::user()->Role == App\myappenv::role_SuperAdmin)
                                    <textarea required id="InfoTxt" required name="ce" class="col-sm-12 form-control">{{ $infoText }} </textarea>
                                @else
                                    <textarea required id="InfoTxt" required name="CustomerInput" class="col-sm-12 form-control">{{ $infoText }} </textarea>
                                @endif
                            </div>
                            <div class="pull-right">
                                <button type="button" onclick="saveextrainfo()" value="register_family"
                                    class="btn btn-primary">
                                    ذخیره
                                </button>
                            </div>
                        </form>

                    </div>

                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="container-fluid px-1 px-sm-4 py-5 mx-auto">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-10 col-lg-9 col-xl-8">
                            <div class="card border-0">
                                <div class="row px-3">
                                    <div class="col-sm-2"> <label class="text-grey mt-1 mb-3">ساعت کاری </label> </div>
                                    <div class="col-sm-10 list">
                                        <div class="mb-2 row justify-content-between px-3">
                                            <select class="mb-2 mob" id="SelectTags">
                                                <option value="شنبه">شنبه</option>
                                                <option value="شنبه-غیرفعال">غیرفعال</option>

                                            </select>
                                            <div class="mob">
                                                <label class="text-grey mr-1">از</label>
                                                <input class="ml-1" type="time" name="from" id='formtime1'>
                                            </div>
                                            <div class="mob mb-2">
                                                <label class="text-grey mr-4">تا</label>
                                                <input class="ml-1" type="time" name="to" id='totime1'>
                                            </div>

                                        </div>
                                        <div class="mb-2 row justify-content-between px-3">
                                            <select class="mb-2 mob" id="SelectTags1">
                                                <option value="یکشنبه">یکشنبه</option>
                                                <option value="یکشنبه-غیرفعال">غیرفعال</option>

                                            </select>
                                            <div class="mob">
                                                <label class="text-grey mr-1">از</label>
                                                <input class="ml-1" type="time" name="from" id='formtime2'>
                                            </div>
                                            <div class="mob mb-2">
                                                <label class="text-grey mr-4">تا</label>
                                                <input class="ml-1" type="time" name="to" id='totime2'>
                                            </div>

                                        </div>
                                        <div class="mb-2 row justify-content-between px-3">
                                            <select class="mb-2 mob" id="SelectTags2">

                                                <option value="دوشنبه">دوشنبه</option>
                                                <option value="دوشنبه-غیرفعال">غیرفعال </option>

                                            </select>
                                            <div class="mob">
                                                <label class="text-grey mr-1">از</label>
                                                <input class="ml-1" type="time" name="from" id='formtime3'>
                                            </div>
                                            <div class="mob mb-2">
                                                <label class="text-grey mr-4">تا</label>
                                                <input class="ml-1" type="time" name="to" id='totime3'>
                                            </div>

                                        </div>
                                        <div class="mb-2 row justify-content-between px-3">
                                            <select class="mb-2 mob" id="SelectTags3">

                                                <option value="سه شنبه">سه شنبه</option>
                                                <option value="سه شنبه-غیرفعال">غیرفعال</option>

                                            </select>
                                            <div class="mob">
                                                <label class="text-grey mr-1">از</label>
                                                <input class="ml-1" type="time" name="from" id='formtime4'>
                                            </div>
                                            <div class="mob mb-2">
                                                <label class="text-grey mr-4">تا</label>
                                                <input class="ml-1" type="time" name="to" id='totime4'>
                                            </div>

                                        </div>
                                        <div class="mb-2 row justify-content-between px-3">
                                            <select class="mb-2 mob" id="SelectTags4">

                                                <option value="چهارشنبه">چهارشنبه</option>
                                                <option value="چهارشنبه-غیرفعال">غیرفعال</option>

                                            </select>
                                            <div class="mob">
                                                <label class="text-grey mr-1">از</label>
                                                <input class="ml-1" type="time" name="from" id='formtime5'>
                                            </div>
                                            <div class="mob mb-2">
                                                <label class="text-grey mr-4">تا</label>
                                                <input class="ml-1" type="time" name="to" id='totime5'>
                                            </div>

                                        </div>
                                        <div class="mb-2 row justify-content-between px-3">
                                            <select class="mb-2 mob" id="SelectTags5">

                                                <option value="پنج شنبه">پنج شنبه</option>
                                                <option value="پنج شنبه-غیرفعال">غیرفعال</option>

                                            </select>
                                            <div class="mob">
                                                <label class="text-grey mr-1">از</label>
                                                <input class="ml-1" type="time" name="from" id='formtime6'>
                                            </div>
                                            <div class="mob mb-2">
                                                <label class="text-grey mr-4">تا</label>
                                                <input class="ml-1" type="time" name="to" id='totime6'>
                                            </div>

                                        </div>
                                        <div class="mb-2 row justify-content-between px-3">
                                            <select class="mb-2 mob" id="SelectTag6">

                                                <option value="جمعه">جمعه</option>
                                                <option value="جمعه-غیرفعال">غیرفعال</option>

                                            </select>
                                            <div class="mob">
                                                <label class="text-grey mr-1">از</label>
                                                <input class="ml-1" type="time" name="from" id='formtime7'>
                                            </div>
                                            <div class="mob mb-2">
                                                <label class="text-grey mr-4">تا</label>
                                                <input class="ml-1" type="time" name="to" id='totime7'>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row px-3 mt-3">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <div class="row px-3">

                                            <button type="button" onclick="addworkingtime()"
                                                class="btn btn-success col-xl-4 col-md-5">افزودن</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                @php
                    $WorkTime = $Order->get_data('WorkTime');

                @endphp
                <div class="card-title"> ساعت کاری در : </div>





            </div>
        </div>
    </div>

    <!-- Container-fluid Ends-->
@endsection
@section('bottom-js')
    <script>
        function addworkingtime() {
            var Day1 = $('#SelectTags').find(":selected").val();
            var Day2 = $('#SelectTags1').find(":selected").val();
            var Day3 = $('#SelectTags2').find(":selected").val();
            var Day4 = $('#SelectTags3').find(":selected").val();
            var Day5 = $('#SelectTags4').find(":selected").val();
            var Day6 = $('#SelectTags5').find(":selected").val();
            var Day7 = $('#SelectTag6').find(":selected").val();
            var form1 = $('#formtime1').val();
            var form2 = $('#formtime2').val();
            var form3 = $('#formtime3').val();
            var form4 = $('#formtime4').val();
            var form5 = $('#formtime5').val();
            var form6 = $('#formtime6').val();
            var form7 = $('#formtime7').val();
            var to1 = $('#totime1').val();
            var to2 = $('#totime2').val();
            var to3 = $('#totime3').val();
            var to4 = $('#totime4').val();
            var to5 = $('#totime5').val();
            var to6 = $('#totime6').val();
            var to7 = $('#totime7').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    submit: 'saveworktime',
                    WorkTime: {
                        Day1: Day1,
                        form1: form1,
                        to1: to1,
                        Day2: Day2,
                        form2: form2,
                        to2: to2,
                        Day3: Day3,
                        form3: form3,
                        to3: to3,
                        Day4: Day4,
                        form4: form4,
                        to4: to4,
                        Day5: Day5,
                        form5: form5,
                        to5: to5,
                        Day6: Day6,
                        form6: form6,
                        to6: to6,
                        Day7: Day7,
                        form7: form7,
                        to7: to7,

                    },


                },
                function(data, status) {
                    if (status == 'success') {
                        alert(data);
                        loadforms('workzones');
                    } else {
                        alert('مشکلی به وجود آمده است');
                    }

                });
        }
    </script>
    <script>
        function saveWorkTime() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    submit: 'saveworktime',
                    WorkTime: $('#WorkTime').val(),


                },

                function(data, status) {
                    if (status == 'success') {
                        alert(data);

                    } else {
                        alert('مشکلی به وجود آمده است');
                    }

                });
        }

        function saveextrainfo() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    submit: 'saveinfo',
                    InfoTxt: $('#InfoTxt').val(),

                },

                function(data, status) {
                    if (status == 'success') {
                        alert(data);
                    } else {
                        alert('مشکلی به وجود آمده است');
                    }

                });
        }

        function loadeditor() {
            $('.loader-cards').removeClass('active-card');
            $('#card_editor').addClass('active-card');
            $('#from-content').html('');
            $('#main_editor').removeClass('nested');
        }
        function loadsetting() {
            $('.loader-cards').removeClass('active-card');
            $('#card_setting').addClass('active-card');
            $('#from-content').html('');
            $('#main_editor').removeClass('nested');
        }

        function loadforms($FormName) {

            $('.loader-cards').removeClass('active-card');
            $('#card_' + $FormName).addClass('active-card');
            $('#main_editor').addClass('nested');

            $.ajax({
                url: '?page=' + $FormName,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#from-content').html(response);

                },
                error: function() {
                    alert('مشکل در ارتباط');
                }
            });
        }

        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    $("#Shahrestan").append(data);
                });
        }
    </script>
    <script>
        function loadfamilyindexes() {
            alert('ssss');
            $.ajax({
                url: '?function=family',
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    alert('salam');
                    $('#familyCat').html(response);

                },
                error: function() {
                    alert('can not');
                }
            });
        }
    </script>

    @include('Layouts.FilemanagerScripts')
    <script>
        function imagesetter() {
            //alert(document.getElementById("modal_pic").value)  ;
            document.getElementById("imagepreviw").src = document.getElementById("modal_pic").value;
            $('#modal_pic1').val(document.getElementById("modal_pic").value);
        }
    </script>
    <script>
        $(document).ready(function() {

            $('.add').click(function() {
                $(".list").append(
                    '<div class="mb-2 row justify-content-between px-3">' +
                    '<select class="mob mb-2" id="dropdownList">' +
                    '<option value="opt1">شنبه</option>' +
                    '<option value="opt2">یکشنبه</option>' +
                    '<option value="opt3">دوشنبه</option>' +
                    '<option value="opt4">سه شنبه</option>' +
                    '<option value="opt5">چهارشنبه</option>' +
                    '<option value="opt6">پنج شنبه</option>' +
                    '<option value="opt7"> جمعه</option>' +
                    '</select>' +
                    '<div class="mob">' +
                    '<label class="text-grey mr-1">از</label>' +
                    '<input class="ml-1" type="time" name="from">' +
                    '</div>' +
                    '<div class="mob mb-2">' +
                    '<label class="text-grey mr-4">تا</label>' +
                    '<input class="ml-1" type="time" name="to">' +
                    '</div>' +
                    '<div class="mt-1 cancel fa fa-times text-danger">' +
                    '</div>' +
                    '</div>');
            });

            $(".list").on('click', '.cancel', function() {
                $(this).parent().remove();
            });

        });
    </script>
@endsection
