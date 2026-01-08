@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('Header')
@endsection
@section('page-header-left')
    <h3>{{ __('Assign shift') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <form method="post">
        @csrf

        <div class="2-columns-form-layout">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title"> افزودن مجوز</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="form-group col-md-2">
                                        <input type="radio" class="form-control" name="type" value="1">
                                        <small class="ul-form__text form-text ">
                                            بدون مبلغ
                                        </small>
                                    </div>
                                    <div class="form-group col-md-2">

                                        <input type="radio" checked class="form-control" name="type"
                                            value="2">
                                        <small class="ul-form__text form-text ">
                                            مبلغ دار
                                        </small>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">

                                        <label for="inputEmail1" class="ul-form__label">نام مجوز

                                        </label>
                                        <input type="text" class="form-control" required name="Name"
                                            placeholder="نام مجوز" value="">
                                        <small class="ul-form__text form-text ">
                                            نام مجوز
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">

                                        <label for="inputEmail1" class="ul-form__label"> مجوز سامانه

                                        </label>
                                        <select name="SysLic" class="form-control" id="">
                                            <option selected value="0">انتخاب مجوز</option>
                                        </select>
                                        <small class="ul-form__text form-text ">
                                           مجوز های تعریف شده در سامانه
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail2" class="ul-form__label">توضیح کوتاه مجوز

                                        </label>
                                        <input type="text" class="form-control" name="note"
                                            placeholder="توضیح کوتاه مجوز" value="">
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            توضیح کوتاه مجوز
                                        </small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label"> مبنای محاسبه
                                        </label>
                                        <div class="input-right-icon">
                                            <select name="PayType" class="form-control">
                                                <option value="1">ساعت</option>
                                                <option value="24">روز</option>
                                                <option value="600">رخداد</option>
                                            </select>
                                            <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                تعیین مبنای محاسبه هزینه
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نوع محاسبه
                                        </label>
                                        <div class="input-right-icon">
                                            <select name="AccountingType" class="form-control">
                                                <option value="1">پیش پرداخت</option>
                                                <option value="2">پس پرداخت</option>
                                                <option value="3">هم پرداخت</option>
                                            </select>
                                            <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                روش پرداخت
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ دریافت
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="SelPrice"
                                                placeholder="مبلغ به ریال" value="">
                                            <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                مبلغی که می باید از مشتری دریافت شود
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ پرداخت
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="fixPrice"
                                                placeholder="مبلغ به ریال" value="">
                                            <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                                مبلغی که می باید به مالک یا ارائه دهنده پرداخت شود
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">وضعیت مجوز

                                        </label>
                                        <div class="input-right-icon">
                                            <select name="Status" class="form-control">
                                                <option value="0">قابل ارائه نیست</option>
                                                <option value="1">قابل ارائه</option>
                                            </select>
                                        </div>
                                    </div>
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
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">مطلب مرتبط با مجوز
                                        </label>
                                        <div class="input-right-icon">
                                            <input name="post" class="form-control">
                                            <small id="passwordHelpBlock" class="ul-form__text form-text ">ارتباط خبر/پست
                                                با مجوز</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="col-lg-3">
                                        <h4>سرفصل مجوز</h4>
                                        <select class="form-control" name="WorkCat" id="WorkCatSelectBox"
                                            onchange="WorkCatSelect()">
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach ($WorkCats as $WorkCat)
                                                <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <h4>سردسته مجوز</h4>
                                        <select class="form-control" name="L1Work" id="L1Select"
                                            onchange="L1Selectfun()" disabled>
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach ($L1Works as $L1Work)
                                                <option class="OptionL1 OptionL1_wc{{ $L1Work->WorkCat }}"
                                                    value="{{ $L1Work->L1ID }}"> {{ $L1Work->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <h4>دسته بندی سرفصل مجوز</h4>
                                        <select class="form-control" name="L2Work" id="L2Select"
                                            onchange="L2Selectfun()" disabled>
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach ($L2Works as $L2Work)
                                                <option
                                                    class="OptionL2 OptionL2_wc{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                                                    value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <h4>دسته مجوز </h4>
                                        <select class="form-control" name="L3Work" id="L3Select" disabled>
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach ($L3Works as $L3Work)
                                                <option
                                                    class="OptionL3 OptionL3_wc{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                                                    value="{{ $L3Work->UID }}"> {{ $L3Work->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>
                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-danger m-1" name="submit"
                                                    value="AddService">افزودن مجوز
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
@endsection
