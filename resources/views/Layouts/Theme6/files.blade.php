@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')
@section('MainTitle')
    {{ $file_src->title }}
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="{{ $file_src->title }}" />
    <meta property="og:url" content="{{ \App\myappenv::SiteAddress }}/{{ Request::path() }}" />
    @foreach ($img_src as $PicItem)
        @if ($PicItem->pic != null)
            <meta property="og:image" content="{{ $PicItem->pic }}" />
        @break
    @endif
@endforeach

<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="600" />
<meta name="twitter:card" content="summary_large_image" />
@endsection


@section('content')
<style>
    .active_td {
        background-color: #f44336;
        color: white;
    }

    .ui-variant-shape {
        background-color: #f6f6f6;
    }

    .ui-variant-shape.active {
        background-color: #f44336 !important;
    }

    #fullpage {
        display: none;
        position: absolute;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-size: contain;
        background-repeat: no-repeat no-repeat;
        background-position: center center;
        background-color: black;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle"></i> اطلاعات تماس</h5>
                <button style="display: contents;" type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $count = 0;
                @endphp
                @foreach ($dealers as $dealer)
                    <ul>
                        <li style="display: contents"> <i class="fa fa-user"></i> کارشناس: {{ $dealer->Family }}</li>
                        <hr>
                        <li style="display: contents"> <i class="fa fa-phone"></i> شماره تماس: <a
                                href="tel:02141484">41484-021</a> داخلی
                            {{ $dealer->Ext }}</li>
                        <hr>
                        <li style="display: contents"> <i class="fa fa-phone"></i> همراه: <a
                                href="tel:{{ $dealer->MobileNo }}">{{ $dealer->MobileNo }} </a> </li>
                    </ul>
                    @php
                        $count++;
                    @endphp
                @endforeach
                @if ($count == 0)
                    <ul>
                        <li style="display: contents"> <i class="fa fa-user"></i> مرکز فروش رایان دیزل</li>
                        <hr>
                        <li style="display: contents"> <i class="fa fa-phone"></i> شماره تماس: <a
                                href="tel:02141484">41484-021</a></li>
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">متوجه شدم</button>
            </div>
        </div>
    </div>
</div>

<!-- Start Single Shop -->
<div id="fullpage" onclick="this.style.display='none';"></div>
<section class="shop-section ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="left-shop">
                    <!-- Shop Cart Details Start -->
                    <div class="cart-details pb-70">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="product-carousel carousel-lg owl-carousel owl-theme">
                                    @foreach ($img_src as $PicItem)
                                        @if ($PicItem->pic != null)
                                            <div><img data-fancybox="gallery" class="mySlides" src="{{ $PicItem->pic }}"
                                                    alt="{{ $file_src->title }}{{ $loop->index }}"></div>
                                        @endif
                                    @endforeach
                                </div>
                                <div>
                                    <div style="text-align:center;background-color: #f44336;color:white">
                                        اگر این خودرو را می‌پسندید از طریق لینک‌های زیر در شبکه‌های اجتماعی به سایر
                                        علاقه مندان همرسانی کنید!
                                    </div>
                                    <div style="
                                        padding-top: 0px;
                                        margin-top: 7px;
                                        "
                                        class="share-items clearfix">
                                        <ul style="text-align:center" class="unstyled footer-social">
                                            <li style="font-size: 30px;display: block;">
                                                <a title="Facebook"
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="fa fa-facebook"></i></span>
                                                </a>
                                                <a title="Twitter"
                                                    href="http://twitter.com/share?url={{ url()->current() }}&text={{ $file_src->title }}&hashtags=simplesharebuttons"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="fa fa-twitter"></i></span>
                                                </a>
                                                <a title="Google+"
                                                    href="https://plus.google.com/share?url={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="fa fa-google-plus"></i></span>
                                                </a>

                                                <a title="Linkdin"
                                                    href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="fa fa-linkedin"></i></span>
                                                </a>
                                                <a target="_blank" title="whatsapp"
                                                    href="whatsapp://send?text={{ url()->current() . '   ' . $file_src->title }}">
                                                    <span class="social-icon"><i class="fa fa-whatsapp"></i></span>
                                                </a>
                                                <a title="pinterest"
                                                    href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
                                                    <span class="social-icon"><i class="fa fa-pinterest"></i></span>
                                                </a>
                                                <a title="instagram"
                                                    href="https://www.instagram.com/?url={{ url()->current() }}"
                                                    target="_blank">
                                                    <span class="social-icon"><i class="fa fa-instagram"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- Share items end -->
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="product-details">
                                    <h1 style="font-size: 22px;font-weight: 700;">{{ $file_src->title }}</h1>
                                    @if (Auth::check() && Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                        <a style="float: left;" href="{{ route('edit_file', [$file_src->id]) }}"><i
                                                class="fa fa-pencil"></i></a>
                                    @endif
                                    {!! $file_src->description !!}
                                    <hr>
                                    <div class="product-option">
                                        <form class="form">
                                            <div class="product-row">
                                                <div>
                                                    <button type="button" class="theme-btn" data-toggle="modal"
                                                        data-target="#exampleModal">
                                                        اطلاعات تماس
                                                    </button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <h6><span>دسته بندی: </span>
                                        {{ $deal_function->get_deal_type($file_src->deal_type) }}
                                        ، {{ $product_type }}</h6>

                                </div> <!-- Products Details -->
                            </div>
                        </div> <!-- end row -->
                    </div>
                    @php
                        $dial_src = App\Deal\DealFiles::get_deal_info(6, 'DESC');
                    @endphp
                    <section class="latest-motors pt-100 pb-70">
                        <div class="container">
                            <div class="section-title text-center">
                                <h3>آگهی های مرتبط</h3>
                            </div>
                            <div class="row">
                                @foreach ($dial_src as $file_item)
                                    @if ($file_item->id != $file_src->id)
                                        @include('Layouts.Theme6.Layout.deal_item')
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <!-- End Reletad Post -->
                </div>
            </div>


        </div>
    </div>
</section>

<!-- End Single Shop -->
@endsection
@section('end_script')
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            rtl: true,
            loop: false,
            margin: 10,
            nav: true
        })

    });
</script>
<script>
    Fancybox.bind('[data-fancybox="gallery"]', {
        //
    });
</script>
@endsection
