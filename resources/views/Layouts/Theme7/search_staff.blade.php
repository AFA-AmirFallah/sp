@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Layouts.Theme7.layout.main_layout')
@section('content')
    <div class="page-content bg-white">
        <!-- inner page banner -->
        <div class="dez-bnr-inr overlay-black-middle" style="background-image:url(images/banner/bnr1.jpg);">
            <div class="container">
                <div class="dez-bnr-inr-entry">
                    <h1 class="text-white">جستجوی درمانگر - پرستار</h1>
                    <!-- Breadcrumb row -->
                    <div class="breadcrumb-row">
                        <ul class="list-inline">
                            <li><a href="{{ route('home') }}">خانه</a></li>
                            <li>جستجوی درمانگر - پرستار</li>
                        </ul>
                    </div>
                    <!-- Breadcrumb row END -->
                </div>
            </div>
        </div>
        <!-- inner page banner END -->
        <!-- Filters Search -->
        
        <div class="section-full browse-job-find">
            <div class="container">
                <div class="find-job-bx">
                    @include('Layouts.Theme7.layout.searchbar')  
                </div>
            </div>
        </div>
        @if ($type == 'add_success')
            <div id="save_result" class="success_box container text-center">
                <img class="success_box" src="/Theme7/images/success.png" alt="success">
                <h1>
                    ثبت موفق
                </h1>
                <p>با تشکر از شما! </p>
                <p>در صورت تمایل به همکاری درمانگر - پرستار معرفی شده با پرستاربانک، احراز هویت انجام شده و نتیجه به
                    اطلاع
                    شما خواهد رسید.</p>
            </div>
        @endif

        <!-- Filters Search END -->
        @if ($type == 'result')
            @php
                $count = 0;
            @endphp
            @foreach ($search_result as $search_result_item)
                @php
                    $count++;
                @endphp
                <div class="content-block">
                    <div class="section-full bg-white browse-job p-b50">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <ul class="post-job-bx">
                                        <li>
                                            <div class="post-bx">
                                                <div class="d-flex m-b30">
                                                    <div class="job-post-company">
                                                        <a
                                                            href="{{ route('report_staff', ['code' => $search_result_item->Ext]) }}"><span>
                                                                <img alt=""
                                                                    src="{{ $search_result_item->avatar ?? App\myappenv::LoginUserAvatarPic }}">
                                                            </span></a>
                                                    </div>
                                                    <div class="job-post-info">
                                                        <h4><a
                                                                href="{{ route('report_staff', ['code' => $search_result_item->Ext]) }}">{{ $search_result_item->Name }}
                                                                {{ $search_result_item->Family }} </a></h4>
                                                        <ul>
                                                            <li><i class="fa fa-map-marker"></i>
                                                                {{ App\geometric\locations::get_provinces_by_id($search_result_item->province) }}
                                                                ,
                                                                {{ App\geometric\locations::get_city_by_id($search_result_item->city) }}
                                                            </li>
                                                            <li><i class="fa fa-user"></i>کد پرستاربانک:
                                                                {{ $search_result_item->Ext }} </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="job-time mr-auto">
                                                        @if ($search_result_item->Status == 0)
                                                            <a href="javascript:void(0);"><span style="color: white"
                                                                    class="bg-danger">بدون مشخصات </span></a>
                                                            <a href="javascript:void(0);"><span style="color: white"
                                                                    class="bg-danger">بدون گزارشی </span></a>
                                                        @endif
                                                        @if (Auth::check())
                                                            <a href="{{ route('report_staff', ['code' => $search_result_item->Ext]) }}"
                                                                class="site-button btn-block">مشاهده استعلام</a>
                                                        @else
                                                            <a href="{{ route('report_staff', ['code' => $search_result_item->Ext]) }}"
                                                                class="site-button btn-block">ورود به سامانه و مشاهده
                                                                استعلام</a>
                                                        @endif


                                                    </div>

                                                    @if ($search_result_item->Status == 0)
                                                        <div class="salary-bx">
                                                            <span>در انتظار تکمیل اطلاعات</span>
                                                        </div>
                                                    @else
                                                        <div class="salary-bx">
                                                            <span>استعلام 49,000 تومان</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <label class="like-btn">
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($count == 0)
                @isset($mobile)
                    <div class="content-block">
                        <div class="section-full bg-white browse-job p-b50">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">

                                        <ul class="post-job-bx">
                                            <li>
                                                <div class="post-bx">
                                                    <div class="d-flex m-b30">
                                                        <div class="job-post-company">
                                                            <i class="fa fa-exclamation-circle"
                                                                style="font-size:60px;color:red"></i>

                                                        </div>
                                                        <div class="job-post-info">
                                                            <h4>متاسفانه اطلاعاتی در خصوص فرد استعلام شده در سامانه وجود ندارد!
                                                            </h4>
                                                            <ul>
                                                                <li>جهت بهبود سامانه لطفا اطلاعات فرد مورد جستجو را در اختیار ما
                                                                    قرار دهید

                                                                </li>
                                                                <li>کارشناسان ما پس از احراز هویت فرد مورد نظر اطلاعات درخواستی
                                                                    را در اختیار شما قرار خواهند داد.
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <form method="POST">
                                                        @csrf
                                                        <div class="d-flex">
                                                            <div class="job-time mr-auto d-flex ">
                                                                <label for="staff_name">نام و نام خانوادگی درمانگر یا پرستار:
                                                                </label>
                                                                <input type="text" required name="staff_name"
                                                                    placeholder="نام درمانگر - پرستار" class="form-control">
                                                            </div>
                                                            <div class="salary-bx">
                                                                <button name="add_user" value="{{ $mobile }}"
                                                                    class="btn btn-success">ثبت</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="content-block">
                        <div class="section-full bg-white browse-job p-b50">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <ul class="post-job-bx">
                                            <li>
                                                <div class="post-bx">
                                                    <div class="d-flex m-b30">
                                                        <div class="job-post-company">
                                                            <i class="fa fa-exclamation-circle"
                                                                style="font-size:60px;color:red"></i>

                                                        </div>
                                                        <div class="job-post-info">
                                                            <h4>کد پرستاربانک وارد شده در سامانه موجود نیست </h4>
                                                            <ul>
                                                                <li>میتوانید از روش جستجو با شماره موبایل استفاده کنید
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            @endif
        @endif

    </div>
@endsection
