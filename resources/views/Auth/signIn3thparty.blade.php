<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{\App\myappenv::CenterName}}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/shafatel.min.css')}}">
    <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">

    <link rel="icon" href="{{url('/') . \App\myappenv::FavIcon }}">
    <style>

        body {
            background-image:url("https://api.kookbaz.ir/filemanagement/AllFile/12264/2019/11/19/13422591579261.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
        html {
            height: 100%
        }
    </style>
</head>
<body>

<script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
<script rel="javascript" type="text/javascript" >


    $.ajaxSetup({
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer MkZN9xDCqPeQ5fr4zo3Mbw==_Cva9iGRwMZrfQu_FUF3iPRZLRWrveW8kXvCDw==_YeX/pN762aKl30Z+gG8E+QAxBeq53X0Qy+CRdAsQ9xM=",
            "Cookie": "cookiesession1=1AD09B10UCPRVA1YBEGZXZVAIIVU2FDD"
        }
    });
    $.post('https://api.kookbaz.ir/usermanagement/v2/account/token',
        {
            "otpCode": "01GhMNKSMQxyaEZJutmSn1Pj6hRXsLGF73I8YEmmkSskbc3wTdgCi1BilwlF"
        },

        function (data, status) {
            alert(data);
        });

</script>
</body>
</html>

