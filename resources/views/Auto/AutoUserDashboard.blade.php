@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .btnaria-header {
            margin-right: -7px;
            margin-bottom: -32px;
        }
    </style>

    <div class="breadcrumb">
        <h1>گروه ها</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                @foreach ($auto->get_groups_brif() as $user_group)
                    <div class="col-lg-3 col-md-4 col-sm-4">
                        <div class="card card-icon mb-4">
                            <div class="card-header text-center blue text-white font-weight-bold ">
                                گروه: {{ $user_group->name }}
                            </div>
                            <div class="card-body text-center">
                                @switch($user_group->auto_role_id)
                                    @case(1)
                                        <p class="text-warning">نقش: مدیر</p>
                                    @break

                                    @case(100)
                                        <p class="text-success">نقش: کاربر</p>
                                    @break

                                    @default
                                @endswitch
                                <p>تعداد اعضا: {{ $user_group->user_count }} نفر</p>

                                <div class="btnaria-header" style="display: flex">
                                    <a href="{{ route('group_work',['group_id'=>$user_group->id]) }}"
                                        class="btn btn-primary btn-block m-1 mb-3">ورورد به گروه <i class=" text-white"></i></a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>





    <!-- end of row-->

    <!-- end of row-->
@endsection

@section('page-js')
@endsection
