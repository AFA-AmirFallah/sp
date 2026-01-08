@if (App\myappenv::SiteTheme == 'Theme1')
    @include('Layouts.Theme1.error404')
@else
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ \App\myappenv::CenterName }}</title>
        <meta name="keywords" content="{{ \App\myappenv::CenterName }}">
        <meta name="author" content="Shafatel">
        <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">
        @yield('before-css')
        <link rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
        <link rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
        <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
        <link rel="stylesheet" href="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/select2.min.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/css/jquery-confirm.css">
    </head>

    <body>
        <div class="not-found-wrap text-center">
            <h1 class="text-60">
                404
            </h1>
            <p class="text-36 subheading mb-3">{{ __('error alert') }}</p>
            @if ($exception->getMessage() != null)
                <p class="mb-5  text-muted text-18">
                    {!! $exception->getMessage() !!}</p>
            @else
                <p class="mb-5  text-muted text-18">
                    {{ __("Sorry! The page you were looking for doesn't exist.") }}</p>
            @endif
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-10 col-xl-10">
                                    <div class="ul-faq__details alert_bug">
                                        <h3 class="headding t-font-bold">آیا این صفحه اشتباها به شما نمایش داده شده است؟
                                        </h3>
                                        <p>نمایش این صفحه به شما نشان دهنده عدم وجود صفحه درخواست شده یا عدم دسترسی شما
                                            به صفحه درخواست داده شده است. در صورتی که این خطا به اشتباه به شما نمایش
                                            داده شده است
                                            لطفا تیم برنامه نویسی ما را از این امر مطلع سازید.
                                        </p>
                                        <div class="input-group mb-3">
                                            <textarea required id="main_text" rows="5" class="form-control" placeholder="متن گزارش خرابی...."></textarea>
                                        </div>
                                    </div>
                                    <a class="btn btn-lg btn-primary btn-rounded"
                                        href="/">{{ __('Back to home') }}</a>
                                    <button type="button" onclick="bug_alert()"
                                        class="btn btn-lg btn-warning btn-rounded alert_bug"> ثبت گزارش خرابی</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="/assets/js/common-bundle-script.js"></script>
    <script src="{{ url('/') }}/assets/js/jquery-confirm.js"></script>
    <script>
        function bug_alert() {
            note = $('#main_text').val();
            note = note.replace(/(<([^>]+)>)/ig, "");
            if (note == '') {
                alert('لطفا متن گزارش خرابی را وارد فرمایید!');
            } else {
                if (note.length < 10) {
                    alert('جهت بررسی موثر تر لطفا توضیحات بیشتری وارد فرمائید!');
                } else {
                    url = window.location.href; // Returns full URL 

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('/ajax', {
                            AjaxType: 'Debug',
                            message: 'Error:404 ' + note,
                            main_url: url
                        },

                        function(data, status) {
                            alert('success');
                        });
                        alert('با تشکر از یاری رسانی شما به بهبود سامانه!');
                        $('.alert_bug').addClass('nested');
                }

            }

        }
    </script>

    </html>
@endif
