@php
    $GetBasketItemsBrif = App\Http\Controllers\woocommerce\buy::GetBasketItemsBrif();
    if ($GetBasketItemsBrif == []) {
        $order_count = 0;
    }

    $benefit = 0;
    $totall = 0;
        $counter = 0;

@endphp

<div class="nav-item cart--wrapper">
    <a class="nav-link basket-cart-info" href="javascript:show_basket()">
        <span class="label-dropdown"></span>
        <i style="font-size: 24px" class="mdi mdi-cart-outline"></i>
        <input class="count" type="number" disabled
            value="{{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() ?? 0 }}">
    </a>
    <div id="main_basket_header" class="header-cart-info">
        <div class="header-cart-info-header">
            <div class="header-cart-info-count">
                {{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() ?? 0 }} کالا
            </div>
            <button type="button" class="buy_new" onclick="close_basket()" data-dismiss="modal" aria-label="Close"
                style="border-style: none;background-color: transparent;box-shadow: none;top: 5px;left: 11px;">
                <i style="font-size: 27px;" class="mdi mdi-close-circle-outline"></i>
            </button>
        </div>

        <ul class="header-basket-list do-nice-scroll" style="overflow: hidden;outline: none;margin-bottom: 0px;">
            @foreach ($GetBasketItemsBrif as $OrderItem)

                @if ($OrderItem['Remian'] != 0)
                    <li class="cart-item">
                        <a href="{{ route('SingleProduct', ['productID' => $OrderItem['id']]) }}"
                            class="header-basket-list-item">
                            <div style="display: flex">
                                <div class="header-basket-list-item-image">
                                    <img src="{{ $OrderItem['Pic'] }}" alt="{{ $OrderItem['Name'] }}">
                                </div>
                                <div class="header-basket-list-item-content">
                                    <p class="header-basket-list-item-title">
                                        {{ $OrderItem['Name'] }}
                                    </p>
                                    <div class="header-basket-list-item-footer">
                                        <div class="header-basket-list-item-props">
                                            <span class="header-basket-list-item-props-item">
                                                {{ $OrderItem['Qty'] }} عدد
                                            </span>
                                        </div>
                                        @if (!isset($OrderItem['TashimRes'][0]))
                                            @php
                                                $totall += $OrderItem['Price'] * $OrderItem['Qty'];
                                                $benefit +=
                                                    $OrderItem['BasePrice'] * $OrderItem['Qty'] -
                                                    $OrderItem['Price'] * $OrderItem['Qty'];
                                            @endphp


                                            <span
                                                class="product-price">{{ number_format($OrderItem['Price'] / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                                        @else
                                            @php
                                                $tashimArr = $OrderItem['TashimRes'];
                                                $targetPrice = 0;

                                                foreach ($tashimArr as $tashimItem) {
                                                    $targetPrice += $tashimItem['priceStr'];
                                                }
                                                $totall += $targetPrice * $OrderItem['Qty'];
                                                $benefit +=
                                                    $OrderItem['BasePrice'] * $OrderItem['Qty'] -
                                                    $targetPrice * $OrderItem['Qty'];

                                            @endphp
                                            <span
                                                class="product-price">{{ number_format($targetPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                                        @endif
                                        <button class="header-basket-list-item-remove"
                                            onclick="removeitemmainlayout({{ $OrderItem['id'] }})">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </li>
                @else
                    @php
                        $counter++;
                    @endphp
                @endif
            @endforeach
            @if (count($GetBasketItemsBrif) == 0)
                <li class="cart-item">
                    <a href="#" class="header-basket-list-item">
                        <div style="display: flex">
                            <div class="header-basket-list-item-image">
                                <i style="font-size: 23px;color:#f44336" class="mdi mdi-cart-off"></i>
                            </div>
                            <div style="padding-top: 15%" class="header-basket-list-item-content">
                                <p class="header-basket-list-item-title">
                                    سبد خرید خالی است
                                </p>

                            </div>
                        </div>

                    </a>
                </li>
            @endif
        </ul>
        @if (count($GetBasketItemsBrif) == 0)
            <div class="header-cart-info-footer">
                <div class="basket_end-btn header-cart-info-total">
                    <p class="header-cart-info-total-amount">

                        <a href="{{ route('ShowProduct') }}" type="button"
                            class="btn-primary-cm btn-with-icon mx-auto w-100"> خرید از فروشگاه
                        </a>
                </div>
            </div>
        @else
            <div class="header-cart-info-footer">
                <div class="header-cart-info-total">
                    <span class="header-cart-info-total-text">مبلغ قابل پرداخت:</span>
                    <p class="header-cart-info-total-amount">
                        <span class="header-cart-info-total-amount-number">
                            {{ number_format($totall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                            <span>{{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span></span>
                    </p>
                </div>
                @if (Auth::Check())
                    @if ($counter != 0)
                        <div style = "background-color: red;
    color: white;" class="alert alert-icon alert-error alert-bg alert-inline d-flex justify-content-center ">
                            <h4 class="alert-title">
                            </h4> سبد خرید شما نیاز به ویرایش دارد
                        </div>
                    @else
                        <div style="text-align: end;">
                            <a href="{{ route('checkout') }}"
                                class="basket_end-btn btn-primary-cm btn-with-icon mx-auto w-100">
                                ثبت سفارش </a>
                        </div>
                    @endif
                @else
                    <div style="
                text-align: end;
            ">
                        <a href="{{ route('login') }}"
                            class="basket_end-btn btn-primary-cm btn-with-icon mx-auto w-100">
                            ورود و ادامه </a>
                    </div>
                @endif

            </div>
        @endif
    </div>
</div>
