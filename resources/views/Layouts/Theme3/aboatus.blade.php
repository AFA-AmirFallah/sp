@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Theme2.Layouts.MainLayout')
@section('PageCSS')
    <link rel="stylesheet" href="/T1assets/vendor/css/pages/page-help-center.css">
@endsection

@section('Content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card overflow-hidden">
            <!-- Help Center Header -->
            <div class="help-center-header d-flex flex-column justify-content-center align-items-center">
                <h3 class="text-center zindex-1 secondary-font">سلام، چطور می‌توانیم کمکتان کنیم؟</h3>
                <h2 class="text-center zindex-1 secondary-font">پلتفرم جامع کسب و کار دیجیکار</h2>
                <p class="text-center zindex-1 px-3 mb-0">
                    زمینه فعالیت: بهداشت و درمان - فروش کالا و خدمات - خبرگزاری - نرم افزار مالی - مدیریت سرمایه
                </p>
            </div>
            <!-- /Help Center Header -->

            <!-- Popular Articles -->
            <div class="help-center-popular-articles py-5">
                <div class="container-xl">
                    <h4 class="text-center mt-2 pb-3 secondary-font">خدمات ما</h4>
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="row mb-3">
                                <div class="col-md-4 mb-md-0 mb-4">
                                    <div class="card border shadow-none">
                                        <div class="card-body text-center">
                                            <img class="mb-4" src="/T1assets/img/icons/unicons/cube.png" height="48"
                                                alt="Help center articles">
                                            <h5>مشاوره و کنترل پروژه</h5>
                                            <p class="text-primary">مشاوره فناوری اطلاعات </p>
                                            <p>مشاوره پیاده سازی سامانه و زیر ساخت بر اساس استاندارد های پیاده سازی و امنیتی
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-md-0 mb-4">
                                    <div class="card border shadow-none">
                                        <div class="card-body text-center">
                                            <img class="mb-4" src="/T1assets/img/icons/unicons/rocket-square.png"
                                                height="48" alt="Help center articles">
                                            <h5>پیاده سازی زیرساخت و شبکه</h5>
                                            <p class="text-primary">زیر ساخت و شبکه</p>
                                            <p>راه اندازی سرور و شبکه - پیاده سازی مانیتورینگ سرویس و نرم افزار </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border shadow-none">
                                        <div class="card-body text-center">
                                            <img class="mb-4" src="/T1assets/img/icons/unicons/desktop.png" height="48"
                                                alt="Help center articles">
                                            <h5>پیاده سازی</h5>
                                            <p class="text-primary">طراحی و پیاده سازی پلتفرم </p>
                                            <p>طراحی و پیاده سازی پلتفرم به همراه پشتیبانی و گسترش</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Popular Articles -->

            <!-- Knowledge Base -->
            <div class="help-center-knowledge-base help-center-bg-alt pt-5 pb-4">
                <div class="container-xl py-2">
                    <h4 class="text-center pb-4 secondary-font">لایسنس های پلتفرم کسب و کار</h4>
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card ">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-store fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">فروشگاه اینترنتی</h5>
                                            <p class="text-info mb-4">فروشگاه کالا</p>
                                            <p class="text-info mb-4">مارکت پلیس
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-news fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">خبر گزاری</h5>
                                            <p class="text-info mb-4">مدیرت محتوا (CMS)</p>
                                            <p class="text-info mb-4">خبرگزاری</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-user-pin fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">مدیریت خدمات</h5>
                                            <p class="text-info mb-4">مدیریت خدمات دهنده</p>
                                            <p class="text-info mb-4">پرونده الکترونیک</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bxs-bank fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">مدیریت سرمایه</h5>
                                            <p class="text-info mb-4">تحلیل گر بازار </p>
                                            <p class="text-info mb-4"> ربات معامله گر</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-recycle fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">کارتابل</h5>
                                            <p class="text-info mb-4">مدیریت گردش کار</p>
                                            <p class="text-info mb-4">ساعتی/ پروژه ایی - پرسنلی</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-git-repo-forked fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">اجاره</h5>
                                            <p class="text-info mb-4">اجاره تجیهزات</p>
                                            <p class="text-info mb-4">اجاره تجهیزات همکار</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-phone fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">کال سنتر</h5>
                                            <p class="text-info mb-4">مشاوره تلفنی</p>
                                            <p class="text-info mb-4">کال سنتر مرکزی</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-file fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">مدیریت فایل</h5>
                                            <p class="text-info mb-4">فایل سنتر عمومی</p>
                                            <p class="text-info mb-4">فایل سنتر خصوصی</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-detail fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">صورت حساب هوشمند</h5>
                                            <p class="text-info mb-4">دوعاملی</p>
                                            <p class="text-info mb-4">تک عاملی</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-message-rounded-dots fs-3 lh-1"></i></span>
                                            <h5 class="mt-3"> مرکز پیامک</h5>
                                            <p class="text-info mb-4">ارسال و دریافت</p>
                                            <p class="text-info mb-4"> دریافت کد دستوری</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bxl-google fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">بهبود عملکرد</h5>
                                            <p class="text-info mb-4">ماژل SEO</p>
                                            <p class="text-info mb-4">گوکل آنالیتکس</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <span class="badge bg-label-secondary p-2 rounded"><i
                                                    class="bx bx-message-detail fs-3 lh-1"></i></span>
                                            <h5 class="mt-3">مدیریت پیامها</h5>
                                            <p class="text-info mb-4">تیکت سنتر</p>
                                            <p class="text-info mb-4">هدایت تیکت</p>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Knowledge Base -->

            <!-- Keep Learning -->
            <div class="help-center-keep-learning py-5">
                <div class="container-xl my-3">
                    <h4 class="text-center pb-4 secondary-font">به توسعه و بهبود ادامه می دهیم</h4>
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="row">
                                <div class="col-md-4 mb-md-0 mb-4 text-center">
                                    <img src="/T1assets/img/icons/unicons/chart.png" class="mb-2" height="48"
                                        alt="Help center blog">
                                    <h5 class="my-3">طراحی گسترش پذیر</h5>
                                    <p class="mb-1">
                                        طراحی پلتفرم کسب و کار دیجیکار به صورت متمرکز انجام شده و برای کسب و کارهای بزرگ به
                                        صورت میکرو سرویس می باشد
                                    </p>
                                </div>
                                <div class="col-md-4 mb-md-0 mb-4 text-center">
                                    <img src="/T1assets/img/icons/unicons/cc-warning.png" class="mb-2" height="48"
                                        alt="Help center inspiration">
                                    <h5 class="my-3">روالهای مالی</h5>
                                    <p class="mb-1">روالهای مالی و حسابداری در پلتفرم کسب و کار دیجی کار کاملا منعطف و بر
                                        اساس منطق cashflow است. </p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <img src="/T1assets/img/icons/unicons/community.png" class="mb-2" height="48"
                                        alt="Help center inspiration">
                                    <h5 class="my-3">رقبا و شرکا</h5>
                                    <p class="mb-1">طراحی هر فسمت از نرم افزار پس از بررسی رقبا و نقاط قوت و ضعف آنها
                                        آنجام شده است و همچنان طراحان ما امکانات جدید رقبا را پایش می کنند</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Keep Learning -->

            <!-- Help Area -->

            <div class="help-center-contact-us help-center-bg-alt">
                <div class="container-xl">
                    <div class="row justify-content-center py-5 my-3">
                        <div class="col-md-8 col-lg-6 text-center">
                            <h4 class="secondary-font">خرید لایسنس و همکاری</h4>
                            <p class="mb-4">
                                متخصصین ما همواره آماده راهنمایی هستند. با ما در طول ساعات <br>
                                کاری تماس بگیرید و یا در هر زمان ایمیل ارسال کنید و ما با شما در ارتباط هستیم .
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">

                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4>امیر فلاح</h4>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-pen"></i>مدیرعامل
                                            </li>
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-map"></i> شهر تهران
                                            </li>
                                            <li class="list-inline-item fw-semibold">
                                                <i style="direction: rtl" class="bx bx-calendar-alt"></i>مدرس مخابرات و
                                                فول استک دولوپر
                                            </li>
                                            <li class="list-inline-item fw-semibold">
                                                <i style="direction: rtl" class="bx bx-phone"></i>۰۹۱۲۳۹۳۶۱۰۵</li>

                                        </ul>
                                    </div>
                                    <a   href="callto:09123936105" class="btn btn-primary text-nowrap">
                                        <i class="bx bx-phone"></i> در دسترس
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4>کاوه راد</h4>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-pen"></i>رئیس هیئت
                                                مدیره</li>
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-map"></i> شهر کرج
                                            </li>
                                            <li class="list-inline-item fw-semibold">
                                                <i style="direction: rtl" class="bx bx-calendar-alt"></i>مدیر محصول و
                                                توسعه بازار
                                            </li>
                                            <li class="list-inline-item fw-semibold">
                                                <i style="direction: rtl" class="bx bx-phone"></i>۰۹۱۲۶۵۴۳۸۰۲</li>
                                        </ul>
                                    </div>
                                    <a href="callto:09126543802" class="btn btn-primary text-nowrap">
                                        <i class="bx bx-phone"></i> در دسترس
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4>زهرا جعفری</h4>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-pen"></i> مدیر پروژه
                                            </li>
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-map"></i> شهر تهران
                                            </li>
                                            <li class="list-inline-item fw-semibold">
                                                <i style="direction: rtl" class="bx bx-calendar-alt"></i> مدیر پروژه
                                            </li>

                                        </ul>
                                    </div>
                                    <button @disabled(true) class="btn btn-dark text-nowrap">
                                         پاسخ به کارفرما
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4>علی مهدیان</h4>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-pen"></i> مدیر
                                                زیرساخت</li>
                                            <li class="list-inline-item fw-semibold"><i class="bx bx-map"></i> شهر تهران
                                            </li>
                                            <li class="list-inline-item fw-semibold">
                                                <i style="direction: rtl" class="bx bx-calendar-alt"></i> طراح دیتاسنتر و
                                                زیر ساخت
                                            </li>

                                        </ul>
                                    </div>
                                    <button class="btn btn-dark text-nowrap">
                                         پاسخ به کارفرما
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Help Area -->
    </div>
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
@endsection
