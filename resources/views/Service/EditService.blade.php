@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('Header')
@endsection

@section('MainCountent')
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#Services_mgt">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('Addservice') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary"> افزودن خدمت</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('ServiceList') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: green" class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">لیست خدمات</p>

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
                        <p class="text-white mt-2 mb-0">ویرایش خدمت</p>

                    </div>
                </div>
            </div>
        </div>

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
                                <h5 class="text-white"><i class=" header-icon i-Newsvine"></i> ویرایش خدمات
                            </div>

                            <!--begin::form-->
                            <div class="card-body">
                                @if (App\myappenv::version < 3)
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1" class="ul-form__label">نام خدمت</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="modal_pic" data-preview="holder"
                                                        class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                    </a>
                                                </span>
                                                <input id="modal_pic" class="form-control" type="text" name="pic"
                                                    onchange="imagesetter()" value="{{ $RespnsType->ImgURL }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1"
                                                class="ul-form__label">{{ __('image preview') }}</label>
                                            </span>
                                            <img style="max-height: 100px" id="imagepreviw" src="{{ $RespnsType->ImgURL }}">
                                        </div>

                                    </div>
                                @endif
                                <div class="form-row">
                                    <div class="form-group col-md-6">

                                        <label for="inputEmail1" class="ul-form__label">نام خدمت

                                        </label>
                                        <input type="text" class="form-control" name="RespnsTypeName"
                                            placeholder="نام خدمت" value="{{ $RespnsType->RespnsTypeName }}">
                                        <small class="ul-form__text form-text ">
                                            نام خدمت
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">توضیح کوتاه خدمت

                                        </label>
                                        <input type="text" class="form-control" name="MainDescription"
                                            placeholder="توضیح کوتاه خدمت" value="{{ $RespnsType->Description }}">
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            توضیح کوتاه خدمت
                                        </small>
                                    </div>
                                </div>
                                @if (App\myappenv::version < 3)
                                    <div class="form-row">
                                        <div class="form-group col-md-2">

                                            <label for="inputEmail1" class="ul-form__label">نوع خدمت

                                            </label>
                                            <input type="radio" class="form-control" name="ServiceType"
                                                @if ($RespnsType->ServiceType == 1) checked @endif value="nomony">
                                            <small class="ul-form__text form-text ">
                                                بدون مبلغ
                                            </small>
                                        </div>
                                        <div class="form-group col-md-2">

                                            <label for="inputEmail1" class="ul-form__label">نوع خدمت

                                            </label>

                                            <input type="radio" class="form-control"
                                                @if ($RespnsType->ServiceType == 2) checked @endif name="ServiceType"
                                                value="withmony">
                                            <small class="ul-form__text form-text ">
                                                قابل انجام
                                            </small>
                                        </div>
                                        <div class="form-group col-md-2">

                                            <label for="inputEmail1" class="ul-form__label">نوع خدمت

                                            </label>
                                            <input type="radio" class="form-control"
                                                @if ($RespnsType->ServiceType == 3) checked @endif name="ServiceType"
                                                value="sharik">
                                            <small class="ul-form__text form-text ">
                                                شریک بر درآمد
                                            </small>
                                        </div>

                                    </div>
                                @endif

                                <div class="form-row">
                                    <div id="time_dev"
                                        class="price_type @if ($RespnsType->price_type != 1) nested @endif "
                                        style="display: contents">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ دریافت ساعتی
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" class="form-control price_type_input"
                                                    name="CustomerhPrice" placeholder="مبلغ به ریال"
                                                    value="{{ $RespnsType->CustomerhPrice }}">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید از مشتری دریافت شود
                                                </small>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ پرداخت ساعتی
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" class="form-control price_type_input"
                                                    name="hPrice" placeholder="مبلغ به ریال"
                                                    value="{{ $RespnsType->hPrice }}">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید به خدمات دهنده پرداخت شود
                                                </small>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="session_dev"
                                        class="price_type @if ($RespnsType->price_type != 2) nested @endif"
                                        style="display: contents">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ دریافت جلسه ای
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" class="form-control price_type_input"
                                                    name="CustomerfixPrice" placeholder="مبلغ به ریال"
                                                    value="{{ $RespnsType->CustomerfixPrice }}">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید از مشتری دریافت شود
                                                </small>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ پرداخت جلسه ای
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" class="form-control price_type_input"
                                                    name="fixPrice" placeholder="مبلغ به ریال"
                                                    value="{{ $RespnsType->fixPrice }}">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید به خدمات دهنده پرداخت شود
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 ">
                                        <label for="inputEmail5" class="ul-form__label">نوع خدمت</label>
                                        <div class="ul-form__radio-inline">
                                            <label class=" ul-radio__position radio radio-primary form-check-inline">
                                                <input onclick="set_price_type('#time_dev')" type="radio"
                                                    @if ($RespnsType->price_type == 1) checked @endif name="price_type"
                                                    value="1">
                                                <span class="ul-form__radio-font"> <i style="font-size: 20px"
                                                        class="i-Stopwatch"></i> خدمت بر اساس زمان</span>
                                                <span class="checkmark"></span>
                                            </label>
                                            <span style="width: 10px;"></span>
                                            <label class="ul-radio__position radio radio-primary">
                                                <input onclick="set_price_type('#session_dev')" type="radio"
                                                    name="price_type" @if ($RespnsType->price_type == 2) checked @endif
                                                    value="2">
                                                <span class="ul-form__radio-font"><i style="font-size: 20px"
                                                        class="i-Handshake"></i> خدمت بر اساس جلسه</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            خدمات جلسه ای خدماتی هستند که مبنای محاسبات آنها جلسه می باشد و خدمات بر اساس
                                            زمان مبنای محاسبه آنها ساعت می باشد
                                        </small>
                                    </div>
                                    <script>
                                        function set_price_type(input_var) {
                                            $('.price_type').addClass('nested');
                                            $(input_var).removeClass('nested');
                                            $('.price_type_input').val(0);
                                        }
                                    </script>


                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">وضعیت خدمت

                                        </label>
                                        <div class="input-right-icon">
                                            <select name="Status" class="form-control">
                                                <option value="0" @if ($RespnsType->Status == '0') selected @endif>
                                                    قابل ارائه نیست
                                                </option>
                                                <option value="1" @if ($RespnsType->Status == '1') selected @endif>
                                                    قابل ارائه
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">سرفصل کل مالی

                                        </label>
                                        <div class="input-right-icon">
                                            <select name="UserCreditIndex" class="form-control">
                                                <option value="0">لطفا انتخاب کنید</option>
                                                @foreach ($usercreditindexs as $usercreditindex)
                                                    <option @if ($RespnsType->UserCreditIndex == $usercreditindex->IndexID) selected @endif
                                                        value="{{ $usercreditindex->IndexID }}">
                                                        {{ $usercreditindex->IndexName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if (App\myappenv::version < 3)
                                        <div class="form-group col-md-6">
                                            <label class="ul-form__label"> روال مالی

                                            </label>
                                            <div class="input-right-icon">
                                                <select name="tashim" class="form-control">
                                                    <option value="0">لطفا انتخاب کنید</option>
                                                    @foreach ($TashimSrc as $TashimItem)
                                                        @if ($RespnsType->tashim == $TashimItem->id)
                                                            <option selected value="{{ $TashimItem->id }}">
                                                                {{ $TashimItem->Name }}</option>
                                                        @else
                                                            <option value="{{ $TashimItem->id }}">
                                                                {{ $TashimItem->Name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="ul-form__label"> کد خدمت (اختیاری)
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="text" class="form-control" name="center_id"
                                                    placeholder="کد خدمت" value="{{ $RespnsType->center_id }}">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="custom-separator"></div>
                                @include('objects.index_object')

                                <div class="custom-separator"></div>
                                @if (App\myappenv::version < 3)
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">توضیحات

                                            </label>

                                        </div>

                                    </div>
                                    <div class="row ">
                                        <div class="input-right-icon col-md-12">
                                            <textarea name="ce" class="form-control"> {{ $RespnsType->MainDescription }} </textarea>

                                        </div>
                                    </div>
                                @endif


                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-danger m-1" name="submit"
                                                    value="EditeService">ویرایش خدمت
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
    <form method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                مدیریت تسهیم
            </div>
            <div class="card-body">
                <div class=" col-lg-8 col-xl-8 col-md-8">
                    @php
                        if ($RespnsType->extra == null) {
                            $local_tashims = [];
                        } else {
                            $estra = json_decode($RespnsType->extra);
                            $local_tashims = $estra->tashim;
                        }
                    @endphp
                    <p>روش تسهیم</p>
                    @foreach ($TashimSrc as $TashimsItem)
                        @php
                            $Exist = false;
                        @endphp
                        @foreach ($local_tashims as $TashimItemTarget)
                            @php
                                if ($TashimItemTarget == $TashimsItem->id) {
                                    $Exist = true;
                                }
                            @endphp
                        @endforeach
                        <div class="form-check">
                            @if ($TashimsItem->Operation == 1)
                                <input style="margin-left: 10px;margin-right:10px;" name="tashim[]"
                                    value="{{ $TashimsItem->id }}" @if ($Exist) checked @endif
                                    class="form-check-input" type="checkbox">
                                <label style="margin-left: 10px;margin-right:44px;"
                                    class="form-check-label">{{ $TashimsItem->Name }}</label>
                                <small>{{ $TashimsItem->Note }}</small>
                            @endif
                        </div>
                    @endforeach
                    <hr>
                    <button type="submit" class="btn btn-success" name="submit" value="submit_tashim">ثبت
                        تسهیم</button>
                </div>
            </div>
        </div>


    </form>
@endsection



@section('page-js')
    <script>
        function WorkCatSelect(div_id) {
            if ($('#WorkCatSelectBox' + div_id).val() != 0) {
                $(".OptionL1" + div_id).hide();
                var TargetL1Show = '.OptionL1_wc' + div_id + $('#WorkCatSelectBox' + div_id).val();
                $(TargetL1Show).show();
                $('#L1Select' + div_id).prop('disabled', false);
                $('#L2Select' + div_id).prop('disabled', true);
                $('#L3Select' + div_id).prop('disabled', true);

            } else {
                $('#L1Select' + div_id).prop('disabled', true);
                $('#L2Select' + div_id).prop('disabled', true);
                $('#L3Select' + div_id).prop('disabled', true);
            }
        }

        function L1Selectfun(div_id) {
            if ($('#L1Select' + div_id).val() != 0) {
                var TargetL2Show = '.OptionL2_wc' + div_id + $('#WorkCatSelectBox' + div_id).val() + '_L1' + $('#L1Select' +
                    div_id).val();
                $(".OptionL2" + div_id).hide();
                $(TargetL2Show).show();
                $('#L1Select' + div_id).prop('disabled', false);
                $('#L2Select' + div_id).prop('disabled', false);
                $('#L3Select' + div_id).prop('disabled', true);

            } else {
                $('#L1Select' + div_id).prop('disabled', false);
                $('#L2Select' + div_id).prop('disabled', true);
                $('#L3Select' + div_id).prop('disabled', true);
            }
        }

        function L2Selectfun(div_id) {
            if ($('#L2Select' + div_id).val() != 0) {
                var TargetL3Show = '.OptionL3_wc' + div_id + $('#WorkCatSelectBox' + div_id).val() + '_L1' + $('#L1Select' +
                    div_id).val() + '_L2' + $(
                    '#L2Select' + div_id).val();
                $(".OptionL3" + div_id).hide();
                $(TargetL3Show).show();
                $('#L1Select' + div_id).prop('disabled', false);
                $('#L2Select' + div_id).prop('disabled', false);
                $('#L3Select' + div_id).prop('disabled', false);

            } else {
                $('#L1Select' + div_id).prop('disabled', false);
                $('#L2Select' + div_id).prop('disabled', false);
                $('#L3Select' + div_id).prop('disabled', true);
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
