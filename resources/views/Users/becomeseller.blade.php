@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.CustomerMainPage')
@section('page-header-left')
@endsection
@section('MainCountent')



<img src="{{ asset('assets/images/landing.png') }}" style="width: 100%; margin-top: 30px;">
</div> 
<div >
  <div class="landing-text">
    <svg style="margin-left: 6px;margin-top: 23px;" width="20" height="5" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="3" width="9" height="2" rx="1" fill="#30BFB4"></rect>
      <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
  </svg>
  <p class="text-heading-landing">مزایای غرفه سازی در کوکباز</p>
  <svg style="margin-right: 6px;margin-top: 23px;" width="40" height="5" viewBox="0 0 30 2" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="3" width="27" height="2" rx="1" fill="#30BFB4"></rect>
    <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
</svg>
</div>
    <div class="card-columns landing" >
        <div class="card border-primary mb-3" style="max-width: 18rem;">

            <div class="card-body text-primary">
              <h5 class="card-title">درگاه پرداخت امن</h5>
              <p class="card-text" style="margin-top: 5%;">ﺑﺪون ﻧﯿﺎز ﺑﻪ دردﺳﺮﻫﺎی اداری، ﺻﺎﺣﺐ درﮔﺎه اﻣﻦ ﺑﺎﻧﮑﯽ ﭘﺮداﺧﺖ ﺷﻮﯾﺪ</p>
            </div>
          </div>
          <div class="card border-secondary mb-3" style="max-width: 18rem;">
       
            <div class="card-body text-primary">
              <h5 class="card-title">ﮐﺎﻫﺶ ﻫﺰﯾﻨﻪ ﭘﺴﺘﯽ

              </h5>
              <p class="card-text"  style="margin-top: 5%;">ﻣﺤﺼﻮﻟﺎﺗﺘﺎن را ﺳﺮﯾﻊ‌ﺗﺮ و آﺳﺎن‌ﺗﺮ

                ارﺳﺎل ﮐﻨﯿﺪ و ﻫﺰﯾﻨﻪ‌ ارﺳﺎل
                
                را ﮐﺎﻫﺶ دﻫﯿﺪ.</p>
            </div>
          </div>

          <div class="card border-warning mb-3" style="max-width: 18rem;">
            <div class="card-body text-primary">
              <h5 class="card-title"  >ﻃﺮح‌ﻫﺎی ﺗﺨﻔﯿﻔﯽ

              </h5>
              <p class="card-text" style="margin-top: 5%;">ﺑﺪون اﯾﻨﮑﻪ ﻫﺰﯾﻨﻪ ﮐﻨﯿﺪ

                ﻣﺸﺘﺮی‌ﻫﺎﯾﺘﺎن از ﺗﺨﻔﯿﻒ‌ﻫﺎی
                
                ﻣﺘﻨﻮع ﺑﺮﺧﻮردار ﻣﯽ‌ﺷﻮﻧﺪ.</p>
            </div>
          </div>
          <div class="card border-info mb-3" style="max-width: 18rem;">
 
            <div class="card-body text-primary">
              <h5 class="card-title">ﺧﺪﻣﺎت مشتری‌ها

              </h5>
              <p class="card-text" style="margin-top: 5%;">ﭘﺸﺘﯿﺒﺎﻧﯽ مشتری‌هایتان ﺑﺮ

                ﻋﻬﺪه ﻣﺎست؛ وﻗﺖ‌ ﺧﻮد را ﺻﺮف
                
                ﮐﺴﺐ‌و‌ﮐﺎرﺗﺎن ﮐﻨﯿﺪ.</p>
            </div>
          </div>
          <div class="card border-light mb-3" style="max-width: 18rem;">

            <div class="card-body text-primary">
              <h5 class="card-title">ﺷﻔﺎﻓﯿﺖ ﻣﺎﻟﯽ

              </h5>
              <p class="card-text" style="margin-top: 5%;">ﺑﺪون ﻧﯿﺎز ﺑﻪ ﺣﺴﺎﺑﺪار،

                در ﺟﺮﯾﺎن ﮔﺮدش ﻣﺎﻟﯽ
                
                ﮐﺴﺐ‌وﮐﺎر ﺧﻮد ﺑﺎﺷﯿﺪ.</p>
            </div>
          </div>
          <div class="card border-dark mb-3" style="max-width: 18rem;">

            <div class="card-body text-primary">
              <h5 class="card-title">ﻓﻀﺎی آﻣﻮزﺷﯽ

              </h5>
              <p class="card-text"  style="margin-top: 5%;">در کوکباز، ﻓﻨﻮن و روش‌ﻫﺎی

                ﮐﺴﺐ‌وﮐﺎر اﯾﻨﺘﺮﻧﺘﯽ را ﺑﺪون
                
                ﻫﺰﯾﻨﻪ ﯾﺎد ﺑﮕﯿﺮﯾﺪ</p>
            </div>
          </div>
    </div>
         
    <div class="landing-text">
      <svg style="margin-left: 6px;margin-top: 23px;" width="20" height="5" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="3" width="9" height="2" rx="1" fill="#30BFB4"></rect>
        <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
    </svg>
    <p class="text-heading-landing">مراحل فروش کوکباز
</p>
    <svg style="margin-right: 6px;margin-top: 23px;" width="40" height="5" viewBox="0 0 30 2" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="3" width="27" height="2" rx="1" fill="#30BFB4"></rect>
      <rect width="2" height="2" rx="1" fill="#30BFB4"></rect>
  </svg>
  </div>   
  <div style="text-align: center;">
    <img src="{{ asset('assets/images/infoghraphy.jpg') }}" style="width: 80%; margin-top: 30px;">  
    </div> 
 
            
      <form method="POST">
        @csrf
        <div style="width: 80% ;margin: 10%;" class="card" >
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">ثبت نام</div>
            <div class="card-body">
              <div class="inputContiner18">
                <label>نام فروشگاه:</label>
                <input type="text" class="inputContiner18" name="StoreName"
                    placeholder="نام فروشگاه خود را به فارسی وارد کنید">
                    <div class="inputContiner18">
                    </div>
                <label> نوع کسب و کار:</label>
               
                    <select class="inputContiner18" aria-label="Default select example" name="Business-Type">
                       
                        <option value="تولید کننده روستایی">تولید کننده روستایی</option>
                        <option value="تولید کننده خانگی">تولید کننده خانگی</option>
                        <option value="کارگاه کوچک"> کارگاه کوچک</option>
                        <option value=" کسب و کار پیشرو"> کسب و کار پیشرو</option>
                        <option value="مغازه دار"> مغازه دار</option>
                        <option value="شعبه">شعبه</option>
                        <option value="سایر">سایر</option>
                      </select>
                    
                    </div>
                      <div class="inputContiner18">
                        <label > استان:</label>
                        <select name="Province" id="Province" onchange="LoadCitys(this.value)"
                            class="inputContiner18">
                            <option value="0">{{ __('--select--') }}</option>
                             @foreach ($Provinces as $ProvincesTarget)
                                <option value="{{ $ProvincesTarget->id }}">
                                    {{ $ProvincesTarget->ProvinceName }}</option>
                            @endforeach
                        </select>
                      
                    </div>
                    <div class="inputContiner18">
                        <label > شهر:</label>
                        <select id="Shahrestan" name="Saharestan" class="inputContiner18">
                        </select>
                    </div>
                    <div class="inputContiner18">
                     <label>کدپستی: </label>
                        <input type="niumber" class="inputContiner18" name="ُStorePostalCode"
                    placeholder="">
                    </div>
                    <div class="inputContiner18">
                    <label>آدرس: </label>
                    <small>توجه کنید که ارتباط با شما (از جمله بازگشت محصول)، فقط از طریق این آدرس خواهد بود.
                    </small>
                    <textarea type="text" class="form-control" name="StoreAddress"
                        placeholder="توضیحات فروشگاه  خود را به فارسی وارد کنید">
                    </textarea>
                        </textarea>
                    </div>
                        <div class="inputContiner18">
                    <label>درباره فروشگاه:</label>
                    <textarea type="text" class="form-control" name="Storeaboutus"
                        placeholder="توضیحات فروشگاه  خود را به فارسی وارد کنید">
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
