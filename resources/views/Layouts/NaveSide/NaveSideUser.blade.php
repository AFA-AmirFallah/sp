<div class="page-sidebar">
    <div class="sidebar custom-scrollbar">
        <ul class="sidebar-menu">
            <li><a class="sidebar-header" href="index.html"><i
                        data-feather="home"></i><span>{{__('Dashboard')}}</span></a></li>
            <li><a class="sidebar-header" href="#"><i data-feather="box"></i> <span>{{__('Register Order')}}</span><i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="#"><i class="fa fa-circle"></i>
                            <span>{{__('Register patiant service')}}</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="category.html"><i class="fa fa-circle"></i>{{__('Add new service')}}</a></li>
                            <li><a href="category-sub.html"><i class="fa fa-circle"></i>{{__('show all services')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-circle"></i>
                            <span>{{__('Register patiant devices')}}</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="category-digital.html"><i class="fa fa-circle"></i>{{__('Add new order')}}</a>
                            </li>
                            <li><a href="category-digitalsub.html"><i class="fa fa-circle"></i>{{__('show all order')}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a class="sidebar-header" href="default.htm"><i
                        data-feather="dollar-sign"></i><span>{{__('Financial works')}}</span><i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="category-digital.html"><i class="fa fa-circle"></i>{{__('Acconts works')}}</a></li>
                    <li><a href="category-digitalsub.html"><i class="fa fa-circle"></i>{{__('Transfer request')}}</a></li>
                    <li><a href="category-digitalsub.html"><i class="fa fa-circle"></i>{{__('Invoice works')}}</a></li>
                </ul>
            </li>
            <li><a class="sidebar-header" href="default.htm"><i
                        data-feather="dollar-sign"></i><span>{{__('Financial report')}}</span><i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="category-digital.html"><i class="fa fa-circle"></i>{{__('Transfer Report')}}</a></li>
                    <li><a href="category-digitalsub.html"><i class="fa fa-circle"></i>{{__('Transfer request')}}</a></li>
                    <li><a href="category-digitalsub.html"><i class="fa fa-circle"></i>{{__('Invoice works')}}</a></li>
                </ul>
            </li>
            <li><a class="sidebar-header" href="{{Route('myPat')}}"><i
                        data-feather="users"></i><span>{{__('My pats')}}</span><i
                        class="fa fa-angle-left pull-right"></i></a>
            </li>
            <li><a class="sidebar-header" href="default.htm"><i
                        data-feather="user-plus"></i><span>{{__('User works')}}</span><i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="{{route('UserSearch')}}"><i class="fa fa-circle"></i>{{__('User list')}}</a></li>
                    <li><a href="{{route('CreateUser')}}"><i class="fa fa-circle"></i>{{__('User add')}}</a></li>
                </ul>
            </li>
            <li><a class="sidebar-header" href="default.htm"><i
                        data-feather="users"></i><span>فروشندگان</span><i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="list-vendor.html"><i class="fa fa-circle"></i>لیست فروشندگان</a></li>
                    <li><a href="create-vendors.html"><i class="fa fa-circle"></i>ایجاد فروشنده</a></li>
                </ul>
            </li>
            <li><a class="sidebar-header" href="default.htm"><i data-feather="chrome"></i><span>محلی
                                    سازی</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="translations.html"><i class="fa fa-circle"></i>ترجمه</a></li>
                    <li><a href="currency-rates.html"><i class="fa fa-circle"></i>واحد پول</a></li>
                    <li><a href="taxes.html"><i class="fa fa-circle"></i>مالیات</a></li>
                </ul>
            </li>
            <li><a class="sidebar-header" href="reports.html"><i
                        data-feather="bar-chart"></i><span>گزارش</span></a></li>
            <li><a class="sidebar-header" href="default.htm"><i
                        data-feather="settings"></i><span>تنظیمات</span><i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li><a href="profile.html"><i class="fa fa-circle"></i>پروفایل</a></li>
                </ul>
            </li>
            <li><a class="sidebar-header" href="invoice.html"><i
                        data-feather="archive"></i><span>فاکتور</span></a>
            </li>
            <li><a class="sidebar-header" href="login.html"><i data-feather="log-in"></i><span>ورود / ثبت
                                    نام</span></a>
            </li>
        </ul>
    </div>
</div>
