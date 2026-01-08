@php
    $Persian = new App\Functions\persian();
    if ($iframeshow) {
        $Layout = 'iframe';
    } else {
        $Layout = null;
    }
@endphp
@extends('Layouts.MainPage', ['layout' => $Layout])
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    @if (!$iframeshow)
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-smg-6">
                        <div class="page-header-left">
                            <h3>صورتحسابها
                                <small>صورتحساب هوشمند</small>
                            </h3>
                        </div>
                    </div>
                    <div class="col-smg-6">
                        <ol class="breadcrumb pull-right">
                            @include('Layouts.AddressBar')
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    @endif
    <form method="post" class="needs-validation user-add">
        @csrf
        <div id="step1" class="card">
            @if (!$iframeshow)
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">{{ $PatInfo->Name }} {{ $PatInfo->Family }}</div>
            @endif
            <div class="card-body">
                <!--==== Edit Area =====-->
                @if (!$iframeshow)
                    <h4>ویرایش صورت حساب</h4>
                @endif
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4">{{ __('Contract type') }}</label>
                    <div class="col-sm-8 col-md-7">
                        پیش فاکتور
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4">تاریخ صدور </label>
                    <input id="startdate" class="form-control col-sm-4 col-md-3 tocheck" type="text" name="StartDate"
                        autocomplete="off" value="{{ $Persian->MyPersianDate($Contrct->RentDate) }}"
                        onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                        placeholder="تاریخ صدور" />
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4">تاریخ اعتبار</label>
                    <input class="form-control col-sm-4 col-md-3 tocheck" type="text" name="EndDate" id="EndDate"
                        autocomplete="off" value="{{ $Persian->MyPersianDate($Contrct->ExpireDate) }}"
                        onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                        placeholder="تاریخ اعتبار" />


                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4 tocheck">{{ __('notes') }} </label>
                    <input class="form-control col-sm-8 col-md-7" type="text" name="Note" id="Note"
                        value="{{ $Contrct->Note }}" placeholder="{{ __('notes') }}" />
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4 tocheck">مبلغ کل</label>
                    <input class="form-control col-sm-8 col-md-7 nested" type="text" name="TotalPriceEnd" id="kolPrice"
                        placeholder="مبلغ کل" />
                    <div class="col-sm-4 col-md-4" id="kolPrice_text">{{ number_format($Contrct->TotalPrice) }} ریال
                    </div>
                    <div class="col-sm-4 col-md-3" id="kolPrice_number"></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4 tocheck">مبلغ تامین کننده</label>
                    <input class="nested col-sm-8 col-md-7" type="text" name="OwnerPrice" id="ProvierPrice"
                        placeholder="مبلغ تامین کننده" />
                    <div class="col-sm-4 col-md-4" id="ProvierPrice_text">{{ number_format($Contrct->OwnerPrice) }} ریال
                    </div>
                    <div class="col-sm-4 col-md-3" id="ProvierPrice_number"></div>

                </div>
                <div class="form-group row" id="daramad_div">
                    <label class="col-sm-3 col-md-4 tocheck">درآمد مرکز</label>
                    <input class="nested col-sm-8 col-md-7" type="text" id="DaramadPrice" placeholder="درآمد مرکز" />
                    <div class="col-sm-4 col-md-4" id="DaramadPrice_text"></div>
                    <div class="col-sm-4 col-md-3" id="DaramadPrice_number">
                        {{ number_format($Contrct->TotalPrice - $Contrct->OwnerPrice) }} ریال</div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4 tocheck">مبلغ بیعانه</label>
                    <input class="form-control col-sm-8 col-md-7" type="text" name="BeyanePrice" id="BeyanePrice"
                        value="{{ $Contrct->BeyanehPrice }}" onkeyup="BeyaneToText()" placeholder="مبلغ بیعانه" />
                    <label class="col-sm-3 col-md-4 tocheck"></label>
                    <div class="col-sm-8 col-md-7" id="BeyanePrice_text"></div>

                </div>
                <div class="form-group row">
                    <div class="table-responsive">
                        <table class="{{ \App\myappenv::MainTableClass }}" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>کالا- خدمت</th>
                                    <th>تعداد</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Pay price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $Counter = 1;
                                @endphp
                                @if (isset($Items))
                                    @foreach ($Items as $ItemsTarget)
                                        <tr>
                                            <th rowspan="3">شماره {{ $Counter }}</th>
                                            <th>{{ $ItemsTarget->DeviceName }}</th>
                                            <th>
                                                <input class="form-control" type="number" name="Qty[]"
                                                    id="Qty_{{ $Counter }}" autocomplete="off"
                                                    value="{{ $ItemsTarget->product_qty }}">
                                            </th>
                                            <input class="nested" type="number" name="item[]"
                                                value="{{ $ItemsTarget->ItemID }}"
                                                onkeyup="PriceChange('{{ $Counter }}')">
                                            <th><input class="form-control tocheck" type="number"
                                                    id="RentPrice_{{ $Counter }}" name="RentPrice[]"
                                                    autocomplete="off" value="{{ $ItemsTarget->unit_Price }}"
                                                    onkeyup="PriceChange('{{ $Counter }}')">
                                                <div id="RentPrice_{{ $Counter }}_text"></div>
                                            </th>
                                            <th><input class="form-control" type="number" name="DiscountPrice[]"
                                                    id="Discount_{{ $Counter }}"
                                                    onkeyup="DiscountChange('{{ $Counter }}')" autocomplete="off"
                                                    value="0">
                                                <div id="DiscountPrice_{{ $Counter }}_text"></div>

                                            </th>

                                            <th><input class="form-control nested" type="number" name="Total[]"
                                                    autocomplete="off" id="Total_{{ $Counter }}" value="0">
                                                <div id="Total_{{ $Counter }}_number">
                                                    {{ number_format($ItemsTarget->Price) }} ریال</div>
                                                <div id="Total_{{ $Counter }}_text"></div>

                                            </th>
                                        </tr>
                                        <tr>
                                            <th>تامین کننده</th>
                                            <th colspan="2">{{ $ItemsTarget->branchname }}
                                            </th>
                                            <th>مبلغ تامین کننده</th>
                                            <th>
                                                <input class="form-control tocheck" type="number" name="ProviderPrice[]"
                                                    autocomplete="off" onkeyup="ProviderChange('{{ $Counter }}')"
                                                    value="{{ $ItemsTarget->OwnerPrice }}"
                                                    id="ProviderPrice_{{ $Counter }}" onkeyup="">
                                                <div id="ProviderPrice_{{ $Counter }}_text"></div>
                                            </th>
                                        </tr>
                                        <tr>


                                            <th>توضیحات</th>
                                            <td colspan="4">
                                                <input class="form-control" name="ItemNote[]"
                                                    value="{{ $ItemsTarget->Note }}">
                                            </td>
                                        </tr>
                                        @php
                                            $Counter++;
                                        @endphp
                                    @endforeach
                                @else
                                    محصول توسط کاربر حذف شده است
                                @endif
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="pull-right">
                    <button type="button" onclick="validation()" class="btn btn-primary">مرحله بعد
                    </button>
                    @if (isset($ItemsTarget))
                        @if ($ItemsTarget->Status > 0)
                            <form method="POST">
                                @csrf
                                <button type="submit" name="submit" value="resendsms" class="btn btn-primary">ارسال
                                    پیامک لینک
                                </button>
                            </form>
                        @endif
                    @endif

                </div>

                <!--==== / Edit Area =====-->

            </div>

        </div>
        <div id="step2" class="card nested">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                تنظیمات نهایی
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-md-4">نوع صورت حساب</label>
                    <div class="col-sm-8 col-md-7">
                        <select name="InvoiceType" id="RentType" class=" form-control tocheck" style="width: 100%">
                            <option value="0">{{ __('--select--') }}</option>
                            <option value="1">ارسال پیامک به مشتری</option>
                        </select>
                    </div>

                </div>
                <button type="button" onclick="previus()" class="btn btn-primary">مرحله قبل
                </button>

                <button type="submit" name="submit" value="editInvoice"
                    class="btn btn-primary ">{{ __('save') }}</button>

            </div>
        </div>
    </form>

    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    @include('Layouts.SearchUserInput_Js')
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
    <script>
        function NumberToText(ItemElement, Price) {
            output = Price.toString().toPersianLetter() + ' تومان ';
            document.getElementById(ItemElement + '_text').innerHTML = output;
        }

        function BeyaneToText() {
            Price = $('#BeyanePrice').val();
            output = Price.toString().toPersianLetter() + ' تومان ';
            document.getElementById('BeyanePrice_text').innerHTML = output;
        }
    </script>


    <script>
        $('#SelectMeta_1').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta').addClass('nested');
            $('.DeviceMeta_1_' + valueSelected).removeClass('nested');
        });
        $('#SelectMeta_2').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta1').addClass('nested');
            $('.DeviceMeta_2_' + valueSelected).removeClass('nested');
        });
        $('#SelectMeta_3').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta2').addClass('nested');
            $('.DeviceMeta_3_' + valueSelected).removeClass('nested');
        });
        $('#SelectMeta_4').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta3').addClass('nested');
            $('.DeviceMeta_4_' + valueSelected).removeClass('nested');
        });
    </script>
    <script>
        function totalcalc() {
            var TotalPrice = 0;
            var MaxCounter = <?php echo $Counter; ?>;
            for (let i = 1; i < MaxCounter; i++) {
                n = i.toString();
                TotalPrice += parseInt($("#Total_" + n).val(), 10);
            }
            $("#kolPrice").val(TotalPrice);
            document.getElementById('kolPrice_text').innerHTML = TotalPrice.toString().toPersianLetter() + ' تومان ';
            document.getElementById('kolPrice_number').innerHTML = TotalPrice.toLocaleString();
            var ProvidreTotalPrice = 0;
            for (let i = 1; i < MaxCounter; i++) {
                n = i.toString();
                ProvidreTotalPrice += parseInt($("#ProviderPrice_" + n).val(), 10);
            }
            $("#ProvierPrice").val(ProvidreTotalPrice);
            document.getElementById('ProvierPrice_text').innerHTML = ProvidreTotalPrice.toString().toPersianLetter() +
                ' تومان ';
            document.getElementById('ProvierPrice_number').innerHTML = ProvidreTotalPrice.toLocaleString();

            var daramad = TotalPrice - ProvidreTotalPrice;
            if (daramad < 0) {
                $("#daramad_div").removeClass('is-valid');
                $("#daramad_div").addClass('is-invalid');
            } else {
                $("#daramad_div").removeClass('is-invalid');
                $("#daramad_div").addClass('is-valid');
            }
            $("#DaramadPrice").val(daramad);
            document.getElementById('DaramadPrice_text').innerHTML = daramad.toString().toPersianLetter() + ' تومان ';
            document.getElementById('DaramadPrice_number').innerHTML = daramad.toLocaleString();


        }

        function PriceChange(changeobject) {
            var RentPrice = parseInt($("#RentPrice_" + changeobject).val(), 10);
            var Discount = parseInt($("#Discount_" + changeobject).val(), 10);
            NumberToText('RentPrice_' + changeobject, RentPrice);
            NumberToText('DiscountPrice_' + changeobject, Discount);
            TotallPrice = RentPrice - Discount;
            NumberToText('Total_' + changeobject, TotallPrice);
            document.getElementById("Total_" + changeobject + '_number').innerHTML = TotallPrice.toLocaleString() +
                ' ریال ';
            $("#Total_" + changeobject).val(TotallPrice);
            totalcalc();
        }

        function DiscountChange(changeobject) {
            var RentPrice = parseInt($("#RentPrice_" + changeobject).val(), 10);
            var Discount = parseInt($("#Discount_" + changeobject).val(), 10);
            NumberToText('RentPrice_' + changeobject, RentPrice);
            NumberToText('DiscountPrice_' + changeobject, Discount);
            TotallPrice = RentPrice - Discount;
            NumberToText('Total_' + changeobject, TotallPrice);
            $("#Total_" + changeobject).val(TotallPrice);
            document.getElementById("Total_" + changeobject + '_number').innerHTML = TotallPrice.toLocaleString() +
                ' ریال ';
            totalcalc();
        }

        function ProviderChange(changeobject) {
            var ProviderPrice = parseInt($("#ProviderPrice_" + changeobject).val(), 10);
            NumberToText('ProviderPrice_' + changeobject, ProviderPrice);
            totalcalc();
        }

        function previus() {
            $("#step2").addClass('nested');
            $("#step1").removeClass('nested');
        }

        function validation() {
            $('.tocheck').removeClass('is-valid');
            $('.tocheck').removeClass('is-invalid');
            var valid = true;
            if ($('#Note').val() == '' || $('#Note').val() == null) {
                $('#Note').addClass('is-invalid');
                $("#Note").focus();
                valid = false;
            } else {
                $('#Note').addClass('is-valid');
            }
            if ($('#startdate').val() == '' || $('#startdate').val() == null) {
                $('#startdate').addClass('is-invalid');
                $("#startdate").focus();
                valid = false;
            } else {
                $('#startdate').addClass('is-valid');
            }
            if ($('#EndDate').val() == '' || $('#EndDate').val() == null) {
                $('#EndDate').addClass('is-invalid');
                $("#EndDate").focus();
                valid = false;
            } else {
                $('#EndDate').addClass('is-valid');
            }
            if ($('#Note').val() == '' || $('#Note').val() == null) {
                $('#Note').addClass('is-invalid');
                $("#Note").focus();
                valid = false;
            } else {
                $('#Note').addClass('is-valid');
            }
            var n = '';
            var MaxCounter = <?php echo $Counter; ?>;
            for (let i = 1; i < MaxCounter; i++) {
                n = i.toString();
                if ($('#Total_' + n).val() != '0') {
                    if ($('#Provider_' + n).val() == 0) {
                        $('#Provider_' + n).addClass('is-invalid');
                        $('#Provider_' + n).focus();
                        valid = false;
                    } else {
                        $('#Provider_' + n).addClass('is-valid');
                    }
                    if ($('#SelectMeta_' + n).val() == 0) {
                        $('#SelectMeta_' + n).addClass('is-invalid');
                        $('#SelectMeta_' + n).focus();
                        valid = false;
                    } else {
                        $('#SelectMeta_' + n).addClass('is-valid');
                    }
                    if ($('#SelectType' + n).val() == 0) {
                        $('#SelectType' + n).addClass('is-invalid');
                        $('#SelectType' + n).focus();
                        valid = false;
                    } else {
                        $('#SelectType' + n).addClass('is-valid');
                    }
                    if ($('#ProviderPrice_' + n).val() == '0' || $('#ProviderPrice_' + n).val() == null) {
                        if ($('#ProviderPrice_' + n).val() == 0) {
                            $('#ProviderPrice_' + n).addClass('is-invalid');
                            $('#ProviderPrice_' + n).focus();
                            valid = false;
                        } else {
                            $('#ProviderPrice_' + n).addClass('is-valid');
                        }
                    }

                }

            }
            if (valid) {
                $("#step1").addClass('nested');
                $("#step2").removeClass('nested');
            } else {
                alert('لطفا اطلاعات وارد شده را بررسی فرمایید!');
            }
        }
    </script>
@endsection
