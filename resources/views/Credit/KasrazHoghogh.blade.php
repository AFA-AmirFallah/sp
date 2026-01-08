@php
    $Persian = new App\Functions\persian();
    $Totall = 0;
    $TotallunitPrice = 0;
    $TotallunitPrice2 = 0;
    $TotallunitPrice3 = 0;
    $TotallTax = 0;
    $Count = 0;
@endphp
@extends('Layouts.NoLoginPage')
@section('page-header-left')
@endsection

@section('MainCountent')

    <div class="d-sm-flex mb-5" data-view="print">
        <span class="m-auto"></span>
        <button id="print-invoice" class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ کسر از حقوق </button>
    </div>
    <div id="print-area">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div style="display: flex;justify-content: space-around;">
                        @if (\App\myappenv::MainOwner == 'kookbaz')
                            <img style="  width: 100px;height: 100px;"
                                src="{{ asset('assets/images/favicon/kookted.png') }}">

                            <h3 class="font-weight-bold" style="margin-top: 50px;">صورتحساب فروش کالا و خدمات</h3>

                            <img style="  width: 100px;height: 83px; " src="{{ asset('assets/images/andishe.png') }}">
                        @endif
                    </div>
                    <div style="display: flex;justify-content: space-between;">
                        <div class="col-3 text-right">
                            <p>شماره سفارش:
                                K-{{ $TargetOrder->id }}</p>

                        </div>
                        <div class="col-3 " style="  float: left;">
                            <p>تاریخ سفارش:
                                {{ $Persian->MyPersianDate($TargetOrder->created_at, false) }}</p>

                        </div>
                    </div>


                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">

                            <!---===== Print Area =======-->
                            <div class="container-xl">
                                <div class="row">


                                </div>
                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="11">مشخصات فروشنده</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="11">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p>
                                                                نام شخص حقوقی {{ App\myappenv::InvoiceData['InvoiceName'] }}
                                                            </p>
                                                            <p>
                                                                استان:{{ App\myappenv::InvoiceData['Provinces'] }}
                                                            </p>
                                                            <p>
                                                                آدرس:{{ App\myappenv::InvoiceData['Address'] }}
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p>
                                                                شماره اقتصادی
                                                                :{{ App\myappenv::InvoiceData['TaxCode'] }}
                                                            </p>
                                                            <p>
                                                                شهر:{{ App\myappenv::InvoiceData['City'] }}
                                                            </p>

                                                        </div>
                                                        <div class="col-3">
                                                            <p>
                                                                شماره ثبت
                                                                ملی:{{ App\myappenv::InvoiceData['RegisterCode'] }}
                                                            </p>
                                                            <p>
                                                                تلفن:{{ App\myappenv::InvoiceData['Phone'] }}
                                                            </p>
                                                            <p>
                                                                کد پستی:{{ App\myappenv::InvoiceData['PostalCode'] }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="11">مشخصات خریدار</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="11">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p>
                                                                نام شخص حقیقی / حقوقی: {{ $TargetOrder->Name }}
                                                                {{ $TargetOrder->Family }}
                                                            </p>

                                                        </div>
                                                        <div class="col-3">

                                                            @if ($TargetOrder->MelliID == null)
                                                                <p>
                                                                    شناسه ملی:{{ $TargetOrder->NationalCode }}
                                                                </p>
                                                            @else
                                                                <p>
                                                                    شماره ملی:
                                                                    {{ $TargetOrder->MelliID }}
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <div class="col-3">
                                                            <p>
                                                                تلفن: {{ $TargetOrder->MobileNo }}
                                                            </p>



                                                        </div>
                                                    </div>
                                                    @if (isset($SendLocation->id))
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>
                                                                    استان:{{ $SendLocation->Province }}
                                                                </p>

                                                            </div>
                                                            <div class="col">
                                                                <p>
                                                                    شهر:{{ $SendLocation->City }}
                                                                </p>

                                                            </div>
                                                            <div class="col">
                                                                <p>
                                                                    شماره اقتصادی :
                                                                </p>

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
                                </td>
                                </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="11">مشخصات کالا یا خدمات مورد معامله
                                        </th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="text-center">
                                        <th>ردیف</th>
                                        <th>کد کالا</th>
                                        <th colspan="3">شرح کالا یا خدمات</th>
                                        <th>تعداد </th>
                                        <th >مبلغ پس از تخفیف (ریال)</th>
                                        <th>مبلغ کل پس از تخیف (ریال)</th>
                                        <th> کارمزد (ریال)</th>
                                        <th> مالیات و عوارض (ریال)</th>
                                        <th>جمع مبلغ کل (ریال)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($TargetproductOrder as $TargetOrderLIst)
                                        @php

                                            $Totall += $TargetOrderLIst->unit_sales * $TargetOrderLIst->product_qty + $TargetOrderLIst->tax_total;
                                            $TotallunitPrice += $TargetOrderLIst->unit_Price;
                                            $TotallunitPrice2 += $TargetOrderLIst->unit_Price *  $TargetOrderLIst->product_qty ;
                                            $TotallunitPrice3 += $TargetOrderLIst->unit_sales* $TargetOrderLIst->product_qty - $TargetOrderLIst->unit_Price * $TargetOrderLIst->product_qty ;
                                       $TotallTax += $TargetOrderLIst->tax_total;
                                       $Count += $TargetOrderLIst->product_qty 
                                       

                                       @endphp
                                    @endforeach
                                    @php
                                        $Conter = 1;
                                        
                                        
                                    @endphp
                                    @foreach ($TargetproductOrder as $TargetOrderLIst)
                                        <tr class="text-center">
                                            <td> {{ $Conter++ }}</td>
                                            <td> {{ $TargetOrderLIst->SKU }}</td>
                                            <td colspan="3"> {{ $TargetOrderLIst->NameFa }} </td>
                                            <td> {{ $TargetOrderLIst->product_qty }}</td>
                                            <td>
                                                {{ number_format($TargetOrderLIst->unit_Price) }}

                                            </td>
                                            <td> {{ number_format($TargetOrderLIst->unit_Price *  $TargetOrderLIst->product_qty  ) }}


                                            </td>
                                           
                                           
                                                <td>{{ number_format($TargetOrderLIst->unit_sales* $TargetOrderLIst->product_qty - $TargetOrderLIst->unit_Price * $TargetOrderLIst->product_qty) }}
                                                </td>
                                        
                                            <td>
                                                {{ number_format($TargetOrderLIst->tax_total )   }}

                                            </td>

                                            <td>
                                                {{ number_format($TargetOrderLIst->unit_sales * $TargetOrderLIst->product_qty + $TargetOrderLIst->tax_total) }}

                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="5
                                        " class="text-center">جمع کل</th>
                                        <th class="text-center">
                                            <b>{{ $Count }}</b> 

                                        </th>
                                        <th class="text-center">
                                            <b>{{ number_format($TotallunitPrice) }}</b> ریال

                                        </th>
                                        <th class="text-center">
                                            <b>{{ number_format($TotallunitPrice2) }}</b> ریال

                                        </th>
                                        <th class="text-center">
                                            <b>{{ number_format($TotallunitPrice3) }}</b> ریال

                                        </th>
                                        <th class="text-center">
                                            <b>{{ number_format($TotallTax) }}</b> ریال

                                        </th>
                                        <th class="text-center">
                                            <b>{{ number_format($Totall) }}</b> ریال

                                        </th>
                                        

                                    </tr>
                                    <tr>

                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="11"> وکالت کسر از حقوق</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @php
                                        $extranote = json_decode($TargetOrder->extradata);
                                        if (isset($extranote->BazCode)) {
                                            $BazCode = $extranote->BazCode;
                                        } else {
                                            $BazCode = '0';
                                        }
                                    @endphp
                                    <tr class="text-center">
                                        <td colspan="11">
                                            <p style="
                                                line-height: 40px;">
                                                اینجانب <b>{{ $TargetOrder->Name }} {{ $TargetOrder->Family }}</b>
                                                فرزند <b> {{ $TargetOrder->fathername }}</b>
                                                به
                                                شماره ملی <b>{{ $TargetOrder->MelliID }}</b>
                                                و
                                                شماره بازنشستگی
                                                <b>{{ $BazCode }}</b>

                                                به شرکت گسترش فناوری اندیشه ایرانیان وکالت می دهم تا مبلغ
                                                <b>{{ number_format($Totall) }}</b> ریال
                                                بابت
                                                پرداخت فاکتور شماره
                                                <b>{{ $TargetOrder->id }} </b>
                                                به شرح زیر
                                                در تاریخ
                                                <b>{{ $Persian->MyPersianDate($TargetOrder->created_at, false) }}</b>


                                                را از حقوق، وجوه، سپرده ها و کلیه مطالبات اینجانب نزد سازمان
                                                برداشت نماید.
                                                .همچنین حق عزل و ضم وکیل و هرگونه اعتراض را از خود سلب نموده و
                                                اسقاط کافه خیارات نموده ام
                                                ضمنا حقوق، وجوه، سپرده ها و کلیه مطالبات مذکور وثیقه دین اینجانب
                                                بوده و در صورت حجر، حق این بدهی مقدم بر
                                                سایر
                                                طلبکاران خواهد بود.
                                                همچنین بانک پس از فوت اینجانب بعنوان وصی بعد از فوت حق اعمال
                                                اختیارات فوق را خواهد داشت.
                                            </p>

                                        </td>


                                    </tr>
                                    <br>
                                    <tr>
                                        <td colspan="11">
                                            @if ($TargetOrder->extradata != null)
                                                @php
                                                    $extranote = json_decode($TargetOrder->extradata);
                                                    if (isset($extranote->tavg)) {
                                                        $tavg = $extranote->tavg;
                                                    } else {
                                                        $tavg = '0';
                                                    }
                                                @endphp

                                                <div>


                                                    میزان توان پرداخت
                                                    خریدار
                                                    در تاریخ
                                                    <span> {{ $Persian->MyPersianDate($TargetOrder->created_at, false) }}
                                                        برابر مبلغ
                                                        :<strong>{{ number_format($tavg) }}</strong> ریال می باشد</span>


                                                </div>
                                        </td>
                                    </tr>


                                </tbody>

                                <thead>
                                    <tr class="text-center">
                                        <th colspan="4">#</th>
                                        <th colspan="4"> تاریخ سر رسید</th>
                                        <th colspan="4">مبلغ هر قسط </th>



                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $Conter = 1;
                                        
                                    @endphp
                                    @foreach ($TavanSrc as $TavanItem)
                                        <tr class="text-center">
                                            <td colspan="4">
                                                {{ $Conter++ }}

                                            </td>
                                            <td colspan="4">
                                                {{ $Persian->MyPersianDate($TavanItem->Date) }}
                                            </td>
                                            <td colspan="4">
                                                {{ number_format(abs($TavanItem->Mony)) }}
                                                <br>
                                                ریال

                                            </td>


                                        </tr>
                                    @endforeach





                                </tbody>




                                </table>
                                @endif


                                <table class="table table-bordered">
                                    <tr class="text-center">
                                        <td>
                                            مهر و امضا شرکت
                                        </td>
                                        <td>
                                            امضا و اثرانگشت خریدار
                                            {{ $TargetOrder->Name }} {{ $TargetOrder->Family }}
                                            <br>
                                            <br>

                                        </td>

                                    </tr>

                                </table>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#print-invoice').on('click', function() {
                window.print();
            })
        });
    </script>
@endsection
