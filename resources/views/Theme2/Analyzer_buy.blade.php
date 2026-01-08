@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')
    <form method="post" >
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <!-- Pricing Plans -->
                        <div class="pricing-plans pb-sm-5 pb-2 rounded-top">
                            <div class="container py-5">
                                <h2 class="text-center mb-4 secondary-font">پلن مناسب را برای ترید خود پیدا کنید</h2>
                                <p class="text-center">
                                    با ما شروع کنید - گزینه‌ای عالی برای تریدرها. یک پلن اشتراک متناسب با نیازهای خود
                                    انتخاب کنید.
                                </p>
                                <div class="row mx-0 gy-3">
                                    <!-- Starter -->
                                    <div class="col-xl mb-lg-0 lg-4">
                                        <div class="card border shadow-none">
                                            <div class="card-body">
                                                <h5 class="text-start text-uppercase">اشتراک یک ماهه</h5>

                                                <div class="text-center position-relative mb-4 pb-3">
                                                    <div class="d-flex">
                                                        <h1 class="price-toggle text-primary price-yearly mb-0">
                                                            <small>تومان</small> ۱۵۰،۰۰۰
                                                        </h1>
                                                    </div>
                                                    <small
                                                        class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">
                                                        </small>
                                                </div>

                                                <p>یک ماه دسترسی به تمامی سیگنالهای پلتفرم هوش مصنوعی فینوارد
.                                                </p>

                                                <hr>

                                                <ul class="list-unstyled pt-2 pb-1 lh-1-85">
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        دسترسی به واچ لیست هوش مصنوعی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        ارائه انالیز اندیکاتوری
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        امکان اضافه کردن بک تست های شخصی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        به‌روزرسانی‌های در هر دقیقه
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        یکپارچه سازی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        پشتیبانی کامل
                                                    </li>
                                                </ul>

                                                <button class="btn btn-primary d-grid w-100" type="submit" name="submit"
                                                    value="pay_1">شروع کنید</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Exclusive -->
                                    <div class="col-xl mb-lg-0 lg-4">
                                        <div class="card border border-2 border-primary">
                                            <div class="card-body">
                                                <div
                                                    class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                                    <h5 class="text-start text-uppercase mb-0"> اشتراک سه ماهه</h5>
                                                    <span class="badge bg-primary rounded-pill">محبوب</span>
                                                </div>

                                                <div class="text-center position-relative mb-4 pb-3">
                                                    <div class="d-flex">
                                                        <h1 class="price-toggle text-primary price-yearly mb-0">
                                                            <small>تومان</small> ۳۰۰،۰۰۰
                                                        </h1>
                                                    </div>
                                                    <small
                                                        class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">۳۳ درصد تخفیف</small>
                                                </div>
                                                <p>3 ماه دسترسی به تمامی سیگنالهای پلتفرم هوش مصنوعی فینوارد.</p>

                                                <hr>

                                                <ul class="list-unstyled pt-2 pb-1 lh-1-85">
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        دسترسی به واچ لیست هوش مصنوعی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        ارائه انالیز اندیکاتوری
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        امکان اضافه کردن بک تست های شخصی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        به‌روزرسانی‌های در هر دقیقه
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        یکپارچه سازی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        پشتیبانی کامل
                                                    </li>
                                                </ul>
                                                <button class="btn btn-primary d-grid w-100" type="submit" name="submit"
                                                    value="pay_2">شروع کنید</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enterprise -->
                                    <div class="col-xl mb-lg-0 lg-4">
                                        <div class="card border shadow-none">
                                            <div class="card-body">
                                                <h5 class="text-start text-uppercase">اشتراک یک ساله</h5>

                                                <div class="text-center position-relative mb-4 pb-3">
                                                    <div class="d-flex">
                                                        <h1 class="price-toggle text-primary price-yearly mb-0">
                                                            <small>تومان</small> ۹۰۰،۰۰۰
                                                        </h1>
                                                    </div>
                                                    <small
                                                        class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">50 درصد تخفیف</small>
                                                </div>
                                                <p>یک سال دسترسی به تمامی سیگنالهای پلتفرم هوش مصنوعی فینوارد.</p>
                                                <hr>

                                                <ul class="list-unstyled pt-2 pb-1 lh-1-85">
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        دسترسی به واچ لیست هوش مصنوعی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        ارائه انالیز اندیکاتوری
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        امکان اضافه کردن بک تست های شخصی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        به‌روزرسانی‌های در هر دقیقه
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        یکپارچه سازی
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        پشتیبانی کامل
                                                    </li>
                                                </ul>

                                                <button class="btn btn-primary d-grid w-100" type="submit" name="submit"
                                                    value="pay_3">شروع کنید</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pricing-faqs bg-alt-pricing rounded-bottom">
                            <div class="container py-5">
                                <div class="row mt-0 mt-md-5">
                                    <div class="col-12 text-center mb-4">
                                        <div class="badge bg-label-primary badge-sm">سوالات متداول</div>
                                        <h4 class="my-2 secondary-font">سوالات متداول</h4>
                                        <p>اجازه بدهید به دستیابی به جواب متداول ترین سوالاتی که ممکن است داشته باشید کمک
                                            کنیم.
                                        </p>
                                    </div>
                                </div>
                                <div class="row mx-0">
                                    <div class="col-12">
                                        <div id="faq" class="accordion accordion-header-primary">
                                            <div class="card accordion-item active">
                                                <h6 class="accordion-header">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" aria-expanded="true"
                                                        data-bs-target="#faq-1" aria-controls="faq-1">
                                                        آیا آنالیزهای ارائه شده برای ترید در بازار رمز ارز کافی است؟
                                                    </button>
                                                </h6>

                                                <div id="faq-1" class="accordion-collapse collapse show"
                                                    data-bs-parent="#faq">
                                                    <div class="accordion-body lh-2">
                                                        آنالیزها زمانی به نتایج بهینه می رسد که با دانش فردی ترکیب شود، پس اگر در این زمینه دانش و تجربه کافی ندارید بهتر است ابتدا در دوره آموزشی معامله گیری که برای شما تهیه کرده ایم شرکت کنید. آنالیز اراده شده در پلتفرم هوش مصنوعی فینوارد نتایجی را منتشر می کند که با الگوریتمهای پیشرفته محاسباتی تعیین شده اند و احتمال سودآوری آنها در سرمایه گذاری بالای 78 درصد می باشند
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card accordion-item">
                                                <h6 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#faq-2" aria-expanded="false"
                                                        aria-controls="faq-2">
                                                        آیا نمادهای پیشنهاد شده حتما سودآور هستند؟
                                                    </button>
                                                </h6>
                                                <div id="faq-2" class="accordion-collapse collapse"
                                                    data-bs-parent="#faq">
                                                    <div class="accordion-body lh-2">
                                                        ما علم غیب نداریم و فقط از نظر آماری پیشنهاداتی را به شما میدهیم که
                                                        شاید
                                                        برای بدست آوردن این پیشنهادات باید ساعت ها وقت صرف کنید. بنابر این
                                                        خودتان پیشنهادات ما را با علم و تجربه خود بررسی کنید!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card accordion-item">
                                                <h6 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#faq-3" aria-expanded="false"
                                                        aria-controls="faq-3">
                                                        آیا جایی نتیجه پیشنهادات فینوارد ثبت می شود؟
                                                    </button>
                                                </h6>
                                                <div id="faq-3" class="accordion-collapse collapse"
                                                    data-bs-parent="#faq">
                                                    <div class="accordion-body lh-2">تمام پیشنهادات تولید شده توسط هوش
                                                        مصنوعی
                                                        در روال تست و اعبار سنجی وارد می شوند و هر روز نتیجه پیشتهادات ۲۴
                                                        ساعت
                                                        گذشته در سایت منشر می شود</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <script></script>
@endsection
@section('EndScripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            (function() {
                const priceDurationToggler = document.querySelector('.price-duration-toggler'),
                    priceMonthlyList = [].slice.call(document.querySelectorAll('.price-monthly')),
                    priceYearlyList = [].slice.call(document.querySelectorAll('.price-yearly'));

                function togglePrice() {
                    if (priceDurationToggler.checked) {
                        // If checked
                        priceYearlyList.map(function(yearEl) {
                            yearEl.classList.remove('d-none');
                        });
                        priceMonthlyList.map(function(monthEl) {
                            monthEl.classList.add('d-none');
                        });
                    } else {
                        // If not checked
                        priceYearlyList.map(function(yearEl) {
                            yearEl.classList.add('d-none');
                        });
                        priceMonthlyList.map(function(monthEl) {
                            monthEl.classList.remove('d-none');
                        });
                    }
                }
                // togglePrice Event Listener
                togglePrice();

                priceDurationToggler.onchange = function() {
                    togglePrice();
                };
            })();
        });
    </script>
@endsection
