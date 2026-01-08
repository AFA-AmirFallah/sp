<tr>
    <th rowspan="3">شماره {{ $row_number }}
        <br>
        <button id="btn_add_row{{ $row_number }}" onclick="add_new_row('{{ $row_number + 1 }}')" class="btn btn-success" type="button">افزودن</button>
    </th>
    <th><select id="SelectMeta_{{ $row_number }}" name="DeviceMeta[]" class="form-control tocheck"
            onchange="change_select_meta('{{ $row_number }}')" style="width: 100%">
            <option value="0">{{ __('--select--') }}</option>
            @foreach ($DeviceMetas as $DeviceMeta)
                <option value="{{ $DeviceMeta->ID }}">{{ $DeviceMeta->DeviceName }}
                </option>
            @endforeach
        </select></th>
    <th><select id="SelectType{{ $row_number }}" name="DeviceType[]" class="form-control" style="width: 100%">
            <option value="0">{{ __('--select--') }}</option>
            @foreach ($DeviceTypes as $DeviceType)
                <option
                    class="DeviceMeta_{{ $row_number }}_{{ $DeviceType->MetaID }} nested DeviceMeta{{ $row_number }}"
                    value="{{ $DeviceType->ID }}">
                    {{ $DeviceType->DeviceName }}
                </option>
            @endforeach
        </select></th>
    <th><input class="form-control tocheck" type="number" id="RentPrice_{{ $row_number }}" name="RentPrice[]"
            autocomplete="off" value="0" onkeyup="PriceChange('{{ $row_number }}')">
        <div id="RentPrice_{{ $row_number }}_text"></div>
    </th>
    <th><input class="form-control" type="number" name="DiscountPrice[]" id="Discount_{{ $row_number }}"
            onkeyup="DiscountChange('{{ $row_number }}')" autocomplete="off" value="0">
        <div id="DiscountPrice_{{ $row_number }}_text"></div>

    </th>
    <th><input class="form-control nested" type="number" name="Total[]" autocomplete="off"
            id="Total_{{ $row_number }}" value="0">
        <div id="Total_{{ $row_number }}_number"></div>
        <div id="Total_{{ $row_number }}_text"></div>

    </th>
</tr>
<tr>
    <th>تامین کننده
        <br>
        و
        <br>
        مورد اجاره
    </th>
    <th colspan="2"><select id="Provider_{{ $row_number }}" name="Provider[]"
            onchange="feach_rent_product('{{ $row_number }}')" class=" form-control tocheck" style="width: 100%">
            <option value="0">{{ __('--select--') }}</option>
            @foreach ($Providers as $Provider)
                <option value="{{ $Provider->id }}">{{ $Provider->Name }}</option>
            @endforeach
        </select>
        <br>
        <select id="rent_products_{{ $row_number }}" name="pwid[]"
            onchange="get_rent_product_data('{{ $row_number }}')" class=" form-control tocheck" style="width: 100%">
            <option value="0">{{ __('--select--') }}</option>

        </select>
    </th>
    <th>مبلغ تامین کننده</th>
    <th>
        <input class="form-control tocheck" type="number" name="ProviderPrice[]" autocomplete="off"
            onkeyup="ProviderChange('{{ $row_number }}')" value="0" id="ProviderPrice_{{ $row_number }}"
            onkeyup="">
        <div id="ProviderPrice_{{ $row_number }}_text"></div>
    </th>
</tr>
<tr>
    <th>توضیحات</th>
    <td colspan="4">
        <input class="form-control" name="ItemNote[]">
    </td>
</tr>
