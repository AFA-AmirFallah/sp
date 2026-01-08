<html>
<style>
    @page {
        margin-top: 7cm;
        margin-bottom: 4.0cm;
        margin-left: 2.3cm;
        margin-right: 1.7cm;
        margin-header: 8mm;
        margin-footer: 8mm;
        header: page-header;
        footer: page-footer;
        background-color: #ffffff;
    }

    @page :first {
        margin-top: 1.5cm;
        margin-bottom: 2cm;
        header: main-page-header;
        footer: main-page-footer;
        resetpagenum: 1;
        background-color: #ffffff;
        background: #ffffff url(images/Selfesteembro.png) no-repeat fixed center center;
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
        width: 50%;
        padding: 15px;
        text-align: center;
    }



    th {
        background-color: #dee2e6 !important;

        color: black;
    }

    .list-tem {
        text-align: right;
        margin-bottom: 1cm;
    }


    div.breakNow { page-break-inside:avoid; page-break-after:always; }
    .page-header {
        height: 10px;
        border-radius: 20px;
        background-color: green;
        color: white;
        font-size: 18px;
        text-align: center;
    }
</style>

<body>
    <htmlpageheader name="page-header">
        <div style="position:absolute;right:0cm;top:0cm;width: 100%;margin:0cm;margin-top:-1cm;">
            <img style="padding: 0cm" src="assets/images/print/shafatel_header.png" />
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <div style="position:absolute;right:0cm;bottom:0cm;width: 100%;margin:0cm;">
            <img style="padding: 0cm" src="assets/images/print/shafatel_footer.png" />
        </div>
    </htmlpagefooter>
    <htmlpageheader name="main-page-header">
        <div style="position:absolute;right:0cm;top:0cm;width: 100%;margin:0cm;background-color: #0072ff;height: 6cm;">
            <h1 style="color: white;text-align:center;margin-top:4cm;font-size:32px">گزارش نتیجه آزمون روانشناسی</h1>
        </div>
        <div
            style="position:absolute;right:0cm;top:6cm;width: 100%;margin:0cm;background-color: #000000;height: 0.5cm;">
        </div>

    </htmlpageheader>

    <htmlpagefooter name="main-page-footer">
        <div
            style="background-color: #0072ff;position:absolute;right:0cm;bottom:0cm;width: 100%;margin:0cm;height: 6cm;">
        </div>
        <div
            style="position:absolute;right:0cm;bottom:6cm;width: 100%;margin:0cm;background-color: #000000;height: 0.5cm;">
        </div>
    </htmlpagefooter>

    <h1 style="text-align:center;padding-top:6cm;">عزت نفس روزنبرگ</h1>
    <h1 style="text-align: center">Rosenberg Self Esteem Scale</h1>



    <h1 style="padding-top: 9cm;text-align:center;"> آزمون دهنده: {{ $ExmAnalyze->get_user('Name') }}
        {{ $ExmAnalyze->get_user('Family') }}</h1>

    <pagebreak />
    <h1>آزمون روانشناسی عزت نفس روزنبرگ</h1>
    <h2>عزت نفس</h2>
    <div style="text-align: center">
        <img style="width: 10cm"
            src="https://shafatel.com/storage/photos/psychology/psychometry/self esteem/romantic-woman-embraces-herself-keeps-arms-crossed-body-touches-shoulders-enjoys-coziness-wears-sweater-tilts-head-has-high-self-esteem-loves-herself-isolated-purple-wall_273609-42740.jpg"
            alt="">
    </div>
    <p>عزت نفس یعنی اعتماد به خود در اندیشیدن و اعتماد به توانایی خود برای کنار آمدن با چالشهای اولیه زندگی. عزت نفس
        اعتماد به حق خود برای موفق و شاد بودن است، احساس ارزشمند بودن، شایسته بودن، داشتن حق ابراز نیازها و خواسته ها.
    </p>
    <div style="margin-top: 20px">
        <table>
            <thead>
                <tr>
                    <th>نشانه های عزت نفس پایین</th>
                    <th>نشانه های عزت نفس بالا</th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td style="text-align: right" >
                        <p style="padding-bottom:1cm;"> احساس بی ارزشی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> انفعالی بودن افراط گونه</p>
                        <br>
                        <p style="padding-bottom:1cm;"> احساس پوچی و بیهودگی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> خود بزرگ بینی بی مورد</p>
                        <br>
                        <p style="padding-bottom:1cm;"> کبر و نخوت</p>
                        <br>
                        <p style="padding-bottom:1cm;"> توجه طلبی شدید</p>
                        <br>
                        <p style="padding-bottom:1cm;"> خود کنترلی بیش از حد</p>
                        <br>
                        <p style="padding-bottom:1cm;"> بی احترامی به خود</p>
                        <br>
                        <p style="padding-bottom:1cm;"> بی احترامی به دیگران</p>
                        <br>
                        <p style="padding-bottom:1cm;"> رفتار غیر عقلانی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> بی توجهی به واقعیات</p>
                        <br>
                        <p style="padding-bottom:1cm;"> نداشتن انعطاف</p>
                        <br>
                        <p style="padding-bottom:1cm;"> ترس از چیزهای بدیع و ناآشنا</p>
                        <br>
                        <p style="padding-bottom:1cm;"> سازگاری بیش از حد</p>
                        <br>
                        <p style="padding-bottom:1cm;"> نا سازگاری غیرمنطقی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> رفتار تدافعی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> رفتار به شدت کنترل کننده</p>
                    </td>
                    <td style="text-align: right">
                        <p style="padding-bottom:1cm;"> احساس ارزشمندی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> اعتماد به افکار</p>
                        <br>
                        <p style="padding-bottom:1cm;"> باور به توانمندیها</p>
                        <br>
                        <p style="padding-bottom:1cm;"> رفتار عقلانی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> واقع گرایی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> فراست</p>
                        <br>
                        <p style="padding-bottom:1cm;"> خلاقیت</p>
                        <br>
                        <p style="padding-bottom:1cm;"> استقلال</p>
                        <br>
                        <p style="padding-bottom:1cm;"> انعطلاف پذیری</p>
                        <br>
                        <p style="padding-bottom:1cm;"> توانایی قبول یا تغییر</p>
                        <br>
                        <p style="padding-bottom:1cm;"> اذعان اشتباهات و اصلاح آنها،</p>
                        <br>
                        <p style="padding-bottom:1cm;"> خیرخواهی</p>
                        <br>
                        <p style="padding-bottom:1cm;"> روحیه همکاری و تعاون</p>
                        <br>
                        <p style="padding-bottom:1cm;"> بلند پروازی در شغل و حرفه، در زمینه‌های احساسی، ذهنی، خلاقیت و معنویت</p>
                        <br>
                        <p style="padding-bottom:1cm;"> احترام به خود</p>
                        <br>
                        <p style="padding-bottom:1cm;"> احترام و خوش برخوردی با دیگران</p>
                        <br>
                        <p style="padding-bottom:1cm;"> رفتار منصفانه</p>
                    </td>


                </tr>
            </tbody>
        </table>

    </div>
    <p>توجه: الزاما نشانه‌های فوق همگی در یک فرد با عزت نفس پایین یا بالا دیده نمی‌شوند!</p>

    <h2>پرسشنامه عزت نفس روزنبرگ</h2>
    <p>مقیاس عزت نفس روزنبرگ (۱۹۶۵) عزت نفس کلی و ارزش شخصی را اندازه می گیرد. این مقیاس شامل ۱۰ عبارت کلی است که میزان
        رضایت از زندگی و داشتن احساس خوب در مورد خود را می سنجد. به نظر بورنت و رایت (۲۰۰۲) مقیاس عزت نفس روزنبرگ (SES)
        یکی از رایج ترین مقیاس های اندازه گیری عزت نفس بوده و مقیاس معتبری در نظر گرفته می شود زیرا برای عزت نفس از
        مفهومی مشابه با مفهوم ارائه شده در نظریه های روان شناختی درباره «خود» استفاده می کند. SESبه منظور ارائه یک تصویر
        کلی از نگرش های مثبت و منفی درباره خود به وجود آمده است (روزنبرگ، ۱۹۷۹؛ به نقل از بورنت و رایت، ۲۰۰۲).این مقیاس
        ضریب همبستگی بالاتری نسبت به پرسشنامه عزت نفس کوپراسمیت (SEI) دارد و در سنجش سطوح عزت نفس روایی بالاتری دارد.
    </p>

    <h2>نتیجه آزمون</h2>
    <p>بر اساس این آزمون میزان عزت نفس هر فرد در یکی از سطوح کم، متوسط و خوب ارزیابی می گردد</p>
    <div style="margin-top: 20px">
        <table>
            <thead>
                <tr>
                    <th>بازه نمره</th>
                    <th>سطح</th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>
                        ۰ تا ۱۵
                    </td>
                    <td>
                        کم
                    </td>
                </tr>
                <tr>
                    <td>
                        ۱۵ تا ۲۵
                    </td>
                    <td>
                        متوسط
                    </td>
                </tr>
                <tr>
                    <td>
                        ۲۵ به بالا
                    </td>
                    <td>
                        خوب
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    @php
        $point = $ExmAnalyze->get_exam_score('point');
    @endphp
    @if ($point < 16)
        <div style="text-align: center">
            <img style="width: 5cm" src="https://shafatel.com/storage/photos/psychology/psychometry/self esteem/3.png"
                alt="">
        </div>
        <p>نمره آزمون عزت نفس شما {{$point}} بوده است که  در طبقه اول قرار دارد. این بدان معناست که میزان عزت نفس شما کم است. این دامنه از
            نمرات (صفر تا 7)، بیان‌کننده‌ی این است که بطور کلی نظر شما در مورد خودتان و ارزشی که برای خود، اندیشه‌ها و
            توانمندیهایتان قائل هستید کافی و کارآمد نیست و نیاز تجدید نظر اساسی در موارد ذکر شده داشته باشید. بهتر است
            هر چه سریعتر از کمک درمانگر متخصص در حوزه روانشناسی و مشاوره بهره بگیرید. </p>
    @elseif($point < 26)
        <div style="text-align: center">
            <img style="width: 5cm" src="https://shafatel.com/storage/photos/psychology/psychometry/self esteem/2.png"
                alt="">
        </div>
        <p>نمره آزمون عزت نقس شما {{$point}} بوده است که در طبقه دوم قرار دارد. این بدان معناست که میزان عزت نفس شما در طیف متوسط قراردارد. این
            دامنه از نمرات (15 تا 25)، نشان می‌دهد شما نیازی به دریافت کمک تخصصی به طور کلی ندارید اما برای افزایش کیفیت
            زندگی خود می توانید از کمک روانشناس یا مشاوره بهره بگیرید یا از کتابهای خودیاری و دوره‌های آموزشی استفاده
            نمایید.</p>
    @elseif($point >= 26)
        <div style="text-align: center">
            <img style="width: 5cm" src="https://shafatel.com/storage/photos/psychology/psychometry/self esteem/1.png"
                alt="">
        </div>
        <p>نمره آزمون عزت شما{{$point}} بوده است که در طبقه سوم قرارداد. این بدان معناست که میزان عزت نفس شما در وضعیت خوب قرار دارد.
        </p>
    @endif
    <h2>اعتبار و روایی پرسشنامه عزت نفس روزنبرگ</h2>
    <p>روزنبرگ باز پدیدآوری مقیاس را ۹/۰ ومقیاس پذیری آن را ۷/۰ گزارش کرده است. ضرایب آالفای کرونباخ برای این مقیاس در
        نوبت اول ۸۷/۰ برای مردان و ۸۶/۰ برای زنان و در نوبت دوم ۸۸/۰ برای مردان و ۸۷/۰ برای زنان محاسبه شده است
        (ماکیکانگاس و همکاران، ۲۰۰۴). همبستگی آزمون مجدد در دامنه ۸۸/۰-۸۲/۰ و ضریب همسانی درونی یا آلفای کرونباخ در
        دامنه ۸۸/۰-۷۷/۰ قرار دارد. این مقیاس از روایی رضایت بخشی (۷۷/۰) برخوردار است. همچنین همبستگی بالایی با پرسشنامه
        ملی نیویورک و گاتمن در سنجش عزت نفس دارد، لذا روایی محتوای آن نیز مورد تأیید است.</p>

</body>

</html>
