<html>
@php
$Persian = new App\Functions\persian();
$Totall = 0;
@endphp
<style>
    @page {
        margin-top: 4cm;
        margin-bottom: 5.0cm;
        margin-left: 2.3cm;
        margin-right: 1.7cm;
        margin-header: 8mm;
        margin-footer: 8mm;
        header: page-header;
        footer: page-footer;
        background-color: #ffffff;
    }

    body {
        font-family: fa;
        direction: rtl;
    }

    p {
        text-align: justify;
    }

    table,
    td,
    th {
        border: 1px solid #ddd;
        text-align: left;
        font-size: 14px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 15px;
        text-align: center;
    }



    th {
        background-color: #dee2e6 !important;

        color: black;
    }

    h1 {
        text-align: center;
    }

    #footer {
        display: flex;
    }
</style>

<body>
    <htmlpageheader name="page-header">
        <div style="position:absolute;right:0cm;top:0cm;width: 100%;margin:0cm;">
            <img style="padding: 0cm" src="https://kookbaz.ir/storage/photos/banner.png" />
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <div style="position:absolute;right:0cm;bottom:0cm;width: 100%;margin:0cm;">
            <img style="padding: 0cm" src="https://kookbaz.ir/storage/photos/banner/footer.png" />
        </div>
    </htmlpagefooter>


    @foreach ($TargetproductOrder as $TargetOrderLIst)
        @php
            $Totall += $TargetOrderLIst->unit_sales * $TargetOrderLIst->product_qty + $TargetOrderLIst->tax_total;
        @endphp
    @endforeach
    @php
        $extranote = json_decode($TargetUser->extradata);
        if (isset($extranote->BazCode)) {
            $BazCode = $extranote->BazCode;
        } else {
            $BazCode = '0';
        }
    @endphp
    <h1> وکالت کسر از حقوق</h1>

    <p style="font-size:14px;text-align:justify;line-height:30px;">
        اینجانب <b>{{ $TargetUser->Name }} {{ $TargetUser->Family }}</b>
        فرزند <b> {{ $TargetUser->fathername }}</b>
        شماره ملی <b>{{ $TargetUser->MelliID }}</b>

       {{ $BazCode }} و شماره بازنشستگی
        به شرکت گسترش فناوری اندیشه ایرانیان وکالت می دهم تا مبلغ
        <b>{{ number_format($Totall) }}</b> ریال
        بابت
        پرداخت فاکتور شماره
        <b>{{ $OrderID }} </b>
        به شرح زیر
        در تاریخ
        <b>{{ $Persian->MyPersianDate($TargetOrder->created_at, false) }}</b>


        را از حقوق، وجوه، سپرده ها و کلیه مطالبات اینجانب نزد سازمان برداشت نماید.
        .همچنین حق عزل و ضم وکیل و هرگونه اعتراض را از خود سلب نموده و اسقاط کافه خیارات نموده ام
        ضمنا حقوق، وجوه، سپرده ها و کلیه مطالبات مذکور وثیقه دین اینجانب بوده و در صورت حجر، حق این بدهی مقدم بر
        سایر
        طلبکاران خواهد بود.
        همچنین بانک پس از فوت اینجانب بعنوان وصی بعد از فوت حق اعمال اختیارات فوق را خواهد داشت.
    </p>



    <div style="margin-top: 20px">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>شرح کالا</th>
                    <th>مبلغ واحد </th>
                    <th>تعداد</th>
                    <th>مبلغ کل </th>
                    <th>تخفیف </th>
                    <th>مبلغ پس از تخفیف </th>
                    <th> مالیات </th>
                    <th>کارمزد </th>
                    <th>جمع کل</th>

                </tr>

            </thead>
            <tbody>
                @php
                    $Conter = 1;
                    
                @endphp
                @foreach ($TargetproductOrder as $TargetOrderLIst)
                    <tr>
                        <td>
                            {{ $Conter++ }}
                        </td>
                        <td>

                            {{ $TargetOrderLIst->NameFa }}
                        </td>
                        <td>

                            {{ number_format($TargetOrderLIst->main_unit_price) }}
                            <br>
                            ریال
                        </td>
                        <td>
                            {{ $TargetOrderLIst->product_qty }}
                        </td>
                        <td>
                            {{ number_format($TargetOrderLIst->main_unit_price * $TargetOrderLIst->product_qty) }}
                            <br>
                            ریال
                        </td>
                        <td>
                            {{ number_format($TargetOrderLIst->UniDef * $TargetOrderLIst->product_qty) }}
                            <br>
                            ریال
                        </td>
                        <td>
                            {{ number_format($TargetOrderLIst->main_unit_price * $TargetOrderLIst->product_qty - $TargetOrderLIst->UniDef * $TargetOrderLIst->product_qty) }}
                            <br>
                            ریال
                        </td>
                        <td>
                            {{ number_format($TargetOrderLIst->tax_total) }}
                            <br>
                            ریال
                        </td>
                        <td>
                            {{ number_format($TargetOrderLIst->unit_sales * $TargetOrderLIst->product_qty - $TargetOrderLIst->unit_Price * $TargetOrderLIst->product_qty) }}
                            <br>
                            ریال
                        </td>
                        <td>
                            {{ number_format($TargetOrderLIst->unit_sales * $TargetOrderLIst->product_qty + $TargetOrderLIst->tax_total) }}
                            <br>
                            ریال
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div style="margin-top: 10px;">
        <strong>
            توضیحات طرح فروش اقساطی:
        </strong>
        <ul>
            <li>مبلغ تایید شده به هیچ عنوان قابل تغییر و کنسلی نمی باشد</li>
            <li> صدور این فرم به منزله تایید ضوابط این طرح است</li>
            <li>انتخاب، تحویل و قیمت نهایی کالا،فقط از کالاهای موجود و پس از تاییدیه سازمان،انجام پذیر است</li>
            <li>
                کالاهای انتخابی این سند هنگام صدور در شرکت موجود بوده، لکن در صورت تاخییر در ارسال مدارک از سوی
                خریدار،امکان ناموجود شدن کالا وجود دارد، که در این صورت با همانگی و تایید خریدار کالای جدید جایگزین
                خواهد شد.
            </li>
        </ul>



    </div>


    <div>
        <table>
            <tr>
                <td>
                    مهر و امضا شرکت
                </td>
                <td>
                    امضا و اثرانگشت خریدار
                    <br>
                    <br>
                    {{ $TargetUser->Name }} {{ $TargetUser->Family }}

                </td>

            </tr>

        </table>

    </div>
    <pagebreak />
    <h1> جدول اقساط</h1>
    <div style="margin-top: 20px">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th> تاریخ سر رسید</th>
                    <th>مبلغ هر قسط </th>



                </tr>

            </thead>
            <tbody>
                @php
                    $Conter = 1;
                    
                @endphp
                @foreach ($TavanSrc as $TavanItem)
                    <tr>
                        <td>
                            {{ $Conter++ }}

                        </td>
                        <td>
                            {{ $Persian->MyPersianDate($TavanItem->Date) }}
                        </td>
                        <td>
                            {{ number_format(abs($TavanItem->Mony)) }}
                            <br>
                            ریال

                        </td>


                    </tr>
                @endforeach



            </tbody>
        </table>

    </div>
    <p>

        @if ($TargetUser->extradata != null)
            @php
                $extranote = json_decode($TargetUser->extradata);
                if (isset($extranote->tavg)) {
                    $tavg = $extranote->tavg;
                } else {
                    $tavg = '0';
                }
            @endphp

            <div>


                میزان توان پرداخت
                خریدار
                در تاریخ
                <span> {{ $Persian->MyPersianDate($TargetOrder->created_at, false) }}
                    برابر مبلغ
                    :<strong>{{ number_format($tavg) }}</strong> ریال می باشد</span>


            </div>
        @endif






    </p>

</body>

</html>
