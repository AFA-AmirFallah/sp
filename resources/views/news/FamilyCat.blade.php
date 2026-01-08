@php
    $Persian = new App\Functions\persian();
@endphp
@extends('news.Layouts.MainLayout')
@section('trending')
    @include('news.Layouts.HotNews')
@endsection
@section('page-title')
@endsection
@section('container')
    <div class="ul-card-list__modal">
        <div class="modal fade modal_detail_to_confirm_work" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div id="modal_content" class="modal-content">
                    <div id="Modaldiv" style="text-align: center" class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <section style="margin-top: 20px;" class="list-news-wrapper block-wrapper">
        <div style="margin-right: -15px" class="container">
            <div style="margin-left: 15px" class="row">
                <div style="margin-right: 15px" class="slider-div col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="latest-news block">
                        <h3 style="margin-top: -30px" class="block-title"><span>رسته های خانواده فرش</span></h3>

                        <div id="latest-news-slide" style="text-align: center;"
                            class="slides-continner owl-carousel owl-theme latest-news-slide">
                            @php
                                $mostviewconter = 1;
                                $CatPic = '';
                            @endphp
                            @foreach ($FamilyClass->get_family_index() as $TargetIndex)
                                @if ($TargetIndex->Name == $CatName)
                                    @php
                                        $CatPic = $TargetIndex->img;
                                    @endphp
                                @endif
                                @if ($mostviewconter % 2 != 0)
                                    <div class="item">
                                        <ul class="list-post">
                                            <li style="max-width: 100px" class="clearfix">
                                                <div class="post-block-style clearfix">
                                                    <div style="border-radius: 15%" class="post-thumb">
                                                        <a
                                                            href="{{ route('familycat', ['familycat' => $TargetIndex->Name]) }}"><img
                                                                class="img-responsive" src="{{ $TargetIndex->img }}"
                                                                alt="{{ $TargetIndex->Name }}"></a>
                                                    </div>
                                                    <div class="post-content" style="height: 55px;">
                                                        <h2 class="text-mian post-title title-medium">
                                                            <a class="text-mian"
                                                                href="{{ route('familycat', ['familycat' => $TargetIndex->Name]) }}">{{ $TargetIndex->Name }}</a>
                                                        </h2>
                                                    </div><!-- Post content end -->
                                                </div><!-- Post Block style end -->
                                            </li><!-- Li end -->
                                        @else
                                            <div class="gap-20"></div>

                                            <li style="max-width: 100px" class="clearfix">
                                                <div class="post-block-style clearfix">
                                                    <div style="border-radius: 15%" class="post-thumb">
                                                        <a
                                                            href="{{ route('familycat', ['familycat' => $TargetIndex->Name]) }}"><img
                                                                class="img-responsive" src="{{ $TargetIndex->img }}"
                                                                alt=""></a>
                                                    </div>
                                                    <div class="post-content" style="height: 55px;">
                                                        <h2 class="text-mian post-title title-medium">
                                                            <a class="text-mian"
                                                                href="{{ route('familycat', ['familycat' => $TargetIndex->Name]) }}">{{ $TargetIndex->Name }}</a>
                                                        </h2>
                                                    </div><!-- Post content end -->
                                                </div><!-- Post Block style end -->
                                            </li><!-- Li end -->
                                        </ul><!-- List post 1 end -->

                                    </div><!-- Item 1 end -->
                                @endif
                                @php
                                    $mostviewconter++;
                                @endphp
                            @endforeach

                        </div><!-- Latest News owl carousel end-->
                    </div>
                    <!--- Latest news end -->

                </div><!-- Content Col end -->

            </div><!-- Row end -->
        </div><!-- Container end -->
    </section><!-- First block end -->



    <div class="row">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="block category-listing category-style2">
                    @if ($CoverPost != null)
                        <div class="top-larget-post clearfix">
                            <div style="border-radius: 50%" style="text-align: center" class="post-thumb">
                                <a href="#">
                                    <img style="max-height: 128px;width: auto;display: inherit;" class="img-responsive"
                                        src="{{ $CoverPost->MainPic }}" alt="">
                                </a>
                            </div>
                            <div class="post-content">
                                <h2 class="post-title title-large">
                                    <a href="#">{!! $CoverPost->Titel !!}</a>
                                </h2>
                                <p>{!! $CoverPost->Content !!} </p>
                            </div><!-- Post content end -->
                        </div><!-- Post Block style end -->
                    @endif
                    <style>
                        .fmily-pic {
                            border-radius: 50%;
                            width: 100px;
                            height: 100px;
                        }

                        .back-img {
                            border-radius: 50%;
                            width: 130px;
                            height: 130px;
                            background-color: white;
                            position: absolute;
                            margin-top: -55px;
                            margin-right: -97px;
                        }

                        .back-img-2 {
                            border-radius: 50%;
                            width: 130px;
                            height: 130px;
                            background-color: white;
                            position: relative;
                            margin-top: -17px;
                            margin-right: -97px;
                        }

                        .desc-continer {
                            margin-top: 32px;
                        }

                        .family-title {
                            display: inline-flex;
                            width: 100%
                        }

                        .family-name-continer {
                            background-color: #d0d0d0;
                            height: 100px;
                            padding-top: 40px;
                            padding-right: 10px;
                            width: 100%;
                            margin-right: -35px;
                            display: inline-flex;
                        }

                        .family-desc-continer {
                            background-color: #e2e9a0;
                            height: 100px;
                            padding-right: 10px;
                            width: 100%;
                            margin-right: -35px;
                            display: inline-flex;
                        }

                        .family-name {
                            margin-right: 48px;
                            font-size: 18px;

                        }

                        .pic-div-family {
                            z-index: 30;
                        }
                    </style>
                    <div class="family-title">
                        <div class="pic-div-family">
                            <img class="fmily-pic" src="{{ $CatPic }}" alt="">
                        </div>
                        <div class="family-name-continer">
                            <div class="back-img"></div>
                            <div class="family-name"> {{ $CatName }}</div>
                        </div>
                    </div>
                    @if ($FamilySrc == null)
                        <div class="post-block-style post-list clearfix">
                            <br>
                            @if ($searchmode)
                                <div style="margin-right: 10px" class="row">
                                    نتیجه ای برای جستجو وجود ندارد!
                                </div><!-- 1st row end -->
                            @else
                                <div style="margin-right: 10px" class="row">
                                    در این دسته محتوایی وارد نشده است!
                                </div><!-- 1st row end -->
                            @endif
                        </div><!-- 1st Post list end -->
                    @else
                        <div class="col-xl-8 col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="ul-widget__head">
                                        <div class="ul-widget__head-label">
                                            <h3 class="ul-widget__head-title">
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="ul-widget__body">
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="ul-widget5-tab1-content">
                                                <div class="ul-widget5">
                                                    @foreach ($FamilySrc as $FamilyItem)
                                                        <div class="family-title">
                                                            <div class="pic-div-family">
                                                                <img class="fmily-pic" src="{{ $FamilyItem->Pic }}"
                                                                    alt="{{ $FamilyItem->Titel }}">
                                                            </div>
                                                            <div class="family-desc-continer">
                                                                <div class="back-img-2"></div>
                                                                <div style="padding: 3px" class="family-name">
                                                                    <small class="ul-widget5__desc">
                                                                        {{ $FamilyItem->UpTitel }}
                                                                    </small>
                                                                    <a href="" class="ul-widget4__title">
                                                                        {{ $FamilyItem->Titel }}
                                                                    </a>
                                                                    <p class="ul-widget5__desc">
                                                                        {{ $FamilyItem->SubTitel }}
                                                                    </p>

                                                                    <div style="font-size: 13px ; margin-top:16px"
                                                                        class="show">
                                                                        <a style="
                                                                        border-style: ridge;
                                                                        margin-right: 10px;
                                                                        padding: 3px;
                                                                    "
                                                                            onclick="showItem( '{{ $FamilyItem->UserName }}' )">نمایش
                                                                            اطلاعات</a>


                                                                        <a style="
                                                                       border-style: ridge;
                                                                       margin-right: 10px;
                                                                       padding: 3px;
                                                                   "
                                                                            onclick="showInfo( '{{ $FamilyItem->UserName }}' )">نمایش
                                                                            توضیحات</a>
                                                                        @if ($FamilyItem->target_url != null)
                                                                            <a style="
                                                                        border-style: ridge;
                                                                        margin-right: 10px;
                                                                        padding: 3px;
                                                                    "
                                                                                href="/{{ $FamilyItem->target_url }}">صفحه
                                                                                کسب و کار
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="desc-continer nested"
                                                            id="{{ $FamilyItem->UserName }}_continer">

                                                        </div>
                                                        <div class="ul-widget5__item ">
                                                            <div style="display: flex" class="ul-widget5__content">

                                                                @if ($DataSource->IsAdminLogin())
                                                                    <h5 style="float: left">
                                                                        <a href="{{ route('myprofile', ['RequestUser' => $FamilyItem->UserName]) }} "
                                                                            target="_blank"> <i class="fa fa-pencil"></i>
                                                                        </a>

                                                                    </h5>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    @endforeach


                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div><!-- Block Technology end -->
            </div><!-- Content Col end -->
            @include('news.Layouts.MostView')
        </div><!-- Row end -->
    </div><!-- Row end -->

    <script>
        function showItem($UserName) {
            $.ajax({
                url: '?page=info&uid=' + $UserName,
                type: 'get',
                beforeSend: function() {
                    $('#' + $UserName + '_continer').removeClass('nested');
                    $('#' + $UserName + '_continer').html('درحال دریافت اطلاعات...');
                },
                success: function(response) {
                    $('#' + $UserName + '_continer').html(response);

                },
                error: function() {
                    alert(' بروز مشکل در برقراری ارتباط');
                }
            });

        }

        function showInfo($UserName) {
            $.ajax({
                url: '?page=InfoTxt&uid=' + $UserName,
                type: 'get',
                beforeSend: function() {
                    $('#' + $UserName + '_continer').removeClass('nested');
                    $('#' + $UserName + '_continer').html('درحال دریافت اطلاعات...');
                },
                success: function(response) {
                    $('#' + $UserName + '_continer').html(response);

                },
                error: function() {
                    alert(' بروز مشکل در برقراری ارتباط');
                }
            });

        }

        function showPersonel($UserName) {
            $.ajax({
                url: '?page=info&uid=' + $UserName,
                type: 'get',
                beforeSend: function() {
                    $('#' + $UserName + '_continer').removeClass('nested');
                    $('#' + $UserName + '_continer').html('درحال دریافت اطلاعات...');
                },
                success: function(response) {
                    $('#' + $UserName + '_continer').html(response);

                },
                error: function() {
                    alert(' بروز مشکل در برقراری ارتباط');
                }
            });

        }
    </script>

@endsection
