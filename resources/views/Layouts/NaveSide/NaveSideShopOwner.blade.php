<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li id="dashboard" class="nav-item">
                <a id="dashboard_text" class="nav-item-hold" href="{{ Route('dashboard') }}">
                    <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li id="userworks" title="{{ __('user management add delete edite') }}" class="nav-item">
                <a id="userworks_text" class="nav-item-hold" href="{{ route('UserSearch') }}">
                    <i class="sidebar-icon-style nav-icon i-Myspace"></i>
                    <span class="nav-text">{{ __('User works') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            @if (\App\myappenv::Lic['HCIS'])
                <li id="patiantworks" title="{{ __('user management add delete edite') }}" class="nav-item"
                    data-item="patiantworks">
                    <a id="patiantworks_text" class="nav-item-hold" href="">
                        <i class="sidebar-icon-style nav-icon i-Love-User"></i>
                        <span class="nav-text">{{ __('Pat works') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            <li id="Financials" class="nav-item" data-item="Financials">
                <a id="Financials_text" class="nav-item-hold" href="#">
                    <i class="sidebar-icon-style nav-icon i-Bar-Code"></i>
                    <span class="nav-text">{{ __('Financial works') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li id="setting" class="nav-item" data-item="AppConfig">
                <a id="setting_text" class="nav-item-hold" href="#">
                    <i class="sidebar-icon-style nav-icon i-Cloud-Smartphone"></i>
                    <span class="nav-text">{{ __('setting') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item">
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
        @if (\App\myappenv::Lic['HCIS'])
            <ul class="childNav" data-parent="patiantworks">
                <li class="nav-item "><a id="patiant_dashboard" href="{{ Route('patdashboard') }}"> <i
                            class="sidebar-icon-style nav-icon i-Dashboard"></i>داشبورد بیماران</a></li>
                <li class="nav-item "><a id="patiant_list" href="{{ Route('myPat') }}"> <i
                            class="sidebar-icon-style nav-icon i-Business-ManWoman"></i> {{ __('My pats') }}</a></li>
                <li class="nav-item "><a id="patiant_order" href="{{ Route('Order') }}"> <i
                            class="sidebar-icon-style nav-icon i-Add-File"></i> {{ __('Register Order') }}</a></li>
                <li class="nav-item "><a id="patiant_shift_done" href="{{ Route('PatShiftDone') }}"><i
                            class="sidebar-icon-style nav-icon i-Check"></i> {{ __('Jobs done') }}</a></li>
                <li class="nav-item "><a id="patiant_order_list" href="{{ Route('OrderList') }}"><i
                            class="sidebar-icon-style nav-icon i-Receipt-3"></i> {{ __('Order list') }}</a></li>
            </ul>
        @endif
        <ul class="childNav" data-parent="AppConfig">
            @if (\App\myappenv::Lic['Service'])
                <li class="nav-item ">
                    <a id="Services_mgt" href="{{ route('ServiceList') }}">
                        <i class="sidebar-icon-style nav-icon i-File-Clipboard-Text--Image"></i>
                        <span class="item-name">{{ __('Services') }}</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a id="req_mgt" href="{{ route('CatOrderList') }}">
                        <i class="sidebar-icon-style nav-icon i-Aim"></i>
                        <span class="item-name">درخواست</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a id="form_mgt" href="{{ route('FormsList') }}">
                        <i class="sidebar-icon-style nav-icon i-File"></i>
                        <span class="item-name">فرم ها</span>
                    </a>
                </li>
            @endif

            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-Coin"></i>
                    <span class="item-name">{{ __('Financial setting') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a id="FinancialIndex" href="{{ Route('FinancialIndex') }}">{{ __('Financial index') }}</a>
                    </li>
                    <li><a href="{{ Route('BankCreate') }}">افزودن بانک</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_3' ? 'open' : '' }}"
                    href="{{ route('tiketsetting') }}">
                    <i class="sidebar-icon-style nav-icon i-Ticket"></i>
                    <span class="item-name">{{ __('Ticket management') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-Gear"></i>
                    <span class="item-name">{{ __('System setting') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{ Route('BranchSetting') }}">تنظیمات عمومی</a></li>
                    <li><a href="{{ Route('FinancialSetting') }}">{{ __('Financial Setting') }}</a></li>
                    <li><a href="{{ Route('PatientSetting') }}">{{ __('Customers settings') }}</a></li>
                </ul>
            </li>
        </ul>
        <ul class="childNav" data-parent="Financials">
            <li class="nav-item ">
                <a id="CrediteTransfer" href="{{ route('CrediteTransfer') }}">
                    <i class="sidebar-icon-style nav-icon i-Money-2"></i>
                    <span class="item-name">{{ __('Credit Transfer') }}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="{{ route('BankList') }}">
                    <i class="sidebar-icon-style nav-icon i-Money-Bag"></i>
                    <span class="item-name">بانک ها</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="{{ route('AsnadMali') }}">
                    <i class="sidebar-icon-style nav-icon i-Money-Bag"></i>
                    <span class="item-name">اسناد مالی</span>
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
                <a id="DirectPay" href="{{ route('DirectPay') }}"
                    class="{{ Route::currentRouteName() == 'dashboard_version_2' ? 'open' : '' }}">
                    <i class="sidebar-icon-style nav-icon i-Credit-Card-2"></i>
                    <span class="item-name">{{ __('Add credite') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="CahngeTransaction" href="{{ route('CahngeTransaction') }}">
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
                    <li><a href="{{ Route('Invoice') }}">{{ __('Invoices List') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a href="{{ Route('MakeInvoice') }}">{{ __('Create Invoice') }}</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-File-Pie"></i>
                    <span class="item-name">{{ __('Credit reports') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{ Route('IPGReport') }}">{{ __('Reports of ipg') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a href="{{ Route('MyTransfersReport') }}">{{ __('My transfers report') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a href="{{ Route('DaramadReport') }}">{{ __('Benefit report') }}</a></li>
                </ul>
                <ul class="submenu">
                    <li><a href="{{ Route('FinancialTotalReport') }}">{{ __('Total report') }}</a></li>
                </ul>
            </li>

        </ul>


    </div>
    <div class="sidebar-overlay"></div>
</div>
