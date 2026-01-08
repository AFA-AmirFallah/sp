@extends('Layouts.Theme1.MainLayout')
@section('MainContent')
<style>
    .container237 {
        display: flex;
        justify-content: center;
        align-items: center;

    }
</style>
    <div class="page-content become-a-vendor">

        <div class="page-content">
            <div class="container">
                <section class="introduce mb-10 pb-10">

                    <figure class="br-lg">
                        <img src="https://kookbaz.ir/assets/images/ghesti.png" alt="Banner" width="1240" height="540"
                            style="background-color: #D0C1AE;" />
                    </figure>
                </section>



            </div>
        </div>


    </div>
    <div class="col-md-12 pr-lg-12 mb-12">

        <h4 class="title  title-center mb-3">طرح فروش اقساطی کالای اساسی ویژه  خانواده بازنشستگان</h4>
        <p class="mb-6">کوکباز با همکاری شرکت یاسیان برای بازنشستگان و مستمری بگیران عزیز این امکان را فراهم آورده تا از
            محصولات خانگی برندهای دوو، اسنوا و بُست با توجه به توان پرداخت مندرج در فیش حقوقی به صورت اقساطی خرید نمایند. در
            این طرح تمامی محصولات قابل عرضه از طریق کالا کارت بانک مهر ایران، با باز پرداخت 18 ماهه و بدون نیاز به ضامن
            تقدیم می‌گردد. جهت آشنایی بیشتر با این طرح به راهنمای گام به گام فرآیند ثبت‌نام تا تحویل دقت فرمائید.</p>

    </div>
    <div class="container237">
        <a target="_blank" class="btn btn-success btn-rounded" style="margin-right: 20px"
            href="https://kookbaz.ir/Product/348/%D8%A7%D8%B3%D9%86%D9%88%D8%A7%D8%8C%D8%AF%D9%88%D9%88"
            title="  محصولات اسنوا،دوو ">
            محصولات اسنوا، دوو
        </a>

    </div>

    <div class="page-content">
        <div class="container">
            <section class="introduce mb-10 pb-10 mt-3">

                <figure class="br-lg">
                    <img src="https://kookbaz.ir/storage/photos/1/Untitled-3.jpg" alt="Banner" width="1240" height="540"
                        style="background-color: #D0C1AE;" />
                </figure>
            </section>



        </div>
    </div>
    </section>


    <section class="count-section mb-10 pb-5">
        @if (!Auth::check())
            {
            <div class="banner parallax" data-parallax-options="{'speed': 10, 'parallaxHeight': '200%', 'offset': -99}"
                data-image-src="assets/images/pages/become/3.jpg" style="background-color: #929294;">
                <div class="container">
                    <div class="banner-content text-center">
                        <h2 class="title title-center text-white font-weight-bold">همین الان سفارش خود را ثبت کنید</h2>
                        <a href="{{ route('login') }}" class="btn btn-white btn-outline btn-rounded ls-25">ثبت نام کنید
                        </a>
                    </div>
                </div>
                }
            @else
                <form method="POST">
                    @csrf
                    <div style="background-color: #fafafa;">
                        <h4 class="title title-link ">ثبت درخواست</h4>
                        <div class="card-body">
                            <div>
                                <label>نام :</label>
                                <span style="color: red">*</span>
                                <input type="text" class="form-control form-control-md" name="Name"
                                    placeholder=" نام" required>

                                <label> نام خانوادگی  :</label>
                                <span style="color: red">*</span>
                                <input type="text" class="form-control form-control-md" name="Family"
                                    placeholder="نام خانوادگی" required>

                            </div>
                            <div class="form-group">
                                <label>شماره موبایل: </label>
                                <span style="color: red">*</span>
                                <input required type="number"  class="form-control form-control-md10"
                                    name="mobilenumber">
                                    <label>کدملی : </label>
                                    <span style="color: red">*</span>
                                    <input required type="number"  class="form-control form-control-md10"
                                        name="MeliID">


                            </div>
                            <div>
                                <label> استان:</label>
                                <span style="color: red">*</span>
                                <select required name="Province" id="Province" onchange="LoadCitys(this.value)"
                                    class="form-control form-control-md">
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($Provinces as $ProvincesTarget)
                                        <option value="{{ $ProvincesTarget->id }}">
                                            {{ $ProvincesTarget->ProvinceName }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="inputContiner18">
                                <label> شهر:</label>
                                <span style="color: red">*</span>
                                <select required id="Shahrestan" name="Saharestan" class="form-control form-control-md">
                                </select>
                            </div>
                            <div>
                                <label>شماره حساب افتتاح شده در بانک: </label>
                                <span style="color: red">*</span>
                                <input required type="number"  class="form-control form-control-md10"
                                name="accountnumber">
                            </div>

                            <div>
                                <button style="float: left" type="submit" name="submit" value="save"
                                    class="btn btn-dark btn-rounded btn-sm mb-4">
                                    ثبت درخواست
                                </button>
                            </div>
                        </div>
                </form>
        @endif
        <div class="form-group mb-10">

        </div>
    </section>
    </div>
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
