@extends("WPA.Layouts.MainPage")

@section('MainCountent')
    <div class="page light">
        <div class="navbar navbar-style-1 navbar-transparent">
            <div class="navbar-inner">
                <div class="left">
                    <a href="#" class="link back">
                        <i class="mdi mdi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="page-content pt-80 bottom-sp90 item-details">
            <div data-pagination='{"el": ".swiper-pagination"}' class="swiper-container swiper-slider-wrapper swiper-init demo-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{$RespnsTypes->ImgURL}}" alt="">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="dz-banner-height"></div>
            <div class="fixed-content py-30">
                <div class="container">
                    <div class="item-info">
                        <div class="clearfix">
                            <h3 class="category">{{$RespnsTypes->RespnsTypeName}}</h3>
                            <h2 class="item-title">{{$RespnsTypes->Description}}</h2>
                        </div>
                    </div>
                    <div class="item-info">
                        <div class="clearfix">
                            <h2 class="text-primary item-price">{{number_format($targetPrice) }} ریال</h2>
                        </div>
                        <div class="stepper stepper-small stepper-round stepper-init">
                            <div class="stepper-button-minus"></div>
                            <div class="stepper-input-wrap">
                                <input type="text" value="1" min="0" max="100" step="1" readonly>
                            </div>
                            <div class="stepper-button-plus"></div>
                        </div>
                    </div>
                    <div class="item-info">
                        <div class="reviews-info">
                            <i class="fa fa-star"></i>
                            <h5 class="reviews">{{$TypeOfService}}</h5>
                        </div>
                    </div>
                    <div class="toolbar toolbar-bottom tabbar tab-style-2 tabbar-scrollable">
                        <div class="toolbar-inner">
                            <a href="#tab-1" class="tab-link tab-link-active">توضیحات</a>
                            <a href="#tab-2" class="tab-link">نظرات</a>
                            <a href="#tab-3" class="tab-link">اطلاعات</a>
                        </div>
                    </div>
                    <div class="tabs-swipeable-wrap tabs-height-auto">
                        <div class="tabs">
                            <div id="tab-1" class="tab  tab-active">
                                {!! $RespnsTypes->MainDescription !!}
                            </div>
                            <div id="tab-2" class="tab">
                                <div class="list media-list review-list">
                                    <ul>
                                        <li>
                                            <div href="#" class="item-link item-content">
                                                <div class="item-media"><img src="img/avatar/1.jpg" width="50"></div>
                                                <div class="item-inner">
                                                    <div class="item-title-row">
                                                        <div class="item-title">جان دو</div>
                                                        <div class="item-after stars">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="item-subtitle">10 مهر 1400</div>
                                                    <div class="item-text">اگر شما یک طراح هستین و یا با طراحی های گرافیکی سروکار دارید به متن های برخورده اید که با نام لورم ایپسوم شناخته می‌شوند.
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div href="#" class="item-link item-content">
                                                <div class="item-media"><img src="img/avatar/2.jpg" width="50"></div>
                                                <div class="item-inner">
                                                    <div class="item-title-row">
                                                        <div class="item-title">لئو تاکر</div>
                                                        <div class="item-after stars">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="item-subtitle">10 مهر 1400</div>
                                                    <div class="item-text">اگر شما یک طراح هستین و یا با طراحی های گرافیکی سروکار دارید به متن های برخورده اید که با نام لورم ایپسوم شناخته می‌شوند.
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="tab-3" class="tab">
                                <div class="data-table">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="label-cell">ویژگی های</th>
                                            <th class="numeric-cell">ارزش ها</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td> <strong>رنگ</strong> </td>
                                            <td>آبی، قرمز، زرد، سبز</td>
                                        </tr>
                                        <tr>
                                            <td> <strong>جنس</strong> </td>
                                            <td>چوب، پلاستیک، فولاد ضد زنگ</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="toolbar toolbar-bottom footer-button padding item-details-btn">
            <div class="container px-15">
                <div class="row">
                    <div class="col-100">
                        <a href="/shopping-cart/" class="button-large button add-cart-btn button-fill">افزودن به سبد خرید</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
