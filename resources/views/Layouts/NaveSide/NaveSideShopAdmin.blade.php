<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('Dashboard/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ Route('dashboard') }}">
                    <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li title="{{ __('user management add delete edite') }}"
                class="nav-item {{ request()->is('userworks/*') ? 'active' : '' }}" data-item="userworks">
                <a class="nav-item-hold" href="">
                    <i class="sidebar-icon-style nav-icon i-Myspace"></i>
                    <span class="nav-text">{{ __('User works') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            @if (\App\myappenv::Lic['woocommerce'])
                <li class="nav-item {{ request()->is('dashboard/*') ? 'active' : '' }}" data-item="Woocommerce">
                    <a class="nav-item-hold" href="#">
                        <i class="sidebar-icon-style nav-icon i-Receipt-3"></i>
                        <span class="nav-text">فروشگاه</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            

            <li class="nav-item {{ request()->is('AdminTools/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('UserProfile', ['RequestUser' => Auth::id()]) }}">
                    <i class="sidebar-icon-style nav-icon i-Checked-User"></i>
                    <span class="nav-text">{{ __('Your info') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="userworks">
            @if (\App\myappenv::Lic['HCIS'])
                @cannot('shopadmin')
                    <li class="nav-item dropdown-sidemenu">
                        <a>
                            <i class="nav-icon i-File-Clipboard-Text--Image"></i>
                            <span class="item-name">{{ __('Pat works') }}</span>
                            <i class="dd-arrow i-Arrow-Down"></i>
                        </a>
                        <ul class="submenu">
                            @cannot('shopadmin')
                                <li><a href="{{ Route('myPat') }}">{{ __('My pats') }}</a></li>
                                <li><a href="{{ Route('Order') }}">{{ __('Register Order') }}</a></li>
                                <li><a href="{{ Route('PatShiftDone') }}">{{ __('Jobs done') }}</a></li>
                                <li><a href="{{ Route('OrderList') }}">{{ __('Order list') }}</a></li>
                            @endcannot()


                        </ul>
                    </li>
                @endcannot
            @endif
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_1' ? 'open' : '' }}"
                    href="{{ route('UserSearch') }}">
                    <i class="sidebar-icon-style nav-icon i-Testimonal"></i>
                    <span class="item-name">{{ __('User list') }}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_1' ? 'open' : '' }}"
                    href="{{ route('CreateUser') }}">
                    <i class="sidebar-icon-style nav-icon i-Testimonal"></i>
                    <span class="item-name">{{ __('User add') }}</span>
                </a>
            </li>

            @cannot('shopadmin')
                <li class="nav-item">
                    <a href="{{ Route('notifications') }}">
                        <i class="sidebar-icon-style nav-icon i-Testimonal"></i>
                        <span class="item-name"> نوتیفیکیشن</span>
                    </a>

                </li>
            @endcannot

        </ul>
        @if (\App\myappenv::Lic['woocommerce'])
            <ul class="childNav" data-parent="Woocommerce">
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('cashier') }}">
                        <i class="sidebar-icon-style nav-icon  i-Cash-register-2 "></i>
                        <span class="item-name"> فروشگاه حضوری </span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('StoreList') }}">
                        <i class="sidebar-icon-style nav-icon i-Shop"></i>
                        <span class="item-name">مدیریت فروشگاه</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('AddCampin') }}">
                        <i class="sidebar-icon-style nav-icon i-Gift-Box"></i>
                        <span class="item-name">افزودن کمپین</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('AddProduct') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">افزودن کالا</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('CampinLsit') }}">
                        <i class="sidebar-icon-style nav-icon i-Gift-Box"></i>
                        <span class="item-name">مدیریت کمپین</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('ProductLsit') }}">
                        <i class="sidebar-icon-style nav-icon i-Data-Center"></i>
                        <span class="item-name">مدیریت کالا</span>
                    </a>
                    <hr>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('AddGoodToWarehouse') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">افزودن کالا به انبار</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('OpenOrders') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">سفارشات</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                        href="{{ route('FaildBuy') }}">
                        <i class="sidebar-icon-style nav-icon i-Post-Sign-2-ways"></i>
                        <span class="item-name">سفارشات ناموفق</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                    href="{{ route('BranchOrders') }}">
                    <i class="sidebar-icon-style nav-icon i-Post-Sign-2-ways"></i>
                    <span class="item-name">مدیریت غرفه دار</span>
                </a>
                </li>
            </ul>
        @endif



    </div>
    <div class="sidebar-overlay"></div>
</div>
