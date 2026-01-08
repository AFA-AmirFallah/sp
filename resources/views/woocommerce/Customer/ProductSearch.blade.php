@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('before-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_arrows.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_circles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_dots.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="confirmcode">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="pwa_h1_title">
                        <h2 class="pwa_h2_title"> <a href="{{ route('mainpage') }}">صفحه اصلی</a> > {{ $TagName }}
                        </h2>
                    </h1>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
                @include('Layouts.PWAProductModal')
                <div style="width: 100%" class="row">
                    @include("Layouts.PWAObjects.PWASearch")
                </div>

                <div class="row">
                    @php
                        $Counter = 0;
                    @endphp
                    @foreach ($Goods as $Good)
                        @php
                            $Counter++;
                        @endphp

                        <div id="ProductBox_{{ $Good->id }}" style="padding-left: 5px ;padding-right: 5px"
                            class="wpa-md6 col-md-6
                            @if (in_array($Good->id, $BuyArray))
                                BuyedProduct
                            @endif
                            ">
                            <div class="nested" id="desc_{{ $Good->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($Good->MainDescription, 'DiscText') !!}</div>
                            <div class="nested" id="text_{{ $Good->id }}">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($Good->MainDescription, 'MainText') !!}</div>
                            <a onclick="SelectProduct('{{ $Good->NameFa }}' , '{{ $Good->wgid }}', '{{ $Good->id }}' ,'{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}',{{ $Good->Price }},{{ $Good->BasePrice }},'{{ $Good->PricePlan }}')"
                                data-toggle="modal" data-target=".bd-example-modal-lg">
                                <div class=" card card-ecommerce-3 o-hidden mb-4">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="">

                                            <img @if ($Good->Remian == 0) style="filter: opacity(0.5);" @endif class=" card-img-left"
                                                src="{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}"
                                                alt="{{ $Good->NameFa }}">
                                        </div>
                                        <div class="flex-grow-1 p-4">
                                            <h6 style="white-space: normal;height:50px;" class="CustomerServiceCardHeader m-0">
                                                {{ Str::substr( $Good->NameFa, 0, 100) }}@if (Str::length( $Good->NameFa) > 100)
                                    ...
                                @endif
                                            </h6>
                                            <hr class="CustomerServiceCardHr">

                                            @if ($Good->Remian > 0)
                                                <p class="m-0 text-small text-muted">
                                                    @if ($Good->PricePlan == null)
                                                        {{ number_format($Good->Price) }} ریال
                                                    @else
                                                        از
                                                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMinPrice($Good->PricePlan)) }}
                                                        تا
                                                        {{ number_format(\App\Http\Controllers\woocommerce\product::GetMaxPrice($Good->PricePlan)) }}
                                                        ریال
                                                    @endif
                                                    <br>
                                                    @if ($Good->BasePrice > 0 && $Good->BasePrice != $Good->Price)
                                                        <del class="text-secondary">{{ $Good->BasePrice }} ریال</del>
                                                    @endif
                                                </p>

                                            @else
                                                <p style="color: red !important" class="m-0 text-small text-muted">
                                                    تمام شده! </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @if($Counter == 0)
                <div style="margin-top: 30px;" class="col-md-6 mb-4">
                    <div class="alert alert-warning alert-simple alert-inline">
                        <h4 class="alert-title"> هیچ موردی یافت نشد! </h4>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>


@endsection
@section('page-js')



@endsection
