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
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3> افزودن محتوا
                        </h3>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @include('news.Layouts.news_admin_menu',['active_menu'=>'MakeNews'])
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">محتوا </h5>
                    </div>
                    <div class="card-body">
                        <div style="float: left;" >
                            <a id="advance-show-btn" href="javascript:show_advance();"  class="btn btn-success">نمایش پیشرفته</a>
                            <a id="normal-show-btn" href="javascript:show_normal();"  class="btn btn-info d-none">نمایش عادی</a>
                        </div>
                        <script>
                            function show_advance(){
                                $('#advance-show-btn').addClass('d-none');
                                $('#normal-show-btn').removeClass('d-none');
                                $('.advance').removeClass('d-none');
                            }
                            function show_normal(){
                                $('#advance-show-btn').removeClass('d-none');
                                $('#normal-show-btn').addClass('d-none');
                                $('.advance').addClass('d-none');
                            }
                        </script>

                        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-toggle="tab"
                                    href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><i
                                        data-feather="user" class="mr-2"></i>افزودن مطلب</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                    href="#credite-card" role="tab" aria-controls="top-contact" aria-selected="false"><i
                                        data-feather="credit-card" class="mr-2"></i>افزودن خانواده
                                </a>
                            </li>
                        </ul>

                        <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                            aria-labelledby="top-profile-tab">
                            <form id="mainform" method="post" class="needs-validation user-add" novalidate="">
                                @csrf
                                <br>
                                <div class="advance d-none">
                                    <h4> نوع مطلب</h4>
                                    <hr>
                                    <div class="form-group row" style="margin-top: 14px;margin-right: 20px;">
                                        <div>
                                            <label> مطلب داغ</label>
                                            <input class="form-group" type="checkbox" name="hotnews"
                                                @if (old('hotnews') == 1) checked @endif value="1">

                                        </div>
                                        <div
                                            style="
                                        display: flex;
                                        border-style: dotted;
                                        border-width: 1px;
                                        border-color: green;
                                        padding: 3px;
                                    ">
                                            <div style="margin-right: 20px">
                                                <label> تبلیغ مستقیم</label>
                                                <input class="form-group" type="checkbox" name="adds_Direct"
                                                    @if (old('adds_Direct') == 1) checked @endif value="1">
                                            </div>
                                            <div style="margin-right: 20px">
                                                <label>تبلیغ به مطلب</label>
                                                <input class="form-group" type="checkbox" name="adds_Itself"
                                                    @if (old('adds_Itself') == 1) checked @endif value="1">
                                            </div>
                                            <div style="margin-right: 20px">
                                                <label>بنر اصلی</label>
                                                <input class="form-group" type="checkbox" name="mainbanner"
                                                    @if (old('mainbanner') == 1) checked @endif value="1">
                                            </div>
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>بدون ثبت نظر</label>
                                            <input class="form-group" type="checkbox" name="CloseComment"
                                                @if (old('CloseComment') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>خبرنامه</label>
                                            <input class="form-group" type="checkbox" name="Newslater"
                                                @if (old('Newslater') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>اخبار پربازدید</label>
                                            <input class="form-group" type="checkbox" name="mostview"
                                                @if (old('mostview') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>جدیدترین مطالب</label>
                                            <input class="form-group" type="checkbox" name="lastnews"
                                                @if (old('lastnews') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>گالری تصاویر</label>
                                            <input class="form-group" type="checkbox" name="galery"
                                                @if (old('galery') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>صفحه اول کوچک </label>
                                            <input class="form-group" type="checkbox" name="mini"
                                                @if (old('mini') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>صفحه اول بزرگ</label>
                                            <input class="form-group" type="checkbox" name="larg"
                                                @if (old('larg') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>مطلب</label>
                                            <input class="form-group" type="radio" name="article" checked
                                                value="0">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>سرمقاله</label>
                                            <input class="form-group" type="radio" name="article"
                                                @if (old('article') == 1) checked @endif value="1">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>سرمقاله بی لینک</label>
                                            <input class="form-group" type="radio" name="article"
                                                @if (old('article') == 3) checked @endif value="3">
                                        </div>
                                        <div style="margin-right: 20px">
                                            <label>نمایش به شاخص های همنام</label>
                                            <input class="form-group" type="checkbox" name="sami_index"
                                                @if (old('sami_index') == 1) checked @endif value="1">
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="account" role="tabpanel"
                                        aria-labelledby="account-tab">
                                        <h4>جزئیات مطلب</h4>
                                        <hr>
                                        @if (\App\myappenv::Lic['MultiBranch'])
                                            <div class="form-group row">
                                                <label for="validationCustom0" class="col-xl-3 col-md-3">شعبه <span
                                                        style="color: red">*</span></label>
                                                <select name="target_branch" class="form-control col-xl-3 col-md-3">
                                                    @foreach ($branch_src as $branch_item)
                                                        <option value="{{ $branch_item->id }}">
                                                            {{ $branch_item->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-3"> دسته
                                                خبری <span style="color: red">*</span></label>
                                            <select id="NewsCat" name="NewsCat" class="form-control col-xl-3 col-md-3">
                                                <option>{{ __('--select--') }}</option>
                                                @foreach ($cats as $cat)
                                                    <option @if (old('NewsCat') == $cat->Name) selected="selected" @endif>
                                                        {{ $cat->Name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="validationCustom0" class="col-xl-2 col-md-2">زمان درج<span
                                                    style="color: red">*</span></label>
                                            <input class="form-control col-xl-3 col-md-3" name="CreateDate"
                                                autocomplete="off"
                                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                value="{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}"
                                                type="text" required="">
                                        </div>
                                        <div class="advance d-none">
                                            <div class="form-group row">
                                                <label for="validationCustom0" class="col-xl-3 col-md-3">بهای مطلب</label>
                                                <input class="form-control col-xl-3 col-md-3" name="Price"
                                                    value="{{ old('Price') }}" type="number">
                                                <label for="validationCustom0" class="col-xl-2 col-md-2">پرداخت به
                                                    مالک</label>
                                                <input class="form-control col-xl-3 col-md-3" name="CreatorPrice"
                                                    value="{{ old('CreatorPrice') }}" type="number">
                                            </div>
                                            <div class="form-group row">
                                                <label for="validationCustom0" class="col-xl-3 col-md-3">نویسنده</label>
                                                <input class="form-control col-xl-3 col-md-3" name="Writer"
                                                    value="{{ old('Writer') }}" type="text">
                                                <label for="validationCustom0" class="col-xl-2 col-md-2">مترجم</label>
                                                <input class="form-control col-xl-3 col-md-3" name="ExtTranslater"
                                                    value="{{ old('ExtTranslater') }}" type="text">
                                            </div>
                                            <div class="form-group row">
                                                <label for="validationCustom0" class="col-xl-3 col-md-3">نویسنده
                                                    اصلی</label>
                                                <input class="form-control col-xl-3 col-md-3" name="ExtWriter"
                                                    value="{{ old('ExtWriter') }}" type="text">
                                                <label for="validationCustom0" class="col-xl-2 col-md-2">نام منبع</label>
                                                <input class="form-control col-xl-3 col-md-3" name="RefName"
                                                    value="{{ old('RefName') }}" type="text">
                                            </div>
                                            <div class="form-group row">
                                                <label for="validationCustom0" class="col-xl-3 col-md-3">آدرس منبع</label>
                                                <input class="form-control col-xl-3 col-md-3" name="RefLink"
                                                    value="{{ old('RefLink') }}" type="text">
                                                <label for="validationCustom0" class="col-xl-2 col-md-2"> آدرس
                                                    خارجی</label>
                                                <input id="OutLink" class="form-control col-xl-3 col-md-3"
                                                    name="OutLink" value="{{ old('OutLink') }}" type="text">
                                            </div>
                                            <div class="form-group row">
                                                <label for="validationCustom0" class="col-xl-3 col-md-3">
                                                    سطح تیتر <span style="color: red">*</span></label>
                                                <select name="TitleAccessLevel" class="form-control col-xl-3 col-md-3">
                                                    <option value="0">نمایش به همه</option>
                                                    @foreach ($UserLevel as $UserLevelItem)
                                                        <option value="{{ $UserLevelItem->Role }}"
                                                            @if (old('TitleAccessLevel') == $UserLevelItem->Role) selected="selected" @endif>
                                                            {{ $UserLevelItem->RoleName }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="validationCustom0" class="col-xl-2 col-md-2">
                                                    سطح متن <span style="color: red">*</span></label>
                                                <select name="ContentAccessLevel" class="form-control col-xl-3 col-md-3">
                                                    <option value="0">نمایش به همه</option>
                                                    @foreach ($UserLevel as $UserLevelItem)
                                                        <option value="{{ $UserLevelItem->Role }}"
                                                            @if (old('ContentAccessLevel') == $UserLevelItem->Role) selected="selected" @endif>
                                                            {{ $UserLevelItem->RoleName }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <h4>محتوای خبر</h4>
                                        <hr>
                                        <div class="form-group row advance d-none">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                روتیتر </label>
                                            <input class="form-control col-xl-8 col-md-7" name="UpTitel"
                                                value="{{ old('UpTitel') }}" type="text" required>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                تیتر <span style="color: red">*</span></label>
                                            <input id="maintitr" class="form-control col-xl-8 col-md-7" name="Titel"
                                                value="" type="text">
                                        </div>
                                        <div class="form-group row advance d-none">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                زیر تیتر</label>
                                            <input class="form-control col-xl-8 col-md-7" name="SubTitel"
                                                value="{{ old('SubTitel') }}" type="text" required>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                تصویر <span style="color: red">*</span></label>
                                            <a id="lfm" data-input="modal_pic" data-preview="holder"
                                                class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> انتخاب تصویر
                                            </a>
                                            <input required id="modal_pic" class="form-control nested" required
                                                type="text" name="pic" value="" onchange="imagesetter()">
                                            <img id="imagepreviw" style="max-height: 100px;" src="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> کلمات کلیدی / شاخص
                                        </label>
                                        <select id="SelectTags" name="SelectTags[]"
                                            class="form-control col-xl-8 col-md-7" multiple="multiple">
                                            @foreach ($Tags as $Tag)
                                                <option @if ($Tag->PostId != null) selected="selected" @endif>
                                                    {{ $Tag->Name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4 "> خلاصه مطلب </label>
                                        <textarea name="Abstract" class="form-control col-xl-8 col-md-7">{{ old('Abstract') }} </textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label id="description-txt" style="color: red" class="col-xl-3 col-md-4"> توضیحات
                                            موتور
                                            جستجو - <small id="description-count">0</small> </label>
                                        <textarea name="description" id="description" onkeyup="descriptionCkeker()" class="form-control col-xl-8 col-md-7">{{ old('description') }}  </textarea>
                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4 "> پی نوشت </label>
                                        <textarea name="PostContent" class="form-control col-xl-8 col-md-7">{{ old('PostContent') }} </textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> متن مطلب <span
                                                style="color: red">*</span></label>
                                    </div>

                                    <textarea required id="hiddenArea" required name="ce" class="col-sm-12 form-control">{{ old('ce') }} </textarea>

                                </div>
                                <div class="pull-right">
                                    <button onclick="checkfeilds()" type="button" name="Registeruser" value="register"
                                        class="btn btn-primary">
                                        ذخیره
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="credite-card" role="tabpanel" aria-labelledby="contact-top-tab">
                            <form id="mainform" method="post" class="needs-validation user-add" novalidate="">
                                @csrf
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="account" role="tabpanel"
                                        aria-labelledby="account-tab">
                                        <h4>جزئیات خانواده فرش</h4>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-3"> دسته
                                                خبری <span style="color: red">*</span></label>
                                            <select onclick="loadfamilyindexes()" id="familyCat" name="NewsCat"
                                                class="form-control col-xl-3 col-md-3">
                                                @foreach ($family_index as $family_index_item)
                                                    <option value="{{ $family_index_item->UID }}">
                                                        {{ $family_index_item->Name }}</option>
                                                @endforeach

                                            </select>
                                            <label for="validationCustom0" class="col-xl-2 col-md-2">زمان درج<span
                                                    style="color: red">*</span></label>
                                            <input class="form-control col-xl-3 col-md-3" name="CreateDate"
                                                autocomplete="off"
                                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                value="{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}"
                                                type="text" required="">
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                بالای نام </label>
                                            <input class="form-control col-xl-8 col-md-7" name="UpTitel"
                                                value="{{ old('UpTitel') }}" type="text" required>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                نام شرکت <span style="color: red">*</span></label>
                                            <input id="maintitr" class="form-control col-xl-8 col-md-7" name="Titel"
                                                value="" type="text">
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                پایین نام</label>
                                            <input class="form-control col-xl-8 col-md-7" name="SubTitel"
                                                value="{{ old('SubTitel') }}" type="text" required>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">
                                                تصویر <span style="color: red">*</span></label>
                                            <a id="lfm1" data-input="modal_pic" data-preview="holder"
                                                class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> انتخاب تصویر
                                            </a>
                                            <input required id="modal_pic1" class="nested form-control " required
                                                type="text" name="pic" value="" onchange="imagesetter()">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3"> نام مدیر </label>
                                        <input class="form-control col-xl-3 col-md-3" name="managername"
                                            autocomplete="off" value="" type="text" required="">
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">شماره مدیر</label>
                                        <input class="form-control col-xl-3 col-md-3" name="managerphone"
                                            autocomplete="off" value="" type="text" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> زمینه فعالیت </label>
                                        <textarea name="activity" class="form-control col-xl-8 col-md-7"></textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> نشانی </label>
                                        <textarea name="companyaddress" class="form-control col-xl-8 col-md-7"> </textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> عضویت و وابستگی ها
                                        </label>
                                        <textarea name="membership" class="form-control col-xl-8 col-md-7"></textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> متن مطلب <span
                                                style="color: red">*</span></label>
                                    </div>
                                    <textarea required id="hiddenArea" required name="ce" class="col-sm-12 form-control">{{ old('ce') }} </textarea>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" name="Registeruser" value="register_family"
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
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('bottom-js')
    <script>
        function descriptionCkeker() {
            descriptionval = $('#description').val();
            if (descriptionval.length == 0) {

                $('#description-txt').css("color", "red");
            } else {
                if (descriptionval.length < 100) {
                    $('#description-txt').css("color", "orange");
                } else {
                    if (descriptionval.length < 500) {
                        $('#description-txt').css("color", "green");
                    } else { // overflow
                        $('#description-txt').css("color", "red");
                    }
                }
            }
            $('#description-count').html(descriptionval.length);
        }

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
    <script>
        function check_submit() {
            if ($("#NewsCat option:selected").text() == "--انتخاب--") {
                alert("لطفا دسته خبری را مشخص فرمایید");

            } else {
                if ($("#maintitr").val() == "") {
                    alert("لطفا تیتر را مشخص فرمایید!!");
                } else {
                    if ($('#modal_pic').val() == '') {
                        alert('لطفا تصویر مطلب را انتخاب فرمایید!!');
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

        function checkfeilds() {
            OutLink_val = $('#OutLink').val();
            if (OutLink_val != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        AjaxType: 'check_outlink',
                        OutLink: OutLink_val,
                    },

                    function(data, status) {
                        if (data) {
                            check_submit();
                            return true;
                        } else {
                            alert('لینک خارجی از پیش موحود است!');
                            return true;

                        }

                    });
            } else {
                check_submit();

            }
        }
    </script>
    <script>
        $('select').select2({
            createTag: function(params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {

                    id: params.term,
                    text: params.term
                }
            }
        });
        $("#SelectTags").select2({
            tags: true
        });
        $("#NewsCat").select2({
            tags: true
        });
    </script>
    @include('Layouts.FilemanagerScripts')
    <script>
        function imagesetter() {
            //alert(document.getElementById("modal_pic").value)  ;
            document.getElementById("imagepreviw").src = document.getElementById("modal_pic").value;
            $('#modal_pic1').val(document.getElementById("modal_pic").value);
        }
    </script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection
