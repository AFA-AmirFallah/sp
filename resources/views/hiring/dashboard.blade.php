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

@endsection
@section('page-js')
    @include('Layouts.SearchUserInput_Js')

    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
        @include('Layouts.FilemanagerScripts')
    @endif
@endsection
