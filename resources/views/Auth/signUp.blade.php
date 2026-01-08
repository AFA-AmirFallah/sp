<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ \App\myappenv::CenterName }}</title>
    @if (\App\myappenv::Captcha == 'google')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onSubmit(token) {
                document.getElementById("step1").submit();
            }
        </script>
    @endif
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
    <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}">
</head>

<body>
    <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            @include('Layouts.ErrorHandler')

                            @if ($step == 1)
                                <h1 class="mb-3 text-18 " style="text-align: center;">{{ __('Register') }}</h1>
                                <form method="post">
                                    @csrf
                                    <div class="form-group form-group-rtl">
                                        <label>{{ __('Mobile No') }}</label>
                                        <input autocomplete="off" required id="MobileNo" name="MobileNo"
                                            onkeyup="mobile_kye_down()" class="form-control form-control-rounded"
                                            type="number">
                                    </div>
                                    @if (\App\myappenv::Captcha == 'local')
                                        <div class="captcha">
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-danger" class="refresh-captcha"
                                                id="refresh-captcha">
                                                &#x21bb;
                                            </button>
                                        </div>
                                        <div class="form-group mb-4">
                                            <input required id="captcha" type="text" autocomplete="off"
                                                class="form-control form-control-rounded"
                                                placeholder="کد امنیتی را وارد فرمایید!" name="captcha">
                                        </div>
                                    @endif

                                    @if (\App\myappenv::Captcha == 'google')
                                            <button id="step1" type="submit" name="submit" value="step1" disabled
                                            class="btn btn-primary btn-block btn-rounded mt-3 ">{{ __('Send Submit Code') }}</button>

                                    @else
                                        <button id="step1" type="submit" name="submit" value="step1" disabled
                                            class="btn btn-primary btn-block btn-rounded mt-3 ">{{ __('Send Submit Code') }}</button>
                                    @endif

                                </form>
                            @elseif($step == 2)
                                <h1 class="mb-3 text-18 " style="text-align: center;">{{ __('Confirm send code') }}
                                </h1>
                                <h2 style="text-align: center;">{{ $MobileNo }} </h2>
                                <form method="post">
                                    @csrf
                                    <div class="form-group form-group-rtl">
                                        <label>{{ __('Confirm code') }}</label>
                                        <input name="ConfirmCode" class="form-control form-control-rounded"
                                            type="number">
                                    </div>
                                    <button type="submit" name="submit" value="ConfirmCode"
                                        class="btn btn-primary btn-block btn-rounded mt-3 ">{{ __('Next step') }}</button>
                                    <button type="submit" name="submit" value="ResendCode"
                                        class="btn btn-warning btn-block btn-rounded mt-3 ">{{ __('Resend code') }}</button>
                                    <button type="submit" name="submit" value="discard"
                                        class="btn btn-block btn-danger btn-rounded mt-3 ">{{ __('discard') }}</button>
                                </form>

                            @elseif($step == 3)
                                <h1 class="mb-3 text-18 " style="text-align: center;">
                                    {{ __('Save personal information') }}</h1>
                                <form method="post">
                                    @csrf
                                    <div class="form-group form-group-rtl">
                                        <label>{{ __('Sex') }}</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="Sex" value="m"
                                                checked="">
                                            <label class="form-check-label ml-3" for="gridRadios1">
                                                {{ __('Man') }}
                                            </label>
                                            <input class="form-check-input" type="radio" name="Sex" value="f">
                                            <label class="form-check-label ml-3" for="gridRadios1">
                                                {{ __('Woman') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-rtl">
                                        <label>{{ __('Name') }}</label>
                                        <input id="input_name" name="Name" autocomplete="off" onkeyup="cehckinput()"
                                            class="form-control form-control-rounded" type="text">
                                    </div>
                                    <div class="form-group form-group-rtl">
                                        <label>{{ __('Family') }}</label>
                                        <input id="input_family" name="Family" autocomplete="off" onkeyup="cehckinput()"
                                            class="form-control form-control-rounded" type="text">
                                    </div>
                                    <div class="form-group form-group-rtl">
                                        <label>{{ __('Password') }}</label>
                                        <input id="input_password" name="Password" autocomplete="off"
                                            onkeyup="cehckinput()" class="form-control form-control-rounded"
                                            type="text">
                                    </div>
                                    <button id="save_user" type="submit" name="submit" value="save" disabled
                                        class="btn btn-primary btn-block btn-rounded mt-3 ">{{ __('save') }}</button>
                                </form>

                            @elseif($step == 4)

                            @endif

                        </div>
                    </div>
                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ url('/') . \App\myappenv::login_background_image }})">
                        <div class="pr-3 auth-right">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{ url('/') . \App\myappenv::MainIcon }}" alt="">
                            </div>
                            <a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text"
                                href="{{ route('login') }}">
                                <i class="i-Add-User"></i> {{ __('Enter to login panel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/common-bundle-script.js"></script>
        <script src="/assets/js/script.js"></script>
        <script>
            function mobile_kye_down() {
                var inputtext = $("#MobileNo").val();
                if (inputtext.startsWith('0') && inputtext.length > 0) {
                    if (inputtext.length == 11) {
                        $("#step1").prop('disabled', false);
                    } else {
                        $("#step1").prop('disabled', true);
                    }

                } else if (inputtext.length > 0) {
                    alert("شماره موبایل می بایست با 0 شروع شود!");
                    $("#MobileNo").val('');
                }

            }
        </script>
        <script>
            function cehckinput() {
                var input_name = $("#input_name").val();
                var input_family = $("#input_family").val();
                var input_password = $("#input_password").val();
                if (input_name.length > 2 && input_family.length > 2 && input_password.length > 3) {
                    $("#save_user").prop('disabled', false);

                } else {
                    $("#save_user").prop('disabled', true);
                }

            }
        </script>
        <script type="text/javascript">
            $('#refresh-captcha').click(function() {
                $.ajax({
                    type: 'GET',
                    url: 'refresh-captcha',
                    success: function(data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
        </script>
</body>

</html>
