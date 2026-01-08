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
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light"> تنظیمات ربات / فعال سازی بر روی
                    سیگنال های هوش مصنوعی</span></h4>
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
                                <button onclick="loadinfo()" type="button" class="step-trigger">
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
                                        <small>مشخص سازی میزان سرمایه گذاری بر روی هر سیگنال هوش مصنوعی  </small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="username">میزان سرمایه ورود به بازار و خرید هر نماد</label>
                                            <input type="number" id="InputBaget" name="InputBaget"
                                                value="{{ $CryptoAttr->InputBaget ?? 0 }}" class="form-control text-start"
                                                dir="ltr" placeholder="میزان سرمایه گذاری">
                                            <label class="form-label">مبلغ بر اساس تتر (USDT)</label>
                                            <br>
                                            <label class="form-label" for="username">تعداد سرمایه گذاری همزمان</label>
                                            <input type="number" id="concurnet" name="concurnet"
                                                value="{{ $CryptoAttr->InputBaget ?? 0 }}" class="form-control text-start"
                                                dir="ltr" placeholder="میزان سرمایه گذاری">
                                            <label class="form-label">تعدا نمادهایی که به صورت همزمان سرمایه گذاری انجام می شود</label>
                                            <p>
                                            میزان سرمایه گذاری اولیه و تعداد ورود به بازار بر روی پیشنهادات هوش مصنوعی
                                            </p>
                                        </div>
                                        <div style="text-align: center" class="col-sm-6">
                                            <img src="../../assets/img/illustrations/boy-working-dark.png" class="img-fluid"
                                                alt="Api Key Image" width="300"
                                                data-app-light-img="illustrations/boy-working-light.png"
                                                data-app-dark-img="illustrations/boy-working-dark.png">
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

                                </div>
                                <!-- Address -->
                                <div id="address" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-1">رفتار ربات</h6>
                                        <small>رفتار ربات بیان گر استراتژی ورود به بازار و حد ضرر است</small>
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
                                                                            name="behav" value="1"
                                                                            @if ($behav == 1) checked="" @endif>
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
                                                                            name="behav" value="2"
                                                                            @if ($behav == 2) checked="" @endif>
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
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">خرید با قیمت مارکت</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="market" value="1"
                                                                             checked="" >
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">با قیمت بازار خرید انجام شود</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-md">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="card-title header-elements">
                                                            <h5 class="m-0 me-2">خرید با قیمت Limit</h5>
                                                            <div class="card-title-elements ms-auto">
                                                                <label class="switch switch-primary switch-sm me-0">

                                                                    <label class="switch">
                                                                        <input type="radio" class="switch-input"
                                                                            name="market" value="2"
                                                                            @if ($behav == 2) checked="" @endif>
                                                                        <span class="switch-toggle-slider">
                                                                            <span class="switch-on"></span>
                                                                            <span class="switch-off"></span>
                                                                        </span>
                                                                        <span class="switch-label">انتخاب</span>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p class="card-text">بر اساس قیمت آنالیزور با تعریف دامنه نوسان خرید انجام شود
                                                        </p>
                                                    </div>
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
                                <!-- Social Links -->
                                <div id="social-links" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-1">حد گذاری ربات</h6>
                                        <small>مشخص سازی حد سود و ضرر ربات بر اساس تنظیمات شخصیت ربات.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="twitter"> حد سود   (درصد)</label>
                                            <input type="number" id="benefit" name="benefit" step=".01"
                                                value="{{ $CryptoAttr->benefit ?? 1 }}" class="form-control text-start"
                                                dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="facebook">حد ضرر   (درصد)</label>
                                            <input type="number" id="stop" name="stop" step=".01"
                                                value="{{ $CryptoAttr->stop ?? 1 }}" class="form-control text-start"
                                                dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">حد  نوسان در خرید Limit (درصد)</label>
                                            <input type="number" step=".01" name="start" id="start"
                                                value="{{ $CryptoAttr->start ?? 0.2 }}" class="form-control text-start"
                                                dir="ltr">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">حد زمانی گرید (دقیقه)</label>
                                            <input type="number" name="timelimit" id="timelimit"
                                                value="{{ $CryptoAttr->timelimit ?? 1800 }}"
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
                                    
                                    <p class="fw-semibold mb-2">نحوه سرمایه گذاری</p>
                                    <ul class="list-unstyled">
                                        <li id="InputBaget_o"></li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li id="concurnet_o"></li>
                                    </ul>
                                    <hr>
                                    <p class="fw-semibold mb-2">حد و مرزهای تعیین شده</p>
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
                $('#InputBaget_o').html('میزان سرمایه گذاری روی هر نماد: '  + $('#InputBaget').val() + ' $');
            }
            if ($('#benefit').val() == null || $('#benefit').val() == '') {
                $('#benefit_o').html('حد سود   : ' + 'تعیین نشده');
            } else {
                $('#benefit_o').html('حد سود   : ' + $('#benefit').val() + '%');
            }
            if ($('#stop').val() == null || $('#stop').val() == '') {
                $('#stop_o').html('حد ضرر   : ' + 'تعیین نشده');
            } else {
                $('#stop_o').html('حد ضرر   : ' + $('#stop').val() + '%');
            }
            if ($('#timelimit').val() == null || $('#timelimit').val() == '') {
                $('#timelimit_o').html('حد زمانی : ' + 'تعیین نشده');
            } else {
                $('#timelimit_o').html('حد زمانی : ' + $('#timelimit').val() + ' دقیقه ');
            }
            if ($('#concurnet').val() == null || $('#concurnet').val() == '') {
                $('#concurnet_o').html('تعداد سرمایه گذاری همزمان: ' + 'تعیین نشده');
            } else {
                $('#concurnet_o').html('تعداد سرمایه گذاری همزمان: '  + $('#concurnet').val() + ' نماد ');
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
