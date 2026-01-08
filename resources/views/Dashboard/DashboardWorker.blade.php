@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Dashboard') }}
                            <small>نیرو عملیاتی</small>
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
    @include('Dashboard.layouts.worker_top_bar')
    @if ($type == 'my_costumer')
        @include('Dashboard.layouts.my_costumer')
    @endif
    @if ($type == 'my_experts')
        @include('Dashboard.layouts.my_experts')
    @endif

    @if ($type == 'add_costumer')
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"> <i class="header-icon i-Add-User"></i>معرفی مشتری</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('dashboard') }}">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">

                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            {{ __('Sex') }}<span class="text-danger">*</span></label>
                                        <div class="col-xl-9 col-sm-8">
                                            <div
                                                class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                <label style="margin-left: 10px" class="d-block" for="edo-ani1">
                                                    <input class="radio_animated" type="radio" name="Sex"
                                                        value="m" checked=""><i style="font-size: 20px"
                                                        class="i-Business-Man"></i>
                                                    {{ __('Man') }}
                                                </label>

                                                <label class="d-block" for="edo-ani2">
                                                    <input class="radio_animated" type="radio" name="Sex"
                                                        @if (old('Sex') == 'f') checked="" @endif value="f">
                                                    <i style="font-size: 20px" class="i-Business-Woman"></i>
                                                    {{ __('Woman') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            {{ __('Name') }} <span class="text-danger">*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" name="Name"
                                            value="{{ old('Name') }}" type="text" required>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom1" class="col-xl-3 col-md-4">{{ __('Family') }}<span
                                                class="text-danger">*</span></label>
                                        <input required class="form-control col-xl-8 col-md-7" name="Family"
                                            value="{{ old('Family') }}" type="text">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom2" class="col-xl-3 col-md-4">
                                            {{ __('Mobile namber') }} <span class="text-danger">*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" name="MobileNo"
                                            value="{{ old('MobileNo') }}" inputmode="numeric" type="text" required>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom2" class="col-xl-3 col-md-4">
                                            نوع مشتری <span class="text-danger">*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" name="customer_type"
                                            placeholder="پزشک ، بیمار" inputmode="numeric" type="text" required>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">استان<span style="color: red">*</span></label>
                                        <select name="Province" id="Province" onchange="LoadCitys(this.value)"
                                            class="form-control col-xl-8 col-md-7">
                                            @php
                                                if (isset($address->Province)) {
                                                    $Province = $address->Province;
                                                } else {
                                                    $Province = 0;
                                                }

                                            @endphp
                                            <option value="0">{{ __('--select--') }}</option>
                                            @foreach (App\geometric\locations::get_all_provinces() as $ProvincesTarget)
                                                <option value="{{ $ProvincesTarget->id }}"
                                                    @if ($ProvincesTarget->id == $Province) selected @endif>
                                                    {{ $ProvincesTarget->ProvinceName }}</option>
                                            @endforeach
                                        </select>
                                        <small class="ul-form__text form-text ">

                                        </small>
                                    </div>
                                    <div class="row">
                                        <label class="col-xl-3 col-md-4">
                                            شهرستان<span style="color: red">*</span></label>
                                        <select id="Shahrestan" name="Saharestan" class="form-control col-xl-8 col-md-7">
                                            @if (isset($address->Shahrestan))
                                                <option value="{{ $address->Shahrestan }}">{{ $address->ShahrestanName }}
                                                </option>
                                            @endif
                                        </select>
                                        <small class="ul-form__text form-text ">

                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button type="submit" name="Registeruser" value="register"
                                    class="btn btn-primary">ذخیره</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('page-js')
@endsection

@section('bottom-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#request_table').DataTable();
    </script>
    <script>
        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    $("#Shahrestan").append(data);
                });

        }
    </script>
    <script>
        function descriptionCkeker() {
            descriptionval = $('#description').val();
            if (descriptionval.length == 0) {
    
                $('#description-txt').css("color", "red");
            } else {
                if (descriptionval.length < 100) {
                    $('#description-txt').css("color", "orange");
                } else {
                    if (descriptionval.length < 500) {
                        $('#description-txt').css("color", "green");
                    } else { // overflow
                        $('#description-txt').css("color", "red");
                    }
                }
            }
            $('#description-count').html(descriptionval.length);
        }
    
        $('select').select2({
            createTag: function(params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }
    
                return {
    
                    id: params.term,
                    text: params.term
                }
            }
        });
        $("#SelectTags").select2({
            tags: true
        });
        $("#NewsCat").select2({
            tags: true
        });
    </script>


    <script>
        function ChangeOrderStatus($OrderID, $TargetStatus, $TargetStatusName) {
            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            var $oldvalue = $('#status_' + $OrderID).html();
            $('#status_' + $OrderID).html($loader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'ChangeOrderStatus',
                    OrderID: $OrderID,
                    TargetStatus: $TargetStatus,
                },

                function(data, status) {
                    if (data == '1') {
                        $('#status_' + $OrderID).html($TargetStatusName);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                        $('#status_' + $OrderID).html($oldvalue);
                    }
                });


        }
    </script>
@endsection
