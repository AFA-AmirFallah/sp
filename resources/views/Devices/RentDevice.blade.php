@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('page-header-left')
    <h3>{{ __('Assign shift') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')

    @if (Auth::user()->Role == \App\myappenv::role_customer)
        <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
        <div id="app">
            <patascustomer></patascustomer>
        </div>
    @else
        <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ $PatInfo->UserName }}">
        <div id="app">
            <Patdashboard></Patdashboard>
        </div>
    @endif

    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modal_title" class="modal-title" id="exampleModalCenterTitle">قرارداد اجاره تجهیزات</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div id="modalbase">

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Fluorescent"></i>اجاره تجهیزات: {{ $PatInfo->Name }}
                            {{ $PatInfo->Family }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="account-tab" data-toggle="tab"
                                    href="#account" role="tab" aria-controls="PatInfo" aria-selected="true"
                                    data-original-title="" title="">{{ __('Pat Info') }}</a>
                            </li>

                            <li class="nav-item"><a class="nav-link" id="permission-tabs" data-toggle="tab"
                                    href="#PatShifts" role="tab" aria-controls="PatShifts" aria-selected="false"
                                    data-original-title="" title="">{{ __('Devices contract list') }}</a>
                            </li>
                            @if (\Illuminate\Support\Facades\Auth::user()->branch == null)
                                <li class="nav-item"><a class="nav-link" id="permission-tabs" data-toggle="tab"
                                        href="#permission" role="tab" aria-controls="permission" aria-selected="false"
                                        data-original-title="" title="">{{ __('Add device contract') }}</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="account" role="tabpanel"
                                aria-labelledby="account-tab">
                                <form class="needs-validation user-add">
                                    <h4>{{ __('Pat Info') }}</h4>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">{{ __('Name') }} -
                                            {{ __('Family') }} </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7"> {{ $PatInfo->Name }}
                                            {{ $PatInfo->Family }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">{{ __('Mobile No') }}
                                        </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7">
                                            {{ $PatInfo->MobileNo }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">{{ __('Email') }}
                                        </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Email }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">{{ __('Phone1') }}
                                        </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Phone1 }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">{{ __('Phone2') }}
                                        </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Phone2 }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">{{ __('Address') }}
                                        </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Address }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">{{ __('Birthday') }}
                                        </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7">
                                            {{ $Persian->MyPersianDate($PatInfo->Birthday) }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">تاریخ رجیستر
                                        </label>
                                        <label for="validationCustom0" class="col-xl-8 col-md-7">
                                            {{ $Persian->MyPersianDate($PatInfo->CreateDate) }}</label>

                                    </div>


                                </form>
                            </div>
                            @if (\Illuminate\Support\Facades\Auth::user()->branch == null)
                                <div class="tab-pane fade" id="permission" role="tabpanel"
                                    aria-labelledby="permission-tabs">
                                    <form method="post" class="needs-validation user-add">
                                        @csrf
                                        <h4>{{ __('Add device contract') }}</h4>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4">{{ __('Contract type') }} </label>
                                            <div class="col-xl-8 col-md-7">
                                                <select name="RespnsType" class=" form-control" style="width: 100%">
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($DeviceContractTypes as $DeviceContractType)
                                                        <option id="{{ $DeviceContractType->ID }}"
                                                            value="{{ $DeviceContractType->ID }}">
                                                            {{ $DeviceContractType->TypeName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4">{{ __('Date of start contract') }} </label>
                                            <input class="form-control col-xl-4 col-md-3" type="text" name="StartDate"
                                                autocomplete="off"
                                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                placeholder="{{ __('Date of start contract') }}" />
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4">{{ __('Date of end contract') }} </label>
                                            <input class="form-control col-xl-4 col-md-3" type="text" name="EndDate"
                                                autocomplete="off"
                                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                placeholder="{{ __('Date of end contract') }}" />
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4">{{ __('notes') }} </label>
                                            <input class="form-control col-xl-8 col-md-7" type="text" name="Note"
                                                placeholder="{{ __('notes') }}" />
                                        </div>
                                        <div class="form-group row">
                                            <div class="table-responsive">
                                                <table class="{{ \App\myappenv::MainTableClass }}"
                                                    id="dataTables-example">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>{{ __('Device model') }}</th>
                                                            <th>{{ __('Rent price') }}</th>
                                                            <th>{{ __('Discount') }}</th>
                                                            <th>{{ __('Pay price') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th><select id="SelectMeta" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceMetas as $DeviceMeta)
                                                                        <option value="{{ $DeviceMeta->ID }}">
                                                                            {{ $DeviceMeta->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th><select id="SelectType" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceTypes as $DeviceType)
                                                                        <option
                                                                            class="DeviceMeta_{{ $DeviceType->MetaID }} nested DeviceMeta"
                                                                            value="{{ $DeviceType->ID }}">
                                                                            {{ $DeviceType->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th>{{ __('Rent price') }}</th>
                                                            <th>{{ __('Rent price') }}</th>
                                                        </tr>

                                                        <tr>
                                                            <th><select id="SelectMeta1" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceMetas as $DeviceMeta)
                                                                        <option value="{{ $DeviceMeta->ID }}">
                                                                            {{ $DeviceMeta->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th><select id="SelectType1" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceTypes as $DeviceType)
                                                                        <option
                                                                            class="DeviceMeta1_{{ $DeviceType->MetaID }} nested DeviceMeta1"
                                                                            value="{{ $DeviceType->ID }}">
                                                                            {{ $DeviceType->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th>{{ __('Rent price') }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th><select id="SelectMeta2" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceMetas as $DeviceMeta)
                                                                        <option value="{{ $DeviceMeta->ID }}">
                                                                            {{ $DeviceMeta->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th><select id="SelectType2" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceTypes as $DeviceType)
                                                                        <option
                                                                            class="DeviceMeta2_{{ $DeviceType->MetaID }} nested DeviceMeta2"
                                                                            value="{{ $DeviceType->ID }}">
                                                                            {{ $DeviceType->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th>{{ __('Rent price') }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th><select id="SelectMeta3" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceMetas as $DeviceMeta)
                                                                        <option value="{{ $DeviceMeta->ID }}">
                                                                            {{ $DeviceMeta->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th><select id="SelectType3" name="RespnsType"
                                                                    class=" form-control " style="width: 100%">
                                                                    <option value="0">{{ __('--select--') }}</option>
                                                                    @foreach ($DeviceTypes as $DeviceType)
                                                                        <option
                                                                            class="DeviceMeta3_{{ $DeviceType->MetaID }} nested DeviceMeta3"
                                                                            value="{{ $DeviceType->ID }}">
                                                                            {{ $DeviceType->DeviceName }}</option>
                                                                    @endforeach
                                                                </select></th>
                                                            <th>{{ __('Rent price') }}</th>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" name="submit" value="AddnewStaff"
                                                class="btn btn-primary">{{ __('save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <div class="tab-pane fade" id="PatShifts" role="tabpanel" aria-labelledby="permission-tabs">
                                <form method="post" class="needs-validation user-add">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="table-responsive">
                                            <table class="table" id="basic-1" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Contract id') }}</th>
                                                        <th>{{ __('Date of start contract') }}</th>
                                                        <th>{{ __('Date of end contract') }}</th>
                                                        <th>مبلغ</th>
                                                        <th>{{ __('Status') }}</th>
                                                        <th>{{ __('notes') }}</th>
                                                        @if (Auth::user()->Role == \App\myappenv::role_admin || Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                                            <th>{{ __('Actions') }}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($DeviceContracts as $DeviceContract)
                                                        <tr>
                                                            <td>{{ $DeviceContract->ContractID }}</td>
                                                            <td>{{ $Persian->MyPersianDate($DeviceContract->RentDate) }}
                                                            </td>
                                                            <td>{{ $Persian->MyPersianDate($DeviceContract->ExpireDate) }}
                                                            </td>
                                                            <td>{{ number_format($DeviceContract->TotalPrice) }} </td>
                                                            @switch($DeviceContract->Status)
                                                                @case(0)
                                                                    <td>حذف شده</td>
                                                                @break

                                                                @case(1)
                                                                    <td>در انتظار پرداخت</td>
                                                                @break

                                                                @case(2)
                                                                    <td>در انتظار پرداخت</td>
                                                                @break

                                                                @case(100)
                                                                    <td>پرداخت شده</td>
                                                                @break

                                                                @default
                                                            @endswitch
                                                            <td>{{ $DeviceContract->Note }}</td>
                                                            @if (Auth::user()->Role == \App\myappenv::role_admin || Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                                                <td style="display: inline-flex">
                                                                    @if ($DeviceContract->Status > 0 && $DeviceContract->Status != 100)
                                                                        <button type="submit" class="btn btn-success"
                                                                            style="margin:auto;display:block"
                                                                            name="payment"
                                                                            value="{{ $DeviceContract->ContractID }}">
                                                                            پرداخت
                                                                        </button>
                                                                        <button type="submit" class="btn btn-danger"
                                                                            style="margin:auto;display:block"
                                                                            name="delete"
                                                                            value="{{ $DeviceContract->ContractID }}">
                                                                            {{ __('delete') }}
                                                                        </button>
                                                                        <button type="button" data-toggle="modal"
                                                                            onclick="load_contract({{ $DeviceContract->ContractID }})"
                                                                            data-target=".bd-example-modal-lg"
                                                                            class="btn btn-primary btn-md m-1">
                                                                            نمایش جزئیات
                                                                        </button>
                                                                    @elseif ($DeviceContract->Status == 0)
                                                                        <button type="submit" class="btn btn-success"
                                                                            style="margin:auto;display:block"
                                                                            name="recover"
                                                                            value="{{ $DeviceContract->ContractID }}">
                                                                            بازگردانی
                                                                        </button>
                                                                        <button type="submit" class="btn btn-danger"
                                                                            style="margin:auto;display:block"
                                                                            name="delete_permanent"
                                                                            value="{{ $DeviceContract->ContractID }}">
                                                                            حذف کامل
                                                                        </button>
                                                                        <button type="button" data-toggle="modal"
                                                                            onclick="load_contract({{ $DeviceContract->ContractID }})"
                                                                            data-target=".bd-example-modal-lg"
                                                                            class="btn btn-primary btn-md m-1">
                                                                            نمایش جزئیات
                                                                        </button>
                                                                    @else
                                                                        <p> <button type="button" data-toggle="modal"
                                                                                onclick="load_contract({{ $DeviceContract->ContractID }})"
                                                                                data-target=".bd-example-modal-lg"
                                                                                class="btn btn-primary btn-md m-1">
                                                                                نمایش جزئیات
                                                                            </button>
                                                                        </p>
                                                                    @endif

                                                                </td>
                                                            @endif

                                                        </tr>
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
        </div>
    </div>

@endsection
@section('page-js')
    @include('Layouts.SearchUserInput_Js')
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'RentDevice';
    </script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
    <script>
        function load_contract($contract_id) {
            $('#modal_title').html('قرارداد اجاره شماره: ' + $contract_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'load_rent_contract',
                    contract_id: $contract_id,
                },
                function(data, status) {
                    $('#modalbase').html(data);
                });
        }
        $('#SelectMeta').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta').addClass('nested');
            $('.DeviceMeta_' + valueSelected).removeClass('nested');
        });
        $('#SelectMeta1').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta1').addClass('nested');
            $('.DeviceMeta1_' + valueSelected).removeClass('nested');
        });
        $('#SelectMeta2').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta2').addClass('nested');
            $('.DeviceMeta2_' + valueSelected).removeClass('nested');
        });
        $('#SelectMeta3').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.DeviceMeta3').addClass('nested');
            $('.DeviceMeta3_' + valueSelected).removeClass('nested');
        });
    </script>
@endsection
