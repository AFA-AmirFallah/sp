@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/quill.snow.css') }}">
@endsection
@section('page-header-left')
    <h3>عملیات بیماران
        <small>روال کاری</small>
    </h3>
@endsection
@section('MainCountent')
    <div id="app">
        <Patdashboard></Patdashboard>
    </div>
    <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
    <input type="text" class="nested" id="UserName_page" value=" {{ $UserInfo->UserName }}">
    <div class="separator-breadcrumb border-top"></div>
    <div class="card user-profile o-hidden mb-4">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80 text-white">
            <h5 class="text-white"><i class=" header-icon i-Over-Time"></i>گردش کار : {{ $UserInfo->Name }} {{ $UserInfo->Family }}</h5>
        </div>
        <div class="card-body">
            @php
                $TargetDate = 'nu';
            @endphp
            <div class="tab-pane fade active show" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                @if ($SubTickets == null)
                    <p>هیچ فعالیتی ثبت نشده است!</p>
                @endif
                @foreach ($SubTickets as $SubTicket)
                    @if ($TargetDate != $Persian->MyPersianDate($SubTicket->created_at))
                        <ul class="timeline clearfix">
                            <li class="timeline-line"></li>
                            <li class="timeline-group text-center">
                                <button class="btn btn-icon-text btn-primary"><i class="i-Calendar-4"></i>
                                    {{ $TargetDate = $Persian->MyPersianDate($SubTicket->created_at) }}
                                </button>
                            </li>
                        </ul>
                    @endif
                    <ul class="timeline clearfix">
                        <li class="timeline-item">
                            <div class="timeline-card card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    {{ $Persian->MyPersianDate($SubTicket->created_at, true) }}
                                </div>
                                <div class="card-body">
                                    <div class="mb-1">
                                        <strong class="mr-1"> {{ $SubTicket->Name }} {{ $SubTicket->Family }}</strong>
                                    </div>
                                    @php
                                        echo $SubTicket->Text;
                                    @endphp
                                </div>
                            </div>
                        </li>
                    </ul>
                @endforeach

                <ul class="timeline clearfix">
                    <li class="timeline-line"></li>
                    <li class="timeline-group text-center">
                        <button class="btn btn-icon-text btn-warning"><i class="i-Calendar-4"></i>
                            {{ __('Created') }}

                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form method="post">
        <div class="card-body">
            @csrf
            <textarea id="hiddenArea" name="ce" class="form-control"></textarea>
            <hr>
            <input type="number" name="TiketID" class="nested" value="{{ $TiketID }}">
            <button id="identifier" class="btn btn-icon-text btn--full" name="submit" type="submit" value="replay">ثبت
                فرایند</button>

        </div>
    </form>
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'Workflow';
    </script>
@endsection
