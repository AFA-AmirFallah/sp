<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            @if (\App\myappenv::Lic['desk'])
                <li id="dashboard" class="nav-item" data-item="DashboardWorks">
                    <a id="dashboard_text" class="nav-item-hold" href="{{ Route('dashboard') }}">
                        <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                        <span class="nav-text">{{ __('Dashboard') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @else
                <li id="dashboard" class="nav-item">
                    <a id="dashboard_text" class="nav-item-hold" href="{{ Route('dashboard') }}">
                        <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                        <span class="nav-text">{{ __('Dashboard') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            @if (\App\myappenv::Lic['auto'] ?? false)
                <li id="dashboard" class="nav-item">
                    <a id="dashboard_text" class="nav-item-hold" href="{{ Route('auto_admin') }}">
                        <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                        <span class="nav-text">اتوماسیون</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            <li id="userworks" title="{{ __('user management add delete edite') }}" class="nav-item"
                data-item="userworks">
                <a id="userworks_text" class="nav-item-hold" href="">
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
            @if (\App\myappenv::Lic['hiring'])
                <li class="nav-item ">
                    <a class="nav-item-hold" href="{{ route('hiring_dashboard') }}">
                        <i class="sidebar-icon-style nav-icon i-Nurse "></i>
                        <span class="nav-text"> پرستاربانک</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            @if (\App\myappenv::Lic['crawler'])
                <li class="nav-item ">
                    <a class="nav-item-hold" href="{{ route('competitor') }}">
                        <i class="sidebar-icon-style nav-icon i-Alien"></i>
                        <span class="nav-text"> بررسی رقبا</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            @if (\App\myappenv::Lic['Voip'])
                <li class="nav-item ">
                    <a class="nav-item-hold" href="{{ route('voip_main') }}">
                        <i class="sidebar-icon-style nav-icon i-Old-Telephone"></i>
                        <span class="nav-text">ویپ</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            @if (\App\myappenv::Lic['deal'])
                <li class="nav-item ">
                    <a class="nav-item-hold" href="{{ route('add_statistic') }}">
                        <i class="sidebar-icon-style nav-icon i-Bar-Chart-2"></i>
                        <span class="nav-text">آمار</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            @if (\App\myappenv::Lic['deal'])
                <li class="nav-item ">
                    <a class="nav-item-hold" href="{{ route('add_file') }}">
                        <i class="sidebar-icon-style nav-icon i-Car"></i>
                        <span class="nav-text"> معاملات</span>
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

            @if (\App\myappenv::Lic['woocommerce'])
                <li class="nav-item " data-item="Woocommerce">
                    <a class="nav-item-hold" href="#">
                        <i class="sidebar-icon-style nav-icon i-Receipt-3"></i>
                        <span class="nav-text">فروشگاه</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif

            @if (\App\myappenv::Lic['crypto'])
                <li class="nav-item " data-item="crypto">
                    <a class="nav-item-hold" href="#">
                        <i class="sidebar-icon-style nav-icon i-Bitcoin"></i>
                        <span class="nav-text">رمز ارز</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
            @if (\App\myappenv::Lic['news'])
                <li class="nav-item ">
                    <a class="nav-item-hold" href="{{ route('NewsList') }}">
                        <i class="sidebar-icon-style nav-icon i-Receipt-3"></i>
                        <span class="nav-text">خبر</span>
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
        @if (\App\myappenv::Lic['HCIS'])
            <ul class="childNav" data-parent="patiantworks">
                <li class="nav-item "><a id="patiant_dashboard" href="{{ Route('patdashboard') }}"> <i
                            class="sidebar-icon-style nav-icon i-Dashboard"></i>داشبورد بیماران</a></li>
                <li class="nav-item "><a id="patiant_order" href="{{ Route('Order') }}"> <i
                            class="sidebar-icon-style nav-icon i-Add-File"></i> {{ __('Register Order') }}</a></li>
                <li class="nav-item "><a id="patiant_shift_done" href="{{ Route('PatShiftDone') }}"><i
                            class="sidebar-icon-style nav-icon i-Check"></i> {{ __('Jobs done') }}</a></li>
                <li class="nav-item "><a id="patiant_order_list" href="{{ Route('OrderList') }}"><i
                            class="sidebar-icon-style nav-icon i-Receipt-3"></i> {{ __('Order list') }}</a></li>
            </ul>
        @endif
        @if (\App\myappenv::Lic['desk'])
            <ul class="childNav" data-parent="DashboardWorks">
                <li class="nav-item ">
                    <a href="{{ Route('dashboard') }}">
                        <i class="sidebar-icon-style nav-icon i-Bar-Chart"></i>
                        <span class="item-name">داشبورد</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ Route('Desk') }}">
                        <i class="sidebar-icon-style nav-icon i-Check"></i>
                        <span class="item-name">میز کار</span>
                    </a>
                </li>
            </ul>
        @endif
        <ul class="childNav" data-parent="userworks">

            <li class="nav-item ">
                <a id="user_list" href="{{ route('UserSearch') }}">
                    <i class="sidebar-icon-style nav-icon i-Business-Mens"></i>
                    <span class="item-name">{{ __('User list') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="notifications" href="{{ Route('notifications') }}">
                    <i class="sidebar-icon-style nav-icon i-Speach-Bubble-2"></i>
                    <span class="item-name"> نوتیفیکیشن</span>
                </a>

            </li>

        </ul>
        @if (\App\myappenv::Lic['crypto'])
            <ul class="childNav" data-parent="crypto">
                <li class="nav-item">
                    <a href="{{ route('CurencyList') }}">
                        <i class="sidebar-icon-style nav-icon  i-Euro "></i>
                        <span class="item-name"> لیست رمز ارز ها</span>
                    </a>
                    <a href="{{ route('ExDif') }}">
                        <i class="sidebar-icon-style nav-icon  i-Euro "></i>
                        <span class="item-name">اختلاف قیمت صرافی ها</span>
                    </a>



                    <hr>
                    <a href="{{ route('BTMGT', ['type' => 'system']) }}">
                        <i class="sidebar-icon-style nav-icon i-Gear "></i>
                        <span class="item-name">بک تست های فعال سامانه</span>
                    </a>
                    <a href="{{ route('BTMGT', ['type' => 'my']) }}">
                        <i class="sidebar-icon-style nav-icon i-Gear "></i>
                        <span class="item-name">بک تست های فعال من</span>
                    </a>

                </li>
            </ul>
        @endif
        @if (\App\myappenv::Lic['woocommerce'])
            <ul class="childNav" data-parent="Woocommerce">
                <li class="nav-item">
                    <a href="{{ route('cashier') }}">
                        <i class="sidebar-icon-style nav-icon  i-Cash-register-2 "></i>
                        <span class="item-name"> فروشگاه حضوری </span>
                    </a>
                    <a href="{{ route('StoreList') }}">
                        <i class="sidebar-icon-style nav-icon i-Shop"></i>
                        <span class="item-name">مدیریت فروشگاه</span>
                    </a>
                    <a href="{{ route('AddProduct') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">افزودن کالا</span>
                    </a>
                    <a href="{{ route('AddCampin') }}">
                        <i class="sidebar-icon-style nav-icon i-Gift-Box"></i>
                        <span class="item-name">افزودن کمپین</span>
                    </a>

                    <a href="{{ route('AddProduct', ['ProductType' => 'SpecialAccount']) }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">افزودن اکانت</span>
                    </a>
                    <a href="{{ route('CampinLsit') }}">
                        <i class="sidebar-icon-style nav-icon i-Gift-Box"></i>
                        <span class="item-name">مدیریت کمپین</span>
                    </a>
                    <a href="{{ route('ProductLsit') }}">
                        <i class="sidebar-icon-style nav-icon i-Data-Center"></i>
                        <span class="item-name">مدیریت کالا</span>
                    </a>
                    <a href="{{ route('ExamAdmin') }}">
                        <i class="sidebar-icon-style nav-icon i-Approved-Window"></i>
                        <span class="item-name">مدیریت آزمونها</span>
                    </a>

                    <hr>
                    <a href="{{ route('AddGoodToWarehouse') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">افزودن کالا به انبار</span>
                    </a>
                    <a href="{{ route('UnitManagement') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">مدیریت واحد ها</span>
                    </a>
                    <a href="{{ route('OpenOrders') }}">
                        <i class="sidebar-icon-style nav-icon i-Add-Window"></i>
                        <span class="item-name">سفارشات</span>
                    </a>
                    <a href="{{ route('FaildBuy') }}">
                        <i class="sidebar-icon-style nav-icon i-Post-Sign-2-ways"></i>
                        <span class="item-name">سفارشات ناموفق</span>
                    </a>
                    <a href="{{ route('BranchOrders') }}">
                        <i class="sidebar-icon-style nav-icon i-Post-Sign-2-ways"></i>
                        <span class="item-name">مدیریت غرفه دار</span>
                    </a>
                </li>
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
            @if (\App\myappenv::Lic['userlic'])
                <li class="nav-item dropdown-sidemenu">
                    <a>
                        <i class="nav-icon i-Diploma-2"></i>
                        <span class="item-name">مدیریت مجوز ها</span>
                        <i class="dd-arrow i-Arrow-Down"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('BannerManagement') }}">لیست مجوز ها</a></li>
                        <li><a href="{{ Route('AddLic') }}">افزودن مجوز</a></li>
                        <li><a href="{{ Route('PwaPostManagement') }}">لیست انواع مجوز ها</a></li>


                    </ul>
                </li>
            @endif
            @if (\App\myappenv::Lic['device'])
                <li class="nav-item dropdown-sidemenu">
                    <a>
                        <i class="nav-icon i-VPN"></i>
                        <span class="item-name">{{ __('devices') }}</span>
                        <i class="dd-arrow i-Arrow-Down"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('DeviceEditor') }}">{{ __('Edit devices') }}</a></li>
                        <li><a href="{{ Route('DeviceContractEditor') }}">{{ __('Edit Contracts') }}</a></li>
                    </ul>
                </li>
            @endif
            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-Coin"></i>
                    <span class="item-name">{{ __('Financial setting') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{ Route('FinancialIndex') }}">{{ __('Financial index') }}</a></li>
                    <li><a href="{{ Route('CreditModCreate') }}">مدیریت کیف پول</a></li>
                    <li><a href="{{ Route('BankCreate') }}">افزودن بانک</a></li>
                    <li><a href="{{ Route('TashimMgt') }}">مدیرت تسهیم</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('tiketsetting') }}">
                    <i class="sidebar-icon-style nav-icon i-Ticket"></i>
                    <span class="item-name">{{ __('Ticket management') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ThemeMgt') }}">
                    <i class="sidebar-icon-style nav-icon i-Dry"></i>
                    <span class="item-name">شخصی سازی تم</span>
                </a>
            </li>
            <li class="nav-item dropdown-sidemenu">
                <a>
                    <i class="nav-icon i-Gear"></i>
                    <span class="item-name">{{ __('System setting') }}</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{ Route('MainSetting') }}">تنظیمات عمومی</a></li>
                    @if (\App\myappenv::Lic['MultiBranch'])
                        <li><a href="{{ Route('BranchSetting') }}">تنظیمات شعب</a></li>
                    @endif
                    <li><a href="{{ Route('FinancialSetting') }}">{{ __('Financial Setting') }}</a></li>
                    <li><a href="{{ Route('PatientSetting') }}">{{ __('Customers settings') }}</a></li>
                    @if (\App\myappenv::Apptype == 'owner')
                        <li><a id="ManageIndex" href="{{ Route('ManageIndex') }}">{{ __('Smart index') }}</a>
                        </li>
                        <li><a href="{{ Route('systemsetting') }}">تنظیمات پیشرفته</a></li>
                        @if (\App\myappenv::Lic['crawler'])
                            <li><a href="{{ Route('MainCrawler') }}">کرال ها</a></li>
                        @endif
                    @endif
                </ul>
            </li>


            @if (\App\myappenv::Lic['wpa'])
                <li class="nav-item dropdown-sidemenu">
                    <a>
                        <i class="nav-icon i-Cloud-Smartphone"></i>
                        <span class="item-name">{{ __('WPA setting') }}</span>
                        <i class="dd-arrow i-Arrow-Down"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('BannerManagement') }}">{{ __('banner management') }}</a></li>
                        <li><a href="{{ Route('IconManagement') }}">مدیریت آیکنها</a></li>
                        <li><a href="{{ Route('PwaPostManagement') }}">مدیریت پست ها</a></li>
                        <li><a href="{{ Route('BoxIcon3x') }}">آیکون باکس ۳X</a></li>
                        <li><a href="{{ Route('IconBoxManagement') }}">مدیریت آیکن باکس</a></li>
                        <li><a href="{{ Route('PosterManagement') }}">مدیریت پوستر ها</a></li>
                        <li><a href="{{ Route('PosterManagement4X') }}">مدیریت پوستر ها4X</a></li>
                        <li><a href="{{ Route('PosterManagementscroll') }}">مدیریت پوستر اسکرول</a></li>
                        <li><a href="{{ Route('TitrManagement') }}">مدیریت تیترها</a></li>
                        <li><a href="{{ Route('Layer2Index') }}">مدیریت دسته بندی لایه ۲</a></li>
                        <li><a href="{{ Route('IndexListManagementAdvnace') }}">مدیریت نمایش شاخص ها</a></li>

                    </ul>
                </li>
            @endif


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
                @if (\App\myappenv::Lic['TavanPardakht'])
                    <ul class="submenu">
                        <li><a href="{{ Route('TavanPardakht') }}">استعلام توان پرداخت</a></li>
                    </ul>
                @endif
            </li>

        </ul>


    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
