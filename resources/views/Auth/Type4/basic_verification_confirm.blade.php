<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if (!isset($branch_src) || $branch_src == null)
        <title>{{ \App\myappenv::CenterName }}</title>
    @else
        <title>{{ $branch_src->Name }}</title>
    @endif
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
    <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            @include('Layouts.ErrorHandler')
                            <div style="text-align:center">
                                <h1 class="mb-3 text-18 " style="text-align: center;">
                                    @if (!isset($branch_src) || $branch_src == null)
                                        {{ \App\myappenv::CenterName }}
                                    @else
                                        {{ $branch_src->Name }}
                                    @endif

                                    <hr> ورود با کد یکبار مصرف
                                </h1>
                                <form method="post">
                                    @csrf
                                    <div class="form-group ">
                                        <label class="text-18" for="UserName" style="float: right;text-align:right">کد
                                            یکبار مصرف شما به شماره موبایل
                                            {{ $MobileNo }} ارسال شد</label>
                                        <div style="text-align: center;display: inline-block;">
                                            <div dir="ltr"
                                                class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                                @for ($i = 1; $i <= strlen(App\myappenv::minpass); $i++)
                                                    <input inputmode="numeric" style="max-width: 40px" required type="text"
                                                        name="confirmcode[{{ $i }}]"
                                                        class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                                        maxlength="1" autofocus>
                                                @endfor
                                            </div>
                                        </div>

                                        <!-- Create a hidden field which is combined by 3 fields above -->
                                        <input type="hidden" name="otp">
                                    </div>
                                    <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                    <button id="OneStep_1btn" type="submit" name="submit" value="confirmcode"
                                        class=" btn btn-primary btn-block mt-2 ">ادامه</button>

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
                        </div>
                    </div>
                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ url('/') . \App\myappenv::login_background_image }})">
                        <div class="pr-3 auth-right">
                            <a href="{{ route('home') }} ">
                                <div class="auth-logo text-center mb-4">
                                    @if (!isset($branch_src) || $branch_src == null)
                                        <img src="{{ \App\myappenv::FavIcon }}" alt="{{ \App\myappenv::CenterName }}">
                                    @else
                                        <img src="{{ $branch_src->avatar }}" alt="{{ $branch_src->Name }}">
                                    @endif

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
        <script>
            document.addEventListener('DOMContentLoaded', function(e) {
                (function() {
                    let maskWrapper = document.querySelector('.numeral-mask-wrapper');

                    for (let pin of maskWrapper.children) {
                        pin.onkeyup = function(e) {
                            // While entering value, go to next
                            if (pin.nextElementSibling) {
                                if (this.value.length === parseInt(this.attributes['maxlength'].value)) {
                                    pin.nextElementSibling.focus();
                                }
                            }

                            // While deleting entered value, go to previous
                            // Delete using backspace and delete
                            if (pin.previousElementSibling) {
                                if (e.keyCode === 8 || e.keyCode === 46) {
                                    pin.previousElementSibling.focus();
                                }
                            }
                        };
                    }

                    const twoStepsForm = document.querySelector('#twoStepsForm');

                    // Form validation for Add new record
                    if (twoStepsForm) {
                        const fv = FormValidation.formValidation(twoStepsForm, {
                            fields: {
                                otp: {
                                    validators: {
                                        notEmpty: {
                                            message: 'لطفا OTP را وارد کنید'
                                        }
                                    }
                                }
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap5: new FormValidation.plugins.Bootstrap5({
                                    eleValidClass: '',
                                    rowSelector: '.mb-3'
                                }),
                                submitButton: new FormValidation.plugins.SubmitButton(),

                                defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                                autoFocus: new FormValidation.plugins.AutoFocus()
                            }
                        });

                        const numeralMaskList = twoStepsForm.querySelectorAll('.numeral-mask');
                        const keyupHandler = function() {
                            let otpFlag = true,
                                otpVal = '';
                            numeralMaskList.forEach(numeralMaskEl => {
                                if (numeralMaskEl.value === '') {
                                    otpFlag = false;
                                    twoStepsForm.querySelector('[name="otp"]').value = '';
                                }
                                otpVal = otpVal + numeralMaskEl.value;
                            });
                            if (otpFlag) {
                                twoStepsForm.querySelector('[name="otp"]').value = otpVal;
                            }
                        };
                        numeralMaskList.forEach(numeralMaskEle => {
                            numeralMaskEle.addEventListener('keyup', keyupHandler);
                        });
                    }
                })();
            });
        </script>


</body>

</html>
