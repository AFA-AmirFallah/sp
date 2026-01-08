@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme5.layout.main_layout')
@section('content')
    <main class="main-content dt-sl mb-3">
        <div class="container main-container">
            <!-- Start title - breadcrumb -->
            <div class="post-thumbnail dt-sl">
                <img  src="{{ $posts->MainPic }}">
            </div>
            <div class="title-breadcrumb-special dt-sl">
                <div class="title-page dt-sl">
                    <h1>{{ $posts->Titel }}</h1>
                </div>
                @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                    <a style="float: left;" href="{{ route('EditNews', [$posts->id]) }}"><i class="fa fa-pencil"></i></a>
                    <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                @endif
            </div>
            <!-- End title - breadcrumb -->
            <div class="row">
                <div class="col-lg-12 col-md-8 col-sm-12 col-12 mb-3">
                    <div class="content-page">
                        <div class="content-desc dt-sn dt-sl">
                            <header class="entry-header dt-sl mb-3">
                            </header>
                            {!! $posts->Content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('end_script')
@endsection
