@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme9.Layout.mian_layout')
@section('content')
    <div class="main-container container">
        <div class="row">
            <div style="text-align: center" class="container mb-3 px-0">
                <div class="swiper-container swiperhighlight">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-primary text-white">
                                <div class="card-body">
                                    <a style="all: unset;cursor: pointer;" href="{{ route('add_file') }}">
                                        <h2 class="mb-3"><i class="bi-file-plus"></i><span class="d-none">Icon</span></h2>
                                        <h6>ثبت آگهی</h6>
                                        <p class="text-muted small">ثبت آگهی جدید</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-danger text-white">
                                <div class="card-body">
                                    <a style="all: unset;cursor: pointer;" href="{{ route('deal_search') }}">
                                        <h2 class="mb-3"><i class="bi bi-list"></i><span class="d-none">Icon</span></h2>
                                        <h6>آگهی های من</h6>
                                        <p class="text-muted small">0 آگهی </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-warning text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi-umbrella"></i><span class="d-none">Icon</span></h2>
                                    <h6>بیمه</h6>
                                    <p class="text-muted small">بیمه وسیله نقلیه</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-danger text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi-badge-ad-fill"></i><span class="d-none">Icon</span></h2>
                                    <h6>خدمات من</h6>
                                    <p class="text-muted small">تبلیغ خدمات من</p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-success text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-gem"></i><span class="d-none">Icon</span></h2>
                                    <h6>خانواده</h6>
                                    <p class="text-muted small">دیزل سواران</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-6 col-md-4 col-lg-3">
                <div class="card shadow-sm mb-4">
                    <figure class="card-img-top mb-0">
                        <img src="https://rayandiesel.co/storage/photos/mobile/truckmain1.webp" alt="project images"
                            class="img-fluid">
                    </figure>

                    <a href="{{ route('add_file') }}" class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-1">ثبت رایگان آگهی خرید و فروش</h6>
                                <p class=" text-muted mb-2 small"> کامیون ، کامیونت ، کشنده</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card shadow-sm mb-4">
                    <figure class="card-img-top mb-0 ">
                        <img src="https://rayandiesel.co/storage/photos/mobile/free_ad.png" alt="project images"
                            class="img-fluid">
                    </figure>
                    <a href="{{ route('add_file') }}" class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-1">آگهی های من </h6>
                                <p class=" text-muted mb-2 small">وضعیت آگهی های ثبت شده من</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card shadow-sm mb-4">
                    <figure class="card-img-top  mb-0 ">
                        <img src="https://rayandiesel.co/storage/photos/mobile/free_ad.png" alt="project images"
                            class="img-fluid">
                    </figure>
                    <a href="{{ route('add_file') }}" class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-1">ثبت رایگان آگهی خرید و فروش</h6>
                                <p class=" text-muted mb-2 small"> کامیون ، کامیونت ، کشنده</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card shadow-sm mb-4">
                    <figure class="card-img-top  mb-0 ">
                        <img src="https://rayandiesel.co/storage/photos/mobile/free_ad.png" alt="project images"
                            class="img-fluid">
                    </figure>
                    <a href="{{ route('add_file') }}" class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-1">ثبت رایگان آگهی خرید و فروش</h6>
                                <p class=" text-muted mb-2 small"> کامیون ، کامیونت ، کشنده</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


        </div>


    </div>
@endsection

@section('page-js')
    <script>
        const swiper = new Swiper('.swiperhighlight', {
            slidesPerView: 3,

            loop: true,
            // اختیاری: اگر بخوای مثلاً دکمه‌ی بعد و قبل هم اضافه کنی
            // navigation: {
            //   nextEl: '.swiper-button-next',
            //   prevEl: '.swiper-button-prev',
            // },
        });
    </script>
@endsection
