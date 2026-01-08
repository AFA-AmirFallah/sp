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
    </style>

    <div class="container  pb-1 pb-lg-10 mb-10">
        <div class="row align-items-center">
            <div class="col-md-8 mb-4 mb-md-0 mt-8">
                <figure class="br-sm">
                    <img src="https://kookbaz.ir/storage/photos/----/چین/chin baner.png" alt="Banner" />
                </figure>
            </div>
            <div class="col-md-4 order-md-first">
                <h1 class="heading mb-3 text-center"> خدمات تعمیرگاهی خودروهای چینی</h1>


                <h5 class="text-center lh-2">
                    تعمیرات تمامـی بخش‌های خودرو با تجهیزات نوین و فناوری به روز با قیمت مناسب و شرایط ویژه
                </h5>
                <div class="icon-box-side">

                    <a href="#chin" class="btn btn-blue btn-outline btn-rounded ls-25
                "> ثبت سفارش</a>
                </div>
            </div>
        </div>
        <!-- End of Row -->
    </div>
    <div class="container ">

        <div class="row">
            <div class="col-sm-4 ">
                <div class="counter text-center">
                    <img src="https://kookbaz.ir/storage/photos/----/چین/123/Screenshot.svg" alt="Banner" />
                    <h4 class="mt-3">۶ و ۲۴ ماه ضمانت </h4>
                    <p> به خدمات تعمیر، ۶ و ۲۴ ماه تعلق مـی‌گیرد.</p>

                </div>
            </div>

            <div class="col-sm-4 ">
                <div class="counter text-center">
                    <img src="https://kookbaz.ir/storage/photos/----/چین/123/Screenshot (.svg" alt="Banner" />
                    <h4 class="mt-3">عیب‌یابـی رایگان
                    </h4>
                    <p> بررسـی فنـی خودروی شما به صورت رایگان صورت مـی‌گیرد.</p>

                </div>

            </div>
            <div class="col-sm-4 ">
                <div class="counter text-center">
                    <img src="https://kookbaz.ir/storage/photos/----/چین/123/Screenshot (18) copy.svg" alt="Banner" />
                    <h4 class="mt-3"> تعمیر به جای تعویض
                    </h4>
                    <p> به منظور کاهش هزینه‌های شما اولویت ما تعمیر قطعات است. </p>

                </div>

            </div>
        </div>

    </div>

    <section class="introduce  ">

        <figure class="br-lg">
            <img src="https://kookbaz.ir/storage/photos/----/چین/baner 2 1.png" alt="Banner" width="1240" height="540"
                style="background-color: #D0C1AE;">
        </figure>
    </section>
    <div class=" how-trade pt-10 pb-5 pb-lg-10">
        <div class="container mt-2 mt-lg-10 mb-0 mb-lg-10">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">

                    <section class="introduce  pb-10 banner-videowordpress">
                        <div class=" banner-video product-video br-xs">
                            <figure>
                                <a href="#">
                                    <img src="https://kookbaz.ir/storage/photos/----/چین/thumbnail.png" alt="Banner">
                                </a>
                                <a class="btn-play-video " onclick="Playvideo()"></a>
                            </figure>


                        </div>
                    </section>
                    <section class="introduce mt-10 pb-10 video nested">

                        <video id="autoplay" width="800" class="video nested" controls>
                            <source src="https://kookbaz.ir/storage/video/chin.mp4" type="video/mp4">

                            Your browser does not support the video tag.
                        </video>



                    </section>

                </div>
                <div class="col-lg-6 ">
                    <ul class="lh-2 font-weight-bolder font-size-lg">
                        <li>ارائه ضمانت ۶ ماهه در بخش تعمیر گیربکس و ۲۴ ماهه در بخش تعمیر کاتالیزور
                        </li>
                        <li> عیب‌یابـی برق ماشین به صورت رایگان و رفع مشکل با جدیدترین فناوری </li>
                        <li>کارواش رایگان خودرو قبل از تحویل</li>
                        <li>تخفیف ویژه ده درصدی برای بازنشستگان نیروهای مسلح</li>
                        <li>مجموعه آقای چین با 8 سال سابقه در زمینه تعمیرات خودروهای چینی</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End of Row -->
    </div>
    <!-- End of Container -->



    @if (!Auth::check())
        <div id="chin" class="banner parallax mt-5"
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
                <div id="chin" style="background-color: #fafafa;" class="mt-5">
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
                            <label> استان:</label>
                            <span style="color: red">*</span>

                            <select required name="Province" id="Province" onchange="LoadCitys(this.value)"
                                class="form-control form-control-md">
                                <option value="0">{{ __('--select--') }}</option>
                                @foreach ($Provinces as $ProvincesTarget)
                                    <option value="{{ $ProvincesTarget->id }}">
                                        {{ $ProvincesTarget->ProvinceName }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div>
                            <label> شهر:</label>
                            <span style="color: red">*</span>
                            <select required id="Shahrestan" name="Saharestan" class="form-control form-control-md">
                            </select>
                        </div>
                        <div>
                            <label>آدرس: </label>
                            <span style="color: red">*</span>
                            <input type="text" class="form-control form-control-md" name="ُAddress"
                                placeholder="آدرس محل سکونت خود را دقیق و کامل وارد نمائید" required>


                        </div>
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
