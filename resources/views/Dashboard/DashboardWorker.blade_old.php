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
@endsection
