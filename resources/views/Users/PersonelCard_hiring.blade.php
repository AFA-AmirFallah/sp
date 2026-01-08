@php
    $Persian = new App\Functions\persian();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ \App\myappenv::CenterName }}</title>
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
            <div style="
            border-width: 3px;
            border-color: #3498db;
            border-style: groove;
        "
                class="card o-hidden">

                <div class="row">

                    <div class="col-md-6">

                        <div class="p-4">


                            <div class="user-profile mb-4">
                                <div class="ul-widget-card__user-info">
                                    <img style="
                                            border-width: 3px;
                                            border-style: groove;
                                            border-color: #3498db;
                                        "
                                        class="profile-picture avatar-lg mb-2"
                                        src=" @if ($targetUser->avatar != null) {{ $targetUser->avatar }}
        @else
            {{ url('/') }}/assets/images/avtar/useravatar.png @endif"
                                        alt="">
                                    <p style="font-weight:600;" class="m-0 text-24">{{ $targetUser->Name }}
                                        {{ $targetUser->Family }}</p>
                                    @if ($UserStatus->Status == 101)
                                        <h6 class="text-success">{{ __('Personel Status') }} : {{ $UserStatus->Name }}
                                        </h6>
                                    @else
                                        <h6 class="text-warning">{{ __('Personel Status') }} : {{ $UserStatus->Name }}
                                        </h6>
                                    @endif
                                    <h6>{{ $targetUser->extranote ?? 'توضیحات کارت' }}</h6>
                                    <p>{{ __('Query time') }} :
                                        {{ $Persian->MyPersianDate(date('Y-m-d h:i:sa'), true) }}</p>
                                </div>

                            </div>
                            <hr>
                            <div class="mt-4">
                                <button type="button" class="btn btn-primary ul-btn-raised--v2  m-1">ثبت تجربه دریافت
                                    خدمت</button>
                                <button type="button"
                                    class="btn btn-outline-success ul-btn-raised--v2 m-1 float-right">استعلام</button>
                            </div>



                        </div>
                    </div>

                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ url('/') . \App\myappenv::login_background_image }})">
                        <div class="pr-3 auth-right">
                            <a href=" {{ route('home') }} ">
                                <div class="auth-logo text-center mb-4">
                                    <img src="{{ url('/') . \App\myappenv::MainIcon }}" alt="">
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
