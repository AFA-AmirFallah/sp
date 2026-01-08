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
                        <i class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-wite">افزودن درخواست</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CatOrderList') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">لیست درخواست ها</p>

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
                    <div class="navcard active-navcard  card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i style="color: green" class="i-Cloud-"></i>
                            <div class="content">
                                <p class=" mt-2 mb-0 text-primary">افزودن درخواست شعبه </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

    </div>

    <form method="POST">
        @csrf
        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Aim"></i> لیست درخواست های مراکز
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>کد</th>
                                            <th>تصویر</th>
                                            <th>نام درخواست</th>
                                            <th>مرکز</th>
                                            <th>قیمت</th>
                                            <th>توضیحات</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pending_request as $pending_request_item)
                                            <tr>
                                                <td>
                                                    {{ $pending_request_item->id }}
                                                </td>
                                                <td name="">
                                                    <img style="width: 60px" src="{{ $pending_request_item->Pic }}" />
                                                </td>
                                                <td>{{ $pending_request_item->TitleDescription }}</td>
                                                <td>{{ $pending_request_item->branch_name }}</td>
                                                <td>
                                                    از {{ number_format($pending_request_item->min_price ?? 0) }}
                                                    تا {{ number_format($pending_request_item->max_price ?? 0) }} ریال
                                                </td>
                                                <td>
                                                    {{ $pending_request_item->MainDescription }}
                                                </td>
                                                <td>
                                                    <button type="submit" name="confirm_cat_to_branch"
                                                        value="{{ $pending_request_item->id }}"
                                                        class="btn btn-success">تایید</button>

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
    </form>
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
