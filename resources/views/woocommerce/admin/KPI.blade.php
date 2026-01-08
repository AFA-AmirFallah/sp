@php
    $Persian = new App\Functions\persian();

@endphp
<style>

</style>
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="main-content">
        <div class="breadcrumb">

            <h1>شاخص کلیدی از {{ $ShamsiStart }} تا {{ $ShamsiEnd }}</h1>

        </div>
        @if ($ShowMod == 'Search')
            <form method="post">
                @csrf
                <div class="separator-breadcrumb border-top"></div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xl-6">
                            <label for="validationCustomtitle"
                                class="col-form-label pt-0">{{ __('Register from date') }}</label>
                            <input required class="form-control" type="text" name="StartDate" autocomplete="off"
                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                placeholder="{{ __('Register from date') }}" />

                        </div>
                        <div class="col-xl-6">
                            <label for="validationCustomtitle"
                                class="col-form-label pt-0">{{ __('Register to date') }}</label>
                            <input required class="form-control" type="text" name="EndDate" autocomplete="off"
                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                placeholder="{{ __('Register to date') }}" />

                        </div>
                    </div>
                    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                لیست بچه های فروش
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    نام </th>
                                                <th>
                                                    نام خانوادگی
                                                </th>

                                                <th>
                                                    عملیات </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($TargetUserInfo as $TargetUserInfo)
                                                <tr>


                                                    <td>
                                                        {{ $TargetUserInfo->Name }}
                                                    </td>

                                                    <td>
                                                        {{ $TargetUserInfo->Family }}

                                                    </td>



                                                    <td>
                                                        <label class="radio radio-primary">
                                                            <input type="radio" name="UserName" [value]="4"
                                                                formcontrolname="radio"
                                                                value="{{ $TargetUserInfo->UserName }}"
                                                                id="radio_{{ $TargetUserInfo->UserName }}">
                                                            <span>انتخاب</span>
                                                            <span class="checkmark"></span>
                                                        </label>



                                                    </td>






                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-group mb-0">
                    <div class="product-buttons text-center">
                        <button type="submit" name="submit" value="Search" class="btn btn-primary">جستجو</button>
                    </div>
                </div>

            </form>
        @elseif ($ShowMod == 'List')
            @php
                $ActiceUsers = $Mystat->GetActiveUsers($StartDate, $EndDate, $UserName);
                $TotallUsers = $Mystat->GetCountOfUsers($StartDate, $EndDate, $UserName);
                $AllWarehouse = $Mystat->GetCountOfWarehouse($StartDate, $EndDate, $UserName);
                $ActiveWarehouse = $Mystat->GetActiveWarehouse($StartDate, $EndDate, $UserName);
                $GetReadyToSalesProducts = $Mystat->GetReadyToSalesProducts($StartDate, $EndDate, $UserName);
                $GetSoldProducts = $Mystat->GetSoldProducts($StartDate, $EndDate, $UserName);
                $getSpecificIndexProduct = $Mystat->getSpecificIndexProduct($StartDate, $EndDate, $UserName);
            @endphp



            <div class="row ">
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-3">
                                    <i class="i-Business-Mens" style="font-size: 30px;"></i>
                                    تعداد کاربران =
                                </h6>
                                <p class="text-20 text-success line-height-1 mt-3">
                                    {{ $TotallUsers }}</p>
                            </div>

                            <small> تعداد کاربران یکتا ثبت نام شده در سایت/اپلیکیشن در طی مدت قرارداد</small>
                        </div>
                        <div>
                            <button id="addobject" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                                class="btn btn-primary btn-md m-1"> نمایش کاربران
                            </button>
                        </div>

                    </div>
                </div>


                <div class="ul-card-list__modal">
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">

                                    <div class="d-sm-flex mb-5" data-view="print">
                                        <span class="m-auto"></span>
                                        <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                    </div>
                                    <div id="print-area">
                                        <div class="table-responsive">
                                            <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> نام و نام خانوادگی</th>
                                                        <th> شماره تماس</th>
                                                        <th>تاریخ ثبت نام</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $Counter = 1;
                                                        $GetDetailOfUsers = $Mystat->GetDetailOfUsers($StartDate, $EndDate, $UserName);

                                                    @endphp
                                                    @if ($GetDetailOfUsers != 0)
                                                        @foreach ($GetDetailOfUsers as $GetDetailOfUsersTarget)
                                                            <tr>
                                                                <td>{{ $Counter++ }}</td>
                                                                <td>{{ $GetDetailOfUsersTarget->Name }}-{{ $GetDetailOfUsersTarget->Family }}
                                                                </td>
                                                                <td>{{ $GetDetailOfUsersTarget->MobileNo }} </td>
                                                                <td>{{ $Persian->MyPersianDate($GetDetailOfUsersTarget->CreateDate, true) }}
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        دیتایی موجود نیست
                                                    @endif


                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-3"> <i class="i-Geek" style="font-size: 30px;"></i>
                                    تعداد کاربران فعال(مشتریان) = </h6>

                                <p class="text-20 text-success line-height-1 mt-3">{{ $ActiceUsers['Count'] }}</p>
                            </div>

                            <small> تعداد کاربرانی که حداقل یک خرید را از پلتفرم کوکباز در طی مدت قرارداد
                            </small>
                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal"
                                class="btn btn-primary btn-md m-1"> نمایش مشتریان
                            </button>
                        </div>
                    </div>
                    <div class="ul-card-list__modal">
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="d-sm-flex mb-5" data-view="print">
                                            <span class="m-auto"></span>
                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                            <a class=" btn btn-success glyphicon glyphicon-export"
                                                onclick="exportAllPages2()" href="#">خروجی
                                                اکسل</a>
                                        </div>
                                        <div id="print-area">

                                            <div class="table-responsive">
                                                <table id="activeuser" class="{{ \App\myappenv::MainTableClass }}"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th> نام</th>
                                                            <th> نام خانوادگی</th>
                                                            <th> شماره تماس مشتری</th>
                                                            <th>مجوع خرید</th>
                                                            <th>شماره سفارش</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $Counter = 1;

                                                        @endphp
                                                        @foreach ($ActiceUsers['SrcTbl'] as $GetDetailOfActiceUsers)
                                                            <tr>
                                                                <td>{{ $Counter++ }}</td>
                                                                <td>{{ $GetDetailOfActiceUsers->Name }}</td>
                                                                <td>{{ $GetDetailOfActiceUsers->Family }}</td>

                                                                <td>{{ $GetDetailOfActiceUsers->CustomerId }}</td>
                                                                <td>{{ $GetDetailOfActiceUsers->total_sales }}</td>

                                                                <td><a target="blank"
                                                                        href="{{ route('EditOrder', ['OrderID' => $GetDetailOfActiceUsers->id]) }}">
                                                                        {{ $GetDetailOfActiceUsers->id }}</a> </td>


                                                            </tr>
                                                        @endforeach

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-3"> <i class="i-Shop" style="font-size: 30px;"></i>
                                    تعداد کل غرفه ها =

                                </h6>
                                <p class="text-20 text-success line-height-1 mt-3">{{ $AllWarehouse }}
                                </p>
                            </div>

                            <small> تعداد غرفه هایی که در طی مدت قرارداد توسط کاربران ایجاد شد</small>
                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal1"
                                class="btn btn-primary btn-md m-1"> نمایش غرفه ها
                            </button>
                        </div>
                        <div class="ul-card-list__modal">
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal1"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="d-sm-flex mb-5" data-view="print">
                                                <span class="m-auto"></span>
                                                <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                            </div>
                                            <div id="print-area">
                                                <div class="table-responsive">
                                                    <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>نام انبار</th>
                                                                <th> شماره تماس غرفه دار</th>
                                                                <th>تاریخ ایجاد </th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $Counter = 1;
                                                                $GetDetailOfWarehouse = $Mystat->GetDetailOfWarehouse($StartDate, $EndDate, $UserName);
                                                            @endphp
                                                            @if ($GetDetailOfUsers != 0)
                                                                @foreach ($GetDetailOfWarehouse as $GetDetailOfWarehouseTarget)
                                                                    <tr>
                                                                        <td>{{ $Counter++ }}</td>
                                                                        <td>{{ $GetDetailOfWarehouseTarget->Name }}
                                                                        </td>
                                                                        <td>{{ $GetDetailOfWarehouseTarget->phone }} </td>
                                                                        <td>{{ $Persian->MyPersianDate($GetDetailOfWarehouseTarget->created_at, true) }}
                                                                        </td>

                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                دیتایی موجود نیست
                                                            @endif

                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-1"><i class="i-Shop-4" style="font-size: 30px;"></i>
                                    تعداد غرفه های فعال =
                                </h6>
                                <p class="text-20 text-success line-height-1 mt-3">
                                    {{ $ActiveWarehouse['Count'] }} </p>
                            </div>

                            <small>تعداد غرفه هایی که در طی مدت قرارداد حداقل یک فروش از طریق آن ها .</small>
                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal2"
                                class="btn btn-primary btn-md m-1"> نمایش غرفه های فعال
                            </button>
                        </div>
                        <div class="ul-card-list__modal">
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal2"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="d-sm-flex mb-5" data-view="print">
                                                <span class="m-auto"></span>
                                                <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                            </div>
                                            <div id="print-area">
                                                <div class="table-responsive">
                                                    <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>نام مشتری</th>
                                                                <th> شماره سفارش</th>
                                                                <th> نام انبار </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $Counter = 1;

                                                            @endphp
                                                            @foreach ($ActiveWarehouse['SrcTbl'] as $ActiveWarehouse)
                                                                <tr>
                                                                    <td>{{ $Counter++ }}</td>
                                                                    <td>{{ $ActiveWarehouse->Name }}-
                                                                        {{ $ActiveWarehouse->Family }}</td>
                                                                    <td><a target="blank"
                                                                            href="{{ route('EditOrder', ['OrderID' => $ActiveWarehouse->id]) }}">
                                                                            {{ $ActiveWarehouse->id }}</a> </td>
                                                                    <td>{{ $ActiveWarehouse->WName }}

                                                                </tr>
                                                            @endforeach

                                                        </tbody>

                                                    </table>
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

            <div class="row">




                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-1"><i class="i-Lamp" style="font-size: 30px;"></i>
                                    تعداد محصول آماده فروش=
                                </h6>

                                <p class="text-20 text-success line-height-1 mt-3">
                                    @if ($GetReadyToSalesProducts != 0)
                                        {{ $GetReadyToSalesProducts['Count'] }}
                                    @endif
                                </p>
                            </div>
                            <small> تعداد محصول تایید شده در طی مدت قرارداد که در هر غرفه برای فروش .</small>

                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal3"
                                class="btn btn-primary btn-md m-1"> نمایش محصول آماده فروش
                            </button>
                        </div>

                        <div class="ul-card-list__modal">
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal3"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="d-sm-flex mb-5" data-view="print">
                                                <span class="m-auto"></span>
                                                <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                            </div>
                                            <div id="print-area">
                                                <div class="table-responsive">
                                                    <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>کد محصول</th>
                                                                <th> تعداد ورود به انبار محصول </th>
                                                                <th> موجودی محصول</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $Counter = 1;

                                                            @endphp
                                                            @if ($GetReadyToSalesProducts != 0)
                                                                @foreach ($GetReadyToSalesProducts['SrcTbl'] as $GetReadyToSalesProductsDetail)
                                                                    <tr>
                                                                        <td>{{ $Counter++ }}</td>
                                                                        <td><a target="blank"
                                                                                href="{{ route('EditProduct', ['id' => $GetReadyToSalesProductsDetail->GoodID]) }}">
                                                                                {{ $GetReadyToSalesProductsDetail->GoodID }}</a>

                                                                        </td>
                                                                        <td>
                                                                            {{ $GetReadyToSalesProductsDetail->Qty }}</td>
                                                                        <td>{{ $GetReadyToSalesProductsDetail->Remian }}
                                                                        </td>



                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                دیتایی موجود نیست
                                                            @endif

                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-1">
                                    <i class="i-Remove-Cart" style="font-size: 30px;"></i>
                                    تعداد محصول فروخته شده =
                                </h6>

                                <p class="text-20 text-success line-height-1 mt-3">{{ $GetSoldProducts }}
                                </p>
                            </div>
                            <small> تعداد محصولات فروخته شده توسط غرفه داران در طی مدت قرارداد</small>

                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal4"
                                class="btn btn-primary btn-md m-1"> نمایش تعداد محصول فروخته شده
                            </button>
                        </div>
                    </div>
                    <div class="ul-card-list__modal">
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal4"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="d-sm-flex mb-5" data-view="print">
                                            <span class="m-auto"></span>
                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                            <a class=" btn btn-success glyphicon glyphicon-export"
                                                onclick="exportAllPages()" href="#">خروجی
                                                اکسل</a>
                                        </div>
                                        <div id="print-area">
                                            <div class="table-responsive">
                                                <table id="productsale" class="{{ \App\myappenv::MainTableClass }}"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th> نام </th>
                                                            <th> نام خانوادگی </th>
                                                            <th> شماره موبایل </th>
                                                            <th> مجموع خرید </th>
                                                            <th> شماره سفارش</th>
                                                            <th> کد محصول</th>
                                                            <th> تعداد محصول فروخته شده</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $Counter = 1;
                                                            $GetSoldProductsDtail = $Mystat->GetSoldProductsDetail($StartDate, $EndDate, $UserName);
                                                        @endphp
                                                        @foreach ($GetSoldProductsDtail as $GetSoldlDetail)
                                                            <tr>
                                                                <td>{{ $Counter++ }}</td>

                                                                <td>{{ $GetSoldlDetail->Name }}</td>
                                                                <td>{{ $GetSoldlDetail->Family }}</td>
                                                                <td>{{ $GetSoldlDetail->MobileNo }}</td>
                                                                <td>{{ $GetSoldlDetail->total_sales }}</td>

                                                                <td>
                                                                    <a target="blank"
                                                                        href="{{ route('EditOrder', ['OrderID' => $GetSoldlDetail->order_id]) }}">
                                                                        {{ $GetSoldlDetail->order_id }}</a>
                                                                </td>
                                                                <td><a target="blank"
                                                                        href="{{ route('EditProduct', ['id' => $GetSoldlDetail->product_id]) }}">
                                                                        {{ $GetSoldlDetail->product_id }}</a>

                                                                </td>

                                                                <td>{{ $GetSoldlDetail->product_qty }}
                                                                </td>



                                                            </tr>
                                                        @endforeach

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">

                            <div style="display: flex">
                                <h6 class="mb-2 text-muted mt-3">
                                    <i class="i-Medicine" style="font-size: 25px;"></i>
                                    تعداد محصول سلامت آماده فروش =
                                </h6>

                                <p class="text-20 text-success line-height-1 mt-3">
                                    @if ($getSpecificIndexProduct != 0)
                                        {{ $getSpecificIndexProduct['Count'] }}
                                    @else
                                        0
                                    @endif

                                </p>

                            </div>


                            <small>تعداد محصول تایید شده در حوزه سلامت در طی مدت قرارداد که برای فروش </small>
                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal5"
                                class="btn btn-primary btn-md m-1"> نمایش محصول سلامت آماده فروش
                            </button>
                        </div>
                    </div>
                    <div class="ul-card-list__modal">
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal5"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="d-sm-flex mb-5" data-view="print">
                                            <span class="m-auto"></span>
                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                        </div>
                                        <div id="print-area">
                                            <div class="table-responsive">
                                                <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>کد محصول</th>
                                                            <th> تعداد ورود به انبار محصول </th>
                                                            <th> موجودی محصول</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $Counter = 1;

                                                        @endphp
                                                        @if ($getSpecificIndexProduct != 0)
                                                            @foreach ($getSpecificIndexProduct['SrcTbl'] as $getSpecificIndexProductDetail)
                                                                <tr>
                                                                    <td>{{ $Counter++ }}</td>
                                                                    <td><a target="blank"
                                                                            href="{{ route('EditProduct', ['id' => $getSpecificIndexProductDetail->GoodID]) }}">
                                                                            {{ $getSpecificIndexProductDetail->GoodID }}</a>

                                                                    </td>
                                                                    <td>
                                                                        {{ $getSpecificIndexProductDetail->Qty }}</td>
                                                                    <td>{{ $getSpecificIndexProductDetail->Remian }}
                                                                    </td>



                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            دیتایی موجود نیست
                                                        @endif

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <i class="i-Medicine-2" style="font-size: 30px;"></i>
                                <h6 class="mb-2 text-muted">تعداد محصول سلامت فروخته شده =</h6>
                                @php

                                    $getSpecificIndexProductSold = $Mystat->getSpecificIndexProductSold($StartDate, $EndDate, $UserName);

                                @endphp
                                <p class="text-20 text-success line-height-1 ">
                                    {{ $getSpecificIndexProductSold }}</p>
                            </div>

                            <small>تعداد محصول سالمندی فروخته شده در پلتفرم کوکباز در طی مدت قرارداد</small>
                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal6"
                                class="btn btn-primary btn-md m-1"> نمایش محصول سلامت فروخته شده
                            </button>
                        </div>
                    </div>
                    <div class="ul-card-list__modal">
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal6"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="d-sm-flex mb-5" data-view="print">
                                            <span class="m-auto"></span>
                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                        </div>
                                        <div id="print-area">
                                            <div class="table-responsive">
                                                <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>شماره سفارش </th>
                                                            <th> کد محصول</th>
                                                            <th> تعداد محصول فروخته شده</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $Counter = 1;
                                                            $GetSoldProductsDetailIndex = $Mystat->getSpecificIndexProductSoldDetail($StartDate, $EndDate, $UserName);
                                                        @endphp
                                                        @foreach ($GetSoldProductsDetailIndex as $GetSoldlIndex)
                                                            <tr>
                                                                <td>{{ $Counter++ }}</td>
                                                                <td>
                                                                    <a target="blank"
                                                                        href="{{ route('EditOrder', ['OrderID' => $GetSoldlIndex->order_id]) }}">
                                                                        {{ $GetSoldlIndex->order_id }}</a>
                                                                </td>
                                                                <td><a target="blank"
                                                                        href="{{ route('EditProduct', ['id' => $GetSoldlIndex->product_id]) }}">
                                                                        {{ $GetSoldlIndex->product_id }}</a>

                                                                </td>

                                                                <td>{{ $GetSoldlIndex->product_qty }}
                                                                </td>



                                                            </tr>
                                                        @endforeach

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @php
                $GetVitualSold = $Mystat->GetVitualSold($StartDate, $EndDate, $UserName);
            @endphp
            <div class="row">



                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-3">
                                    <i class="i-Student-Hat-2" style="font-size: 30px;"></i>
                                    تعداد خدمات آموزشی =
                                </h6>

                                <p class="text-20 text-success line-height-1 mt-3">{{ $GetVitualSold }}</p>
                            </div>
                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal20"
                                class="btn btn-primary btn-md m-1"> نمایش خدمات آموزشی
                            </button>
                        </div>
                        <div class="ul-card-list__modal">
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                id="exampleModal20" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="d-sm-flex mb-5" data-view="print">
                                                <span class="m-auto"></span>
                                                <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                            </div>
                                            <div id="print-area">
                                                <div class="table-responsive">
                                                    <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> شماره مشتری</th>
                                                                <th> نام دوره آموزشی</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $Counter = 1;
                                                                $GetVitualSoldDetail = $Mystat->GetVitualSoldDetail($StartDate, $EndDate, $UserName);
                                                            @endphp
                                                            @if ($GetVitualSold != 0)
                                                                @foreach ($GetVitualSoldDetail as $GetVitualSoldDetail)
                                                                    <tr>
                                                                        <td>{{ $Counter++ }}</td>
                                                                        <td>{{ $GetVitualSoldDetail->customer }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $GetVitualSoldDetail->Name }}
                                                                        </td>




                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                دیتایی موجود نیست
                                                            @endif
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @php
                    $TotallSales = $Mystat->SalesTotallStatistics($StartDate, $EndDate, $UserName);
                    $GetCounsoult = $Mystat->GetCounsoult($StartDate, $EndDate, $UserName);
                @endphp
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">تعداد خدمات مشاوره ای ارائه شده </h6>
                            @if ($GetCounsoult != 0)
                                <p class="mb-1  font-weight-light">
                                    تعداد: {{ $GetCounsoult['count'] }}</p>
                                <p class="mb-1 font-weight-light">
                                    مجموع : {{ $GetCounsoult['sum'] }}</p>
                            @else
                                0
                            @endif

                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal7"
                                class="btn btn-primary btn-md m-1"> نمایش خدمات مشاوره ای
                            </button>
                        </div>

                        <div class="ul-card-list__modal">
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal7"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="d-sm-flex mb-5" data-view="print">
                                                <span class="m-auto"></span>
                                                <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                            </div>
                                            <div id="print-area">
                                                <div class="table-responsive">
                                                    <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> شماره مشتری</th>
                                                                <th> مدت زمان مکالمه(ثانیه)</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $Counter = 1;
                                                                $GetCounsoultDetail = $Mystat->GetCounsoultDetail($StartDate, $EndDate, $UserName);
                                                            @endphp
                                                            @if ($GetCounsoult != 0)
                                                                @foreach ($GetCounsoultDetail as $GetCounsoultDetail)
                                                                    <tr>
                                                                        <td>{{ $Counter++ }}</td>
                                                                        <td>{{ $GetCounsoultDetail->CallerNumber }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $GetCounsoultDetail->CallDuration }}
                                                                        </td>




                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                دیتایی موجود نیست
                                                            @endif
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $TotallSales = $Mystat->SalesTotallStatistics($StartDate, $EndDate, $UserName);
                    $OrdersTotall = $Mystat->GetOrdersTotall($StartDate, $EndDate, $UserName);
                @endphp
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div style="display: flex">
                                <h6 class="mb-3">
                                    <i class="i-Receipt-3" style="font-size: 30px;"></i>
                                    تعداد سفارشات =
                                </h6>

                                <p class="text-20 text-success line-height-1 mt-3">{{ $OrdersTotall }}</p>
                            </div>


                        </div>
                        <div>
                            <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal8"
                                class="btn btn-primary btn-md m-1"> نمایش سفارشات
                            </button>
                        </div>

                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0 text-muted">میزان فروش
                            </h6>
                            <p class="text-22 font-weight-light mb-1">
                                {{ number_format($TotallSales->total_sales) }} ریال
                            </p>

                        </div>
                    </div>
                </div>


                <div class="ul-card-list__modal">
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModal8"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="d-sm-flex mb-5" data-view="print">
                                        <span class="m-auto"></span>
                                        <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ </button>
                                    </div>
                                    <div id="print-area">
                                        <div class="table-responsive">
                                            <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> شماره مشتری</th>
                                                        <th> شماره سفارش</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $Counter = 1;
                                                        $GetOrdersTotallDetail = $Mystat->GetOrdersTotallDetail($StartDate, $EndDate, $UserName);
                                                        $UserPointStatistics = $Mystat->UserPointStatistics($StartDate, $EndDate, $UserName);
                                                    @endphp
                                                    @foreach ($GetOrdersTotallDetail as $OrdersTotallDetail)
                                                        <tr>
                                                            <td>{{ $Counter++ }}</td>
                                                            <td>{{ $OrdersTotallDetail->CustomerId }}
                                                            </td>
                                                            <td>
                                                                <a target="blank"
                                                                    href="{{ route('EditOrder', ['OrderID' => $OrdersTotallDetail->id]) }}">
                                                                    {{ $OrdersTotallDetail->id }}</a>
                                                            </td>




                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div style="display: flex;
                            justify-content: space-between;">
                                <h6 class="mb-0 text-muted">میزان رضایتمندی از محصولات</h6>
                                <button id="addcustomer" type="button" data-toggle="modal" data-target="#exampleModal9"
                                    class="btn btn-warning btn-md m-1"> نمایش شرکت کنندگان
                                </button>
                            </div>

                            @if ($UserPointStatistics != 0)
                                <p class="text-22 font-weight-light mb-1">
                                    @php

                                        $Totall = $UserPointStatistics[1]['wight'] + $UserPointStatistics[2]['wight'] + $UserPointStatistics[3]['wight'] + $UserPointStatistics[4]['wight'] + $UserPointStatistics[5]['wight'];
                                        if ($UserPointStatistics[5]['Total'] != 0) {
                                            $Percnet = intval($Totall / $UserPointStatistics[5]['Total']);
                                        } else {
                                            $Percnet = '-';
                                        }

                                    @endphp

                                <p>درصد رضایت مندی کل: {{ $Percnet }} % </p>
                                <p>امتیاز ۱ : {{ $UserPointStatistics[1]['percent'] }}% </p>
                                <p>امتیاز ۲ : {{ $UserPointStatistics[2]['percent'] }}% </p>
                                <p>امتیاز ۳ : {{ $UserPointStatistics[3]['percent'] }}% </p>
                                <p>امتیاز ۴ : {{ $UserPointStatistics[4]['percent'] }}% </p>
                                <p>امتیاز ۵ : {{ $UserPointStatistics[5]['percent'] }}% </p>
                                </p>
                            @else
                                0
                            @endif

                            <div class="ul-card-list__modal">
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                    id="exampleModal9" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="d-sm-flex mb-5" data-view="print">
                                                    <span class="m-auto"></span>
                                                    <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ
                                                    </button>
                                                </div>
                                                <div id="print-area">
                                                    <div class="table-responsive">
                                                        <table id="ul-order-list"
                                                            class="{{ \App\myappenv::MainTableClass }}"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th> شماره مشتری</th>
                                                                    <th> امتیاز</th>
                                                                    <th> شماره سفارش</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $Counter = 1;
                                                                    $UserPointStatisticsDetail = $Mystat->UserPointStatisticsDetail($StartDate, $EndDate, $UserName);
                                                                @endphp
                                                                @if ($UserPointStatisticsDetail != 0)
                                                                    @foreach ($UserPointStatisticsDetail as $UserPointStatisticsDetail)
                                                                        <tr>
                                                                            <td>{{ $Counter++ }}</td>
                                                                            <td>{{ $UserPointStatisticsDetail->UserName }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $UserPointStatisticsDetail->Point }}
                                                                            </td>
                                                                            <td>
                                                                                <a target="blank"
                                                                                    href="{{ route('EditOrder', ['OrderID' => $UserPointStatisticsDetail->order]) }}">
                                                                                    {{ $UserPointStatisticsDetail->order }}</a>

                                                                            </td>




                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    دیتایی موجود نیست
                                                                @endif
                                                            </tbody>

                                                        </table>
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

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0 text-muted">میزان رضایتمندی از خدمات</h6>
                            <p class="text-22 font-weight-light mb-1">
                                @if ($UserPointStatistics != 0)
                                    <p>درصد رضایت مندی کل: {{ $Percnet }} % </p>
                                    <p>امتیاز ۱ : {{ $UserPointStatistics[1]['percent'] }}% </p>
                                    <p>امتیاز ۲ : {{ $UserPointStatistics[2]['percent'] }}% </p>
                                    <p>امتیاز ۳ : {{ $UserPointStatistics[3]['percent'] }}% </p>
                                    <p>امتیاز ۴ : {{ $UserPointStatistics[4]['percent'] }}% </p>
                                    <p>امتیاز ۵ : {{ $UserPointStatistics[5]['percent'] }}% </p>

                            </p>
        @endif
    </div>
    </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-0 text-muted">میزان رضایتمندی از فرآیند فروش و پشتیبانی
                </h6>
                <p class="text-22 font-weight-light mb-1">
                    @if ($UserPointStatistics != 0)
                        <p>درصد رضایت مندی کل: {{ $Percnet }} % </p>
                        <p>امتیاز ۱ : {{ $UserPointStatistics[1]['percent'] }}% </p>
                        <p>امتیاز ۲ : {{ $UserPointStatistics[2]['percent'] }}% </p>
                        <p>امتیاز ۳ : {{ $UserPointStatistics[3]['percent'] }}% </p>
                        <p>امتیاز ۴ : {{ $UserPointStatistics[4]['percent'] }}% </p>
                        <p>امتیاز ۵ : {{ $UserPointStatistics[5]['percent'] }}% </p>

                </p>
                @endif
            </div>
        </div>
    </div>

    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 text-muted">میزان سود
                    </h6>
                    <p class="text-22 font-weight-light mb-1">
                        {{ number_format($TotallSales->net_total) }}
                        ریال
                    </p>

                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 text-muted"> کل اقلام فروش
                    </h6>
                    <p class="text-22 font-weight-light mb-1">
                        {{ number_format($TotallSales->num_items_sold) }}
                        ریال</p>

                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 text-muted">هزینه حمل ارسال
                    </h6>
                    <p class="text-22 font-weight-light mb-1">
                        {{ number_format($TotallSales->shipping_total) }}
                        ریال</p>

                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 text-muted">میزان مالیات
                    </h6>
                    <p class="text-22 font-weight-light mb-1">
                        {{ number_format($TotallSales->tax_total) }}
                        ریال
                    </p>

                </div>
            </div>
        </div>
    @endif
    </div>

    <div class="row">


    </div>
    @endif


    </div>
@endsection
@section('page-js')
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>

    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>

    <script>
        function exportAllPages() {
            $("#productsale").tableExport({

                formats: ["csv", "xlsx"],
                fileName: "table_data",
                position: "top",
                ignoreColumn: [0], // exclude the first column from export
                ignoreRows: null,
                trimWhitespace: true,
                RTL: false,
                sheetName: "Sheet1",
                exportButtons: true,
                pageSize: "all" // export all pages

            });
        }
        function exportAllPages2() {
            $("#activeuser").tableExport({

                formats: ["csv", "xlsx"],
                fileName: "table_data",
                position: "top",
                ignoreColumn: [0], // exclude the first column from export
                ignoreRows: null,
                trimWhitespace: true,
                RTL: false,
                sheetName: "Sheet1",
                exportButtons: true,
                pageSize: "all" // export all pages

            });
        }
    </script>
@endsection
