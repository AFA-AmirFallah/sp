@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت
                            <small> المانهای HTML</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>محتوای المان</h5>
                        <img id="imagepreviw" style="float: left;max-height: 100px;" src="">
                        <a class="btn btn-warning" href="{{ route('HtmlObj', ['Cat' => 'add']) }}">افزودن المان</a>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="table-responsive">
                                <table id="ul-contact-list" class="display table " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>کد</th>
                                            <th>نام</th>
                                            @if (App\myappenv::Lic['MultiBranch'])
                                                <th>شعبه</th>
                                            @endif
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form method="POST">
                                            @csrf
                                            @foreach ($html_object as $html_objectItem)
                                                <tr>
                                                    <td>
                                                        {{ $html_objectItem->id }}
                                                    </td>
                                                    <td>
                                                        {{ $html_objectItem->htmlname }}
                                                    </td>
                                                    @if (App\myappenv::Lic['MultiBranch'])
                                                        <th>{{ $html_objectItem->branch_name }}</th>
                                                    @endif
                                                    <td>
                                                        <a class="btn btn-default"
                                                            href="{{ route('HtmlObj', ['Cat' => $html_objectItem->id]) }}">ویرایش</a>
                                                        <button class="btn btn-danger" type="submit" name="delete"
                                                            value="{{ $html_objectItem->id }}">حذف</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </form>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
@endsection
