@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="breadcrumb">
        <h1>عملیات اکانت</h1>
        <ul>
            <li><a href="">افزودن</a></li>
            <li>فروش اکانت</li>
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
                                <h3 class="card-title"> افزودن اکانت </h3>
                                <small>تغییر وضعیت کاربر پس از خرید اکانت</small>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label"> SKU

                                        </label>
                                        <input type="text" class="form-control" name="SKU" placeholder="کد اکانت" value="">
                                        <small class="ul-form__text form-text ">
                                            کد اکانت انبار داری
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">نام فارسی اکانت
                                        </label>
                                        <input type="text" class="form-control" required name="NameFa"
                                            placeholder="نام فارسی اکانت" value="">
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            نام اصلی اکانت به فارسی
                                        </small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نام لاتین اکانت
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="NameEn" required
                                                placeholder="Enter Account English name" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">واحد اکانت</label>
                                        <select id="SelectMeta_1" name="MainUnit" class="form-control tocheck"
                                            style="width: 100%">
                                            @foreach ($ProductUnits as $ProductUnit)
                                                <option  value="{{ $ProductUnit->id }}">{{ $ProductUnit->Name }}</option>
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
                                        <label for="inputEmail3" class="ul-form__label"> مدت اعتبار به روز
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="weight" value="0">
<small>صفر به معنای نا محدود زمانی است!</small>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">آدرس اختیاری
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="urladdress" value="">
                                            <small>پر کردن این فیلد باعث می شود محصول آدرس تعیین شده را داشته باشد!</small>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail1" class="ul-form__label">توضیح کوتاه
                                        </label>
                                        <input type="text" class="form-control"  name="Description" required
                                            placeholder="توضیح کوتاه یک خطی" value="">
                                        <small class="ul-form__text form-text ">
                                            توضیح کوتاه یک خطی برای نمایش کوتاه
                                        </small>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail3" class="ul-form__label">توضیحات
                                        </label>
                                        <div class="input-right-icon">
                                            <textarea id="hiddenArea" name="ce" required
                                                class="col-sm-12 form-control">{{ old('ce') }} </textarea>

                                        </div>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail3" class="ul-form__label">مشخصات
                                        </label>
                                        <div class="input-right-icon">
                                            <textarea id="hiddenArea" name="ce1"
                                                class="col-sm-12 form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                                    value="UpdateGoods">ثبت اکانت </button>

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
    @include('Layouts.FilemanagerScripts')

@endsection
