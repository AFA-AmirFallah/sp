@php
$Persian = new App\Functions\persian();
@endphp

<form id="finalmainformvirtual" method="POST">
    @csrf
    <div class="payment-methods" id="payment_method">

        <h4 class="title font-weight-bold ls-25 pb-0 mb-1">روش‌های پرداخت </h4>
        <div class="accordion payment-accordion">
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <a onclick="changepayment('submit')" href="#cash-on-delivery" class="collapse">
                        پرداخت از طریق درگاه بانکی</a>
                </div>
                <div id="cash-on-delivery" class="card-body expanded">
                    <input type="text" class="nested" id="directpay"
                        value="{{ $Directpay = $Order->Get_order_Cash_to_pay() }}">
                    <p class="mb-0">
                        مبلغ قابل پرداخت از طریق درگاه:
                        <strong
                            id="to_pay_txt">{{ number_format($Directpay / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        </strong>
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}

                    </p>


                    <p>به صورت حساب هایی که صرفا به صورت اقساطی پرداخت میگردند مبلغ ۱۰ هزار تومان کارمزد
                        تعلق
                        میگیرد!
                    </p>

                </div>

            </div>
            @if ($Order->UserCashCredit() >= $Directpay && $Directpay != 0 )
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <a onclick="changepayment('PayFromCredit')" href="#payment" class="expand"> پرداخت از طریق کیف
                            پول</a>
                    </div>
                    <div id="payment" class="card-body collapsed">
                        <input type="text" class="nested" id="directpay" value="{{ $Directpay }}">
                        <p class="mb-0">
                            مبلغ قابل پرداخت از طریق کیف پول:
                            <strong
                                id="to_pay_txt">{{ number_format($Directpay / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                            </strong>
                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}

                        </p>
                    </div>
                </div>
        </div>
        @endif
        @if ($Order->is_use_wallet(3, 'buyer'))
            <input id="addnewRadio" name="addnewRadio" onchange="confirm_creadit();" type="checkbox"
                class="custom-checkbox">
            <label> تایید کسر از حقوق</label>
            <div id="addnewcheckbox" style="display: none;" class="card-body collapsed">
                <section class="mb-6">
                    <div class="tab tab-nav-center tab-nav-underline tab-line-grow">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#tab5-1" class="nav-link active"> وکالت کسر از حقوق</a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab5-1">
                                اینجانب <b>{{ Auth::user()->Name }}{{ Auth::user()->Family }}</b>
                                به شماره ملی<b>{{ Auth::user()->MelliID }}</b>
                                به شرکت گسترش فناوری اندیشه ایرانیان (کوکباز)
                                وکالت بلاعزل می‌دهم تا
                                مبلغ <b>{{ number_format($Order->Get_order_Cash_to_pay(3)/ App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}</b> {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                بابت خرید کالا در تاریخ<b>{{ $Persian->TodayPersian() }}</b>
                                را از حقوق، وجوه، سپرده ها و کلیه مطالبات اینجانب نزد سازمان برداشت نماید.


                            </div>

                        </div>
                    </div>

                </section>

            </div>
        @else
            <input id="addnewRadio" name="addnewRadio" checked type="checkbox" class="nested">
        @endif
    </div>

    <input class="nested" id="paymentfild" name="typesubmit" value="submit">
    <input class="nested" id="Locations" name="Location" value="1">
    <input class="nested" id="shipping" name="shipping" value="1">
    <input class="nested" id="Street_t" name="Street" value="1">
    <input class="nested" id="Pelak_t" name="OthersAddress" value="1">
    <input class="nested" id="recivername_t" name="recivername" value="1"> 
    <input class="nested" id="reciverphone_t" name="reciverphone" value="1">
    <input class="nested" id="Sharestan_t" name="Shahrestan" value="1">
    <input class="nested" id="PostalCode_t" name="PostalCode" value="1">
    <input class="nested" id="Province_t" name="Province" value="1">
    <input class="nested" id="LocationName_t" name="LocationName" value="1">


    </div>
    </div>
    <div class="form-group place-order pt-6">
        <button type="button" onclick="virtual()" class="btn btn-dark btn-block btn-rounded">ثبت
            سفارش</button>
    </div>

</form>
<script>
    $('#totalprice1').text($('#TotalPrice').val());

    function changeshiping(ShipingPrice) {
        $directpay = parseInt($('#directpay').val());
        ShipingPrice = parseInt(ShipingPrice);
        $tppay = $directpay + ShipingPrice;
        $textpay = formatCurrency($tppay);
        $('#to_pay_txt').html($textpay);
    }
</script>
