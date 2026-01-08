@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    @csrf
    <div class="row">
        <div style="display: grid" class="col-lg-3 col-xl-3 mt-3">
            <div class="card card-profile-1 mb-4 "
                style="
            border-color: cadetblue;
            border-width: 3px;
            border-style: groove;
        ">
                <div class="card-body text-center">
                    <div class="avatar box-shadow-2 mb-3">
                        <img src="@if (Auth::user()->avatar != null) {{ Auth::user()->avatar }}
        @else
            {{ url('/') }}/assets/images/avtar/useravatar.png @endif"
                            alt="">
                    </div>
                    <h5 class="m-0">{{ Auth::user()->Name }} {{ Auth::user()->Family }}</h5>
                    <p class="mt-0 text-muted">{{ Auth::user()->extranote ?? 'زمینه کاری ثبت نشده' }} </p>
                    <a href="{{ route('UserProfile') }}" class="btn btn-primary btn-rounded">ویرایش اطلاعات من</a>
                    <div class="card-socials-simple mt-4">
                        <a target="_blank" href="{{ route('PersonelCard', ['RequestUser' => Auth::id()]) }}">
                            نمایش کارت شناسائی پرستاربانک
                        </a>
                    </div>
                    <hr>
                    <div class="ul-widget-card__full-status mb-3">
                        <div class="ul-widget-card__status1">
                            <span>0</span>
                            <span class="text-mute">تعداد بازدید</span>
                        </div>
                        <div class="ul-widget-card__status1">
                            <span>0</span>
                            <span class="text-mute">تعداد گزارش</span>
                        </div>
                        <div class="ul-widget-card__status1">
                            <span>0</span>
                            <span class="text-mute">تعداد استعلام</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: grid" class="col-lg-4 col-xl-4 mt-3">
            <div class="card "
                style="
            border-color: cadetblue;
            border-width: 3px;
            border-style: groove;
        ">
                @php
                    $active_lic = false;
                @endphp
                @foreach ($worker_class->get_user_active_license() as $active_license)
                    @php
                        $active_lic = true;
                    @endphp
                    <div class="card-body">
                        <form action="{{ route('dashboard') }}" method="POST">
                            @csrf
                            <div class="user-profile mb-4">
                                <div class="ul-widget-card__user-info">
                                    <img class="profile-picture avatar-lg mb-2"
                                        src="https://parastarbank.com/storage/photos/main/subscription.png" alt="">
                                    <p class="m-0 text-24">{{ $active_license->name }}</p>
                                    <p class="text-muted m-0">زمان فعال سازی:
                                        {{ $Persian->MyPersianDate($active_license->created_at, true) }}</p>
                                    <p class="text-muted m-0">تاریخ اتمام:
                                        {{ $Persian->MyPersianDate($active_license->expire, true) }}</p>
                                    <p class="text-success m-0">وضعیت: فعال </p>
                                </div>

                            </div>
                            <div class="mt-4 float-right">

                            </div>
                        </form>

                    </div>
                @endforeach
                @if (!$active_lic)
                    <div id="one_month_package" class="card-body d-none">
                        <form action="{{ route('dashboard') }}" method="POST">
                            @csrf
                            <div class="user-profile mb-4">
                                <div class="ul-widget-card__user-info">
                                    <img class="profile-picture avatar-lg mb-2"
                                        src="https://parastarbank.com/storage/photos/main/subscription.png" alt="">
                                    <p class="m-0 text-24"> فعال سازی بسته ۱ ماهه</p>
                                    <p class="text-muted m-0">ویژه درمانگران - پرستاران</p>
                                    <span class="badge badge-pill badge-success p-2 m-1">یک ماهه</span>
                                    <span onclick="change_package('#one_month_package','#three_month_package')"
                                        class="badge badge-pill badge-primary p-2 m-1 ">سه ماهه</span>
                                    <span onclick="change_package('#one_month_package','#one_year_package')"
                                        class="badge badge-pill badge-primary p-2 m-1">یک ساله</span>

                                    <div class="ul-product-detail__features mt-3">
                                        <h6 class=" font-weight-700">قابلیت ها:</h6>
                                        <ul class="m-0 p-0">
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">ثبت رزومه در پرستاربانک</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">مشاهده گزارشات مشتریان</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">صدور کارت هویت آنلاین اختصاصی</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">نمایش آگهی های شغلی و درخواست خدمات</span>
                                            </li>
                                        </ul>
                                        <div class="ul-product-detail__price-and-rating  align-items-baseline">
                                            <span class="text-mute font-weight-800 mr-2"><del>۲۰۰،۰۰۰ تومان</del></span>
                                            <small class="text-success font-weight-700">33% به مناسبت عضویت اول</small>
                                            <h3 class="font-weight-700 text-primary mb-0 mr-2">۱۰۰،۰۰۰ تومان</h3>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="mt-4 float-right">
                                <button type="submit" name="buy_package" value="1"
                                    class="btn btn-primary ul-btn-raised--v2  m-1 ">خرید و فعال سازی</button>
                            </div>
                        </form>

                    </div>
                    <div id="three_month_package" class="card-body">
                        <form action="{{ route('dashboard') }}" method="POST">
                            @csrf
                            <div class="user-profile mb-4">
                                <div class="ul-widget-card__user-info">
                                    <img class="profile-picture avatar-lg mb-2"
                                        src="https://parastarbank.com/storage/photos/main/subscription.png" alt="">
                                    <p class="m-0 text-24"> فعال سازی بسته 3 ماهه</p>
                                    <p class="text-muted m-0">ویژه درمانگران - پرستاران</p>
                                    <span onclick="change_package('#three_month_package','#one_month_package')"
                                        class="badge badge-pill badge-primary p-2 m-1">یک ماهه</span>
                                    <span class="badge badge-pill badge-success p-2 m-1 ">سه ماهه</span>
                                    <span onclick="change_package('#three_month_package','#one_year_package')"
                                        class="badge badge-pill badge-primary p-2 m-1">یک ساله</span>

                                    <div class="ul-product-detail__features mt-3">
                                        <h6 class=" font-weight-700">قابلیت ها:</h6>
                                        <ul class="m-0 p-0">
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">ثبت رزومه در پرستاربانک</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">مشاهده گزارشات مشتریان</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">صدور کارت هویت آنلاین اختصاصی</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">نمایش آگهی های شغلی و درخواست خدمات</span>
                                            </li>
                                        </ul>
                                        <div class="ul-product-detail__price-and-rating  align-items-baseline">
                                            <span class="text-mute font-weight-800 mr-2"><del>۶۰۰،۰۰۰ تومان</del></span>
                                            <small class="text-success font-weight-700">55% به مناسبت عضویت اول</small>
                                            <h3 class="font-weight-700 text-primary mb-0 mr-2">۲۰۰،۰۰۰ تومان</h3>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="mt-4 float-right">
                                <button type="submit" name="buy_package" value="2"
                                    class="btn btn-primary ul-btn-raised--v2  m-1 ">خرید و فعال سازی</button>
                            </div>
                        </form>

                    </div>
                    <div id="one_year_package" class="card-body d-none">
                        <form action="{{ route('dashboard') }}" method="POST">
                            @csrf
                            <div class="user-profile mb-4">
                                <div class="ul-widget-card__user-info">
                                    <img class="profile-picture avatar-lg mb-2"
                                        src="https://parastarbank.com/storage/photos/main/subscription.png"
                                        alt="">
                                    <p class="m-0 text-24"> فعال سازی بسته یک ساله</p>
                                    <p class="text-muted m-0">ویژه درمانگران - پرستاران</p>
                                    <span onclick="change_package('#one_year_package','#one_month_package')"
                                        class="badge badge-pill badge-primary p-2 m-1">یک ماهه</span>
                                    <span onclick="change_package('#one_year_package','#three_month_package')"
                                        class="badge badge-pill badge-primary p-2 m-1 ">سه ماهه</span>
                                    <span class="badge badge-pill badge-success p-2 m-1">یک ساله</span>

                                    <div class="ul-product-detail__features mt-3">
                                        <h6 class=" font-weight-700">قابلیت ها:</h6>
                                        <ul class="m-0 p-0">
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">ثبت رزومه در پرستاربانک</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">مشاهده گزارشات مشتریان</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">صدور کارت هویت آنلاین اختصاصی</span>
                                            </li>
                                            <li>
                                                <i class="i-Left1 text-primary text-15 align-middle font-weight-700"> </i>
                                                <span class="align-middle">نمایش آگهی های شغلی و درخواست خدمات</span>
                                            </li>
                                        </ul>
                                        <div class="ul-product-detail__price-and-rating  align-items-baseline">
                                            <span class="text-mute font-weight-800 mr-2"><del>۳۰۰،۰۰۰ تومان</del></span>
                                            <small class="text-success font-weight-700">61% به مناسبت عضویت اول</small>
                                            <h3 class="font-weight-700 text-primary mb-0 mr-2">۷۰۰،۰۰۰ تومان</h3>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="mt-4 float-right">
                                <button type="submit" name="buy_package" value="3"
                                    class="btn btn-primary ul-btn-raised--v2  m-1 ">خرید و فعال سازی</button>
                            </div>
                        </form>

                    </div>
                @endif
            </div>
        </div>
        <script>
            function change_package(pakage_src, pakage_name) {
                $(pakage_src).addClass('d-none');
                $(pakage_name).removeClass('d-none');


            }
        </script>


        <div style="display: grid" class="col-lg-5 col-xl-5 mt-3  ">
            <div class="card"
                style="
            border-color: cadetblue;
            border-width: 3px;
            border-style: groove;
        ">
                <div class="card-body">
                    <div class="user-profile mb-4">
                        <div class="ul-widget-card__user-info">
                            <p class="m-0 text-24">نظرات دیگران </p>
                            <p class="text-muted m-0">در یک نگاه</p>
                        </div>

                    </div>
                    @php
                        $max_weight = 1;
                    @endphp
                    @foreach ($worker_class->get_worker_hiring_skills(Auth::id()) as $index_item)
                        @if ($index_item->Weight > $max_weight)
                            @php
                                $max_weight = $index_item->Weight;
                            @endphp
                        @endif
                    @endforeach
                    @php
                        $count = 0;
                    @endphp

                    @foreach ($worker_class->get_worker_hiring_skills(Auth::id()) as $index_item)
                        @php
                            $percent = ($index_item->Weight / $max_weight) * 100;
                            $count++;
                        @endphp
                        <div class="ul-widget-card__progress-rate">
                            <span>{{ $index_item->Name }}</span>
                            <span class="">{{ $index_item->Weight }}</span>
                        </div>
                        @if ($index_item->L2ID == 1)
                            <div class="progress progress--height  mb-3">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $percent }}%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="{{ $max_weight }}"></div>
                            </div>
                        @else
                            <div class="progress progress--height mb-3">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{ $percent }}%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="{{ $max_weight }}"></div>
                            </div>
                        @endif
                    @endforeach
                    @if ($count == 0)
                        <div style="text-align: center">
                            <img src="https://parastarbank.com/storage/photos/main/no-data.png" alt="no-data">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80 d-float">
                    <h3 style="display: contents" class="w-50 float-left card-title m-0 text-white"><i
                            class="header-icon i-Notepad"></i> گزارشات
                        ثبت
                        شده اخیر</h3>
                </div>

                <div class="">
                    <div class="table-responsive">
                        <table id="user_table" class="table  text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">نام</th>
                                    <th scope="col">امتیاز</th>
                                    <th scope="col">تاریخ ثبت</th>
                                    <th scope="col">وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($worker_class->get_worker_comments(3) as $comment_item)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $comment_item->id }}</th>
                                        @if ($comment_item->show_info)
                                            <td>{{ $comment_item->cname }} {{ $comment_item->cfamily }} </td>
                                        @else
                                            <td>کاربر سامانه</td>
                                        @endif
                                        <td>
                                            @switch($comment_item->rate)
                                                @case(1)
                                                    <p class="text-danger">خیلی بد</p>
                                                @break

                                                @case(2)
                                                    <p class="text-warning"> بد</p>
                                                @break

                                                @case(3)
                                                    <p class="text-info">متوسط</p>
                                                @break

                                                @case(4)
                                                    <p class="text-success">خوب</p>
                                                @break

                                                @case(5)
                                                    <p class="text-success">خیلی خوب</p>
                                                @break

                                                @default
                                            @endswitch

                                        </td>
                                        <td>{{ $Persian->MyPersianDate($comment_item->created_at) }}</td>
                                        <td><span class="badge badge-success">تائید شده</span></td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        @if ($count == 0)
                            <div style="text-align: center">
                                <img src="https://parastarbank.com/storage/photos/main/no-data.png" alt="no-data">
                            </div>
                        @endif
                    </div>
                </div>
            </div>


        </div>
        <div class="col-md-6">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80 d-float">
                    <h3 style="display: contents" class="w-50 float-left card-title m-0 text-white "><i
                            class="header-icon i-Professor"></i> آخرین
                        استعلامهای گرفته شده</h3>
                </div>

                <div class="">
                    <div class="table-responsive">
                        <table id="user_table" class="table  text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">نام</th>
                                    <th scope="col">امتیاز</th>
                                    <th scope="col">تاریخ ثبت</th>
                                    <th scope="col">وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($worker_class->get_worker_comments() as $comment_item)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $comment_item->id }}</th>
                                        @if ($comment_item->show_info)
                                            <td>{{ $comment_item->cname }} {{ $comment_item->cfamily }} </td>
                                        @else
                                            <td>کاربر سامانه</td>
                                        @endif
                                        <td>
                                            @switch($comment_item->rate)
                                                @case(1)
                                                    <p class="text-danger">خیلی بد</p>
                                                @break

                                                @case(2)
                                                    <p class="text-warning"> بد</p>
                                                @break

                                                @case(3)
                                                    <p class="text-info">متوسط</p>
                                                @break

                                                @case(4)
                                                    <p class="text-success">خوب</p>
                                                @break

                                                @case(5)
                                                    <p class="text-success">خیلی خوب</p>
                                                @break

                                                @default
                                            @endswitch

                                        </td>
                                        <td>{{ $Persian->MyPersianDate($comment_item->created_at) }}</td>
                                        <td><span class="badge badge-success">تائید شده</span></td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($count == 0)
                            <div style="text-align: center">
                                <img src="https://parastarbank.com/storage/photos/main/no-data.png" alt="no-data">
                            </div>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('page-js')
@endsection

@section('bottom-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
@endsection
