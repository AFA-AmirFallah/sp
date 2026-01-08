@php
$OrderDetials = $Order->get_order_detials();
$BenefitTotall = 0;
$TOPayTotall = 0;
$TotallProductPrice = 0;
@endphp
<div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
    <div class="order-summary-wrapper sticky-sidebar">

        <h3 class="title text-uppercase ls-10">سفارش شما </h3>
        <div class="order-summary">
            <table class="order-table" style="table-layout: fixed">
                <thead>
                    <tr>
                        <th colspan="2">
                            <b>اقلام </b>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($OrderDetials as $MyOrderTarget)
                        <tr class="bb-no">
                            <td class="product-name">
                                {{ $MyOrderTarget['Product']->NameFa }}

                            </td>
                            <td style="text-align: center">
                                تعداد {{ $MyOrderTarget['ProductQty'] }}
                            </td>
                            @php
                                $Price = $MyProduct->GetTargetPrice($MyOrderTarget['ProductInWarehouse']->Price, $MyOrderTarget['Product']->tax_status);
                                $BasePrice = $MyProduct->GetTargetPrice($MyOrderTarget['ProductInWarehouse']->BasePrice, $MyOrderTarget['Product']->tax_status);
                                $TashimRes = $MyProduct->TashimBlade($MyOrderTarget['Product']->id, $MyOrderTarget['ProductInWarehouse']->Price,$MyOrderTarget['Product']->tax_status);
                                
                            @endphp

                            <td class="product-price"><span class="amount">
                                    @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == 0)
                                        @if ($TashimRes[0] == null)
                                        
                                            <strong class="product_continer_91">
                                                {{ number_format(($Price * $MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            </strong>
                                            @php
                                                $TotallProductPrice += $Price * $MyOrderTarget['ProductQty'];
                                            @endphp
                                        @else
                                            
                                            {{ number_format(($TashimRes[1] * $MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            <small>{{ $TashimRes[0] }}</small>
                                            @php
                                                $TotallProductPrice += $TashimRes[1] * $MyOrderTarget['ProductQty'];
                                            @endphp
                                        @endif
                                    @else
                                        @if ($MyOrderTarget['ProductInWarehouse']->MinPrice == $MyOrderTarget['ProductInWarehouse']->MaxPrice ||
                                            $MyOrderTarget['ProductInWarehouse']->MaxPrice == 0)
                                            {{ number_format(($MyOrderTarget['ProductInWarehouse']->MinPrice * $MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @else
                                            از
                                            {{ number_format(($MyOrderTarget['ProductInWarehouse']->MinPrice * $MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            تا
                                            {{ number_format(($MyOrderTarget['ProductInWarehouse']->MaxPrice * $MyOrderTarget['ProductQty']) / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                        @endif
                                    @endif

                            </td>
                        </tr>
                    @endforeach

                </tbody>

                <tfoot>
                    <tr class="order-total">

                        <th>
                            <b>مجموع :</b>
                        </th>

                        <td>
                            <strong id="TotalTopay">
                                {{ number_format($TotallProductPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                            </strong>
                        </td>
                    </tr>

                </tfoot>
            </table>
