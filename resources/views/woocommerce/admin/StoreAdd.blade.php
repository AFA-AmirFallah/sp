@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')

    <div class="breadcrumb">
        <h1> فروشگاه </h1>
        <ul>
            <li><a href="">پروفایل</a></li>
            <li> فروشگاه</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post">
        @csrf
        <div class="row col-md-12">
            <hr>
            <div class="4-columns-form-layout">
                <div class="card">
                    <div class="form-row" style="margin-top: 10px;">
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title">ثبت فروشگاه
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label">نام فروشگاه
                                        </label>
                                        <span class="label_red">*</span>
                                        <input  required type="text" class="form-control" id="Name" name="Name"
                                            placeholder="نام فروشگاه" value="{{ old('Name') }}">

                                        <small class="ul-form__text form-text ">
                                            نام فروشگاهی که با آن همکاری میکنید
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">تلفن
                                        </label>
                                        <span class="label_red">*</span>
                                        <input required type="text" class="form-control" id="Phone" name="Phone"
                                            placeholder="تلفن (برای مثال: 02187654321)" value="{{ old('Phone') }}">
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            تلفن ثابت فروشگاه
                                        </small>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">تلفن همراه
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="Mobile" id="Mobile" required
                                                placeholder="تلفن همراه (برای مثال: 09128765432)"
                                                value="{{ old('Mobile') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4" class="ul-form__label">شماره مجوز فعالیت
                                        </label>
                                        <span class="label_red">*</span>

                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="License" id="License" required
                                                placeholder="شماره مجوز" value="{{ old('License') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نوع فعالیت
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <select name="Field" class="form-control">
                                                <option value="0">لطفا انتخاب کنید</option>
                                                @foreach ($StoreFields as $StoreField)
                                                    <option @if (old('Field') == $StoreField->id) selected @endif value="{{ $StoreField->id }}">
                                                        {{ $StoreField->Name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">نوع فروشگاه
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <select name="Type" class="form-control">
                                                <option value="0">لطفا انتخاب کنید</option>
                                                @foreach ($StoreTypes as $StoreType)

                                                    <option @if (old('Type') == $StoreType->id) selected @endif value="{{ $StoreType->id }}">
                                                        {{ $StoreType->Name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نام کاربری مالک فروشگاه 
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="owner" required
                                                id="MainDescription" placeholder="  نام کاربری مالک فروشگاه به صورت پیش فرض شماره موبایل کاربر است"
                                                value="{{ old('owner') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">شعبه
                                        </label>
                                       

                                        <div class="input-right-icon">
                                            <select name="Branch" class="form-control">
                                                <option value="0">لطفا انتخاب کنید</option>
                                                @foreach ($Branchs as $Branch)

                                                    <option @if (old('Branch') == $Branch->id) selected @endif value="{{ $Branch->id }}">
                                                        {{ $Branch->Name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <small class="ul-form__text form-text ">
                                           اگر فروشگاه برای بار اول ساخته می شود نیازی به وارد کردن شعبه نیست
                                        </small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نام مالک
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="ownername" required
                                                id="MainDescription" placeholder=" نام و نام خانوادگی مالک فروشگاه" value="{{ old('owner') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">تصویر فروشگاه
                                        </label>
                                        <span class="label_red">*</span>
                                        <a id="lfm" data-input="modal_pic" data-preview="holder"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                                        </a>
                                        <input required id="modal_pic" class="form-control" required type="text"
                                            name="pic" value="">

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="inputEmail3" class="ul-form__label">آدرس
                                    </label>
                                    <span class="label_red">*</span>
                                    <div class="input-right-icon">
                                        <input required type="text" class="form-control" name="Address" id="MainDescription"
                                            placeholder="   آدرس فروشگاه یا استان محل فروشگاه " value="{{ old('Address') }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail3" class="ul-form__label">توضیحات فروشگاه
                                    </label>
                                    <span class="label_red">*</span>
                                    <textarea required id="hiddenArea" required name="ce"
                                        class="col-sm-12 form-control">{{ old('ce') }} </textarea>
                                </div>

                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                                    value="AddStore">ساخت فروشگاه
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
