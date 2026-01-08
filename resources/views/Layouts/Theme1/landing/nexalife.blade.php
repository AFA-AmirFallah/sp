@extends('Layouts.Theme1.MainLayout')
@section('MainContent')
    <style>
        <style>.bargprice {
            border: 1px solid #999;
            margin: 20px 0 20px 5px;
            font: 14px/32px iranyekan, arial;
            padding: 5px 30px;
            border-radius: 40px;
        }

        .text-decoration22 {

            font-size: 17px;
            line-height: 2;
            text-align: justify;

        }

        .ex-23 {

            border-radius: 5px;
            background: #fff;
            border: 2px solid #30bfb4;
            box-shadow: 0 0 20px 0 #a7bf2e00 !important;
            margin-bottom: 16px;
        }

        .card-box {
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
        }

        .course-info-inline {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }


        .banner-video .btn-play-video {
            position: absolute;
            top: 50%;
            right: 50%;
            transform: translate(50%, -50%);
            width: 6rem;
            height: 6rem;
            background-color: #fff;
            border-radius: 50%;
            z-index: 1000;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }

        .banner-video .btn-play-video:hover {
            background-color: #333;
        }

        .banner-video .btn-play-video:hover::before {
            color: #fff;
        }

        .banner-video .btn-play-video::before {
            content: "";
            position: absolute;
            margin-right: 0.2rem;
            font-family: "Font Awesome 5 Free";
            font-size: 2.8rem;
            font-weight: 600;
            color: #333;
            top: 50%;
            right: 50%;
            transform: translate(50%, -50%);
            transition: color 0.3s;
            z-index: 1;
        }

        .banner-video video {
            display: none;
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-video.playing .btn-play-video,
        .banner-video.paused .btn-play-video {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0.4s, opacity 0.4s;
        }

        .banner-video.playing:hover .btn-play-video,
        .banner-video.paused:hover .btn-play-video {
            visibility: visible;
            opacity: 1;
        }

        .banner-video.playing video,
        .banner-video.paused video {
            display: block;
        }

        .banner-video.playing .btn-play-video::before {
            content: "";
        }

        video {
            width: 100%;
            height: auto;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
    </style>
    <div class="  row">
        <div class="container">
            <div class=" row align-items-center mt-8">
                <div class="col-lg-7 col-md-6 col-12">
                    <div class="title-heading me-lg-4">
                        <div class="btn btn-primary btn-ellipse">
                            <span class="content"> آیا می‌دانستید شغل مدیر مجتمع و لابی من، وجود دارد؟</span>
                        </div>

                        <h2 class="heading mb-3 mt-1"> دوره مقدماتی تربیت مدیر مجتمع و لابی من </span></h2>

                    </div>
                </div>
                <!--end col-->

                <div class="col-lg-5 col-md-6 col-12 mt-4 pt-2 mt-sm-0 pt-sm-0">
                    <section class="introduce  pb-10 banner-videowordpress">
                        <div class="banner banner-video product-video br-xs">
                            <figure class="banner-media">
                                <a href="#">
                                    <img src="https://kookbaz.ir/storage/photos/----/nexa.life-20230125-0004.jpg"
                                        alt="banner" width="610" height="300" style="background-color: #bebebe;">
                                </a>
                                <a class="btn-play-video " onclick="Playvideo()"></a>
                            </figure>


                        </div>
                    </section>
                    <section class="introduce mt-10 pb-10 video nested">

                        <video id="autoplay" width="800" class="video nested" controls>
                            <source src="https://kookbaz.ir/storage/video/22nexalife.mp4" type="video/mp4">

                            Your browser does not support the video tag.
                        </video>



                    </section>



                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </div>
    <section class="customer-service mt-7 mb-7">
        <div class="card-box ex-23">
            <div class="row flexer flex-no-wrap flex-direction-row">
                <div class="col-md-6 col-sm-6">
                    <div class="course-info-inline">
                        <div class="inner">
                            <div class="title"> شرایط عمومی </div>
                            <div class="value">
                                • مدرک تحصیلی حداقل دیپلم

                            </div>
                            <div class="value">

                                • سن حداقل 25 سال
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-sm-6 ">
                    <div class="course-info-inline">
                        <div class="inner">
                            <div class="title"> مشخصات دوره </div>
                            <div class="value">
                                تاریخ برگزاری:
                                پنج شنبه 1401/12/11 و جمعه 1401/12/12


                            </div>
                            <div class="value"> ساعت برگزاری: 9 الی 16

                            </div>
                            <div class="value">
مدت زمان آموزش : 12 ساعت +میان وعده+ نهار
                            </div>
                            <div class="value">
                                • محل برگزاری: تهران سیدخندان - ضلع جنوب ‌غربی پل سیدخندان، کوچه مهاجر، پلاک 11، طبقه 6

                            </div>
                            <div class="value">
                                • مبلغ نقدی: 550.000 تومان

                            </div>
                            <div class="value">

                                • مبلغ اقساطی: 600.000 تومان (3 قسط)
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <div class=" bg-grey page-content become-a-vendor">

        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                <div class="card blog rounded border-0 shadow overflow-hidden">
                    <div class="position-relative">
                        <img src="https://kookbaz.ir/storage/photos/----/collage.jpg6_-scaled.jpg" class="card-img-top"
                            alt="...">

                    </div>

                </div>
                <!--end card / course-blog-->
            </div>
            <!--end col-->

            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                <div class="card blog rounded border-0 shadow overflow-hidden">


                    <div class="card-body content">

                        <h4 class="mt-10 " style="font-size: 20px"><a class="text-dark"> آدم‌هایی فرصت‌های شغلی مناسب را
                                پیدا می‌کنند که از قبل خود را آماده کرده باشند </a></ح>

                    </div>
                </div>
                <!--end card / course-blog-->
            </div>
            <!--end col-->

            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                <div class="card blog rounded border-0 shadow overflow-hidden">
                    <div class="position-relative">
                        <img src="https://kookbaz.ir/storage/photos/----/nexa.life-20230125-0003.jpg" class="card-img-top"
                            alt="...">

                    </div>

                </div>
                <!--end card / course-blog-->
            </div>
            <!--end col-->


        </div>
        <h4 class=" bg-grey title  title-center mt-10 mb-10 text-primary"> توانمندسازی و ایجاد مهارت برای یافتن شغل و درآمد
            مأموریت ما است.
        </h4>
        <div class=" bg-grey container create-store pb-1 pb-lg-10  mt-10">
            <div class="row align-items-center">

                <div class="col-md-6 mb-4 mb-md-0">
                    <figure class="br-sm">
                        <img src="https://kookbaz.ir/storage/photos/nexa1.jpg" alt="Banner" width="610" height="435"
                            style="background-color: #D9D8DD;" />
                    </figure>
                </div>
                <div class="col-md-6 order-md-first">
                    <h2 class="mb-0 font-weight-bold"> آشنایی با نوآوری در حوزه مدیریت ساختمان
                        <p>
                        </p>

                        <p>
                            در سال های اخیر، احداث و بهره برداری از برج های مسکونی، تجاری و اداری نوین و مجتمع های فاخر در
                            تهران گسترش یافته است،
                            ساکنان و بهره برداران این برج ها ضمن تقاضای مراقبت های تخصصی از زیر ساخت ها و امکانات ویژه آن به
                            عنوان سرمایه خود،
                            خواستار محیطی آرام و امن، با برخورداری حـداکثـری و با کـیفیت از امکانات رفاهی می باشند.
                        </p>
                        <p>
                            بر این اساس پذیرش مسئولـیت ارائه خـدمات نـگهداری، راهـبری و مـدیریت حرفه ای این مجموعه ها
                            نیازمند شایستگی های حرفه ای است.
                            نکسالایف مجموعه ای متشکل از مدیران و کارشناسان مجرب هتلداری است که تجارب این صنعت پیشرو و بین
                            المللی را برای ارائه خدمات به ساکنان رزیدنس های لوکس،
                            مناسب سازی نموده و خدمات حرفه ای پنج ستاره را در راهبری مجتمع های مسکونی، تجاری و اداری ارائه می
                            نماید.
                        </p>

                </div>
            </div>
            <!-- End of Row -->
        </div>
        <!-- End of Create Store -->
        <div class="bg-grey how-trade ">
            <div class="container  mb-0 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <figure class="br-sm">
                            <img src="https://kookbaz.ir/storage/photos/----/nexa.life-20230125-0001.jpg" alt="Banner"
                                width="610" height="520" style="background-color: #C9C8CD;" />
                        </figure>
                    </div>
                    <div class="col-lg-6 pl-lg-8">

                        <p class="mb-0 font-weight-bold text-left"
                            style="
                        font-size: 26px;
                        color:black;
                    ">
                            مشاغلی چون مدیریت یک مجتمع مسکونی، اداری و تجاری از شغل‌های مهم و حساس بوده و متقاضیان آن علاوه
                            بر داشتن صلاحیت‌های عمومی باید آموزش‌های مناسبی را طی کرده باشند.
                        </p>

                    </div>
                </div>
                <!-- End of Row -->
            </div>
            <!-- End of Container -->
        </div>
        <div class="bg-grey how-trade ">
            <div class="container mt-2 mt-lg-10 mb-0 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-6 pl-lg-8">
                        <h2 class="title text-left">خدمات</h2>
                        <p class="mb-6">هم اکنون در بیش از 30 مجتمع در تهران
                            خدمات و سرویس‌هایی مبتنی بر استانداردهای حرفه ای و دانش هتلداری توسط این شرکت در حال اجراست.</p>
                        <div class="row cols-sm-2 mb-1">
                            <div class="stage-item mb-6 stage-register d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                </svg>
                                <p class="mb-0 font-weight-bold">راهبری و مدیریت بهره‌برداری </p>
                            </div>
                            <div class="stage-item mb-6 stage-selling d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                </svg>
                                <p class="mb-0 font-weight-bold">هتلینگ اختصاصی </p>
                            </div>
                            <div class="stage-item mb-5 stage-deliver d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                </svg>
                                <p class="mb-0 font-weight-bold">مشاوره و آموزش</p>
                            </div>
                            <div class="stage-item mb-5 stage-get d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                </svg>
                                <p class="mb-0 font-weight-bold">مدیریت واگذاری واحدها</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <figure class="br-sm">
                            <img src="https://kookbaz.ir/assets/images/nexa2.png" alt="Banner" width="610"
                                height="520" style="background-color: #C9C8CD;" />
                        </figure>
                    </div>

                </div>
                <!-- End of Row -->
            </div>
            <!-- End of Container -->
        </div>
        <!-- End of How Trade -->
        <div class="bg-grey how-trade ">
            <div class="container mb-0 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <figure class="br-sm">
                            <img src="https://kookbaz.ir/storage/photos/----/nexa.life-20230125-0002.jpg" alt="Banner"
                                width="610" height="520" style="background-color: #C9C8CD;" />
                        </figure>
                    </div>
                    <div class="col-lg-6 pl-lg-8">

                        <p class=" text-left font-weight-bold"
                            style="
                        font-size: 26px;
                        color:black;
                    ">
                            لابی من، وظیفه ارائه تشریفات، پذیرش و نظارت بر کارکنان لابی مجتمع را داشته و باید بسیار حرفه‌ای،
                            با توجه به آموزش‌هایی که گذرانده است، نقش‌آفرینی کند.
                        </p>

                    </div>
                </div>
                <!-- End of Row -->
            </div>
            <!-- End of Container -->
        </div>
        <div class="bg-grey how-trade ">
            <div class="container mt-2 mt-lg-10 mb-0 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-6 pl-lg-8">
                        <h2 class="title text-left">دعوت به همکاری</h2>
                        <p class="mb-6">کوکباز با همکاری گروه نکسالایف در راستای ایجاد بازار گسترده‌ی اشتغال برای خانواده
                            محترم بازنشستگان ، از علاقمندان به فعالیت در این حوزه دعوت به عمل می‌آورد. </p>
                        <div class="row cols-sm-1 mb-1">
                            <div class="stage-item mb-6 stage-register d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                </svg>
                                <p class="mb-0 font-weight-bold">آموزش مهارتی و جذب مدیران ساختمان </p>
                            </div>
                            <div class="stage-item mb-6 stage-selling d-flex align-items-center">

                            </div>
                            <div class="stage-item mb-5 stage-deliver d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                </svg>
                                <p class="mb-0 font-weight-bold">آموزش مهارتی و جذب میهمانداران و راهنمایان</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <figure class="br-sm">
                            <img src="https://kookbaz.ir/assets/images/nexa3.png" alt="Banner" width="610"
                                height="520" style="background-color: #C9C8CD;" />
                        </figure>
                    </div>

                </div>
                <!-- End of Row -->
            </div>
            <!-- End of Container -->
        </div>




        @if (!Auth::check())
            <div class="banner parallax" data-parallax-options="{'speed': 10, 'parallaxHeight': '200%', 'offset': -99}"
                data-image-src="assets/images/pages/become/3.jpg" style="background-color: #929294;">
                <div class="container">
                    <div class="banner-content text-center">
                        <h2 class="title title-center text-white font-weight-bold">همین الان ثبت‌ نام کنید</h2>
                        <a href="{{ route('login') }}" class="btn btn-white btn-outline btn-rounded ls-25">کلیک کنید
                        </a>
                    </div>
                </div>
            @else
                <form method="POST">
                    @csrf
                    <div style="background-color: #fafafa;">
                        <h4 class="title title-link ">ثبت درخواست</h4>
                        <div class="card-body">
                            <div>
                                <label>نام و نام خانوادگی:</label>
                                <span  style="color: red">*</span>
                                <input type="text" class="form-control form-control-md" name="Name"
                                    placeholder="نام و نام خانوادگی خود را به فارسی وارد نمائید" required>


                            </div>

                            <div>
                                <label>کدملی: </label>
                                <span  style="color: red">*</span>
                                <input type="number" class="form-control form-control-md" name="MelliID"
                                    placeholder="کدملی خود را وارد نمائید" required>


                            </div>

                            <div>
                                <label>سن: </label>
                                <span  style="color: red">*</span>
                                <input type="number" class="form-control form-control-md" name="ُage"
                                    placeholder="سن خودرا به عدد وارد نمائید" required>


                            </div>

                            <div>
                                <label>آخرین مدرک تحصیلی: </label>
                                <span  style="color: red">*</span>
                                <input type="text" class="form-control form-control-md" name="ُMadrak"
                                    placeholder="آخرین مدرک تحصیلی و سال اخذ مدرک را وارد نمائید" required>


                            </div>

                            <div>
                                <label>شماره موبایل: </label>
                                <span  style="color: red">*</span>
                                <input type="number" class="form-control form-control-md" name="ُMobileno"
                                    placeholder="" required>


                            </div>
                            <div>
                                <label>آدرس: </label>
                                <span  style="color: red">*</span>
                                <input type="text" class="form-control form-control-md" name="ُAddress"
                                    placeholder="آدرس محل سکونت خود را دقیق و کامل وارد نمائید" required>


                            </div>

                            <div class="mt-1">

                                <div class="custom-radio">
                                    <input type="checkbox" id="free-shipping" class="custom-control-input"
                                        name="healt">
                                    <label for="free-shipping" class="custom-control-label color-dark"> اینجانب دارای
                                        سلامت کامل روحی و جسمی (شنوایی،بینایی و حرکتی) هستم.</label>
                                        <span  style="color: red">*</span>

                                </div>
                                <textarea  type="text" class="form-control form-control-md" name="note" > در صورت وجود هرگونه عارضه یا معلولیت لطفا در این قسمت شرح دهید"</textarea>

                            </div>

                            <div>
                                <button style="float: left" type="submit" name="submit" value="save"
                                    class="btn btn-dark btn-rounded btn-sm mb-4">
                                    ثبت درخواست
                                </button>
                            </div>
                        </div>
                </form>
        @endif
        <div class="form-group mb-10">

        </div>
    </div>
    <!-- End of Page Content -->
@endsection
@section('page-js')
    <script>
        window.Province = 0;

        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    $("#Shahrestan").append(data);
                });
        }
    </script>
    <script>
        function Playvideo() {

            $(".banner-videowordpress").addClass("nested");
            $(".video").removeClass("nested");
            document.getElementById('autoplay').play();
        }
    </script>
@endsection
