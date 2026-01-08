@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .horizantal-list-container {}

        .mainpage_h1 {
            font-size: 10px;
        }

    </style>
    @if (\App\myappenv::MainOwner == 'sepehrmall')
        <div style="display: flex;align-items: center;margin-bottom: 10px;">
            <img style="width: 176px;" src="{{ \App\myappenv::MainIcon }}" alt="MainLogo">
        </div>
    @else
        @if (\App\myappenv::SiteTheme != 'kookbaz')
            @if ($DashboardClass->GetPageTitr($page) != null)
                <h1 class="mainpage_h1">{{ $DashboardClass->GetPageTitr($page) }}</h1>
            @endif
        @else
            @if ($page != 1)
                @if ($DashboardClass->GetPageTitr($page) != null)
                    <h1 class="mainpage_h1">{{ $DashboardClass->GetPageTitr($page) }}</h1>
                @endif
            @endif
        @endif
    @endif
    @include('Layouts.PWAProductModal')


    @if (\App\myappenv::Lic['wpa'])
        @include('Layouts.PWAObjects.PWABanner')
        @if (\App\myappenv::SiteTheme != 'kookbaz')
            @include('Layouts.PWAObjects.PWASearch')
        @endif
        @foreach ($mobile_banners as $mobile_banner)
            @if ($mobile_banner->theme == 2)
                @include('Layouts.PWAObjects.PWAIcons')
            @endif
            @if ($mobile_banner->theme == 10)
            
                @include('Layouts.PWAObjects.PWAHorizontalList')
            @endif
            @if ($mobile_banner->theme == 3)
                @include('Layouts.PWAObjects.PWABOXIcon')
            @endif
            @if ($mobile_banner->theme == 4)
                @include('Layouts.PWAObjects.PWAPosters')
            @endif
            @if ($mobile_banner->theme == 11)
                @include('Layouts.PWAObjects.PWAPosters4X')
            @endif
            @if ($mobile_banner->theme == 12)
                @include('Layouts.PWAObjects.PWAPostersScroll')
            @endif
            @if ($mobile_banner->theme == 13)
                @include('Layouts.PWAObjects.PWAPost')
            @endif
            @if ($mobile_banner->theme == 14)
                @include('Layouts.PWAObjects.L2Items')
            @endif
            @if ($mobile_banner->theme == 15)
                @include('Layouts.PWAObjects.IconBox3X')
            @endif
        @endforeach
    @endif
    @include('Layouts.MainRouteCard')
@endsection

@section('page-js')
    <script>

    </script>
@endsection

@section('bottom-js')
    <script>
        $('.owl-carousel').owlCarousel({
            rtl: true,
            loop: false,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
@endsection
