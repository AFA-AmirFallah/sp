@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.CustomerMainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div>
        <img src="{{ asset('assets/images/ghesti.png') }}" style="
      margin-top: 30px; width:100%;">
    </div>


    <div>
        <div class="landing-text">
            <svg style="margin-left: 6px;margin-top: 23px;" width="20" height="5" viewBox="0 0 12 2" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x="3" width="9" height="2" rx="1" fill="#30BFB4"></rect>
                <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
            </svg>
            <p class="text-heading-landing">طرح های اقساطی</p>
            <svg style="margin-right: 6px;margin-top: 23px;" width="40" height="5" viewBox="0 0 30 2" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x="3" width="27" height="2" rx="1" fill="#30BFB4"></rect>
                <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
            </svg>
        </div>
        <div style="  text-align: center;">
            <img src="{{ asset('assets/images/infoghraphy-ghest.png') }}" style="width: 60%; margin-top: 30px;">  
        </div>


        <div class="landing-text">
            <svg style="margin-left: 6px;margin-top: 23px;" width="20" height="5" viewBox="0 0 12 2" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x="3" width="9" height="2" rx="1" fill="#30BFB4"></rect>
                <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
            </svg>
            <p class="text-heading-landing">شرکت‌ها و فروشگاه های طرف قرارداد با مجموعه کوکباز
            </p>
            <svg style="margin-right: 6px;margin-top: 23px;" width="40" height="5" viewBox="0 0 30 2" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x="3" width="27" height="2" rx="1" fill="#30BFB4"></rect>
                <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
            </svg>
        </div>
        <p class="text-subheading-landing">شما می توانید کالای مورد نظر خود را از فروشگاه های ذیل استعلام نمایید و سپس درخواست خود را بخش ثبت سفارش در پایین همین صفحه ثبت نماید. کارشناسان ما در اسرع وقت برای ادامه فرآیند خرید با شما تماس خواهند گرفت.. </p>

        <div id="accordion">
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            مبلمان
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">


                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>پیروزی ، م 13 آبان ، خ افراسیابی جنوبی ، پلاک 212 ، مبلمان شاهین ، آقای حسینی ،
                                        33095744 ، 09123279615 (دارای سه شعبه می باشد و  در آن  سرویس مبل راحتی و سرویس خواب ارائه می گردد.)
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>خیابان دلاوران ، تقاطع تکاوران ، ضلع شمال ، پلاک 281 ، مبلمان چهل ستون ،آقای فشگی 66603605
                                        ، ۰۹۱۲۲۵۸۷۹۵۳ ، ۷۷۱۹۹۹۲۰(در این فروشگاه انواع مبل راحتی ، سرویس خواب ،کاناپه تختخوابشو و ...ارائه می گردد.)
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>دلاوران ، نرسیده به آزادگان ، ضلع جنوب ، پلاک 558 ، مبلمان مانتل (دوران) ، آقای
                                        راشکو ، 77898045 ، 09128386033</td>

                                </tr>
                                
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingTwo">

                    <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="false" aria-controls="collapseTwo">
                        پرده و رو تختی
                    </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">


                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>مولوی، خ رئیس عبداللهی، پاساژ روحی، راهرو حدیث شمالی، پ ۱۴۲۷ ، گالری ایزدی ، آقای
                                        ایزدی، ۵۵۵۸۱۹۸۶ ، ۰۹۱۲۲۱۴۷۷۵۰</td>
                                      
                                </tr>
                           

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link  kookbaz collapsed" data-toggle="collapse" data-target="#collapsefoure"
                            aria-expanded="false" aria-controls="collapsefoure">
                            سیسمونی
                        </button>
                    </h5>
                </div>
                <div id="collapsefoure" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>چوبی کودک و نوجوان : خ دلاوران ، خ آزادگان جنوبی ، پلاک های ۴۲ و ۵۰ ، بادریس ، آقای
                                        نداف ، ۷۷۴۴۱۶۵۵ ، ۰۹۱۲۳۳۵۴۵۱۰</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        کامل کودک : خیابان هنگام ، شمیران نو ، روبروی پاساژ رضا ، پ ۱۷۹ ، فروشگاه هانا ،
                                        آقای رفیعی ، ۷۷۴۵۵۱۶۳ ، ۰۹۳۸۴۹۶۵۵۵۱(مجموعه ای کامل از صفر تا صد سیسمونی در این فروشگاه قابل ارائه می باشد)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link  kookbaz collapsed" data-toggle="collapse" data-target="#collapse22"
                            aria-expanded="false" aria-controls="collapsefoure">
                            وسایل چوبی
                        </button>
                    </h5>
                </div>
                <div id="collapse22" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                       خ شمیران نو،، 20متری شهدای غربی، پ 83، فروشگاه چوبسازان،آقای حسین کیایی،02177452982،09127967249(این واحد تولیدی و فروشگاهی ، انواع کمد های ریلی و لولایی ، جاکفشی و غیره به سفارش خریدار انجام خواهد یافت)
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                خ استقلال، خ والائیان، پلاک 587، گالری چوب مهدی،آقای شربتی، 77242536،09125371373)(میز تلویزیون ، جاکفشی ، ساعت ایستاده ، میز عسلی)
                                    </td>
                                </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>
                                    دلاوران ، چهار راه اول ، ضلع شمال ، پلاک ۶۱۵ ، مبلمان سانترال ، آقای تدین ، ۷۷۴۴۹۱۳۲
                                    ، ۰۹۳۵۶۳۸۳۵۳۷(این فروشگاه دارای تنوع بسیار بالایی از سرویس خواب و کمد های ریلی می باشد - لازم به ذکر است که با توجه به تولید کننده بودن مدیران این فروشگاه ، کابینت ، کمد ، تخت کمجا و تختخوابشو پذیرفته می شود)
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>
                                    خیابان فرجام - بین خیابان سراج و باقری - جنب شیرینی پاگشا - پلاک 284 - فروشگاه روشا. آقای حسین زاده 09123118715- (در این واحد صنفی که دارای اکسسوری کاملی از تجهیزات کابینت آشپزخانه می باشند سفارش انواع کابینت و کمد پذیرفته می شود)                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingfive">
                    <h5 class="mb-0">
                        <button class="btn btn-link  kookbaz collapsed" data-toggle="collapse" data-target="#collapsefive"
                            aria-expanded="false" aria-controls="collapsefive">
                            لوستر ، کنسول و ...
                        </button>
                    </h5>
                </div>
                <div id="collapsefive" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        اتوبان بسیج ، بلوار هجرت ، جنب شهرک فجر ، فروشگاه ایثار ، گالری لوستر حدیث ،آقای
                                        توکلی ، ۳۳۲۴۲۵۰۰ ، ۰۹۱۲۵۸۴۸۲۹۱
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>اتوبان امام علی ع جنوب ، خروجی شهید رجایی ، رو بروی سه راه ترانسفور ، بازار آرین ،
                                        لوستر آصفیان ، ۵۵۲۱۴۱۶۴ ، ۰۹۱۲۵۲۷۴۶۴۱(این فروشگاه ، نمایشگاه تولیدات برند لوستر آصفیان می باشد که دارای تنوع گسترده در انواع لوستر ، آباژور و ... می باشد)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingsix">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapsesix"
                            aria-expanded="false" aria-controls="collapsesix">
                            تردمیل و وسایل ورزشی
                        </button>
                    </h5>
                </div>
                <div id="collapsesix" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        فروشگاه نارسیس،اطیابی/سید وحید،فروشگاه لاله صدر،09126120676
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingseven">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapseseven"
                            aria-expanded="false" aria-controls="collapseseven">
                            پتو ،حوله، رو تختی و ...
                        </button>
                    </h5>
                </div>
                <div id="collapseseven" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        خ هنگام ، خ شمیران نو ، پاساژمهدیه ، ط زیر همکف ، فروشگاه خیری ، آقای مرتضی خیری ،(در این فروشگاه تمامی مایحتاج پارچه ای جهیزیه شامل انواع پتو ، رو تختی و ... ارائه می گردد)
                                        ۷۷۱۹۴۷۷۰ ، ۰۹۱۲۲۰۳۵۲۶۱ </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingeight">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapseeight"
                            aria-expanded="false" aria-controls="collapseghit">
ساعت / تلفن                        </button>
                    </h5>
                </div>
                <div id="collapseeight" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        ((فروشنده انواع ساعت های مچی مردانه و زنانه با برندهای متنوع و بنام دنیا ...))خ ۱۵خرداد ، روبروی مسجد امام ، سرای چیت ساز ، ط ۳ ، پ ۹ ، ویولت (تاج آبادی) ،
                                        ۳۳۹۷۴۱۶۴ ، ۵۵۵۷۶۳۷۸ ، ۰۹۱۲۲۴۶۳۷۵۴
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        شوش - خ کاخ جوانان - پاساژ الغدیر - ط 3 - واحد 11- فروشگاه فرجی 55347870- آقای فرجی 09121798255- (انواع ساعت های دیواری ، ایستاده و فانتزی - انواع گرامافون - انواع تلفن های فانتزی - انواع کالاهای لوکس ، فانتزی و دکوری - لوازم تزئینی و دکوری خانه)                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingnine">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapsenine"
                            aria-expanded="false" aria-controls="collapsenine">
                            هود،فر،سینک،شیر،سرامیک ...
                        </button>
                    </h5>
                </div>
                <div id="collapsenine" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        خ فرجام ، بین شهید باقری و سراج ، جنب بانک پارسیان ، پلاک ۲۱۲ ، عقیق (شقایق) ، آقای
                                        شیرزاد ، ۷۷۷۱۳۸۰۱ ، ۰۹۱۲۷۹۵۹۶۰۰

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        خیابان فرجام - بین خیابان سراج و باقری - جنب شیرینی پاگشا - پلاک 284- فروشگاه روشا- 09123118715 آقای حسین زاده- (انواع هود ، فر برقی و گازی ، شیرآلات ، روشویی ، توالت فرنگی ، اکسسوری کاملی از تجهیزات کابینت آشپزخانه و ...)
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingten">
                    <h5 class="mb-0">
                        <button class="btn btn-link  kookbaz collapsed" data-toggle="collapse" data-target="#collapseten"
                            aria-expanded="false" aria-controls="collapseten">
                            کابینت
                        </button>
                    </h5>
                </div>
                <div id="collapseten" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        دلاوران ، چهار راه اول ، ضلع شمال ، پلاک ۶۱۵ ، مبلمان سانترال ، آقای تدین ، ۷۷۴۴۹۱۳۲
                                        ، ۰۹۳۵۶۳۸۳۵۳۷(در این واحد صنفی که دارای کارخانه اختصاصی می باشند سفارش انواع کابینت ، کمد ، تخت کمجا و تختخوابشو پذیرفته می شود)
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        
                                       09123118715،فروشگاه روشا،علی حسین زاده/جواد ، خیابان فرجام - بین خیابان سراج و باقری - جنب شیرینی پاگشا - پلاک 284)(در این واحد صنفی که دارای اکسسوری کاملی از تجهیزات کابینت آشپزخانه می باشند سفارش انواع کابینت و کمد پذیرفته می شود)


                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="headingeleven">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapseeleven"
                            aria-expanded="false" aria-controls="collapseeleven">
                    موتور سیکلت و دوچرخه
                        </button>
                    </h5>
                </div>
                <div id="collapseeleven" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        نارمک - چهار راه تلفن خانه - جنب دفتر پست - پلاک 254،شرکت تارا کیمیا،داود مقدمی(در این فروشگاه انواع موتورسیکلت ، دوچرخه و لوازم یدکی مرتبط ارائه می گردد)  09121261684


                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        افسریه ، 15 متری سوم ، نبش خ 17 ، پلاک 192 و 194 – شرکت تارا کیمیا 33149917-  داود مقدمی - (در این فروشگاه انواع موتورسیکلت ، دوچرخه و لوازم یدکی مرتبط ارائه می گردد)  09121261684

                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>
                                        اتوبان بسیج ، بلوار هجرت ، جنب شهرک فجر ، فروشگاه ایثار – فروشگاه کویر – 09194011834 آقای توکلی زاده
                                    </td>

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading12">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse12"
                            aria-expanded="false" aria-controls="collapse12">
                           اسکوتر و دوچرخه
                        </button>
                    </h5>
                </div>
                <div id="collapse12" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                       ،فروشگاه دوچرخه ستاره،ستاره/محمد حسن،09384233066،(دارای انواع دوچرخه و اسکوتر در سایزهای مختلف  - در این واحد تعمیرات دوچرخه و اسکوتر نیز انجام می پذیرد) اتوبان شهید باقری شمال به جنوب - نرسیده به 196  - نبش ک 200 (کراری) - پ 152،


                                    </td>

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading13">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse13"
                            aria-expanded="false" aria-controls="collapse13">
                       بلور و کریستال
                        </button>
                    </h5>
                </div>
                <div id="collapse13" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        شوش - خ صابونیان - مجتمع میلاد - ط همکف - پ 247- بلور و کریستال ارس 55084399- غلامی 09126861404- (تنوع مناسب از انواع بلورجات و کریستال در این فروشگاه قابل ارائه بوده و سفارشات نیز پذیرفته می شود) 


                                    </td>

                                </tr>
                           


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading13">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse25"
                            aria-expanded="false" aria-controls="collapse13">
                      لوازم آشپزخانه
                        </button>
                    </h5>
                </div>
                <div id="collapse25" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        شوش - خ صابونیان - پاساژ میلاد - ط همکف - پ 236- یونیک تک 55339884- آقای نجفی 09123340691

                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        شهرک شهید محلاتی ره ، م امام علی ع ، مجتمع تجاری ارم ، ط 2 بال شرقی ، پ 24- لوازم آشپزخانه بامبو 22467132- آقای رضایی خواه 09123001756                                </tr>

                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>
                                        م شوش، خ صابونیان ، پاساژ میلاد نور ، طبقه مثبت 1 ، پ 342- مرادیان55089455-  09360056656- (انواع چینی ، آرکوپال ، سماور و ... در این فروشگاه ارائه می گردد)                                </tr>

                                    </td>

                                </tr>


                            </tbody>
                        </table>
                    </div>
              
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading13">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse26"
                            aria-expanded="false" aria-controls="collapse13">
                            کولر گازی و اسپیلت
                        </button>
                    </h5>
                </div>
                <div id="collapse26" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        سه راه امین حضور - جنب حسینیه بنی فاطمه س- فروشگاه سهند 09121772510 آقای نوری -(در این واحد صنفی انواع کولر های گازی ، اسپیلت و وسایل سرمایشی قابل ارائه می باشد)                                </tr>

                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        امین حضور ، خ امیرکبیر شرقی ، روبروی حسینیه بنی فاطمه ، پ 205- فروشگاه سیبری سنتر 33552637- آقای افشار 09124367551- (ارائه دهنده انواع کولر های گازی در برند های مختلف می باشد)                                </tr>

                                    </td>

                                </tr>
                           


                            </tbody>
                        </table>
                    </div>
                  
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading14">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse14"
                            aria-expanded="false" aria-controls="collapse14">
صوتی و تصویری                        </button>
                    </h5>
                </div>
                <div id="collapse14" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        خ انقلاب، روبروی خ بهار، پلاک ۴۴۸ ، طبقه ۱ ، واحد ۴ ، شرکت آپادانا ، آقای عبدالمحمدی
                                        (این فروشگاه  سفارش انواع لوازم خانگی کوچک و بزرگ و انواع لوازم صوتی و تصویری پذیرفته می شود) ، ۲ و ۷۷۶۸۳۷۷۱ ، ۰۹۱۲۶۹۵۰۹۵۲


                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        سه راه امین حضور - جنب حسینیه بنی فاطمه س- (در این فروشگاه  سفارش انواع لوازم خانگی کوچک و بزرگ و انواع لوازم صوتی و تصویری پذیرفته می شود - همچنین امکان سفارش لپ تاپ و موبایل نیز در این فروشگاه امکانپذیر می باشد
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>
                                        خ جمهوری ، بعد از ساختمان آلومینیوم ، پ 754- فروشگاه آیوا 66747533- آقای تکلو 09123006445- (عرضه انواع اسپیکر های مکسیدر و تلویزیون های آیوا)
                                    </td>

                                </tr>
                             
                        


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading14">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse29"
                            aria-expanded="false" aria-controls="collapse14">
لوازم خانگی                      </button>
                    </h5>
                </div>
                <div id="collapse29" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        میدان شوش - خیابان صابونیان - پاساژ میلاد - ط همکف - پ 241- فروشگاه صبا 55357912 – آقای هادی 09124069667

                                    </td>

                                </tr>
                               
                             
                        


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading14">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse22"
                            aria-expanded="false" aria-controls="collapse14">
چرخ خیاطی                     </button>
                    </h5>
                </div>
                <div id="collapse22" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        خیابان جمهوری اسلامی - بین خ اردیبهشت و خ 12 فروردین - پلاک 1047- فروشگاه جانتک 66974242 – آقای آشام 09121365691 –( در این فروشگاه انواع چرخ خیاطی ، اطو پرس ، چایساز ، دم آور ، و بخار شور قابل ارائه می باشد)

                                    </td>

                                </tr>
                               
                             
                        


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading15">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse15"
                            aria-expanded="false" aria-controls="collapse14">
                            کامپیوتر، موبایل و ...
                        </button>
                    </h5>
                </div>
                <div id="collapse15" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">


                            <tr>
                                <th scope="row">1</th>
                                <td>
                              
                                    خیابان انقلاب اسلامی - روبروی خیابان بهار - پ 448 - ط 1 - واحد 4- فروشگاه آپادانا 77683771- آقای عبدالمحمدی 09126950952- (کلیه کالاهای دیجیتال شامل : موبایل ، تبلت ، لپ تاپ ، کامپیوتر و ...)



                                </td>

                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>
                                    سه راه امین حضور - جنب حسینیه بنی فاطمه س- فروشگاه سهند 09121772510 آقای نوری- (کلیه کالاهای دیجیتال شامل : موبایل ، تبلت ، لپ تاپ ، کامپیوتر و ...)



                                </td>

                            </tr>


                            </tbody>
                        </table>

                    </div>
            
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading16">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse16"
                            aria-expanded="false" aria-controls="collapse14">
                            پارچه ترمه </button>
                    </h5>
                </div>
                <div id="collapse16" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">


                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    کرج ، بعداز ۴۵ متری گلشهر ، خیابان برزنت ، نمایشگاه صنایع دستی هنری ، ترمه قاسمی ، آقای
                                    دهقان ، واتساپ ۰۹۱۷۵۶۵۵۰۱۰ ، ۰۲۶۳۴۵۶۶۸۸۵



                                </td>

                            </tr>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading18">
                    <h5 class="mb-0">
                        <button class="btn btn-link kookbaz collapsed" data-toggle="collapse" data-target="#collapse18"
                            aria-expanded="false" aria-controls="collapse15">
                            تجهیزات بهداشتی و پزشکی </button>
                    </h5>
                </div>
                <div id="collapse18" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">



                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        تهران، ستارخان - خیابان حبیب الهی - پلاک ۲۸۷ طبقه سوم،مجموعه شفاتل
                                        ،۴۱۴۸۴۰۰۰-۰۲۱،https://shafatel.com/




                                    </td>

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80" id="heading17">
                    <h5 class="mb-0">
                        <button class="btn btn-link  kookbaz collapsed" data-toggle="collapse" data-target="#collapse17"
                            aria-expanded="false" aria-controls="collapse16">
                            سیستم تصفیه آب </button>
                    </h5>
                </div>
                <div id="collapse17" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table">



                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        خیابان سعدی ، کوچه بوشهری ، پتاساژ نیرو صنعت ، طبقه همکف ، پلاک ۱۷، فروشگاه دیزل نور
                                        ، آقای دودانگه ، ۰۹۱۹۴۰۲۰۷۹۳




                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        خیابان آزادی - خیابان بهبودی - پ 368 - واحد 1 غربی - شرکت آرمان 66533288 – آقای یوسفی 09126792439



                                    </td>

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

       

            <form method="POST">
                    <div class="landing-text">
                        <svg style="margin-left: 6px;margin-top: 23px;" width="20" height="5" viewBox="0 0 12 2" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" width="9" height="2" rx="1" fill="#30BFB4"></rect>
                            <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
                        </svg>
                        <p class="text-heading-landing">ثبت سفارش</p>
                        <svg style="margin-right: 6px;margin-top: 23px;" width="40" height="5" viewBox="0 0 30 2" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" width="27" height="2" rx="1" fill="#30BFB4"></rect>
                            <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
                        </svg>
                       
                    </div>
                @csrf
                <div style="width: 80% ;    margin-right: 10%;    margin-bottom: 10%;" class="card">
                    
                    <div class="card-body">
                        <div class="inputContiner18">
                            <label>شرح کالا:</label>
                            <input type="text" class="inputContiner18" name="KallaName"
                                placeholder="شرح کالا مورد نظر خود را به فارسی وارد کنید" required>
                            <div class="inputContiner18">
                            </div>
                            <label> مبلغ کالا </label>

                            <input type="number" class="inputContiner18" name="PriceKalla" placeholder="مبلغ استعلام شده کالا
    خود را ازفروشگاه مورد نظر وارد کنید                            " required>

                        </div>
                        <div class="inputContiner18">
                            <label> استان:</label>
                            <select name="Province" id="Province" onchange="LoadCitys(this.value)" class="inputContiner18"
                                required>
                                <option value="0">{{ __('--select--') }}</option>
                                @foreach ($Provinces as $ProvincesTarget)
                                    <option value="{{ $ProvincesTarget->id }}">
                                        {{ $ProvincesTarget->ProvinceName }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="inputContiner18">
                            <label> شهر:</label>
                            <select id="Shahrestan" name="Saharestan" class="inputContiner18" required>
                            </select>
                        </div>
                        <div class="inputContiner18">
                            <label>کدپستی: </label>
                            <input type="niumber" class="inputContiner18" name="ُStorePostalCode" placeholder="" required>
                        </div>
                        <div class="inputContiner18">
                            <label>آدرس: </label>
                            <small>
                            </small>
                            <textarea type="text" class="form-control" name="StoreAddress" required
                                placeholder="آدرس خود را به صورت دقیق وارد کنید">
                    </textarea>

                        </div>

                        <div class="card-fotter">
                            <button type="submit" name="submit" value="save" class="btn-kookbaz598">
                                ثبت درخواست
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    @endsection

    @section('page-js')
        <script>
            window.Province = 0;

            function LoadCitys($ProvinceCode) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetCitysOfProvinces',
                        ProvinceCode: $ProvinceCode,
                    },

                    function(data, status) {
                        $("#Shahrestan").empty();
                        $("#Shahrestan").append(data);
                    });
            }
        </script>
    @endsection

    @section('bottom-js')
    @endsection
