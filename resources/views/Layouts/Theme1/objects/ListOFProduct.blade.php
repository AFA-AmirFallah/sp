@php
    $OrderDetials = $Order->get_order_detials();
    $ProductVirtual = $Order->get_order_virtual();
    // echo "ProductVirtual = $ProductVirtual";
    $BenefitTotall = 0;
    $TOPayTotall = 0;
@endphp
@if ($OrderDetials !== null)
    <div class="col-lg-8 pr-lg-4 mb-6" style="border: 1px solid var(--color_palet_6);
border-radius: 4px;">

        <input id="ProductVirtual" class="nested" value="{{ $ProductVirtual }}">
        <input id="Totalweighttmp" class="nested" value="{{ $Order->get_totall_wight() }}">
        <form method="POST">
            @csrf
            <table class="shop-table cart-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th class="product-name"><span>محصول </span></th>
                        <th class="product-price"><span>قیمت</span></th>
                        <th class="product-quantity"><span>تعداد</span></th>
                        <th class="product-subtotal"><span>جمع کل</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OrderDetials as $MyOrderTarget)
                        <tr>
                            <td class="product-thumbnail">
                                <div class="p-relative">
                                    <a>
                                        <figure>
                                            <img src="{{ App\Functions\Images::GetPicture($MyOrderTarget['Product']->ImgURL, 1) }}"
                                                alt="{{ $MyOrderTarget['Product']->NameFa }}" width="300"
                                                height="338">
                                        </figure>
                                    </a>
                                    <button type="button" onclick="removeitem({{ $MyOrderTarget['Product']->id }})"
                                        class="btn btn-close"><i class="fas fa-times"></i></button>
                                </div>
                            </td>
                            <td class="product-name">
                                <a>
                                    {{ $MyOrderTarget['Product']->NameFa }}
                                </a>
                            </td>
                            @php
                                $Price = $MyProduct->GetTargetPrice($MyOrderTarget['ProductInWarehouse']->Price, $MyOrderTarget['Product']->tax_status);
                                $BasePrice = $MyProduct->GetTargetPrice($MyOrderTarget['ProductInWarehouse']->BasePrice, $MyOrderTarget['Product']->tax_status);
                                $TashimRes = $MyProduct->TashimBlade($MyOrderTarget['Product']->id, $MyOrderTarget['ProductInWarehouse']->Price, $MyOrderTarget['Product']->tax_status);
                                $MinPrice = $MyProduct->GetTargetPrice($MyOrderTarget['ProductInWarehouse']->MinPrice, $MyOrderTarget['Product']->tax_status);
                                $MaxPrice = $MyProduct->GetTargetPrice($MyOrderTarget['ProductInWarehouse']->MaxPrice, $MyOrderTarget['Product']->tax_status);
                                $TotallProductPrice = 0;
                            @endphp

                            <td class="product-price"><span class="amount">

                                    @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0)
                                        @if ($TashimRes[0] == null)
                                            @php
                                                $TotallProductPrice += $Price;
                                            @endphp
                                            <strong class="product_continer_91">
                                                {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            </strong>
                                        @else
                                            @php
                                                $TotallProductPrice += $TashimRes[1];
                                            @endphp
                                            {{ number_format($TashimRes[1] / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            <small>{{ $TashimRes[0] }}</small>
                                        @endif
                                    @else
                                        @if (
                                            $MyOrderTarget['ProductInWarehouse']->MinPrice == $MyOrderTarget['ProductInWarehouse']->MaxPrice ||
                                                $MyOrderTarget['ProductInWarehouse']->MaxPrice == 0)
                                            {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @else
                                            از
                                            {{ number_format($MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            تا
                                            {{ number_format($MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @endif
                                    @endif

                                </span>
                            </td>
                            <td class="product-quantity">
                                <div class="input-group">

                                    <input type="text" class="nested" name="productid[]"
                                        value="{{ $MyOrderTarget['Product']->id }}">
                                    <input class="qty form-control" name="qty[]"
                                        id="qty_{{ $MyOrderTarget['Product']->id }}" type="number" min="1"
                                        value="{{ $MyOrderTarget['ProductQty'] }}"
                                        max="{{ $MyOrderTarget['ProductInWarehouse']->Remian }}">
                                    <button type="button" onclick="qtyplus({{ $MyOrderTarget['Product']->id }})"
                                        class="qty-plus w-icon-plus"></button>
                                    <button type="button" onclick="qtyminus({{ $MyOrderTarget['Product']->id }})"
                                        class="qty-minus w-icon-minus"></button>
                                </div>

                            </td>
                            @php
                                $Estelam = false;
                                if ($MyOrderTarget['ProductInWarehouse']->PricePlan == null) {
                                    if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0) {
                                        if (isset($TashimRes[0]) && $TashimRes[0] != '') {
                                            $UnitPrice = $TashimRes[1];
                                        } else {
                                            $UnitPrice = $Price;
                                        }

                                        $ItemTotall = $UnitPrice * $MyOrderTarget['ProductQty'];

                                        $ItemBenefit = $BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;

                                        $BenefitTotall += $ItemBenefit;

                                        $TOPayTotall += $ItemTotall;
                                    } else {
                                        //estelam
                                        $Estelam = true;
                                    }
                                } else {
                                    $ItemTotall = $MyProduct->GetTargetPriceFromPricePlanJson($MyOrderTarget['ProductInWarehouse']->PricePlan, $MyOrderTarget['ProductQty']) * $MyOrderTarget['ProductQty'];
                                    $ItemBenefit = $BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;
                                    $BenefitTotall += $ItemBenefit;
                                    $TOPayTotall += $ItemTotall;
                                }

                            @endphp
                            @if ($Estelam)
                                <input id="Estelamstatus" value="1" class="nested">
                                <td class="product-subtotal">
                                    پس از استعلام اعلام خواهد شد

                                </td>
                            @else
                                <input id="Estelamstatus" value="0" class="nested">
                                <td class="product-subtotal">
                                    <span class="amount">
                                        {{ number_format($ItemTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                                    @php
                                        $TashimResddd = $Order->TashimBlade($MyOrderTarget['Product']->id, $MyOrderTarget['ProductInWarehouse']->Price, $MyOrderTarget['Product']->tax_status);
                                    @endphp

                                    @foreach ($TashimResddd as $TashimResdItem)
                                        @if (!str_contains($TashimResdItem['OutPutStr'], '~'))
                                            <div>
                                                <li> <small>{{ $TashimResdItem['OutPutStr'] }} :
                                                        {{ number_format(($TashimResdItem['priceStr'] * $MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</small>

                                                </li>
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                            @endif

                        </tr>
                    @endforeach



                </tbody>

            </table>

            <div class="cart-action mb-6">
                {{--  <a href="/" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i
                    class="w-icon-long-arrow-right"></i>خرید را ادامه دهید </a> --}}
                <button type="button" onclick="clearorder()" class="btn btn-rounded btn-default btn-clear"
                    name="clear_cart" value="پاک کردن سبد">پاک
                    کردن سبد </button>
                <button class="btn btn-rounded btn-update disabled" name="typesubmit" id="update_cart"
                    value="updatepasket" onclick="updatebasket()">بروزرسانی سبد</button>
            </div>

            {{-- <h5 class="title coupon-title font-weight-bold text-uppercase">انواع کد تخفیف </h5>
        <button class="btn btn-dark btn-outline btn-rounded">اعمال کد</button> --}}
        </form>
        <input id="BenefitTotall" class="nested" value="{{ $BenefitTotall }}">
        <input id="TOPayTotall" class="nested" value="{{ $TOPayTotall }}">

    </div>
@else
    <div id="emtycheckout" class="row gutter-lg mb-10 ">
        <div class="order-success text-center font-weight-bolder text-dark">
            <svg width="161" height="160" viewBox="0 0 161 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_140_30)">
                    <path
                        d="M78.6067 75.1768L78.7837 75L78.6067 74.8231L67.1367 63.3632C67.1367 63.3632 67.1367 63.3631 67.1367 63.3631C66.695 62.9215 66.3447 62.3972 66.1057 61.8201C65.8667 61.2431 65.7437 60.6246 65.7437 60C65.7437 59.3754 65.8667 58.7569 66.1057 58.1798C66.3447 57.6027 66.6951 57.0784 67.1367 56.6367C67.5784 56.1951 68.1027 55.8447 68.6798 55.6057C69.2569 55.3667 69.8754 55.2437 70.5 55.2437C71.1246 55.2437 71.7431 55.3667 72.3201 55.6057C72.8972 55.8447 73.4215 56.195 73.8631 56.6367C73.8631 56.6367 73.8632 56.6367 73.8632 56.6367L85.3231 68.1067L85.5 68.2837L85.6768 68.1067L97.1367 56.6367C97.1368 56.6367 97.1368 56.6367 97.1368 56.6367C98.0288 55.7447 99.2386 55.2437 100.5 55.2437C101.761 55.2437 102.971 55.7448 103.863 56.6367C104.755 57.5287 105.256 58.7385 105.256 60C105.256 61.2614 104.755 62.4712 103.863 63.3632L92.3933 74.8231L92.2163 75L92.3933 75.1768L103.863 86.6367C104.755 87.5287 105.256 88.7385 105.256 90C105.256 91.2614 104.755 92.4712 103.863 93.3632C102.971 94.2552 101.761 94.7563 100.5 94.7563C99.2385 94.7563 98.0287 94.2552 97.1367 93.3632L85.6768 81.8933L85.5 81.7163L85.3231 81.8933L73.8632 93.3632C73.4215 93.8049 72.8972 94.1552 72.3201 94.3942C71.7431 94.6333 71.1246 94.7563 70.5 94.7563C69.8754 94.7563 69.2569 94.6333 68.6798 94.3942C68.1027 94.1552 67.5784 93.8049 67.1367 93.3632C66.6951 92.9215 66.3447 92.3972 66.1057 91.8201C65.8667 91.2431 65.7437 90.6246 65.7437 90C65.7437 89.3754 65.8667 88.7569 66.1057 88.1798C66.3447 87.6028 66.695 87.0785 67.1367 86.6368C67.1367 86.6368 67.1367 86.6368 67.1367 86.6367L78.6067 75.1768Z"
                        fill="#E8E8E8" stroke="black" stroke-width="0.5" />
                    <path
                        d="M16.8426 19.9395L16.7953 19.75H16.6H5.5C4.24022 19.75 3.03204 19.2496 2.14124 18.3588C1.25045 17.468 0.75 16.2598 0.75 15C0.75 13.7402 1.25045 12.532 2.14124 11.6412C3.03204 10.7504 4.24022 10.25 5.5 10.25L20.4999 10.25C20.5 10.25 20.5 10.25 20.5 10.25C21.5595 10.2503 22.5885 10.6048 23.4234 11.2572C24.2582 11.9096 24.851 12.8224 25.1074 13.8505L25.1075 13.8506L29.1575 30.0606L29.2048 30.25H29.4H145.5C146.197 30.2506 146.886 30.4049 147.517 30.7017C148.148 30.9986 148.706 31.4308 149.152 31.9676C149.597 32.5045 149.918 33.1328 150.093 33.8079C150.268 34.4831 150.293 35.1885 150.164 35.8739L135.164 115.874C134.961 116.962 134.383 117.946 133.531 118.653C132.679 119.361 131.607 119.749 130.5 119.75H120.5H50.5H40.5002C39.3928 119.749 38.3206 119.361 37.4689 118.653C36.6172 117.946 36.0395 116.962 35.8357 115.874L35.8357 115.874L20.8557 36.0239L20.8544 36.0166L20.8526 36.0095L16.8426 19.9395ZM44.4043 110.046L44.4425 110.25H44.65H126.35H126.557L126.596 110.046L139.726 40.0461L139.781 39.75H139.48H31.52H31.2187L31.2743 40.0461L44.4043 110.046ZM36.5346 126.035C40.2385 122.331 45.262 120.25 50.5 120.25C55.738 120.25 60.7615 122.331 64.4654 126.035C68.1692 129.738 70.25 134.762 70.25 140C70.25 145.238 68.1692 150.262 64.4654 153.965C60.7615 157.669 55.738 159.75 50.5 159.75C45.262 159.75 40.2385 157.669 36.5346 153.965C32.8308 150.262 30.75 145.238 30.75 140C30.75 134.762 32.8308 129.738 36.5346 126.035ZM106.535 126.035C110.238 122.331 115.262 120.25 120.5 120.25C125.738 120.25 130.762 122.331 134.465 126.035C138.169 129.738 140.25 134.762 140.25 140C140.25 145.238 138.169 150.262 134.465 153.965C130.762 157.669 125.738 159.75 120.5 159.75C115.262 159.75 110.238 157.669 106.535 153.965C102.831 150.262 100.75 145.238 100.75 140C100.75 134.762 102.831 129.738 106.535 126.035ZM57.7478 147.248C59.6701 145.326 60.75 142.718 60.75 140C60.75 137.282 59.6701 134.674 57.7478 132.752C55.8256 130.83 53.2185 129.75 50.5 129.75C47.7815 129.75 45.1744 130.83 43.2522 132.752C41.3299 134.674 40.25 137.282 40.25 140C40.25 142.718 41.3299 145.326 43.2522 147.248C45.1744 149.17 47.7815 150.25 50.5 150.25C53.2185 150.25 55.8256 149.17 57.7478 147.248ZM127.748 147.248C129.67 145.326 130.75 142.718 130.75 140C130.75 137.282 129.67 134.674 127.748 132.752C125.826 130.83 123.218 129.75 120.5 129.75C117.782 129.75 115.174 130.83 113.252 132.752C111.33 134.674 110.25 137.282 110.25 140C110.25 142.718 111.33 145.326 113.252 147.248C115.174 149.17 117.782 150.25 120.5 150.25C123.218 150.25 125.826 149.17 127.748 147.248Z"
                        fill="#E8E8E8" stroke="black" stroke-width="0.5" />
                </g>
                <defs>
                    <clipPath id="clip0_140_30">
                        <rect width="160" height="160" fill="white" transform="translate(0.5)" />
                    </clipPath>
                </defs>
            </svg>




            <p class="font-weight-bolder">در سبد خرید شما کالایی موجود نیست</p>

            <a href="{{ route('home') }}" class="btn btn-dark btn-rounded btn-icon-left btn-back mt-4"><i
                    class="w-icon-long-arrow-left"></i> ادامه خرید </a>
        </div>
    </div>

@endif

<script>
    $(document).ready(function() {
        window.BenefitTotall = $('#BenefitTotall').val();
        window.TOPayTotall = $('#TOPayTotall').val();
        $('#Totalweight').val($('#Totalweighttmp').val());




        // alternative is to use "change" - explained below


    });
</script>
