@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.CustomerMainPage')
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
    @if (\App\myappenv::MainOwner == 'sepehrmall')
        <style>
            .CatImg {
                width: 38px;
            }

            .Title_card {}

            .sht198 {
                border-width: 1px;
                border-style: solid;
                border-color: blue;
                margin-right: 10px;
                white-space: nowrap;
                margin-bottom: 13px;
                padding: 4px;
                font-size: 15px;
                border-radius: 10px;
                margin-top: 0px;
            }

            .cats-header {
                font-size: 13px;
                font-weight: 500;
                margin: 0px 0px 1.6rem;
            }

            .product-card-img {
                height: 165px;
                margin: auto;
            }

            .item-title {
                height: 7px;
            }

            .picutre_fixer {
                height: 167px;
            }

            .list_continer {
                margin-bottom: -31px;
                padding-right: 14px;
            }

            .list_show_all {
                position: absolute;
                left: 32px;
                margin-top: -24px;
                font-size: 14px;
                font-weight: 600;
            }

            .percentbox {
                color: white;
                background: rgb(204, 0, 0);
                border-radius: 3 px;
                padding: 2 px;
                font-size: 13px;
                font-weight: 800;
            }

            .list_title {
                font-size: 14px;
                font-weight: 600;
                color: black;
                position: absolute;
                margin-top: -23px;
            }
        </style>
    @else
        <style>
            .item-title {
                text-align: center;
                color: #47404f;
            }

            .product-card-img {
                height: 140px;
                margin: auto;
            }

            .picutre_fixer {
                height: 140px;
            }

            .list_show_all {
                position: absolute;
                left: 10px;
                margin-top: -30px;
                font-size: 14px;
                font-weight: 600;
            }

            .percentbox {
                color: white;
                background: red;
                border-radius: 3 px;
                padding: 2 px;
                font-size: 13px;
                font-weight: 800;
            }

            .CatImg {
                width: 38px;
            }

            .Title_card {}

            .list_title {
                font-size: 14px;
                font-weight: 600;

            }

            .sht198 {
                border-width: 1px;
                border-style: solid;
                border-color: blue;
                margin-right: 10px;
                white-space: nowrap;
                margin-bottom: 13px;
                padding: 4px;
                font-size: 15px;
                border-radius: 10px;
                margin-top: 0px;
            }

            .cats-header {
                font-size: 13px;
                font-weight: 500;
                margin: 0px 0px 1.6rem;
            }
        </style>
    @endif
    <div class="row">
        <div class="container-fluid">
            <div class="page-header">
                <div style="margin: 0px;margin-bottom:20px;" class="row col-12">
                    <div class="card col-12">
                        <div class="cats-header card-header">
                            دسته: {{ $TagScName }}
                        </div>
                        <div style="margin-top: -30px;" class="card-body">
                            <div id="sub_tags" direction="row" class="Shafatel19 horizental-list">
                                @foreach ($Tags as $Tag)
                                    <a href="{{ route('ShowProduct', ['Tags' => $Tag->UID]) }}"
                                        class="sht198">{{ $Tag->L3Name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            @include('Layouts.AddressBar')
                        </ol>
                    </div>
                    @include('Layouts.PWAProductModal')

                </div>
            </div>

            @include('woocommerce.Customer.ProductListItems')


        </div>
    </div>
    @if ($post_src != null)
        {!! $post_src->Content !!}
    @endif
@endsection
@section('page-js')
    <script>
        $("#viewContainer span").on("click", function() {
            $("#viewContainer span").removeClass("active");
            $("#sub_tags").removeClass("nested");
            $(this).addClass("active");
            $("#viewContainer").scrollCenter(".active", 300);
        });

        jQuery.fn.scrollCenter = function(elem, speed) {

            // this = #timepicker
            // elem = .active

            var active = jQuery(this).find(elem); // find the active element
            //var activeWidth = active.width(); // get active width
            var activeWidth = active.width() / 2; // get active width center

            //alert(activeWidth)

            //var pos = jQuery('#timepicker .active').position().left; //get left position of active li
            // var pos = jQuery(elem).position().left; //get left position of active li
            //var pos = jQuery(this).find(elem).position().left; //get left position of active li
            var pos = active.position().left + activeWidth; //get left position of active li + center position
            var elpos = jQuery(this).scrollLeft(); // get current scroll position
            var elW = jQuery(this).width(); //get div width
            //var divwidth = jQuery(elem).width(); //get div width
            pos = pos + elpos - elW / 2; // for center position if you want adjust then change this

            jQuery(this).animate({
                scrollLeft: pos
            }, speed == undefined ? 1000 : speed);
            return this;
        };

        jQuery.fn.scrollCenterORI = function(elem, speed) {
            jQuery(this).animate({
                scrollLeft: jQuery(this).scrollLeft() - jQuery(this).offset().left + jQuery(elem).offset().left
            }, speed == undefined ? 1000 : speed);
            return this;
        };
    </script>
    <script>
        $(document).ready(function() {
            $("#viewContainer").scrollCenter(".active", 300);
        });
    </script>
@endsection
