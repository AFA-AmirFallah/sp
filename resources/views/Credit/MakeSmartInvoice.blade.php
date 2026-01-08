@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div id="app">
        <Patdashboard></Patdashboard>
    </div>

    <form method="post" class="needs-validation user-add">
        @csrf
        <input class="nested" id="row_count" value="1">
        <div id="step1" class="card">
            <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
            <input type="text" class="nested" id="UserName_page" value=" {{ $PatInfo->UserName }}">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80 text-white">
                <h5 class="text-white"><i class=" header-icon i-Diploma"></i> صورت حساب هوشمند: {{ $PatInfo->Name }}
                    {{ $PatInfo->Family }}</h5>
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4">{{ __('Contract type') }}</label>
                    <div class="col-xl-8 col-md-7">
                        <select name="RentType" id="RentType" class=" form-control tocheck" style="width: 100%">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($DeviceContractTypes as $DeviceContractType)
                                <option id="{{ $DeviceContractType->ID }}" value="{{ $DeviceContractType->ID }}">
                                    {{ $DeviceContractType->TypeName }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4">{{ __('Date of start contract') }} </label>
                    <input id="startdate" class="form-control col-xl-4 col-md-3 tocheck" type="text" name="StartDate"
                        autocomplete="off"
                        onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                        placeholder="{{ __('Date of start contract') }}" />
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4">{{ __('Date of end contract') }} </label>
                    <input class="form-control col-xl-4 col-md-3 tocheck" type="text" name="EndDate" id="EndDate"
                        autocomplete="off"
                        onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                        placeholder="{{ __('Date of end contract') }}" />
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4 tocheck">{{ __('notes') }} </label>
                    <input class="form-control col-xl-8 col-md-7" type="text" name="Note" id="Note"
                        placeholder="{{ __('notes') }}" />
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4 tocheck">مبلغ کل</label>
                    <input class="form-control col-xl-8 col-md-7 nested" type="text" name="TotalPriceEnd" id="kolPrice"
                        placeholder="مبلغ کل" />
                    <div class="col-xl-4 col-md-4" id="kolPrice_text"></div>
                    <div class="col-xl-4 col-md-3" id="kolPrice_number"></div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4 tocheck">مبلغ تامین کننده</label>
                    <input class="nested col-xl-8 col-md-7" type="text" name="OwnerPrice" id="ProvierPrice"
                        placeholder="مبلغ تامین کننده" />
                    <div class="col-xl-4 col-md-4" id="ProvierPrice_text"></div>
                    <div class="col-xl-4 col-md-3" id="ProvierPrice_number"></div>

                </div>
                <div class="form-group row" id="daramad_div">
                    <label class="col-xl-3 col-md-4 tocheck">درآمد مرکز</label>
                    <input class="nested col-xl-8 col-md-7" type="text" id="DaramadPrice" placeholder="درآمد مرکز" />
                    <div class="col-xl-4 col-md-4" id="DaramadPrice_text"></div>
                    <div class="col-xl-4 col-md-3" id="DaramadPrice_number"></div>

                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4 tocheck">مبلغ بیعانه</label>
                    <input class="form-control col-xl-8 col-md-7" type="text" name="BeyanePrice" id="BeyanePrice"
                        value="0" onkeyup="BeyaneToText()" placeholder="مبلغ بیعانه" />
                    <label class="col-xl-3 col-md-4 tocheck"></label>
                    <div class="col-xl-8 col-md-7" id="BeyanePrice_text"></div>

                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4 tocheck">ضریب </label>
                    <input class="form-control col-xl-8 col-md-7" disabled type="number" name="multiple_days"
                        id="multiple_days" onkeyup="" value="1" placeholder=" ضریب" />
                    <label class="col-xl-3 col-md-4 tocheck"></label>
                    <div class="col-xl-8 col-md-7" id="BeyanePrice_text"></div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-md-4 tocheck">تسهیم</label>
                    <select name="tashim" class="form-control col-xl-8 col-md-7">
                        @foreach ($TashimSrc as $TashimItem)
                            <option value="{{ $TashimItem->id }}">
                                {{ $TashimItem->Name }}</option>
                        @endforeach
                    </select>
                    <label class="col-xl-3 col-md-4 tocheck"></label>
                    <div class="col-xl-8 col-md-7" id="BeyanePrice_text"></div>
                </div>
                <div class="form-group row">
                    <div class="table-responsive">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>{{ __('Type of device') }}</th>
                                    <th>{{ __('Device model') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Pay price') }}</th>
                                </tr>
                            </thead>
                            <tbody id="dataTables-main">
                                <tr>
                                    <th rowspan="3">شماره 1
                                        <br>
                                        <button id="btn_add_row1" onclick="add_new_row('2')" class="btn btn-success"
                                            type="button">افزودن</button>
                                    </th>
                                    <th><select id="SelectMeta_1" name="DeviceMeta[]" class="form-control tocheck"
                                            style="width: 100%">
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach ($DeviceMetas as $DeviceMeta)
                                                <option value="{{ $DeviceMeta->ID }}">{{ $DeviceMeta->DeviceName }}
                                                </option>
                                            @endforeach
                                        </select></th>
                                    <th><select id="SelectType1" name="DeviceType[]" class="form-control"
                                            style="width: 100%">
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach ($DeviceTypes as $DeviceType)
                                                <option class="DeviceMeta_1_{{ $DeviceType->MetaID }} nested DeviceMeta"
                                                    value="{{ $DeviceType->ID }}">{{ $DeviceType->DeviceName }}
                                                </option>
                                            @endforeach
                                        </select></th>
                                    <th><input class="form-control tocheck" type="number" id="RentPrice_1"
                                            name="RentPrice[]" autocomplete="off" value="0"
                                            onkeyup="PriceChange('1')">
                                        <div id="RentPrice_1_text"></div>
                                    </th>
                                    <th><input class="form-control" type="number" name="DiscountPrice[]"
                                            id="Discount_1" onkeyup="DiscountChange('1')" autocomplete="off"
                                            value="0">
                                        <div id="DiscountPrice_1_text"></div>

                                    </th>
                                    <th><input class="form-control nested" type="number" name="Total[]"
                                            autocomplete="off" id="Total_1" value="0">
                                        <div id="Total_1_number"></div>
                                        <div id="Total_1_text"></div>

                                    </th>
                                </tr>
                                <tr>
                                    <th>تامین کننده
                                        <br>
                                        و
                                        <br>
                                        مورد اجاره
                                    </th>
                                    <th colspan="2"><select id="Provider_1" name="Provider[]"
                                            onchange="feach_rent_product('1')" class=" form-control tocheck"
                                            style="width: 100%">
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach ($Providers as $Provider)
                                                <option value="{{ $Provider->id }}">{{ $Provider->Name }}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <select id="rent_products_1" name="pwid[]" onchange="get_rent_product_data('1')"
                                            class=" form-control tocheck" style="width: 100%">
                                            <option value="0">{{ __('--select--') }}</option>

                                        </select>
                                    </th>
                                    <th>مبلغ تامین کننده</th>
                                    <th>
                                        <input class="form-control tocheck" type="number" name="ProviderPrice[]"
                                            autocomplete="off" onkeyup="ProviderChange('1')" value="0"
                                            id="ProviderPrice_1" onkeyup="">
                                        <div id="ProviderPrice_1_text"></div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>توضیحات</th>
                                    <td colspan="4">
                                        <input class="form-control" name="ItemNote[]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="pull-right">
                    <button type="button" onclick="validation()" class="btn btn-primary">مرحله بعد
                    </button>
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
                    <label class="col-xl-3 col-md-4">نوع صورت حساب</label>
                    <div class="col-xl-8 col-md-7">
                        <select name="InvoiceType" id="RentType" class=" form-control tocheck" style="width: 100%">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach (\App\myappenv::SmartInvoiceStatus as $SmartInvoiceStatus)
                                <option value="{{ $SmartInvoiceStatus[0] }}">{{ $SmartInvoiceStatus[1] }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <button type="button" onclick="previus()" class="btn btn-primary">مرحله قبل
                </button>

                <button type="submit" name="submit" value="AddnewStaff"
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
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'MakeSmartInvoice';
    </script>
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
        function change_select_meta($Select_id) {
            var valueSelected = $('#SelectMeta_' + $Select_id).val();
            $('.DeviceMeta' + $Select_id).addClass('nested');
            $('.DeviceMeta_' + $Select_id + '_' + valueSelected).removeClass('nested');

        }
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
            var rows = $('#row_count').val();
            rows++;
            for (let i = 1; i < rows; i++) {
                n = i.toString();
                TotalPrice += parseInt($("#Total_" + n).val(), 10);
            }
            $("#kolPrice").val(TotalPrice);
            document.getElementById('kolPrice_text').innerHTML = TotalPrice.toString().toPersianLetter() + ' تومان ';
            document.getElementById('kolPrice_number').innerHTML = TotalPrice.toLocaleString();
            var ProvidreTotalPrice = 0;
            for (let i = 1; i < rows; i++) {
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
            if ($('#RentType').val() == 0) {
                $('#RentType').addClass('is-invalid');
                $("#RentType").focus();
                valid = false;
            } else {
                $('#RentType').addClass('is-valid');
            }

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
            var rows = $('#row_count').val();
            rows++;
            for (let i = 1; i < rows; i++) {
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
    <script>
        function get_rent_product_data(src_caller) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'get_rent_device_info',
                    selected_product: $('#rent_products_' + src_caller).val(),
                    WarehouseID: $('#Provider_' + src_caller).val(),

                },
                function(data, status) {
                    $('#RentPrice_' + src_caller).val(data.Discount);
                    $('#Discount_' + src_caller).val(data.Discount - data.RentPrice);
                    $('#ProviderPrice_' + src_caller).val(data.ProviderPrice);
                    PriceChange(src_caller);
                    DiscountChange(src_caller);
                    ProviderChange(src_caller);
                });

        }

        function add_new_row($row_id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'add_new_row',
                    row_id: $row_id,

                },
                function(data, status) {
                    $('#row_count').val($row_id);
                    row_number = $row_id - 1;
                    $('#btn_add_row' + row_number.toString()).addClass('nested');
                    $('#dataTables-main').append(data);
                });

        }

        function feach_rent_product(src_caller) {
            $SelectType1 = $('#SelectType' + src_caller).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'load_rent_device',
                    SelectType1: $SelectType1,

                },
                function(data, status) {
                    $('#rent_products_' + src_caller).html('');
                    $('#rent_products_' + src_caller).append($('<option>', {
                        value: 0,
                        text: 'انتخاب مورد اجاره'
                    }));
                    $.each(data, function(i, item) {
                        $('#rent_products_' + src_caller).append($('<option>', {
                            value: item.id,
                            text: item.name
                        }));
                    });

                });

        }
    </script>
@endsection
