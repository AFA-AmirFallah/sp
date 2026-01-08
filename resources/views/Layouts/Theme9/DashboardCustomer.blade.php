@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme9.Layout.mian_layout')
@section('content')
    <div class="main-container container">
        <h2 class="my-4">سلام!<br>سعید <span class="text-primary">مظفری </span> عزیز</h2>

        <!-- welcome message and notifications lead -->
        <div class="row mb-4">
            <div class="col-auto">
                <h1 class="position-relative">
                    <span
                        class="position-absolute top-0 end-75 translate-middle badge border border-light rounded-circle bg-danger p-1 mt-2">
                        <span class="visually-hidden">پیام های خوانده نشده</span>
                    </span>
                    <i class="bi bi-bell text-primary"></i>
                </h1>
            </div>
            <div class="col">
                <p class="m-0 text-muted small">روز خوشی داشته باشبد <br>3 اعلان </p>
            </div>
        </div>
        <div class="row">
            @php
                $mostviewconter = 1;
            @endphp
            @foreach ($DataSource->MostViewPosts() as $LastPost)
                @php
                    if ($LastPost->OutLink == null) {
                        $news_route = route('ShowNewsItem', [
                            'NewsId' => $LastPost->id,
                            'newsitem' => $LastPost->Titel,
                        ]);
                    } else {
                        $news_route = route('ShowNewsItem', ['NewsId' => $LastPost->OutLink]);
                    }

                @endphp
                <div class="col-12 col-md-6 mb-3">
                    <div class="row">
                        <div class="col-5">
                            <figure class="rounded position-relative h-190 overflow-hidden shadow-sm">
                                <div class="coverimg h-100 w-100 position-absolute start-0 top-0"
                                    style="background-image: url(&quot;{{ $LastPost->MainPic }}&quot;);">
                                    <img src="{{ $LastPost->MainPic }}" alt="" style="display: none;">
                                </div>
                            </figure>
                        </div>
                        <div class="col">
                            <a href="{{ $news_route }}"
                                class="h5 d-block text-normal">{{ strip_tags($LastPost->Titel) }}</a>
                            <p class="small text-muted">{{ $LastPost->description }}</p>
                            <a href="{{ $news_route }}" class="text-normal small">ادامه مطلب <i
                                    class="bi bi-arrow-left"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Chart and Circular progress -->
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col">
                                <p class="my-0">آمار <small class="text-muted">پیشرفت روزانه</small></p>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-link btn-sm dropdown-toggle caret-none" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-filter"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                                    aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">عملیات</a></li>
                                    <li><a class="dropdown-item" href="#">عملیات</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">حذف</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <canvas id="areachart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-6 col-md-12">
                        <div class="card shadow-sm text-center mb-4">
                            <div class="card-body">
                                <div id="progressCircle1" class="progressCircle mb-3"></div>
                                <h6 class="mb-1">34251</h6>
                                <p class="text-muted small">عضو جدید</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-12">
                        <div class="card shadow-sm text-center mb-4">
                            <div class="card-body">
                                <div id="progressCircle2" class="progressCircle mb-3"></div>
                                <h6 class="mb-1">6588</h6>
                                <p class="text-muted small">طراحی</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dark mode switch -->
        <!--<div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="darkmodeswitch">
                                        <label class="form-check-label text-muted px-2 " for="darkmodeswitch">فعالسازی حالت تاریک </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
        <!-- swiper carousel -->
        <div class="row">
            <div class="container mb-3 px-0">
                <div class="swiper-container swiperhighlight">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-primary text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-bag"></i><span class="d-none">Icon</span></h2>
                                    <h6>وضعیت طراحی</h6>
                                    <p class="text-muted small">12 عضو جدید</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-danger text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-gem"></i><span class="d-none">Icon</span></h2>
                                    <h6>لورم ایپسوم متن</h6>
                                    <p class="text-muted small">12 عضو جدید</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-warning text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-house"></i><span class="d-none">Icon</span></h2>
                                    <h6>لورم ایپسوم متن</h6>
                                    <p class="text-muted small">12 عضو جدید</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-success text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-cart"></i><span class="d-none">Icon</span></h2>
                                    <h6>وضعیت طراحی</h6>
                                    <p class="text-muted small">12 عضو جدید</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-danger text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-gem"></i><span class="d-none">Icon</span></h2>
                                    <h6>لورم ایپسوم متن</h6>
                                    <p class="text-muted small">12 عضو جدید</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-warning text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-house"></i><span class="d-none">Icon</span></h2>
                                    <h6>لورم ایپسوم متن</h6>
                                    <p class="text-muted small">12 عضو جدید</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm bg-success text-white">
                                <div class="card-body">
                                    <h2 class="mb-3"><i class="bi bi-cart"></i><span class="d-none">Icon</span></h2>
                                    <h6>وضعیت طراحی</h6>
                                    <p class="text-muted small">12 عضو جدید</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appreaciation banner with chart -->
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6>بسیار عالی</h6>
                                <p class="text-muted small">شما در وضعیت مناسبی قرار دارید ، موفق باشید.</p>
                            </div>
                            <div class="col-auto align-self-center">
                                <canvas id="smallchart1" class="smallchart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto align-self-center">
                                <canvas id="smallchart2" class="smallchart"></canvas>
                            </div>
                            <div class="col">
                                <h6>بسیار عالی</h6>
                                <p class="text-muted small">شما در وضعیت مناسبی قرار دارید ، موفق باشید.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trending Projects carousel -->
        <div class="row mb-2">
            <div class="col">
                <h6 class="my-1">پروژه های ترند شده </h6>
            </div>
            <div class="col-auto px-0">
                <a class="btn btn-link btn-sm" href="product.html">نمایش همه</a>
            </div>
            <div class="col-auto">
                <button class="btn btn-link btn-sm dropdown-toggle caret-none" type="button" id="dropdownMenuButton2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-filter"></i>
                </button>
                <ul class="dropdown-menu shadow border-0" aria-labelledby="dropdownMenuButton2">
                    <li><a class="dropdown-item" href="#">عملیات</a></li>
                    <li><a class="dropdown-item" href="#">عملیات</a></li>
                    <li><a class="dropdown-item text-danger" href="#">حذف</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="container mb-4 px-0">
                <div class="swiper-container swiperprojects">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card shadow-sm">
                                <button
                                    class="btn btn-danger avatar avatar-40 p-0 rounded-circle position-absolute top-0 start-0 m-3"><i
                                        class="bi bi-heart h4 mb-0"></i></button>
                                <figure class="card-img-top overflow-hidden mb-0 coverimg"><img
                                        src="assets/img/project1.jpg" alt="project images"></figure>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto align-self-center">
                                            <div id="progressCircle3" class="progressCircle"></div>
                                        </div>
                                        <div class="col">
                                            <p class="text-uppercase text-muted mb-1">مطالعه موردی</p>
                                            <h3 class="mb-1">34251</h3>
                                            <p class="small text-muted">بازدید</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm">
                                <button
                                    class="btn btn-danger avatar avatar-40 p-0 rounded-circle position-absolute top-0 start-0 m-3"><i
                                        class="bi bi-heart h4 mb-0"></i></button>
                                <figure class="card-img-top overflow-hidden mb-0 coverimg"><img
                                        src="assets/img/project2.jpg" alt="project images"></figure>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto align-self-center">
                                            <div id="progressCircle4" class="progressCircle"></div>
                                        </div>
                                        <div class="col">
                                            <p class="text-uppercase text-muted mb-1">مطالعه موردی</p>
                                            <h3 class="mb-1">34251</h3>
                                            <p class="small text-muted">بازدید</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm">
                                <button
                                    class="btn btn-danger avatar avatar-40 p-0 rounded-circle position-absolute top-0 start-0 m-3"><i
                                        class="bi bi-heart h4 mb-0"></i></button>
                                <figure class="card-img-top overflow-hidden mb-0 coverimg"><img
                                        src="assets/img/project3.jpg" alt="project images"></figure>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto align-self-center">
                                            <div id="progressCircle5" class="progressCircle"></div>
                                        </div>
                                        <div class="col">
                                            <p class="text-uppercase text-muted mb-1">مطالعه موردی</p>
                                            <h3 class="mb-1">34251</h3>
                                            <p class="small text-muted">بازدید</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card shadow-sm">
                                <button
                                    class="btn btn-danger avatar avatar-40 p-0 rounded-circle position-absolute top-0 start-0 m-3"><i
                                        class="bi bi-heart h4 mb-0"></i></button>
                                <figure class="card-img-top overflow-hidden mb-0 coverimg"><img
                                        src="assets/img/project1.jpg" alt="project images"></figure>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto align-self-center">
                                            <div id="progressCircle6" class="progressCircle"></div>
                                        </div>
                                        <div class="col">
                                            <p class="text-uppercase text-muted mb-1">مطالعه موردی</p>
                                            <h3 class="mb-1">34251</h3>
                                            <p class="small text-muted">بازدید</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- list host players -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h6 class="my-1">بازیکنان میزبان</h6>
                            </div>
                            <div class="col-auto px-0">
                                <a class="btn btn-link btn-sm" href="product.html">نمایش همه</a>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0">
                            <div class="row">
                                <div class="col-auto">
                                    <figure class="avatar avatar-50 rounded-circle">
                                        <img src="assets/img/user1.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="col px-0">
                                    <p>سعید مظفری<br><small class="text-muted">52540 تومان</small></p>
                                </div>
                                <div class="col-auto text-start">
                                    <p>
                                        <small class="text-muted">آنلاین <span
                                                class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>
                                        <br><small class="text-success">+500 تومان</small>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0">
                            <div class="row">
                                <div class="col-auto">
                                    <figure class="avatar avatar-50 rounded-circle">
                                        <img src="assets/img/user2.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="col px-0">
                                    <p>سعید مظفری<br><small class="text-muted">52540 تومان</small></p>
                                </div>
                                <div class="col-auto text-start">
                                    <p>
                                        <small class="text-muted">آنلاین <span
                                                class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>
                                        <br><small class="text-danger">-215 تومان</small>
                                    </p>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item border-0">
                            <div class="row">
                                <div class="col-auto">
                                    <figure class="avatar avatar-50 rounded-circle">
                                        <img src="assets/img/user3.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="col px-0">
                                    <p>سعید مظفری<br><small class="text-muted">52540 تومان</small></p>
                                </div>
                                <div class="col-auto text-start">
                                    <p>
                                        <small class="text-muted">آنلاین <span
                                                class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>
                                        <br><small class="text-danger">-300 تومان</small>
                                    </p>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item border-0">
                            <div class="row">
                                <div class="col-auto">
                                    <figure class="avatar avatar-50 rounded-circle">
                                        <img src="assets/img/user1.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="col px-0">
                                    <p>سعید مظفری<br><small class="text-muted">52540 تومان</small></p>
                                </div>
                                <div class="col-auto text-start">
                                    <p>
                                        <small class="text-muted">آنلاین <span
                                                class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>
                                        <br><small class="text-success">+500 تومان</small>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Event list -->
        <div class="row mb-2">
            <div class="col">
                <h6 class="my-1">برترین رویدادها </h6>
            </div>
            <div class="col-auto px-0">
                <a class="btn btn-link btn-sm" href="events.html">نمایش همه</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <div class="row gx-3">
                            <div class="col-auto">
                                <div class="avatar avatar-30 rounded-circle text-danger bg-danger-light">
                                    <i class="bi bi-bell"></i>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <h6 class="my-1">یادآور</h6>
                            </div>
                            <div class="col align-self-center text-start">
                                <button class="btn btn-sm btn-link">پیوستن به رویداد</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="text-primary ">رویداد گتسبی کبیر</h6>
                        <p class="text-muted">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                            طراحان گرافیک است.</p>
                        <div class="row mt-4">
                            <div class="col-auto">
                                <figure class="avatar avatar-50 rounded-circle">
                                    <img src="assets/img/user1.jpg" alt="Generic placeholder image">
                                </figure>
                                <figure class="avatar avatar-50 rounded-circle">
                                    <img src="assets/img/user2.jpg" alt="Generic placeholder image">
                                </figure>
                                <figure class="avatar avatar-50 rounded-circle">
                                    <img src="assets/img/user3.jpg" alt="Generic placeholder image">
                                </figure>
                            </div>
                            <div class="col align-self-center">
                                <h6 class="my-0">6 دوست</h6>
                                <p class="small text-muted">2546 سایر</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <div class="row gx-3">
                                    <div class="col-auto align-self-center">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-1 text-primary">آدرس</h6>
                                        <p class="text-muted small">تهران،انقلاب </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col text-end">
                                <div class="row gx-3">
                                    <div class="col-auto align-self-center">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-1 text-primary text-start">تاریخ</h6>
                                        <p class="text-muted mb-0 small text-start">17 خرداد 1401</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <div class="row gx-3">
                            <div class="col-auto">
                                <div class="avatar avatar-30 rounded-circle text-danger bg-danger-light">
                                    <i class="bi bi-bell"></i>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <h6 class="my-1">یادآور</h6>
                            </div>
                            <div class="col align-self-center text-start">
                                <button class="btn btn-sm btn-link">پیوستن به رویداد</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body z-index-1">
                        <h6 class="text-primary ">رویدادهای تازه</h6>
                        <p class="text-muted">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                            طراحان گرافیک است.</p>
                        <div class="row mt-4">
                            <div class="col-auto">
                                <div class="avatar-group">
                                    <figure class="avatar avatar-50 rounded-circle">
                                        <img src="assets/img/user1.jpg" alt="Generic placeholder image">
                                    </figure>
                                    <figure class="avatar avatar-50 rounded-circle">
                                        <img src="assets/img/user2.jpg" alt="Generic placeholder image">
                                    </figure>
                                    <figure class="avatar avatar-50 rounded-circle">
                                        <img src="assets/img/user3.jpg" alt="Generic placeholder image">
                                    </figure>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <h6 class="my-0">5 دوست</h6>
                                <p class="small text-muted">2546 سایر</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <p>
                                    <i class="bi bi-geo-alt text-success mx-1"></i>
                                    <span class="text-muted small">ایران</span>
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                    <i class="bi bi-calendar text-warning mx-1"></i>
                                    <span class="text-muted small">22 تیرماه</span>
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                    <i class="bi bi-clock text-primary mx-1"></i>
                                    <span class="text-muted small">01:01 صبح</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
