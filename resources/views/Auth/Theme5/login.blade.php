@extends('Layouts.Theme5.layout.main_layout')
@section('content')
    <hr style="margin-top: 90px">
    <div id="main_container" class="container main-container">
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 col-12 mx-auto">
                <div class="logo-area text-center mb-3">
                    <a><img src="{{ \App\myappenv::Sitelogo }}" class="img-fluid" alt="logo"></a>
                </div>
                <div class="auth-wrapper form-ui border pt-4">
                    <div class="section-title title-wide mb-1 no-after-title-wide">
                        <h2 class="font-weight-bold">ورود</h2>
                    </div>
                    <form action="javascript:send_otp()">
                        <div class="form-row-title">
                            <h3>شماره موبایل</h3>
                        </div>
                        <div class="form-row with-icon">
                            <input id="UserName" type="text" inputmode="numeric" class="input-ui pr-2"
                                placeholder="شماره موبایل خود را وارد نمایید">
                            <i class="mdi mdi-account-circle-outline"></i>
                        </div>
                        <div class="form-row mt-3">
                            <button type="button" onclick="send_otp()" class="btn-primary-cm btn-with-icon mx-auto w-100">
                                <i class="mdi mdi-login-variant"></i>
                                ورود به سپهرمال
                            </button>
                        </div>
                    </form>
                    <div class="form-footer mt-3">
                        @php
                            $Role = App\Http\Controllers\setting\SettingManagement::GetSiteRole();
                        @endphp
                        @if ($Role != null)
                            <div>
                                <span class="font-weight-bold">
                                    <a data-toggle="modal" style="color: var(--shafatel-main-background-color);"
                                        data-target=".add-device-contract-modal">شرایط استفاده از
                                        سپهرمال</a>
                                </span>
                            </div>

                            <div class="ul-card-list__modal">
                                <div class="modal fade add-device-contract-modal" tabindex="-1"
                                    style="direction: rtl;text-align:right" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <p class="modal-title" id="device_model_title">
                                                    {{ $Role->Titel }}</p>
                                                <button style="display: contents" type="button" class="close"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                {!! $Role->Content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_script')
    <script>
        function send_verification_code(verification_code) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'confirm_verification_code',
                    verification_code: verification_code
                },

                function(data, status) {
                    if (data['result']) {
                        $('#main_container').html(data['data']);
                    } else {
                        alert(data['msg']);
                    }
                });


        }

        function send_verification_code_admin() {
            total = '';
            user_pass = $('#admin_password').val();
            $(".line-number").each(function() {
                total += $(this).val();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'confirm_verification_code_admin',
                    verification_code: total,
                    password: user_pass
                },

                function(data, status) {
                    if (data['result']) {
                        $('#main_container').html(data['data']);
                    } else {
                        alert(data['msg']);
                    }
                });
        }

        function check_mobile_number() {
            UserName = $("#UserName").val();
            if (UserName.length == 0) {
                return false;
            }
            if ($.isNumeric(UserName) == false) {
                alert('شماره موبایل می باید فقط از عدد استفاده کنید!');
                return false;
            }
            if (UserName.length != 11) {
                alert('طول شماره موبایل وارد شده صحیح نیست');
                return false;
            }
            if (UserName.startsWith('09')) {
                return true;
            } else {
                alert('شماره موبایل می باید با ۰۹ شروع');
                return false;
            }
        }

        function send_otp() {
            $mobile_validation = check_mobile_number();
            if ($mobile_validation == false) {
                return false;
            }
            UserName = $("#UserName").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'send_otp',
                    phone_number: UserName

                },

                function(data, status) {
                    $('#main_container').html(data);
                });

        }
    </script>
@endsection
