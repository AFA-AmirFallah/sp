@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#userworks">
    <input class="nested" id="sub-menu" value="#notifications">
    <div class="ul-card-list__modal">
        <div id="send_sms_modal" class="modal fade confirm_send_sms" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div id="Modaldiv" style="text-align: center" class="modal-body">
                        <div class="card">
                            <div style="background-color: green" class="card-header  0-hidden pb-80">
                                <h5 class="text-white"><i class=" header-icon i-Mail"></i> لیست پیامک های دریافت شده
                                </h5>
                            </div>
                            <div id="resrve_user_body" class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('makenotification') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Paper-Plane"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary">ارسال نوتیفیکیشن</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ Route('notifications') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Speach-Bubble-Asking"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">نوتیفیکیشن های باز</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ Route('notifications') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: green" class="i-Check"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">نوتیفیکیشن های موفق</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <form method="post">
        @csrf
        <div class="card">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                <h5 class="text-white"><i class=" header-icon i-Speach-Bubble-Asking"></i>نوتیفیکیشن های باز
                </h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('No.') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>نوع نوتیفیکیشن</th>
                                <th>متن</th>
                                <th>تولید</th>
                                <th>دیدن</th>
                                <th>تایید</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $Rowno = 1;
                            @endphp
                            @foreach ($Notificaions as $Notificaion)

                                <tr>
                                    <td>{{ $Notificaion->id }}</td>
                                    <td>{{ $Notificaion->Name }} {{ $Notificaion->Family }}</td>
                                    <td>
                                        @foreach (\app\myappenv::Notification as $arrtype)
                                            @if ($arrtype[0] == $Notificaion->AlertType)
                                                {{ $arrtype[1] }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $Notificaion->Continer ?? '' }}</td>
                                    <td>{{ $Persian->MyPersianDate($Notificaion->created_at, true) }}</td>
                                    <td>
                                        @if ($Notificaion->ViewTime == null)
                                            دیده نشده
                                        @else
                                            {{ $Persian->MyPersianDate($Notificaion->ViewTime, true) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($Notificaion->AckTime == null)
                                            تایید نشده
                                        @else
                                            {{ $Persian->MyPersianDate($Notificaion->AckTime, true) }}
                                        @endif
                                    </td>
                                    <td> <button class="btn btn-danger" type="submit" name="delete"
                                            value="{{ $Notificaion->id }}">حذف</button> </td>
                                </tr>
                            @endforeach
                            @foreach ($sms_notifications as $Notificaion)
                                <tr>
                                    <td>{{ $Notificaion->id }}</td>
                                    <td>مجموعه کاربران</td>
                                    <td>
                                        ارسال پیامک
                                    </td>
                                    <td>{{ $Notificaion->Container }}</td>
                                    <td>{{ $Persian->MyPersianDate($Notificaion->created_at, true) }}</td>
                                    <td>
                                        ارسال به اپراتور
                                    </td>
                                    <td>
                                        @if ($Notificaion->extra == null)
                                            پاسخ داده نشده
                                        @else
                                            @php
                                                $extra = json_decode($Notificaion->extra, true);
                                                $extra = count($extra);
                                            @endphp
                                            {{ $extra }} پاسخ
                                        @endif


                                    </td>
                                    <td> <button class="btn btn-danger" type="submit" name="delete"
                                            value="{{ $Notificaion->id }}">حذف</button>
                                        <button class="btn btn-success" type="button"
                                            onclick="show_alert('{{ $Notificaion->id }}')"
                                            value="{{ $Notificaion->id }}">نمایش</button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </form>
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script>
        function show_alert(notification_id) {
            $('#resrve_user_body').html('درحال دریافت اطلاعات ...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'receive_notifications',
                    NotificationId: notification_id
                },

                function(data, status) {
                    $('#resrve_user_body').html(data);
                });
            $('.confirm_send_sms').modal('toggle');
            $('.confirm_send_sms').modal('show');
            $('.confirm_send_sms').modal('hide');

        }
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
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
            });
        }
    </script>
    <script>
        var selected = new Array();
        $(document).ready(function() {

            $("input[type='checkbox']").on('change', function() {
                // check if we are adding, or removing a selected item
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                } else {
                    for (var i = 0; i < selected.length; i++) {
                        if (selected[i] == $(this).val()) {
                            // remove the item from the array
                            selected.splice(i, 1);
                        }
                    }
                }

                // output selected
                var output = "";
                for (var o = 0; o < selected.length; o++) {
                    if (output.length) {
                        output += ", " + selected[o];
                    } else {
                        output += selected[o];
                    }
                }

                $(".taid").val(output);

            });

        });
    </script>
    <script>
        $(document).ready(function() {
                    $("#L1").change(function() {
                        var num = this.value;
                        $("#L11").css("display", "none");
                    });
    </script>
@endsection
