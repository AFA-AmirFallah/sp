@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')
@section('MainTitle')
@endsection

@section('ExtraTags')
@endsection
@section('MainContent')
    <input id="main_url" class="nested" value="{{ url('/') }}">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ route('home') }}">صفحه اصلی </a></li>
                <li><a href="#">فروشگاه </a></li>

            </ul>
        </div>
    </nav>




    <div class="page-content">



        <div class="container">
            <!-- Start of Shop Content -->

            <!--
                     Consult Main

                  ss  -->
            @foreach ($Consult->get_consulting_cats() as $cats)
                <div>
                    <a onclick="selectcat({{ $cats->L1ID }})">{{ $cats->Name }}</a>
                </div>
            @endforeach

            <!--
                     End Consult Main

                    -->

           <div id="divcontent">

        </div>

        </div>
    </div>
    <!-- End of Page Content -->
@endsection
@section('page-js')
    <script>
        function selectcat($catID) {
            $.ajax({
                url: '?page=2&catID=' + $catID,
                type: 'get',
                beforeSend: function() {
                    //todo: start loading
                },
                success: function(response) {
                    //todo: end loading
                    $('#divcontent').html(response)

                },
                error: function() {
                    //todo: end loading
                    alert(' بروز مشکل در برقراری ارتباط');
                }
            });

        }
        function l3laoding($catID,$ZoneID) {
            $.ajax({
                url: '?page=3&catID=' + $catID + '&ZoneID=' + $ZoneID,
                type: 'get',
                beforeSend: function() {
                    //todo: start loading
                },
                success: function(response) {
                    //todo: end loading
                    $('#divcontent').html(response)

                },
                error: function() {
                    //todo: end loading
                    alert(' بروز مشکل در برقراری ارتباط');
                }
            });

        }
    </script>
@endsection
