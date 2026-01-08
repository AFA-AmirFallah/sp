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
</head>

<body>
    <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>{{ \App\myappenv::CenterName }}</h2>
                        <h3>تایید پراخت</h3>
                        <table class="table" style="text-align: right">
                            <tr>
                                <td>
                                    واریز به حساب
                                </td>
                                <td>
                                    {{ $UserInfo->Name }} {{ $UserInfo->Family }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    مبلغ
                                </td>
                                <td>
                                    @isset($Result->Mony)
                                        {{ number_format($Result->Mony) }}
                                    @else
                                        {{ number_format($Result['Mony']) }}
                                    @endisset

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    تاریخ
                                </td>
                                <td>
                                    @isset($Result->Confirmdate)
                                        {{ $Persian->MyPersianDate($Result->Confirmdate) }}
                                    @else
                                        {{ $Persian->MyPersianDate($Result['Confirmdate'],true) }}
                                    @endisset

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    نوع پرداخت
                                </td>
                                <td>
                                    @isset($Result['GateWay'])
                                        {{ $Result['GateWay'] }}
                                    @else
                                       درگاه بانکی
                                    @endisset

                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
               <a href="{{ route('home') }}"><button class="btn btn-success" >بازگشت به سامانه</button> </a>
            </div>
        </div>
        <script src="/assets/js/common-bundle-script.js"></script>
        <script src="/assets/js/script.js"></script>
</body>

</html>
