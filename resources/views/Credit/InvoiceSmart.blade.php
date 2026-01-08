@php
$Persian = new App\Functions\persian();
$totall = 0;
$Discount = 0;
$TotallSum = 0;
@endphp
@extends("Layouts.NoLoginPage")
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
                            <img src="">
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
                    <form method="post">
                        @csrf
                        <div class="row">
                            <button class="btn btn-primary print-invoice" style="float: left"><i
                                    class="i-Receipt-3 text-white"></i> {{ __('Print Invoice') }}</button>
                            @if ($InvoiceTarget->Status != 100)
                                <button class="btn btn-primary " type="submit" data-target=".add-device-contract-modal"
                                    name="submitandPay" value="{{ $InvoiceTarget->ContractID }}"
                                    style="background-color: green; float: left"><i
                                        class="i-Internet text-white"></i>{{ __('online Payment') }}</button>
                                <button id="addcontact" type="button" data-toggle="modal" style="float: left;"
                                    data-target=".add-device-contract-modal" class="btn btn-primary ">
                                    <i class="i-Credit-Card text-white"></i>کارت به کارت
                                </button>
                            @endif
                        </div>

                    </form>


                </div>
                <!---===== Print Area =======-->
                <hr>

                <div id="print-area">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold">{{ __('Invoice number') }}</h4>
                            <p>#{{ $InvoiceTarget->ContractID }}</p>
                        </div>
                        <div class="col-md-6 text-sm-right">
                            <p><strong>{{ __('Invoice status') }}: </strong>
                                @if ($InvoiceTarget->Status == 1)
                                    @if($InvoiceTarget->BeyanehPrice == null || $InvoiceTarget->BeyanehPrice == 0)
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
                            <p><strong>{{ __('Invoice issue date') }}
                                    : </strong>{{ $Persian->MyPersianDate($InvoiceTarget->created_at, true) }} </p>
                        </div>
                    </div>
                    <div class="mt-3 mb-4 border-top"></div>
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-sm-0">
                            <h5 class="font-weight-bold">تامین کننده</h5>
                            <p>{{ $TargetOwner->Name }}</p>
                            <span style="white-space: pre-line">
                                {{ $TargetOwner->Description }}
                            </span>
                        </div>
                        <div class="col-md-6 text-sm-right">
                            <h5 class="font-weight-bold">{{ __('Invoice To') }}</h5>
                            <p>{{ $Owner->Name }} {{ $Owner->Family }}</p>
                            <span style="white-space: pre-line">
                                {{ $Owner->MobileNo }}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover mb-4">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Item Name') }}</th>
                                        <th scope="col">{{ __('Note') }}</th>
                                        <th scope="col">{{ __('Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $RowCount = 1;
                                    @endphp
                                    @foreach ($InvoiceItems as $InvoiceItem)
                                        <tr>
                                            <th>{{ $RowCount++ }}</th>
                                            <th scope="row">{{ $InvoiceItem->MetaName }} {{ $InvoiceItem->TypeName }}
                                            </th>
                                            <td>{{ $InvoiceItem->ItemNote }}</td>
                                            <td>{{ number_format($InvoiceItem->Price) }} ریال</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="invoice-summary">
                                <p>بیعانه: <span> {{ number_format($InvoiceItem->BeyanehPrice) }} ریال </span></p>
                                <h5 class="font-weight-bold">مجموع قابل پرداخت:
                                    <span> {{ number_format($InvoiceItem->TotalPrice) }} ریال </span>
                                </h5>
                                <small> مبلغ بیعانه از مبلغ کل کم خواهد شد</small>
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
