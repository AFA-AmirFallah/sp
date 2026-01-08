@extends('Layouts.Theme4.Layout.mian_layout_shafatel')
@section('Content')
    <style>
        .active-box {
            border-style: solid;
            border-color: blue;
            background-color: #bfefb947;
        }
    </style>
    <div class="st-hero-slide st-style2 st-flex" id="home">
        <div class="container">
            <div class="st-hero-text st-style1 st-color1">
                <h1 class="st-hero-title"> زنجیره تامین سلامت شفاتل<br> </h1>
                <div class="st-hero-subtitle"> شفاتل در مسیر دستیابی به سلامت همراه شما است<br> پلتفرم ارائه خدمات درمانی و
                    مراقبتی در منزل </div>
                <div class="st-btn-group st-style1"> <a href="https://panel.shafatel.com/login"
                        style="background-color: greenyellow;" class="st-btn st-style1 st-color1"> پنل بیماران</a>
                    <a style="background-color: goldenrod;" href="https://panel.shafatel.com/login"
                        class="st-btn st-style1 st-color1">پنل همکاران</a>
                </div>
            </div>
        </div>
        <div class="st-hero-img"><img src="https://panel.shafatel.com/storage/photos/banners/hero-img.png" alt="main_pic">
        </div>
        <div class="st-circla-animation">
            <div class="st-circle st-circle-first"></div>
            <div class="st-circle st-circle-second"></div>
        </div>
        <div class="st-wave-wrap">
            <div class="st-wave st-wave-first">
                <div class="st-wave-in"
                    style="background-image: url(https://panel.shafatel.com/Theme4/assets/img/light-img/shape1.png);">
                </div>
            </div>
            <div class="st-wave st-wave-second">
                <div class="st-wave-in"
                    style="background-image: url(https://panel.shafatel.com/Theme4/assets/img/light-img/shape1.png);">
                </div>
            </div>
        </div>
    </div>

    <section class="st-section-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4  ">
                    <div class="st-iconbox st-style1 text-center wow fadeInUp active-box" data-wow-duration="0.8s"
                        data-wow-delay="0.2s">
                        <div class="st-iconbox-icon">
                            <img src="https://panel.shafatel.com/storage/photos/banners/healthcare.png" alt="healthcare">

                        </div>
                        <h3 class="st-iconbox-title">خدمات درمانی مراقبتی در منزل</h3>
                        <div class="st-iconbox-text">
                            ارجاع درخواست خدمات به مراکز هوم کر با مجوز رسمی از وزارت بهداشت
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                        data-wow-delay="0.3s">
                        <div class="st-iconbox-icon">
                            <img src="https://panel.shafatel.com/storage/photos/banners/rent.png" alt="rent">
                        </div>
                        <h3 class="st-iconbox-title">اجاره تجهیزات پزشکی</h3>
                        <div class="st-iconbox-text">
                            ارجاع درخواست به مراکز اجاره دهنده تجیهزات پزشکی
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                        data-wow-delay="0.4s">
                        <div class="st-iconbox-icon">
                            <img src="https://panel.shafatel.com/storage/photos/banners/shop.jpeg" alt="shop">
                        </div>
                        <h3 class="st-iconbox-title">فروش کالای سلامت</h3>
                        <div class="st-iconbox-text">
                            مارکت پلیس تجهیزات پزشکی و کالای سلامت توسط بهترین تامین کنندگان </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                        data-wow-delay="0.4s">
                        <div class="st-iconbox-icon">
                            <img src="https://panel.shafatel.com/storage/photos/banners/helthcheck.png" alt="health_check">
                        </div>
                        <h3 class="st-iconbox-title">سلامت بان</h3>
                        <div class="st-iconbox-text">
                           خدمات و محصولات پیشگیرانه سلامت محور</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="st-section-top">
        <div style="margin-top: 20px" class="container">
            <div class="st-section-heading st-style2 text-center">
                <h2>خدمات مراکز خدمات پزشکی و پرستاری در منزل</h2>
                <div class="st-seperator">
                    <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    </div>
                    <img src="/Theme4/assets/img/light-img/seperator-icon1.png" alt="demo" class="st-seperator-icon">
                    <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                    </div>
                </div>
                <p>جهت نیل به هدفت ارائه خدمات شایسته و با کیفیت <br> ما افتخار داریم پل ارتباطی بین بیماران و مراکز
                    ارائه دهنده خدمات درمانی در منزل باشیم.</p>
            </div>
        </div>
        <div class="container">
            <div class="st-blog-wrap st-section" id="blog">
                <div class="container">
                    <div class="row">
                        @include('Order.order_object')
                    </div>
                </div>
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
                                <img src="https://panel.shafatel.com/storage/photos/banners/about-img1.png" alt="demo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="st-section-heading st-style1">
                        <h3>درباره ما</h3>
                        <h2 style="text-align: justify;color: cornflowerblue;font-size:30px;">ما یک تیم فناوری اطلاعات
                            برای همراهی شما جهت دریافت خدمات درمانی و مراقبتی شایسته هستیم.</h2>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
