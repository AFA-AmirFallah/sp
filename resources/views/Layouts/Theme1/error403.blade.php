@extends('Layouts.Theme1.MainLayout')
@section('MainContent')
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ route('home') }}">صفحه اصلی </a></li>
                <li>ارور 403</li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of Page Content -->
    <div class="page-content error-404">
        <div class="container">
            <div class="banner">
                <figure>
                    <img src={{ asset("Theme1/assets/images/pages/404.png") }} alt="ارور 404" width="820" height="460" />
                </figure>
                <div class="banner-content text-center">
                    <h2 class="banner-title">
                        {{ __('Access deny') }}
                    </h2>
                    <p class="text-light">{{ __('Sorry you have not Access permission to brows this URL !!') }}</p>
                    <a href="{{ route('home') }}" class="btn btn-dark btn-rounded btn-icon-right">برگشت به صفحه اصلی<i
                            class="w-icon-long-arrow-left"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Content -->
@endsection
