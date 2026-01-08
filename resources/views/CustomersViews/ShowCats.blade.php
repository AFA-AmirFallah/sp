@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('page-header-left')

@endsection
@section('MainCountent')
    @if (\App\myappenv::Lic['wpa'])
        @include("Layouts.PWAObjects.PWABanner")
    @endif
    @include("Layouts.MainRouteCard")
    <div class="row">
        @foreach ($Cats as $Cat)

            <div style="padding-right:5px" class="wpa-md6 col-md-6">
                @if ($route == 'ToL2')
                    <a href="{{ route('ShowCats', ['workcat' => $Cat->WorkCat, 'L1Work' => $Cat->L1ID]) }}">
                    @elseif ($route == 'ToL3')
                        <a
                            href="{{ route('ShowCats', ['workcat' => $Cat->WorkCat, 'L1Work' => $Cat->L1ID, 'L2Work' => $Cat->L2ID]) }}">

                        @elseif ($route == 'Totarget')
                            <a href="{{ route('Moshavere', ['CatID' => $Cat->UID]) }}">

                @endif
                <div class=" card card-ecommerce-3 o-hidden mb-4">
                    <div class="d-flex flex-column flex-sm-row">
                        <div class="">
                            <img class="card-img-left" src="{{ $Cat->img }}" alt="{{ $Cat->Name }}">
                        </div>
                        <div class="flex-grow-1 p-4">
                            <h6 class="CustomerServiceCardHeader m-0">{{ $Cat->Name }}</h6>
                            @if ($Cat->Description == null || $Cat->Description == '')
                            @else
                                <hr class="CustomerServiceCardHr">
                                <p class="m-0 text-small text-muted">{{ $Cat->Description }}</p>
                            @endif
                            <!-- <button style="width:100%;background:linear-gradient(45deg, #0072ff, #4ed199) ; border-width:0px" class="btn from-control btn-primary"> انتخاب</button> -->
                        </div>
                    </div>
                </div>
                </a>
            </div>
        @endforeach

    </div>

@endsection

@section('page-js')

@endsection

@section('bottom-js')

@endsection
