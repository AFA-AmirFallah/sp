@extends('Layouts.Theme4.Layout.mian_layout')
@section('content')
    @foreach ($mobile_banners as $mobile_banner)
        @if ($mobile_banner->theme == 401)
            @include('Layouts.Theme4.Layout.objects.main_banner')
        @endif
        @if ($mobile_banner->theme == 402)
            @include('Layouts.Theme4.Layout.objects.small_cards')
        @endif
    @endforeach
    @if (\App\myappenv::version >= 3)
        <section class="st-section-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                            data-wow-delay="0.2s">
                            <div class="st-iconbox-icon">
                                <i class="flaticon-focus"></i>
                            </div>
                            <h3 class="st-iconbox-title">اتوماسیون درمان</h3>
                            <div class="st-iconbox-text">
                                شفاتل با استفاده از HCIS v4 اتوماسیون مراکز خدمات هوم کر را انجام می دهد
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                            data-wow-delay="0.3s">
                            <div class="st-iconbox-icon">
                                <i class="flaticon-career"></i>
                            </div>
                            <h3 class="st-iconbox-title">تمرکز بر کسب و کار</h3>
                            <div class="st-iconbox-text">
                                با استفاده از پلتفرم شفاتل تمرکز مدیران هوم کر تنها بر ارائه خدمات با کیفیت به بیماران است
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                            data-wow-delay="0.4s">
                            <div class="st-iconbox-icon">
                                <i class="flaticon-career-1"></i>
                            </div>
                            <h3 class="st-iconbox-title">نظام ارجاع</h3>
                            <div class="st-iconbox-text">
                                شفاتل مدیریت ارجاع بیمار را بین مراکز فعال در زنجیره سلامت بر عهده دارد
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="st-section-top">
            <div style="margin-top: 20px" class="container">
                <div class="st-section-heading st-style2 text-center">
                    <h2>مراکز مجاز خدمات پزشکی و پرستاری در منزل</h2>
                    <div class="st-seperator">
                        <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                        </div>
                        <img src="/Theme4/assets/img/light-img/seperator-icon1.png" alt="demo"
                            class="st-seperator-icon">
                        <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                        </div>
                    </div>
                    <p>ارائه خدمات شایسته و با کیفیت اتفاقی نیست <br> ما افتخار داریم به مراکز دارای مجوز خدمات درمانی در
                        منزل
                        امکانات نرم افزاری جهت بهبود مدیریت خدمات رسانی به بیماران ارائه میکنیم</p>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach (\App\branchenv::get_active_branches() as $branch_src)
                        <a href="{{ route('login', ['BranchName' => $branch_src->login_name]) }}">
                            <div class="col-lg-4">
                                <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                                    data-wow-delay="0.2s">
                                    <div style="max-width: 50px" class="st-iconbox-icon">
                                        <img src="{{ $branch_src->avatar }}" alt="">
                                    </div>
                                    <h3 class="st-iconbox-title">{{ $branch_src->Name }}</h3>
                                    <div class="st-iconbox-text">
                                        {{ $branch_src->Description }}
                                    </div>
                                    <span></span>
                                    <a style="margin-top: 20px" class="btn btn-success"
                                        href="{{ route('login', ['BranchName' => $branch_src->login_name]) }}">ورود به
                                        سامانه
                                    </a>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        <div class="st-about-wrap st-section-top" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="st-vertical-middle">
                            <div class="st-vertical-middle-in">
                                <div class="st-about-img wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.2s">
                                    <img src="https://panel.shafatel.com/storage/photos/banners/about-img1.png"
                                        alt="demo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="st-section-heading st-style1">
                            <h3>درباره ما</h3>
                            <h2 style="text-align: justify;color: cornflowerblue;font-size:30px;">ما یک تیم فناوری اطلاعات
                                برای همراهی شما جهت افزایش بهره‌وری و حضور موثر در فضای مجازی هستیم.</h2>
                        </div>
                        <div class="st-about-text">
                            <p style="text-align: justify;">تیم دیجی‌کار سالهااست در زمینه فناوری اطلاعات حوزه درمان فعالیت
                                می کند و نیازمندی‌های
                                ساختارهای IT در این حوزه را به خوبی میداند و بر این اساس اقدام به ارائه پلتفرم قدرتمند شفاتل
                                نموده است مزایای پلتفرم شفاتل :</p>
                            <ul class="tr-list">
                                <li>شفاتل تیم درمان نیست و در روالها و ارجاعات درمانی هیچ گونه دخل و تصرفی ندارد.</li>
                                <li>اعتماد سازی برای بیماران بر اساس شفافیت روالهای درمانی و مالی.</li>
                                <li>اعتماد سازی برای بیمه ها و تامین کنندگان مالی بر اساس صحت ارائه خدمات.</li>
                                <li>ارجاع امن در بستر شفاتل برای کلیه فعالین حوزه سلامت.</li>
                                <li>پنجره واحد ارائه دهندگان خدمات درمانی مراقبتی در منزل</li>
                            </ul>
                            <a href="#" class="st-btn st-style1 st-size1 st-color2">اطلاعات بیشتر و ثبت نام !</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <section class="st-section-top">
            <div class="container">
                <div class="row">
                    <a href="">
                        <div class="col-lg-4">
                            <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <div class="st-iconbox-icon">
                                    <img src="/Theme4/assets/img/novin/aloamblunce.jpg" alt="">
                                </div>
                                <h3 class="st-iconbox-title">الو آمبولانس</h3>
                                <div class="st-iconbox-text">
                                    سامانه جامع مدیریت خدمات حمل و نقل بیماران

                                </div>
                                <span></span>
                                <a href="">ورود به سامانه </a>
                            </div>
                        </div>
                    </a>
                    <a href="https://doctorkomak.ir/">
                        <div class="col-lg-4">
                            <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <div class="st-iconbox-icon">
                                    <img src="/Theme4/assets/img/novin/doctorkomak.jpg" alt="">
                                </div>
                                <h3 class="st-iconbox-title">دکتر کمک </h3>
                                <div class="st-iconbox-text">
                                    سامانه جامع خدمات پزشکان
                                </div>
                                <span></span>
                                <a href="">ورود به سامانه </a>
                            </div>
                        </div>
                    </a>
                    <a href="">
                        <div class="col-lg-4">
                            <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <div class="st-iconbox-icon">
                                    <img src="/Theme4/assets/img/novin/enoskhe.jpg" alt="">
                                </div>
                                <h3 class="st-iconbox-title"> ای نسخه </h3>
                                <div class="st-iconbox-text">
                                    دیتابیس جامع نسخ پزشکی
                                </div>
                                <span></span>
                                <a href="">ورود به سامانه </a>
                            </div>
                        </div>
                    </a>
                    <a href="https://hospitour.net/">
                        <div class="col-lg-4">
                            <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <div class="st-iconbox-icon">
                                    <img src="/Theme4/assets/img/novin/hospitour.jpg" alt="">
                                </div>
                                <h3 class="st-iconbox-title"> هاسپیتور</h3>
                                <div class="st-iconbox-text">
                                    سامانه جامع گردشگری سلامت
                                </div>
                                <span></span>
                                <a href="">ورود به سامانه </a>
                            </div>
                        </div>
                    </a>
                    <a href="">
                        <div class="col-lg-4">
                            <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <div class="st-iconbox-icon">
                                    <img src="/Theme4/assets/img/novin/medicheks.jpg" alt="">
                                </div>
                                <h3 class="st-iconbox-title"> مدی چک</h3>
                                <div class="st-iconbox-text">
                                    سامانه آزمایشگاه آنلاین
                                </div>
                                <span></span>
                                <a href="">ورود به سامانه </a>
                            </div>
                        </div>
                    </a>
                    <a href="https://novinnurse.com/Novin/">
                        <div class="col-lg-4">
                            <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <div class="st-iconbox-icon">
                                    <img src="/Theme4/assets/img/novin/novinnurse.png" alt="">
                                </div>
                                <h3 class="st-iconbox-title">مرکز پرستاری نوین</h3>
                                <div class="st-iconbox-text">
                                    ارائه دهنده خدمات نوین پرستاری در منزل
                                </div>
                                <span></span>
                                <a href="">ورود به سامانه </a>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </section>
        <section class="st-team-wrap st-section" id="team">
            <div class="container">
                <div class="st-section-heading st-style2 text-center">
                    <h2>همکاران ما</h2>
                    <div class="st-seperator">
                        <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                        </div>
                        <img src="/Theme4/assets/img/light-img/seperator-icon1.png" alt="demo"
                            class="st-seperator-icon">
                        <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                        </div>
                    </div>
                    <p>ارائه خدمات شایسته و با کیفیت اتفاقی نیست <br> ما افتخار داریم با مجموعه ای از متعهد ترین مراکز تخصصی
                        همکاری میکنیم.</p>
                </div>
            </div>
            <div class="st-owl-controler3-hover">
                <div class="container">
                    <div class="st-member-carousel owl-carousel st-style2 st-owl-controler3">
                        <div class="st-team-member text-center wow fadeInUp" data-wow-duration="0.8s"
                            data-wow-delay="0.2s">
                            <div class="st-member-img">
                                <img src="/Theme4/assets/img/novin/novinnurse.png" alt="demo">
                            </div>
                            <div class="st-member-info">
                                <h3 class="st-member-name">مرکز پرستاری نوین</h3>
                                <div class="st-member-designation">مرکز خدمات پرستاری در منزل</div>
                                <ul class="st-member-social-btn st-flex st-mp0">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
