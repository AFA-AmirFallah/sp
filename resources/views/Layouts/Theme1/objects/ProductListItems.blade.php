
@foreach ($Tags as $Tag)
    @if ($loop->first)


    @php
        $Source = $DashboardClass->GetProductListFromIndex($Tag->UID, 10);

    @endphp
    @if ($Source != [])

        @foreach ($Source as $ProductItem)
            @php
                $ProductSample = $ProductItem;

            @endphp
        @break

    @endforeach

    <section class="vendor-product-section">
        @if ($ProductSample->WorkCat < 1000)
            <div class="title-link-wrapper mb-4">
                <h4 class="title text-left"> {{ $Tag->L3Name }}</h4>
                <a href="{{ route('ShowProduct', ['Tags' => $Tag->UID]) }}"
                    class="btn btn-dark btn-link btn-slide-right btn-icon-right">ادامه محصولات
                    <i class="w-icon-long-arrow-left"></i></a>
            </div>
            <div class="owl-carousel owl-theme row cols-lg-3 cols-md-4 cols-sm-3 cols-2"
                data-owl-options="{
        'nav': false,
        'dots': false,
        'margin': 20,
        'responsive': {
            '0': {
                'items': 2
            },
            '576': {
                'items': 3
            },
            '768': {
                'items': 4
            },
            '992': {
                'items': 3
            }
        }
    }">

                @foreach ($Source as $ProductItem)
                    <div class="product">
                        <figure class="product-media">
                            <a
                                href="{{ route('SingleProduct', ['productID' => App\myappenv::PreProductTag . $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                                    alt="Product" width="300" height="338" />
                            </a>

                            <div class="product-action">

                                <a class="btn-product btn-quickview" title="نمایش سریع"
                                    href="{{ route('SingleProduct', ['productID' => App\myappenv::PreProductTag . $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">نمایش
                                    محصول

                                </a>
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="product-cat"><a href="">{{ $Tag->L3Name }} </a>
                            </div>
                            <h4 class="product-name"><a
                                    href="{{ route('SingleProduct', ['productID' => App\myappenv::PreProductTag . $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ Str::substr($ProductItem->NameFa, 0, 20) }}
                                    @if (Str::length($ProductItem->NameFa) > 20)
                                        ...
                                    @endif
                                </a>
                            </h4>

                            <div class="product-pa-wrapper">

                                <div class="product-price">
                                    @php
                                        $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);

                                    @endphp
                                    {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </section>
@endif
@endif
@endforeach
