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
    @include('deal/objects/stepers', ['target_step' => 4, 'file_id' => $file_id])

    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h5>کارشناسان مربوط به : {{ $deal_src->title }}</h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="col-lg-12 col-md-12 mb-4">
                                    <div class="form-group ul-form-group d-flex align-items-center">
                                        <select name="oprator" class="form-control ul-form-input">
                                            <option value="0">انتخاب کارشناس</option>
                                            @foreach ($operator_src as $operator_item)
                                                <option value="{{ $operator_item->UserName }}">{{ $operator_item->Name }}
                                                    {{ $operator_item->Family }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" name="submit" value="add_operator"
                                            class="btn btn-success">افزودن کارشناس</button>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($dealers as $dealer_item)
                                                <div class="ul-contact-page__profile">
                                                    <div class="user-profile">
                                                        <img class="profile-picture mb-2"
                                                            src="@if ($dealer_item->avatar == null || $dealer_item->avatar == '') {{ App\myappenv::LoginUserAvatarPic }}@else{{ $dealer_item->avatar }} @endif"
                                                            alt="">
                                                    </div>
                                                    <div class="ul-contact-page__info">
                                                        <p class="m-0 text-24">{{ $dealer_item->Name }}
                                                            {{ $dealer_item->Family }}</p>
                                                        <p class="text-muted m-0">{{ $dealer_item->MobileNo }}</p>
                                                        <button class="btn btn-danger" type="submit" name="delete"
                                                            value="{{ $dealer_item->UserName }}">حذف
                                                            کارشناس</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </form>
@endsection
@section('page-js')
@endsection
