@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="breadcrumb">
        <h1>{{ $TargetStore->Name }} </h1>
        <ul>
            <li><a href="">افزودن</a></li>
            <li>کالا</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <form method="post">
        @csrf
        <div class="2-columns-form-layout">
            <div class="___class_+?3___">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title"> افزودن کالا در انبار</h3>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label"> کالا

                                        </label>
                                        <br>
                                        <select id="Goods" name="GoodID" class="form-control col-xl-8 col-md-7">
                                            @foreach ($Goods as $good)
                                                <option value="{{ $good->id }}">{{ $good->NameFa }}</option>
                                            @endforeach
                                        </select> <small class="ul-form__text form-text ">
                                            نام کالا
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">انبار
                                        </label>
                                        <select name="WarehouseID" class="form-control col-xl-8 col-md-7">
                                            @foreach ($Warehouses as $Warehouse)
                                                <option value="{{ $Warehouse->id }}">{{ $Warehouse->Name }}</option>
                                            @endforeach
                                        </select>
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            انباری که کالا در آن قرار میگیرد
                                        </small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">تعداد
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="QTY" required
                                                placeholder="تعداد واحد محصول" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ خرید
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="BuyPrice" required
                                                placeholder="مبلغ خرید هر واحد" value="">
                                        </div>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">حد اکثر فروش در هر فاکتور </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control"
                                                placeholder="حد اکثر تعداد فروش در هر فاکنور" name="SaleLimit"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">تعداد موجودی اخطار
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="AlertLimit" value="5">
                                        </div>

                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">تعداد موجودی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="Remian" value="">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3" class="ul-form__label">اخطار اتمام موجودی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="checkbox" class="form-control" name="AlertFinish" checked>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">تاریخ ورود به انبار </label>
                                        <div class="input-right-icon">
                                            <input type="date" required class="form-control"
                                                placeholder="تاریخ ورود به انبار" name="InputDate" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">شروع به فروش </label>
                                        <div class="input-right-icon">
                                            <input type="datetime-local" class="form-control"
                                                placeholder="تاریخ و زمان شروع به فروش" name="ActiveTime" value="">
                                        </div>
                                        <label for="inputEmail3" class="ul-form__label">اتمام به فروش </label>
                                        <div class="input-right-icon">
                                            <input type="datetime-local" class="form-control"
                                                placeholder="تاریخ و زمان شروع اتمام فروش" name="DeactiveTime"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">تاریخ تولید
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="date" class="form-control" name="MadeDate"
                                                placeholder="تاریخ تولید محصول" value="">
                                        </div>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">تاریخ انقضا
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="date" class="form-control" name="ExpireDate"
                                                placeholder="تاریخ انقضای محصول" value="">
                                        </div>

                                    </div>

                                </div>
                                <div class="form-row">
                                    <div id="fix_price" class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ فروش
                                            <a onclick="FixPrice()" class="btn btn-success">مبلغ ثابت</a>
                                            <a onclick="FormolPrice()" class="btn btn-warning">مبلغ فرمولی</a>
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" placeholder="مبلغ فروش هر واحد"
                                                name="Price" value="">
                                        </div>
                                        <small style="color: red">در صورتی که از فرمول استفاده میکنید این قسمت را خالی
                                            بگذارید</small>
                                    </div>
                                    <div id="formol_price" class="nested form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">فرمول فروش
                                            <a onclick="FixPrice()" class="btn btn-success">مبلغ ثابت</a>
                                            <a onclick="FormolPrice()" class="btn btn-warning">مبلغ فرمولی</a>
                                        </label>
                                        <table class="form-group table responsive">
                                            <tr>
                                                <th>از تعداد</th>
                                                <th>تا تعداد</th>
                                                <th>مبلغ فروش</th>
                                                <th>عملیات</th>
                                            </tr>
                                            @for ($Conter = 1; $Conter < 14; $Conter++)
                                                <tr id="PriceRow_{{ $Conter }}"
                                                    @if ($Conter != 1) class="nested" @endif>
                                                    <td id="FirstNumber_{{ $Conter }}">

                                                        1
                                                    </td>
                                                    <td>
                                                        <input type="number" id="ToNumber_{{ $Conter }}"
                                                            class="form-control" name="ToNumber[{{ $Conter }}]"
                                                            value="">

                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            onclick="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')"
                                                            onkeyup="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')"
                                                            name="Price[{{ $Conter }}]" value="">
                                                        <p id="BasePriceTxt_{{ $Conter }}"></p>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success"
                                                            onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                                            فرمول</button>
                                                    </td>
                                                </tr>
                                            @endfor


                                        </table>

                                    </div>
                                    <div id="fix_price" class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ پایه
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" placeholder="مبلغ فروش هر واحد"
                                                name="BasePrice" value="">
                                        </div>
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
    @include('Layouts.FilemanagerScripts')
    <script>
        function AddPriceRow($RowId) {
            if ($RowId < 14) {
                $('#PriceRow_' + $RowId).removeClass('nested');
                $CurentTonumber = $RowId - 1;
                $toNumer = $('#ToNumber_' + $CurentTonumber).val();
                $('#FirstNumber_' + $RowId).text($toNumer);
            } else {
                alert('تعداد سطوح فرمول تمام شد');
            }

        }
    </script>
    <script>
        $(document).ready(function() {
            $('#Goods').select2();
        });


        function FormolPrice() {
            $('#formol_price').removeClass('nested');
            $('#fix_price').addClass('nested');
        }

        function FixPrice() {
            $('#formol_price').addClass('nested');
            $('#fix_price').removeClass('nested');
        }
    </script>
@endsection
