@php

    $MyProduct = new App\Http\Controllers\woocommerce\product();
    $Order = new App\Functions\Orders();

    $OrderDetials = $Order->get_order_detials();
    $BenefitTotall = 0;
    $TOPayTotall = 0;
@endphp
<div class="col-lg-12 pr-lg-4 mb-6" style="border: 1px solid var(--color_palet_6);
border-radius: 4px;">
    <input id="Totalweighttmp" class="nested" value="{{ $Order->get_totall_wight() }}">

    <div class="table-responsive">
        <table class="{{ \App\myappenv::MainTableClass }}">

            <thead>
                <tr>
                    <th class="product-thumbnail"><span># </span></th>
                    <th class="product-name"><span> کد محصول </span></th>
                    <th class="product-name"><span> sku </span></th>
                    <th class="product-name"><span>نام محصول </span></th>
                    <th class="product-price"><span>قیمت</span></th>
                    <th class="product-quantity"><span>تعداد</span></th>
                    <th class="product-subtotal"><span>جمع کل</span></th>
                    <th class="product-subtotal"><span> عملیات</span></th>
                </tr>
            </thead>
            <tbody>
                @if ($OrderDetials != null)
                    @foreach ($OrderDetials as $MyOrderTarget)
                        <tr>
                            <td class="product-thumbnail">
                                <div class="p-relative">
                                    <img src="{{ App\Functions\Images::GetPicture($MyOrderTarget['Product']->ImgURL, 1) }}"
                                        alt="{{ $MyOrderTarget['Product']->NameFa }}" height="100">
                                </div>
                            </td>

                            <td class="product-price">
                                <a target="blank"
                                    href="{{ route('EditProduct', ['id' => $MyOrderTarget['Product']->id]) }}">
                                    {{ $MyOrderTarget['Product']->id }}

                                </a>
                            </td>
                            <td class="product-price">
                                <a>
                                    {{ $MyOrderTarget['Product']->SKU }}
                                </a>
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

                                $TotallProductPrice = 0;
                            @endphp
                            <td class="product-price"><span class="amount">
                                    @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0)
                                        @if ($TashimRes[0] == null)
                                            @php
                                                $TotallProductPrice += $Price * $MyOrderTarget['ProductQty'];
                                            @endphp
                                            <strong class="product_continer_91">
                                                {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            </strong>
                                        @else
                                            @php
                                                $TotallProductPrice += $TashimRes[1] * $MyOrderTarget['ProductQty'];
                                            @endphp
                                            {{ number_format($TashimRes[1] / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            <small>{{ $TashimRes[0] }}</small>
                                        @endif
                                    @else
                                        @if (
                                            $MyOrderTarget['ProductInWarehouse']->MinPrice == $MyOrderTarget['ProductInWarehouse']->MaxPrice ||
                                                $MyOrderTarget['ProductInWarehouse']->MaxPrice == 0)
                                            {{ number_format($MyOrderTarget['ProductInWarehouse']->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @else
                                            از
                                            {{ number_format($MyOrderTarget['ProductInWarehouse']->MinPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            تا
                                            {{ number_format($MyOrderTarget['ProductInWarehouse']->MaxPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
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

                            <input id="Estelamstatus" value="0" class="nested">
                            <td class="product-subtotal">
                                <span class="amount">
                                    {{ number_format($ItemTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>

                                @php
                                    $TashimResddd = $Order->TashimBlade($MyOrderTarget['Product']->id, $MyOrderTarget['ProductInWarehouse']->Price, $MyOrderTarget['Product']->tax_status);


                                @endphp
                                @foreach ($TashimResddd as $TashimResdItem)
                                    <div>
                                        <li> <small>{{ $TashimResdItem['OutPutStr'] }} :
                                                {{ number_format(($TashimResdItem['priceStr'] * $MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</small>

                                        </li>
                                    </div>
                                @endforeach

                            </td>
                            <td>
                                <button type="button"
                                    onclick="removeitem({{ $MyOrderTarget['Product']->id }})"title="حذف محصول"
                                    style="background: none;border-style: hidden;color: red;cursor: pointer;font-size: 18px;">
                                    <i class="i-Delete-File"></i>
                                </button>

                            </td>

                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="7">جمع کل :</td>
                        <td>
                            {{ number_format($TOPayTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                        </td>
                    </tr>
                @else
                    <p>سبد خرید خالی است</p>
                @endif



            </tbody>

        </table>
    </div>

    <div class="cart-action mb-6">

        <button type="button" onclick="clearorder()" class="btn btn-rounded btn-default btn-clear" name="clear_cart"
            value="پاک کردن سبد">پاک
            کردن سبد </button>
        <button type="button" onclick="finalyze()" class="btn btn-primary fill">نهایی سازی و پرداخت</button>
    </div>


    <input id="BenefitTotall" class="nested" value="{{ $BenefitTotall }}">
    <input id="TOPayTotall" class="nested" value="{{ $TOPayTotall }}">

</div>
<script>
    $(document).ready(function() {
        window.BenefitTotall = $('#BenefitTotall').val();
        window.TOPayTotall = $('#TOPayTotall').val();
        $('#Totalweight').val($('#Totalweighttmp').val());

    });

    function clearorder() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                ajax: true,
                procedure: 'clearorder',
            },
            function(data, status) {
                loadpage('BasketList', 'product_table_detial');
                alert('سبد خرید خالی شد!');

            });

    }
</script>
