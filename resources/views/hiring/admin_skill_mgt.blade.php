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
                                            <th>کد</th>
                                            <th>نام مهارت </th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skill_src as $skill_item)
                                            <tr>
                                                <td>{{$skill_item->UID}} </td>
                                                <td>{{$skill_item->Name}} </td>
                                                <td>غیر فعال</td>
                                                <td>
                                                    <button name="activate" value="{{$skill_item->UID}}" class="btn btn-success" >فعال سازی</button>
                                                </td>
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
