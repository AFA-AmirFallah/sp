@extends('Layouts.Theme5.layout.main_layout')
@section('content')
    <div class="product_cat_meta main_tag">

        @foreach ($matas as $mata_item)
            @if ($mata_item->L2ID == $TargetLayer)
                <a href="{{ route('ProductCats', ['TargetLayer' => $mata_item->L2ID]) }}" class="item-meta-sdsfd main_tag active">
                    {{ $mata_item->Name }}
                </a>
            @else
                <a href="{{ route('ProductCats', ['TargetLayer' => $mata_item->L2ID]) }}" class="item-meta-sdsfd main_tag">
                    {{ $mata_item->Name }}
                </a>
            @endif
        @endforeach
    </div>
    <div class="product_cat_meta">

        @foreach ($Cats as $Cats_item)
            @if ($loop->first)
                <a href="{{ route('ShowProduct', ['Tags' => $Cats_item->UID]) }}" class="item-meta-sdsfd active">
                    {{ $Cats_item->Name }}
                </a>
            @else
                <a href="{{ route('ShowProduct', ['Tags' => $Cats_item->UID]) }}" class="item-meta-sdsfd">
                    {{ $Cats_item->Name }}
                </a>
            @endif
        @endforeach
    </div>



    <main class="main-content dt-sl mb-3">
        <div class="container main-container">
            <!-- Start Main-Slider -->
            @foreach ($Cats as $Cats_item)
                <!-- Top Sliders -->
                @include('Layouts.Theme5.objects.T508_single_banner_cats', [
                    'Cats_item' => $Cats_item,
                    'DashboardClass' => $DashboardClass,
                    'MyProduct' => $MyProduct,
                    'Product' => $Product,
                ])
            @endforeach

        </div>
    </main>
@endsection
@section('end_script')
@endsection
