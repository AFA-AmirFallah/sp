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
                <li><a href="#">خدمات</a></li>

            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of Page Content -->
    <div class="page-content">

        <div class="container">
            <!-- Start of Shop Content -->
            <div>

                <div class="main-content">
                    <div id="data_temp" class="product-wrapper row cols-md-3 cols-sm-2 cols-2">
                        @php
                            $Conter = 0;
                        @endphp

                        @foreach ($cat_orders as $cat_orders_item)
                            @php
                                $Conter++;
                            @endphp
                            @if ($cat_orders_item->centers > 0)
                                <div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="{{ route('CustomerOrder', ['OrderID' => $cat_orders_item->Cat]) }}">
                                                <img src="{{ $cat_orders_item->Pic }}"
                                                    alt="{{ $cat_orders_item->TitleDescription }}" />
                                            </a>
                                        </figure>
                                        <div class="product-details">
                                            <h3 class="product-name">

                                                <a
                                                    href="{{ route('CustomerOrder', ['OrderID' => $cat_orders_item->Cat]) }}">{{ $cat_orders_item->TitleDescription }}</a>
                                            </h3>

                                            <div class="st-blog-label"> {{ $cat_orders_item->centers }} <a
                                                    href="{{ route('CustomerOrder', ['OrderID' => $cat_orders_item->Cat]) }}">مرکز
                                                    ارائه دهنده</div>
                                            @if ($cat_orders_item->centers > 0)
                                                <div style="margin: 10px" class="product-pa-wrapper">
                                                    <div class="product-price">
                                                        <button style="border-radius: 5px" class="btn btn-primary">ورود به سامانه</button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="product-pa-wrapper">
                                                    <div class="product-price">
                                                        <p style="color: red !important" class="m-0 text-small text-muted">
                                                            ارائه دهنده خدمت وجود ندارد </p>
                                                    </div>
                                                </div>
                                            @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if ($Conter == 0)
                            <script>
                                show_moredata(2);
                            </script>
                        @elseif ($Conter == 10)
                            <script>
                                window.loaddatainit = true;
                                show_moredata(1);
                            </script>
                        @else
                            <script>
                                window.loaddatainit = true;
                                show_moredata(3);
                            </script>
                        @endif
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
@endsection
