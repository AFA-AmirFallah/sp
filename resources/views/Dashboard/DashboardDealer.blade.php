@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
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
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <a href="{{ route('PatShiftDone') }}">
                    <div class="card-body text-center">
                        @if (Session::get('shafatelunmanagedcustomers') > 0)
                            <i style="color: red" class="i-Checked-User"></i>
                        @else
                            <i class="i-Checked-User"></i>
                        @endif
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">{{ __('customers') }}</p>
                            <p class="text-primary text-24 line-height-1 mb-2">{{ $MyCustomers }}</p>
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
                        <p class="text-primary text-24 line-height-1 mb-2">{{ Session::get('shafatelunmanagedLabs') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        @php
            $call_counter = 0;
        @endphp

        @foreach ($calls as $call)
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">تماس ورودی</h3>
                    </div>

                    <form method="post" action="{{route('dashboard')}}" >
                        @csrf
                        <div class="card-body">
                            <div class="form-row ">
                                <ui>
                                    <li>زمان تماس: {{ $Persian->MyPersianDate($call->StartTime, true) }} </li>
                                    <li>مدت مکالمه: {{ $call->CallDuration }} ثانیه </li>
                                    @if ($call->Name != null)
                                        <li>تماس گیرنده: {{ $call->Name }} {{ $call->Family }} </li>
                                    @endif
                                </ui>
                                @if ($call->Name == null)
                                    <br>
                                    <ui>
                                        <li>شماره تماس گیرنده: {{ $call->CallerNumber }} </li>
                                    </ui>
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="ul-form__label">نام تماس گیرنده :</label>
                                        <input type="text" name="Name" class="form-control" placeholder="نام">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="ul-form__label">نام خانوادگی تماس گیرنده :</label>
                                        <input type="text" name="Family" class="form-control"
                                            placeholder="نام خانوادگی">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="ul-form__label"> جنسیت :</label>
                                        <select class="form-control" name="Sex">
                                            <option value="m">آقا</option>
                                            <option value="f">خانم</option>
                                        </select>
                                    </div>
                                @endif

                            </div>
                            <div class="custom-separator"></div>
                            <label for="inputEmail4" class="ul-form__label">تماس مربوط به:</label>

                            <select class="form-control" name="file_id">
                                @foreach ($dealer_files as $dealer_file_item)
                                    <option value="{{ $dealer_file_item->id }}">{{ $dealer_file_item->title }}</option>
                                @endforeach
                            </select>
                            @php
                                $subject_src = $deal_functions->call_subject();
                            @endphp
                            <label for="inputEmail4" class="ul-form__label">موضوع مکالمه:</label>
                            <select class="form-control" name="Status">
                                @foreach ($subject_src as $key => $subject)
                                    <option value="{{ $key }}">{{ $subject }}</option>
                                @endforeach
                            </select>
                            <div id="more_{{ $call_counter }}">
                                <a href="javascript:show_more('{{ $call_counter }}')">+ بیشتر</a>

                            </div>
                            @php
                                $type_src = $deal_functions->call_type();
                            @endphp
                            <div class="nested" id="less_{{ $call_counter }}">
                                <a href="javascript:show_less('{{ $call_counter }}')">+ کمتر</a>
                                <br>
                                <label for="inputEmail4" class="ul-form__label"> تماس خاص:</label>
                                <select class="form-control" name="CallType">
                                    @foreach ($type_src as $key => $subject)
                                        <option value="{{ $key }}">{{ $subject }}</option>
                                    @endforeach
                                </select>

                                <label for="inputEmail4" class="ul-form__label">توضیحات در خصوص تماس:</label>
                                <textarea name="note" class="form-control" cols="30" rows="10"></textarea>


                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div style="height: 40px" class="col-lg-12">
                                        <button type="submit" name="delete" value="{{ $call->CallID }}"
                                            style="
                                        left: 10px;
                                        position: absolute;
                                    "
                                            class="btn  btn-danger m-1">حذف تماس</button>
                                        <button type="submit" name="add" value="{{ $call->CallID }}"
                                            style="
                                        right: 10px;
                                        position: absolute;
                                    "
                                            class="btn  btn-primary m-1 footer-delete-right">تائيد</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            @php
                $call_counter++;
            @endphp
        @endforeach

    </div>
    @foreach ($dealer_files as $dealer_file_item)
        <div class="col-md-6 mb-4">
            <div class="card text-left">

                <div class="card-body">
                    <h4 class="card-title mb-3">{{ $dealer_file_item->title }}</h4>
                    <p>تاریخ شروع: {{ $Persian->MyPersianDate($dealer_file_item->assign_date, true) }} <a
                            href="{{ route('working_file', ['file_id' => $dealer_file_item->id]) }}">جزئیات فایل</a> </p>
                    <div class="carousel_wrap">
                        @php
                            $pic_src = $deal_functions->get_deal_file_pics($dealer_file_item->id);
                            $pic_count = count($pic_src);
                        @endphp
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                @for ($i = 1; $i < $pic_count; $i++)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"
                                        class=""></li>
                                @endfor

                            </ol>
                            <div class="carousel-inner">

                                @foreach ($pic_src as $pic_item)
                                    @if ($loop->first)
                                        <div class="carousel-item active">
                                        @else
                                            <div class="carousel-item">
                                    @endif
                                    <img class="d-block w-100" src="{{ $pic_item['pic'] }}" alt="pic">
                            </div>
    @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    </div>
    </div>
    </div>
    </div>
    </div>
    @endforeach
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
        $('#request_table').DataTable();
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
    </script>
    <script>
        function show_more(main_id) {
            $('#less_' + main_id).removeClass('nested');
            $('#more_' + main_id).addClass('nested');

        }

        function show_less(main_id) {
            $('#less_' + main_id).addClass('nested');
            $('#more_' + main_id).removeClass('nested');
        }
    </script>
@endsection
