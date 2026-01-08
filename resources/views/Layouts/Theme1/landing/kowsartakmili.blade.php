<style>
    table,
    td,
    th {
        border: 1px solid #ddd;
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



    th {
        background-color: #dee2e6 !important;

        color: black;
    }
</style>

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')
<a href="https://kookbaz.ir/Product">
    <div class="sticky-content fix-top sticky-header " style="height: 60px;"><img class="w-100 fix-banner22"
            src="https://kookbaz.ir/storage/photos/000123/قسطی بخر.png?x-oss-process=image/quality,q_95" height="60"
            style="object-fit: cover;  height: 60px;"></div>

</a>
@section('MainContent')
    <div class="page-content become-a-vendor">

        <div class="page-content">
            <div class="container">
                <section class="introduce mb-10 pb-10">

                    <figure class="br-lg mt-9">
                        <img src="https://kookbaz.ir/storage/photos/1/bime5.png" alt="Banner" width="1240"
                            height="540" style="background-color: #D0C1AE;" />
                    </figure>
                </section>

                <section class="customer-service mb-7">

                    <div class="col-md-12 pr-lg-12 mb-12">

                        <h4 class="title  title-center mb-3">طرح بیمه درمان گروهی

                            خانواده بازنشستگان</h4>
                        <p class="mb-6">
                            بیمه تکمیلی درمان نوعی پوشش بیمه‌ای اضافه بر بیمه پایه است. بیمه تکمیلی درمانی هزینه‌های مختلف
                            خدمات درمانی و پزشکی مثل بستری، جراحی سرپایی و حتی بیماری‌های سختی مانند سرطان یا حمله قلبی را
                            تا سقف پوشش معین در بیمه نامه تحت پوشش قرار می‌دهد. از طرفی بیمه نامه تکمیلی درمان شامل بعضی از
                            هزینه‌های خدمات پزشکی و درمانی که تحت پوشش بیمه‌ پایه نیست (مانند هزینه‌های دندانپزشکی و
                            بینایی)، هم می‌شود.

                        </p>
                        <a href="#register" class="btn btn-primary">
                            ثبت نام<i class="w-icon-long-arrow-left"></i>
                        </a>

                    </div>
                </section>

            </div>
        </div>

    </div>

    <div class=" how-trade pt-10 pb-5 pb-lg-10">
        <div class="container mt-2 mt-lg-10 mb-0 mb-lg-10">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <figure class="br-sm">
                        <img src="https://kookbaz.ir/storage/photos/1/bime3.png" alt="Banner" width="610"
                            height="520" style="background-color: #C9C8CD;" />
                    </figure>
                </div>
                <div class="col-lg-6 pl-lg-8">
                    <h2 class="title text-left"> انواع بیمه تکمیلی
                    </h2>
                    <p class="mb-6"> بیمه تکمیلی درمان در قالب طرح‌های مختلفی ارائه می‌شود. بیمه های تکمیلی به‌شکل زیر
                        دسته‌بندی می‌شوند:
                    </p>
                    <div class="row cols-sm-2 mb-1">
                        <div class="stage-item mb-6 stage-register d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            <p class="mb-0 font-weight-bold"> بیمه تکمیلی انفرادی کوثر</p>
                        </div>
                        <div class="stage-item mb-6 stage-selling d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            <p class="mb-0 font-weight-bold"> بیمه تکمیلی گروهی کوثر</p>
                        </div>
                        <div class="stage-item mb-5 stage-deliver d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            <p class="mb-0 font-weight-bold"> بیمه تکمیلی خانواده</p>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End of Row -->
        </div>
        <!-- End of Container -->
    </div>

    <section class="customer-service mb-7">

        <div class="col-md-12 pr-lg-12 mb-12">

            <h4 class="title  title-center mb-3"> جدول تعهدات بیمه نامه تکمیل درمان سازمان بازنشستگی ن .م

            </h4>
            <p class="mb-6 title title-center">
                طرح آرامش بیمه کوثر سال 1401

            </p>
            <table class="table">
                <tr>
                    <th scope="col">ردیف</th>
                    <th scope="col">سقف تعهد سالیانه به ازای هر نفر</td>
                    <th scope="col">طرح الف</th>
                    <th scope="col">طرح ب</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>جبران هزینه های بستری، جراحی و care day در بیمارستان یا مراکز جراحی محدود. )اعمال جراحی day
                        care به اعمال جراحی اطالق می شود که نیازمند مراقبت کمتر از یک شبانه روز باشد(. هزینه همراه بیمه
                        شدگان
                        کمتر از 10 سال یا بیشتر از 70 سال ، جبران هزینه اعمال جراحی مرتبط با سرطان، قلب ، مغز و اعصاب
                        مرکزی و نخاع، دیسک و ستون فقرات، گامانایف ، پیوند ریه، پیوند کبد، پیوند کلیه، پیوند مغز استخوان،
                        آنژیوپالستی عروق کرونر و عروق داخل مغز، شیمی درمانی، رادیوتراپی </td>
                    <td>700.000.000</td>
                    <td>350.000.000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>هزینه آمبوالنس و سایر فوریتهای پزشکی مشروط به بستری شدن بیمهشده در مراکز درمانی و یا نقل و انتقال
                        <br> بیمار بستری شده به سایر مراکز تشخیصی درمانی طبق دستور پزشک معالج.
                        داخل شهری
                        <br>
                        بین شهری
                    </td>
                    <td> 7،000،000
                        <br>
                        17.000.000

                    </td>
                    <td>7،000،000
                        <br>
                        17.000.000
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>جبران هزینه زایمان اعم از طبیعی و سزارین</td>
                    <td>52.000.00</td>
                    <td>فاقد پوشش </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>جبران هزینه انواع رادیوگرافی، آنژیوگرافی عروق محیطی، آنژیوگرافی چشم، سونوگرافی، ماموگرافی، انواع
                        اسکن،
                        ام آر آی، پزشکی هستهای )شامل اسکن هستهای و درمان رادیوایزوتوپ(، دانسیتومتری،جبران هزینه انواع
                        آندوسکوپی، خدمات تشخیصی قلبی و عروقی شامل انواع الکتروکاردیوگرافی، انواع اکوکاردیوگرافی، انواع هولتر
                        مانیتورینگ، تست ورزش، آنالیز پیسمیکر، EECP ،تیلت تست، خدمات تشخیصی تنفسی شامل )اسپیرومتری
                        و PFT ،)خدمات تشخیصی الکترومیلوگرافی و هدایت عصبی )NCV،EMG ،) الکتروانسفالوگرافی )EEG ،)
                        خدمات تشخیصی یورودینامیک )نوار مثانه(، خدمات تشخیصی و پرتو پزشکی چشم مانند اپتومتری، پریمتری،
                        بیومتری و پنتاکم، شنوایی سنجی )انواع ادیومتری(، جبران هزینه اعمال مجاز سرپائی مانند شکستگی و
                        دررفتگی، گچ گیری، ختنه، بخیه، کرایوتراپی، اکسیزیون لیپوم، بیوپسی، تخلیه کیست و لیزر درمانی، سوزن و
                        نوار تست قند خون ، اروتز بالفاصله بعد از جراحی </td>
                    <td>87.000.000</td>
                    <td> 52.000.000</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>جبران هزینه انواع خدمات آزمایش های تشخیصی پزشکی شامل پاتولوژی و ژنتیک پزشکی، تستهای آلرژیک ،
                        فیزیوتراپی</td>
                    <td>44.000.00</td>
                    <td>26.000.00</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>جبران هزینههای ویزیت، دارو )براساس فهرست داروهای مجاز کشور صرفاً مازاد بر سهم بیمهگر اول( و خدمات
                        اورژانس در موارد غیربستری</td>
                    <td>70.000.000</td>
                    <td>35.000.000</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>جبران هزینههای سرپایی یا بستری مربوط به خدمات دندانپزشکی و جراحی لثه
                        ) به استثناء ایمپلنت و ارتودنسی( </td>
                    <td>52.000.000</td>
                    <td>26.000.000</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>جبران هزینههای مربوط به خرید عینک طبی و لنز تماسی طبی با تجویز چشمپزشک و یا اپتومتریست </td>
                    <td>1.000.000</td>
                    <td>7.000.000</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>هزینه جراحی مربوط به رفع عیوب انکساری چشم در مواردی که به تشخیص پزشک معتمد بیمهگر درجه
                        نزدیک بینی، دوربینی، آستیگمات یا مجموع قدرمطلق نقص بینایی هر چشم 3 دیوپتر یا بیشتر باشد.)برای دو
                        چشم( </td>
                    <td>35.000.000</td>
                    <td>17.000.000</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td> سمعک خرید به مربوط هزینه جبر</td>
                    <td>35.000.000</td>
                    <td>17.000.000 </td>
                </tr>
                <tr>
                    <td></td>
                    <td>حق بیمه ماهانه هر نفر با اعمال فرانشیز 20 درصد (به ریال)</td>
                    <td>1.950.000</td>
                    <td>1.500.000</td>
                </tr>
            </table>

        </div>
    </section>
    <section class="customer-service mb-7">

        <div class="col-md-12 pr-lg-12 mb-12">

            <h4 class="title  title-center mb-3">مزایای بیمه درمان تکمیلی</h4>
            </p>

        </div>

        <div class="col-md-12 pr-lg-12 mb-12">


            <p class="mb-6">


                سهم پرداختی بیمه‌های پایه مثل بیمه‌های تامین اجتماعی یا خدمات درمانی برای هزینه‌های پزشکی و درمانی تحت پوشش
                معمولا نهایت 30درصد است. اما در بیشتر مواقع هزینه کارهای درمانی و تشخیصی حتی آزمایش یا یک عکس سی‌اتی‌اسکن
                ساده بسیار بالاست. بسیاری از خدمات کلینکی و آزمایشگاهی و پاراکلینکی هم عملا تحت پوشش بیمه‌های پایه قرار
                ندارند. مزیت اصلی بیمه درمان تکمیلی جبران حداکثری هزینه کارهای درمانی و بیمارستانی است. این بیمه نامه تقریبا
                تمام یا دست‌کم بخش بزرگی از هزینه‌های پزشکی را جبران می‌‌کند
            </p>

        </div>

    </section>

    <!-- End of Container -->

    <!-- End of How Trade -->

    <div class="page-content become-a-vendor">
        <div class="container create-store pb-1 pb-lg-10 mb-10">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <figure class="br-sm">
                        <img src="https://kookbaz.ir/storage/photos/1/bime4.png" alt="Banner" width="610"
                            height="435" style="background-color: #D9D8DD;" />
                    </figure>
                </div>
                <div class="col-md-6 order-md-first">
                    <h4 class="text-primary font-weight-bold ls-25">فراخوان </h4>
                    <h2 class="title text-left">ثبت نام آنلاین بیمه درمان </h2>
                    <p>

                        کوکباز با همکاری بیمه کوثر به منظور پوشش حداکثری هزینه‌های درمانی و افزایش رضایت جامعه هدف به صورت
                        غیرحضوری
                        آغاز به ثبت نام بیمه تکمیلی می نماید. متضایان می توانند با تکمیل فرم این صفحه درخواست خود را ثبت
                        نمایند.
                    </p>
                </div>
            </div>
            <!-- End of Row -->
        </div>
        <!-- End of Create Store -->


        <div class="container few-fees mt-10 mb-2 mb-lg-10 pt-2 pt-lg-9">
            <h2 class="text-center text-primary text-capitalize font-weight-bold ls-25"> مدارک لازم برای خرید بیمه درمان
            </h2>
            <div class="row">
                <div class="col-sm-6 listing-fee">
                    <div class="counter text-center">
                        <h4>فرم تکمیل‌شده درخواست </h4>
                        <p> </p>

                    </div>
                </div>

                <div class="col-sm-6 final-fee">
                    <div class="counter text-center">
                        <h4>فرم تکمیل‌شده پرسشنامه سلامت
                        </h4>
                        <p> </p>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 listing-fee">
                    <div class="counter text-center">
                        <h4>
                            صفحه اول شناسنامه و کارت ملی
                        </h4>
                        <p> </p>

                    </div>
                </div>

                <div class="col-sm-6 final-fee">
                    <div class="counter text-center">

                        <h4>
                            ﮐﭙﯽ ﺻﻔﺤﻪ اول دﻓﺘﺮﭼﻪ ﺑﯿﻤﻪ </h4>
                        <p> </p>
                    </div>


                </div>
            </div>
        </div>

        <!-- End of Container -->


        <div id="register">

            <div class="alert alert-primary alert-bg alert-button alert-block text-center">
                <h4 class="alert-title  text-center text-white" style="color: black"> اتمام مهلت ثبت نام</h4>
                <h6 class="text-center" style="color: black">
                    مهلت ثبت نام این طرح به پایان رسیده است<br>
                   
                </h6>
                <h6 class="text-center" style="color: black">
برای ثبت نام به دفاتر ساتا مراجعه فرمایید<br>
                   
                </h6>



            </div>

            {{--  @if (!Auth::check())
             
                <div class="banner parallax" data-parallax-options="{'speed': 10, 'parallaxHeight': '200%', 'offset': -99}"
                    data-image-src="assets/images/pages/become/3.jpg" style="background-color: #929294;">
                    <div class="container">
                        <div class="banner-content text-center">
                            <h2 class="title title-center text-white font-weight-bold">همین الان ثبت نام کنید</h2>
                            <a href="{{ route('login') }}" class="btn btn-white btn-outline btn-rounded ls-25">
                               ثبت نام / ورود 
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
                                    <input required type="text" class="form-control form-control-md" name="Name"
                                        placeholder="">

                                    <label> کد ملی:</label>

                                    <input required type="number" class="form-control form-control-md" name="meliId"
                                        placeholder="">

                                </div>
                                <div>
                                    <label> استان:</label>
                                    <select required name="Province" id="Province" onchange="LoadCitys(this.value)"
                                        class="form-control form-control-md">
                                        <option value="0">{{ __('--select--') }}</option>
                                        @foreach ($Provinces as $ProvincesTarget)
                                            <option value="{{ $ProvincesTarget->id }}">
                                                {{ $ProvincesTarget->ProvinceName }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="inputContiner18">
                                    <label> شهر:</label>
                                    <select required id="Shahrestan" name="Saharestan"
                                        class="form-control form-control-md">
                                    </select>
                                </div>
                                <div>
                                    <label>شماره تماس: </label>
                                    <input required type="number" class="form-control form-control-md" name="ُmobileno"
                                        placeholder="">
                                </div>

                                <div>
                                    <button style="float: left" type="submit" name="submit" value="save"
                                        class="btn btn-dark btn-rounded btn-sm mb-4">
                                        ثبت درخواست
                                    </button>
                                </div>
                            </div>
                    </form>
            @endif --}}
            <div class="form-group mb-10">

            </div>
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
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection
