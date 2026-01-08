@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <form method="POST">
        @csrf
        <div class="auth-content">

            <div class="card user-profile o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h2 class="text-white"><img width="100px" src="{{ $branch->avatar }}" alt="">
                        {{ $branch->Description }}</h2>
                </div>
                <div class="card-body" style="text-align: center ; ">
                    <h5>مبلغ: <span> {{ number_format($CreditSrc->Mony) }} ریال </span></h5>
                    <h5> واریز به : <span>{{ $branch->Name }} - {{ $branch->Description }} </span> </h5>
                    <h5> موضوع: <span> {{ $CreditSrc->Note }} </span></h5>
                    <h5>تاریخ صدور: <span> {{ $Persian->MyPersianDate($CreditSrc->Date, true) }} </span></h5>
                    <hr>
                    <div class="row" style="text-align: center">
                        <label style="margin: 10px" class="radio radio-outline-primary">
                            <input type="radio" checked name="radio" value="{{ App\myappenv::Bank }}"
                                formcontrolname="radio">
                            <img style="max-width: 80px;" src="{{ App\myappenv::ipg_info['img'] }}">
                            <span>{{ App\myappenv::ipg_info['fa_name'] }} </span>

                            <span class="checkmark"></span>
                        </label>
                        @if ($loan == 'azki')
                            <label style="margin: 10px" class="radio radio-outline-primary">
                                <input type="radio" checked name="radio" value="azki" formcontrolname="radio">
                                <img style="max-width: 80px;"
                                    src="https://panel.shafatel.com/storage/photos/logo/azkivam.svg">
                                <span>ازکی وام</span>

                                <span class="checkmark"></span>
                            </label>
                        @endif

                    </div>


                </div>
                <div class="card-footer bg-transparent">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" name="submit" value="Trnsfer"
                                    class="btn  btn-primary m-1">پرداخت</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </form>
@endsection

@section('page-js')
    <script></script>
@endsection

@section('bottom-js')
@endsection
