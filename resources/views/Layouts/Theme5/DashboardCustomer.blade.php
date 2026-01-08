@extends('Layouts.Theme5.layout.main_layout')
@section('content')




    <main class="main-content dt-sl mb-3">
        <div class="container main-container">
            <!-- Start Main-Slider -->

            @foreach ($mobile_banners as $mobile_banner)
                @if ($mobile_banner->theme == 501)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T501_main_slider')
                @endif
            @endforeach
            @foreach ($mobile_banners as $mobile_banner)
                @if ($mobile_banner->theme == 505)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T505_single_banner')
                @endif
                @if ($mobile_banner->theme == 506)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T506_single_banner')
                @endif
                @if ($mobile_banner->theme == 507)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T507_single_banner')
                @endif
                @if ($mobile_banner->theme == 504)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T504_single_banner')
                @endif
                @if ($mobile_banner->theme == 508)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T508_single_banner')
                @endif
                @if ($mobile_banner->theme == 509)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T509_single_banner')
                @endif
                @if ($mobile_banner->theme == 510)
                    <!-- Top Sliders -->
                    @include('Layouts.Theme5.objects.T510_single_banner')
                @endif
            @endforeach

        </div>
    </main>
@endsection
@section('end_script')

@endsection
