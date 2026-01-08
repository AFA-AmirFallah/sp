@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')
@section('MainTitle')
@endsection

@section('ExtraTags')
@endsection
@section('MainContent')
    <style>
        .Discount_Percent {
            position: absolute;
            left: 6px;
            top: 6px;
            background: red;
            border-radius: 3px;
            color: white;
            padding: 3px;
            font-size: large;

        }

        .Discount_Percent label {
            padding-bottom: 0px;
            margin-bottom: 0px;

        }

        .container237 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;

        }

        .active-box {
            border-style: solid;
            border-color: blue;
            background-color: #bfefb947;
        }
    </style>

    <input id="main_url" class="nested" value="{{ url('/') }}">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ route('home') }}">صفحه اصلی </a></li>
                <li><a href="#">خدمات</a></li>

            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of Page Content -->
    <div class="page-content">

        <div class="container">
            <div class="row gutter-lg">
                <aside class="sidebar vendor-sidebar sticky-sidebar-wrapper left-sidebar sidebar-fixed">
                    <div class="sidebar-overlay"></div>
                    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                    <a href="#" class="sidebar-toggle"><i class="fas fa-chevron-right"></i></a>
                    <div class="sidebar-content">
                        <div class="sticky-sidebar">
                            <div class="widget widget-search-form">
                                <div class="widget-body">
                                    <form action="#" method="GET" class="input-wrapper input-wrapper-inline">
                                        <input type="text" class="form-control" placeholder="جستجو ..."
                                            autocomplete="off" required="">
                                        <button class="btn btn-search"><i class="w-icon-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <!-- End of Widget -->

                            <div class="widget widget-filter">
                                <h4 class="widget-title">فیلتر بر اساس طبقه بندی</h4>
                                <div class="widget-body">
                                    <form class="select-box">
                                        <select name="orderby" class="form-control">
                                            <option value="choose" selected="selected">انتخاب دسته ...</option>
                                            <option value="clothing">خدمات پرستاری </option>
                                            <option value="men">خدمات پزشکسی </option>
                                            <option value="electronics"> خدمات ICU</option>
                                            <option value="accessories">خدمات نگهداری از سالمند </option>
                                            <option value="home-kitchen"> خدمات نگهداری از کودک</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <!-- End of Widget -->

                            <div class="widget widget-filter">
                                <h4 class="widget-title">فیلتر بر اساس مکان</h4>
                                <div class="widget-body">
                                    <form class="select-box">
                                        <select name="orderby" class="form-control">
                                            <option value="choose" selected="selected">انتخاب موقعیت ...</option>
                                            <option value="afghanistan">تهران </option>
                                            <option value="aland">اصفهان </option>
                                            <option value="albania">شیراز </option>
                                            <option value="algeria">مشهد</option>
                                            <option value="bahamas">تبریز</option>
                                            <option value="cuba">کرج</option>
                                            <option value="greece">سنندج</option>
                                        </select>
                                    </form>
                                    <form class="select-box">
                                        <select name="orderby" class="form-control">
                                            <option value="choose" selected="selected">نوع مجوز را انتخاب کنید</option>
                                        </select>
                                    </form>
                                    <form>
                                        <input type="search" id="city" name="city" class="form-control"
                                            placeholder="جستجو بر اساس شهر" required />
                                        <input type="search" id="zip" name="zip" class="form-control"
                                            placeholder="جستجو بر اساس کد پستی" required />
                                    </form>
                                </div>
                            </div>
                            <!-- End of Widget -->
                        </div>
                        <!-- End of Sticky Sidebar -->
                    </div>
                    <!-- End of Sidebar Content -->
                </aside>
                <!-- End of Sidebar -->

                <div id="service_section" class="main-content">
                    <div style="margin-top: 20px" class="container">
                        <div class="st-section-heading st-style2 text-center">
                            <h2> ارائه دهندگان خدمات : {{ $OrderSrc->Cat }} </h2>
                            <div class="st-seperator">
                                <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                    data-wow-delay="0.2s">
                                </div>
                                <img src="/Theme4/assets/img/light-img/seperator-icon1.png" alt="demo"
                                    class="st-seperator-icon">
                                <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                    data-wow-delay="0.2s">
                                </div>
                            </div>
                            <p>{{ $OrderSrc->TitleDescription }} </p>
                        </div>
                    </div>
                    <!-- End of Toolbox -->

                    <div class="row cols-sm-2">
                        @foreach ($supported_branch as $supported_branch_item)
                            <div class="store-wrap mb-4">
                                <div class="store store-grid store-wcfm">
                                    <div class="store-header">
                                        <figure style="background-color: #40475E;width:100%;height:200px"
                                            class="store-banner">

                                        </figure>
                                    </div>
                                    <!-- End of Store Header -->

                                    <div class="store-content">
                                        <h4 class="store-title">
                                            <a href="vendor-dokan-store.html">{{ $supported_branch_item->branch_name }}</a>
                                        </h4>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 100%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                        </div>
                                        <ul class="seller-info-list list-style-none">
                                            <li class="st-iconbox-text">
                                                {{ $supported_branch_item->Description }}
                                            </li>
                                            <li class="st-iconbox-text">
                                                {{ $supported_branch_item->MainDescription }}
                                            </li>
                                            @isset($supported_branch_item->min_price)
                                                <li>
                                                    قیمت از:
                                                    {{ number_format($supported_branch_item->min_price) }} تا
                                                    {{ number_format($supported_branch_item->max_price) }} ریال
                                                </li>
                                            @endisset
                                        </ul>
                                    </div>

                                    <!-- End of Store Content -->
                                    <div class="store-footer">
                                        <figure class="seller-brand">
                                            <img src="{{ $supported_branch_item->avatar }}" alt="Brand" width="80"
                                                height="80">
                                        </figure>
                                        <a href="#" class="btn btn-inquiry btn-rounded btn-icon-left"><i
                                                class="far fa-question-circle"></i>استعلام </a>
                                        <a onclick="add_service({{ $supported_branch_item->id }})"
                                            class="btn btn-rounded btn-visit">ثبت رایگان درخواست </a>
                                    </div>

                                    <!-- End of Store Footer -->
                                </div>
                                <!-- End of Store -->
                            </div>
                        @endforeach


                    </div>
                </div>

                <div id="register_section" class="main-content" style="display: none">

                    <div style="margin-top: 20px">
                        <div class="st-section-heading st-style2 text-center">
                            <h2> ثبت رایگان درخواست: {{ $OrderSrc->Cat }} </h2>
                            <div class="st-seperator">
                                <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                    data-wow-delay="0.2s">
                                </div>
                                <img src="/Theme4/assets/img/light-img/seperator-icon1.png" alt="demo"
                                    class="st-seperator-icon">
                                <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                    data-wow-delay="0.2s">
                                </div>
                            </div>
                            <p>{{ $OrderSrc->TitleDescription }} </p>
                        </div>
                    </div>
                    <section class="contact-section">
                        <div class="row gutter-lg pb-3">
                            <div class="col-lg-6 mb-8">

                                <h4 class="title mb-3"> سوالات متداول ثبت درخواست
                                </h4>
                                <div class="accordion accordion-bg accordion-gutter-md accordion-border">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#collapse1" class="collapse">چگونه می توانم درخواست خود را پیگیری
                                                کنم؟</a>
                                        </div>
                                        <div id="collapse1" class="card-body expanded">
                                            <p class="mb-0">
                                                پس از ثبت درخواست در پلتفرم شفاتل - درخواست ثبت شده مستقیما به مرکز خدمات
                                                دهنده‌ی انتخاب شده ارسال می گردد. شما می توانید در پنل کاربری خود وضعیت
                                                درخواست خود را مشاهده و از طریق همان پنل پیگیر درخواست خود از مرکز خدمات
                                                دهنده باشید.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#collapse2" class="expand">آیا شفاتل کیفیت خدمات را تضمین می نماید
                                                ؟</a>
                                        </div>
                                        <div id="collapse2" class="card-body collapsed">
                                            <p class="mb-0">
                                                پلتفرم شفاتل مستقیما ارائه دهنده خدمت نمی باشد لذا نمیتواند کیفیت خدمات
                                                مراکز یا افراد را تضمین نماید. ولیکن تمام پزشکان - مراکز و فروشگاه‌هایی که
                                                در شفاتل فعال می‌باشند جزو بهترین خوش سابقه ترین‌های حوزه مربوط به خود می
                                                باشند.
                                                پیشنهاد می شود قبل از ثبت خدمت سابقه ارائه دهنده خدمت را در پلتفرم شفاتل
                                                بررسی فرمائید.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#collapse3" class="expand">آیا شفاتل مرکز درمانی است؟</a>
                                        </div>
                                        <div id="collapse3" class="card-body collapsed">
                                            <p class="mb-0">
                                                خیر، شفاتل یک پلتفرم زنجیره تامین سلامت است که زیر ساخت فناوری لازم را جهت
                                                تسهیل کسب و کارهای حوزه سلامت در اختیار مراکز و افراد مجاز قرار می دهد و پل
                                                ارتباطی بیماران با فروشنده گان کالا یا خدمات پزشکی و درمانی است.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#collapse4" class="expand">نظر خودم را در خصوص نحوه انجام خدمت کجا
                                                اعلام کنم؟</a>
                                        </div>
                                        <div id="collapse4" class="card-body collapsed">
                                            <p class="mb-0">
                                                پس از اتمام هر خدمت از طریق پنل کاربری خود میتوانید میزان رضایت مندی خود را
                                                از خدمات ارائه شده ثبت نمائید.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#collapse5" class="expand">چگونه می توانم پولم را پس بگیرم؟</a>
                                        </div>
                                        <div id="collapse5" class="card-body collapsed">
                                            <p class="mb-0">
                                                با توجه به اینکه پلتفرم شفاتل در روال مالی فی مابین ارائه دهندگان خدمات یا
                                                کالای درمان دخالتی ندارد لذا در خصوص این امر می باید به صورت مستقیم با فرد
                                                یا مرکز ارائه دهنده خدمات مذاکره نمائید اما در انجام این روند کارشناسان
                                                شفاتل این فرایند را برای شده تسهیل خواهند نمود.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-8">
                                <h4 class="title mb-3"> ثبت درخواست خدمت در: <div id="center_title_2"
                                        style="margin-right: 3px"></div>
                                </h4>
                                <form class="form contact-us-form" method="post">
                                    <div class="form-group">
                                        <label for="username">شماره موبایل <small style="color: red" class="danger">
                                                (الزامی)</small></label>
                                        <input inputmode="numeric" required id="username" name="username"
                                            class="form-control">

                                    </div>
                                    <div class="form-group">
                                        <label for="email_1">نام <small style="color: red" class="danger">
                                                (الزامی)</small></label>
                                        <input type="email" name="name" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="email_1">نام خانوادگی <small style="color: red" class="danger">
                                                (الزامی)</small></label>
                                        <input type="email" name="family" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="message">متن درخواست</label>
                                        <textarea id="message" placeholder="توضیحات و آدرس محل خدمت" name="message" cols="30" rows="5"
                                            class="form-control"></textarea>
                                    </div>
                                    <button type="button" onclick="back_to_centers()"
                                        class="btn btn-warning btn-rounded">
                                        بازگشت</button>
                                    <button type="submit"
                                        style="
                                    display: inline-flex;
                                "
                                        class="btn btn-dark btn-rounded">اکنون به <div id="center_title"
                                            style="margin-right: 3px;margin-left: 3px"> </div> ارسال کنید</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- End of Main Content -->
            </div>
        </div>
    </div>
    <!-- End of Page Content -->
@endsection
@section('page-js')
    <script>
        function add_service(service_id) {
            $('#select_div').removeClass('active-box');
            $('#save_order_div').addClass('active-box');
            $('#center_title').html('.....');
            $('#center_title_2').html('.....');
            $('#center_desc').html('.....');
            $("#service_section").attr("style", "display:none;");
            $("#register_section").attr("style", "display:block;");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    service_id: service_id
                },
                function(data, status) {
                    $('#center_title').html(data['Name']);
                    $('#center_title_2').html(data['Name']);
                    $('#center_desc').html(data['Description']);
                });

        }

        function back_to_centers() {
            $('#select_div').addClass('active-box');
            $('#save_order_div').removeClass('active-box');
            $("#service_section").attr("style", "display:block;");
            $("#register_section").attr("style", "display:none;");
            $('#center_title').html('');
            $('#center_title_2').html('');
            $('#center_desc').html('');
        }
    </script>





    <!---start GOFTINO code--->
@endsection
