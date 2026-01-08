@extends('Layouts.Theme1.MainLayout')
<a href="https://kookbaz.ir/Product">
    <div class="sticky-content fix-top sticky-header " style="height: 60px;"><img class="w-100 fix-banner22"
            src="https://kookbaz.ir/storage/photos/000123/قسطی بخر.png?x-oss-process=image/quality,q_95" height="60"
            style="object-fit: cover;  height: 60px;"></div>

</a>
@section('MainContent')
    <style>
    

        .bargprice {
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

    <div class="page-content become-a-vendor">

        <div class="page-content">
            <div class="container">
                <section class="introduce  pb-10 banner-videowordpress">
                    <div class="banner banner-video product-video br-xs">
                        <figure class="banner-media">
                            <a href="#">
                                <img src="https://kookbaz.ir/storage/photos/000123/123.png" alt="banner" width="610"
                                    height="300" style="background-color: #bebebe;">
                            </a>
                            <a class="btn-play-video " onclick="Playvideo()"></a>
                        </figure>


                    </div>




                </section>
                <section class="introduce mt-10 pb-10 video nested">

                    <video id="autoplay" width="800" class="video nested" controls>
                        <source src="https://kookbaz.ir/storage/video/1.mp4" type="video/mp4">

                        Your browser does not support the video tag.
                    </video>



                </section>

                <section class="customer-service mb-7">

                    <div class="col-md-12 pr-lg-12 mb-12">

                        <h4 class="title  title-center mb-3"> دوره حضوری انتخاب شغل و رضایت از زندگی
                        </h4>
                        <p class="mb-6 text-decoration22">
                            درس بخونم یا نخونم؟ چه رشته‌ای انتخاب کنم؟ تا کدوم مقطع بخونم؟ دکتری بگیرم؟ کی وارد بازار کار
                            بشم؟ بیام تهران با بمونم شهر خودم؟ مهاجرت کنم؟ کارآفرین بشم؟ کسب و کار خودمو داشته باشم؟ کارمند
                            بشم؟ از زیر کار در برم؟ کار هنری بدرد می‌خوره؟ پول بیشتر رو انتخاب کنم یا برم دنبال علاقه‌ام؟
                            اگر برم سراغ کار مورد علاقم و موفق نشم چی؟
                            <br>
                            خیلی از ما انسانها با این سوالات و خیلی سوالات مشابه اینها درگیریم، به جرات میگم همه ما انسانها
                            لحظاتی از زندگیمون وجود داره که زیر فشار این سوالات احساس می‌کنیم کمر خم کردیم!
                            این سوالات برای من هم خیلی آزار دهنده بودن و مدت زمان زیادی از عمرم رو درگیر پاسخ به این سوالات
                            بودم و حالا می‌خوام تمام آنچه تجربه کردم و آموختم رو با شما در این دوره به اشتراک بزارم، تا شما
                            در مدت زمانی خیلی کوتاه تر از من از این شرایط عبور کنید و وارد مرحله‌ای بشید که همه تلاشها و
                            s سختی‌ها معنا و لذت متفاوتی براتون داشته باشه.

                        </p>

                    </div>

                </section>

            </div>
        </div>

    </div>
    </section>
    <section class="customer-service mb-7">
        <div class="card-box ex-23">
            <div class="row flexer flex-no-wrap flex-direction-row">
                <div class="col-md-4 col-sm-6">
                    <div class="course-info-inline">
                        <div class="inner">
                            <div class="title">دوره آموزشی</div>
                            <div class="value">
                                جمعه 1401/10/02

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="course-info-inline">
                        <div class="inner">
                            <div class="title">
                                ساعت برگزاری</div>
                            <div class="value">9 الی 16</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="course-info-inline">
                        <div class="inner">
                            <div class="title">مدت زمان آموزشی</div>
                            <div class="value"> 7 ساعت + پذیرایی ناهار و میان وعده </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="col-md-12 pr-lg-12 mb-12">
        <div class="col-md-12 col-sm-12 new-section-title pt-4">
            <h2 class="s_section_title text-center text-black" style="margin-top:7%;">
                سرفصل های دوره
            </h2>
        </div>
        <div class="col-md-12 pr-lg-8 mb-8">

            <div class="accordion accordion-simple accordion-plus">
                <div class="card border-no">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">

                        <a href="#collapse3-1" class="collapse">
                            آیا علاقه برای انتخاب شغل کافی است؟
                        </a>

                    </div>

                </div>
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-2" class="expand"> علاقه یا علایق </a>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            استعداد
                        </a>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            چرا آزمونهای روانشناسی ما را به نتیجه قطعی نمی رسونن
                        </a>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            شاخصهای رضایت شغلی</a>

                    </div>

                </div>

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            لذات اصلی
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            ارزشهای زندگی
                        </a>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            ترمزهایی که نمی‌دانیم وجود دارند
                        </a>
                    </div>

                </div>


                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            نیروی انگیزه بخش مرگ
                        </a>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            کف بازار
                        </a>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a href="#collapse3-3" class="expand">
                            انتخاب شغل و نگارش عهدنامه شخصی
                        </a>
                    </div>

                </div>





            </div>
        </div>

    </section>
    <section class="col-md-12 pr-lg-12 mb-12">
        <div class="col-md-12 col-sm-12 new-section-title pt-4">
            <h2 class="s_section_title text-center text-black" style="margin-top:7%;">
                مسیر دوره </h2>
        </div>
        <div class="col-md-12 pr-lg-8 mb-8">

            <p class="mb-6 text-decoration22">

                قرار هست در این دوره کار رو با تعریف یک چهارچوب شروع کنیم و یکسری شاخص در نظر بگیریم که بر اساس اونها میشه
                به شغلی رسید که هم علایق و استعدادهای ما رو پوشش بده و هم بتونیم با کسب درآمد از اون زندگی مادی مناسبی داشته
                باشیم.برای این کار قراره سری به دنیای تست های روانشناسی بزنیم، چند شیوه خودشناسی رو با هم مرور کنیم و به کمک
                خاطرات دوران کودکی چراغی برای ادامه مسیر بدست بیاریم.
                در مرحله بعد باید لذات اصلی رو بشناسیم و اونها رو بر اساس اولویت های خودمون مرتب کنیم.
                بعد از شناسایی لذت ها، بنا داریم تا بریم سراغ ارزشهای زندگی، با اونها آشنا بشیم و 5 ارزش اصلی زندگیمونو
                مکتوب کنیم.
                مشکلات زیادی که خیلی از اونها مربوط به نگرشهای ما میشن باید اصلاح بشن تا احتمال اشتباه در این مسیر رو به
                حداقل برسونیم پس مفصل در مورد اشتباهات نگرشی مسیر شغلی با هم صحبت می کنیم.
                واقعا انتخاب شغل بدون در نظر گرفتن شرایط شغلی جامعه ای که در اون زندگی می کنیم بی معنیه پس باید ببینیم چه
                راههایی برای شناخت بازار کسب و کار داریم و چه کاری می تونیم در این مورد انجام بدیم.
                در پایان کار وقت اون هست که هر چی در موردش تا ایجا صحبت کردیم رو در قالب یک عهد نامه شخصی به رشته تحریر در
                بیاریم و از این به بعد بر اساس اون ادامه زندگی شغلیمون رو شکل بدیم


            </p>
        </div>

    </section>
    <div class="col-md-12 ">
        <figure class="br-lg">
            <img src="https://kookbaz.ir/storage/photos/1/carrrer.png" class="center" alt="Banner" width="610"
                height="450" style="background-color: #9E9DA2;">
        </figure>
    </div>

    <section>
        <div>
            <span>
                <div class="col-md-12 col-sm-12 new-section-title pt-4" style="margin-top:7%;">
                    <h2 class="s_section_title text-center text-black">
                        مدرس دوره
                    </h2>
                </div>
                <div>



                    <div>
                        <div>


                            <div>
                                <div class="testimonial-wrap">
                                    <div class="testimonial testimonial-centered testimonial-shadow">
                                        <div class="testimonial-info">
                                            <figure class="testimonial-author-thumbnail"
                                                style="
                                            width: 20rem;
                                            height: 20rem;
                                        ">
                                                <img src="https://kookbaz.ir/storage/photos/000123/Untitled-1.png"
                                                    alt="Testimonial">
                                            </figure>

                                        </div>
                                        <blockquote>

                                            کارشناس ارشد روانشناسی شخصیت





                                        </blockquote>
                                        <cite>
                                            کاوه راد </cite>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </span>
        </div>
    </section>
    <section>
        <div class="cd-section course-content pt-4" id="course-requirement" style="margin-top:7%;">
            <div class="col-md-12 col-sm-12 new-section-title pt-4">
                <h2 class="s_section_title text-center text-black">سوالات متداول</h2>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-md-6 mb-10 mb-md-4">
                        <div class="accordion accordion-bg accordion-primary accordion-gutter-md accordion-plus">

                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <a href="#collapse5-2" class="collapse">
                                        این دوره مناسب چه کسانی است؟
                                    </a>
                                </div>
                                <div class="card-body expanded" id="collapse5-2">
                                    <p class="mb-0">
                                        اگر به دنبال موفقیت بیشتر هستید، اگر دوست دارید خلاقیت خود را بکار گیرید و عرصه های
                                        کاری جدید را تجربه کنید، اگر به دنبال علاقه واقعی خود می‌گردید اما هنوز به هیچ چیز
                                        مطمئن نیستید، اگر از شغل خود لذت نمی‌برید اما نمی‌دانید چه کنید این دوره دقیقا برای
                                        شما طراحی شده است.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <a href="#collapse5-1" class="expand"> آیا این دوره حول مسائل انگیزشی است؟</a>
                                </div>
                                <div class="card-body collapsed" id="collapse5-1">
                                    <p class="mb-0">
                                        این دوره قرار نیست به شما انگیزه دروغین بدهد تا بعد از مدتی ببینید هیچ چیز بدست
                                        نیاورده اید بلکه قرار است با واقعیات زندگی از منظر جدیدی رو به رو شوید.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <a href="#collapse5-3" class="expand"> هزینه شرکت در دوره چقدر است؟
                                    </a>
                                </div>
                                <div class="card-body collapsed" id="collapse5-3">
                                    <p class="mb-0">
                                        هزینه این دوره 450 هزار تومان است که با تخفیف ویژه کوکباز برابر 50 هزار تومان است
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="accordion accordion-bg accordion-primary accordion-gutter-md accordion-plus">
                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <a href="#collapse6-1" class="collapse">آیا این دوره پشتیبانی دارد؟</a>
                                </div>
                                <div class="card-body expanded" id="collapse6-1">
                                    <p class="mb-0">
                                        یک جلسه مشاوره آنلاین و 3 ماه عضویت در گروه به صورت پشتیبان این جلسه ارائه خواهد شد.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <a href="#collapse6-2" class="expand"> محل برگزاری دوره کجاست؟ </a>
                                </div>
                                <div class="card-body collapsed" id="collapse6-2">
                                    <p class="mb-0">
                                        این دوره در مجموعه کوکباز واقع در میدان اقدیسه - نبش میدان ارتش برگزار می گردد.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                    <a href="#collapse6-3" class="expand"> راه های ثبت نام چگونه است؟</a>
                                </div>
                                <div class="card-body collapsed" id="collapse6-3">
                                    <p class="mb-0">
                                        ثبت نام از طریق فرم پایین همین صفحه قابل انجام است
                                        جهت دریافت هرگونه مشاوره و پشتیبانی نیز میتوانید در شبکه های اجتماعی و همینطور با
                                        شماره تماس های مجموعه با پشتیبانان کوکباز درارتباط باشید.

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="col-md-12 col-sm-12 new-section-title pt-4" style="margin-top:7%;">
            <h2 class="s_section_title text-center text-black">
                ثبت نام دوره
            </h2>
        </div>

        <div>
            <form method="POST">
                @csrf
                <div class="testimonial testimonial-centered testimonial-shadow" style="font-size:17px">

                    <p style="font-size: 20px ;font-weight:800">
                        دوره حضوری انتخاب شغل و رضایت از زندگی</p>



                    <div>طول دوره : 7 ساعت / شروع : 2 دی ۱۴۰۱</div>
                    <p>مکان دوره : تهران- میدان اقدسیه</p>
                    <p>
                    <div style="color: red">میزان تخفیف : 90%</div>
                    </p>

                    <div>
                        <span class="bargprice">99,000 تومان </span>
                    </div>
                    <br>
                    <a href="{{ route('SingleProduct', ['productID' => '6352']) }}"
                        class="btn btn-dark btn-rounded btn-icon-right"> شروع ثبت نام دوره
                    </a>
                </div>
            </form>

            <div class="form-group mb-10">

            </div>
    </section>
    </div>
    </div>
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
