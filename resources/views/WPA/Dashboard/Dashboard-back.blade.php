@extends("WPA.Layouts.MainPage")

@section('MainCountent')
    <div class="page page-homepage light" data-name="homepage">
        <div class="page-content content-area pt-30 bottom-sp80">
            <div class="container">
                <div class="notification-bar">
                    <div class="info">
                        <a  href="/deals/">
                            <h5 class="title">خدمات پزشکی، پرستاری و مراقبتی</h5>
                        </a>

                    </div>
                    <div class="media">
                        <a href="/notifications-app/" class="notibell">
                            <i class="mdi mdi-bell-outline"></i>
                            <div class="badge"></div>
                        </a>
                    </div>
                </div>
                <div data-space-between="10" data-slides-per-view="auto" data-centered-slides="false"
                     class="swiper-container swiper-init mb-30 post-area">
                    <div class="swiper-wrapper">
                        @foreach($mobile_banners as $mobile_banner)
                            <div class="swiper-slide">
                                <a class="link external" href="{{$mobile_banner->link}}">

                                    <div class="post-card">
                                        <div class="post-media">
                                            <img src="{{$mobile_banner->pic}}" alt="">
                                        </div>
                                        <div class="post-info">
                                            <h3 class="title">{{$mobile_banner->title}}</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="title-bar mb-15">
                    <h3 class="dz-title my-5">خدمات ما</h3>
                    <a href="/deals/"><small></small></a>
                </div>
                <div class="row">
                    @foreach($Services as $Service)
                        <div class="col-50 medium-25">
                            <a class="link external" href="{{route('ServicesWithIndex',['IndexID'=>$Service->UID])}}">
                                <div class="item-box">
                                    <div class="item-media">
                                        <img src="{{$Service->img}}" alt="">
                                    </div>
                                    <a href="" class="item-bookmark active">
                                        <i class="fa fa-heart"></i>
                                        <input type="checkbox">
                                    </a>
                                    <div class="item-content">
                                        <h3 class="title">{{$Service->Name}}</h3>
                                        <h4 class="price"></h4>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach
                    @foreach($CatOrders as $CatOrder)
                        <div class="col-50 medium-25">
                            <a class="link external" href="{{route('Order',['OrderID'=>$CatOrder->ID])}}">
                                <div class="item-box">
                                    <div class="item-media">
                                        <img src="{{$CatOrder->Pic}}" alt="">
                                    </div>
                                    <a href="" class="item-bookmark active">
                                        <i class="fa fa-heart"></i>
                                        <input type="checkbox">
                                    </a>
                                    <div class="item-content">
                                        <h3 class="title">{{$CatOrder->Cat}}</h3>
                                        <h4 class="price"></h4>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="toolbar tabbar tabbar-labels toolbar-bottom menubar-area">
            <div class="toolbar-inner">
                <a href="/home/" class="tab-link active">
                    <i class="mdi mdi-home-outline"></i>
                </a>
                <a href="{{route('wpaclassification')}}" class="tab-link link external">
                    <i class="mdi mdi-view-grid-outline"></i>
                </a>
                <a href="/shopping-cart/" class="tab-link cart-in">
                    <i class="mdi mdi-cart-outline"></i>
                </a>
                <a href="/wishlist/" class="tab-link">
                    <i class="mdi mdi-heart-outline"></i>
                </a>
                <a href="/user/" class="tab-link">
                    @if(Auth::user()->avatar == null)
                        <i class="mdi mdi-account-box"></i>
                    @else
                        <img src="{{Auth::user()->avatar}}" class="user-media" alt="">
                    @endif

                </a>
            </div>
        </div>
    </div>
@endsection
@section('page-js')

@endsection
