@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="breadcrumb">
        <h1>{{$Store->Name}}</h1>
        <ul>
            <li><a href="">افزودن</a></li>
            <li>انبار</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <form method="post">
        @csrf
        <input style="visibility:hidden" id="tableID" name="tableid">
        <div class="form-group row">
            <label for="inputName"
                   class="col-sm-2 col-form-label">نام انبار</label>
            <div class="col-sm-10">
                <input class="form-control" required id="Name" name="Name" value="{{old('Name')}}"
                       placeholder="نام انبار">
            </div>
        </div>
        <fieldset class="form-group">
            <div class="row">
                <div class="col-form-label col-sm-2 pt-0">وضعیت انبار</div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               id="modal_active"
                               name="Status" id="gridRadios1" value="0"
                               checked="">
                        <label class="form-check-label ml-3" for="gridRadios1">
                            انبار فروش
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               id="modal_deactive"
                               name="Status" id="gridRadios2" value="1">
                        <label class="form-check-label ml-3" for="gridRadios2">
                            انبار پشتیبان
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputName"
                       class="col-sm-2 col-form-label">کدپستی انبار</label>
                <div class="col-sm-10">
                    <input required class="form-control" id="Postalcode"
                           name="Postalcode" value="{{old('Postalcode')}}"
                           placeholder="کدپستی انبار">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputName"
                       class="col-sm-2 col-form-label">تلفن انبار</label>
                <div class="col-sm-10">
                    <input required class="form-control" id="phone"
                           name="phone" value="{{old('phone')}}"
                           placeholder="تلفن انبار">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputName"
                       class="col-sm-2 col-form-label">آدرس انبار</label>
                <div class="col-sm-10">
                    <input  required class="form-control" id="address"
                           name="address" value="{{old('address')}}"
                           placeholder="آدرس انبار">
                </div>
            </div>
        </fieldset>
        <div class="form-group row">
            <div class="col-sm-10">
                <button id="addelement" type="submit" name="submit" value="addwarehouse"
                        class="btn btn-success">افزودن
                </button>

            </div>
        </div>
    </form>

@endsection
@section('page-js')
    @include('Layouts.FilemanagerScripts')

@endsection
