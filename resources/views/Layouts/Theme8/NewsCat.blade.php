@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme8.layout.main_layout')
@section('content')
    <section class="search-result-services">
        <div class="container-xxl flex-grow-1 container-p-y">

            <section class="result-services mb-4">
                <div class="container">
                    <h2 class="title-result mb-2">
                        نمایش نتایج جستجو {{ $CatName }}
                    </h2>
                    <div class="row">
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
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('ShowNewsItem', ['NewsId' => $RelatedPost->id]) }}"
                                        class="service bg-white">
                                        <div class="img">
                                            <img class="w-100" src="{{ $RelatedPost->MainPic }}"
                                                alt="{{ $RelatedPost->Name }}">
                                            <div class="s-type text-one-line text-white text-center p-2">
                                                {{ $RelatedPost->Titel }}
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div class="s-name text-one-line mb-2">
                                                {{ $RelatedPost->CreatorName }}
                                                {{ $RelatedPost->CreatorFamily }}
                                            </div>
                                            <div class="star-rate d-inline-flex mb-2">
                                                <!-- set width inline style!! -->

                                            </div>
                                            <div class="s-location d-flex pb-2 mb-3">
                                                <div class="text-one-line">
                                                    {{ $RelatedPost->Titel }}
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="s-price text-green font-bold">
                                                    <span>{{ $Persian->MyPersianDate($RelatedPost->CrateDate) }}</span>
                                                </div>
                                                <button href="{{ route('ShowNewsItem', ['NewsId' => $RelatedPost->id]) }}"
                                                    class="btn-view font-semibold mr-auto">
                                                    مشاهده جزئیات
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
@section('EndScripts')
@endsection
