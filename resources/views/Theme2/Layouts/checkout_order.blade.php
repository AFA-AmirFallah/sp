<div class="row mb-3">
    <div class="col-12 col-lg-8 offset-lg-2 text-center mb-3">
        <h4 class="mt-2 secondary-font">متشکریم!</h4>
        <p>سفارش شما <a id="order_number" href="javascript:void(0)"> {{ $result->id }} </a> ثبت شد!</p>
        <p>
            ما یک ایمیل به کد را به همراه
            فاکتور و تایید سفارش شما ارسال کردیم. اگر پیامک در عرض دو دقیقه دریافت نشود، لطفا پوشه
            اسپم خود را نیز چک کنید.
        </p>
        <p>
            <span class="fw-semibold"><i class="bx bx-time-five"></i> زمان ثبت:</span> 1401/01/25
            13:35 ق.ظ
        </p>
    </div>
    <!-- Confirmation details -->
    <div class="col-12">
        <ul class="list-group list-group-horizontal-md lh-2">
            <li class="list-group-item flex-fill">
                <h6 class="secondary-font"><i class="bx bx-map"></i> آدرس صرافی</h6>
                <address>
                    {{ $sarafi_src->Family }} <br>
                    {{ $sarafi_src->Address }}
                    <span class="d-inline-block" dir="ltr">{{ $sarafi_src->MobileNo }}</span>
                </address>
            </li>
            <li class="list-group-item flex-fill">
                <h6 class="secondary-font"><i class="bx bx-credit-card"></i>اطلاعات سفارش</h6>
                <address>
                    ارز: {{ $DataInput['CoinId'] }} <br>
                    <br>تعداد: {{ $DataInput['Count'] }} <br>
                    <br>مبلغ واحد: {{ $DataInput['unit_price'] }} <br>
                    <br>مجموع: {{ $DataInput['sum_price'] }}
                </address>
            </li>
            <li class="list-group-item flex-fill">
                <h6 class="secondary-font"><i class="bx bx-train"></i> روش دریافت</h6>
                <span class="fw-semibold">روش مد نظر:</span><br>
                ارسال استاندارد<br>
                (معمولا 3-4  ساعت)
            </li>
        </ul>
    </div>
</div>
