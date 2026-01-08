@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <style>
        .label_red {
            color: red;
        }
    </style>
    @include('hiring/objects/header')

    <div class="separator-breadcrumb border-top"></div>

    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4"> 
                <div class="card text-left">
                    <div class="card-body">
                        <div class="table-responsive">
                            <form method="POST" name="object">
                                @csrf
                                <table id="ul-contact-list" class="display table " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>نام</th>
                                            <th>نام خانوادگی</th>
                                            <th>شماره تماس</th>
                                            <td>تاریخ ثبت</td>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user_src as $user_item)
                                            <tr>
                                                <td>{{$user_item->Name}}</td>
                                                <td>{{$user_item->Family}}</td>
                                                <td>{{$user_item->MobileNo}}</td>
                                                <td>{{$Persian->MyPersianDate($user_item->CreateDate)}}</td>
                                                <td><a target="_blank" href="{{route('UserProfile',['RequestUser'=>$user_item->UserName])}}">ویرایش</a> </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </form>
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

@endsection
@section('bottom-js')
@endsection
