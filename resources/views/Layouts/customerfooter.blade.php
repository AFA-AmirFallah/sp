@if (\App\myappenv::SiteTheme == 'kookbaz')
    <div class="footer-footer-continer">
        <hr class="footer-hr">
        <div class="footer-continer">
            <div class="footer-continer main">
                <div class="footer-nav-right">
                    <img src="{{ asset('assets/images/kookbaz_second_logo.png') }}" alt="kookbaz_white_logo" class="footer-kookbaaz2">
                </div>

                <div class="footer-nav-text right">
                    <h4 class="footer-nav-text main">کوکباز</h4>
                    <a class="footer-nav-text main" href="https://blog.kookbaz.ir/%d8%af%d8%b1%d8%a8%d8%a7%d8%b1%d9%87-%da%a9%d9%88%da%a9%d8%a8%d8%a7%d8%b2/">درباره ما</a>
                    <a class="footer-nav-text main" href="https://blog.kookbaz.ir/%d8%aa%d9%85%d8%a7%d8%b3-%d8%a8%d8%a7-%da%a9%d9%88%da%a9%d8%a8%d8%a7%d8%b2/">تماس با ما</a>
                    <a class="footer-nav-text main" href="https://blog.kookbaz.ir/">اهداف و چشم انداز</a>
                    <a class="footer-nav-text main" href="https://blog.kookbaz.ir/">اخبار کوکباز</a>
                </div>
                <div class="footer-nav-text center-right">
                    <h4 class="footer-nav-text main">راهنمای کاربران</h4>
                    <a class="footer-nav-text main" href="https://blog.kookbaz.ir/%d8%af%d8%b1%d8%ae%d9%88%d8%a7%d8%b3%d8%aa-%d8%ba%d8%b1%d9%81%d9%87-%d8%af%d8%a7%d8%b1%db%8c/"> راهنمای ایجاد غرفه</a>
                    <a class="footer-nav-text main" href="">سوالات متدوال</a>
                    <a class="footer-nav-text main" href="https://blog.kookbaz.ir/privacy/">قوانین و مقررات</a>
                    <a class="footer-nav-text main" href="https://blog.kookbaz.ir/order/">رویه ارسال و مرجوعی کالا</a>
                </div>


                <div class="footer-nav-text center-left">
                    <h4 class="footer-nav-text main">تماس با ما</h4>
                    <a class="footer-nav-text main" href=""> تلفن : 28111119-021</a>
                    <a class="footer-nav-text main" href="">آدرس: تهران </a>
                    <a class="footer-nav-text main" href="">وب سایت: kookbaz.ir</a>

                    <div class="footer-nav-svg">
                       <a href="https://www.instagram.com/kookbaz/"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">

                            <rect width="30" height="30" fill="url(#pattern0)" />



                            <defs>
                                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_3340_5" transform="scale(0.0078125)" />
                                </pattern>
                                <image id="image0_3340_5" width="128" height="128"
                                    xlink:href="data:image/png;base64,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" />
                            </defs>

                        </svg></a>
                       <a href="https://api.whatsapp.com/send?phone=989054652921&text=%D8%B3%D9%84%D8%A7%D9%85%0A%D8%A8%D9%81%D8%B1%D9%85%D8%A7%DB%8C%DB%8C%D8%AF">
                        <svg width="29" height="30" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M20.5039 3.50391C18.2461 1.24609 15.2461 0 12.0508 0C5.46484 0 0.101562 5.35937 0.101562 11.9453C0.097656 14.0508 0.648438 16.1055 1.69531 17.918L0 24.1094L6.33594 22.4453C8.07813 23.3984 10.0469 23.8984 12.0469 23.9023H12.0508C18.6367 23.9023 23.9961 18.543 24 11.9531C24 8.76172 22.7578 5.76172 20.5039 3.50391ZM12.0508 21.8828H12.0469C10.2656 21.8828 8.51563 21.4023 6.99219 20.5L6.62891 20.2852L2.86719 21.2695L3.87109 17.6055L3.63672 17.2305C2.64063 15.6484 2.11719 13.8203 2.11719 11.9453C2.11719 6.47266 6.57422 2.01953 12.0547 2.01953C14.707 2.01953 17.1992 3.05469 19.0742 4.92969C20.9492 6.80859 21.9805 9.30078 21.9805 11.9531C21.9805 17.4297 17.5234 21.8828 12.0508 21.8828ZM17.4961 14.4453C17.1992 14.2969 15.7305 13.5742 15.457 13.4766C15.1836 13.375 14.9844 13.3281 14.7852 13.625C14.5859 13.9258 14.0156 14.5977 13.8398 14.7969C13.668 14.9922 13.4922 15.0195 13.1953 14.8711C12.8945 14.7227 11.9336 14.4062 10.793 13.3867C9.90625 12.5977 9.30469 11.6172 9.13281 11.3203C8.95703 11.0195 9.11328 10.8594 9.26172 10.7109C9.39844 10.5781 9.5625 10.3633 9.71094 10.1875C9.85938 10.0156 9.91016 9.89063 10.0117 9.69141C10.1094 9.49219 10.0586 9.31641 9.98438 9.16797C9.91016 9.01953 9.3125 7.54687 9.0625 6.94922C8.82031 6.36719 8.57422 6.44922 8.39062 6.4375C8.21875 6.42969 8.01953 6.42969 7.82031 6.42969C7.62109 6.42969 7.29688 6.50391 7.02344 6.80469C6.75 7.10156 5.98047 7.82422 5.98047 9.29297C5.98047 10.7617 7.05078 12.1836 7.19922 12.3828C7.34766 12.5781 9.30469 15.5937 12.3008 16.8867C13.0117 17.1953 13.5664 17.3789 14 17.5156C14.7148 17.7422 15.3672 17.7109 15.8828 17.6367C16.457 17.5508 17.6484 16.9141 17.8984 16.2148C18.1445 15.5195 18.1445 14.9219 18.0703 14.7969C17.9961 14.6719 17.7969 14.5977 17.4961 14.4453Z"
                                fill="#50CD5E" />
                        </svg></a>


                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_3342_37)">
                                <path
                                    d="M29.243 0.756941C28.5542 0.0678227 27.5506 -0.173524 26.6238 0.127237L1.78388 8.1893C0.809825 8.50547 0.132953 9.33415 0.0174063 10.352C-0.0981401 11.3701 0.375881 12.3296 1.25455 12.8561C1.31924 12.8949 1.38756 12.9273 1.4584 12.9529L8.89638 15.6424L8.90364 23.6633C8.90464 24.7164 9.54032 25.6412 10.5233 26.0192C11.4911 26.3945 12.5954 26.1424 13.3042 25.3558C13.3057 25.3541 13.3074 25.3523 13.3089 25.3506L15.8818 22.4715L20.2013 28.7781C20.728 29.6376 21.6964 30.0979 22.6817 29.9825C23.6996 29.8678 24.5287 29.1912 24.8455 28.2168C24.8593 28.1741 24.8707 28.1308 24.8796 28.0869L25.6682 24.1898C25.7965 23.5554 25.3864 22.9371 24.752 22.8088C24.1177 22.6803 23.4993 23.0906 23.371 23.725L22.6008 27.5312C22.5654 27.6028 22.5045 27.6439 22.4193 27.6535C22.3202 27.6644 22.2431 27.6266 22.1916 27.5404C22.1792 27.5196 22.1662 27.4993 22.1526 27.4794L17.3672 20.4928L24.235 7.7625C24.484 7.30102 24.3961 6.73032 24.0198 6.3651C23.6434 5.99995 23.0703 5.92911 22.6166 6.1919L9.9428 13.5285L2.40398 10.8026C2.35699 10.7543 2.33759 10.6919 2.34621 10.6164C2.35757 10.5162 2.41183 10.4496 2.5074 10.4186L27.3473 2.35654C27.4381 2.32725 27.518 2.34647 27.5854 2.41391C27.6533 2.48188 27.6727 2.56279 27.6429 2.65437C27.6291 2.69703 27.6177 2.74033 27.6088 2.78422L24.5244 18.0259C24.396 18.6602 24.8062 19.2785 25.4405 19.4068C26.0745 19.5355 26.6932 19.1251 26.8215 18.4907L29.8946 3.30529C30.1603 2.3985 29.9142 1.42848 29.243 0.756941ZM20.2054 10.2958L15.0051 19.9354L11.5641 23.7858C11.5379 23.8147 11.479 23.8757 11.3647 23.8317C11.2476 23.7866 11.2476 23.6986 11.2475 23.6611L11.2401 15.4857L20.2054 10.2958Z"
                                    fill="#00ABE1" />
                            </g>
                            <defs>
                                <clipPath id="clip0_3342_37">
                                    <rect width="30" height="30" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                       <a href="https://www.linkedin.com/company/kookbaz/"> <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.20358 24.7852H6.44577C5.79849 24.7852 5.2739 24.2606 5.2739 23.6133V12.7148C5.2739 12.0676 5.79849 11.543 6.44577 11.543H8.20358C8.85086 11.543 9.37546 12.0676 9.37546 12.7148V23.6133C9.37546 24.2606 8.85086 24.7852 8.20358 24.7852ZM9.7847 7.32399C9.7847 5.99808 8.70895 4.92188 7.38373 4.92188C6.05347 4.92188 4.98047 5.99808 4.98047 7.32399C4.98047 8.65036 6.05347 9.72656 7.38373 9.72656C8.70895 9.72656 9.7847 8.65036 9.7847 7.32399ZM24.7266 23.6133V17.4998C24.7266 13.9451 23.9756 11.3086 19.823 11.3086C17.8276 11.3086 16.4882 12.3065 15.9414 13.3443H15.9375V12.7148C15.9375 12.0676 15.4129 11.543 14.7656 11.543H13.125C12.4777 11.543 11.9531 12.0676 11.9531 12.7148V23.6133C11.9531 24.2606 12.4777 24.7852 13.125 24.7852H14.7656C15.4129 24.7852 15.9375 24.2606 15.9375 23.6133V18.2103C15.9375 16.4884 16.3758 14.8203 18.5101 14.8203C20.6154 14.8203 20.6836 16.7894 20.6836 18.3197V23.6133C20.6836 24.2606 21.2082 24.7852 21.8555 24.7852H23.5547C24.202 24.7852 24.7266 24.2606 24.7266 23.6133ZM30 25.3125C30 24.6652 29.4754 24.1406 28.8281 24.1406C28.1808 24.1406 27.6562 24.6652 27.6562 25.3125C27.6562 26.6048 26.6048 27.6562 25.3125 27.6562H4.6875C3.39523 27.6562 2.34375 26.6048 2.34375 25.3125V4.6875C2.34375 3.39523 3.39523 2.34375 4.6875 2.34375H25.3125C26.6048 2.34375 27.6562 3.39523 27.6562 4.6875V19.3945C27.6562 20.0418 28.1808 20.5664 28.8281 20.5664C29.4754 20.5664 30 20.0418 30 19.3945V4.6875C30 2.10274 27.8973 0 25.3125 0H4.6875C2.10274 0 0 2.10274 0 4.6875V25.3125C0 27.8973 2.10274 30 4.6875 30H25.3125C27.8973 30 30 27.8973 30 25.3125Z"
                                fill="url(#paint0_linear_3342_10)" />
                            <defs>
                                <linearGradient id="paint0_linear_3342_10" x1="0" y1="15" x2="30" y2="15"
                                    gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#00F2FE" />
                                    <stop offset="0.0208" stop-color="#03EFFE" />
                                    <stop offset="0.2931" stop-color="#24D2FE" />
                                    <stop offset="0.5538" stop-color="#3CBDFE" />
                                    <stop offset="0.7956" stop-color="#4AB0FE" />
                                    <stop offset="1" stop-color="#4FACFE" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </a>

                    </div>



                </div>


                <div class="footer-nav-text left">
                    <h4 class="footer-nav-text main">خدمات مشتریان</h4>
                    <div class="footer-nav-text main last">هدف ما در کوکباز، گرد آوردن خانواده بزرگ بازنشستگان است تا بار
                        دیگر، همچون گذشته در کنار هم برای ایران، تلاش کنیم.</div>
                        <div class="footer-nav-logo">
                            <img referrerpolicy="origin" id = 'jxlzsizpfukzapfuesgtapfu' style = 'cursor:pointer; height: 84px;' onclick = 'window.open("https://logo.samandehi.ir/Verify.aspx?id=196505&p=rfthpfvlgvkadshwobpddshw", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt = 'logo-samandehi' src="{{ asset('assets/images/perNemad.png') }}" />
                            <a referrerpolicy="origin" target="_blank" href="{{\App\myappenv::Namad}}">
                                <img src="{{ asset('assets/images/nemad.png') }}" alt="نماد الکترونیک" class="footer-nav-namad"></a>

                        <img class ="footer-nav-image"src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQwIiBoZWlnaHQ9IjM2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KCTxwYXRoIGQ9Im0xMjAgMjQzbDk0LTU0IDAtMTA5IC05NCA1NCAwIDEwOSAwIDB6IiBmaWxsPSIjODA4Mjg1Ii8+Cgk8cGF0aCBkPSJtMTIwIDI1NGwtMTAzLTYwIDAtMTE5IDEwMy02MCAxMDMgNjAgMCAxMTkgLTEwMyA2MHoiIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS13aWR0aDo1O3N0cm9rZTojMDBhZWVmIi8+Cgk8cGF0aCBkPSJtMjE0IDgwbC05NC01NCAtOTQgNTQgOTQgNTQgOTQtNTR6IiBmaWxsPSIjMDBhZWVmIi8+Cgk8cGF0aCBkPSJtMjYgODBsMCAxMDkgOTQgNTQgMC0xMDkgLTk0LTU0IDAgMHoiIGZpbGw9IiM1ODU5NWIiLz4KCTxwYXRoIGQ9Im0xMjAgMTU3bDQ3LTI3IDAtMjMgLTQ3LTI3IC00NyAyNyAwIDU0IDQ3IDI3IDQ3LTI3IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2Utd2lkdGg6MTU7c3Ryb2tlOiNmZmYiLz4KCTx0ZXh0IHg9IjE1IiB5PSIzMDAiIGZvbnQtc2l6ZT0iMjVweCIgZm9udC1mYW1pbHk9IidCIFlla2FuJyIgc3R5bGU9ImZpbGw6IzI5Mjk1Mjtmb250LXdlaWdodDpib2xkIj7Yudi22Ygg2KfYqtit2KfYr9uM2Ycg2qnYtNmI2LHbjDwvdGV4dD4KCTx0ZXh0IHg9IjgiIHk9IjM0MyIgZm9udC1zaXplPSIyNXB4IiBmb250LWZhbWlseT0iJ0IgWWVrYW4nIiBzdHlsZT0iZmlsbDojMjkyOTUyO2ZvbnQtd2VpZ2h0OmJvbGQiPtqp2LPYqCDZiCDaqdin2LHZh9in24wg2YXYrNin2LLbjDwvdGV4dD4KPC9zdmc+ " alt="" onclick="window.open('https://ecunion.ir/verify/kookbaz.ir?token=869226661a33290b016a', 'Popup','toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30')" style="cursor:pointer; width:56px;height: 85px;">
                    </div>





                </div>

            </div>

        </div>
@endif
