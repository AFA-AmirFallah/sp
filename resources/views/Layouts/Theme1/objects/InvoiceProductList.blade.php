@php
$OrderDetials = $Order->get_order_detials();

@endphp
<table class="order-table">
    <thead>
        <tr>
            <th class="text-dark">محصول </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($OrderDetials as $MyOrderTarget)

        <tr>
            <td>
                <a href="#">  {{ $MyOrderTarget['Product']->NameFa }}</a>&nbsp;<strong>x {{ $MyOrderTarget['ProductQty'] }}</strong><br>
              
            </td>
            <td>  {{ number_format($MyOrderTarget['ProductInWarehouse']->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</td>
        </tr>
       @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>مجموع کل: </th>
            <td>{{ number_format($Order->get_totall_price_totall())  }}{{ App\Http\Controllers\Credit\currency::GetCurrency() }}</td>
        </tr>
        <tr>
            <th>حمل و نقل :</th>
            <td></td>
        </tr>
        <tr>
            <th>روش پرداختی:</th>
            <td>انتقال مستقیم بانکی</td>
        </tr>
        <tr class="total">
            <th  class="border-no">مجموع :</th>
            <td   id="TotalTopay" > </td>
        </tr>
    </tfoot>
</table>
