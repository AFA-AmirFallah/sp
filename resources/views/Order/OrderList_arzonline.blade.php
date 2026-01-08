@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#patiantworks">
    <input class="nested" id="sub-menu" value="#patiant_order_list">
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"> <i class=" header-icon i-Receipt-3"></i> {{ __('Request Orders') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="request_table" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Number') }}</th>
                                        <th>صرافی</th>
                                        <th>مشتری</th>
                                        <th>{{ __('Mobile No') }}</th>
                                        <th>{{ __('Date of enter') }}</th>
                                        <th>{{ __('service type') }}</th>
                                        <th>شعبه</th>
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
                                            <td>{{ $MyOrder->branch_name }}</td>
                                            <td>{!! $processor->extra_info_process($MyOrder->Extranote)  !!}</td>
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
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable({
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
    </script>
@endsection
