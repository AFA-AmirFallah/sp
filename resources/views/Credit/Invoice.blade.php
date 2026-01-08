@php
    $Persian = new App\Functions\persian();
    $totall = 0;
    $Discount = 0;
    $TotallSum = 0;
    $Tax = 0;
@endphp
@extends('Layouts.NoLoginPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="ul-card-list__modal">
        <div class="modal fade add-device-contract-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="device_model_title"> عملیات کارت به کارت </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">لطفا واریز را به شماره کارت ذیل انجام دهید</label>
                        </div>
                        <div class="form-group row" style="text-align: center;display: flow-root;">
                            <img src="{{ asset('assets/images/PayCard.jpeg') }}">
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-12 col-form-label">لطفا پس از واریز از طریق شماره تلفن ذیل
                                مشخصات
                                پرداخت را اطلاع دهید</label>
                        </div>
                        <input style="visibility: hidden" type="text" value="5022291301837583" id="myInput">
                        <div class="ul-bottom__line mb-3">
                            <button type="button" name="submit" onclick="myFunction()"
                                class="btn btn-primary btn-rounded m-1">کپی شماره کارت
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <button class="btn btn-primary mb-sm-0 mb-3 print-invoice"><i class="i-Receipt-3 text-white mr-2"></i>
                        {{ __('Print Invoice') }}</button>
                    <span class="m-auto"></span>
                    <form method="post">
                        @csrf
                        <button class="btn btn-primary btn-md m-1" type="submit" data-target=".add-device-contract-modal"
                            name="submitandPay" value="{{ $InvoiceTarget->id }}"
                            style="background-color: green;margin: 10px;"><i
                                class="i-Internet text-white mr-3"></i>{{ __('online Payment') }}</button>

                    </form>
                    @if (\App\myappenv::MainOwner != 'kookbaz')
                        <button id="addcontact" type="button" data-toggle="modal" style="float: left;"
                            data-target=".add-device-contract-modal" class="btn btn-primary btn-md m-1">
                            <i class="i-Credit-Card text-white mr-2"></i>کارت به کارت
                        </button>
                    @endif

                </div>
                <!---===== Print Area =======-->
                <div id="print-area">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold">صورت حساب :</h4>
                            @if (\App\myappenv::MainOwner == 'kookbaz')
                                <img style="    width: 170px;" src="{{ asset('assets/images/logo-kookbaz.png') }}">
                            @endif
                        </div>
                        <div class="col-md-6 text-sm-right">
                            <p><strong>{{ __('Invoice status') }}: </strong> {{ $InvoiceTarget->StatusName }}</p>
                            <p><strong>{{ __('Invoice issue date') }}
                                    : </strong>{{ $Persian->MyPersianDate($InvoiceTarget->created_at) }} </p>
                            <p><strong>شماره سند:</strong> S-{{ $InvoiceTarget->id }}</p>
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

                                    شرکت/نام شخص: {{ $InvoiceTarget->ownername }} {{ $InvoiceTarget->ownnerfamily }}
                                </div>


                                <div class="col">
                                    تلفن: {{ $InvoiceTarget->ownnerMobileNo }}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover mb-4">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Item Name') }}</th>
                                        <th scope="col">{{ __('Unit Price') }}</th>
                                        <th scope="col">{{ __('Unit') }}</th>
                                        <th scope="col">{{ __('Qty') }}</th>
                                        <th scope="col">{{ __('Discount') }}</th>
                                        <th scope="col">مالیات</th>
                                        <th scope="col">{{ __('Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($InvoiceItems as $InvoiceItem)
                                        <tr>
                                            @php
                                                $totall += $InvoiceItem->TotallPrice;
                                                $Discount += $InvoiceItem->Discount;
                                                $Tax += $InvoiceItem->Tax;
                                                $TotallSum += $InvoiceItem->Qty * $InvoiceItem->UnitPrice;
                                            @endphp
                                            <th scope="row">{{ $InvoiceItem->ItemID }}</th>
                                            <td>{{ $InvoiceItem->ItemName }}</td>
                                            <td>{{ number_format($InvoiceItem->UnitPrice) }} ریال</td>
                                            <td>{{ $InvoiceItem->Unit }}</td>
                                            <td>{{ $InvoiceItem->Qty }}</td>
                                            <td>{{ number_format($InvoiceItem->Discount) }} ریال</td>
                                            <td>{{ number_format($InvoiceItem->Tax) }} ریال</td>
                                            <td>{{ number_format($InvoiceItem->TotallPrice) }} ریال</td>
                                          
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="invoice-summary" style="float: left">
                                <p>مبلغ کل: <span> {{ number_format($TotallSum) }} ریال </span></p>
                                <p>مجموع تخفیف: <span> {{ number_format($Discount) }} ریال </span></p>
                              
                                <p>مالیات :<span> {{ number_format($Tax) }}  ریال</span></p>
                                      
                                <h5 class="font-weight-bold">مجموع  :
                                    <span> {{ number_format($totall) }} ریال </span>
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
