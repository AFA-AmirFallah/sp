@php
    $Persian= new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section("page-header-left")
    <h3>{{__('Pats')}}
        <small>{{__('My pats')}}</small>
    </h3>
@endsection
@section('MainCountent')

    <div class="breadcrumb">
        <h1>{{__("setting")}}</h1>
        <ul>
            <li><a href="">{{ __('Tickets')}}</a></li>
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
                                class="i-Ticket text-white mr-2"></i>{{__("Resiver define")}}
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
                                                       class="col-sm-2 col-form-label">{{__("Reciver Role")}}</label>
                                                <div class="col-sm-10">

                                                    <input type="text" class="form-control" name="TicketText"

                                                           placeholder={{__("Reciver Role")}} value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName"
                                                       class="col-sm-2 col-form-label">{{__("Username")}} {{__("Receiver")}} </label>
                                                <div class="col-sm-10">

                                                    <input type="text" class="form-control" name="TickeReciver"

                                                           placeholder="Username" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <button id="addelement" type="submit" name="submit" value="add"
                                                            class="btn btn-success">{{ __("save")}}
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
                                <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>{{__("Unique ID")}}</th>
                                        <th>{{__("Resiver")}}</th>
                                        <th>{{__("Username")}} {{__("Resiver")}}</th>
                                        <th>{{__("Actions")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ticket_recivers as $ticket_reciver)
                                        <tr>
                                            <td>{{$ticket_reciver->id}}</td>
                                            <td>{{$ticket_reciver->TicketText}}</td>
                                            <td>{{$ticket_reciver->TickeReciver}}</td>
                                            <td>
                                                <button type="submit" name="DeleteReciver"
                                                        value="{{$ticket_reciver->id}}" class="text-success mr-2"
                                                        style="width: 30px;height: 30px;padding-left: 0px;
                                            padding-right: 0px; border: 2px solid #ffffff;background-color: white;">
                                                    <i class="nav-icon i-Close-Window font-weight-bold"></i></button>
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


    @if(app()->getLocale() == 'fa')
        <script src="{{asset('assets/js/vendor/datatables.min.fa.js')}}"></script>
    @else
        <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection

