@php
    $OrderDetials = $Order->get_order_detials();
    $BenefitTotall = 0;
    $TOPayTotall = 0;
    $TotallProductPrice = 0;
    $weight = 0;
@endphp
@php
    $GetBasketItemsBrif = App\Http\Controllers\woocommerce\buy::GetBasketItemsBrif();
    if ($GetBasketItemsBrif == []) {
        $order_count = 0;
    }
    $benefit = 0;
    $totall = 0;

    $DeleverCondition = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('BuyCondition');
    $FreeDelever = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('FreeDelever');
    $FreeDeleverText = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('FreeDeleverText');

@endphp
@if ($DeleverCondition != null && $DeleverCondition != '#')
    <div class="modal fade" id="notloginmodal" tabindex="-1" role="dialog" aria-labelledby="notloginmodalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notloginmodalLabel">شرایط و قوانین سایت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! $DeleverCondition !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-primary-cm btn-with-icon text-center "
                        data-dismiss="modal">بستن</button>

                </div>
            </div>
        </div>
    </div>
@endif
<div class="col-xl-3 col-lg-4 col-12 w-res-sidebar sticky-sidebar">
    <div class="order-summary-wrapper sticky-sidebar">
        <h3 style="font-size: 16px;" class="title text-uppercase ls-10">سفارش شما </h3>
        <div class="order-summary">
            @foreach ($GetBasketItemsBrif as $OrderItem)
                <li style="display: block" class="cart-item">
                    <a target="blank" href="{{ route('SingleProduct', ['productID' => $OrderItem['id']]) }}"
                        class="header-basket-list-item">
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
                                        $weight += $OrderItem['weight'] * $OrderItem['Qty'];
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
                                        $weight += $OrderItem['weight'] * $OrderItem['Qty'];

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
                    </a>
                </li>
            @endforeach
            @php
                $account = $MyProduct->get_my_credit() ?? 0;
            @endphp


            <ul class="checkout-summary-summary">
                <h4 style="text-align: right;font-size:16px;" class="title title-simple bb-no mb-1 pb-0 pt-3">حمل و نقل
                </h4>
                <div style="text-align: right" id="tansfrer_selector"
                    class="  checkout-shipment border-bottom pb-3 mb-4">
                    <div id="delevery_order">
                        @include('Layouts.Theme5.objects.delevery_order')
                    </div>

                </div>

                <li>
                    <input type="text" class="d-none" id="directpay" value="{{ $totall }}">
                    <span>مبلغ
                        کل</span><span>{{ number_format($totall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                </li>
                <li class="checkout-summary-discount">
                    <span>سود شما از خرید</span><span>
                        {{ number_format($benefit / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                    </span>
                </li>
                <li>
                    <span style="font-size: 16px">هزینه ارسال</span><span id="TotalDeleveryPriceFinal"> بر اساس
                        آدرس</span>
                </li>

                <li>
                    <span style="font-size: 16px">کیف پول</span><span>
                        {{ number_format($account / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span>
                </li>
                @if ($account > 0)
                    <li>
                        <inputtype="checkbox" class="custom-control-input" name="usecredit">
                        <label class="custom-control-label">
                            استفاده از کیف پول
                        </label>
                    </li>
                @endif



            </ul>
        </div>
    </div>
    <div style="font-size: 16px" class="checkout-summary-price-title">مبلغ قابل پرداخت:</div>
    <div class="checkout-summary-price-value">
        <span id="total_show"
            class="checkout-summary-price-value-amount">{{ number_format($totall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}</span>
        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
    </div>

    <script>
        function inhouse_delever() {
            $('#TotalDeleveryPriceFinal').html('درحال محاسبه');
            $('#tansfrer_selector').addClass('animated-background');
            $('#TotalDeleveryPriceFinal').addClass('animated-background');
            $('#TotalDeleveryPriceFinal').html('بعد از آماده شدن سفارش با شما تماس گرفته می شود.');
            $('#tansfrer_selector').removeClass('animated-background');
            $('#TotalDeleveryPriceFinal').removeClass('animated-background');
            $('#shipping').val('ask');
            totall_price = $('#price').val();
            $('#total_show').html(number_format(totall_price));
        }

        function peyk_delever() {

            $('#TotalDeleveryPriceFinal').html('درحال محاسبه');
            $('#tansfrer_selector').addClass('animated-background');
            $('#TotalDeleveryPriceFinal').addClass('animated-background');
            $('#TotalDeleveryPriceFinal').html('هزینه ارسال به پیک توسط مشتری پرداخت میگردد.');
            $('#tansfrer_selector').removeClass('animated-background');
            $('#TotalDeleveryPriceFinal').removeClass('animated-background');
            $('#shipping').val('peyk');
            totall_price = $('#price').val();
            $('#total_show').html(number_format(totall_price));
        }

        function tipax_delever() {

            $('#TotalDeleveryPriceFinal').html('درحال محاسبه');
            $('#tansfrer_selector').addClass('animated-background');
            $('#TotalDeleveryPriceFinal').addClass('animated-background');
            $('#TotalDeleveryPriceFinal').html('هزینه ارسال به تیپاکس توسط مشتری پرداخت میگردد.');
            $('#tansfrer_selector').removeClass('animated-background');
            $('#TotalDeleveryPriceFinal').removeClass('animated-background');
            $('#shipping').val('tipax');
            totall_price = $('#price').val();
            $('#total_show').html(number_format(totall_price));
        }

        function tapinfree() {
            $('#TotalDeleveryPriceFinal').html(' رایگان');
            $('#shipping').val('post_free');
            $('#tansfrer_selector').removeClass('animated-background');
            $('#TotalDeleveryPriceFinal').removeClass('animated-background');
        }

        function tapinprice() {
            $('#TotalDeleveryPriceFinal').html('درحال محاسبه');
            $('#tansfrer_selector').addClass('animated-background');
            $('#TotalDeleveryPriceFinal').addClass('animated-background');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/ajax', {
                    AjaxType: 'GetTapinPrice',
                    price: {{ $totall }},
                    weight: {{ $weight }},
                    location: $('#Locations').val()
                },
                function(data, status) {
                    if (data[0]) {
                        $delever_price = data[1];
                        $('#TotalDeleveryPriceFinal').html(number_format($delever_price) + ' ریال');
                        $('#shipping').val('post');
                        $('#tansfrer_selector').removeClass('animated-background');
                        $('#TotalDeleveryPriceFinal').removeClass('animated-background');
                        price = $('#price').val();
                        totall_price = parseInt($delever_price) + parseInt(price);
                        $('#total_show').html(number_format(totall_price));
                    } else {
                        alert(data[1]);
                        tipax_delever();
                    }
                });
        }

        function TapinGetPrice() {
            FreeDelever =
                {{ \App\Http\Controllers\setting\SettingManagement::GetSettingValue('FreeDelever') == null ? 0 : \App\Http\Controllers\setting\SettingManagement::GetSettingValue('FreeDelever') }};
            if ({{ $totall }} > FreeDelever) {
                return tapinfree();
            } else {
                return tapinprice();
            }
        }
    </script>
    <form id="finalmainform" method="POST">
        @csrf


        <div class="mb-2 d-block">
            @if ($DeleverCondition != null && $DeleverCondition != '#')
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="conditioncheck" />
                    <label style="margin-right: 20px;">من
                        <a style="color: blue;cursor: pointer!important;" data-toggle="modal"
                            data-target="#notloginmodal"> شرایط و مقررات
                            سایت </a>را خوانده و می پذیرم</label>
                </div>
                <hr>
            @endif


            <button type="button" onclick="save_order()"
                class="btn-primary-cm btn-with-icon w-100 text-center pr-0 pl-0">
                <i class="mdi mdi-arrow-left"></i>
                پرداخت و ثبت نهایی سفارش
            </button>

        </div>
        <input class="d-none" id="paymentfild" name="typesubmit" value="submit">
        <input class="d-none" id="Locations" name="Location" value="0">
        <input class="d-none" id="price" name="price" value="{{ $totall }}">
        <input class="d-none" id="shipping" name="shipping" value="none">

</div>

</form>
<script>
    $('#totalprice1').text($('#TotalPrice').val());

    function save_order() {

        if ($("#conditioncheck").length != 0) {
            if (!$('#conditioncheck').is(":checked")) {
                alert('لطفا شرایط و مقرارات را تائید کنید! ');
                return false;
            }
        }
        Locations = $('#Locations').val();
        shipping = $('#shipping').val();
        if (Locations == 0) {
            alert('هیچ آدرسی ثبت نشده است.');
            return false;
        }
        if (shipping == 'none') {
            alert('لطفا روش ارسال را مشخص کنید.');
            return false;
        }
        $('#finalmainform').submit();
    }

    function changeshiping(ShipingPrice) {
        $directpay = parseInt($('#directpay').val());
        ShipingPrice = parseInt(ShipingPrice);
        $tppay = $directpay + ShipingPrice;
        $textpay = formatCurrency($tppay);
        $('#to_pay_txt').html($textpay);
    }
</script>
</div>
