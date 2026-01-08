@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

@section('Content')
        <div id="app" class="container-xxl flex-grow-1 container-p-y">

            <Crypto-Analyzer></Crypto-Analyzer>
        </div>

       
@endsection
@section('EndScripts')
@endsection
