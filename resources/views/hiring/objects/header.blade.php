<div class="row">
    <!-- ICON BG -->

    <div class=" col-lg-3 col-md-6 col-sm-6 ">
        <a href="{{ route('admin_experience_list') }}">
            <div
                class="navcard {{ request()->is('admin_experience_list') ? 'active-navcard' : 'navcard-main' }}  card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="{{ request()->is('admin_experience_list') ? 'color: white' : 'color: green' }}  "
                        class="i-Receipt"></i>
                    <div class="content">
                        <p class=" mt-2 mb-0 {{ request()->is('admin_experience_list') ? 'text-white' : 'text-primary' }} ">گزارشات</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class=" col-lg-3 col-md-6 col-sm-6 ">
        <a href="{{ route('hiring_skill_mgt') }}">
            <div
                class="navcard {{ request()->is('hiring_skill_mgt') ? 'active-navcard' : 'navcard-main' }}  card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="{{ request()->is('hiring_skill_mgt') ? 'color: white' : 'color: green' }}  "
                        class="i-Receipt"></i>
                    <div class="content">
                        <p class=" mt-2 mb-0 {{ request()->is('hiring_skill_mgt') ? 'text-white' : 'text-primary' }} ">مدیریت مهارت‌ها</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 ">
        <a href="{{route('hiring_confirmable')}}">
            <div class="navcard {{ request()->is('hiring_confirmable') ? 'active-navcard' : 'navcard-main' }}  card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="color: orange" class="i-Gears"></i>
                    <div class="content">
                        <p class="{{ request()->is('hiring_confirmable') ? 'text-white' : 'text-primary' }} mt-2 mb-0">کاربران در انتظار تائید</p>

                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 ">
        <a href="{{ Route('deal_search') }}">
            <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i style="color: green" class="i-Receipt-3"></i>
                    <div class="content">
                        <p class="text-primary mt-2 mb-0">لیست فایل‌ها</p>

                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
