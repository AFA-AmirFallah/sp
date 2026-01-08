@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage_shafatel')
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
    </style>
    <h1 class="text-primary">{{ \App\myappenv::DefultPageTitr }} </h1>
    <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
    <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
    <div id="app">
        <shafatel_dashboard></shafatel_dashboard>
    </div>
    <div class="st-seperator">

    </div>

    <div class="title-link-wrapper mb-3">
        <h2 class="title-heading">مطالب پر بازدید</h2>
    </div>
    @php
        $StartMostView = true;
    @endphp

    <section class="product-cart">
        <div class="row list-grid">
            @foreach ($DataSource->MostViewPosts() as $LastPost)
                @if ($StartMostView)
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
                    <div class="list-item col-md-3">
                        <div class="card o-hidden mb-4 d-flex flex-column">
                            <div class="list-thumb d-flex">
                                <img alt="{{ strip_tags($LastPost->Titel) }}" src="{{ $LastPost->MainPic }}">
                            </div>
                            <div class="flex-grow-1 d-bock">
                                <div
                                    class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
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
        $('#request_table').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    </script>

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
