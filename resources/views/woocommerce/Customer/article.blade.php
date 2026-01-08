@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection


@section('page-header-left')
@endsection
@section('MainCountent')
{!! $posts->Content !!}
@endsection

@section('bottom-js')

@endsection
