@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('page-header-left')

@endsection
@section('MainCountent')

    @include('Layouts.PWAObjects.PWAPageName')
    @include("Layouts.PWAObjects.PWABanner")
    @if (in_array(2, $PagesObjects))
        @include('Layouts.PWAObjects.PWAIcons')
    @endif
    @if (in_array(3, $PagesObjects))
        @include('Layouts.PWAObjects.PWABOXIcon')
    @endif
    @if (in_array(4, $PagesObjects))
        @include('Layouts.PWAObjects.PWAPosters')
    @endif

    </div>
    @include("Layouts.MainRouteCard")
@endsection

@section('page-js')
    <script>

    </script>


@endsection

@section('bottom-js')

@endsection
