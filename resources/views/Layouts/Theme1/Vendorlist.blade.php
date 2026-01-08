@extends('Layouts.Theme1.MainLayout')
@section('MainContent')
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="demo1.html">صفحه اصلی </a></li>
                <li><a href="#">فروشنده </a></li>
                <li><a href="#">WCFM</a></li>
                <li>لیست فروشگاه</li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of Pgae Contetn -->
    <div class="page-content mb-8">
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
                                            <option value="clothing">لباس </option>
                                            <option value="men">منوها </option>
                                            <option value="electronics">دفتر الکترونیک ی </option>
                                            <option value="accessories">تجهیزات جانبی </option>
                                            <option value="home-kitchen">خانه و آشپرخانه </option>
                                            <option value="healthy-beauty">سالم و زیبا</option>
                                            <option value="jewelry-watch">جواهرات و ساعت</option>
                                            <option value="smart-watch">اسمارت واچ </option>
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
                                            <option value="afghanistan">افغانستان </option>
                                            <option value="aland">ایسلند </option>
                                            <option value="albania">هلند </option>
                                            <option value="algeria">الجزیره</option>
                                            <option value="bahamas">باهاما</option>
                                            <option value="cuba">کوبا</option>
                                            <option value="greece">یونان</option>
                                        </select>
                                    </form>
                                    <form class="select-box">
                                        <select name="orderby" class="form-control">
                                            <option value="choose" selected="selected">دولت را انتخاب کنید</option>
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

                <div class="main-content">
                    <div class="toolbox wcfm-toolbox">
                        <div class="toolbox-left">
                            <form class="select-box toolbox-item">
                                <select name="orderby" class="form-control">
                                    <option value="old-new" selected="selected">مرتب سازی بر اساس تازگی: قدیمی به جدید
                                    </option>
                                    <option value="new-old">مرتب سازی بر اساس جدید بودن: جدید به قدیمی</option>
                                    <option value="low-high">مرتب سازی بر اساس رتبه بندی متوسط: کم به زیاد</option>
                                    <option value="high-low">مرتب سازی بر اساس رتبه بندی متوسط: بالا به پایین</option>
                                    <option value="old-new">حروف الفبا را مرتب کنید: A تا Z</option>
                                    <option value="old-new">مرتب سازی بر اساس حروف الفبا: Z به A</option>
                                </select>
                            </form>
                        </div>
                        <div class="toolbox-right">
                            <div class="toolbox-item">
                                <label class="showing-info">نمایش 1-2 از 2 نتیجه</label>
                            </div>
                        </div>
                    </div>
                    <!-- End of Toolbox -->

                    <div class="row cols-sm-2">
                        <div class="store-wrap mb-4">
                            <div class="store store-grid store-wcfm">
                                <div class="store-header">
                                    <figure class="store-banner">
                                        <img src="Theme1/assets/images/vendor/dokan/1.jpg" alt="Vendor" width="400"
                                            height="194" style="background-color: #40475E">
                                    </figure>
                                </div>
                                <!-- End of Store Header -->
                                <div class="store-content">
                                    <h4 class="store-title">
                                        <a href="vendor-dokan-store.html">فروشنده 1</a>
                                    </h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 100%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                    </div>
                                    <ul class="seller-info-list list-style-none">
                                        <li class="store-email">
                                            <a href="email:#">
                                                <i class="far fa-envelope"></i>
                                                wolamrtvendor1@email.com
                                            </a>
                                        </li>
                                        <li class="store-phone">
                                            <a href="tel:123456789">
                                                <i class="w-icon-phone"></i>
                                                123456789
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End of Store Content -->
                                <div class="store-footer">
                                    <figure class="seller-brand">
                                        <img src="Theme1/assets/images/vendor/brand/1.jpg" alt="Brand" width="80"
                                            height="80">
                                    </figure>
                                    <a href="#" class="btn btn-inquiry btn-rounded btn-icon-left"><i
                                            class="far fa-question-circle"></i>استعلام </a>
                                    <a href="#" class="btn btn-rounded btn-visit">بازدید </a>
                                </div>
                                <!-- End of Store Footer -->
                            </div>
                            <!-- End of Store -->
                        </div>

                        <div class="store-wrap mb-4">
                            <div class="store store-grid store-wcfm">
                                <div class="store-header">
                                    <figure class="store-banner">
                                        <img src="Theme1/assets/images/vendor/dokan/2.jpg" alt="Vendor" width="400"
                                            height="194" style="background-color: #40475E">
                                    </figure>
                                </div>
                                <!-- End of Store Header -->
                                <div class="store-content">
                                    <h4 class="store-title">
                                        <a href="vendor-dokan-store.html">فروشنده 2</a>
                                    </h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 100%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                    </div>
                                    <ul class="seller-info-list list-style-none">
                                        <li class="store-email">
                                            <a href="email:#">
                                                <i class="far fa-envelope"></i>
                                                wolamrtvendor2@email.com
                                            </a>
                                        </li>
                                        <li class="store-phone">
                                            <a href="tel:123456789">
                                                <i class="w-icon-phone"></i>
                                                1234567890
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End of Store Content -->
                                <div class="store-footer">
                                    <figure class="seller-brand">
                                        <img src="Theme1/assets/images/vendor/brand/2.jpg" alt="Brand" width="80"
                                            height="80">
                                    </figure>
                                    <a href="#" class="btn btn-inquiry btn-rounded btn-icon-left"><i
                                            class="far fa-question-circle"></i>استعلام </a>
                                    <a href="#" class="btn btn-rounded btn-visit">بازدید </a>
                                </div>
                                <!-- End of Store Footer -->
                            </div>
                            <!-- End of Store -->
                        </div>

                        <div class="store-wrap mb-4">
                            <div class="store store-grid store-wcfm">
                                <div class="store-header">
                                    <figure class="store-banner">
                                        <img src="Theme1/assets/images/vendor/dokan/3.jpg" alt="Vendor" width="400"
                                            height="194" style="background-color: #40475E">
                                    </figure>
                                </div>
                                <!-- End of Store Header -->
                                <div class="store-content">
                                    <h4 class="store-title">
                                        <a href="vendor-dokan-store.html">فروشنده 3</a>
                                    </h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 100%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                    </div>
                                    <ul class="seller-info-list list-style-none">
                                        <li class="store-email">
                                            <a href="email:#">
                                                <i class="far fa-envelope"></i>
                                                wolamrtvendor3@email.com
                                            </a>
                                        </li>
                                        <li class="store-phone">
                                            <a href="tel:123456789">
                                                <i class="w-icon-phone"></i>
                                                12312567
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End of Store Content -->
                                <div class="store-footer">
                                    <figure class="seller-brand">
                                        <img src="Theme1/assets/images/vendor/brand/3.jpg" alt="Brand" width="80"
                                            height="80">
                                    </figure>
                                    <a href="#" class="btn btn-inquiry btn-rounded btn-icon-left"><i
                                            class="far fa-question-circle"></i>استعلام </a>
                                    <a href="#" class="btn btn-rounded btn-visit">بازدید </a>
                                </div>
                                <!-- End of Store Footer -->
                            </div>
                            <!-- End of Store -->
                        </div>

                        <div class="store-wrap mb-4">
                            <div class="store store-grid store-wcfm">
                                <div class="store-header">
                                    <figure class="store-banner">
                                        <img src="Theme1/assets/images/vendor/dokan/4.jpg" alt="Vendor" width="400"
                                            height="194" style="background-color: #40475E">
                                    </figure>
                                </div>
                                <!-- End of Store Header -->
                                <div class="store-content">
                                    <h4 class="store-title">
                                        <a href="vendor-dokan-store.html">فروشنده 4</a>
                                    </h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 100%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                    </div>
                                    <ul class="seller-info-list list-style-none">
                                        <li class="store-email">
                                            <a href="email:#">
                                                <i class="far fa-envelope"></i>
                                                wolamrtvendor4@email.com
                                            </a>
                                        </li>
                                        <li class="store-phone">
                                            <a href="tel:123456789">
                                                <i class="w-icon-phone"></i>
                                                123325794
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End of Store Content -->
                                <div class="store-footer">
                                    <figure class="seller-brand">
                                        <img src="Theme1/assets/images/vendor/brand/4.jpg" alt="Brand" width="80"
                                            height="80">
                                    </figure>
                                    <a href="#" class="btn btn-inquiry btn-rounded btn-icon-left"><i
                                            class="far fa-question-circle"></i>استعلام </a>
                                    <a href="#" class="btn btn-rounded btn-visit">بازدید </a>
                                </div>
                                <!-- End of Store Footer -->
                            </div>
                            <!-- End of Store -->
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
        </div>
    </div>
    <!-- End of Page Content -->
@endsection
