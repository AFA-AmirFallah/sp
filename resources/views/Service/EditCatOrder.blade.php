@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('Header')
@endsection

@section('MainCountent')
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#req_mgt">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('AddCatOrder') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary">افزودن درخواست</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CatOrderList') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: green" class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">لیست درخواست ها</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Pen-4"></i>
                    <div class="content">
                        <p class="text-white mt-2 mb-0">ویرایش درخواست</p>

                    </div>
                </div>
            </div>
        </div>
        @if (\App\myappenv::version >= 3 && \App\myappenv::Branch == Auth::user()->branch)
            <div class=" col-lg-3 col-md-6 col-sm-6 ">
                <a href="{{ route('branch_order_req') }}">
                    <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i style="color: red" class="i-Cloud-"></i>
                            <div class="content">
                                <p class=" mt-2 mb-0 text-primary"> افزودن درخواست شعبه </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

    </div>

    <form method="post">
        @csrf

        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h5 class="text-white"><i class=" header-icon i-Aim"></i> ویرایش نوع درخواست
                                </h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label">نام درخواست</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="modal_pic" data-preview="holder"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                </a>
                                            </span>
                                            <input id="modal_pic" class="form-control" type="text" name="pic"
                                                onchange="imagesetter()" value="{{ $CatOrder->Pic }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label">{{ __('image preview') }}</label>
                                        </span>
                                        <img id="imagepreviw" src="{{ $CatOrder->Pic }}">
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">

                                        <label for="inputEmail1" class="ul-form__label">نام خدمت

                                        </label>
                                        <input type="text" class="form-control" name="RespnsTypeName"
                                            placeholder="نام خدمت" value="{{ $CatOrder->Cat }}">
                                        <small class="ul-form__text form-text ">
                                            نام خدمت
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">توضیح کوتاه درخواست

                                        </label>
                                        <input type="text" class="form-control" name="MainDescription"
                                            placeholder="توضیح کوتاه خدمت" value="{{ $CatOrder->TitleDescription }}">
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            توضیح کوتاه خدمت
                                        </small>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">توضیحات

                                        </label>

                                    </div>

                                </div>
                                <div class="row ">
                                    <div class="input-right-icon col-md-12">
                                        <textarea name="ce" class="form-control"> {{ $CatOrder->MainDescription }} </textarea>

                                    </div>
                                </div>
                                @include('objects.index_object')
                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-danger m-1" name="submit"
                                                    value="EditeService">ثبت ویرایش درخواست
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-js')
    <script>
        function submitter(myid) {
            if ($('#' + myid).val() != '') {
                if (myid != 'WorkCatAddInput') {
                    $('#WorkCatAddInput').val('');
                }
                if (myid != 'L1AddInput') {
                    $('#L1AddInput').val('');
                }
                if (myid != 'L2AddInput') {
                    $('#L2AddInput').val('');
                }
                if (myid != 'L3AddInput') {
                    $('#L3AddInput').val('');
                }

                $("#targetform").submit();
            } else {
                alert('مقدار ورودی نمی تواند خالی باشد');
            }


        }

        function WorkCatSelect() {
            if ($('#WorkCatSelectBox').val() != 0) {
                $(".OptionL1").hide();
                var TargetL1Show = '.OptionL1_wc' + $('#WorkCatSelectBox').val();
                $(TargetL1Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);

            } else {
                $('#L1Select').prop('disabled', true);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L1Selectfun() {
            if ($('#L1Select').val() != 0) {
                var TargetL2Show = '.OptionL2_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val();
                $(".OptionL2").hide();
                $(TargetL2Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L2Selectfun() {
            if ($('#L2Select').val() != 0) {
                var TargetL3Show = '.OptionL3_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val() + '_L2' + $(
                    '#L2Select').val();
                $(".OptionL3").hide();
                $(TargetL3Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', false);

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);
            }
        }
    </script>
    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
            });
        }
    </script>
    <script>
        function newindex() {
            $('#newindexinput').attr("disabled", false);
            $('#Oldindexinput').attr("disabled", true);

        }

        function oldindex() {
            $('#newindexinput').attr("disabled", true);
            $('#Oldindexinput').attr("disabled", false);
        }
    </script>
    <script>
        function imagesetter() {
            //alert(document.getElementById("modal_pic").value)  ;
            document.getElementById("imagepreviw").src = document.getElementById("modal_pic").value;
        }
    </script>
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
@endsection
