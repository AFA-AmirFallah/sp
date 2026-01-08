@extends('Layouts.Moshavereh.objects.MainLayout')
@section('content')
<section class="container-fluid pt-5 pb-4 pb-lg-0 intro-section">
     
    <div class="container mb-5  box br-top p-5 ">
        <h5 class="mb-4 bt-color">ارتباط با ما</h5>
        <div class="row">
            <div class="col-md-6 mb-4">
                <p class="mb-3">جهت ارتباط با ما و ارسال نظـرات و پیشنهادات خود می توانید از فرم زیر استفاده نمایید</p>

                <div class="form-group">
                    <input class="form-control w-75 mb-2" type="text" placeholder="نـام کامل">
                    <input class="form-control w-75 mb-2" type="email" placeholder="ایمیل معتـبر">
                    <input class="form-control w-75 mb-2" type="tel" placeholder="شمـاره موبایل">
                    <input class="form-control w-75 mb-2" type="text" placeholder="موضوع پیام">
                    <textarea class="form-control area mb-2" cols="60" rows="9" placeholder="متن پیام" style="height: 150px!important"></textarea>
                </div>

                <button class="btn btn-danger mb-3" type="submit">ارسـال پیـام<svg class="svg-inline--fa fa-paper-plane fa-w-16 pr-2" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"></path></svg><!-- <i class="fa fa-paper-plane pr-2"></i> --></button>

            </div>
            <div class="col-md-6 pr-md-4">

                <p>

                    {{ App\myappenv::CenterFootertext 
                }}                </p>

                <p><span class="IRANSansWeb_Medium  text-lightgreen"><svg class="svg-inline--fa fa-map-marker-alt fa-w-12 ml-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-marker-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path></svg><!-- <i class="fas fa-map-marker-alt ml-2"></i> -->آدرس :</span>  {{ App\myappenv::InvoiceData['Address'] }}</p>
                <p><span class="IRANSansWeb_Medium  text-lightgreen"><svg class="svg-inline--fa fa-phone fa-w-16 pl-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"></path></svg><!-- <i class="fas fa-phone pl-2"></i> -->تلفن : </span>{{ App\myappenv::InvoiceData['Phone'] }}</p>
                <div>
                    <iframe src=" {{ App\myappenv::googleadress 
                    }} " class="my-4" allowfullscreen="" frameborder="0" style="width:100%"></iframe>
                </div>
            </div>
        </div>

    </div>

<object class="d-none d-xl-block" type="image/svg+xml" data="/Images/Svg/desktop-wave.svg"></object>


</section>

@endsection
