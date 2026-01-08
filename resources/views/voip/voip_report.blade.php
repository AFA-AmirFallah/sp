@php
    $Persian = new App\Functions\persian();
    $maxfeild = 0;
@endphp
@extends('Layouts.MainPage')
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('page-header-left')
    <h3>گزارش ویپ
    </h3>
@endsection
@section('MainCountent')
    <div class="ul-card-list__modal">
        <div class="modal fade set_responsible" id="add_response_modal" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 id="modal_header">ارجاع تماس</h6>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div style="display: block" class="row ">
                                <!-- فیلد توضیحات گزارش -->
                                <div class="mb-3">
                                    <table id="ul-contact-list" class="display table " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>مشخصه</th>
                                                <th>مقدار</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ارجاع به</td>
                                                <td><select class="form-control" name="" id="responsible">
                                                        @foreach ($operator_src as $operator)
                                                            <option value="{{ $operator->UserName }}">
                                                                {{ $operator->Name }} {{ $operator->Family }}
                                                            </option>
                                                        @endforeach
                                                    </select> </td>
                                            </tr>

                                            <tr>
                                                <td>گزارش</td>
                                                <td>
                                                    <textarea class="form-control" rows="5" id="report_text_res"></textarea>
                                                    <div id="record_history_res">

                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- دکمه ارسال -->
                                <button type="button" onclick="do_add_responsible()"
                                    class="btn btn-primary w-100">ارجاع</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ul-card-list__modal">
        <div class="modal fade add-user-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 id="modal_header">افزودن کاربر</h6>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div style="display: block" class="row ">
                                <!-- فیلد توضیحات گزارش -->
                                <div class="mb-3">
                                    <table id="ul-contact-list" class="display table " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>مشخصه</th>
                                                <th>مقدار</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>جنسیت</td>
                                                <td><select class="form-control" name="" id="sex">
                                                        <option value="M">آقا</option>
                                                        <option value="F">خانم</option>
                                                    </select> </td>
                                            </tr>
                                            <tr>
                                                <td>نام</td>
                                                <td><input type="text" class="form-control" id="name"></td>
                                            </tr>
                                            <tr>
                                                <td>فامیل</td>
                                                <td><input type="text" class="form-control" id="family"></td>
                                            </tr>
                                            <tr>
                                                <td>شماره موبایل</td>
                                                <td><input type="text" class="form-control" id="mobile_no"></td>
                                            </tr>
                                            <tr>
                                                <td>شاخص</td>
                                                <td><select class="form-control" name="" id="user_cat">
                                                        @foreach ($Tags as $Tag)
                                                            <option value="{{ $Tag->UID }}">
                                                                {{ $Tag->Name }}
                                                            </option>
                                                        @endforeach
                                                    </select> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- دکمه ارسال -->
                                <button type="button" onclick="save_user()" class="btn btn-primary w-100">ثبت
                                    کاربر</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 id="modal_header"></h6>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div style="display: block" class="row ">
                                <!-- فیلد توضیحات گزارش -->
                                <div class="mb-3">
                                    <label for="reportDescription" class="form-label">توضیحات گزارش</label>
                                    <textarea class="form-control" id="reportDescription" rows="5" placeholder="توضیحات گزارش خود را وارد کنید"
                                        required></textarea>
                                </div>
                                <div id="record_history">

                                </div>
                                <!-- دکمه ارسال -->
                                <button type="button" onclick="save_report()" class="btn btn-primary w-100">ثبت
                                    گزارش</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    گزارش سیستم ویپ
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">گزارش در بازه زمانی </label>
                        <input class="form-control col-xl-4 col-md-3" required type="text" name="StartDate"
                            value="{{ $StartDate }}" autocomplete="off"
                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                            placeholder="{{ __('Start report date') }}" />
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">{{ __('End report date') }} </label>
                        <input class="form-control col-xl-4 col-md-3" required type="text" name="EndDate"
                            value="{{ $EndDate }}" autocomplete="off"
                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                            placeholder="{{ __('End report date') }}" />

                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">شماره تماس</label>
                        <input class="form-control col-xl-4 col-md-3" type="text" name="caller_phone"
                            value="{{ $caller_phone ?? '' }}" autocomplete="off"
                            placeholder="شماره تماس گیرنده یا مقصد" />
                    </div>


                    <div class="form-group row col-md-3"></div>
                    <div class="form-group row col-md-6">
                        <button type="submit" class="btn btn-green" name="submit"
                            value="filter">{{ __('Show Table') }}</button>
                    </div>
                    <div class="form-group row col-md-3"></div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="card-body">
            <div class="card-title">تماسها {{ __('from Date:') }}
                {{ $StartDate }} {{ __('to Date:') }}
                {{ $EndDate }}
                <form method="post">
                    @csrf
                    <button type="submit" name="submit" value="sync" class="btn btn-success">همگام سازی</button>
                    <!--
                                                                                                                <button type="submit" name="submit" value="sync_voice" class="btn btn-success"> سازی فایل تماس
                                                                                                                    همگام</button> -->
                </form>
            </div>
            @php
                $Sum = 0;
            @endphp

            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>#</th>
                            <th>تاریخ تماس</th>
                            <th>تماس گیرنده</th>
                            <th>مقصد</th>
                            <th>مدت مکالمه</th>
                            <th>وضعیت</th>
                            <th>محتوا</th>
                            <th>آخرین اقدام</th>
                            <th>ارجاع به</th>
                            <th>عملیات</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cdr_alerts_src as $cdr_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cdr_item->id }}
                                    @if ($cdr_item->todo_flag != 1)
                                        <i id="alert_{{ $cdr_item->id }}" class="i-Information text-danger d-none"
                                            style="font-size: 20px;"></i>
                                    @else
                                        <i id="alert_{{ $cdr_item->id }}" class="i-Information text-danger"
                                            style="font-size: 20px;"></i>
                                    @endif

                                </td>
                                <td>{{ $Persian->MyPersianDate($cdr_item->calldate, true) }}</td>
                                @if ($cdr_item->UserName == null)
                                    <td><a id="caller_name_{{ $cdr_item->id }}"
                                            href="javascript:makeCall_by_phone('{{ $cdr_item->src }}')">
                                            {{ $cdr_item->src }}</a></td>
                                @else
                                    <td>
                                        <a id="caller_name_{{ $cdr_item->id }}"
                                            href="javascript:makeCall_by_phone('{{ $cdr_item->src }}')">
                                            {{ $cdr_item->Name }}
                                            {{ $cdr_item->Family }}
                                            <br>
                                            {{ $cdr_item->src }}
                                        </a>
                                    </td>
                                @endif
                                <td>{{ $cdr_item->dst }}</td>
                                <td>{{ $cdr_item->duration }} </td>
                                <td>{{ $cdr_item->disposition }} </td>
                                <td>{{ $cdr_item->dcontext }} </td>
                                <td>{{ $cdr_item->lastapp }} </td>
                                <td>{{ $cdr_item->rName }} {{ $cdr_item->rFamily }}</td>
                                <td>
                                    @if ($cdr_item->UserName == null)
                                        <button id="add_user_{{ $cdr_item->id }}" type="button" data-toggle="modal"
                                            onclick="add_user({{ $cdr_item->id }},'{{ $cdr_item->src }}')"
                                            data-target=".add-user-modal" class="btn btn-warning btn-sm m-1"><i
                                                class="i-Add-User text-white mr-2"></i>افزودن کاربر
                                        </button>
                                    @endif
                                    <button id="user_operation_{{ $cdr_item->id }}" type="button" data-toggle="modal"
                                        onclick="add_responsible({{ $cdr_item->id }},'{{ $cdr_item->src }}')"
                                        data-target=".set_responsible"
                                        class="btn btn-info btn-sm m-1 {{ $cdr_item->UserName == null ? 'd-none' : '' }} "><i
                                            class="i-Gear text-white mr-2"></i> ارجاع
                                    </button>
                                    @if ($cdr_item->recordingfile != null)
                                        <button onclick="playAudio('{{ $cdr_item->recordingfile }}')"
                                            class="btn btn-sm btn-success"> <i class="i-Video-5"></i> پخش</button>
                                    @endif
                                    @if ($cdr_item->more_data == '')
                                        <button id="addobject_{{ $cdr_item->id }}" type="button" data-toggle="modal"
                                            onclick="set_report_id({{ $cdr_item->id }})"
                                            data-target=".bd-example-modal-lg" class="btn btn-info btn-sm m-1"><i
                                                class="i-Ticket text-white mr-2"></i>گزارش
                                        </button>
                                    @else
                                        <button id="addobject_{{ $cdr_item->id }}" type="button" data-toggle="modal"
                                            onclick="set_report_id({{ $cdr_item->id }})"
                                            data-target=".bd-example-modal-lg" class="btn btn-success btn-sm m-1"><i
                                                class="i-Ticket text-white mr-2"></i>گزارش
                                        </button>
                                    @endif
                                    @if ($cdr_item->todo_flag != 1)
                                        <button id="todo_{{ $cdr_item->id }}" type="button"
                                            onclick="set_alert_id({{ $cdr_item->id }})" class="btn btn-sm m-1"><i
                                                class="i-Information mr-2"></i>مهم
                                        </button>
                                    @else
                                        <button id="todo_{{ $cdr_item->id }}" type="button"
                                            onclick="reset_alert_id({{ $cdr_item->id }})"
                                            class="btn btn-danger btn-sm m-1"><i class="i-Information mr-2"></i>مهم
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($cdr_src as $cdr_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th>{{ $cdr_item->id }}
                                    @if ($cdr_item->todo_flag != 1)
                                        <i id="alert_{{ $cdr_item->id }}" class="i-Information text-danger d-none"
                                            style="font-size: 20px;"></i>
                                    @else
                                        <i id="alert_{{ $cdr_item->id }}" class="i-Information text-danger"
                                            style="font-size: 20px;"></i>
                                    @endif

                                </th>
                                <td>{{ $Persian->MyPersianDate($cdr_item->calldate, true) }}</td>
                                @if ($cdr_item->UserName == null)
                                    <td><a id="caller_name_{{ $cdr_item->id }}"
                                            href="javascript:makeCall_by_phone('{{ $cdr_item->src }}')">
                                            {{ $cdr_item->src }}</a></td>
                                @else
                                    <td>
                                        <a id="caller_name_{{ $cdr_item->id }}"
                                            href="javascript:makeCall_by_phone('{{ $cdr_item->src }}')">
                                            {{ $cdr_item->Name }}
                                            {{ $cdr_item->Family }}
                                            <br>
                                        </a>
                                        {{ $cdr_item->src }}
                                    </td>
                                @endif
                                <td>{{ $cdr_item->dst }}</td>
                                <td>{{ $cdr_item->duration }} </td>
                                <td>{{ $cdr_item->disposition }} </td>
                                <td>{{ $cdr_item->dcontext }} </td>
                                <td>{{ $cdr_item->lastapp }} </td>
                                <td id="related_row_{{ $cdr_item->id }}">{{ $cdr_item->rName }} {{ $cdr_item->rFamily }}
                                </td>
                                <td>
                                    @if ($cdr_item->UserName == null)
                                        <button id="add_user_{{ $cdr_item->id }}" type="button" data-toggle="modal"
                                            onclick="add_user({{ $cdr_item->id }},'{{ $cdr_item->src }}')"
                                            data-target=".add-user-modal" class="btn btn-warning btn-sm m-1"><i
                                                class="i-Add-User text-white mr-2"></i>افزودن کاربر
                                        </button>
                                    @endif
                                    @if ($cdr_item->rFamily == null)
                                        <button id="user_operation_{{ $cdr_item->id }}" type="button"
                                            data-toggle="modal"
                                            onclick="add_responsible({{ $cdr_item->id }},'{{ $cdr_item->src }}')"
                                            data-target=".set_responsible"
                                            class="btn btn-info btn-sm m-1 {{ $cdr_item->UserName == null ? 'd-none' : '' }} "><i
                                                class="i-Gear text-white mr-2"></i> ارجاع
                                        </button>
                                    @endif
                                    @if ($cdr_item->recordingfile != null)
                                        <button onclick="playAudio('{{ $cdr_item->recordingfile }}')"
                                            class="btn btn-sm btn-success"> <i class="i-Video-5"></i> پخش</button>
                                    @endif
                                    @if ($cdr_item->more_data == '')
                                        <button id="addobject_{{ $cdr_item->id }}" type="button" data-toggle="modal"
                                            onclick="set_report_id({{ $cdr_item->id }})"
                                            data-target=".bd-example-modal-lg" class="btn btn-info btn-sm m-1"><i
                                                class="i-Ticket text-white mr-2"></i>گزارش
                                        </button>
                                    @else
                                        <button id="addobject_{{ $cdr_item->id }}" type="button" data-toggle="modal"
                                            onclick="set_report_id({{ $cdr_item->id }})"
                                            data-target=".bd-example-modal-lg" class="btn btn-success btn-sm m-1"><i
                                                class="i-Ticket text-white mr-2"></i>گزارش
                                        </button>
                                    @endif
                                    @if ($cdr_item->todo_flag != 1)
                                        <button id="todo_{{ $cdr_item->id }}" type="button"
                                            onclick="set_alert_id({{ $cdr_item->id }})" class="btn btn-sm m-1"><i
                                                class="i-Information mr-2"></i>مهم
                                        </button>
                                    @else
                                        <button id="todo_{{ $cdr_item->id }}" type="button"
                                            onclick="reset_alert_id({{ $cdr_item->id }})"
                                            class="btn btn-danger btn-sm m-1"><i class="i-Information mr-2"></i>مهم
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection


@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>

    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>

    <script>
        function playAudio(address) {
            var windowSizeArray = ["width=100,height=300",
                "width=500,height=160,scrollbars=yes"
            ];
            var windowSize = windowSizeArray[$(this).attr("rel")];
            window.open(address, "player", windowSizeArray);
        }
    </script>
    <script>
        var $report_id;

        function add_user(cdr_id, user_phone) {
            $report_id = cdr_id;
            $('#mobile_no').val(user_phone);
        }


        function save_user() {
            if ($('#name').val().replace(/^\s+|\s+$/g, "").length < 3) {
                return alert('نام نمیتواند خالی یا کمتر از ۲ کارکتر باشد!');
            }
            name = $('#name').val().replace(/^\s+|\s+$/g, "");
            if ($('#family').val().replace(/^\s+|\s+$/g, "").length < 3) {
                return alert('فامیل نمیتواند خالی یا کمتر از ۲ کارکتر باشد!');
            }
            family = $('#family').val().replace(/^\s+|\s+$/g, "");
            if ($('#mobile_no').val().replace(/^\s+|\s+$/g, "").length != 11) {
                return alert('شماره موبایل صحیح نیست!');
            }
            mobile_no = $('#mobile_no').val().replace(/^\s+|\s+$/g, "");
            user_cat = $("#user_cat option:selected").val();
            sex = $("#sex option:selected").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'add_user',
                    Name: name,
                    Family: family,
                    MobileNo: mobile_no,
                    cat: user_cat,
                    Sex: sex,
                },
                function(data, status) {
                    if (data.result) {
                        $('#caller_name_' + $report_id).html(data.sex + ' ' + data.name + ' ' + data.family);
                        $('#caller_name_fa_' + $report_id).html(data.sex + ' ' + data.name + ' ' + data.family);
                        $('#add_user_' + $report_id).addClass('d-none');
                        $('#user_operation_' + $report_id).removeClass('d-none');
                        return true;
                    }
                });

        }
        var $cdr_id;

        function do_add_responsible() {

            report_txt = $('#report_text_res').val();
            select = document.getElementById("responsible");
            responsible = select.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'add_responsible',
                    cdr_id: $cdr_id,
                    ReportTxt: report_txt,
                    Responsible: responsible
                },
                function(data, status) {
                    $('#user_operation_' + $cdr_id).addClass('d-none');
                    $('#related_row_' + $cdr_id).html(data);
                    $('#add_response_modal').modal('hide');


                });
        }

        function add_responsible(cdrid, user_phone) {
            $cdr_id = cdrid;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'get_report',
                    cdr_id: cdrid,
                },
                function(data, status) {
                    report_text = data;
                    $('#record_history_res').html(report_text);

                });
        }

        function set_alert_id(report_id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'set_alert',
                    cdr_id: report_id,
                },
                function(data, status) {
                    if (data) {
                        $('#alert_' + report_id).removeClass('d-none');
                        $('#todo_' + report_id).addClass('btn-danger');
                        return true;
                    }
                });
        }

        function reset_alert_id(report_id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'reset_alert',
                    cdr_id: report_id,
                },
                function(data, status) {
                    if (data) {
                        $('#alert_' + report_id).addClass('d-none');
                        $('#todo_' + report_id).removeClass('btn-danger');
                        return true;
                    }
                });
        }

        function set_report_id(report_id) {
            $report_id = report_id;
            $('#modal_header').html('فرم ثبت گزارش رکورد شماره : ' + report_id);
            $('#reportDescription').val('');
            $('#record_history').html('');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'get_report',
                    cdr_id: $report_id,
                },
                function(data, status) {
                    $('#record_history').html(data);
                });
        }

        function save_report() {
            reportDescription = $('#reportDescription').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'add_report',
                    cdr_id: $report_id,
                    report_text: reportDescription
                },
                function(data, status) {
                    if (data == 0) {
                        alert('مشکلی به وجود آمده است ');
                    } else {
                        $('#addobject_' + $report_id).removeClass('btn-info');
                        $('#addobject_' + $report_id).addClass('btn-success');
                        alert('انجام شد');
                    }
                    //redirect
                });
        }
        $('select').select2({
            createTag: function(params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {
                    id: params.term,
                    text: params.term
                }
            }
        });
        $("#user_cat").select2({
            tags: true
        });
    </script>


    @include('Layouts.SearchUserInput_Js')
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection
