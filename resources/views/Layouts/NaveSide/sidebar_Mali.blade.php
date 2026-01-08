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
            <li class="nav-item {{ request()->is('uikits/*') ? 'active' : '' }}" data-item="Financials">
                <a class="nav-item-hold" href="#">
                    <i class="sidebar-icon-style nav-icon i-Bar-Code"></i>
                    <span class="nav-text">{{ __('Financial works') }}</span>
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
            @if (\App\myappenv::Lic['TavanPardakht'])
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_1' ? 'open' : '' }}"
                    href="{{ route('TavanPardakht') }}">
                    <i class="sidebar-icon-style nav-icon i-Testimonal"></i>
                    <span class="item-name">استعلام توان پرداخت</span>
                </a>
            </li>
            @endif
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
                        href="{{ route('OpenOrders') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">سفارشات</span>
                    </a>
                    <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                    href="{{ route('BranchOrders') }}">
                    <i class="sidebar-icon-style nav-icon i-Post-Sign-2-ways"></i>
                    <span class="item-name">مدیریت غرفه دار</span>
                </a>
                </li>
            </ul>
        @endif
        <ul class="childNav" data-parent="Financials">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_1' ? 'open' : '' }}"
                    href="{{ route('CrediteTransfer') }}">
                    <i class="sidebar-icon-style nav-icon i-Money-Bag"></i>
                    <span class="item-name">{{ __('Credit Transfer') }}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_1' ? 'open' : '' }}"
                    href="{{ route('BankList') }}">
                    <i class="sidebar-icon-style nav-icon i-Money-Bag"></i>
                    <span class="item-name">بانک ها</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_1' ? 'open' : '' }}"
                    href="{{ route('AsnadMali') }}">
                    <i class="sidebar-icon-style nav-icon i-Money-Bag"></i>
                    <span class="item-name">اسناد مالی</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('CrediteTransferConfirmserv') }}"
                    class="{{ Route::currentRouteName() == 'dashboard_version_2' ? 'open' : '' }}">
                    <i class="sidebar-icon-style nav-icon i-Device-Sync-with-Cloud"></i>
                    <span class="item-name">{{ __('Transfer service request') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('CrediteTransferConfirm') }}"
                    class="{{ Route::currentRouteName() == 'dashboard_version_2' ? 'open' : '' }}">
                    <i class="sidebar-icon-style nav-icon i-Cool-Guy"></i>
                    <span class="item-name">{{ __('Transfer request') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="AccountConfirm" href="{{ route('AccountConfirm') }}"
                    class="{{ Route::currentRouteName() == 'dashboard_version_2' ? 'open' : '' }}">
                    <i class="sidebar-icon-style nav-icon i-File-Horizontal-Text"></i>
                    <span class="item-name">{{ __('Accounts oprations') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="DirectPay" href="{{route('DirectPay')}}" class="{{ Route::currentRouteName() == 'dashboard_version_2' ? 'open' : '' }}">
                    <i class="sidebar-icon-style nav-icon i-Credit-Card-2"></i>
                    <span class="item-name">{{ __('Add credite') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="CahngeTransaction" href="{{ route('CahngeTransaction') }}"
                    class="{{ Route::currentRouteName() == 'dashboard_version_2' ? 'open' : '' }}">
                    <i class="sidebar-icon-style nav-icon i-Credit-Card-2"></i>
                    <span class="item-name">تغییر وضعیت تراکنش</span>
                </a>
            </li>
            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-Billing"></i>
                    <span class="item-name">{{ __('Invoices') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a class="{{ Route::currentRouteName() == 'apexAreaCharts' ? 'open' : '' }}"
                            href="{{ Route('Invoice') }}">{{ __('Invoices List') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a class="{{ Route::currentRouteName() == 'apexAreaCharts' ? 'open' : '' }}"
                            href="{{ Route('MakeInvoice') }}">{{ __('Create Invoice') }}</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-File-Pie"></i>
                    <span class="item-name">{{ __('Credit reports') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a class="{{ Route::currentRouteName() == 'apexAreaCharts' ? 'open' : '' }}"
                            href="{{ Route('IPGReport') }}">{{ __('Reports of ipg') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a class="{{ Route::currentRouteName() == 'apexAreaCharts' ? 'open' : '' }}"
                            href="{{ Route('MyTransfersReport') }}">{{ __('My transfers report') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a class="{{ Route::currentRouteName() == 'apexAreaCharts' ? 'open' : '' }}"
                            href="{{ Route('DaramadReport') }}">{{ __('Benefit report') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a class="{{ Route::currentRouteName() == 'apexAreaCharts' ? 'open' : '' }}"
                            href="{{ Route('FinancialTotalReport') }}">{{ __('Total report') }}</a></li>
                </ul>
                @if (\App\myappenv::Lic['TavanPardakht'])
                    <ul class="submenu">
                        <li><a class="{{ Route::currentRouteName() == 'apexAreaCharts' ? 'open' : '' }}"
                                href="{{ Route('TavanPardakht') }}">استعلام توان پرداخت</a></li>
                    </ul>
                @endif
            </li>

        </ul>



    </div>
    <div class="sidebar-overlay"></div>
</div>
