<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('Dashboard/') || request()->is('/') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ Route('home') }}">
                    <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('worker_experience_list/')  ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ Route('worker_experience_list') }}">
                    <i class="sidebar-icon-style nav-icon i-Speak-2"></i>
                    <span class="nav-text">گزارشات من</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('worker_experience_listdd/')  ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ Route('worker_experience_list') }}">
                    <i class="sidebar-icon-style nav-icon i-Double-Tap"></i>
                    <span class="nav-text">استعلامهای من</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('requestes/')  ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ Route('home') }}">
                    <i class="sidebar-icon-style nav-icon i-Megaphone"></i>
                    <span class="nav-text">آگهی ها</span>
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
            <li class="nav-item {{ request()->is('UserProfile') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('UserProfile') }}">
                    <i class="sidebar-icon-style nav-icon i-Checked-User"></i>
                    <span class="nav-text">{{ __('Your info') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>

    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
