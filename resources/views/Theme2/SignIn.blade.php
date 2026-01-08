<!DOCTYPE html>
<html lang="fa" class="light-style customizer-hide" dir="rtl" data-theme="theme-default"
    data-assets-path="./T1assets/" data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>{{ \App\myappenv::CenterName }}</title>

    <meta name="description" content="{{ \App\myappenv::description }}">
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ \App\myappenv::FavIcon }}">

    <!-- Icons -->
    <link rel="stylesheet" href="./T1assets/vendor/fonts/boxicons.css">
    <link rel="stylesheet" href="./T1assets/vendor/fonts/fontawesome.css">
    <link rel="stylesheet" href="./T1assets/vendor/fonts/flag-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="./T1assets/vendor/css/rtl/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="./T1assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css">
    <link rel="stylesheet" href="./T1assets/css/demo.css">
    <link rel="stylesheet" href="./T1assets/vendor/css/rtl/rtl.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="./T1assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="./T1assets/vendor/libs/typeahead-js/typeahead.css">
    <!-- Vendor -->
    <link rel="stylesheet" href="./T1assets/vendor/libs/formvalidation/dist/css/formValidation.min.css">

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="./T1assets/vendor/css/pages/page-auth.css">
    <!-- Helpers -->
    <script src="./T1assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="./T1assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="./T1assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
                <div class="flex-row text-center mx-auto">
                    <img src="./T1assets/img/pages/login-light.png" alt="Auth Cover Bg color" width="520"
                        class="img-fluid authentication-cover-img" data-app-light-img="pages/login-light.png"
                        data-app-dark-img="pages/login-dark.png">
                    <div class="mx-auto">
                        <h3>قدرتمند ترین ابزار سرمایه گذاری</h3>
                        <p>
                            کاملا مناسب برای هر سطح از سرمایه گذاران که به شما کمک می‌کند <br>
                            تا با کمترین دانش سرمایه گذاری موفقیت های مالی را تجربه کنید
                        </p>
                    </div>
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        <a href="#" class="app-brand-link gap-2 mb-2">

                            <span class="app-brand-logo demo">
                                <img style="width: 31px;border-radius: 50%;" src="{{ \App\myappenv::MainIcon }}"
                                    alt="">
                            </span>
                            <span class="app-brand-text demo h3 mb-0 fw-bold">{{ \App\myappenv::CenterName }}</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">به {{ \App\myappenv::CenterName }} خوش آمدید!</h4>
                    <p class="mb-4">لطفا وارد حساب خود شده و ماجراجویی را شروع کنید</p>

                    <form class="mb-3" method="POST">
                        @csrf
                        <input name="TargetUrl" class="nested" value="{{ $TargetUrl }}">
                        <div class="mb-3">
                            <label for="email" class="form-label"> شماره موبایل</label>
                            <input type="text" class="form-control text-start" dir="ltr" name="UserName"
                                required placeholder="شماره موبایل خود را وارد کنید" autofocus>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me"> به خاطر سپاری </label>
                            </div>
                        </div>
                        <button type="submit" name="submit" value="OneStep_1"
                            class="btn btn-primary d-grid w-100">ورود</button>
                    </form>

                    <p class="text-center">
                        <span>کاربر جدید هستید؟</span>
                        <a href="#">
                            <span>یک حساب بسازید</span>
                        </a>
                    </p>

                    <div class="divider my-4">
                        <div class="divider-text">یا</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                            <i class="tf-icons bx bxl-facebook"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                            <i class="tf-icons bx bxl-google-plus"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                            <i class="tf-icons bx bxl-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="./T1assets/vendor/libs/jquery/jquery.js"></script>
    <script src="./T1assets/vendor/libs/popper/popper.js"></script>
    <script src="./T1assets/vendor/js/bootstrap.js"></script>
    <script src="./T1assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="./T1assets/vendor/libs/hammer/hammer.js"></script>

    <script src="./T1assets/vendor/libs/i18n/i18n.js"></script>
    <script src="./T1assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="./T1assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="./T1assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="./T1assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="./T1assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="./T1assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="./T1assets/js/pages-auth.js"></script>
</body>

</html>
