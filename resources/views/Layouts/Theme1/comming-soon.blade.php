<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>{{ \App\myappenv::description }}</title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="{ \App\myappenv::description }}">
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ url('/') . \App\myappenv::FavIcon }}">

    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: {
                families: ['Poppins:400,500,600,700,800']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = 'assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <link rel="preload" href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ url('/') }}/Theme1/assets/fonts/wolmart87d5.ttf?png09e" as="font"
        type="font/ttf" crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/fontawesome-free/css/all.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/Theme1/assets/vendor/animate/animate.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ url('/') }}/Theme1/assets/vendor/magnific-popup/magnific-popup.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/Theme1/assets/css/style.min.css">
</head>

<body>
    <div class="page-wrapper">
        <main class="main">
            <div class="page-content">
                <div class="banner coming-soon-bg"
                    style="background-image: url(../../../www.portotheme.com/html/wolmart/assets/images/pages/coming/coming-soon.html); background-color: #333;">
                    <div class="coming-content-wrapper d-flex align-items-center justify-content-end pl-sm-4 pr-sm-4">
                        <div class="coming-content">
                            <a href="demo1.html" class="logo">
                                <img src="{{ asset(App\myappenv::Sitelogo) }}" alt="Logo" width="168"
                                    height="53">
                            </a>
                            <h2 class="coming-title ls-25">به <span> زودی ...</span></h2>
                            <p>ما در حال بررسی و رفع مشکلات هستیم. امروز یا فردا به بهترین و جذاب ترین بروز رسانی
                                خدمتتون خواهیم رسید. </p>
                            <div class="countdown countdown-coming" data-until="+10d" data-format="DHMS"
                                data-relative="true">10:00:00</div>

                            <div class="social-icons social-icons-colored">
                                <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                <a href="#" class="social-icon social-instagram w-icon-instagram"></a>
                                <a href="#" class="social-icon social-youtube w-icon-youtube"></a>
                                <a href="#" class="social-icon social-pinterest w-icon-pinterest"></a>
                            </div>
                            <p class="copyright mb-0">{!! App\myappenv::copyright !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i
            class="fas fa-chevron-up"></i></a>

    <!-- Plugin JS File -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/jquery.plugin/jquery.plugin.min.js"></script>
    <script src="assets/vendor/jquery.countdown/jquery.countdown.min.js"></script>
    <script src="assets/js/main.min.js"></script>
</body>


</html>
