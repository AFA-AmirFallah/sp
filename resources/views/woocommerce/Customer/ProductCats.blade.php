@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.CustomerMainPage')
@section('page-header-left')
@endsection
@section('MainCountent')

    @include('Layouts.PWAProductModal')
    @if ($MenuType == 'L3')
        <div style="margin: 0px;margin-right: -15px !important;margin-left: 38px !important;display: -webkit-box;width: 111%;"
            class="carousel_wrap col-md-12 row">
            <div class="row">
                @php
                    $Counter = 0;
                @endphp

                @foreach ($Cats as $Cat)
                    @if ($Counter == 3)
            </div>
            <div class="row">
                @php
                    $Counter = 0;
                @endphp
    @endif
    <div style="padding-left: 0px ;padding-right: 5px" class="wpa-md4 col-md-4">
        <a href="{{ route('ShowProduct', ['Tags' => $Cat->UID]) }} " data-target=".bd-example-modal-lg">
            @if (\App\myappenv::SiteTheme == 'kookbaz')
                <div class=" card card-ecommerce-3 o-hidden mb-4" style="height: 90%">
                @else
                    <div class=" card card-ecommerce-3 o-hidden mb-4" style="height: 100%">
            @endif
            <div class="d-flex flex-column flex-sm-row">
                <div class="">
                    <img class=" card-img-left" src="{{ $Cat->img }}" alt="{{ $Cat->Name }}">
                </div>
                <div class="flex-grow-1 p-4">
           
                  
                        <h6 style="white-space: normal;" class="CustomerServiceCardHeader m-0">
                            {{ $Cat->Name }} </h6> 
                       
                </div>
            </div>
    </div>
    </a>
    </div>
    @php
    $Counter++;
    @endphp
    @endforeach
@elseif($MenuType == 'L2')
    <div style="margin: 0px;margin-right: -15px !important;margin-left: 38px !important;display: -webkit-box;width: 111%;"
        class="carousel_wrap col-md-12 row">
        <div class="row">
            @php
                $Counter = 0;
            @endphp
            @foreach ($Cats as $Cat)
                @if ($Counter == 3)
        </div>
        <div class="row">
            @php
                $Counter = 0;
            @endphp
            @endif

            <div style="padding-left: 0px ;padding-right: 5px" class="wpa-md4 col-md-4">
                <a href="{{ route('ShowProduct', ['l2' => $Cat->L2ID, 'l1' => $Cat->L1ID, 'TagsrcName' => $Cat->Name]) }} "
                    data-target=".bd-example-modal-lg">
                    @if (\App\myappenv::SiteTheme == 'kookbaz')
                        <div class=" card card-ecommerce-3 o-hidden mb-4" style="height: 90%">
                        @else
                            <div class=" card card-ecommerce-3 o-hidden mb-4" style="height: 100%">
                    @endif
                    <div class="d-flex flex-column flex-sm-row">
                        <div class="">
                            <img class=" card-img-left" src="{{ $Cat->img }}" alt="{{ $Cat->Name }}">
                        </div>
                        <div class="flex-grow-1 p-4">
                           
                                <h6 style="white-space: normal;" class="CustomerServiceCardHeader m-0">
                                    {{ $Cat->Name }} </h6>   
                               
                        </div>
                    </div>
            </div>
            </a>
        </div>
        @php
            $Counter++;
        @endphp
        @endforeach
    @elseif($MenuType == 'L1')
        <div style="margin: 0px;margin-right: -15px !important;margin-left: 38px !important;display: -webkit-box;width: 111%;"
            class="carousel_wrap col-md-12 row">
            <div class="row">
                @php
                    $Counter = 0;
                @endphp
                @foreach ($Cats as $Cat)
                    @if ($Counter == 3)
            </div>
            <div class="row">
                @php
                    $Counter = 0;
                @endphp
                @endif
                <div style="padding-left: 0px ;padding-right: 5px" class="wpa-md4 col-md-4">
                    <a href="{{ route('ProductCats', ['TargetLayer' => $Cat->L1ID]) }} "
                        data-target=".bd-example-modal-lg">
                        @if (\App\myappenv::SiteTheme == 'kookbaz')
                            <div class=" card card-ecommerce-3 o-hidden mb-4" style="height: 90%">
                            @else
                                <div class=" card card-ecommerce-3 o-hidden mb-4" style="height: 100%">
                        @endif
                        <div class="d-flex flex-column flex-sm-row">
                            <div class="">
                                <img class=" card-img-left" src="{{ $Cat->img }}" alt="{{ $Cat->Name }}">
                            </div>
                            <div class="flex-grow-1 p-4">
                               
                                    <h6 style="white-space: normal;" class="CustomerServiceCardHeader m-0">
                                        {{ $Cat->Name }} </h6>
                                     
                            </div>
                        </div>
                </div>
                </a>
            </div>
            @php
                $Counter++;
            @endphp
            @endforeach
            @endif

        </div>

        @include('Layouts.MainRouteCard')
    @endsection

    @section('page-js')
    @endsection

    @section('bottom-js')
        <script>
            $(window).on('load', function() {
                var maxHeight = 0;

                $('.card').each(function() {
                    var thisH = $(this).height();
                    if (thisH > maxHeight) {
                        maxHeight = thisH;
                    }
                });

                $('.card').height(maxHeight);

            });
            $(document).ready(function() {
                var maxHeight = 0;

                $('.card').each(function() {
                    var thisH = $(this).height();
                    if (thisH > maxHeight) {
                        maxHeight = thisH;
                    }
                });

                $('.card').height(maxHeight);

            });
        </script>
    @endsection
