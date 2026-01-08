@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Layouts.Theme7.layout.main_layout')
@section('content')
    <style>
        .table {
            display: table;
            width: 100%
        }

        .tr {
            display: table-row;
            text-align: center;
        }

        .td {
            display: table-cell;
            border: 1px solid #ccc;
            padding: 5px;

        }

        .th {
            background-color: #e1e7ff;
            display: table-cell;
            border: 1px solid #ccc;
            padding: 5px;
            font-weight: 600;
        }
    </style>

    <div class="page-content">
        <!-- inner page banner -->
        <div class="overlay-black-dark profile-edit p-t50 p-b20" style="background-image:url(images/banner/bnr1.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-7 candidate-info">
                        <div class="candidate-detail">
                            <div class="canditate-des text-center">
                                <a href="javascript:void(0);">
                                    <img alt="" src="{{ $user_src->avatar ?? App\myappenv::LoginUserAvatarPic }}">
                                </a>
                            </div>
                            <div class="text-white browse-job text-left">
                                <h4 class="m-b0">{{ $user_src->Name }} {{ $user_src->Family }}
                                </h4>
                                <p class="m-b15">{{ $user_src->extranote ?? 'زمینه کاری ثبت نشده' }}</p>
                                <ul class="clearfix">
                                    <li><i class="ti-location-pin"></i>
                                        {{ App\geometric\locations::get_provinces_by_id($user_src->province) }} ,
                                        {{ App\geometric\locations::get_city_by_id($user_src->city) }}</li>
                                    <li><i
                                            class="ti-mobile"></i>{{ substr($user_src->MobileNo, -3) }}****{{ substr($user_src->MobileNo, 0, 4) }}
                                    </li>
                                    <li><i class="ti-briefcase"></i>تحصیلات: @switch($user_src->Degree)
                                            @case(1)
                                                زیر دیپلم
                                            @break

                                            @case(2)
                                                دیپلم
                                            @break

                                            @case(3)
                                                فوق دیپلم
                                            @break

                                            @case(4)
                                                کارشناسی
                                            @break

                                            @case(5)
                                                کارشناسی ارشد
                                            @break

                                            @case(6)
                                                دکترای تخصصی
                                            @break

                                            @case(7)
                                                پزشکی
                                            @break

                                            @default
                                                نامشخص
                                        @endswitch
                                    </li>
                                    <li><i class="ti-email"></i>کد پرستاربانک: {{ $user_src->Ext }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- inner page banner END -->
        <!-- contact area -->
        <div class="content-block">
            <!-- Browse Jobs -->
            <div class="section-full browse-job content-inner-2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 m-b30">
                            <div class="sticky-top bg-white">
                                <div class="candidate-info onepage">
                                    <ul>
                                        <li><a class="scroll-bar nav-link" href="#key_skills_bx">
                                                <span>مهارت ها</span></a></li>
                                        <li><a class="scroll-bar nav-link" href="#indexes">
                                                <span>شاخص های ثبت شده</span></a></li>
                                        <li><a class="scroll-bar nav-link" href="#comments">
                                                <span>تجربیات دیگران</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if ($type == 'buy_page')
                            <div class="col-xl-9 col-lg-8 m-b30">
                                <div class="job-bx job-profile">
                                    <div class="job-bx-title clearfix">
                                        <h5 class="font-weight-700 pull-left text-uppercase">صفحه استعلام شخصی</h5>
                                        <a href="{{ route('home') }}"
                                            class="site-button right-arrow button-sm float-right">بازگشت</a>
                                    </div>
                                    <form method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>برای دسترسی به سوابق این کاربر می باید پرداخت انجام
                                                        دهید</label>
                                                    <p> پس از پرداخت رزومه و سوابق تا یک ماه برای شما قابل استفاده
                                                        است و اطلاعات ارائه شده به روز می باشد.</p>
                                                    <p>اطلاعات {{ $user_src->Name }} {{ $user_src->Family }} در پرستاربانک
                                                        شامل موارد ذیل می باشد: </p>
                                                    <ul class="list-check secondry">
                                                        <li>امتیاز</li>
                                                        <li>مهارت‌ها</li>
                                                        <li>شاخص های عملیاتی </li>
                                                        <li>نظرات و تجربیات سایرین</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 m-b10">
                                                <button name="submit" value="show_profile" class="site-button float-left">پرداخت و مشاهده</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if ($type == 'show_info')
                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
                                <div id="key_skills_bx" class="job-bx bg-white m-b30">
                                    <div class="d-flex">
                                        <h5 class="m-b15">مهارت ها</h5>
                                    </div>
                                    <div class="job-time mr-auto">
                                        @foreach ($worker->get_worker_exact_skills($user_src->UserName) as $skill)
                                            <a href="javascript:void(0);"><span>{{ $skill->Name }}</span></a>
                                        @endforeach
                                    </div>
                                </div>
                                <div id="indexes" class="job-bx table-job-bx bg-white m-b30">
                                    <div class="d-flex">
                                        <h5 class="m-b15">شاخص های ثبت شده</h5>
                                    </div>
                                    <p>شاخص های ثبت شده نظر دیگر افراد در خصوص {{ $user_src->Name }}
                                        {{ $user_src->Family }}
                                        است.</p>

                                    <div class="table">
                                        <div class="tr">
                                            <div class="th">شاخصه</div>
                                            <div class="th">تعداد گزارش</div>
                                        </div>
                                        @php
                                            $max_index = 1;
                                            foreach ($worker_skills as $worker_skills_item) {
                                                if ($worker_skills_item->Weight > $max_index) {
                                                    $max_index = $worker_skills_item->Weight;
                                                }
                                            }

                                        @endphp
                                        @foreach ($worker_skills as $worker_skills_item)
                                            @if ($worker_skills_item->L2ID == 1)
                                                @php
                                                    $percent = ($worker_skills_item->Weight / $max_index) * 100;
                                                @endphp
                                                <div class="tr">
                                                    <div class="td">{{ $worker_skills_item->Name }}</div>
                                                    <div class="td">
                                                        {{ $worker_skills_item->Weight }} نظر برابر با :
                                                        {{ $percent }}%

                                                        <div class="progress">
                                                            <div class="progress-bar bg-success"
                                                                style="width: {{ $percent }}%" role="progressbar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="tr">
                                                    <div class="td">{{ $worker_skills_item->Name }}</div>
                                                    <div class="td">
                                                        {{ $worker_skills_item->Weight }} نظر برابر با :
                                                        {{ $percent }}%

                                                        <div class="progress">
                                                            <div class="progress-bar bg-danger"
                                                                style="width: {{ $percent }}%" role="progressbar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <hr>

                                <div id="comments" class="job-bx bg-white m-b30">
                                    <h5 class="m-b10">تجربیات دیگران در خصوص {{ $user_src->Name }}
                                        {{ $user_src->Family }}
                                    </h5>
                                    <div class="list-row">
                                        @foreach ($comment_src as $comment_item)
                                            <div class="list-line">
                                                <div class="d-flex">
                                                    <h6 class="font-14 m-b5 "><i class="fa fa-user commented-user"></i>
                                                        @if ($comment_item->show_info)
                                                            {{ $comment_item->cname }} {{ $comment_item->cfamily }}
                                                        @else
                                                            نام کابر محفوظ
                                                        @endif
                                                    </h6>
                                                    <div
                                                        style="
                                                position: absolute;
                                                left: 56px;
                                            ">
                                                        <fieldset style="display: contents" class="rating good">
                                                            @for ($i = 0; $i < $comment_item->rate; $i++)
                                                                <label style="color: gold;margin: 0px;padding: 0px;"
                                                                    class="rating-stars"><i
                                                                        class="fa fa-star m-r5"></i></label>
                                                            @endfor
                                                        </fieldset>
                                                    </div>


                                                </div>
                                                <p class="m-b0">خدمت: {{ $comment_item->service }} </p>
                                                <p class="m-b0"> {{ $comment_item->comment }} </p>
                                                @if ($comment_item->recommend)
                                                    <ul class="list-check secondry">
                                                        <li>به دیگران توصیه میکنم</li>
                                                        @if ($comment_item->weight < 5)
                                                            <li>تجربه تائید شده</li>
                                                        @elseif ($comment_item->weight < 10)
                                                            <li>تجربه صحت سنجی شده و تائید شده</li>
                                                        @endif

                                                    </ul>
                                                @endif

                                            </div>
                                        @endforeach

                                    </div>
                                </div>


                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Browse Jobs END -->
        </div>

    </div>
@endsection
