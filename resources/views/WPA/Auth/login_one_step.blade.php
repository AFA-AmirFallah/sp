@extends('WPA.Layouts.MainPage')
@section('MainCountent')
    <style>
        .custominput {
            height: 12px !important;
            width: 82%;
        }

        .explaintext {
            font-size: .857rem;
            color: #62666d;
        }
    </style>


    <div class="page">

        <div class="page-content account-area">
            <div class="fixed-content py-30">
                <div class="container">

                    <div class=" form-elements ">
                        @if (isset($error))
                            <div
                                style="
                                                                                                    background-color: burlywood;
                                                                                                    width: 100%;
                                                                                                    border-radius: 10px;
                                                                                                    font-size: 11px;
                                                                                                    padding: 10px;
                                                                                                ">
                                <h4>{{ __('error alert') }} </h4>
                                <p> {{ $error }}</p>
                            </div>
                        @endif

                        @if ($Step == 'init')
                            <form method="post">
                                @csrf
                                <h5> ورود / ثبت نام </h5>
                                <div class="title-bar mb-20">
                                    <h3 class="dz-title ma-0">
                                        {{ \App\myappenv::CenterName }}</h3>
                                    <a href="{{ route('login') }}" class="link external icon-close"><i
                                            class="mdi mdi-arrow-left"></i></a>
                                </div>
                                <div class="list mb-0">
                                    <ul class="row">
                                        <li class="item-content item-input col-100 item-input-with-value">
                                            <div class="item-inner">
                                                <div class="item-input-wrap">
                                                    <p>شماره موبایل یا ایمیل خود را وارد کنید</p>
                                                    <input onkeyup="UsernameFormatValidator()" autocomplete="off"
                                                        id="UserName" required name="UserName" value=""
                                                        class="custominput form-control " />
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                @php
                                    $Role = App\Http\Controllers\setting\SettingManagement::GetSiteRole();
                                    
                                @endphp
                                <div class="list">
                                    <ul>
                                        <li class="mb-15"><button type="submit" name="submit" id="OneStep_1"
                                                value="OneStep_1"
                                                class="button-large button button-fill disabled">{{ __('Login') }}</button>
                                            @if ($Role != null)
                                                <a class="button popup-open" href="#" data-popup=".popup-about">شرایط
                                                    استفاده از برنامه</a>
                                                <div class="popup popup-about">
                                                    <div class="block">
                                                        <p>{{ $Role->Titel }}</p>
                                                        <p><a class="link popup-close" href="#">بستن صفحه</a></p>
                                                        {!! $Role->Content !!}
                                                    </div>
                                                </div>
                                            @endif

                                        </li>
                                    </ul>
                                </div>
                            </form>
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
                            <form method="post">
                                @csrf
                                <h5>ورود با کد یکبار مصرف </h5>
                                <div class="title-bar mb-20">
                                    <h3 class="dz-title ma-0">
                                        {{ \App\myappenv::CenterName }}</h3>
                                    <a href="{{ route('login') }}" class="link external icon-close"><i
                                            class="mdi mdi-arrow-left"></i></a>
                                </div>
                                <div class="list mb-0">
                                    <ul class="row">
                                        <li class="item-content item-input col-100 item-input-with-value">
                                            <div class="item-inner">
                                                <div class="item-input-wrap">
                                                    <p class="explaintext">کد یکبار مصرف شما به شماره موبایل
                                                        {{ $MobileNo }}
                                                        ارسال شد</p>
                                                    <input autocomplete="off" required id="confirmcode" inputmode="numeric" name="confirmcode"
                                                        value="" class="custominput form-control " />
                                                </div>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                                <div class="list">
                                    <ul id="conterdiv">
                                        <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                    </ul>
                                    <ul id="Resenddiv">
                                        <li class="mb-15"><button id="OneStep_1btn" type="submit" name="submit"
                                                value="confirmcode" class="button-large button button-fill">ادامه</button>
                                        </li>
                                    </ul>
                                </div>

                            </form>
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
                                        $("#OneStep_1btn").attr('value', 'GetPass');
                                        $("#OneStep_1btn").html('ارسال مجدد');
                                        $("#confirmcode").prop('disabled', true);

                                    }
                                }, 1000);
                            </script>
                        @elseif($Step == 'loginWithSendCode')
                            <form method="post">
                                @csrf
                                <h5>ورود با کد تایید </h5>
                                <div class="title-bar mb-20">
                                    <h3 class="dz-title ma-0">
                                        {{ \App\myappenv::CenterName }}</h3>
                                    <a href="{{ route('login') }}" class="link external icon-close"><i
                                            class="mdi mdi-arrow-left"></i></a>
                                </div>
                                <div class="list mb-0">
                                    <ul class="row">
                                        <li class="item-content item-input col-100 item-input-with-value">
                                            <div class="item-inner">
                                                <div class="item-input-wrap">
                                                    <p class="explaintext">کد تاییده به شماره موبایل {{ $MobileNo }}
                                                        ارسال شد</p>
                                                    <input autocomplete="off" required name="Password" value=""
                                                        class="custominput form-control " />
                                                </div>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                                <div class="list">
                                    <ul id="conterdiv">
                                        <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                    </ul>
                                    <ul id="Resenddiv">
                                        <li class="mb-15"><button id="OneStep_1btn" type="submit" name="submit"
                                                value="login" class="button-large button button-fill">ورود</button>
                                        </li>
                                    </ul>
                                </div>

                            </form>
                            <script>
                                // Set the date we're counting down to
                                var countDownDate = new Date().getTime() + 10000;

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
                                        $("#OneStep_1btn").attr('value', 'GetPass');
                                        $("#OneStep_1btn").html('ارسال مجدد');
                                        $("#confirmcode").prop('disabled', true);

                                    }
                                }, 1000);
                            </script>
                        @elseif($Step == 'login')
                            <form method="post">
                                @csrf
                                <h5> ورود / ثبت نام </h5>
                                <div class="title-bar mb-20">
                                    <h3 class="dz-title ma-0">
                                        {{ \App\myappenv::CenterName }}</h3>
                                    <a href="{{ route('login') }}" class="link external icon-close"><i
                                            class="mdi mdi-arrow-left"></i></a>
                                </div>
                                <div class="list mb-0">
                                    <ul class="row">
                                        <li class="item-content item-input col-100 item-input-with-value">
                                            <div class="item-inner">
                                                <div class="item-input-wrap">
                                                    <p>رمز عبور را وارد کنید</p>
                                                    <input type="password" autocomplete="off" id="Password" required
                                                        name="Password" value=""
                                                        class="custominput form-control " />
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="list">
                                    <ul>
                                        <li class="mb-15"><button type="submit" name="submit" id="OneStep_1"
                                                value="login" class="button-large button button-fill ">ورود</button>
                                        </li>
                            </form>
                            <form method="POST">
                                @csrf
                                <li class="mb-15"><button type="submit" name="submit" id="OneStep_1" value="GetPass"
                                        class="button-large button button-fill ">دریافت کد یکبار
                                        مصرف</button>
                                </li>
                            </form>
                            </ul>
                    </div>
                @elseif($Step == 'information')
                    <form method="post">
                        @csrf
                        <h5 style="margin-top: 0px;padding-top: 0px;"> مشخصات کاربری </h5>
                        <div style="text-align: center" class="row">
                            <div class="col-50">
                                <label class="radio">خانم<input type="radio" name="Sex" value="f" /><i
                                        class="icon-radio"></i></label>
                            </div>
                            <div class="col-50">

                                <label class="radio">آقای<input type="radio" checked name="Sex"
                                        value="m" /><i class="icon-radio"></i></label>
                            </div>
                        </div>


                        <div class="list mb-0">
                            <ul class="row">
                                <li class="item-content item-input col-100 item-input-with-value">
                                    <div class="item-inner">
                                        <div class="item-input-wrap">
                                            <p style="margin-top: 0px;margin-bottom: 0px;">نام</p>
                                            <input required name="Name" value=""
                                                class="custominput form-control " />
                                            <p style="margin-top: 0px;margin-bottom: 0px;">نام خانوادگی</p>
                                            <input required name="Family" value=""
                                                class="custominput form-control " />
                                            <p style="margin-top: 0px;margin-bottom: 0px;">رمز عبور </p>
                                            <input required name="Password" value=""
                                                class="custominput form-control " />
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="list">
                            <ul>
                                <li class="mb-15"><button type="submit" name="submit" id="OneStep_1"
                                        value="Saveinfo" class="button-large button button-fill ">ورود</button>
                                </li>
                            </ul>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            <div class="dz-banner"
                style="position: inherit;height: 100%; text-align:center;width: 100% !important;background-image:url({{ url('/') . \App\myappenv::login_background_image }}); background-repeat:no-repeat; background-size:cover;">
                <img style="margin-top:10%;max-width:150px;" src="{{ url('/') . \App\myappenv::Sitelogo }}"
                    alt="">
            </div>
            <div class="dz-banner-height"></div>

        </div>
    </div>
    </div>
    x

@endsection
