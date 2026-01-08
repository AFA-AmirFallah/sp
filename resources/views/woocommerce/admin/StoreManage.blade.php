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
            <li><a href="">ویرایش </a></li>
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
                                <h3 class="card-title">ویرایش فروشگاه
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label">نام فروشگاه
                                        </label>
                                        <input type="text" class="form-control" id="Name" name="Name"
                                            placeholder="نام فروشگاه" value="{{$Store->Name }}">

                                        <small class="ul-form__text form-text ">
                                            نام فروشگاهی که با آن همکاری میکنید
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">تلفن
                                        </label>
                                        <input type="text" class="form-control" id="Phone" name="Phone"
                                            placeholder="تلفن (برای مثال: 02187654321)" value="{{ $Store->Phone }}">
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

                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="Mobile" id="Mobile"
                                                placeholder="تلفن همراه (برای مثال: 09128765432)"
                                                value="{{ $Store->Mobile }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4" class="ul-form__label">شماره مجوز فعالیت
                                        </label>


                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="License" id="License"
                                                placeholder="شماره مجوز" value="{{ $Store->License }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نوع فعالیت
                                        </label>
                                        <div class="input-right-icon">
                                            <select name="Field" class="form-control">
                                                <option value="0">لطفا انتخاب کنید</option>
                                                @foreach ($StoreFields as $StoreField)
                                                    <option @if ($Store->Field == $StoreField->id) selected @endif value="{{ $StoreField->id }}">
                                                        {{ $StoreField->Name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="ul-form__label">نوع فروشگاه

                                        </label>
                                        <div class="input-right-icon">
                                            <select name="Type" class="form-control">
                                                <option value="0">لطفا انتخاب کنید</option>
                                                @foreach ($StoreTypes as $StoreType)

                                                    <option @if ($Store->Type  == $StoreType->id) selected @endif value="{{ $StoreType->id }}">
                                                        {{ $StoreType->Name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label"> مالک فروشگاه- {{$Owner->Name . ' ' . $Owner->Family}}
                                        </label>

                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="owner" required
                                                id="MainDescription" placeholder="نام کاربری مالک"
                                                value="{{ $Store->Owner }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">آدرس
                                        </label>

                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="Address" id="MainDescription"
                                                placeholder="آدرس" value="{{ $Store->Address }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">نام مالک
                                        </label>

                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="ownername" required
                                                id="MainDescription" placeholder="نام مالک" value="{{ $Store->Malek }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">تصویر فروشگاه
                                        </label>

                                        <a id="lfm" data-input="modal_pic" data-preview="holder"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                                        </a>
                                        <input required id="modal_pic" class="form-control" required type="text"
                                            name="pic" value="{{ $Store->Pic }}">

                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail3" class="ul-form__label">توضیحات فروشگاه
                                    </label>
                                    <textarea required id="hiddenArea" required name="ce"
                                        class="col-sm-12 form-control">{{ $Store->Description }} </textarea>
                                </div>


                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                                    value="AddStore">ویرایش  فروشگاه
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
