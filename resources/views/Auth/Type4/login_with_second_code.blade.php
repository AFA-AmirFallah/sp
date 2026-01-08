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
                document.getElementById("login-form").submit();
            }
        </script>
    @endif
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
    <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>
    @php
        $Feilds = App\Functions\CacheData::GetSetting('register_feilds');
        $Feilds = json_decode($Feilds);
        if (!isset($UserInfo->UserName)) {
           
           $UserName = null; 
        }
        else{
            $UserName = $UserInfo->UserName;
        }
        $BrancSrc = App\Branchs\BranchsFunctions::get_user_name_branch_info($UserName);
    @endphp

    <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            @include('Layouts.ErrorHandler')
                            @if ($Step == 'init')
                                <div>
                                    <h1 class="mb-3 text-18 " style="text-align: center;">
                                        {{ $BrancSrc['branch_name']}}
                                        <hr> ورود / ثبت نام
                                    </h1>
                                    @php
                                        $Role = App\Http\Controllers\setting\SettingManagement::GetSiteRole();
                                        
                                    @endphp
                                    <form id="login-form" method="post">
                                        @csrf
                                        <div class="form-group ">
                                            <label class="text-18" for="UserName" style="float: right;">شماره
                                                موبایل یا ایمیل خود را وارد کنید</label>


                                            <input onkeyup="UsernameFormatValidator()" id="UserName" name="UserName"
                                                required autocomplete="off" class="form-control form-control-rounded">
                                        </div>
                                        @if (\App\myappenv::Captcha == 'google')
                                            <!-- <button type="submit"
                                                data-sitekey="{{ App\myappenv::RECAPTCHA_SITE_KEY }}"
                                                data-callback='onSubmit' id="OneStep_1" name="submit" value="OneStep_1"
                                                class="btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">ادامه</button>
                                            !-->
                                            <button type="submit" name="submit" name="submit" value="OneStep_1"
                                                class=" btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">ادامه</button>
                                            @if ($Role != null)
                                                <div style="text-align: center;padding-top: 8px;">
                                                    <a data-toggle="modal"
                                                        style="color: var(--shafatel-main-background-color);"
                                                        data-target=".add-device-contract-modal">شرایط استفاده از
                                                        برنامه</a>

                                                </div>
                                                <div class="ul-card-list__modal">
                                                    <div class="modal fade add-device-contract-modal" tabindex="-1" style="direction: rtl;text-align:right"
                                                        role="dialog" aria-labelledby="myLargeModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <p class="modal-title" id="device_model_title">
                                                                        {{ $Role->Titel }}</p>
                                                                    <button style="display: contents" type="button"
                                                                        class="close" data-dismiss="modal"
                                                                        aria-label="Close">
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
                                        @else
                                            <div class="captcha">
                                                <span>{!! captcha_img() !!}</span>
                                                <button type="button" class="btn btn-danger" class="refresh-captcha"
                                                    id="refresh-captcha">
                                                    &#x21bb;
                                                </button>
                                            </div>
                                            <div class="form-group mb-4">
                                                <input required id="captcha" type="text" autocomplete="off"
                                                    required class="form-control form-control-rounded"
                                                    placeholder="کد امنیتی را وارد فرمایید!" name="captcha">
                                            </div>
                                            <button type="submit" name="submit" name="submit" value="OneStep_1"
                                                class=" btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">{{ __('Login') }}</button>

                                        @endif
                                    </form>
                                </div>
                                <script>
                                    function UsernameFormatValidator() {
                                        $("#OneStep_1").addClass("disabled");
                                        $UserName = $("#UserName").val();
                                        if ($UserName.startsWith('09')) {
                                            if ($UserName.length == 11) {
                                                $("#OneStep_1").removeClass("disabled");
                                            }
                                        } else {
                                            if ($UserName.length > 5) {
                                                if ($UserName.includes("@") && $UserName.includes(".")) {
                                                    $("#OneStep_1").removeClass("disabled");
                                                }
                                            }
                                        }
                                    }
                                </script>
                            @elseif($Step == 'register')
                                <div>
                                    <h1 class="mb-3 text-18 " style="text-align: center;">
                                        {{ $BrancSrc['branch_name']}}
                                        <hr> ورود با کد یکبار مصرف
                                    </h1>
                                    <form method="post">
                                        @csrf
                                        <div class="form-group ">
                                            <label class="text-18" for="UserName"
                                                style="float: right;text-align:right">کد یکبار مصرف شما به شماره موبایل
                                                {{ $MobileNo }} ارسال شد</label>
                                            <input autocomplete="off" required id="confirmcode" inputmode="numeric" name="confirmcode"
                                                class="form-control form-control-rounded">
                                        </div>
                                        <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                        <button id="OneStep_1btn" type="submit" name="submit" value="confirmcode"
                                            class=" btn btn-rounded btn-primary btn-block mt-2 ">ادامه</button>

                                    </form>
                                </div>
                                <script>
                                    // Set the date we're counting down to
                                    var countDownDate = new Date().getTime() + 180000;

                                    // Update the count down every 1 second
                                    var x = setInterval(function() {

                                        // Get today's date and time
                                        var now = new Date().getTime();

                                        // Find the distance between now and the count down date
                                        var distance = countDownDate - now;

                                        // Time calculations for days, hours, minutes and seconds
                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                        // Display the result in the element with id="CountDownP"
                                        document.getElementById("CountDownP").innerHTML = "ارسال مجدد کد تا  " + seconds + " : " + minutes +
                                            " دیگر";

                                        // If the count down is finished, write some text
                                        if (distance < 0) {
                                            clearInterval(x);
                                            document.getElementById("CountDownP").innerHTML = "اتمام زمان";
                                            $("#OneStep_1btn").attr('value', 'resend');
                                            $("#OneStep_1btn").html('ارسال مجدد');
                                            $("#confirmcode").prop('disabled', true);

                                        }
                                    }, 1000);
                                </script>
                            @elseif($Step == 'loginWithSendCode')
                                <div>
                                    <h1 class="mb-3 text-18 " style="text-align: center;">
                                        {{ $BrancSrc['branch_name']}}
                                        <hr>ورود با کد تایید
                                    </h1>
                                    <form method="post">
                                        @csrf
                                        <div class="form-group ">
                                            <label class="text-18" for="UserName"
                                                style="float: right;text-align:right">شماره
                                                کد تاییده به شماره موبایل {{ $MobileNo }} ارسال شد</label>
                                            <input autocomplete="off" required name="Password"
                                                class="form-control form-control-rounded">
                                        </div>
                                        <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                        <button id="OneStep_1btn" type="submit" name="submit" value="login"
                                            class=" btn btn-rounded btn-primary btn-block mt-2 ">ادامه</button>

                                    </form>
                                </div>
                                <script>
                                    // Set the date we're counting down to
                                    var countDownDate = new Date().getTime() + 180000;

                                    // Update the count down every 1 second
                                    var x = setInterval(function() {

                                        // Get today's date and time
                                        var now = new Date().getTime();

                                        // Find the distance between now and the count down date
                                        var distance = countDownDate - now;

                                        // Time calculations for days, hours, minutes and seconds
                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                        // Display the result in the element with id="CountDownP"
                                        document.getElementById("CountDownP").innerHTML = "ارسال مجدد کد تا  " + seconds + " : " + minutes +
                                            " دیگر";

                                        // If the count down is finished, write some text
                                        if (distance < 0) {
                                            clearInterval(x);
                                            document.getElementById("CountDownP").innerHTML = "اتمام زمان";
                                            $("#OneStep_1btn").attr('value', 'resend');
                                            $("#OneStep_1btn").html('ارسال مجدد');
                                            $("#confirmcode").prop('disabled', true);

                                        }
                                    }, 1000);
                                </script>
                            @elseif ($Step == 'login')
                                <div>
                                    <h1 class="mb-3 text-18 " style="text-align: center;">
                                        {{ $BrancSrc['branch_name']}}
                                        <hr> ورود / ثبت نام
                                    </h1>
                                    <form method="post">
                                        @csrf

                                        <div class="form-group ">
                                            <label class="text-18" for="UserName" style="float: right;">رمز عبور
                                                یا کد یکبار مصرف را وارد کنید</label>
                                            <input type="password" autocomplete="off" id="Password" required
                                                name="Password" type="password"
                                                class="form-control form-control-rounded">
                                        </div>
                                        <button type="submit" name="submit" name="submit" value="login"
                                            class=" btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">ورود</button>

                                    </form>
                                    <form method="post">
                                        @csrf
                                        <button type="submit" name="submit" name="submit" value="GetPass"
                                            class=" btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">دریافت کد
                                            یکبار
                                            مصرف</button>

                                    </form>

                                </div>
                            @elseif ($Step == 'adminlogin')
                                <div>
                                    <h1 class="mb-3 text-18 " style="text-align: center;">
                                        {{ $BrancSrc['branch_name']}}
                                        <hr> ورود به سامانه
                                    </h1>
                                    <form method="post">
                                        @csrf

                                        <div class="form-group ">
                                            <label class="text-18" for="UserName" style="float: right;">رمز
                                                عبور</label>
                                            <input type="password" autocomplete="off" id="Password" required
                                                name="Password" class="form-control form-control-rounded">
                                            <label class="text-18" for="UserName" style="float: right;"> کد یکبار
                                                مصرف</label>
                                            <input type="number" autocomplete="off" required name="onetime"
                                                class="form-control form-control-rounded">
                                        </div>
                                        <button type="submit" name="submit" name="submit" value="login"
                                            class=" btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">ورود</button>

                                    </form>
                                    <form method="post">
                                        @csrf
                                        <button type="submit" name="submit" name="submit" value="GetPass"
                                            class=" btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">دریافت کد
                                            یکبار
                                            مصرف</button>

                                    </form>

                                </div>
                            @elseif($Step == 'information')
                                <div>
                                    <h1 class="mb-3 text-18 " style="text-align: center;">
                                        {{ $BrancSrc['branch_name']}}
                                        <hr>ورود با کد تایید
                                    </h1>
                                    <form method="post">
                                        @csrf
                                        <form method="post">
                                            @csrf
                                            <div class="form-group form-group-rtl">
                                                <label>{{ __('Sex') }}</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="Sex"
                                                        value="m" checked="">
                                                    <label class="form-check-label ml-3" for="gridRadios1">
                                                        {{ __('Man') }}
                                                    </label>
                                                    <input class="form-check-input" type="radio" name="Sex"
                                                        value="f">
                                                    <label class="form-check-label ml-3" for="gridRadios1">
                                                        {{ __('Woman') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-rtl">
                                                <label>{{ __('Name') }}</label>
                                                <input id="input_name" name="Name" value="{{old('Name') ?? ''}}" autocomplete="off" required
                                                    onkeyup="cehckinput()" class="form-control form-control-rounded"
                                                    type="text">
                                            </div>
                                            <div class="form-group form-group-rtl">
                                                <label>{{ __('Family') }}</label>
                                                <input id="input_family" name="Family" required autocomplete="off"
                                                    onkeyup="cehckinput()" class="form-control form-control-rounded"
                                                    type="text">
                                            </div>
                                            @if (isset($Feilds->melliid))
                                                <div class="form-group form-group-rtl">
                                                    <label>کد ملی</label>
                                                    @if (isset($Feilds->melliid_req))
                                                        <input id="MelliID" name="MelliID" required
                                                            autocomplete="off"
                                                            class="form-control form-control-rounded" type="text">
                                                    @else
                                                        <input id="MelliID" name="MelliID" autocomplete="off"
                                                            class="form-control form-control-rounded" type="text">
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="form-group form-group-rtl">
                                                <label>{{ __('Password') }}</label>
                                                <input id="input_password" name="Password" autocomplete="off"
                                                    onkeyup="cehckinput()" class="form-control form-control-rounded"
                                                    type="text">

                                            </div>
                                            <button id="save_user" type="submit" name="submit" value="Saveinfo"
                                                disabled
                                                class="btn btn-primary btn-block btn-rounded mt-3 ">{{ __('save') }}</button>
                                            <button id="save_user_oneTime" type="submit" name="submit"
                                                value="SaveinfoOneTime" disabled
                                                class="btn btn-success btn-block btn-rounded mt-3 ">ورود با کد یکبار
                                                مصرف</button>
                                        </form>
                                    </form>
                                </div>
                                <script>
                                    function cehckinput() {
                                        var input_name = $("#input_name").val();
                                        var input_family = $("#input_family").val();
                                        var input_password = $("#input_password").val();
                                        if (input_name.length > 2 && input_family.length > 2 && input_password.length > 8) {
                                            $("#save_user").prop('disabled', false);

                                        } else {
                                            $("#save_user").prop('disabled', true);
                                        }
                                        if (input_name.length > 2 && input_family.length > 2) {
                                            $("#save_user_oneTime").prop('disabled', false);

                                        } else {
                                            $("#save_user_oneTime").prop('disabled', true);
                                        }

                                    }
                                </script>
                            @endif


                        </div>
                    </div>

                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ url('/') . \App\myappenv::login_background_image }})">
                        <div class="pr-3 auth-right">
                            <a href=" {{ route('home') }} ">
                                <div class="auth-logo text-center mb-4">
                                    <img src="{{$BrancSrc['branch_avatar']}}" alt="">
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script src="/assets/js/common-bundle-script.js"></script>
        <script src="/assets/js/script.js"></script>
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
