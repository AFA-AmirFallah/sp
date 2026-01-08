<div class="row appear-animate">
    <div class="col-lg-4 col-md-5 mb-6">
        <div class="product-lg br-sm">
            <h2 class="title title-underline mb-4">
                {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title1') }}</h2>
            <div class="owl-carousel owl-theme owl-nav-top owl-nav-md row cols-1"
                data-owl-options="{
                'nav': true,
                'dots': false,
                'autoplay': true,
             'autoplayTimeout': 4000,
                'margin': 20
            }">
                @foreach ($DashboardClass->GetProductListFromIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID1'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit1')) as $ProductItem)
                    @php
                        $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
                        $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
                        $MinPrice = $Product->GetTargetPrice($ProductItem->MinPrice, $ProductItem->tax_status);
                        $MaxPrice = $Product->GetTargetPrice($ProductItem->MaxPrice, $ProductItem->tax_status);
                    @endphp
                    <div class="product text-center">
                        <figure class="product-media">


                            <a
                                href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                                    alt="{{ $ProductItem->NameFa }}" width="300" height="300">

                                <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 2) }}"
                                    alt="{{ $ProductItem->NameFa }}" width="300" height="300">
                            </a>


                        </figure>
                        @if ($BasePrice != $Price)
                            <div class="product-label-group">
                                @if ($ProductItem->PricePlan == null)
                                    <label
                                        class="product-label label-discount">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label>
                                @else
                                    <label
                                        class="product-label label-discount">{{ ceil((($BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $BasePrice) }}%</label>
                                @endif
                            </div>
                        @endif
                        <div class="product-details">
                            <h3 class="product-name">
                                <a
                                    href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ $ProductItem->NameFa }}</a>
                            </h3>
                            <div class="product-price">
                                @if ($ProductItem->MinPrice != 0)
                                    @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductItem->MaxPrice == 0)
                                        <ins class="new-price">
                                            {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        </ins>
                                    @else
                                        <ins class="new-price"> از
                                            {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            تا
                                            {{ number_format($MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        </ins>
                                    @endif
                                @else
                                    <ins class="new-price">
                                        {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    </ins>
                                @endif

                                @if ($BasePrice != $Price && $BasePrice != 0)
                                    <del class="old-price">{{ $BasePrice }} </del>
                                @endif

                            </div>
                        </div>
                    </div>
                    <!-- End of Product -->
                @endforeach
            </div>
            <!-- End of Owl Carousel -->
            <div class="product-countdown-container">
                <div class="countdown-lable mr-3 mb-2">
                    <h4 class="font-weight-bold ls-10">عجله کن!</h4>
                    <label class="text-dark">پیشنهاد به پایان می رسد:</label>
                </div>
                <div class="product-countdown countdown-compact mb-2" data-until="2021, 9, 9" data-format="DHMS"
                    data-compact="false" data-labels-short="Days, Hours, Mins, Secs">
                    00:00:00:00
                </div>
            </div>
        </div>
    </div>
    <!-- End of Col -->
    <div class="col-lg-8 col-md-7 mb-6">
        <div class="tab tab-nav-underline tab-nav-center">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"
                        href="#tab-1">{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title2') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="#tab-2">{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title3') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab-3">
                        {{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'title4') }} </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-1">
                <div class="owl-carousel owl-theme row cols-lg-4 cols-sm-3 cols-2"
                    data-owl-options="{
                    'nav': false,
                    'dots': true,
                    'margin': 20,
                    'responsive': {
                        '0': {
                            'items': 2
                        },
                        '576': {
                            'items': 3
                        },
                        '992': {
                            'items': 4
                        }
                    }
                }">
                    @php
                        $products = $DashboardClass->GetProductListFromIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID2'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit2'));
                    @endphp
                    @foreach (collect($products)->chunk(2) as $productChunk)
                        <div class="product-col">
                            @foreach ($productChunk as $ProductItem)
                                @php
                                    $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
                                    $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
                                    $MinPrice = $Product->GetTargetPrice($ProductItem->MinPrice, $ProductItem->tax_status);
                                    $MaxPrice = $Product->GetTargetPrice($ProductItem->MaxPrice, $ProductItem->tax_status);
                                @endphp
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a
                                            href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                            <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                                                alt="{{ $ProductItem->NameFa }}" width="300" height="338">
                                        </a>

                                    </figure>
                                    @if ($BasePrice != $Price)
                                        <div class="product-label-group">
                                            @if ($ProductItem->PricePlan == null)
                                                <label
                                                    class="product-label label-discount">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label>
                                            @else
                                                <label
                                                    class="product-label label-discount">{{ ceil((($BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $BasePrice) }}%</label>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="product-details">
                                        <h3 class="product-name">
                                            <a
                                                href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ $ProductItem->NameFa }}</a>
                                        </h3>
                                        <div class="product-price">
                                            @if ($ProductItem->MinPrice != 0)
                                                @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductItem->MaxPrice == 0)
                                                    <ins class="new-price">
                                                        {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @else
                                                    <ins class="new-price"> از
                                                        {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        تا
                                                        {{ number_format($MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @endif
                                            @else
                                                <ins class="new-price">
                                                    {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                </ins>
                                            @endif

                                            @if ($BasePrice != $Price && $BasePrice != 0)
                                                <del class="old-price">{{ $BasePrice }} </del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End of Tab Pane -->
            <div class="tab-pane" id="tab-2">
                <div class="owl-carousel owl-theme row cols-xl-4 cols-lg-3 cols-md-2"
                    data-owl-options="{
                    'nav': false,
                    'dots': true,
                    'margin': 20,
                    'responsive': {
                        '0': {
                            'items': 2
                        },
                        '576': {
                            'items': 3
                        },
                        '992': {
                            'items': 4
                        }
                    }
                }">
                    @php
                        $products = $DashboardClass->GetProductListFromIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID3'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit3'));
                    @endphp
                    @foreach (collect($products)->chunk(2) as $productChunk)
                        <div class="product-col">
                            @foreach ($productChunk as $ProductItem)
                                @php
                                    $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
                                    $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
                                    $MinPrice = $Product->GetTargetPrice($ProductItem->MinPrice, $ProductItem->tax_status);
                                    $MaxPrice = $Product->GetTargetPrice($ProductItem->MaxPrice, $ProductItem->tax_status);
                                @endphp
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a
                                            href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                            <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                                                alt="{{ $ProductItem->NameFa }}" width="300" height="338">
                                        </a>

                                    </figure>
                                    @if ($BasePrice != $Price)
                                        <div class="product-label-group">
                                            @if ($ProductItem->PricePlan == null)
                                                <label
                                                    class="product-label label-discount">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label>
                                            @else
                                                <label
                                                    class="product-label label-discount">{{ ceil((($BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $BasePrice) }}%</label>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="product-details">
                                        <h3 class="product-name">
                                            <a
                                                href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ $ProductItem->NameFa }}</a>
                                        </h3>
                                        <div class="product-price">
                                            @if ($ProductItem->MinPrice != 0)
                                                @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductItem->MaxPrice == 0)
                                                    <ins class="new-price">
                                                        {{ number_format($ProductItem->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @else
                                                    <ins class="new-price"> از
                                                        {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        تا
                                                        {{ number_format($MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @endif
                                            @else
                                                <ins class="new-price">
                                                    {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                </ins>
                                            @endif

                                            @if ($BasePrice != $Price && $BasePrice != 0)
                                                <del class="old-price">{{ $BasePrice }} </del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End of Tab Pane -->
            <div class="tab-pane" id="tab-3">
                <div class="owl-carousel owl-theme row cols-xl-4 cols-lg-3 cols-md-2"
                    data-owl-options="{
                    'nav': false,
                    'dots': true,
                    'margin': 20,
                    'responsive': {
                        '0': {
                            'items': 2
                        },
                        '576': {
                            'items': 3
                        },
                        '992': {
                            'items': 4
                        }
                    }
                }">
                    @php
                        $products = $DashboardClass->GetProductListFromIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID4'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit4'));
                    @endphp
                    @foreach (collect($products)->chunk(2) as $productChunk)
                        <div class="product-col">
                            @foreach ($productChunk as $ProductItem)
                                @php
                                    $Price = $Product->GetTargetPrice($ProductItem->Price, $ProductItem->tax_status);
                                    $BasePrice = $Product->GetTargetPrice($ProductItem->BasePrice, $ProductItem->tax_status);
                                    $MinPrice = $Product->GetTargetPrice($ProductItem->MinPrice, $ProductItem->tax_status);
                                    $MaxPrice = $Product->GetTargetPrice($ProductItem->MaxPrice, $ProductItem->tax_status);
                                @endphp
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a
                                            href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">
                                            <img src="{{ App\Functions\Images::GetPicture($ProductItem->ImgURL, 1) }}"
                                                alt="{{ $ProductItem->NameFa }}" width="300" height="338">
                                        </a>

                                    </figure>
                                    @if ($BasePrice != $Price)
                                        <div class="product-label-group">
                                            @if ($ProductItem->PricePlan == null)
                                                <label
                                                    class="product-label label-discount">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label>
                                            @else
                                                <label
                                                    class="product-label label-discount">{{ ceil((($BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan)) * 100) / $BasePrice) }}%</label>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="product-details">
                                        <h3 class="product-name">
                                            <a
                                                href="{{ route('SingleProduct', ['productID' => $ProductItem->id, 'productName' => $ProductItem->NameFa]) }}">{{ $ProductItem->NameFa }}</a>
                                        </h3>
                                        <div class="product-price">
                                            @if ($ProductItem->MinPrice != 0)
                                                @if ($ProductItem->MinPrice == $ProductItem->MaxPrice || $ProductItem->MaxPrice == 0)
                                                    <ins class="new-price">
                                                        {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @else
                                                    <ins class="new-price"> از
                                                        {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        تا
                                                        {{ number_format($MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                    </ins>
                                                @endif
                                            @else
                                                <ins class="new-price">
                                                    {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                                </ins>
                                            @endif

                                            @if ($BasePrice != $Price && $BasePrice != 0)
                                                <del class="old-price">{{ $BasePrice }} </del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End of Tab Pane -->
        </div>
    </div>
    <!-- End of Col -->
</div>
