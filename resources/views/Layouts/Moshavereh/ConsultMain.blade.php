

@extends('Layouts.Moshavereh.objects.MainLayout')
@section('content')
    <section id="above-page" class="container-fluid mb-5 mb-3 ">
        <div class="above-page-img">
            <img src="Mosahvereh/Images/bg1.jpg" alt="" title="" class="d-lg-block d-none">
        </div>
        <div class="container">
            <div class="row">
                <div class="above-page-content m-auto">
                    <div class="above-page-tagline">
                        <h1 class="main-tagline IRANSansWeb_Bold">جامع ترین سامانه مشـاوره آنلاین</h1>
                       {{--  <p class="explaine-tagline">
                            <span>با بیش از 5000 کارشناس متخصص به صورت </span>
                            <span class="rw-words rw-words-1">
                                <span>متنی</span>
                                <span>صوتی</span>
                                <span>تلفنی</span>
                                <span>متنی</span>
                                <span>صوتی</span>
                                <span>تلفنی</span>
                            </span>
                            <span>گفتگو کنید</span>
                        </p> --}}
                    </div>
                    <form method="get" action="{{ route('search') }}">
                        <div class="above-page-search">
                            <input type="text" class="srch-input" name="M" id="search"
                                placeholder="جستجوی کارشناس، تخصص .." />
                            <button class="search-icon" type="submit"
                                style="
                            background-color: white;
                            border: none;
                            border-radius: 20px;">
                                <i class="fas fa-search text-danger fa-2x"></i>
                            </button>

                        </div>

                    </form>

                    <div class="last-question-time d-lg-block d-none">
                        <div class="d-flex flex-row justify-content-center">
                            <a href="{{route('shop')}}" class="btn btn-danger text-white rad25 py-2 m-2"><i class="fa fa-shop ml-2"></i>فروشگاه</a>
                            <a href="{{route('home')}}"  class="btn btn-purple text-white rad25 py-2 m-2"><i class="fa fa-stethoscope  ml-2"></i>بیمارستان مجازی</a>
                                <a href="https://doctorkomak.ir"  class="btn btn-primary text-white rad25 py-2 m-2"><i class="fa fa-stethoscope  ml-2"></i>دکتر کمک</a>
                                    <a href="https://hospitour.net"  class="btn btn-success text-white rad25 py-2 m-2"><i class="fa fa-stethoscope  ml-2"></i>بخش بین الملل</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    @include('Layouts.Moshavereh.objects.M1401-1')



    <div id="container">

    </div>

    @include('Layouts.Moshavereh.objects.M1401-2')

    @include('Layouts.Moshavereh.objects.M1401-3')
    @foreach ($mobile_banners as $mobile_banner)
        @if ($mobile_banner->theme == 310)
            @include('Layouts.Moshavereh.objects.M1401-4')
        @endif
    @endforeach
@endsection
@section('script')
    <script>
        $loadingHtml = ` <div class="d-flex justify-content-center">
        <div class="loader276 "></div>
    </div>`;
    </script>
    <script>
        $(document).ready(function() {
            $(window).load(function() {
                $.ajax({
                    url: '?page=1',
                    type: 'get',
                    beforeSend: function() {
                        $('#container').html($loadingHtml);

                    },
                    success: function(response) {
                        //todo: end loading
                        $('#container').html(response)

                    },
                    error: function() {
                        //todo: end loading
                        alert(' بروز مشکل در برقراری ارتباط');
                    }
                });
            });
        });

        function selectcat($catID) {
            $.ajax({
                url: '?page=2&catID=' + $catID,
                type: 'get',
                beforeSend: function() {
                    //todo: start loading
                },
                success: function(response) {
                    //todo: end loading
                    $('#container').html(response)

                },
                error: function() {
                    //todo: end loading
                    alert(' بروز مشکل در برقراری ارتباط');
                }
            });

        }

        function l2laoding($catID, $ZoneID) {
            $.ajax({
                url: '?page=3&catID=' + $catID + '&ZoneID=' + $ZoneID,
                type: 'get',
                beforeSend: function() {
                    //todo: start loading
                },
                success: function(response) {
                    //todo: end loading
                    $('#container').html(response)

                },
                error: function() {
                    //todo: end loading
                    alert(' بروز مشکل در برقراری ارتباط');
                }
            });

        }
    </script>
@endsection
