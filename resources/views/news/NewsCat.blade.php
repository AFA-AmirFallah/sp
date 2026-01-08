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
    <style>


    </style>
    <div class="row">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="block category-listing category-style2">
                    @if ($CoverPost != null)
                        <div class="top-larget-post clearfix">
                            @if ($DataSource->IsAdminLogin())
                                <h5 style="float: left">
                                    <a href="{{ route('EditTagCover', ['TagID' => $CoverPost->id]) }}" target="_blank"> <i
                                            class="fa fa-pencil"></i> </a>
                                </h5>
                            @endif
                            <div style="text-align: center" class="post-thumb">
                                <a href="#">
                                    <img style="max-height: 328px;width: auto;display: inherit;" class="img-responsive"
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
                        @php
                            $posts = $CoverPost;
                        @endphp
                        @include('news.Layouts.SocialLinks')
                    @endif

                    <h3 class="block-title"><span>{{ $CatName }}</span></h3>
                    @if ($RelatedPosts == null)
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
                        @foreach ($RelatedPosts as $RelatedPost)
                            <div class="post-block-style post-list clearfix">
                                <div class="row">
                                    <div class="col-md-5 col-sm-6">
                                        <div class="post-thumb thumb-float-style">
                                            <a href="{{ route('ShowNewsItem', ['NewsId' => $RelatedPost->id]) }}">
                                                <img class="img-responsive" src="{{ $RelatedPost->MainPic }}"
                                                    alt="{{ $RelatedPost->Name }}">
                                            </a>
                                        </div>
                                    </div><!-- Img thumb col end -->
                                    <div class="col-md-7 col-sm-6">
                                        <div style="padding-right: 20px;padding-left:20px;" class="post-content">
                                            <h2 class="post-title title-large">
                                                <a href="{{ route('ShowNewsItem', ['NewsId' => $RelatedPost->id]) }}">
                                                    @if ($RelatedPost->UpTitel != null)
                                                        <h2
                                                            style="font-size: 10px;font-weight: 500;margin-bottom: 0px !important;padding-bottom: 0px !important;margin-top: -10px;">
                                                            {{ $RelatedPost->UpTitel }} </h2>
                                                    @endif
                                                    <h1
                                                        style="
                                                                font-size: 12px;
                                                                @if ($RelatedPost->UpTitel == null) margin-top:-13px; @else margin-top:0px !important; padding-top:0px !important; @endif
                                                                @if ($RelatedPost->SubTitel != null) margin-bottom: -13px; @endif">
                                                        {{ $RelatedPost->Titel }}</h1>
                                                    @if ($RelatedPost->SubTitel != null)
                                                        <h3
                                                            style="font-size: 12px;color: #848383;font-style: normal;margin-top:0px !important; padding-top:0px !important;">
                                                            {{ $RelatedPost->SubTitel }}
                                                        </h3>
                                                    @endif
                                                </a>
                                                @if ($DataSource->IsAdminLogin())
                                                    <h5 style="float: left">
                                                        <a href="{{ route('EditNews', ['NewsID' => $RelatedPost->id]) }}"
                                                            target="_blank"> <i class="fa fa-pencil"></i> </a>
                                                        <a href="{{ route('MakeNews') }}" target="_blank"> <i
                                                                class="fa fa-plus"></i> </a>
                                                    </h5>
                                                @endif
                                            </h2>
                                            <div class="post-meta">
                                                <span class="post-author">{{ $RelatedPost->CreatorName }}
                                                    {{ $RelatedPost->CreatorFamily }}</span>
                                                <span
                                                    class="post-date">{{ $Persian->MyPersianDate($RelatedPost->CrateDate) }}</span>
                                                <span class="post-comment pull-right"><i class="fa fa-comments-o"></i>
                                                    <a href="#"
                                                        class="comments-link"><span>{{ $RelatedPost->CommentCount }}</span></a></span>
                                            </div>
                                            <p class="entry-content" style="text-align: justify">
                                                {!! str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($RelatedPost->Content), 400)) !!}</p>

                                        </div><!-- Post content end -->
                                    </div><!-- Post col end -->
                                </div><!-- 1st row end -->
                            </div><!-- 1st Post list end -->
                        @endforeach
                    @endif
                </div><!-- Block Technology end -->
            </div><!-- Content Col end -->
            @include('news.Layouts.MostView')
        </div><!-- Row end -->
    </div><!-- Row end -->
@endsection
