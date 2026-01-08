@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')

    <section class="chekout-page">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs justify-content-end mb-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab"
                            aria-controls="invoice" aria-selected="true">صورت حساب</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
                            aria-controls="edit" aria-selected="false">جزئیات پرداخت</a>
                    </li>

                </ul>
                <div class="card">

                    <div class="tab-content" id="myTabContent">
                        @if ($invoice_type == 'product')
                            <div class="tab-pane fade show active" id="invoice" role="tabpanel"
                                aria-labelledby="invoice-tab">
                                <div class="d-sm-flex mb-5" data-view="print">
                                    <span class="m-auto"></span>
                                    <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ صورت حساب</button>
                                </div>
                                <!---===== Print Area =======-->
                                <div id="print-area">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <h4 class="font-weight-bold">صورت حساب :</h4>
                                            @if (\App\myappenv::MainOwner == 'kookbaz')
                                                <img style="    width: 170px;"
                                                    src="{{ asset('assets/images/logo-kookbaz.png') }}">
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-sm-right">
                                            <p><strong>وضعیت سفارش: </strong>
                                                @if ($OrderSrc->status == 0)
                                                    در انتظار پرداخت
                                                @elseif ($OrderSrc->status == 1)
                                                    پرداخت شده
                                                @elseif($OrderSrc->status == 10)
                                                    در دست اقدام
                                                @elseif($OrderSrc->status == 20)
                                                    ارسال به انبار
                                                @elseif($OrderSrc->status == 30)
                                                    درحال بسته بندی
                                                @elseif($OrderSrc->status == 40)
                                                    ارسال به پست
                                                @elseif($OrderSrc->status == 50)
                                                    ثبت شده در تاپین <br>
                                                    بارکد پستی:
                                                    {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                                @elseif($OrderSrc->status == 51)
                                                    ارسال شده به تاپین <br>
                                                    بارکد پستی:
                                                    {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                                @endif


                                            </p>
                                            <p><strong>تاریخ: </strong>{{ $Persian->MyPersianDate($OrderSrc->created_at) }}
                                            </p>
                                            <p><strong>شماره سند:</strong> S-{{ $OrderSrc->id }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-4 border-top"></div>
                                    <div class="card mb-5">
                                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                            مشخصات فروشنده
                                        </div>
                                        <div class="card-body">
                                            <div class="row ">
                                                <div class="col">
                                                    نام شخص: {{ App\myappenv::InvoiceData['InvoiceName'] }}
                                                </div>
                                                <div class="col">
                                                    شماره اقتصادی :{{ App\myappenv::InvoiceData['TaxCode'] }}
                                                </div>
                                                <div class="col">
                                                    شماره ثبت ملی:{{ App\myappenv::InvoiceData['RegisterCode'] }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    استان:{{ App\myappenv::InvoiceData['Provinces'] }}
                                                </div>
                                                <div class="col">
                                                    شهر:{{ App\myappenv::InvoiceData['City'] }}
                                                </div>
                                                <div class="col">
                                                    تلفن:{{ App\myappenv::InvoiceData['Phone'] }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    آدرس:{{ App\myappenv::InvoiceData['Address'] }}
                                                </div>
                                                <div class="col">
                                                    کد پستی:{{ App\myappenv::InvoiceData['PostalCode'] }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-5">
                                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                            مشخصات خریدار
                                        </div>
                                        <div class="card-body">
                                            <div class="row ">
                                                <div class="col">
                                                    شرکت/نام شخص: {{ $OrderSrc->Name }} {{ $OrderSrc->Family }}
                                                </div>
                                                <div class="col">
                                                    @if ($OrderSrc->MelliID == null)
                                                        شناسه ملی:{{ $OrderSrc->NationalCode }}
                                                    @else
                                                        شماره ملی:
                                                        {{ $OrderSrc->MelliID }}
                                                    @endif
                                                </div>

                                                <div class="col">
                                                    تلفن: {{ $OrderSrc->MobileNo }}


                                                </div>
                                            </div>
                                            @if (isset($SendLocation->id))
                                                <div class="row">
                                                    <div class="col">
                                                        استان:{{ $SendLocation->Province }}
                                                    </div>
                                                    <div class="col">
                                                        شهر:{{ $SendLocation->City }}
                                                    </div>
                                                    <div class="col">
                                                        شماره اقتصادی : {{ $OrderSrc->extranote }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        آدرس:{{ $SendLocation->Street }} -
                                                        {{ $SendLocation->OthersAddress }}
                                                    </div>
                                                    <div class="col">
                                                        کد پستی:{{ $SendLocation->PostalCode }}
                                                    </div>

                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-hover mb-4">
                                                <thead class="bg-gray-300">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">شرح کالا</th>
                                                        <th scope="col">مبلغ واحد (ریال)</th>
                                                        <th scope="col">تعداد</th>
                                                        <th scope="col">مبلغ کل (ریال)</th>
                                                        <th scope="col">تخفیف (ریال)</th>
                                                        <th scope="col">مبلغ پس از تخفیف (ریال)</th>
                                                        <th scope="col"> کارمزد (ریال)</th>
                                                        <th scope="col">مالیات</th>
                                                        <th scope="col">جمع کل</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $Conter = 1;
                                                        $Totall = 0;
                                                    @endphp

                                                    @foreach ($OrderItems as $OrderItem)
                                                        <tr>
                                                            <th scope="row">{{ $Conter++ }}</th>
                                                            <td>{{ $OrderItem->NameFa }}</td>
                                                            <td>{{ number_format($OrderItem->main_unit_price) }}</td>
                                                            <td>{{ $OrderItem->product_qty }}</td>
                                                            <td>{{ number_format($OrderItem->main_unit_price * $OrderItem->product_qty) }}
                                                            </td>
                                                            <td>{{ number_format($OrderItem->unitDef * $OrderItem->product_qty) }}
                                                            </td>
                                                            <td>{{ number_format($OrderItem->main_unit_price * $OrderItem->product_qty - $OrderItem->unitDef * $OrderItem->product_qty) }}
                                                            </td>
                                                            <td>{{ number_format($OrderItem->unit_sales * $OrderItem->product_qty - $OrderItem->unit_Price * $OrderItem->product_qty) }}
                                                            </td>
                                                            <td>{{ number_format($OrderItem->tax_total) }}</td>
                                                            <td>{{ number_format($OrderItem->unit_sales * $OrderItem->product_qty + $OrderItem->tax_total) }}
                                                                @php
                                                                    $Totall += $OrderItem->unit_sales * $OrderItem->product_qty + $OrderItem->tax_total;
                                                                @endphp</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="invoice-summary" style="float: left">

                                                <p>مبلغ کل: <span>{{ number_format($Totall) }} ریال</span></p>
                                                <p>هزینه ارسال: <span>{{ number_format($OrderSrc->shipping_total) }}
                                                        ریال</span></p>
                                                <p>مالیات بر ارزش افزوده: <span>{{ number_format($OrderSrc->tax_total) }}
                                                        ریال</span></p>
                                                <h5 style="margin-right: -34px;"class="font-weight-bold">مبلغ قابل پرداخت:
                                                    <span>

                                                        {{ number_format($OrderSrc->shipping_total + $Totall) }}
                                                        ریال</span>
                                                </h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--==== / Print Area =====-->
                            </div>
                        @elseif($invoice_type == 'service')
                            <div class="tab-pane fade show active" id="invoice" role="tabpanel"
                                aria-labelledby="invoice-tab">
                                <div class="d-sm-flex mb-5" data-view="print">
                                    <span class="m-auto"></span>
                                    <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ صورت حساب</button>
                                </div>
                                <!---===== Print Area =======-->
                                <div id="print-area">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <h4 class="font-weight-bold">صورت حساب خدمات : {{App\myappenv::InvoiceData['InvoiceName']}} </h4>
                                            <img style="width: 100px;"
                                                src="{{App\myappenv::MainIcon}}">
                                        </div>
                                        <div class="col-md-6 text-sm-right">
                                            <p><strong>وضعیت سفارش: </strong>
                                                @if ($OrderSrc->status == 0)
                                                    در انتظار پرداخت
                                                @elseif ($OrderSrc->status == 1)
                                                    پرداخت شده
                                                @elseif($OrderSrc->status == 10)
                                                    در دست اقدام
                                                @elseif($OrderSrc->status == 20)
                                                    ارسال به انبار
                                                @elseif($OrderSrc->status == 30)
                                                    درحال بسته بندی
                                                @elseif($OrderSrc->status == 40)
                                                    ارسال به پست
                                                @elseif($OrderSrc->status == 50)
                                                    ثبت شده در تاپین <br>
                                                    بارکد پستی:
                                                    {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                                @elseif($OrderSrc->status == 51)
                                                    ارسال شده به تاپین <br>
                                                    بارکد پستی:
                                                    {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                                @endif


                                            </p>
                                            <p><strong>تاریخ: </strong>{{ $Persian->MyPersianDate($OrderSrc->created_at) }}
                                            </p>
                                            <p><strong>شماره سند:</strong> S-{{ $OrderSrc->id }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-4 border-top"></div>
                                    <div class="card mb-5">
                                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                            مشخصات فروشنده
                                        </div>
                                        <div class="card-body">
                                            <div class="row ">
                                                <div class="col">
                                                    نام شخص: {{ App\myappenv::InvoiceData['InvoiceName'] }}
                                                </div>
                                                <div class="col">
                                                    شماره اقتصادی :{{ App\myappenv::InvoiceData['TaxCode'] }}
                                                </div>
                                                <div class="col">
                                                    شماره ثبت ملی:{{ App\myappenv::InvoiceData['RegisterCode'] }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    استان:{{ App\myappenv::InvoiceData['Provinces'] }}
                                                </div>
                                                <div class="col">
                                                    شهر:{{ App\myappenv::InvoiceData['City'] }}
                                                </div>
                                                <div class="col">
                                                    تلفن:{{ App\myappenv::InvoiceData['Phone'] }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    آدرس:{{ App\myappenv::InvoiceData['Address'] }}
                                                </div>
                                                <div class="col">
                                                    کد پستی:{{ App\myappenv::InvoiceData['PostalCode'] }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-5">
                                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                            مشخصات خریدار
                                        </div>
                                        <div class="card-body">
                                            <div class="row ">
                                                <div class="col">
                                                    شرکت/نام شخص: {{ $OrderSrc->Name }} {{ $OrderSrc->Family }}
                                                </div>
                                                <div class="col">
                                                    @if ($OrderSrc->MelliID == null)
                                                        شناسه ملی:{{ $OrderSrc->NationalCode }}
                                                    @else
                                                        شماره ملی:
                                                        {{ $OrderSrc->MelliID }}
                                                    @endif
                                                </div>

                                                <div class="col">
                                                    تلفن: {{ $OrderSrc->MobileNo }}
                                                </div>
                                            </div>
                                            @if (isset($SendLocation->id))
                                                <div class="row">
                                                    <div class="col">
                                                        استان:{{ $SendLocation->Province }}
                                                    </div>
                                                    <div class="col">
                                                        شهر:{{ $SendLocation->City }}
                                                    </div>
                                                    <div class="col">
                                                        شماره اقتصادی : {{ $OrderSrc->extranote }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        آدرس:{{ $SendLocation->Street }} -
                                                        {{ $SendLocation->OthersAddress }}
                                                    </div>
                                                    <div class="col">
                                                        کد پستی:{{ $SendLocation->PostalCode }}
                                                    </div>

                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-hover mb-4">
                                                <thead class="bg-gray-300">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">شرح خدمت</th>
                                                        <th scope="col">تاریخ شروع خدمت</th>
                                                        <th scope="col">تاریخ پایان خدمت</th>
                                                        <th scope="col">خدمات دهنده</th>
                                                        <th scope="col">مبلغ کل (ریال)</th>
                                                        <th scope="col">مالیات</th>
                                                        <th scope="col">جمع کل</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($AllShiftsTotall != null)<tr>
                                                        <th scope="row">1</th>
                                                        <td>{{ $AllShiftsTotall->RespnsTypeName}} </td>
                                                        <td>{{ $Persian->MyPersianDate($AllShiftsTotall->StartRespns,true) }} </td>
                                                        <td>{{$Persian->MyPersianDate($AllShiftsTotall->EndRespns,true)}} </td>
                                                        <td>{{$AllShiftsTotall->ResponserName}} {{$AllShiftsTotall->ResponserFamily}} </td>
                                                        <td>{{ number_format($OrderSrc->total_sales) }}</td>
                                                        <td>{{ number_format($OrderSrc->tax_total) }} </td>
                                                        <td>{{ number_format($OrderSrc->shipping_total + $OrderSrc->total_sales) }}</td>
                                                    </tr>
                                                    @else
                                                        <p class="text-danger">اطلاعات شیفت موجود نیست!</p>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="invoice-summary" style="float: left">

                                                <p>مبلغ کل: <span>{{ number_format($OrderSrc->total_sales) }} ریال</span></p>
                                                <p>هزینه حمل و نقل: <span>{{ number_format($OrderSrc->shipping_total) }}
                                                        ریال</span></p>
                                                <p>مالیات بر ارزش افزوده: <span>{{ number_format($OrderSrc->tax_total) }}
                                                        ریال</span></p>
                                                <h5 style="margin-right: -34px;"class="font-weight-bold">مبلغ قابل پرداخت:
                                                    <span>

                                                        {{ number_format($OrderSrc->shipping_total + $OrderSrc->total_sales) }}
                                                        ریال</span>
                                                </h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--==== / Print Area =====-->
                            </div>
                        @endif
                        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                            <!--==== Edit Area =====-->
                            <form>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-hover mb-3">
                                            <thead class="bg-gray-300">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">کد تراکنش</th>
                                                    <th scope="col">حساب</th>
                                                    <th scope="col">مبلغ</th>
                                                    <th scope="col">تاریخ</th>
                                                    <th scope="col">کیف پول</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $Counter = 1;
                                                @endphp
                                                @foreach ($Transactions as $TransactionItem)
                                                    @if (Auth::user()->Role == App\myappenv::role_customer)
                                                        @if (Auth::id() == $TransactionItem->UserName)
                                                            <tr>
                                                                <th scope="row">{{ $Counter++ }}</th>
                                                                <td>
                                                                    {{ $TransactionItem->TranctionID }}
                                                                </td>
                                                                <td>
                                                                    {{ $TransactionItem->Name }}
                                                                    {{ $TransactionItem->Family }}
                                                                </td>
                                                                <td>
                                                                    @if ($TransactionItem->Mony >= 0)
                                                                        {{ number_format($TransactionItem->Mony) }}
                                                                    @else
                                                                        برداشت
                                                                        {{ number_format($TransactionItem->Mony * -1) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $Persian->MyPersianDate($TransactionItem->Date) }}
                                                                </td>
                                                                <td> {{ $TransactionItem->ModName }}</td>
                                                            </tr>
                                                        @endif
                                                    @elseif (Auth::user()->Role > App\myappenv::role_customer)
                                                        <tr>
                                                            <th scope="row">{{ $Counter++ }}</th>
                                                            <td>
                                                                {{ $TransactionItem->TranctionID }}
                                                            </td>
                                                            <td>
                                                                {{ $TransactionItem->Name }}
                                                                {{ $TransactionItem->Family }}
                                                            </td>
                                                            <td>
                                                                @if ($TransactionItem->Mony >= 0)
                                                                    {{ number_format($TransactionItem->Mony) }}
                                                                @else
                                                                    برداشت
                                                                    {{ number_format($TransactionItem->Mony * -1) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $Persian->MyPersianDate($TransactionItem->Date) }}
                                                            </td>
                                                            <td> {{ $TransactionItem->ModName }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>
@endsection
