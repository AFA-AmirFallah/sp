@php
    $Persian= new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section("page-header-left")
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{__("setting")}}
                            <small>{{__("Customers settings")}}</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">{{__("Assign shift with paste date")}}</h3>
                    </div>

                    <!--begin::form-->
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" name="value" value="true"
                                               @if($ShiftWithPasteTime == "true" )
                                               checked
                                               @endif
                                               formcontrolname="radio">
                                        <span>{{__("Enable")}}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="radio radio-outline-secondary">
                                        <input type="radio" name="value" value="false"
                                               @if($ShiftWithPasteTime == "false" )
                                               checked
                                               @endif
                                               formcontrolname="radio">
                                        <span>{{__("Disable")}}</span>
                                        <span class="checkmark"></span>
                                    </label>

                                </div>

                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="ShiftWithPasteTime"
                                                class="btn  btn-primary m-1">{{__("Submit")}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-js')

@endsection
