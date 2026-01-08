@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>مدیریت تم
        <small> تم ول مارت</small>
    </h3>
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت تم
                            <small>فروشگاه</small>
                        </h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">اسلایدر صفحه اصلی</h5>
                    </div>
                    <div class="card-body">
                        <small>designer size: 1200x800 </small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/1.jpg') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/top_slider.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 601])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">متن صفحه اصلی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('/Theme6/assets/thememgt/banner-text.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme6_singleBannerText']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">تصویر صفحه اصلی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('/Theme6/assets/thememgt/Theme6_singleBannerPic.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme6_singleBannerPic']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">تصویر صفحه اصلی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('/Theme6/assets/thememgt/Theme6_3box.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme6_3box']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">بخش در باره ما</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('/Theme6/assets/thememgt/Theme6_aboutUs.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme6_aboutUs']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">بخش خدمات‌ما</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('/Theme6/assets/thememgt/Theme6_OurServices.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme6_OurServices']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">بخش ماموریت‌ما</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('/Theme6/assets/thememgt/Theme6_MissionSection.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme6_MissionSection']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ---------------------old
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">اسلایدر صفحه اصلی حالت لپتاپ</h5>
                    </div>
                    <div class="card-body">
                        <small>سایز ظراح : 1780px X 890px </small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/1.jpg') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/top_slider.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 501])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">اسلایدر صفحه اصلی حالت موبایل</h5>
                    </div>
                    <div class="card-body">
                        <small>سایز ظراح : ۶۵۸X ۴۳۶</small>
                        <small> در حالت نمایش موبایل از این اسلایدر استفاده کنید</small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/2.jpg') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/mobile_top_slider.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 502])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">عکس های کناری اسلایدر</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-danger">نمایش فقط در حالت لپ تاپ</p>
                        <small>سایز ظراح : ۸۵۶ در  ۴۲۸</small>
                        <small> در حالت نمایش موبایل از این اسلایدر استفاده کنید</small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/3.jpg') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/top_slider.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 503])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">لیست محصولات در حالت مدرن با بک گراند و عکس</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-danger">نمایش فقط در حالت لپ تاپ</p>

                        <small>عکس سر دسته می باید به صورت transparnet باشد</small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/4.png') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/Product_Slider.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 504])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">بنر تکی</h5>
                    </div>
                    <div class="card-body">
                        <small>1656 × 210 pixels</small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/large-banner.jpg') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/single_banner.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 505])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">بنر دو تایی</h5>
                    </div>
                    <div class="card-body">
                        <small>820 × 300 pixels</small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/5.jpg') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/duble_slide.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 506])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">بنر چهار تایی</h5>
                    </div>
                    <div class="card-body">
                        <small>400 × 300 pixels</small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/6.jpg') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/four_slide.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 507])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">لیست محصولات</h5>
                    </div>
                    <div class="card-body">
                        <small>نمایش محصولات بر اساس شاخص</small>
                        <div>
                            <img src="{{ asset('Theme5/manual/simple_product_list.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 508])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">لیست محصولات پیشرفته</h5>
                    </div>
                    <div class="card-body">
                        <small>نمایش محصولات بر اساس شاخص</small>
                        <small> پیشنهاد رنگ های بکگراند: </small>
                        <small>#ef394e</small>
                        <small>#304ffe</small>
                        <p class="text-warning">آدرس تصویر را در تیتر بارگذاری کنید!</p>
                        <small>495 × 864 pixels</small>
                        <a arget=”_blank” href="{{ asset('Theme5/manual/temp/7.png') }}">نمونه عکس</a>
                        <div>
                            <img src="{{ asset('Theme5/manual/advance_list.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 509])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">لیست  برند ها</h5>
                    </div>
                    <div class="card-body">
                        <small>نمایش برند ها</small>
                        <div>
                            <img src="{{ asset('Theme5/manual/brands.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 510])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">لیست محصولات کلاسیک</h5>
                    </div>
                    <div class="card-body">
                        <small>نمایش کلاسیک محصولات</small>
                        <div>
                            <img src="{{ asset('Theme5/manual/old_list.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 511])  }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> منوی بالای صفحه </h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/topmenu.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme1_TopMenu']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> فوتر اصلی </h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/footer.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme1_footer']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> منوی سمت راست </h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/rightmenu.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('HtmlObj', ['Cat' => 'Theme1_RightMenu']) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>اسلایدر صفحه اصلی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/MainSlider.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 201]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> لیست محصولات افقی </h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/vertical_list.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 202]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> لیست محصولات افقی - جدید</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/vertical_list.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 210]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> لیست محصولات - 4 تایی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/newproduct.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 211]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>نمایش تگ های خرید</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/tagsshow.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 203]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>برند ها</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/brandsshow.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 204]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> باکس آیکن</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/boxicon.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 212]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> نمایش اخبار</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/weblogs.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 205]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> نمایش تصاویر ۴ تایی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/4xpicturs.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 206]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> نمایش تصاویر2 تایی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/2xpicture.jpg') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 208]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5> بنر تکی</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/1xpicture.jpg') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 209]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>مشاوره نمایش اخبار</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme1/assets/images/Objects/khabar.jpg') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ThemeObjectMgt', ['Theme' => 310]) }}" class="btn btn-primary">ویرایش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
