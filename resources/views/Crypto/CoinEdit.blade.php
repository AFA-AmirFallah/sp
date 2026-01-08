@php
    $Persian = new App\Functions\persian();
    $registeDate = $Persian->MyPersianDate(Auth::user()->CreateDate);
@endphp

@extends('Theme2.Layouts.MainLayout')
@section('PageCSS')
    <link rel="stylesheet" href="/T1assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/bs-stepper/bs-stepper.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/bootstrap-select/bootstrap-select.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/select2/select2.css">
@endsection

@section('Content')
    <form method="post">
        @csrf

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light"> تنظیمات ربات /</span>
                {{ $CoinSrc->CoinName }}</h4>
            <div class="row gy-4">
                <div class="col-12">
                    <div class="bs-stepper wizard-icons wizard-icons-example mt-2">
                        <div class="bs-stepper-header">
                            <div class="step" data-target="#account-details">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewbox="0 0 54 54">
                                            <use xlink:href="/T1assets/svg/icons/form-wizard-account.svg#wizardAccount">
                                            </use>
                                        </svg>
                                    </span>
                                    <span class="bs-stepper-label">بودجه</span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" data-target="#personal-info">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewbox="0 0 58 54">
                                            <use xlink:href="/T1assets/svg/icons/form-wizard-personal.svg#wizardPersonal">
                                            </use>
                                        </svg>
                                    </span>
                                    <span class="bs-stepper-label">شخصیت ربات</span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" data-target="#address">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewbox="0 0 54 54">
                                            <use xlink:href="/T1assets/svg/icons/form-wizard-address.svg#wizardAddress">
                                            </use>
                                        </svg>
                                    </span>
                                    <span class="bs-stepper-label">رفتار ربات</span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" data-target="#social-links">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewbox="0 0 54 54">
                                            <use
                                                xlink:href="/T1assets/svg/icons/form-wizard-social-link.svg#wizardSocialLink">
                                            </use>
                                        </svg>
                                    </span>
                                    <span class="bs-stepper-label">گرید ها</span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" data-target="#review-submit">
                                <button  onclick="loadinfo()" type="button" class="step-trigger">
                                    <span class="bs-stepper-icon">
                                        <svg viewbox="0 0 54 54">
                                            <use xlink:href="/T1assets/svg/icons/form-wizard-submit.svg#wizardSubmit"></use>
                                        </svg>
                                    </span>
                                    <span class="bs-stepper-label">بررسی و اجرا</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <form onsubmit="return false">
                                <!-- Account Details -->
                                <div id="account-details" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-1">میزان سرمایه گذاری</h6>
                                        <small>مشخص سازی میزان سرمایه گذاری ورود به بازار</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="username">میزان سرمایه</label>
                                            <input type="number" id="InputBaget" name="InputBaget" value="{{ $CryptoAttr->InputBaget ?? 0 }}" 
                                                class="form-control text-start" dir="ltr"
                                                placeholder="میزان سرمایه گذاری">
                                            <label class="form-label">میزان سرمایه ورود به بازار</label>
                                            <p>
                                                میزان سرمایه گذاری اولیه بر روی رمز ارز پیشنهادی
                                            </p>

                                        </div>
                                        <div class="col-sm-6">
                                            <div style="height: 500px">
                                                <iframe id="tradingview_4c8ef"
                                                    src="https://s.tradingview.com/widgetembed/?frameElementId=tradingview_4c8ef&amp;symbol={{ $CoinSrc->CoinName }}USDT&amp;interval=D&amp;hidesidetoolbar=0&amp;symboledit=0&amp;saveimage=1&amp;toolbarbg=f4f7f9&amp;studies=%5B%5D&amp;hideideas=1&amp;theme=dark&amp;timezone=Asia%2FTehran&amp;withdateranges=1&amp;studies_overrides=%7B%7D&amp;overrides=%7B%7D&amp;enabled_features=%5B%22header_fullscreen_button%22%2C%22side_toolbar_in_fullscreen_mode%22%2C%22header_in_fullscreen_mode%22%2C%22header_undo_redo%22%2C%22header_settings%22%5D&amp;disabled_features=%5B%22header_saveload%22%5D&amp;locale=en&amp;utm_source=wallex.ir&amp;utm_medium=widget&amp;utm_campaign=chart&amp;utm_term=BINANCE%3ABTCUSDT#%7B%22page-uri%22%3A%22wallex.ir%2Fapp%2Ftrade%2FBTCTMN%22%7D"
                                                    style="width: 100%; height: 100%; margin: 0 !important; padding: 0 !important;"
                                                    frameborder="0" allowtransparency="true" scrolling="no"
                                                    allowfullscreen=""></iframe>
                                            </div>

                                        </div>

                                        <div class="col-12 d-flex justify-content-between">
                                            <button type="button" class="btn btn-label-secondary btn-prev" disabled>
                                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                <span class="d-sm-inline-block d-none">قبلی</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-next">
                                                <span class="d-sm-inline-block d-none me-sm-1">بعدی</span>
                                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal Info -->
                                @php
                                    $RobotType = $CryptoAttr->type ?? 0;
                                    $behav = $CryptoAttr->behav ?? 0; 
                                @endphp
                                <div id="personal-info" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-1">شخصیت ربات</h6>
                                        <small>شخصیت روبات ها بر گرفته از نحوه کار تریدر ها در شرایط گوناگون است</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">بخر نگه دار</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="type" value="1" @if($RobotType == 1) checked="" @endif  >
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>

                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">مناسب برای بازارهای صعودی که اطمینان از رشد آن
                                                            دارید</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">بخر بفروش</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="type" value="2"  @if($RobotType == 2) checked="" @endif >
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">مناسب برای بازارهای نامظمئن و صعودی</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">بخر بخر</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="type" value="3"  @if($RobotType == 3) checked="" @endif >
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">مناسب برای بازارهای آینده دار</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">بخر بفروش بخر</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="type" value="4"  @if($RobotType == 4) checked="" @endif >
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>

                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">مناسب برای بازارهای پر طلاتم</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2 ">هانسل گرتل</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">
                                                                    <label class="switch">
                                                                        <label class="switch">
                                                                            <input type="radio" class="switch-input"
                                                                                name="type" value="5"  @if($RobotType ==5) checked="" @endif 
                                                                              >
                                                                            <span class="switch-toggle-slider">
                                                                                <span class="switch-on"></span>
                                                                                <span class="switch-off"></span>
                                                                            </span>
                                                                            <span class="switch-label">انتخاب</span>
                                                                        </label>
                                                                    </label>

                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">فرمول معاملاتی انحصاری دیجی کار </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between">
                                            <button type="button" class="btn btn-primary btn-prev">
                                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                <span class="d-sm-inline-block d-none">قبلی</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-next">
                                                <span class="d-sm-inline-block d-none me-sm-1">بعدی</span>
                                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Address -->
                                <div id="address" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-1">شخصیت ربات</h6>
                                        <small>شخصیت روبات ها بر گرفته از نحوه کار تریدر ها در شرایط گوناگون است</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">حد ضرر خزنده</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="behav" value="1"  @if($behav ==1) checked="" @endif >
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">مناسب برای بازارهای نواسان دار جهت دریافت سود
                                                            تا
                                                            هر کجا که گرید بازگردد</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">حد ضرر ثابت</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="behav" value="2" @if($behav ==2) checked="" @endif>
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">مناسب برای بازارهای کم نوسان و دریافت سود قطعی
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <button  type="button" class="btn btn-primary btn-prev">
                                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                            <span class="d-sm-inline-block d-none">قبلی</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next">
                                            <span class="d-sm-inline-block d-none me-sm-1">بعدی</span>
                                            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Social Links -->
                                <div id="social-links" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-1">حد گذاری ربات</h6>
                                        <small>مشخص سازی حد سود و ضرر ربات بر اساس تنظیمات شخصیت ربات.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="twitter"> حد سود هر گرید (درصد)</label>
                                            <input type="number" id="benefit" name="benefit" step=".01" value="{{ $CryptoAttr->benefit ?? 1 }}"
                                                class="form-control text-start" dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="facebook">حد ضرر هر گرید (درصد)</label>
                                            <input type="number" id="stop" name="stop" step=".01" value="{{ $CryptoAttr->stop ?? 1 }}"
                                                class="form-control text-start" dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="google">حد سود کلی (درصد)</label>
                                            <input type="number" step=".01" id="RobotstopUp" value="{{ $CryptoAttr->RobotstopUp ?? '0' }}"  name="RobotstopUp"
                                                class="form-control text-start" dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="linkedin">حد ضرر کلی (درصد)</label>
                                            <input type="number" step=".01" id="RobotstopDown" value="{{ $CryptoAttr->RobotstopDown ?? '0' }}"  name="RobotstopDown"
                                                class="form-control text-start" dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">حد شروع مجدد (درصد)</label>
                                            <input type="number" step=".01" name="start" id="start"  value="{{ $CryptoAttr->start ?? 0.2 }}"
                                                class="form-control text-start" dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">حد زمانی گرید (دقیقه)</label>
                                            <input type="number" name="timelimit" id="timelimit" value="{{ $CryptoAttr->timelimit ?? 1800 }}"
                                                class="form-control text-start" dir="ltr">
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <button type="button" class="btn btn-primary btn-prev">
                                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                <span class="d-sm-inline-block d-none">قبلی</span>
                                            </button>
                                            <button type="button" onclick="loadinfo()" class="btn btn-primary btn-next">
                                                <span class="d-sm-inline-block d-none me-sm-1">بعدی</span>
                                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Review -->
                                <div id="review-submit" class="content lh-2">
                                    <p class="fw-semibold mb-2">نام رمز ارز</p>
                                    <ul class="list-unstyled">
                                        <li>{{ $CoinSrc->CoinName }}</li>
                                    </ul>
                                    <hr>
                                    <p class="fw-semibold mb-2">میزان سرمایه گذاری</p>
                                    <ul class="list-unstyled">
                                        <li id="InputBaget_o"></li>
                                    </ul>
                                    <hr>
                                    <p class="fw-semibold mb-2">رفتار و شخصیت ربات</p>
                                    <ul class="list-unstyled">
                                        <li id="type_o">آدرس</li>
                                        <li id="behav_o">آدرس</li>
                                    </ul>
                                    <hr>
                                    <p class="fw-semibold mb-2">حدود و مرزهای تعیین شده</p>
                                    <ul class="list-unstyled">
                                        <li id="benefit_o"></li>
                                        <li id="stop_o"></li>
                                        <li id="RobotstopUp_o"></li>
                                        <li id="RobotstopDown_o"></li>
                                        <li id="start_o"></li>
                                        <li id="timelimit_o"></li>
                                    </ul>
                                    <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary btn-prev">
                                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                            <span class="d-sm-inline-block d-none">قبلی</span>
                                        </button>
                                        <button type="submit" class="btn btn-success btn-submit">ثبت</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
@endsection
@section('EndScripts')
    <script src="/T1assets/vendor/js/menu.js"></script>
    <script src="/T1assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="/T1assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="/T1assets/vendor/libs/bootstrap-select/i18n/defaults-fa_IR.js"></script>
    <script src="/T1assets/vendor/libs/select2/select2.js"></script>
    <script src="/T1assets/vendor/libs/select2/i18n/fa.js"></script>

    <!-- Main JS -->
    <script src="/T1assets/js/main.js"></script>

    <!-- Page JS -->

    <script src="/T1assets/js/form-wizard-icons.js"></script>
    <script>
        function loadinfo() {
            if ($('#InputBaget').val() == null || $('#InputBaget').val() == '') {
                $('#InputBaget_o').html('تعیین نشده');
            } else {
                $('#InputBaget_o').html('$' + $('#InputBaget').val());
            }
            if ($('#benefit').val() == null || $('#benefit').val() == '') {
                $('#benefit_o').html('حد سود هر گرید : ' + 'تعیین نشده');
            } else {
                $('#benefit_o').html('حد سود هر گرید : ' + $('#benefit').val() + '%');
            }
            if ($('#stop').val() == null || $('#stop').val() == '') {
                $('#stop_o').html('حد ضرر هر گرید : ' + 'تعیین نشده');
            } else {
                $('#stop_o').html('حد ضرر هر گرید : ' + $('#stop').val() + '%');
            }
            if ($('#RobotstopUp').val() == null || $('#RobotstopUp').val() == '') {
                $('#RobotstopUp_o').html('حد سود کلی: ' + 'تعیین نشده');
            } else {
                $('#RobotstopUp_o').html('حد سود کلی : ' + $('#RobotstopUp').val() + '%');
            }
            if ($('#RobotstopDown').val() == null || $('#RobotstopDown').val() == '') {
                $('#RobotstopDown_o').html('حد ضرر کلی : ' + 'تعیین نشده');
            } else {
                $('#RobotstopDown_o').html('حد ضرر کلی : ' + $('#RobotstopDown').val() + '%');
            }
            if ($('#start').val() == null || $('#start').val() == '') {
                $('#start_o').html('حد شروع مجدد: ' + 'تعیین نشده');
            } else {
                $('#start_o').html('حد شروع مجدد: ' + $('#start').val() + '%');
            }
            if ($('#timelimit').val() == null || $('#timelimit').val() == '') {
                $('#timelimit_o').html('حد زمانی گرید: ' + 'تعیین نشده');
            } else {
                $('#timelimit_o').html('حد زمانی گرید: ' + $('#timelimit').val() + 'دقیقه ');
            }
            type = $('input[name="type"]:checked').val();
            switch (type) {
                case '1':
                    $('#type_o').html('بخر نگه دار');
                    break;
                case '2':
                    $('#type_o').html('بخر بفروش');
                    break;
                case '3':
                    $('#type_o').html('بخر بخر');
                    break;
                case '4':
                    $('#type_o').html('بخر بفروش بخر');
                    break;
                case '5':
                    $('#type_o').html('هانسل گرتل');
                    break;

                default:
                    // code block
            }
            behav = $('input[name="behav"]:checked').val();
            switch (behav) {
                case '1':
                    $('#behav_o').html('حد ضرر خزنده');
                    break;
                case '2':
                    $('#behav_o').html('حد ضرر ثابت');
                    break;

                default:
                    // code block
            }

        }
    </script>
@endsection
