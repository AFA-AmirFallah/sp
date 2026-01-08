@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .label_red {
            color: red;
        }
    </style>

    @include('deal/objects/header')
    <div class="row">
        <div id="table-continer" class=" col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Business-Mens"></i> لیست فایل ها </h3>
                </div>
                <div class="card-body">


                    <form method="post">

                        @csrf
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>مورد معامله</th>
                                            <th>وضعیت</th>
                                            <th>شعبه</th>
                                            <th>تاریخ ثبت</th>
                                            <th>کارشناس</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $Rowno = 1;
                                        @endphp
                                        @foreach ($deals_src as $deals_item)
                                            <tr>
                                                <td>{{ $Rowno++ }}</td>
                                                <td>{{ $deals_item->title }} </td>
                                                <td>
                                                    @switch($deals_item->status)
                                                        @case(0)
                                                            غیر فعال
                                                        @break

                                                        @case(101)
                                                            فعال
                                                        @break

                                                        @default
                                                            نامشخص
                                                    @endswitch
                                                </td>
                                                <td>{{$deals_item->branch_name}}</td>
                                                <td>
                                                    {{ $Persian->MyPersianDate($deals_item->created_at) }}
                                                </td>
                                                <td>
                                                    {{ $deals_item->operator }}
                                                </td>
                                                <td>
                                                    <a href="{{route('edit_file',['file_id'=>$deals_item->id])}}" title="ویرایش فایل">
                                                        <i style="font-size: 20px" class="i-Edit"></i>
                                                    </a>
                                                </td>


                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
@endsection
@section('page-js')
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection
