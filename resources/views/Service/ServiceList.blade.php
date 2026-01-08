@php
    $MyImage = new \App\Functions\Images();
@endphp
@extends('Layouts.MainPage')

@section('MainCountent')
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#Services_mgt">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('Addservice') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary"> افزودن خدمت</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('ServiceList') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">لیست خدمات</p>

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
                        <p class="text-primary mt-2 mb-0">ویرایش خدمت</p>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Loading-2"></i>{{ __('Services list') }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        @if (App\myappenv::version < 3)
                                            <th>{{ __('Service code') }}</th>
                                            <th>{{ __('Service picture') }}</th>
                                        @endif
                                        <th>{{ __('Service name') }}</th>
                                        <th>{{ __('Get price') }}</th>
                                        <th>{{ __('Pay price') }}</th>
                                        <th>{{ __('Financial index') }}</th>
                                        <th>{{ __('Service index') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Services as $Service)
                                        <tr>
                                            @if (App\myappenv::version < 3)
                                                <td>
                                                    {{ $Service->center_id }}
                                                </td>
                                                <td name="">
                                                    <img style="width: 60px" src="{{ $Service->ImgURL }}" />
                                                </td>
                                            @endif
                                            <td> {{ $Service->RespnsTypeName }}</td>
                                            @if ($Service->hPrice != 0)
                                                <td>{{ number_format($Service->CustomerhPrice) }} ساعتی </td>
                                                <td>{{ number_format($Service->hPrice) }} ساعتی </td>
                                            @else
                                                <td>{{ number_format($Service->CustomerfixPrice) }} جلسه </td>
                                                <td>{{ number_format($Service->fixPrice) }} جلسه </td>
                                            @endif
                                            <td>{{ $Service->IndexName }}</td>
                                            <td>{{ $Service->Minindexname }}</td>
                                            <td>
                                                <a target="_blank"
                                                    href="{{ route('Editservice', ['ServiceID' => $Service->RespnsTypeID]) }}"
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
