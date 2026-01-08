@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#patiantworks">
    <input class="nested" id="sub-menu" value="#patiant_dashboard">
    <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
    <div id="app">
        <Patdashboard></Patdashboard>
    </div>

@endsection
@section('page-js')
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName').val();
    </script>
@endsection
