@extends('Layouts.MainPage')


@section('MainCountent')
    <input class="nested" id="main-menu" value="#userworks">
    <input class="nested" id="sub-menu" value="#notifications">
    <form method="post">
        @csrf
        <div class="ul-card-list__modal">
            <div class="modal fade modal_detail_to_confirm_work" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div id="Modaldiv" style="text-align: center" class="modal-body">
                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <h5 class="text-white"><i class=" header-icon i-Administrator"></i> لیست کاربران
                                        انتخاب
                                        شده
                                    </h5>
                                </div>
                                <div id="resrve_user_body" class="card-body">
                                    ...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ul-card-list__modal">
                <div id="send_sms_modal" class="modal fade confirm_send_sms" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div id="Modaldiv" style="text-align: center" class="modal-body">
                                <div class="card">
                                    <div style="background-color: orange" class="card-header  0-hidden pb-80">
                                        <h5 class="text-white"><i class=" header-icon i-Electricity"></i> اخطار ارسال پیامک
                                            شده
                                        </h5>
                                    </div>
                                    <div id="resrve_user_body" class="card-body">
                                        <p>آیا نسبت به ارسال پیامک انبوه مطمئن هستید</p>
                                        <button type="submit" name="submit" value="send_sms"
                                            class="btn btn-danger">ارسال</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="basic-action-bar">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-12 mb-12">
                                <div class="card">
                                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                        <h5 class="text-white"><i class=" header-icon i-Paper-Plane"></i>ارسال نوتیفیکیشن
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-row ">

                                            @if ($SelectedUser != [])
                                                <div class="form-group col-md-6 ">
                                                    <label for="inputEmail4" class="ul-form__label"> ارسال به مجموعه کاربران
                                                        انتخاب
                                                        شده</label>
                                                    <div>
                                                        <button class="btn btn-success" type="button" data-toggle="modal"
                                                            data-target=".modal_detail_to_confirm_work"
                                                            onclick="get_saved_user_list()" aria-haspopup="true"
                                                            aria-expanded="false">نمایش کاربران</button>
                                                        <button class="btn btn-danger">حذف کاربران</button>
                                                    </div>
                                                    <small id="user_numbers" class="ul-form__text form-text ">
                                                        تعداد {{ count($SelectedUser) }} کاربر
                                                    </small>
                                                </div>
                                            @else
                                                <div class="form-group col-md-6 ">
                                                    <label for="inputEmail4" class="ul-form__label"> به کاربر:</label>
                                                    @include('Layouts.SearchUserInput', [
                                                        'InputName' => 'UserName',
                                                        'InputPalceholder' => __('Target username'),
                                                    ])
                                                    <small class="ul-form__text form-text ">
                                                        نام کاربر
                                                    </small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="ul-form__label">به رول:</label>
                                                    <select name="NotificationRole" class="form-control">
                                                        <option value="0">{{ __('--select--') }}</option>
                                                        @foreach ($UserRoles as $UserRole)
                                                            <option value="{{ $UserRole->Role }}">{{ $UserRole->RoleName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="ul-form__text form-text ">
                                                        {{ __('Credite transfer to user account') }}
                                                    </small>
                                                </div>
                                            @endif


                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4" class="ul-form__label">نوع نوتیفیکیشن:</label>
                                                <select name="NotificationMod" class="form-control">
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach (\app\myappenv::Notification as $UserNotificationModMeta)
                                                        @if ($UserNotificationModMeta[0] == old('NotificationMod') && old('NotificationMod') != 0)
                                                            <option value="{{ $UserNotificationModMeta[0] }}" selected>
                                                                {{ $UserNotificationModMeta[1] }}</option>
                                                        @else
                                                            <option value="{{ $UserNotificationModMeta[0] }}">
                                                                {{ $UserNotificationModMeta[1] }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <small class="ul-form__text form-text ">
                                                    {{ __('Select transfer credite type') }}
                                                </small>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <p>اطلاعات ارسال پیامک</p>
                                                    <div class="col">
                                                        <table style="text-align: center">
                                                            <label for="">کد متن ارسال</label>
                                                            <input class="form-control" name="sms code" type="text">
                                                            <th>
                                                                <tr>
                                                                    <td>مشخصه</td>
                                                                    <td>مقدار</td>
                                                                </tr>
                                                            </th>
                                                            <tbody>
                                                                @for ($i = 1; $i < 4; $i++)
                                                                    <tr>
                                                                        <td><input class="form-control" name="list_name[{{$i}}]"  type="text">
                                                                        </td>
                                                                        <td><input class="form-control" name="list_val[{{$i}}]" type="text">
                                                                        </td>
                                                                    </tr>
                                                                @endfor

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col">
                                                        <ul>
                                                            <li><span style="color: orange">NNNN</span> : کد تایید
                                                                نوتیفیکیشن</li>
                                                            <li><span style="color: orange">%Name% </span> : نام </li>
                                                            <li><span style="color: orange">%Family% </span> : فامیل </li>
                                                            <li><span style="color: orange">%MobileNo% </span> : شماره
                                                                موبایل </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="ul-form__label">{{ __('Note') }}</label>
                                                <br>
                                                <small class="text-danger">در متن هر کجا از NNNN استفاده کنید به این
                                                    معنااست که متن با کد تایید نوتیفیکیشن تغییر پیدا میکند</small>
                                                <textarea required name="ce" id="notification_text" class="col-sm-12 form-control"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="submit" name="submit" value="Trnsfer"
                                                        class="btn  btn-primary m-1">ثبت نوتیفیکیشن</button> <button
                                                        type="submit" name="submit" value="list"
                                                        class="btn  btn-primary m-1">ارسال لیست سریع</button>
                                                    <button type="button" name="submit" value="Trnsfer"
                                                        onclick="sendsems()" class="btn btn-warning m-1"> ارسال از
                                                        طریق پیامک</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- end::form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
    </form>
@endsection
@section('page-js')
    <script>
        function sendsems() {

            alert_text = $('#notification_text').val();
            if (alert_text != '' && alert_text != null) {
                alert_text = alert_text.replace(/(<([^>]+)>)/ig, "");
                jQuery.noConflict();
                $('.confirm_send_sms').modal('toggle');
                $('.confirm_send_sms').modal('show');
                $('.confirm_send_sms').modal('hide');
            } else {

                alert('لطفا متن ارسال پیامک را وارد فرمایید!');
            }


        }

        function removeuser(username) {
            btn_id = '#btn_' + username.toString();
            $(btn_id).text('...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    AjaxType: 'remove_user_from_list',
                    selected_user: username

                },

                function(data, status) {
                    if (status == 'success') {
                        row_id = '#row_' + username.toString();
                        $(row_id).addClass('nested');
                        $('#user_numbers').html('تعداد کاربران ' + data + ' نفر ');

                    } else {
                        $(btn_id).text('حذف کاربر');
                        alert('بروز مشکل در انجام عملیات!');

                    }
                });


        }

        function get_saved_user_list() {
            $('#resrve_user_body').html('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    AjaxType: 'get_saved_user_list'
                },

                function(data, status) {
                    if (status == 'success') {
                        $('#resrve_user_body').html(data);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');

                    }
                });

        }
    </script>

    @include('Layouts.FilemanagerScripts')

    @include('Layouts.SearchMultiUserInput_Js')
@endsection
