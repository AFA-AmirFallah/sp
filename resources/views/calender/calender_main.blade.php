@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/calendar/fullcalendar.min.css') }}">
@endsection
@section('MainCountent')
    <div class="breadcrumb">
        <h1>{{ __('Calendar') }}</h1>
        <ul>
            <li><a href="">{{ __('Apps') }}</a></li>
            <li>{{ __('Calendar') }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="create_event_wrap">
                        <form class="js-form-add-event">
                            <div class="form-group">
                                <label for="newEvent"> {{ __('Create new Event') }}</label>
                                <input type="text" name="newEvent" id="newEvent" class="form-control"
                                    placeholder="{{ __('new Event') }}" aria-describedby="helpId">

                            </div>


                        </form>


                        <ul class="list-group" id="external-events">
                            <li class="list-group-item bg-success fc-event">
                               پروژه اول

                            </li>
                            <li class="list-group-item bg-primary fc-event">

                                {{ __('Go to Shopping') }}
                            </li>
                            <li class="list-group-item bg-warning fc-event">

                                {{ __('Payment schedule') }}
                            </li>
                            <li class="list-group-item bg-danger fc-event">

                                {{ __('Rent Due') }}
                            </li>
                        </ul>
                        <p>
                            <input type='checkbox' id='drop-remove' />
                            <label for='drop-remove'>{{ __('remove after drop') }}</label>
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-4 o-hidden">
                <div class="card-body">
                    <div id="calendar"></div>


                </div>
            </div>
        </div>

    </div>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/calendar/fa_jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/calendar/fa_moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/calendar/fa_fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/calendar.script.js') }}"></script>
@endsection
