@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme5.layout.main_layout')
@section('content')
    <main class="menu-page main-content dt-sl mb-3">
        <div class="main-product-cat">
            @foreach ($main_cat as $main_cat_item)
                <div class="eDChSaa">
                    <a class="eDChSee" href="{{ route('ProductCats', ['TargetLayer' => $main_cat_item->L2ID]) }}">
                        <div class="sc-gDeeJ eDChSf">
                            <div class="eDChSfcc">
                                <img src="{{ $main_cat_item->img ?? 'https://sepehrmall.com/storage/photos/category/1-biscuit.chocolate.png' }}"
                                    alt="{{ $main_cat_item->Name }}" class="eDChSfee">
                            </div>
                        </div>
                        <p class="eDChSfddff">{{ $main_cat_item->Name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </main>
@endsection
