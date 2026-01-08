@extends('Layouts.Theme7.layout.main_layout')
@section('content')
    <style>
        .directionbix {
            padding: 30px 30px 5px 30px;
            background-color: rgb(255 255 255 / 31%);
            border-radius: 4px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2);
        }

        .directio_item {
            text-align: center;
            background-color: #3498db;
            width: 100% !important;
            color: #fff !important;
            font-size: 16px;
            font-weight: 600;
            height: 50px;
            padding-top: 13px;

        }

        .directio_item_div {
            display: flex !important;
            margin-bottom: 25px;
        }
    </style>
    <div class="dez-bnr-inr dez-bnr-inr-md"
        style="background-image:url(/storage/photos/%d9%be%d8%b1%d8%b3%d8%aa%d8%a7%d8%b1%d8%a8%d8%a7%d9%86%da%a9/A-Guided-Meditation-for-Nurses-Honoring-Your-Hands.jpeg);">
        <div class="container">
            <div class="dez-bnr-inr-entry align-m">
                <div class="find-job-bx">
                    <h1 class="site-button button-sm">پرستاربانک مرجع سوابق درمانگران و پرستاران خدمات دهنده در
                        منزل</h1>
                    <h2 class="text-white">آرامش خاطر خود را با بررسی سابقه پرستار،در <br> <span style="color: #ff6000">پرستار بانک </span>  تضمین کنید .</h2>
                    <div class="row directionbix">
                        <div class="col-lg-4 col-md-6 directio_item_div">
                            <a class="directio_item" href="{{ route('add_experience') }}"> ثبت نظرات کاربران </a>
                        </div>
                        <div class="col-lg-4 col-md-6 directio_item_div">
                            <a class="directio_item" href="{{ route('search_staff') }}"> استعلام پرستار/درمانگر </a>
                        </div>
                        <div class="col-lg-4 col-md-6 directio_item_div">
                            <a class="directio_item" href="{{ route('pb_register') }}">ثبت‌نام درمانگر-پرستار </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!Auth::check())
        <div style="background-color: #3396d1"
            class="section-full content-inner-2 call-to-action  text-white text-center bg-img-fix">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="m-b10">ثبت نام پرستار / درمانگر</h2>
                        <h3 style="direction: rtl">با ایجاد پروفایل شخصی در پرستاربانک می توانید تجربه های کاری و سوابق خود
                            را جهت استعلام و استخدام در اختیار دیگران قرار دهید.</h3>
                        <a href="pb_register" class="site-button m-t20 outline outline-2 radius-xl">ایجاد حساب
                            کاربری</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Section Banner END -->
    <!-- About Us -->

    <div class="section-full job-categories content-inner-2">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="m-b30 blog-grid main-grid-blog">
                    <div class="dez-post-media dez-img-effect "> <a><img src="/Theme7/images/expriance_report.png"
                                alt="ثبت تجربیات"></a> </div>
                    <div class="dez-info p-a20 border-1">
                        <div class="dez-post-title ">
                            <h5 class="post-title"><a> ثبت نظرات کاربران</a></h5>
                        </div>
                        <div class="dez-post-meta ">

                        </div>
                        <div class="dez-post-text">
                            <p>شما می‌توانید با ثبت تجربیات و نظرات خود، به دیگران هم در انتخاب خدمات دهنده مناسب کمک کنید.
                                (رایگان)</p>
                        </div>
                        <div style="text-align: center">
                            <a href="{{ route('add_experience') }}" class="site-button radius-xl"><span class="p-lr30">شروع
                                    کن</span></a>
                        </div>



                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="m-b30 blog-grid main-grid-blog">
                    <div class="dez-post-media dez-img-effect "> <a href="{{ route('search_staff') }}"><img
                                src="/Theme7/images/hireing.webp" alt="استعلام"></a> </div>
                    <div class="dez-info p-a20 border-1">
                        <div class="dez-post-title ">
                            <h5 class="post-title"><a href="{{ route('search_staff') }}">استعلام پرستار/درمانگر</a></h5>
                        </div>
                        <div class="dez-post-meta ">

                        </div>
                        <div class="dez-post-text">
                            <p>شما می‌توانید قبل از آغاز به کار پرستار مورد نظرتان، گزارشات و تجربیات دیگران را در این بخش
                                مطالعه کنید.</p>
                        </div>
                        <div style="text-align: center">
                            <a href="{{ route('search_staff') }}" class="site-button radius-xl"><span class="p-lr30">شروع
                                    کن</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="m-b30 blog-grid main-grid-blog">
                    <div class="dez-post-media dez-img-effect "> <a href="#"><img
                                src="https://parastarbank.com/storage/photos/پرستاربانک/service-desk-agents-1024x5122222.jpg"
                                alt="درخواست خدمات"></a> </div>
                    <div class="dez-info p-a20 border-1">
                        <div class="dez-post-title ">
                            <h5 class="post-title"><a href="#">ثبت درخواست پرستار</a></h5>
                        </div>
                        <div class="dez-post-meta ">

                        </div>
                        <div class="dez-post-text">
                            <p>شما می‌توانید در صورت نیاز به پرستار، درخواست خود را در این بخش وارد نمايید. (به زودی)</p>
                        </div>
                        <div style="text-align: center">
                            <a href="#" class="site-button radius-xl"><span class="p-lr30">شروع
                                    کن</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="m-b30 blog-grid main-grid-blog">
                    <div class="dez-post-media dez-img-effect "> <a href="#"><img
                                src="https://parastarbank.com/storage/photos/%d9%be%d8%b1%d8%b3%d8%aa%d8%a7%d8%b1%d8%a8%d8%a7%d9%86%da%a9/hiring-agency-candidates-job-interview_1262-18940.jpg"
                                alt="مراکز درمانی"></a> </div>
                    <div class="dez-info p-a20 border-1">
                        <div class="dez-post-title ">
                            <h5 class="post-title"><a href="#">استعلام مراکز درمانی</a></h5>
                        </div>
                        <div class="dez-post-meta">

                        </div>
                        <div class="dez-post-text">
                            <p>تمامی مراکز درمانی می توانند سوابق نیروی مد نظر خود را قبل از استخدام، از پرستاربانک استعلام
                                بگیرند.</p>
                        </div>
                        <div style="text-align: center">
                            <a href="#" class="site-button radius-xl"><span class="p-lr30">شروع
                                    کن</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Our Latest Blog -->

@endsection
