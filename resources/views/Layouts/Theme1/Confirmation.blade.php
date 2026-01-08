@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme1.MainLayout')
@section('MainTitle')
@endsection
<section class="mb-6">
    <h2 class="title title-center mb-2">   شرکت گسترش فناوری اندیشه ایرانیان</h2>
    <div class="tab tab-nav-center tab-nav-underline tab-line-grow">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a href="#tab5-1" class="nav-link active"> وکالت کسر از حقوق</a>
            </li>
          
        </ul>
        <div class="tab-pane active" id="tab5-1">
            اینجانب <b>{{ Auth::user()->Name }}{{ Auth::user()->Family }}</b>
            فرزند...................................
            به شماره ملی<b>{{ Auth::user()->MelliID }}</b>
            به آدرس................
            به شرکت گسترش فناوری اندیشه ایرانیان (کوکباز) 
            وکالت بلاعزل می‌دهم تا
            مبلغ ..........................
            طی ..................... قسط،
            هر قسط به مبلغ ...................... 
            بابت خرید کالا در تاریخ.....................
            را از حقوق، وجوه، سپرده ها و کلیه مطالبات اینجانب نزد سازمان برداشت نماید.
            <br>
            توان پرداخت خریدار در تاریخ.......
            برابر با مبلغ ........... می باشد
                        </div>
       
    </div>
    </div>
</section>
@endsection

