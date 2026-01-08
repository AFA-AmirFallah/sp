<div id="warehouse_iframe" class="main_forme 2-columns-form-layout nested">

    <div class="">
        <div class=" row">
            <div class="col-lg-12">
                <!-- start card -->
                <div class="card">

                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">

                        <div>
                            <button id="hide_warehouse" style="float: left;" onclick="hidewarehouse()" class="btn"><i
                                    style="font-weight: 800" class="i-Remove text-20"></i></button>
                            <button type="button" onclick="loadwarehouse('0')" style="float: left;"
                                class="btn btn-success">افرزودن انبار <i style="font-weight: 800"
                                    class="i-Cloud- text-20"></i></button>

                        </div>

                        انبارها


                    </div>

                    <div id="licens_view" style="margin: 4px;" class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            @php
                                $WarehouseSrc = $Product->get_good_warehouse();
                            @endphp
                            @if ($WarehouseSrc == [])
                                <a onclick="loadwarehouse('0')">
                                    <div class="selectors p-4 rounded d-flex align-items-center text-white bg-warning">
                                        <i class="i-Shop  text-32 mr-3"></i>
                                        <div>
                                            <h4 class="text-18 mb-1 text-white">بدون انبار</h4>

                                        </div>
                                    </div>
                                </a>
                            @else
                                @foreach ($WarehouseSrc as $warehouse)
                                    <a onclick="loadwarehouse('{{ $warehouse->id }}')">
                                        <div
                                            class="selectors p-4 rounded d-flex align-items-center text-white bg-success">
                                            <i class="i-Shop  text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">{{ $warehouse->Name }} </h4>
                                                <small>موجودی {{ $warehouse->Remian }} واحد</small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif

                        </div>

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
                                        <button onclick="offline()" id="online_btn_active" class="btn btn-success ">فروش
                                            آفلاین</button>
                                        <button onclick="offline()" id="online_btn_deactive" class="btn nested">فروش
                                            آفلاین</button>
                                    @endif
                                    <button onclick="online()" id="offline_btn_active" class="btn btn-success nested">فروش
                                        آنلاین</button>
                                    <button onclick="online()" id="offline_btn_deactive" class="btn ">فروش
                                        آنلاین</button>
                                @else
                                    <button onclick="offline()" id="online_btn_active" class="btn btn-success nested">فروش
                                        آفلاین</button>
                                    <button onclick="offline()" id="online_btn_deactive" class="btn ">فروش آفلاین</button>
                                    <button onclick="online()" id="offline_btn_active" class="btn btn-success">فروش
                                        آنلاین</button>
                                    <button onclick="online()" id="offline_btn_deactive" class="btn nested">فروش
                                        آنلاین</button>
                                @endif
                            @endcan


                            <button id="hide_warehouse" onclick="hidewarehouse()" class="btn">-</button>
                        </div>

                    </div>
                    <!--begin::form-->


                    <div class="  card-body">

                        <form id="warehouseForm" action="" method="post">

                            @if ($GoodInWarehouse == null)
                                <form action="{{ route('P_AddGoodToWarehouse') }}" method="post">
                                @else
                                    <form action="{{ route('P_EditProductInStore', ['id' => $GoodInWarehouse->id]) }}"
                                        method="POST">
                            @endif
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail1" class="ul-form__label"> کالا</label>
                                    <br>
                                    <input class="nested" value="{{ $good->id }}">
                                    <h5>{{ $good->NameFa }}</h5>
                                    <small class="ul-form__text form-text ">
                                        نام کالا
                                    </small>
                                </div>
                                @php
                                    if (isset($GoodInWarehouse->owner)) {
                                        $Owner = $GoodInWarehouse->owner;
                                    } else {
                                        $Owner = null;
                                    }
                                    
                                @endphp
                                @if (Auth::user()->Role == App\myappenv::role_SuperAdmin || Auth::user()->Role == App\myappenv::role_ShopAdmin)
                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4" class="ul-form__label">مالک :</label>
                                        <div id="ownerselector">
                                            @include('Layouts.SearchUserInput', [
                                                'InputName' => 'UserName',
                                                'InputPalceholder' => __('Target username'),
                                            ])
                                        </div>

                                        <input id="ownerusername" class="nested" type="text"
                                            value="{{ $Owner }}" class="">
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
                                    <h5>انبار</h5>
                                    <select name="WarehouseID" class="form-control col-xl-8 col-md-7" id="warehouse"
                                        style="width:100%">
                                        @foreach ($Warehouses as $Warehouse)
                                            <option value="{{ $Warehouse->id }}">
                                                {{ $Warehouse->Name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                        انباری که کالا در آن قرار میگیرد
                                    </small>
                                </div>
                            </div>
                            <div id="NormalSale">
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">تعداد ورود به انبار
                                        </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="QTY" required
                                                placeholder="  تعداد  محصول موجود در انبار  "
                                                value="{{ $GoodInWarehouse->QTY ?? '0' }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">تعداد موجودی باقی مانده
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="text" class="form-control" name="Remian"
                                                value="{{ $GoodInWarehouse->Remian ?? 0 }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">تعداد موجودی اخطار
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control" name="AlertLimit"
                                                value="{{ $GoodInWarehouse->AlertLimit ?? 5 }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3" class="ul-form__label">حد اکثر فروش در هر فاکتور
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="number" class="form-control"
                                                placeholder="حد اکثر تعداد فروش در هر فاکنور" name="SaleLimit"
                                                value="{{ $GoodInWarehouse->SaleLimit ?? 10 }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3" class="ul-form__label">اخطار اتمام موجودی
                                        </label>
                                        <div class="input-right-icon">
                                            <input type="checkbox" class="form-control" name="AlertFinish"
                                                @if (isset($GoodInWarehouse->AlertFinish) && $GoodInWarehouse->AlertFinish == 1) checked @endif>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="inputEmail3" class="ul-form__label">مبلغ خرید(برای محاسبه سود کالا
                                        الزامی
                                        است)
                                    </label>
                                    <span class="label_red">*</span>
                                    <div class="input-right-icon">
                                        <input onclick="CurencyTextRT(this.value,'mainPriceTxt')"
                                            onkeyup="CurencyTextRT(this.value,'mainPriceTxt')" type="number"
                                            class="form-control" name="BuyPrice" required
                                            placeholder="مبلغ خرید هر واحد"
                                            value="{{ $GoodInWarehouse->BuyPrice ?? 0 }}">
                                        <p id="mainPriceTxt"></p>
                                    </div>
                                </div>
                                <div id="fix_price"
                                    class="@if (isset($GoodInWarehouse->PricePlan) && $GoodInWarehouse->PricePlan != null) nested @endif form-group col-md-6">
                                    <label for="inputEmail3" class="ul-form__label">مبلغ فروش(مبلغ پس از تخفیف)
                                    </label>
                                    <span class="label_red">*</span>
                                    @if ($AccessType == 'admin')
                                        <a onclick="FixPrice()" class="btn btn-success">مبلغ ثابت</a>
                                        <a onclick="FormolPrice()" class="btn btn-warning">مبلغ فرمولی</a>
                                        </label>
                                    @endif
                                    <div class="input-right-icon">
                                        <input onclick="CurencyTextRT(this.value,'MainPrice')"
                                            onkeyup="CurencyTextRT(this.value,'MainPrice')" type="number"
                                            class="form-control" placeholder="مبلغ فروش هر واحد" name="Price"
                                            value="{{ $GoodInWarehouse->Price ?? '' }}">
                                        <p id="MainPrice"></p>
                                    </div>
                                    @if ($AccessType == 'admin')
                                        <small style="color: red">در صورتی که از فرمول استفاده میکنید این قسمت را
                                            خالی
                                            بگذارید</small>
                                    @endif
                                </div>
                                @if ($AccessType == 'admin')
                                    <div id="formol_price"
                                        class=" @if (!isset($GoodInWarehouse->PricePlan) || $GoodInWarehouse->PricePlan == null) nested @endif form-group col-md-6">
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
                                            @if (isset($GoodInWarehouse->PricePlan) && $GoodInWarehouse->PricePlan != null)
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
                                                                class="form-control"
                                                                name="ToNumber[{{ $Conter }}]"
                                                                value="{{ $targetPlan->ToNumber }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="formol_price_in form-control"
                                                                disabled name="Price[{{ $Conter }}]"
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
                                                                class="form-control"
                                                                name="ToNumber[{{ $Conter }}]" value="">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                name="PricePlan[{{ $Conter }}]" value="">
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
                                                    <tr id="PriceRow_{{ $Conter }}"
                                                        @if ($Conter != 1) class="nested" @endif>
                                                        <td id="FirstNumber_{{ $Conter }}">

                                                            1
                                                        </td>
                                                        <td>
                                                            <input type="number" id="ToNumber_{{ $Conter }}"
                                                                class="form-control"
                                                                name="ToNumber[{{ $Conter }}]" value="">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control formol_price_in"
                                                                disabled name="Price[{{ $Conter }}]"
                                                                value="">
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
                                @endif
                                <div id="fix_price" class="form-group col-md-2">
                                    <label for="inputEmail3" class="ul-form__label">مبلغ پایه(مبلغ قبل از تخفیف)
                                    </label>
                                    <span class="label_red">*</span>
                                    <div class="input-right-icon">
                                        <input onclick="CurencyTextRT(this.value,'BasePriceTxt')"
                                            onkeyup="CurencyTextRT(this.value,'BasePriceTxt')" type="number"
                                            class="form-control" placeholder="مبلغ فروش هر واحد" name="BasePrice"
                                            value="{{ $GoodInWarehouse->BasePrice ?? '' }}">
                                        <p id="BasePriceTxt"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3" class="ul-form__label">تاریخ ورود به انبار </label>
                                        <span class="label_red">*</span>
                                        <div class="input-right-icon">
                                            <input type="date" required class="form-control"
                                                placeholder="تاریخ ورود به انبار" name="InputDate"
                                                value="{{ $GoodInWarehouse->InputDate ?? date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    @if ($AccessType == 'admin')
                                        <div class="form-group col-md-3">
                                            <label for="inputEmail3" class="ul-form__label">شروع به فروش </label>
                                            <div class="input-right-icon">
                                                <input class="form-control" placeholder="تاریخ و زمان شروع به فروش"
                                                    name="ActiveTime"
                                                    value="{{ $GoodInWarehouse->ActiveTime ?? '' }}">
                                            </div>
                                            <label for="inputEmail3" class="ul-form__label">اتمام فروش </label>
                                            <div class="input-right-icon">
                                                <input class="form-control" placeholder="تاریخ و زمان شروع اتمام فروش"
                                                    name="DeactiveTime"
                                                    value="{{ $GoodInWarehouse->DeactiveTime ?? date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputEmail3" class="ul-form__label">تاریخ تولید
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="date" required class="form-control" name="MadeDate"
                                                    placeholder="تاریخ تولید محصول"
                                                    value="{{ $GoodInWarehouse->MadeDate ?? date('Y-m-d') }}">
                                            </div>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputEmail3" class="ul-form__label">تاریخ انقضا
                                            </label>
                                            <div class="input-right-icon">
                                                <input type="date" class="form-control" name="ExpireDate"
                                                    placeholder="تاریخ انقضای محصول"
                                                    value="{{ $GoodInWarehouse->ExpireDate ?? date('Y-m-d') }}">
                                            </div>

                                        </div>
                                    @endif
                                </div>
                                <div class="form-row col-md-12">

                                </div>
                            </div>
                    </div>
                    @can('offline')
                        @if ($Offline)
                            <div id="PreInvoice" class=" ">
                            @else
                                <div id="PreInvoice" class="nested ">
                        @endif

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail3" class="ul-form__label">حداقل مبلغ
                                </label>
                                <div class="input-right-icon">
                                    <input onclick="CurencyTextRT(this.value,'minPriceTxt')"
                                        onkeyup="CurencyTextRT(this.value,'minPriceTxt')" type="number"
                                        class="form-control" name="MinPrice" required placeholder="حداقل مبلغ فروش"
                                        value="{{ $GoodInWarehouse->MinPrice ?? 0 }}">
                                    <p id="minPriceTxt"></p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail3" class="ul-form__label">حداکثر مبلغ
                                </label>
                                <div class="input-right-icon">
                                    <input onclick="CurencyTextRT(this.value,'maxPriceTxt')"
                                        onkeyup="CurencyTextRT(this.value,'maxPriceTxt')" type="number"
                                        class="form-control" name="MaxPrice" required placeholder="حد اکثر مبلغ فروش"
                                        value="{{ $GoodInWarehouse->MaxPrice ?? 0 }}">
                                    <p id="maxPriceTxt"></p>
                                </div>
                            </div>

                        </div>
                        <label for="inputEmail3" class="ul-form__label">توضیحات کالا
                        </label>
                        <textarea rows="5" name="Note" class="col-sm-12 form-control">{{ $GoodInWarehouse->extra ?? '' }} </textarea>

                    </div>
                @endcan

                <div class="row">
                    <div class="col-lg-12">
                        @if ($Offline)
                            <button type="submit" id="online_btn_submit" class="btn btn-primary m-1 nested"
                                name="submit" value="online">ثبت موجودی آنلاین </button>
                            @can('offline')
                                <button type="submit" id="offline_btn_submit" class="btn btn-primary m-1 "
                                    name="submit" value="offline">ثبت موجودی آفلاین </button>
                            @endcan
                        @else
                            <button type="submit" id="online_btn_submit" class="btn btn-primary m-1" name="submit"
                                value="online">ثبت موجودی آنلاین </button>
                            @can('offline')
                                <button type="submit" id="offline_btn_submit" class="btn btn-primary m-1 nested"
                                    name="submit" value="offline">ثبت موجودی آفلاین </button>
                            @endcan
                        @endif

                        @isset($GoodInWarehouse->OnSale)
                            @if ($GoodInWarehouse->OnSale == 1)
                                <button type="submit" class="btn btn-warning m-1" name="submit"
                                    value="DisableItem">غیر
                                    فعال
                                    سازی کالا
                                </button>
                            @endif
                            @if ($GoodInWarehouse->OnSale == 0)
                                <button type="submit" class="btn btn-success m-1" name="submit"
                                    value="EnableItem">فعال
                                    سازی
                                    کالا
                                </button>
                            @endif
                        @endisset


                    </div>
                </div>
            </div>

            <!-- end::form -->
        </div>
        <script>
            $BaseAddress = '<?php echo route('home'); ?>';

            function addgoodtowarehose() {

                $('#detailcard').removeClass('nested');
                $('#warehouseForm').attr('action', $BaseAddress + '/P_AddGoodToWarehouse');

            }

            function loadwarehouse($WGID) {
                $ProductName = '<?php echo $good->NameFa; ?>';
                $addRoute = '<?php echo route('P_AddGoodToWarehouse'); ?>';
                if ($WGID == 0) {
                    $('#productTitle').html('افزودن موجودی ' + $ProductName);
                    addgoodtowarehose();
                } else {
                    $('#productTitle').html('ویرایش موجودی ' + $ProductName);
                    $('#detailcard').removeClass('nested');
                    $('#warehouseForm').attr('action', $BaseAddress + '/P_EditProductInStore/' + $WGID);

                    alert($WGID);
                }

            }
        </script>
