@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')
@section('MainTitle')
    {{ $posts->Titel }}
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="{{ $posts->Titel }}" />
    <meta property="og:url" content="{{ \App\myappenv::SiteAddress }}/{{ Request::path() }}" />
    <meta property="og:site_name" content="{{ \App\myappenv::CenterName }}" />
    <meta property="og:image" content="" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection
@section('ExtraTags')
@endsection
@section('description')
    {{ $posts->description }}
@endsection
@section('MainContent')
    
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">

                <div class="card invoice-preview-card">
                    <div class="card-body">
                        @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                            <a style="float: left;" href="{{ route('EditNews', [$posts->id]) }}"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="{{ route('MakeNews') }}" target="_blank"> <i class="fa fa-plus"></i> </a>
                        @endif
                        @if ($posts->UpTitel != null)
                            <div class="post-uptitle">{{ $posts->UpTitel }}</div>
                        @endif
                        <div style="display: inline-flex">
                            <div class="avatar me-2">
                                <img style="width: 40px; height:40px;" src="{{ \App\myappenv::FavIcon }}" alt="Avatar"
                                    class="rounded-circle">
                            </div>
                            <h1 style="font-size: 24px" class="card-title"> {{ $posts->Titel }}</h1>
                        </div>

                        <small>{{ $Persian->MyPersianDate($posts->CrateDate) }}</small>
                        @if ($posts->SubTitel != null)
                            <div class="post-subtitle">{{ $posts->SubTitel }}</div>
                        @endif

                    </div>
                    <img class="img-fluid" src="{{ $posts->MainPic }}" alt="{{ $posts->Titel }}">
                    <div class="card-body">
                        @if ($posts->Abstract != null)
                            <blockquote class="text-center mb-8">
                                <i class="fas fa-quote-left"></i>
                                <p class="font-weight-bold text-dark mt-1 mb-2">{!! $posts->Abstract !!}</p>
                            </blockquote>
                        @endif
                        <div style="text-align: justify" class="post-content">
                            @if (!Auth::check() && $posts->ContentAccessLevel == 0)
                                {!! $posts->Content !!}
                            @elseif (Auth::check() && $posts->ContentAccessLevel <= Auth::user()->Role)
                                @if ($for_buy_news['is_buyable'] && !$for_buy_news['buy_before'])
                                    <div class="col-xl mb-lg-0 lg-4">
                                        <div class="card border border-2 border-primary">
                                            <div class="card-body">
                                                <div
                                                    class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                                    <h5 class="text-start text-uppercase mb-0">دسترسی به محتوای این صفحه
                                                        نیاز به پرداخت دارد</h5>
                                                    <span class="badge bg-primary rounded-pill">محتوای آموزشی</span>
                                                </div>

                                                <div class="text-center position-relative mb-4 pb-3">
                                                    <div class="d-flex">
                                                        <h1 class="price-toggle text-primary price-yearly mb-0">
                                                            {{ number_format($for_buy_news['price']) }} <small>ریال</small>
                                                        </h1>

                                                        <sub class="h5 text-muted pricing-duration mt-auto mb-3"> /
                                                            دسترسی نا محدود</sub>
                                                    </div>
                                                    <small
                                                        class="position-absolute start-0 m-auto price-yearly price-yearly-toggle text-muted">با
                                                        یک بار پرداخت میتوانید به صورت نامحدود این صفحه را بازدید
                                                        کنید!</small>
                                                </div>
                                                <p>امکانات این صفحه پس از پرداخت</p>

                                                <hr>

                                                <ul class="list-unstyled pt-2 pb-1 lh-1-85">
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        بازدید نا محدود از این صفحه
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        بازدید از تغییرات و به روز رسانی های این صفحه
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                                            <i class="bx bx-check bx-xs"></i>
                                                        </span>
                                                        پشتیبانی در صورت بروز مشکل
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        استفاده دیگر کاربران
                                                    </li>
                                                    <li class="mb-2">
                                                        <span
                                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-secondary me-2">
                                                            <i class="bx bx-x fs-5 lh-1"></i>
                                                        </span>
                                                        اشتراک گذاشتن محتوا یا کپی از آن
                                                    </li>
                                                </ul>
                                                <form method="POST">
                                                    @csrf
                                                    <button class="btn btn-primary d-grid w-100" type="submit"
                                                        name="submit" value="pay">پرداخت</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                @elseif($for_buy_news['is_buyable'] && $for_buy_news['buy_before'])
                                    <span class="badge bg-success rounded-pill">خریداری شده</span>
                                    {!! $posts->Content !!}
                                @else
                                    {!! $posts->Content !!}
                                @endif
                            @else
                                <div class="alert alert-warning" role="alert">
                                    <h6 class="alert-heading mb-1">متن خبر برای کاربران ويژه می باشد!</h6>
                                    <span>جهت نمایش خبر
                                        <a href="{{ route('login') }}"> از اینجا</a>
                                        وارد سامانه شوید</span>
                                </div>
                            @endif

                        </div>
                        @if ($Tags != null)
                            <div class="tags">
                                <label class="text-dark mr-2">برچسب ها :</label>
                                @foreach ($Tags as $Tag)
                                    <a style="
                                    display: contents;
                                    border-style: solid;
                                    padding: 3px;
                                    border-width: 1px;
                                    margin-left: 3px;"
                                        href="{{ route('newscat', ['newscat' => $Tag->Name]) }}"
                                        class="tag">#{{ $Tag->Name }} </a>
                                @endforeach
                            </div>
                        @endif


                        <!-- End Social Links -->
                        @if ($posts->PostContent != null)
                            <div class="post-author-detail">
                                <div class="author-details">
                                    <div class="author-name-wrapper flex-wrap mb-2">
                                        <h4 class="author-name font-weight-bold mb-2 pr-4 mr-auto"> پی نوشت:
                                        </h4>
                                    </div>
                                    <p style="text-align: justify" class="mb-0"> {{ $posts->PostContent }}</p>
                                </div>
                            </div>
                        @endif
                        <hr>
                        <form class="reply-section pb-4">
                            <h4 class="title title-md font-weight-bold pt-1 mt-10 mb-0">ارسال پیام </h4>
                            <p>آدرس ایمیل شما منتشر نخواهد شد. فیلدهای مورد نیاز علامت گذاری شده است</p>
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <input type="text" name="name" required class="form-control"
                                        placeholder="نام خود را وارد کنید " id="name">
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <input type="text" required name="WriterEmail" class="form-control"
                                        placeholder="ایمیل خود را وارد کنید " id="email_1">
                                </div>
                            </div>
                            <textarea cols="30" name="message" required rows="6" placeholder="نوشتن  پیام" class="form-control mb-4"
                                id="comment"></textarea>
                            <button type="submit" class="btn btn-dark btn-rounded btn-icon-right btn-comment">ارسال
                                پیام<i class="w-icon-long-arrow-left"></i></button>
                        </form>


                    </div>


                </div>
            </div>
            <!-- /Invoice Add-->

            <!-- Invoice Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="widget widget-posts">
                            <h5 class="card-title mb-0"> جدید ترین مطالب </h5>
                            <div class="widget-body">
                                @foreach ($DataSource->LastPosts() as $LastPost)
                                    <div class="post-widget mb-4">
                                        <figure class="post-media br-sm">
                                            <img src="{{ $LastPost->MainPic }}" width="100%"
                                                alt="{{ $LastPost->Titel }}" />
                                        </figure>
                                        <div style="display: inline-flex" class="post-details">

                                            <a
                                                href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                            <small>
                                                <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}"
                                                    class="post-date">{{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                                                </a>
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="widget widget-posts">
                            <h5 class="card-title mb-0">مطالب پر بازدید </h5>
                            <div class="widget-body">
                                @foreach ($DataSource->MostViewPosts() as $LastPost)
                                    <div class="post-widget mb-4">
                                        <figure class="post-media br-sm">
                                            <img src="{{ $LastPost->MainPic }}" width="100%"
                                                alt="{{ strip_tags($LastPost->Titel) }}" />
                                        </figure>
                                        <div style="display: inline-flex" class="post-details">

                                            <a
                                                href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                            <small>
                                                <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}"
                                                    class="post-date">{{ $Persian->MyPersianDate($LastPost->CrateDate) }}
                                                </a>
                                            </small>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Invoice Actions -->
        </div>


    </div>


@endsection
@section('EndScripts')
    <script src="https://app.spotplayer.ir/assets/js/app-api.js"></script>

    <script>

        async function Play() {
            course = "{{ $spot_player['ID'] ?? '' }}";
            key = "{{ $spot_player['key'] ?? '' }}";
            url = "{{ $spot_player['URL'] ?? '' }}";

            item = "{{ $spot_player['course_code'] }}";
            try {
                const sp = new SpotPlayer(document.getElementById('player'),
                    '/news/3/رویداد%20از%20افسانه%20تا%20اصالت', false);
                await sp.Open(key, course, item);
            } catch (ex) {
                console.log(ex);
            }
        }
    </script>
@endsection
