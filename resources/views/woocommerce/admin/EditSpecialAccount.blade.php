@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')

    <div class="breadcrumb">
        <h1>عملیات فروش اکانت</h1>
        <ul>
            <li><a href="">ویرایش</a></li>
            <li>اکانت</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    @if ($AccessType == 'admin')
        <div class="2-columns-form-layout">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title"> ویرایش شاخص ها : {{ $good->NameFa }}</h3>
                                <button id="show_index" onclick="showindex()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">+</button>
                                <button id="hide_index" onclick="hideindex()" class="btn nested"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            <div id="index_iframe" class="nested card-body">
                                <iframe src="{{ route('ProductIndex', ['id' => $good->id, 'iframe' => true]) }}"
                                    style="height: 500px;width: 100%;border: none;"></iframe>
                            </div>
                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($AccessType == 'admin')
        <div class="2-columns-form-layout">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title"> ویرایش تصاویر : {{ $good->NameFa }}</h3>
                                <button id="show_galery" onclick="showgalery()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">+</button>
                                <button id="hide_galery" onclick="hidegalery()" class="btn nested"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            <div id="galery_iframe" class="nested card-body">
                                <iframe src="{{ route('ProductGalery', ['id' => $good->id, 'iframe' => true]) }}"
                                    style="height: 500px;width: 100%;border: none;"></iframe>
                            </div>
                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($AccessType == 'admin')
        <form method="post">
            @csrf
            <input type="text" name="ProductType" value="SpecialAccount" class="nested">
            <div class="2-columns-form-layout">
                <div class="">
                    <div class=" row">
                        <div class="col-lg-12">
                            <!-- start card -->
                            <div class="card">
                                <div class="card-header bg-transparent">
                                    <h3 class="card-title"> ویرایش اکانت : {{ $good->NameFa }}</h3>
                                    <button id="show_good" onclick="showgood()" type="button" class="btn"
                                        style="position: absolute;left: 10px;top: 9px;">+</button>
                                    <button id="hide_good" onclick="hidegood()" type="button" class="btn nested"
                                        style="position: absolute;left: 10px;top: 9px;">-</button>
                                </div>
                                <!--begin::form-->
                                <div id="good" class="nested card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1" class="ul-form__label"> SKU

                                            </label>
                                            <input type="text" class="form-control" name="SKU" placeholder="کد اکانت"
                                                value="{{ $good->SKU }}">
                                            <small class="ul-form__text form-text ">
                                                کد اکانت انبار داری
                                            </small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail2" class="ul-form__label">نام فارسی اکانت
                                            </label>
                                            <input type="text" class="form-control" required name="NameFa"
                                                placeholder="نام فارسی اکانت" value="{{ $good->NameFa }}">
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
                                                    placeholder="Enter Good English name" value="{{ $good->NameEn }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">واحد اکانت</label>
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
                                            <label for="inputEmail3" class="ul-form__label">مدت اعتبار به روز
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="text" class="form-control" name="weight"
                                                    value="{{ $good->weight }}">
                                                <small>صفر به معنای نا محدود زمانی است!</small>
                                            </div>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">آدرس اختیاری
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="text" class="form-control" name="urladdress"
                                                    value="{{ $good->urladdress }}">
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
                                            <label for="inputEmail3" class="ul-form__label">توضیحات
                                            </label>
                                            <div class="input-right-icon">
                                                <textarea id="hiddenArea" name="ce" required class="col-sm-12 form-control">
@if ($TextArr == null)
{{ $good->MainDescription }}
@else
{{ $TextArr->MainText }}
@endif
</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail3" class="ul-form__label">مشخصات
                                            </label>
                                            <div class="input-right-icon">
                                                <textarea id="hiddenArea" name="ce1" class="col-sm-12 form-control">
@if ($TextArr == null)
@else
{{ $TextArr->DiscText }}
@endif
</textarea>
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
    @endif
    <div class="2-columns-form-layout">
        <div class="">
            <div class=" row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title"> ویرایش نحوه فروش : {{ $good->NameFa }}</h3>
                            @if ($AccessType == 'admin')
                                <button id="show_warehouse" onclick="showarehouse()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">+</button>
                                <button id="hide_warehouse" onclick="hidewarehouse()" class="btn nested"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            @endif
                        </div>
                        <!--begin::form-->
                        @if ($GoodInWarehouse == null)
                            @if ($AccessType == 'admin')
                                <div id="warehouse_iframe" class="nested card-body">
                                @else
                                    <div id="warehouse_iframe" class="card-body">
                            @endif
                            <form action="{{ route('P_AddGoodToWarehouse') }}" method="post">
                                @csrf
                                <input type="text" name="ProductType" value="SpecialAccount" class="nested">
                                <div class="form-row">
                                    <div class="form-group col-md-6 ">
                                        <label for="inputEmail1" class="ul-form__label"> اکانت

                                        </label>
                                        <br>
                                        <select id="Goods" name="GoodID" class="form-control col-xl-8 col-md-7">
                                            <option value="{{ $good->id }}">
                                                {{ $good->NameFa }}</option>
                                        </select> <small class="ul-form__text form-text ">
                                            نام اکانت
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail2" class="ul-form__label">انبار
                                        </label>
                                        <select name="WarehouseID" class="form-control col-xl-8 col-md-7">

                                            @foreach ($Warehouses as $Warehouse)
                                                <option value="{{ $Warehouse->id }}">
                                                    {{ $Warehouse->Name }}</option>
                                            @endforeach
                                        </select>
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            انباری که اکانت در آن قرار میگیرد
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
                                        <label for="inputEmail3" class="ul-form__label"> مبلغ خرید ریال
                                        </label>
                                        <div class="input-right-icon">
                                            <input onkeyup="CurencyTextRT(this.value,'kharid')" type="number"
                                                class="form-control" name="BuyPrice" required
                                                placeholder="مبلغ خرید هر واحد" value="">
                                            <p id="kharid"></p>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="inputEmail3" class="ul-form__label">تعداد
                                            موجودی اخطار
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="AlertLimit" value="5">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3" class="ul-form__label">اخطار اتمام
                                            موجودی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="checkbox" class="form-control" name="AlertFinish" checked>
                                        </div>
                                    </div>
                                    <div id="fix_price" class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">تغییر وضعیت کاربر به اکانت:
                                        </label>

                                        <div class="input-right-icon">
                                            <select class="form-control" name="TargetRole">
                                                @foreach ($Roles as $Role)
                                                    <option value="{{ $Role->Role }}">{{ $Role->RoleName }} </option>
                                                @endforeach
                                            </select>
                                            <small>پس از خرید اکانت وضعیت کاربر به اکانت تعیین شده تغییر میکند!</small>
                                        </div>
                                    </div>
                                </div>
                                @if ($AccessType == 'admin')
                                    <div class="form-row">
                                    @else
                                        <div class="form-row nested">
                                @endif

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail3" class="ul-form__label"> مبلغ فروش به ریال <small
                                    style="color: red">مبلغ فروش پس از تخفیف</small></label>
                            <input onkeyup="CurencyTextRT(this.value,'mainPriceTxt')" type="number" class="form-control"
                                placeholder="مبلغ فروش هر واحد" name="Price" value="">
                            <p id="mainPriceTxt"></p>

                        </div>
                        <div id="fix_price" class="form-group col-md-6">
                            <label for="inputEmail3" class="ul-form__label"> مبلغ پایه ریال
                            </label>
                            <div class="input-right-icon">
                                <input onkeyup="CurencyTextRT(this.value,'basepricetext')" type="number"
                                    class="form-control" placeholder="مبلغ فروش هر واحد" name="BasePrice" value="">
                                <p id="basepricetext"></p>
                            </div>
                        </div>


                    </div>


                    <div class="card-footer">
                        <div class="mc-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary m-1" name="submit" value="UpdateGoods">ثبت
                                        اکانت
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            @else
                @if ($AccessType == 'admin')
                    <div id="warehouse_iframe" class="nested card-body">
                    @else
                        <div id="warehouse_iframe" class=" card-body">
                @endif

                <form action="{{ route('P_EditProductInStore', ['id' => $GoodInWarehouse->id]) }}" method="POST">
                    @csrf
                    <input type="text" name="ProductType" value="SpecialAccount" class="nested">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail1" class="ul-form__label"> اکانت</label>
                            <br>
                            <select id="Goods" name="GoodID" class="form-control col-xl-8 col-md-7">
                                <option value="{{ $good->id }}">{{ $good->NameFa }}</option>
                            </select> <small class="ul-form__text form-text ">
                                نام اکانت
                            </small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail2" class="ul-form__label">انبار
                            </label>
                            <select name="WarehouseID" class="form-control col-xl-8 col-md-7">
                                @foreach ($Warehouses as $Warehouse)
                                    <option value="{{ $Warehouse->id }}">
                                        {{ $Warehouse->Name }}</option>
                                @endforeach

                            </select>
                            <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                انباری که اکانت در آن قرار میگیرد
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
                                <input onclick="CurencyTextRT(this.value,'mainPriceTxt')"
                                    onkeyup="CurencyTextRT(this.value,'mainPriceTxt')" type="number" class="form-control"
                                    name="BuyPrice" required placeholder="مبلغ خرید هر واحد"
                                    value="{{ $GoodInWarehouse->BuyPrice }}">
                                <p id="mainPriceTxt"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail3" class="ul-form__label">تغییر وضعیت کاربر به اکانت:
                            </label>
                            <div class="input-right-icon">
                                <select class="form-control" name="TargetRole">
                                    @foreach ($Roles as $Role)
                                        @if ($extra->TargetRole == $Role->Role)
                                            <option selected value="{{ $Role->Role }}">{{ $Role->RoleName }} </option>
                                        @else
                                            <option value="{{ $Role->Role }}">{{ $Role->RoleName }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                <small>پس از خرید اکانت وضعیت کاربر به اکانت تعیین شده تغییر میکند!</small>
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
                    @if ($AccessType == 'admin')
                        <div class="form-row">
                        @else
                            <div class="form-row nested">
                    @endif
            </div>
            <div class="form-row">
                <div id="fix_price" class="@if ($GoodInWarehouse->PricePlan != null) nested @endif form-group col-md-6">
                    <label for="inputEmail3" class="ul-form__label">مبلغ فروش </label>

                    <div class="input-right-icon">
                        <input onclick="CurencyTextRT(this.value,'MainPrice')"
                            onkeyup="CurencyTextRT(this.value,'MainPrice')" type="number" class="form-control"
                            placeholder="مبلغ فروش هر واحد" name="Price" value="{{ $GoodInWarehouse->Price }}">
                        <p id="MainPrice"></p>
                    </div>
                </div>
                <div id="fix_price" class="form-group col-md-6">
                    <label for="inputEmail3" class="ul-form__label">مبلغ پایه
                    </label>
                    <div class="input-right-icon">
                        <input onclick="CurencyTextRT(this.value,'BasePriceTxt')"
                            onkeyup="CurencyTextRT(this.value,'BasePriceTxt')" type="number" class="form-control"
                            placeholder="مبلغ فروش هر واحد" name="BasePrice" value="{{ $GoodInWarehouse->BasePrice }}">
                        <p id="BasePriceTxt"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary m-1" name="submit" value="UpdateGoods">ثبت
                        اکانت </button>

                </div>
            </div>
            </form>
        </div>
        @endif
        <!-- end::form -->
    </div>
    </div>
    </div>
    </div>
    </div>
    @if ($AccessType == 'admin')
        <div class="2-columns-form-layout">
            <div class="">
                <div class=" row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title">عملیات ویژه</h3>
                                <button id="show_operation" onclick="showoperation()" class="btn"
                                    style="position: absolute;left: 10px;top: 9px;">+</button>
                                <button id="hide_operation" onclick="hideoperation()" class="btn nested"
                                    style="position: absolute;left: 10px;top: 9px;">-</button>
                            </div>
                            <!--begin::form-->
                            <div id="operation_iframe" class="nested card-body">
                                <form method="post">
                                    @csrf
                                    <button type="submit" name="delete" value="1" class="btn btn-danger">حذف محصول</button>
                                </form>
                            </div>

                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
@section('page-js')
    @include('Layouts.FilemanagerScripts')
    <script>
        function showoperation() {
            $('#show_operation').addClass('nested');
            $('#hide_operation').removeClass('nested');
            $('#operation_iframe').removeClass('nested');

        }

        function hideoperation() {
            $('#show_operation').removeClass('nested');
            $('#hide_operation').addClass('nested');
            $('#operation_iframe').addClass('nested');

        }

        function showarehouse() {
            $('#show_warehouse').addClass('nested');
            $('#hide_warehouse').removeClass('nested');
            $('#warehouse_iframe').removeClass('nested');
        }

        function hidewarehouse() {
            $('#show_warehouse').removeClass('nested');
            $('#hide_warehouse').addClass('nested');
            $('#warehouse_iframe').addClass('nested');
        }

        function showgalery() {
            $('#show_galery').addClass('nested');
            $('#hide_galery').removeClass('nested');
            $('#galery_iframe').removeClass('nested');
        }

        function hidegalery() {
            $('#show_galery').removeClass('nested');
            $('#hide_galery').addClass('nested');
            $('#galery_iframe').addClass('nested');
        }

        function showindex() {
            $('#show_index').addClass('nested');
            $('#hide_index').removeClass('nested');
            $('#index_iframe').removeClass('nested');
        }

        function hideindex() {
            $('#show_index').removeClass('nested');
            $('#hide_index').addClass('nested');
            $('#index_iframe').addClass('nested');
        }

        function showgood() {
            $('#show_good').addClass('nested');
            $('#hide_good').removeClass('nested');
            $('#good').removeClass('nested');
        }

        function hidegood() {
            $('#show_good').removeClass('nested');
            $('#hide_good').addClass('nested');
            $('#good').addClass('nested');
        }
    </script>
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

        function AddUnitRow($RowId) {
            if ($RowId < 14) {
                $('#UnitRow_' + $RowId).removeClass('nested');
                $CurentTonumber = $RowId - 1;
            } else {
                alert('تعداد سطوح فرمول تمام شد');
            }

        }
    </script>
    <script>
        function FormolPrice() {
            $('#formol_price').removeClass('nested');
            $('#fix_price').addClass('nested');
            $(".formol_price_in").prop('disabled', false);
        }

        function FixPrice() {
            $('#formol_price').addClass('nested');
            $('#fix_price').removeClass('nested');
            $(".formol_price_in").prop('disabled', true);
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
