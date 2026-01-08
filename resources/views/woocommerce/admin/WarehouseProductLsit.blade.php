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
                        <h3>فروشگاه {{ $TargetStore->Name }}
                            <small>
                                لیست محصولات در {{ $TargetWarehouse->Name }}</small>
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
    <div class="d-sm-flex mb-5" data-view="print">
        <span class="m-auto"></span>
        <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">چاپ گزارش </button>
    </div>
    <!-- Container-fluid starts-->
    <form method="post">
        @csrf

        <div class="card-body">
            <div id="print-area">
                <div class="table-responsive">
                    <table id="Product-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('No.') }}</th>
                                <th>sku</th>
                                <th>نام محصول</th>
                                <th>نام لاتین</th>
                                <th> تاریخ ورود به انبار</th>
                                <th> تعداد ورود به انبار</th>
                                <th>موجودی</th>
                                <th>عملیات</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $Rowno = 1;
                                $GoodId = null;
                            @endphp
                            @foreach ($goods as $good)
                                @if ($GoodId == $good->id)
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{ $good->Name }} - {{ $good->QTY }}</td>
                                        <td>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $Rowno++ }}</td>
                                        <td>{{ $good->SKU }}</td>
                                        <td>{{ $good->NameFa }}</td>
                                        <td>{{ $good->NameEn }}</td>
                                        <td> {{ $Persian->MyPersianDate($good->InputDate, false) }} </td>
                                        <td>{{ $good->QTY }}</td>
                                        <td>{{ $good->Remian }}</td>
                                        <td>
                                            <a target="_blank"
                                                href="{{ Route('EditProductInStore', ['id' => $good->wgid]) }}"
                                                title="ویرایش محصول">
                                                <i style="font-size: 20px" class="i-Edit"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </form>
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.script.js') }}"></script>
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif

    <script>
        $('#Product-list').DataTable();
    </script>
@endsection
