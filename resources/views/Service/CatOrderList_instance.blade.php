@php
    $MyImage = new \App\Functions\Images();
@endphp
@extends('Layouts.MainPage')

@section('MainCountent')
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#req_mgt">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('AddCatOrder') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary">افزودن درخواست</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CatOrderList') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">لیست درخواست ها</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="color: orange" class="i-Pen-4"></i>
                    <div class="content">
                        <p class="text-primary mt-2 mb-0">ویرایش درخواست</p>

                    </div>
                </div>
            </div>
        </div>
        @if (\App\myappenv::version >= 3 && \App\myappenv::Branch == Auth::user()->branch)
            <div class=" col-lg-3 col-md-6 col-sm-6 ">
                <a href="{{ route('branch_order_req') }}">
                    <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i style="color: red" class="i-Cloud-"></i>
                            <div class="content">
                                <p class=" mt-2 mb-0 text-primary">افزودن درخواست شعبه </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

    </div>



    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Aim"></i> لیست درخواست ها
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>تصویر</th>
                                        <th>نام درخواست</th>
                                        <th>مبلغ</th>
                                        <th>وضعیت</th>

                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_src as $Catorder)
                                        <tr>
                                            <td name="">
                                                <img style="width: 60px" src="{{ $Catorder->Pic }}" />
                                            </td>
                                            <td>{{ $Catorder->TitleDescription }}</td>
                                            <td>
                                                از {{ number_format($Catorder->min_price ?? 0) }}
                                                تا {{ number_format($Catorder->max_price ?? 0) }} ریال
                                            </td>
                                            <td>
                                                @if ($Catorder->OnSale == 1)
                                                    <span class="badge badge-pill badge-success p-2 m-1">فعال</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger p-2 m-1"> غیر فعال</span>
                                                @endif
                                                @switch($Catorder->Status)
                                                    @case(0)
                                                        <span class="badge badge-pill badge-danger p-2 m-1">در انتظار ثبت
                                                            نهایی</span>
                                                    @break

                                                    @case(1)
                                                        <span class="badge badge-pill badge-primary p-2 m-1">نمایش به کاربران
                                                            مرکز</span>
                                                    @break

                                                    @case(50)
                                                        <span class="badge badge-pill badge-primary p-2 m-1">نمایش به کاربران
                                                            مرکز</span>
                                                        <span class="badge badge-pill badge-warning p-2 m-1">در دست بررسی کارشناسان
                                                            شفاتل</span>
                                                    @break

                                                    @case(100)
                                                        <span class="badge badge-pill badge-primary p-2 m-1">نمایش به کاربران
                                                            مرکز</span>
                                                        <span class="badge badge-pill badge-success p-2 m-1">نمایش به کاربران
                                                            شفاتل</span>
                                                    @break

                                                    @default
                                                @endswitch

                                            </td>
                                            <td>
                                                <a href="{{ route('EditCatOrder', ['ID' => $Catorder->id]) }}"
                                                    class="btn btn-primary btn-md m-1 edit_btn" title="Edit">
                                                    <i class="i-Edit"></i>
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
        $('#ul-contact-list').DataTable();
    </script>
@endsection
