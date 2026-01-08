@php
    $Persian = new App\Functions\persian();
    $NetTotall = 0;
    $BuyTotall = 0;
    $SellTotall = 0;
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
                        <h3>فروشگاه
                            <small>
                            </small>
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
                <div class="card-body text-center"><i class="i-Car-Items"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">تعداد صورت حساب ها </p>
                        <p id="Totallitems_t" class="text-primary text-24 line-height-1 mb-2">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Data-Upload"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0"> سود کل </p>
                        <p id="NetTotall_t" class="text-primary text-24 line-height-1 mb-2">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Feedburner"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">مبلغ خرد کل </p>
                        <p id="BuyTotall_t" class="text-primary text-24 line-height-1 mb-2">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-File-Horizontal-Text"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">مبلغ فروش کل</p>
                        <p id="SellTotall_t" class="text-primary text-24 line-height-1 mb-2">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <form method="post">
        @csrf
        <div class="card-body">

            <div class="table-responsive">
                <table id="Product-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>شماره سفارش</th>
                            <th>نام مشتری</th>
                            <th>تاریخ خرید</th>
                            <th>سود</th>
                            <th>مبلغ خرید</th>
                            <th>مبلغ فروش</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $Rowno = 1;
                            
                        @endphp
                        @foreach ($Orders as $Orders)
                            <tr>
                                <td>{{ $Rowno++ }}</td>
                                <td>
                                    @if ($Orders->countitems > 1)
                                        <button class="btn btn-success">+</button> {{ $Orders->id }}
                                    @else
                                        {{ $Orders->id }}
                                    @endif
                                </td>
                                <td>{{ $Orders->Name }} {{ $Orders->Family }} </td>
                                <td>{{ $Persian->MyPersianDate($Orders->CreateDate, true) }}</td>

                                <td>{{ number_format($Orders->nettotall) }}
                                </td>
                                <td>{{ number_format($Orders->BuyPrice) }}</td>
                                <td>{{ number_format($Orders->total_sales) }}</td>

                                <td>

                                    @if ($Orders->status == 1)
                                        پرداخت شده
                                    @elseif($Orders->status == 10)
                                        در دست اقدام
                                    @elseif($Orders->status == 20)
                                        ارسال به انبار
                                    @elseif($Orders->status == 30)
                                        درحال بسته بندی
                                    @elseif($Orders->status == 40)
                                        ارسال به پست
                                    @elseif($Orders->status == 50)
                                        ثبت شده در تاپین
                                    @elseif($Orders->status == 51)
                                        ارسال شده به تاپین
                                    @elseif($Orders->status == 60)
                                        انصراف مشتری
                                    @elseif($Orders->status == 70)
                                        تحویل مشتری
                                    @endif


                                </td>

                                <td>
                                    <a target="_blank" href="{{ Route('EditOrder', ['OrderID' => $Orders->id]) }}"
                                        title="ویرایش محصول">
                                        <i style="font-size: 20px" class="i-Edit"></i>
                                    </a>

                                </td>
                            </tr>
                            @php
                                $NetTotall += $Orders->nettotall;
                                $BuyTotall += $Orders->BuyPrice;
                                $SellTotall += $Orders->total_sales;
                            @endphp
                        @endforeach
                        <input class="nested" id="Totallitems" value="{{ $Rowno }}">
                        <input class="nested" id="NetTotall" value="{{ $NetTotall }}">
                        <input class="nested"id="BuyTotall" value="{{ $BuyTotall }}">
                        <input class="nested" id="SellTotall" value="{{ $SellTotall }}">


                    </tbody>

                </table>
            </div>

        </div>
    </form>
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif

    <script>
        $('#Product-list').DataTable();
    </script>
    <script>
        $(document).ready(function() {
            $('#Totallitems_t').html($('#Totallitems').val());
            $('#NetTotall_t').html($('#NetTotall').val());
            $('#BuyTotall_t').html($('#BuyTotall').val());
            $('#SellTotall_t').html($('#SellTotall').val());
        });
    </script>
@endsection
