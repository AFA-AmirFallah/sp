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
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-white"> افزودن خدمت</p>
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
            <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="color: orange" class="i-Pen-4"></i>
                    <div class="content">
                        <p class="text-primary mt-2 mb-0">ویرایش خدمت</p>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <form method="post">
        @csrf

        <div class="2-columns-form-layout">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h5 class="text-white"><i class=" header-icon i-Loading-2"></i> افزودن خدمت
                                </h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                @if (App\myappenv::version < 3)
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1" class="ul-form__label">تصویر خدمت</label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="modal_pic" data-preview="holder"
                                                        class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                    </a>
                                                </span>
                                                <input id="modal_pic" class="form-control" type="text" name="pic"
                                                    onchange="imagesetter()" value="{{ old('pic') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1"
                                                class="ul-form__label">{{ __('image preview') }}</label>
                                            </span>
                                            <img style="max-height: 100px" id="imagepreviw" src="{{ old('pic') }}">
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">

                                            <label for="inputEmail1" class="ul-form__label">نوع خدمت

                                            </label>
                                            <input type="radio" class="form-control" name="ServiceType" value="nomony">
                                            <small class="ul-form__text form-text ">
                                                بدون مبلغ
                                            </small>
                                        </div>
                                        <div class="form-group col-md-2">

                                            <label for="inputEmail1" class="ul-form__label">نوع خدمت

                                            </label>
                                            <input type="radio" checked class="form-control" name="ServiceType"
                                                value="withmony">
                                            <small class="ul-form__text form-text ">
                                                قابل انجام
                                            </small>
                                        </div>
                                        <div class="form-group col-md-2">

                                            <label for="inputEmail1" class="ul-form__label">نوع خدمت

                                            </label>
                                            <input type="radio" class="form-control" name="ServiceType" value="sharik">
                                            <small class="ul-form__text form-text ">
                                                شریک بر درآمد
                                            </small>
                                        </div>

                                    </div>
                                @endif
                                <div class="form-row">
                                    <div class="form-group col-md-6">

                                        <label for="inputEmail1" class="ul-form__label">نام خدمت

                                        </label>
                                        <input type="text" class="form-control" required name="RespnsTypeName"
                                            placeholder="نام خدمت" value="">
                                        <small class="ul-form__text form-text ">
                                            نام خدمت
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">توضیح کوتاه خدمت

                                        </label>
                                        <input type="text" class="form-control" name="MainDescription"
                                            placeholder="توضیح کوتاه خدمت" value="">
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            توضیح کوتاه خدمت
                                        </small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div id="time_dev" class="price_type " style="display: contents">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ دریافت ساعتی
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" id="get_price_h"
                                                    onkeyup="price_to_persian(`#get_price_h`)"
                                                    class="form-control price_type_input" name="CustomerhPrice"
                                                    placeholder="مبلغ به ریال" value="{{ old('CustomerhPrice') }}">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید از مشتری دریافت شود
                                                </small>
                                                <div class="number_text" id="get_price_h_text"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ پرداخت ساعتی
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" id="pay_price_h" onkeyup="price_to_persian(`#pay_price_h`)" class="form-control price_type_input"
                                                    name="hPrice" placeholder="مبلغ به ریال"
                                                    value="{{ old('hPrice') }}}">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید به خدمات دهنده پرداخت شود
                                                </small>
                                                <div class="number_text" id="pay_price_h_text"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="session_dev" class="price_type nested" style="display: contents">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ دریافت جلسه ای
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" class="form-control price_type_input" id="get_price_s"
                                                onkeyup="price_to_persian(`#get_price_s`)"
                                                    name="CustomerfixPrice" placeholder="مبلغ به ریال" value="">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید از مشتری دریافت شود
                                                </small>
                                                <div class="number_text" id="get_price_s_text"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ پرداخت جلسه ای
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="number" id="pay_price_s" onkeyup="price_to_persian(`#pay_price_s`)" class="form-control price_type_input"
                                                    name="fixPrice" placeholder="مبلغ به ریال"
                                                    value="{{ old('fixPrice') }}">
                                                <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                    مبلغی که می باید به خدمات دهنده پرداخت شود
                                                </small>
                                                <div class="number_text" id="pay_price_s_text"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 ">
                                        <label for="inputEmail5" class="ul-form__label">نوع خدمت</label>
                                        <div class="ul-form__radio-inline">
                                            <label class=" ul-radio__position radio radio-primary form-check-inline">
                                                <input onclick="set_price_type('#time_dev')" type="radio" checked
                                                    name="price_type" value="1">
                                                <span class="ul-form__radio-font"> <i style="font-size: 20px"
                                                        class="i-Stopwatch"></i> خدمت بر اساس زمان</span>
                                                <span class="checkmark"></span>
                                            </label>
                                            <span style="width: 10px;"></span>
                                            <label class="ul-radio__position radio radio-primary">
                                                <input onclick="set_price_type('#session_dev')" type="radio"
                                                    name="price_type" value="2">
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
                                            $('.number_text').html('');
                                        }
                                    </script>
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">وضعیت خدمت

                                        </label>
                                        <div class="input-right-icon">
                                            <select name="Status" class="form-control">
                                                <option value="0">قابل ارائه نیست</option>
                                                <option value="1">قابل ارائه</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">سرفصل کل ملی

                                        </label>
                                        <div class="input-right-icon">
                                            <select name="UserCreditIndex" class="form-control">
                                                <option value="0">لطفا انتخاب کنید</option>
                                                @foreach ($usercreditindexs as $usercreditindex)
                                                    <option value="{{ $usercreditindex->IndexID }}">
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
                                                        <option value="{{ $TashimItem->id }}">
                                                            {{ $TashimItem->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="ul-form__label"> کد خدمت (اختیاری)
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="text" class="form-control" name="center_id"
                                                    placeholder="کد خدمت" value="">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="custom-separator"></div>
                                <div class="card">
                                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                        <div class="text-white card-title">
                                            <i class=" header-icon i-Library"></i> شاخص های هوشمند
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6><i class="i-First-Aid" style="font-size: 20px"></i> شاخص خدمت</h6>
                                        <div style="background-color: blue;padding-bottom: 20px;padding-top: 20px;border-radius: 5px;"
                                            class="form-row">
                                            <div class="col-lg-3">
                                                <p class="text-white">شاخص اصلی</p>
                                                <select class="form-control" name="WorkCat" id="WorkCatSelectBox_1"
                                                    onchange="WorkCatSelect('_1')">
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($WorkCats as $WorkCat)
                                                        <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="text-white">شاخص لایه اول</p>
                                                <select class="form-control" name="L1Work" id="L1Select_1"
                                                    onchange="L1Selectfun('_1')" disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L1Works as $L1Work)
                                                        <option class="OptionL1_1 OptionL1_wc_1{{ $L1Work->WorkCat }}"
                                                            value="{{ $L1Work->L1ID }}"> {{ $L1Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="text-white">شاخص لایه دوم</p>
                                                <select class="form-control" name="L2Work" id="L2Select_1"
                                                    onchange="L2Selectfun('_1')" disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L2Works as $L2Work)
                                                        <option
                                                            class="OptionL2_1 OptionL2_wc_1{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                                                            value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="text-white"> شاخص هدف </p>
                                                <select class="form-control" name="L3Work" id="L3Select_1" disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L3Works as $L3Work)
                                                        <option
                                                            class="OptionL3_1 OptionL3_wc_1{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                                                            value="{{ $L3Work->UID }}"> {{ $L3Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="custom-separator"></div>
                                        <h6><i class="i-Cool-Guy" style="font-size: 20px"></i> شاخص خدمات دهنده </h6>
                                        <div style="background-color: green;padding-bottom: 20px;padding-top: 20px;border-radius: 5px;"
                                            class="form-row">
                                            <div class="col-lg-3">
                                                <p class="text-white">شاخص اصلی</p>
                                                <select class="form-control" name="WorkCat" id="WorkCatSelectBox_2"
                                                    onchange="WorkCatSelect('_2')">
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($WorkCats as $WorkCat)
                                                        <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="text-white">شاخص لایه اول</p>
                                                <select class="form-control" name="L1Work" id="L1Select_2"
                                                    onchange="L1Selectfun('_2')" disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L1Works as $L1Work)
                                                        <option class="OptionL1_2 OptionL1_wc_2{{ $L1Work->WorkCat }}"
                                                            value="{{ $L1Work->L1ID }}"> {{ $L1Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="text-white">شاخص لایه دوم</p>
                                                <select class="form-control" name="L2Work" id="L2Select_2"
                                                    onchange="L2Selectfun('_2')" disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L2Works as $L2Work)
                                                        <option
                                                            class="OptionL2_2 OptionL2_wc_2{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                                                            value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="text-white"> شاخص هدف </p>
                                                <select class="form-control" name="worker_index" id="L3Select_2"
                                                    disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L3Works as $L3Work)
                                                        <option
                                                            class="OptionL3_2 OptionL3_wc_2{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                                                            value="{{ $L3Work->UID }}"> {{ $L3Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="custom-separator"></div>
                                        <h6><i class="i-Business-Man" style="font-size: 20px"></i> شاخص خدمات گیرنده</h6>
                                        <div style="background-color: orange;padding-bottom: 20px;padding-top: 20px;border-radius: 5px;"
                                            class="form-row">
                                            <div class="col-lg-3">
                                                <p>شاخص اصلی</p>
                                                <select class="form-control" name="WorkCat" id="WorkCatSelectBox_3"
                                                    onchange="WorkCatSelect('_3')">
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($WorkCats as $WorkCat)
                                                        <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p>شاخص لایه اول</p>
                                                <select class="form-control" name="L1Work" id="L1Select_3"
                                                    onchange="L1Selectfun('_3')" disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L1Works as $L1Work)
                                                        <option class="OptionL1_3 OptionL1_wc_3{{ $L1Work->WorkCat }}"
                                                            value="{{ $L1Work->L1ID }}"> {{ $L1Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p>شاخص لایه دوم</p>
                                                <select class="form-control" name="L2Work" id="L2Select_3"
                                                    onchange="L2Selectfun('_3')" disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L2Works as $L2Work)
                                                        <option
                                                            class="OptionL2_3 OptionL2_wc_3{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                                                            value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <p> شاخص هدف </p>
                                                <select class="form-control" name="customer_index" id="L3Select_3"
                                                    disabled>
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($L3Works as $L3Work)
                                                        <option
                                                            class="OptionL3_3 OptionL3_wc_3{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                                                            value="{{ $L3Work->UID }}"> {{ $L3Work->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            <textarea name="ce" class="form-control"></textarea>

                                        </div>
                                    </div>
                                @endif
                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-danger m-1" name="submit"
                                                    value="AddService">افزودن خدمت
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
        function price_to_persian(handler) {
            input_number = $(handler).val();
            input_text = input_number.toPersianLetter() + ' تومان ';
            $(handler + '_text').html(input_text);
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
