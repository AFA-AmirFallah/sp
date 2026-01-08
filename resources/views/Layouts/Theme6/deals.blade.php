@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')

@section('MainTitle')
    {{ $page_title }}
@endsection

@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="{{ \App\myappenv::SiteAddress }}/{{ Request::path() }}" />
    <meta property="og:image" content="" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection

@section('content')
    <style>
        .cate-title {
            cursor: pointer;
            padding-top: 12px;
            padding-right: 6px;
            background-color: #be2026;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cate-title:hover {
            background-color: #be2026;
        }

        .checkbox-categories {
            padding-left: 20px;
            margin-top: 10px;
        }

        /* انیمیشن برای فلش */
        .cate-title.collapsing .fa-chevron-down,
        .cate-title.collapsing .fa-chevron-up {
            transition: transform 0.3s ease;
        }

        .cate-title.collapsed .fa-chevron-down {
            transform: rotate(0deg);
            /* فلش رو به پایین */
        }

        .cate-title:not(.collapsed) .fa-chevron-down {
            transform: rotate(180deg);
            /* فلش رو به بالا */
        }

        .checkbox-categories {
            padding-left: 20px;
            margin-top: 10px;
        }

        .cate-list {
            list-style: none;
            padding: 0;
            max-height: 250px;
            overflow: hidden;
        }

        .cate-list li {
            margin-bottom: 12px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cate-list li:hover {
            background-color: #f1f1f1;
        }

        /* دکمه بارگذاری بیشتر */
        .load-more-btn {
            background-color: #be2026;
            color: white;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .load-more-btn:hover {
            background-color: #d78b00;
        }

        .checkbox-categories label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
            cursor: pointer;
            background: #f9f9f9;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .checkbox-categories label:hover {
            background: #f0f0f0;
        }

        .checkbox-categories input[type="checkbox"] {
            margin-left: 10px;
            width: 18px;
            height: 18px;
        }

        .modal-content {
            border-radius: 8px;
            overflow: hidden;
            padding: 20px;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 15px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .close {
            color: #aaa;
            font-size: 30px;
        }

        .close:hover {
            color: #333;
            cursor: pointer;
        }

        /* استایل برای فیلترها */
        .productsearchforma {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .productsearchforma input[type="text"] {
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 14px;
            color: #555;
        }

        .productsearchforma button {
            background-color: #be2026;
            color: white;
            border: none;
            padding: 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }



        /* استایل لیست فیلترها */
        .cate-list {
            list-style: none;
            padding: 0;
        }

        .cate-list li {
            margin-bottom: 12px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cate-list li:hover {
            background-color: #f1f1f1;
        }

        /* استایل چک‌باکس‌ها */
        .checkbox-categories label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 6px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .checkbox-categories label:hover {
            background-color: #e0e0e0;
        }

        .checkbox-categories input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin: 0;
        }

        /* استایل دکمه فیلتر در موبایل */
        .btn-warning {
            background-color: #f7a600;
            color: white;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 6px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #d78b00;
        }

        /* استایل برای بخش محتوا */
        .modal-body {
            max-height: 80vh;
            overflow-y: auto;
        }

        /* استایل برای کادر دکمه بستن Modal */
        .modal-footer {
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #dee2e6;
            padding: 15px;
        }
    </style>

    <!-- Start Single Shop -->
    <section class="shop-section ptb-100">
        <div class="container">
            <h1 class="deal-title"> {{ $page_title }} </h1>

            <!-- دکمه فیلترها فقط در موبایل -->
            <button class="btn btn-warning d-lg-none mb-3" type="button" data-toggle="modal"
                data-target="#mobileFiltersModal">
                فیلترها
            </button>

            <div class="row">
                <!-- فیلترهای سمت راست در دسکتاپ -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="right-shop">
                        <div class="productsearchforma">
                            <form method="GET" action="{{ url()->current() }}" id="searchForm">
                                <input type="text" name="q" value="{{ $search ?? '' }}"
                                    placeholder="جستجوی آگهی...">
                                <button type="submit">جستجو</button>

                                <div class="category-wrapper">
                                    <div class="cate-box">
                                        <div class="cate-title">
                                            <h3 style="color: #fff"> نوع آگهی </h3>
                                        </div>
                                        <ul class="cate-list">
                                            @foreach ($deal_functions->get_product_type() as $product_type)
                                                <li>
                                                    <a href="{{ route('deals', ['cat' => $product_type->id]) }}">
                                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                        {{ $product_type->Name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="category-wrapper">
                                    <div class="cate-box">
                                        <div class="cate-title">
                                            <h3 style="color: #fff">دسته بندی ها</h3>
                                        </div>
                                        <div class="checkbox-categories">
                                            @foreach ($deal_functions->get_post_cats() as $cat)
                                                <label>
                                                    <input type="checkbox" name="cat_id" value="{{ $cat->UID }}"
                                                        onchange="document.getElementById('searchForm').submit()"
                                                        {{ request('cat_id') == $cat->UID ? 'checked' : '' }}>
                                                    {{ $cat->Name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @php
                    $file_id = 0;
                @endphp

                <!-- بخش نمایش آگهی‌ها -->
                <div class="col-lg-9">
                    <div class="left-shop">
                        <div class="row">
                            @foreach ($file_src as $file_item)
                                @if ($file_item->id != $file_id)
                                    @include('Layouts.Theme6.Layout.deal_item')
                                    @php
                                        $file_id = $file_item->id;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($file_id == 0)
                                <div class="col-12">
                                    <p>هیچ آگهی‌ای یافت نشد.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal فیلترها برای موبایل -->
    <div class="modal fade" id="mobileFiltersModal" tabindex="-1" role="dialog" aria-labelledby="mobileFiltersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mobileFiltersModalLabel">فیلتر آگهی‌ها</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="بستن">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="productsearchform">
                        <form method="GET" action="{{ url()->current() }}" id="searchFormMobile">
                            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="جستجوی آگهی...">
                            <button type="submit">جستجو</button>

                            <div class="category-wrapper">
                                <div class="cate-box">
                                    <div class="cate-title mt-3">
                                        <h3 style="color: #fff">نوع آگهی</h3>
                                    </div>
                                    <ul class="cate-list">
                                        @foreach ($deal_functions->get_product_type() as $product_type)
                                            <li>
                                                <a href="{{ route('deals', ['cat' => $product_type->id]) }}">
                                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                    {{ $product_type->Name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="category-wrapper">
                                <div class="cate-box">
                                    <div class="cate-title" data-toggle="collapse" data-target="#categoryList"
                                        aria-expanded="false" aria-controls="categoryList">
                                        <h3 style="color: #fff">دسته بندی ها</h3>
                                        <!-- فلش آیکون -->
                                        <i class="fa fa-chevron-down float-left ml-2"></i>
                                    </div>
                                    <div id="categoryList" class="collapse">
                                        <div class="checkbox-categories">
                                            @foreach ($deal_functions->get_post_cats() as $cat)
                                                <label>
                                                    <input type="checkbox" name="cat_id" value="{{ $cat->UID }}"
                                                        onchange="document.getElementById('searchFormMobile').submit()"
                                                        {{ request('cat_id') == $cat->UID ? 'checked' : '' }}>
                                                    {{ $cat->Name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Bootstrap JS (همراه با Popper) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
