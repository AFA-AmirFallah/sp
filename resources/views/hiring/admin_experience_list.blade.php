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
    @include('hiring/objects/header')


    <div class="row">
        <div id="table-continer" class=" col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Receipt"></i> گزارشات باز</h3>
                    <div class="dropdown dropleft text-right w-50 float-right">
                        <button class="btn btn-primary" type="button" id="dropdownMenuButton_table_1" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon i-Gear-2"></i>
                        </button>
                        <div class="dropdown-menu " aria-labelledby="dropdownMenuButton_table_1">
                            <a class="dropdown-item" onclick="multiselect()">انتخاب چند کاربر</a>
                            <div id="multi-user-option" class="nested">
                                <a class="dropdown-item" onclick="selectalloptions()" href="#">انتخاب همه</a>
                                <a class="dropdown-item" onclick="deselecttalloptions()" href="#">حذف همه</a>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-body">


                    <form method="post">

                        @csrf
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>کد</th>
                                            <th>ثبت کننده</th>
                                            <th>نیرو</th>
                                            <th>رضایت</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments_src as $comments_item)
                                            <tr>
                                                <td>{{ $comments_item->id }}</td>
                                                <td>{{ $comments_item->cname }} {{ $comments_item->cfamily }}</td>
                                                <td>{{ $comments_item->Name }}</td>
                                                <td>{{ $comments_item->rate }}</td>
                                                <td>{{ $Persian->MyPersianDate($comments_item->created_at) }}</td>
                                                <td>
                                                    {{ $comments->get_comment_state_text($comments_item->status) }}
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{route('admin_single_experience',['id'=>$comments_item->id])}}">نمایش</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                        <button type="submit" name="submit" class="btn btn-success select-div nested" value="tmpsave">ثبت
                            موقت کاربران</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
@endsection
@section('page-js')
@endsection
