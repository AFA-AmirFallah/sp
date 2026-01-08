@extends('Layouts.Theme4.Layout.mian_layout_shafatel')
@section('content')
    <style>
        .active-box {
            border-style: solid;
            border-color: blue;
            background-color: #bfefb947;
        }
    </style>
    <section class="st-section-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="st-iconbox st-style1 text-center wow fadeInUp active-box">
                        <div class="st-iconbox-icon">
                            <i class="flaticon-portfolio"></i>
                        </div>
                        <h3 class="st-iconbox-title">انتخاب خدمت</h3>
                        <div class="st-iconbox-text">
                            انتخاب خدمت مورد نظر
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                        data-wow-delay="0.3s">
                        <div class="st-iconbox-icon">
                            <i class="flaticon-doctor"></i>
                        </div>
                        <h3 class="st-iconbox-title">انتخاب مرکز </h3>
                        <div class="st-iconbox-text">
                            انتخاب مرکز ارائه دهنده خدمت بر اساس معیارهای مد نظر شما یا درخواست خدمت از کلیه مراکز بر اساس
                            موقعیت خدمت
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="st-iconbox st-style1 text-center wow fadeInUp" data-wow-duration="0.8s"
                        data-wow-delay="0.4s">
                        <div class="st-iconbox-icon">
                            <i class="flaticon-career-1"></i>
                        </div>
                        <h3 class="st-iconbox-title">ثبت درخواست</h3>
                        <div class="st-iconbox-text">
                            ثبت درخواست به همراه جزئیاتی که مرکز ارائه دهنده خدمت را در اجرای دقیق تر خدمت یاری خواهد داد.
                        </div>
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




    <!---start GOFTINO code--->
@endsection
