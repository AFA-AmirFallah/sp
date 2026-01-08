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
                            <small> Limty</small>
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
                        <div>
                            <img src="{{ asset('Theme4/assets/img/Objects/main_page_banner.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 401])  }}" class="btn btn-primary">ویرایش</a>
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
                        <h5 class="text-white">کارت های کوچک</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('Theme4/assets/img/Objects/small_cards.png') }}" alt="slaider">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{  route('ThemeObjectMgt', ['Theme' => 402])  }}" class="btn btn-primary">ویرایش</a>
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
