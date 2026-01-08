@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    @if (Auth::user()->Role == \App\myappenv::role_worker)
        @include('Dashboard.layouts.worker_top_bar')
    @endif
    <input class="nested" id="main-menu" value="#patiantworks">
    <input class="nested" id="sub-menu" value="#patiant_order">
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <input style="visibility:hidden" id="tableID" name="tableid">
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Service index') }}</label>
                                <div class="col-sm-10">
                                    <select id="cat_list" name="ServiceesID" class="form-control">
                                        <option value="0">{{ __('--select--') }}</option>
                                        @foreach ($catorders as $catorder)
                                            <option value="{{ $catorder->id }}">
                                                {{ $catorder->Cat }}</option>
                                        @endforeach
                                    </select>
                                    @foreach ($catorders as $catorder)
                                        <small class="catorder_Items nested"
                                            id="order_desc_small_{{ $catorder->id }}">{{ $catorder->TitleDescription }}</small>
                                    @endforeach

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Mobile namber') }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" required autocomplete="off" id="ADDMobile" name="ADDMobile"
                                        value="">
                                    <div id="suggesstion-box">
                                    </div>

                                </div>
                            </div>
                            <div style="display: none;" id="HideDiv">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" autocomplete="off" name="ADDName" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">{{ __('Family') }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" autocomplete="off" name="ADDFamily" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">کدملی</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" autocomplete="off" name="MelliID" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">استان</label>
                                <div class="col-sm-10">
                                    <select name="Province" id="Province" onchange="LoadCitys(this.value)"
                                        class="form-control">
                                        <option value="0">انتخاب استان</option>
                                        @foreach (App\geometric\locations::get_all_provinces() as $ProvincesTarget)
                                            <option value="{{ $ProvincesTarget->id }}">
                                                {{ $ProvincesTarget->ProvinceName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">شهر</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="Shahrestan" name="city">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Service location') }}</label>
                                <div class="col-sm-10">
                                    <textarea name="ADDAddress" class="form-control" rows="3" value=""></textarea>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('notes') }}</label>
                                <div class="col-sm-10">
                                    <textarea required name="ADDExtranote" class="form-control" rows="3" value=""></textarea>

                                </div>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="register"
                                    class="btn btn-success btn-rounded m-1">{{ __('save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-header text-right bg-transparent">
                <button id="addcontact" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                    class="btn btn-primary btn-md m-1"><i
                        class="i-First-Aid text-white mr-2"></i>{{ __('Register Order') }}
                </button>
            </div>
            <form method="post">
                @csrf
                <div class="container-fluid">
                    <div class="row product-adding">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <h5 class="text-white"><i class=" header-icon i-Box-Full"></i> درخواست های ثبت شده
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('No.') }}</th>
                                                    <th>{{ __('Order number') }}</th>
                                                    <th>{{ __('Pataint name and family') }}</th>
                                                    <th>{{ __('Pataint phone number') }}</th>
                                                    <th>{{ __('Date of enter') }}</th>
                                                    <th>{{ __('service type') }}</th>
                                                    <th>عملیات</th>
                                                    <th>{{ __('Status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $Rowno = 1;
                                                @endphp
                                                @if ($Orders == null)
                                                @else
                                                    @foreach ($Orders as $Order)
                                                        <tr>
                                                            <td>{{ $Rowno++ }}</td>
                                                            <td>{{ $Order->ID }}</td>
                                                            <td>{{ $Order->Name }} {{ $Order->Family }}</td>
                                                            <td>{{ $Order->MobileNo }}</td>
                                                            <td>{{ $Persian->MyPersianDate($Order->CreateDate, true) }}
                                                            </td>
                                                            <td>{{ $Order->Cat }}</td>
                                                            <td><a href=""
                                                                    onclick="window.open('{{ url('/') . '/filemanager?type=file&usertraget=' . $Order->BimarUserName }}',
                                                                        'newwindow',
                                                                        'width=1000,height=600');
                                                             return false;">مشاهده
                                                                    و آپلود مدارک</a>
                                                                @if ($Order->OrderStatus == 1)
                                                                    <button type="submit" name="Cancle_req"
                                                                        value="{{ $Order->ID }}"
                                                                        class="btn btn-danger">لغو</button>
                                                                @endif
                                                                @if ($Order->OrderStatus == 8)
                                                                    <button type="submit" name="Recover_req"
                                                                        value="{{ $Order->ID }}"
                                                                        class="btn btn-success">درخواست بررسی</button>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $Order->status }}
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
            @include('Layouts.FilemanagerScripts')
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
                            data = `<option value="0">همه شهرها</option>` + data;
                            $("#Shahrestan").append(data);
                        });

                }
            </script>
            <script>
                $("#ADDMobile").keyup(function() {
                    if ($("#ADDMobile").val().length == 11) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            }
                        });
                        $.post('{{ route('ajax') }}', {
                                AjaxType: 'CheckUsersMobile',
                                MobileNo: $("#ADDMobile").val(),
                                count: 1
                            },
                            function(data, status) {
                                if (data != 'nok') {
                                    $("#ADDMobile").css("background", "#8bd586");
                                    $("#suggesstion-box").html(data);
                                    $("#HideDiv").hide();
                                } else {
                                    $("#ADDMobile").css("background", "#FFF");
                                    $("#suggesstion-box").html('جستجوی بدون نتیجه!');
                                    $("#HideDiv").show();
                                }
                            });
                    } else {
                        $("#ADDMobile").css("background", "#FFF");
                        $("#suggesstion-box").html('');
                        $("#HideDiv").hide();

                    }
                });
            </script>

            @if (app()->getLocale() == 'fa')
                <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
            @else
                <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
            @endif
            <!-- page script -->
            <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

            <script>
                $('#ul-contact-list').DataTable();
            </script>

            <script>
                $('#cat_list').change(function() {
                    selectItem = $(this).val();
                    $(".catorder_Items").addClass('nested');
                    $("#order_desc_small_" + selectItem).removeClass('nested');
                });
            </script>
            <script>
                function newuserchange() {
                    if ($('#useradd_radio').is(':checked')) {
                        $("#HideDiv").show();
                    } else {
                        $("#HideDiv").hide();
                    }
                }
            </script>
        @endsection
