@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    @if (Auth::check() && Auth::user()->Role == App\myappenv::role_customer)
        @if (Auth::user()->Role == \App\myappenv::role_customer)
            <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
            <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
            <div id="app">
                <patascustomer></patascustomer>
            </div>
        @endif
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>عملیات مالی
                            <small>لیست صورت حساب ها</small>
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
    <form method="post">
        @csrf
        <div class="card-body">

            @if ($SmartInvoice != [])
                <div class="table-responsive">
                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>به نام</th>
                                <th>صورت حساب</th>
                                <th>تاریخ صدور</th>
                                <th>مبلغ</th>
                                <th>تامین کننده</th>
                                <th>وضعیت</th>

                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($SmartInvoice as $SmartInvoiceTarget)
                                <tr @if ($SmartInvoiceTarget->InvoiceStatus == '1') class="table-row-danger" @endif>
                                    <td>{{ $SmartInvoiceTarget->ContractID }}</td>
                                    <td>{{ $SmartInvoiceTarget->OwnerName }} {{ $SmartInvoiceTarget->OwnerFamily }}</td>
                                    <td>{{ $SmartInvoiceTarget->TypeName }} </td>
                                    <td> {{ $Persian->MyPersianDate($SmartInvoiceTarget->created_at, true) }} </td>
                                    @if ($ShowType == 'Cusetomer')
                                        <td>{{ number_format($SmartInvoiceTarget->TotalPrice) }}</td>
                                    @elseif ($ShowType == 'MainOwner')
                                        <td>{{ number_format($SmartInvoiceTarget->TotalPrice) }}</td>
                                    @elseif ($ShowType == 'ProviderOwners')
                                        <td>{{ number_format($SmartInvoiceTarget->BranchPrice) }}</td>
                                    @endif
                                    <td>{{ $SmartInvoiceTarget->Provider }}</td>
                                    <td>
                                        @if ($SmartInvoiceTarget->InvoiceStatus == '1')
                                            در انتظار پرداخت
                                        @elseif($SmartInvoiceTarget->InvoiceStatus == '50')
                                            در انتظار تسویه حساب
                                        @elseif($SmartInvoiceTarget->InvoiceStatus == '100')
                                            تسویه شده
                                        @endif
                                    </td>
                                    <td>
                                        <a title="{{ __('View invoice') }}" class="btn btn-primary"
                                            href="{{ route('Invoice', ['Invoice' => $SmartInvoiceTarget->ContractID . 'SI']) }}">
                                            <i class="nav-icon i-Eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            @else
                @include('Layouts.nodata')
            @endif
            @if ($Invoices != [])
                <div class="table-responsive">
                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>صورت حساب</th>
                                <th>تاریخ صدور</th>
                                <th>مبلغ</th>
                                <th>وضعیت</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Invoices as $Invoice)
                                <tr @if ($Invoice->Status == 1) class="table-row-danger" @endif>
                                    <td>{{ $Invoice->id }}</td>
                                    <td>{{ $Invoice->ownername }} {{ $Invoice->ownnerfamily }} </td>
                                    <td> {{ $Persian->MyPersianDate($Invoice->created_at, true) }} </td>
                                    <td>{{ number_format($Invoice->Amount) }}</td>
                                    <td>{{ $Invoice->StatusName }}</td>
                                    <td>
                                        <a title="{{ __('View invoice') }}" class="btn btn-primary"
                                            href="{{ route('Invoice', ['Invoice' => $Invoice->id]) }}"> <i
                                                class="nav-icon i-Eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            @else
                @include('Layouts.nodata')
            @endif
        </div>
    </form>
@endsection
@section('page-js')
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'Invoice';
    </script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>
@endsection
