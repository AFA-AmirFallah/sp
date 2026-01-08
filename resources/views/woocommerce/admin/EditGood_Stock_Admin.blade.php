@php
    $renteing = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('renting') ?? 0;
    $alerted = App\Shop\ProductAlert::get_product_alert($good->id);
    $alerted = count($alerted);
@endphp
<form id="warehouseForm" action="{{ route('P_AddGoodToWarehouse') }}" method="post">
    @csrf
    <div class=" row">
        <div class="col-lg-12">
            <!-- start card -->
            <div class="card">

                <div class="card-header gradient-purple-indigo 0-hidden pb-80">

                    <div>
                        <button id="hide_warehouse" style="float: left;" onclick="hidewarehouse()" class="btn"><i
                                style="font-weight: 800" class="i-Remove text-20"></i></button>


                    </div>

                    انبارها


                </div>

                <div id="licens_view" style="margin: 4px;" class="row">

                    @php
                        $WarehouseSrc = $Product->get_good_warehouse();
                    @endphp
                    @if ($WarehouseSrc == [])
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <a onclick="loadwarehouse('0')">
                                <div class="selectors p-4 rounded d-flex align-items-center text-white bg-warning">
                                    <i class="i-Shop  text-32 mr-3"></i>
                                    <div>
                                        <h4 class="text-18 mb-1 text-white">بدون انبار</h4>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        @foreach ($WarehouseSrc as $warehouse)
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                <input class="nested" id="WGID" value="0">
                                <a onclick="loadwarehouse('{{ $warehouse->id }}')">
                                    <div
                                        class="selectors p-4 rounded d-flex align-items-center text-white @if ($warehouse->OnSale == 1) bg-success @else bg-warning @endif">
                                        <i class="i-Shop  text-32 mr-3"></i>
                                        <div>
                                            <h4 class="text-18 mb-1 text-white">{{ $warehouse->Name }} </h4>
                                            <small>موجودی {{ $warehouse->Remian }} واحد</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif



                </div>
                <div class="card-footer">
                    <button type="button" onclick="loadwarehouse('0')" style="float: left;" class="btn btn-primary">

                        افزودن انبار جدید
                    </button>

                </div>

            </div>
            <div id="detailcard" class="card nested">
                <div class="card-header bg-transparent">
                    <h3 id="productTitle" class="card-title"></h3>
                    <div style="position: absolute;left: 10px;top: 9px;">
                        @can('offline')
                            @php
                                $Offline = false;
                                if ($GoodInWarehouse != null && $GoodInWarehouse->MaxPrice != 0) {
                                    $Offline = true;
                                }
                            @endphp
                            @if ($Offline)
                                @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                    <a onclick="offline()" id="online_btn_active" class="btn btn-success ">فروش
                                        آفلاین</a>
                                    <a onclick="offline()" id="online_btn_deactive" class="btn nested">فروش
                                        آفلاین</a>
                                @endif
                                <a onclick="online()" id="offline_btn_active" class="btn btn-success nested">فروش
                                    آنلاین</a>
                                <a onclick="online()" id="offline_btn_deactive" class="btn ">فروش
                                    آنلاین</a>
                            @else
                                <a onclick="offline()" id="online_btn_active" class="btn btn-success nested">فروش
                                    آفلاین</a>
                                <a onclick="offline()" id="online_btn_deactive" class="btn ">فروش آفلاین</a>
                                <a onclick="online()" id="offline_btn_active" class="btn btn-success">فروش
                                    آنلاین</a>
                                <a onclick="online()" id="offline_btn_deactive" class="btn nested">فروش
                                    آنلاین</a>
                            @endif
                        @endcan


                        <button id="hide_warehouse" onclick="hidewarehouse()" class="btn">-</button>
                    </div>

                </div>
                <!--begin::form-->


                <div class="card-body">


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputEmail1" class="ul-form__label"> کالا</label>
                            <br>
                            <input class="nested" name="GoodID" value="{{ $good->id }}">
                            <h5 id="product_name">{{ $good->NameFa }}</h5>
                            <small class="ul-form__text form-text ">
                                نام کالا
                            </small>
                        </div>

                        @if (Auth::user()->Role == App\myappenv::role_SuperAdmin || Auth::user()->Role == App\myappenv::role_ShopAdmin)
                            <div class="form-group col-md-4">
                                <label for="inputEmail4" class="ul-form__label">مالک :</label>
                                <div id="ownerselector">
                                    @include('Layouts.SearchUserInput', [
                                        'InputName' => 'UserName',
                                        'InputPalceholder' => __('Target username'),
                                    ])
                                </div>

                                <input id="ownerusername" class="nested" type="text" value="" class="">
                                <div id="ownerdisplay" class="input-group col-xl-8 col-md-7">
                                    <div id="name_of_target_user" class="tag">
                                        <div id="nametarget"></div> <input type="hidden" name="tag[]"
                                            value="preexisting-tag"><a role="button"
                                            onclick="changestatetosearcharialoacl()" class="tag-i">×</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group col-md-4">
                            <label for="inputEmail2" class="ul-form__label">انبار
                            </label>
                            <h5 id="warehousename">انبار</h5>
                            <select id="WarehouseID" name="WarehouseID" class="custom-select col-xl-8 col-md-7"
                                id="warehouse" style="width:100%">
                                @foreach ($Warehouses as $Warehouse)
                                    <option value="{{ $Warehouse->id }}">
                                        {{ $Warehouse->Name }}</option>
                                @endforeach
                            </select>
                            <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                انباری که کالا در آن قرار دارد
                            </small>
                        </div>
                    </div>
                    <div id="NormalSale">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="ul-form__label">تعداد ورود به انبار
                                </label>
                                <span class="label_red">*</span>
                                <div class="input-right-icon">
                                    <h3 id="QTY_txt">12</h3>
                                    <input type="number" class="form-control" name="QTY" id="QTY"
                                        required placeholder="  تعداد  محصول موجود در انبار  " value="">
                                </div>
                            </div>
                            <div class="on-edit-part form-group col-md-2">
                                <label class="ul-form__label">تعداد موجودی باقی مانده
                                </label>
                                <div class="input-right-icon">
                                    <input type="number" class="form-control" name="Remian" id="Remian"
                                        value="">
                                </div>
                            </div>
                            <div class="on-edit-part form-group col-md-2">
                                <label class="ul-form__label">تعداد موجودی اخطار
                                </label>
                                <div class="input-right-icon">
                                    <input type="number" class="form-control" name="AlertLimit" id="AlertLimit"
                                        value="">
                                </div>
                            </div>
                            <div class="on-edit-part form-group col-md-2">
                                <label class="ul-form__label">حد اکثر فروش در هر فاکتور
                                </label>
                                <div class="input-right-icon">
                                    <input type="number" class="form-control"
                                        placeholder="حد اکثر تعداد فروش در هر فاکنور" name="SaleLimit" id="SaleLimit"
                                        value="">
                                </div>
                            </div>
                            <div class="on-edit-part form-group col-md-2">
                                <label class="ul-form__label">اخطار اتمام موجودی
                                </label>
                                <div class="input-right-icon">
                                    <input type="checkbox" class="form-control" name="AlertFinish" id="AlertFinish">
                                </div>

                            </div>
                        </div>
                        @php
                            $step_price =
                                \App\Http\Controllers\setting\SettingManagement::GetSettingValue('step_mode') ?? 0;
                        @endphp

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label class="ul-form__label">مبلغ خرید
                                </label>
                                <span class="label_red">*</span>
                                <div class="input-right-icon">
                                    <input onclick="CurencyTextRT(this.value,'mainPriceTxt')"
                                        onkeyup="CurencyTextRT(this.value,'mainPriceTxt')" type="number"
                                        class="form-control" name="BuyPrice" id="BuyPrice" required
                                        placeholder="مبلغ خرید هر واحد" value="">
                                    <p id="mainPriceTxt"></p>
                                </div>
                            </div>
                            <div id="fix_price" class="form-group col-md-4">

                                <label class="ul-form__label">مبلغ فروش
                                </label>
                                @if ($step_price == 1 || $step_price == 2)
                                    <span class="label_red">* در صورتی که مبلغ صفر باشد از جدول پلکانی استفاده می
                                        شود</span>
                                @endif

                                <div class="input-right-icon">
                                    <input onclick="CurencyTextRT(this.value,'MainPrice')"
                                        onkeyup="CurencyTextRT(this.value,'MainPrice')" type="number"
                                        class="form-control" placeholder="مبلغ فروش هر واحد" name="MainPrice"
                                        id="Price" value="">
                                    <input class="d-none" id="cover_price" type="text">
                                    <p id="MainPrice"></p>
                                </div>

                            </div>
                            <div id="fix_price" class="form-group col-md-4">
                                <label class="ul-form__label">مبلغ پایه(مبلغ پیش از تخفیف)
                                </label>
                                <span class="label_red">*</span>
                                <div class="input-right-icon">
                                    <input onclick="CurencyTextRT(this.value,'BasePriceTxt')"
                                        onkeyup="CurencyTextRT(this.value,'BasePriceTxt')" type="number"
                                        class="form-control" placeholder="مبلغ فروش هر واحد" name="BasePrice"
                                        id="BasePrice" value="">
                                    <p id="BasePriceTxt"></p>
                                </div>
                            </div>
                        </div>


                        <div id="step_price_table"  class="form-row">

                        </div>

                        <div class="on-edit-part form-row">
                            @isset($good->onrent)
                                @if ($good->onrent == 0)
                                    @if ($renteing)
                                        <form method="POST">
                                            @csrf

                                            <div class="form-group col-md-12">
                                                <label class="ul-form__label">کالای اجاره ای
                                                </label>
                                                <div class=" row form-group nested "
                                                    style="display: flex;margin-right: 10px;padding: 15px;background-color: gainsboro;"
                                                    id="listing">
                                                    <label style="margin-left: 5px" class="ul-form__label"> دسته اجاره:
                                                    </label>

                                                    <select id="meta_selector" onchange="select_device_meta()"
                                                        class="form-control select col-xl-4 col-md-3">
                                                        <option value="0">لطفا انتخاب کنید</option>
                                                        @foreach (\App\Renting\ProductRenting::get_DeviceMeta_list() as $DeviceMeta)
                                                            <option value="{{ $DeviceMeta->ID }}">
                                                                {{ $DeviceMeta->DeviceName }}</option>
                                                        @endforeach

                                                    </select>

                                                    <select onchange="select_device_meta()"
                                                        class="form-control select col-xl-4 col-md-3" name="DeviceType">
                                                        <option value="0">لطفا انتخاب کنید</option>
                                                        @foreach (\App\Renting\ProductRenting::get_DeviceTypes() as $DeviceType)
                                                            <option
                                                                class="devicetype_{{ $DeviceType->MetaID }} devicetypes nested"
                                                                id="DeviceNameSub_{{ $DeviceType->ID }}"
                                                                value="{{ $DeviceType->ID }}">
                                                                {{ $DeviceType->DeviceName }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div id="rening_div" class="form-group col-md-12">

                                                    <button type="button" onclick="conert_to_rating()"
                                                        class="btn btn-danger">این کالا اجاره داده می
                                                        شود</button>
                                                </div>


                                            </div>
                                        </form>
                                    @endif





                                    <script>
                                        function select_device_meta() {
                                            //  alert('sss' + $('#meta_selector').find(":selected").val());
                                            $selectID = $('#meta_selector').find(":selected").val();
                                            $('.devicetypes').addClass('nested');
                                            $('.devicetype_' + $selectID).removeClass('nested');
                                        }

                                        function conert_to_rating() {
                                            $('#listing').removeClass('nested');
                                            $('#rening_div').html(`
                                    <p class="text-danger">آیا از انجام این عمل مطمئن هستید؟ <br> در جریان
                                            باشید کالای اجاره ای به کالای مورد فروش تیدیل نخواهد شد!</p>
                                        <button type="submit" name="submit" value="renting"
                                            class="btn btn-danger">مطمئنم</button>
                                        <button type="button" onclick="cancel_to_rating()"
                                            class="btn btn-success">انصراف</button>
                                    `);
                                        }

                                        function cancel_to_rating() {
                                            $('#listing').addClass('nested');
                                            $('#rening_div').html(`
                                    <button type="button" onclick="conert_to_rating()"
                                            class="btn btn-danger">این کالا اجاره داده می
                                            شود</button>
                                    `);
                                        }
                                    </script>
                            </div>
                            <div class="nested from-row">
                                <div class=" card text-left">
                                    <div class="card-header bg-transparent" style="text-align: right">
                                        <h5>فروش پیشرفته</h5>
                                        <button style="position: relative; left: 10px;top: 9px;" onclick="addatt()"
                                            class="btn btn-success" type="button"> افزودن صفت
                                            محصول </button>

                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="attr_val"
                                                class="{{ \App\myappenv::MainTableClass }} nested display table table-striped table-bordered"
                                                class="" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>مشخصه</th>
                                                        <th>مقدار </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>صفت محصول</th>
                                                        <th><input type="text" id="productattName"
                                                                class="form-control"></th>

                                                    </tr>
                                                    <tr>
                                                        <th>مقدار صفت</th>
                                                        <th><input type="text" id="productattval"
                                                                class="form-control"></th>

                                                    </tr>
                                                    <tr>
                                                        <th>موجودی</th>
                                                        <th><input type="number" id="productattremain"
                                                                class="form-control"></th>

                                                    </tr>
                                                    <tr>
                                                        <th>مبلغ خرید</th>
                                                        <th><input type="number"
                                                                onkeyup="CurencyTextRT(this.value,'productattbuypricetext')"
                                                                id="productattbuyprice" class="form-control">
                                                            <div id="productattbuypricetext"></div>
                                                        </th>

                                                    </tr>
                                                    <tr>
                                                        <th>مبلغ فروش</th>
                                                        <th><input type="number" id="productattprice"
                                                                onkeyup="CurencyTextRT(this.value,'productattpricetext')"
                                                                class="form-control">
                                                            <div id="productattpricetext"></div>
                                                        </th>

                                                    </tr>
                                                    <tr>
                                                        <th>مبلغ پایه</th>
                                                        <th><input type="number" id="productattbaseprice"
                                                                class="form-control"></th>

                                                    </tr>
                                                    <tr>
                                                        <th>توضیحات</th>
                                                        <th><input type="text" id="productattnote"
                                                                class="form-control"></th>

                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">

                                                            <button class="btn btn-danger" type="button"
                                                                onclick="cancelatt()">بی خیال</button>

                                                            <button class="btn btn-success" type="button"
                                                                onclick="addattdata()">افزودن</button>
                                                        </th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                            <table class="display table table-striped table-bordered"
                                                class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>صفت محصول</th>
                                                        <th>مقدار صفت</th>
                                                        <th>موجودی</th>
                                                        <th>مبلغ خرید</th>
                                                        <th>مبلغ فروش</th>
                                                        <th>مبلغ پایه</th>
                                                        <th>توضیحات</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($Conter = 1; $Conter < 14; $Conter++)
                                                        <tr id="AttRow_{{ $Conter }}">
                                                            <th id="AttName_{{ $Conter }}"></th>
                                                            <th id="Attval_{{ $Conter }}"></th>
                                                            <th id="AttRemain_{{ $Conter }}"></th>
                                                            <th id="AttBuyPrice_{{ $Conter }}"></th>
                                                            <th id="AttPrice_{{ $Conter }}"></th>
                                                            <th id="AttBasePrice_{{ $Conter }}"></th>
                                                            <th id="AttNote_{{ $Conter }}"></th>
                                                            <th id="AttOP_{{ $Conter }}">


                                                            </th>
                                                        </tr>
                                                    @endfor
                                                </tbody>


                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @else
                        </div>
                        <div class="on-edit-part from-row">
                            <div class="card text-left">
                                <div class="card-header bg-transparent" style="text-align: right">
                                    <h5>کالای اجاره ای </h5>


                                </div>

                                <div class="card-body">


                                </div>
                            </div>
                        </div>
                        @endif

                    @endisset



                </div>
                <div class="nested form-row">
                    <input class="nested" id="nowdate" value="{{ date('Y-m-d') }}">


                    <div class="form-group col-md-3">
                        <label class="ul-form__label">تاریخ ورود به انبار </label>
                        <span class="label_red">*</span>
                        <div class="input-right-icon">
                            <input type="date" required class="form-control" placeholder="تاریخ ورود به انبار"
                                name="InputDate" id="InputDate" value="">
                        </div>
                    </div>
                    @if ($AccessType == 'admin')
                        <div class="form-group col-md-3">
                            <label class="ul-form__label">شروع به فروش </label>
                            <div class="input-right-icon">
                                <input class="form-control" placeholder="تاریخ و زمان شروع به فروش" name="ActiveTime"
                                    id="ActiveTime" value="">
                            </div>
                            <label class="ul-form__label">اتمام فروش </label>
                            <div class="input-right-icon">
                                <input class="form-control" placeholder="تاریخ و زمان شروع اتمام فروش"
                                    name="DeactiveTime" id="DeactiveTime" value="">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="ul-form__label">تاریخ تولید
                            </label>
                            <div class="input-right-icon">
                                <input type="date" required class="form-control" name="MadeDate" id="MadeDate"
                                    placeholder="تاریخ تولید محصول" value="">
                            </div>

                        </div>
                        <div class="form-group col-md-3">
                            <label class="ul-form__label">تاریخ انقضا
                            </label>
                            <div class="input-right-icon">
                                <input type="date" class="form-control" id="ExpireDate" name="ExpireDate"
                                    placeholder="تاریخ انقضای محصول" value="">
                            </div>

                        </div>
                    @endif
                </div>
                @can('offline')
                    @if ($Offline)
                        <div id="PreInvoice" class=" ">
                        @else
                            <div id="PreInvoice" class="nested ">
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="ul-form__label">حداقل مبلغ
                            </label>
                            <div class="input-right-icon">
                                <input onclick="CurencyTextRT(this.value,'minPriceTxt')"
                                    onkeyup="CurencyTextRT(this.value,'minPriceTxt')" type="number" class="form-control"
                                    name="MinPrice" id="MinPrice" required placeholder="حداقل مبلغ فروش"
                                    value="">
                                <p id="minPriceTxt"></p>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="ul-form__label">حداکثر مبلغ
                            </label>
                            <div class="input-right-icon">
                                <input onclick="CurencyTextRT(this.value,'maxPriceTxt')"
                                    onkeyup="CurencyTextRT(this.value,'maxPriceTxt')" type="number" class="form-control"
                                    name="MaxPrice" id="MaxPrice" required placeholder="حد اکثر مبلغ فروش"
                                    value="">
                                <p id="maxPriceTxt"></p>
                            </div>
                        </div>

                    </div>
                    <label class="ul-form__label">توضیحات کالا
                    </label>
                    <textarea rows="5" name="Note" id="Note" class="col-sm-12 form-control"></textarea>

                </div>
            @endcan

        </div>


        <div class="row">
            <div class="col-lg-12">
                @if ($Offline ?? false)
                    <button type="submit" id="online_btn_submit" class="btn btn-primary m-1 nested" name="submit"
                        value="online">ثبت موجودی </button>
                    @if ($alerted > 0)
                        <button type="submit" id="online_btn_submit" class="btn btn-primary m-1" name="submit"
                            value="online_alert">ثبت موجودی و اطلاع رسانی </button>
                    @endif
                    @can('offline')
                        <button type="submit" id="offline_btn_submit" class="btn btn-primary m-1 " name="submit"
                            value="offline">ثبت موجودی آفلاین </button>
                    @endcan
                @else
                    <button type="submit" id="online_btn_submit" class="btn btn-primary m-1" name="submit"
                        value="online">ثبت موجودی </button>
                    @if ($alerted > 0)
                        <button type="submit" id="online_btn_submit" class="btn btn-primary m-1 " name="submit"
                            value="online_alert">ثبت موجودی و اطلاع رسانی </button>
                    @endif
                    @can('offline')
                        <button type="submit" id="offline_btn_submit" class="btn btn-primary m-1 nested" name="submit"
                            value="offline">ثبت موجودی آفلاین </button>
                    @endcan
                @endif
                @php
                    $active = $GoodInWarehouse->OnSale ?? 0;
                @endphp
                <button type="submit" id="DisableItem"
                    class="btn btn-warning m-1 @if (!$active) d-none @endif" name="submit"
                    value="DisableItem">غیر
                    فعال
                    سازی کالا
                </button>
                <button type="submit" id="EnableItem"
                    class="btn btn-success m-1 @if ($active) d-none @endif" name="submit"
                    value="EnableItem">فعال
                    سازی
                    کالا
                </button>
            </div>
        </div>
    </div>

    <!-- end::form -->
    </div>
</form>

<script>
    $BaseAddress = '<?php echo route('home'); ?>';

    function addgoodtowarehose() {
        $('.on-edit-part').addClass('nested');
        $nowdate = $('#nowdate').val();

        $('#detailcard').removeClass('nested');
        $('#warehouseForm').attr('action', $BaseAddress + '/AddGoodToWarehouse');
        $('#warehousename').addClass('nested');
        $('#WarehouseID').removeClass('nested');
        $('#ownerselector').removeClass('nested');
        $('#ownerdisplay').addClass('nested');
        $('#QTY_txt').addClass('nested');
        $('#QTY').val('');
        $('#QTY').removeClass('nested');
        $('#Remian').val('');
        $('#AlertLimit').val('');
        $('#SaleLimit').val('');
        $('#AlertFinish').val('');
        $('#BasePrice').val('');
        $('#BuyPrice').val('');
        $('#Price').val('');
        $('#InputDate').val($nowdate);
        $('#ActiveTime').val('');
        $('#DeactiveTime').val('');
        $('#MadeDate').val($nowdate);
        $('#ExpireDate').val($nowdate);
        $('#MinPrice').val('0');
        $('#MaxPrice').val('0');
        $('#Note').val('');

    }

    function loadattribute(data) {
        //TODO: clear table before jobs
        i = 1;
        $.each(data, function(index, value) {
            istr = i.toString();
            saveedbutton = `<a onclick="SaveAtt(` + istr + `)" title="ذخیره">
                <i style = "font-size: 25px;color: green;"
            class = "i-Data-Yes" ></i></a>`;
            $('#AttName_' + istr).html(value['AttName']);
            $('#Attval_' + istr).html(value['Attval']);
            $('#AttRemain_' + istr).html(value['AttRemain']);
            $('#AttBuyPrice_' + istr).html(value['AttBuyPrice']);
            $('#AttPrice_' + istr).html(value['AttPrice']);
            $('#AttBasePrice_' + istr).html(value['AttBasePrice']);
            $('#AttNote_' + istr).html(value['AttNote']);
            $('#AttOP_' + istr).html(saveedbutton);
            i++;

        });


        return false;
    }

    function loadwarehouse($WGID) {

        $('#WGID').val($WGID);
        $ProductName = $('#product_name').html();
        $addRoute = '/AddGoodToWarehouse';
        if ($WGID == 0) {
            $('#productTitle').html('افزودن موجودی ' + $ProductName);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'load_step_table',
                    WGID: $WGID,

                },
                function(data, status) {
                    $('#step_price_table').html(data);

                });

           
            addgoodtowarehose();
        } else {
            $('.on-edit-part').removeClass('nested');
            $('#productTitle').html('ویرایش موجودی ' + $ProductName);
            $('#detailcard').removeClass('nested');
            $('#warehouseForm').attr('action', $BaseAddress + '/EditProductInStore/' + $WGID);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'loadwarehouse',
                    WGID: $WGID,

                },
                function(data, status) {
                    $('#warehousename').removeClass('nested');
                    $('#warehousename').html(data['warehousename']);
                    $('#WarehouseID').addClass('nested');
                    $('#WarehouseID').val(data['WarehouseID']);
                    $('#ownerselector').addClass('nested');
                    $('#ownerdisplay').removeClass('nested');
                    $('#ownerusername').val(data['owner']);
                    $('#nametarget').html(data['ownerusername']);
                    $('#QTY').addClass('nested');
                    $('#QTY').val(data['QTY']);
                    $('#QTY_txt').html(data['QTY']);
                    $('#QTY_txt').removeClass('nested');
                    $('#Remian').val(data['Remian']);
                    $('#AlertLimit').val(data['AlertLimit']);
                    $('#SaleLimit').val(data['AlertLimit']);
                    $('#AlertFinish').val(data['AlertFinish']);
                    $('#BasePrice').val(data['BasePrice']);
                    $('#BuyPrice').val(data['BuyPrice']);
                    $('#Price').val(data['Price']);
                    $('#cover_price').val(data['Price']);
                    $('#InputDate').val(data['InputDate']);
                    $('#ActiveTime').val(data['ActiveTime']);
                    $('#DeactiveTime').val(data['DeactiveTime']);
                    $('#MadeDate').val(data['MadeDate']);
                    $('#ExpireDate').val(data['ExpireDate']);
                    $('#MinPrice').val(data['MinPrice']);
                    $('#MaxPrice').val(data['MaxPrice']);
                    $('#Note').val(data['Note']);
                    $('#step_price_table').html(data['step_table']);
                    onsale = data['OnSale'];
                    if (onsale == 1) {
                        $('#EnableItem').addClass('d-none');
                        $('#DisableItem').removeClass('d-none');
                    } else {
                        $('#DisableItem').addClass('d-none');
                        $('#EnableItem').removeClass('d-none');
                    }
                    loadattribute(data['attr']);



                });

        }

    }
</script>

<script>
    $(document).ready(function() {
        $('#WarehouseID').select2();
    });
</script>
