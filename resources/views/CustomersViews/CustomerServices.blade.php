@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('page-header-left')

@endsection
@section('MainCountent')
    @if (\App\myappenv::Lic['wpa'])
        <div class="row" style="margin-bottom: 33px">
            <div class="carousel_wrap col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @for ($i = 0; $i < $mobile_banners->count(); $i++)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" @if ($i == 0) class="active"
                            @else
                                class="" @endif></li>
                        @endfor
                    </ol>
                    <div class="carousel-inner"
                                style="border-radius: 10px">
                                @php
                                    $initslide = true;
                                @endphp
                                @foreach ($mobile_banners as $mobile_banner)
                                    @if ($initslide)
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="{{ $mobile_banner->pic }}">
                                        </div>
                                        @php
                                            $initslide = false;
                                        @endphp
                                    @else
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="{{ $mobile_banner->pic }}">
                                        </div>

                                    @endif

                                @endforeach

                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">قبلی</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">بعدی</span>
                </a>
            </div>
        </div>
        </div>
    @endif
    @include("Layouts.MainRouteCard")
    <div class="row">
        @foreach ($CatOrders as $CatOrder)

            <div class="wpa-md6 col-md-6">

                @if (\App\myappenv::OrderAddressType == 'id')
                    <a href="{{ route('Order', ['OrderID' => $CatOrder->ID]) }}">
                    @elseif(\App\myappenv::OrderAddressType=='name' )
                        <a href="{{ route('Order', ['OrderID' => $CatOrder->Cat]) }}">
                @endif
                <div class=" card card-ecommerce-3 o-hidden mb-4">
                    <div class="d-flex flex-column flex-sm-row">
                        <div class="">
                            <img class=" card-img-left" src="{{ $CatOrder->Pic }}"
                            alt="{{ $CatOrder->Cat }}">
                        </div>
                        <div class="flex-grow-1 p-4">
                            <h6 class="CustomerServiceCardHeader m-0">{{ $CatOrder->Cat }}</h6>
                            <hr class="CustomerServiceCardHr">
                            <p class="m-0 text-small text-muted">{{ $CatOrder->TitleDescription }}</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        @endforeach

    </div>

@endsection

@section('page-js')

@endsection

@section('bottom-js')

@endsection
