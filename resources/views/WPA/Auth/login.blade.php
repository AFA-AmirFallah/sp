@extends("WPA.Layouts.MainPage")

@section('MainCountent')
    <div class="page">
        <div class="page-content account-area">
            <div class="dz-banner" style=" width: 360px !important;right: calc((100vw - 360px) / 2);background-image:url({{ url('/'). \App\myappenv::login_background_image}}); background-repeat:no-repeat; background-size:cover;"></div>
            <div class="dz-banner-height"></div>
            <div class="fixed-content py-30">
                <div class="container">
                    <div class="tabs">
                        <div class="tab tab-active form-elements tabs">
                            <form class="tab tab-active" method="post" id="tabA1">
                                @csrf
                                <div class="title-bar mb-20">
                                    <h3 class="dz-title ma-0">{{ __('Enter to user panel') }}</h3>
                                    <a href="{{ route('login') }}" class="link external icon-close"><i class="mdi mdi-arrow-left"></i></a>
                                </div>
                                <div class="list mb-0">
                                    <ul class="row">
                                        <li class="item-content item-input col-100 item-input-with-value">
                                            <div class="item-inner">
                                                <div class="item-input-wrap">
                                                    <input type="number" autocomplete="off" required name="UserName" placeholder="{{__("Mobile No")}}" value=""  class="form-control" />
                                                </div>
                                            </div>
                                        </li>
                                        <li class="item-content item-input col-100">
                                            <div class="item-inner">
                                                <div class="item-input-wrap">
                                                    <input type="password" autocomplete="off" required name="UserPass" autocomplete="false" placeholder="{{ __('Password') }}" value=""  class="form-control" />
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="list"> 
                                    <ul>
                                        <li class="mb-20 text-center"><a href="#tabA2" data-route-tab-id="tabA2" class="tab-link fs-14 d-inline-block">{{__("Are you forget password")}}</a></li>
                                        <li class="mb-15"><button href="/home/" class="button-large button button-fill">{{ __('Login') }}</button></li>
                                        <li><a class="link external  button-large button button-fill" href="{{ route('register') }}" >{{__("Register")}}</a></li>
                                    </ul>
                                </div>
                            </form>
                            <form class="tab" id="tabA2">
                                <div class="title-bar mb-20">
                                    <h3 class="dz-title ma-0">فراموشی رمز عبور</h3>
                                    <a href="#tabA1" data-route-tab-id="tabA1" class="tab-link icon-close"><i class="flaticon-cancel"></i></a>
                                </div>
                                <div class="list mb-0">
                                    <ul>
                                        <li class="item-content item-input item-input-with-value">
                                            <div class="item-inner">
                                                <div class="item-input-wrap">
                                                    <input type="password" placeholder="رمز عبور جدید" id="demo-username-25" class="form-control" />
                                                </div>
                                            </div>
                                        </li>
                                        <li><a href="/home/" class="button-large button button-fill">ارسال</a></li>
                                    </ul>
                                </div>
                                <div class="list text-center">
                                    <p class="fs-14 d-inline-block mt-10">بازگشت به سایت  <a href="#tabA1" data-route-tab-id="tabA1" class="fw6 tab-link">از اینجا وارد شوید</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
