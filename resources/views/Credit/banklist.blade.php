@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <div class="breadcrumb">
        <h1>لیست بانکها</h1>

    </div>
    <div class="separator-breadcrumb border-top"></div>
    <section class="basic-action-bar">
        <div class="card">
            @if ($BankArr == [])
                <p>هیچ بانکی تعریف نشده است.</p>
            @else
                @foreach ($BankArr as $BankArrItem)
                    <div style="background-color: {{ $BankArrItem['backcolor'] }} !important"
                        class="p-4 rounded d-flex align-items-center bg-primary text-white">
                        @isset($BankArrItem['avatar'])
                            <img width="50px" style="margin-left: 10px;" src="{{ $BankArrItem['avatar'] }}"
                                alt="{{ $BankArrItem['BankName'] }}">
                        @else
                            <i style="font-size: 49px;margin-left: 30px;" class="sidebar-icon-style nav-icon i-Money-Bag "></i>
                        @endisset

                        <div>
                            <h4 class="text-18 mb-1 text-white">{{ $BankArrItem['BankName'] }}</h4>
                            <span> موجودی فعلی: {{ number_format($BankArrItem['Mony']) }} ریال</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection
@section('page-js')
@endsection
