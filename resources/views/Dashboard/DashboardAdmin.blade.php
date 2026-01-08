@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <input class="nested" id="main-menu" value="#dashboard">
    <input class="nested" id="sub-menu" value="#dashboard">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Dashboard') }}
                            <small>{{ __('Dashboard') }}</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="row">
        <!-- ICON BG -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <a href="{{ route('UserSearch') }}">
                    <div class="card-body text-center">
                        @if (Session::get('shafatelunmanagedcustomers') > 0)
                            <i style="color: red" class="i-Checked-User"></i>
                        @else
                            <i class="i-Checked-User"></i>
                        @endif

                        <div class="content">
                            <p class="text-muted mt-2 mb-0">{{ __('customers') }}</p>
                            <p class="text-primary text-24 line-height-1 mb-2">
                                {{ Session::get('shafatelunmanagedcustomers') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ route('Order') }}">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        @if (Session::get('shafatelunmanagedServices') > 0)
                            <i style="color: red" class="i-Ambulance"></i>
                        @else
                            <i class="i-Ambulance"></i>
                        @endif

                        <div class="content">
                            <p class="text-muted mt-2 mb-0">{{ __('Register service') }}</p>
                            <p class="text-primary text-24 line-height-1 mb-2">
                                {{ Session::get('shafatelunmanagedServices') }}</p>
                        </div>
                    </div>
                </div>

            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    @if (Session::get('shafatelunmanagedDevices') > 0)
                        <i style="color: red" class="i-Luggage-2"></i>
                    @else
                        <i class="i-Luggage-2"></i>
                    @endif
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">{{ __('devices') }}</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ Session::get('shafatelunmanagedDevices') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    @if (Session::get('shafatelunmanagedLabs') > 0)
                        <i style="color: red" class="i-Drop"></i>
                    @else
                        <i class="i-Drop"></i>
                    @endif
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">{{ __('Labs') }}</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ Session::get('shafatelunmanagedLabs') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @if ($SMSReciver != 'NoLic')
        <section class="contact-list_1">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header text-right bg-transparent" style="text-align: right">
                            <h5 style="text-align: right;">پیامک های دریافتی</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="request_table" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ارسال کننده</th>
                                            <th>تاریخ</th>
                                            <th>متن پیام</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SMSReciver as $SMSReciverTarget)
                                            @if (!is_numeric($SMSReciverTarget->Message))
                                                <tr id='SmsRow_{{ $SMSReciverTarget->SMSID }}'>

                                                    <td><a href="{{ route('UserProfile', ['RequestUser' => $SMSReciverTarget->UserName]) }}">{{ $SMSReciverTarget->Name }} {{ $SMSReciverTarget->Family }}</a> 
                                                    </td>
                                                    <td>{{ $Persian->MyPersianDate($SMSReciverTarget->SMSTime, true) }}
                                                    </td>
                                                    <td>{{ $SMSReciverTarget->Message }}</td>
                                                    <td>
                                                        <button onclick="DeleteMessage({{ $SMSReciverTarget->SMSID }})"
                                                            type="button" class="btn btn-danger">حذف</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="contact-list_1">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card  text-left">
                    <div class="card-header  text-right bg-transparent" style="text-align: right">
                        <h5 style="text-align: right;">{{ __('Request Orders') }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="request_table" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Number') }}</th>
                                        <th>{{ __('Request person') }}</th>
                                        <th>{{ __('Pat') }}</th>
                                        <th>{{ __('Mobile No') }}</th>
                                        <th>{{ __('Date of enter') }}</th>
                                        <th>{{ __('service type') }}</th>
                                        <th>{{ __('Note') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($MyOrders as $MyOrder)
                                        <tr>
                                            <td>{{ $MyOrder->ID }}</td>
                                            <td>{{ $MyOrder->ordername }} {{ $MyOrder->orderfamily }} </td>
                                            <td>{{ $MyOrder->BimarName }} {{ $MyOrder->Bimarfamily }} </td>
                                            <td>{{ $MyOrder->BimarMobile }}</td>
                                            <td>{{ $Persian->MyPersianDate($MyOrder->CreateDatew, true) }}</td>
                                            <td>{{ $MyOrder->Cat }}</td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        استان: {{ $MyOrder->ProvinceName ?? 'نامشخص' }}
                                                    </li>
                                                    <li>
                                                        شهر: {{ $MyOrder->CityName ?? 'نامشخص' }}
                                                    </li>

                                                    <li>
                                                        توضیحات: 
                                                        @php
                                                            $OutPut = json_decode($MyOrder->Extranote);
                                                        @endphp
                                                        @if (is_object($OutPut))
                                                            @foreach ($OutPut as $OutPutItem)
                                                                {{ $OutPutItem[0] ?? '' }} : {{ $OutPutItem[1] ?? '' }}
                                                                <br>
                                                            @endforeach
                                                        @else
                                                            {{ $MyOrder->Extranote }}
                                                        @endif
                                                    </li>
                                                    <li>
                                                        آدرس: {{ $MyOrder->Address ?? 'نامشخص' }}
                                                    </li>
                                                </ul>


                                            </td>
                                            <td id="status_{{ $MyOrder->ID }}" name="{{ $MyOrder->status }}">
                                                {{ $MyOrder->status }}</td>
                                            <td>
                                                <button type="button" class="btn bg-white _r_btn border-0"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="_dot _inline-dot bg-primary"></span>
                                                    <span class="_dot _inline-dot bg-primary"></span>
                                                    <span class="_dot _inline-dot bg-primary"></span>
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                    style="position: absolute; text-align: right; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    @foreach ($orderstatus as $orderstatusItem)
                                                        <a class="dropdown-item ul-widget__link--font"
                                                            onclick="ChangeOrderStatus({{ $MyOrder->ID }},{{ $orderstatusItem->ID }},'{{ $orderstatusItem->status }}')">
                                                            <i class="i-Data-Save"> </i>
                                                            {{ $orderstatusItem->status }}
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                    @endforeach


                                                </div>
                                                @if (\App\myappenv::Lic['SmartInvoice'])
                                                    @if (Auth::user()->Role != App\myappenv::role_customer)
                                                        <a style="padding: 3px" class="dropdown-item ul-widget__link--font"
                                                            href="{{ Route('Workflow', $MyOrder->BimarUserName) }}">
                                                            <i class="i-Over-Time"> </i>
                                                            روال کار
                                                        </a>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->Role >= App\myappenv::role_superviser)
                                                    <a class="dropdown-item ul-widget__link--font"
                                                        href="{{ Route('PatShift', $MyOrder->BimarUserName) }}">
                                                        <i class="i-Bar-Chart-4"> </i>
                                                        {{ __('Assign shift') }}
                                                    </a>
                                                @endif
                                                <a class="dropdown-item ul-widget__link--font" href="#"
                                                    onclick="window.open('{{ url('/') . '/filemanager?type=file&usertraget=' . $MyOrder->BimarUserName }}',
                                                                        'newwindow',
                                                                        'width=1000,height=600');
                                                             return false;">
                                                    <i class="i-Folder-Open"></i>
                                                    فولدر کاربر
                                                </a>
                                                <a class="dropdown-item ul-widget__link--font"
                                                    href="{{ Route('PatDoc', $MyOrder->BimarUserName) }}">
                                                    <i class="i-Data-Save"> </i>
                                                    {{ __('Electronic document') }}
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-list_1">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header text-right bg-transparent" style="text-align: right">
                        <h5 style="text-align: right;">{{ __('Doing Shifts') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="request_table" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Personel') }}</th>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('service type') }}</th>
                                        <th>{{ __('Shift Time') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ActiveShifts as $ActiveShift)
                                        <tr>
                                            <td>{{ $ActiveShift->Name }} {{ $ActiveShift->Family }} </td>
                                            <td>{{ $ActiveShift->ownername }} {{ $ActiveShift->ownerFamily }} </td>
                                            <td>{{ $ActiveShift->RespnsTypeName }}</td>
                                            <td> از {{ $Persian->MyPersianDate($ActiveShift->StartRespns, true) }} <br>
                                                تا {{ $Persian->MyPersianDate($ActiveShift->EndRespns, true) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>







@endsection

@section('page-js')
@endsection

@section('bottom-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#request_table').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    </script>

    <script>
        function ChangeOrderStatus($OrderID, $TargetStatus, $TargetStatusName) {
            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            var $oldvalue = $('#status_' + $OrderID).html();
            $('#status_' + $OrderID).html($loader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'ChangeOrderStatus',
                    OrderID: $OrderID,
                    TargetStatus: $TargetStatus,
                },

                function(data, status) {
                    if (data == '1') {
                        $('#status_' + $OrderID).html($TargetStatusName);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                        $('#status_' + $OrderID).html($oldvalue);
                    }
                });


        }

        function DeleteMessage($MessageId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'RemoveSMS',
                    MessageId: $MessageId,
                },

                function(data, status) {
                    if (data == true) {
                        $("#SmsRow_" + $MessageId).addClass("nested");
                    } else {
                        alert('بروز مشکل در انجام عملیات!');

                    }
                });



        }
    </script>
@endsection
