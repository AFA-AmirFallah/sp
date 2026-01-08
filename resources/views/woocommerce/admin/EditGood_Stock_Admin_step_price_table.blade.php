@if ($step_price == 2)
    <label class="ul-form__label">تخفیف پلکانی</label>
    <div class="form-group col-md-12">
        <table class="form-group table responsive">
            <tr style="text-align: center">
                <th>بیشتر از</th>
                <th>مبلغ فروش</th>
                <th>عملیات</th>
            </tr>
            @if ($GoodInWarehouse != null && $GoodInWarehouse->PricePlan != null)
                @php
                    $Conter = 0;
                    $ToNumber = 1;
                @endphp
                @foreach (json_decode($GoodInWarehouse->PricePlan) as $targetPlan)
                    @php
                        $Conter++;
                        $OldToNumber = $targetPlan->ToNumber;
                    @endphp
                    <tr id="PriceRow_1">
                        <td>
                            <input type="number" id="ToNumber_{{ $Conter }}" class="form-control"
                                name="ToNumber[{{ $Conter }}]" value="{{ $ToNumber }}">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="Price[{{ $Conter }}]"
                                onclick="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')"
                                onkeyup="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')"
                                value="{{ $targetPlan->Price }}">
                            <p id="BasePriceTxt_{{ $Conter }}"></p>

                        </td>
                        <td>
                            @if ($loop->last)
                                <button type="button" id="add_row_btn_{{ $Conter }}"
                                    class="btn btn-success add_row_btn"
                                    onclick="AddPriceRow_new({{ $Conter + 1 }})">افزودن
                                    فرمول</button>
                            @else
                                <button type="button" id="add_row_btn_{{ $Conter }}"
                                    class="btn btn-success d-none add_row_btn"
                                    onclick="AddPriceRow_new({{ $Conter + 1 }})">افزودن
                                    فرمول</button>
                            @endif
                        </td>
                        @php
                            $ToNumber = $targetPlan->ToNumber;
                        @endphp
                    </tr>
                @endforeach
                @for ($Conter++; $Conter < 14; $Conter++)
                    <tr id="PriceRow_{{ $Conter }}" class="nested">
                        <td>
                            <input type="number" id="ToNumber_{{ $Conter }}" class="form-control"
                                name="ToNumber[{{ $Conter }}]" value="">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="Price[{{ $Conter }}]"
                                onclick="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')"
                                onkeyup="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')" value="">
                            <p id="BasePriceTxt_{{ $Conter }}"></p>

                        </td>
                        <td>
                            <button type="button" id="add_row_btn_{{ $Conter }}"
                                class="btn btn-success add_row_btn"
                                onclick="AddPriceRow_new({{ $Conter + 1 }})">افزودن
                                فرمول</button>
                        </td>
                    </tr>
                @endfor
            @else
                @for ($Conter = 1; $Conter < 14; $Conter++)
                    <tr id="PriceRow_{{ $Conter }}" @if ($Conter != 1) class="nested" @endif>

                        <td>
                            <input type="number" id="ToNumber_{{ $Conter }}" class="form-control"
                                name="ToNumber[{{ $Conter }}]" value="">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="Price[{{ $Conter }}]"
                                onclick="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')"
                                onkeyup="CurencyTextRT(this.value,'BasePriceTxt_{{ $Conter }}')" value="">
                            <p id="BasePriceTxt_{{ $Conter }}"></p>

                        </td>
                        <td>
                            <button type="button" id="add_row_btn_{{ $Conter }}"
                                class="btn btn-success add_row_btn"
                                onclick="AddPriceRow_new({{ $Conter + 1 }})">افزودن
                                فرمول</button>
                        </td>
                    </tr>
                @endfor

            @endif
        </table>
    </div>
@endif
@if ($step_price == 1)
    <label class="ul-form__label">تخفیف پلکانی</label>
    <div class="form-group col-md-12">
        <table class="form-group table responsive">
            <tr style="text-align: center">
                <th>از </th>
                <th>تا </th>
                <th>مبلغ فروش</th>
                <th>عملیات</th>
            </tr>
            @if ($GoodInWarehouse != null && $GoodInWarehouse->PricePlan != null)
                @php
                    $Conter = 0;
                @endphp
                @foreach (json_decode($GoodInWarehouse->PricePlan) as $targetPlan)
                    <tr id="PriceRow_1">
                        <td>
                            @if ($Conter == 0)
                                1
                            @else
                                {{ $OldToNumber }}
                            @endif
                            @php
                                $Conter++;
                                $OldToNumber = $targetPlan->ToNumber;
                            @endphp

                        </td>
                        <td>
                            <input type="number" id="ToNumber_{{ $Conter }}" class="form-control"
                                name="ToNumber[{{ $Conter }}]" value="{{ $targetPlan->ToNumber }}">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="Price[{{ $Conter }}]"
                                value="{{ $targetPlan->Price }}">
                        </td>
                        <td>
                            @if ($loop->last)
                                <button type="button" id="add_row_btn_{{ $Conter }}"
                                    class="btn btn-success add_row_btn"
                                    onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                    فرمول</button>
                            @else
                                <button type="button" id="add_row_btn_{{ $Conter }}"
                                    class="btn btn-success d-none add_row_btn"
                                    onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                    فرمول</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @for ($Conter++; $Conter < 14; $Conter++)
                    <tr id="PriceRow_{{ $Conter }}" class="nested">
                        <td id="FirstNumber_{{ $Conter }}">

                        </td>
                        <td>
                            <input type="number" id="ToNumber_{{ $Conter }}" class="form-control"
                                name="ToNumber[{{ $Conter }}]" value="">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="Price[{{ $Conter }}]"
                                value="">
                        </td>
                        <td>
                            <button type="button" id="add_row_btn_{{ $Conter }}"
                                class="btn btn-success add_row_btn" onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                فرمول</button>
                        </td>
                    </tr>
                @endfor
            @else
                @for ($Conter = 1; $Conter < 14; $Conter++)
                    <tr id="PriceRow_{{ $Conter }}" @if ($Conter != 1) class="nested" @endif>
                        <td id="FirstNumber_{{ $Conter }}">

                            1
                        </td>
                        <td>
                            <input type="number" id="ToNumber_{{ $Conter }}" class="form-control"
                                name="ToNumber[{{ $Conter }}]" value="">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="Price[{{ $Conter }}]"
                                value="">
                        </td>
                        <td>
                            <button type="button" id="add_row_btn_{{ $Conter }}"
                                class="btn btn-success add_row_btn" onclick="AddPriceRow({{ $Conter + 1 }})">افزودن
                                فرمول</button>
                        </td>
                    </tr>
                @endfor

            @endif
        </table>
    </div>
@endif
