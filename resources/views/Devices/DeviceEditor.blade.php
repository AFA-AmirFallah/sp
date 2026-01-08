@extends("Layouts.MainPage")
@section("page-header-left")
@endsection
@section('MainCountent')
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row nested" >
                                    <input class="form-control" id="modal_metadeviceid" name="metadeviceid" value="">
                            </div>
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Device Type")}}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_metadevicename" name="DeviceName"  value="">
                                </div>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="EditeMetaDevice"
                                        class="btn btn-primary btn-rounded m-1">{{ __("Edit") }}</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ul-card-list__modal">
        <div class="modal fade add-device-meta-modal" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Device Type")}}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="DeviceName"  value="">
                                </div>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="AddMetaDevice"
                                        class="btn btn-primary btn-rounded m-1">{{ __("Add record") }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ul-card-list__modal">
        <div class="modal fade add-device-model-modal" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="device_model_title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Device model")}}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="DeviceName"  value="">
                                    <input class="form-control nested" id="Devicemodelmodaladdmodel" name="DeviceType"  value="">

                                </div>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="AddModelDevice"
                                        class="btn btn-primary btn-rounded m-1">{{ __("Add record") }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ul-card-list__modal">
        <div class="modal fade edit-device-model-modal" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="device_model_edite_title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName"
                                       class="col-sm-2 col-form-label">{{ __("Device model")}}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="EditesubDeviceName" name="DeviceName"  value="">
                                    <input class="form-control  nested" id="Devicemodelmodaleditmodel" name="DeviceModel"  value="">
                                </div>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="EditModelDevice"
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
                            <small>{{__("Edit devices")}}</small>
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
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5>{{__("Device Type")}}:
                                <button id="addcontact" type="button" data-toggle="modal" style="float: left;"
                                        data-target=".add-device-meta-modal"
                                        class="btn btn-primary btn-md m-1">
                                    <i class="i-Add text-white mr-2"></i>{{__("Adding device meta")}}
                                </button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="display: none">{{__("Device code")}}</th>
                                        <th>{{__("Device Type")}}</th>
                                        <th>{{__('Actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($DeviceMetas == null)

                                    @else
                                        @foreach($DeviceMetas as $DeviceMeta)
                                            <tr>
                                                <td style="display: none">{{$DeviceMeta->ID}}</td>
                                                <td id="DeviceName_{{$DeviceMeta->ID}}"
                                                    name="{{$DeviceMeta->DeviceName}}">{{$DeviceMeta->DeviceName}}</td>
                                                <td>
                                                    <button id="{{$DeviceMeta->ID}}" type="button" data-toggle="modal"
                                                            data-target=".bd-example-modal-lg"
                                                            class="btn btn-danger btn-md m-1 edit_device_meta"
                                                            title="Edit">
                                                        <i class="i-Edit"></i>
                                                    </button>
                                                    <button id="{{$DeviceMeta->ID}}" type="button"
                                                            class="btn btn-primary btn-md m-1 edit_btn_account"
                                                            title="Sublayer list">
                                                        <i class="i-Letter-Open"></i>
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
                <div class="col-xl-5">

                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 id="device_model_name" >{{__("Device model")}}:
                                <small id="DeviceSelectedType">

                                </small>

                                <button id="addcontact" type="button" data-toggle="modal" style="float: left;"
                                        data-target=".add-device-model-modal"
                                        class="btn btn-primary btn-md m-1">
                                    <i class="i-Folder-Add- text-white mr-2"></i>{{__("Adding device model")}}
                                </button>
                            </h5>


                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>{{__("Device code")}}</th>
                                        <th>{{__("Device Type")}}</th>
                                        <th>{{__('Actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $Rowno = 1;
                                    @endphp
                                    @if($DeviceMetas == null)

                                    @else
                                        @foreach($DeviceTypes as $DeviceType)
                                            <tr class="devicetype_{{$DeviceType->MetaID}} devicetypes nested">
                                                <td>{{$DeviceType->ID}}</td>
                                                <td id="DeviceNameSub_{{$DeviceType->ID}}"
                                                    name="{{$DeviceType->DeviceName}}">{{$DeviceType->DeviceName}}</td>
                                                <td>
                                                    <button id="{{$DeviceType->ID}}" type="button" data-toggle="modal"
                                                            data-target=".edit-device-model-modal"
                                                            class="btn btn-primary btn-md m-1 edit_btn_DeviceType"
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
        $('.edit_btn_account').on('click', function () {
            var $selectID = $(this).attr('id');

            //  alert($selectID);
            var $befortext = "تجهیزات زیر مجموعه ";
            $('.devicetypes').addClass('nested');
            $('.devicetype_' + $selectID).removeClass('nested');
            $("#DeviceSelectedType").html( $('#DeviceName_'+$selectID).attr('name') );
            $("#device_model_title").html( $befortext + $('#DeviceName_'+$selectID).attr('name'));
            $("#device_model_edite_title").html( $befortext + $('#DeviceName_'+$selectID).attr('name'));
            $('#Devicemodelmodaladdmodel').val($selectID);
        });
    </script>
    <script>
        $('.edit_device_meta').on('click', function () {
            var $selectID = $(this).attr('id');
            $('#modal_metadeviceid').val($selectID);
            $('#modal_metadevicename').val($('#DeviceName_' + $selectID).attr('name'));
         });
    </script>
    <script>
        $('.edit_btn_DeviceType').on('click', function () {
            var $selectID = $(this).attr('id');
            $('#Devicemodelmodaleditmodel').val($selectID);
            $('#EditesubDeviceName').val($('#DeviceNameSub_' + $selectID).attr('name'));
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
