<div class="card-body">
    <div class="table-responsive">
        <table id="Product-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>کد</th>
                    <th>sku</th>
                    <th>نام محصول</th>
                    <th>مالیات</th>
                    <th>موجودی</th>
                    <th>قیمت</th>

                    <th>عملیات
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $Rowno = 1;
                    $GoodId = null;
                @endphp

                @foreach ($ProductList as $good)
                    @if ($GoodId == $good->id)
                        <tr>
                            <td>{{ $Rowno++ }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{{ $good->Name }} - {{ $good->QTY }}</td>
                            <td>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $Rowno++ }}</td>
                            <td>{{ $good->id }}</td>
                            <td>
                                @if ($good->SKU == '')
                                    ندارد
                                @else
                                    {{ $good->SKU }}
                                @endif
                            </td>
                            <td><a href="{{ route('EditProduct', ['id' => $good->id]) }}"
                                target="_blank">
                                {{ $good->NameFa }}
                            </a></td>
                            <td>{{ $good->NameEn }}
                                @if ($good->tax_status == 0)
                                    معاف
                                    <i class="i-Money-Bag" style="color:green;font-weight: bold;font-size: 20px;"></i>
                                @else
                                    مشمول
                                    <i class="i-Money-Bag" style="color:red;font-weight: bold;font-size: 20px;"></i>
                                @endif
                            </td>

                            <td style="white-space: nowrap;">
                                {{ $good->Remian }}
                            </td>
                            <td style="white-space: nowrap;">
                                {{ number_format($good->Price ) }}
                            </td>
                            <td>
                                <input id="wgid_{{ $Rowno }}" class="nested" type="number" value="{{ $good->wgid }}" >
                                <input id="Qty_{{ $Rowno }}" class="form-control" type="number" value="1" >
                                <div id="but_continner_{{ $Rowno }}">
                                    <button type="button" class="btn btn-success" onclick="get_Product_tashims('{{ $good->id}}',{{ $Rowno }})"  >بررسی</button>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                @if ($Rowno == 1)
                    <p>محصولی یافت نشد!</p>
                @endif

            </tbody>

        </table>
    </div>

</div>
