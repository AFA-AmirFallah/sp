@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    @if ($result['result'])
        {!! $result['not_exist'] !!}
    @endif
    @if (!$result['result'])
        {!! $result['msg'] !!}
    @endif
@endsection
