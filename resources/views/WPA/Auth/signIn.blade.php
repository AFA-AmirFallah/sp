<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#2196f3">
    <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">
    <title>{{ \App\myappenv::CenterName }}</title>
    <link rel="stylesheet" href="{{url('/') . '/WPA/'}}css/framework7.bundle.min.css">
    <link rel="stylesheet" href="{{url('/') . '/WPA/'}}css/app.css">
    <link rel="stylesheet" href="{{url('/') . '/wpa/'}}css/style.css">
    <link rel="apple-touch-icon" href="img/icon-square.png">
    <link rel="icon" href="img/icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="">
<div id="app">
    <div class="view  view-main view-init safe-areas" data-master-detail-breakpoint="800" data-url="/">
        <div class="row no-gutters vh-100 loader-screen">
            <div class="col align-self-center text-white text-align-center">
                <div class="logo-icon">
                    <img src="img/shafatel logo small.PNG" alt="" />
                </div>
                <div class="laoderhorizontal">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="page page-onboading" data-name="home">
            <div class="page-content pb-100 container">
                <div class="started-swiper-box">
                    <div data-pagination='{"el": ".swiper-pagination", "hideOnClick": true}' class="swiper-container swiper-init swiper-container-initialized swiper-container-horizontal get-started">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class=" slide-info">
                                    <div class="slide-media">
                                        <div class="logo-icon">
                                            <img src="img/shafatel logo small.PNG" alt="" />
                                        </div>
                                    </div>
                                    <div class="slide-content color-white">
                                        <h1 class="text-uppercase dz-title">به شفاتل خوش آمدید</h1>
                                        <p>شبکه تامین کالا و خدمات سلامت</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slide-info">
                                    <div class="slide-media">
                                        <img src="img/slider/2.png" alt="" />
                                    </div>
                                    <div class="slide-content">
                                        <h1 class="text-uppercase dz-title">محصولات ما
                                            بالاترین کیفیت</h1>
                                        <p>محصولات محلی، مصرف محلی، محصولات طبیعی.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slide-info">
                                    <div class="slide-media">
                                        <img src="img/slider/1.png" alt="" />
                                    </div>
                                    <div class="slide-content">
                                        <h1 class="text-uppercase dz-title">پشتیبانی آنلاین 24/7</h1>
                                        <p>رضایت مشتری یکی از اهداف اصلی بسیاری از صاحبان کسب و کار است.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <div class="toolbar toolbar-bottom footer-button padding">
                <div class="container px-15">
                    <a href="/signin/" class="button-large button button-fill">شروع کردن</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{url('/') . '/WPA/'}}js/framework7.bundle.min.js"></script>
<script src="{{url('/') . '/WPA/'}}js/framework7.debug.js"></script>
<script src="{{url('/') . '/WPA/'}}js/routes.js"></script>
<script src="{{url('/') . '/WPA/'}}js/app.js"></script>
</body>
</html>
