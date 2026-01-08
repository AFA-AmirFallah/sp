mo<!DOCTYPE html>
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
    <script>
        function get_action(form) {
            var v = grecaptcha.getResponse();
            if (v.length == 0) {
                document.getElementById('captcha').innerHTML = "You can't leave Captcha Code empty";
                return false;
            } else {
                document.getElementById('captcha').innerHTML = "Captcha completed";
                return true;
            }
        }
    </script>
</head>

<body>
    <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            @include('Layouts.ErrorHandler')
                            <h1 class="mb-3 text-18 " style="text-align: center;">{{ __('Enter to user panel') }}</h1>
                            <form id="login-form" method="post">
                                @csrf
                                <div class="form-group ">
                                    <label class="text-18" for="UserName"
                                        style="float: right;">{{ __('Mobile No') }}</label>
                                    <input id="UserName" name="UserName" class="form-control form-control-rounded">
                                </div>
                                <div class="form-group">
                                    <label class="text-18" for="password"
                                        style="float: right;">{{ __('Password') }}</label>
                                    <input id="password" name="UserPass" class="form-control form-control-rounded"
                                        type="password">
                                    <input name="TargetUrl" class="nested" value="{{ $TargetUrl }}">

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
                                    <button type="submit" data-sitekey="{{ App\myappenv::RECAPTCHA_SITE_KEY }}"
                                        data-callback='onSubmit'
                                        class="btn btn-rounded btn-primary btn-block mt-2 g-recaptcha">{{ __('Login') }}</button>
                                @else
                                    <button type="submit"
                                        class="btn btn-rounded btn-primary btn-block mt-2">{{ __('Login') }}</button>

                                @endif
                            </form>
                            <div class="mt-3 text-center">
                                <a href="{{ Route('forgot') }}"
                                    class="text-muted"><u>{{ __('Are you forget password') }}
                                    </u>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ url('/') . \App\myappenv::login_background_image }})">
                        <div class="pr-3 auth-right">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{ url('/') . \App\myappenv::MainIcon }}" alt="">
                            </div>
                            <a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text"
                                href="{{ route('register') }}">
                                <i class="i-Add-User"></i> {{ __('Register') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/common-bundle-script.js"></script>
        <script src="/assets/js/script.js"></script>
        <script rel="javascript" type="text/javascript">
            var settings = {
                "url": "https://api.kookbaz.ir/usermanagement/v2/account/token",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer MkZN9xDCqPeQ5fr4zo3Mbw==_Cva9iGRwMZrfQu_FUF3iPRZLRWrveW8kXvCDw==_YeX/pN762aKl30Z+gG8E+QAxBeq53X0Qy+CRdAsQ9xM=",
                    "Cookie": "cookiesession1=1AD09B10UCPRVA1YBEGZXZVAIIVU2FDD"
                },
                "data": JSON.stringify({
                    "otpCode": "TemCKpFp9TD9JnHB8iE9QIGaaljMuCKzxjzB50fBMVKzZTMHYFyzifOlImCy"
                }),
            };

            $.ajax(settings).done(function(response) {
                console.log(response);
            });
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
