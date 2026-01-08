@php
$User = new \App\Users\UserClass();
@endphp
@if (\App\myappenv::MainOwner == 'sepehrmall')
    <div>
        <style>
            .icontext {
                color: #fff;
            }

            .icondiv {
                color: #fff;
                margin-bottom: -7px;
            }
        </style>

        <div style="z-index:110; margin-right:0px; padding-left: 0px;padding-right:0px;text-align:center;border: 0px; bottom:0px; "
            class="navtop_pwa140011 main-header col-md-12 col-sm-12 col-xs-12">
            <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                <a href="{{ url('/') }}">
                    <i style="color: #336666" class="pwa_nav_Icon i-Home1"></i>
                    <div style="color: #336666;font-size: 12px;" class="icontext">
                        خانه
                    </div>

                </a>

            </div>

            <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                <a href="{{ route('ProductCats') }}">
                    <i style="color: #336666" class="pwa_nav_Icon i-Windows-Microsoft"></i>

                    <div style="color: #336666;font-size: 12px;" class="icontext">
                        دسته بندی
                    </div>
                </a>


            </div>
            <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                <a href="{{ route('checkout') }}">
                    <i style="color: #336666 ;font-size: 25px;" class="pwa_nav_Icon i-Full-Cart">
                        @if (\App\Http\Controllers\woocommerce\buy::BasketItems() != null)
                            <div id="basketnumber" class="basketnumber">
                                {{ \App\Http\Controllers\woocommerce\buy::BasketItems() }}</div>
                        @else
                            <div id="basketnumber" class="basketnumber nested"></div>
                        @endif
                    </i>

                    <div style="color: #336666;font-size: 12px;" class="icontext">
                        سبد خرید
                    </div>
                </a>

            </div>
            <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                @if (Auth::check())
                    <a href="{{ route('MyAccount') }}">
                        <i style="color: #336666" class="pwa_nav_Icon i-Administrator"></i>
                        <div style="color: #336666;font-size: 12px;" class="icontext">
                            پروفایل
                        </div>

                    </a>
                @else
                    <a href="{{ route('login') }}">
                        <i style="color: #336666" class="pwa_nav_Icon i-Password-shopping"></i>
                        <div style="color: #336666;font-size: 12px;" class="icontext">
                            ورود
                        </div>
                    </a>
                @endif


            </div>
        </div>
        <!-- header top menu end -->
    @elseif(\App\myappenv::SiteTheme == 'kookbaz')
        <div class="mobile-nav-top">
            <div class="nav-top-top">
                <div class="top-top-continer">
                    <div class="top-nav-right">
                        <img src="{{ asset('assets/images/favicon/KookbazwhiteLogo.png') }}" alt="kookbaz_white_logo"
                            class="nav-top-top">
                        <div id="search_icon_deactive" onclick="search_Click(0)" class="top-search-continer">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                                <path
                                    d="M15.7364 2.32233C14.2767 1.08547 12.336 0.404297 10.2717 0.404297C8.20747 0.404297 6.26674 1.08547 4.80709 2.32233C3.34744 3.55916 2.54352 5.20364 2.54352 6.95276C2.54352 8.55196 3.21585 10.0634 4.4466 11.2561L0.154617 14.8929C-0.0515391 15.0676 -0.0515391 15.3508 0.154617 15.5255C0.257695 15.6129 0.392801 15.6566 0.527871 15.6566C0.662941 15.6566 0.798082 15.6129 0.901125 15.5255L5.19314 11.8887C6.60069 12.9316 8.38445 13.5013 10.2717 13.5013C12.336 13.5013 14.2767 12.8201 15.7364 11.5833C17.196 10.3464 17.9999 8.70195 17.9999 6.95279C17.9999 5.20364 17.1961 3.55916 15.7364 2.32233ZM14.9899 10.9507C12.3883 13.1551 8.15526 13.1551 5.55367 10.9507C2.9521 8.74624 2.9521 5.15937 5.55367 2.95494C6.85459 1.85261 8.5629 1.30162 10.2718 1.30162C11.9802 1.30162 13.6892 1.85287 14.9899 2.95494C17.5914 5.15934 17.5914 8.74621 14.9899 10.9507Z"
                                    fill="#29A0A8"></path>
                            </svg>
                        </div>
                        @include('Layouts.PWAObjects.PWASearch_kookbaz')



                    </div>
                    <div class="top-nav-left">
                        <div style="width: 1.25rem;display: contents;"><svg style="width: 1.25rem;" class="mx-3 w-5 h-6"
                                width="26" height="32" viewBox="0 0 26 32" fill="none">
                                <path
                                    d="M19.6394 15.3013C19.2116 15.8406 18.7309 16.3384 18.1789 16.7878C21.3299 18.5971 23.4572 21.9988 23.4572 25.8886C23.4572 27.9904 18.857 29.6368 12.9843 29.6368C7.11166 29.6368 2.51138 27.9904 2.51138 25.8886C2.51138 21.9988 4.63868 18.5971 7.78971 16.7878C7.23775 16.3384 6.75711 15.8406 6.32922 15.3013C2.82018 17.5195 0.484375 21.4359 0.484375 25.8886C0.484375 27.2375 1.22217 29.1173 4.73725 30.4128C6.92985 31.221 9.85872 31.666 12.9844 31.666C16.11 31.666 19.0389 31.221 21.2315 30.4128C24.7465 29.1173 25.4844 27.2375 25.4844 25.8886C25.4842 21.4359 23.1484 17.5195 19.6394 15.3013Z"
                                    fill="white"></path>
                                <path
                                    d="M12.9769 16.639C16.9163 16.639 19.9498 12.8271 19.9498 8.31952C19.9498 3.80991 16.9148 0 12.9769 0C9.03744 0 6.00391 3.81192 6.00391 8.31946C6.00391 12.8291 9.03904 16.639 12.9769 16.639ZM12.9769 2.02912C15.704 2.02912 17.9228 4.85094 17.9228 8.31946C17.9228 11.788 15.704 14.6098 12.9769 14.6098C10.2497 14.6098 8.03091 11.788 8.03091 8.31946C8.03091 4.85094 10.2497 2.02912 12.9769 2.02912Z"
                                    fill="white"></path>
                            </svg>
                            @if (Auth::check())
                                <div style="padding-top: 6px;padding-right: 5px;" class="text-white text-xs"><a
                                        style="color: white" href="{{ route('MyAccount') }}">
                                        {{ Auth::user()->Name . ' ' . Auth::user()->Family }} </a>
                                @else
                                    <div style="padding-top: 6px;padding-right: 5px;" class="text-white text-xs"><a
                                            style="color: white" href="{{ route('login') }}"> ورود/ثبت نام</a>
                            @endif
                        </div>
                    </div>
                    <div style="background-color: #fff;width: 1px;margin-right: 6px;"></div>

                    <a href="{{ route('checkout') }}">
                        <a href="{{ route('checkout') }}" class="border-r border-white" aria-label="سبد خرید">
                            <svg style="width: 1.30rem;border-right-width:1px;" class="mx-3 w-5 h-6" width="33"
                                height="33" viewBox="0 0 33 33" fill="none">
                                <path
                                    d="M31.8659 10.3256H20.2798V3.78849C20.2798 1.69905 18.5801 0 16.4906 0C14.4018 0 12.7021 1.69905 12.7021 3.78849V10.3256H1.14014C0.600668 10.3256 0.164062 10.7623 0.164062 11.3017V16.7411C0.164062 17.2806 0.600668 17.7172 1.14014 17.7172H2.46633L3.28166 30.675C3.36365 31.979 4.45097 33 5.75763 33H27.2484C28.555 33 29.6424 31.979 29.7243 30.675L30.5397 17.7172H31.8659C32.4053 17.7172 32.8419 17.2806 32.8419 16.7411V11.3017C32.8419 10.7623 32.4053 10.3256 31.8659 10.3256ZM16.4906 1.95216C17.5038 1.95216 18.3276 2.776 18.3276 3.78849C18.3276 7.74836 18.3276 16.9365 18.3276 20.7203C17.1687 20.1977 15.8198 20.1977 14.6543 20.7307C14.6543 20.4708 14.6543 4.86698 14.6543 3.78855C14.6543 2.776 15.4781 1.95216 16.4906 1.95216ZM16.503 22.282C18.3421 22.282 19.5555 24.1993 18.787 25.8538C18.3875 26.7153 17.5136 27.3147 16.503 27.3147C15.1133 27.3147 13.9867 26.1835 13.9867 24.7983C13.9867 23.413 15.1131 22.282 16.503 22.282ZM2.11622 15.765V12.2778H12.7021C12.7021 14.2515 12.7021 13.7711 12.7021 15.765C11.5409 15.765 3.20451 15.765 2.11622 15.765ZM27.7761 30.5527C27.7585 30.8305 27.5269 31.0478 27.2484 31.0478H5.75763C5.47913 31.0478 5.24748 30.8305 5.22989 30.5527L4.423 17.7172H12.7021V22.4519C10.8731 25.3963 12.9957 29.2669 16.503 29.2669C18.9667 29.2669 20.9715 27.262 20.9715 24.7984C20.9715 23.9219 20.7177 23.1033 20.2798 22.4129V17.7173H28.5829L27.7761 30.5527ZM20.2798 15.765C20.2798 12.913 20.2798 14.2844 20.2798 12.2778H30.8898V15.765C29.8038 15.765 21.446 15.765 20.2798 15.765Z"
                                    fill="white"></path>
                            </svg></a>

                        @if (\App\Http\Controllers\woocommerce\buy::BasketItems() != null)
                            <div id="basket_on_top" class="basket_number_top_128 ">
                                {{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() }}</div>
                        @else
                            <div id="basket_on_top" class="basket_number_top_128 nested"></div>
                        @endif
                    </a>
                </div>
            </div>
        </div>
        <div class="nav-top-boton">
            <div class="menu-continer">
                <a class="menu-item" href="{{ url('/') }}">خانه</a>
                <a class="menu-item" href="{{ url('https://kookbaz.ir/RegisterForm/11') }}">فروشنده شوید</a>
                <a class="menu-item" href="{{ url('https://kookbaz.ir/RegisterForm/12') }}">خرید اقساطی</a>
                <a class="menu-item"
                    href="{{ url('https://kookbaz.ir/Product/348/%D8%A7%D8%B3%D9%86%D9%88%D8%A7%D8%8C%D8%AF%D9%88%D9%88') }}">اسنوا
                    - دوو </a>
                <a class="menu-item" href="{{ url('https://kookbaz.ir/Product?sort=expensive') }}">همه محصولات</a>
                <div onmouseover="ShowNested('CateguryContineer')" onmouseout="hideItem('CateguryContineer')"
                    class="sub_item_included">
                    <a class="menu-item">دسته بندی ها</a>
                    <div style="height: 13px"></div>
                    <div id="CateguryContineer" class="submenu_continer nested">
                        {!! App\Functions\Indexes::HTMLMenu('HTMLMenu') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div style="text-align: center">
            <div class="mobile-nave-down navtop_pwa main-header col-md-12 col-sm-12 col-xs-12 navbotom">
                <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                    <a href="{{ url('/') }}">
                        <i style="color: #fff" class="pwa_nav_Icon i-Home1"></i>
                        <div class="icontext">
                            خانه
                        </div>

                    </a>

                </div>

                <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                    <a href="{{ route('ProductCats') }}">
                        <i style="color: #fff" class="pwa_nav_Icon i-Windows-Microsoft"></i>

                        <div class="icontext">
                            دسته بندی
                        </div>
                    </a>


                </div>
                <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                    <a href="{{ route('checkout') }}">
                        <i style="color: #fff" class="pwa_nav_Icon i-Full-Cart">
                            @if (\App\Http\Controllers\woocommerce\buy::BasketItems() != null)
                                <div id="basketnumber" class="basketnumber">
                                    {{ \App\Http\Controllers\woocommerce\buy::BasketItems() }}</div>
                            @else
                                <div id="basketnumber" class="basketnumber nested"></div>
                            @endif
                        </i>

                        <div class="icontext">
                            سبد خرید
                        </div>
                    </a>

                </div>
                <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
                    @if (Auth::check())
                        <a href="{{ route('MyAccount') }}">
                            <i style="color: #fff" class="pwa_nav_Icon i-Administrator"></i>
                            <div class="icontext">
                                مشخصات من
                            </div>

                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <img style="width: 16px" src="{{ asset('assets/images/loginimg.png') }}" alt="login">

                            <div class="icontext">
                                ورود
                            </div>
                        </a>
                    @endif


                </div>
            </div>

        </div>
    </div>
    <script>
        function search_Click($state) {
            if ($state == 1) {
                $('#search_input').addClass('nested');
                $('#search_icon_active').addClass('nested');
                $('#search_icon_deactive').removeClass('nested');

            } else {
                $('#search_input').removeClass('nested');
                $('#search_icon_active').removeClass('nested');
                $('#search_icon_deactive').addClass('nested');

            }

        }


        function ActiveL1($L1Item) {
            $('.menu_items').addClass('nested');
            $('.cat_' + $L1Item).removeClass('nested');
        }
    </script>
@else
    <div>
        <style>
            .icontext {
                color: #fff;
            }

            .icondiv {
                color: #fff;
                margin-bottom: -7px;
            }
        </style>
        @if (App\myappenv::MainOwner == 'Carpetour')
            <div style="z-index:110; margin-right:4px; padding-left: 0px;padding-right:0px;text-align:center;background: linear-gradient(90deg, #bb2922, #283a80) !important;color: #fff;border: 0px; bottom:6px; "
                class="navtop_pwa main-header col-md-12 col-sm-12 col-xs-12">
            @else
                <div style="z-index:110; margin-right:4px; padding-left: 0px;padding-right:0px;text-align:center;background: linear-gradient(90deg, #0072ff, #4ed199);color: #fff;border: 0px; bottom:6px; "
                    class="navtop_pwa main-header col-md-12 col-sm-12 col-xs-12">
        @endif
        <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
            <a href="{{ url('/') }}">
                <i style="color: #fff" class="pwa_nav_Icon i-Home1"></i>
                <div class="icontext">
                    خانه
                </div>

            </a>

        </div>

        <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
            <a href="{{ route('ProductCats') }}">
                <i style="color: #fff" class="pwa_nav_Icon i-Windows-Microsoft"></i>

                <div class="icontext">
                    دسته بندی
                </div>
            </a>


        </div>
        <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
            <a href="{{ route('checkout') }}">
                <i style="color: #fff" class="pwa_nav_Icon i-Full-Cart">
                    @if (\App\Http\Controllers\woocommerce\buy::BasketItems() != null)
                        <div id="basketnumber" class="basketnumber">
                            {{ \App\Http\Controllers\woocommerce\buy::BasketItems() }}</div>
                    @else
                        <div id="basketnumber" class="basketnumber nested"></div>
                    @endif
                </i>

                <div class="icontext">
                    سبد خرید
                </div>
            </a>

        </div>
        <div class="icondiv col-md-3 col-sm-3 col-xs-3 ">
            @if (Auth::check())
                <a href="{{ route('MyAccount') }}">
                    <i style="color: #fff" class="pwa_nav_Icon i-Administrator"></i>
                    <div class="icontext">
                        مشخصات من
                    </div>

                </a>
            @else
                <a href="{{ route('login') }}">
                    <img style="width: 16px" src="{{ asset('assets/images/loginimg.png') }}" alt="login">

                    <div class="icontext">
                        ورود
                    </div>
                </a>
            @endif


        </div>
    </div>
    <!-- header top menu end -->

@endif
<script>
    function ShowNested($ItemId) {
        $('#CateguryContineer').removeClass('nested');
    }

    function hideItem($ItemId) {
        $('#CateguryContineer').addClass('nested');
    }
</script>
