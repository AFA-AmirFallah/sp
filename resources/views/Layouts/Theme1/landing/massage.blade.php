@extends('Layouts.Theme1.MainLayout')
@section('MainContent')
    <style>
        .title {
            line-height: 2.75;
        }

        .bg-100 {
            border-top-right-radius: 100px !important;
            border-bottom-right-radius: 100px !important;

        }

        .text-decoration22 {
            font-weight: 400;
            font-size: 20px;
            line-height: 50px;
            text-align: justify;

        }

        .bg-blue {
            background-color: #E1F6FF !important;
        }

        .btn-blue {
            background-color: #E1F6FF !important;
            border-color: #E1F6FF !important;

            color: black;
        }

        table,
        td,
        th {
            border: 2px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
        }

        tr {
            background-color: #5FB6CE;
            color: #FFFFFF !important;
        }



        th {
            background-color: #355B60;
            color: #FFFFFF !important;




        }
    </style>
    <div class="row align-items-center mt-5 ">
        <div class="col-lg-8 mb-lg-0">
            <figure class="br-sm">
                <img src="https://kookbaz.ir/storage/photos/----/massage/بنر 11.png" alt="Banner">
            </figure>
        </div>
        <div class="col-lg-4 pl-lg-8">
            <h1 class="heading mb-3 title-center text-center"> دوره آموزشی ماساژ </h1>
            <h3 class="heading mb-3 text-center"> مهارتـی کاربردی برای زندگـی و اشتغال </h3>
            <h5 class="heading mb-3 title-center text-center"> زیر نظر اساتید مجرب </h5>
            <div class="icon-box-side">
                <a href="#formlanding" class="btn btn-blue  btn-ellipse"> ثبت نام</a>
            </div>

        </div>
    </div>

    <div class=" mt-3 br-xs  ">
        <div class="container mt-0 mt-lg-10 mb-2 mb-lg-9 bg-blue ">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0 icon-box-side ">
                    <img src="https://kookbaz.ir/storage/photos/----/123/Untitled-1 (1).svg" alt="">
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0 mt-5 lh-3 text-center">
                    <h2 class="title   text-center ls-25">ارائه مدرک بین المللـی معتبر</h2>
                    <h2 class="title  text-center ls-25">تکنیک‌های عملـی و مطالب تئوری </h2>
                    <h2 class="title text-center ls-25"> تضمین اشتغال برای برترین‌های دوره </h2>


                </div>
                <div class="col-lg-4 mb-4 mb-lg-0 mt-5 ">

                    <p class="text-center">
                        این دوره زیر نظر اساتید شناخته شده برگزار و در پایان دوره مدرک معتبر بین‌المللـی اعطا مـی‌گردد.
                    </p>
                    <p class="text-center">
                        دوره مقدماتـی ماساژ شامل آموزش تکنیک‌های عملـی و مطالب تئوری مورد نیاز برای شروع فعالیت اولیه در شغل
                        ماساژ مـی‌باشد. </p>
                    <p class="text-center">
                        برترین‌های هر دوره به مجموعه‌های مختلف خدمات ماساژ جهت استخدام یا معرفـی متقاضیان خدمات معرفـی
                        خواهند گردید. </p>

                </div>
            </div>
        </div>
        <!-- End of Container -->
    </div>
    <div class="container  pb-lg-10 mb-10">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <figure class="br-sm">
                    <img src="https://kookbaz.ir/storage/photos/----/massage/aks 11.jpg" alt="Banner" width="610"
                        height="435" style="background-color: #D9D8DD;">
                </figure>
            </div>
            <div class="col-md-6 order-md-first">

                <p class="text-decoration22">
                    استاد پارسا محمدزاده با سابقه ۱۲ ساله در حیطه ماساژ و دارا بودن عناوینـی چون ماسور اعضای تیم ملـی فوتبال
                    ، بسکتبال و ... در این دوره ها بر پایه منابع علمـی و تجربه چندین ساله در این حیطه ، پایه گذار آموزش
                    ماساژ به سبک نوینـی مـی‌باشند که اثر بخشـی و کاربرد بسیار بالایـی در بازار دارد. بعد از برگزاری دوره
                    عمومـی از کسانـی که مهارت و یادگیری لازم را دارا باشند در مجموعه‌های ماساژ تحت تعامل با مجموعه اسپادنا
                    استفاده خواهد گردید.
                </p>
            </div>
        </div>
        <!-- End of Row -->
    </div>
    <section class="introduce mb-10 pb-10 mt-2">

        <figure class="br-lg ">
            <img src="https://kookbaz.ir/storage/photos/----/massage/بنر 2.png" alt="Banner" width="1240" height="540"
                style="background-color: #D0C1AE;">
        </figure>
    </section>

    <table class="table-primary">
        <tbody>
            <tr>
                <th colspan="2">مشخصات و شرایط عمومی دوره</th>

            </tr>
            <tr>
                <td>سن</td>
                <td>بالای 18 سال</td>
            </tr>
            <tr>
                <td>جنسیت</td>
                <td>مرد</td>
            </tr>
            <tr>
                <td>توان جسمی</td>
                <td>معمولی</td>
            </tr>
            <tr>
                <td>تاریخ دوره</td>
                <td> 28 و 29 و 30 اردیبهشت ماه</td>
            </tr>
            <tr>
                <td>ساعت برگزاری</td>
                <td> ۸ تا ۱۱</td>
            </tr>
            <tr>
                <td>مدت زمان آموزش</td>
                <td>۱۰ ساعت</td>
            </tr>
            <tr>
                <td>نوع مدرک</td>
                <td>مدرک بین المللـی معتبر</td>
            </tr>
            <tr>
                <td>شهریه</td>
                <td>3 میلیون تومان</td>
            </tr>
            <tr>
                <td>اقساطی</td>
                <td>امکان پرداخت در 3 قسط </td>
            </tr>
        </tbody>
    </table>







    @if (!Auth::check())
        <div id="formlanding" class="banner parallax mt-5"
            data-parallax-options="{'speed': 10, 'parallaxHeight': '200%', 'offset': -99}"
            data-image-src="assets/images/pages/become/3.jpg" style="background-color: #929294;">
            <div class="container">
                <div class="banner-content text-center">
                    <h2 class="title title-center text-white font-weight-bold mt-10">همین الان ثبت‌ نام کنید</h2>
                    <a href="{{ route('login') }}" class="btn btn-white btn-outline btn-rounded ls-25">کلیک کنید
                    </a>
                </div>
            </div>
        @else
            <form method="POST">
                @csrf
                <div id="formlanding" style="background-color: #fafafa;" class="mt-5">
                    <h4 class="title title-link ">ثبت درخواست</h4>
                    <div class="card-body">
                        <div>
                            <label>نام و نام خانوادگی:</label>
                            <span style="color: red">*</span>
                            <input type="text" class="form-control form-control-md" name="Name"
                                placeholder="نام و نام خانوادگی خود را به فارسی وارد نمائید" required>


                        </div>

                        <div>
                            <label>کدملی: </label>
                            <span style="color: red">*</span>
                            <input type="number" class="form-control form-control-md" name="MelliID"
                                placeholder="کدملی خود را وارد نمائید" required>


                        </div>

                        <div>
                            <label>سن: </label>
                            <span style="color: red">*</span>
                            <input type="number" class="form-control form-control-md" name="ُage"
                                placeholder="سن خودرا به عدد وارد نمائید" required>


                        </div>

                        <div>
                            <label>آخرین مدرک تحصیلی: </label>
                            <span style="color: red">*</span>
                            <input type="text" class="form-control form-control-md" name="ُMadrak"
                                placeholder="آخرین مدرک تحصیلی و سال اخذ مدرک را وارد نمائید" required>


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
