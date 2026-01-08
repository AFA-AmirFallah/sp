<style>
    .active-navcard i {
        color: white !important;
    }
</style>
@php
    if (!isset($type)) {
        $type = null;
    }

@endphp

<div id="worker_nav_top">
    <div>
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/">
                        <div
                            class="navcard {{ (request()->is('dashboard') || request()->is('/')) && $type == null ? 'active-navcard' : 'navcard-main' }}  card card-icon mb-4 ">
                            <div class="card-body text-center"><i class="i-Bar-Chart"></i>
                                <p class="mt-2 mb-2">داشبورد</p>
                            </div>
                        </div>
                    </a></div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/myPat">
                        <div
                            class="navcard {{ request()->is('myPat') ? 'active-navcard' : 'navcard-main' }} card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Diploma"></i>
                                <p class="mt-2 mb-2">بیماران</p>
                            </div>
                        </div>
                    </a></div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/?action=add_costumer">
                        <div
                            class="navcard {{ $type == 'add_costumer' ? 'active-navcard' : 'navcard-main' }}  card card-icon mb-4 ">
                            <div class="card-body text-center"><i class="i-Bar-Chart-4"></i>
                                <p class="mt-2 mb-2">معرفی مشتری</p>
                            </div>
                        </div>
                    </a></div>

                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/?action=my_costumer">
                        <div
                            class="navcard {{ $type == 'my_costumer' ? 'active-navcard' : 'navcard-main' }}  card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Full-Basket"></i>
                                <p class="mt-2 mb-2">مشتریان من</p>
                            </div>
                        </div>
                    </a></div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/Order">
                        <div
                            class="navcard {{ request()->is('Order') ? 'active-navcard' : 'navcard-main' }}  card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Full-Basket"></i>
                                <p class="mt-2 mb-2">ثبت درخواست</p>
                            </div>
                        </div>
                    </a></div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/DirectPay">
                        <div
                            class="navcard {{ request()->is('DirectPay') ? 'active-navcard' : 'navcard-main' }}  card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Credit-Card-2"></i>
                                <p class="mt-2 mb-2">افزایش موجودی</p>
                            </div>
                        </div>
                    </a></div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/?action=my_experts">
                        <div
                            class="navcard {{ $type == 'my_experts' ? 'active-navcard' : 'navcard-main' }} card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Fluorescent"></i>
                                <p class="mt-2 mb-2">مهارت‌ها</p>
                            </div>
                        </div>
                    </a></div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-6"><a href="/UserProfile">
                        <div
                            class="navcard {{ request()->is('UserProfile') ? 'active-navcard' : 'navcard-main' }} card card-icon mb-4">
                            <div class="card-body text-center"><i class="i-Love-User"></i>
                                <p class="mt-2 mb-2">پروفایل</p>
                            </div>
                        </div>
                    </a></div>
            </div>
        </div>
    </div>
</div>
