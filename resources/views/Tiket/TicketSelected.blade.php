@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.snow.css') }}">
@endsection
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <div class="breadcrumb">
        <h1>{{ __('Ticket') }}</h1>
        <ul>
            <li>{{ __('TicketView') }}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card user-profile o-hidden mb-4">
        <div class="card-body">
            <div class="tab-pane fade active show" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                @foreach ($SubTickets as $SubTicket)
                    <ul class="timeline clearfix">
                        @if ($SubTicket->FromUser == Auth::ID())
                            <li class="timeline-item"></li>
                        @endif
                        <li class="timeline-item">
                            <div class="timeline-badge">
                                @if ($SubTicket->FromUser == Auth::ID())
                                    <i class="badge-icon bg-primary text-white i-Ticket"></i>
                                @else
                                    <i class="badge-icon bg-warning text-white i-Ticket"></i>
                                @endif
                            </div>
                            <div class="timeline-card card">
                                <div class="card-body">
                                    <div class="mb-1">
                                        <strong class="mr-1"> {{ $SubTicket->UserInfoName }}</strong>
                                    </div>
                                    @php
                                        echo $SubTicket->Text;
                                    @endphp
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="timeline clearfix">
                        <li class="timeline-line"></li>
                        <li class="timeline-group text-center">
                            <button class="btn btn-icon-text btn-primary"><i class="i-Calendar-4"></i>
                                {{ $Persian->MyPersianDate($SubTicket->CreateDate) }}
                            </button>
                        </li>
                    </ul>
                @endforeach
                <ul class="timeline clearfix">
                    <div class="timeline-item"></div>
                    <li class="timeline-item">
                        <div class="timeline-badge">
                            <i class="badge-icon bg-primary text-white i-Ticket"></i>
                        </div>
                        <div class="timeline-card card">
                            <div class="card-body">
                                <div class="mb-1">
                                    <strong class="mr-1"> {{ $MainTicket->UserInfoName }}
                                    </strong>{{ $MainTicket->Subject }}
                                </div>
                                @php
                                    echo $MainTicket->Text;
                                @endphp
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="timeline clearfix">
                    <li class="timeline-line"></li>
                    <li class="timeline-group text-center">
                        <button class="btn btn-icon-text btn-warning"><i class="i-Calendar-4"></i> {{ __('Created') }}
                            {{ $Persian->MyPersianDate($MainTicket->CreateDate) }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form method="post">
        <div class="card-body">
            @csrf
            @if (Auth::user()->Role >= App\myappenv::role_admin)
                <textarea id="hiddenArea" name="ce" class="form-control"></textarea>
                <hr>
            @else
                <textarea placeholder="پاسخ به تیکت" name="cee" class="form-control"></textarea>
                <hr>
            @endif

            <button id="identifier" class="btn btn-icon-text btn--full" name="submit" type="submit"
                value="replay">{{ __('SendReply') }}</button>

        </div>
    </form>
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
@endsection
