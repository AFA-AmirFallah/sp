@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme8.layout.main_layout')
@section('content')
    <section class="blog-page">

        <header>
            <div class="container">

                <div class="header-image mb-4">
                    <img src="/Theme8/assets//img/hospital1.png" alt="">
                </div>

                <div class="row align-items-center">
                    <div class="col-xl-9 col-12">
                        <h3 class="text-green d-lg-none">
                            دسته بندی ها
                        </h3>

                        <div class="categories-dropdown text-gray-dark mb-xl-0 mb-4">

                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">بیماریها</a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/پوستی">
                                            پوستی
                                        </a>
                                        <a class="child" href="/newscat/زنان و زایمان">
                                            زنان و زایمان
                                        </a>
                                        <a class="child" href="/newscat/قلبی و عروقی">
                                            قلبی و عروقی
                                        </a>
                                        <a class="child" href="/newscat/مغز و اعصاب">
                                            مغز و اعصاب
                                        </a>
                                        <a class="child" href="/newscat/تنفسی">
                                            تنفسی
                                        </a>
                                        <a class="child" href="/newscat/گوش و حلق و بینی">
                                            گوش و حلق و بینی
                                        </a>
                                        <a class="child" href="/newscat/داخلی">
                                            داخلی
                                        </a>
                                        <a class="child" href="/newscat/خون و انکولوژی">
                                            خون و انکولوژی
                                        </a>
                                        <a class="child" href="/newscat/گوارشی">
                                            گوارشی
                                        </a>
                                        <a class="child" href="/newscat/کلیه و مجاری ادراری">
                                            کلیه و مجاری ادراری
                                        </a>
                                        <a class="child" href="/newscat/غدد">
                                            غدد
                                        </a>
                                        <a class="child" href="/newscat/چشم و پلک">
                                            چشم و پلک
                                        </a>
                                        <a class="child" href="/newscat/کودکان و نوزادان">
                                            کودکان و نوزادان
                                        </a>
                                        <a class="child" href="/newscat/استخوانی عضلانی">
                                            استخوانی عضلانی
                                        </a>
                                        <a class="child" href="/newscat/اعصاب و روان">
                                            اعصاب و روان
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">خدمات</a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/خدمات درمانی در مراکز بستری">
                                            خدمات درمانی در مراکز بستری
                                        </a>
                                        <a class="child" href="/newscat/خدمات درمانی سرپایی">
                                            خدمات درمانی سرپایی
                                        </a>
                                        <a class="child" href="/newscat/خدمات بهداشت جامعه">
                                            خدمات بهداشت جامعه
                                        </a>
                                        <a class="child" href="/newscat/خدمات آموزشی">
                                            خدمات آموزشی
                                        </a>
                                        <a class="child" href="/newscat/خدمات اورژانسی و امدادی">
                                            خدمات اورژانسی و امدادی
                                        </a>
                                        <a class="child" href="/newscat/خدمات غذایی و دارویی">
                                            خدمات غذایی و دارویی
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">فناوری ها</a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/مراقبت از راه دو">
                                            مراقبت از راه دو
                                        </a>
                                        <a class="child" href="/newscat/تجهیزات پزشکی">
                                            تجهیزات پزشکی
                                        </a>
                                        <a class="child" href="/newscat/تشخیصی">
                                            تشخیصی
                                        </a>
                                        <a class="child" href="/newscat/ساخت مراکز درمانی">
                                            ساخت مراکز درمانی
                                        </a>
                                        <a class="child" href="/newscat/دارویی">
                                            دارویی
                                        </a>
                                        <a class="child" href="/newscat/فناوری اطلاعات سلامت">
                                            فناوری اطلاعات سلامت
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">داروشناسی</a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/داروها و عوارض آنها">
                                            داروها و عوارض آنها
                                        </a>
                                        <a class="child" href="/newscat/مجوز تولید دارو">
                                            مجوز تولید دارو
                                        </a>
                                        <a class="child" href="/newscat/نانو داروها و داروهای نوترکیب">
                                            نانو داروها و داروهای نوترکیب
                                        </a>
                                        <a class="child" href="/newscat/تولید دارو">
                                            تولید دارو
                                        </a>
                                        <a class="child" href="/newscat/توزیع دارو">
                                            توزیع دارو
                                        </a>
                                        <a class="child" href="/newscat/داروهای گیاهی">
                                            داروهای گیاهی
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">انجمن ها</a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/اتحادیه ملی مراکز مراقبت در منزل">
                                            اتحادیه ملی مراکز مراقبت در منزل
                                        </a>
                                        <a class="child" href="/newscat/انجمن جراحان گوش گلو بینی و سروگردن ایران">
                                            انجمن جراحان گوش گلو بینی و سروگردن ایران
                                        </a>
                                        <a class="child" href="/newscat/انجمن فیزیوتراپی ایران">
                                            انجمن فیزیوتراپی ایران
                                        </a>
                                        <a class="child" href="/newscat/انجمن ریه">
                                            انجمن ریه
                                        </a>
                                        <a class="child" href="/newscat/انجمن آنستزیولوژی و مراقبت های ویژه ایران">
                                            انجمن آنستزیولوژی و مراقبت های ویژه ایران
                                        </a>
                                        <a class="child" href="/newscat/انجمن تله مدیسین">
                                            انجمن تله مدیسین
                                        </a>
                                        <a class="child" href="/newscat/انجمن روانپزشکان ایران">
                                            انجمن روانپزشکان ایران
                                        </a>
                                        <a class="child" href="/newscat/انجمن پرستاری ایران">
                                            انجمن پرستاری ایران
                                        </a>
                                        <a class="child" href="/newscat/انجمن دندانپزشکان عمومی ایران">
                                            انجمن دندانپزشکان عمومی ایران
                                        </a>
                                        <a class="child" href="/newscat/انجمن دمانس و آلزایمر ایران">
                                            انجمن دمانس و آلزایمر ایران
                                        </a>
                                        <a class="child" href="/newscat/انجمن علمی طب سالمندان">
                                            انجمن علمی طب سالمندان
                                        </a>
                                        <a class="child" href="/newscat/انجمن آسیبهای نخاعی">
                                            انجمن آسیبهای نخاعی
                                        </a>

                                    </div>
                                </div>
                            </div>

                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">مراکز درمانی </a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/مراکز هوم کر">
                                            مراکز هوم کر
                                        </a>
                                        <a class="child" href="/newscat/بیمارستانها">
                                            بیمارستانها
                                        </a>
                                        <a class="child" href="/newscat/درمانگاهها">
                                            درمانگاهها
                                        </a>
                                        <a class="child" href="/newscat/آزمایشگاهها">
                                            آزمایشگاهها
                                        </a>
                                        <a class="child" href="/newscat/رادیولوژی و تصویر برداری">
                                            رادیولوژی و تصویر برداری
                                        </a>
                                        <a class="child" href="/newscat/کلینیک ها">
                                            کلینیک ها
                                        </a>
                                        <a class="child" href="/newscat/مراکز جراحی محدود">
                                            مراکز جراحی محدود
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">سبک زندگی </a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/ورزش">
                                            ورزش
                                        </a>
                                        <a class="child" href="/newscat/تغذیه و رژیم درمانی">
                                            تغذیه و رژیم درمانی
                                        </a>
                                        <a class="child" href="/newscat/تناسب اندام">
                                            تناسب اندام
                                        </a>
                                        <a class="child" href="/newscat/ارگونومی">
                                            ارگونومی
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="category-dropdown">
                                <div href="" class="parent">
                                    <a href="#" class="font-semibold">کسب کار سلامت </a>
                                    <span>
                                        <svg width="12" viewBox="0 0 14 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.0111 1.02223L7.00001 7.01108L1.01116 0.999944" stroke="#212A30"
                                                stroke-width="2" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="children custom-scrollbar">
                                    <div class="py-2">
                                        <a class="child" href="/newscat/مشاوره کسب و کار">
                                            مشاوره کسب و کار </a>
                                        <a class="child" href="/newscat/بازاریابی و تبلیغات سلامت">
                                            بازاریابی و تبلیغات سلامت </a>
                                        <a class="child" href="/newscat/تولیدات سلامت محور">
                                            تولیدات سلامت محور </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-5 col-12 mr-auto">
                        <form action="">
                            <div class="search my-lg-0 my-2">
                                <button class="icon">
                                    <svg class="w-100" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="13.75" cy="13.75" r="8.75" stroke="#212A30"
                                            stroke-width="2" />
                                        <path
                                            d="M13.75 10C13.2575 10 12.7699 10.097 12.3149 10.2855C11.86 10.4739 11.4466 10.7501 11.0983 11.0983C10.7501 11.4466 10.4739 11.86 10.2855 12.3149C10.097 12.7699 10 13.2575 10 13.75"
                                            stroke="#212A30" stroke-width="2" stroke-linecap="round" />
                                        <path d="M25 25L21.25 21.25" stroke="#212A30" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                                <input placeholder="جستجو" type="text">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </header>


        @if ($Article == null)
            <div class="row">
                سرمقاله تعریف نشده است!
            </div>
        @else
            <section class="head-secretary">
                <div class="container">
                    <div class="py-4 border-b">
                        <div class="article-text-aria">
                            <div class="row">


                                <div class="col-xl-4 col-lg-5">
                                    <div class="note mb-lg-0 mb-4">
                                        <div class="n-header bg-green text-white text-center p-md-3 p-2">
                                            یادداشت سر دبیر
                                        </div>
                                        <div class="n-body p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <svg width="50" height="50" viewBox="0 0 77 77" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M38.4969 0C43.71 0 48.6787 1.04012 53.2214 2.91985L53.2903 2.95118C57.9709 4.89983 62.1877 7.75075 65.7154 11.2846C69.2618 14.8248 72.119 19.0667 74.0739 23.7848C75.9599 28.3213 76.9937 33.2963 76.9937 38.5031C76.9937 43.7163 75.9536 48.685 74.0739 53.2277L74.0426 53.2966C72.0876 57.9771 69.243 62.194 65.7091 65.7216C62.1689 69.268 57.927 72.1252 53.2089 74.0802C48.6725 75.9661 43.6975 77 38.4906 77C33.2838 77 28.3087 75.9599 23.7661 74.0802L23.6971 74.0488C19.0166 72.1002 14.7997 69.2492 11.2721 65.7216L11.2784 65.7091C7.73196 62.1627 4.87477 57.927 2.91985 53.2214C1.04012 48.6787 0 43.71 0 38.4969C0 33.2837 1.04012 28.315 2.91985 23.7723L2.95118 23.7034C4.89983 19.0229 7.75075 14.806 11.2784 11.2784H11.2846C14.8311 7.73196 19.0667 4.87477 23.7786 2.91985C28.315 1.04012 33.2838 0 38.4969 0ZM10.6455 59.1927L10.7959 59.105C14.4927 57.0435 24.1169 56.3606 28.1145 53.5723C28.409 53.1337 28.7223 52.4946 29.0293 51.7991C29.4867 50.7527 29.9065 49.6061 30.1697 48.8291C29.0544 47.5133 28.0957 46.0283 27.1809 44.5684L24.1545 39.75C23.0518 38.0959 22.4753 36.5921 22.4377 35.3515C22.4189 34.7687 22.5192 34.2424 22.7385 33.7725C22.964 33.2837 23.3087 32.8765 23.7786 32.5632C23.9979 32.4128 24.2423 32.2875 24.5117 32.1935C24.3112 29.5807 24.2423 26.2912 24.3676 23.5342C24.4302 22.8826 24.5618 22.2247 24.7372 21.573C25.5142 18.8098 27.4503 16.5855 29.8501 15.0566C31.1722 14.2108 32.6258 13.5779 34.1359 13.1518C35.1008 12.8761 33.3151 9.80592 34.3113 9.69941C39.1172 9.20441 46.893 13.5967 50.2514 17.2246C51.9307 19.0417 52.9896 21.454 53.2152 24.6433L53.0272 32.5005C53.8668 32.7574 54.4057 33.29 54.6187 34.1484C54.8631 35.1071 54.5999 36.448 53.7853 38.2838C53.7728 38.3152 53.754 38.3528 53.7352 38.3841L50.2828 44.0671C49.0171 46.1536 47.7263 48.2527 46.0534 49.9006C46.21 50.1261 46.3667 50.3454 46.5171 50.5647C47.2 51.5673 47.8893 52.5698 48.7727 53.4658C48.8041 53.4971 48.8291 53.5284 48.8479 53.5598C52.8204 56.3668 62.4885 57.0498 66.1978 59.1175L66.3482 59.2052C70.6528 53.4282 73.1967 46.2664 73.1967 38.5094C73.1967 28.929 69.3119 20.251 63.0336 13.9789C56.7678 7.69436 48.0898 3.80959 38.5094 3.80959C28.929 3.80959 20.251 7.69436 13.9789 13.9727C7.6881 20.2384 3.80332 28.9165 3.80332 38.4969C3.80332 46.2539 6.34722 53.4157 10.6455 59.1927Z"
                                                        fill="#85888E" />
                                                </svg>
                                                <span class="text-gray-dark font-bold mr-2">{{ $ArticleWriterName }}</span>
                                            </div>
                                            <div>
                                                @if ($DataSource->IsAdminLogin())
                                                    <h5 style="float: left">
                                                        <a href="{{ route('EditNews', ['NewsID' => $Article->id]) }}"
                                                            target="_blank"> <i class="fa fa-pencil"></i> </a>
                                                        <a href="{{ route('MakeNews') }}" target="_blank"> <i
                                                                class="fa fa-plus"></i>
                                                        </a>
                                                    </h5>
                                                @endif
                                                @if ($Article->article == 1)
                                                    {{ str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($Article->Abstract), 400)) }}

                                                    @if (strlen($Article->Abstract) > 400)
                                                        <a href="{{ route('ShowNewsItem', [$Article->id]) }}">ادامه مطلب
                                                        </a>
                                                    @endif
                                                @elseif ($Article->article == 3)
                                                    {{ str_replace(';', ' ', Str::limit(App\Functions\TextClassMain::StripText($Article->Abstract), 400)) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-8 col-lg-7">
                                    @foreach ($mobile_banners as $mobile_banner)
                                        @if ($mobile_banner->theme == 7)
                                            <div class="image">
                                                @if ($DataSource->IsAdminLogin())
                                                    <a style="position: absolute;left: 32px;z-index: 20;"
                                                        href="{{ route('ArticlePicManagement') }}" target="_blank"> <i
                                                            class="fa fa-pencil"></i> </a>
                                                @endif
                                                <a href="{{ $mobile_banner->link }}">
                                                    <img src="{{ $mobile_banner->pic }}">
                                                </a>


                                            </div>
                                        @break
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    @endif

    <section>
        <div class="container">
            <div class="sub-header py-4 border-b">
                <div class="row">
                    <div class="col-xl-7 col-lg-6 col-12">

                        <div class="slider mb-lg-0 mb-4">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($mobile_banners as $mobile_banner)
                                        @if ($mobile_banner->theme == 1)
                                            @if ($DataSource->IsAdminLogin())
                                                <a style="position: absolute;left: 32px;z-index: 20;"
                                                    href="{{ route('BannerManagement') }}" target="_blank"> <i
                                                        class="fa fa-pencil"></i> </a>
                                            @endif
                                            <a href="{{ $mobile_banner->link }}" class="swiper-slide">
                                                <img class="w-100" alt="{{ $mobile_banner->title }}"
                                                    src="{{ $mobile_banner->pic }}">
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <button class="arrow next-slide">
                                <svg height="10" viewBox="0 0 5 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.7 0.3C4.3 -0.1 3.7 -0.1 3.3 0.3L0.3 3.3C-0.1 3.7 -0.1 4.3 0.3 4.7L3.3 7.7C3.5 7.9 3.8 8 4 8C4.2 8 4.5 7.9 4.7 7.7C5.1 7.3 5.1 6.7 4.7 6.3L2.4 4L4.7 1.7C5.1 1.3 5.1 0.7 4.7 0.3Z"
                                        fill="#1EA499" />
                                </svg>
                            </button>

                            <button class="arrow prev-slide">
                                <svg height="10" viewBox="0 0 5 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.374612 7.76339C0.77678 8.16121 1.37677 8.15795 1.77459 7.75578L4.75824 4.73952C5.15606 4.33735 5.1528 3.73736 4.75063 3.33954L1.73437 0.355891C1.53329 0.156981 1.23275 0.0586127 1.03275 0.0596997C0.832755 0.0607867 0.533304 0.162416 0.334393 0.3635C-0.0634271 0.765668 -0.0601661 1.36566 0.342002 1.76348L2.65447 4.05094L0.367003 6.36341C-0.0308176 6.76558 -0.0275566 7.36557 0.374612 7.76339Z"
                                        fill="#1EA499" />
                                </svg>
                            </button>
                        </div>

                    </div>

                    <div class="col-xl-5 col-lg-6 col-12">

                        <div class="gallery-articles h-100 d-flex flex-column justify-content-between">
                            @foreach ($mobile_banners as $mobile_banner)
                                @if ($mobile_banner->theme == 1)
                                    <a href="{{ $mobile_banner->link }}" class="article-lg w-100 mb-4">
                                        <div class="item">
                                            @if ($DataSource->IsAdminLogin())
                                                <a style="position: absolute;left: 32px;z-index: 20;"
                                                    href="{{ route('BannerManagement') }}" target="_blank"> <i
                                                        class="fa fa-pencil"></i> </a>
                                            @endif
                                            <img class="w-100" src="{{ $mobile_banner->pic }}">
                                            <!--tag-->
                                            <div class="article-tag">{{ $mobile_banner->title }}</div>
                                        </div>
                                    </a>
                                @break
                            @endif
                        @endforeach


                        <div class="articles-sm w-100">
                            @foreach ($mobile_banners as $mobile_banner)
                                @if ($mobile_banner->theme == 4)
                                    @if ($DataSource->IsAdminLogin())
                                        <a style="position: absolute;left: 32px;z-index: 20;"
                                            href="{{ route('PosterManagement') }}" target="_blank"> <i
                                                class="fa fa-pencil"></i> </a>
                                    @endif
                                    <a href="{{ $mobile_banner->link }}" class="article-sm mb-sm-0 mb-4">

                                        <img class="w-100" src="{{ $mobile_banner->pic }}">
                                        <!--tag-->
                                        <div class="article-tag">{{ $mobile_banner->title }}</div>
                                    </a>
                                @endif
                            @endforeach
                            @foreach ($mobile_banners as $mobile_banner)
                                @if ($mobile_banner->theme == 6)
                                    @if ($DataSource->IsAdminLogin())
                                        <a style="position: absolute;left: 32px;z-index: 20;"
                                            href="{{ route('SmallPicManagement') }}" target="_blank"> <i
                                                class="fa fa-pencil"></i> </a>
                                    @endif
                                    <a href="{{ $mobile_banner->link }}" class="article-sm">
                                        <img class="w-100" src="{{ $mobile_banner->pic }}">
                                        <!--tag-->
                                        <div class="article-tag">{{ $mobile_banner->title }}</div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="border-b">
            <div class="row">

                <div class="col-xl-8 col-lg-7">
                    <div class="h-100 new-articles pt-4">
                        <h3 class="text-green mb-4">
                            جدید ترین موضوعات
                        </h3>
                        <div></div>
                        <div>
                            @foreach ($DataSource->LastPosts() as $LastPost)
                                <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}"
                                    class="new-article border-b pb-4">
                                    <div class="img">
                                        <img src="{{ $LastPost->MainPic }}" alt="">
                                    </div>
                                    <div class="details d-flex flex-column justify-content-between p-2">
                                        <div class="text-gray-dark title text-2-line md:mb-3 mb-4">
                                            {{ strip_tags($LastPost->Titel) }}
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <svg width="19" height="20" viewBox="0 0 19 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.25971 11.7691C6.02257 11.7691 3.3877 9.13424 3.3877 5.89711C3.3877 2.65997 6.02257 0 9.25971 0C12.4968 0 15.1317 2.63488 15.1317 5.87201C15.1317 9.10915 12.4968 11.7691 9.25971 11.7691ZM9.25971 2.00753C7.12671 2.00753 5.37013 3.73902 5.37013 5.89711C5.37013 8.0552 7.12671 9.76159 9.25971 9.76159C11.3927 9.76159 13.1493 8.0301 13.1493 5.87201C13.1493 3.71392 11.3927 2.00753 9.25971 2.00753Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M17.5157 20.0001C16.9636 20.0001 16.5119 19.5484 16.5119 18.9963C16.5119 15.0064 13.2748 11.7441 9.25971 11.7441C5.24466 11.7441 2.00753 15.0064 2.00753 18.9963C2.00753 19.5484 1.55583 20.0001 1.00376 20.0001C0.451693 20.0001 0 19.5484 0 18.9963C0 13.9022 4.14052 9.76172 9.23462 9.76172C14.3287 9.76172 18.4692 13.9022 18.4692 18.9963C18.4943 19.5484 18.0677 20.0001 17.5157 20.0001Z"
                                                        fill="currentColor" />
                                                </svg>
                                                <span class="mr-2">{{ $LastPost->Writer }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.0005 2H15.0005V1C15.0005 0.734784 14.8951 0.48043 14.7076 0.292893C14.52 0.105357 14.2657 0 14.0005 0C13.7353 0 13.4809 0.105357 13.2934 0.292893C13.1058 0.48043 13.0005 0.734784 13.0005 1V2H7V1C7 0.734784 6.89464 0.48043 6.70711 0.292893C6.51957 0.105357 6.26522 0 6 0C5.73478 0 5.48043 0.105357 5.29289 0.292893C5.10536 0.48043 5 0.734784 5 1V2H3C2.20435 2 1.44129 2.31607 0.87868 2.87868C0.316071 3.44129 0 4.20435 0 5V17C0 17.7957 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20H17.0005C17.7961 20 18.5592 19.6839 19.1218 19.1213C19.6844 18.5587 20.0005 17.7957 20.0005 17V5C20.0005 4.20435 19.6844 3.44129 19.1218 2.87868C18.5592 2.31607 17.7961 2 17.0005 2ZM18.0005 17.0005C18.0005 17.2657 17.8951 17.52 17.7076 17.7076C17.52 17.8951 17.2657 18.0005 17.0005 18.0005H3C2.73478 18.0005 2.48043 17.8951 2.29289 17.7076C2.10536 17.52 2 17.2657 2 17.0005V10H18.0005V17.0005ZM18.0005 8.00047H2V5C2 4.73478 2.10536 4.48043 2.29289 4.29289C2.48043 4.10536 2.73478 4 3 4H5V5C5 5.26522 5.10536 5.51957 5.29289 5.70711C5.48043 5.89464 5.73478 6 6 6C6.26522 6 6.51957 5.89464 6.70711 5.70711C6.89464 5.51957 7 5.26522 7 5V4H13V5C13 5.26522 13.1054 5.51957 13.2929 5.70711C13.4804 5.89464 13.7348 6 14 6C14.2652 6 14.5196 5.89464 14.7071 5.70711C14.8946 5.51957 15 5.26522 15 5V4H17C17.2652 4 17.5196 4.10536 17.7071 4.29289C17.8946 4.48043 18 4.73478 18 5L18.0005 8.00047Z"
                                                        fill="currentColor" />
                                                </svg>
                                                <span
                                                    class="mr-2">{{ $Persian->MyPersianDate($LastPost->created_at) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="pt-4 pb-4">
                        <h3 class="text-green mb-4">
                            مراکز و پزشکان بیمارستان مجازی
                        </h3>

                        <div class="doctors">

                            <a href="#" class="doctor mb-3">
                                <img src="/Theme8/assets//img/image2.png" alt="">
                            </a>

                            <a href="#" class="doctor mb-3">
                                <img src="/Theme8/assets//img/hospital.jpg" alt="">
                            </a>

                            <a href="#" class="doctor mb-3">
                                <img src="/Theme8/assets//img/hospital1.png" alt="">
                            </a>

                            <a href="#" class="doctor mb-3">
                                <img src="/Theme8/assets//img/hospital2.png" alt="">
                            </a>

                            <a href="#" class="doctor mb-3">
                                <img src="/Theme8/assets//img/hospital1.png" alt="">
                            </a>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="border-b pb-4 pt-4">
            <h3 class="text-green mb-4">
                پربازدیدترین ها
            </h3>
            <div class="blog-items">
                @php
                    $mostviewconter = 1;
                @endphp
                @foreach ($DataSource->MostViewPosts() as $LastPost)
                    <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}" class="blog-item">
                        <img src="{{ $LastPost->MainPic }}">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="border-b">
            <div class="row">

                <div class="col-xl-6 col-lg-5">
                    <div class="h-100 diseases pt-4">
                        <h3 class="text-green mb-4">
                            بیماری ها و علائم آن ها
                        </h3>

                        <div>
                            <a class="disease border-b pb-3" href="#">
                                <div class="mb-1">
                                    <b class="text-gray-dark">عنوان بیماری :</b>
                                    <span class="text-blue-light font-semibold">اندومتریوز</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">علائم بیماری :</b>
                                    <span class="text-blue-light font-semibold">سر درد ، تب</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">درمان بیماری :</b>
                                    <span class="text-blue-light font-semibold">مراقبت و استراحت طولانی</span>
                                </div>
                            </a>
                            <a class="disease border-b pt-3 pb-3" href="#">
                                <div class="mb-1">
                                    <b class="text-gray-dark">عنوان بیماری :</b>
                                    <span class="text-blue-light font-semibold">اندومتریوز</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">علائم بیماری :</b>
                                    <span class="text-blue-light font-semibold">سر درد ، تب</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">درمان بیماری :</b>
                                    <span class="text-blue-light font-semibold">مراقبت و استراحت طولانی</span>
                                </div>
                            </a>
                            <a class="disease border-b pt-3 pb-3" href="#">
                                <div class="mb-1">
                                    <b class="text-gray-dark">عنوان بیماری :</b>
                                    <span class="text-blue-light font-semibold">اندومتریوز</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">علائم بیماری :</b>
                                    <span class="text-blue-light font-semibold">سر درد ، تب</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">درمان بیماری :</b>
                                    <span class="text-blue-light font-semibold">مراقبت و استراحت طولانی</span>
                                </div>
                            </a>
                            <a class="disease border-b pt-3 pb-3" href="#">
                                <div class="mb-1">
                                    <b class="text-gray-dark">عنوان بیماری :</b>
                                    <span class="text-blue-light font-semibold">اندومتریوز</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">علائم بیماری :</b>
                                    <span class="text-blue-light font-semibold">سر درد ، تب</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">درمان بیماری :</b>
                                    <span class="text-blue-light font-semibold">مراقبت و استراحت طولانی</span>
                                </div>
                            </a>
                            <a class="disease pt-3 pb-3" href="#">
                                <div class="mb-1">
                                    <b class="text-gray-dark">عنوان بیماری :</b>
                                    <span class="text-blue-light font-semibold">اندومتریوز</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">علائم بیماری :</b>
                                    <span class="text-blue-light font-semibold">سر درد ، تب</span>
                                </div>
                                <div class="mb-1">
                                    <b class="text-gray-dark">درمان بیماری :</b>
                                    <span class="text-blue-light font-semibold">مراقبت و استراحت طولانی</span>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-xl-6 col-lg-7">
                    <div class="py-4">
                        <h3 class="text-green mb-4">
                            از مشاورین و متخصصان بیمارستان مجازی کمک بگیرید
                        </h3>

                        <div class="consultants">
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>

                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>

                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>

                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon1.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                            <a href="#" class="consultant">
                                <div class="img mb-3">
                                    <img src="/Theme8/assets//img/icons/icon2.png">
                                </div>
                                <div class="text-one-line text-gray-dark font-bold">
                                    بسته های سلامت
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="mb-4">
    <div class="container">
        <div class="pb-4 pt-4">
            <h3 class="text-green mb-4">
                پادکست های آموزشی صوتی و ویدئویی
            </h3>
            <div class="blog-items">
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital1.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/image2.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital2.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital1.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital2.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/image2.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital2.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital1.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/image2.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital1.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/image2.png">
                </a>
                <a href="#" class="blog-item">
                    <img src="/Theme8/assets//img/hospital1.png">
                </a>
            </div>
        </div>
    </div>
</section>

</section>
@endsection

@section('end-js')
<script>
    //dropdown
    $(".categories-dropdown .category-dropdown").click(function() {

        if ($(this).hasClass("active")) {
            $(this).children(".children").slideUp(300);
            $(this).removeClass("active");
            return
        }

        const currentActiveDropdown = $(".categories-dropdown .category-dropdown.active");
        $(currentActiveDropdown).children(".children").slideUp(300);
        $(currentActiveDropdown).removeClass("active");

        $(this).addClass("active");
        $(this).children(".children").slideDown(300)

    })

    $(window).resize(function() {
        $(".categories-dropdown .category-dropdown .children").removeAttr("style");
        $(".categories-dropdown .category-dropdown").removeClass("active")
    })

    //slider
    const swiper = new Swiper('.slider .swiper', {
        loop: true,
        spaceBetween: 15,

        // Navigation arrows
        navigation: {
            nextEl: '.slider .next-slide',
            prevEl: '.slider .prev-slide',
        },

    });
</script>
@endsection
