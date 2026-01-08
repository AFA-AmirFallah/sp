@php
    $Conter = 0;
@endphp
@foreach ($Goods as $Good)
    @php
        $Conter++;
    @endphp
    <div class="product-wrap">
        <div class="product text-center">
            <figure class="product-media">
                <a href="{{ route('SingleProduct', ['productID' => $Good->id]) }}">
                    <img src="{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}" alt="" width="300"
                        height="338" />
                </a>
                @if ($Good->BasePrice - $Good->Price != 0)
                    <div class="Discount_Percent">
                        <label>

                            {{ ceil((($Good->BasePrice - $Good->Price) * 100) / $Good->BasePrice) }}%

                        </label>
                    </div>
                @endif
            </figure>
            <div class="product-details">
                <h3 class="product-name">
                    <a href="{{ route('SingleProduct', ['productID' => $Good->id]) }}">{{ $Good->NameFa }}</a>
                </h3>
                @php
                    $BasePrice = App\Http\Controllers\woocommerce\ProductClass::GetTargetPrice($Good->BasePrice, $Good->tax_status);
                    $Price = App\Http\Controllers\woocommerce\ProductClass::GetTargetPrice($Good->Price, $Good->tax_status);
                    
                @endphp

                @if ($Good->Remian > 0)
                    <div class="product-pa-wrapper">
                        <div class="product-price">

                            <div style="float:left;white-space: nowrap;">
                                @if ($Good->BasePrice - $Good->Price != 0)
                                    <div class="discount_main">

                                        <del class="old-price">
                                            {{ number_format($BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        </del>
                                    </div>
                                @endif
                                @if ($Good->MinPrice != 0)
                                    @if ($Good->MinPrice == $Good->MaxPrice || $Good->MaxPrice == 0)
                                        {{ number_format($Good->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    @else
                                        {{ number_format($Good->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        تا
                                        {{ number_format($Good->MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                    @endif
                                @else
                                    {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                @endif

                            </div>
                        </div>
                    </div>
                @else
                    <div class="product-pa-wrapper">
                        <div class="product-price">
                            <p style="color: red !important" class="m-0 text-small text-muted">
                                تمام شده! </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
@if ($Conter == 0)
    <script>
        show_moredata(2);
    </script>
@elseif ($Conter == 10)
    <script>
        window.loaddatainit = true;
        show_moredata(1);
    </script>
@else
    <script>
        window.loaddatainit = true;
        show_moredata(3);
    </script>
@endif
