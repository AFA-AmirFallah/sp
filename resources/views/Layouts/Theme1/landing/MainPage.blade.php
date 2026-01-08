@extends('Layouts.Theme1.MainLayout')
@section('MainContent')
    <style>
        .btn-blue {
            background-color: #2862A7 !important;
            border-color: #2862A7 !important;
            color: #FFFFFF !important;
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

        .text-decoration22 {

            font-size: 17px;
            line-height: 70.45px;
            text-align: justify;

        }


        td,
        th {
            border: 2px solid #000000;
            text-align: left;
            font-size: 20px;
            font-weight: 900

        }

        table {
            border-collapse: separate;
            border-spacing: 0 10px;
            width: 100%;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-radius: 20px
        }
        tr{
            border-spacing: 0 10px;


        }



        th {
            background-color: #dee2e6 !important;

            color: black;
        }
    </style>


    <div class="page-content become-a-vendor">

        <div class="page-content">
            <div class="container">
                <section class="introduce pb-10">

                    <figure class="br-lg">
                        <img src="https://kookbaz.ir/storage/photos/----/خدمات/Frame 17.png" alt="Banner" width="1240"
                            height="540" style="background-color: #D0C1AE;" />
                    </figure>
                </section>


            </div>
        </div>

    </div>
    <div class="container ">

        <div class="row">
            <div class="col-sm-4 d-flex">
                <div class="counter text-center">
                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/promotion 1.svg" alt="Banner" width="100" />

                </div>
                <div class="mt-5 ml-3 bg-dark text-white br-lg pt-1 pl-3">
                    <p class="mt-1"> بازپرداخت به صورت نقد، اقساطـی و حتـی رایـگــان</p>

                </div>
            </div>

            <div class="col-sm-4 d-flex ">
                <div class="counter text-center">
                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/success copy 2.png" alt="Banner"
                        width="100" />


                </div>
                <div class="mt-5 ml-3 bg-dark text-white br-lg pt-1 pl-3">
                    <p> برگزاری دوره‌های آموزشـی با هدف اشتغال و درامدزایی</p>

                </div>

            </div>
            <div class="col-sm-4 d-flex">
                <div class="counter text-center">
                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/development copy 1.svg" alt="Banner"
                        width="100" />

                </div>
                <div class="mt-5 ml-3 bg-dark text-white br-lg pt-1
             pl-3 ">
                    <p> خدمات متنوع با هدف ارتقاء سطح زندگـی و کسب‌و‌کار </p>

                </div>

            </div>
        </div>

    </div>
    <div class="container mt-2 mt-lg-10 mb-0 mb-lg-10">
        <div class="row align-items-center">
            <div class="col-lg-6 pl-lg-8">
                <h2 class="title text-left"> آموزش منجر به اشتغال</h2>

                <div class="row cols-sm-1 mb-1">
                    <p class="text-decoration22 ">
                        آموزش منجر به اشتغال در این بخش شما مـی‌توانید با شرکت در دوره‌های آموزشـی کاربردی(بوت‌کمپ و
                        کارگاهـی) و افزایش قابلیت‌های تخصصـی خود در آن حوزه از طریق پلتفرم کوکباز به مجموعه‌هایـی که متقاضـی
                        جذب نیروی انسانـی در آن حوزه هستند، معرفـی گردید.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 mb-4 mb-lg-0">
                <figure class="br-sm">
                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/city-committed-education-collage-concept copy 1.png"
                        alt="Banner" width="610" height="520" style="background-color: #C9C8CD;">
                </figure>
            </div>

        </div>
        <!-- End of Row -->
    </div>
    <div class=" how-trade  ">
        <div class="container mt-2 mt-lg-10 mb-0 mb-lg-10">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">

                    <section class="introduce  pb-10 banner-videowordpress">
                        <div class=" banner-video product-video br-xs">
                            <figure>
                                <a href="#">
                                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/close-up-man-s-hand-using-his-mobile-phone 1.png"
                                        alt="Banner">
                                </a>

                            </figure>


                        </div>
                    </section>


                </div>
                <div class="col-lg-6 ">
                    <h2 class="title text-left"> خدمات متنوع</h2>

                    <div class="row cols-sm-1 mb-1">
                        <p class="text-decoration22 ">
                            در این بخش در حوزه‌های مختلفـی شامل؛ سلامت، خدمات تعمیرات، خدمات بیمه و معرفـی
                            به اماکن ورزشـی خدمات متنوع ارائه مـی‌گردد. از طرفـی شما مـی‌توانید خدمات خود را برای ارائه
                            به کاربران ما در این بخش معرفـی نمائید.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Row -->
    </div>
    <section class="mb-10">
        <div class="owl-carousel owl-shadow-carousel owl-theme owl-loaded owl-drag"
            data-owl-options="{
            'items': 3,
            'nav': false,
            'dots': true,
            'loop': false,
            'margin': 20,
            'responsive': {
                '0': {
                    'items': 1
                },
                '576': {
                    'items': 2
                },
                '992': {
                    'items': 3,
                    'dots': false
                }
            }
        }">



            <div class="owl-stage-outer">
                <div class="owl-stage"
                    style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1260px;">
                    <div class="owl-item active" style="width: 400px; margin-right: 20px;">
                        <div class="testimonial-wrap">
                            <div class="testimonial testimonial-centered testimonial-shadow">
                                <div class="testimonial-info">
                                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/تعمیر2 1.png" alt="Testimonial"
                                        width="500" height="500">

                                </div>
                                <h4 class="member-name mt-3"> تعمیرگاه ویژه خودروهای چینـی </h4>



                            </div>
                        </div>
                    </div>
                    <div class="owl-item active" style="width: 400px; margin-right: 20px;">
                        <div class="testimonial-wrap">
                            <div class="testimonial testimonial-centered testimonial-shadow">
                                <div class="testimonial-info">
                                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/نکسا-1 1.png" alt="Testimonial"
                                        width="500" height="500">

                                </div>
                                <h4 class="member-name mt-3"> دوره آموزشـی مدیریت مجتمع تجاری و اداری </h4>



                            </div>
                        </div>
                    </div>
                    <div class="owl-item active" style="width: 400px; margin-right: 20px;">
                        <div class="testimonial-wrap">
                            <div class="testimonial testimonial-centered testimonial-shadow">
                                <div class=" testimonial-info">
                                    <img src="https://kookbaz.ir/storage/photos/----/خدمات/بومگردی 1.png" alt="Testimonial"
                                        width="500" height="500">
                                    <div class="ratings-container">

                                    </div>
                                </div>
                                <h4 class="member-name mt-3"> اقامتگاه بومگردی تجهیز شده منتخب کاشان </h4>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><i
                        class="w-icon-angle-left"></i></button><button type="button" role="presentation"
                    class="owl-next"><i class="w-icon-angle-right"></i></button></div>
            <div class="owl-dots disabled"></div>
        </div>
    </section>
    <!-- End of Container -->
    <div
        style="background-image:url(' https://kookbaz.ir/storage/photos/----/خدمات/illustration-home-cleaning-service-laptop copy 1.png') ; ">

        <table class="table-primary text-decoration22">
            <tbody>
                <tr>
                    <th colspan="2"> طرح های فعال در بازار اجتماعی کسب و کار بازنشستگان </th>

                </tr>
                <tr>
                    <td><a href="https://kookbaz.ir/RegisterForm/15">
                        بوم‌گردی
                    </a></td>
                </tr>
                <tr>
                    <td><a href="https://kookbaz.ir/RegisterForm/16">
                        خدمات بیمه
                    </a></td>
                </tr>
                <tr>
                    <td> <a href="https://kookbaz.ir/Consulting">مشاوره کسب و کار

                    </a>
                </td>
                </tr>
                <tr>
                    <td><a href="https://kookbaz.ir/RegisterForm/20">آموزش فروش تلفنی</a>
                        </td>
                </tr>
                <tr>
                    <td><a href="https://kookbaz.ir/RegisterForm/22" target="_blank">تعمیرات خودرو چینی</a> </td>
                </tr>
                <tr>
                    <td> <a href="https://kookbaz.ir/RegisterForm/14">
                   آموزش مدیریت مجتمع تجاری و مسکونی (نکسالایف)
                    </a>
                </td>
                </tr>

            </tbody>
        </table>

    </div>

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
