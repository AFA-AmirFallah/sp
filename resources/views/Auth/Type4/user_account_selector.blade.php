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

    @include('Layouts.ErrorHandler')
    <form method="POST">
        @csrf
        <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
            <div class="auth-content">
                <div class="card o-hidden">
                    @foreach ($UserInfo_src as $UserInfo_Item)
                        <div class="navcard navcard-main  card card-profile-1 mb-3">
                            <div class="card-body text-center">
                                <div class="avatar box-shadow-2 mb-3">
                                    <img src="{{ $UserInfo_Item->branch_avatar ?? \App\myappenv::FavIcon }}"
                                        alt="">
                                </div>
                                <h5 class="m-0">{{ $UserInfo_Item->Name }} {{ $UserInfo_Item->Family }} </h5>
                                <p class="mt-0">{{ $UserInfo_Item->RoleName }} </p>
                                <p>{{ $UserInfo_Item->branch_desc }}</p>
                                <button type="submit" name="accountlogin" value="{{ $UserInfo_Item->UserName }}"
                                    class="btn btn-primary btn-rounded">ورود به پنل </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    <script src="/assets/js/common-bundle-script.js"></script>
    <script src="/assets/js/script.js"></script>



</body>

</html>
