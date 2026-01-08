@php
$Persian = new App\Functions\persian();
@endphp
<form id="finalEstelammainform" method="POST">
    @csrf
    <div class="payment-methods" id="payment_method">




        <h4 class="title font-weight-bold ls-25 pb-0 mb-1">روش‌های پرداخت </h4>
        <div class="accordion payment-accordion">
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <a href="#cash-on-delivery" class="collapse">
                        پس از استعلام مبلغ نهایی جهت پرداخت اعلام خواهد شد.</a>
                </div>

            </div>
            @if (!$Order->IsValidTashim())
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
                                    مبلغ <b id="totalprice1"></b>
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

        <input class="nested" name="typesubmit" value="SubmitOrder">
        <input class="nested" id="Locations" name="Location" value="1">
        <input class="nested" id="shipping" name="shipping" value="1">
        <input class="nested" id="Street_t" name="Street"  value="1">
        <input class="nested" id="Pelak_t" name="OthersAddress"  value="1">
        <input class="nested" id="recivername_t" name="recivername"  value="1"> 
        <input class="nested" id="reciverphone_t" name="reciverphone"  value="1">
        <input class="nested" id="Sharestan_t" name="Shahrestan"  value="1">
        <input class="nested" id="PostalCode_t" name="PostalCode"  value="1">
        <input class="nested" id="Province_t" name="Province"  value="1">
        <input class="nested" id="LocationName_t" name="LocationName"  value="1">

    </div>
    </div>
    <div class="form-group place-order pt-6">
        <button type="button" onclick="estelam()" class="btn btn-dark btn-block btn-rounded">ثبت
            درخواست</button>
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
