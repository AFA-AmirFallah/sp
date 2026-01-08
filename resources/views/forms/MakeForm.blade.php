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
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#form_mgt">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('MakeForm') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i  class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-white"> افزودن فرم</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('FormsList') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: green" class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">لیست فرمها</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="color: orange" class="i-Pen-4"></i>
                    <div class="content">
                        <p class="text-primary mt-2 mb-0">ویرایش فرم</p>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class="header-icon i-File"></i> محتوای فرم</h5>
                        <img id="imagepreviw" style="float: left;max-height: 100px;" src="">
                    </div>
                    
                    <div class="card-body">
                        <form id="mainform" method="post" class="needs-validation user-add" novalidate="">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            تیتر <span style="color: red">*</span></label>
                                        <input id="maintitr" class="form-control col-xl-8 col-md-7" name="title"
                                            value="{{ old('title') }}" type="text">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            روتیتر </label>
                                        <input class="form-control col-xl-8 col-md-7" name="up_title"
                                            value="{{ old('up_title') }}" type="text" required>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            زیر تیتر</label>
                                        <input class="form-control col-xl-8 col-md-7" name="sub_title"
                                            value="{{ old('sub_title') }}" type="text" required>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3">
                                            تولید و ویرایش توسط: <span style="color: red">*</span></label>
                                        <select name="AdminAccessLevel" class="form-control col-xl-3 col-md-3">
                                            <option value="0"> همه</option>
                                            @foreach ($UserLevel as $UserLevelItem)
                                                <option value="{{ $UserLevelItem->Role }}"
                                                    @if (old('AdminAccessLevel') == $UserLevelItem->Role) selected="selected" @endif>
                                                    {{ $UserLevelItem->RoleName }}</option>
                                            @endforeach
                                        </select>
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">
                                            متعلق به <span style="color: red">*</span></label>
                                        <select name="UserAccessLevel" class="form-control col-xl-3 col-md-3">
                                            <option value="0"> همه</option>
                                            @foreach ($UserLevel as $UserLevelItem)
                                                <option value="{{ $UserLevelItem->Role }}"
                                                    @if (old('UserAccessLevel') == $UserLevelItem->Role) selected="selected" @endif>
                                                    {{ $UserLevelItem->RoleName }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            تصویر <span style="color: red">*</span></label>
                                        <a id="lfm" data-input="modal_pic" data-preview="holder"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                                        </a>
                                        <input required id="modal_pic" class="form-control nested" required type="text"
                                            name="pic" value="" onchange="imagesetter()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> خلاصه مطلب </label>
                                    <textarea name="Abstract" class="form-control col-xl-8 col-md-7">{{ old('Abstract') }} </textarea>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> پی نوشت </label>
                                    <textarea name="PostContent" class="form-control col-xl-8 col-md-7">{{ old('PostContent') }} </textarea>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> متن فرم <span
                                            style="color: red">*</span></label>
                                </div>
                                <textarea required id="hiddenArea" required name="ce" class="col-sm-12 form-control">{{ old('ce') }} </textarea>
                            </div>
                            <div class="pull-right">
                                <button type="submit" name="submit" value="register" class="btn btn-primary">
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
