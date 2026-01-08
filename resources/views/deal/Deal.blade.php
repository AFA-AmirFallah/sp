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
    @include('deal/objects/header')
    @include('deal/objects/stepers', ['target_step' => 1, 'file_id' => $file_id])

    <form method="post">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h5>{{ $deal_src->title ?? 'افزودن فایل جدید' }}</h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="card-title">فایل قسمت عمومی</h3>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail1" class="ul-form__label">شعبه

                                                </label>
                                                <select name="branch" class="form-control tocheck" style="width: 100%">
                                                    @php
                                                        $file_branch = $deal_src->branch ?? 0;
                                                    @endphp
                                                    @foreach ($branches as $branch_item)
                                                        <option value="{{ $branch_item->id }}"
                                                            @if ($file_branch == $branch_item->id) selected @endif>
                                                            {{ $branch_item->Name }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    سرفصل اصلی </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail1" class="ul-form__label"> دسته بندی

                                                </label>
                                                @php
                                                    $post_cat = $deal_src->post_cat ?? 0;
                                                @endphp
                                                <select name="post_cat" class="form-control tocheck" style="width: 100%">
                                                    @foreach ($deal_functions->get_post_cats() as $cat)
                                                        <option value="{{ $cat->UID }}"
                                                            @if ($post_cat == $cat->UID) selected @endif>
                                                            {{ $cat->Name }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    سرفصل اصلی </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail1" class="ul-form__label"> نوع مورد معامله

                                                </label>
                                                @php
                                                    $old_product_type = $deal_src->product_type ?? 0;
                                                @endphp

                                                <select name="product_type" class="form-control tocheck"
                                                    style="width: 100%">
                                                    @foreach ($deal_functions->get_product_type() as $product_type)
                                                        <option @if ($product_type->id == $old_product_type) selected @endif
                                                            value="{{ $product_type->id }}">{{ $product_type->Name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    نوع مورد معامله
                                                </small>
                                            </div>
                                            @php
                                                $old_deal_type = $deal_src->deal_type ?? 0;
                                            @endphp
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail2" class="ul-form__label">نوع معامله
                                                </label>
                                                <span class="label_red">*</span>
                                                <select name="deal_type" class="form-control tocheck" style="width: 100%">
                                                    <option @if ($old_deal_type == 1) selected @endif
                                                        value="1">فروش نقدی</option>
                                                    <option @if ($old_deal_type == 2) selected @endif
                                                        value="2">فروش اقساطی</option>
                                                </select>
                                                <small id="product_name_small" class="ul-form__text form-text ">
                                                    مورد معامله نامی است که در آگهی از آن استفاده می شود
                                                </small>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail2" class="ul-form__label">مورد معامله
                                                </label>
                                                <span class="label_red">*</span>
                                                <input type="text" class="form-control" required name="title"
                                                    placeholder="نام مورد معامله" value="{{ $deal_src->title ?? '' }}">
                                                <small id="product_name_small" class="ul-form__text form-text ">
                                                    مورد معامله نامی است که در آگهی از آن استفاده می شود
                                                </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail3" class="ul-form__label">مبلغ در آگهی
                                                </label>
                                                <span class="label_red">*</span>
                                                <div class="input-right-icon">
                                                    <input type="text" class="form-control" name="show_price" required
                                                        placeholder="توافقی - ۱۰۰ میلون تومان"
                                                        value="{{ $deal_src->show_price ?? '' }}">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-row">
                                            <div class="form-group col-md-12">

                                                <label for="inputEmail3" class="ul-form__label">توضیحات
                                                </label>
                                                <span class="label_red">*</span>
                                                <div class="input-right-icon">
                                                    <textarea id="hiddenArea" name="description" required class="ckeditor-basic col-sm-12 form-control">{{ $deal_src->description ?? '' }}</textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="card-title">فایل قسمت همکاران (اختصاصی)</h3>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="ul-form__label">حداقل مبلغ
                                                </label>
                                                <div class="input-right-icon">
                                                    <input onclick="CurencyTextRT(this.value,'minPriceTxt')"
                                                        onkeyup="CurencyTextRT(this.value,'minPriceTxt')" type="number"
                                                        class="form-control" name="min_price" id="MinPrice" required
                                                        placeholder="حداقل مبلغ فروش"
                                                        value="{{ $deal_src->min_price ?? '' }}">
                                                    <p id="minPriceTxt"></p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="ul-form__label">حداکثر مبلغ
                                                </label>
                                                <div class="input-right-icon">
                                                    <input onclick="CurencyTextRT(this.value,'maxPriceTxt')"
                                                        onkeyup="CurencyTextRT(this.value,'maxPriceTxt')" type="number"
                                                        class="form-control" name="max_price" id="MaxPrice" required
                                                        placeholder="حد اکثر مبلغ فروش"
                                                        value="{{ $deal_src->max_price ?? '' }}">
                                                    <p id="maxPriceTxt"></p>
                                                </div>
                                            </div>

                                        </div>
                                        @php
                                            $old_location = $deal_src->location ?? 0;
                                        @endphp
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="ul-form__label">محل مورد
                                                </label>
                                                <div class="input-right-icon">
                                                    <select name="location" class="form-control tocheck"
                                                        style="width: 100%">
                                                        <option @if ($old_location == 1) selected @endif
                                                            value="1">نمایشگاه</option>
                                                        <option @if ($old_location == 2) selected @endif
                                                            value="2">در اختیار مالک</option>
                                                        <option @if ($old_location == 3) selected @endif
                                                            value="3">نمایشگاه همکار</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @php
                                                $username = $deal_src->owner ?? null;
                                            @endphp
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail1" class="ul-form__label"> مالک

                                                </label>
                                                @include('Layouts.SearchUserInput', [
                                                    'InputName' => 'owner',
                                                    'InputPalceholder' => 'مالک مورد معامله',
                                                    'username' => $username,
                                                ])
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    مالک مورد معامله
                                                </small>
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="ul-form__label">شماره پلاک
                                                </label>
                                                <input type="text" class="form-control" name="pelak"
                                                    placeholder="شماره پلاک خودرو" value="{{ $deal_src->pelak ?? '' }}">
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    ۸۷ د ۷۱۱ ایرن ۸۸
                                                </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail1" class="ul-form__label">
                                                    vin
                                                </label>
                                                <input type="text" class="form-control" name="vin"
                                                    placeholder="کد VIN خودرو" value="{{ $deal_src->vin ?? '' }}">
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    کد vin خودرو
                                                </small>
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail3" class="ul-form__label">توضیحات برای همکار
                                                </label>
                                                <span class="label_red">*</span>
                                                <div class="input-right-icon">
                                                    <textarea cols="80" rows="10" name="dealer_note" class="ckeditor-basic col-sm-12 form-control">{{ $deal_src->dealer_note ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
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
