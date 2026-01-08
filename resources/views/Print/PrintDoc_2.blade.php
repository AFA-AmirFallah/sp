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
        background: #ffffff url(https://finoward.com/storage/photos/Services/psychology/tests/traders-risk-test.jpg) no-repeat fixed center center;
    }


    body {
        font-family: fa;
        direction: rtl;
    }

    p {
        text-align: justify;
    }


    .page-header {
        margin-top: 0cm;
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
        <div style="position:absolute;right:0cm;top:0cm;width: 100%;">
            <img style="padding: 0cm"
                src="https://finoward.com/storage/photos/Services/psychology/tests/reports/shafatel_header.png" />
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <div style="position:absolute;right:0cm;bottom:0cm;width: 100%;margin:0cm;">
            <img style="padding: 0cm"
                src="https://finoward.com/storage/photos/Services/psychology/tests/reports/shafatel_footer.png" />
        </div>
    </htmlpagefooter>
    <htmlpageheader name="main-page-header">
        <div style="position:absolute;right:0cm;top:0cm;width: 100%;margin:0cm;background-color: #4880ea;height: 6cm;">
            <h1 style="color: white;text-align:center;margin-top:3cm;font-size:32px">گزارش نتیجه آزمون </h1>
        </div>
        <div
            style="position:absolute;right:0cm;top:6cm;width: 100%;margin:0cm;background-color: #000000;height: 0.5cm;">
        </div>

    </htmlpageheader>

    <htmlpagefooter name="main-page-footer">
        <div
            style="background-color: #4880ea;position:absolute;right:0cm;bottom:0cm;width: 100%;margin:0cm;height: 6cm;">
        </div>
        <div
            style="position:absolute;right:0cm;bottom:6cm;width: 100%;margin:0cm;background-color: #000000;height: 0.5cm;">
        </div>
    </htmlpagefooter>

    <h1 style="text-align:center;padding-top:6cm;">آزمون روانشناسی ریسک پذیری دربازارهای مالی</h1>
    <h1 style="text-align: center">Psychological test financial markets</h1>



    <h1 style="padding-top: 9cm;text-align:center;"> آزمون دهنده: {{ $ExmAnalyze->get_user('Name') }}
        {{ $ExmAnalyze->get_user('Family') }}</h1>

    <pagebreak />
    <div style="text-align: center">
        <img src="https://finoward.com/storage/photos/slider%2011.jpg" alt="">
    </div>
    <h1>آزمون اضطراب بک</h1>
    <h2>مقدمه:</h2>
    <p>
        ما در عصر اضطراب زندگی می کنیم، اضطراب بسیار شدیدتر از نگرانی‌های معمول روزمره است و تاثیرات زیادی بر کیفیت
        زندگی ما دارد، نکته غیرقابل چشم پوشی این است که، روز به روز شیوع اضطراب به عنوان یک بیماری بیشتر می‌شود. اضطراب
        برای انسان از دیدگاه تکاملی بسیار مفید بوده و باعث شده طی هزاران سال ما خود را در برابر خطرات مختلف حفظ کنیم.
        زمانی انسان برای ادامه زندگی مجبور بود شکار کند و شکار نشود اما امروز مسائل انسان متفاوت تر و حتی پیچیده تر از
        گذشته شده و احساسی که در گذشته باعث بقا می‌شد امروز منجر به بروز بیماریهای اضطرابی شده است.
    </p>
    <h2>چکیده:</h2>
    <p> تست اضطراب بک یکی از معتبر ترین ابزار برای شناسایی اضطرب افراد می باشد که در سال ۱۹۸۸ توسط دکتر بک اختراع شد و
        امروزه هم برای تشخیص اختلال اضطراب در افراد از این تست استفاده می شود. اصولا این پرسشنامه یک پرسشنامه ی خود
        گزارشی است که در آن میزان اضطراب نوجوانان و بزرگسالان سنجیده می شود. این پرشسنامه یک پرسشنامه ی ۲۱ سوالی است که
        هر سوال چهار گزینه دارد و مراجعه کننده باید با دقت و با توجه به شخصیت و تیپ شخصیتی خود و همینطور با توجه به قرار
        گرفتن در موقعیت های تنش زا که اضطراب افراد را زیاد می کند و در آن ها حالتی از تنش و بروز فشار های روانی را در
        افراد مشخص میکند، به سوالات جواب داده و از هیچ سوالی به صورت سهوی عبور نکنند.
    </p>


    <p>ارزیابی علایم اضطراب در تشخیص گذاری ها و درمان از اهمیت خاصی برخوردار است. هرچند مقیاس های زیادی تا کنون با توجه
        به دیدگاه های مختلف پدید آمده است(مثل کاستلو،1967-اندلر،1991-زونگ،1965) اما بررسی این مقیاس ها نشان می دهد که
        احتمالا مشکلاتی در مفهوم سازی نظری و ویژگی های روش شناختی آنها وجود دارد(دابسون،1985-مندلز و همکاران،1972). با
        توجه به این مشکلات آیرون برگ و همکارانش (1990). پرسشنامه اضطراب بک (BAI) را معرفی کردند که به طور اختصاصی علایم
        شدت اضطراب بالینی را در افراد می سنجد.</p>
    <p>پرسشنامه اضطراب بک، یک پرسشنامه خود گزارشی است که برای اندازه گیری شدت اضطراب در نوجوانان و بزرگسالان تهیه شده
        است.</p>
    <h2>اعتبار و روایی:</h2>
    <p>مطالعات انجام شده نشان می دهند که این پرسشنامه از اعتبار و روایی بالایی برخوردار است. ضریب همسانی درونی آن(ضریب
        آلفا) 92/. ،اعتبار آن با روش باز آزمایی به فاصله یک هفته 75/. و همبستگی ماده های آن از 30/0 تا 76/. متغیر است.
        پنج نوع روایی محتوا ، همزمان، سازه، تشخیصی و کاملی ،برای این آزمون سنجیده شده است که همگی نشان دهنده کارایی
        بالای این ابزار در اندازه گیری شدت اضطراب می باشد(بک و همکاران،1988).</p>
    <p>برخی تحقیقات در ایران در مورد خصوصیات روانسنجی این آزمون انجام گرفته است به عنوان مثال غرایی (1372) ضریب اعتبار
        آن را با روش باز آزمایی و به فاصله دو هفته 80/. گزارش کرده است. همچنین کاویانی و موسوی (1387)در بررسی ویژگی های
        روانسنجی این آزمون در جمعیت ایرانی ضریب روایی در حدود 72/. و ضریب اعتبار آزمون –آزمون مجدد به فاصله یک ماه را
        83/. و آلفای کرونباخ 92/. را گزارش کرده اند.</p>
    <h2>نمره گذاری و تفسیر نمرات:</h2>
    <p>این پرسشنامه یک مقیاس 21 ماده ای است که آزمودنی در هر ماده یکی از چهار گزینه ای را که نشان دهنده شدت اضطراب او
        است را انتخاب می کند. چهار گزینه هر سوال در یک طیف چهار بخشی از صفر تا سه نمره گذاری می شود. هر یک ار ماده های
        آزمون یکی از علایم شایع اضطراب(ذهنی، بدنی و هراس) را توصیف می کند. بنابراین نمره کل این پرسشنامه در دامنه ای از
        صفر تا 63 قرار می گیرد. نقاط برش پیشنهاد شده برای این پرسشنامه در جدول زیر آمده است.</p>
    <h2>نتیجه آزمون شما</h2>
    @php
        $point = $ExmAnalyze->get_exam_score('point');
    @endphp
    @if ($point < 56)
        <h3> شما به ویژگیهای روانشناختی مورد نیاز برای یک تریدر موفق بودن را دارید. وضعیت ذهنی شما شما را متوقف نمی کند
        </h3>
    @elseif ($point >= 56 && $point < 89)
        <h3> شما مشخصات روانشناختی را دارید که اغلب با یک معامله گر شکست خورده مرتبط است. برخی از عادات ذهنی شما بر علیه
            شما کار می کنند.</h3>
    @elseif ($point >= 89)
        <h3> شما مشخصات روانشناختی یک معامله گر با ریسک بالا را دارید. ممکن است موفق باشید، اما به احتمال زیاد نتایج شما
            رونق و رکود خواهد داشت. شما باید بیشتر روی ایجاد نظم و انضباط تمرکز کنید. </h3>
    @endif
</body>

</html>
