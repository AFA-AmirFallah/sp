@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')
@section('MainTitle')
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="{{ \App\myappenv::SiteAddress }}/{{ Request::path() }}" />
    @foreach ($PicSource as $PicItem)
        @if ($PicItem->PicUrl != null)
            <meta property="og:image" content="{{ $PicItem->PicUrl }}" />
        @break
    @endif
@endforeach
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="600" />
<meta name="twitter:card" content="summary_large_image" />
@endsection
@section('content')
<!-- SearchBox Modal -->
<div class="search">
    <button type="button" class="close">×</button>
    <form>
        <input type="search" value="" class="form-control" placeholder="جستجو کن..." />
        <button type="submit" class="btn theme-btn"><i class="fa fa-search"></i> جستجو</button>
    </form>
</div>
<!-- Start Single Shop -->
<section class="shop-section ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="left-shop">
                    <!-- Shop Cart Details Start -->
                    @php
                        $PicSource = json_decode($TargetGood->ImgURL);

                    @endphp
                    <div class="cart-details pb-70">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-lg-4">
                                <div class="shop-single-slider">
                                    <div class="slider-for border-for">
                                        @foreach ($PicSource as $PicItem)
                                            @if ($PicItem->PicUrl != null)
                                                <div><img src="{{ $PicItem->PicUrl }}" alt="{{ $TargetGood->NameFa }}{{$loop->index}} "></div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="slider-nav border-nav">
                                        @foreach ($PicSource as $PicItem)
                                            @if ($PicItem->PicUrl != null)
                                                <div class="slider-img-count"><img class="set_img"
                                                        src="{{ $PicItem->PicUrl }}" alt></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-8">
                                <div class="product-details">
                                    <h3>{{ $TargetGood->NameFa }}</h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th colspan="2">مشخصات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd">
                                                <td>
                                                    مدل :
                                                </td>
                                                <td>
                                                    4HK1-E4N
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    قدرت موتور ۵ تن :
                                                </td>
                                                <td>
                                                    ۱۴۵ اسب بخار

                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td>
                                                    قدرت موتور ۶ تن :
                                                </td>
                                                <td>
                                                    ۱۵۰ اسب بخار

                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    قدرت موتور ۸ تن :
                                                </td>
                                                <td>
                                                    ۱۵۴ اسب بخار

                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td>
                                                    گشتاور:
                                                </td>
                                                <td>
                                                    ۴۰۲

                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    استاندارد آلایندگی:
                                                </td>
                                                <td>
                                                    EURO 4

                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td>
                                                    تعداد سیلندر:
                                                </td>
                                                <td>
                                                    ۴ سیلندر

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="product-option">
                                        <form class="form">
                                            <div class="product-row">
                                                <div>
                                                    <button type="submit" class="theme-btn">تماس با کارشناس</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <h6><span>دسته بندی: </span>صندلی های اتومبیل ، سیستم ایربگ</h6>
                                </div> <!-- Products Details -->
                            </div>
                        </div> <!-- end row -->
                    </div>
                    <!-- End Shop Cart Details -->

                    <!-- Shop Cart Tab Start -->
                    <section class="shop-cart-tab">
                        <div class="container">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#home">شرح محصول</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mr-0" data-toggle="pill" href="#menu2">بازدیدها (2)</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content shop-tab">
                                <div id="home" class="tab-pane active description">
                                    <h3>شرح محصول</h3>
                                    <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال
                                        استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.
                                        لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار
                                        چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.
                                        لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40
                                        سال استاندارد صنعت بوده است.</p>
                                </div>

                                <div id="menu2" class="tab-pane review fade">
                                    <h3>2 بررسی ماشین</h3>
                                    <ol>
                                        <li>
                                            <div class="comment-wrap">
                                                <div class="prof-image">
                                                    <img src="/Theme6/assets/img/shop/member/6.jpg" alt="Image">
                                                </div>
                                                <div class="text-wrap">
                                                    <div class="text-meta">
                                                        <strong>سندی راین</strong>
                                                        <div class="dashed">-</div>
                                                        <div class="time">
                                                            <i class="fa fa-clock-o" aria-hidden="true"></i> 01 دی
                                                            1398
                                                        </div>
                                                        <div class="rate">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star color " aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم
                                                        ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به
                                                        سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40
                                                        سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و
                                                        متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت
                                                        بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می
                                                        گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="comment-wrap">
                                                <div class="prof-image">
                                                    <img src="/Theme6/assets/img/shop/member/7.jpg" alt="Image">
                                                </div>
                                                <div class="text-wrap">
                                                    <div class="text-meta">
                                                        <strong>سندی راین</strong>
                                                        <div class="dashed">-</div>
                                                        <div class="time">
                                                            <i class="fa fa-clock-o" aria-hidden="true"></i> 01 دی
                                                            1398
                                                        </div>
                                                        <div class="rate">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star color " aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم
                                                        ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به
                                                        سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40
                                                        سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و
                                                        متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت
                                                        بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می
                                                        گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. </p>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                    <div class="comment-box-wrapper">
                                        <div class="comment-heading">
                                            <h3>افزودن نظر</h3>
                                            <p>آدرس ایمیل شما منتشر نخواهد شد. قسمت های مورد نیاز علامت گذاری شده اند
                                            </p>
                                        </div>
                                        <div class="raiting-p">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star color " aria-hidden="true"></i>
                                        </div>
                                        <div class="comment-form">
                                            <form id="contactForm" class="form-inline">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 pl-0">
                                                            <div class="form-group">
                                                                <input type="text" name="firstname" id="firstname"
                                                                    class="form-control" placeholder="نام شما">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6  col-md-6 p-0">
                                                            <div class="form-group">
                                                                <input type="email" name="email" id="#email"
                                                                    class="form-control" placeholder="ایمیل شما">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 p-0">
                                                            <div class="form-group">
                                                                <textarea name="message" class="form-control" id="message" cols="30" rows="6" placeholder="پیام شما"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 p-0">
                                                            <button type="submit"
                                                                class="btn custom-btn2">ارسال</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End Shop Cart Tab -->

                    <!-- Reletad Post -->
                    <section class="related-post related-post2">
                        <div class="container">
                            <div class="post-title text-center">
                                <h3>پست های مرتبط</h3>
                            </div>
                            <div class="related-post-slider owl-carousel owl-theme">
                                <div class="single-shop">
                                    <div class="shop-image">
                                        <a href="shop-details.html"><img src="/Theme6/assets/img/shop/1.png"
                                                alt="Image"></a>

                                        <div class="add-cart-hover">
                                            <div class="d-table">
                                                <div class="d-tablecell">
                                                    <a href="#" class="add-cart">افزودن سبد خرید</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="image-caption">
                                        <a href="shop-details.html">
                                            <h3>تایر حرفه ای</h3>
                                        </a>
                                        <span>500000 تومان</span>
                                    </div>
                                </div>
                                <div class="single-shop">
                                    <div class="shop-image">
                                        <a href="shop-details.html"><img src="/Theme6/assets/img/shop/2.png"
                                                alt="Image"></a>

                                        <div class="add-cart-hover">
                                            <div class="d-table">
                                                <div class="d-tablecell">
                                                    <a href="#" class="add-cart">افزودن سبد خرید</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="image-caption">
                                        <a href="shop-details.html">
                                            <h3>تایر حرفه ای</h3>
                                        </a>
                                        <span>390000 تومان</span>
                                    </div>
                                </div>
                                <div class="single-shop">
                                    <div class="shop-image">
                                        <a href="shop-details.html"><img src="/Theme6/assets/img/shop/3.png"
                                                alt="Image"></a>

                                        <div class="add-cart-hover">
                                            <div class="d-table">
                                                <div class="d-tablecell">
                                                    <a href="#" class="add-cart">افزودن سبد خرید</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="image-caption">
                                        <a href="shop-details.html">
                                            <h3>تایر حرفه ای</h3>
                                        </a>
                                        <span>400000 تومان</span>
                                    </div>
                                </div>
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
