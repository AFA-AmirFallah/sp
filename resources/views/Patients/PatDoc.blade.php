@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    @if (Auth::user()->Role == \App\myappenv::role_customer)
        <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
        <div id="app">
            <patascustomer></patascustomer>
        </div>
    @else
        <div id="app">
            <Patdashboard></Patdashboard>
        </div>
    @endif
    <div class="ul-card-list__modal">
        <div class="modal fade add-device-contract-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h6 id="modal_header"></h6>
                        <button style="display: contents" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>

                    <div id="modal_body" class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
    <input type="text" class="nested" id="UserName_page" value=" {{ $PatiantInfo->UserName }}">

    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80" style="text-align: right">
                        <h5 class="text-white"><i class="header-icon i-File"></i> {{ __('Electronic document') }}</h5>
                        <small class="text-white">{{ $PatiantInfo->Name }} {{ $PatiantInfo->Family }}</small>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>شماره </th>
                                        <th>نام فرم</th>
                                        <th>توسط</th>
                                        <th>تارخ ثبت</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($FormSrc as $FormItem)
                                        @php
                                            $MainFields = json_decode($FormItem->extra);
                                            $MainFields = $MainFields->FormSrc;
                                            
                                        @endphp
                                        <tr>
                                            <td>{{ $FormItem->SubParvandehID }} </td>
                                            <td>{{ $MainFields->title }} </td>
                                            <td>{{ $FormItem->creatorName }} {{ $FormItem->creatorFamily }} </td>
                                            <td>{{ $Persian->MyPersianDate($FormItem->created_at, 1) }} </td>
                                            <td> <button
                                                    onclick="modal_loader(`{{ $FormItem->html_content }}` , `{{ $MainFields->title }}` )"
                                                    data-toggle="modal" data-target=".add-device-contract-modal"
                                                    type="button" class="btn btn-success">نمایش</button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('bottom-js')
    <script>
        function modal_loader($modal_body, $modal_header) {
            $('#modal_body').html('');
            $("#modal_header").text('');
            $('#modal_body').html($modal_body);
            $("#modal_header").text($modal_header);
            var sList = "";
            $('input[type=checkbox]').each(function() {

                if (this.disabled) {
                    this.checked = true;
                } else {
                    $(this).addClass('nested');
                }

            });


        }
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'PatDoc';
    </script>
@endsection
