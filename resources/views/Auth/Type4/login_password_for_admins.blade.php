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
    <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            @include('Layouts.ErrorHandler')
                            <div>
                                <h1 class="mb-3 text-18 " style="text-align: center;">
                                    {{ \App\myappenv::CenterName }}
                                    <hr> رمز عبور برای کاربران ویژه
                                </h1>
                                <form method="post">
                                    @csrf
                                    <div class="form-group ">
                                        <label class="text-18" for="UserName" style="float: right;text-align:right">با
                                            توجه به اینکه دسترسی شما ویژه می باشد لذا نیاز به وارد نمودن پسورد جهت ورود
                                            به سامانه دارید</label>
                                        <input type="password" autocomplete="off" required id="confirmcode" name="Password"
                                            class="form-control">
                                    </div>
                                    <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                    <button id="OneStep_1btn" type="submit" name="submit" value="admin_password"
                                        class=" btn btn-primary btn-block mt-2 ">ادامه</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ url('/') . \App\myappenv::login_background_image }})">
                        <div class="pr-3 auth-right">
                            <a href="{{ route('home') }} ">
                                <div class="auth-logo text-center mb-4">
                                    <img src="{{ \App\myappenv::FavIcon }}" alt="">
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script src="/assets/js/common-bundle-script.js"></script>
        <script src="/assets/js/script.js"></script>
</body>

</html>
