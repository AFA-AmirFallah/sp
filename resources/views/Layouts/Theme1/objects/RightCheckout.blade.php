@php
    $benefit = 0;
    $totall = 0;
@endphp

<div class="products" >

    @foreach ($OrderDetials as $OrderItem)
        <div class="product product-cart">
            <div class="product-detail">
                <a href="{{ route('SingleProduct', ['productID' => $OrderItem['id']]) }}"
                    class="product-name">{{ $OrderItem['Name'] }}</a>
                <div class="price-box">
                    @if (!isset($OrderItem['TashimRes'][0]))
                        @php
                            $totall += $OrderItem['Price'] * $OrderItem['Qty'];
                            $benefit += $OrderItem['BasePrice'] * $OrderItem['Qty'] - $OrderItem['Price'] * $OrderItem['Qty'];
                        @endphp


                        <span
                            class="product-price">{{ number_format($OrderItem['Price'] / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                        <span class="product-quantity">{{ $OrderItem['Qty'] }}</span>
                    @else
                        @php
                            $tashimArr = $OrderItem['TashimRes'];
                            $targetPrice = 0;

                            foreach ($tashimArr as $tashimItem) {
                                $targetPrice += $tashimItem['priceStr'];
                            }
                            $totall += $targetPrice * $OrderItem['Qty'];
                            $benefit += $OrderItem['BasePrice'] * $OrderItem['Qty'] - $targetPrice * $OrderItem['Qty'];

                        @endphp
                        <span
                            class="product-price">{{ number_format($targetPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                        <span class="product-quantity">{{ $OrderItem['Qty'] }}</span>
                    @endif

                </div>
            </div>
            <figure class="product-media">
                <a href="{{ route('SingleProduct', ['productID' => $OrderItem['id']]) }}">
                    <img src="{{ $OrderItem['Pic'] }}" alt="product" height="84" width="94" />
                </a>
            </figure>
            <button class="btn btn-link btn-close" type="button" onclick="removeitemmainlayout({{ $OrderItem['id'] }})">
                <i class="fas fa-times"></i>
            </button>

        </div>
    @endforeach
</div>


<div class="cart-total">
    <label>مجموع کل: </label>
    <span class="price">{{ number_format($totall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
        {{ App\Http\Controllers\Credit\currency::GetCurrency() }} </span>


</div>
@if (Auth::Check())
    <div class="cart-action">
        <a href="{{ route('checkout') }}" class="btn btn-block btn-primary btn-rounded btn-icon-right">پرداخت
        </a>
    </div>
@else
    <div class="cart-action">
        <a href="{{ route('login') }}" class="btn btn-block btn-primary btn-rounded btn-icon-right">ورود و
            ادامه
        </a>
    </div>
@endif
