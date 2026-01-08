@php
$Persian = new App\Functions\persian();
if ($iframe) {
    $Layout = 'iframe';
} else {
    $Layout = null;
}
@endphp
@extends("Layouts.MainPage",['layout'=>$Layout])
@section('page-header-left')
@endsection
@section('MainCountent')
    @if (!$iframe)
        <div class="breadcrumb">
            <h1>{{ $TargetStore->Name }} </h1>
            <ul>
                <li><a href="">ویرایش </a></li>
                <li>کالا</li>
            </ul>
        </div>

        <div class="separator-breadcrumb border-top"></div>
    @endif
    <form method="post">
        @csrf
        <div class="2-columns-form-layout">
            <div class="___class_+?3___">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            @if (!$iframe)
                                <div class="card-header bg-transparent">
                                    <h3 class="card-title"> ویرایش کالا در انبار</h3>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail1" class="ul-form__label"> کالا</label>
                                        <br>
                                        <select id="Goods" name="GoodID" class="form-control col-xl-8 col-md-7">
                                            <option value="{{ $Good->id }}">{{ $Good->NameFa }}</option>
                                        </select> <small class="ul-form__text form-text ">
                                            نام کالا
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">انبار
                                        </label>
                                        <select name="WarehouseID" class="form-control col-xl-8 col-md-7">
                                            <option value="{{ $Warehouse->id }}">{{ $Warehouse->Name }}</option>
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
                                                placeholder="تعداد واحد محصول" value="{{ $GoodInWarehouse->QTY }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ خرید
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="BuyPrice" required
                                                placeholder="مبلغ خرید هر واحد" value="{{ $GoodInWarehouse->BuyPrice }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">حد اکثر فروش در هر فاکتور </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control"
                                                placeholder="حد اکثر تعداد فروش در هر فاکنور" name="SaleLimit"
                                                value="{{ $GoodInWarehouse->SaleLimit }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">تعداد موجودی اخطار
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="AlertLimit"
                                                value="{{ $GoodInWarehouse->AlertLimit }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">تعداد موجودی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="Remian"
                                                value="{{ $GoodInWarehouse->Remian }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3" class="ul-form__label">اخطار اتمام موجودی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="checkbox" class="form-control" name="AlertFinish"
                                                @if ($GoodInWarehouse->AlertFinish == 1) checked @endif>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">تاریخ ورود به انبار </label>
                                        <div class="input-right-icon">
                                            <input type="date" required class="form-control"
                                                placeholder="تاریخ ورود به انبار" name="InputDate"
                                                value="{{ $GoodInWarehouse->InputDate }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">شروع به فروش </label>
                                        <div class="input-right-icon">
                                            <input class="form-control" placeholder="تاریخ و زمان شروع به فروش"
                                                name="ActiveTime" value="{{ $GoodInWarehouse->ActiveTime }}">
                                        </div>
                                        <label for="inputEmail3" class="ul-form__label">اتمام فروش </label>
                                        <div class="input-right-icon">
                                            <input class="form-control" placeholder="تاریخ و زمان شروع اتمام فروش"
                                                name="DeactiveTime" value="{{ $GoodInWarehouse->DeactiveTime }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">تاریخ تولید
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="date" required class="form-control" name="MadeDate"
                                                placeholder="تاریخ تولید محصول" value="{{ $GoodInWarehouse->MadeDate }}">
                                        </div>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">تاریخ انقضا
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="date" class="form-control" name="ExpireDate"
                                                placeholder="تاریخ انقضای محصول"
                                                value="{{ $GoodInWarehouse->ExpireDate }}">
                                        </div>

                                    </div>

                                </div>
                                <div class="form-row">
                                    <div id="fix_price" class="@if ($GoodInWarehouse->PricePlan != null) nested @endif form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ فروش
                                            <a onclick="FixPrice()" class="btn btn-success">مبلغ ثابت</a>
                                            <a onclick="FormolPrice()" class="btn btn-warning">مبلغ فرمولی</a>
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" placeholder="مبلغ فروش هر واحد"
                                                name="Price" value="{{ $GoodInWarehouse->Price }}">
                                        </div>
                                        <small style="color: red">در صورتی که از فرمول استفاده میکنید این قسمت را خالی
                                            بگذارید</small>
                                    </div>
                                    <div id="formol_price" class=" @if ($GoodInWarehouse->PricePlan == null) nested @endif form-group col-md-6">
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
                                            @if ($GoodInWarehouse->PricePlan != null)
                                                @php
                                                    $Conter = 0;
                                                @endphp
                                                @foreach (json_decode($GoodInWarehouse->PricePlan) as $targetPlan)
                                                    <tr id="PriceRow_1">
                                                        <td>
                                                            @if ($Conter == 0)
                                                                1
                                                            @else
                                                                {{ $OldToNumber }}
                                                            @endif
                                                            @php
                                                                $Conter++;
                                                                $OldToNumber = $targetPlan->ToNumber;
                                                            @endphp

                                                        </td>
                                                        <td>
                                                            <input type="number" id="ToNumber_{{ $Conter }}"
                                                                class="form-control" name="ToNumber[{{ $Conter }}]"
                                                                value="{{ $targetPlan->ToNumber }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                name="Price[{{ $Conter }}]"
                                                                value="{{ $targetPlan->Price }}">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                                                فرمول</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @for ($Conter++; $Conter < 14; $Conter++)
                                                    <tr id="PriceRow_{{ $Conter }}" class="nested">
                                                        <td id="FirstNumber_{{ $Conter }}">

                                                        </td>
                                                        <td>
                                                            <input type="number" id="ToNumber_{{ $Conter }}"
                                                                class="form-control" name="ToNumber[{{ $Conter }}]"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                name="Price[{{ $Conter }}]" value="">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                                                فرمول</button>
                                                        </td>
                                                    </tr>
                                                @endfor

                                            @else
                                                @for ($Conter = 1; $Conter < 14; $Conter++)
                                                    <tr id="PriceRow_{{ $Conter }}" @if ($Conter != 1) class="nested"  @endif>
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
                                                                name="Price[{{ $Conter }}]" value="">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                                                فرمول</button>
                                                        </td>
                                                    </tr>

                                                @endfor

                                            @endif
                                        </table>


                                    </div>
                                    <div id="fix_price" class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">مبلغ پایه
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" placeholder="مبلغ فروش هر واحد"
                                                name="BasePrice" value="{{ $GoodInWarehouse->BasePrice }}">
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
