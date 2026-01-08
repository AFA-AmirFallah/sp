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
    </style>

    <input id="main_url" class="nested" value="{{ url('/') }}">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ route('home') }}">صفحه اصلی </a></li>
                <li><a href="#">فروشگاه </a></li>

            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of Page Content -->
    <div class="page-content">
        <div class="container">
            <!-- Start of Shop Content -->
            <div class="shop-content row gutter-lg mb-10">
                <!-- Start of Sidebar, Shop Sidebar -->
                <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                    <!-- Start of Sidebar Overlay -->
                    <div class="sidebar-overlay"></div>
                    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                    <!-- Start of Sidebar Content -->
                    <div class="sidebar-content scrollable">
                        <!-- Start of Sticky Sidebar -->
                        <div class="sticky-sidebar">
                            <div class="filter-actions">
                                <label>فیلتر : </label>
                                <a onclick="loadindexmenu()" class="btn btn-dark btn-link filter-clean">حذف همه </a>
                            </div>
                            <!-- Start of Collapsible widget -->
                            <div id="indexmenu" class="widget widget-collapsible"
                                style="
                            cursor: pointer;
                        ">

                            </div>
                            <!-- End of Collapsible Widget -->

                            <!-- Start of Collapsible Widget -->
                            <div class="nested widget widget-collapsible">
                                <h3 class="widget-title"><span>قیمت </span></h3>
                                <div class="widget-body">
                                    <ul class="filter-items search-ul">
                                        <li><a href="#">0 تومان - 100000 تومان</a></li>
                                        <li><a href="#">100000 تومان - 200000 تومان</a></li>
                                        <li><a href="#">200000 تومان - 300000 تومان</a></li>
                                        <li><a href="#">300000 تومان - 590000 تومان</a></li>
                                        <li><a href="#">590000 تومان+</a></li>
                                    </ul>
                                    <form class="price-range">
                                        <input type="number" name="min_price" class="min_price text-center"
                                            placeholder="حداقل به تومان"><span class="delimiter">-</span><input
                                            type="number" name="max_price" class="max_price text-center"
                                            placeholder="حداکثر به تومان"><a href="#"
                                            class="btn btn-primary btn-rounded">برو </a>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <!-- End of Sidebar Content -->
                    </div>
                    <!-- End of Sidebar Content -->
                </aside>
                <!-- End of Shop Sidebar -->

                <!-- Start of Shop Main Content -->
                <div class="main-content">
                    <nav class="toolbox sticky-toolbox sticky-content fix-top">
                        <div class="toolbox-left">
                            <a href="#"
                                class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle
                                        btn-icon-left d-block d-lg-none"><i
                                    class="w-icon-category"></i><span>فیلتر </span></a>
                            <div class="toolbox-item toolbox-sort select-box text-dark">
                                <label>مرتب سازی بر اساس: </label>
                                <select id="orderselect" name="orderby" class="form-control">
                                    <option value="default" selected="selected">مرتب سازی پیش فرض</option>
                                    <option value="last">مرتب سازی بر اساس جدید ترین محصولات</option>
                                    <option value="view">مرتب سازی بر اساس بیشترین تخفیفات</option>
                                    <option value="view">مرتب سازی بر اساس محبوبیت</option>
                                    <option value="cheap">مرتب سازی بر اساس قیمت: کم به زیاد</option>
                                    <option value="expensive">مرتب سازی بر اساس قیمت: زیاد به کم</option>
                                </select>
                            </div>
                        </div>
                        <div class="toolbox-right">
                            {{-- <div class="toolbox-item toolbox-show select-box">
                                <select name="count" class="form-control">
                                    <option value="9">نمایش 9</option>
                                    <option value="12" selected="selected">نمایش 12</option>
                                    <option value="24">نمایش 24</option>
                                    <option value="36">نمایش 36</option>
                                </select>
                            </div> --}}
                            {{-- <div class="toolbox-item toolbox-layout">
                                <a href="shop-banner-sidebar.html" class="icon-mode-grid btn-layout active">
                                    <i class="w-icon-grid"></i>
                                </a>
                                <a href="shop-list.html" class="icon-mode-list btn-layout">
                                    <i class="w-icon-list"></i>
                                </a>
                            </div> --}}
                        </div>
                    </nav>
                    <div id="data_temp" class="product-wrapper row cols-md-3 cols-sm-2 cols-2">

                    </div>
                    <div id="no_data" class="nested no-data text-center mb-4">
                        <hr>
                    </div>
                    <div id="no_data_list" class="nested no-data text-center mb-4 mt-5">
                        <svg width="70" height="70" viewBox="0 0 70 70" fill="none">
                            <path
                                d="M35.0011 42.6094C29.328 42.6094 23.9243 45.0122 20.1717 49.2031C19.6117 49.83 19.665 50.7902 20.2904 51.3518C20.5795 51.612 20.9432 51.7398 21.3054 51.7398C21.7224 51.7398 22.1393 51.5694 22.4391 51.2331C25.615 47.6859 30.1939 45.6529 35.0011 45.6529C39.8097 45.6529 44.3887 47.6859 47.563 51.2331C48.123 51.86 49.0863 51.9118 49.7117 51.3518C50.3371 50.7918 50.3904 49.83 49.8304 49.2031C46.0793 45.0137 40.6756 42.6094 35.0011 42.6094Z"
                                fill="#A6A4A4"></path>
                            <path
                                d="M35 0C15.6998 0 0 15.7013 0 35C0 54.2987 15.6998 70 35 70C54.3002 70 70 54.2987 70 35C70 15.7013 54.3002 0 35 0ZM35 66.9565C17.3798 66.9565 3.04348 52.6217 3.04348 35C3.04348 17.3783 17.3798 3.04348 35 3.04348C52.6202 3.04348 66.9565 17.3783 66.9565 35C66.9565 52.6217 52.6202 66.9565 35 66.9565Z"
                                fill="#A6A4A4"></path>
                            <path
                                d="M53.2601 24.3477C52.4186 24.3477 51.7384 25.0294 51.7384 25.8694C51.7384 28.3864 49.6901 30.4346 47.1732 30.4346C44.6562 30.4346 42.6079 28.3864 42.6079 25.8694C42.6079 25.0294 41.9277 24.3477 41.0862 24.3477C40.2447 24.3477 39.5645 25.0294 39.5645 25.8694C39.5645 30.0648 42.9777 33.4781 47.1732 33.4781C51.3686 33.4781 54.7819 30.0648 54.7819 25.8694C54.7819 25.0294 54.1016 24.3477 53.2601 24.3477Z"
                                fill="#A6A4A4"></path>
                            <path
                                d="M30.4342 25.8694C30.4342 25.0294 29.754 24.3477 28.9124 24.3477C28.0709 24.3477 27.3907 25.0294 27.3907 25.8694C27.3907 28.3864 25.3424 30.4346 22.8255 30.4346C20.3085 30.4346 18.2603 28.3864 18.2603 25.8694C18.2603 25.0294 17.5801 24.3477 16.7385 24.3477C15.897 24.3477 15.2168 25.0294 15.2168 25.8694C15.2168 30.0648 18.6301 33.4781 22.8255 33.4781C27.0209 33.4781 30.4342 30.0648 30.4342 25.8694Z"
                                fill="#A6A4A4"></path>
                        </svg>
                        <p>هیچ کالایی موجود نیست</p>
                    </div>
                    <div id="show_more_data" class="nested container237">



                        <button class="btn btn-dark btn-rounded btn-sm mb-4 " onclick="lazyLoad()"> مشاهده محصولات بیشتر
                        </button>
                    </div>

                </div>
                <!-- End of Shop Main Content -->
            </div>
            <!-- End of Shop Content -->
        </div>
    </div>
    <!-- End of Page Content -->
@endsection
@section('page-js')
    <script>
        window.loaddatainit = false;
        window.count = 0; //if counter = 0 means in page ProductListFeild have no goods to show

        function show_moredata($Condition) {
            if ($Condition == 1) {
                window.count++;
                $('#show_more_data').removeClass('nested');
                if (!window.loaddatainit) {
                    $('#no_data').addClass('nested');
                }

                return 0;
            }
            if ($Condition == 2) {
                if (window.count == 0) {
                    $('#no_data_list').removeClass('nested');

                } else {
                    $('#no_data').removeClass('nested');

                }
                $('#show_more_data').addClass('nested');
                return 0;
            }
            if ($Condition == 3) {
                window.count++;
                $('#no_data').addClass('nested');
                $('#show_more_data').addClass('nested');
                return 0;
            }

        }
    </script>
    <script>
        window.order = 'defult';
        window.page = 1;
        window.orderchange = false;
        $('#orderselect').on('change', function() {
            window.order = this.value;
            window.orderchange = true;
            lazyLoad(1);
        });
    </script>
    <script>
        function getpage() {
            return window.page;
        }

        function getnextPage() {
            window.page = window.page + 1;
            return window.page;
        }
    </script>
    <script>
        function l3load(l1id, l2id, header, L1Name) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    menu: 'l3',
                    l1: l1id,
                    header: header + ' - ' + L1Name,
                    l2: l2id
                },

                function(data, status) {
                    if (status == 'success') {
                        $('#indexmenu').html(data);

                    } else {
                        alert('بروز خطا');
                    }


                });

        }

        function l2load(l1id, L1Name) {
            $.ajax({
                url: '?menu=l2&l1=' + l1id + '&l1nmae=' + L1Name,
                type: 'GET',
                beforeSend: function() {},
                success: function(response) {
                    $('#indexmenu').html(response);
                }
            });
        }

        function loadindexmenu() {
            $.ajax({
                url: '?menu=l1',
                type: 'GET',
                beforeSend: function() {},
                success: function(response) {
                    $('#indexmenu').html(response);
                }
            });

        }

        function number_format(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        <?php if (isset($searchstr)) {
            echo "let searchstr = '&q=$searchstr' ;";
        } else {
            echo "let searchstr = '' ;";
        }
        ?>
        let rate = parseInt($('#curency_rate').val());
        let curency = $('#curency_name').val();
        let pages = 2;
        let current_page = 0;
        let SingleProductAddress = $('#main_url').val() + '/product/';
        let bool = false;
        let lastPage = 1;
        $(window).scroll(function() {
            let height = $(document).height();
            if ($(window).scrollTop() + $(window).height() >= height && bool == false) {
                bool = true;
                $('.ajax-load').show();
                pages = getpage();
                lazyLoad()
                    .then(() => {
                        bool = false;
                    })
            }
        })


        function lazyLoad() {

            return new Promise((resolve, reject) => {

                if (window.orderchange) {
                    page = getnextPage();
                    $url = '?page=' + page + '&sort=' + window.order + searchstr;
                } else {
                    page = getnextPage();
                    $url = '?page=' + page + searchstr;
                }
                $.ajax({
                    url: $url,
                    type: 'GET',
                    beforeSend: function() {
                        $('.ajax-load').show();
                    },
                    success: function(response) {
                        $('.ajax-load').hide();
                        let html = '';
                        if (window.orderchange) {
                            window.orderchange = false;
                            $('#data_temp').html(response);
                        } else {
                            $('#data_temp').append(response);
                        }

                        resolve();
                    }
                });
            })
        }
        loadData(1);

        function loadData(page) {
            $.ajax({
                url: '?page=' + page + '&sort=' + window.order + searchstr,
                type: 'GET',
                beforeSend: function() {
                    $('.ajax-load').show();
                },
                success: function(response) {
                    $('.ajax-load').hide();

                    lastPage = 1;
                    $('#data_temp').html(response);
                }
            });
            loadindexmenu();
        }

        function GetPercent(BasePrice, Price, Remain) {
            if (parseInt(Remain) > 0) {
                BasePrice = parseInt(BasePrice);
                Price = parseInt(Price);
                if (BasePrice == 0) {
                    return '';
                }
                $Percent = Math.round(((BasePrice - Price) * 100) / BasePrice);
                return $Percent;
            } else {
                return '';
            }
        }

        function GetPrice(BasePrice, Price, Remain) {
            if (parseInt(Remain) > 0) {
                BasePrice = parseInt(BasePrice);
                Price = parseInt(Price);
                $Percent = Math.round(((BasePrice - Price) * 100) / BasePrice);

                BasePrice /= rate;
                Price /= rate;

                if (BasePrice > 0 && BasePrice != Price) {
                    // Product Has discount
                    BasePrice = number_format(BasePrice);
                    Price = number_format(Price);
                    return `
                    <div class="product-pa-wrapper">
                <div class="product-price">

                        <div style="float:left;white-space: nowrap;">
                            <div class="discount_main">
                                <del class="old-price">
                                    ` + BasePrice + `
                                </del>
                            </div>
                            ` + Price + ` ` + curency + `
                        </div>
                </div>
            </div>
`;
                } else {
                    Price = number_format(Price);
                    // Product Without Discount
                    return `<div class="product-pa-wrapper">
                <div class="product-price">

                        <div style="float:left;white-space: nowrap;">
                            <div class="discount_main">

                            </div>
                            ` + Price + ` ` + curency + `
                        </div>
                </div>
            </div>
`;
                }

            } else {
                return `
                <div class="product-pa-wrapper">
                <div class="product-price">
                        <p style="color: red !important" class="m-0 text-small text-muted">
                            تمام شده! </p>
                </div>
            </div>`;
            }

        }
    </script>
@endsection
