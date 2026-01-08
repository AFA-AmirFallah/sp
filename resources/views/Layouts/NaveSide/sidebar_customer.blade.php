<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li id="Dashboard" class="nav-item {{ request()->is('Dashboard/*') ? 'active' : '' }}">
                <a id="Dashboard_text" class="nav-item-hold" href="{{ Route('home') }}">
                    <i class="sidebar-icon-style nav-icon i-Home1"></i>
                    <span class="nav-text">خانه</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('AdminTools/*') ? 'active' : '' }}">
            <li class="nav-item {{ request()->is('uikits/*') ? 'active' : '' }}" data-item="wallet">
                <a class="nav-item-hold" href="#">
                    <i class="sidebar-icon-style nav-icon i-Wallet-21"></i>
                    <span class="nav-text">{{ __('My wallet') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('dashboard/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('tikets') }}">
                    <i class="sidebar-icon-style nav-icon i-Ticket"></i>
                    <span class="nav-text">{{ __('Tikets') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('AdminTools/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('UserProfile') }}">
                    <i class="sidebar-icon-style nav-icon i-Checked-User"></i>
                    <span class="nav-text">{{ __('Your info') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            @if ( App\myappenv::Lic['affiliate'] ?? false)
                <li class="nav-item ">
                    <a class="nav-item-hold" href="{{ route('affiliate') }}">
                        <i class="sidebar-icon-style nav-icon i-Handshake"></i>
                        <span class="nav-text">همکاری</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="TransferOperations">
            <li class="nav-item ">
                <a href="">
                    <i class="sidebar-icon-style nav-icon i-Hospital1"></i>
                    <span class="item-name">{{ __('My services') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="">
                    <i class="sidebar-icon-style nav-icon i-Notepad"></i>
                    <span class="item-name">{{ __('My orders') }}</span>
                </a>
            </li>
        </ul>
        <ul class="childNav" data-parent="wallet">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName() == 'dashboard_version_1' ? 'open' : '' }}"
                    href="{{ route('DirectPay') }}">
                    <i class="sidebar-icon-style nav-icon i-Money-2"></i>
                    <span class="item-name">{{ __('Add credite') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('Invoice') }}">
                    <i class="sidebar-icon-style nav-icon i-Billing"></i>
                    <span class="item-name">{{ __('My bills') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('MyTransfersReport') }}">
                    <i class="sidebar-icon-style nav-icon i-Refresh"></i>
                    <span class="item-name">{{ __('My transaction') }}</span>
                </a>
            </li>

        </ul>

    </div>
    <div class="sidebar-overlay"></div>
</div>
