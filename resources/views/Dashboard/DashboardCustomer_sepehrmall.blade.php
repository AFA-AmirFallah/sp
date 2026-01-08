@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage_sepehrmall')
@section('page-header-left')
@endsection
@section('ExtraTags')
    <meta name="description" content="{{ \App\myappenv::description }}">
@endsection
@section('MainCountent')
    <style>
        @keyframes placeHolderShimmer {
            0% {
                background-position: -800px 0
            }

            100% {
                background-position: 800px 0
            }
        }

        .animated-background {
            animation-duration: 2s;
            animation-fill-mode: forwards;
            animation-iteration-count: infinite;
            animation-name: placeHolderShimmer;
            animation-timing-function: linear;
            background-color: #f6f7f8;
            background: linear-gradient(to right, #eeeeee 8%, #bbbbbb 18%, #eeeeee 33%);
            background-size: 800px 104px;
            height: 70px;
            position: relative;
        }

        .swiper-continer {
            width: 100%;
            background-color: red;
            padding: 15px 5px 5px 50px;
            display: inline-flex;
        }

        .sk_bg {
            animation-duration: 1s;
            animation-fill-mode: forwards;
            animation-iteration-count: infinite;
            animation-name: sk_bg_animation;
            animation-timing-function: linear;
            background: #f6f7f8;
            background: linear-gradient(to right, #eee 8%, #ddd 18%, #eee 33%);
            background-size: 800px 104px;
            position: relative;
            width: 100%;
            margin-bottom: 10px;
        }


        @keyframes sk_bg_animation {
            0% {
                background-position: -468px 0
            }

            100% {
                background-position: 468px 0
            }
        }


        .sk_bg.big {
            height: 96px;
        }
    </style>










    <style>
        .nodata {
            background-image: url('https://panel.shafatel.com/storage/photos/icon/nodata.jpeg');
            height: 200px;
            background-repeat: no-repeat;
        }

        .title-heading {
            font-size: 1.4rem;
            font-weight: 700;
            margin-right: 1rem;
            line-height: 1.2rem;
            border-bottom-style: solid;
            border-bottom-color: var(--shafatel-main-background-color);
            width: fit-content;
            padding-bottom: 8px;
            margin-bottom: 1.5rem !important;
        }

        .st-seperator {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .transitionStarted {
            width: 140px;
        }
    </style>
    <h1 class="text-primary">{{ \App\myappenv::DefultPageTitr }} </h1>
    <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
    <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
    <div id="app">
        <sepehrmall_dashboard></sepehrmall_dashboard>
    </div>
    <div class="st-seperator">

    </div>

    <div class="title-link-wrapper mb-3">
        <h2 class="title-heading">مطالب پر بازدید</h2>
    </div>
    @php
        $StartMostView = true;
    @endphp



    <style>
        .product_title {
            font-size: 13px;
            display: block;
            font-weight: 500;
        }

        .lader {
            width: fit-content;
            border-color: darkgray;
            border-width: 2px;
            border-radius: 8px;
            padding: 4px;
            border: 0.1rem solid rgba(35, 71, 251, 0.12);
            margin-bottom: 1.2rem;
            color: blue;
            font-size: 12px;
            font-weight: 600;
        }

        .lader i {
            font-size: 15px;
            font-weight: 400;
        }


        .discount del {
            margin-right: 4px;
            font-size: 16px;
            font-weight: 600;
        }

        .add-to-card {
            left: 10px;
            bottom: 18px;
            position: absolute;
        }

        .add-to-card button {
            background-color: transparent;
            border-color: #567e8c;
            border-style: none;
            color: #567e8c;
            font-size: 22px;
        }

        .discount strong {
            font-size: 20px;
        }

        .jdRqnI {
            display: flex;
        }

        .single-product-card {
            border-style: solid;
            border-width: 1px;
            border-color: #ccd2d7;
        }

        .prices-row {
            display: flex;
        }

        .prices-table {
            border-style: solid;
            border-radius: 5px;
            text-align: center;
        }

        .table {
            display: table;
            width: 100%
        }

        .tr {
            display: table-row;
            text-align: center;
        }

        .td {
            display: table-cell;
            border: 1px solid #ccc;
            padding: 5px;

        }

        .th {
            display: table-cell;
            border: 1px solid #ccc;
            padding: 5px;
            font-weight: 600;
        }

        .step-number {
            font-size: 27px;
            border-style: hidden;
            background-color: transparent;
            text-align: center;
        }

        .step_btn {
            border-radius: 50%;
            padding: 10px;
            padding-top: 15px;
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 50px;
        }

        .main-price-box {
            border-top: 0.1rem dashed rgb(163, 163, 163);
            padding-top: 1.4rem;
            margin-top: 0.2rem;
        }

        .pic-holder {
            border-style: solid;
            border-width: 0 0 0 1px;
            border-color: #ccc;
        }

        .swiper-full {
            width: 100%;
        }

        .swiper-full img {
            border-radius: 20px;
            width: 100%;
            margin: 0 0 15px 0;
        }



        @media (max-width: 768px) {
            .pic-holder {
                border-style: none;

            }

            .tr {
                display: block;
                float: right;
                width: 50%;
                text-align: center;

            }

            .th {
                display: block;
            }

            .td {
                display: block;
            }
        }
    </style>


    <section class="product-cart">
        <div class="row list-grid">
            @foreach ($Product_src as $Product_item)
                <div class="list-item col-md-2">
                    <div class="card single-product-card o-hidden mb-4 d-flex flex-column">
                        <div class="list-thumb d-flex">
                            <img style="width: auto!important;height:auto!important;" alt="product"
                                src="{{ App\Functions\Images::GetPicture($Product_item->ImgURL, 1) }}">
                        </div>
                        <div class="flex-grow-1 d-bock">
                            <div
                                class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                <div class="lader">
                                    <i class="i-Diamond"></i> تخفیف پلکانی
                                </div>

                                <a class="w-500 w-sm-100" href="">
                                    <h2 lines="2" class="product_title">
                                        {{ $Product_item->NameFa }}
                                    </h2>
                                </a>
                                <p class="m-0 text-muted text-small w-15 w-sm-100">

                                </p>
                                <footer class="sc-1q5lmzx-2 jdRqnI">
                                    <div class="discount">
                                        <div><label>٪15</label><del>50٬000
                                            </del></div><span><strong>42٬500 </strong><small>تومان</small></span>
                                    </div>
                                    <div class="add-to-card"><button role="button" data-toggle="modal"
                                            data-target="#product_fast_show" direction="right" font-size="1.4"
                                            height="3">افزودن
                                            به سبد</button></div>

                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="product-cart">
        <div class="row list-grid">
            @foreach ($DataSource->MostViewPosts() as $LastPost)
                @if ($StartMostView)
                    <div class="list-item col-md-3">
                        <div class="card o-hidden mb-4 d-flex flex-column">
                            <div class="list-thumb d-flex">
                                <img alt="{{ strip_tags($LastPost->Titel) }}" src="{{ $LastPost->MainPic }}">
                            </div>
                            <div class="flex-grow-1 d-bock">
                                <div
                                    class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                    @php
                                        if ($LastPost->OutLink == null) {
                                            $news_route = route('ShowNewsItem', [
                                                'NewsId' => $LastPost->id,
                                                'newsitem' => $LastPost->Titel,
                                            ]);
                                        } else {
                                            $news_route = route('ShowNewsItem', ['NewsId' => $LastPost->OutLink]);
                                        }

                                    @endphp
                                    <a class="w-500 w-sm-100" href="{{ $news_route }}">
                                        <div class="item-title">
                                            {{ strip_tags($LastPost->Titel) }}
                                        </div>
                                    </a>
                                    <p class="m-0 text-muted text-small w-15 w-sm-100">تاریخ:
                                        {{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>




    <div id="app">
        <patascustomer></patascustomer>
    </div>
@endsection

@section('page-js')
    <script>
        window.targetpage = 'Dashboard';
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
    </script>
@endsection

@section('bottom-js')
    <script>
        function ChangeOrderStatus($OrderID, $TargetStatus, $TargetStatusName) {
            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            var $oldvalue = $('#status_' + $OrderID).html();
            $('#status_' + $OrderID).html($loader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'ChangeOrderStatus',
                    OrderID: $OrderID,
                    TargetStatus: $TargetStatus,
                },

                function(data, status) {
                    if (data == '1') {
                        $('#status_' + $OrderID).html($TargetStatusName);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                        $('#status_' + $OrderID).html($oldvalue);
                    }
                });


        }

        function DeleteMessage($MessageId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'RemoveSMS',
                    MessageId: $MessageId,
                },

                function(data, status) {
                    if (data == true) {
                        $("#SmsRow_" + $MessageId).addClass("nested");
                    } else {
                        alert('بروز مشکل در انجام عملیات!');

                    }
                });



        }
    </script>
@endsection
