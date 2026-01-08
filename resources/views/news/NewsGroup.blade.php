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
    <div class="row">
        <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="block category-listing category-style2">
                    @if ($CoverPost != null)
                        <div class="col-md-12 col-sm-12">
                            <div class="top-larget-post clearfix">
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
                        </div>
                    @endif
                    <h3 class="block-title"><span>{{ $CatName }}</span></h3>


                    @foreach ($RelatedPosts as $RelatedPost)
                        <div class="post-block-style post-list clearfix">
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="post-thumb thumb-float-style">
                                        <a href="{{ route('ShowNewsItem', ['newsitem' => $RelatedPost->Name]) }}">
                                            <img class="img-responsive" src="{{ $RelatedPost->MainPic }}"
                                                alt="{{ $RelatedPost->Name }}">
                                        </a>
                                        <a class="post-cat" href="#">{{ $CatName }}</a>
                                    </div>
                                </div><!-- Img thumb col end -->

                                <div class="col-md-7 col-sm-6">
                                    <div class="post-content">
                                        <h2 class="post-title title-large">
                                            <a
                                                href="{{ route('ShowNewsItem', ['newsitem' => $RelatedPost->Name]) }}">{{ $RelatedPost->Name }}</a>
                                            @if ($DataSource->IsAdminLogin())
                                                <a href="{{ route('EditNews', ['NewsID' => $RelatedPost->id]) }}"
                                                    target="_blank"> <i class="fa fa-pencil"></i> </a>
                                                <a href="{{ route('MakeNews') }}" target="_blank"> <i
                                                        class="fa fa-plus"></i> </a>
                                            @endif
                                        </h2>
                                        <div class="post-meta">
                                            <span class="post-author">{{ $RelatedPost->CreatorName }}
                                                {{ $RelatedPost->CreatorFamily }}</span>
                                            <span
                                                class="post-date">{{ $Persian->MyPersianDate($RelatedPost->created_at) }}</span>
                                            <span class="post-comment pull-right"><i class="fa fa-comments-o"></i>
                                                <a href="#"
                                                    class="comments-link"><span>{{ $RelatedPost->CommentCount }}</span></a></span>
                                        </div>
                                        <p style="text-align: justify">
                                            {{ App\Functions\TextClassMain::StripText($RelatedPost->Content) }}</p>
                                        <p style="font-size: 12px;color:blue">
                                            {{ str_replace(',', ' #', '#' . $RelatedPost->indexname) }} </p>
                                    </div><!-- Post content end -->
                                </div><!-- Post col end -->
                            </div><!-- 1st row end -->
                        </div><!-- 1st Post list end -->
                    @endforeach
                </div><!-- Block Technology end -->




            </div><!-- Content Col end -->

            @include('news.Layouts.MostView')

        </div><!-- Row end -->




    </div><!-- Row end -->
@endsection
