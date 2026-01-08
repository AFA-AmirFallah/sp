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
    @include('statistic/objects/header')

    <form method="post">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h5>افزودن آمار جدید</h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="card-title">آمار قسمت عمومی</h3>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">

                                                <label for="inputEmail1" class="ul-form__label">شعبه

                                                </label>
                                                <select name="branch" class="form-control tocheck" style="width: 100%">
                                                    @foreach ($branch_src as $branch_item)
                                                        <option value="{{ $branch_item->id }}">
                                                            {{ $branch_item->Name }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    سرفصل اصلی </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail1" class="ul-form__label"> نوع آمار یا نظر سنجی

                                                </label>


                                                <select name="type" class="form-control tocheck"
                                                    style="width: 100%">
                                                    @foreach ($statistic_class->get_statistic_type() as $type_item)
                                                        <option value="{{ $type_item['id'] }}">
                                                            {{ $type_item['name'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                            @php
                                                $old_deal_type = $deal_src->deal_type ?? 0;
                                            @endphp
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail2" class="ul-form__label"> نام آمار یا نظر سنجی
                                                </label>
                                                <span class="label_red">*</span>
                                                <input type="text" class="form-control" required name="Name"
                                                    placeholder="نام  " value="">

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail2" class="ul-form__label">دوره زمانی 
                                                </label>
                                                <span class="label_red">*</span>
                                                <input type="number" class="form-control" required name="period"
                                                    placeholder="دوره زمانی" value="">
                                                <small id="product_name_small" class="ul-form__text form-text ">
                                                    عدد ۰ به معنای بدون دوره هست - دوره به دقیقه
                                                </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail2" class="ul-form__label">پست مرتبط 
                                                </label>
                                                <span class="label_red">*</span>
                                                <input type="number" class="form-control" required name="post"
                                                    placeholder="آیدی پست مرتبط" value="">
                                                <small id="product_name_small" class="ul-form__text form-text ">
                                                    عدد صفر به معنای بدون پست است
                                                </small>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="form-group col-md-12">

                                                <label for="inputEmail3" class="ul-form__label">توضیحات
                                                </label>
                                                <span class="label_red">*</span>
                                                <div class="input-right-icon">
                                                    <textarea id="hiddenArea" name="desc" required class="ckeditor-basic col-sm-12 form-control">{{ $deal_src->description ?? '' }}</textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                                    value="add_file">ثبت فایل </button>
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
    @include('Layouts.SearchUserInput_Js')
    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
        @include('Layouts.FilemanagerScripts')
    @endif
@endsection
