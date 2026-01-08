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
    <div id="app">
        <Patdashboard></Patdashboard>
    </div>
    <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
    <input type="text" class="nested" id="UserName_page" value=" {{ $PatInfo->UserName }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"> <i class=" header-icon i-Bar-Chart-4"></i> ثبت شیفت برای :
                            {{ $PatInfo->Name }}
                            {{ $PatInfo->Family }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="account-tab" data-toggle="tab"
                                    href="#account" role="tab" aria-controls="PatInfo" aria-selected="true"
                                    data-original-title="" title="">{{ __('Pat Info') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="permission-tabs" data-toggle="tab"
                                    href="#Patpersonel" role="tab" aria-controls="Patpersonel" aria-selected="false"
                                    data-original-title="" title="">{{ __('Pat personel') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="permission-tabs" data-toggle="tab"
                                    href="#PatShifts" role="tab" aria-controls="PatShifts" aria-selected="false"
                                    data-original-title="" title="">{{ __('Pat Shifts') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="permission-tabs" data-toggle="tab"
                                    href="#permission" role="tab" aria-controls="permission" aria-selected="false"
                                    data-original-title="" title="">{{ __('Assign shift') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="account" role="tabpanel"
                                aria-labelledby="account-tab">
                                <form class="needs-validation user-add">
                                    <h4>{{ __('Pat Info') }}</h4>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Name') }} -
                                            {{ __('Family') }} </label>
                                        <label class="col-xl-8 col-md-7"> {{ $PatInfo->Name }}
                                            {{ $PatInfo->Family }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Mobile No') }}
                                        </label>
                                        <label class="col-xl-8 col-md-7">
                                            {{ $PatInfo->MobileNo }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Email') }}
                                        </label>
                                        <label class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Email }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Phone1') }}
                                        </label>
                                        <label class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Phone1 }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Phone2') }}
                                        </label>
                                        <label class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Phone2 }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Address') }}
                                        </label>
                                        <label class="col-xl-8 col-md-7">
                                            {{ $PatInfo->Address }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Birthday') }}
                                        </label>
                                        <label class="col-xl-8 col-md-7">
                                            {{ $Persian->MyPersianDate($PatInfo->Birthday) }}</label>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('CreateDate') }}
                                        </label>
                                        <label class="col-xl-8 col-md-7">
                                            {{ $Persian->MyPersianDate($PatInfo->CreateDate, true) }}</label>

                                    </div>


                                </form>
                            </div>
                            <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tabs">
                                <form method="post" class="needs-validation user-add">
                                    @csrf
                                    <h4>{{ __('Add new shift') }}</h4>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('service type') }} </label>
                                        <div class="col-xl-8 col-md-7">
                                            <select id="SelectService" name="RespnsType" onchange="select_change()"
                                                class=" form-control serviceselect" style="width: 100%">
                                                @foreach ($RespnsTypes as $RespnsType)
                                                    @if (Auth::user()->Rule == \App\myappenv::role_Accounting)
                                                        @if ($RespnsType->id > \App\myappenv::StackholdersLimitID)
                                                            <option value="{{ $RespnsType->id }}">
                                                                {{ $RespnsType->RespnsTypeName }}</option>
                                                        @endif
                                                    @else
                                                        @if ($RespnsType->id < \App\myappenv::StackholdersLimitID || $RespnsType->id > \App\myappenv::BaseServiceTypeID)
                                                            <option value="{{ $RespnsType->id }}">
                                                                {{ $RespnsType->RespnsTypeName }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class=" col-xl-3 col-md-4">{{ __('Personel') }} </label>
                                        @include('Layouts.SearchUserInput', [
                                            'SmartSearch' => true,
                                            'InputName' => 'ResponserID',
                                            'InputPalceholder' => __('Name family or username'),
                                        ])
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Shift start') }} </label>
                                        <div class="input-group clockpicker col-xl-4 col-md-4">
                                            <input type="text" name="StartTime" class="form-control" required
                                                autocomplete="off" value="18:00">

                                        </div>
                                        <input class="form-control col-xl-4 col-md-3" type="text" name="StartDate"
                                            required autocomplete="off"
                                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                            placeholder="{{ __('Date of shift start') }}" />
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('Shift end') }} </label>
                                        <div class="input-group clockpicker col-xl-4 col-md-4">
                                            <input name="EndTime" type="text" class="form-control" autocomplete="off"
                                                required value="18:00">

                                        </div>
                                        <input class="form-control col-xl-4 col-md-3" type="text" name="EndDate"
                                            required autocomplete="off"
                                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                            placeholder="{{ __('Date of shift finish') }}" />

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('notes') }} </label>
                                        <input required class="form-control col-xl-8 col-md-7" type="text" required
                                            name="Note" placeholder="{{ __('notes') }}" />
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">{{ __('stackholders') }} </label>
                                        <div class="table-responsive">
                                            <table class="{{ \App\myappenv::MainTableClass }}" id="dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="selectall"
                                                                onclick="checkboxfunction()" />{{ __('select') }}
                                                        </th>
                                                        <th>{{ __('Username') }}</th>
                                                        <th>{{ __('stackholders') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($stackHolders as $stackHolder)
                                                        <tr>
                                                            <td><input type="checkbox" class="case"
                                                                    id="{{ $stackHolder->ResponserID }}"
                                                                    name="formDoor[][]"
                                                                    value="{{ $stackHolder->ResponserID }},{{ $stackHolder->RespnsTypeName }}">
                                                            </td>
                                                            <td>{{ $stackHolder->ResponserID }}</td>
                                                            <td>{{ $stackHolder->RespnsTypeName }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                    <div id="tashim_div" class="card-body">

                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" name="submit" value="AddnewStaff"
                                            class="btn btn-primary">{{ __('save') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="PatShifts" role="tabpanel" aria-labelledby="permission-tabs">
                                <form method="post" class="needs-validation user-add">
                                    @csrf
                                    <h4>{{ __('Pat personel') }}</h4>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="table-responsive">
                                            <table class="table" id="basic-1" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>کد خدمت</th>
                                                        <th>{{ __('Personel') }}</th>
                                                        <th>{{ __('Date of enter') }}</th>
                                                        <th>{{ __('service type') }}</th>
                                                        <th>{{ __('Shift start') }}</th>
                                                        <th>{{ __('Shift end') }}</th>
                                                        <th>{{ __('notes') }}</th>
                                                        @if (Auth::user()->Role == \App\myappenv::role_admin || Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                                            <th>{{ __('Actions') }}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($WorkersListInfo as $Pat)
                                                        <tr>
                                                            <td>{{$Pat->id}}</td>
                                                            <td>{{ $Pat->Name }} {{ $Pat->Family }}</td>
                                                            <td>{{ $Persian->MyPersianDate($Pat->CreateDate, true) }}</td>
                                                            <td>{{ $Pat->RespnsTypeName }}</td>
                                                            <td>

                                                                {{ $Persian->MyPersianDate($Pat->StartRespns, true) }}
                                                            </td>
                                                            <td>

                                                                {{ $Persian->MyPersianDate($Pat->EndRespns, true) }}
                                                            </td>
                                                            <td>{{ $Pat->Note }}</td>
                                                            @if (Auth::user()->Role == \App\myappenv::role_admin || Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                                                @if ($Pat->datedif > 0)
                                                                    @if ($Pat->confirmcredits == 0)
                                                                        <td>
                                                                            <button class="btn btn-danger" type="submit"
                                                                                name="delete_shift"
                                                                                value="{{ $Pat->id }}">
                                                                                {{ __('delete') }}
                                                                            </button>
                                                                        </td>
                                                                    @else
                                                                        <td>{{ __('Confirmed transaction') }}</td>
                                                                    @endif
                                                                @else
                                                                    <td>{{ __('Shift can not delete') }}</td>
                                                                @endif
                                                            @endif

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="Patpersonel" role="tabpanel"
                                aria-labelledby="permission-tabs">
                                <form class="needs-validation user-add">
                                    <h4>{{ __('Personels') }}</h4>
                                    <hr>
                                    <div class="permission-block" style="text-align: right">
                                        @if ($WorkersInfo == [])
                                            <div class="alert alert-warning" role="alert">
                                                {{ __('no data') }}
                                            </div>
                                        @endif
                                        @foreach ($WorkersInfo as $WorkerInfo)
                                            @if ($WorkerInfo->rowcount == 1)
                                                <p>
                                                    {{ $WorkerInfo->Name }} {{ $WorkerInfo->Family }}
                                                    - {{ $WorkerInfo->RespnsTypeName }}
                                                </p>
                                            @else
                                                <p>
                                                    {{ $WorkerInfo->Name }} {{ $WorkerInfo->Family }}
                                                    - {{ __('Services package') }}
                                                </p>
                                            @endif
                                        @endforeach
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
        function select_change() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'get_service_tashim',
                    service_id: $('#SelectService').val()
                },

                function(data, status) {
                    $('#tashim_div').html('');
                    if (data['result']) {
                        main_data = data['data'];
                        output = `<div class="card-title">انتخاب تسهیم</div>
                                        `;

                        $.each(main_data, function(index, value) {
                            tashim_id = value['id'];
                            tashim_name = value['name'];
                            output += `<label cltashim_idass="radio radio-primary">
                                            <input type="radio" checked name="tashim" value="` + tashim_id + `" formcontrolname="radio">
                                            <span>` + tashim_name + `</span>
                                            <span class="checkmark"></span>
                                        </label> <br>`;
                        });
                        $('#tashim_div').html(output);


                    } else {
                        $('#tashim_div').html('');
                    }
                });
        }
    </script>
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'PatShiftManage';
    </script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
    <script>
        $(document).ready(function() {
            $('.serviceselect').select2();
        });
    </script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/bootstrap-clockpicker.min.js"></script>
    <script type="text/javascript">
        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'ثبت'
        });
    </script>
@endsection
