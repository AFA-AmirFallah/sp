@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')
@section('MainContent')
    <!--  Main Banner    -->
    @foreach ($mobile_banners as $mobile_banner)
        @if ($mobile_banner->theme == 201)
            <!-- Top Sliders -->
            @include('Layouts.Theme1.objects.T1401_17')
        @endif
        @if ($mobile_banner->theme == 202)
            <!-- horizantal product list -->
            @include('Layouts.Theme1.objects.T1401_18')
        @endif
        @if ($mobile_banner->theme == 203)
            <!-- horizantal Tags show -->
            @include('Layouts.Theme1.objects.T1401_7')
        @endif
        @if ($mobile_banner->theme == 204)
            <!-- Brands show -->
            @include('Layouts.Theme1.objects.T1401_9')
        @endif
        @if ($mobile_banner->theme == 205)
            <!-- news  show -->
            @include('Layouts.Theme1.objects.T1401_15')
        @endif
        @if ($mobile_banner->theme == 206)
            <!--  4x photos -->
            @include('Layouts.Theme1.objects.T1401_1')
        @endif
        @if ($mobile_banner->theme == 208)
            <!--   2x photos -->
            @include('Layouts.Theme1.objects.T1401_11')
        @endif
        @if ($mobile_banner->theme == 209)
            <!--   1x photos -->
            @include('Layouts.Theme1.objects.T1401_19')
        @endif
        @if ($mobile_banner->theme == 210)
            <!--   new horizantal product list -->
            @include('Layouts.Theme1.objects.T1401_20')
        @endif
        @if ($mobile_banner->theme == 211)
            <!--   product list  -->
            @include('Layouts.Theme1.objects.T1401_21')
        @endif
        @if ($mobile_banner->theme == 212)
            <!--   product list  -->
            @include('Layouts.Theme1.objects.T1401_5')
        @endif
        @if ($mobile_banner->theme == 299)
            <!--   free style -->
            @include('Layouts.Theme1.objects.T1_free_style')
        @endif
    @endforeach



@endsection
