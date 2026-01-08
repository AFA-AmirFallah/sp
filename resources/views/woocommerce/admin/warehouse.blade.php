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
                        <h3>{{ $Store->Name }}
                            <small>لیست انبارها </small>
                        </h3>
                    </div>
                </div>
                @canany(['shopadmin_', 'root_'])
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-left">
                            <a class="btn btn-primary" href="{{ route('AddWarehouse', $Store->id) }} ">افزودن انبار</a>
                        </ol>
                    </div>
                @endcanany

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <form method="post">
        @csrf
        <div class="card-body">

            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>نام انبار</th>
                            <th>نوع انبار</th>
                            <th>تلفن انبار</th>
                            <th>عملیات</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $Rowno = 1;
                        @endphp
                        @foreach ($warehouses as $warehouse)
                            <tr>
                                <td>{{ $Rowno++ }}</td>
                                <td>{{ $warehouse->Name }}</td>
                                <td>
                                    @if ($warehouse->status == 0)
                                        انبار فروش
                                    @elseif($warehouse->status == 1)
                                        انبار پشتیبان
                                    @endif
                                </td>
                                <td>{{ $warehouse->phone }}</td>
                                <td>
                                    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                                        <a target="_blank"
                                            href="{{ Route('WarehouseManagement', ['StoreID' => $warehouse->StoreID]) }}"
                                            title="   تسهیم به انبار ">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                                <path
                                                    d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                                <path
                                                    d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                                <path
                                                    d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                            </svg>
                                        </a>

                                        <a target="_blank"
                                            href="{{ Route('EditWarehouse', ['StoreID' => $warehouse->StoreID, 'Warehousid' => $warehouse->id]) }}"
                                            title="ویرایش انبار">
                                            <i style="font-size: 20px" class="i-Edit"></i>
                                        </a>
                                        <a target="_blank"
                                            href="{{ Route('WarehouseReport', ['warehouseid' => $warehouse->id]) }}"
                                            title="گزارش انبار    ">
                                            <i class="i-Letter-Open" style="font-size: 20px"></i>
                                        </a>
                                    @endif
                                    <a target="_blank"
                                        href="{{ Route('WarehouseManagement', ['StoreID' => $warehouse->id]) }}"
                                        title="ویرایش  کالا های انبار">
                                        <i class="i-Shop" style="font-size: 20px"></i>

                                    </a>


                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </form>
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
@endsection
