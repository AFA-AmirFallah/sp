@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .label_red {
            color: red;
        }
    </style>
    <div class="breadcrumb">
        <h1>عملیات کالا</h1>
        <ul>
            <li><a href="">افزودن</a></li>
            <li>کالاها</li>
        </ul>
    </div>
    <a class="dropdown-item link linkexternal" href="">برگشت به صفحه ی قبل <i class="i-Arrow-Back-3"></i></a>
    <div class="separator-breadcrumb border-top"></div>
    <form method="post">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title"> افزودن کالا</h3>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label"> SKU

                                        </label>
                                        <input type="text" class="form-control" name="SKU" id="sku"
                                            placeholder="کد کالا" value="" onkeydown="ChangeSku()">
                                        <small id="sku_samall" class="ul-form__text form-text ">
                                            کد کالا انبار داری
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">نام فارسی کالا
                                        </label>
                                        <span class="label_red">*</span>
                                        <input type="text" class="form-control" required name="NameFa" id="NameFa"
                                            onkeyup="ChangeName()" placeholder="ماهیت کالا + برند + کلمه مدل+مدل کالا"
                                            value="">
                                        <small id="product_name_small" class="ul-form__text form-text ">
                                            نام اصلی کالا به فارسی
                                        </small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نامک کالا
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="NameEn" required
                                                placeholder="Syntax for naming product : Brand + Model + Nature of the Product"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">واحد کالا</label>
                                        <select id="SelectMeta_1" name="MainUnit" class="form-control tocheck"
                                            style="width: 100%">
                                            @foreach ($ProductUnits as $ProductUnit)
                                                <option value="{{ $ProductUnit->id }}">{{ $ProductUnit->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">بارکد بین المللی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="IntID" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">بارکد ایران
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="IRID" value="">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">وزن محصول به گرم
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="weight" value="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">آدرس اختیاری
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" id="urladdress" name="urladdress"
                                                value="">
                                            <div class="invalid-feedback">
                                                طول آدرس کمتر از ۳ کارکتر است یا قبلا استفاده شده است! </div>
                                            <small>پر کردن این فیلد باعث می شود محصول آدرس تعیین شده را داشته
                                                باشد!</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail1" class="ul-form__label">توضیح کوتاه
                                        </label>
                                        <span class="label_red">*</span>
                                        <input type="text" class="form-control" name="Description" required
                                            placeholder="توضیح کوتاه یک خطی" value="">
                                        <small class="ul-form__text form-text ">
                                            توضیح کوتاه یک خطی برای نمایش کوتاه
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> کلمات کلیدی / شاخص
                                    </label>
                                    <select id="SelectTags" name="SelectTags[]" class="form-control col-xl-8 col-md-7"
                                        multiple="multiple">
                                        @foreach ($Tags as $Tag)
                                            <option>
                                                {{ $Tag->Name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="custom-separator"></div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">

                                        <label for="inputEmail3" class="ul-form__label">توضیحات
                                        </label>
                                        <span class="label_red">*</span>
                                        @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                            <div class="input-right-icon">
                                                <textarea id="hiddenArea" name="ce" required class="col-sm-12 form-control">{{ old('ce') }} </textarea>

                                            </div>
                                        @else
                                            <textarea cols="80" rows="10" class="col-sm-12 form-control" name="ce" required> {{ old('ce') }} </textarea>
                                        @endif
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">


                                        <label for="inputEmail3" class="ul-form__label">مشخصات
                                        </label>
                                        <span class="label_red">*</span>
                                        @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                            <div class="input-right-icon">
                                                <textarea id="hiddenArea" name="ce1" class="col-sm-12 form-control"></textarea>
                                            </div>
                                        @else
                                            <div class="input-right-icon">
                                                <textarea cols="80" rows="10" name="ce1" class="col-sm-12 form-control"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                                    value="UpdateGoods">ثبت کالا </button>

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
        var $urladdress;
        $("#urladdress").on("keyup change", function(e) {

            if (urladdress != $('#urladdress').val()) {
                str_len = $('#urladdress').val().length;
                if (str_len < 4) {
                    $("#urladdress").addClass("is-invalid").removeClass("is-valid");
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('', {
                            ajax: true,
                            procedure: 'check_url',
                            new_url: $('#urladdress').val()
                        },
                        function(data, status) {
                            if (data) {
                                $("#urladdress").removeClass("is-invalid").addClass("is-valid");
                            } else {
                                $("#urladdress").addClass("is-invalid").removeClass("is-valid");
                            }
                        });
                }
            }

            urladdress = $('#urladdress').val();

        })
    </script>
    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
        <script>
            function ChangeSku() {
                $SearchText = $('#sku').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'DuplicateSKUCheck',
                        SearchText: $SearchText,
                    },

                    function(data, status) {
                        if (data != '0') {
                            $Text = '<a href="EditProduct/' + data + '">این SKU قبلا تعریف شده است</a>'
                            $('#sku_samall').css("background-color", "red");
                            $('#sku_samall').css("color", "white");
                            $('#sku_samall').html($Text);

                        } else {
                            $Text = '';
                            $('#sku_samall').css("background-color", "white");
                            $('#sku_samall').css("color", "black");
                            $('#sku_samall').html($Text);
                        }
                    });


            }

            function ChangeName() {
                $SearchText = $('#NameFa').val();

                if ($SearchText.length > 3) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('<?php echo e(route('ajax')); ?>', {
                            AjaxType: 'DuplicateNameCheck',
                            SearchText: $SearchText,
                        },

                        function(data, status) {
                            if (data != '0') {
                                $Text = '<a href="EditProduct/' + data + '">این کالا قبلا تعریف شده است</a>'
                                $('#product_name_small').css("background-color", "red");
                                $('#product_name_small').css("color", "white");
                                $('#product_name_small').html($Text);

                            } else {
                                $Text = '';
                                $('#product_name_small').css("background-color", "white");
                                $('#product_name_small').css("color", "black");
                                $('#product_name_small').html($Text);
                            }
                        });

                }

            }
        </script>

        @include('Layouts.FilemanagerScripts')
    @endif
@endsection
@section('bottom-js')
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
@endsection
