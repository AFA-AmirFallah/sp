@php
    $Persian = new App\Functions\persian();
    $totall = 0;
    $Discount = 0;
    $TotallSum = 0;
@endphp
@extends('Layouts.NoLoginPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="ul-card-list__modal">
        <div class="modal fade edit-device-contract-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="device_model_title">{{ __('Add device contract') }} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                <div class="d-sm-flex mb-5" data-view="print">
                    <span class="m-auto"></span>
                    <form method="post">
                        @csrf
                        <div class="row">
                            <button type="button" class="btn btn-primary print-invoice" style="float: left"><i
                                    class="i-Receipt-3 text-white"></i> {{ __('Print Invoice') }}</button>
                            @if ($InvoiceTarget->Status != 100)
                                <button class="btn btn-primary " type="submit" data-target=".add-device-contract-modal"
                                    name="submitandPay" value="{{ $InvoiceTarget->ContractID }}"
                                    style="background-color: green; float: left"><i
                                        class="i-Internet text-white"></i>{{ __('online Payment') }}</button>
                            @endif
                            @can('admin')
                                <a href="{{ route('EditeSmartInvoice', ['InvoiceID' => $InvoiceTarget->ContractID]) }}"
                                    style="float: left;" data-target=".add-device-contract-modal" class="btn btn-danger ">
                                    ویرایش
                                </a>
                            @endcan
                        </div>

                    </form>


                </div>
                <!---===== Print Area =======-->
                <hr>
                <h4 class="font-weight-bold">پیش فاکتور :</h4>

                <div id="print-area">
                    <div class="row">

                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6 text-sm-right">

                            <p><strong>وضعیت پیش فاکتور: </strong>
                                @if ($InvoiceTarget->Status == 1)
                                    @if ($InvoiceTarget->BeyanehPrice == null || $InvoiceTarget->BeyanehPrice == 0)
                                        در انتظار تسویه حساب
                                    @else
                                        در انتظار بیعانه
                                    @endif
                                @elseif($InvoiceTarget->Status == 50)
                                    در انتظار تسویه حساب
                                @elseif($InvoiceTarget->Status == 100)
                                    تسویه شده
                                @endif

                            </p>
                            <p><strong>تاریخ صدور پیش فاکتور
                                    : </strong>{{ $Persian->MyPersianDate($InvoiceTarget->created_at, true) }} </p>
                            <p><strong> شماره پیش فاکتور:</strong>#{{ $InvoiceTarget->ContractID }}</p>

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
                                    نام شخص: {{ $Owner->Name }} {{ $Owner->Family }}
                                </div>
                                <div class="col">
                                    شماره اقتصادی : {{ $Owner->extranote }}
                                </div>



                                <div class="col">
                                    @if ($Owner->MelliID == null)
                                        شناسه ملی:{{ $Owner->NationalCode }}
                                    @else
                                        شناسه ملی:
                                        {{ $Owner->MelliID }}
                                    @endif
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
                                        تلفن: {{ $SendLocation->reciverphone }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        آدرس:{{ $SendLocation->Street }} - {{ $SendLocation->OthersAddress }}
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
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">شرح کالا</th>
                                        <th scope="col">مبلغ واحد (ریال)</th>
                                        <th scope="col">تعداد</th>
                                        <th scope="col">مبلغ کل (ریال)</th>
                                        <th scope="col">تخفیف (ریال)</th>
                                        <th scope="col">مبلغ پس از تخفیف (ریال)</th>
                                        <th scope="col">جمع کل</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $RowCount = 1;
                                    @endphp

                                    @foreach ($InvoiceItems as $InvoiceItem)
                                        <tr>
                                            <th scope="row">{{ $RowCount++ }}</th>
                                            <td>{{ $InvoiceItem->DeviceName }}</td>
                                            <td>{{ number_format($InvoiceItem->unit_Price) }}</td>
                                            <td>{{ $InvoiceItem->product_qty }}</td>
                                            <td>{{ $InvoiceItem->unit_Price * $InvoiceItem->product_qty }} ریال
                                            </td>
                                            <td>{{ $InvoiceItem->unit_Price - $InvoiceItem->Price }}</td>
                                            <td>{{ number_format($InvoiceItem->Price) }}</td>
                                            <td>{{ number_format($InvoiceItem->Price) }} ریال</td>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="invoice-summary" style="float: left">
                                <p>مبلغ کل: <span>{{ number_format($InvoiceItem->TotalPrice) }} ریال </span></p>
                                <p>هزینه ارسال: <span> ریال</span></p>
                                <p>بیعانه: <span> {{ number_format($InvoiceItem->BeyanehPrice) }} ریال </span></p>
                                <small> مبلغ بیعانه از مبلغ کل کم خواهد شد</small>
                                <h5 style="margin-top: 20px;
                                margin-right: -56px;"
                                    class="font-weight-bold">مجموع قابل پرداخت:
                                    <span> {{ number_format($InvoiceItem->TotalPrice) }} ریال </span>
                                </h5>




                            </div>
                        </div>
                    </div>
                </div>
                <!--==== / Print Area =====-->
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
@section('page-js')
    <script>
        function myFunction() {
            /* Get the text field */
            var copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            //      document.execCommand("copy");
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Fallback: Copying text command was ' + msg);
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
            }
            /* Alert the copied text */
            alert("کپی شماره کارت: " + copyText.value);
        }
    </script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>
@endsection
