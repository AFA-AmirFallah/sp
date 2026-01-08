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
    @include('hiring/objects/stepers_comments', ['target_step' => 3, 'id' => $id])
    <div class="main-content">
        <div data-sidebar-container="chat" class="card chat-sidebar-container sidebar-container">
            <div data-sidebar-content="chat" class="chat-content-wrap sidebar-content" style="margin-left: 0px;">
                <div class="d-flex pl-3 pr-3 pt-2 pb-2 o-hidden box-shadow-1 chat-topbar">
                    <a data-sidebar-toggle="chat" class="link-icon d-md-none">
                        <i class="icon-regular i-Right ml-0 mr-3"></i>
                    </a>
                    <div class="d-flex align-items-center">
                        <p class="m-0 text-title text-16 flex-grow-1">گزارش اقدامات و عملکرد کارشناسان</p>
                    </div>
                </div>
                <div class="chat-content perfect-scrollbar ps" data-suppress-scroll-x="true">

                    @foreach ($report_src as $report_item)
                        <div class="d-flex mb-4 user">
                            @switch($report_item->report_type)
                                @case(1)
                                    <div class="primary-report-avatar avatar-sm rounded-circle mr-3">
                                        <i class="i-Speach-Bubble-4"></i>
                                    </div>
                                @break
                                @case(2)
                                    <div class="success-report-avatar avatar-sm rounded-circle mr-3">
                                        <i class="i-Flag"></i>
                                    </div>
                                @break
                                @case(3)
                                    <div class="warning-report-avatar avatar-sm rounded-circle mr-3">
                                        <i class="i-Bell1"></i>
                                    </div>
                                @break
                                @case(4)
                                    <div class="danger-report-avatar avatar-sm rounded-circle mr-3">
                                        <i class="i-Danger"></i>
                                    </div>
                                @break

                                @default
                            @endswitch

                            <div class="success message flex-grow-1">
                                <div class="d-flex">
                                    <p class="mb-1 text-title text-16 flex-grow-1">{{ $report_item->reporter_Name }}
                                        {{ $report_item->reporter_family }}</p>
                                    <span
                                        class="text-small text-muted">{{ $Persian->int_date($report_item->report_time) }}</span>
                                </div>
                                <p class="m-0">{{ $report_item->report_text }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                    </div>
                </div>
                <div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">
                    <form method="POST" class="inputForm">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control form-control-rounded" required placeholder="متن گزارش" name="report"
                                id="message" cols="30" rows="3"></textarea>
                        </div>
                        <div class="d-flex">
                            <div class="flex-grow-1"></div>
                            <button class="btn btn-icon btn-rounded btn-outline-primary" type="submit" name="add_report"
                                value="1">
                                <i class="i-Add-File"></i>
                            </button> <button class="btn btn-icon btn-rounded btn-outline-success" type="submit"
                                name="add_report" value="2">
                                <i class="i-Add-File"></i>
                            </button> <button class="btn btn-icon btn-rounded btn-outline-warning" type="submit"
                                name="add_report" value="3">
                                <i class="i-Add-File"></i>
                            </button><button class="btn btn-icon btn-rounded btn-outline-danger" type="submit"
                                name="add_report" value="4">
                                <i class="i-Add-File"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


    </div>

@endsection
@section('page-js')

@endsection
