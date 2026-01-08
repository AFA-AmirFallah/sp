<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{request()->is('dashboard')  || request()->is('/')  ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{Route('home')}}">
                    <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li title="{{__("user management add delete edite")}}"
                class="nav-item  {{ request()->is('myPat') ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{Route('myPat')}}">
                    <i class="sidebar-icon-style nav-icon i-Myspace"></i>
                    <span class="nav-text">{{__('My pats')}}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('uikits/*') ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{route('MyTransfersReport')}}">
                    <i class="sidebar-icon-style nav-icon i-Bar-Code"></i>
                    <span class="nav-text">امور مالی</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('dashboard/*') ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{route('tikets')}}">
                    <i class="sidebar-icon-style nav-icon i-Ticket"></i>
                    <span class="nav-text">{{ __('Tikets') }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('AdminTools/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('UserProfile')}}">
                    <i class="sidebar-icon-style nav-icon i-Checked-User"></i>
                    <span class="nav-text">{{ __("Your info") }}</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="userworks">
            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-File-Clipboard-Text--Image"></i>
                    <span class="item-name">{{ __('Pat works') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a class="{{ Route::currentRouteName()=='apexAreaCharts' ? 'open' : '' }}"
                           href="{{Route('myPat')}}">{{__('My pats')}}</a></li>
                    <li><a class="{{ Route::currentRouteName()=='apexAreaCharts' ? 'open' : '' }}"
                           href="{{Route('Order')}}">{{__("Register Order")}}</a></li>
                    <li><a class="{{ Route::currentRouteName()=='apexAreaCharts' ? 'open' : '' }}"
                           href="{{Route('PatShiftDone')}}">{{__("Jobs done")}}</a></li>
               </ul>
            </li>

            <li class="nav-item">

        </ul>
        <ul class="childNav" data-parent="Financials">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='dashboard_version_1' ? 'open' : '' }}"
                   href="{{route('MyTransfersReport')}}">
                    <i class="sidebar-icon-style nav-icon i-Dollar-Sign"></i>
                    <span class="item-name">{{__("My transfers report")}}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
