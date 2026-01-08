@php
    $Persian = new App\Functions\persian();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>کارت شناسايی: {{ $targetUser->Name }} {{ $targetUser->Family }} </title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
    <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<style>
    .top-text {
        text-align: right;
        font-size: 18px;
        font-weight: 600;
        direction: rtl;
        border-style: none;
        border-color: #3498db;
        border-radius: 9px;
        padding: 10px 3px 10px 3px;

    }
</style>

<body>
    <form method="POST">
        @csrf
        <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
            <div style="
            border-style: groove;
            padding: 22px;
            border-radius: 5px;
            border-color: #3498db;
        "
                class="auth-content">
                <div class="top-text">
                    در کارت زیر با وارد نمودن عنوان شغلی ، کارت شناسائی خود را بسازید.
                    <br>
                    <div style="color:#726c6c">
                        <span>به عنوان مثال:</span>
                        پزشک عمومی، پرستار پرایوت، فیزیوتراپیست و ...

                    </div>
                </div>
                <hr>
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
                                            <h6 class="text-success">{{ __('Personel Status') }} :
                                                {{ $UserStatus->Name }}
                                            </h6>
                                        @else
                                            <h6 class="text-warning">{{ __('Personel Status') }} :
                                                {{ $UserStatus->Name }}
                                            </h6>
                                        @endif
                                        <h6>{{ $targetUser->extranote ?? 'توضیحات کارت' }}</h6>
                                        <div><input class="form-control editing-mod nested" name="extranote"
                                                placeholder="عنوان شغلی" value="{{ $targetUser->extranote ?? '' }}"
                                                type="text"></div>
                                        <p>{{ __('Query time') }} :
                                            {{ $Persian->MyPersianDate(date('Y-m-d h:i:sa'), true) }}</p>
                                    </div>

                                </div>


                                <script>
                                    function editcard() {
                                        $('.edit-mod').addClass('nested');
                                        $('.editing-mod').removeClass('nested');
                                    }

                                    function canceledit() {
                                        $('.edit-mod').removeClass('nested');
                                        $('.editing-mod').addClass('nested');
                                    }
                                </script>


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
                <div class="mt-4">
                    <button type="button" onclick="editcard()"
                        class="btn btn-primary ul-btn-raised--v2  m-1 edit-mod">ویرایش</button>

                    <button type="button" onclick="canceledit()"
                        class="nested btn btn-info ul-btn-raised--v2 m-1 editing-mod">انصراف</button>
                    <button type="submit"
                        class="nested btn btn-danger ul-btn-raised--v2 m-1 editing-mod">دخیره</button>
                </div>
                <hr>
                <div class="top-text">

                    این کارت پرسنلی شما در سامانه پرستاربانک است و با زدن روی گزینه کپی لینک میتوانید آن را با دیگران به
                    اشتراک بگذارید .
                    <button type="button" onclick="copyToClipboard()" class="btn btn-primary ul-btn-raised--v2  m-1 edit-mod"
                        id='copyLinkButton'>کپی لینک <i class="i-Duplicate-Layer"></i></button>

                    <br>
                    <span style="color: red">توجه: </span>
                    هیج یک از مشتریان سامانه پرستاربانک بدون اجازه شما امکان دسترسی به اطلاعات و پروفایل شخصی شما را
                    نخواهند داشت و صرفا کارت پرسنلی شما به آنها نمایش داده خواهد شد.
                </div>
            </div>

    </form>
    <script>
        function copyToClipboard() {
            const input = document.createElement('input');
            input.value = window.location.href; // Get the current URL  
            document.body.appendChild(input);
            input.select(); // Select the input value  
            document.execCommand('copy'); // Copy the selected text to clipboard  
            document.body.removeChild(input); // Remove the input element from the DOM  
            alert('لینک کارت پرسنلی کپی شد!');
        }

    </script>

    <script src="/assets/js/common-bundle-script.js"></script>
    <script src="/assets/js/script.js"></script>
</body>

</html>
