@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .store_continer_1603 {
            background-color: green;
            border-radius: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .store_item {
            padding: 10px;
            background-color: white;
            margin-top: 5px;
            margin-bottom: 5px;
            border-radius: 10px;
        }

        .label_red {
            color: red;
        }
    </style>
    <div class="breadcrumb">
        <h1>عملیات کالا</h1>
        <ul>
            <li><a href="">ویرایش</a></li>
            <li>کالا</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <h2 style="text-align: center">{{ $good->NameFa }} <a href="{{ route('SingleProduct', ['productID' => $good->id]) }}"><i
                class="i-Movie"></i></a></h2>


    @if ($good->tax_status == 0)
        <label style="position: absolute;top: 10px;left: 10px;padding: 8px;border-radius: 22px;color: white;" class="green">
            معاف از مالیات

        </label>
    @elseif($good->tax_status == 10)
        <label style="position: absolute;top: 10px;left: 10px;padding: 8px;border-radius: 22px;color: white;" class="red">
            مشمول مالیات

        </label>
    @endif

    <div class="row">
        @if ($AccessType == 'admin')
            <div onclick="showindex()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center green">
                        <i class="i-Present text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class=" mt-2 mb-0 text-white">شاخص ها</p>
                            <small style="white-space: nowrap;margin-right: -20px;" class="text-white">ویرایش شاخص های
                                هوشمند</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div onclick="showgalery()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary red o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Financial text-white"></i>
                    <div class="content">
                        <p style="font-weight: 600;" class="text-white  mt-2 mb-0"> تصاویر </p>
                        <small style="white-space: nowrap;margin-right: -20px;" class="text-white">ویرایش تصاویر
                            محصول</small>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="showgood()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 orange">
                <div class="card-body text-center">
                    <i class="i-Checkout-Basket text-white"></i>
                    <div class="content">
                        <p style="font-weight: 600;" class="text-white mt-2 mb-0 boldness">اطلاعات</p>
                        <small style="white-space: nowrap;margin-right: -20px;" class="text-white">ویرایش اطلاعات
                            پایه محصول</small>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="showarehouse()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 blue">
                <div class="card-body text-center">
                    <i class="i-Shop text-white"></i>
                    <div class="content">
                        <p style="font-weight: 600;" class="text-white mt-2 mb-0">موجودی</p>
                        <small style="white-space: nowrap;margin-right: -20px;" class="text-white">ویرایش موجودی
                            محصول</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->Role == App\myappenv::role_SuperAdmin || Auth::user()->Role == App\myappenv::role_ShopAdmin)
        <div class="row">
            <div onclick="showReport()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center blue">
                        <i class="i-Bar-Chart text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class=" mt-2 mb-0 text-white">گزارشات</p>
                            <small style="white-space: nowrap;margin-right: -20px;" class="text-white">مشاهده گزارشات
                                محصول</small>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="ShowTashim()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary orange o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Money-2 text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class="text-white  mt-2 mb-0"> تسهیم </p>
                            <small style="white-space: nowrap;margin-right: -20px;" class="text-white">عملیات اختصاص
                                تسهیم </small>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="ShowSeo()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 green">
                    <div class="card-body text-center">
                        <i class="i-Dashboard text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class="text-white mt-2 mb-0 boldness">SEO</p>
                            <small style="white-space: nowrap;margin-right: -20px;" class="text-white">عملیات موتور
                                جستجو</small>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="showoperation()" style="cursor: pointer" class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 red">
                    <div class="card-body text-center">
                        <i class="i-Gear-2 text-white"></i>
                        <div class="content">
                            <p style="font-weight: 600;" class="text-white mt-2 mb-0">عملیات</p>
                            <small style="white-space: nowrap;margin-right: -20px;" class="text-white">عملیات ويژه محصول
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="index_iframe" class="main_forme 2-columns-form-layout nested">

        <div class="">
            <div class=" row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title"> ویرایش شاخص ها : {{ $good->NameFa }}</h3>
                            <button id="hide_index" onclick="hideindex()" class="btn"
                                style="position: absolute;left: 10px;top: 9px;">-</button>
                        </div>
                        @if (Auth::user()->Role == App\myappenv::role_SuperAdmin || Auth::user()->Role == App\myappenv::role_ShopAdmin)
                            <!--begin::form-->
                            <div class=" card-body">
                                <iframe src="{{ route('ProductIndex', ['id' => $good->id, 'iframe' => true]) }}"
                                    style="height: 500px;width: 100%;border: none;"></iframe>
                            </div>
                        @else
                            <p style="text-align: center;color:red;">شما مجوز دسترسی به این قابلیت را ندارید!</p>
                        @endif
                        <!-- end::form -->
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div id="galery_iframe" class="main_forme 2-columns-form-layout nested">
        <div class="">
            <div class=" row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title"> ویرایش تصاویر : {{ $good->NameFa }}</h3>
                            <button id="hide_galery" onclick="hidegalery()" class="btn"
                                style="position: absolute;left: 10px;top: 9px;">-</button>
                        </div>
                        <!--begin::form-->
                        <div class=" card-body">
                            <iframe src="{{ route('ProductGalery', ['id' => $good->id, 'iframe' => true]) }}"
                                style="height: 500px;width: 100%;border: none;"></iframe>
                        </div>
                        <!-- end::form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post">
        @csrf
        <input type="text" name="ProductType" value="good" class="nested">
        <div id="good" class="main_forme 2-columns-form-layout nested">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title"> ویرایش محصول : {{ $good->NameFa }}</h3>
                                <button id="hide_good" onclick="hidegood()" type="button" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            <div class=" card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label"> SKU

                                        </label>
                                        <input type="text" class="form-control" name="SKU" placeholder="کد کالا"
                                            value="{{ $good->SKU }}">
                                        <small class="ul-form__text form-text ">
                                            کد کالا انبار داری
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">نام فارسی کالا
                                        </label>
                                        <span class="label_red">*</span>
                                        <input type="text" class="form-control" required name="NameFa"
                                            placeholder="ماهیت کالا + برند + کلمه مدل+مدل کالا"
                                            value="{{ $good->NameFa }}">
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
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
                                                value="{{ $good->NameEn }}">
                                            @if (strlen($good->NameEn) > 24)
                                                <small class="text-danger">{{ strlen($good->NameEn) }} کاراکتر</small>
                                            @else
                                                <small lass="text-success">{{ strlen($good->NameEn) }} کاراکتر</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">واحد کالا</label>
                                        <select id="SelectMeta_1" name="MainUnit" class="form-control tocheck"
                                            style="width: 100%">
                                            @foreach ($ProductUnits as $ProductUnit)
                                                <option @if ($ProductUnit->id == $good->Unit) selected @endif
                                                    value="{{ $ProductUnit->id }}">
                                                    {{ $ProductUnit->Name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">بارکد بین المللی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="IntID"
                                                value="{{ $good->IntID }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">بارکد ایران
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="IRID"
                                                value="{{ $good->IRID }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">وزن محصول به گرم
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="weight"
                                                value="{{ $good->weight }}">
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">آدرس اختیاری
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" id="urladdress" name="urladdress"
                                                value="{{ $good->urladdress }}">
                                            <div class="invalid-feedback">
                                                طول آدرس کمتر از ۳ کارکتر است یا قبلا استفاده شده است! </div>
                                            <small>پر کردن این فیلد باعث می شود محصول آدرس تعیین شده را داشته
                                                باشد!</small>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> کلمات کلیدی </label>
                                    <select style="width: 100%" id="SelectTags" name="SelectTags[]"
                                        class="form-control col-xl-8 col-md-7" multiple="multiple">
                                        @foreach ($Tags as $Tag)
                                            <option @if ($Tag->PostId != null) selected="selected" @endif>
                                                {{ $Tag->Name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail1" class="ul-form__label">توضیح کوتاه
                                        </label>
                                        <span class="label_red">*</span>
                                        <input type="text" class="form-control" name="Description" required
                                            placeholder="توضیح کوتاه یک خطی" value="{{ $good->Description }}">
                                        <small class="ul-form__text form-text ">
                                            توضیح کوتاه یک خطی برای نمایش کوتاه
                                        </small>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail3" class="ul-form__label">شرح کالا
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                                <textarea id="hiddenArea" name="ce" required class="col-sm-12 form-control" placeholder="توضیح کوتاه یک خطی">
                                                @if ($TextArr == null)
{{ $good->MainDescription }}
@else
{{ $TextArr->MainText }}
@endif
                                                </textarea>
                                            @else
                                                <textarea cols="80" rows="10" class="col-sm-12 form-control" name="ce" required
                                                    placeholder="توضیح کوتاه یک خطی">
                                                    @if ($TextArr == null)
{{ $good->MainDescription }}
@else
{{ $TextArr->MainText }}
@endif </textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail3" class="ul-form__label">مشخصات
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                                <textarea id="hiddenArea" name="ce1" class="col-sm-12 form-control">
@if ($TextArr == null)
@else
{{ $TextArr->DiscText }}
@endif
</textarea>
                                            @else
                                                <textarea cols="80" rows="10" name="ce1" class="col-sm-12 form-control">
    @if ($TextArr == null)
@else
{{ $TextArr->DiscText }}
@endif
</textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                    <label for="">بسته بندی</label>
                                    <div id="formol_unit" class="form-group col-md-12">
                                        <table class="form-group table responsive">
                                            <tr>
                                                <th>ضرب واحد</th>
                                                <th>نام واحد</th>
                                                <th>تصویر</th>
                                                <th>عملیات</th>
                                            </tr>
                                            @if ($good->UnitPlan != null)
                                                @php
                                                    $Conter = 0;
                                                @endphp
                                                @foreach (json_decode($good->UnitPlan) as $targetPlan)
                                                    @php
                                                        $Conter++;
                                                    @endphp
                                                    <tr id="UnitRow_{{ $Conter }}">
                                                        <td>
                                                            <input type="number" id="multiple_{{ $Conter }}"
                                                                class="form-control" name="multiple[{{ $Conter }}]"
                                                                value="{{ $targetPlan->multiple }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="UnitName[{{ $Conter }}]"
                                                                value="{{ $targetPlan->UnitName }}">

                                                        </td>
                                                        <td
                                                            style="
                                                        display: flex;
                                                        direction: ltr;
                                                    ">
                                                            <a id="lfm_{{ $Conter }}"
                                                                data-input="modal_pic_{{ $Conter }}"
                                                                data-preview="holder" class="btn btn-primary text-white">
                                                                انتخاب تصویر
                                                            </a>
                                                            <input id="modal_pic_{{ $Conter }}"
                                                                class="form-control" type="text"
                                                                name="img[{{ $Conter }}]"
                                                                value="{{ $targetPlan->img }}">
                                                            <img style="max-width: 100px"
                                                                id="imagepreviw_{{ $Conter }}"
                                                                src="{{ $targetPlan->img }}" alt="">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="AddUnitRow({{ $Conter + 1 }})">افزودن
                                                                فرمول</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @php
                                                    $Conter++;
                                                @endphp
                                                @for ($Conter; $Conter < 14; $Conter++)
                                                    @if ($Conter == 1)
                                                        <tr id="UnitRow_{{ $Conter }}">
                                                        @else
                                                        <tr id="UnitRow_{{ $Conter }}" class="nested">
                                                    @endif

                                                    <td>
                                                        <input type="number" id="multiple_{{ $Conter }}"
                                                            class="form-control" name="multiple[{{ $Conter }}]"
                                                            value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="UnitName_{{ $Conter }}"
                                                            class="form-control" name="UnitName[{{ $Conter }}]"
                                                            value="">
                                                    </td>
                                                    <td
                                                        style="
                                                    display: flex;
                                                    direction: ltr;
                                                ">
                                                        <a id="lfm_{{ $Conter }}"
                                                            data-input="modal_pic_{{ $Conter }}"
                                                            data-preview="holder" class="btn btn-primary text-white">
                                                            انتخاب تصویر
                                                        </a>
                                                        <input id="modal_pic_{{ $Conter }}" class="form-control"
                                                            type="text" name="img[{{ $Conter }}]"
                                                            value="">
                                                        <img style="max-width: 100px"
                                                            id="imagepreviw_{{ $Conter }}" src=""
                                                            alt="">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success"
                                                            onclick="AddUnitRow({{ $Conter + 1 }})">افزودن
                                                            فرمول</button>
                                                    </td>
                                                    </tr>
                                                @endfor
                                            @else
                                                @for ($Conter = 1; $Conter < 14; $Conter++)
                                                    <tr id="UnitRow_{{ $Conter }}"
                                                        @if ($Conter != 1) class="nested" @endif>
                                                        <td>
                                                            <input type="number" id="multiple_{{ $Conter }}"
                                                                class="form-control" name="multiple[{{ $Conter }}]"
                                                                value="">

                                                        </td>
                                                        <td>
                                                            <input type="text" id="UnitName_{{ $Conter }}"
                                                                class="form-control" name="UnitName[{{ $Conter }}]"
                                                                value="">
                                                        </td>
                                                        <td
                                                            style="
                                                        display: flex;
                                                        direction: ltr;
                                                    ">
                                                            <a id="lfm_{{ $Conter }}"
                                                                data-input="modal_pic_{{ $Conter }}"
                                                                data-preview="holder" class="btn btn-primary text-white">
                                                                انتخاب تصویر
                                                            </a>
                                                            <input id="modal_pic_{{ $Conter }}"
                                                                class="form-control" type="text"
                                                                name="img[{{ $Conter }}]" value="">
                                                            <img style="max-width: 100px"
                                                                id="imagepreviw_{{ $Conter }}" src=""
                                                                alt="">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="AddUnitRow({{ $Conter + 1 }})">افزودن
                                                                فرمول</button>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                        </table>


                                    </div>
                                @endif
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
    <div id="EditGood_Stock" class="main_forme">

    </div>
    @if ($AccessType == 'admin')
        <div id="operation_iframe" class="main_forme 2-columns-form-layout nested">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title">عملیات ویژه</h3>
                                <button id="hide_operation" onclick="hideoperation()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            @if (Auth::user()->Role == App\myappenv::role_SuperAdmin || Auth::user()->Role == App\myappenv::role_ShopAdmin)
                                <div class=" card-body">
                                    <form method="post">
                                        @csrf
                                        <button type="submit" name="delete" value="1" class="btn btn-danger">حذف
                                            محصول</button>
                                        @if ($good->onsale == 1)
                                            <button type="submit" name="Deactive" value="1"
                                                class="btn btn-danger">غیر فعال
                                                سازی
                                                محصول</button>
                                        @else
                                            <button type="submit" name="Activeate" value="1"
                                                class="btn btn-sucess"> فعال
                                                سازی
                                                محصول</button>
                                        @endif
                                        @if ($good->tax_status == 0)
                                            <button type="submit" name="Tax" value="10"
                                                class="btn btn-success">فعال سازی مالیات بر ارزش افزوده </button>
                                        @else
                                            <button type="submit" name="Tax" value="0"
                                                class="btn btn-danger">غیر فعال سازی مالیات بر ارزش افزوده </button>
                                        @endif


                                    </form>
                                </div>
                            @else
                                <p style="text-align: center;color:red;">شما مجوز دسترسی به این قابلیت را ندارید!</p>
                            @endif

                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="operationSeo" class="main_forme 2-columns-form-layout nested">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title">عملیات SEO</h3>
                                <button id="hide_operation" onclick="hideSeo()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            @if (Auth::user()->Role == App\myappenv::role_SuperAdmin)
                                <div class=" card-body">
                                    <form method="post">
                                        @csrf
                                        <button type="submit" name="delete" value="1" class="btn btn-danger">حذف
                                            محصول</button>
                                    </form>
                                </div>
                            @else
                                <p style="text-align: center;color:red;">شما مجوز دسترسی به این قابلیت را ندارید!</p>
                            @endif

                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="operationtashim" class="main_forme 2-columns-form-layout nested">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title">عملیات تسهیم</h3>
                                <button id="hide_operation" onclick="hideTashim()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                <div class=" card-body">
                                    <form method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="store_continer_1603 col-lg-4 col-xl-4 col-md-4">
                                                <p class="text-white">تامین کنندگان</p>
                                                @foreach ($MultiWarehouse as $Warehouse)
                                                    <div onclick="selectwarehouse('{{ $Warehouse->wgid }}')"
                                                        class="store_item">
                                                        {{ $Warehouse->Name }} - موجودی : {{ $Warehouse->Remian }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class=" col-lg-8 col-xl-8 col-md-8">
                                                <p>روش تسهیم</p>
                                                @isset($GoodInWarehouse->WarehouseID)
                                                    @foreach ($Tashims as $TashimsItem)
                                                        @php
                                                            $Exist = false;
                                                        @endphp

                                                        @foreach ($TashimItems as $TashimItemTarget)
                                                            @php

                                                                if ($TashimItemTarget->TashimID == $TashimsItem->id) {
                                                                    $Exist = true;
                                                                }
                                                            @endphp
                                                        @endforeach



                                                        <div class="form-check">
                                                            @if ($TashimsItem->Operation == 1)
                                                                <input style="margin-left: 10px;margin-right:10px;"
                                                                    name="tashim[]" value="{{ $TashimsItem->id }}"
                                                                    @if ($Exist) checked @endif
                                                                    class="form-check-input" type="checkbox">
                                                                <label style="margin-left: 10px;margin-right:44px;"
                                                                    class="form-check-label">{{ $TashimsItem->Name }}</label>
                                                                <small>{{ $TashimsItem->Note }}</small>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                    <hr>
                                                    <button type="submit" class="btn btn-success" name="submit_tashim"
                                                        value="{{ $GoodInWarehouse->WarehouseID }}">ثبت تسهیم</button>
                                                @endisset
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            @else
                                <p style="text-align: center;color:red;">شما مجوز دسترسی به این قابلیت را ندارید!</p>
                            @endif
                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="operationReport" class="main_forme 2-columns-form-layout nested">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title"> گزارشات</h3>
                                <button id="hide_operation" onclick="hideReport()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            @if (Auth::user()->Role == App\myappenv::role_SuperAdmin)
                                @php
                                    $alerted = App\Shop\ProductAlert::get_product_alert($good->id);
                                @endphp
                                <div class="card-body">
                                    <div>

                                        <head>درخواست موجود شدن : </head>
                                        <ul>
                                            @foreach ($alerted as $alert_item)
                                                <li>{{ $alert_item->Name }} {{ $alert_item->Family }} -
                                                    {{ $Persian->MyPersianDate($alert_item->created_at) }} </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @php
                                        $like_src = App\Functions\Indexes::who_has_this_product_index($good->id);
                                    @endphp
                                    <div>

                                        <head> افرادی که این محصول را میخرند: </head>
                                        <ul>
                                            <form action="" method="POST">
                                                @csrf
                                                @foreach ($like_src as $like_item)
                                                    <li>{{ $like_item->Name }} {{ $like_item->Family }} -
                                                        {{ $like_item->Weight }} </li>
                                                    <input name="c_name[]" value="{{ $like_item->Name }}">
                                                    <input name="c_phone[]" value="{{ $like_item->MobileNo }}">
                                                @endforeach
                                                <button type="submit" class="btn btn-success" name="send_sms"
                                                    value="like">ارسال
                                                    پیامک</button>
                                            </form>
                                        </ul>
                                    </div>
                                    @php
                                        $like_src = App\Functions\Indexes::who_buy_this_product($good->id);
                                    @endphp
                                    <div>

                                        <head> سابقه خرید این محصول: </head>
                                        <ul>
                                            @foreach ($like_src as $like_item)
                                                <li>{{ $like_item->Name }} {{ $like_item->Family }} -
                                                    تعداد: {{ $like_item->product_qty }} <a
                                                        href="{{ route('EditOrder', ['OrderID' => $like_item->id]) }}">نمایش</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if ($GoodReport != null)
                                        @foreach ($GoodReport as $GoodReportLISt)
                                            @if ($GoodReportLISt->ReportVal != null)
                                                <div>
                                                    @if ($GoodReportLISt->ReportType == 3)
                                                        <svg width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.00063 14.6709C11.6766 14.6702 14.6673 11.6796 14.6673 8.00356C14.6673 4.32756 11.6766 1.3369 7.99996 1.3369C4.32463 1.3369 1.33396 4.32757 1.3333 8.00357C1.3333 11.6796 4.32396 14.6702 8.00063 14.6709ZM7.99995 2.67025C10.9413 2.67025 13.334 5.06292 13.334 8.00359C13.334 10.9443 10.9413 13.3369 8.00062 13.3376C5.05929 13.3369 2.66662 10.9443 2.66662 8.00359C2.66729 5.06292 5.05995 2.67025 7.99995 2.67025Z"
                                                                fill="#495057" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.99996 8.67085L10.6666 8.67085L10.6666 7.33752L7.99996 7.33752L7.99996 5.33352L5.32996 8.00352L7.99996 10.6729L7.99996 8.67085Z"
                                                                fill="#495057" />
                                                        </svg>
                                                        @php
                                                            $extranote = json_decode($GoodReportLISt->ReportVal);
                                                        @endphp
                                                        <span>
                                                            {{ $Persian->MyPersianDate($GoodReportLISt->created_at, true) }}
                                                            :
                                                            <strong>{{ $GoodReportLISt->UserID }}</strong>
                                                        </span>
                                                        قیمت فروش محصول را از
                                                        <strong>{{ number_format($extranote->FromPrice) }}</strong>
                                                        به
                                                        {{--  <strong>{{ number_format($extranote->ToPrice) }}</strong> --}}
                                                        تغییر داد
                                                    @elseif($GoodReportLISt->ReportType == 4)
                                                        <svg width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.00063 14.6709C11.6766 14.6702 14.6673 11.6796 14.6673 8.00356C14.6673 4.32756 11.6766 1.3369 7.99996 1.3369C4.32463 1.3369 1.33396 4.32757 1.3333 8.00357C1.3333 11.6796 4.32396 14.6702 8.00063 14.6709ZM7.99995 2.67025C10.9413 2.67025 13.334 5.06292 13.334 8.00359C13.334 10.9443 10.9413 13.3369 8.00062 13.3376C5.05929 13.3369 2.66662 10.9443 2.66662 8.00359C2.66729 5.06292 5.05995 2.67025 7.99995 2.67025Z"
                                                                fill="#495057" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.99996 8.67085L10.6666 8.67085L10.6666 7.33752L7.99996 7.33752L7.99996 5.33352L5.32996 8.00352L7.99996 10.6729L7.99996 8.67085Z"
                                                                fill="#495057" />
                                                        </svg>
                                                        @php
                                                            $extranote = json_decode($GoodReportLISt->ReportVal);
                                                        @endphp
                                                        <span>
                                                            {{ $Persian->MyPersianDate($GoodReportLISt->created_at, true) }}
                                                            :
                                                            <strong>{{ $GoodReportLISt->UserID }}</strong>
                                                        </span>
                                                        موجودی محصول
                                                        <strong>{{ number_format($extranote->FromRemain) }}</strong>
                                                        به
                                                        <strong>{{ number_format($extranote->ToRemain) }}</strong>
                                                        تغییر کرد
                                                    @elseif($GoodReportLISt->ReportType == 5)
                                                        <svg width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.00063 14.6709C11.6766 14.6702 14.6673 11.6796 14.6673 8.00356C14.6673 4.32756 11.6766 1.3369 7.99996 1.3369C4.32463 1.3369 1.33396 4.32757 1.3333 8.00357C1.3333 11.6796 4.32396 14.6702 8.00063 14.6709ZM7.99995 2.67025C10.9413 2.67025 13.334 5.06292 13.334 8.00359C13.334 10.9443 10.9413 13.3369 8.00062 13.3376C5.05929 13.3369 2.66662 10.9443 2.66662 8.00359C2.66729 5.06292 5.05995 2.67025 7.99995 2.67025Z"
                                                                fill="#495057" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.99996 8.67085L10.6666 8.67085L10.6666 7.33752L7.99996 7.33752L7.99996 5.33352L5.32996 8.00352L7.99996 10.6729L7.99996 8.67085Z"
                                                                fill="#495057" />
                                                        </svg>
                                                        @php
                                                            $extranote = json_decode($GoodReportLISt->ReportVal);
                                                        @endphp
                                                        <span>
                                                            {{ $Persian->MyPersianDate($GoodReportLISt->created_at, true) }}
                                                            :
                                                            <strong>{{ $GoodReportLISt->UserID }}</strong>
                                                        </span>
                                                        محصول جدید با قیمت خرید
                                                        <strong>{{ number_format($extranote->BuyPrice) }}</strong>
                                                        را
                                                        بارگذاری کرد
                                                    @endif

                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>گزارشی موجود نیست</p>
                                    @endif
                                </div>
                            @else
                                <p style="text-align: center;color:red;">شما مجوز دسترسی به این قابلیت را ندارید!</p>
                            @endif

                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
@section('page-js')
    @include('Layouts.SearchUserInput_Js')
    @include('Layouts.SearchMultiUserInput_Js')
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
        @include('Layouts.FilemanagerScripts')
        <script>
            $(document).ready(function() {
                $('#warehouse').select2();
            });
        </script>
    @endif

    <script>
        function SaveRent(istr) {
            savebutton = `<a onclick="SaveAtt(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Disk" ></i></a>`;

            saveedbutton = `<a onclick="SaveAtt(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Data-Yes" ></i></a>`;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'save_rent',
                    RentName: $('#RentName_' + istr).html(),
                    rent_days: $('#rent_days_' + istr).html(),
                    rent_status: $('#rent_status_' + istr).html(),
                    rent_buyprice: $('#rent_buyprice_' + istr).html(),
                    rent_price: $('#rent_price_' + istr).html(),
                    rent_tasshims: $('#rent_tasshims_' + istr).html(),
                    WGID: $('#WGID').val(),
                },
                function(data, status) {
                    if (status == 'success') {
                        $('#rent_OP_' + istr).html(saveedbutton);
                    } else
                        alert(data);

                });

        }

        function SaveAtt(istr) {
            savebutton = `<a onclick="SaveAtt(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Disk" ></i></a>`;

            saveedbutton = `<a onclick="SaveAtt(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Data-Yes" ></i></a>`;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'saveatt',
                    AttName: $('#AttName_' + istr).html(),
                    Attval: $('#Attval_' + istr).html(),
                    AttRemain: $('#AttRemain_' + istr).html(),
                    AttBuyPrice: $('#AttBuyPrice_' + istr).html(),
                    AttPrice: $('#AttPrice_' + istr).html(),
                    AttBasePrice: $('#AttBasePrice_' + istr).html(),
                    AttNote: $('#AttNote_' + istr).html(),
                    WGID: $('#WGID').val(),
                },
                function(data, status) {
                    if (status == 'success') {
                        $('#AttOP_' + istr).html(saveedbutton);
                    } else
                        alert(data);

                });

        }

        function addatt() {
            $('#attr_val').removeClass('nested');
        }



        function cancelatt() {
            $('#attr_val').addClass('nested');
            $('#attr_val').addClass('nested');
            $('#rent_days').val('');
            $('#rent_buyprice').val('');
            $('#rent_price').val('');
            $('#productattName').val('');
            $('#productattval').val('');
            $('#productattremain').val('');
            $('#productattbuyprice').val('');
            $('#productattbaseprice').val('');
            $('#productattnote').val('');
            $('#productattprice').val('');
        }

        function add_rent_type_data() {
            alert(localStorage.getItem('afa_test'));
            var tashims_arr = [];
            var tashims_str = '';
            loop_conter = 0;
            $('#tashim_div input:checked').each(function() {
                tashims_arr.push([$(this).attr('name'), $(this).val()]);
                if (loop_conter != 0) {
                    tashims_str += ' , ';
                }
                tashims_str += $(this).attr('name');
                loop_conter++;

            });
            var myRadio = $("input[name=active]");
            var $status = myRadio.filter(":checked").val();
            if ($status == 1) {
                $status_text = 'فعال';
            } else {
                $status_text = 'غیر فعال';
            }
            $rent_name = $('#rent_name').val();
            $rent_days = $('#rent_days').val();
            $rent_buyprice = $('#rent_buyprice').val();
            $rent_price = $('#rent_price').val();

            for (var i = 1; i < 14; i++) {
                istr = i.toString();
                if ($('#RentName_' + istr).html() == '') {
                    break;
                }

            }
            savebutton = `<a onclick="SaveRent(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Disk" ></i></a>`;

            saveedbutton = `<a onclick="SaveRent(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Data-Yes" ></i></a>`;
            $('#RentName_' + istr).html($rent_name);
            $('#rent_days_' + istr).html($rent_days);
            $('#rent_status_' + istr).html($status_text);
            $('#rent_buyprice_' + istr).html($rent_buyprice);
            $('#rent_price_' + istr).html($rent_price);
            $('#rent_tasshims_' + istr).html(tashims_str);
            $('#rent_OP_' + istr).html(savebutton);
            // localStorage.setItem('afa_test', tashims_arr);

            cancelatt();
        }

        function addattdata() {
            for (var i = 1; i < 14; i++) {
                istr = i.toString();
                if ($('#AttName_' + istr).html() == '') {
                    break;
                }

            }
            savebutton = `<a onclick="SaveAtt(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Disk" ></i></a>`;

            saveedbutton = `<a onclick="SaveAtt(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Data-Yes" ></i></a>`;
            $('#AttName_' + istr).html($('#productattName').val());
            $('#Attval_' + istr).html($('#productattval').val());
            $('#AttRemain_' + istr).html($('#productattremain').val());
            $('#AttBuyPrice_' + istr).html($('#productattbuyprice').val());
            $('#AttPrice_' + istr).html($('#productattprice').val());
            $('#AttBasePrice_' + istr).html($('#productattbaseprice').val());
            $('#AttNote_' + istr).html($('#productattnote').val());
            $('#AttOP_' + istr).html(savebutton);


            cancelatt();
        }


        function showReport() {
            $('.main_forme').addClass('nested');
            $('#operationReport').removeClass('nested');

        }

        function ShowTashim() {
            $('.main_forme').addClass('nested');
            $('#operationtashim').removeClass('nested');

        }

        function ShowSeo() {
            $('.main_forme').addClass('nested');
            $('#operationSeo').removeClass('nested');

        }

        function hideReport() {
            $('#operationReport').addClass('nested');
        }

        function hideTashim() {
            $('#operationtashim').addClass('nested');
        }

        function hideSeo() {
            $('#operationSeo').addClass('nested');
        }

        function showoperation() {
            $('.main_forme').addClass('nested');
            $('#operation_iframe').removeClass('nested');

        }

        function hideoperation() {
            $('#operation_iframe').addClass('nested');
        }

        function changestatetosearcharialoacl() {
            $('#ownerselector').removeClass('nested');
            $('#ownerdisplay').addClass('nested');
        }

        function showarehouse() {
            $('.main_forme').addClass('nested');
            $('#EditGood_Stock').removeClass('nested');

            $.ajax({
                url: '?page=EditGood',
                type: 'get',
                beforeSend: function() {
                    $('#EditGood_Stock').html('loadding .....');
                },
                success: function(response) {
                    $('#EditGood_Stock').html(response);
                    $('#warehouse_iframe').removeClass('nested');

                },
                error: function() {
                    alert('can not');
                }
            });



            // show product owner

            $OwnerID = $('#ownerusername').val();
            if ($OwnerID == null || $OwnerID == '') {

            } else {
                //setowner
                $('#ownerselector').addClass('nested');
                $('#ownerdisplay').removeClass('nested');
                $('#nametarget').html('...');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        getownerinfo: $OwnerID,

                    },
                    function(data, status) {
                        $('#nametarget').html(data);

                    });

            }



        }

        function hidewarehouse() {
            $('#warehouse_iframe').addClass('nested');
        }

        function showgalery() {
            $('.main_forme').addClass('nested');
            $('#galery_iframe').removeClass('nested');
        }

        function hidegalery() {
            $('#galery_iframe').addClass('nested');
        }

        function showindex() {
            $('.main_forme').addClass('nested');
            $('#index_iframe').removeClass('nested');
        }

        function hideindex() {
            $('#index_iframe').addClass('nested');
        }

        function showgood() {
            $('.main_forme').addClass('nested');
            $('#good').removeClass('nested');
        }

        function hidegood() {
            $('#good').addClass('nested');
        }

        function offline() {
            $('#online_btn_deactive').addClass('nested');
            $('#online_btn_active').removeClass('nested');
            $('#offline_btn_active').addClass('nested');
            $('#offline_btn_deactive').removeClass('nested');
            $('#NormalSale').addClass('nested');
            $('#PreInvoice').removeClass('nested');
            $('#offline_btn_submit').removeClass('nested');
            $('#online_btn_submit').addClass('nested');
        }

        function online() {
            $('#online_btn_deactive').removeClass('nested');
            $('#online_btn_active').addClass('nested');
            $('#offline_btn_active').removeClass('nested');
            $('#offline_btn_deactive').addClass('nested');
            $('#PreInvoice').addClass('nested');
            $('#NormalSale').removeClass('nested');
            $('#offline_btn_submit').addClass('nested');
            $('#online_btn_submit').removeClass('nested');

        }
    </script>
    <script>
        function AddPriceRow($RowId) {
            if ($RowId < 14) {
                $active_row = $RowId - 1;
                $('.add_row_btn').addClass('d-none');
                $('#add_row_btn_' + $RowId).removeClass('d-none');
                $('#PriceRow_' + $RowId).removeClass('nested');
                $CurentTonumber = $RowId - 1;
                $toNumer = $('#ToNumber_' + $CurentTonumber).val();
                $('#FirstNumber_' + $RowId).text($toNumer);
            } else {
                alert('تعداد سطوح فرمول تمام شد');
            }
        }

        function AddPriceRow_new($RowId) {
            if ($RowId < 14) {
                $active_row = $RowId - 1;
                $('.add_row_btn').addClass('d-none');
                $('#add_row_btn_' + $RowId).removeClass('d-none');
                $('#PriceRow_' + $RowId).removeClass('nested');
                $CurentTonumber = $RowId - 1;
                $toNumer = $('#ToNumber_' + $CurentTonumber).val();
                $('#FirstNumber_' + $RowId).text($toNumer);
            } else {
                alert('تعداد سطوح فرمول تمام شد');
            }
        }

        function AddUnitRow($RowId) {
            if ($RowId < 14) {
                $('#UnitRow_' + $RowId).removeClass('nested');
                $CurentTonumber = $RowId - 1;
            } else {
                alert('تعداد سطوح فرمول تمام شد');
            }

        }
    </script>
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script>
        function FormolPrice() {
            $('#formol_price').removeClass('nested');
            $('#fix_price').addClass('nested');
            $(".formol_price_in").prop('disabled', false);
            $('#cover_price').val($('#Price').val());
            $('#Price').val(0);

        }

        function FixPrice() {
            $('#formol_price').addClass('nested');
            $('#fix_price').removeClass('nested');
            $(".formol_price_in").prop('disabled', true);
            $('#Price').val($('#cover_price').val());
        }

        function FormolUnit() {
            $('#formol_unit').removeClass('nested');
            $('#fix_unit').addClass('nested');
        }

        function FixUnit() {
            $('#formol_unit').addClass('nested');
            $('#fix_unit').removeClass('nested');
        }
    </script>
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
