@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Theme2.Layouts.MainLayout')
@section('PageCSS')
    <link rel="stylesheet" href="/T1assets/vendor/css/pages/page-profile.css">
@endsection

@section('Content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> </span> {{ $CatName }}
        </h4>

        <div class="row mb-5">
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
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <img class="card-img-top" src="{{ $RelatedPost->MainPic }}" alt="{{ $RelatedPost->Name }}">
                            <div class="card-header primary-font">
                                <div class="d-flex align-items-start">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar me-3">
                                            <img src="{{ $RelatedPost->Avatar }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div class="me-2">
                                            <h5 class="mb-1"><a
                                                    href="{{ route('ShowNewsItem', ['NewsId' => $RelatedPost->id]) }}"
                                                    class="h5 stretched-link">{{ $RelatedPost->Titel }}</a></h5>
                                            <div class="client-info d-flex align-items-center text-nowrap">
                                                <h6 class="mb-0 me-1">نویسنده:</h6>
                                                <span>{{ $RelatedPost->CreatorName }}
                                                    {{ $RelatedPost->CreatorFamily }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $RelatedPost->Titel }}</h5>
                                <p style="text-align: justify" class="card-text">
                                    {{ $RelatedPost->Abstract }}
                                </p>
                                <a href="{{ route('ShowNewsItem', ['NewsId' => $RelatedPost->id]) }}"
                                    class="btn btn-outline-primary">متن مطلب</a>
                                <p style="float: left;display: flex;">
                                    {{ $Persian->MyPersianDate($RelatedPost->CrateDate) }} </p>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('EndScripts')
    <script src="/T1assets/js/pages-account-settings-account.js"></script>
@endsection
