@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .label_red {
            color: red;
        }
    </style>
    <form action="{{ route('dashboard') }}" method="POST">
        @csrf

        <section class="ul-pricing-table">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5>خرید اشتراک <span class="text-danger">مشاهده این صفحه نیاز به اشتراک دارد</span> </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-xl-3">
                                    <div class="ul-pricing__table-1 mb-4">
                                        <div class="ul-pricing__image card-icon-bg-primary">
                                            <i class="i-Gift-Box"></i>
                                        </div>
                                        <div class="ul-pricing__title">
                                            <h2 class="heading text-primary">رایگان</h2>
                                        </div>
                                        <div class="ul-pricing__text text-mute">همیشگی</div>
                                        <div class="ul-pricing__main-number">
                                            <h3 style="font-size: 30px"
                                                class="heading display-3 text-primary t-font-boldest">۰
                                                تومان</h3>
                                        </div>
                                        <div class="ul-pricing__list">
                                            <p> ثبت و نگهداری اطلاعات هویتی شما </p>
                                            <p> صدور کارت پرستاربانک</p>
                                            <p> قابلیت استعلام گیری از شما</p>
                                        </div>
                                        <button type="button" disabled
                                            class="btn btn-lg btn-success btn-rounded m-1">فعال</button>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <div class="ul-pricing__table-1">
                                        <div class="ul-pricing__image card-icon-bg-primary">
                                            <i class="i-Bicycle1"></i>
                                        </div>
                                        <div class="ul-pricing__title">
                                            <h2 class="heading text-primary">درمانگر - پرستار</h2>
                                        </div>
                                        <div class="ul-pricing__text text-mute">۱ماه</div>
                                        <div class="ul-pricing__main-number">
                                            <h3 style="font-size: 30px"
                                                class="heading display-3 text-primary t-font-boldest">
                                                ۱۰۰ هزار تومان</h3>
                                        </div>
                                        <div class="ul-pricing__list">
                                            <p> مشاهده گزارشات ثبت شده</p>
                                            <p> مشاهده استعلامهای شما</p>
                                            <p> مشاهده آگهی های کاری</p>
                                        </div>
                                        <button type="submit" name="buy_package" value="1" class="btn btn-primary m-1 btn-rounded text-18">

                                            خرید </button>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <div class="ul-pricing__table-1">
                                        <div class="ul-pricing__image card-icon-bg-primary">
                                            <i class="i-Scooter"></i>
                                        </div>
                                        <div class="ul-pricing__title">
                                            <h2 class="heading text-primary">درمانگر - پرستار</h2>
                                        </div>
                                        <div class="ul-pricing__text text-mute">۳ ماهه</div>
                                        <div class="ul-pricing__main-number">
                                            <h3 style="font-size: 30px"
                                                class="heading display-3 text-primary t-font-boldest">
                                                ۲۰۰ هزار تومان</h3>
                                        </div>
                                        <div class="ul-pricing__list">
                                            <p> مشاهده گزارشات ثبت شده</p>
                                            <p> مشاهده استعلامهای شما</p>
                                            <p> مشاهده آگهی های کاری</p>
                                        </div>
                                        <button type="submit" name="buy_package" value="2" class="btn btn-lg btn-primary btn-rounded m-1">خرید</button>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xl-3">
                                    <div class="ul-pricing__table-1">
                                        <div class="ul-pricing__image card-icon-bg-primary">
                                            <i class="i-Car-2"></i>
                                        </div>
                                        <div class="ul-pricing__title">
                                            <h2 class="heading text-primary">درمانگر - پرستار</h2>
                                        </div>
                                        <div class="ul-pricing__text text-mute">۱ ساله</div>
                                        <div class="ul-pricing__main-number">
                                            <h3 style="font-size: 30px"
                                                class="heading display-3 text-primary t-font-boldest">
                                                ۷۰۰ هزار تومان</h3>
                                        </div>
                                        <div class="ul-pricing__list">
                                            <p> مشاهده گزارشات ثبت شده</p>
                                            <p> مشاهده استعلامهای شما</p>
                                            <p> مشاهده آگهی های کاری</p>
                                        </div>
                                        <button type="submit" name="buy_package" value="3" class="btn btn-lg btn-primary btn-rounded m-1">خرید</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>
    </form>
@endsection
@section('page-js')
@endsection
