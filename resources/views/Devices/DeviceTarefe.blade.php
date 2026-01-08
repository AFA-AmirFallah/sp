@extends("Layouts.MainPage")
@section("page-header-left")
@endsection
@section('MainCountent')
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
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5>{{__("Device Type")}}:
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
                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 id="device_model_name" >{{__("Device model")}}:
                                <small id="DeviceSelectedType">

                                </small>

                            </h5>


                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>{{__("Device code")}}</th>
                                        <th>{{__("Device Type")}}</th>
                                        <th>{{__("Rent price")}}</th>
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
                                                <td>{{$DeviceType->DeviceName}}</td>
                                                <td id="Device_Price_{{$DeviceType->ID}}" > {{number_format($DeviceType->Price)}}</td>
                                                <td id="Device_input_Price_{{$DeviceType->ID}}" class="nested"> <input value="{{$DeviceType->Price}}"> </td>
                                                <td>
                                                    <button id="{{$DeviceType->ID}}" type="button"
                                                            class="btn btn-primary btn-md m-1 edit_btn_DeviceType"
                                                            title="Edit">
                                                        <i class="i-Edit"></i>
                                                    </button>
                                                    <button id="save_button_{{$DeviceType->ID}}" type="button"
                                                            class="btn btn-primary btn-md m-1 group2_button nested"
                                                            title="Edit">
                                                        <i class="i-Pen-2"></i>
                                                    </button>
                                                    <button id="cancel_button_{{$DeviceType->ID}}" type="button" onclick="set_to_default()"
                                                            class="btn btn-primary btn-md m-1 edit_btn_DeviceType group2_button  nested"
                                                            title="Edit">
                                                        <i class="i-Close-Window"></i>
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
        $('.edit_btn_DeviceType').on('click', function () {
            var $selectID = $(this).attr('id');
            $('#Device_Price_'+$selectID).addClass('nested');
            $('#Device_input_Price_'+$selectID).removeClass('nested');
            $('#'+$selectID).addClass('nested');
            $('#save_button_'+$selectID).removeClass('nested');
            $('#cancel_button_'+$selectID).removeClass('nested');
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
