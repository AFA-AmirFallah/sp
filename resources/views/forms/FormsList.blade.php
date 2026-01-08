@php
    $MyImage = new \App\Functions\Images();
    $Persian = new \App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#form_mgt">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('MakeForm') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary"> افزودن فرم</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('FormsList') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">لیست فرمها</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="color: orange" class="i-Pen-4"></i>
                    <div class="content">
                        <p class="text-primary mt-2 mb-0">ویرایش فرم</p>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class="header-icon i-File"></i>فرم های سامانه</h5>

                    </div>
                    <form method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="Post_table" class="{{ \App\myappenv::MainTableClass }}">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Number') }}</th>

                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Date of enter') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>ثبت کننده</th>
                                            <th>متعلق به </th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($forms_src as $FormTarget)
                                            <tr>
                                                <td>{{ $FormTarget->id }}</td>
                                                <td style="overflow-wrap: anywhere;">
                                                    {{ $FormTarget->title }}

                                                </td>
                                                <td>{{ $Persian->MyPersianDate($FormTarget->created_at) }}</td>
                                                <td id="status_{{ $FormTarget->id }}" name="{{ $FormTarget->Status }}">
                                                    @foreach (\App\myappenv::PostStatus as $PostStatusItem)
                                                        @if ($PostStatusItem[0] == $FormTarget->Status)
                                                            {{ $PostStatusItem[1] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $FormTarget->adminPrevilage }}

                                                </td>
                                                <td>
                                                    {{ $FormTarget->userPrevilage }}

                                                </td>
                                                <td>
                                                    <a href="{{ route('EditForm', ['form_id' => $FormTarget->id]) }}"
                                                        class="btn bg-white _r_btn border-0">ویرایش
                                                    </a>
                                                    <button type="button" class="btn bg-white _r_btn border-0"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start"
                                                        style="position: absolute; text-align: right; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        @foreach (\App\myappenv::PostStatus as $PostStatus)
                                                            <a class="dropdown-item ul-widget__link--font"
                                                                onclick="ChangeNewsStatus({{ $FormTarget->id }},{{ $PostStatus[0] }},'{{ $PostStatus[1] }}')">
                                                                <i class="i-Data-Save"> </i>
                                                                {{ $PostStatus[1] }}
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </select>
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>

    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#Post_table').DataTable();
    </script>
    <script>
        function ChangeNewsStatus($FormID, $TargetStatus, $TargetStatusName) {
            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            var $oldvalue = $('#status_' + $FormID).html();
            $('#status_' + $FormID).html($loader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'ChangeFormStatus',
                    FormID: $FormID,
                    TargetStatus: $TargetStatus,
                },

                function(data, status) {
                    if (data == '1') {
                        $('#status_' + $FormID).html($TargetStatusName);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                        $('#status_' + $FormID).html($oldvalue);
                    }
                });


        }
    </script>
@endsection
