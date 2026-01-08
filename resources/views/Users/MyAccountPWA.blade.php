@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.CustomerMainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        @media (min-width: 768px) {
            .main-userinfo-continer-77 {
                display: flex;
            }

            div.userinfo-continer-13 {
                margin: 10px;
                width: 320px;
                padding: 10px;
                border-style: solid;
                border-width: 2px;
                border-radius: 10px;
                border-color: #e0e0e2;
                background-color: white;
            }

            .side-userinfo-right-129 {
                margin: 10px;
                width: calc(100% - 320px);
                padding: 10px;
                height: fit-content;
            }




        }

        @media (max-width: 767px) {
            .main-userinfo-continer-77 {
                display: inline-block;
                margin-right: 20px;
                margin-left: 20px;
            }

            div.userinfo-continer-13 {
                margin: 10px;
                width: 100%;
                padding: 10px;
                border-style: solid;
                border-width: 2px;
                border-radius: 10px;
                border-color: #e0e0e2;
                background-color: white;
            }

            .side-userinfo-right-129 {
                width: 100%;
                padding: 10px;
                height: fit-content;
            }


        }

        .form-control.credit {
            width: 30%
        }

        .progress-bar.first {
            background: linear-gradient(to left, #4CD9E2, #69B8FF);
        }

        .progress-bar.second {
            background: linear-gradient(to left, #FF998A, #FF547B);
        }

        .progress-bar.third {
            background: linear-gradient(to left, #FFC52D, #FF9D50);
        }

        .progress-bar.four {
            background: linear-gradient(to left, #9AE770, #6CB841);
        }


        .wallet-credit {
            margin: 50px;
        }

        .wallet-row.final {
            align-items: center;
            justify-content: center;


        }

        .mainloader_21 {
            text-align: center;
        }

        .wallet-name {
            font-weight: 500;
            line-height: 17px;
            text-align: right;

        }

        .wallet-value {
            border-radius: 10px;
            border-width: 2px;
            border-color: #e0e0e2;
            width: 10%;
            text-align: center;

            padding-top: 22px;
        }

        .wallet-value.first {
            background-color: #eff9fe
        }

        .wallet-value.second {
            background-color: #fddce3
        }

        .wallet-value.third {
            background-color: #fff9ea
        }

        .wallet-value.four {
            background-color: #f2faee
        }

        .wallet-row {
            display: flex;
            border-radius: 10px;
            م border-style: solid;
            border-width: 2px;
            border-color: #e0e0e2;
            padding-left: 2px;
            margin-top: 20px
        }

        .wallet-item {
            width: 90%;
            padding: 8px;
        }

        .useinfo-item-62:hover {
            background-color: #e0e0e2;
        }

        @media (min-width: 920px) {
            .row223 {
                display: grid;
                flex-wrap: wrap;
                width: 100%;
            }

            .informatiom-contineer-204 {
                display: flex;
                border-radius: 10px;
                border-style: solid;
                border-width: 2px;
                border-color: #e0e0e2;
            }

            .information-item-204 {

                width: 100%;
                display: flex;
                padding: 24px;
            }

            .information-item-204.right-row:nth-child(1) {

                border-bottom: 1px solid #e0e0e2;
                border-left: 1px solid #e0e0e2;


            }

            .information-item-204.right-row:nth-child(2) {

                border-bottom: 1px solid #e0e0e2;
                border-left: 1px solid #e0e0e2;

            }

            .information-item-204.right-row:nth-child(3) {

                border-bottom: 1px solid #e0e0e2;
                border-left: 1px solid #e0e0e2;

            }

            .information-item-204.right-row:nth-child(4) {

                border-left: 1px solid #e0e0e2;

            }

            .information-item-204.left-row:nth-child(1) {

                border-bottom: 1px solid #e0e0e2;

            }

            .information-item-204.left-row:nth-child(2) {

                border-bottom: 1px solid #e0e0e2;

            }

            .information-item-204.left-row:nth-child(3) {

                border-bottom: 1px solid #e0e0e2;

            }


            .title-204 {
                font-size: 14px;
                font-weight: 600;
                margin-left: 10px;
            }

            .value-204 {
                font-size: 14px;
                font-weight: 400;
            }
        }

        @media (max-width: 920px) {
            .row223 {
                display: grid;
                flex-wrap: wrap;
                width: 100%;
            }

            .informatiom-contineer-204 {

                border-radius: 10px;
                border-style: solid;
                border-width: 2px;
                border-color: #e0e0e2;
            }

            .information-item-204 {

                width: 100%;
                display: flex;
                padding: 24px;
            }

            .information-item-204.right-row:nth-child(1) {

                border-bottom: 1px solid #e0e0e2;



            }

            .information-item-204.right-row:nth-child(2) {

                border-bottom: 1px solid #e0e0e2;


            }

            .information-item-204.right-row:nth-child(3) {

                border-bottom: 1px solid #e0e0e2;


            }

            .information-item-204.right-row:nth-child(4) {


                border-bottom: 1px solid #e0e0e2;

            }

            .information-item-204.left-row:nth-child(1) {

                border-bottom: 1px solid #e0e0e2;

            }

            .information-item-204.left-row:nth-child(2) {

                border-bottom: 1px solid #e0e0e2;

            }

            .information-item-204.left-row:nth-child(3) {

                border-bottom: 1px solid #e0e0e2;

            }


            .title-204 {
                font-size: 14px;
                font-weight: 600;
                margin-left: 10px;
            }

            .value-204 {
                font-size: 14px;
                font-weight: 400;
            }
        }



        p.userinfo_base_15 {}

        i.userinfo_base_15 {
            font-size: 57px;
            color: green;
        }

        .userinfo_base_15 {
            display: flex
        }

        .userinfo_continer_26 {
            margin-right: 10px;
            font-size: 14px;
            font-weight: 500;
        }

        .edit_26 {
            width: 100%;
            text-align: end;
            font-size: 18px;
            padding-top: 11px;
            color: green;
        }

        hr.userinfo-continer-13 {
            margin: 0px;
        }

        .useinfo-item-62 {
            cursor: pointer;
            display: flex;
            font-size: 14px;
            font-weight: 400;
            padding-top: 4px;
            font-weight: 600;
        }

        svg.useinfo-item-62 {
            width: 24px;
            height: 24px;
            margin-left: 12px;
            margin-right: 12px;
        }


        .side-userinfo-129 {
            display: flex;
            margin: 10px;
            width: calc(100% - 320px);
            padding: 10px;
            border-style: solid;
            border-width: 2px;
            border-radius: 10px;
            border-color: #e0e0e2;
            background-color: white;
            height: fit-content;
        }


        .side-userinfo-sub-129 {
            margin: 10px;
            width: 100%;
            border-style: solid;
            border-width: 2px;
            border-radius: 10px;
            border-color: #e0e0e2;
            background-color: white;
            height: fit-content;
            padding: 10px 10px 37px 10px;
        }


        .important {
            margin-top: 10px;
            margin-bottom: 10px;
            color: red;
        }

        .progress-deactive {}

        .card-title-184 {
            font-size: 16px;
            font-weight: 600;
            border-style: solid;
            border-color: red;
            border-width: 0px 0px 2px 0px;
            padding-right: 2px;
            padding-left: 2px;
            width: fit-content;
            padding-bottom: 8px;
            margin-right: 10px;
            margin-top: 6px;
        }

        .user-special {
            font-size: 14px;
            width: 100%;
            color: gray;
            font-weight: 500;
            margin-right: 20px;
        }
    </style>
    <!-- begin::modal -->
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" style="margin-right: 20%" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        تغییر وضیعت به کاربر ويژه
                    </div>
                    <div class="modal-body">
                        @if (Auth::user()->MelliID == null)
                            <form method="POST">
                                @csrf
                                کد ملی :
                                <input type="number" required class="form-control" name="mellicode">
                                <small class="important">لطفا کد ملی خود را به صورت دقیق با صفحه کلید لاتین وارد
                                    فرمایید!</small>
                                <hr>
                                <button type="submit" name="submit" value="UpdateMellidCode" class="btn btn-warning">ثبت
                                    کد
                                    ملی در سامانه</button>


                            </form>
                        @else
                            <div id="loader_tavan" class="mainloader_21">
                                <div class="loader-bubble loader-bubble-primary m-2"></div>
                                <p style="margin-top: 10px">دریافت اطلاعات از مرکز</p>
                            </div>

                            <div id="tavan" class="nested">
                                <form method="POST">
                                    @csrf
                                    <p class="important"><i class="i-Information"
                                            style="font-size: 17px;font-weight: 500;position: relative;margin-left: 6px;"></i>
                                        کاربر گرامی لطفا کد اعتباری سنجی پیامک شده راوارد نمایید </p>
                                    <button class="btn btn-success" name="submit" value="tavnpardakht"
                                        style="float: left;margin-top: -34px " type="submit">تایید کد اعتبارسنجی</button>
                                    <input type="number" required name="confirmcode" class="form-control credit">

                                </form>

                            </div>
                            <div id="notvalidtavan" class="nested">

                                <p class="important"><i class="i-Information"
                                        style="font-size: 17px;font-weight: 500;position: relative;margin-left: 6px;"></i>

                                    کدملی مورد نظر در سامانه یافت نشد
                                    لطفا طی 24 ساعت آینده مجددا تلاش کنید
                                    و یا با پشتیبانی به شماره 0212811119 تماس بگیرید
                                </p>


                                </form>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end::modal -->
    <div class="main-userinfo-continer-77">
        <div class="userinfo-continer-13">
            <div class="userinfo_base_15">
                <i class="i-Male-21 userinfo_base_15"></i>
                <div class="userinfo_continer_26">
                    <p class="userinfo_base_15"> {{ Auth::user()->Name }} {{ Auth::user()->Family }}
                    </p>
                    <p class="userinfo_base_15">{{ Auth::user()->MobileNo }}</p>
                </div>

                <div class="user-special">
                    @if (Auth::user()->CreditePlan == 1)
                        <small>کاربر ویژه</small>

                        <img class="line-btn" src="{{ asset('assets/images/medal.png') }}" alt="medal">
                    @endif


                </div>
                <div class="userinfo_continer_26 edit_26" onclick="ShowItems('PersonalInfo')">
                    <svg xmlns="http://www.w3.org/2000/svg" style=" fill: green;" width="20" height="20"
                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>

                </div>


            </div>
            <hr class="userinfo-continer-13">
            <div onclick="ShowItems('PersonalInfo')" class="useinfo-item-62">
                <svg class="useinfo-item-62" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path
                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                </svg>
                <p class="useinfo-item-62">اطلاعات حساب کاربری</p>
            </div>
            <hr class="userinfo-continer-13">
            <div onclick="ShowItems('walet')" class="useinfo-item-62">
                <svg class="useinfo-item-62" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                    <path
                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                </svg>
                <p class="useinfo-item-62">کیف پول</p>
            </div>
            <hr class="userinfo-continer-13">
            <div onclick="ShowItems('basket')" class="useinfo-item-62">
                <svg class="useinfo-item-62" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                    <path
                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                </svg>
                <p class="useinfo-item-62">سفارش ها</p>
            </div>
            <hr class="userinfo-continer-13">
            <div onclick="ShowItems('Addresses')" class="useinfo-item-62">
                <svg class="useinfo-item-62" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                    <path
                        d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                </svg>
                <p class="useinfo-item-62">آدرس ها</p>
            </div>
            <hr class="userinfo-continer-13">
            <div onclick="ShowItems('comment')" class="useinfo-item-62">
                <svg class="useinfo-item-62" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                    <path
                        d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                </svg>
                <p class="useinfo-item-62">پیام ها</p>
            </div>
            <hr class="userinfo-continer-13">
            <a href="{{ route('logout') }}">
                <div class="useinfo-item-62">
                    <svg class="useinfo-item-62" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-box-arrow223-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                        <path fill-rule="evenodd"
                            d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                    </svg>
                    <p class="useinfo-item-62">خروج</p>
                </div>
            </a>
        </div>

        <div class="side-userinfo-right-129">
                <div class="side-userinfo-sub-129">
                    @if (Auth::user()->CreditePlan == null)
                    <p class="important">
                        <i class="i-Information"
                            style="font-size: 17px;font-weight: 500;position: relative;margin-left: 6px;"></i>
                        برای استفاده از امکانات کاربر ویژه در صورتی که عضو سازمان بازنشستگی نیروهای مسلح هستید کد هویتی خود
                        را
                        تایید کنید
                    </p>
                    @if (Auth::user()->MelliID == null)
                        <button class="btn btn-success" type="button" data-toggle="modal"
                            data-target=".bd-example-modal-lg" style="float: left;margin-top: -34px;" href="">ثبت
                            کد ملی</button>
                        <small>جهت تبدیل وضعیت به کاربر ویژه ثبت کد ملی الزامی است</small>
                     @else
                         <button onclick="tavanpardakhtfn()" class="btn btn-success" type="button" data-toggle="modal"
                            data-target=".bd-example-modal-lg" style="float: left;" href="">تایید
                            هویت</button>
                        @endif
                    @else
                   
                
                    @endif




                </div>
           
            <div id="walet" class="ItemsMain  side-userinfo-sub-129 nested ">
                <p class="card-title-184"> کیف پول</p>
                <div class="wallwt-coloum">
                    <div class="wallet-row">
                        <div class="wallet-item">
                            <p class="wallet-name ">اعتبار ریالی</p>
                            <div class="progress">
                                <div id="Cach_bar" class="progress-bar  progress-deactive first" role="progressbar"
                                    style="width:5%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                        <div id="Cach_val" class="wallet-value first">0</div>
                    </div>
                    <div class="wallet-row">
                        <div class="wallet-item">
                            <p class="wallet-name">اعتبار سازمانی</p>
                            <div class="progress">
                                <div class="progress-bar progress-deactive second" role="progressbar" style="width: 5%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                        <div class="wallet-value second">0</div>
                    </div>
                    <div class="wallet-row">
                        <div class="wallet-item">
                            <p class="wallet-name">اعتبار همکاری (بازاریابی)</p>
                            <div class="progress">
                                <div class="progress-bar progress-deactive third" role="progressbar " style="width: 5%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                        <div class="wallet-value third">0</div>
                    </div>
                    <div class="wallet-row">
                        <div class="wallet-item">
                            <p class="wallet-name">اعتبار فروشندگان</p>
                            <div class="progress">
                                <div id="Credit_bar" class="progress-bar  progress-deactive four" role="progressbar"
                                    style="width: 5%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                        <div id="Credit_val " class="wallet-value four">0</div>
                    </div>

                    <div class="wallet-row final">

                        <div class="wallet-credit">
                            <p class="p-credit23">:اعتبار کل کیف پول</p>
                            <button onclick="ShowItems('Increment')" class="btn-kookbaz598 light "><svg width="9"
                                    height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="4" width="1" height="9" rx="0.5" fill="#30BFB4" />
                                    <rect y="5" width="1" height="9" rx="0.5"
                                        transform="rotate(-90 0 5)" fill="#30BFB4" />
                                </svg>



                                افزایش موجودی </button>
                            <button onclick="ShowItems('Decrement')" class="btn-kookbaz598  light"> <svg width="9"
                                    height="1" viewBox="0 0 9 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="1" width="1" height="9" rx="0.5"
                                        transform="rotate(-90 0 1)" fill="#30BFB4" />
                                </svg>
                                برداشت موجودی</button>
                            <button onclick="ShowItems('PayOthers')" class="btn-kookbaz598 light"> انتقال کیف پول</button>

                        </div>
                    </div>
                </div>
            </div>
            <div id="Addresses" class="ItemsMain  side-userinfo-sub-129 nested">
                <p class="card-title-184">آدرس ها</p>
                <p>آدرس های زیر به طور پیش فرض در صفحه پرداخت استفاده می شود.</p>
                <div class="row">
                    @foreach ($Locations as $Location)
                        <div style="margin-right: 0px; padding-left:0px; margin-bottom: 10px;"
                            class="card col-lg-3 col-md-5 col-sm-12">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                {{ $Location->name }}</h4>
                            </div>
                            <div class="card-body">
                                <address>
                                    <table class="address-table">
                                        <tbody>
                                            <tr>
                                                <th>نام :</th>
                                                <td>{{ $Location->recivername }}</td>
                                            </tr>
                                            <tr>
                                                <th>استان:</th>
                                                <td>{{ $Location->Province }}</td>
                                            </tr>
                                            <tr>
                                                <th>شهر :</th>
                                                <td>{{ $Location->City }}</td>
                                            </tr>
                                            <tr>
                                                <th>خیابان:</th>
                                                <td>{{ $Location->Street }} </td>
                                            </tr>

                                            <tr>
                                                <th>آدرس:</th>
                                                <td>{{ $Location->OthersAddress }} </td>
                                            </tr>
                                            <tr>
                                                <th>پلاک :</th>
                                                <td>{{ $Location->Pelak }} </td>
                                            </tr>
                                            <tr>
                                                <th>تلفن:</th>
                                                <td>{{ $Location->reciverphone }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </address>
                                <a href="#" class="btn btn-danger btn-rounded">حذف آدرس </a>
                            </div>
                        </div>
                        <br>
                    @endforeach

                </div>

            </div>
            <div id="Increment" class="ItemsMain  side-userinfo-sub-129 nested">
                <p class="card-title-184">افزایش موجودی</p>
                <p>افزایش موجودی کیف پول از طریق درگاه بانکی</p>
                <div class="row">
                    <form action="{{ route('DoDirectPay') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4"
                                        class="ul-form__label">{{ __('Credite mony real') }}:</label>
                                    <input type="number" id="amount" autocomplete="off" class="form-control"
                                        name="Amount" value="{{ old('Amount') }}"
                                        placeholder="{{ __('Credite transfer to user account') }}">
                                    <div id="amountext"></div>
                                    <small class="ul-form__text form-text ">
                                        {{ __('Credite transfer to user account') }}
                                    </small>
                                </div>
                                @if (\app\myappenv::MainOwner == 'shafatel')
                                    <div class="row" style="text-align: center">
                                        <label style="margin: 10px" class="radio radio-outline-primary">
                                            <input type="radio" checked name="radio" value="pep"
                                                formcontrolname="radio">
                                            <span>بانک پاسارگاد</span>
                                            <img style="max-width: 80px;"
                                                src="{{ asset('assets/images/favicon/pep.png') }}">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label style="margin: 10px" class="radio radio-outline-primary">
                                            <input type="radio" name="radio" value="ic" formcontrolname="radio">
                                            <span>کارت اعتباری ایرانیان</span>
                                            <img style="max-width: 80px;"
                                                src="{{ asset('assets/images/favicon/IC.png') }}">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                @endif
                                <div class="form-group col-md-12">
                                    <label class="ul-form__label">{{ __('Note') }}</label>
                                    <textarea name="Note" rows="3" class="form-control">{{ old('Note') }}</textarea>

                                </div>
                            </div>
                            <div class="custom-separator"></div>

                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="Trnsfer"
                                            class="btn  btn-primary m-1">{{ __('Add credite') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
            <div id="Decrement" class="ItemsMain  side-userinfo-sub-129 nested">
                <p class="card-title-184">برداشت موجودی</p>
                <p>واریز به شماره شبا تعریف شده در سیستم انجام میگیرد</p>
                <div class="row">
                    <div class="row">
                        <form action="{{ route('DoDirectPay') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-row ">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="ul-form__label">مبلغ برداشت از کیف پول:</label>
                                        <input type="number" id="amount1" autocomplete="off" class="form-control"
                                            name="Amount" value="{{ old('Amount') }}"
                                            placeholder="مبلغ واریزی به حساب بانکی">
                                        <div id="amountext1"></div>
                                        <small class="ul-form__text form-text ">
                                            واریز به شماره شبا تعریف شده در سیستم
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="ul-form__label">توضیحات برداشت</label>
                                        <textarea name="Note" rows="3" class="form-control">{{ old('Note') }}</textarea>
                                        <small>درصورتی که نیاز به توضیحات برداشت دارید این فیلد را پر کنید</small>
                                    </div>
                                </div>
                                <div class="custom-separator"></div>

                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" name="submit" value="Decrease_free"
                                                class="btn  btn-primary m-1">انتقال در چهارشنبه های بی کارمزد</button>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" name="submit" value="Decrease_fast"
                                                class="btn  btn-danger m-1">انتقال در اسرع وقت کارمزد ۱٪</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
            <div id="PayOthers" class="ItemsMain  side-userinfo-sub-129 nested">
                <p class="card-title-184">انتقال کیف پول</p>
                <p>انتقال به کیف پول دیگران از طریق کیف پول شخصی</p>
                <div class="row">
                </div>
            </div>


            <div id="PersonalInfo" class="ItemsMain side-userinfo-sub-129 nested">
                <p class="card-title-184">اطلاعات فردی</p>
                <button style="float: left;left:10px;position: relative;top: -56px;" onclick="changetoedit()"
                    class="viewmod btn btn-warning">ویرایش</button>
                <button style="float: left;left:10px;position: relative;top: -56px;" onclick="changetoview()"
                    class="editmod btn btn-success nested">انصراف</button>
                <input type="text" id="TargetUserName" class="nested" value="{{ Auth::id() }}">
                <form method="post">
                    @csrf
                    <div class="informatiom-contineer-204">
                        <div class="row223">
                            <div class="information-item-204 right-row ">
                                <div class="title-204">
                                    :نام
                                </div>
                                <div class="value-204 viewmod ">
                                    {{ Auth::user()->Name }}
                                </div>
                                <div class="value-204 editmod nested">
                                    <input type="text" class="form-control " name="Name"
                                        value="{{ Auth::user()->Name }}">
                                </div>
                            </div>
                            <div class="information-item-204 right-row">
                                <div class="title-204">
                                    نام خانوادگی:
                                </div>
                                <div class="value-204 viewmod ">
                                    {{ Auth::user()->Family }}
                                </div>
                                <div class="value-204 editmod nested">
                                    <input type="text" class="form-control " name="Family"
                                        value="{{ Auth::user()->Family }}">
                                </div>

                            </div>
                            <div class="information-item-204 right-row">
                                <div class="title-204">
                                    تاریخ تولد:
                                </div>
                                <div class="value-204 viewmod ">
                                    {{ Auth::user()->Birthday }}
                                </div>
                                <div class="value-204 editmod nested">
                                    <input type="text" class="form-control " name="Birthday"
                                        value="{{ Auth::user()->Birthday }}">
                                </div>

                            </div>
                            <div class="information-item-204 right-row">
                                <div class="title-204">
                                    کد همکاری:
                                </div>
                                <div class="value-204 viewmod ">
                                    {{ Auth::user()->MarketingCode }}
                                </div>
                                <div class="value-204 editmod nested">
                                    <input type="text" class="form-control " name="MarketingCode"
                                        value="{{ Auth::user()->MarketingCode }}">
                                </div>

                            </div>


                        </div>

                        <div class="row223">
                            <div class="information-item-204 left-row">
                                <div class="title-204">
                                    شماره موبایل:
                                </div>
                                <div class="value-204 viewmod ">
                                    {{ Auth::user()->MobileNo }}
                                </div>
                                <div class="value-204 editmod nested ">
                                    @if (Auth::user()->CreditePlan != 1)
                                        <input type="text" class="form-control " name="MobileNo"
                                            value="{{ Auth::user()->MobileNo }}">
                                    @else
                                        <input type="text" class="form-control " name="MobileNo"
                                            value="{{ Auth::user()->MobileNo }}" disabled>
                                    @endif
                                </div>
                                @if (Auth::user()->CreditePlan == 1)
                                    <a class="btn-kookbaz-small"> تایید شده</a>
                                @endif
                            </div>
                            <div class="information-item-204 left-row ">
                                <div class="title-204">
                                    ایمیل:
                                </div>
                                <div class="value-204 viewmod ">
                                    {{ Auth::user()->Email }}
                                </div>
                                <div class="value-204 editmod nested">
                                    <input type="email" class="form-control " name="Email"
                                        value="{{ Auth::user()->Email }}">
                                </div>

                            </div>
                            <div class="information-item-204 left-row ">

                                <div class="title-204  ">
                                    کد ملی :
                                </div>

                                <div class="value-204 viewmod">
                                    {{ Auth::user()->MelliID }}

                                </div>

                                <div class="value-204 editmod nested">
                                    @if (Auth::user()->CreditePlan != 1)
                                        <input type="text" class="form-control " name="MelliID"
                                            value="{{ Auth::user()->MelliID }}">
                                    @else
                                        <input type="text" class="form-control " name="MelliID"
                                            value="{{ Auth::user()->MelliID }}" disabled>
                                    @endif
                                </div>
                                @if (Auth::user()->CreditePlan == 1)
                                    <a class="btn-kookbaz-small"> تایید شده</a>
                                @endif
                            </div>
                            <div class="information-item-204 left-row">
                                <div class="title-204 ">
                                    رمز عبور :
                                </div>
                                <div class="value-204 viewmod ">

                                </div>
                                <div class="value-204 editmod nested">
                                    <input type="text" class="form-control " name="new_password" value="">
                                </div>

                            </div>

                        </div>

                    </div>
                    <button type="submit" name="submit" class="btn btn-warning editmod nested"
                        style="    margin-top: 20px;
                                                margin-right: 31px;"
                        value="updateUserInfo">ذخیره
                        تغییرات</button>

                    <hr>

                </form>
                <p class="card-title-184">اطلاعات حساب بانکی</p>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card text-left">
                            <div class="card-header text-right bg-transparent">
                                <button id="addobject" type="button" data-toggle="modal"
                                    data-target=".bd-example-modal-lg2" class="btn btn-primary btn-md m-1">اضافه کردن
                                    شماره شبا
                                </button>
                            </div>
                            <!-- begin::modal -->
                            <div class="ul-card-list__modal">
                                <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog"
                                    style="margin-right: 20%" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                افزودن شماره شبا
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    @csrf
                                                    <label for="">شماره شبا (IR)</label>
                                                    <input type="number" name="shaba" placeholder="شماره شبا بدون IR"
                                                        required class="form-control" name="shabanumber">
                                                    <label for="">شماره کارت</label>
                                                    <input type="number" name="cardnumber" class="form-control"
                                                        name="cardnumber">
                                                    <label for="">بانک صادر کننده</label>
                                                    <input type="text" name="bankname" required class="form-control"
                                                        name="bankname">
                                                    <button type="submit" name="submit" value="Updatecardnumber"
                                                        class="btn-kookbaz598">
                                                        ثبت شماره شبا</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end::modal -->
                            <form method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="ul-contact-list" style="width:100%">
                                            <thead>


                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>نام بانک</th>
                                                    <th>شماره کارت</th>
                                                    <th>وضعیت</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                @php
                                                    $Conter = 0;
                                                @endphp
                                                @foreach ($Banks as $BankTarget)
                                                    @php
                                                        $Conter++;
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $Conter }}</td>
                                                        <td>{{ $BankTarget->‌BankName }}</td>
                                                        <td>{{ $BankTarget->CardNo }}</td>
                                                        @if ($BankTarget->Status == 1)
                                                            <td>در انتظار تایید </td>
                                                        @else
                                                            <td>فعال</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="basket" class="ItemsMain side-userinfo-sub-129 nested">
                <p class="card-title-184">سفارشات</p>
                <div class="card-body">
                    @if (sizeof($Orders) == 0)
                        <p>تا کنون سفارشی ثبت نشده است!</p>
                    @endif
                    @foreach ($Orders as $Order)
                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h6>
                                    سفارش شماره: {{ $Order->id }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <p>تاریخ سفارش: {{ $Persian->MyPersianDate($Order->created_at) }} </p>
                                <p>وضیعت سفارش: @if ($Order->status == 1)
                                        در انتظار پردازش
                                    @elseif($Order->status == 2)
                                        در حال پردازش
                                    @elseif($Order->status == 100)
                                        تکمیل سفارش
                                    @endif
                                </p>
                                <p>مبلغ:
                                    {{ number_format($Order->total_sales / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                                <p>تعداد: {{ $Order->num_items_sold }} قلم کالا</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="comment" class="ItemsMain side-userinfo-sub-129 nested">
                <p class="card-title-184">پیام ها</p>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card text-left">
                            <div class="card-header text-right bg-transparent">
                                <button id="addobject" type="button" data-toggle="modal"
                                    data-target=".bd-example-modal-lg1" class="btn btn-primary btn-md m-1"><i
                                        class="i-Ticket text-white mr-2"></i>{{ __('Send ticket') }}
                                </button>
                            </div>
                            <!-- begin::modal -->
                            <div class="ul-card-list__modal">
                                <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog"
                                    style="margin-right: 20%" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="{{ route('tikets') }}" method="post">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <input style="visibility:hidden" id="tableID" name="tableid">
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-2 col-form-label">{{ __('Receiver') }}</label>
                                                        <div class="col-sm-10">
                                                            <select name="ToUser" class="form-control">
                                                               
                                                                @foreach ($ticket_recivers as $ticket_reciver)
                                                                    <option value="{{ $ticket_reciver->id }}">
                                                                        {{ $ticket_reciver->TicketText }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-2 col-form-label">{{ __('Topic') }}</label>
                                                        <div class="col-sm-10">

                                                            <input type="text" class="form-control" name="subject"
                                                                id="" placeholder="{{ __('Ticket subject') }}"
                                                                value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName"
                                                            class="col-sm-2 col-form-label">{{ __('Priority') }}</label>
                                                        <div class="col-sm-10">
                                                            <select name="TicketPeriority" class="form-control">
                                                                @foreach (\App\myappenv::TicketPeriority as $Periority)
                                                                    <option value="{{ $Periority[0] }}">
                                                                        {{ __($Periority[1]) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <label for="inputName"
                                                        class="col-sm-2 col-form-label">{{ __('TicketText') }}</label>
                                                    <div class="input-right-icon">
                                                        <textarea name="ce" class="form-control"></textarea>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="captcha">
                                                            <span>{!! captcha_img() !!}</span>
                                                            <button type="button" class="btn btn-danger"
                                                                class="refresh-captcha" id="refresh-captcha">
                                                                &#x21bb;
                                                            </button>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input required id="captcha" type="text" autocomplete="off" required
                                                                class="form-control form-control-rounded"
                                                                placeholder="کد امنیتی را وارد فرمایید!" name="captcha">
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <button id="addelement" type="submit" name="submit"
                                                                value="add"
                                                                class="btn btn-success">{{ __('Send') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end::modal -->
                            <form method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('TrackingCode') }}</th>
                                                    <th>{{ __('Title') }}</th>
                                                    <th>{{ __('Date') }}</th>
                                                    <th>{{ __('Priority') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Tickets as $Ticket)
                                                    <tr id="tr_{{ $Ticket->TicketID }}">
                                                        <td id="id_{{ $Ticket->TicketID }}">
                                                            <a href="{{ route('tikets', $Ticket->TicketID) }}">
                                                                {{ $Ticket->TicketID }}
                                                            </a>
                                                        </td>
                                                        <td id="Subject_{{ $Ticket->TicketID }}"
                                                            name="{{ $Ticket->Subject }}">{{ $Ticket->Subject }}</td>
                                                        <td id="CreateDate_{{ $Ticket->TicketID }}"
                                                            name="{{ $Ticket->CreateDate }}">
                                                            {{ $Persian->MyPersianDate($Ticket->CreateDate) }}</td>
                                                        <td id="Priority_{{ $Ticket->TicketID }}"
                                                            name="{{ $Ticket->Priority }}">
                                                            @foreach (\App\myappenv::TicketPeriority as $Periority)
                                                                @if ($Periority[0] == $Ticket->Priority)
                                                                    {{ __($Periority[1]) }}
                                                                @endif
                                                            @endforeach

                                                        </td>
                                                        <td id="State_{{ $Ticket->State }}"
                                                            name="{{ $Ticket->State }}">
                                                            @foreach (\App\myappenv::TicketState as $State)
                                                                @if ($State[0] == $Ticket->State)
                                                                    {{ __($State[1]) }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('page-js')
    <script>
        function changetoedit() {
            $('.editmod').removeClass('nested');
            $('.viewmod').addClass('nested');
        }

        function changetoview() {
            $('.editmod').addClass('nested');
            $('.viewmod').removeClass('nested');

        }
    </script>
    <script>
        let Conter = 0;
        onload = function() {
            var e = document.getElementById('amount');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }

            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };
        onload = function() {
            var e = document.getElementById('amount1');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext1').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }

            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };

        function Itemfunction($First, $Second, $index) {
            $MonyLimit = 30000000;
            $Mony = $index[Conter]['Mony'];
            $MonyInt = parseInt($Mony);
            $Percent = Math.round($Mony / $MonyLimit * 100);
            $CreditMod = $index[Conter]['CreditMod'];
            //Cach 1
            if ($CreditMod == '1') {
                $('#Cach_val').html(number_format($Mony));
                $('#Cach_bar').css("width", $Percent + '%');
                $('#Cach_bar').html($Percent + '%');
            }
            if ($CreditMod == '2') {
                $('#Credit_val').html(number_format($Mony));
                $('#Credit_bar').css("width", $Percent + '%');
                $('#Credit_bar').html($Percent + '%');
            }
            Conter++;
        }

        function tavanpardakhtfn() {
            $TargetUserName = $('#TargetUserName').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'tavanpardakhtfn',
                    TargetUserName: $TargetUserName
                },

                function(data, status) {
                    if (data == 'notvalid') {
                        $('#loader_tavan').addClass('nested');
                        $('#notvalidtavan').removeClass('nested');
                    } else {
                        $('#loader_tavan').addClass('nested');
                        $('#tavan').removeClass('nested');
                    }
                });

        }

        function WaletShow() {
            $TargetUserName = $('#TargetUserName').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetWalet',
                    TargetUserName: $TargetUserName
                },

                function(data, status) {
                    const obj = JSON.parse(data);
                    Conter = 0;
                    obj.forEach(Itemfunction);
                });

        }

        function ShowItems($ItemName) {
            $('.ItemsMain').addClass('nested');
            $('#' + $ItemName).removeClass('nested');
            if ($ItemName == 'walet') {
                WaletShow();
            }

        }
    </script>
@endsection

@section('bottom-js')
@endsection
