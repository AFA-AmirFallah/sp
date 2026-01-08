@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>تم ساز
                            <small>مدیریت المانهای تم</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>محتوای المان</h5>
                        <img id="imagepreviw" style="float: left;max-height: 100px;" src="">
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="account-tab" data-toggle="tab"
                                    href="#account" role="tab" aria-controls="account" aria-selected="true"
                                    data-original-title="" title=""> افزودن
                                    المان</a>
                            </li>

                        </ul>
                        <div class="row">
                            <div class="col-lg-3">
                                <p>سرفصل </p>
                                <select class="form-control" name="WorkCat" id="WorkCatSelectBox"
                                    onchange="WorkCatSelect()">
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($WorkCats as $WorkCat)
                                        <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p>سردسته </p>
                                <select class="form-control" name="L1Work" id="L1Select" onchange="L1Selectfun()"
                                    disabled>
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($L1Works as $L1Work)
                                        <option class="OptionL1 OptionL1_wc{{ $L1Work->WorkCat }}"
                                            value="{{ $L1Work->L1ID }}"> {{ $L1Work->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p>دسته بندی سرفصل </p>
                                <select class="form-control" name="L2Work" id="L2Select" onchange="L2Selectfun()"
                                    disabled>
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($L2Works as $L2Work)
                                        <option
                                            class="OptionL2 OptionL2_wc{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                                            value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <p>دسته </p>
                                <select class="form-control" name="L3Work" id="L3Select" disabled>
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($L3Works as $L3Work)
                                        <option
                                            class="OptionL3 OptionL3_wc{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                                            value="{{ $L3Work->UID }}"> {{ $L3Work->UID }} - {{ $L3Work->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr>
                        <form id="mainform" method="post" class="needs-validation user-add" novalidate="">
                            @csrf

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <h4>جزئیات المان</h4>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3">
                                            سطح المان <span style="color: red">*</span></label>
                                        <select name="UserRole" class="form-control col-xl-3 col-md-3">
                                            <option value="0">نمایش به همه</option>
                                            @foreach ($UserLevel as $UserLevelItem)
                                                <option value="{{ $UserLevelItem->Role }}" @if (old('TitleAccessLevel') == $UserLevelItem->Role) selected="selected" @endif>
                                                    {{ $UserLevelItem->RoleName }}</option>
                                            @endforeach
                                        </select>
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">
                                            تم <span style="color: red">*</span></label>
                                        <select name="ContentAccessLevel" class="form-control col-xl-3 col-md-3">
                                            <option value="0" selected>تمام تم ها</option>
                                            @foreach (app\myappenv::Themes as $Themes)
                                                <option value="{{ $Themes[0] }}">{{ $Themes[1] }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group row">
                                        <input style="visibility:hidden" id="tableID" name="tableid">
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">ترتیب</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="number" id="modal_order" name="order"
                                                required placeholder="ترتیب(کیبورد در حالت انگلیسی باشد)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">کدتم</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="themecode" type="number" name="theme" required
                                                placeholder="کد تم">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">صفحه</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="number" id="modal_page" name="Page" required
                                                placeholder="صفحه (کیبورد در حالت انگلیسی باشد)">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">لینک به آدرس</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="modal_link" name="link" required
                                                value="#" placeholder="آدرس">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">تایتل</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="modal_title" required name="title"
                                                placeholder="تایتل">
                                        </div>
                                    </div>
                                    <fieldset class="form-group">
                                        <div class="row">
                                            <div class="col-form-label col-sm-2 pt-0">وضعیت</div>
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="modal_active"
                                                        name="staus" id="gridRadios1" value="1" checked="">
                                                    <label class="form-check-label ml-3" for="gridRadios1">
                                                        فعال
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="modal_deactive"
                                                        name="staus" id="gridRadios2" value="0">
                                                    <label class="form-check-label ml-3" for="gridRadios2">
                                                        غیر فعال
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            تصویر <span style="color: red">*</span></label>
                                        <a id="lfm" data-input="modal_pic" data-preview="holder"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                                        </a>
                                        <input id="modal_pic" class="form-control nested" required type="text" name="pic"
                                            value="" onchange="imagesetter()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> شاخص </label>
                                    <select id="SelectTags" name="SelectTags[]" class="form-control col-xl-8 col-md-7"
                                        multiple="multiple">
                                        @foreach ($L3Works as $Tag)
                                            <option @if ($Tag->PostId != null) selected="selected" @endif>
                                                {{ $Tag->Name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> متن المان <span
                                            style="color: red">*</span></label>
                                </div>

                                <textarea required id="hiddenArea" required name="ce"
                                    class="col-sm-12 form-control">{{ old('ce') }} </textarea>

                            </div>
                            <div class="pull-right">
                                <button onclick="checkfeilds()" type="button" name="Registeruser" value="register"
                                    class="btn btn-primary">
                                    ذخیره
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
@section('bottom-js')
    <script>
        function checkfeilds() {
            if ($("#modal_page").val() == "") {
                alert("لطفا صفحه را مشخص فرمایید!!");
            } else {
                if ($("#themecode").val() == "") {
                    alert("لطفا کد تم را مشخص فرمایید!!");
                } else {

                    if ($("#modal_order").val() == "") {
                        alert("لطفا ترتیب تم را مشخص فرمایید!!");
                    } else {

                        if ($("#modal_title").val() == "") {
                            alert("لطفا ترتیب تم را مشخص فرمایید!!");
                        } else {
                            if ($('#hiddenArea').val() == '') {
                                alert('لطفا متن مطلب را وارد فرمایید!!');
                            } else {
                                $('#mainform').submit()
                            }
                        }
                    }

                }

            }

        }
    </script>
    @include('Layouts.FilemanagerScripts')
    <script>
        function imagesetter() {
            //alert(document.getElementById("modal_pic").value)  ;
            document.getElementById("imagepreviw").src = document.getElementById("modal_pic").value;
        }
    </script>
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


@endsection
