@extends("Layouts.MainPage")
@section("page-header-left")
@endsection
@section('MainCountent')
    <div class="ul-card-list__modal">
        <div class="modal fade add-device-contract-modal" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="device_model_title">{{__("Add device contract")}} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Contract type")}}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="TypeName" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Number of rent days")}}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="DurationDays" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("allow to use")}}</label>

                                <label class="checkbox checkbox-primary col-sm-10">
                                    <input type="checkbox" name="useable">
                                    <span>{{__("Show to operator to use this type of contract")}}</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="addcontract"
                                        class="btn btn-primary btn-rounded m-1">{{ __("Add record") }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ul-card-list__modal">
        <div class="modal fade edit-device-contract-modal" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="device_model_title">{{__("Add device contract")}} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Contract type")}}</label>
                                <div class="col-sm-10">
                                    <input class="form-control nested" id="Modal_DeviceContractID" name="DeviceContractID"
                                           value="">
                                    <input class="form-control" id="Modal_DeviceContractName" name="TypeName" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Number of rent days")}}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="Modal_DurationDays"
                                           name="DurationDays" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("allow to use")}}</label>

                                <label class="checkbox checkbox-primary col-sm-10">
                                    <input type="checkbox" id="Modal_useable" name="useable">
                                    <span>{{__("Show to operator to use this type of contract")}}</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="Editcontract"
                                        class="btn btn-primary btn-rounded m-1">{{ __("Edit") }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{__("Edit")}}
                            <small>{{__("Edit Contracts")}}</small>
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
    </div>
    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="row product-adding">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5>{{__("Devices contract list")}}:
                                <button id="addcontact" type="button" data-toggle="modal" style="float: left;"
                                        data-target=".add-device-contract-modal"
                                        class="btn btn-primary btn-md m-1">
                                    <i class="i-Add text-white mr-2"></i>{{__("Add device contract")}}
                                </button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="display: none">{{__("Code")}}</th>
                                        <th>{{__("Contract type")}}</th>
                                        <th>{{__("Number of rent days")}}</th>
                                        <th>{{__("allow to use")}}</th>
                                        <th>{{__('Actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($DeviceContractTypes == null)

                                    @else
                                        @foreach($DeviceContractTypes as $DeviceContractType)
                                            <tr>
                                                <td style="display: none">{{$DeviceContractType->ID}}</td>
                                                <td id="DeviceName_{{$DeviceContractType->ID}}"
                                                    name="{{$DeviceContractType->TypeName}}">{{$DeviceContractType->TypeName}}</td>
                                                <td id="DurationDays_{{$DeviceContractType->ID}}"
                                                    name="{{$DeviceContractType->DurationDays}}">{{$DeviceContractType->DurationDays}}</td>
                                                <td id="IsShow_{{$DeviceContractType->ID}}"
                                                    name="{{$DeviceContractType->IsShow}}">
                                                    @if($DeviceContractType->IsShow)
                                                        <i style="font-size: 33px;color: green;" class="i-Yes"></i>
                                                    @else
                                                        <i style="font-size: 33px;color: red;"
                                                           class="i-Close-Window"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button id="{{$DeviceContractType->ID}}" type="button"
                                                            data-toggle="modal"
                                                            data-target=".edit-device-contract-modal"
                                                            class="btn btn-danger btn-md m-1 edit_device_contract"
                                                            title="Edit">
                                                        <i class="i-Edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
    <!-- Container-fluid Ends-->

@endsection
@section('page-js')
    <script>
        $('.edit_device_contract').on('click', function () {
            var $selectID = $(this).attr('id');
            $('#Modal_DeviceContractID').val($selectID);
            $('#Modal_DeviceContractName').val($('#DeviceName_' + $selectID).attr('name'));
            $('#Modal_DurationDays').val($('#DurationDays_' + $selectID).attr('name'));
            $('#Modal_useable').val($('#IsShow_' + $selectID).attr('name'));
            if ($('#IsShow_' + $selectID).attr('name') == 1) {
                $('#Modal_useable').prop('checked', true);
            } else {
                $('#Modal_useable').prop('checked', false);
            }
        });
    </script>
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
