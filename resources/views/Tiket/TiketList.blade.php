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
    <div class="breadcrumb">
        <h1>{{ __('Ticket') }}</h1>
        <ul>
            <li><a href="">{{ __('Tickets') }}</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header text-right bg-transparent">
                        <button id="addobject" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                            class="btn btn-primary btn-md m-1"><i
                                class="i-Ticket text-white mr-2"></i>{{ __('Send ticket') }}
                        </button>
                    </div>
                    <!-- begin::modal -->
                    <div class="ul-card-list__modal">
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form method="post">
                                            @csrf
                                            <div class="form-group row">
                                                <input style="visibility:hidden" id="tableID" name="tableid">
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName"
                                                    class="col-sm-2 col-form-label">{{ __('Receiver') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="ToUser" class="form-control">
                                                        @foreach ($ticket_recivers as $ticket_reciver)
                                                            <option value="{{ $ticket_reciver->id }}">
                                                                {{ $ticket_reciver->TicketText }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName"
                                                    class="col-sm-2 col-form-label">{{ __('Topic') }}</label>
                                                <div class="col-sm-10">

                                                    <input type="text" class="form-control" required name="subject" id=""
                                                        placeholder="{{ __('Ticket subject') }}" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName"
                                                    class="col-sm-2 col-form-label">{{ __('Priority') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="TicketPeriority" class="form-control">
                                                        @foreach (\App\myappenv::TicketPeriority as $Periority)
                                                            <option value="{{ $Periority[0] }}">
                                                                {{ __($Periority[1]) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <label for="inputName"
                                                class="col-sm-2 col-form-label">{{ __('TicketText') }}</label>
                                            <div class="input-right-icon">
                                                <textarea name="cee" required class="form-control"></textarea>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <button id="addelement" type="submit" name="submit" value="add"
                                                        class="btn btn-success">{{ __('Send') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end::modal -->
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('TrackingCode') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Priority') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Tickets as $Ticket)
                                            <tr id="tr_{{ $Ticket->TicketID }}">
                                                <td id="id_{{ $Ticket->TicketID }}">
                                                    <a href="{{ route('tikets', $Ticket->TicketID) }}">
                                                        {{ $Ticket->TicketID }}
                                                    </a>
                                                </td>
                                                <td id="Subject_{{ $Ticket->TicketID }}" name="{{ $Ticket->Subject }}">
                                                    {{ $Ticket->Subject }}</td>
                                                <td id="CreateDate_{{ $Ticket->TicketID }}"
                                                    name="{{ $Ticket->CreateDate }}">
                                                    {{ $Persian->MyPersianDate($Ticket->CreateDate) }}</td>
                                                <td id="Priority_{{ $Ticket->TicketID }}" name="{{ $Ticket->Priority }}">
                                                    @foreach (\App\myappenv::TicketPeriority as $Periority)
                                                        @if ($Periority[0] == $Ticket->Priority)
                                                            {{ __($Periority[1]) }}
                                                        @endif
                                                    @endforeach

                                                </td>
                                                <td id="State_{{ $Ticket->State }}" name="{{ $Ticket->State }}">
                                                    @foreach (\App\myappenv::TicketState as $State)
                                                        @if ($State[0] == $Ticket->State)
                                                            {{ __($State[1]) }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
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
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable({
        "order": [[ 0, "desc" ]]
    });
    </script>
@endsection
