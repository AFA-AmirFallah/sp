<style>
    .active_td {
        background-color: #f44336;
        color: white;
    }
</style>
@php
    if ($warehouse_good->PricePlan != null) {
        $steps = true;
        $Price = $MyProduct->GetTargetPriceFromPricePlan($warehouse_good->PricePlan, 1);
        $price_plan_arr = $MyProduct->get_product_plan_array($warehouse_good->PricePlan);
        $PricePlan = $warehouse_good->PricePlan;
    } else {
        $steps = false;
        $Price = $warehouse_good->Price;
        $price_plan_arr = [];
        $PricePlan = '';
    }
    $max_qty = $warehouse_good->Remian;
    $BasePrice = $MyProduct->GetTargetPrice($warehouse_good->BasePrice, $warehouse_good->tax_status);
@endphp

<div class="d-none" id="PricePlan">{{ $PricePlan }}</div>
<div class="modal-header">
    <h5 class="modal-title" id="productname">
        <div class="steps_icon  rating-stars">
            <p class="steps_sddjf">خرید سریع</p>
        </div>

        @if ($steps)
            <div class="steps_icon  rating-stars">
                <p class="steps_sddjf"> تخفیف پلکانی</p>
            </div>
        @endif
    </h5>
    <button type="button" class="add-to-card buy_new" data-dismiss="modal" aria-label="Close"
        style="border-style: none;background-color: transparent;box-shadow: none;top: 5px;left: 11px;">
        <i style="font-size: 27px;" class="mdi mdi-close-circle-outline"></i>
    </button>

</div>
<div style="padding-top: 0px;" class="modal-body">
    <div class="row">
        <div class="pic-holder col-md-4">
            <img class="fast_img" src="{{ App\Functions\Images::GetPicture($good_src->ImgURL, 1) }}"
                alt="{{ Str::limit($good_src->NameFa, 50) }}">
        </div>
        <div class="col-md-8">
            <div style="margin-top:1.5rem">
                <h5 style="font-size: 16px;font-weight: 300;line-height: 29px;" class="product-variant-name">
                    {!! $good_src->NameFa !!}
                </h5>
            </div>
            <hr>
            <div class="row">
                <h6 class="col">قیمت مصرف کننده: </h6>
                <div style="direction: rtl;text-align: left;margin-top:-8px;margin-left:7px;" style="text-align: left"
                    class="col main-price-box ">
                    <div style="direction: ltr" class="discount">
                        <label style="
                        margin-right: 24px;
                    "
                            id="dis_percent">{{ ceil((($BasePrice - $Price) * 100) / $BasePrice) }}%</label><del
                            style="
                            margin-left: 3px;
                            margin-right: 17px;
                            font-weight: 300;
                        ">{{ number_format($BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}

                        </del>
                    </div>
                    <div
                        style="
                    margin-top: 13px;
                    font-size: 25px;
                    font-weight: 900;
                ">
                        <div style="display:contents;" id="target_price">
                            {{ number_format($Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        </div>

                        <small
                            style="font-size: 20px;
                        font-weight: 300;margin-right: 10px;">{{ App\Http\Controllers\Credit\currency::GetCurrency() }}</small>
                    </div>
                </div>
            </div>
            <div style="margin-top: 16px;" class="input-group mb-3">
                <div>
                    <div style="margin-right: 10px;" class="number-input">

                        <button onclick="step_down()"></button>
                        <input onkeyup="checkvaue()" id="quantity_in" class="quantity" min="0" name="quantity"
                            value="1" type="number">
                        <button onclick="step_up()" class="plus"></button>
                    </div>
                </div>
                <div>
                    <button type="button" style="padding: 5px;margin-right: 10px !important;width: 142px!important;"
                        onclick="ProductAddToBasket()" class="btn-primary-cm btn-with-icon mx-auto w-100">افزودن
                        به سبد</button>
                </div>
            </div>

        </div>

    </div>
    <script>
        $max_qty = {{ $max_qty }};
        $price_type = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
        $old_number = 1;
        $BasePrice = {{ $BasePrice }};
        plan = $('#PricePlan').html();
        if (plan != '') {
            var $paln_arr = jQuery.parseJSON(plan);
        } else {
            var $paln_arr = null;
        }
        //ToNumber
        //Price


        function checkvaue() {

            curent_qty = $('#quantity_in').val();
            if (curent_qty > $max_qty) {
                $('#quantity_in').val($max_qty);

            }
        }

        function change_number() {
            $('#dis_percent').html();
            percent = Math.round((($BasePrice - $new_price) * 100) / $BasePrice);
            $('#dis_percent').html(percent + '%');
            $('#target_price').html(number_format($new_price / $price_type));

        }

        function light_table() {
            target_val = $('#quantity_in').val();
            $.each($paln_arr, function(key, value) {
                if (value.ToNumber > parseInt(target_val)) {

                    $target_number = value.ToNumber;
                    $new_price = value.Price;
                    return false; // breaks
                }
            });
            if ($old_number != $target_number) {
                $('.td').removeClass('active_td');
                $('#top_row_' + $target_number).addClass('active_td');
                $('#down_row_' + $target_number).addClass('active_td');
                $old_number = $target_number;
                change_number();
            }


        }

        function step_up() {
            curent_qty = $('#quantity_in').val();

            if (curent_qty < $max_qty) {
                document.getElementById("quantity_in").stepUp();
                if ($paln_arr != null) {
                    light_table();
                }

            } else {
                alert('اتمام موجودی');

            }

        }

        function step_down() {
            document.getElementById("quantity_in").stepDown();
            if ($paln_arr != null) {
                light_table();
            }
        }
    </script>
    @if ($steps)
        <hr>
        <div class="product-collateral">

            <div class="tier-prices">
                <div style="margin-bottom: 15px" class="title">
                    <strong><i id="Products.TierPrices" class="EL"></i>هر چی بیشتر سفارش بدی قیمت کمتر
                        میشه</strong>
                </div>
                <div class="table">
                    <div class="tr">
                        <div class="th">تعداد</div>
                        @php
                            $inactive = false;
                        @endphp
                        @foreach ($price_plan_arr as $price_plan_item)
                            @if ($inactive)
                                @if ($loop->first)
                                    <div id="top_row_{{ $price_plan_item->ToNumber }}" class="td inactive">
                                    @else
                                        <div id="top_row_{{ $price_plan_item->ToNumber }}" class="td inactive">
                                @endif
                            @else
                                @if ($loop->first)
                                    <div id="top_row_{{ $price_plan_item->ToNumber }}" class="td active_td">
                                    @else
                                        <div id="top_row_{{ $price_plan_item->ToNumber }}" class="td">
                                @endif
                            @endif
                            @if ($price_plan_item->ToNumber > $max_qty)
                                @php
                                    $inactive = true;
                                @endphp
                            @endif

                            @if ($loop->first)
                                پایه
                                @php
                                    $count = $price_plan_item->ToNumber;
                                @endphp
                            @else
                                {{ $count }}+
                                @php
                                    $count = $price_plan_item->ToNumber;
                                @endphp
                            @endif
                    </div>
    @endforeach

</div>
<div class="tr">
    <div class="th">مبلغ</div>
    @php
        $inactive = false;
    @endphp
    @foreach ($price_plan_arr as $price_plan_item)
        @if ($inactive)
            @if ($loop->first)
                <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td inactive">
                @else
                    <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td inactive">
            @endif
        @else
            @if ($loop->first)
                <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td active_td">
                @else
                    <div id="down_row_{{ $price_plan_item->ToNumber }}" class="td">
            @endif
        @endif
        @if ($price_plan_item->ToNumber > $max_qty)
            @php
                $inactive = true;
            @endphp
        @endif

        {{ number_format($price_plan_item->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
</div>
@endforeach

</div>
</div>
</div>
</div>
@endif
</div>
<script>
    function ProductAddToBasket() {

        $CountValu = $('#quantity_in').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('/ajax', {
                ajax: true,
                AjaxType: 'AddToBasket',
                ProductId: {{ $warehouse_good->GoodID }},
                pw_id: {{ $warehouse_good->id }},
                OrderQty: $CountValu,
                Tashim: window.Tashim
            },

            function(data, status) {
                if (data == 'typemismatch') {
                    alert('کالای شما با کالای سبدخریدتان مغایرت دارد.ابتدا سبدخرید خود را تسویه فرمایید!');
                } else {
                    $('#basket_on_top').html(data);
                    $('#basket_on_top').removeClass('nested');
                    //  document.getElementById("basketnumber").innerHTML = data;
                    $("#basketnumber").removeClass("nested");
                    location.reload();
                }
            });


    }
</script>
